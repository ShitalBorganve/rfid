<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->library('session');

		$this->load->model("students_model");
		$this->load->model("rfid_model");
		$this->load->model("guardian_model");
		$this->load->model("gate_logs_model");
		
		$this->data["title"] = "Main Title";
		$this->data["css_scripts"] = $this->load->view("scripts/css","",true);
		$this->data["js_scripts"] = $this->load->view("scripts/js","",true);
		$this->data["meta_scripts"] = $this->load->view("scripts/meta","",true);
		
		$modal_data["guardians_list"] = $this->guardian_model->get_list();
		$modal_data["modals_sets"] = "admin";
		$this->data["modaljs_scripts"] = $this->load->view("layouts/modals",$modal_data,true);
		
		$navbar_data["navbar_type"] = "admin";
		($this->session->userdata("admin_sessions")?$navbar_data["navbar_is_logged_in"] = TRUE:$navbar_data["navbar_is_logged_in"] = FALSE);
		$this->data["navbar_scripts"] = $this->load->view("layouts/navbar",$navbar_data,true);
	}

	public function index($student_id='')
	{

		// var_dump($this->rfid_model->get_data('rfid="2222"',TRUE));
		// $date1 = strtotime(date("m/d/Y h:i:s A"));
		// var_dump($date1);
		// echo "<br>";
		// $date2 = date("m/d/Y h:i:s A",$date1);
		// var_dump($date1);
		
		// exit;
		$this->data["login_type"] = "admin";
		if($this->session->userdata("admin_sessions")){
			// var_dump($this->gate_logs_model->get_list());exit;
			// $this->data["students_log_data"] = $this->gate_logs_model->get_list();
			$where["type"] = "entry";
			$gate_log_data = $this->gate_logs_model->get_list();

			// var_dump($gate_log_data);



			$this->load->view('gate-logs',$this->data);
		}else{
			$this->load->view('app-login',$this->data);
		}
	}
	public function login($value='')
	{
		# code...
	}
	public function logout($value='')
	{
		$this->session->unset_userdata('admin_sessions');
	}

	public function students($value='')
	{
		$this->load->model("students_model");
		$this->data["students_list"] = $this->students_model->get_list();
		$this->load->view("students-list",$this->data);
	}

	public function teachers($value='')
	{
		$this->load->model("teachers_model");
		$this->data["teachers_list"] = $this->teachers_model->get_list();
		$this->load->view("teachers-list",$this->data);
	}
}
