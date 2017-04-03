<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

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
		$this->load->library('session');

		$this->load->model("students_model");
		$this->load->model("rfid_model");
		$this->load->model("guardian_model");
		$this->load->model("teachers_model");
		$this->load->model("gate_logs_model");
		$this->load->model("classes_model");
		$this->load->model("sms_model");
		
		$this->data["title"] = "Main Title";
		$this->data["css_scripts"] = $this->load->view("scripts/css","",true);
		$this->data["js_scripts"] = $this->load->view("scripts/js","",true);
		$this->data["meta_scripts"] = $this->load->view("scripts/meta","",true);
		
		$modal_data["guardians_list"] = $this->guardian_model->get_list();
		$modal_data["teachers_list"] = $this->teachers_model->get_list();
		$modal_data["classes_list"] = $this->classes_model->get_list();
		$modal_data["modals_sets"] = "admin";
		$this->data["modaljs_scripts"] = $this->load->view("layouts/modals",$modal_data,true);
		
		$navbar_data["navbar_type"] = "admin";
		($this->session->userdata("admin_sessions")?$navbar_data["navbar_is_logged_in"] = TRUE:$navbar_data["navbar_is_logged_in"] = FALSE);
		$this->data["navbar_scripts"] = $this->load->view("layouts/navbar",$navbar_data,true);
	}

	public function index($student_id='')
	{

		// var_dump($)
		// var_dump($this->rfid_model->get_data('rfid="2222"',TRUE));
		// $date1 = strtotime(date("m/d/Y h:i:s A"));
		// var_dump($date1);
		// echo "<br>";
		// $date2 = date("m/d/Y h:i:s A",$date1);
		var_dump($this->session->userdata("admin_sessions"));
		
		// exit;
		$this->data["login_type"] = "admin";
		if($this->session->userdata("admin_sessions")){
			// var_dump($this->gate_logs_model->get_list());exit;
			// $this->data["students_log_data"] = $this->gate_logs_model->get_list();
			$where["type"] = "entry";
			$gate_log_data = $this->gate_logs_model->get_list();

			// var_dump($gate_log_data);



			$this->load->view('gate-logs',$this->data);
		}else{
			$this->load->view('app-login',$this->data);
		}
	}
	public function login($value='')
	{
		# code...
	}
	public function logout($value='')
	{
		$this->session->unset_userdata('admin_sessions');
	}

	public function students($value='')
	{
		$this->load->view("students-list",$this->data);
	}

	public function teachers($value='')
	{
		$this->load->view("teachers-list",$this->data);
	}

	public function classes($value='')
	{
		$this->load->view("classes-list",$this->data);
	}

	public function guardians($value='')
	{
		$this->load->view("guardians-list",$this->data);
	}
	public function sms($value='')
	{
		$this->data["messages_list"] = $this->sms_model->get_list();
		$this->load->view("sms",$this->data);
	}


	public function test($value='')
	{
		echo '
		{"id":"1","last_name":"first","first_name":"first","middle_name":"first","suffix":"first","birthdate":"01\/01\/1980","display_photo":"\/\/localhost\/rfid\/assets\/images\/student_photo\/empty.jpg","display_photo_type":"","guardian_id":"1","class_id":"1","deleted":"0","rfid_data":{"id":"1","rfid":"123","load_credits":"0","ref_id":"1","ref_table":"students","pin":"0","valid":"1","deleted":"0"},"is_valid":true,"full_name":"first f. first","gate_logs_data":true}
		';
		// echo date("m/d/Y h:i:s A",1490703420);
		exit;
		$hidden = array(
			"1" => "09301167850",
			"2" => "This is a test Message",
			"3" => "TR-JBTEC167850_X6UFC",
			// "5" => "HIGH",
			// 'username' => "anonympox@gmail.com",
			// 'password' => "g1fth",
			// 'msgid' => "1001",
			// 'tel' => "639301167850",
			// 'msg' => "This is a Test Message",
			// 'pricegroup' => "0",
			// 'campaignid' => "372429",
			// 'message_type' => "SEND",
			// 'shortcode' => "29290247219",
			// 'message_id' => "100000",
			// 'client_id' => "2ef99635eb9bf11a9a141c2e6903c75ca70bd1970e46c808a764ba9a83d79ced",
			// 'secret_key' => "544397679cc9d7301079d673d2f3c018d349bd44a2354bc440fc92defbc5f881",
			 );
		echo form_open("https://www.itexmo.com/php_api/api.php",'id="form-test"',$hidden);

		$data = array();
		$data = array(
		        'name' => 'mobile_number',
		        'id' => 'mobile_number',
		        'placeholder' => 'mobile_number'
		);


		echo form_input($data);

		$data = array();
		$data = array(
		        'name' => 'message',
		        'id' => 'message',
		        'placeholder'   => 'message'
		);

		echo form_input($data);

		$data = array();
		$data = array(
		        'type' => 'submit',
		        'content' => 'Reset',
		        'form' => 'form-test'
		);

		echo form_button($data);
		echo form_close();
		// echo $this->load->view("scripts/js","",true);
		
		exit;

		var_dump(send_sms("639301167850","test message"));
		exit;

		$data = array(
			'message_type' => "SEND",
			// 'mobile_number' => "639301167850",
			'shortcode' => "29290247219",
			'message_id' => "100011",
			'message' => "This is a test message",
			'client_id' => "2ef99635eb9bf11a9a141c2e6903c75ca70bd1970e46c808a764ba9a83d79ced",
			'secret_key' => "544397679cc9d7301079d673d2f3c018d349bd44a2354bc440fc92defbc5f881",
		);

		$data = http_build_query($data);
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://post.chikka.com/smsapi/request",
			CURLOPT_RETURNTRANSFER => TRUE,
			CURLOPT_SSL_VERIFYPEER => FALSE,
			CURLOPT_POSTFIELDS => $data,
		));
		$result = curl_exec($curl);
		$result = json_decode($result);
		curl_close($curl);
		// var_dump($result);
		// $data
		exit;
		$data = array(
			// 'emailaddress' => "admin",
			'rfid_scan_add' => "7393422",
			'type' => "students",
			// 'message_type' => "SEND",
			// 'mobile_number' => "639301167850",
			// 'shortcode' => "29290247219",
			// 'message_id' => "100010",
			// 'message' => "This is a test message",
			// 'client_id' => "2ef99635eb9bf11a9a141c2e6903c75ca70bd1970e46c808a764ba9a83d79ced",
			// 'secret_key' => "544397679cc9d7301079d673d2f3c018d349bd44a2354bc440fc92defbc5f881",
		);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "http://www.qfcdavao.com/rfid/rfid_ajax/scan_add");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

		$output = curl_exec($ch);
		$info = curl_getinfo($ch);
		// $output = file_get_contents($output);
		// curl_close($ch);
		print $output;
		// var_dump($info);
		exit;
		$qry_str = "?x=10&y=20";
		$ch = curl_init();

		// Set query data here with the URL
		curl_setopt($ch, CURLOPT_URL, "localhost/rfid/admin/test_2" . $qry_str); 

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, '3');
		$content = trim(curl_exec($ch));
		curl_close($ch);
		print $content;
		exit;
		$hidden = array(
			'message_type' => "SEND",
			'shortcode' => "29290247219",
			'message_id' => "100000",
			'client_id' => "2ef99635eb9bf11a9a141c2e6903c75ca70bd1970e46c808a764ba9a83d79ced",
			'secret_key' => "544397679cc9d7301079d673d2f3c018d349bd44a2354bc440fc92defbc5f881",
			 );
		echo form_open("https://post.chikka.com/smsapi/request",'id="form-test"',$hidden);

		$data = array();
		$data = array(
		        'name' => 'mobile_number',
		        'id' => 'mobile_number',
		        'placeholder' => 'mobile_number'
		);

		echo form_input($data);

		$data = array();
		$data = array(
		        'name' => 'message',
		        'id' => 'message',
		        'placeholder'   => 'message'
		);

		echo form_input($data);

		$data = array();
		$data = array(
		        'type' => 'submit',
		        'content' => 'Reset',
		        'form' => 'form-test'
		);

		echo form_button($data);
		echo form_close();
		echo $this->load->view("scripts/js","",true);
		?>

		<script type="text/javascript">
			$(document).on("submit","#form-test",function(e) {
				e.preventDefault();
				$.ajax({
					type: "POST",
					url: $("#form-test").attr("action"),
					data: $("##form-test").serialize(),
					cache: false,
					dataType: "json",
					success: function(data) {
						console.log(data)
					}
				});
				
			});
		</script>
		<?php
		# code...
	}

	public function test_2($value='')
	{
		var_dump($_POST);
		# code...
	}
}
