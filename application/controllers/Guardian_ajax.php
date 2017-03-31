<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Guardian_ajax extends CI_Controller {

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
		$this->load->helper('app_helper');


		//models
		$this->load->helper('string');
		$this->load->model('guardian_model');
		$this->load->model("admin_model");
		$this->load->model("students_model");
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
	/* admin ajax*/
	public function register($value='')
	{
		if($_POST){
			$this->form_validation->set_rules('email_address', 'Email Address', 'required|valid_email|trim|htmlspecialchars|is_available[guardians.email_address]|min_length[2]|max_length[50]');
			$this->form_validation->set_rules('guardian_name', 'Guardian Name', 'required|custom_alpha_dash|trim|htmlspecialchars|min_length[2]|max_length[50]');
			$this->form_validation->set_rules('contact_number', 'Contact Number', 'trim|htmlspecialchars|min_length[11]|max_length[11]');
			$this->form_validation->set_message('is_available', 'This Email is invalid or already taken');

			if ($this->form_validation->run() == FALSE)
			{
				$data["is_valid"] = FALSE;
				$data["guardian_name_error"] = form_error("guardian_name");
				$data["email_address_error"] = form_error("email_address");
				$data["contact_number_error"] = form_error("contact_number");
			}else{
				$data["is_valid"] = TRUE;
				$data["guardian_name_error"] = "";
				$data["email_address_error"] = "";
				$data["contact_number_error"] = "";

				($this->input->post("email_subscription")!=NULL?$email_subscription=1:$email_subscription=0);
				($this->input->post("sms_subscription")!=NULL?$sms_subscription=1:$sms_subscription=0);

				$guardian_data["name"] = $this->input->post("guardian_name");
				$guardian_data["email_address"] = $this->input->post("email_address");
				$guardian_data["contact_number"] = $this->input->post("contact_number");
				$guardian_data["sms_subscription"] = $sms_subscription;
				$guardian_data["email_subscription"] = $email_subscription;
				$guardian_data["password"] = random_string('alnum', 8);




				$this->load->library('email');

				$this->email->from('info@qfcdavao.com', 'Your Name');
				$this->email->to($this->input->post("email_address"));

				$this->email->subject('Email Test');
				$this->email->message('
					Testing the email class.
					Email: '.$this->input->post("email_address").'<br>
					Password: '.$guardian_data["password"].'
					');

				$this->email->send();


				$guardian_data["password"] = md5($guardian_data["password"]);
				$this->guardian_model->add($guardian_data);
			}
			echo json_encode($data);
		}
	}


	public function edit($value='')
	{
		if($_POST){
			$this->form_validation->set_rules('guardian_name', 'Guardian Name', 'required|custom_alpha_dash|trim|htmlspecialchars|min_length[2]|max_length[50]');
			$this->form_validation->set_rules('contact_number', 'Contact Number', 'trim|htmlspecialchars|min_length[11]|max_length[11]');
			$this->form_validation->set_rules('guardian_id', 'Guardian', 'required|trim|htmlspecialchars|is_in_db[guardians.id]');
			$this->form_validation->set_rules('email_address', 'Email Address', 'required|is_unique_edit[guardians.email_address.guardian_id]|valid_email|trim|htmlspecialchars|min_length[2]|max_length[50]');
			$this->form_validation->set_message('is_available', 'This Email is invalid or already taken');

			if ($this->form_validation->run() == FALSE)
			{
				$data["is_valid"] = FALSE;
				$data["guardian_name_error"] = form_error("guardian_name");
				$data["email_address_error"] = form_error("email_address");
				$data["contact_number_error"] = form_error("contact_number");
			}else{
				$data["is_valid"] = TRUE;
				$data["guardian_name_error"] = "";
				$data["email_address_error"] = "";
				$data["contact_number_error"] = "";

				($this->input->post("email_subscription")!=NULL?$email_subscription=1:$email_subscription=0);
				($this->input->post("sms_subscription")!=NULL?$sms_subscription=1:$sms_subscription=0);

				$guardian_id = $this->input->post("guardian_id");
				$guardian_data["name"] = $this->input->post("guardian_name");
				$guardian_data["email_address"] = $this->input->post("email_address");
				$guardian_data["contact_number"] = $this->input->post("contact_number");
				$guardian_data["sms_subscription"] = $sms_subscription;
				$guardian_data["email_subscription"] = $email_subscription;
				$this->guardian_model->edit_info($guardian_data,$guardian_id);
			}
			echo json_encode($data);
		}
	}

	public function applogin($value='')
	{
		if($_POST){
			$this->form_validation->set_rules('account', 'Account', 'required|min_length[5]|max_length[50]|is_in_db[guardians.email_address]|trim|htmlspecialchars');
			$this->form_validation->set_rules('account_password', 'Password', 'required|min_length[5]|max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_message('is_in_db', 'This account is invalid');

			if ($this->form_validation->run() == FALSE)
			{
				$data["is_valid"] = FALSE;
				$data["account_error"] = form_error('account');
				$data["account_password_error"] = form_error('account_password');
			}
			else
			{
				$login_data["email_address"] = $account_id = $this->input->post("account");
				$login_data["password"] = $account_password = $this->input->post("account_password");
				$login_data["deleted"] = 0;
				$login_data["password"] = md5($login_data["password"]);

				$data["is_valid"] = $this->guardian_model->login($login_data);
				$data["account_error"] = "";
				
				if($data["is_valid"]){
					$data["account_password_error"] = "";
					$data["redirect"] = base_url("home");
				}else{
					$data["account_password_error"] = "Incorrect Passord. Try Again.";
					$data["redirect"] = "";
				}
			}

			echo json_encode($data);
		}
	}

	public function get_data($value='')
	{
		$guardian_data["id"] = $this->input->get("guardian_id");
		$guardian_data = $this->guardian_model->get_data($guardian_data);
		($guardian_data["id"]==0?$guardian_data["id"]="":FALSE);
		echo json_encode($guardian_data);
	}

	public function get_list($arg='')
	{
		$data = $this->guardian_model->get_list();
		echo json_encode($data["result"]);
	}
}