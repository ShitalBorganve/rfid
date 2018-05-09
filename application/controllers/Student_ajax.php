<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student_ajax extends CI_Controller {


	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('app_helper');
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
		
		if($_POST){

			$this->form_validation->set_rules('address', 'Address', 'required|min_length[2]|max_length[100]|trim|htmlspecialchars');
			$this->form_validation->set_rules('lrn_number', 'LRN Number', 'min_length[2]|max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('gender', 'Gender', 'required|max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('mothers_name', 'Mother&apos;s Name', 'max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('fathers_name', 'Father&apos;s Name', 'max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('first_name', 'First Name', 'required|custom_alpha_dash|min_length[2]|max_length[50]|trim|htmlspecialchars');
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
				$student_data["fathers_name"] = $student_data["fathers_first_name"]." ".$student_data["fathers_middle_name"]." ".$student_data["fathers_middle_name"];
				$student_data["mothers_name"] = $student_data["mothers_first_name"]." ".$student_data["mothers_middle_name"]." ".$student_data["mothers_middle_name"];
				$bday_m = sprintf("%02d",$this->input->post("bday_m"));
				$bday_d = sprintf("%02d",$this->input->post("bday_d"));
				$bday_y = sprintf("%04d",$this->input->post("bday_y"));
				$birthdate_str = $bday_m."/".$bday_d."/".$bday_y;
				$student_data["birthdate"] = strtotime($birthdate_str);

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
			$this->form_validation->set_rules('first_name', 'First Name', 'required|custom_alpha_dash|min_length[2]|max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('gender', 'Gender', 'required|max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('address', 'Address', 'required|min_length[2]|max_length[100]|trim|htmlspecialchars');
			$this->form_validation->set_rules('mothers_name', 'Mother&apos;s Name', 'max_length[50]|trim|htmlspecialchars');
			$this->form_validation->set_rules('fathers_name', 'Father&apos;s Name', 'max_length[50]|trim|htmlspecialchars');
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
				$student_data["fathers_name"] = $student_data["fathers_first_name"]." ".$student_data["fathers_middle_name"]." ".$student_data["fathers_middle_name"];
				$student_data["mothers_name"] = $student_data["mothers_first_name"]." ".$student_data["mothers_middle_name"]." ".$student_data["mothers_middle_name"];

				($this->students_model->edit_info($student_data,$this->input->post("student_id"))?$data["is_successful"] = TRUE:$data["is_successful"] = FALSE);

				if($has_uploaded_pic){
					if(file_exists("assets/images/student_photo/".$student_data_db["display_photo"])){
						unlink("assets/images/student_photo/".$student_data_db["display_photo"]);
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
			'Last Name',
			'Middle Name',
			'First Name',
			'Suffix',
			'Gender',
			'Contact Number',
			'Birthdate',
			'Age',
			'Address',
			'Mothers Name',
			'Fathers Name',
			'Guardians Name',
			'Guardians Contact Number',
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
		    	$student_data->last_name,
		    	$student_data->middle_name,
		    	$student_data->first_name,
		    	$student_data->suffix,
		    	$student_data->gender,
		    	$student_data->contact_number,
		    	date("m/d/Y",$student_data->birthdate),
		    	age($student_data->birthdate),
		    	$student_data->address,
		    	$student_data->mothers_name,
		    	$student_data->fathers_name,
		    	$guardian_data["name"],
		    	$guardian_data["contact_number"],
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

}