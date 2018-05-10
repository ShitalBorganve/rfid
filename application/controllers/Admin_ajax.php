<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_ajax extends CI_Controller {


	public function __construct()
	{
		parent::__construct();
		$this->load->helper('app_helper');
		$this->load->database(database());
		
		$this->load->helper('form');
		$this->load->helper('url');


		//models
		$this->load->helper('string');
		$this->load->model('guardian_model');
		$this->load->model("admin_model");
		$this->load->model("students_model");
		$this->load->model("classes_model");
		$this->load->model("gate_logs_model");
		$this->load->model("canteen_model");
		$this->load->model("canteen_items_model");

		$this->load->library('form_validation');
		$this->load->library('session');
		
		$this->form_validation->set_error_delimiters('', '');
	}

	public function index()
	{
		show_404();
	}

	public function gate_change_password($arg='')
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

	public function reset_password($arg='')
	{
		$this->form_validation->set_rules('email_address', 'Email Address', 'required|valid_email|trim|htmlspecialchars|min_length[2]|max_length[50]');
		if ($this->form_validation->run() == FALSE){
			$data["is_valid"] = FALSE;
			$data["email_address_error"] = form_error("email_address");
		}else{

			$this->db->where('id', $this->input->post("id"));
			$admin_data = $this->db->get("admins")->row();
			$this->load->library('email');

			$this->email->from('no-reply@rfid-ph.net', 'Admin Password Reset');
			$this->email->to($this->input->post("email_address"));

			$this->email->subject('Admin Password Reset');
			$password = random_string('alnum', 8);
			$message = "Your account details an admin are:
Login: ".$admin_data->username."
Password: ".$password."
You can login to ".base_url("admin");
			$this->email->message($message);

			$this->db->set('password', md5($password));
			$this->db->where('id', $this->input->post("id"));
			$this->db->update('admins');

			$this->email->send();

			$data["is_valid"] = TRUE;
			$data["email_address"] = $this->input->post("email_address");
			$data["email_address_error"] = form_error("email_address");
		}
		echo json_encode($data);
	}

	public function add_account($arg='')
	{
		$this->form_validation->set_rules('email_address', 'Email Address', 'required|valid_email|trim|htmlspecialchars|min_length[2]|max_length[50]');
		$this->form_validation->set_rules('username', 'Username', 'is_available[admins.username]|required|trim|htmlspecialchars|min_length[2]|max_length[50]');
		if ($this->form_validation->run() == FALSE){
			$data["is_valid"] = FALSE;
			$data["email_address_error"] = form_error("email_address");
			$data["username_error"] = form_error("username");
		}else{
			$data["is_valid"] = TRUE;
			$data["email_address_error"] = form_error("email_address");
			$data["username_error"] = form_error("username");
			$data["email_address"] = $this->input->post("email_address");


			$this->load->library('email');

			$this->email->from('no-reply@rfid-ph.net', 'Admin Account');
			$this->email->to($this->input->post("email_address"));

			$this->email->subject('Admin Account');
			$password = random_string('alnum', 8);
			$message = "Your account details an admin are:
Login: ".$this->input->post("username")."
Password: ".$password."
You can login to ".base_url("admin");
			$this->email->message($message);

			$this->email->send();

			$insert_data["username"] = $this->input->post("username");
			$insert_data["password"] = md5($password);
			$this->db->insert("admins",$insert_data);
		}
		echo json_encode($data);
	}

	public function get_list($arg='')
	{
		echo json_encode($this->admin_model->get_list());
	}
}