<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tables extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('app_helper');


		//models
		$this->load->helper('string');
		$this->load->model('guardian_model');
		$this->load->model("admin_model");
		$this->load->model("teachers_model");
		$this->load->model("students_model");
		$this->load->model("gate_logs_model");
		$this->load->model("rfid_model");
		$this->load->model("canteen_model");
		$this->load->model("canteen_items_model");

		$this->load->library('form_validation');
		$this->load->library('session');
		
		$this->form_validation->set_error_delimiters('', '');
	}

	public function students($arg='')
	{
		
		if($arg=="list"){

				$page = $this->input->post("page");
				$search = "";
				$where = "";

				if($this->input->post("search_last_name")){
					$search["search"] = "last_name";
					$search["value"] = $this->input->post("search_last_name");
				}

				if($this->input->post("owner_id")){
					$search = "";
					$where["id"] = $this->input->post("owner_id");
				}
				$students_list_data = $this->students_model->get_list($where,$page,$this->config->item("max_item_perpage"),$search);

				// var_dump($this->input->post("owner_id"));
				// var_dump($students_list_data["query"]);
				// exit;
				foreach ($students_list_data["result"] as $student_data) {
					$get_data["ref_id"] = $student_data->id;
					$get_data["ref_table"] = "students";
					$rfid_data = $this->rfid_model->get_data($get_data);
					echo '
					<tr>
						<td>'.$rfid_data->rfid.'</td>
						<td>'.$student_data->last_name.", ".$student_data->first_name." ".$student_data->middle_name[0].". $student_data->suffix".'</td>
						<td>
						<a href="#" class="edit_student" id="'.$student_data->id.'">Edit info</a>
						</td>
					</tr>
					';
				}
				$attrib["href"] = "#";
				$attrib["class"] = "paging";
				echo paging($page,$students_list_data["count"],$this->config->item("max_item_perpage"),$attrib,'<tr><td colspan="20" style="text-align:center">','</td></tr>');	
		}	
	}

	public function gate_logs($arg='')
	{
		$where = "";
		$table = ((
			$this->input->post("ref_table") ||
			$this->input->post("ref_table")=="students" ||
			$this->input->post("ref_table")=="teachers"
			)?$this->input->post("ref_table"):"students");
		$page = $this->input->post("page");
		($this->input->post("ref_id")?$where["ref_id"]=$this->input->post("ref_id"):FALSE);
		if(!$this->input->post("ref_id")&&$this->input->post("search_last_name")){
			$this->db->where("last_name",$this->input->post("search_last_name"));
		}
		($this->input->post("date_from")?$date_from=strtotime($this->input->post("date_from")):$date_from=0);	
		($this->input->post("date_to")?$date_to=strtotime($this->input->post("date_to")):$date_to=strtotime(date("m/d/Y")));
		$between = "date BETWEEN '".$date_from."' AND '".$date_to."'";

		// $where["ref_id"]=1;
		// $where["ref_table"]="students";
		// if($this->input->post("search_last_name")){
		// 	$this->db->like('last_name', $this->input->post("search_last_name"));
		// }
		$for_guardian = ($this->input->post("for_guardian")?TRUE:FALSE);
		// var_dump($between);
		// exit;
		// var_dump($this->gate_logs_model->get_list($where,$between,$page,$this->config->item("max_item_perpage")));exit;
		// $students_log_data = $this->gate_logs_model->get_list($where,$between,$page,$this->config->item("max_item_perpage"));
		$gate_logs_data = $this->gate_logs_model->get_list($table,$where,$between);
		echo '
		<tr>
			<td>';
		// echo $gate_logs_data["query"];
		// echo "<br><br>";
		// echo $gate_logs_data["count"];
		echo $gate_logs_data["query"].'</td>
		</tr>
		';

		// var_dump($gate_logs_data["query"]);
		// echo $this->input->post("ref_table");
		// exit;
		foreach ($gate_logs_data["result"] as $gate_log_data) {
			if($gate_log_data->type=="exit"){
				$status = "danger";
			}else{
				$status = "success";
			}
			if($for_guardian){
				echo '
					<tr class="'.$status.'">
						<td>'.strtoupper($gate_log_data->type).'</td>
						<td>'.date("m/d/Y",$gate_log_data->date).'</td>
						<td>'.date("h:i:s A",$gate_log_data->date_time).'</td>
					</tr>
				';
			}else{
				echo '
					<tr class="'.$status.'">
						<td><a href="#" id="'.$gate_log_data->owner_data->id.'" class="gate_logs">'.$gate_log_data->owner_data->last_name.", ".$gate_log_data->owner_data->first_name." ".$gate_log_data->owner_data->middle_name[0].". ".$gate_log_data->owner_data->suffix.'</td>
						<td>'.$gate_log_data->rfid_data->rfid.'</td>
						<td>'.date("m/d/Y",$gate_log_data->date).'</td>
						<td>'.date("h:i:s A",$gate_log_data->date_time).'</td>
						<td>'.strtoupper($gate_log_data->type).'</td>
					</tr>
				';
			}

		}
		// $attrib["href"] = "#";
		// $attrib["class"] = "paging";
		// echo paging($page,$students_log_data["count"],$this->config->item("max_item_perpage"),$attrib,'<tr><td colspan="20" style="text-align:center">','</td></tr>');
	}
	public function teachers($arg='')
	{
		
		if($arg=="list"){

				$page = $this->input->post("page");
				$teachers_list_data = $this->teachers_model->get_list("",$page,$this->config->item("max_item_perpage"));

				// var_dump($teachers_list);
				// exit;
				foreach ($teachers_list_data["result"] as $teacher_data) {
					$get_data["ref_id"] = $teacher_data->id;
					$get_data["ref_table"] = "teachers";
					$rfid_data = $this->rfid_model->get_data($get_data);
					echo '
					<tr>
						<td>'.$rfid_data->rfid.'</td>
						<td>'.$teacher_data->last_name.", ".$teacher_data->first_name." ".$teacher_data->middle_name[0].". $teacher_data->suffix".'</td>
						<td><a href="#" class="edit_teacher" id="'.$teacher_data->id.'">Edit info</a></td>
					</tr>
					';
				}
				$attrib["href"] = "#";
				$attrib["class"] = "paging";
				echo paging($page,$teachers_list_data["count"],$this->config->item("max_item_perpage"),$attrib,'<tr><td colspan="20" style="text-align:center">','</td></tr>');	
		}
	}

	public function canteen($arg='')
	{
		$canteen_user_data = $this->session->userdata("canteen_sessions");
		if($arg=="item_list"){
			$page = $this->input->post("page");
			$get_list_where["deleted"] = 0;
			$get_list_where["canteen_id"] = $canteen_user_data->canteen_id;
			$item_list_data = $this->canteen_items_model->get_list($get_list_where,$page,$this->config->item("max_item_perpage"));
			foreach ($item_list_data["result"] as $item_data) {
				echo '
				<tr>
					<td>'.$item_data->category.'</td>
					<td>'.$item_data->item_name.'</td>
					<td style="text-align:right">'.number_format($item_data->cost_price,2).'</td>
					<td style="text-align:right">'.number_format($item_data->selling_price,2).'</td>
					<td style="text-align:center">'.$item_data->stocks.'</td>
				</tr>
				';
			}
			$attrib["href"] = "#";
			$attrib["class"] = "paging";
			echo paging($page,$item_list_data["count"],$this->config->item("max_item_perpage"),$attrib,'<tr><td colspan="20" style="text-align:center">','</td></tr>');

			// echo '<tr><td>';
			// var_dump($item_list_data);
			// echo '</td></tr>';
		}elseif ($arg=="sales_cart") {
			$cart_list = $this->session->userdata("canteen_sales_cart");
			if(isset($cart_list["items"])){
				// echo "<table>";
				$total = 0;
				foreach ($cart_list["items"] as $cart_data) {
					$get_data["id"] = $cart_data["id"];
					$item_data = $this->canteen_items_model->get_data($get_data,TRUE);
					$line_total = $item_data["selling_price"]*$cart_data["quantity"];
					$total += $line_total;
					echo '
					<tr>
						<td><a class="sales_cart-remove_item" href="#" title="Remove" id="item_'.$cart_data["id"].'">&times;</a></td>
						<td>'.$item_data["item_name"].'</td>
						<td style="text-align:center;">'.$item_data["stocks"].'</td>
						<td style="text-align:center;"><input type="number" class="sales_cart_quantity" name="quantity" min="1" max="'.$item_data["stocks"].'" value="'.$cart_data["quantity"].'" id="item_'.$cart_data["id"].'"></td>
						<td style="text-align:right;" id="item_'.$cart_data["id"].'">'.number_format($item_data["selling_price"],2).'</td>
						<td style="text-align:right;" id="item_'.$cart_data["id"].'" class="line_total">'.number_format($line_total,2).'</td>
					</tr>
					';
				}
				echo '
					<tr class="success">
						<th colspan="5" style="text-align:right;">TOTAL:</th>
						<th style="text-align:right;" class="cart_total">'.number_format($total,2).'</th>
					</tr>
				';
				// echo "</table>";
			}else{
				echo '
					<tr class="success">
						<th colspan="5" style="text-align:right;">TOTAL:</th>
						<th style="text-align:right;" class="cart_total">0.00</th>
					</tr>
				';
			}
			# code...
		}
	}
}