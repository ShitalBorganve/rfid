<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gate_logs_model extends CI_Model {

    function __construct(){
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        
    }

    function add_log($data=""){
        
        $get_data["rfid_id"] = $data["rfid_id"];
        $get_data["date"] = $data["date"];
        $this->db->order_by("id","DESC");
        $this->db->limit(1);
        $get_log_data = $this->db->get_where("gate_logs",$get_data)->row();
        if($get_log_data==NULL){
            $data["type"] = "entry";
            return ($this->db->insert("gate_logs",$data));
            exit;
        }elseif ($get_log_data->type=="exit") {
            $data["type"] = "entry";
        }else{
            $data["type"] = "exit";
        }
        $limit_date = strtotime(date("m/d/Y h:i:s A", strtotime("+1 min",$get_log_data->date_time)));
        if($get_log_data->date_time<=$limit_date&&$limit_date<=$data["date_time"]){
            return ($this->db->insert("gate_logs",$data));
        }else{
            return FALSE;
        }
    }

    function get_list($table="students",$where='',$between='',$page=1,$maxitem=50)
    {


        // $limit = ($page*$maxitem)-$maxitem;
        // $this->db->limit($maxitem,$limit);

        $test[] = 'gate_logs.*';
        $test[] = $table.'.middle_name';
        $test[] = $table.'.last_name';
        $test[] = $table.'.first_name';

        $this->db->where("ref_table",$table);
        ($where!=""?$this->db->where($where):false);
        ($between!=""?$this->db->where($between):false);

        $this->db->order_by("id","DESC");
        $this->db->select($test);
        $this->db->from('gate_logs');
        $this->db->join($table, $table.'.id = gate_logs.ref_id');
        $gate_logs_query = $this->db->get();

        // $gate_logs_data = $this->db->get("gate_logs")->result();
        $data["query"] = $this->db->last_query();

        $this->db->where("gate_logs.ref_table","students");
        $this->db->select($test);
        $data["count"] = $this->db->count_all_results("gate_logs");
        // return $data;
        // exit;
        $gate_logs_data = $gate_logs_query->result();
        foreach ($gate_logs_data as $gate_log_data) {
            $get_rfid_data = array();
            $get_rfid_data["id"] = $gate_log_data->rfid_id;
            $gate_log_data->rfid_data = $this->db->get_where("rfid",$get_rfid_data)->row();
            $get_owner_data = array();
            $get_owner_data["id"] = $gate_log_data->ref_id;
            $gate_log_data->owner_data = $this->db->get_where($gate_log_data->ref_table,$get_owner_data)->row();
            # code...
        }

        $data["result"] = $gate_logs_data;


        // $this->db->select('*, gate_logs.id as gate_logs_id');
        // $this->db->from('gate_logs');
        // $this->db->join('students', 'students.id=gate_logs.student_id');
        // $this->db->order_by("gate_logs_id","DESC");
        // $query = $this->db->get();
        
        // if($where!=""){
        //     $this->db->where($where);
        // }
        // if($between!=""){
        //     $this->db->where($between);
        // }

        // $limit = ($page*$maxitem)-$maxitem;
        // $this->db->select('*, gate_logs.id as gate_logs_id');
        // $this->db->from('gate_logs');
        // $this->db->join('students', 'students.id=gate_logs.student_id');
        // $this->db->order_by("gate_logs_id","DESC");
        // $this->db->limit($maxitem,$limit);
        // $query = $this->db->get();
        // $data["result"] = $query->result();
        // $data["query"] = $this->db->last_query();
        return $data;
    }

}


?>