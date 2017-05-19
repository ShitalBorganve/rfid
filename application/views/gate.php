<!DOCTYPE html>
<html>
<head>
<?php echo '<title>'.$title.'</title>'.$meta_scripts.$css_scripts; ?>
<style>

</style>
</head>

<body id="has-logo">
<?php echo $navbar_scripts; ?>
<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12" style="font-size: 5.9vw;display: block;padding: 1.7vw">
			<center>
			<b style="background-color: white;" id="gate-time"><?php echo date("h:i:s A"); ?></b>
			</center>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<?php echo form_open("rfid_ajax/scangate",'id="gate_rfid_scan"'); ?>
				<center>
				<input type="text" name="gate_rfid_scan" autocomplete="off" autofocus>
				</center>
			</form>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<div id="display-photo-container">
				<img class="img-responsive" id="display-photo" src="<?php echo base_url("assets/images/empty.jpg");?>">
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-6 col-md-push-3">
			<div class="table-responsive" style="background-color: white;">
				<table class="table table-hover">
					<thead>
						<tr>
							<th colspan="2" class="table-header" style="text-transform: uppercase;"><span id="rfid_owner"></span> Information</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th>Last Name:</th>
							<td><span id="gate_rfid_last_name"></span></td>
						</tr>
						<tr>
							<th>First Name:</th>
							<td><span id="gate_rfid_first_name"></span></td>
						</tr>
						<tr>
							<th>Middle Name:</th>
							<td><span id="gate_rfid_middle_name"></span></td>
						</tr>
						<tr>
							<th><span id="designation_label">Designation:</span></th>
							<td><span id="designation_value"></span></td>
						</tr>
						<tr>
							<th colspan="2" id="gate_status" class="table-header"></th>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<?php echo $modaljs_scripts; ?>
<?php echo $js_scripts; ?>
<script>
$("document").ready(function() {
	setInterval(function(){
		$("#gate-time").html(moment().format('hh:mm:ss A'));
	}, 500);
	var timerId;
	$("#gate_rfid_scan").submit(function(e) {
		e.preventDefault();
		$.ajax({
			type: "POST",
			url: $("#gate_rfid_scan").attr("action"),
			data: $("#gate_rfid_scan :input").serialize(),
			cache: false,
			dataType: "json",
			beforeSend: function() {
				clearTimeout(timerId);
			},
			success: function(data) {
				$("#gate_rfid_scan")[0].reset();
				$("#gate_rfid_last_name").html(data.last_name);
				$("#designation_label").html(data.designation_label);
				$("#designation_value").html(data.designation_value);
				$("#gate_rfid_first_name").html(data.first_name);
				$("#gate_rfid_middle_name").html(data.middle_name);
				$("#gate_rfid_suffix").html(data.suffix);
				$("#gate_status").removeClass( "danger success" );
				$("#gate_status").html("");
				if(data.is_valid){
					$("#rfid_scan").val("");
					$("#display-photo").attr("src",data.display_photo);
					$("#rfid_owner").html(data.rfid_data.owner_type + "'S");

					if(data.gate_logs_data.is_valid){
						$("#gate_status").html('<b>'+data.full_name + "</b> " + data.type_status+ ' the school premises on <br><span style="font-size: 30px;">'+data.gate_logs_data.date_time_passed+"</span>");
						$("#gate_status").removeClass( "danger success" ).addClass("success");
						if((data.guardian_sms_subscription == "1" && data.rfid_data.owner_type == "student") || (data.in_case_contact_number_sms == "1" && (data.rfid_data.owner_type == "teacher" || data.rfid_data.owner_type == "staff"))){
							if(data.status_code == "0"){
								alertify.success(data.sms_status);
							}else{
								alertify.error(data.sms_status);
							}
						}
					}else{
						$("#gate_status").html("<b>"+data.full_name+"</b> had recently passed the gate. Try again later.");
						$("#gate_status").removeClass( "danger success" ).addClass("danger");
					}
				}else{
					$("#display-photo").attr("src",data.display_photo);
					$("#rfid_scan").val("");
				}
			},
			error: function(e) {
				console.log(e);
			},
			complete: function() {
				timerId = setTimeout(function(){
					$("#rfid_owner").html("")
					$("#gate_rfid_last_name").html("");
					$("#gate_rfid_first_name").html("");
					$("#gate_rfid_middle_name").html("");
					$("#designation_value").html("");
					$("#designation_label").html("Designation:");
					$("#gate_status").html("");
					$("#gate_status").removeClass( "danger success" );
					$("#display-photo").attr("src","<?php echo base_url("assets/images/empty.jpg");?>");
				}, 10000);
				$(".help-block").html("");
			}
		});
	return false;
	});
});
</script>
</body>
</html>