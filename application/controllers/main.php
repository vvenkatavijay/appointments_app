<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//$this->output->enable_profiler();
	}

	public function index()
	{
		echo "Welcome to CodeIgniter. The default Controller is Main.php";
	}

	public function add_error($error) 
	{
		$errors = $this->session->flashdata('errors');

		if($errors) {
			$errors .= $error;
		} else {
			$errors = $error;
		}

		$this->session->set_flashdata('errors', $errors);
	}

	public function check_date($string)
	{
		date_default_timezone_set('America/Los_Angeles');
		$date = date_create_from_format('m/d/Y', $string);
		$today = new DateTime();

		if($date < $today)
		{
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function check_for_future_date($string)
	{
		date_default_timezone_set('America/Los_Angeles');
		$date = date_create_from_format('m/d/Y', $string);
		$today = new DateTime();

		if($date >= $today)
		{
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function check_for_valid_time($string)
	{
		date_default_timezone_set('America/Los_Angeles');
		$time = date_create_from_format('H:i', $string);

		return $time;
	}

}

//end of main controller