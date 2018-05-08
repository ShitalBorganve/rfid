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

<body>
<?php echo $navbar_scripts; ?>

<div class="container-fluid">
<h1 style="text-align: center;">List of Students</h1>
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      
      <?php echo form_open("tables/students/list",'id="student-list-form" class="form-inline"');?>
      <div class="form-group">
      <label>Class:</label>
      <?php
      echo '
      <select class="ui search dropdown form-control" id="select_class" name="class_id">
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
      <label>Search Last Name</label>
      <select class="ui search dropdown" name="owner_id" id="select_student">
        <option value="">Select Student's Last Name</option>
        <?php
          foreach ($students_list["all"] as $student_data) {
            echo '<option value="'.$student_data->id.'">'.$student_data->full_name.'</option>';
          }
        ?>
      </select>
      </div>
      <div class="form-group">



      <button class="btn btn-primary" type="submit" form="student-list-form"><span class="glyphicon glyphicon-search"></span> Search</button>
      <button class="btn btn-danger" type="button" id="reset"><span class="glyphicon glyphicon-refresh"></span> Reset</button>
      <button type="submit" form="student_download_list" class="btn btn-info"><span class="glyphicon glyphicon-download"></span> Download</button>
      </div>
      </form>
      <?php echo form_open("student_ajax/download",'class="form-inline" id="student_download_list"');?>

      </form>
      <div class="table-responsive">
        <table class="table table-hover" id="student-list-table">
          <thead>
            <tr>
              <th>ID</th>
              <th>LRN</th>
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
            <label class="col-sm-2" for="lrn_number">LRN Number:</label>
            <div class="col-sm-10"> 
              <input type="text" class="form-control edit_field" name="lrn_number" placeholder="Enter LRN Number">
              <p class="help-block" id="lrn_number_help-block"></p>
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
            <label class="col-sm-2" for="last_name">Last Name:</label>
            <div class="col-sm-10"> 
              <input type="text" class="form-control edit_field" name="last_name" placeholder="Enter Last Name">
              <p class="help-block" id="last_name_help-block"></p>
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
            <label class="col-sm-2" for="contact_number">Contact Number:</label>
            <div class="col-sm-10"> 
              <input type="text" class="form-control edit_field" name="contact_number" placeholder="Enter Contact Number">
              <p class="help-block" id="contact_number_help-block"></p>
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
              <label class="col-sm-2" for="age_as_of_august">Age as of August 31st(of the current year):</label>
              <div class="col-sm-10">
                <input type="text" class="form-control edit_field" name="age_as_of_august" placeholder="Enter Age">
                <p class="help-block" id="age_help-block"></p>
              </div>
              
            </div>

            <div class="form-group">
              <label class="col-sm-2" for="mother_tongue">Mother Tongue:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control edit_field" name="mother_tongue" placeholder="Enter Mother Tongue">
                <p class="help-block" id="mother_tongue_help-block"></p>
              </div>
              
            </div>

            <div class="form-group">
              <label class="col-sm-2" for="ethnic_group">Ethnic Group:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control edit_field" name="ethnic_group" placeholder="Enter Ethnic Group">
                <p class="help-block" id="ethnic_group_help-block"></p>
              </div>
              
            </div>

            <div class="form-group">
              <label class="col-sm-2" for="religion">Religion:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control edit_field" name="religion" placeholder="Enter Religion">
                <p class="help-block" id="religion_help-block"></p>
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
              <label class="col-sm-2" for="is_transferee">Transferee:</label>
              <div class="col-sm-10">
                <label class="radio-inline"><input class="edit_field" type="radio" name="is_transferee" id="is_transferee_yes" value="1">Yes</label>
                <label class="radio-inline"><input class="edit_field" type="radio" name="is_transferee" id="is_transferee_no" value="0">No</label>
                <p class="help-block" id="is_transferee_help-block"></p>
              </div>
              
            </div>

            <div class="form-group">
              <label class="col-sm-2" for="last_school_attended">Last School Attended:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control edit_field" name="last_school_attended" placeholder="Enter Last School Attended">
                <p class="help-block" id="last_school_attended_help-block"></p>
              </div>
              
            </div>

            <div class="form-group">
              <label class="col-sm-2" for="last_year_attended">Last Year Attended:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control edit_field" name="last_year_attended" placeholder="Enter Last Year Attended">
                <p class="help-block" id="last_year_attended_help-block"></p>
              </div>
              
            </div>

            <div class="form-group">
              <label class="col-sm-2" for="last_grade_attended">Last Grade Attended:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control edit_field" name="last_grade_attended" placeholder="Enter Last Grade Attended">
                <p class="help-block" id="last_grade_attended_help-block"></p>
              </div>
              
            </div>

            <div class="form-group">
              <label class="col-sm-2" for="last_track_strand">Last Track - Strand:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control edit_field" name="last_track_strand" placeholder="Enter Last Track - Strand">
                <p class="help-block" id="last_track_strand_help-block"></p>
              </div>
              
            </div>

            <div class="form-group">
              <label class="col-sm-2" for="academic_track">Academic Track:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control edit_field" name="academic_track" placeholder="Enter Academic Track">
                <p class="help-block" id="academic_track_help-block"></p>
              </div>
              
            </div>

            <div class="form-group">
              <label class="col-sm-2" for="tech_voc_track">Technical-Vocational Livelihood Track:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control edit_field" name="tech_voc_track" placeholder="Enter Technical-Vocational Livelihood Track">
                <p class="help-block" id="tech_voc_track_help-block"></p>
              </div>
              
            </div>

            <div class="form-group">
              <label class="col-sm-2" for="fathers_last_name">Father&apos;s Last Name:</label>
              <div class="col-sm-10"> 
                <input type="text" class="form-control edit_field" name="fathers_last_name" placeholder="Enter Father&apos;s Last Name">
                <p class="help-block" id="fathers_last_name_help-block"></p>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2" for="fathers_middle_name">Father&apos;s Middle Name:</label>
              <div class="col-sm-10"> 
                <input type="text" class="form-control edit_field" name="fathers_middle_name" placeholder="Enter Father&apos;s Middle Name">
                <p class="help-block" id="fathers_middle_name_help-block"></p>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2" for="fathers_first_name">Father&apos;s First Name:</label>
              <div class="col-sm-10"> 
                <input type="text" class="form-control edit_field" name="fathers_first_name" placeholder="Enter Father&apos;s First Name">
                <p class="help-block" id="fathers_first_name_help-block"></p>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2" for="fathers_contact_number">Fathers&apos;s Contact Number:</label>
              <div class="col-sm-10"> 
                <input type="text" class="form-control edit_field" name="fathers_contact_number" placeholder="Enter Fathers&apos;s Contact Number">
                <p class="help-block" id="fathers_contact_number_help-block"></p>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2" for="fathers_address">Fathers&apos;s Address:</label>
              <div class="col-sm-10"> 
                <input type="text" class="form-control edit_field" name="fathers_address" placeholder="Enter Fathers&apos;s Address">
                <p class="help-block" id="fathers_address_help-block"></p>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2" for="mothers_last_name">Mother&apos;s Last Name:</label>
              <div class="col-sm-10"> 
                <input type="text" class="form-control edit_field" name="mothers_last_name" placeholder="Enter Mother&apos;s Last Name">
                <p class="help-block" id="mothers_last_name_help-block"></p>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2" for="mothers_middle_name">Mother&apos;s Middle Name:</label>
              <div class="col-sm-10"> 
                <input type="text" class="form-control edit_field" name="mothers_middle_name" placeholder="Enter Mother&apos;s Middle Name">
                <p class="help-block" id="mothers_middle_name_help-block"></p>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2" for="mothers_first_name">Mother&apos;s First Name:</label>
              <div class="col-sm-10"> 
                <input type="text" class="form-control edit_field" name="mothers_first_name" placeholder="Enter Mother&apos;s First Name">
                <p class="help-block" id="mothers_first_name_help-block"></p>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2" for="mothers_contact_number">Mother&apos;s Contact Number:</label>
              <div class="col-sm-10"> 
                <input type="text" class="form-control edit_field" name="mothers_contact_number" placeholder="Enter Mother&apos;s Contact Number">
                <p class="help-block" id="mothers_contact_number_help-block"></p>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2" for="mothers_address">Mother&apos;s Address:</label>
              <div class="col-sm-10"> 
                <input type="text" class="form-control edit_field" name="mothers_address" placeholder="Enter Mother&apos;s Address">
                <p class="help-block" id="mothers_address_help-block"></p>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2" for="is_living_with_parents">Living with parents?:</label>
              <div class="col-sm-10"> 
                <label class="radio-inline"><input class="edit_field" type="radio" name="is_living_with_parents" id="is_living_with_parents_yes" value="1">Yes</label>
                <label class="radio-inline"><input class="edit_field" type="radio" name="is_living_with_parents" id="is_living_with_parents_no" value="0">No</label>
                <p class="help-block" id="is_living_with_parents_help-block"></p>
              </div>
            </div>

          <div class="form-group">
            <label class="col-sm-2" for="guardian">Guardians Contact Number:</label>
            <div class="col-sm-8"> 
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
            <div class="col-sm-2"> 
              <button type="button" class="btn btn-default btn-block" id="student_add_guardian">Add</button>
            </div>
          </div>




          <div class="form-group">
            <label class="col-sm-2" for="student_photo">Photo:</label>
            <div class="col-sm-10">
            <input type="file" name="student_photo" size="20" class="form-control" accept="image/*">
              <p class="help-block" id="photo_help-block"></p>
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


echo '
<!--RFID Scan to Add Student Modal -->
<div id="fetcher_modal" class="modal fade" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-sm">

    <!-- Modal content-->
    <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title" id="rfid_add_modal_title">Add Fetcher</h4>
    </div>
      <div class="modal-body">
        <p>
        '.form_open("student_ajax/add_fetcher",'id="add_fetcher_student"').'
        <input type="hidden" name="type">
        <input type="hidden" name="id">

          <div class="form-group">

            <label for="rfid"></label>
            <div class="col-sm-12">
              <input type="text" class="form-control" name="rfid" placeholder="Scan RFID using RFID Reader..." autocomplete="off">
              <p class="help-block" id="add_fetcher_student_rfid_help-block"></p>
            </div>

          </div>


        </form>
        </p>
      </div>
      <div class="modal-footer">
       
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
$(document).ready(function() {
  $(document).on("click","#reset",function(e) {
    $(".ui").dropdown("clear");
    show_student_list();
  });

  $('#add_fetcher_student').submit(function(e) {
    e.preventDefault();
    $.ajax({
      type: 'POST',
      url: $('#add_fetcher_student').attr('action'),
      data: $('#add_fetcher_student').serialize(),
      cache: false,
      beforeSend: function(data) {
        
      },
      success: function(data) {
        // body...
      },
      complete: function(data) {
        
      },
      error: function(e) {
        console.log(e);
      }
    });
  });

  $(document).on("click",".add_rfid_student",function(e) {
    var id = e.target.id;
    $('input[name="type"]').val("students");
    $('input[name="id"]').val(id);
    $("#rfid_add_modal_title").html("scan student&apos;s rfid");
    $("#rfid_scan_add_modal").modal("show");
  });
  $(document).on("click",".delete_rfid_student",function(e) {
    var datastr = "<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash();?>"+"&id="+e.target.id+"&type=students";
    alertify.confirm('REMOVE RFID', 'Are you sure you want to remove the rfid of this student?<br> This action is irreversible.', function(){
      $.ajax({
        type: "POST",
        url: "<?php echo base_url("rfid_ajax/delete"); ?>",
        data: datastr,
        cache: false,
        success: function(data) {
          show_student_list();
          alertify.success('RFID has been removed.');
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
  $(document).on("submit","#rfid_scan_add_form",function(e) {
    e.preventDefault();
    $.ajax({
      type: "POST",
      url: $("#rfid_scan_add_form").attr("action"),
      data: $("#rfid_scan_add_form :input").serialize(),
      cache: false,
      dataType: "json",
      success: function(data) {
        console.log(data);
        if(data.is_valid){
          $("#rfid_scan_add_modal").modal("hide");
          $(".help-block").html("");
          alertify.success("You have successfully added the rfid of the student.");  
          show_student_list();
        }else{
          $("#rfid_scan_help-block").html(data.error);
          $("#rfid_valid_date_help-block").html(data.date_error);
        }
      },
      error: function(e) {
        console.log(e);
      },
      complete: function() {
        $('input[name="rfid"]').val("");
      }
    });
  });
  $(document).on("click",".edit_student",function(e) {
      var id = e.target.id;
      show_student_data(id);
  });


  $(document).on("click",".fetcher",function(e) {
    $("#fetcher_modal").modal("show");
  });

  $(document).on("click",".delete_student",function(e) {
    var datastr = "<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash();?>"+"&id="+e.target.id;
    alertify.confirm('DELETE STUDENT', 'Are you sure you want to delete this student in the list?<br> This action is irreversible.', function(){
      $.ajax({
        type: "POST",
        url: "<?php echo base_url("student_ajax/delete"); ?>",
        data: datastr,
        cache: false,
        dataType: "json",
        success: function(data) {
          show_student_list();
          alertify.success(data.last_name + ' has been deleted.');
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
  function show_student_data(id) {
    $.ajax({
      type: "GET",
      url: "<?php echo base_url("student_ajax/get_data"); ?>",
      data: "student_id="+id,
      cache: false,
      dataType: "json",
      success: function(data) {
        console.log(data);
        $("#display-photo").attr("src","<?php echo base_url("assets/images/student_photo/");?>"+data.display_photo);
        $('input[name="student_id"]').val(id);
        $('input[name="first_name"].edit_field').val(data.first_name);
        $('input[name="last_name"].edit_field').val(data.last_name);
        $('input[name="lrn_number"].edit_field').val(data.lrn_number);
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
        $('input[name="age_as_of_august"].edit_field').val(data.age_as_of_august);
        $('input[name="mother_tongue"].edit_field').val(data.mother_tongue);
        $('input[name="ethnic_group"].edit_field').val(data.ethnic_group);
        $('input[name="religion"].edit_field').val(data.religion);
        if(data.is_transferee=="1"){
          $('#is_transferee_yes').attr('checked',true);
        }else{
          $('#is_transferee_no').attr('checked',true);
        }
        if(data.is_living_with_parents=="1"){
          $('#is_living_with_parents_yes').attr('checked',true);
        }else{
          $('#is_living_with_parents_no').attr('checked',true);
        }
        $('input[name="last_school_attended"].edit_field').val(data.last_school_attended);
        $('input[name="last_year_attended"].edit_field').val(data.last_year_attended);
        $('input[name="last_grade_attended"].edit_field').val(data.last_grade_attended);
        $('input[name="last_track_strand"].edit_field').val(data.last_track_strand);
        $('input[name="academic_track"].edit_field').val(data.academic_track);
        $('input[name="tech_voc_track"].edit_field').val(data.tech_voc_track);
        $('input[name="fathers_last_name"].edit_field').val(data.fathers_last_name);
        $('input[name="fathers_middle_name"].edit_field').val(data.fathers_middle_name);
        $('input[name="fathers_first_name"].edit_field').val(data.fathers_first_name);
        $('input[name="fathers_contact_number"].edit_field').val(data.fathers_contact_number);
        $('input[name="fathers_address"].edit_field').val(data.fathers_address);
        $('input[name="mothers_last_name"].edit_field').val(data.mothers_last_name);
        $('input[name="mothers_middle_name"].edit_field').val(data.mothers_middle_name);
        $('input[name="mothers_first_name"].edit_field').val(data.mothers_first_name);
        $('input[name="mothers_contact_number"].edit_field').val(data.mothers_contact_number);
        $('input[name="mothers_address"].edit_field').val(data.mothers_address);
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
      },
      error: function(e) {
        console.log(e);
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
      beforeSend: function() {
        $('button[form="student_edit_form"]').prop('disabled', true);
      },
      success: function(data) {
        $("#lrn_number_help-block").html(data.lrn_number_error);
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
        $("#photo_help-block").html(data.photo_error);
        $("#student_id_help-block").html(data.student_id_error);
        if(data.is_valid){
          $("#student_edit_form")[0].reset();
          $(".ui .dropdown").dropdown("clear");
          $("#student_edit_modal").modal("hide");
          alertify.success("You have successfully updated a student's information.");
        }
      },
      error: function(e) {
        console.log(e);
      },
      complete: function() {
        $('button[form="student_edit_form"]').prop('disabled', false);
      }
    });
  });
  $(document).on("change",'#select_class',function(e) {
    var datastr = "class_id="+e.target.value;
    $.ajax({
      type: "GET",
      url: "<?php echo base_url("student_ajax/get_list/admin"); ?>",
      data: datastr,
      cache: false,
      dataType: "json",
      beforeSend: function() {
        $('#select_student').dropdown("clear");
        $('#select_student').html("");
        $('#select_student').append('<option value="">Select a Class</option>');
      },
      success: function(data) {
        $.each(data, function(i, item) {
            $('#select_student').append('<option value="'+data[i].id+'">'+data[i].full_name+'</option>');
        });
      },
      error: function(e) {
        console.log(e);
      }
    });
  });
  $(document).on("click",".paging",function(e) {
    show_student_list(e.target.id);
  });

  $(document).on("submit","#student_download_list",function(e) {
    e.preventDefault();
    $.ajax({
      type: "GET",
      url: $("#student_download_list").attr("action"),
      cache: false,
      data: "class_id="+$("#select_class").val(),
      success: function(data) {
        window.location = data;
      },
      error: function(e) {
        console.log(e);
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
      },
      error: function(e) {
        console.log(e);
      }
    });
  }
});
</script>
</body>
</html>