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
  <h1 style="text-align: center;">List of Your Students</h1>
  <div class="row">
    <div class="col-sm-12">
        <?php echo form_open("tables/students/list/teachers",'id="student-list-form" class="form-inline"');?>
        <div class="form-group">
        <label>Search Last Name</label>
        <select class="ui search dropdown form-control" id="students-select" name="owner_id">
        <option value="">Select Student</option>
        </select>
        </div>
        <div class="form-group">
          <select name="class_id_" class="form-control" id="class_id_">
          <?php 
            foreach ($classes_of_teacher as $classes_of_teacher_data) {
              echo '<option value="'.$classes_of_teacher_data->id.'">'.$classes_of_teacher_data->class_name.'</option>';
            }
          ?>
          </select>
        </div>
        <div class="form-group">
        <button class="btn btn-primary" type="submit" form="student-list-form"><span class="glyphicon glyphicon-search"></span> Search</button>
        <span class="btn btn-danger" id="clear"><span class="glyphicon glyphicon-refresh"></span> Reset</span>
        </div>
        </form>
          <div class="table-responsive">
        <table class="table table-hover" id="student-list-table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Last Name</th>
              <th>First Name</th>
              <th>Middle Name</th>
              <th>Suffix</th>
              <th>Gender</th>
              <th>Age</th>
              <th>Birthday</th>
              <th>Contact Number</th>
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
$(document).ready(function() {
  $(document).on("click","#clear",function(e) {
    $("#students-select").dropdown("clear");
    show_student_list();
  });
  $(document).on("change","#students-select",function(e) {
    show_student_list();
  });
  $(document).on("submit","#student-list-form",function(e) {
    e.preventDefault();
    show_student_list();
  });
  $(document).on("click",".paging",function(e) {
    show_student_list(e.target.id);
  });
  $(document).on("change","#class_id_",function(e) {
    $("#students-select").dropdown("clear");
    populate_selection();
  });
  show_student_list();
  populate_selection();
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
  function populate_selection() {
    $("#students-select").html("");
    $.ajax({
      type: "GET",
      url: "<?php echo base_url("student_ajax/get_list/teachers"); ?>",
      data: $("#student-list-form").serialize(),
      cache: false,
      dataType: "json",
      success: function(data) {
        $.each(data, function(i, item) {
            $("#students-select").append('<option value="'+data[i].id+'">'+data[i].full_name+'</option>');
        })
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