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
                    $this->db->query("ALTER TABLE `teachers` ADD `blood_type` VARCHAR(50) NOT NULL AFTER `birthdate`, ADD `sss` VARCHAR(50) NOT NULL AFTER `blood_type`, ADD `philhealth` VARCHAR(50) NOT NULL AFTER `sss`, ADD `pagibig` VARCHAR(50) NOT NULL AFTER `philhealth`, ADD `tin` VARCHAR(50) NOT NULL AFTER `pagibig`");
                    $this->db->query("ALTER TABLE `teachers` ADD `in_case_address` TEXT NOT NULL AFTER `in_case_contact_number`");
                    $this->db->query("ALTER TABLE `staffs` ADD `blood_type` VARCHAR(50) NOT NULL AFTER `birthdate`, ADD `sss` VARCHAR(50) NOT NULL AFTER `blood_type`, ADD `philhealth` VARCHAR(50) NOT NULL AFTER `sss`, ADD `pagibig` VARCHAR(50) NOT NULL AFTER `philhealth`, ADD `tin` VARCHAR(50) NOT NULL AFTER `pagibig`");
                    $this->db->query("ALTER TABLE `staffs` ADD `in_case_address` TEXT NOT NULL AFTER `in_case_contact_number`");
                    $this->db->query("ALTER TABLE `app_config` ADD `apicode` VARCHAR(100) NOT NULL AFTER `deleted`");
                    $this->db->query("UPDATE app_config SET version='".$app_config->version."' WHERE id='1'");
                    // echo $app_config->version;
                    break;
                case 1.0002:
                    $this->db->query("CREATE TABLE `rfid`.`fetchers` ( `id` INT NOT NULL AUTO_INCREMENT , `rfid_status` INT NOT NULL , `deleted` INT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;");
                    $this->db->query("ALTER TABLE `students` ADD `fetcher_id` INT NOT NULL AFTER `guardian_id`;");
                    $this->db->query("UPDATE app_config SET version='".$app_config->version."' WHERE id='1'");
                    // echo $app_config->version;
                    break;
                default:
                    
                    break;
            }
        }
    }
}
