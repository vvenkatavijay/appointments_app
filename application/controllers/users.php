<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once('main.php'); 

/**
* The Users class
*/
class Users extends Main
{
	
	function __construct()
	{
		parent::__construct();
	}

	public function index() 
	{
		$errors = $this->session->flashdata("errors");
		$success_message = $this->session->flashdata("success_message");

		$view_data = array('errors' => $errors,
							'success_message' => $success_message);
		
		$this->load->view("welcome.php", $view_data);
	}

	public function register()
	{
		
		$this->load->library("form_validation");

		$this->form_validation->set_rules('user_name', 'Name', 'required');
		$this->form_validation->set_rules('password', 'Password', 
			'required|min_length[8]|matches[confpassword]');
		$this->form_validation->set_rules('email', 'Email', 
			'required|valid_email|is_unique[users.email]');
		$this->form_validation->set_rules('date_of_birth', 'Date of Birth', 'required');

		$this->form_validation->set_message('is_unique', '%s already exists.');
		
		if($this->form_validation->run() && 
		   $this->check_date($this->input->post('date_of_birth')) ) 
		{
			$this->load->model("User");

			$user_data = $this->input->post(NULL, TRUE);
			$user_data['password'] = md5($user_data['password']);
			unset($user_data['confpassword']);

			if($this->User->add_user($user_data)) {
				$this->session->set_flashdata("success_message", 
					"Registration successful. Please sign in to continue");
			} else {
				$this->add_error("<p>Unable to add user to database</p>");
			}
			
		} else {
			$this->add_error(validation_errors());
			if (!$this->check_date($this->input->post('date_of_birth'))) {
				$this->add_error("<p>Please enter a valid birth date</p>");
			}
		}

		redirect("/");

	}

	public function signin() 
	{
		$this->load->library('form_validation');
		$this->load->model('User');

		$this->form_validation->set_rules('email', 'Email', 
			'required|valid_email');

		if($this->form_validation->run()) {

			$email = $this->input->post('email');
			$user_details = $this->User->get_user_details($email);

			if(!$user_details) {

				$this->add_error("<p> Unable to login due to database error. Please try later </p>");

			} else if(md5($this->input->post('password')) === $user_details['password']){

				unset($user_details['password']);
				$this->session->set_userdata('user_details', $user_details);

				redirect("/users/appointments");

			} else {

				$this->add_error('<p>Invalid login credentials</p>');
			}
		} else {
			$this->add_error(validation_errors());
		}

		redirect("/");
	}

	public function appointments() {
		$this->load->model("User");

		date_default_timezone_set('America/Los_Angeles');
		$today = date('j F, Y');
		$user_details = $this->session->userdata('user_details');
		$current_appointments = $this->User->get_current_appointments($user_details['id']);

		$future_appointments = $this->User->get_future_appointments($user_details['id']);

		$view_data = array("user_details" => $user_details,
							"today" => $today,
							"current_appointments" => $current_appointments,
							"future_appointments" => $future_appointments,
							"errors" => $this->session->flashdata('errors'),
							"success_message" => $this->session->flashdata('success_message'));

		$this->load->view('appointments', $view_data);
	}

	public function add_appointment() 
	{
		$this->load->library("form_validation");

		$this->form_validation->set_rules('date_of_appointment', 'Date', 'required');
		$this->form_validation->set_rules('time_of_appointment', 'Time', 'required');
		$this->form_validation->set_rules('task', 'Task', 'required');

		if($this->form_validation->run() && 
		   $this->check_for_future_date($this->input->post('date_of_appointment')) &&
		   $this->check_for_valid_time($this->input->post('time_of_appointment')) ) 
		{
			$this->load->model("User");
			$user_details = $this->session->userdata("user_details");

			$appointment_data = $this->input->post(NULL,TRUE);
			$appointment_data['user_id'] = $user_details['id'];

			if($this->User->add_appointment($appointment_data)) {
				$this->session->set_flashdata("success_message", 
					"<p>Appointment added successfully!");
			} else {
				$this->add_error("<p>Unable to add appointment to database</p>");
			}

		} else {
			$this->add_error(validation_errors());
			if (!$this->check_for_future_date($this->input->post('date_of_appointment'))) {
				$this->add_error("<p>Please enter a date in the future</p>");
			}

			if (!$this->check_for_valid_time($this->input->post('time_of_appointment'))) {
				$this->add_error("<p>Please enter a valid time in future (hh:mm format)</p>");
			}
		}

		redirect("/users/appointments");
	}

	public function remove_appointment($id)
	{
		$this->load->model('User');

		if(!$this->User->remove_appointment($id)) {
			$this->add_error("<p>Unable to remove appointment. Please try again later</p>");
		}
		redirect("/users/appointments");
	}

	public function edit_appointment($id)
	{
		$this->load->model('User');

		$appt_data = $this->User->get_appointment($id);

		if(!$appt_data) {
			$this->add_error("<p>Unable to fetch appointment data</p>");
			redirect('/users/appointments');
		}

		$temp_date = date_create_from_format('Y-m-d H:i:s', $appt_data['time']);

		$appt_data['date'] = $temp_date->format('m/d/Y');
		$appt_data['time'] = $temp_date->format('H:i');
		$appt_data['errors'] = $this->session->flashdata('errors');
		
		$this->load->view("edit_appointment",$appt_data);
	}

	public function process_edit() 
	{
		$this->load->library("form_validation");

		$this->form_validation->set_rules('date_of_appointment', 'Date', 'required');
		$this->form_validation->set_rules('time_of_appointment', 'Time', 'required');
		$this->form_validation->set_rules('task', 'Task', 'required');

		if($this->form_validation->run() && 
		   $this->check_for_future_date($this->input->post('date_of_appointment')) &&
		   $this->check_for_valid_time($this->input->post('time_of_appointment')) ) 
		{
			$this->load->model("User");
			$user_details = $this->session->userdata("user_details");

			$appointment_data = $this->input->post(NULL,TRUE);
			$appointment_data['user_id'] = $user_details['id'];

			if($this->User->add_appointment($appointment_data)) {

				if($this->User->remove_appointment($this->input->post('id'))) 
				{
					$this->session->set_flashdata("success_message", 
						"<p>Appointment edited successfully!");
					redirect("/users/appointments");
					die();

				} else {
					$this->add_error("<p>Unable to edit appointment</p>");
				}
			} else {
				$this->add_error("<p>Unable to edit appointment</p>");
			}

		} else {
			$this->add_error(validation_errors());
			if (!$this->check_for_future_date($this->input->post('date_of_appointment'))) {
				$this->add_error("<p>Please enter a date in the future</p>");
			}

			if (!$this->check_for_valid_time($this->input->post('time_of_appointment'))) {
				$this->add_error("<p>Please enter a valid time in future (hh:mm format)</p>");
			}
		}

		$url = "/users/edit_appointment/" . $this->input->post('id');
		redirect($url);
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect("/");
	}

}

?>