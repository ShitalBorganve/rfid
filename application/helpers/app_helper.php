<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('admin_paging'))
{
	function paging($page,$num_items,$maxitem,$attrib="",$pre='<div class="text-center">',$post='</div>')
	{
		if($attrib==""){
			$attrib["href"] = "#";
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
		# code...
	}
}