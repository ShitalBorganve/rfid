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
  <h1 style="text-align: center;">List of Non-Teaching Staffs</h1>
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <?php echo form_open("tables/staffs/list",'id="staff-list-form" class="form-inline"');?>
      <div class="form-group">
      <label>Search Last Name</label>
        <select class="ui search dropdown form-control" name="owner_id">
          <option value="">Select Staff's Last Name</option>
          <?php
            foreach ($staffs_list["result"] as $staff_data) {
              echo '<option value="'.$staff_data->id.'">'.$staff_data->full_name.'</option>';
            }
          ?>
        </select>        
      </div>

      <div class="form-group">
      <button class="btn btn-primary" type="submit"><span class="glyphicon glyphicon-search"></span> Search</button>
      <button class="btn btn-danger" type="button" id="reset"><span class="glyphicon glyphicon-refresh"></span> Reset</button>
      <button type="submit" form="staff_download_list" class="btn btn-info"><span class="glyphicon glyphicon-download"></span> Download</button>
      </div>
      </form>
      <?php echo form_open("staff_ajax/download",'class="form-inline" id="staff_download_list"');?>
      </form>
      <div class="table-responsive">
        <table class="table table-hover" id="staff-list-table">
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
              <th>Contact Number</th>
              <th>Position</th>
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

<!--Edit staff Modal -->
<div id="staff_edit_modal" class="modal fade" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit staffs</h4>
      </div>
      <div class="modal-body">
        <p>'.form_open_multipart("staff_ajax/edit",'id="staff_edit_form" class="form-horizontal"').'
        <input type="hidden" name="staff_id">
        <div class="col-sm-12">
          <div id="display-photo-container">
            <img class="img-responsive" id="display-photo" src="'.base_url("assets/images/empty.jpg").'">
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-2" for="position">Position:</label>
          <div class="col-sm-10">
            <input type="text" class="form-control edit_field" name="position" placeholder="Enter Position">
            <p class="help-block" id="position_help-block"></p>
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
            <label class="col-sm-2" for="gender">Gender:</label>
            <div class="col-sm-10"> 
              <select name="gender" class="form-control edit_field" required>
                <option value="MALE">MALE</option>
                <option value="FEMALE">FEMALE</option>
              </select>
              <p class="help-block" id="gender_help-block"></p>
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
                for ($i=1940; $i <= date("Y"); $i++) { 
                  echo '<option value="'.$i.'">'.sprintf("%04d",$i).'</option>';
                }
                echo '
              </select>
              <p class="help-block" id="bday_help-block"></p>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2" for="blood_type">Blood Type:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control edit_field" name="blood_type" placeholder="Enter Blood Type">
              <p class="help-block" id="blood_type_help-block"></p>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2" for="sss">SSS:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control edit_field" name="sss" placeholder="Enter SSS">
              <p class="help-block" id="sss_help-block"></p>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2" for="philhealth">PhilHealth:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control edit_field" name="philhealth" placeholder="Enter PhilHealth">
              <p class="help-block" id="philhealth_help-block"></p>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2" for="pagibig">Pag-IBIG:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control edit_field" name="pagibig" placeholder="Enter Pag-IBIG">
              <p class="help-block" id="pagibig_help-block"></p>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2" for="tin">TIN:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control edit_field" name="tin" placeholder="Enter TIN">
              <p class="help-block" id="tin_help-block"></p>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2" for="dept_head">Department Head:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control edit_field" name="dept_head" placeholder="Enter Department Head">
              <p class="help-block" id="dept_head_help-block"></p>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2" for="dept_head_number">Department Head Contact Number:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control edit_field" name="dept_head_number" placeholder="Enter Department Head Contact Number">
              <p class="help-block" id="dept_head_number_help-block"></p>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2" for="in_case_name">In Case of Emergency Contact:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control edit_field" name="in_case_name" placeholder="Enter Contact Name">
              <p class="help-block" id="in_case_name_help-block"></p>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2" for="in_case_contact_number">Person Contact Number:</label>
            <div class="col-sm-10"> 
              <input type="text" class="form-control edit_field" name="in_case_contact_number" placeholder="Enter Contact Number">
            <p class="help-block" id="in_case_contact_number_help-block"></p>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2" for="in_case_address">Person Address:</label>
            <div class="col-sm-10"> 
              <input type="text" class="form-control edit_field" name="in_case_address" placeholder="Enter Address">
            <p class="help-block" id="in_case_address_help-block"></p>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2" for="staff_photo">Photo:</label>
            <div class="col-sm-10">
            <input type="file" name="staff_photo" size="20" class="form-control" accept="image/*">
              <p class="help-block" id="photo_help-block"></p>
            </div>
          </div>

        </form></p>
      </div>
      <div class="modal-footer">
      <p class="help-block" id="staff_id_help-block"></p>
        <button type="submit" class="btn btn-primary" form="staff_edit_form">Submit</button>
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
  $(".ui").dropdown("clear");
  $(document).on("click",".add_rfid_staff",function(e) {
    var id = e.target.id;
    $('input[name="type"]').val("staffs");
    $('input[name="id"]').val(id);
    $("#rfid_add_modal_title").html("scan staff&apos;s rfid");
    $("#rfid_scan_add_modal").modal("show");
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
          alertify.success("You have successfully added the rfid for the non-teaching staff.");  
          show_staff_list();
        }else{
          $("#rfid_scan_help-block").html(data.error);
          $("#rfid_valid_date_help-block").html(data.date_error);
        }
      },
      error: function(e) {
        console.log(e);
      }
    });
  });
  $(document).on("click",".edit_staff",function(e) {
      var id = e.target.id;
      show_staff_data(id);
  });
  $(document).on("click",".delete_rfid_staff",function(e) {
    var datastr = "<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash();?>"+"&id="+e.target.id+"&type=staffs";
    alertify.confirm('REMOVE RFID', 'Are you sure you want to remove the rfid of this non-teaching staff?<br> This action is irreversible.', function(){
      $.ajax({
        type: "POST",
        url: "<?php echo base_url("rfid_ajax/delete"); ?>",
        data: datastr,
        cache: false,
        success: function(data) {
          show_staff_list();
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
  $(document).on("click",".delete_staff",function(e) {
    var datastr = "<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash();?>"+"&id="+e.target.id;
    alertify.confirm('DELETE NON-TEACHING STAFF', 'Are you sure you want to delete this non-teaching staff in the list?<br> This action is irreversible.', function(){
      $.ajax({
        type: "POST",
        url: "<?php echo base_url("staff_ajax/delete"); ?>",
        data: datastr,
        cache: false,
        dataType: "json",
        success: function(data) {
          show_staff_list();
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
  function show_staff_data(id) {
    $.ajax({
      type: "GET",
      url: "<?php echo base_url("staff_ajax/get_data"); ?>",
      data: "staff_id="+id,
      cache: false,
      dataType: "json",
      success: function(data) {
        $('input[name="staff_id"]').val(id);
        $("#display-photo").attr("src","<?php echo base_url("assets/images/staff_photo/");?>"+data.display_photo);
        $('input[name="position"].edit_field').val(data.position);
        $('input[name="dept_head"].edit_field').val(data.dept_head);
        $('input[name="dept_head_number"].edit_field').val(data.dept_head_number);
        $('input[name="first_name"].edit_field').val(data.first_name);
        $('input[name="in_case_name"].edit_field').val(data.in_case_name);
        $('input[name="in_case_contact_number"].edit_field').val(data.in_case_contact_number);
        $('input[name="last_name"].edit_field').val(data.last_name);
        $('input[name="address"].edit_field').val(data.address);
        $('input[name="middle_name"].edit_field').val(data.middle_name);
        $('input[name="suffix"].edit_field').val(data.suffix);
        $('input[name="contact_number"].edit_field').val(data.contact_number);
        $('input[name="blood_type"].edit_field').val(data.blood_type);
        $('input[name="sss"].edit_field').val(data.sss);
        $('input[name="philhealth"].edit_field').val(data.philhealth);
        $('input[name="pagibig"].edit_field').val(data.pagibig);
        $('input[name="tin"].edit_field').val(data.tin);
        $('input[name="in_case_address"].edit_field').val(data.in_case_address);
        $('select[name="bday_m"].edit_field').val(data.bday_m);
        $('select[name="gender"].edit_field').val(data.gender);
        $('select[name="bday_d"].edit_field').val(data.bday_d);
        $('select[name="bday_y"].edit_field').val(data.bday_y);
        if(data.in_case_contact_number_sms == 1){
          $('input[name="in_case_contact_number_sms"].edit_field').prop("checked",true);
        }else{
          $('input[name="in_case_contact_number_sms"].edit_field').prop("checked",false);
        }
        if(data.class_id!=""){
          $('#edit-class_id').dropdown('set value',data.class_id);
        }else{
          $('#edit-class_id').dropdown('clear');
        }
        $("#staff_edit_modal").modal("show");
      },
      error: function(e) {
        console.log(e);
      }
    });
  }
  $(document).on("submit","#staff_edit_form",function(e) {
    e.preventDefault();
    $.ajax({
      url: $(this).attr('action'),
      data: new FormData(this),
      processData: false,
      contentType: false,
      method:"POST",
      dataType: "json",
      beforeSend: function() {
        $('button[form="staff_edit_form"]').prop('disabled', true);
      },
      success: function(data) {
        $("#first_name_help-block").html(data.first_name_error);
        $("#blood_type_help-block").html(data.blood_type_error);
        $("#sss_help-block").html(data.sss_error);
        $("#philhealth_help-block").html(data.philhealth_error);
        $("#pagibig_help-block").html(data.pagibig_error);
        $("#tin_help-block").html(data.tin_error);
        $("#in_case_address_help-block").html(data.in_case_address_error);
        $("#dept_head_help-block").html(data.dept_head_error);
        $("#dept_head_number_help-block").html(data.dept_head_number_error);
        $("#in_case_name_help-block").html(data.in_case_name_error);
        $("#in_case_contact_number_help-block").html(data.in_case_contact_number_error);
        $("#gender_help-block").html(data.gender_error);
        $("#address_help-block").html(data.address_error);
        $("#position_help-block").html(data.position_error);
        $("#last_name_help-block").html(data.last_name_error);
        $("#middle_name_help-block").html(data.middle_name_error);
        $("#suffix_help-block").html(data.suffix_error);
        $("#contact_number_help-block").html(data.contact_number_error);
        $("#bday_help-block").html(data.bday_error);
        $("#staff_class_id_help-block").html(data.class_id_error);
        $("#photo_help-block").html(data.photo_error);
        $("#staff_id_help-block").html(data.staff_id_error);
        if(data.is_valid){
          $("#staff_edit_form")[0].reset();
          $(".ui .dropdown").dropdown("clear");
          $("#staff_edit_modal").modal("hide");
          alertify.success("You have successfully updated a non-teaching staff's information.");
          show_staff_list();
        }
      },
      error: function(e) {
        console.log(e);
      },
      complete: function() {
        $('button[form="staff_edit_form"]').prop('disabled', false);
      }
    });
  });
  $(document).on("click",".paging",function(e) {
    show_staff_list(e.target.id);
  });
  $(document).on("click","#reset",function(e) {
    $(".ui").dropdown("clear");
    show_staff_list();
  });
  $(document).on("click",".reset_password_staff",function(e) {
    var datastr = "<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash();?>"+"&id="+e.target.id;
    if(confirm("Are you sure you want to reset the password of this staff? This action is irreversible.")){
      $.ajax({
        type: "POST",
        url: "<?php echo base_url("staff_ajax/reset_password"); ?>",
        data: datastr,
        dataType: "json",
        cache: false,
        success: function(data) {
          if(data.is_successful){
            $("#alert-modal-title").html("Reset Password");
            $("#alert-modal-body p").html("You have sent the new password to "+ data.contact_number);
            $("#alert-modal").modal("show");         
          }else{
            $("#alert-modal-title").html("Reset Password");
            $("#alert-modal-body p").html(data.error);
            $("#alert-modal").modal("show");    
          }
        },
        error: function(e) {
          console.log(e);
        }
      });
    }
  });
  $(document).on("submit","#staff_download_list",function(e) {
    e.preventDefault();
    $.ajax({
      type: "GET",
      url: $("#staff_download_list").attr("action"),
      cache: false,
      success: function(data) {
        window.location = data;
      },
      error: function(e) {
        console.log(e);
      }
    });
  });
  $(document).on("submit","#staff-list-form",function(e) {
    e.preventDefault();
    $('input[name="owner_id"]').removeAttr('value');
    show_staff_list();
  });
  show_staff_list();
  function show_staff_list(page='1',clear=false) {
    var datastr = $("#staff-list-form").serialize();
    $.ajax({
      type: "GET",
      url: $("#staff-list-form").attr("action"),
      data: datastr+"&page="+page,
      cache: false,
      success: function(data) {
        if(clear){
          $("#search_last_name").val("");
        }
        $("#staff-list-table tbody").html(data);
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