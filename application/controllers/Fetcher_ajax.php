<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fetcher_ajax extends CI_Controller {


  public function __construct()
  {
    parent::__construct();
    $this->load->database();
    
    $this->load->helper('form');
    $this->load->helper('url');
    $this->load->helper('app_helper');


    //models
    $this->load->helper('string');

    $this->load->model("students_model");
    $this->load->model("fetchers_model");
    $this->load->model("rfid_model");

    $this->load->library('form_validation');
    $this->load->library('session');
    
    $this->form_validation->set_error_delimiters('', '');
  }

  public function add()
  {
    $this->form_validation->set_rules('fetcher_student_id','requied');
    $students = $this->input->post('fetcher_student_id');
    if ($students==null){
        $data['is_valid'] = false;
    }else{
        $add = array();
        $add["deleted"] = 0;
        $fetcher_data = $this->fetchers_model->add($add);
        $edit = array();
        $edit['fetcher_id'] = $fetcher_data->id;
        foreach ($students as $student_id) {
            $this->students_model->edit_info($edit,$student_id);
        }
        $add = array();
        $add["ref_table"] = 'fetchers';
        $add["ref_id"] = $fetcher_data->id;
        $add["valid"] = 1;
        $this->rfid_model->add($add);
        $data["is_valid"] = true;
    }
    echo json_encode($data);
  }

  public function get_data($arg='')
  {
    if($arg=="jbtech"){

      $get_data["id"] = $this->input->get('fetcher_id');
      $fetcher_data = $this->fetchers_model->get_data($get_data);
      $fetcher_data["id_string"] = sprintf("%04d",$fetcher_data["id"]);
      $students = $this->db->get_where('students',"fetcher_id='".$get_data["id"]."'")->result();
      if($students!=array()){
        $fetcher_data["student_data"] = $students[0];
        $fetcher_data["display_photo"] = $students[0]->display_photo;
        $fetcher_data["full_name"] = $students[0]->last_name.', '.$students[0]->first_name." ".($students[0]->middle_name!=""?$students[0]->middle_name[0].".":"");
        $fetcher_data["class_name"] = $this->db->get_where('classes',['id'=>$students[0]->class_id])->row()->class_name;
        $fetcher_data["grade"] = $this->db->get_where('classes',['id'=>$students[0]->class_id])->row()->grade;
      }else{
        $fetcher_data["display_photo"] = "";
        $fetcher_data["full_name"] = "";
        $fetcher_data["class_name"] = "";
        $fetcher_data["grade"] = "";
      }
      echo json_encode($fetcher_data);
      
    }else{
        $get_data["id"] = $this->input->get('fetcher_id');
        $fetcher_data = $this->fetchers_model->get_data($get_data);
        $fetcher_data["id_string"] = sprintf("%04d",$fetcher_data["id"]);
        $students = $this->db->get_where('students',"fetcher_id='".$get_data["id"]."'")->result();
        $fetcher_data["students"] = array();
        foreach ($students as $student_data) {
            $fetcher_data["students"][] = $student_data->id;
        }
        echo json_encode($fetcher_data);
    }
  }

  public function edit()
  {
      $students = $this->input->post('fetcher_student_id');
      if($students!=null){
        $fetcher_id = $this->input->post('fetcher_id');
        $this->db->set('fetcher_id',0);
        $this->db->where('fetcher_id',$fetcher_id);
        $this->db->update('students');
        $data["is_valid"] = true;
        foreach ($students as $student_id) {
            $edit = array();
            $edit["fetcher_id"] = $fetcher_id;
            $this->students_model->edit_info($edit,$student_id);
        }
      }else{
        $data["is_valid"] = false;
      }
      echo json_encode($data);
  }

  public function delete()
  {
    $this->fetchers_model->delete($this->input->post('id'));
    $data["id"] = sprintf("%04d",$this->input->post('id'));
    echo json_encode($data);
  }

}
