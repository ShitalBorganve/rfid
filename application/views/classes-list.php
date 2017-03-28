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
      <?php echo form_open("tables/classes/list",'id="class-list-form"');?>
      <label>Seaarch</label>
      <input type="text" name="last_name" placeholder="Enter Last Name" id="search_last_name">
      </form>
				<table class="table table-hover" id="class-list-table">
					<thead>
						<tr>
							<th>Class Name</th>
							<th>Classroom</th>
              <th>Schedule</th>
							<th></th>
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
<!-- Edit Class Modal -->
<div id="class_add_modal" class="modal fade" role="dialog" tabindex="-1">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title" id="rfid_add_modal_title">Add students</h4>
    </div>
      <div class="modal-body">
        <p>
        '.form_open("class_ajax/edit",'id="class_add_form"  class="form-horizontal"').'

          <div class="form-group">
            <label class="col-sm-4" for="class_adviser">Class Adviser:</label>
            <div class="col-sm-8">
            ';
            // var_dump($teachers_list);
            echo '
              <select name="class_adviser">
                <option value="">Select a Class Adviser</option>
                ';
                foreach ($teachers_list["result"] as $teacher_data) {
                  echo '<option data-tokens="'.$teacher_data->full_name.'" value="'.$teacher_data->id.'">'.$teacher_data->full_name.'</option>';
                }

                echo '
              </select>
              <p class="help-block" id="class_adviser_help-block"></p>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-4" for="class_name">Class Name:</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" name="class_name" placeholder="Enter Class Name">
              <p class="help-block" id="class_name_help-block"></p>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-4" for="class_room">Classroom:</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" name="class_room" placeholder="Enter Classroom">
              <p class="help-block" id="class_room_help-block"></p>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-4" for="class_schedule">Class Schedule:</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" name="class_schedule" placeholder="Enter Class Schedule">
              <p class="help-block" id="class_schedule_help-block"></p>
            </div>
          </div>

        </form>
        </p>
      </div>
      <div class="modal-footer">
       
        <button type="submit" class="btn btn-primary" form="class_add_form">Submit</button>
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


$(document).on("click",".edit_class",function(e) {
    var id = e.target.id;
    // alert(id);
    show_class_data(id);
});
function show_class_data(id) {
  $.ajax({
    type: "POST",
    url: "<?php echo base_url("class_ajax/get_data"); ?>",
    data: "class_id="+id,
    cache: false,
    // dataType: "json",
    success: function(data) {
      alert(data);
/*      $('input[name="class_id"]').val(id);
      $('input[name="first_name"]').val(data.first_name);
      $('input[name="last_name"]').val(data.last_name);
      $('input[name="middle_name"]').val(data.middle_name);
      $('input[name="suffix"]').val(data.suffix);
      $('select[name="bday_m"]').val(data.bday_m);
      $('select[name="bday_d"]').val(data.bday_d);
      $('select[name="bday_y"]').val(data.bday_y);
      $('select[name="guardian_id"]').val(data.guardian_id);
      $('select[name="class_id"]').val(data.class_id);*/
      $("#class_edit_modal").modal("show");
    }
  });
}

$(document).on("submit","#class_edit_form",function(e) {
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
			$("#class_class_id_help-block").html(data.class_id_error);
			$("#class_photo_help-block").html(data.class_photo_error);
			$("#class_id_help-block").html(data.class_id_error);
			if(data.is_valid){
				$("#class_edit_modal").modal("hide");
				$("#alert-modal").modal("show");
				$("#alert-modal-title").html("Edit class Information");
				$("#alert-modal-body p").html("You have successfully editted a class's information.");
			}
		}
	});
});
$(document).on("click",".paging",function(e) {
	show_class_list(e.target.id);
});

$("#search_last_name").autocomplete({
  source: "<?php echo base_url("search/classes/list"); ?>",
  select: function(event, ui){
      show_class_data(ui.item.data);
      $("#search_last_name").val("");
      // alert(data);
    // window.location='item?s='+ui.item.data;
  }
});

show_class_list();
function show_class_list(page='1') {
  var datastr = $("#class-list-form").serialize();
	$.ajax({
		type: "POST",
    url: $("#class-list-form").attr("action"),
		data: datastr+"&page="+page,
		cache: false,
		success: function(data) {
			$("#class-list-table tbody").html(data);
		}
	});
}
</script>
</body>
</html>