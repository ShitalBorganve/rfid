<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Guardian_ajax extends CI_Controller {


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

	public function register($value='')
	{
		if($_POST){
			$this->form_validation->set_rules('guardian_address', 'Guardian Address', 'required|trim|htmlspecialchars|min_length[2]|max_length[50]');
			$this->form_validation->set_rules('email_address', 'Email Address', 'valid_email|trim|htmlspecialchars|min_length[2]|max_length[50]');
			$this->form_validation->set_rules('email_subscription', 'Email Address', 'email_subscription[email_address]');
			// $this->form_validation->set_rules('guardian_name', 'Guardian Name', 'required|custom_alpha_dash|trim|htmlspecialchars|min_length[2]|max_length[50]');
			$this->form_validation->set_rules('guardian_last_name', 'Guardian Last Name', 'required|trim|htmlspecialchars|max_length[50]');
			$this->form_validation->set_rules('guardian_middle_name', 'Guardian Middle Name', 'trim|htmlspecialchars|max_length[50]');
			$this->form_validation->set_rules('guardian_first_name', 'Guardian First Name', 'trim|htmlspecialchars|max_length[50]');
			$this->form_validation->set_rules('contact_number', 'Contact Number', 'numeric|required|is_available[guardians.contact_number]|trim|htmlspecialchars|min_length[11]|max_length[11]');
			$this->form_validation->set_message('is_available', 'This %s is invalid or already taken');

			if ($this->form_validation->run() == FALSE)
			{
				$data["is_valid"] = FALSE;
				$data["guardian_name_error"] = form_error("guardian_name");
				$data["guardian_last_name_error"] = form_error("guardian_last_name");
				$data["guardian_middle_name_error"] = form_error("guardian_middle_name");
				$data["guardian_first_name_error"] = form_error("guardian_first_name");
				$data["guardian_address_error"] = form_error("guardian_address");
				$data["email_address_error"] = form_error("email_address");
				$data["contact_number_error"] = form_error("contact_number");
				$data["subscription_error"] = form_error("email_subscription");
			}else{
				$data["is_valid"] = TRUE;
				$data["guardian_address_error"] = "";
				$data["guardian_name_error"] = "";
				$data["guardian_last_name_error"] = "";
				$data["guardian_middle_name_error"] = "";
				$data["guardian_first_name_error"] = "";
				$data["email_address_error"] = "";
				$data["contact_number_error"] = "";
				$data["subscription_error"] = "";

				($this->input->post("email_subscription")!=NULL?$email_subscription=1:$email_subscription=0);
				($this->input->post("sms_subscription")!=NULL?$sms_subscription=1:$sms_subscription=0);
				
				$guardian_data["name"] = $this->input->post("guardian_name");
				$guardian_data["middle_name"] = $this->input->post("guardian_middle_name");
				$guardian_data["first_name"] = $this->input->post("guardian_first_name");
				// $guardian_data["name"] = $guardian_data['last_name'] . " " .$guardian_data['first_name'] . " " .$guardian_data['middle_name'];
				$guardian_data["email_address"] = $this->input->post("email_address");
				$guardian_data["guardian_address"] = $this->input->post("guardian_address");
				$guardian_data["contact_number"] = $this->input->post("contact_number");
				$guardian_data["sms_subscription"] = $sms_subscription;
				$guardian_data["email_subscription"] = $email_subscription;
				$password = random_string('alnum', 8);


				$message = "Your account details as guardian are:
Login: ".$this->input->post("contact_number")."
Password: ".$password."
You can login to ".base_url();
				$app_config_data = $this->db->get("app_config")->row();
				$data["sms_code"] = send_sms($this->input->post("contact_number"),$message,$app_config_data->apicode);
				$data["sms_status"] = sms_status($data["sms_code"]);
				$data["contact_number"] = $guardian_data["contact_number"];


				$guardian_data["password"] = md5($password);
				$data["guardian_data"] = $this->guardian_model->add($guardian_data);
			}
			echo json_encode($data);
		}
	}


	public function edit($value='')
	{
		if($_POST){
			$this->form_validation->set_rules('guardian_address', 'Guardian Address', 'required|trim|htmlspecialchars|min_length[2]|max_length[50]');
			$this->form_validation->set_rules('guardian_name', 'Guardian Name', 'required|custom_alpha_dash|trim|htmlspecialchars|min_length[2]|max_length[50]');
			$this->form_validation->set_rules('guardian_last_name', 'Guardian Last Name', 'required|trim|htmlspecialchars|max_length[50]');
			$this->form_validation->set_rules('guardian_middle_name', 'Guardian Middle Name', 'trim|htmlspecialchars|max_length[50]');
			$this->form_validation->set_rules('guardian_first_name', 'Guardian First Name', 'trim|htmlspecialchars|max_length[50]');
			$this->form_validation->set_rules('email_subscription', 'Email Address', 'email_subscription[email_address]');
			$this->form_validation->set_rules('guardian_id', 'Guardian', 'trim|htmlspecialchars|is_in_db[guardians.id]');
			$this->form_validation->set_rules('email_address', 'Email Address', 'valid_email|trim|htmlspecialchars|min_length[2]|max_length[50]');
			$this->form_validation->set_message('is_available', 'This Email is invalid or already taken');
			$this->form_validation->set_rules('contact_number', 'Contact Number', 'numeric|required|is_unique_edit[guardians.contact_number.guardian_id]"trim|htmlspecialchars|min_length[11]|max_length[11]');

			if ($this->form_validation->run() == FALSE)
			{
				$data["is_valid"] = FALSE;
				$data["guardian_name_error"] = form_error("guardian_name");
				$data["guardian_last_name_error"] = form_error("guardian_last_name");
				$data["guardian_middle_name_error"] = form_error("guardian_middle_name");
				$data["guardian_first_name_error"] = form_error("guardian_first_name");
				$data["guardian_address_error"] = form_error("guardian_address");
				$data["email_address_error"] = form_error("email_address");
				$data["contact_number_error"] = form_error("contact_number");
				$data["subscription_error"] = form_error("email_subscription");
			}else{
				$data["is_valid"] = TRUE;
				$data["guardian_name_error"] = "";
				$data["guardian_last_name_error"] = "";
				$data["guardian_middle_name_error"] = "";
				$data["guardian_first_name_error"] = "";
				$data["guardian_address_error"] = "";
				$data["email_address_error"] = "";
				$data["contact_number_error"] = "";
				$data["subscription_error"] = "";

				($this->input->post("email_subscription")!=NULL?$email_subscription=1:$email_subscription=0);
				($this->input->post("sms_subscription")!=NULL?$sms_subscription=1:$sms_subscription=0);

				$guardian_id = $this->input->post("guardian_id");
				$guardian_data["name"] = $this->input->post("guardian_name");
				$guardian_data["last_name"] = $this->input->post("guardian_last_name");
				$guardian_data["middle_name"] = $this->input->post("guardian_middle_name");
				$guardian_data["first_name"] = $this->input->post("guardian_first_name");
				// $guardian_data["name"] = $guardian_data['last_name'] . " " .$guardian_data['first_name'] . " " .$guardian_data['middle_name'];
				$guardian_data["email_address"] = $this->input->post("email_address");
				$guardian_data["guardian_address"] = $this->input->post("guardian_address");
				$guardian_data["contact_number"] = $this->input->post("contact_number");
				$guardian_data["sms_subscription"] = $sms_subscription;
				$guardian_data["email_subscription"] = $email_subscription;

				$get_data = array();
				$get_data["id"] = $this->input->post("guardian_id");
				$guardian_data_db = $this->guardian_model->get_data($get_data);

				if($guardian_data_db["contact_number"]!=$this->input->post("contact_number")){
					$password = random_string('alnum', 8);
					$message = "Your account details as guardian are:
Login: ".$this->input->post("contact_number")."
Password: ".$password."
You can login to ".base_url();
					$app_config_data = $this->db->get("app_config")->row();
					$sms_code = send_sms($this->input->post("contact_number"),$message,$app_config_data->apicode);
					$guardian_data["password"] = md5($password);

					if($sms_code==0){
						$this->guardian_model->edit_info($guardian_data,$guardian_id);
						$data["password_reset"] = TRUE;
						$data["contact_number"] = $this->input->post("contact_number");
					}else{
						$data["password_reset"] = FALSE;
						$data["is_valid"] = FALSE;
						$data["contact_number_error"] = sms_status($sms_code);
					}
				}else{
					$this->guardian_model->edit_info($guardian_data,$guardian_id);
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
		$data = $this->guardian_model->get_list("",1,$this->db->get("guardians")->num_rows(),"id","DESC");
		echo json_encode($data["result"]);
	}

	public function reset_password($arg='')
	{
		$guardian_id = $this->input->post("id");
		$get_data["id"] = $guardian_id;
		$guardian_data = $this->guardian_model->get_data($get_data);

		$password = random_string('alnum', 8);
		$message = "Your account details as guardian are:
Login: ".$guardian_data["contact_number"]."
Password: ".$password."
You can login to ".base_url();
		$app_config_data = $this->db->get("app_config")->row();
		$sms_status_code = send_sms($guardian_data["contact_number"],$message,$app_config_data->apicode);
		$data["status_code"] = $sms_status_code;
		$data["contact_number"] = $guardian_data["contact_number"];
		if($sms_status_code=="0"){
			$update["password"] = md5($password);
			$data = $this->guardian_model->edit_info($update,$guardian_id);
			$data->is_successful = TRUE;
			echo json_encode($data);
		}else{
			$data["is_successful"] = FALSE;
			$data["error"] = sms_status($sms_status_code);
			echo json_encode($data);
		}
		
	}

	public function delete()
	{
		if($_POST){
			$data["deleted"] = 1;
			$this->guardian_model->edit_info($data,$this->input->post("id"));
			$get_data = array();
			$get_data["id"] = $this->input->post("id");
			echo json_encode($this->guardian_model->get_data($get_data));

			$this->db->where('guardian_id', $this->input->post("id"));
			$this->db->set("guardian_id","0");
			$this->db->update('students');
		}
	}

	public function email_settings($arg='')
	{
		if($_POST){
			$this->form_validation->set_rules('email_address', 'Email Address', 'required|valid_email|trim|htmlspecialchars|min_length[2]|max_length[50]');
			$this->form_validation->set_rules('id', 'Guardian', 'trim|htmlspecialchars|is_in_db[guardians.id]');

			if ($this->form_validation->run() == FALSE)
			{
				$data["is_valid"] = FALSE;
				$data["email_address_error"] = form_error("email_address");
			}else{
				$data["is_valid"] = TRUE;
				$update_data["email_address"] = $this->input->post("email_address");
				$update_data["email_subscription"] = ($this->input->post("email_subscription")?1:0);
				$this->guardian_model->edit_info($update_data,$this->input->post("id"));
			}
			echo json_encode($data);
		}
	}
}