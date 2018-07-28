<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student_ajax extends CI_Controller {


	public function __construct()
	{
		parent::__construct();
		$this->load->helper('app_helper');
		$this->load->database(database());
		
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('string');


		//models
		$this->load->model('guardian_model');
		$this->load->model("admin_model");
		$this->load->model("classes_model");
		$this->load->model("teachers_model");
		$this->load->model("students_model");
		$this->load->model("gate_logs_model");
		$this->load->model("rfid_model");
		$this->load->model("rfid_photo_model");
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
	public function add($arg='')
	{
		$compiled_errors = array();
		if($_POST){

			$this->form_validation->set_rules('address', 'Address', 'required|min_length[2]|max_length[100]|trim|htmlspecialchars');
			$this->form_validation->set_rules('lrn_number', 'LRN Number', 'min_length[2]|max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('gender', 'Gender', 'required|max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('mothers_name', 'Mother&apos;s Name', 'max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('fathers_name', 'Father&apos;s Name', 'max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('first_name', 'First Name', 'required|is_unique_name[students.first_name.middle_name.last_name.NULL]|custom_alpha_dash|min_length[2]|max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('last_name', 'Last Name', 'required|custom_alpha_dash|min_length[2]|max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('middle_name', 'Middle Name', 'custom_alpha_dash|min_length[2]|max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('suffix', 'Suffix', 'custom_alpha_dash|min_length[2]|max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('contact_number', 'Contact Number', 'numeric|min_length[11]|max_length[11]|trim|htmlspecialchars');
			$this->form_validation->set_rules('bday_m', 'Birth Date', 'required|is_valid_date[bday_m.bday_d.bday_y]|trim|htmlspecialchars');
			$this->form_validation->set_rules('bday_d', 'Birth Date', 'required|is_valid_date[bday_m.bday_d.bday_y]|trim|htmlspecialchars');
			$this->form_validation->set_rules('bday_y', 'Birth Date', 'required|is_valid_date[bday_m.bday_d.bday_y]|trim|htmlspecialchars');
			$this->form_validation->set_rules('guardian_id', 'Guardian', 'is_in_db[guardians.id]|trim|htmlspecialchars');
			$this->form_validation->set_rules('class_id', 'Class', 'required|is_valid[classes.id]|trim|htmlspecialchars');
			$this->form_validation->set_rules('age_as_of_august', 'Age as of August', 'numeric|max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('fathers_last_name', 'Father&apos;s Last Name', 'min_length[2]|max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('fathers_middle_name', 'Father&apos;s Middle Name', 'min_length[2]|max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('fathers_first_name', 'Father&apos;s First Name', 'min_length[2]|max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('fathers_contact_number', 'Father&apos;s Contact Number', 'numeric|min_length[11]|max_length[11]|trim|htmlspecialchars');
			$this->form_validation->set_rules('fathers_address', 'Mother&apos;s Address', 'min_length[2]|max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('mothers_last_name', 'Mother&apos;s Last Name', 'min_length[2]|max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('mothers_middle_name', 'Mother&apos;s Middle Name', 'min_length[2]|max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('mothers_first_name', 'Mother&apos;s First Name', 'min_length[2]|max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('mothers_contact_number', 'Mother&apos;s Contact Number', 'numeric|min_length[11]|max_length[11]|trim|htmlspecialchars');
			$this->form_validation->set_rules('mothers_address', 'Mother&apos;s Address', 'min_length[2]|max_length[50]|trim|htmlspecialchars');
			$grade = $this->input->post('grade');
			if($grade == 'grade 1' || $grade == 'grade 2' || $grade == 'grade 3'){
				$this->form_validation->set_rules('mother_tongue', 'Mother Tongue', 'required|max_length[50]|trim|htmlspecialchars');
			}

			$this->form_validation->set_message('is_in_db', 'This account is invalid');
			$has_uploaded_pic = FALSE;

			//uploads files
			if(isset($_FILES['student_photo']) && $_FILES['student_photo']["error"]==0){

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
				$config['upload_path'] = './assets/images/student_photo/';
				$config['allowed_types'] = '*';
				$config['file_name'] = $filename;
				$config['max_size']	= '20480';
				$this->load->library('upload', $config);
				if ( ! $this->upload->do_upload("student_photo"))
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
				
				$data["lrn_number_error"] = form_error('lrn_number');
				$data["address_error"] = form_error('address');
				$data["gender_error"] = form_error('gender');
				$data["mothers_name_error"] = form_error('mothers_name');
				$data["fathers_name_error"] = form_error('fathers_name');
				$data["first_name_error"] = form_error('first_name');
				$data["last_name_error"] = form_error('last_name');
				$data["middle_name_error"] = form_error('middle_name');
				$data["suffix_error"] = form_error('suffix');
				$data["bday_error"] = form_error('bday_m');
				$data["guardian_id_error"] = form_error('guardian_id');
				$data["class_id_error"] = form_error('class_id');
				$data["contact_number_error"] = form_error('contact_number');
				$data["mother_tongue_error"] = form_error('mother_tongue');
				$data["age_as_of_august_error"] = form_error('age_as_of_august');
				$data["fathers_last_name_error"] = form_error('fathers_last_name');
				$data["fathers_middle_name_error"] = form_error('fathers_middle_name');
				$data["fathers_first_name_error"] = form_error('fathers_first_name');
				$data["fathers_contact_number_error"] = form_error('fathers_contact_number');
				$data["fathers_address_error"] = form_error('fathers_address');
				$data["mothers_last_name_error"] = form_error('mothers_last_name');
				$data["mothers_middle_name_error"] = form_error('mothers_middle_name');
				$data["mothers_first_name_error"] = form_error('mothers_first_name');
				$data["mothers_contact_number_error"] = form_error('mothers_contact_number');
				$data["mothers_address_error"] = form_error('mothers_address');
				foreach ($data as $value) {
					if($value!="true"){
						if($value!=""){
							$compiled_errors[] = $value;
						}
					}
				}
				$data["is_valid"] = FALSE;
				$data["need_to_add_guardian"] = $data["guardian_id_error"]!="";
				$data["need_to_add_class"] = $data["class_id_error"]!="";
				$data["compiled_errors"] = $compiled_errors;
			}
			else
			{
				$data["is_valid"] = TRUE;
				$data["lrn_number_error"] = "";
				$data["address_error"] = "";
				$data["gender_error"] = "";
				$data["mothers_name_error"] = "";
				$data["fathers_name_error"] = "";
				$data["first_name_error"] = "";
				$data["last_name_error"] = "";
				$data["middle_name_error"] = "";
				$data["suffix_error"] = "";
				$data["bday_error"] = "";
				$data["guardian_id_error"] = "";
				$data["class_id_error"] = "";
				$data["contact_number_error"] = "";
				$data["mother_tongue_error"] = "";
				$data["age_as_of_august"] = "";
				$data["fathers_last_name_error"] = "";
				$data["fathers_middle_name_error"] = "";
				$data["fathers_first_name_error"] = "";
				$data["fathers_contact_number_error"] = "";
				$data["fathers_address_error"] = "";
				$data["mothers_last_name_error"] = "";
				$data["mothers_middle_name_error"] = "";
				$data["mothers_first_name_error"] = "";
				$data["mothers_contact_number_error"] = "";
				$data["mothers_address_error"] = "";

				$student_data["lrn_number"] = $this->input->post("lrn_number");
				$student_data["first_name"] = $this->input->post("first_name");
				$student_data["mothers_name"] = $this->input->post("mothers_name");
				$student_data["fathers_name"] = $this->input->post("fathers_name");
				$student_data["last_name"] = $this->input->post("last_name");
				$student_data["address"] = $this->input->post("address");
				$student_data["gender"] = $this->input->post("gender");
				$student_data["middle_name"] = $this->input->post("middle_name");
				$student_data["suffix"] = $this->input->post("suffix");
				$student_data["contact_number"] = $this->input->post("contact_number");
				$student_data["guardian_id"] = $this->input->post("guardian_id");
				$student_data["class_id"] = $this->input->post("class_id");
				$student_data["display_photo"] = $filename;
				$student_data["age_as_of_august"] = $this->input->post("age_as_of_august");
				$student_data["mother_tongue"] = $this->input->post("mother_tongue");
				$student_data["ethnic_group"] = $this->input->post("ethnic_group");
				$student_data["religion"] = $this->input->post("religion");
				$student_data["is_transferee"] = $this->input->post("is_transferee");
				$student_data["last_school_attended"] = $this->input->post("last_school_attended");
				$student_data["last_year_attended"] = $this->input->post("last_year_attended");
				$student_data["last_grade_attended"] = $this->input->post("last_grade_attended");
				$student_data["last_track_strand"] = $this->input->post("last_track_strand");
				$student_data["academic_track"] = $this->input->post("academic_track");
				$student_data["tech_voc_track"] = $this->input->post("tech_voc_track");
				$student_data["fathers_last_name"] = $this->input->post("fathers_last_name");
				$student_data["fathers_middle_name"] = $this->input->post("fathers_middle_name");
				$student_data["fathers_first_name"] = $this->input->post("fathers_first_name");
				$student_data["fathers_contact_number"] = $this->input->post("fathers_contact_number");
				$student_data["fathers_address"] = $this->input->post("fathers_address");
				$student_data["mothers_last_name"] = $this->input->post("mothers_last_name");
				$student_data["mothers_middle_name"] = $this->input->post("mothers_middle_name");
				$student_data["mothers_first_name"] = $this->input->post("mothers_first_name");
				$student_data["mothers_contact_number"] = $this->input->post("mothers_contact_number");
				$student_data["mothers_address"] = $this->input->post("mothers_address");
				$student_data["is_living_with_parents"] = $this->input->post("is_living_with_parents");
				$student_data["fathers_name"] = $student_data["fathers_last_name"]." ".$student_data["fathers_middle_name"]." ".$student_data["fathers_middle_name"];
				$student_data["mothers_name"] = $student_data["mothers_last_name"]." ".$student_data["mothers_middle_name"]." ".$student_data["mothers_middle_name"];
				$bday_m = sprintf("%02d",$this->input->post("bday_m"));
				$bday_d = sprintf("%02d",$this->input->post("bday_d"));
				$bday_y = sprintf("%04d",$this->input->post("bday_y"));
				$birthdate_str = $bday_m."/".$bday_d."/".$bday_y;
				$student_data["birthdate"] = strtotime($birthdate_str);
				$data["compiled_errors"] = $compiled_errors;

				$data["is_successful"] = TRUE;
				$student_data = $this->students_model->add($student_data);

				if($has_uploaded_pic){
					rename($full_path,$file_path.$student_data->id."_".$file_name);
					$edit_data = array();
					$edit_data["display_photo"] = $student_data->id."_".$file_name;
					$this->students_model->edit_info($edit_data,$student_data->id);
				}

				$rfid_data["ref_id"] = $student_data->id;
				$rfid_data["ref_table"] = "students";
				$rfid_data["valid"] = 1;
				$this->rfid_model->add($rfid_data);

			}

			echo json_encode($data);
		}
		
	}

	public function edit($arg='')
	{
		if($_POST){
			$this->form_validation->set_rules('lrn_number', 'LRN Number', 'min_length[2]|max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('student_id', 'First Name', 'required|trim|htmlspecialchars|is_in_db[students.id]');
			$this->form_validation->set_rules('gender', 'Gender', 'required|max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('address', 'Address', 'required|min_length[2]|max_length[100]|trim|htmlspecialchars');
			$this->form_validation->set_rules('mothers_name', 'Mother&apos;s Name', 'max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('fathers_name', 'Father&apos;s Name', 'max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('first_name', 'First Name', 'required|is_unique_name[students.first_name.middle_name.last_name.student_id]|custom_alpha_dash|min_length[2]|max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('last_name', 'Last Name', 'required|custom_alpha_dash|min_length[2]|max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('middle_name', 'Middle Name', 'custom_alpha_dash|min_length[2]|max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('suffix', 'Suffix', 'custom_alpha_dash|min_length[2]|max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('bday_m', 'Birth Date', 'required|is_valid_date[bday_m.bday_d.bday_y]|trim|htmlspecialchars');
			$this->form_validation->set_rules('bday_d', 'Birth Date', 'required|is_valid_date[bday_m.bday_d.bday_y]|trim|htmlspecialchars');
			$this->form_validation->set_rules('bday_y', 'Birth Date', 'required|is_valid_date[bday_m.bday_d.bday_y]|trim|htmlspecialchars');
			$this->form_validation->set_rules('contact_number', 'Contact Number', 'numeric|min_length[11]|max_length[11]|trim|htmlspecialchars');
			$this->form_validation->set_rules('guardian_id', 'Guardian', 'is_in_db[guardians.id]|trim|htmlspecialchars');
			$this->form_validation->set_rules('class_id', 'Class', 'required|is_valid[classes.id]|trim|htmlspecialchars');
			$this->form_validation->set_message('is_in_db', 'An Error has occured please refresh the page and try again.');
			$this->form_validation->set_rules('age_as_of_august', 'Age as of August', 'numeric|max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('fathers_last_name', 'Father&apos;s Last Name', 'min_length[2]|max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('fathers_middle_name', 'Father&apos;s Middle Name', 'min_length[2]|max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('fathers_first_name', 'Father&apos;s First Name', 'min_length[2]|max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('fathers_contact_number', 'Father&apos;s Contact Number', 'numeric|min_length[11]|max_length[11]|trim|htmlspecialchars');
			$this->form_validation->set_rules('fathers_address', 'Mother&apos;s Address', 'min_length[2]|max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('mothers_last_name', 'Mother&apos;s Last Name', 'min_length[2]|max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('mothers_middle_name', 'Mother&apos;s Middle Name', 'min_length[2]|max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('mothers_first_name', 'Mother&apos;s First Name', 'min_length[2]|max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('mothers_contact_number', 'Mother&apos;s Contact Number', 'numeric|min_length[11]|max_length[11]|trim|htmlspecialchars');
			$this->form_validation->set_rules('mothers_address', 'Mother&apos;s Address', 'min_length[2]|max_length[50]|trim|htmlspecialchars');
			$get_data = array();
			$class_id = $this->input->post('class_id');
	    	$get_data["id"] = $class_id;
			$class_data = $this->classes_model->get_data($get_data);
			$grade = strtolower($class_data['grade']);
			if($grade == 'grade 1' || $grade == 'grade 2' || $grade == 'grade 3'){
				$this->form_validation->set_rules('mother_tongue', 'Mother Tongue', 'required|max_length[50]|trim|htmlspecialchars');
			}


			$get_data = array();
			$get_data["id"] = $this->input->post("student_id");
			$student_data_db = $this->students_model->get_data($get_data);

			$has_uploaded_pic = FALSE;

			//uploads files
			if($_FILES['student_photo']["error"]==0){

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
				$get_data["ref_id"] = $this->input->post("student_id");
				$get_data["ref_table"] = "students";
				$rfid_data = $this->rfid_model->get_data($get_data);
				

				$filename = $filename_full_name."_".$this->rfid_photo_model->add();



				$config['overwrite'] = TRUE;
				$config['upload_path'] = './assets/images/student_photo/';
				$config['allowed_types'] = '*';
				$config['file_name'] = $filename;
				$config['max_size']	= '20480';
				$this->load->library('upload', $config);
				if ( ! $this->upload->do_upload("student_photo"))
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


				$filename = $student_data_db["display_photo"];
			}

			if ($this->form_validation->run() == FALSE|| $data["is_valid_photo"] == FALSE)
			{
				$data["is_valid"] = FALSE;
				$data["lrn_number_error"] = form_error('lrn_number');
				$data["address_error"] = form_error('address');
				$data["gender_error"] = form_error('gender');
				$data["mothers_name_error"] = form_error('mothers_name');
				$data["fathers_name_error"] = form_error('fathers_name');
				$data["first_name_error"] = form_error('first_name');
				$data["last_name_error"] = form_error('last_name');
				$data["middle_name_error"] = form_error('middle_name');
				$data["suffix_error"] = form_error('suffix');
				$data["contact_number_error"] = form_error('contact_number');
				$data["bday_error"] = form_error('bday_m');
				$data["guardian_id_error"] = form_error('guardian_id');
				$data["class_id_error"] = form_error('class_id');
				$data["student_id_error"] = form_error('student_id');
				$data["mother_tongue_error"] = form_error('mother_tongue');
				$data["age_as_of_august_error"] = form_error('age_as_of_august');
				$data["fathers_last_name_error"] = form_error('fathers_last_name');
				$data["fathers_middle_name_error"] = form_error('fathers_middle_name');
				$data["fathers_first_name_error"] = form_error('fathers_first_name');
				$data["fathers_contact_number_error"] = form_error('fathers_contact_number');
				$data["fathers_address_error"] = form_error('fathers_address');
				$data["mothers_last_name_error"] = form_error('mothers_last_name');
				$data["mothers_middle_name_error"] = form_error('mothers_middle_name');
				$data["mothers_first_name_error"] = form_error('mothers_first_name');
				$data["mothers_contact_number_error"] = form_error('mothers_contact_number');
				$data["mothers_address_error"] = form_error('mothers_address');
				// echo validation_errors();
			}
			else
			{
				$data["is_valid"] = TRUE;
				$data["lrn_number_error"] = "";
				$data["first_name_error"] = "";
				$data["address_error"] = "";
				$data["gender_error"] = "";
				$data["mothers_name_error"] = "";
				$data["fathers_name_error"] = "";
				$data["last_name_error"] = "";
				$data["middle_name_error"] = "";
				$data["suffix_error"] = "";
				$data["contact_number_error"] = "";
				$data["bday_error"] = "";
				$data["guardian_id_error"] = "";
				$data["class_id_error"] = "";
				$data["mother_tongue_error"] = "";
				$data["age_as_of_august_error"] = "";
				$data["fathers_last_name_error"] = "";
				$data["fathers_middle_name_error"] = "";
				$data["fathers_first_name_error"] = "";
				$data["fathers_contact_number_error"] = "";
				$data["fathers_address_error"] = "";
				$data["mothers_last_name_error"] = "";
				$data["mothers_middle_name_error"] = "";
				$data["mothers_first_name_error"] = "";
				$data["mothers_contact_number_error"] = "";
				$data["mothers_address_error"] = "";

				$student_data["first_name"] = $this->input->post("first_name");
				$student_data["lrn_number"] = $this->input->post("lrn_number");
				$student_data["address"] = $this->input->post("address");
				$student_data["gender"] = $this->input->post("gender");
				$student_data["mothers_name"] = $this->input->post("mothers_name");
				$student_data["fathers_name"] = $this->input->post("fathers_name");
				$student_data["last_name"] = $this->input->post("last_name");
				$student_data["middle_name"] = $this->input->post("middle_name");
				$student_data["suffix"] = $this->input->post("suffix");
				$student_data["contact_number"] = $this->input->post("contact_number");
				$student_data["guardian_id"] = $this->input->post("guardian_id");
				$student_data["class_id"] = $this->input->post("class_id");
				$student_data["display_photo"] = $filename;
				$bday_m = sprintf("%02d",$this->input->post("bday_m"));
				$bday_d = sprintf("%02d",$this->input->post("bday_d"));
				$bday_y = sprintf("%04d",$this->input->post("bday_y"));
				$birthdate_str = $bday_m."/".$bday_d."/".$bday_y;
				$student_data["birthdate"] = strtotime($birthdate_str);
				$student_data["age_as_of_august"] = $this->input->post("age_as_of_august");
				$student_data["mother_tongue"] = $this->input->post("mother_tongue");
				$student_data["ethnic_group"] = $this->input->post("ethnic_group");
				$student_data["religion"] = $this->input->post("religion");
				$student_data["is_transferee"] = $this->input->post("is_transferee");
				$student_data["last_school_attended"] = $this->input->post("last_school_attended");
				$student_data["last_year_attended"] = $this->input->post("last_year_attended");
				$student_data["last_grade_attended"] = $this->input->post("last_grade_attended");
				$student_data["last_track_strand"] = $this->input->post("last_track_strand");
				$student_data["academic_track"] = $this->input->post("academic_track");
				$student_data["tech_voc_track"] = $this->input->post("tech_voc_track");
				$student_data["fathers_last_name"] = $this->input->post("fathers_last_name");
				$student_data["fathers_middle_name"] = $this->input->post("fathers_middle_name");
				$student_data["fathers_first_name"] = $this->input->post("fathers_first_name");
				$student_data["fathers_contact_number"] = $this->input->post("fathers_contact_number");
				$student_data["fathers_address"] = $this->input->post("fathers_address");
				$student_data["mothers_last_name"] = $this->input->post("mothers_last_name");
				$student_data["mothers_middle_name"] = $this->input->post("mothers_middle_name");
				$student_data["mothers_first_name"] = $this->input->post("mothers_first_name");
				$student_data["mothers_contact_number"] = $this->input->post("mothers_contact_number");
				$student_data["mothers_address"] = $this->input->post("mothers_address");
				$student_data["is_living_with_parents"] = $this->input->post("is_living_with_parents");
				$student_data["fathers_name"] = $student_data["fathers_last_name"]." ".$student_data["fathers_middle_name"]." ".$student_data["fathers_middle_name"];
				$student_data["mothers_name"] = $student_data["mothers_last_name"]." ".$student_data["mothers_middle_name"]." ".$student_data["mothers_middle_name"];

				($this->students_model->edit_info($student_data,$this->input->post("student_id"))?$data["is_successful"] = TRUE:$data["is_successful"] = FALSE);

				if($has_uploaded_pic){
					if(file_exists("assets/images/student_photo/".$student_data_db["display_photo"])){
						if($student_data_db["display_photo"]!='empty.jpg'){
							unlink("assets/images/student_photo/".$student_data_db["display_photo"]);
						}
					}
					$student_id = $this->input->post("student_id");
					rename($full_path,$file_path.$student_id."_".$file_name);
					$edit_data = array();
					$edit_data["display_photo"] = $student_id."_".$file_name;
					$this->students_model->edit_info($edit_data,$student_id);
				}

			}
			echo json_encode($data);
		}

	}

	public function get_data($arg='')
	{


		if($arg=="jbtech"){
			
			$student_data["id"] = $this->input->get("student_id");
			$student_data = $this->students_model->get_data($student_data);
			$student_data["id"] = sprintf("%03d",$this->input->get("student_id"));
			$student_data["birthday"] = date("m/d/Y",$student_data["birthdate"]);
			$student_data["middle_initial"] = ($student_data["middle_name"]==""?"":$student_data["middle_name"][0].". ");
			$student_data["full_name"] = $student_data["first_name"]." ".$student_data["middle_initial"]." ".$student_data["last_name"]." ".$student_data["suffix"];;
			$student_data["age"] = age($student_data["birthdate"]);

			if($student_data["guardian_id"] != 0){
				$get_data = array();
				$get_data["id"] = $student_data["guardian_id"];
				$student_data["guardian_data"] = $this->guardian_model->get_data($get_data);
				$student_data["guardian_name"] = $student_data["guardian_data"]["name"];
				$student_data["guardian_address"] = $student_data["guardian_data"]["guardian_address"];
				$student_data["guardian_contact_number"] = $student_data["guardian_data"]["contact_number"];
			}else{
				$student_data["guardian_name"] = "";
				$student_data["guardian_address"] = "";
				$student_data["guardian_contact_number"] = "";
			}

			if($student_data["class_id"] != 0){
				$get_data = array();
				$get_data["id"] = $student_data["class_id"];
				$student_data["class_data"] = $this->classes_model->get_data($get_data);
				$student_data["class_name"] = $student_data["class_data"]["class_name"];
				$student_data["grade"] = $student_data["class_data"]["grade"];

				if($student_data["class_data"]["teacher_id"] != 0){
					$get_data = array();
					$get_data["id"] = $student_data["class_data"]["teacher_id"];
					$student_data["class_data"]["teacher_data"] = $this->teachers_model->get_data($get_data);
					$student_data["class_data"]["teacher_data"]["middle_initial"] = ($student_data["class_data"]["teacher_data"]["middle_name"]==""?"":$student_data["class_data"]["teacher_data"]["middle_name"][0].". ");
					$student_data["class_adviser"] = $student_data["class_data"]["teacher_data"]["first_name"]." ".$student_data["class_data"]["teacher_data"]["middle_initial"].". ".$student_data["class_data"]["teacher_data"]["last_name"]." ".$student_data["class_data"]["teacher_data"]["suffix"];
				}else{
					$student_data["class_adviser"] = "";
				}

			}else{
				$student_data["class_name"] = "";
				$student_data["grade"] = "";
				$student_data["class_adviser"] = "";
			}
			echo json_encode($student_data);
		}else{

			$student_data["id"] = $this->input->get("student_id");
			$student_data = $this->students_model->get_data($student_data);
			$student_data["bday_m"] = date("n",$student_data["birthdate"]);
			$student_data["bday_d"] = date("j",$student_data["birthdate"]);
			$student_data["bday_y"] = date("Y",$student_data["birthdate"]);
			($student_data["guardian_id"]==0?$student_data["guardian_id"]="":FALSE);
			($student_data["class_id"]==0?$student_data["class_id"]="":FALSE);
			echo json_encode($student_data);
		}
	}

	public function delete()
	{
		if($_POST){
			$data["deleted"] = 1;
			$this->students_model->edit_info($data,$this->input->post("id"));

			$edit_data["ref_id"] = $this->input->post("id");
			$edit_data["ref_table"] = "students";
			$this->rfid_model->edit_info($data,$edit_data);

			$get_data = array();
			$get_data["id"] = $this->input->post("id");
			echo json_encode($this->students_model->get_data($get_data));
		}
	}


	public function get_list($arg='')
	{
		$where = "";
		if($arg=="teachers"){

			$where["class_id"] = $this->input->get("class_id_");

			$where["deleted"] = 0;
			$data = $this->students_model->get_list($where,1,$this->db->get_where("students",$where)->num_rows());

			foreach ($data["result"] as $student_data) {
				$student_data->middle_initial = ($student_data->middle_name==""?"":$student_data->middle_name[0].". ");
				$student_data->full_name = $student_data->last_name.", ".$student_data->first_name." ".$student_data->middle_initial.$student_data->suffix;
			}
			echo json_encode($data["result"]);
		}elseif ($arg=="admin") {

			if($this->input->get("class_id")){
				$where["class_id"] = $this->input->get("class_id");
			}
			$where["deleted"] = 0;
			$data = $this->students_model->get_list($where,1,$this->db->get_where("students",$where)->num_rows());

			foreach ($data["result"] as $student_data) {
				$student_data->middle_initial = ($student_data->middle_name==""?"":$student_data->middle_name[0].". ");
				$student_data->full_name = $student_data->last_name.", ".$student_data->first_name." ".$student_data->middle_initial.$student_data->suffix;
			}
			echo json_encode($data["result"]);
			
		}elseif ($arg=="jbtech") {

			if($this->input->get("class_id")){
				$where["class_id"] = $this->input->get("class_id");
			}
			$where["deleted"] = 0;
			$data = $this->students_model->get_list($where,1,$this->db->get_where("students",$where)->num_rows());

			foreach ($data["result"] as $student_data) {
				$student_data->middle_initial = ($student_data->middle_name==""?"":$student_data->middle_name[0].". ");
				$student_data->full_name = $student_data->last_name.", ".$student_data->first_name." ".$student_data->middle_initial.$student_data->suffix;
			}
			echo json_encode($data["result"]);
			
		}
	}

	public function download($arg='')
	{
		$where = "";
		$fp = fopen('students.csv', 'w');

		$headers = array (
			'id',
			'lrn',
			'First Name',
			'Middle Name',
			'Last Name',
			'Suffix',
			'Contact Number',
			'Gender',
			'Birthdate',
			'Age as of August 31st (of the current year)',
			'Mother Tongue',
			'Ethnic Group',
			'Religion',
			'Complete Address',
			'Transferee?',
			'Last School Attended',
			'Last Year Attended',
			'Last Grade Level',
			'Last Track - Strand',
			'Academic Track',
			'Technical-Vocational Livelihood Track',
			"Father's First Name",
			"Father's Middle Name",
			"Father's Last Name",
			"Father's Contact Number",
			"Father's Complete Address",
			"Mother's First Name",
			"Mother's Middle Name",
			"Mother's Last Name",
			"Mother's Contact Number",
			"Mother's Complete Address",
			'Living with Parents?',
			"Guardian's First Name",
			"Guardian's Middle Name",
			"Guardian's Last Name",
			"Guardian's Contact Number",
			"Guardian's Complete Address",
			'Class',
			'Grade or Year'
			);
	    fputcsv($fp, $headers);
	    if($this->input->get("class_id")&&$this->input->get("class_id")!=""){
	    	$where["class_id"] = $this->input->get("class_id");
	    	$where["deleted"] = 0;
	    }
	    $student_list = $this->students_model->get_list($where,1,$this->db->get("students")->num_rows());
	    foreach ($student_list["result"] as $student_data) {
	    	$get_data = array();
	    	$get_data["id"] = $student_data->guardian_id;
	    	$guardian_data = $this->guardian_model->get_data($get_data);
	    	$get_data = array();
	    	$get_data["id"] = $student_data->class_id;
	    	$class_data = $this->classes_model->get_data($get_data);
		    $records = array(
		    	sprintf("%03d",$student_data->id),
		    	$student_data->lrn_number,
		    	$student_data->first_name,
		    	$student_data->middle_name,
		    	$student_data->last_name,
		    	$student_data->suffix,
		    	$student_data->contact_number,
		    	$student_data->gender,
		    	date("m/d/Y",$student_data->birthdate),
		    	$student_data->age_as_of_august,
		    	$student_data->mother_tongue,
		    	$student_data->ethnic_group,
		    	$student_data->religion,
		    	$student_data->address,
		    	($student_data->is_transferee == 1 ? "yes" : "no"),
		    	$student_data->last_school_attended,
		    	$student_data->last_year_attended,
		    	$student_data->last_grade_attended,
		    	$student_data->last_track_strand,
		    	$student_data->academic_track,
				$student_data->tech_voc_track,
				$student_data->fathers_first_name,
				$student_data->fathers_middle_name,
				$student_data->fathers_last_name,
				$student_data->fathers_contact_number,
				$student_data->fathers_address,
				$student_data->mothers_first_name,
				$student_data->mothers_middle_name,
				$student_data->mothers_last_name,
				$student_data->mothers_contact_number,
				$student_data->mothers_address,
				($student_data->is_living_with_parents == 1 ? "yes" : "no"),
		    	$guardian_data["first_name"],
		    	$guardian_data["middle_name"],
		    	$guardian_data["last_name"],
		    	$guardian_data["contact_number"],
		    	$guardian_data["guardian_address"],
		    	$class_data["class_name"],
		    	$class_data["grade"]
		    	);
		    fputcsv($fp, $records);
	    }
		fclose($fp);
		echo base_url("students.csv");
	}

	public function add_fetcher()
	{
		# code...
	}

	public function upload()
	{
		$config['allowed_types'] = 'csv';
		$config['overwrite'] = true;
		$config['file_name'] = "uploaded-student-csv.csv";
		$config['upload_path'] = './uploads/';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('student_csv'))
		{
			$error = array('error' => $this->upload->display_errors());
			$this->output->set_status_header(422);
			echo json_encode($error);
			// $this->load->view('upload_form', $error);
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
			$file = fopen(base_url("uploads/".$data['upload_data']["orig_name"]),"r");
			$iterations = 0;
			$columns = array();
			$rows = array();
			while(! feof($file))
			{
				$student_data_array = fgetcsv($file);
				if($iterations == 0){
					if($student_data_array!=array()){
						foreach ($student_data_array as $key => $labels) {
							if($labels != "" && $this->label_to_column_name($labels)!=false){
								$columns[] = [
									"value" => $this->label_to_column_name($labels),
									"key" => $key,
									"name" => $labels
								];
							}
						}
					}
					$index = 0;
				}else{
					$is_not_empty = true;
					foreach ($student_data_array as $value) {
						if($value!=""){
							$is_not_empty = false;
							break;
						}
					}
					if(!$is_not_empty){
						if($student_data_array!=array()){
							foreach ($student_data_array as $row) {
								$rows[$index][] = strtoupper($row)=="NA" || strtoupper($row)=="N/A" ?"":$row;
							}
							$index++;
						}
					}
				}
				$iterations++;
			}
			fclose($file);
			$exported_data = array();
			$index = 0;
			if($columns==array()){
				$error = array('error' => ["File is not valid"]);
				$this->output->set_status_header(422);
				echo json_encode($error);
				exit;
			}
			foreach ($rows as $key => $row) {
				$exported_data[$key] = array();
				for ($i=0; $i < count($columns); $i++) {
					$columns[$i]['value'] = (string)$columns[$i]['value'];
					if($columns[$i]['value'] == 'birthdate'){
						$exploded_birthdate = explode('/',$row[$columns[$i]['key']]);
						if(checkdate($exploded_birthdate[0],$exploded_birthdate[1],$exploded_birthdate[2])){
							$exported_data[$key]['bday_m'] = $exploded_birthdate[0];
							$exported_data[$key]['bday_d'] = $exploded_birthdate[1];
							$exported_data[$key]['bday_y'] = $exploded_birthdate[2];
						}
					}
					if($columns[$i]['value'] == 'class_name'){
						$class_name = $row[$columns[$i]['key']];
						$get_data = array();
						$get_data["class_name"] = $class_name;
						$get_data["deleted"] = 0;
						$class_data = $this->classes_model->get_data($get_data,TRUE);
						if($class_data){
							$exported_data[$key]['class_id'] = $class_data->id;
						}
					}
					if($columns[$i]['value'] == 'guardian_contact_number'){
						$guardian_contact_number = $row[$columns[$i]['key']];
						$get_data = array();
						$get_data["contact_number"] = $guardian_contact_number;
						$get_data["deleted"] = 0;
						$guardian_data = $this->guardian_model->get_data($get_data,TRUE);
						if($guardian_data){
							$exported_data[$key]['guardian_id'] = $guardian_data->id;
						}
					}
					$exported_data[$key][$columns[$i]['value']] = $row[$columns[$i]['key']];
				}
				$get_data = array();
				$get_data["first_name"] = $exported_data[$key]['first_name'];
				$get_data["middle_name"] = $exported_data[$key]['middle_name'];
				$get_data["last_name"] = $exported_data[$key]['last_name'];
				if($this->students_model->get_data($get_data) != null){
					unset($exported_data[$key]);
				}
				// $index++;
			}
			$result = [
				'exported_data' => array_values($exported_data),
				'columns' => $columns
			];
			
			echo $this->safe_json_encode($result);
		}
	}

	private function safe_json_encode($value, $options = 0, $depth = 512){
		$encoded = json_encode($value, $options, $depth);
		switch (json_last_error()) {
			case JSON_ERROR_NONE:
				return $encoded;
			case JSON_ERROR_DEPTH:
				return 'Maximum stack depth exceeded'; // or trigger_error() or throw new Exception()
			case JSON_ERROR_STATE_MISMATCH:
				return 'Underflow or the modes mismatch'; // or trigger_error() or throw new Exception()
			case JSON_ERROR_CTRL_CHAR:
				return 'Unexpected control character found';
			case JSON_ERROR_SYNTAX:
				return 'Syntax error, malformed JSON'; // or trigger_error() or throw new Exception()
			case JSON_ERROR_UTF8:
				$clean = $this->utf8ize($value);
				return $this->safe_json_encode($clean, $options, $depth);
			default:
				return 'Unknown error'; // or trigger_error() or throw new Exception()

		}
	}

	private function utf8ize($d) {
		if (is_array($d)) {
			foreach ($d as $k => $v) {
				$d[$k] = $this->utf8ize($v);
			}
		} else if (is_string ($d)) {
			return utf8_encode($d);
		}
		return $d;
	}

	public function validate_upload()
	{
		if ($_POST) {
			$compiled_errors = array();
			$this->form_validation->set_rules('address', 'Address', 'required|min_length[2]|max_length[100]|trim|htmlspecialchars');
			$this->form_validation->set_rules('lrn_number', 'LRN Number', 'min_length[2]|max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('gender', 'Gender', 'required|max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('mothers_name', 'Mother&apos;s Name', 'max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('fathers_name', 'Father&apos;s Name', 'max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('first_name', 'First Name', 'required|is_unique_name[students.first_name.middle_name.last_name.NULL]|custom_alpha_dash|min_length[2]|max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('last_name', 'Last Name', 'required|custom_alpha_dash|min_length[2]|max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('middle_name', 'Middle Name', 'custom_alpha_dash|min_length[2]|max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('suffix', 'Suffix', 'custom_alpha_dash|min_length[2]|max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('contact_number', 'Contact Number', 'numeric|min_length[11]|max_length[11]|trim|htmlspecialchars');
			$this->form_validation->set_rules('bday_m', 'Birth Date', 'required|is_valid_date[bday_m.bday_d.bday_y]|trim|htmlspecialchars');
			$this->form_validation->set_rules('bday_d', 'Birth Date', 'required|is_valid_date[bday_m.bday_d.bday_y]|trim|htmlspecialchars');
			$this->form_validation->set_rules('bday_y', 'Birth Date', 'required|is_valid_date[bday_m.bday_d.bday_y]|trim|htmlspecialchars');
			if($this->input->post('guardian_contact_number') || $this->input->post('guardian_first_name') ||  $this->input->post('guardian_last_name')){
				$this->form_validation->set_rules('guardian_id', 'Guardian', 'required|is_in_db[guardians.id]|trim|htmlspecialchars');
			}else{
				$this->form_validation->set_rules('guardian_id', 'Guardian', 'is_in_db[guardians.id]|trim|htmlspecialchars');
			}
			$this->form_validation->set_rules('class_id', 'Class', 'required|is_valid[classes.id]|trim|htmlspecialchars');
			$this->form_validation->set_rules('age_as_of_august', 'Age as of August', 'numeric|max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('fathers_last_name', 'Father&apos;s Last Name', 'min_length[2]|max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('fathers_middle_name', 'Father&apos;s Middle Name', 'min_length[2]|max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('fathers_first_name', 'Father&apos;s First Name', 'min_length[2]|max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('fathers_contact_number', 'Father&apos;s Contact Number', 'numeric|min_length[11]|max_length[11]|trim|htmlspecialchars');
			$this->form_validation->set_rules('fathers_address', 'Mother&apos;s Address', 'min_length[2]|max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('mothers_last_name', 'Mother&apos;s Last Name', 'min_length[2]|max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('mothers_middle_name', 'Mother&apos;s Middle Name', 'min_length[2]|max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('mothers_first_name', 'Mother&apos;s First Name', 'min_length[2]|max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('mothers_contact_number', 'Mother&apos;s Contact Number', 'numeric|min_length[11]|max_length[11]|trim|htmlspecialchars');
			$this->form_validation->set_rules('mothers_address', 'Mother&apos;s Address', 'min_length[2]|max_length[50]|trim|htmlspecialchars');

			$grade = $this->input->post('grade');
			if($grade == 'grade 1' || $grade == 'grade 2' || $grade == 'grade 3'){
				$this->form_validation->set_rules('mother_tongue', 'Mother Tongue', 'required|max_length[50]|trim|htmlspecialchars');
			}

			$this->form_validation->set_message('is_in_db', 'This account is invalid');

			if ($this->form_validation->run() == FALSE)
			{
				$errors["lrn_number_error"] = form_error('lrn_number');
				$errors["address_error"] = form_error('address');
				$errors["gender_error"] = form_error('gender');
				$errors["mothers_name_error"] = form_error('mothers_name');
				$errors["fathers_name_error"] = form_error('fathers_name');
				$errors["first_name_error"] = form_error('first_name');
				$errors["last_name_error"] = form_error('last_name');
				$errors["middle_name_error"] = form_error('middle_name');
				$errors["suffix_error"] = form_error('suffix');
				$errors["bday_error"] = form_error('bday_m');
				$errors["guardian_id_error"] = form_error('guardian_id') != "" ? "Guardian is not registered." : "";
				$errors["class_id_error"] = form_error('class_id') != "" ? "Class is not registered." : "";
				$errors["contact_number_error"] = form_error('contact_number');
				$errors["mother_tongue_error"] = form_error('mother_tongue');
				$errors["age_as_of_august_error"] = form_error('age_as_of_august');
				$errors["fathers_last_name_error"] = form_error('fathers_last_name');
				$errors["fathers_middle_name_error"] = form_error('fathers_middle_name');
				$errors["fathers_first_name_error"] = form_error('fathers_first_name');
				$errors["fathers_contact_number_error"] = form_error('fathers_contact_number');
				$errors["fathers_address_error"] = form_error('fathers_address');
				$errors["mothers_last_name_error"] = form_error('mothers_last_name');
				$errors["mothers_middle_name_error"] = form_error('mothers_middle_name');
				$errors["mothers_first_name_error"] = form_error('mothers_first_name');
				$errors["mothers_contact_number_error"] = form_error('mothers_contact_number');
				$errors["mothers_address_error"] = form_error('mothers_address');
				$data['is_valid'] = FALSE;
				foreach ($errors as $value) {
					if($value!=""){
						$compiled_errors[] = $value;
					}
				}
				$data["need_to_add_guardian"] = $errors["guardian_id_error"]!="";
				$data["need_to_add_class"] = $errors["class_id_error"]!="";
				$data["compiled_errors"] = $compiled_errors;
			}
			else
			{
				$data["is_valid"] = TRUE;
				$data["lrn_number_error"] = "";
				$data["address_error"] = "";
				$data["gender_error"] = "";
				$data["mothers_name_error"] = "";
				$data["fathers_name_error"] = "";
				$data["first_name_error"] = "";
				$data["last_name_error"] = "";
				$data["middle_name_error"] = "";
				$data["suffix_error"] = "";
				$data["bday_error"] = "";
				$data["guardian_id_error"] = "";
				$data["class_id_error"] = "";
				$data["contact_number_error"] = "";
				$data["mother_tongue_error"] = "";
				$data["age_as_of_august"] = "";
				$data["fathers_last_name_error"] = "";
				$data["fathers_middle_name_error"] = "";
				$data["fathers_first_name_error"] = "";
				$data["fathers_contact_number_error"] = "";
				$data["fathers_address_error"] = "";
				$data["mothers_last_name_error"] = "";
				$data["mothers_middle_name_error"] = "";
				$data["mothers_first_name_error"] = "";
				$data["mothers_contact_number_error"] = "";
				$data["mothers_address_error"] = "";
				$data["need_to_add_guardian"] = $data["guardian_id_error"]!="";
				$data["need_to_add_class"] = $data["class_id_error"]!="";
				$data["compiled_errors"] = $compiled_errors;
			}
			echo json_encode($data);
		}
	}

	private function label_to_column_name($label)
	{
		$label = strtolower($label);
		switch ($label) {
			case 'lrn':
				return "lrn_number";
				break;
			case 'first name':
				return "first_name";
				break;
			case 'middle name':
				return "middle_name";
				break;
			case 'last name':
				return "last_name";
				break;
			case 'suffix':
				return "suffix";
				break;
			case 'middle name':
				return "middle_name";
				break;
			case 'contact number':
				return "contact_number";
				break;
			case 'gender':
				return "gender";
				break;
			case 'birthdate':
				return "birthdate";
				break;
			case 'age as of august 31st (of the current year)':
				return "age_as_of_august";
				break;
			case 'mother tongue':
				return "mother_tongue";
				break;
			case 'ethnic group':
				return "ethnic_group";
				break;
			case 'religion':
				return "religion";
				break;
			case 'complete address':
				return "address";
				break;
			case 'transferee?':
				return "is_transferee";
				break;
			case 'last school attended':
				return "last_school_attended";
				break;
			case 'last year attended':
				return "last_year_attended";
				break;
			case 'last grade level':
				return "last_grade_attended";
				break;
			case 'last track - strand':
				return "last_track_strand";
				break;
			case 'academic track':
				return "academic_track";
				break;
			case 'technical-vocational livelihood track':
				return "tech_voc_track";
				break;
			case "father's first name":
				return "fathers_first_name";
				break;
			case "father's middle name":
				return "fathers_middle_name";
				break;
			case "father's last name":
				return "fathers_last_name";
				break;
			case "father's contact number":
				return "fathers_contact_number";
				break;
			case "father's complete address":
				return "fathers_address";
				break;
			case "mother's first name":
				return "mothers_first_name";
				break;
			case "mother's middle name":
				return "mothers_middle_name";
				break;
			case "mother's last name":
				return "mothers_last_name";
				break;
			case "mother's contact number":
				return "mothers_contact_number";
				break;
			case "mother's complete address":
				return "mothers_address";
				break;
			case "living with parents?":
				return "is_living_with_parents";
				break;
			case "guardian's first name":
				return "guardian_first_name";
				break;
			case "guardian's middle name":
				return "guardian_middle_name";
				break;
			case "guardian's last name":
				return "guardian_last_name";
				break;
			case "guardian's complete address":
				return "guardian_address";
				break;
			case "guardian's contact number":
				return "guardian_contact_number";
				break;
			case "class":
				return "class_name";
				break;
			case "grade or year":
				return "grade";
				break;
			default:
				return false;
				break;
		}
	}

}