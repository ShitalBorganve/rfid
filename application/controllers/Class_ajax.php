<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Class_ajax extends CI_Controller {

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
		$this->load->helper('string');


		//models
		$this->load->model('guardian_model');
		$this->load->model("admin_model");
		$this->load->model("students_model");
		$this->load->model("gate_logs_model");
		$this->load->model("canteen_model");
		$this->load->model("classes_model");
		$this->load->model("canteen_items_model");

		$this->load->library('form_validation');
		$this->load->library('session');
		
		$this->form_validation->set_error_delimiters('', '');
	}

	public function add($arg='')
	{
		$this->form_validation->set_rules('class_adviser', 'Class Adviser', 'trim|htmlspecialchars');
		$this->form_validation->set_rules('class_name', 'Class Name', 'required|max_length[50]|trim|htmlspecialchars');
		$this->form_validation->set_rules('class_room', 'Classroom', 'required|max_length[50]|trim|htmlspecialchars');
		$this->form_validation->set_rules('class_schedule', 'Class Schedule', 'required|max_length[50]|trim|htmlspecialchars');
		$this->form_validation->set_message('is_in_db', 'This Teacher is invalid');

		$data["class_adviser_error"] = "";
		$data["class_name_error"] = "";
		$data["class_room_error"] = "";
		$data["class_schedule_error"] = "";
		if ($this->form_validation->run() == FALSE){
			$data["is_valid"] = FALSE;
			$data["class_adviser_error"] = form_error("class_adviser");
			$data["class_name_error"] = form_error("class_name");
			$data["class_room_error"] = form_error("class_room");
			$data["class_schedule_error"] = form_error("class_schedule");
		}else{
			$insert_data["class_name"] = $this->input->post("class_name");
			$insert_data["teacher_id"] = $this->input->post("class_adviser");
			$insert_data["schedule"] = $this->input->post("class_schedule");
			$insert_data["room"] = $this->input->post("class_room");
			$data["is_valid"] = $this->classes_model->add($insert_data);
		}
		echo json_encode($data);
	}

	public function get_data($value='')
	{
		if($_POST){
			$class_data["id"] = $this->input->post("class_id");
			$class_data = $this->classes_model->get_data($class_data);
			($class_data["class_id"]==0?$class_data["id"]="":FALSE);
			echo json_encode($class_data);
		}
	}
}