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
					Students Gate Logs
				</h1>
				<?php echo form_open("tables/gate_logs", 'id="gate_logs-form" class="form-inline'); ?>
				<input type="hidden" name="ref_table" value="students">
				<div class="form-group">
				<label>Class:</label>
				<?php
				echo '
				<select class="ui search dropdown" id="select_class" name="class_id">
				  <option value="">All Class</option>
				  ';
				  foreach ($classes_list["result"] as $class_data) {
				    echo '<option value="'.$class_data->id.'">'.$class_data->class_name.'</option>';
				  }

				  echo '
				</select>
				';
				?>
				</div>

				<div class="form-group">
				<label>Last Name:</label>
				<?php
				echo '
				<select class="ui search dropdown" id="select_student" name="ref_id">
					<option value="">Search for Student&apos;s Last Name</option>
					';
					foreach ($students_list["result"] as $student_data) {
						echo '<option value="'.$student_data->id.'">'.$student_data->full_name.'</option>';
					}

					echo '
				</select>
				';
				?>
				</div>

				<div class="form-group">
				<label>Date From:</label>
				<input type="text" class="form-control" name="date_from" id="datepicker_from" value="<?php echo date("m/d/Y");?>" readonly>
				</div>
				<div class="form-group">
				<label>Date To:</label>
				<input type="text" class="form-control" name="date_to" id="datepicker_to" value="<?php echo date("m/d/Y");?>" readonly>
				<button type="submit" class="btn btn-primary" form="gate_logs-form"><span class="glyphicon glyphicon-search"></span> Search</button>
				</div>
				<span class="btn btn-danger" id="gate_logs-reset_search"><span class="glyphicon glyphicon-refresh"></span> Reset</span>
				</form>
				<table class="table table-hover" id="gatelogs-table">
					<thead>
						<tr>
							<th>ID</th>
							<th>Full Name</th>
							<th>Date</th>
							<th>Time</th>
							<th>Type</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	</div>

</div>
<?php echo $modaljs_scripts; ?>
<?php echo $js_scripts; ?>
<script>
$(document).on("submit","#gate_logs-form",function(e) {
	e.preventDefault();
	$('input[name="ref_id"]').removeAttr("value");
	show_gatelogs();
});
$(document).on("click",".gate_logs",function(e) {
	$('input[name="ref_id"]').val(e.target.id);
	show_gatelogs();
});


$("#search_last_name").autocomplete({
	source: function(request, response) {
	    $.ajax({
	        url: "<?php echo base_url("search/students/gate_logs"); ?>",
	        dataType: "json",
	        data: {
	            term : request.term,
	            ref_table : $("#ref_table").val()
	        },
	        success: function(data) {
	            response(data);
	        }
	    });
	},
	select: function(event, ui){
			$('input[name="ref_id"]').val(ui.item.data);
			
			show_gatelogs(1,true);
	}
});

$(document).on("change","#ref_table",function(e) {
	$('input[name="ref_id"]').val("");
	show_gatelogs();
});
$(document).on("change",'#select_class',function(e) {
	// show_gatelogs();
	$('#select_student').dropdown("clear");
	$('#select_student').html("");
	$('#select_student').append('<option value="">Select a Class</option>');
	var datastr = "class_id="+e.target.value;
	$.ajax({
		type: "GET",
		url: "<?php echo base_url("student_ajax/get_list/admin"); ?>",
		data: datastr,
		cache: false,
		dataType: "json",
		success: function(data) {
			$.each(data, function(i, item) {
			    $('#select_student').append('<option value="'+data[i].id+'">'+data[i].full_name+'</option>');
			});
		}
	});
});
$(document).on("change","#datepicker_from,#datepicker_to",function(e) {
	show_gatelogs();
});
$(document).on("click","#gate_logs-reset_search",function(e) {
	$("#gate_logs-form")[0].reset();
	$('input[name="ref_id"]').val("");
	$(".ui.dropdown").dropdown("clear");
	$('#select_student').html("");
	$('#select_student').append('<option value="">Select a Class</option>');
	var datastr = "get=1";
	$.ajax({
		type: "GET",
		url: "<?php echo base_url("student_ajax/get_list/admin"); ?>",
		data: datastr,
		cache: false,
		dataType: "json",
		success: function(data) {
			$.each(data, function(i, item) {
			    $('#select_student').append('<option value="'+data[i].id+'">'+data[i].full_name+'</option>');
			});
		}
	});
	show_gatelogs();
});

$(document).on("click",".paging",function(e) {
	show_gatelogs(e.target.id);
});

show_gatelogs();
function show_gatelogs(page=1,clear) {
	var data_str = $("#gate_logs-form").serialize();
	$.ajax({
		type: "GET",
		url: $("#gate_logs-form").attr("action"),
		data: data_str+"&page="+page,
		cache: false,
		success: function(data) {
			$("#gatelogs-table tbody").html(data);
			if(clear){
				$("#search_last_name").val("");
			}
			
		}
	});
}
</script>
</body>
</html>