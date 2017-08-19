<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fetchers_model extends CI_Model {

    function __construct(){
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
    }

    function add($fetchers_data=""){
        $this->db->insert("fetchers",$fetchers_data);
        return $this->db->get("fetchers")->last_row();
    }

    function edit_info($data='',$id=''){
        $this->db->where('id', $id);
        $this->db->update('fetchers', $data);

        $this->db->where('id', $id);
        return $this->db->get("fetchers")->row();
      
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
        $this->db->limit($maxitem,$limit);
        $query = $this->db->get("fetchers");
        $data["query"] = $this->db->last_query();
        $fetchers_data = $query->result();
        $data["result"] = $fetchers_data;
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
        $query = $this->db->get("fetchers");
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
        $query = $this->db->get("fetchers");
        $fetchers_data = $query->result();
        $data["all"] = $fetchers_data;

        //end all records
        return $data;
    }

    function get_data($where='',$to_object=FALSE){
      $query = $this->db->get_where("fetchers",$where);
        if($to_object){
            return $query->row();
        }else{
            return $query->row_array();
        }
    }

    function scangate($data='')
    {
        $query = $this->db->get_where("fetchers",$data);
    }

    function add_load_credits($data='')
    {
        $query = $this->db->get_where("fetchers",'id="'.$data["id"].'"');
        $fetcher_data = $query->row();

        $new_load = $fetcher_data->load_credits+$data["load_credits"];
        $new_load_data["load_credits"] = $new_load;
        $this->db->where('id="'.$data["id"].'"');
        $this->db->update('fetchers', $new_load_data);

        $query = $this->db->get_where("fetchers",'id="'.$data["id"].'"');
        return $query->row_array();
    }


    public function delete($id)
    {
        $this->db->set('deleted',1);
        $this->db->where('id',$id);
        $this->db->update('fetchers');
        $this->db->set('deleted',1);
        $this->db->where('ref_id',$id);
        $this->db->where('ref_table','fetchers');
        $this->db->update('rfid');
        $this->db->set('fetcher_id',0);
        $this->db->where('fetcher_id',$id);
        $this->db->update('students');
    }


}


?>