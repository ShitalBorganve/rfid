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
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="table-responsive">
				<h1 style="text-align: center;">
					Gate Logs
				</h1>
				<?php echo form_open("tables/gate_logs", 'id="gate_logs-form"'); ?>
				<input type="hidden" name="rfid_id">
				<span class="btn btn-danger" id="gate_logs-reset_search">Reset</span>
				<label>Last Name:</label>
				<input type="text" name="search_last_name" id="search_last_name">
				<label>Date From:</label>
				<input type="text" name="date_from" id="datepicker_from" readonly>
				<label>Date To:</label>
				<input type="text" name="date_to" id="datepicker_to" readonly>
				</form>
				<table class="table table-hover" id="gatelogs-table">
					<thead>
						<tr>
							<th>Type</th>
							<th>Full Name</th>
							<th>RFID</th>
							<th>Date</th>
							<th>Time</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
	</div>

</div>
<?php echo $modaljs_scripts; ?>
<?php echo $js_scripts; ?>
<script>
$(document).on("submit","#gate_logs-form",function(e) {
	// e.preventDefault();
	$('input[name="rfid_id"]').val("");
	show_gatelogs();
});
$(document).on("click",".gate_logs",function(e) {
	$('input[name="rfid_id"]').val(e.target.id);
	show_gatelogs();
});

$("#search_last_name").autocomplete({
	source: "<?php echo base_url("search/students/gate_logs"); ?>",
	select: function(event, ui){
			$("#search_last_name").val("");
			$('input[name="rfid_id"]').val(ui.item.data);
			show_gatelogs();
	}
});

$(document).on("change","#datepicker_from,#datepicker_to",function(e) {
	show_gatelogs();
});
$(document).on("click","#gate_logs-reset_search",function(e) {
	$('input[name="rfid_id"]').val("");
	$("#search_last_name").val("");
	$("#datepicker_from").val("");
	$("#datepicker_to").val("");
	show_gatelogs();
});


show_gatelogs();
function show_gatelogs(page=1) {
	var data_str = $("#gate_logs-form").serialize();
	$.ajax({
		type: "POST",
		url: $("#gate_logs-form").attr("action"),
		data: data_str+"&page="+page,
		cache: false,
		success: function(data) {
			$("#gatelogs-table tbody").html(data);
		}
	});
}
</script>
</body>
</html>