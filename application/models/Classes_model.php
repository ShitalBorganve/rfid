<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Classes_model extends CI_Model {

    function __construct(){
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
    }

    function add($data=""){
        return $this->db->insert("classes",$data);
        // return $this->db->get("classes")->last_row();
    }

    function get_list($where='',$page=1,$maxitem=50,$search=""){
        if($where==""){
            $this->db->where('deleted=0');
        }else{
            $this->db->where($where);
        }
        if($search!=""){
            $this->db->like($search["search"],$search["value"]);
        }
            $limit = ($page*$maxitem)-$maxitem;
            $this->db->limit($maxitem,$limit);
            $query = $this->db->get("classes");
            $data["query"] = $this->db->last_query();
            $data["count"] = $this->db->count_all_results("classes");
            $classes_data = $query->result();
            $data["result"] = $classes_data;

            
            return $data;
    }

    function get_data($where=''){
        $query = $this->db->get_where("classes",$where);
        return $query->row_array();
    }
}