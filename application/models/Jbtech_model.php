<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jbtech_model extends CI_Model {

    function __construct(){
        // Call the Model constructor
        parent::__construct();
        $this->load->helper('app_helper');
        $this->load->database(database());
        $this->load->library('session');
        
    }

    function add($add_students_data=""){

    }

    function edit_info($value=''){
    	
    }

    function delete($value=''){
    	
    }

    function get_list($value=''){
    	
    }

    function get_data($value=''){
    	
    }

    function login($data='')
    {
        $login_query = $this->db->get_where("jbtech",$data);
        $data = $login_query->row(0);
        $this->session->set_userdata("jbtech_sessions",$data);
        return ($login_query->num_rows()===1);
    }
}


?>