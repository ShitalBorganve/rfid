<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Staff_ajax extends CI_Controller {


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
		$this->load->model("teachers_model");
		$this->load->model("staffs_model");
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
			$this->form_validation->set_rules('blood_type', 'Blood Type', 'required|max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('sss', 'SSS', 'required|max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('philhealth', 'PhilHealth', 'required|max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('pagibig', 'Pag-IBIG', 'required|max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('tin', 'TIN', 'required|max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('in_case_address', 'Person Address', 'required|max_length[200]|trim|htmlspecialchars');
			$this->form_validation->set_rules('dept_head', 'Department Head', 'max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('dept_head_number', 'Department Head Contact Number', 'numeric|max_length[11]|min_length[11]|trim|htmlspecialchars');
			$this->form_validation->set_rules('position', 'Position', 'required|custom_alpha_dash|min_length[2]|max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('address', 'Address', 'required|min_length[2]|max_length[100]|trim|htmlspecialchars');
			$this->form_validation->set_rules('first_name', 'First Name', 'required|custom_alpha_dash|min_length[2]|max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('last_name', 'Last Name', 'required|custom_alpha_dash|min_length[2]|max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('middle_name', 'Middle Name', 'custom_alpha_dash|min_length[2]|max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('suffix', 'Suffix', 'custom_alpha_dash|min_length[2]|max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('bday_m', 'Birth Date', 'required|is_valid_date[bday_m.bday_d.bday_y]|trim|htmlspecialchars');
			$this->form_validation->set_rules('bday_d', 'Birth Date', 'required|is_valid_date[bday_m.bday_d.bday_y]|trim|htmlspecialchars');
			$this->form_validation->set_rules('bday_y', 'Birth Date', 'required|is_valid_date[bday_m.bday_d.bday_y]|trim|htmlspecialchars');
			$this->form_validation->set_rules('contact_number', 'Contact Number', 'numeric|min_length[11]|max_length[11]|trim|htmlspecialchars');
			$this->form_validation->set_rules('gender', 'Gender', 'required|max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('in_case_name', 'Name', 'custom_alpha_dash|min_length[2]|max_length[50]|trim|htmlspecialchars');

			if($this->input->post("in_case_contact_number_sms")){
				$this->form_validation->set_rules('in_case_contact_number', 'In Case of Emergency Contact Number', 'required|numeric|min_length[11]|max_length[11]|trim|htmlspecialchars');
				$in_case_contact_number_sms = 1;
			}else{
				$this->form_validation->set_rules('in_case_contact_number', 'In Case of Emergency Contact Number', 'numeric|min_length[11]|max_length[11]|trim|htmlspecialchars');
				$in_case_contact_number_sms = 0;
			}



			$has_uploaded_pic = FALSE;

			//uploads files
			if($_FILES['staff_photo']["error"]==0){

				$filename_first_name_array = explode(" ", $this->input->post("first_name"));
				$filename_first_name = implode("-", $filename_first_name_array);

				$filename_middle_name_array = explode(" ", $this->input->post("middle_name"));
				$filename_middle_name = implode("-", $filename_middle_name_array);

				$filename_last_name_array = explode(" ", $this->input->post("last_name"));
				$filename_last_name = implode("-", $filename_last_name_array);

				$filename_suffix_array = explode(" ", $this->input->post("suffix"));
				$filename_suffix = implode("-", $filename_suffix_array);

				$filename_full_name = $filename_last_name."_".$filename_first_name."_".$filename_middle_name."_".$filename_suffix;

				$filename = $filename_full_name."_".$this->rfid_photo_model->add();;



				$config['overwrite'] = TRUE;
				$config['upload_path'] = './assets/images/staff_photo/';
				$config['allowed_types'] = 'gif|jpg|png';
				$config['file_name'] = $filename;
				$config['max_size']	= '20480';
				$this->load->library('upload', $config);
				if ( ! $this->upload->do_upload("staff_photo"))
				{
					$data["is_valid_photo"] = FALSE;
					$data["photo_error"] = $this->upload->display_errors("","");
				}
				else
				{
					$data["photo_error"] = "";
					$data["is_valid_photo"] = TRUE;
					$image_data = $this->upload->data();
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
				$data["address_error"] = form_error('address');
				$data["in_case_name_error"] = form_error('in_case_name');
				$data["in_case_contact_number_error"] = form_error('in_case_contact_number');
				$data["gender_error"] = form_error('gender');
				$data["position_error"] = form_error('position');
				$data["first_name_error"] = form_error('first_name');
				$data["last_name_error"] = form_error('last_name');
				$data["middle_name_error"] = form_error('middle_name');
				$data["suffix_error"] = form_error('suffix');
				$data["contact_number_error"] = form_error('contact_number');
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
				$data["gender_error"] = form_error('gender');
				$data["dept_head_error"] = form_error('dept_head');
				$data["dept_head_number_error"] = form_error('dept_head_number');
				$data["address_error"] = form_error('address');
				$data["in_case_name_error"] = form_error('in_case_name');
				$data["in_case_contact_number_error"] = form_error('in_case_contact_number');
				$data["gender_error"] = form_error('gender');
				$data["position_error"] = form_error('position');
				$data["first_name_error"] = form_error('first_name');
				$data["last_name_error"] = form_error('last_name');
				$data["middle_name_error"] = form_error('middle_name');
				$data["suffix_error"] = form_error('suffix');
				$data["contact_number_error"] = form_error('contact_number');
				$data["bday_error"] = form_error('bday_m');
				$data["blood_type_error"] = form_error('blood_type');
				$data["sss_error"] = form_error('sss');
				$data["philhealth_error"] = form_error('philhealth');
				$data["pagibig_error"] = form_error('pagibig');
				$data["tin_error"] = form_error('tin');
				$data["in_case_address_error"] = form_error('in_case_address');

				$staff_data["blood_type"] = $this->input->post("blood_type");
				$staff_data["sss"] = $this->input->post("sss");
				$staff_data["philhealth"] = $this->input->post("philhealth");
				$staff_data["pagibig"] = $this->input->post("pagibig");
				$staff_data["tin"] = $this->input->post("tin");
				$staff_data["in_case_address"] = $this->input->post("in_case_address");
				$staff_data["dept_head"] = $this->input->post("dept_head");
				$staff_data["dept_head_number"] = $this->input->post("dept_head_number");
				$staff_data["first_name"] = $this->input->post("first_name");
				$staff_data["in_case_name"] = $this->input->post("in_case_name");
				$staff_data["in_case_contact_number"] = $this->input->post("in_case_contact_number");
				$staff_data["in_case_contact_number_sms"] = $in_case_contact_number_sms;
				$staff_data["gender"] = $this->input->post("gender");
				$staff_data["address"] = $this->input->post("address");
				$staff_data["last_name"] = $this->input->post("last_name");
				$staff_data["middle_name"] = $this->input->post("middle_name");
				$staff_data["suffix"] = $this->input->post("suffix");
				$staff_data["position"] = $this->input->post("position");
				$staff_data["contact_number"] = $this->input->post("contact_number");
				$staff_data["display_photo"] = $filename;
				$bday_m = sprintf("%02d",$this->input->post("bday_m"));
				$bday_d = sprintf("%02d",$this->input->post("bday_d"));
				$bday_y = sprintf("%04d",$this->input->post("bday_y"));
				$birthdate_str = $bday_m."/".$bday_d."/".$bday_y;
				$staff_data["birthdate"] = strtotime($birthdate_str);
				$data["is_successful"] = TRUE;
				$staff_data = $this->staffs_model->add($staff_data);

				if($has_uploaded_pic){
					rename($full_path,$file_path.$staff_data->id."_".$file_name);
					$edit_data = array();
					$edit_data["display_photo"] = $staff_data->id."_".$file_name;
					$this->staffs_model->edit_info($edit_data,$staff_data->id);
				}


				$rfid_data["ref_id"] = $staff_data->id;
				$rfid_data["ref_table"] = "staffs";
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
			$this->form_validation->set_rules('staff_id', 'First Name', 'required|trim|htmlspecialchars|is_in_db[staffs.id]');
			$this->form_validation->set_rules('dept_head', 'Department Head', 'max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('dept_head_number', 'Department Head Contact Number', 'numeric|max_length[11]|min_length[11]|trim|htmlspecialchars');
			$this->form_validation->set_rules('address', 'Address', 'required|min_length[2]|max_length[100]|trim|htmlspecialchars');
			$this->form_validation->set_rules('position', 'Position', 'required|custom_alpha_dash|min_length[2]|max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('first_name', 'First Name', 'required|custom_alpha_dash|min_length[2]|max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('last_name', 'Last Name', 'required|custom_alpha_dash|min_length[2]|max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('middle_name', 'Middle Name', 'custom_alpha_dash|min_length[2]|max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('suffix', 'Suffix', 'custom_alpha_dash|min_length[2]|max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('bday_m', 'Birth Date', 'required|is_valid_date[bday_m.bday_d.bday_y]|trim|htmlspecialchars');
			$this->form_validation->set_rules('bday_d', 'Birth Date', 'required|is_valid_date[bday_m.bday_d.bday_y]|trim|htmlspecialchars');
			$this->form_validation->set_rules('bday_y', 'Birth Date', 'required|is_valid_date[bday_m.bday_d.bday_y]|trim|htmlspecialchars');
			$this->form_validation->set_rules('contact_number', 'Contact Number', 'numeric|min_length[11]|max_length[11]|trim|htmlspecialchars');
			$this->form_validation->set_rules('in_case_name', 'Name', 'custom_alpha_dash|min_length[2]|max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('gender', 'Gender', 'required|max_length[50]|trim|htmlspecialchars');

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
			$get_data["id"] = $this->input->post("staff_id");
			$staff_data_db = $this->staffs_model->get_data($get_data);

			//uploads files
			if($_FILES['staff_photo']["error"]==0){

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
				$get_data["ref_id"] = $this->input->post("staff_id");
				$get_data["ref_table"] = "staffs";
				$rfid_data = $this->rfid_model->get_data($get_data);
				

				$filename = $filename_full_name."_".$this->rfid_photo_model->add();;



				$config['overwrite'] = TRUE;
				$config['upload_path'] = './assets/images/staff_photo/';
				$config['allowed_types'] = 'gif|jpg|png';
				$config['file_name'] = $filename;
				$config['max_size']	= '20480';
				$this->load->library('upload', $config);
				if ( ! $this->upload->do_upload("staff_photo"))
				{
					$data["is_valid_photo"] = FALSE;
					$data["photo_error"] = $this->upload->display_errors("","");
				}
				else
				{
					$data["photo_error"] = "";
					$data["is_valid_photo"] = TRUE;
					$image_data = $this->upload->data();
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
			}else{
				$data["is_valid_photo"] = TRUE;
				$filename = "empty.jpg";


				$filename = $staff_data_db["display_photo"];
			}



			if ($this->form_validation->run() == FALSE|| $data["is_valid_photo"] == FALSE)
			{
				$data["is_valid"] = FALSE;
				$data["dept_head_error"] = form_error('dept_head');
				$data["dept_head_number_error"] = form_error('dept_head_number');
				$data["gender_error"] = form_error('gender');
				$data["in_case_name_error"] = form_error('in_case_name');
				$data["in_case_contact_number_error"] = form_error('in_case_contact_number');
				$data["address_error"] = form_error('address');
				$data["position_error"] = form_error('position');
				$data["first_name_error"] = form_error('first_name');
				$data["last_name_error"] = form_error('last_name');
				$data["middle_name_error"] = form_error('middle_name');
				$data["suffix_error"] = form_error('suffix');
				$data["contact_number_error"] = form_error('contact_number');
				$data["bday_error"] = form_error('bday_m');
				$data["staff_id_error"] = form_error('staff_id');
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
				$data["dept_head_error"] = form_error('dept_head');
				$data["dept_head_number_error"] = form_error('dept_head_number');
				$data["gender_error"] = form_error('gender');
				$data["in_case_name_error"] = form_error('in_case_name');
				$data["in_case_contact_number_error"] = form_error('in_case_contact_number');
				$data["address_error"] = form_error('address');
				$data["position_error"] = form_error('position');
				$data["first_name_error"] = form_error('first_name');
				$data["last_name_error"] = form_error('last_name');
				$data["middle_name_error"] = form_error('middle_name');
				$data["suffix_error"] = form_error('suffix');
				$data["contact_number_error"] = form_error('contact_number');
				$data["bday_error"] = form_error('bday_m');
				$data["class_id_error"] = "";
				$data["blood_type_error"] = form_error('blood_type');
				$data["sss_error"] = form_error('sss');
				$data["philhealth_error"] = form_error('philhealth');
				$data["pagibig_error"] = form_error('pagibig');
				$data["tin_error"] = form_error('tin');
				$data["in_case_address_error"] = form_error('in_case_address');

				$staff_data["blood_type"] = $this->input->post("blood_type");
				$staff_data["sss"] = $this->input->post("sss");
				$staff_data["philhealth"] = $this->input->post("philhealth");
				$staff_data["pagibig"] = $this->input->post("pagibig");
				$staff_data["tin"] = $this->input->post("tin");
				$staff_data["in_case_address"] = $this->input->post("in_case_address");
				$staff_data["first_name"] = $this->input->post("first_name");
				$staff_data["dept_head"] = $this->input->post("dept_head");
				$staff_data["dept_head_number"] = $this->input->post("dept_head_number");
				$staff_data["address"] = $this->input->post("address");
				$staff_data["position"] = $this->input->post("position");
				$staff_data["gender"] = $this->input->post("gender");
				$staff_data["last_name"] = $this->input->post("last_name");
				$staff_data["middle_name"] = $this->input->post("middle_name");
				$staff_data["suffix"] = $this->input->post("suffix");
				$staff_data["contact_number"] = $this->input->post("contact_number");
				$staff_data["in_case_name"] = $this->input->post("in_case_name");
				$staff_data["in_case_contact_number"] = $this->input->post("in_case_contact_number");
				$staff_data["in_case_contact_number_sms"] = $in_case_contact_number_sms;
				$staff_data["display_photo"] = $filename;
				$bday_m = sprintf("%02d",$this->input->post("bday_m"));
				$bday_d = sprintf("%02d",$this->input->post("bday_d"));
				$bday_y = sprintf("%04d",$this->input->post("bday_y"));
				$birthdate_str = $bday_m."/".$bday_d."/".$bday_y;
				$staff_data["birthdate"] = strtotime($birthdate_str);


				$get_data = array();
				$get_data["id"] = $this->input->post("staff_id");
				$staff_data_db = $this->staffs_model->get_data($get_data);

				$this->staffs_model->edit_info($staff_data,$this->input->post("staff_id"));

				if($has_uploaded_pic){
					unlink("assets/images/staff_photo/".$staff_data_db["display_photo"]);
					$staff_id = $this->input->post("staff_id");
					rename($full_path,$file_path.$staff_id."_".$file_name);
					$edit_data = array();
					$edit_data["display_photo"] = $staff_id."_".$file_name;
					$this->staffs_model->edit_info($edit_data,$staff_id);
				}

			}
			echo json_encode($data);

			
		}

	}

	public function get_data($arg='')
	{
		if($arg=="jbtech"){
			$staff_data["id"] = $this->input->get("staff_id");
			$staff_data = $this->staffs_model->get_data($staff_data);
			$staff_data["id"] = sprintf("%03d",$this->input->get("staff_id"));
			$staff_data["birthday"] = date("m/d/Y",$staff_data["birthdate"]);
			$staff_data["age"] = age($staff_data["birthdate"]);
			$staff_data["full_name"] = $staff_data["first_name"]." ".$staff_data["middle_name"][0].". ".$staff_data["last_name"]." ".$staff_data["suffix"];
			echo json_encode($staff_data);
		}else{
			$staff_data["id"] = $this->input->get("staff_id");
			$staff_data = $this->staffs_model->get_data($staff_data);
			$staff_data["bday_m"] = date("n",$staff_data["birthdate"]);
			$staff_data["bday_d"] = date("j",$staff_data["birthdate"]);
			$staff_data["bday_y"] = date("Y",$staff_data["birthdate"]);
			echo json_encode($staff_data);
		}
	}

	public function get_list($arg='')
	{
		if($arg=="admin"){
			$where = "";
			if($this->input->get("position")){
				$where["position"] = $this->input->get("position");
				$where["deleted"] = 0;
			}
			$data = $this->staffs_model->get_list($where);
			echo json_encode($data["result"]);
		}elseif ($arg=="jbtech") {
			$where["rfid_status"] = 0;
			$where["deleted"] = 0;
			if($this->input->get("position")){
				$where["position"] = $this->input->get("position");
			}
			$data = $this->staffs_model->get_list($where);
			echo json_encode($data["result"]);
		}
	}

	public function delete()
	{
		if($_POST){
			$data = array();
			$data["deleted"] = 1;
			$this->staffs_model->delete($data,$this->input->post("id"));

			$data = array();
			$data["deleted"] = 1;
			$edit_data["ref_id"] = $this->input->post("id");
			$edit_data["ref_table"] = "staffs";
			$this->rfid_model->edit_info($data,$edit_data);

			$get_data = array();
			$get_data["id"] = $this->input->post("id");
			echo json_encode($this->staffs_model->get_data($get_data));

		}
	}

	public function applogin($arg='')
	{
		if($_POST){
			$this->form_validation->set_rules('account', 'Account', 'required|min_length[5]|max_length[12]|is_valid[staffs.contact_number]|trim|htmlspecialchars');
			$this->form_validation->set_rules('account_password', 'Password', 'required|min_length[5]|max_length[12]|trim|htmlspecialchars');
			$this->form_validation->set_message('is_valid', 'This account is invalid');

			if ($this->form_validation->run() == FALSE)
			{
				$data["is_valid"] = FALSE;
				$data["account_error"] = form_error('account');
				$data["account_password_error"] = form_error('account_password');
			}
			else
			{
				$data["contact_number"] = $account_id = $this->input->post("account");
				$data["password"] = md5($account_password = $this->input->post("account_password"));
				$data["is_valid"] = $this->staffs_model->login($data);
				$data["account_error"] = "";
				
				if($data["is_valid"]){
					$data["account_password_error"] = "";
					$data["redirect"] = base_url("staff");


				}else{
					$data["account_password_error"] = "Incorrect Passord. Try Again.";
					$data["redirect"] = "";
				}
			}

			echo json_encode($data);
		}
	}


	public function download($arg='')
	{

		$fp = fopen('staffs.csv', 'w');

		$headers = array (
			'id',
			'Position',
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
			'SSS',
			'PhilHealth',
			'Pag-IBIG'
			);
	    fputcsv($fp, $headers);
	    $staff_list = $this->staffs_model->get_list("",1,$this->db->get("staffs")->num_rows());
	    foreach ($staff_list["result"] as $staff_data) {
		    $records = array(
		    	sprintf("%03d",$staff_data->id),
		    	$staff_data->position,
		    	$staff_data->last_name,
		    	$staff_data->middle_name,
		    	$staff_data->first_name,
		    	$staff_data->suffix,
		    	$staff_data->gender,
		    	$staff_data->contact_number,
		    	date("m/d/Y",$staff_data->birthdate),
		    	age($staff_data->birthdate),
		    	$staff_data->address,
		    	$staff_data->in_case_name,
		    	$staff_data->in_case_contact_number,
		    	$teacher_data->sss,
		    	$teacher_data->philhealth,
		    	$teacher_data->pagibig
		    	);
		    fputcsv($fp, $records);
	    }
		fclose($fp);
		echo base_url("staffs.csv");
	}



}