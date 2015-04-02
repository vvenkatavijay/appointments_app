<?php

/**
* 
*/
class User extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}

	public function add_user($user_data) 
	{
		$user_query = "INSERT INTO users VALUES(NULL, ?, ?, ?, ?, NOW())";

		return $this->db->query($user_query, $user_data);
	}

	public function get_appointment($id) {
		$appt_query = "SELECT * FROM appointments WHERE id = ?";

		$raw_data = $this->db->query($appt_query, $id)->row_array();
		return $raw_data;
	}

	public function get_user_details($email)
	{
		$user_query = "SELECT * FROM users WHERE email = ?";

		return $this->db->query($user_query, $email)->row_array();
	}

	public function get_current_appointments($user_id)
	{
		$appoint_query = 'SELECT * FROM appointments WHERE DATE(time) = curdate() 
														AND user_id = ?
														ORDER BY time ASC';

		$raw_appointments = $this->db->query($appoint_query, $user_id)->result_array();
		return $this->process_appointments($raw_appointments);
	}

	public function get_future_appointments($user_id)
	{
		$appoint_query = 'SELECT * FROM appointments WHERE DATE(time) > curdate() 
														AND user_id = ?
														ORDER BY time ASC';

		$raw_appointments = $this->db->query($appoint_query, $user_id)->result_array();
		return $this->process_appointments($raw_appointments);
	}

	public function add_appointment($data) {
		
		$time = $this->get_mysql_time_format($data); 
		$new_appt_query = "INSERT INTO appointments VALUES(NULL, ?, ?, ?, NOW())";

		$result = $this->db->query($new_appt_query, array($data['user_id'], $data['task'], $time));
		return $result;
	}

	public function remove_appointment($id) {

		$remove_query = "DELETE FROM appointments WHERE id = ?";

		return $this->db->query($remove_query, $id);
	}

	public function process_appointments($raw_appointments)
	{
		date_default_timezone_set('America/Los_Angeles');
		if(!$raw_appointments)
		{
			return FALSE;
		} else {
			foreach ($raw_appointments as $key => $appointment) {
				$now = new DateTime();
				$temp_date = date_create_from_format('Y-m-d H:i:s', $appointment['time']);
				$raw_appointments[$key]['time'] = $temp_date->format('H:i');
				$raw_appointments[$key]['date'] = $temp_date->format('F j');
				if($temp_date < $now)
					$raw_appointments[$key]['status'] = "Done";
				else
					$raw_appointments[$key]['status'] = "Pending";
			}

			return $raw_appointments;
		}
	}

	public function get_mysql_time_format($data) {

		$date_string = $data['date_of_appointment'] ." " . $data['time_of_appointment'];

		$temp_date = date_create_from_format('m/d/Y H:i', $date_string);
		return $temp_date->format('Y-m-d H:i:s');
	}
}


?>