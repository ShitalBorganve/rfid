<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('admin_paging'))
{
	function paging($page,$num_items,$maxitem,$attrib="",$pre='<div class="text-center">',$post='</div>')
	{
		if($attrib==""){
			$attrib["href"] = "javascript:void(0);";
		}
		echo $pre;
		($page<=1?$page=1:false);
		$limit = ($page*$maxitem)-$maxitem;
 		if(($num_items%$maxitem)==0){
			$lastpage=($num_items/$maxitem);
		}else{
			$lastpage=($num_items/$maxitem)-(($num_items%$maxitem)/$maxitem)+1;
		}
		$i = 0;
		if(is_array($attrib)){
			foreach ($attrib as $prop => $value) {
				if($i==0){
					$attr = $prop.'="'.$value.'"';
				}else{
					$attr .=" ".$prop.'="'.$value.'"';
				}
				$i++;
			}
		}else{
			$attr = "";
		}
		$maxpage = 3;
		echo '
		<ul class="pagination prints">
		';
		$cnt=0;
		if($page>1){
			$back=$page-1;
			echo '<li><a '.$attr.' id="1">&laquo;&laquo;</a></li>';	
			echo '<li><a '.$attr.' id="'.$back.'">&laquo;</a></li>';	
			for($i=($page-$maxpage);$i<$page;$i++){
				if($i>0){
					echo "<li><a $attr id='$i'>$i</a></li>";	
				}
				$cnt++;
				if($cnt==$maxpage){
					break;
				}
			}
		}
		
		$cnt=0;
		for($i=$page;$i<=$lastpage;$i++){
			$cnt++;
			if($i==$page){
				echo '<li class="active"><a>'.$i.'</a></li>';	
			}else{
				echo '<li><a '.$attr.' id="'.$i.'">'.$i.'</a></li>';	
			}
			if($cnt==$maxpage){
				break;
			}
		}
		
		$cnt=0;
		for($i=($page+$maxpage);$i<=$lastpage;$i++){
			$cnt++;
			echo '<li><a '.$attr.' id="'.$i.'">'.$i.'</a></li>';	
			if($cnt==$maxpage){
				break;
			}
		}
		if($page!=$lastpage&&$num_items>0){
			$next=$page+1;
			echo '<li><a '.$attr.' id="'.$next.'">&raquo;</a></li>';
			echo '<li><a '.$attr.' id="'.$lastpage.'">&raquo;&raquo;</a></li>';
		}
		echo "</ul>";

		echo $post;	
		
	}

	function sms_status($code)
	{
		switch ($code) {
			case '1':
				return "Invalid Number.";
				
				break;
			case '2':
				return "Number not Supported.";
				
				break;
			case '3':
				return "Invalid ApiCode.";
				
				break;
			case '4':
				return "Maximum Message per day reached. This will be reset every 12MN.";
				
				break;
			case '5':
				return "Maximum allowed characters for message reached.";
				
				break;
			case '6':
				return "System OFFLINE.";
				
				break;
			case '7':
				return "Expired ApiCode.";
				
				break;
			case '8':
				return "iTexMo Error. Please try again later.";
				
				break;
			case '9':
				return "Invalid Function Parameters.";
				
				break;
			case '10':
				return "Recipient's number is blocked due to FLOODING, message was ignored.";
				
				break;
			case '11':
				return "Recipient's number is blocked temporarily due to HARD sending (after 3 retries of sending and message still failed to send) and the message was ignored. Try again after an hour.";
				
				break;
			case '12':
				return "Invalid request. You can't set message priorities on non corporate apicodes.";
				
				break;
			case '0':
				return "Success! Message is now on queue and will be sent soon.";
				
				break;
			default:
				return "Connection Error. Check your internet connection.";
				
				break;
		}
	}

	function send_sms($mobile_number='',$message='',$apicode='')
	{
		if(ENVIRONMENT=='development'){
			return 0;
		}
		$data["1"] =  $mobile_number;
		$data["2"] =  $message;
		$data["3"] =  $apicode;
		$data = http_build_query($data);
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://www.itexmo.com/php_api/api.php",
			CURLOPT_RETURNTRANSFER => TRUE,
			CURLOPT_SSL_VERIFYPEER => FALSE,
			CURLOPT_POSTFIELDS => $data,
		));
		$result = curl_exec($curl);
		curl_close($curl);
		return $result;
		// return 7;
	}

	function age($birthdate)
	{
		$birthdate = date("m/d/Y",$birthdate);
		$birthdate = explode("/", $birthdate);
		$age = (date("md", date("U", mktime(0, 0, 0, $birthdate[0], $birthdate[1], $birthdate[2]))) > date("md")
			? ((date("Y") - $birthdate[2]) - 1)
			: (date("Y") - $birthdate[2]));
		return $age;
	}

	function current_build()
	{
		return "1.0004";
	}

	function init_database_settings()
	{
		$has_settings = file_exists('settings/database.json');
		if(!$has_settings){
			$data = array();
			$data = [
				'databases' => [
					'2017',
					'2018',
				],
				'default_database' => (string)date('Y')
			];
			$fp = fopen('settings/database.json', 'w');
			fwrite($fp, json_encode($data));
			fclose($fp);
		}
		return $has_settings;
	}

	function get_database_settings()
	{
		$string = file_get_contents((custom_base_url()."/settings/database.json"));
		return $string;
	}

	function database()
	{
		init_database_settings();
		$CI =& get_instance();
		$CI->load->helper('cookie');
		$settings = json_decode(get_database_settings(),true);
		$database = $CI->input->cookie('db',true);
		if($database == null){
			//43200s = 12hrs
			$CI->input->set_cookie('db',$settings['default_database'],43200);
			$database = $settings['default_database'];
		}else{
			if(!in_array($database,$settings['databases'])){
				$database = $settings['default_database'];
			}
		}
		return $database;
		return $CI->input->cookie('db');
	}

	function custom_base_url()
	{
		$CI =& get_instance();
		return $CI->config->item('base_url');
	}

	function footer()
	{
		$CI =& get_instance();
		$CI->load->database(database());
		$CI->load->model("app_config");
		$CI->app_config->updates(current_build());
		$school_year = $CI->db->school_year;
		$app_config = $CI->db->get('app_config')->row();
		return '<br><br><br><p style="text-align:center"><small>'.$app_config->client_name.' SY '.$school_year.'</i></small></p>';
	}

	function change_database($database)
	{
		$CI =& get_instance();
		$CI->load->helper('cookie');
		$CI->input->set_cookie('db',$database,43200);
		$settings = json_decode(get_database_settings(),true);
		if(!in_array($database,$settings['databases'])){
			$database = $settings['default_database'];
		}
		return $database;
	}
}