<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sms_model extends CI_Model {

    function __construct(){
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
    }

    function send($data='',$sms_id='')
    {
        $data["sms_id"] = $sms_id;
    	$this->db->insert("sms_list",$data);
        // return $sms_data;
    }

    function add($data='')
    {

       $sms_data["date_time"] = strtotime(date("m/d/Y h:i:s A"));
       $sms_data["date"] = strtotime(date("m/d/Y"));
       $sms_data["sent_by_id"] = $data->id;
       $sms_data["sent_by_table"] = $data->sender;
       $this->db->insert("sms",$sms_data);
       $this->db->limit(1);
       $this->db->order_by("id","DESC");
       return $this->db->get("sms")->row();
    }

    function get_sms_list($data='',$to_object=FALSE)
    {
        $this->db->where($data);
        if($to_object){
            return $this->db->get("sms_list")->result();
        }else{
            return $this->db->get("sms_list")->result_array();
        }

    }

    function get_sms_data($data='',$to_object=FALSE)
    {
        $this->db->where($data);
        if($to_object){
            return $this->db->get("sms_list")->row();
        }else{
            return $this->db->get("sms_list")->row_array();
        }
        
    }


    function check_messages($id='')
    {
        $this->db->where("sms_id",$id);
        $this->db->where("status_code !=",0);
        $query = $this->db->get("sms_list");
        if($query->num_rows()==0){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    function get_data($data='',$to_object=FALSE)
    {
        $this->db->where($data);
        if($to_object){
            return $this->db->get("sms")->row();
        }else{
            return $this->db->get("sms")->row_array();
        }
    }

    function get_list($where='',$between='',$page=1,$maxitem=50)
    {
        if($where!=""){
            $this->db->where($where);
        }
        ($between!=""?$this->db->where($between):false);

        $this->db->order_by("id","DESC");
        $limit = ($page*$maxitem)-$maxitem;
        $this->db->limit($maxitem,$limit);
        $query = $this->db->get("sms");
        $data["query"] = $this->db->last_query();
        $data["result"] = $query->result();


        if($where!=""){
            $this->db->where($where);
        }
        ($between!=""?$this->db->where($between):false);
        $query = $this->db->get("sms");
        $data["count"] = $query->num_rows();
        return $data;
    }


    function resend($data='',$sms_id='')
    {
        $this->db->set($data);
        $this->db->where("sms_id",$sms_id);
        $this->db->update("sms_list");
        return $this->db->last_query();
    }

    function find_owner($contact_number)
    {
        $get_data["contact_number"] = $contact_number;
        $get_data["deleted"] = 0;
        if($this->db->get_where("teachers",$get_data)->num_rows()==1){
            $owner_data = $this->db->get_where("teachers",$get_data)->row();
            $owner_data->table = "teachers";
            return $owner_data;
            exit;
        }elseif($this->db->get_where("staffs",$get_data)->num_rows()==1){
            $owner_data = $this->db->get_where("staffs",$get_data)->row();
            $owner_data->table = "staffs";
            return $owner_data;
            exit;
        }elseif($this->db->get_where("guardians",$get_data)->num_rows()==1){
            $owner_data = $this->db->get_where("guardians",$get_data)->row();
            $owner_data->table = "guardians";
            return $owner_data;
            exit;
        }elseif($this->db->get_where("students",$get_data)->num_rows()==1){
            $owner_data = $this->db->get_where("students",$get_data)->row();
            $owner_data->table = "students";
            return $owner_data;
            exit;
        }else{
            return FALSE;
        }
    }

}
