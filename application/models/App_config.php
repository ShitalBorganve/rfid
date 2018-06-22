
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App_config extends CI_Model {

    function __construct(){
        // Call the Model constructor
        parent::__construct();
        $this->load->helper('app_helper');
        $this->load->database(database());
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
                    $this->db->query("CREATE TABLE `".$this->db->database."`.`fetchers` ( `id` INT NOT NULL AUTO_INCREMENT , `rfid_status` INT NOT NULL , `deleted` INT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;");
                    $this->db->query("ALTER TABLE `students` ADD `fetcher_id` INT NOT NULL AFTER `guardian_id`");
                    $this->db->query("UPDATE app_config SET version='".$app_config->version."' WHERE id='1'");
                    // echo $app_config->version;
                    break;
                case 1.0003:
                    $this->db->query("ALTER TABLE `students` ADD `age_as_of_august` INT NOT NULL AFTER `birthdate`");
                    $this->db->query("ALTER TABLE `students`  ADD `mother_tongue` VARCHAR(255) NOT NULL  AFTER `rfid_status`,  ADD `ethnic_group` VARCHAR(255) NOT NULL  AFTER `mother_tongue`,  ADD `religion` VARCHAR(255) NOT NULL  AFTER `ethnic_group`,  ADD `is_transferee` INT NOT NULL  AFTER `religion`,  ADD `last_school_attended` TEXT NOT NULL  AFTER `is_transferee`,  ADD `last_year_attended` INT NOT NULL  AFTER `last_school_attended`,  ADD `last_grade_attended` VARCHAR(255) NOT NULL  AFTER `last_year_attended`,  ADD `last_track_strand` VARCHAR(255) NOT NULL  AFTER `last_grade_attended`,  ADD `academic_track` VARCHAR(255) NOT NULL  AFTER `last_track_strand`,  ADD `tech_voc_track` TEXT NOT NULL  AFTER `academic_track`,  ADD `fathers_last_name` VARCHAR(255) NOT NULL  AFTER `tech_voc_track`,  ADD `fathers_middle_name` VARCHAR(255) NOT NULL  AFTER `fathers_last_name`,  ADD `fathers_first_name` VARCHAR(255) NOT NULL  AFTER `fathers_middle_name`,  ADD `fathers_contact_number` VARCHAR(255) NOT NULL  AFTER `fathers_first_name`,  ADD `fathers_address` TEXT NOT NULL  AFTER `fathers_contact_number`,  ADD `mothers_last_name` VARCHAR(255) NOT NULL  AFTER `fathers_address`,  ADD `mothers_middle_name` VARCHAR(255) NOT NULL  AFTER `mothers_last_name`,  ADD `mothers_first_name` VARCHAR(255) NOT NULL  AFTER `mothers_middle_name`,  ADD `mothers_contact_number` VARCHAR(255) NOT NULL  AFTER `mothers_first_name`,  ADD `mothers_address` TEXT NOT NULL  AFTER `mothers_contact_number`,  ADD `is_living_with_parents` INT NOT NULL  AFTER `mothers_address`");
                    $this->db->query("ALTER TABLE `guardians` ADD `last_name` VARCHAR(255) NOT NULL AFTER `name`, ADD `first_name` VARCHAR(255) NOT NULL AFTER `last_name`, ADD `middle_name` VARCHAR(255) NOT NULL AFTER `first_name`");
                    $this->db->query("UPDATE app_config SET version='".$app_config->version."' WHERE id='1'");
                    // echo $app_config->version;
                    break;
                default:
                $this->db->query("ALTER TABLE `students` CHANGE `last_year_attended` `last_year_attended` VARCHAR(255) NOT NULL");
                $this->db->query("UPDATE app_config SET version='".$app_config->version."' WHERE id='1'");
                    
                    break;
            }
        }
    }
}
