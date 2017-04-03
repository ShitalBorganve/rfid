<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sms_model extends CI_Model {

    function __construct(){
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
    }

    function send($data='',$sms_data='')
    {
    	
        $data["sms_id"] = $sms_data->id;
    	$this->db->insert("sms_list",$data);
        return $sms_data;
    }

    function add($data='')
    {

       $sms_data["date_time"] = strtotime(date("m/d/Y h:i:s A"));
       $sms_data["date"] = strtotime(date("m/d/Y"));
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
        # code...
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

    function get_list($where='',$page=1,$maxitem=50)
    {
        return $this->db->get("sms")->result();
    }


}
