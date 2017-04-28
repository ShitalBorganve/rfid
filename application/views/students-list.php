<!DOCTYPE html>
<html>
<head>
<?php echo '<title>'.$title.'</title>'.$meta_scripts.$css_scripts; ?>
<style>
#display-photo-container{
  height: 10em;
  margin-bottom: 10px;
}
</style>
</head>

<?php echo $navbar_scripts; ?>
<body>

<div class="container-fluid">
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="table-responsive">
      <?php echo form_open("tables/students/list",'id="student-list-form"');?>
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
      <label>Search Last Name</label>
      <select class="ui search dropdown" name="owner_id" id="select_student">
        <option value="">Select Student's Last Name</option>
        <?php
          foreach ($students_list["result"] as $student_data) {
            echo '<option value="'.$student_data->id.'">'.$student_data->full_name.'</option>';
          }
        ?>
      </select>



      <button class="btn btn-primary" type="submit"><span class="glyphicon glyphicon-search"></span> Search</button>
      <button class="btn btn-danger" type="button" id="reset"><span class="glyphicon glyphicon-refresh"></span> Reset</button>
      <button type="submit" form="student_download_list" class="btn btn-info"><span class="glyphicon glyphicon-download"></span> Download</button>
      </form>
      <?php echo form_open("student_ajax/download",'class="form-inline" id="student_download_list"');?>

      </form>
        <table class="table table-hover" id="student-list-table">
          <thead>
            <tr>
              <th>ID</th>
              <th>RFID</th>
              <th>Last Name</th>
              <th>First Name</th>
              <th>Middle Name</th>
              <th>Suffix</th>
              <th>Gender</th>
              <th>Age</th>
              <th>Birthday</th>
              <th>Guardian</th>
              <th>Contact Number</th>
              <th>Class</th>
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
          <div class="col-sm-12">
            <div id="display-photo-container">
              <img class="img-responsive" id="display-photo" src="'.base_url("assets/images/empty.jpg").'">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2" for="last_name">Last Name:</label>
            <div class="col-sm-10"> 
              <input type="text" class="form-control edit_field" name="last_name" placeholder="Enter Last Name">
              <p class="help-block" id="last_name_help-block"></p>
            </div>
          </div>
        

          <div class="form-group">
            <label class="col-sm-2" for="first_name">First Name:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control edit_field" name="first_name" placeholder="Enter First Name">
              <p class="help-block" id="first_name_help-block"></p>
            </div>
            
          </div>

          <div class="form-group">
            <label class="col-sm-2" for="middle_name">Middle Name:</label>
            <div class="col-sm-10"> 
              <input type="text" class="form-control edit_field" name="middle_name" placeholder="Enter Middle Name">
              <p class="help-block" id="middle_name_help-block"></p>
            </div>
          </div>
          
          <div class="form-group">
            <label class="col-sm-2" for="suffix">Suffix:</label>
            <div class="col-sm-10"> 
              <input type="text" class="form-control edit_field" name="suffix" placeholder="Enter Suffix (Jr. III etc.)">
              <p class="help-block" id="suffix_help-block"></p>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2" for="guardian_name">Gender:</label>
            <div class="col-sm-10"> 
              <select name="gender" class="form-control edit_field" required>
                <option value="MALE">MALE</option>
                <option value="FEMALE">FEMALE</option>
              </select>
              <p class="help-block" id="gender_help-block"></p>
            </div>
          </div>



          <div class="form-group">
            <label class="col-sm-2" for="last_name">Birth Date:</label>
            <div class="col-sm-10">
              <select class="edit_field" name="bday_m" required>
                <option value="">MM</option>
                ';
                for ($i=1; $i <= 12; $i++) { 
                  echo '<option value="'.$i.'">'.sprintf("%02d",$i).'</option>';
                }
                echo '
              </select>
              /
              <select class="edit_field" name="bday_d" required>
                <option value="">DD</option>
                ';
                for ($i=1; $i <= 31; $i++) { 
                  echo '<option value="'.$i.'">'.sprintf("%02d",$i).'</option>';
                }
                echo '
              </select>
              /
              <select class="edit_field" name="bday_y" required>
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
            <label class="col-sm-2" for="contact_number">Contact Number:</label>
            <div class="col-sm-10"> 
              <input type="text" class="form-control edit_field" name="contact_number" placeholder="Enter Contact Number">
              <p class="help-block" id="contact_number_help-block"></p>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2" for="address">Address:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control edit_field" name="address" placeholder="Enter Address">
              <p class="help-block" id="address_help-block"></p>
            </div>
            
          </div>

          <div class="form-group">
            <label class="col-sm-2" for="guardian">Guardians Contact Number:</label>
            <div class="col-sm-10"> 
              <select name="guardian_id" id="edit-guardian_id" class="ui search dropdown form-control edit_field">
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
            <label class="col-sm-2" for="guardian_name">Father&apos;s Name:</label>
            <div class="col-sm-10"> 
              <input type="text" class="form-control edit_field" name="fathers_name" placeholder="Enter Father&apos;s Name">
              <p class="help-block" id="fathers_name_help-block"></p>
            </div>
          </div>



          <div class="form-group">
            <label class="col-sm-2" for="guardian_name">Mother&apos;s Name:</label>
            <div class="col-sm-10"> 
              <input type="text" class="form-control edit_field" name="mothers_name" placeholder="Enter Mother&apos;s Name">
              <p class="help-block" id="mothers_name_help-block"></p>
            </div>
          </div>




          <div class="form-group">
            <label class="col-sm-2" for="class_id">Class:</label>
            <div class="col-sm-10"> 
              <select name="class_id" id="edit-class_id" class="ui search dropdown form-control edit_field">
                <option value="">Select a Class</option>
                ';
                foreach ($classes_list["result"] as $class_data) {
                  echo '<option value="'.$class_data->id.'">'.$class_data->class_name.'</option>';
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

$(document).on("click","#reset",function(e) {
  $(".ui").dropdown("clear");
  show_student_list();
});



$(document).on("click",".add_rfid_student",function(e) {
  var id = e.target.id;
  $('input[name="type"]').val("students");
  $('input[name="id"]').val(id);
  $("#rfid_add_modal_title").html("scan student&apos;s rfid");
  $("#rfid_scan_add_modal").modal("show");
});

$(document).on("click",".delete_rfid_student",function(e) {
  if(confirm("Are you sure you want to remove the rfid of this student? This action is irreversible.")){
    var datastr = "id="+e.target.id+"&type=students";
    $.ajax({
      type: "POST",
      url: "<?php echo base_url("rfid_ajax/delete"); ?>",
      data: datastr,
      cache: false,
      success: function(data) {
        show_student_list();
      }
    });
  }
});


$(document).on("submit","#rfid_scan_add_form",function(e) {
  e.preventDefault();
  $.ajax({
    type: "POST",
    url: $("#rfid_scan_add_form").attr("action"),
    data: $("#rfid_scan_add_form :input").serialize(),
    cache: false,
    dataType: "json",
    success: function(data) {
      $('input[name="rfid"]').val("");
      
      
      if(data.is_valid){
        $("#rfid_scan_add_modal").modal("hide");
        $(".help-block").html("");

        $("#alert-modal").modal("show");
        $("#alert-modal-title").html("scan student&apos;s rfid");
        $("#alert-modal-body p").html("You have successfully added the rfid of the student.");
        show_student_list();
      }else{
        $("#rfid_scan_help-block").html(data.error);
        $("#rfid_valid_date_help-block").html(data.date_error);
      }
    }
  });
});



$(document).on("click",".edit_student",function(e) {
    var id = e.target.id;
    show_student_data(id);
});

$(document).on("click",".delete_student",function(e) {
  var datastr = "id="+e.target.id;
  if(confirm("Are you sure you want to delete this student? This acton is irreversible.")){
    $.ajax({
      type: "POST",
      url: "<?php echo base_url("student_ajax/delete"); ?>",
      data: datastr,
      cache: false,
      success: function(data) {
        show_student_list();
      }
    });
  }
});

function show_student_data(id) {
  $.ajax({
    type: "GET",
    url: "<?php echo base_url("student_ajax/get_data"); ?>",
    data: "student_id="+id,
    cache: false,
    dataType: "json",
    success: function(data) {
      $("#display-photo").attr("src","<?php echo base_url("assets/images/student_photo/");?>"+data.display_photo);
      $('input[name="student_id"]').val(id);
      $('input[name="first_name"].edit_field').val(data.first_name);
      $('input[name="last_name"].edit_field').val(data.last_name);
      $('input[name="address"].edit_field').val(data.address);
      $('select[name="gender"].edit_field').val(data.gender);
      $('input[name="mothers_name"].edit_field').val(data.mothers_name);
      $('input[name="fathers_name"].edit_field').val(data.fathers_name);
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


$(document).on("submit","#student_edit_form",function(e) {
	e.preventDefault();
  $('button[form="student_edit_form"]').prop('disabled', true);
  $.ajax({
    url: $(this).attr('action'),
    data: new FormData(this),
    processData: false,
    contentType: false,
    method:"POST",
    dataType: "json",
    success: function(data) {
      $('button[form="student_edit_form"]').prop('disabled', false);
			$("#first_name_help-block").html(data.first_name_error);
      $("#last_name_help-block").html(data.last_name_error);
      $("#address_help-block").html(data.address_error);
      $("#gender_help-block").html(data.gender_error);
      $("#mothers_name_help-block").html(data.mothers_name_error);
			$("#fathers_name_help-block").html(data.fathers_name_error);
			$("#middle_name_help-block").html(data.middle_name_error);
      $("#suffix_help-block").html(data.suffix_error);
			$("#contact_number_help-block").html(data.contact_number_error);
			$("#bday_help-block").html(data.bday_error);
			$("#guardian_id_help-block").html(data.guardian_id_error);
			$("#student_photo_help-block").html(data.student_photo_error);
			$("#student_id_help-block").html(data.student_id_error);
			if(data.is_valid){
        $("#student_edit_form")[0].reset();
        $(".ui .dropdown").dropdown("clear");
				$("#student_edit_modal").modal("hide");
				$("#alert-modal").modal("show");
				$("#alert-modal-title").html("Edit Student Information");
				$("#alert-modal-body p").html("You have successfully editted a student's information.");
			}
		}
	});
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

$(document).on("submit","#student_download_list",function(e) {
  e.preventDefault();
  $.ajax({
    type: "GET",
    url: $("#student_download_list").attr("action"),
    cache: false,
    success: function(data) {
      window.location = data;
    }
  });
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