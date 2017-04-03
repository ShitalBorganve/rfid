<!DOCTYPE html>
<html>
<head>
<?php echo '<title>'.$title.'</title>'.$meta_scripts.$css_scripts; ?>
<style>

</style>
</head>

<?php echo $navbar_scripts; ?>
<body>

<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<table class="table table-hover">
				<thead>
					<tr>
						<th>Message ID:</th>
						<th>Date</th>
						<th>Time</th>
					</tr>
				</thead>
				<tbody>
					<?php
					foreach ($messages_list as $message_data) {
						echo '
						<tr class="message" id="'.$message_data->id.'">
							<td>'.$message_data->id.'</td>
							<td>'.date("m/d/Y",$message_data->date).'</td>
							<td>'.date("h:i:s A",$message_data->date_time).'</td>
						</tr>
						';
					}
					?>
				</tbody>
			</table>
		</div>
	</div>

</div>
<?php echo $modaljs_scripts; ?>

<?php echo $js_scripts; ?>
<script>
$(document).on("click",".message",function(e) {
	var id = $(this).attr("id");
	$.ajax({
		type: "GET",
		data: "sms_id="+id,
		url: "<?php echo base_url("sms_ajax/get_data"); ?>",
		cache: false,
		dataType: "json",
		success: function(data) {
			$("#sms-list-modal").modal("show");
			$("#message_id_txt").html(id);
		    $('.sms_list_table tbody').html("");

			$.each(data, function(i, item) {
			    $('.sms_list_table tbody').append('\
			    	<tr>\
			    	<td>'+data[i].message+'</td>\
			    	<td>'+data[i].mobile_number+'</td>\
			    	<td>'+data[i].recipient+'</td>\
			    	<td>'+data[i].status+'</td>\
			    	</tr>\
			    	');
			});
		}
	});
});
</script>
</body>
</html>