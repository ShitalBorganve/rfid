<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Teachers_model extends CI_Model {

    function __construct(){
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
    }

    function add($students_data=""){
        $this->db->insert("teachers",$students_data);
        return $this->db->get("teachers")->last_row();
    }

    function edit_info($data='',$id=''){
        $this->db->where('id', $id);
        $this->db->update('teachers', $data);
        return $this->db->last_query();
    	# code...
    }

    function delete($value=''){
    	# code...
    }

    function get_list($where='',$page=1,$maxitem=50){
        if($where==""){
            $this->db->where('deleted="0"');
        }else{
            $this->db->where($where);
        }
            $limit = ($page*$maxitem)-$maxitem;
            $this->db->limit($maxitem,$limit);
            $query = $this->db->get("teachers");
            $data["query"] = $this->db->last_query();
            $data["count"] = $this->db->count_all_results("teachers");
            $teachers_data = $query->result();
            foreach ($teachers_data as $teacher_data) {
                $teacher_data->full_name = $teacher_data->last_name.", ".$teacher_data->first_name." ".$teacher_data->middle_name[0]." ".$teacher_data->suffix;
                $get_data = array();
                $get_data["ref_id"] = $teacher_data->id;
                $get_data["ref_table"] = "teachers";
                $teacher_data->rfid_data = $this->db->get_where("rfid",$get_data)->row();
            }
            $data["result"] = $teachers_data;

            
            return $data;
    }

    function get_data($where=''){
        $query = $this->db->get_where("teachers",$where);
        return $query->row_array();
    }

    function scangate($data='')
    {
        $query = $this->db->get_where("teachers",$data);
    }

    function add_load_credits($data='')
    {
        $query = $this->db->get_where("teachers",'id="'.$data["id"].'"');
        $student_data = $query->row();

        $new_load = $student_data->load_credits+$data["load_credits"];
        $new_load_data["load_credits"] = $new_load;
        $this->db->where('id="'.$data["id"].'"');
        $this->db->update('teachers', $new_load_data);

        $query = $this->db->get_where("teachers",'id="'.$data["id"].'"');
        return $query->row_array();
    }

}


?>