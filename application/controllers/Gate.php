<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gate extends CI_Controller {


	public function __construct()
	{
		parent::__construct();
		$this->load->helper('app_helper');
		$this->load->database(database());
		$this->load->helper('form');
		$this->load->helper('url');

		$this->load->model("students_model");
		$this->load->model("guardian_model");
		$this->load->model("app_config");
		$this->load->model("gate_logs_model");


		$this->load->library('form_validation');
		$this->load->library('session');

		$this->data["title"] = "Main Title";
		$this->data["css_scripts"] = $this->load->view("scripts/css","",true);
		$this->data["js_scripts"] = $this->load->view("scripts/js","",true);
		$this->data["meta_scripts"] = $this->load->view("scripts/meta","",true);
		
		$modal_data["modals_sets"] = "home";
		$modal_data["rfid_scanned_addstudent"] = $this->session->userdata("rfid_scanned_addstudent");
		$this->data["modaljs_scripts"] = $this->load->view("layouts/modals",$modal_data,true);
		
		$navbar_data["navbar_type"] = "home";
		($this->session->userdata("guardian_sessions")?$navbar_data["navbar_is_logged_in"] = TRUE:$navbar_data["navbar_is_logged_in"] = FALSE);
		$this->data["navbar_scripts"] = $this->load->view("layouts/navbar",$navbar_data,true);
		$this->form_validation->set_error_delimiters('', '');
	}

	public function index($arg='')
	{
		$this->data["modaljs_scripts"] = "";
		$this->data["navbar_scripts"] = "";

		if($this->session->userdata("gate_sessions")){
			$this->data["title"] = "Gate";
			$this->load->view('gate',$this->data);
		}else{
			$this->data["title"] = "Gate Login";
			$this->data["account_password_error"] = "";
			$this->load->view('gate-login',$this->data);
		}
	}

	public function login($value='')
	{
			$this->form_validation->set_rules('account_password', 'Password', 'required|min_length[5]|max_length[12]|trim|htmlspecialchars');

			if ($this->form_validation->run() == FALSE)
			{
				$data["is_valid"] = FALSE;
				$data["account_password_error"] = form_error('account_password');
				$this->data["account_password_error"] = form_error('account_password');
				$this->data["title"] = "Gate Login";
				$this->load->view('gate-login',$this->data);
			}
			else
			{
				$data["password"] = md5($account_password = $this->input->post("account_password"));
				$data["id"] = 1;
				$data["is_valid"] = $this->app_config->login($data);
				
				if($data["is_valid"]){
					$data["account_password_error"] = "";
					$data["redirect"] = base_url("gate");
					redirect("gate");
				}else{
					$data["account_password_error"] = "Incorrect Passord. Try Again.";
					$data["redirect"] = "";
					$this->data["account_password_error"] = "Incorrect Passord. Try Again.";
					$this->data["title"] = "Gate Login";
					$this->load->view('gate-login',$this->data);
				}
			}
		}
	
	public function logout($value='')
	{
		$this->session->unset_userdata('guardian_sessions');
	}

}
