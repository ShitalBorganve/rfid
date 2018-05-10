<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Guardian_model extends CI_Model {

    function __construct(){
        // Call the Model constructor
        parent::__construct();
        $this->load->helper('app_helper');
        $this->load->database(database());
        $this->load->library('session');
        
    }

    function add($data=""){
        $this->db->insert("guardians",$data);
        $this->db->limit(1);
        $this->db->order_by("id","DESC");
        return $this->db->get("guardians")->row();
    }


    function delete($value=''){
    	
    }

    function get_list($where='',$page=1,$maxitem=50,$order_by_col="id",$order_by_val="DESC"){
    	if($where==""){
            $this->db->where("deleted",0);
        }else{
            $this->db->where($where);
        }
        $limit = ($page*$maxitem)-$maxitem;
        $this->db->order_by($order_by_col,$order_by_val);
        $this->db->limit($maxitem,$limit);
        $query = $this->db->get("guardians");
        $data["query"] = $this->db->last_query();
        $data["result"] = $query->result();

        if($where==""){
            $this->db->where("deleted",0);
        }else{
            $this->db->where($where);
        }
        $this->db->order_by('name');
        $query = $this->db->get("guardians");
        $data["all"] = $query->result();

        $data["count"] = $query->num_rows();
        return $data;
    }

    function get_data($where,$to_object=FALSE){
        $query = $this->db->get_where("guardians",$where);
        if($to_object){
            return $query->row();
        }else{
            return $query->row_array();
        }
    }

    function login($data='')
    {
        $login_query = $this->db->get_where("guardians",$data);
        $data = $login_query->row(0);
        $this->session->set_userdata("guardian_sessions",$data);
        return ($login_query->num_rows()===1);
    }

    function edit_info($data='',$id=''){
        $this->db->where('id', $id);
        $this->db->update('guardians', $data);
        $this->db->where('id', $id);
        return $this->db->get("guardians")->row();
        
    }
}


?>