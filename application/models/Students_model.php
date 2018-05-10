<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Students_model extends CI_Model {

    function __construct(){
        // Call the Model constructor
        parent::__construct();
        $this->load->helper('app_helper');
        $this->load->database(database());
    }

    function add($students_data=""){
        $this->db->insert("students",$students_data);
        return $this->db->get("students")->last_row();
    }

    function edit_info($data='',$id=''){
        $this->db->where('id', $id);
        $this->db->update('students', $data);

        $this->db->where('id', $id);
        return $this->db->get("students")->row();
    	
    }

    function delete($value=''){
    	
    }

    function get_list($where='',$page=1,$maxitem=2,$search=""){
        //start

        if($where==""){
            $this->db->where('deleted=0');
        }else{
            $this->db->where($where);
        }
        if($search!=""){
            $this->db->like($search["search"],$search["value"]);
        }
            $limit = ($page*$maxitem)-$maxitem;
            $this->db->order_by('last_name ASC, first_name ASC, middle_name ASC, suffix ASC');
            $this->db->limit($maxitem,$limit);
            $query = $this->db->get("students");
            $data["query"] = $this->db->last_query();
            $students_data = $query->result();
            foreach ($students_data as $student_data) {
                $get_data = array();
                $get_data["ref_id"] = $student_data->id;
                $get_data["ref_table"] = "students";
                $student_data->rfid_data = $this->db->get_where("rfid",$get_data)->row();
                $student_data->middle_initial = ($student_data->middle_name==""?"":$student_data->middle_name[0].". ");
                $student_data->full_name = $student_data->last_name.", ".$student_data->first_name." ".$student_data->middle_initial.$student_data->suffix;
            }
        $data["result"] = $students_data;
        //end


        //start count
        if($where==""){
            $this->db->where('deleted=0');
        }else{
            $this->db->where($where);
        }
        if($search!=""){
            $this->db->like($search["search"],$search["value"]);
        }
        $query = $this->db->get("students");
        $data["count"] = $query->num_rows();
        //end count

        //all records
        if($where==""){
            $this->db->where('deleted=0');
        }else{
            $this->db->where($where);
        }
        if($search!=""){
            $this->db->like($search["search"],$search["value"]);
        }
            $this->db->order_by('last_name ASC, first_name ASC, middle_name ASC, suffix ASC');
            $query = $this->db->get("students");
            $students_data = $query->result();
            foreach ($students_data as $student_data) {
                $get_data = array();
                $get_data["ref_id"] = $student_data->id;
                $get_data["ref_table"] = "students";
                $student_data->rfid_data = $this->db->get_where("rfid",$get_data)->row();
                $student_data->middle_initial = ($student_data->middle_name==""?"":$student_data->middle_name[0].". ");
                $student_data->full_name = $student_data->last_name.", ".$student_data->first_name." ".$student_data->middle_initial.$student_data->suffix;
            }
        $data["all"] = $students_data;

        //end all records
        return $data;
    }

    function get_data($where='',$to_object=FALSE){
    	$query = $this->db->get_where("students",$where);
        if($to_object){
            return $query->row();
        }else{
            return $query->row_array();
        }
    }

    function scangate($data='')
    {
        $query = $this->db->get_where("students",$data);
    }

    function add_load_credits($data='')
    {
        $query = $this->db->get_where("students",'id="'.$data["id"].'"');
        $student_data = $query->row();

        $new_load = $student_data->load_credits+$data["load_credits"];
        $new_load_data["load_credits"] = $new_load;
        $this->db->where('id="'.$data["id"].'"');
        $this->db->update('students', $new_load_data);

        $query = $this->db->get_where("students",'id="'.$data["id"].'"');
        return $query->row_array();
    }


}


?>