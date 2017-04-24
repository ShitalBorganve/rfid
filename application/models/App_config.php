<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App_config extends CI_Model {

    function __construct(){
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
    }

    function edit_info($data='')
    {
    	
    }

    function login($data='')
    {
    	$login_query = $this->db->get_where("app_config",$data);
    	$data = $login_query->row(0);
    	$this->session->set_userdata("gate_sessions",$data);
    	return ($login_query->num_rows()===1);
    }

    public function updates($current_build)
    {
        $app_config = $this->db->get("app_config")->row();
        while ($app_config->version<$current_build) {
            $app_config->version += 0.0001;
            switch ($app_config->version) {
                case 1.0001:
                    echo $app_config->version;
                    break;
                case 1.0002:
                    echo $app_config->version;
                    # code...
                    break;
                default:
                    # code...
                    break;
            }
        }
    }
}