<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rfid_photo_model extends CI_Model {

    function __construct(){
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
    }

    function add()
    {
        $data["name"] = "";
        $this->db->insert("rfid_photo",$data);
        $this->db->limit(1);
        $this->db->order_by("id","DESC");
        $photo_data = $this->db->get("rfid_photo")->row();

        return md5("_jbtech_11".$photo_data->id);
    }
}


?>