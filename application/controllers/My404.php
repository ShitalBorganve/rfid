<?php 
class My404 extends CI_Controller 
{
    public function __construct() 
    {
        parent::__construct(); 
    } 

    public function index() 
    { 
        $this->load->helper('url');
        $this->output->set_status_header('404'); 
        $this->load->view("errors/404");
    } 
} 
?> 