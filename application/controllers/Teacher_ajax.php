<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Teacher_ajax extends CI_Controller {

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
		$this->load->model("teachers_model");
		$this->load->model("teachers_model");
		$this->load->model("gate_logs_model");
		$this->load->model("rfid_model");
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

			// $data["guardian_id"] = $this->input->post("guardian_id");
			// $data["class_id"] = $this->input->post("class_id");

			$this->form_validation->set_rules('first_name', 'First Name', 'required|custom_alpha_dash|min_length[2]|max_length[50]trim|htmlspecialchars');
			$this->form_validation->set_rules('last_name', 'Last Name', 'required|custom_alpha_dash|min_length[2]|max_length[50]trim|htmlspecialchars');
			$this->form_validation->set_rules('middle_name', 'Middle Name', 'required|custom_alpha_dash|min_length[2]|max_length[50]trim|htmlspecialchars');
			$this->form_validation->set_rules('suffix', 'Suffix', 'custom_alpha_dash|min_length[2]|max_length[50]trim|htmlspecialchars');
			$this->form_validation->set_rules('bday_m', 'Birth Date', 'required|is_valid_date[bday_m.bday_d.bday_y]|trim|htmlspecialchars');
			$this->form_validation->set_rules('bday_d', 'Birth Date', 'required|is_valid_date[bday_m.bday_d.bday_y]|trim|htmlspecialchars');
			$this->form_validation->set_rules('bday_y', 'Birth Date', 'required|is_valid_date[bday_m.bday_d.bday_y]|trim|htmlspecialchars');
			$this->form_validation->set_rules('class_id', 'Class', 'trim|htmlspecialchars');

			$this->form_validation->set_message('is_in_db', 'This account is invalid');




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

				$filename = $this->input->post("rfid")."_".$filename_full_name;



				$config['overwrite'] = TRUE;
				$config['upload_path'] = './assets/images/teacher_photo/';
				$config['allowed_types'] = 'gif|jpg|png';
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
					$data["photo_error"] = "";
					$data["is_valid_photo"] = TRUE;
					$image_data = $this->upload->data();
					$filename = $filename.$image_data["file_ext"];
					$image_data = $this->upload->data();
					$config['image_library'] = 'gd2';
					$config['source_image'] = $image_data["full_path"]; 
					$config['create_thumb'] = FALSE;
					$config['new_image'] = $filename;
					$config['maintain_ratio'] = TRUE;
					$config['width']     = 360;
					$config['height']   = 360;
					$this->load->library('image_lib', $config); 
					$this->image_lib->resize();
					$this->image_lib->clear();
				}
			}else{
				$data["is_valid_photo"] = TRUE;
				$filename = "empty.jpg";				
			}

			if ($this->form_validation->run() == FALSE|| $data["is_valid_photo"] == FALSE)
			{
				$data["is_valid"] = FALSE;
				$data["first_name_error"] = form_error('first_name');
				$data["last_name_error"] = form_error('last_name');
				$data["middle_name_error"] = form_error('middle_name');
				$data["suffix_error"] = form_error('suffix');
				$data["class_id_error"] = form_error('class_id');
				$data["bday_error"] = form_error('bday_m');
			}
			else
			{
				$data["is_valid"] = TRUE;
				$data["first_name_error"] = "";
				$data["last_name_error"] = "";
				$data["middle_name_error"] = "";
				$data["suffix_error"] = "";
				$data["class_id_error"] = "";
				$data["bday_error"] = "";

				$teacher_data["first_name"] = $this->input->post("first_name");
				$teacher_data["last_name"] = $this->input->post("last_name");
				$teacher_data["middle_name"] = $this->input->post("middle_name");
				$teacher_data["suffix"] = $this->input->post("suffix");
				$teacher_data["class_id"] = $this->input->post("class_id");
				$teacher_data["display_photo"] = $filename;
				// $teacher_data["display_photo_type"] = $new_image_data['file_type'];
				$bday_m = sprintf("%02d",$this->input->post("bday_m"));
				$bday_d = sprintf("%02d",$this->input->post("bday_d"));
				$bday_y = sprintf("%04d",$this->input->post("bday_y"));
				$birthdate_str = $bday_m."/".$bday_d."/".$bday_y;
				$teacher_data["birthdate"] = strtotime($birthdate_str);

				// $teacher_data["rfid"] = $this->input->post("rfid");
				$data["is_successful"] = TRUE;
				$teacher_data = $this->teachers_model->add($teacher_data);

				$rfid_data["rfid"] = $this->input->post("rfid");
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


			// $data["guardian_id"] = $this->input->post("guardian_id");
			// $data["class_id"] = $this->input->post("class_id");

			$this->form_validation->set_rules('teacher_id', 'First Name', 'required|trim|htmlspecialchars|is_in_db[teachers.id]');
			$this->form_validation->set_rules('first_name', 'First Name', 'required|custom_alpha_dash|min_length[2]|max_length[50]trim|htmlspecialchars');
			$this->form_validation->set_rules('last_name', 'Last Name', 'required|custom_alpha_dash|min_length[2]|max_length[50]trim|htmlspecialchars');
			$this->form_validation->set_rules('middle_name', 'Middle Name', 'required|custom_alpha_dash|min_length[2]|max_length[50]trim|htmlspecialchars');
			$this->form_validation->set_rules('suffix', 'Suffix', 'custom_alpha_dash|min_length[2]|max_length[50]trim|htmlspecialchars');
			$this->form_validation->set_rules('bday_m', 'Birth Date', 'required|is_valid_date[bday_m.bday_d.bday_y]|trim|htmlspecialchars');
			$this->form_validation->set_rules('bday_d', 'Birth Date', 'required|is_valid_date[bday_m.bday_d.bday_y]|trim|htmlspecialchars');
			$this->form_validation->set_rules('bday_y', 'Birth Date', 'required|is_valid_date[bday_m.bday_d.bday_y]|trim|htmlspecialchars');
			$this->form_validation->set_rules('guardian_id', 'Guardian', 'is_in_db[guardians.id]|trim|htmlspecialchars');
			$this->form_validation->set_rules('class_id', 'Class', 'required|is_valid[classes.id]|trim|htmlspecialchars');

			$this->form_validation->set_message('is_in_db', 'An Error has occured please refresh the page and try again.');




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

				$filename = $this->input->post("rfid")."_".$filename_full_name;



				$config['overwrite'] = TRUE;
				$config['upload_path'] = './assets/images/teacher_photo/';
				$config['allowed_types'] = 'gif|jpg|png';
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
					$data["photo_error"] = "";
					$data["is_valid_photo"] = TRUE;
					$image_data = $this->upload->data();
					$filename = $filename.$image_data["file_ext"];
					$image_data = $this->upload->data();
					$config['image_library'] = 'gd2';
					$config['source_image'] = $image_data["full_path"]; 
				$data["guardian_id_error"] = form_error('guardian_id');
					$config['create_thumb'] = FALSE;
					$config['new_image'] = $filename;
					$config['maintain_ratio'] = TRUE;
					$config['width']     = 360;
					$config['height']   = 360;
					$this->load->library('image_lib', $config); 
					$this->image_lib->resize();
					$this->image_lib->clear();
				}
			}else{
				$data["is_valid_photo"] = TRUE;
				$filename = "empty.jpg";
				$get_data["id"] = $this->input->post("teacher_id");
				$teacher_data_db = $this->teachers_model->get_data($get_data);
				$filename = $teacher_data_db["display_photo"];
			}

			if ($this->form_validation->run() == FALSE|| $data["is_valid_photo"] == FALSE)
			{
				$data["is_valid"] = FALSE;
				$data["first_name_error"] = form_error('first_name');
				$data["last_name_error"] = form_error('last_name');
				$data["middle_name_error"] = form_error('middle_name');
				$data["suffix_error"] = form_error('suffix');
				$data["bday_error"] = form_error('bday_m');
				$data["guardian_id_error"] = form_error('guardian_id');
				$data["class_id_error"] = form_error('class_id');
				$data["teacher_id_error"] = form_error('teacher_id');
				// echo json_encode($data);
			}
			else
			{
				$data["is_valid"] = TRUE;
				$data["first_name_error"] = "";
				$data["last_name_error"] = "";
				$data["middle_name_error"] = "";
				$data["suffix_error"] = "";
				$data["bday_error"] = "";
				$data["guardian_id_error"] = "";
				$data["class_id_error"] = "";

				$teacher_data["first_name"] = $this->input->post("first_name");
				$teacher_data["last_name"] = $this->input->post("last_name");
				$teacher_data["middle_name"] = $this->input->post("middle_name");
				$teacher_data["suffix"] = $this->input->post("suffix");
				$teacher_data["class_id"] = $this->input->post("class_id");
				$teacher_data["guardian_id"] = $this->input->post("guardian_id");
				$teacher_data["display_photo"] = $filename;
				// $teacher_data["display_photo_type"] = $new_image_data['file_type'];
				$bday_m = sprintf("%02d",$this->input->post("bday_m"));
				$bday_d = sprintf("%02d",$this->input->post("bday_d"));
				$bday_y = sprintf("%04d",$this->input->post("bday_y"));
				$birthdate_str = $bday_m."/".$bday_d."/".$bday_y;
				$teacher_data["birthdate"] = strtotime($birthdate_str);

				($this->teachers_model->edit_info($teacher_data,$this->input->post("teacher_id"))?$data["is_successful"] = TRUE:$data["is_successful"] = FALSE);

			}
			// var_dump($this->teachers_model->edit_info($teacher_data,$this->input->post("teacher_id")));
			echo json_encode($data);

			
		}

	}

	public function get_data($value='')
	{
		$teacher_data["id"] = $this->input->get("teacher_id");
		$teacher_data = $this->teachers_model->get_data($teacher_data);
		$teacher_data["bday_m"] = date("n",$teacher_data["birthdate"]);
		$teacher_data["bday_d"] = date("j",$teacher_data["birthdate"]);
		$teacher_data["bday_y"] = date("Y",$teacher_data["birthdate"]);
		($teacher_data["class_id"]==0?$teacher_data["class_id"]="":FALSE);
		echo json_encode($teacher_data);
	}


}