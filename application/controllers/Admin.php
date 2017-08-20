<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

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
		$this->load->model("app_config");
		$this->load->model("gate_logs_model");
		$this->load->model("staffs_model");
		$this->load->model("classes_model");
		$this->load->model("admin_model");
		$this->load->model("sms_model");

		$this->load->library('form_validation');
		$this->load->library('session');

		//updates
		$this->app_config->updates(current_build());
		
		$this->data["title"] = "Main Title";
		$this->data["css_scripts"] = $this->load->view("scripts/css","",true);
		$this->data["js_scripts"] = $this->load->view("scripts/js","",true);
		$this->data["meta_scripts"] = $this->load->view("scripts/meta","",true);
		


		
		$modal_data["guardians_list"] = $this->guardian_model->get_list();
		$modal_data["login_user_data"] = $this->session->userdata("admin_sessions");
		$modal_data["teachers_list"] = $this->teachers_model->get_list();
		$modal_data["students_list"] = $this->students_model->get_list();
		$modal_data["staffs_list"] = $this->staffs_model->get_list();
		$modal_data["classes_list"] = $this->classes_model->get_list();
		$modal_data["modals_sets"] = "admin";
		$modal_data["app_config"] = $app_config_data = $this->db->get("app_config")->row();
		$this->data["modaljs_scripts"] = $this->load->view("layouts/modals",$modal_data,true);
		

		$navbar_data["navbar_type"] = "admin";
		($this->session->userdata("admin_sessions")?$navbar_data["navbar_is_logged_in"] = TRUE:$navbar_data["navbar_is_logged_in"] = FALSE);
		$navbar_data["school_name"] = $this->db->get("app_config")->row()->client_name;
		$this->data["navbar_scripts"] = $this->load->view("layouts/navbar",$navbar_data,true);

		if(current_url()==base_url("admin")||current_url()==base_url("admin/login")){
			
		}else{
			if($this->session->userdata("admin_sessions")==NULL){
				redirect(base_url("admin"));
			}
		}
	}

	public function index($student_id='')
	{
		$this->data["login_type"] = "admin";
		if($this->session->userdata("admin_sessions")){
			$where["type"] = "entry";
			$gate_log_data = $this->gate_logs_model->get_list();
			$this->data["title"] = "Students Gate Logs";
			$this->load->view('gate-logs-students',$this->data);
		}else{
			$this->data["title"] = "Admin Login";
			$this->data["type"] = "ADMINISTRATOR LOGIN";
			$this->data["account_password_error"] = "";
			$this->load->view('app-login',$this->data);
		}
	}

	public function logout($value='')
	{
		$this->session->sess_destroy();
		redirect("admin");
	}

	public function students($value='')
	{
		$this->data["title"] = "Students List";
		$this->load->view("students-list",$this->data);
	}

	public function teachers($value='')
	{
		$this->data["title"] = "Teachers List";
		$this->load->view("teachers-list",$this->data);
	}

	public function staffs($value='')
	{
		$this->data["title"] = "Staffs List";
		$this->load->view("staffs-list",$this->data);
	}

	public function classes($value='')
	{
		$this->data["title"] = "Classes List";
		$this->load->view("classes-list",$this->data);
	}

	public function guardians($value='')
	{
		$this->data["title"] = "Guardians List";
		$this->load->view("guardians-list",$this->data);
	}
	public function sms($value='')
	{
		$this->data["title"] = "SMS Thread List";
		$this->load->view("sms",$this->data);
	}

	public function fetchers($value='')
	{
		$this->data["title"] = "Fetchers List";
		$this->data["fetchers_list"] = $this->db->get_where('fetchers',['deleted'=>0])->result();
		$this->load->view("fetchers-list",$this->data);
	}

	public function gatelogs($arg='')
	{
		if($arg=="students"){
			$this->data["title"] = "Students Gate Logs";
			$this->load->view('gate-logs-students',$this->data);
		}elseif ($arg=="teachers") {
			
			$this->data["title"] = "Teachers Gate Logs";
			$this->load->view('gate-logs-teachers',$this->data);
		}elseif ($arg=="staffs") {
			$this->data["positions_list"] = $this->staffs_model->get_positions_list();
			$this->data["title"] = "Non-teaching Staffs Gate Logs";
			$this->load->view('gate-logs-staffs',$this->data);
		}elseif ($arg=="fetchers") {
			$this->data["fetchers_list"] = $this->db->get_where('fetchers',['deleted'=>0])->result();
			$this->data["title"] = "Fetchers Gate Logs";
			$this->load->view('gate-logs-fetchers',$this->data);
		}
	}

	public function login($arg='')
	{
		if($_POST){
			$this->data["account_password_error"] = "";

			$this->form_validation->set_error_delimiters('', '');
			$this->form_validation->set_rules('account', 'Account', 'required|min_length[5]|max_length[12]|is_valid[admins.username]|trim|htmlspecialchars');
			$this->form_validation->set_rules('account_password', 'Password', 'required|min_length[5]|max_length[12]|trim|htmlspecialchars');
			$this->form_validation->set_message('is_in_db', 'This account is invalid');

			if ($this->form_validation->run() == FALSE)
			{
				$data["is_valid"] = FALSE;
				$data["account_error"] = form_error('account');
				$data["account_password_error"] = form_error('account_password');
				$this->data["login_type"] = "admin";
				$this->data["account_password_error"] = form_error('account_password');
				$this->data["title"] = "Admin Login";
				$this->data["type"] = "ADMINISTRATOR LOGIN";
				$this->load->view('app-login',$this->data);
			}
			else
			{
				$data["username"] = $account_id = $this->input->post("account");
				$data["password"] = md5($account_password = $this->input->post("account_password"));
				// $data["var_dump"] = $this->admin_model->login($data);
				$data["deleted"] = 0;
				$data["is_valid"] = $this->admin_model->login($data);
				$data["account_error"] = "";
				
				if($data["is_valid"]){
					$data = array();
					$data["is_valid"] = TRUE;
					$data["account_password_error"] = "";
					$data["redirect"] = base_url("admin");
					redirect('admin');
				}else{
					$this->data["account_password_error"] = "Incorrect Passord. Try Again.";
					$data["redirect"] = "";
					$this->data["login_type"] = "admin";
					$this->data["title"] = "Admin Login";
					$this->data["type"] = "ADMINISTRATOR LOGIN";
					$this->load->view('app-login',$this->data);
					// echo json_encode($data);
				}
			}
		}else{
			redirect('admin');
		}
	}
	public function change_school_name()
	{
		
	}
	public function json($value='')
	{
		exit;
		echo '{"sms_list":[{"id":"33","sms_id":"44","message":"asdasd","mobile_number":"09301167850","recipient":"","ref_id":"1","ref_table":"teachers","status_code":"0","status":""},{"id":"34","sms_id":"44","message":"asdasd","mobile_number":"09301167851","recipient":"","ref_id":"1","ref_table":"students","status_code":"0","status":""},{"id":"35","sms_id":"44","message":"asdasd","mobile_number":"09301167852","recipient":"","ref_id":"2","ref_table":"students","status_code":"0","status":""}],"sms_id":"44"}';
	}

}
