<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Users extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('api/User_model', 'user_model');
	}

	public function checkMethod($method, $apiName)
	{
		if ($method == 'POST') {

			if ($_SERVER['REQUEST_METHOD'] != 'POST') {
				$results['success'] = 'false';
				$results['error'] = 1;
				$results['msg'] = 'Expecting Details - Bad Request';
				$results['data'] = [];
				$results['service'] = BASE_URL . 'api/user/' . $apiName;
				echo json_encode($results);
				exit();
			}
		} else {
			if ($_SERVER['REQUEST_METHOD'] != 'GET') {
				$results['success'] = 'false';
				$results['error'] = 1;
				$results['msg'] = 'Expecting Details - Bad Request';
				$results['data'] = [];
				$results['service'] = BASE_URL . 'api/user/' . $apiName;
				echo json_encode($results);
				exit();
			}
		}
	}

	public function registerUser()
	{
		header('Content-type: application/json; charset=utf-8');
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
		$this->checkMethod('POST', 'registerUser');
		$json_file = file_get_contents('php://input');
		$jsonvalue = json_decode($json_file, true);
		$email = !empty($jsonvalue['email']) ? $jsonvalue['email'] : '';
		$password = !empty($jsonvalue['password']) ? md5($jsonvalue['password']) : '';
		$phone = !empty($jsonvalue['phone']) ? $jsonvalue['phone'] : '';
		$name = !empty($jsonvalue['name']) ? $jsonvalue['name'] : '';
		if (empty($name)) {
			$results['success'] = 'false';
			$results['error'] = 1;
			$results['data'] = [];
			$results['msg'] = 'Name is missing ';
			$results['service'] = BASE_URL . 'api/user/registerUser';
		} else if (empty($email)) {
			$results['success'] = 'false';
			$results['error'] = 1;
			$results['data'] = [];
			$results['msg'] = 'Email is missing ';
			$results['service'] = BASE_URL . 'api/user/registerUser';
		} else if (empty($password)) {
			$results['success'] = 'false';
			$results['error'] = 1;
			$results['data'] = [];
			$results['msg'] = 'Password is missing ';
			$results['service'] = BASE_URL . 'api/user/registerUser';
		} else if (empty($phone)) {
			$results['success'] = 'false';
			$results['error'] = 1;
			$results['data'] = [];
			$results['msg'] = 'Phone is missing ';
			$results['service'] = BASE_URL . 'api/user/registerUser';
		} else {
			$user_info 	 = $this->user_model->checkEmail($email);
			if (!empty($user_info)) {
				$results['success'] = 'false';
				$results['error'] = 1;
				$results['data'] = [];
				$results['msg'] = 'Email Already Exist';
				$results['service'] = BASE_URL . 'api/user/registerUser';
			} else {
				$postData = array(
					'name' 	=> $name,
					'email' 	=> $email,
					'password' 	=> $password,
					'phone' 	=> $phone,
					'date_added' 	=> date('Y-m-d H:i:s'),
				);
				$user_info 	 = $this->user_model->registerUser($postData);
				if (!empty($user_info)) {
					$results['success'] = 'true';
					$results['error'] = 0;
					$results['data'] = '';
					$results['msg'] = 'Details Register Successfully';
					$results['service'] = BASE_URL . 'api/user/registerUser';
				} else {
					$results['success'] = 'false';
					$results['error'] = 1;
					$results['msg'] = 'Server not responding, please try again later.';
					$results['service'] = BASE_URL . 'api/user/registerUser';
				}
			}
		}
		echo json_encode($results);
		exit();
	}

	public function loginUser()
	{
		header('Content-type: application/json; charset=utf-8');
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
		$this->checkMethod('POST', 'loginUser');
		$json_file = file_get_contents('php://input');
		$jsonvalue = json_decode($json_file, true);
		$email  	= !empty($jsonvalue['email']) ? $jsonvalue['email'] : '';
		$password  	= !empty($jsonvalue['password']) ? md5($jsonvalue['password']) : '';
		if (empty($email)) {
			$results['success'] = 'false';
			$results['error'] = 1;
			$results['data'] = [];
			$results['msg'] = 'Expecting Details - Email';
			$results['service'] = BASE_URL . 'api/user/loginUser';
		} else if (empty($password)) {
			$results['success'] = 'false';
			$results['error'] = 1;
			$results['data'] = [];
			$results['msg'] = 'Expecting Details - Password';
			$results['service'] = BASE_URL . 'api/user/loginUser';
		} else {
			$user_info = $this->user_model->loginUser($email, $password); //verify otp
			if (!empty($user_info)) {
				$results['success'] = 'true';
				$results['error'] = 0;
				$results['data'] = [];
				$results['msg'] = 'Expecting Details - Login Successfully';
				$results['service'] = BASE_URL . 'api/user/loginUser';
			} else {
				$results['success'] = 'false';
				$results['error'] = 1;
				$results['data'] = [];
				$results['msg'] = 'Expecting Details - please enter valid email and password';
				$results['service'] = BASE_URL . 'api/user/loginUser';
			}
		}
		echo json_encode($results);
		exit();
	}
}
