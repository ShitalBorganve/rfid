<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('app_helper');
		$this->load->database(database());
		$this->load->helper('form');
		$this->load->helper('url');
		$this->data["title"] = "Main Title";
		$this->data["css_scripts"] = $this->load->view("scripts/css","",true);
		$this->data["js_scripts"] = $this->load->view("scripts/js","",true);
		$this->data["meta_scripts"] = $this->load->view("scripts/meta","",true);
		$this->data["navbar_scripts"] = $this->load->view("layouts/navbar","",true);
		$this->data["modaljs_scripts"] = $this->load->view("layouts/modals","",true);
	}

	public function index($arg='')
	{
		$this->data["type_entry"] = $arg; 
		$this->load->view('students-entry',$this->data);
	}
	public function gate($arg='')
	{
		$this->data["type_entry"] = $arg; 
		$this->load->view('students-entry',$this->data);
	}
}
