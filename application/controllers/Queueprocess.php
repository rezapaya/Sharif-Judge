<?php
/**
 * Sharif Judge online judge
 * @file Queueprocess.php
 * @author Mohammad Javad Naderi <mjnaderi@gmail.com>
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Queueprocess extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		// This controller should not be called from a browser
		if ( PHP_SAPI !== 'cli' OR ! defined('STDIN'))
			show_404();
		$this->load->model('queue_model');
		$this->load->model('submit_model');
	}


	// ------------------------------------------------------------------------


	/**
	 * This is the main function for processing the queue
	 * This function judges queue items one by one
	 */
	public function run() {

		$queue_item = $this->queue_model->get_first_item();

		if ($queue_item === NULL) {
			$this->settings_model->set_setting('queue_is_working', '0');
			exit;
		}
		if ($this->settings_model->get_setting('queue_is_working'))
			exit;
		$this->settings_model->set_setting('queue_is_working', '1');
		
		$output_size_limit = $this->settings_model->get_setting('output_size_limit') * 1024;

		do {

			if ( ! $this->settings_model->get_setting('queue_is_working') )
				exit;
			$submit_id = $queue_item['submit_id'];
			$username = $queue_item['username'];
			$assignment = $queue_item['assignment'];
			$problem = $this->assignment_model->problem_info($assignment, $queue_item['problem']);
			$type = $queue_item['type'];  // $type can be 'judge' or 'rejudge'

			$submission = $this->submit_model->get_submission($username, $assignment, $problem['id'], $submit_id);

			$file_type = $submission['file_type'];
			$file_extension = filetype_to_extension($file_type);
			$raw_filename = $submission['file_name'];
			$main_filename = $submission['main_file_name'];

			$assignments_dir = rtrim($this->settings_model->get_setting('assignments_root'), '/');
			$tester_path = rtrim($this->settings_model->get_setting('tester_path'), '/');
			$problemdir = $assignments_dir."/assignment_$assignment/p".$problem['id'];
			$userdir = "$problemdir/$username";
			$the_file = "$userdir/$raw_filename.$file_extension";

			// python shield settings
			$enable_py2_shield = $this->settings_model->get_setting('enable_py2_shield');
			$enable_py3_shield = $this->settings_model->get_setting('enable_py3_shield');

			$op1 = $this->settings_model->get_setting('enable_log');
			$op2 = $this->settings_model->get_setting('enable_easysandbox');
			$op3 = 0;
			if ($file_type === 'c')
				$op3 = $this->settings_model->get_setting('enable_c_shield');
			elseif ($file_type === 'cpp')
				$op3 = $this->settings_model->get_setting('enable_cpp_shield');

			$op4 = $this->settings_model->get_setting('enable_java_policy');

			if ($file_type === 'c' OR $file_type === 'cpp')
				$time_limit = $problem['c_time_limit']/1000;
			else if ($file_type === 'java')
				$time_limit = $problem['java_time_limit']/1000;
			else if ($file_type === 'py2' OR $file_type === 'py3')
				$time_limit = $problem['python_time_limit']/1000;
			$time_limit = round($time_limit, 3);
			$time_limit_int = floor($time_limit) + 1;

			$memory_limit = $problem['memory_limit'];
			$diff_cmd = $problem['diff_cmd'];
			$diff_arg = $problem['diff_arg'];

			$cmd = "cd $tester_path;\n./tester.sh $problemdir ".escapeshellarg($username).' '.escapeshellarg($main_filename).' '.escapeshellarg($raw_filename)." $file_type $time_limit $time_limit_int $memory_limit $output_size_limit $diff_cmd $diff_arg $op1 $op2 $op3 $op4";

			file_put_contents($userdir.'/log', $cmd);

			// Adding shield to python source if shield is enabled for python
			if ($file_type === 'py2' && $enable_py2_shield){
				$source = file_get_contents($the_file);
				file_put_contents($the_file, file_get_contents($tester_path.'/shield/shield_py2.py').$source);
			}
			if ($file_type === 'py3' && $enable_py3_shield){
				$source = file_get_contents($the_file);
				file_put_contents($the_file, file_get_contents($tester_path.'/shield/shield_py3.py').$source);
			}

			// Running tester (judging the code)
			$output = shell_exec($cmd);


			// Removing shield from python source if shield is enabled for python
			if ($file_type === 'py2' && $enable_py2_shield)
				file_put_contents($the_file, $source);
			if ($file_type === 'py3' && $enable_py3_shield)
				file_put_contents($the_file, $source);

			// Deleting the jail folder, if still exists
			shell_exec("cd $tester_path; rm -rf jail*");

			$output = trim($output);

			// Saving judge result
			if ( $output != -4 && $output != -5 && $output != -6 )
				shell_exec("cp $userdir/result.html $userdir/result-{$submit_id}.html");

			$score = ($output<0?0:$output);
			$stat = 'SCORE';
			switch($output){
				case -1: $stat = 'Compilation Error'; break;
				case -2: $stat = 'Syntax Error'; break;
				case -3: $stat = 'Bad System Call'; break;
				case -4: $stat = 'Invalid Special Judge'; break;
				case -5: $stat = 'File Format not Supported'; break;
				case -6: $stat = 'Judge Error'; break;
			}

			$submission['status'] = $stat;
			$submission['pre_score'] = $score;

			$this->queue_model->add_judge_result_to_db($submission, $type);

			// Remove the judged item from queue
			$this->queue_model->remove_item($username, $assignment, $problem['id'], $submit_id);

			// Get next item from queue
			$queue_item = $this->queue_model->get_first_item();

		}while($queue_item !== NULL);

		$this->settings_model->set_setting('queue_is_working', '0');

	}

}