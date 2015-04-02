<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['default_controller'] = "users";
$route['404_override'] = '';
$route['/appointments'] = '/users/appointments';

//end of routes.php