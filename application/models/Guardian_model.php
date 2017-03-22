<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Guardian_model extends CI_Model {

    function __construct(){
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        
    }

    function add($data=""){
        return ($this->db->insert("guardians",$data));
    }

    function edit_info($value=''){
    	# code...
    }

    function delete($value=''){
    	# code...
    }

    function get_list($data=''){
    	if($data==""){
            $query = $this->db->get_where("guardians",'deleted=0');
            return $query->result();
        }
    }

    function get_data($id){
        $this->db->where("id",$id);
    	$query = $this->db->get("guardians");
        return $query->row_array();
    }

    function login($data='')
    {
        $login_query = $this->db->get_where("guardians",$data);
        $data = $login_query->row(0);
        $this->session->set_userdata("guardian_sessions",$data);
        return ($login_query->num_rows()===1);
    }
}


?>