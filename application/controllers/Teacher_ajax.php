<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Teacher_ajax extends CI_Controller {

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
		$this->load->model("teachers_model");
		$this->load->model("teachers_model");
		$this->load->model("gate_logs_model");
		$this->load->model("rfid_model");
		$this->load->model("canteen_model");
		$this->load->model("classes_model");
		$this->load->model("canteen_items_model");
		$this->load->model("rfid_photo_model");

		$this->load->library('form_validation');
		$this->load->library('session');
		
		$this->form_validation->set_error_delimiters('', '');
	}

	public function index()
	{
		show_404();
	}
	public function add($arg='')
	{
		if($_POST){
			$this->form_validation->set_rules('blood_type', 'Blood Type', 'max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('sss', 'SSS', 'max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('philhealth', 'PhilHealth', 'max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('pagibig', 'Pag-IBIG', 'max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('tin', 'TIN', 'max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('in_case_address', 'Person Address', 'max_length[200]|trim|htmlspecialchars');
			$this->form_validation->set_rules('gender', 'Gender', 'max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('dept_head', 'Department Head', 'max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('dept_head_number', 'Department Head Contact Number', 'numeric|max_length[11]|min_length[11]|trim|htmlspecialchars');
			$this->form_validation->set_rules('address', 'Address', 'required|min_length[2]|max_length[100]|trim|htmlspecialchars');
			$this->form_validation->set_rules('first_name', 'First Name', 'required|is_unique_name[teachers.first_name.middle_name.last_name.NULL]|custom_alpha_dash|min_length[2]|max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('last_name', 'Last Name', 'required|custom_alpha_dash|min_length[2]|max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('middle_name', 'Middle Name', 'custom_alpha_dash|min_length[2]|max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('suffix', 'Suffix', 'custom_alpha_dash|min_length[2]|max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('bday_m', 'Birth Date', 'required|is_valid_date[bday_m.bday_d.bday_y]|trim|htmlspecialchars');
			$this->form_validation->set_rules('bday_d', 'Birth Date', 'required|is_valid_date[bday_m.bday_d.bday_y]|trim|htmlspecialchars');
			$this->form_validation->set_rules('bday_y', 'Birth Date', 'required|is_valid_date[bday_m.bday_d.bday_y]|trim|htmlspecialchars');
			$this->form_validation->set_rules('class_id', 'Class', 'trim|htmlspecialchars');
			$this->form_validation->set_rules('in_case_name', 'Name', 'custom_alpha_dash|min_length[2]|max_length[50]|trim|htmlspecialchars');
			
			$this->form_validation->set_rules('contact_number', 'Contact Number', 'required|is_available[teachers.contact_number]|numeric|min_length[11]|max_length[11]|trim|htmlspecialchars');
			$this->form_validation->set_message('is_in_db', 'This account is invalid');
			if($this->input->post("in_case_contact_number_sms")){
				$this->form_validation->set_rules('in_case_contact_number', 'In Case of Emergency Contact Number', 'required|numeric|min_length[11]|max_length[11]|trim|htmlspecialchars');
				$in_case_contact_number_sms = 1;
			}else{
				$this->form_validation->set_rules('in_case_contact_number', 'In Case of Emergency Contact Number', 'numeric|min_length[11]|max_length[11]|trim|htmlspecialchars');
				$in_case_contact_number_sms = 0;
			}

			$has_uploaded_pic = FALSE;

			//uploads files
			if($_FILES['teacher_photo']["error"]==0){

				$filename_first_name_array = explode(" ", $this->input->post("first_name"));
				$filename_first_name = implode("-", $filename_first_name_array);

				$filename_middle_name_array = explode(" ", $this->input->post("middle_name"));
				$filename_middle_name = implode("-", $filename_middle_name_array);

				$filename_last_name_array = explode(" ", $this->input->post("last_name"));
				$filename_last_name = implode("-", $filename_last_name_array);

				$filename_suffix_array = explode(" ", $this->input->post("suffix"));
				$filename_suffix = implode("-", $filename_suffix_array);

				$filename_full_name = $filename_last_name."_".$filename_first_name."_".$filename_middle_name."_".$filename_suffix;

				$filename = $filename_full_name."_".$this->rfid_photo_model->add();



				$config['overwrite'] = TRUE;
				$config['upload_path'] = './assets/images/teacher_photo/';
				$config['allowed_types'] = '*';
				$config['file_name'] = $filename;
				$config['max_size']	= '20480';
				$this->load->library('upload', $config);
				if ( ! $this->upload->do_upload("teacher_photo"))
				{
					$data["is_valid_photo"] = FALSE;
					$data["photo_error"] = $this->upload->display_errors("","");
				}
				else
				{
					$image_data = $this->upload->data();
					$data["photo_error"] = "";
					$data["is_valid_photo"] = TRUE;
					if($image_data["is_image"]=="0"){
						$data["is_valid_photo"] = FALSE;
						$data["photo_error"] = "The file you are attempting to upload is not an image.";
					}else{
						$filename = $filename.$image_data["file_ext"];
						$image_data = $this->upload->data();
						$config['image_library'] = 'gd2';
						$config['source_image'] = $image_data["full_path"];
						$full_path = $image_data["full_path"];
						$file_path = $image_data["file_path"];
						$file_name = $image_data["file_name"];
						$config['create_thumb'] = FALSE;
						$config['new_image'] = $filename;
						$config['maintain_ratio'] = TRUE;
						$config['width']     = 360;
						$config['height']   = 360;
						$this->load->library('image_lib', $config); 
						$this->image_lib->resize();
						$this->image_lib->clear();

						$has_uploaded_pic = TRUE;
					}
				}
			}else{
				$data["is_valid_photo"] = TRUE;
				$filename = "empty.jpg";				
			}

			if ($this->form_validation->run() == FALSE|| $data["is_valid_photo"] == FALSE)
			{
				$data["is_valid"] = FALSE;
				$data["gender_error"] = form_error('gender');
				$data["dept_head_error"] = form_error('dept_head');
				$data["dept_head_number_error"] = form_error('dept_head_number');
				$data["in_case_contact_number_error"] = form_error('in_case_contact_number');
				$data["in_case_name_error"] = form_error('in_case_name');
				$data["first_name_error"] = form_error('first_name');
				$data["last_name_error"] = form_error('last_name');
				$data["address_error"] = form_error('address');
				$data["middle_name_error"] = form_error('middle_name');
				$data["suffix_error"] = form_error('suffix');
				$data["contact_number_error"] = form_error('contact_number');
				$data["class_id_error"] = form_error('class_id');
				$data["bday_error"] = form_error('bday_m');
				$data["blood_type_error"] = form_error('blood_type');
				$data["sss_error"] = form_error('sss');
				$data["philhealth_error"] = form_error('philhealth');
				$data["pagibig_error"] = form_error('pagibig');
				$data["tin_error"] = form_error('tin');
				$data["in_case_address_error"] = form_error('in_case_address');
			}
			else
			{
				$data["is_valid"] = TRUE;
				$data["gender_error"] = "";
				$data["dept_head_error"] = "";
				$data["dept_head_number_error"] = "";
				$data["in_case_contact_number_error"] = "";
				$data["in_case_name_error"] = "";
				$data["first_name_error"] = "";
				$data["last_name_error"] = "";
				$data["address_error"] = "";
				$data["middle_name_error"] = "";
				$data["suffix_error"] = "";
				$data["contact_number_error"] = "";
				$data["class_id_error"] = "";
				$data["bday_error"] = "";
				$data["blood_type_error"] = form_error('blood_type');
				$data["sss_error"] = form_error('sss');
				$data["philhealth_error"] = form_error('philhealth');
				$data["pagibig_error"] = form_error('pagibig');
				$data["tin_error"] = form_error('tin');
				$data["in_case_address_error"] = form_error('in_case_address');

				$teacher_data["blood_type"] = $this->input->post("blood_type");
				$teacher_data["sss"] = $this->input->post("sss");
				$teacher_data["philhealth"] = $this->input->post("philhealth");
				$teacher_data["pagibig"] = $this->input->post("pagibig");
				$teacher_data["tin"] = $this->input->post("tin");
				$teacher_data["in_case_address"] = $this->input->post("in_case_address");
				$teacher_data["dept_head"] = $this->input->post("dept_head");
				$teacher_data["dept_head_number"] = $this->input->post("dept_head_number");
				$teacher_data["first_name"] = $this->input->post("first_name");
				$teacher_data["in_case_name"] = $this->input->post("in_case_name");
				$teacher_data["gender"] = $this->input->post("gender");
				$teacher_data["address"] = $this->input->post("address");
				$teacher_data["last_name"] = $this->input->post("last_name");
				$teacher_data["middle_name"] = $this->input->post("middle_name");
				$teacher_data["suffix"] = $this->input->post("suffix");
				$teacher_data["contact_number"] = $this->input->post("contact_number");
				$teacher_data["in_case_contact_number"] = $this->input->post("in_case_contact_number");
				$teacher_data["in_case_contact_number_sms"] = $in_case_contact_number_sms;
				$teacher_data["display_photo"] = $filename;
				$bday_m = sprintf("%02d",$this->input->post("bday_m"));
				$bday_d = sprintf("%02d",$this->input->post("bday_d"));
				$bday_y = sprintf("%04d",$this->input->post("bday_y"));
				$birthdate_str = $bday_m."/".$bday_d."/".$bday_y;
				$teacher_data["birthdate"] = strtotime($birthdate_str);
				$password = random_string('alnum', 8);

				$message = "Your account details as teacher are:
Login: ".$teacher_data["contact_number"]."
Password: ".$password."
You can login to ".base_url("teacher");

				$app_config_data = $this->db->get("app_config")->row();
				$data["sms_code"] = send_sms($this->input->post("contact_number"),$message,$app_config_data->apicode);
				$data["sms_status"] = sms_status($data["sms_code"]);
				$data["contact_number"] = $teacher_data["contact_number"];
				$teacher_data["password"] = md5($password);
				$teacher_data = $this->teachers_model->add($teacher_data);

				if($has_uploaded_pic){
					rename($full_path,$file_path.$teacher_data->id."_".$file_name);
					$edit_data = array();
					$edit_data["display_photo"] = $teacher_data->id."_".$file_name;
					$this->teachers_model->edit_info($edit_data,$teacher_data->id);
				}


				$rfid_data["ref_id"] = $teacher_data->id;
				$rfid_data["ref_table"] = "teachers";
				$rfid_data["valid"] = 1;
				$this->rfid_model->add($rfid_data);
			}

			echo json_encode($data);
		}
		
	}

	public function edit($arg='')
	{

		if($_POST){
			$this->form_validation->set_rules('blood_type', 'Blood Type', 'max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('sss', 'SSS', 'max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('philhealth', 'PhilHealth', 'max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('pagibig', 'Pag-IBIG', 'max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('tin', 'TIN', 'max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('in_case_address', 'Person Address', 'max_length[200]|trim|htmlspecialchars');
			$this->form_validation->set_rules('gender', 'Gender', 'required|max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('dept_head', 'Department Head', 'max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('dept_head_number', 'Department Head Contact Number', 'numeric|max_length[11]|min_length[11]|trim|htmlspecialchars');
			$this->form_validation->set_rules('teacher_id', 'First Name', 'required|trim|htmlspecialchars|is_in_db[teachers.id]');
			$this->form_validation->set_rules('first_name', 'First Name', 'required|is_unique_name[teachers.first_name.middle_name.last_name.teacher_id]|custom_alpha_dash|min_length[2]|max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('address', 'Address', 'required|min_length[2]|max_length[100]|trim|htmlspecialchars');
			$this->form_validation->set_rules('last_name', 'Last Name', 'required|custom_alpha_dash|min_length[2]|max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('middle_name', 'Middle Name', 'custom_alpha_dash|min_length[2]|max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('suffix', 'Suffix', 'custom_alpha_dash|min_length[2]|max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('bday_m', 'Birth Date', 'required|is_valid_date[bday_m.bday_d.bday_y]|trim|htmlspecialchars');
			$this->form_validation->set_rules('bday_d', 'Birth Date', 'required|is_valid_date[bday_m.bday_d.bday_y]|trim|htmlspecialchars');
			$this->form_validation->set_rules('bday_y', 'Birth Date', 'required|is_valid_date[bday_m.bday_d.bday_y]|trim|htmlspecialchars');
			$this->form_validation->set_rules('guardian_id', 'Guardian', 'is_in_db[guardians.id]|trim|htmlspecialchars');
			$this->form_validation->set_rules('class_id', 'Class', 'is_valid[classes.id]|trim|htmlspecialchars');
			$this->form_validation->set_rules('in_case_name', 'Name', 'custom_alpha_dash|min_length[2]|max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('contact_number', 'Contact Number', 'required|is_unique_edit[teachers.contact_number.teacher_id]|numeric|min_length[11]|max_length[11]|trim|htmlspecialchars');

			if($this->input->post("in_case_contact_number_sms")){
				$this->form_validation->set_rules('in_case_contact_number', 'In Case of Emergency Contact Number', 'required|numeric|min_length[11]|max_length[11]|trim|htmlspecialchars');
				$in_case_contact_number_sms = 1;
			}else{
				$this->form_validation->set_rules('in_case_contact_number', 'In Case of Emergency Contact Number', 'numeric|min_length[11]|max_length[11]|trim|htmlspecialchars');
				$in_case_contact_number_sms = 0;
			}

			$this->form_validation->set_message('is_in_db', 'An Error has occured please refresh the page and try again.');



			$has_uploaded_pic = FALSE;

			$get_data = array();
			$get_data["id"] = $this->input->post("teacher_id");
			$teacher_data_db = $this->teachers_model->get_data($get_data);

			//uploads files
			if($_FILES['teacher_photo']["error"]==0){

				$filename_first_name_array = explode(" ", $this->input->post("first_name"));
				$filename_first_name = implode("-", $filename_first_name_array);

				$filename_middle_name_array = explode(" ", $this->input->post("middle_name"));
				$filename_middle_name = implode("-", $filename_middle_name_array);

				$filename_last_name_array = explode(" ", $this->input->post("last_name"));
				$filename_last_name = implode("-", $filename_last_name_array);

				$filename_suffix_array = explode(" ", $this->input->post("suffix"));
				$filename_suffix = implode("-", $filename_suffix_array);

				$filename_full_name = $filename_last_name."_".$filename_first_name."_".$filename_middle_name."_".$filename_suffix;

				$get_data = array();
				$get_data["ref_id"] = $this->input->post("teacher_id");
				$get_data["ref_table"] = "teachers";
				$rfid_data = $this->rfid_model->get_data($get_data);
				

				$filename = $filename_full_name."_".$this->rfid_photo_model->add();



				$config['overwrite'] = TRUE;
				$config['upload_path'] = './assets/images/teacher_photo/';
				$config['allowed_types'] = '*';
				$config['file_name'] = $filename;
				$config['max_size']	= '20480';
				$this->load->library('upload', $config);
				if ( ! $this->upload->do_upload("teacher_photo"))
				{
					$data["is_valid_photo"] = FALSE;
					$data["photo_error"] = $this->upload->display_errors("","");
				}
				else
				{
					$image_data = $this->upload->data();
					$data["photo_error"] = "";
					$data["is_valid_photo"] = TRUE;
					if($image_data["is_image"]=="0"){
						$data["is_valid_photo"] = FALSE;
						$data["photo_error"] = "The file you are attempting to upload is not an image.";
					}else{
						$filename = $filename.$image_data["file_ext"];
						$image_data = $this->upload->data();
						$config['image_library'] = 'gd2';
						$config['source_image'] = $image_data["full_path"]; 
						$full_path = $image_data["full_path"];
						$file_path = $image_data["file_path"];
						$file_name = $image_data["file_name"];
						$config['create_thumb'] = FALSE;
						$config['new_image'] = $filename;
						$config['maintain_ratio'] = TRUE;
						$config['width']     = 360;
						$config['height']   = 360;
						$this->load->library('image_lib', $config); 
						$this->image_lib->resize();
						$this->image_lib->clear();

						$has_uploaded_pic = TRUE;
					}
				}
			}else{
				$data["is_valid_photo"] = TRUE;
				$filename = "empty.jpg";

				$get_data = array();
				$get_data["id"] = $this->input->post("teacher_id");
				$teacher_data_db = $this->teachers_model->get_data($get_data);
				$filename = $teacher_data_db["display_photo"];
			}



			if ($this->form_validation->run() == FALSE|| $data["is_valid_photo"] == FALSE)
			{
				$data["is_valid"] = FALSE;
				$data["dept_head_error"] = form_error('dept_head');
				$data["dept_head_number_error"] = form_error('dept_head_number');
				$data["in_case_contact_number_error"] = form_error('in_case_contact_number');
				$data["in_case_name_error"] = form_error('in_case_name');
				$data["first_name_error"] = form_error('first_name');
				$data["gender_error"] = form_error('gender');
				$data["last_name_error"] = form_error('last_name');
				$data["address_error"] = form_error('address');
				$data["middle_name_error"] = form_error('middle_name');
				$data["suffix_error"] = form_error('suffix');
				$data["contact_number_error"] = form_error('contact_number');
				$data["bday_error"] = form_error('bday_m');
				$data["guardian_id_error"] = form_error('guardian_id');
				$data["class_id_error"] = form_error('class_id');
				$data["teacher_id_error"] = form_error('teacher_id');
				$data["blood_type_error"] = form_error('blood_type');
				$data["sss_error"] = form_error('sss');
				$data["philhealth_error"] = form_error('philhealth');
				$data["pagibig_error"] = form_error('pagibig');
				$data["tin_error"] = form_error('tin');
				$data["in_case_address_error"] = form_error('in_case_address');
			}
			else
			{
				$data["dept_head_error"] = "";
				$data["dept_head_number_error"] = "";
				$data["is_valid"] = TRUE;
				$data["gender_error"] = "";
				$data["in_case_name_error"] = "";
				$data["in_case_contact_number_error"] = "";
				$data["first_name_error"] = "";
				$data["address_error"] = "";
				$data["last_name_error"] = "";
				$data["middle_name_error"] = "";
				$data["suffix_error"] = "";
				$data["contact_number_error"] = "";
				$data["bday_error"] = "";
				$data["guardian_id_error"] = "";
				$data["class_id_error"] = "";
				$data["blood_type_error"] = form_error('blood_type');
				$data["sss_error"] = form_error('sss');
				$data["philhealth_error"] = form_error('philhealth');
				$data["pagibig_error"] = form_error('pagibig');
				$data["tin_error"] = form_error('tin');
				$data["in_case_address_error"] = form_error('in_case_address');

				$teacher_data["blood_type"] = $this->input->post("blood_type");
				$teacher_data["sss"] = $this->input->post("sss");
				$teacher_data["philhealth"] = $this->input->post("philhealth");
				$teacher_data["pagibig"] = $this->input->post("pagibig");
				$teacher_data["tin"] = $this->input->post("tin");
				$teacher_data["in_case_address"] = $this->input->post("in_case_address");
				$teacher_data["gender"] = $this->input->post("gender");
				$teacher_data["dept_head"] = $this->input->post("dept_head");
				$teacher_data["dept_head_number"] = $this->input->post("dept_head_number");
				$teacher_data["in_case_name"] = $this->input->post("in_case_name");
				$teacher_data["in_case_contact_number"] = $this->input->post("in_case_contact_number");
				$teacher_data["in_case_contact_number_sms"] = $in_case_contact_number_sms;
				$teacher_data["first_name"] = $this->input->post("first_name");
				$teacher_data["address"] = $this->input->post("address");
				$teacher_data["last_name"] = $this->input->post("last_name");
				$teacher_data["middle_name"] = $this->input->post("middle_name");
				$teacher_data["suffix"] = $this->input->post("suffix");
				$teacher_data["contact_number"] = $this->input->post("contact_number");
				$teacher_data["guardian_id"] = $this->input->post("guardian_id");
				$teacher_data["display_photo"] = $filename;
				$bday_m = sprintf("%02d",$this->input->post("bday_m"));
				$bday_d = sprintf("%02d",$this->input->post("bday_d"));
				$bday_y = sprintf("%04d",$this->input->post("bday_y"));
				$birthdate_str = $bday_m."/".$bday_d."/".$bday_y;
				$teacher_data["birthdate"] = strtotime($birthdate_str);




				if($teacher_data_db["contact_number"]!=$this->input->post("contact_number")){
					$password = random_string('alnum', 8);
					$message = "Your account details as teacher are:
Login: ".$teacher_data["contact_number"]."
Password: ".$password."
You can login to ".base_url("teacher");
					$app_config_data = $this->db->get("app_config")->row();
					$sms_code = send_sms($this->input->post("contact_number"),$message,$app_config_data->apicode);
					$teacher_data["password"] = md5($password);
					if($sms_code==0){
						$this->teachers_model->edit_info($teacher_data,$this->input->post("teacher_id"));
						$data["password_reset"] = TRUE;
						$data["contact_number"] = $this->input->post("contact_number");
					}else{
						$data["password_reset"] = FALSE;
						$data["is_valid"] = FALSE;
						$data["contact_number_error"] = sms_status($sms_code);
					}
				}else{
					$this->teachers_model->edit_info($teacher_data,$this->input->post("teacher_id"));
				}


				

				if($has_uploaded_pic){
					if(file_exists("assets/images/student_photo/".$teacher_data_db["display_photo"])){
						if($teacher_data_db["display_photo"]=='empty.jpg'){
							unlink("assets/images/student_photo/".$teacher_data_db["display_photo"]);
						}
					}
					$teacher_id = $this->input->post("teacher_id");
					rename($full_path,$file_path.$teacher_id."_".$file_name);
					$edit_data = array();
					$edit_data["display_photo"] = $teacher_id."_".$file_name;
					$this->teachers_model->edit_info($edit_data,$teacher_id);
				}

			}
			echo json_encode($data);

			
		}

	}

	public function get_data($arg='')
	{
		if($arg=="jbtech"){
			$teacher_data["id"] = $this->input->get("teacher_id");
			$teacher_data = $this->teachers_model->get_data($teacher_data);
			$teacher_data["id"] = sprintf("%03d",$this->input->get("teacher_id"));
			$teacher_data["birthday"] = date("m/d/Y",$teacher_data["birthdate"]);
			$teacher_data["age"] = age($teacher_data["birthdate"]);
			$teacher_data["middle_initial"] = ($teacher_data["middle_name"]==""?"":$teacher_data["middle_name"][0].". ");
			$teacher_data["full_name"] = $teacher_data["first_name"]." ".$teacher_data["middle_initial"]." ".$teacher_data["last_name"]." ".$teacher_data["suffix"];

			if($teacher_data["class_id"] != 0){
				$get_data = array();
				$get_data["id"] = $teacher_data["class_id"];
				$teacher_data["class_data"] = $this->classes_model->get_data($get_data);
				$teacher_data["class_name"] = $teacher_data["class_data"]["class_name"];
			}else{
				$teacher_data["class_name"] = "";
			}


			echo json_encode($teacher_data);
		}else{
			$teacher_data["id"] = $this->input->get("teacher_id");
			$teacher_data = $this->teachers_model->get_data($teacher_data);
			$teacher_data["bday_m"] = date("n",$teacher_data["birthdate"]);
			$teacher_data["bday_d"] = date("j",$teacher_data["birthdate"]);
			$teacher_data["bday_y"] = date("Y",$teacher_data["birthdate"]);
			($teacher_data["class_id"]==0?$teacher_data["class_id"]="":FALSE);
			echo json_encode($teacher_data);
		}
	}

	public function get_list($arg='')
	{
		if($arg=="admin"){
			$data = $this->teachers_model->get_list("",1,$this->db->get("teachers")->num_rows());
			echo json_encode($data["result"]);
		}elseif ($arg=="jbtech") {
			$where["deleted"] = 0;
			$data = $this->teachers_model->get_list($where,1,$this->db->get("teachers")->num_rows());
			echo json_encode($data["result"]);
		}
	}

	public function delete()
	{
		if($_POST){
			$data = array();
			$data["deleted"] = 1;
			$data["class_id"] = 0;
			$this->teachers_model->delete($data,$this->input->post("id"));

			$data = array();
			$data["deleted"] = 1;
			$edit_data["ref_id"] = $this->input->post("id");
			$edit_data["ref_table"] = "teachers";
			$this->rfid_model->edit_info($data,$edit_data);

			$get_data = array();
			$get_data["id"] = $this->input->post("id");
			echo json_encode($this->teachers_model->get_data($get_data));

			$this->db->where('teacher_id', $this->input->post("id"));
			$this->db->set("teacher_id","0");
			$this->db->update('classes');
		}
	}

	


	public function reset_password($arg='')
	{
		$teacher_id = $this->input->post("id");
		$get_data["id"] = $teacher_id;
		$teacher_data = $this->teachers_model->get_data($get_data);

		$password = random_string('alnum', 8);
		$message = "Your account details as teacher are:
Login: ".$teacher_data["contact_number"]."
Password: ".$password."
You can login to ".base_url("teacher");
		$app_config_data = $this->db->get("app_config")->row();
		$sms_status_code = send_sms($teacher_data["contact_number"],$message,$app_config_data->apicode);
		if($sms_status_code=="0"){
			$update["password"] = md5($password);
			$data = $this->teachers_model->edit_info($update,$teacher_id);
			$data->is_successful = TRUE;
			echo json_encode($data);
		}else{
			$data["is_successful"] = FALSE;
			$data["error"] = sms_status($sms_status_code);
			echo json_encode($data);
		}
	}

	public function download($arg='')
	{

		$fp = fopen('teachers.csv', 'w');

		$headers = array (
			'id',
			'Last Name',
			'Middle Name',
			'First Name',
			'Suffix',
			'Gender',
			'Contact Number',
			'Birthdate',
			'Age',
			'Address',
			'In Case of Emergency Name',
			'Contact Number',
			'Class',
			'SSS',
			'PhilHealth',
			'Pag-IBIG'
			);
	    fputcsv($fp, $headers);
	    $teacher_list = $this->teachers_model->get_list("",1,$this->db->get("teachers")->num_rows());
	    foreach ($teacher_list["result"] as $teacher_data) {
	    	$get_data = array();
	    	$get_data["id"] = $teacher_data->class_id;
	    	$class_data = $this->classes_model->get_data($get_data);
		    $records = array(
		    	sprintf("%03d",$teacher_data->id),
		    	$teacher_data->last_name,
		    	$teacher_data->middle_name,
		    	$teacher_data->first_name,
		    	$teacher_data->suffix,
		    	$teacher_data->gender,
		    	$teacher_data->contact_number,
		    	date("m/d/Y",$teacher_data->birthdate),
		    	age($teacher_data->birthdate),
		    	$teacher_data->address,
		    	$teacher_data->in_case_name,
		    	$teacher_data->in_case_contact_number,
		    	$class_data["class_name"],
		    	$teacher_data->sss,
		    	$teacher_data->philhealth,
		    	$teacher_data->pagibig
		    	);
		    fputcsv($fp, $records);
	    }
		fclose($fp);
		echo base_url("teachers.csv");
	}



}