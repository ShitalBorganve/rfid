<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {


	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->library('session');

		$this->load->library('form_validation');

		$this->load->model("students_model");
		$this->load->model("guardian_model");
		$this->load->model("gate_logs_model");

		$this->data["title"] = "Main Title";
		$this->data["css_scripts"] = $this->load->view("scripts/css","",true);
		$this->data["js_scripts"] = $this->load->view("scripts/js","",true);
		$this->data["meta_scripts"] = $this->load->view("scripts/meta","",true);

		if($this->session->userdata("guardian_sessions")){
			$modal_data["modals_sets"] = "home";
			$get_data = array();
			$get_data["id"] = $this->session->userdata("guardian_sessions")->id;
			$modal_data["login_user_data"] = $this->guardian_model->get_data($get_data,TRUE);
			$modal_data["rfid_scanned_addstudent"] = $this->session->userdata("rfid_scanned_addstudent");
			$this->data["modaljs_scripts"] = $this->load->view("layouts/modals",$modal_data,true);
		}
		
		$navbar_data["navbar_type"] = "home";
		($this->session->userdata("guardian_sessions")?$navbar_data["navbar_is_logged_in"] = TRUE:$navbar_data["navbar_is_logged_in"] = FALSE);
		$this->data["navbar_scripts"] = $this->load->view("layouts/navbar",$navbar_data,true);


		if(current_url()==base_url()||current_url()==base_url("home")||current_url()==base_url("/login")||current_url()==base_url("home/login")){
			
		}else{
			if($this->session->userdata("guardian_sessions")==NULL){
				redirect(base_url());
			}
		}

	}

	public function index($arg='')
	{
		
		if(!$this->session->userdata("guardian_sessions")){
			$this->data["title"] = "Guardian Login";
			$this->data["account_password_error"] = "";
			$this->data["login_type"] = "home";
			$this->data["type"] = "GUARDIAN LOGIN";
			$this->load->view('app-login',$this->data);
		}else{
			$this->data["title"] = "My Students";
			$guardian_data = $this->session->userdata("guardian_sessions");
			$where["deleted"] = 0;
			$where["guardian_id"] = $guardian_data->id;
			$students_list = $this->students_model->get_list($where);
			// var_dump($students_list);
			$this->data["students_list"] = $this->students_model->get_list($where);
			$this->load->view('guardian_home',$this->data);
		}
		
	}

	public function logout($value='')
	{
		$this->session->sess_destroy();
		redirect("/");
	}

	public function login($value='')
	{
		
		if($_POST){
			$this->form_validation->set_rules('account', 'Account', 'required|min_length[5]|max_length[50]|is_valid[guardians.contact_number]|trim|htmlspecialchars');
			$this->form_validation->set_rules('account_password', 'Password', 'required|min_length[5]|max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_message('is_in_db', 'This account is invalid');
			$this->form_validation->set_error_delimiters('', '');

			if ($this->form_validation->run() == FALSE)
			{
				$data["is_valid"] = FALSE;
				$data["account_error"] = form_error('account');
				$data["account_password_error"] = form_error('account_password');
				$this->data["account_password_error"] = form_error('account_password');
				$this->data["title"] = "Guardian Login";
				$this->data["login_type"] = "home";
				$this->data["type"] = "GUARDIAN LOGIN";
				$this->load->view('app-login',$this->data);
			}
			else
			{
				$login_data["contact_number"] = $account_id = $this->input->post("account");
				$login_data["password"] = $account_password = $this->input->post("account_password");
				$login_data["deleted"] = 0;
				$login_data["password"] = md5($login_data["password"]);

				$data["is_valid"] = $this->guardian_model->login($login_data);
				$data["account_error"] = "";
				
				if($data["is_valid"]){
					$data = array();
					$data["is_valid"] = TRUE;
					$data["redirect"] = base_url();
					redirect();
				}else{
					$data["account_password_error"] = "Incorrect Passord. Try Again.";
					$data["redirect"] = "";
					$this->data["account_password_error"] = "Incorrect Passord. Try Again.";
					$this->data["title"] = "Guardian Login";
					$this->data["login_type"] = "home";
					$this->data["type"] = "GUARDIAN LOGIN";
					$this->load->view('app-login',$this->data);
				}
			}
		}else{
			redirect();
		}
		
	}

}
