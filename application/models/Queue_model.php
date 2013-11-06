<?php
/**
 * Sharif Judge online judge
 * @file Queue_model.php
 * @author Mohammad Javad Naderi <mjnaderi@gmail.com>
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Queue_model extends CI_Model {

	public function __construct(){
		parent::__construct();
		$this->load->database();
	}


	// ------------------------------------------------------------------------


	/**
	 * Returns TRUE if one submission with $username, $assignment and $problem
	 * is already in queue (for preventing multiple submission)
	 */
	public function in_queue ($username, $assignment, $problem){
		$query = $this->db->get_where('queue', array('username'=>$username, 'assignment'=>$assignment, 'problem'=>$problem));
		if ($query->num_rows() > 0)
			return TRUE;
		return FALSE;
	}


	// ------------------------------------------------------------------------


	/**
	 * Returns all the submission queue
	 */
	public function get_queue (){
		return $this->db->get('queue')->result_array();
	}


	// ------------------------------------------------------------------------


	/**
	 * Empties the queue
	 */
	public function empty_queue (){
		return $this->db->empty_table('queue');
	}


	// ------------------------------------------------------------------------


	public function add_to_queue($submit_info){
		$now = shj_now();

		$submit_query = $this->db->get_where('final_submissions', array(
			'username' => $submit_info['username'],
			'assignment' => $submit_info['assignment'],
			'problem' => $submit_info['problem']
		));

		$submit_info['time'] = date('Y-m-d H:i:s', $now);
		$submit_info['status'] = 'PENDING';
		$submit_info['pre_score'] = 0;

		if ($submit_query->num_rows() == 0)
			$submit_info['submit_number'] = 1;
		else
			$submit_info['submit_number'] = $submit_query->row()->submit_count + 1;

		$this->db->insert('all_submissions', $submit_info);

		$this->db->insert('queue', array(
			'submit_id' => $submit_info['submit_id'],
			'username' => $submit_info['username'],
			'assignment' => $submit_info['assignment'],
			'problem' => $submit_info['problem'],
			'type' => 'judge'
		));
	}


	// ------------------------------------------------------------------------


	/**
	 * Adds submissions of a problem to queue for rejudge
	 */
	public function rejudge($assignment_id, $problem_id){
		$problem = $this->assignment_model->problem_info($assignment_id, $problem_id);
		if ($problem['is_upload_only'])
			return;
		// Bringing all submissions of selected problem into PENDING state:
		$this->db->where(array('assignment'=>$assignment_id, 'problem'=>$problem_id))->update('all_submissions', array('pre_score'=>0, 'status'=>'PENDING'));

		// Adding submissions to queue:
		$submissions = $this->db->select('submit_id,username,assignment,problem')->get_where('all_submissions', array('assignment'=>$assignment_id, 'problem'=>$problem_id))->result_array();
		foreach($submissions as $submission){
			$this->db->insert('queue', array(
				'submit_id' => $submission['submit_id'],
				'username' => $submission['username'],
				'assignment' => $submission['assignment'],
				'problem' => $submission['problem'],
				'type' => 'rejudge'
			));
		}
		// Now ready for rejudge
	}


	// ------------------------------------------------------------------------


	/**
	 * Adds a single submission to queue for rejudge
	 */
	public function rejudge_one($submission){
		$problem = $this->assignment_model->problem_info($submission['assignment'], $submission['problem']);
		if ($problem['is_upload_only'])
			return;
		// Bringing the submissions into PENDING state:
		$this->db->where(array(
			'submit_id' => $submission['submit_id'],
			'username' => $submission['username'],
			'assignment' => $submission['assignment'],
			'problem' => $submission['problem']
		))->update('all_submissions', array('pre_score'=>0, 'status'=>'PENDING'));

		// Adding submission to queue:
		$submissions = $this->db->select('submit_id,username,assignment,problem')
			->get_where('all_submissions',array(
				'submit_id' => $submission['submit_id'],
				'username' => $submission['username'],
				'assignment' => $submission['assignment'],
				'problem' => $submission['problem'],
			))->result_array();
		foreach($submissions as $submission){
			$this->db->insert('queue', array(
				'submit_id' => $submission['submit_id'],
				'username' => $submission['username'],
				'assignment' => $submission['assignment'],
				'problem' => $submission['problem'],
				'type' => 'rejudge'
			));
		}
		// Now ready for rejudge
	}


	public function get_first_item(){
		$query = $this->db->limit(1)->get('queue');
		if ($query->num_rows() != 1)
			return NULL;
		return $query->row_array();
	}


	public function remove_item($username, $assignment, $problem, $submit_id){
		$this->db->delete('queue', array(
			'submit_id' => $submit_id,
			'username' => $username,
			'assignment' => $assignment,
			'problem' => $problem
		));
	}


	public function add_judge_result_to_db ($submission, $type) {

		$submit_id = $submission['submit_id'];
		$username = $submission['username'];
		$assignment = $submission['assignment'];
		$problem = $submission['problem'];
		$time = $submission['time'];
		$status = $submission['status'];
		$pre_score = $submission['pre_score'];
		$coefficient = $submission['coefficient'];
		$submit_count = $submission['submit_number'];
		$file_name = $submission['file_name'];
		$main_file_name = $submission['main_file_name'];
		$file_type = $submission['file_type'];

		$submission_copy = $submission;
		$submission_copy['submit_count'] = $submission_copy['submit_number'];
		unset($submission_copy['submit_number']);

		$query = $this->db->get_where('final_submissions', array(
			'username' => $username,
			'assignment' => $assignment,
			'problem' => $problem
		));

		if ($query->num_rows()===0)
			$this->db->insert('final_submission', $submission_copy);
		else {
			$sid = $query->row()->submit_id;
			if ($type === 'judge') {
				$this->db->where(array(
					'username' => $username,
					'assignment' => $assignment,
					'problem' => $problem
				))->update('final_submissions', $submission_copy);
			}
			elseif ($type === 'rejudge' && $sid === $submit_id){
				unset($submission_copy['submit_count']);
				$this->db->where(array(
					'username' => $username,
					'assignment' => $assignment,
					'problem' => $problem
				))->update('final_submissions', $submission_copy);
			}
		}

		$this->db->where(array(
			'submit_id' => $submit_id,
			'username' => $username,
			'assignment' => $assignment,
			'problem' => $problem
		))->update('all_submissions', array('status' => $status, 'pre_score' => $pre_score));

		// update scoreboard:
		$this->load->model('scoreboard_model');
		$this->scoreboard_model->update_scoreboard($assignment);

	}

}