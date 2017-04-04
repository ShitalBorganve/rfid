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
			<?php echo form_open("tables/students/list/jbtech",'id="student-list-form"');?>
			<label>Search</label>
			<input type="text" name="search_last_name" placeholder="Enter Last Name" id="search_last_name">
			
			
			<div class="checkbox">
			<input type="hidden" name="owner_id">
			</form>

			<table class="table table-hover" id="student-list-table">
			  <thead>
			    <tr>
			      <th>First Name</th>
			      <th>Middle Name</th>
			      <th>Last Name</th>
			      <th>Birthday</th>
			      <th>Guardian</th>
			      <th>Contact Number</th>
			      <th>Class</th>
			      <th>RFID</th>
			    </tr>
			  </thead>
			  <tbody>

			  </tbody>
			</table>
		</div>
	</div>

</div>
<?php echo $modaljs_scripts; ?>

<?php echo $js_scripts; ?>
<script>

$(document).on("click",".paging",function(e) {
	show_student_list(e.target.id);
});

$("#search_last_name").autocomplete({
  source: "<?php echo base_url("search/students/list"); ?>",
  select: function(event, ui){
      $('input[name="owner_id"]').val(ui.item.data);
      show_student_list(1,true);
  }
});

$(document).on("submit","#student-list-form",function(e) {
  e.preventDefault();
  $('input[name="owner_id"]').removeAttr('value');
  show_student_list();
});

$(document).on("change",'input[name="has_rfid"]',function(e) {
	show_student_list();
});

$(document).on("click",".view_student",function(e) {
	
});

show_student_list();
function show_student_list(page='1',clear=false) {

  var datastr = $("#student-list-form").serialize();
	$.ajax({
		type: "GET",
    url: $("#student-list-form").attr("action"),
		data: datastr+"&page="+page,
		cache: false,
		success: function(data) {
      if(clear){
        $("#search_last_name").val("");
      }
			$("#student-list-table tbody").html(data);
		}
	});
}


function show_student_data(id) {
  $.ajax({
    type: "GET",
    url: "<?php echo base_url("student_ajax/get_data"); ?>",
    data: "student_id="+id,
    cache: false,
    dataType: "json",
    success: function(data) {
      $('input[name="student_id"]').val(id);
      $('input[name="first_name"].edit_field').val(data.first_name);
      $('input[name="last_name"].edit_field').val(data.last_name);
      $('input[name="middle_name"].edit_field').val(data.middle_name);
      $('input[name="suffix"].edit_field').val(data.suffix);
      $('input[name="contact_number"].edit_field').val(data.contact_number);
      $('select[name="bday_m"].edit_field').val(data.bday_m);
      $('select[name="bday_d"].edit_field').val(data.bday_d);
      $('select[name="bday_y"].edit_field').val(data.bday_y);
      if(data.guardian_id!=""){
        $('#edit-guardian_id').dropdown('set value',data.guardian_id);
      }else{
        $('#edit-guardian_id').dropdown('clear');
      }
      if(data.class_id!=""){
        $('#edit-class_id').dropdown('set value',data.class_id);
      }else{
        $('#edit-class_id').dropdown('clear');
      }
      $("#student_edit_modal").modal("show");
    }
  });
}
</script>
</body>
</html>