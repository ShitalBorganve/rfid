<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jbtech_ajax extends CI_Controller {


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
		$this->load->model("jbtech_model");
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
	
}