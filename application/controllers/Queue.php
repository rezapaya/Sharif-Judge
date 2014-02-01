<?php
/**
 * Sharif Judge online judge
 * @file Queue.php
 * @author Mohammad Javad Naderi <mjnaderi@gmail.com>
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Queue extends CI_Controller
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
		if ( $this->user_level <= 1) // permission denied
			show_404();
		$this->load->model('queue_model');
	}


	// ------------------------------------------------------------------------


	public function index()
	{

		$data = array(
			'username' => $this->username,
			'user_level' => $this->user_level,
			'all_assignments' => $this->assignment_model->all_assignments(),
			'assignment' => $this->assignment,
			'title' => 'Submission Queue',
			'queue' => $this->queue_model->get_queue(),
			'working' => $this->settings_model->get_setting('queue_is_working')
		);

		$this->twig->display('pages/admin/queue.twig', $data);
	}


	// ------------------------------------------------------------------------


	public function pause()
	{
		if ( ! $this->input->is_ajax_request() )
			show_404();
		$this->settings_model->set_setting('queue_is_working','0');
		echo 'success';
	}


	// ------------------------------------------------------------------------


	public function resume()
	{
		if ( ! $this->input->is_ajax_request() )
			show_404();
		process_the_queue();
		echo 'success';
	}


	// ------------------------------------------------------------------------


	public function empty_queue()
	{
		if ( ! $this->input->is_ajax_request() )
			show_404();
		$this->queue_model->empty_queue();
		echo 'success';
	}
}