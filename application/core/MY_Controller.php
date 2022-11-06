<?php



class MY_Controller extends CI_Controller{



public $sessionData,$data;



	/*function __construct(){

		parent::__construct();

		if(empty($this->session->userdata('my_session_id'))){

			$uniqueId = uniqid($this->input->ip_address(), TRUE);

			$this->session->set_userdata("my_session_id", md5($uniqueId));

		}



		if($this->session->userdata('user_logged_in')){

			$this->load->model('admin');

			$this->sessionData = $this->session->userdata('user_logged_in');

		}

		$this->init();

	}*/



	public function init()

    {



    }



	public function loginCheck(){

		if(empty($this->session->userdata('user_logged_in'))){

              redirect(BASE_URL.'erp-new/settings/login','refresh');

		}



    }



	public function adminloginCheck(){

		if(empty($this->session->userdata('admin_logged_in'))){


				redirect(BASE_URL.'login','refresh');

		}

	}



	public function customerloginCheck(){

		if(empty($this->session->userdata('customer_logged_in'))){

              redirect(BASE_URL.'login','refresh');

		}



    }







	public function createPagination($data){

	    $this->load->library('pagination');

	    $config['base_url'] = $data['base_url'];

	    $config['total_rows'] = $data['total_rows'];

	    $config['per_page'] = $data['per_page'];

	    $config['uri_segment'] = $data['uri_segment'];

	    $choice = $config["total_rows"] / $config["per_page"];

	    $config["num_links"] = round($choice);

	    $config['full_tag_open'] = ' <ul class="pagination pagination-sm no-margin pull-right" style="cursor:pointer;">';

	    $config['full_tag_close'] = '</ul>';

	    $config['first_link'] = 'First';

	    $config['first_tag_open'] = '<li >';

	    $config['first_tag_close'] = '</li>';

	    $config['last_link'] = 'Last';

	    $config['last_tag_open'] = '<li>';

	    $config['last_tag_close'] = '</li>';

	    $config['next_link'] = '&gt;';

	    $config['next_tag_open'] = '<li>';

	    $config['next_tag_close'] = '</li>';

	    $config['prev_link'] = '&lt;';

	    $config['prev_tag_open'] = '<li>';

	    $config['prev_tag_close'] = '</li>';

	    $config['cur_tag_open'] = '<li class="paginate_button active"><a href="#">';

	    $config['cur_tag_close'] = '</a></li>';

	    $config['num_tag_open'] = '<li>';

	    $config['num_tag_close'] = '</li>';

	    $this->pagination->initialize($config);



	    return $this->pagination->create_links();



	}





	public function generateRandomString($length = 20) {

	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

	    $charactersLength = strlen($characters);

	    $randomString = '';

	    for ($i = 0; $i < $length; $i++) {

	        $randomString .= $characters[rand(0, $charactersLength - 1)];

	    }

	    return $randomString;

	}



	public function sendMail($to,$subject,$message,$debugger=FALSE)
	{	
	$config['protocol'] = 'upd';
	$config['smtp_host'] = 'smtp.sendgrid.net';
	$config['smtp_port'] = '587';
	$config['smtp_timeout'] = '15';
	$config['smtp_user'] = 'sales@equalinfotech.com';
	$config['smtp_pass'] = 'sales@equalinfotech11';
	$config['charset']    = 'utf-8';
	$config['newline']    = "\r\n";
	$config['_smtp_auth'] = 'true';
	$config['smtp_crypto'] = 'tls';
	$config['mailtype'] = 'html';
	$this->load->library('email');
	$this->email->initialize($config);
	$this->email->from('vikram@equalinfotech.com', 'Swiss');
	$this->email->to($to);
	$this->email->subject($subject);
	$this->email->message($message);
	if(!$this->email->send($to)){
	if($debugger)
	{
		echo $this->email->print_debugger();
	}
	return false;
	}
	else
	{
		return true;
	}
	}







	public function doUpload($field="",$dir="",$old_file=""){
		$config['upload_path'] = $dir;
		$config['allowed_types'] = '*';
		if($_FILES[$field]['name'] <> ""){
			if(file_exists($dir.$old_file) && $old_file <> ""){

				unlink($dir.$old_file);

		   	}



		   	if (!is_dir($dir)){

				echo $_FILES[$field]['name'];

		   		mkdir($dir, 0777, TRUE);

		   	}



			$this->load->library('upload', $config);
			$this->upload->initialize($config);

			if ( ! $this->upload->do_upload($field)){

				 $error = array('error' => $this->upload->display_errors());

			}

			else{

				$data = array('upload_data' => $this->upload->data());

				return $data['upload_data']['file_name'];

			}

		}else{

			return $old_file;

		}

	}



	public function thumbnail($uploadData,$uploadPath,$thumb_width,$thumb_height)
	{
		$uploadedImage = $uploadData['file_name'];
		$org_image_size = $uploadData['image_width'].'x'.$uploadData['image_height'];

		//$source_path = $this->uploadPath.$uploadedImage;
		$thumb_path = $uploadPath.'/'.'thumb/';


		// Image resize config
		$config['image_library']    = 'gd2';
		$config['source_image']     = $uploadPath.'/'.$uploadedImage;
		$config['new_image']         = $thumb_path;
		$config['maintain_ratio']     = FALSE;
		$config['width']            = $thumb_width;
		$config['height']           = $thumb_height;

		// Load and initialize image_lib library
		$this->load->library('image_lib', $config);
			//echo '<pre>'; print_r($config);die;
		// Resize image and create thumbnail
		$this->image_lib->resize();
	}






}
