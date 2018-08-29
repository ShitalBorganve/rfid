<!DOCTYPE html>
<html>
<head>
<?php echo '<title>'.$title.'</title>'.$meta_scripts.$css_scripts; ?>
<style>

</style>
</head>

<body>
<?php echo $navbar_scripts; ?>

<div class="container-fluid">
<h1 style="text-align: center;">List of Classes</h1>
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <?php echo form_open("tables/classes/list",'id="class-list-form" class="form-inline"');?>
      <div class="form-group">
      <label>Search Class Name</label>
        <select class="ui search dropdown form-control" name="id">
          <option value="">Select Class Name</option>
          <?php
            foreach ($classes_list["result"] as $classe_data) {
              echo '<option value="'.$classe_data->id.'">'.$classe_data->class_name.' - '.$classe_data->grade.'</option>';
            }
          ?>
        </select>
      </div>


      <div class="form-group">
      <button class="btn btn-primary" type="submit"><span class="glyphicon glyphicon-search"></span> Search</button>
      <button class="btn btn-danger" type="button" id="reset"><span class="glyphicon glyphicon-refresh"></span> Reset</button>
      </div>
      </form>
			<div class="table-responsive">
				<table class="table table-hover" id="class-list-table">
					<thead>
						<tr>
							<th>Class Name</th>
              <th>Grade or Year</th>
							<th>Classroom</th>
              <th>Schedule</th>
              <th>Class Adviser</th>
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
<div id="class_edit_modal" class="modal fade" role="dialog" tabindex="-1">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title" id="rfid_add_modal_title">Add students</h4>
    </div>
      <div class="modal-body">
        <p>
        '.form_open("class_ajax/edit",'id="class_edit_form"  class="form-horizontal"').'
          <input type="hidden" name="class_id" class="edit_field">
          <div class="form-group">
            <label class="col-sm-4" for="class_adviser">Class Adviser:</label>
            <div class="col-sm-8">
            ';
            // var_dump($teachers_list);
            echo '
              <select name="class_adviser" class="ui search dropdown form-control edit_field" id="edit-class_adviser">
                <option value="">Select a Class Adviser</option>
                ';
                foreach ($teachers_list["result"] as $teacher_data) {
                  echo '<option value="'.$teacher_data->id.'">'.$teacher_data->full_name.'</option>';
                }

                echo '
              </select>
              <p class="help-block" id="class_adviser_help-block"></p>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-4" for="class_name">Class Name:</label>
            <div class="col-sm-8">
              <input type="text" class="form-control edit_field" name="class_name" placeholder="Enter Class Name">
              <p class="help-block" id="class_class_name_help-block"></p>
            </div>
          </div>


          <div class="form-group">
            <label class="col-sm-4" for="grade">Grade or Year:</label>
            <div class="col-sm-8">
              <input type="text" class="form-control edit_field" name="grade" placeholder="Enter Grade or Year">
              <p class="help-block" id="class_grade_help-block"></p>
            </div>
          </div>


          <div class="form-group">
            <label class="col-sm-4" for="class_room">Classroom:</label>
            <div class="col-sm-8">
              <input type="text" class="form-control edit_field" name="class_room" placeholder="Enter Classroom">
              <p class="help-block" id="class_room_help-block"></p>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-4" for="class_schedule">Class Schedule:</label>
            <div class="col-sm-8">
              <input type="text" class="form-control edit_field" name="class_schedule" placeholder="Enter Class Schedule">
              <p class="help-block" id="class_schedule_help-block"></p>
            </div>
          </div>

        </form>
        </p>
      </div>
      <div class="modal-footer">
       
        <button type="submit" class="btn btn-primary" form="class_edit_form">Submit</button>
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

$(document).ready(function(e) {
  $(document).on("click",".edit_class",function(e) {
      var id = e.target.id;
      show_class_data(id);
  });
  $(".ui").dropdown("clear");
  $(document).on("click",".delete_class",function(e) {
    var datastr = "<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash();?>"+"&id="+e.target.id;
    alertify.confirm('DELETE CLASS', 'Are you sure you want to delete this class in the list?<br> This action is irreversible.', function(){
      $.ajax({
        type: "POST",
        url: "<?php echo base_url("class_ajax/delete"); ?>",
        data: datastr,
        cache: false,
        dataType: "json",
        success: function(data) {
          show_class_list();
          alertify.success(data.class_name + ' has been deleted.');
        },
        error: function(e) {
          console.log(e);
        }
      });
    },
    function(){
      alertify.error('Cancelled')
    });
  });
  function show_class_data(id) {
    $.ajax({
      type: "GET",
      url: "<?php echo base_url("class_ajax/get_data"); ?>",
      data: "class_id="+id,
      cache: false,
      dataType: "json",
      success: function(data) {
        if(data.teacher_id!=""){
          $('#edit-class_adviser').dropdown('set value',data.teacher_id);
        }else{
          $('#edit-class_adviser').dropdown('clear');
        }
        $('input[name="class_name"].edit_field').val(data.class_name);
        $('input[name="grade"].edit_field').val(data.grade);
        $('input[name="class_room"].edit_field').val(data.room);
        $('input[name="class_schedule"].edit_field').val(data.schedule);
        $('input[name="class_id"]').val(id);
        $("#class_edit_modal").modal("show");
      },
      error: function(e) {
        console.log(e);
      }
    });
  }
  $(document).on("submit","#class_edit_form",function(e) {
    e.preventDefault();
      $.ajax({
      type: "POST",
      url: $("#class_edit_form").attr("action"),
      data: $("#class_edit_form").serialize(),
      cache: false,
      dataType: "json",
      beforeSend: function() {
        $('button[form="class_edit_form"]').prop('disabled',true);
      },
      success: function(data) {
        if(data.is_valid){
          $(".help-block").html("");
          alertify.success("You have successfully the class information.");
          $("#class_edit_modal").modal("hide");
          show_class_list();
        }else{
          $("#class_adviser_help-block").html(data.class_adviser_error);
          $("#class_class_name_help-block").html(data.class_name_error);
          $("#class_grade_help-block").html(data.grade_error);
          $("#class_room_help-block").html(data.class_room_error);
          $("#class_schedule_help-block").html(data.class_schedule_error);
          $("#class_schedule_help-block").html(data.class_schedule_error);
        }
      },
      error: function(e) {
        console.log(e);
      },
      complete: function() {
        $('button[form="class_edit_form"]').prop('disabled',false);
      }
      });
    });
  $(document).on("click",".paging",function(e) {
    show_class_list(e.target.id);
  });

  $(document).on("submit","#class-list-form",function(e) {
    e.preventDefault();
    show_class_list();  
  });

  $(document).on("click","#reset",function(e) {
    $(".ui").dropdown("clear");
    show_class_list();
  });
  show_class_list();
  function show_class_list(page='1') {
    var datastr = $("#class-list-form").serialize();
    $.ajax({
      type: "GET",
      url: $("#class-list-form").attr("action"),
      data: datastr+"&page="+page,
      cache: false,
      success: function(data) {
        $("#class-list-table tbody").html(data);
      },
      error: function(e) {
        console.log(e);
      }
    });
  }
})
</script>
</body>
</html>