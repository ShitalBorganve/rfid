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
      <?php echo form_open("tables/students/list",'id="student-list-form"');?>
      <label>Seaarch</label>
      <input type="text" name="search_last_name" placeholder="Enter Last Name" id="search_last_name">
      <input type="hidden" name="owner_id">
      </form>
				<table class="table table-hover" id="student-list-table">
					<thead>
						<tr>
							<th>RFID</th>
							<th>Full Name</th>
							<th>Edit</th>
						</tr>
					</thead>
					<tbody>

					</tbody>
				</table>
			</div>
		</div>
	</div>

</div>

<?php
echo '

<!--Edit Student Modal -->
<div id="student_edit_modal" class="modal fade" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Students</h4>
      </div>
      <div class="modal-body">
        <p>'.form_open_multipart("student_ajax/edit",'id="student_edit_form" class="form-horizontal"').'
        <input type="hidden" name="student_id">


          <div class="form-group">
            <label class="col-sm-2" for="first_name">First Name:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="first_name" placeholder="Enter First Name">
              <p class="help-block" id="first_name_help-block"></p>
            </div>
            
          </div>
          
          <div class="form-group">
            <label class="col-sm-2" for="last_name">Last Name:</label>
            <div class="col-sm-10"> 
              <input type="text" class="form-control" name="last_name" placeholder="Enter Last Name">
              <p class="help-block" id="last_name_help-block"></p>
            </div>
          </div>
          
          <div class="form-group">
            <label class="col-sm-2" for="middle_name">Middle Name:</label>
            <div class="col-sm-10"> 
              <input type="text" class="form-control" name="middle_name" placeholder="Enter Middle Name">
              <p class="help-block" id="middle_name_help-block"></p>
            </div>
          </div>
          
          <div class="form-group">
            <label class="col-sm-2" for="suffix">Suffix:</label>
            <div class="col-sm-10"> 
              <input type="text" class="form-control" name="suffix" placeholder="Enter Suffix (Jr. III etc.)">
              <p class="help-block" id="suffix_help-block"></p>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2" for="last_name">Birth Date:</label>
            <div class="col-sm-10">
              <select class="" name="bday_m" required>
                <option value="">MM</option>
                ';
                for ($i=1; $i <= 12; $i++) { 
                  echo '<option value="'.$i.'">'.sprintf("%02d",$i).'</option>';
                }
                echo '
              </select>
              /
              <select class="" name="bday_d" required>
                <option value="">DD</option>
                ';
                for ($i=1; $i <= 31; $i++) { 
                  echo '<option value="'.$i.'">'.sprintf("%02d",$i).'</option>';
                }
                echo '
              </select>
              /
              <select class="" name="bday_y" required>
                <option value="">YYYY</option>
                ';
                for ($i=1980; $i <= date("Y"); $i++) { 
                  echo '<option value="'.$i.'">'.sprintf("%04d",$i).'</option>';
                }
                echo '
              </select>
              <p class="help-block" id="bday_help-block"></p>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2" for="guardian">Guardians Email:</label>
            <div class="col-sm-10"> 
              <select name="guardian_id">
                <option value="">Select a Guardians Email</option>
                ';
                foreach ($guardians_list as $guardian_data) {
                  echo '<option value="'.$guardian_data->id.'">'.$guardian_data->contact_number.'</option>';
                }
                echo '
              </select>

              <p class="guardian_id_help-block"></p>
            </div>
          </div>


          <div class="form-group">
            <label class="col-sm-2" for="class_id">Class:</label>
            <div class="col-sm-10"> 
              <select name="class_id" data-live-search="true">
                <option value="">Select a Class</option>
                ';
                foreach ($classes_list["result"] as $class_data) {
                  echo '<option data-tokens="'.$class_data->class_name.'" value="'.$class_data->id.'">'.$class_data->class_name.'</option>';
                }

                echo '
              </select>

              <p class="class_help-block"></p>
            </div>
          </div>


          <div class="form-group">
            <label class="col-sm-2" for="student_photo">Photo:</label>
            <div class="col-sm-10">
            <input type="file" name="student_photo" size="20" class="form-control">
              <p class="help-block" id="student_photo_help-block"></p>
            </div>
          </div>

        </form></p>
      </div>
      <div class="modal-footer">
      <p class="help-block" id="student_id_help-block"></p>
        <button type="submit" class="btn btn-primary" form="student_edit_form">Submit</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

';

?>
<?php echo $modaljs_scripts; ?>
<?php echo $js_scripts; ?>
<script>


$(document).on("click",".edit_student",function(e) {
    var id = e.target.id;
    show_student_data(id);
});

function show_student_data(id) {
  $.ajax({
    type: "GET",
    url: "<?php echo base_url("student_ajax/get_data"); ?>",
    data: "student_id="+id,
    cache: false,
    dataType: "json",
    success: function(data) {
      $('input[name="student_id"]').val(id);
      $('input[name="first_name"]').val(data.first_name);
      $('input[name="last_name"]').val(data.last_name);
      $('input[name="middle_name"]').val(data.middle_name);
      $('input[name="suffix"]').val(data.suffix);
      $('select[name="bday_m"]').val(data.bday_m);
      $('select[name="bday_d"]').val(data.bday_d);
      $('select[name="bday_y"]').val(data.bday_y);
      $('select[name="guardian_id"]').val(data.guardian_id);
      $('select[name="class_id"]').val(data.class_id);
      $("#student_edit_modal").modal("show");
    }
  });
}


$(document).on("submit","#student_edit_form",function(e) {
	e.preventDefault();
	$.ajax({
		url: $(this).attr('action'),
		data: new FormData(this),
		processData: false,
		contentType: false,
		method:"POST",
		dataType: "json",
		success: function(data) {
			$("#first_name_help-block").html(data.first_name_error);
			$("#last_name_help-block").html(data.last_name_error);
			$("#middle_name_help-block").html(data.middle_name_error);
			$("#suffix_help-block").html(data.suffix_error);
			$("#bday_help-block").html(data.bday_error);
			$("#guardian_id_help-block").html(data.guardian_id_error);
			$("#student_photo_help-block").html(data.student_photo_error);
			$("#student_id_help-block").html(data.student_id_error);
			if(data.is_valid){
				$("#student_edit_modal").modal("hide");
				$("#alert-modal").modal("show");
				$("#alert-modal-title").html("Edit Student Information");
				$("#alert-modal-body p").html("You have successfully editted a student's information.");
			}
		}
	});
});
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
</script>
</body>
</html>