<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Accounts extends CI_Controller {


	public function __construct()
	{
		parent::__construct();
		$this->load->helper('app_helper');
		$this->load->database(database());
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->library('session');

		$this->load->model("students_model");
		$this->load->model("rfid_model");
		$this->load->model("guardian_model");
		$this->load->model("teachers_model");
		$this->load->model("gate_logs_model");
		$this->load->model("staffs_model");
		$this->load->model("classes_model");
		$this->load->model("sms_model");

		$this->load->library('form_validation');
		$this->load->library('session');
		
		$this->form_validation->set_error_delimiters('', '');
		
	}

	public function change_password($value='')
	{
		$this->form_validation->set_rules('id', 'Owner', 'trim|htmlspecialchars');
		$this->form_validation->set_rules('type', 'Owner', 'trim|htmlspecialchars');
		$this->form_validation->set_rules('current_password', 'Current Password', 'required|is_valid_current_password[type.id]|trim|htmlspecialchars|min_length[2]|max_length[16]');
		$this->form_validation->set_rules('new_password', 'Contact Number', 'required|trim|htmlspecialchars|min_length[8]|max_length[16]');
		$this->form_validation->set_rules('confirm_password', 'Email Address', 'required|matches[new_password]|trim|htmlspecialchars|min_length[8]|max_length[16]');

		if ($this->form_validation->run() == FALSE)
		{
			$data["is_valid"] = FALSE;
			$data["confirm_password_error"] = form_error("confirm_password");
			$data["current_password_error"] = form_error("current_password");
			$data["new_password_error"] = form_error("new_password");
		}else{
			$data["is_valid"] = TRUE;
			$data["confirm_password_error"] = form_error("confirm_password");
			$data["current_password_error"] = form_error("current_password");
			$data["new_password_error"] = form_error("new_password");

			$this->db->where("id",$this->input->post("id"));
			$this->db->set("password",md5($this->input->post("new_password")));
			$this->db->update($this->input->post("type"));
		}
		echo json_encode($data);
	}
}