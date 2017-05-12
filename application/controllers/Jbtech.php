<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jbtech extends CI_Controller {


	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('app_helper');


		$this->load->model("students_model");
		$this->load->model("rfid_model");
		$this->load->model("guardian_model");
		$this->load->model("teachers_model");
		$this->load->model("gate_logs_model");
		$this->load->model("staffs_model");
		$this->load->model("classes_model");
		$this->load->model("sms_model");
		$this->load->model("jbtech_model");


		$this->load->library('form_validation');
		$this->load->library('session');
		$this->form_validation->set_error_delimiters('', '');
		
		
		$this->data["title"] = "Main Title";
		$this->data["css_scripts"] = $this->load->view("scripts/css","",true);
		$this->data["js_scripts"] = $this->load->view("scripts/js","",true);
		$this->data["meta_scripts"] = $this->load->view("scripts/meta","",true);
		


		$modal_data["guardians_list"] = $this->guardian_model->get_list();
		$modal_data["login_user_data"] = $this->session->userdata("jbtech_sessions");
		$modal_data["teachers_list"] = $this->teachers_model->get_list();
		$modal_data["students_list"] = $this->students_model->get_list();
		$modal_data["staffs_list"] = $this->staffs_model->get_list();
		$modal_data["classes_list"] = $this->classes_model->get_list();

		$modal_data["modals_sets"] = "jbtech";
		$this->data["modaljs_scripts"] = $this->load->view("layouts/modals",$modal_data,true);
		
		$navbar_data["navbar_type"] = "jbtech";
		($this->session->userdata("jbtech_sessions")?$navbar_data["navbar_is_logged_in"] = TRUE:$navbar_data["navbar_is_logged_in"] = FALSE);
		$this->data["navbar_scripts"] = $this->load->view("layouts/navbar",$navbar_data,true);

		if(current_url()==base_url("jbtech")||current_url()==base_url("jbtech/login")){
			
		}else{
			if($this->session->userdata("jbtech_sessions")==NULL){
				redirect(base_url());
			}
		}
	}

	public function index($student_id='')
	{
		$this->data["login_type"] = "jbtech";
		if($this->session->userdata("jbtech_sessions")){
			$this->load->view('jbtech-students',$this->data);
		}else{
			$this->data["type"] = "JBTECH LOGIN";
			$this->data["account_password_error"] = "";
			$this->load->view('app-login',$this->data);
		}
	}

	public function teachers($arg='')
	{

			$this->load->view('jbtech-teachers',$this->data);
	}

	public function students($arg='')
	{
			$this->load->view('jbtech-students',$this->data);

	}

	public function staffs($arg='')
	{
			$this->load->view('jbtech-staffs',$this->data);

	}

	public function logout($value='')
	{
		$this->session->sess_destroy();
		redirect("jbtech");		
		
	}


	public function login($arg='')
	{
		if($_POST){
			$this->form_validation->set_rules('account', 'Account', 'required|min_length[5]|max_length[12]|is_in_db[jbtech.username]|trim|htmlspecialchars');
			$this->form_validation->set_rules('account_password', 'Password', 'required|min_length[5]|max_length[12]|trim|htmlspecialchars');
			$this->form_validation->set_message('is_in_db', 'This account is invalid');

			if ($this->form_validation->run() == FALSE)
			{
				$data["is_valid"] = FALSE;
				$data["account_error"] = form_error('account');
				$data["account_password_error"] = form_error('account_password');
				$this->data["type"] = "JBTECH LOGIN";
				$this->data["account_password_error"] = form_error('account_password');
				$this->data["login_type"] = "jbtech";
				$this->load->view('app-login',$this->data);
			}
			else
			{
				$data["username"] = $account_id = $this->input->post("account");
				$data["password"] = md5($account_password = $this->input->post("account_password"));
				$data["is_valid"] = $this->jbtech_model->login($data);
				$data["account_error"] = "";
				
				if($data["is_valid"]){
					$data["account_password_error"] = "";
					$data["redirect"] = base_url("jbtech");
					redirect(base_url("jbtech"));


				}else{
					$data["account_password_error"] = "Incorrect Passord. Try Again.";
					$data["redirect"] = "";
					$this->data["type"] = "JBTECH LOGIN";
					$this->data["login_type"] = "jbtech";
					$this->data["account_password_error"] = "Incorrect Passord. Try Again.";
					$this->load->view('app-login',$this->data);
				}
			}
		}
	}

}