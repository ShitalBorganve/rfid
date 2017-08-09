<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sms_ajax extends CI_Controller {


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
		$this->load->model('staffs_model');
		$this->load->model("admin_model");
		$this->load->model("students_model");
		$this->load->model("teachers_model");
		$this->load->model("sms_model");
		$this->load->model("gate_logs_model");
		$this->load->model("canteen_model");
		$this->load->model("canteen_items_model");

		$this->load->library('form_validation');
		$this->load->library('session');
		
		$this->form_validation->set_error_delimiters('', '');
	}

	public function send()
	{
		if($_POST){
			$type_recipient = $this->input->post("type_recipient");
			$message = $this->input->post("message");
			$sender = $this->input->post("sender");
			$classes = ($this->input->post("class_id")?$this->input->post("class_id"):NULL);

			$this->form_validation->set_rules('type_recipient', 'Recipient', 'required');
			$this->form_validation->set_rules('message', 'Message', 'required|max_length[480]|trim|htmlspecialchars');
			if($type_recipient=="all_teachers"||$type_recipient=="all_teachers_students"||$type_recipient=="all_students"||$type_recipient=="all_members"||$type_recipient=="all_guardians"||$type_recipient=="staffs"){
				
				$is_valid_class = TRUE;
			}else{
				if($classes===NULL){
					$is_valid_class = FALSE;
				}else{
					$is_valid_class = TRUE;
				}
			}

			if ($this->form_validation->run() == FALSE || $is_valid_class == FALSE)
			{
				$data["is_valid"] = FALSE;
				$data["type_recipient_error"] = form_error('type_recipient');
				$data["message_error"] = form_error('message');
				$data["class_id_error"] = ($is_valid_class?"":"The Class field is required.");
			}
			else
			{
				$data["is_valid"] = TRUE;
				$data["type_recipient_error"] = form_error('type_recipient');
				$data["message_error"] = form_error('message');
				$data["class_id_error"] = ($is_valid_class?"":"The Class field is required.");


				$valid_recipient = FALSE;
				$data["recipients_number"] = array();
				$data["recipients_id"] = array();
				$data["recipients_table"] = array();
				switch ($type_recipient) {
					case 'teachers_students':
						foreach ($classes as $class) {
							$get_list["class_id"] = $class;
							$get_list["deleted"] = 0;
							$students_list = $this->students_model->get_list($get_list,1,$this->db->get("students")->num_rows());

							if($students_list["result"] != array()){
								foreach ($students_list["result"] as $students_data) {
									if($students_data->contact_number!=""){
										$valid_recipient = TRUE;
										$data["recipients_number"][] = $students_data->contact_number;
										$data["recipients_table"][] = "students";
									}
								}
							}


							$get_list["class_id"] = $class;
							$get_list["deleted"] = 0;
							$teachers_list = $this->teachers_model->get_list($get_list,1,$this->db->get("teachers")->num_rows());

							if($teachers_list["result"] != array()){
								foreach ($teachers_list["result"] as $teachers_data) {
									if($teachers_data->contact_number!=""){
										$valid_recipient = TRUE;
										$data["recipients_number"][] = $teachers_data->contact_number;
										$data["recipients_table"][] = "teachers";
									}
								}
							}

						}
						$data["recipients_number"] = array_unique($data["recipients_number"]);
						sort($data["recipients_number"]);
						$data["recipients_table"] = array_unique($data["recipients_table"]);
						sort($data["recipients_table"]);
						break;
					case 'teachers':
						foreach ($classes as $class) {
							$get_list["class_id"] = $class;
							$get_list["deleted"] = 0;
							$teachers_list = $this->teachers_model->get_list($get_list,1,$this->db->get("teachers")->num_rows());
							if($teachers_list["result"] != array()){
								foreach ($teachers_list["result"] as $teachers_data) {
									if($teachers_data->contact_number!=""){
										$valid_recipient = TRUE;
										$data["recipients_number"][] = $teachers_data->contact_number;
										$data["recipients_table"][] = "teachers";
									}
								}
							}
						}
						$data["recipients_number"] = array_unique($data["recipients_number"]);
						sort($data["recipients_number"]);
						$data["recipients_table"] = array_unique($data["recipients_table"]);
						sort($data["recipients_table"]);
						break;
					case 'students':
						foreach ($classes as $class) {
							$get_list["class_id"] = $class;
							$get_list["deleted"] = 0;
							$students_list = $this->students_model->get_list($get_list,1,$this->db->get("students")->num_rows());
							if($students_list["result"] != array()){
								foreach ($students_list["result"] as $students_data) {
									if($students_data->contact_number!=""){
										$valid_recipient = TRUE;
										$data["recipients_number"][] = $students_data->contact_number;
										$data["recipients_table"][] = "students";
									}
								}
							}
						}
						$data["recipients_number"] = array_unique($data["recipients_number"]);
						sort($data["recipients_number"]);
						$data["recipients_table"] = array_unique($data["recipients_table"]);
						sort($data["recipients_table"]);
						break;
					case 'guardian':
						foreach ($classes as $class) {
							$get_list["class_id"] = $class;
							$get_list["deleted"] = 0;
							$students_list = $this->students_model->get_list($get_list,1,$this->db->get("students")->num_rows());
							if($students_list["result"] != array()){
								foreach ($students_list["result"] as $students_data) {
									$get_data["id"] = $students_data->guardian_id;
									if($students_data->guardian_id != 0){
										$guardian_data = $this->guardian_model->get_data($get_data,TRUE);
										if($guardian_data->contact_number!=""){
											$valid_recipient = TRUE;
											$data["recipients_number"][] = $guardian_data->contact_number;
											$data["recipients_table"][] = "guardians";
										}
									}
								}
							}
						}
						$data["recipients_number"] = array_unique($data["recipients_number"]);
						sort($data["recipients_number"]);
						$data["recipients_table"] = array_unique($data["recipients_table"]);
						sort($data["recipients_table"]);
						break;
					case 'members':
						foreach ($classes as $class) {
							$get_list["class_id"] = $class;
							$get_list["deleted"] = 0;
							$students_list = $this->students_model->get_list($get_list,1,$this->db->get("students")->num_rows());

							if($students_list["result"] != array()){
								foreach ($students_list["result"] as $students_data) {
									if($students_data->contact_number!=""){
										$valid_recipient = TRUE;
										$data["recipients_number"][] = $students_data->contact_number;
										$data["recipients_table"][] = "students";
									}
								}
							}

							$get_list["class_id"] = $class;
							$get_list["deleted"] = 0;
							$teachers_list = $this->teachers_model->get_list($get_list,1,$this->db->get("teachers")->num_rows());
							if($teachers_list["result"] != array()){
								foreach ($teachers_list["result"] as $teachers_data) {
									if($teachers_data->contact_number!=""){
										$valid_recipient = TRUE;
										$data["recipients_number"][] = $teachers_data->contact_number;
										$data["recipients_table"][] = "teachers";
									}
								}
							}

							$get_list["class_id"] = $class;
							$get_list["deleted"] = 0;
							$students_list = $this->students_model->get_list($get_list,1,$this->db->get("students")->num_rows());
							if($students_list["result"] != array()){
								foreach ($students_list["result"] as $students_data) {
									$get_data["id"] = $students_data->guardian_id;
									if($students_data->guardian_id != 0){
										$guardian_data = $this->guardian_model->get_data($get_data,TRUE);
										if($guardian_data->contact_number!=""){
											$valid_recipient = TRUE;
											$data["recipients_number"][] = $guardian_data->contact_number;
											$data["recipients_table"][] = "guardians";
										}
									}
								}
							}
						}
						$data["recipients_number"] = array_unique($data["recipients_number"]);
						sort($data["recipients_number"]);
						$data["recipients_table"] = array_unique($data["recipients_table"]);
						sort($data["recipients_table"]);
						break;
					case 'staffs':
						$staffs_list = $this->staffs_model->get_list("",1,$this->db->get("staffs")->num_rows());
						if($staffs_list["result"] != array()){
							foreach ($staffs_list["result"] as $staffs_data) {
								if($staffs_data->contact_number!=""){
									$valid_recipient = TRUE;
									$data["recipients_number"][] = $staffs_data->contact_number;
									$data["recipients_table"][] = "staffs";
								}
							}
						}
						$data["recipients_number"] = array_unique($data["recipients_number"]);
						sort($data["recipients_number"]);
						$data["recipients_table"] = array_unique($data["recipients_table"]);
						sort($data["recipients_table"]);
						break;
					case 'all_teachers_students':
						$students_list = $this->students_model->get_list("",1,$this->db->get("students")->num_rows());
						if($students_list["result"] != array()){
							foreach ($students_list["result"] as $students_data) {
								if($students_data->contact_number!=""){
									$valid_recipient = TRUE;
									$data["recipients_number"][] = $students_data->contact_number;
									$data["recipients_table"][] = "students";
								}
							}
						}
						$teachers_list = $this->teachers_model->get_list("",1,$this->db->get("teachers")->num_rows());
						if($teachers_list["result"] != array()){
							foreach ($teachers_list["result"] as $teachers_data) {
								if($teachers_data->contact_number!=""){
									$valid_recipient = TRUE;
									$data["recipients_number"][] = $teachers_data->contact_number;
									$data["recipients_table"][] = "teachers";
								}
							}
						}
						$data["recipients_number"] = array_unique($data["recipients_number"]);
						sort($data["recipients_number"]);
						$data["recipients_table"] = array_unique($data["recipients_table"]);
						sort($data["recipients_table"]);
						break;
					case 'all_teachers':
						$teachers_list = $this->teachers_model->get_list("",1,$this->db->get("teachers")->num_rows());
						if($teachers_list["result"] != array()){
							foreach ($teachers_list["result"] as $teachers_data) {
								if($teachers_data->contact_number!=""){
									$valid_recipient = TRUE;
									$data["recipients_number"][] = $teachers_data->contact_number;
									$data["recipients_table"][] = "teachers";
								}
							}
						}
						$data["recipients_number"] = array_unique($data["recipients_number"]);
						sort($data["recipients_number"]);
						$data["recipients_table"] = array_unique($data["recipients_table"]);
						sort($data["recipients_table"]);
						break;
					case 'all_students':
						$students_list = $this->students_model->get_list("",1,$this->db->get("students")->num_rows());
						if($students_list["result"] != array()){
							foreach ($students_list["result"] as $students_data) {
								if($students_data->contact_number!=""){
									$valid_recipient = TRUE;
									$data["recipients_number"][] = $students_data->contact_number;
									$data["recipients_table"][] = "students";
								}
							}
						}
						$data["recipients_number"] = array_unique($data["recipients_number"]);
						sort($data["recipients_number"]);
						$data["recipients_table"] = array_unique($data["recipients_table"]);
						sort($data["recipients_table"]);
						break;
					case 'all_guardians':
						$students_list = $this->students_model->get_list("",1,$this->db->get("students")->num_rows());
						if($students_list["result"] != array()){
							foreach ($students_list["result"] as $students_data) {
								$get_data["id"] = $students_data->guardian_id;
								if($students_data->guardian_id != 0){
									$guardian_data = $this->guardian_model->get_data($get_data,TRUE);
									if($guardian_data->contact_number!=""){
										$valid_recipient = TRUE;
										$data["recipients_number"][] = $guardian_data->contact_number;
										$data["recipients_table"][] = "guardians";
									}
								}
							}
						}
						$data["recipients_number"] = array_unique($data["recipients_number"]);
						sort($data["recipients_number"]);
						$data["recipients_table"] = array_unique($data["recipients_table"]);
						sort($data["recipients_table"]);
						break;
					case 'all_members':
						$students_list = $this->students_model->get_list("",1,$this->db->get("students")->num_rows());
						if($students_list["result"] != array()){
							foreach ($students_list["result"] as $students_data) {
								if($students_data->contact_number!=""){
									$valid_recipient = TRUE;
									$data["recipients_number"][] = $students_data->contact_number;
									$data["recipients_table"][] = "students";
								}
							}
						}

						$teachers_list = $this->teachers_model->get_list("",1,$this->db->get("teachers")->num_rows());
						if($teachers_list["result"] != array()){
							foreach ($teachers_list["result"] as $teachers_data) {
								if($teachers_data->contact_number!=""){
									$valid_recipient = TRUE;
									$data["recipients_number"][] = $teachers_data->contact_number;
									$data["recipients_table"][] = "teachers";
								}
							}
						}

						$students_list = $this->students_model->get_list("",1,$this->db->get("students")->num_rows());
						if($students_list["result"] != array()){
							foreach ($students_list["result"] as $students_data) {
								$get_data["id"] = $students_data->guardian_id;
								if($students_data->guardian_id != 0){
									$guardian_data = $this->guardian_model->get_data($get_data,TRUE);
									if($guardian_data->contact_number!=""){
										$valid_recipient = TRUE;
										$data["recipients_number"][] = $guardian_data->contact_number;
										$data["recipients_table"][] = "guardians";
									}
								}
								
							}
						}

						$staffs_list = $this->staffs_model->get_list("",1,$this->db->get("staffs")->num_rows());
						if($staffs_list["result"] != array()){
							foreach ($staffs_list["result"] as $staffs_data) {
								if($staffs_data->contact_number!=""){
									$valid_recipient = TRUE;
									$data["recipients_number"][] = $staffs_data->contact_number;
									$data["recipients_table"][] = "staffs";
								}
							}
						}
						$data["recipients_number"] = array_unique($data["recipients_number"]);
						sort($data["recipients_number"]);
						$data["recipients_table"] = array_unique($data["recipients_table"]);
						sort($data["recipients_table"]);
						break;
					default:
						$data["is_valid"] = FALSE;
						break;
				}

				if($valid_recipient){
					if($sender=="admin"){
						$sms_sender = $this->session->userdata("admin_sessions");
						$sms_sender->sender = "admins";
						$sms_db_data = $this->sms_model->add($sms_sender);
					}else{
						$sms_sender = $this->session->userdata("teacher_sessions");
						$sms_sender->sender = "teachers";
						$sms_db_data = $this->sms_model->add($sms_sender);
					}
					$data["sms_id"] = $sms_db_data->id;
				}else{
					$data["is_valid"] = FALSE;
					$data["message_error"] = "No valid Recipient.";
				}
			}
			echo json_encode($data);			
		}
	}

	public function send_api($value='')
	{
		// sleep(2);
		// exit;
		// var_dump($this->input->get("sms_id"));
		$sms_id = $this->input->post("sms_id");
		$data["message"] = $this->input->post("message");
		$data["mobile_number"] = $this->input->post("recipients_number");
	
		$app_config_data = $this->db->get("app_config")->row();
		$data["status_code"] = send_sms($data["mobile_number"],$data["message"],$app_config_data->apicode);
		$data["status"] = sms_status($data["status_code"]);
		$owner_data = $this->sms_model->find_owner($data["mobile_number"]);
		$data["ref_table"] = $owner_data->table;
		$data["ref_id"] = $owner_data->id;
		$get_data["id"] = $owner_data->id;
		if($owner_data->table=="students"){
			$students_data = $this->students_model->get_data($get_data,TRUE);
			$students_data->middle_initial = ($students_data->middle_name==""?"":$students_data->middle_name[0].". ");
			$data["recipient"] = $students_data->last_name.", ".$students_data->first_name." ".$students_data->middle_initial.$students_data->suffix;
		}elseif ($owner_data->table=="teachers") {
			if($owner_data->table=="teachers"){
				$teachers_data = $this->teachers_model->get_data($get_data,TRUE);
				$teachers_data->middle_initial = ($teachers_data->middle_name==""?"":$teachers_data->middle_name[0].". ");
				$data["recipient"] = $teachers_data->last_name.", ".$teachers_data->first_name." ".$teachers_data->middle_initial.$teachers_data->suffix;
			}
		}elseif ($owner_data->table=="staffs") {
			if($owner_data->table=="staffs"){
				$staffs_data = $this->staffs_model->get_data($get_data,TRUE);
				$staffs_data->middle_initial = ($staffs_data->middle_name==""?"":$staffs_data->middle_name[0].". ");
				$data["recipient"] = $staffs_data->last_name.", ".$staffs_data->first_name." ".$staffs_data->middle_initial.$staffs_data->suffix;
			}
		}elseif ($owner_data->table=="guardians") {
			if($owner_data->table=="guardians"){
				$guardians_data = $this->guardian_model->get_data($get_data,TRUE);
				$data["recipient"] = $guardians_data->name;
			}
		}else{
			$data["recipient"] = "";
		}

		$this->sms_model->send($data,$sms_id);
		$data = array();
		$get_data = array();
		$get_data["sms_id"] = $sms_id;
		$data["sms_list"] = $this->sms_model->get_sms_list($get_data);
		$data["sms_id"] = $sms_id;
		echo json_encode($data);
		// echo $this->input->post("recipients_number")." ".$this->input->post("recipients_id")." ".$owner_data->table." ".$this->input->post("sms_id");
	}

	public function get_data($arg='')
	{
		$sms_id = $this->input->get("sms_id");
		$get_data["sms_id"] = $sms_id;
		echo json_encode($this->sms_model->get_sms_list($get_data));
	}

	public function resend($value='')
	{
		$sms_id = $this->input->post("id");
		$get_data["sms_id"] = $sms_id;
		$sms_list = $this->sms_model->get_sms_list($get_data);
		$data["is_success"] = TRUE;
		foreach ($sms_list as $sms_data) {
			$app_config_data = $this->db->get("app_config")->row();
			$resend_data["status_code"] = send_sms($sms_data["mobile_number"],$sms_data["message"],$app_config_data->apicode);
			$resend_data["status"] = sms_status($resend_data["status_code"]);
			$this->sms_model->resend($resend_data,$sms_data["id"]);

			if($resend_data["status"]!=0){
				$data["is_success"] = FALSE;
			}
		}
		echo json_encode($data);
	}

	public function get_api_data($value='')
	{
		$curl = curl_init();
		$app_config_data = $this->db->get("app_config")->row();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://www.itexmo.com/php_api/apicode_info.php?apicode=".$app_config_data->apicode,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_SSL_VERIFYPEER => FALSE,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "GET",
		  CURLOPT_HTTPHEADER => array(
		    "cache-control: no-cache"
		  ),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);
		$response = json_decode($response,true);
		$data["MessagesLeft"] = $response["Result "]["MessagesLeft"];
		$data["ExpiresOn"] = $response["Result "]["ExpiresOn"];
		echo json_encode($data);
		// var_dump($response);
		curl_close($curl);
	}
}
