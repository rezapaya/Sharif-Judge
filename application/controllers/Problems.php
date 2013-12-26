<?php
/**
 * Sharif Judge online judge
 * @file Problems.php
 * @author Mohammad Javad Naderi <mjnaderi@gmail.com>
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Problems extends CI_Controller
{

	private $username;
	private $assignment;
	private $user_level;


	// ------------------------------------------------------------------------


	public function __construct()
	{
		parent::__construct();

		$this->load->driver('session');
		if ( ! $this->session->userdata('logged_in')) // if not logged in
			redirect('login');

		$this->username = $this->session->userdata('username');
		$this->assignment = $this->assignment_model->assignment_info($this->user_model->selected_assignment($this->username));
		$this->user_level = $this->user_model->get_user_level($this->username);
	}


	// ------------------------------------------------------------------------


	public function index($assignment_id = NULL, $problem_id = 1)
	{

		if ($assignment_id === NULL)
			$assignment_id = $this->assignment['id'];

		$this->assignment = $this->assignment_model->assignment_info($assignment_id);

		$data = array(
			'username' => $this->username,
			'user_level' => $this->user_level,
			'all_assignments' => $this->assignment_model->all_assignments(),
			'all_problems' => $this->assignment_model->all_problems($assignment_id),
			'title' => 'Problems',
			'assignment' => $this->assignment,
			'style' => 'main.css',
		);

		if ( ! is_numeric($problem_id) || $problem_id < 1 || $problem_id > count($data['all_problems']))
			show_404();

		$data['problem'] = array(
			'id' => $problem_id,
			'description' => '<p>Description not found</p>'
		);

		$path = rtrim($this->settings_model->get_setting('assignments_root'),'/')."/assignment_{$assignment_id}/p{$problem_id}/desc.html";
		if (file_exists($path))
			$data['problem']['description'] = file_get_contents($path);

		$this->load->view('templates/header', $data);
		$this->load->view('pages/problems', $data);
		$this->load->view('templates/footer');
	}

}