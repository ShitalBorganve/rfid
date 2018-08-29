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
  <div class="row">
    <div class="col-sm-8 col-sm-push-2">
    <h1 style="text-align: center;">List of Fetchers</h1>
      
      <?php echo form_open("tables/fetchers/list",'id="fetcher-list-form" class="form-inline"');?>

      <div class="form-group">
      <label>Search Fetcher ID</label>
      <select class="ui search dropdown" name="owner_id" id="select_fetcher">
        <option value="">Fetcher ID</option>
        <?php
          foreach ($fetchers_list as $fetcher_data) {
            echo '<option value="'.$fetcher_data->id.'">'.sprintf("%04d",$fetcher_data->id).'</option>';
          }
        ?>
      </select>
      </div>
      <div class="form-group">

      <button class="btn btn-primary" type="submit" form="fetcher-list-form"><span class="glyphicon glyphicon-search"></span> Search</button>
      <button class="btn btn-danger" type="button" id="reset"><span class="glyphicon glyphicon-refresh"></span> Reset</button>
      </div>
      </form>
      <?php echo form_open("fetcher_ajax/download",'class="form-inline" id="fetcher_download_list"');?>

      </form>
      <div class="table-responsive">
        <table class="table table-hover" id="fetcher-list-table">
          <thead>
            <tr>
              <th style="text-align: center;">ID</th>
              <th style="text-align: center;">RFID</th>
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

<!--Edit fetcher Modal -->
<div id="fetcher_edit_modal" class="modal fade" role="dialog" tabindex="-1">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Fetchers</h4>
      </div>
      <div class="modal-body" style="min-height: 300px;">
        <p>'.form_open_multipart("fetcher_ajax/edit",'id="fetcher_edit_form" class="form-horizontal"').'
          <!-- <input type="hidden" class="form-control rfid_scanned_add" name="rfid"> -->


          <div class="form-group">
            <label class="col-sm-3" for="fetcher_id">Fetcher ID:</label>
            <div class="col-sm-9"> 
              <input class="form-control" name="fetcher_id" type="hidden">
              <span class="form-control" id="fetcher_id"></span>
            </div>
          </div>


          <div class="form-group">
            <label class="col-sm-3" for="student_id">Students to Fetch:</label>
            <div class="col-sm-9"> 
              <select class="ui fluid search dropdown" multiple="" name="fetcher_student_id[]" id="fetcher_students">
                <option value="">Last Name</option>
              </select>
              <p class="help-block" id="student_id_help-block"></p>
            </div>
          </div>

        </form></p>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" form="fetcher_edit_form">Submit</button>
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
    show_fetcher_list();
  });



  $(document).on("click",".add_rfid_fetcher",function(e) {
    var id = e.target.id;
    $('input[name="type"]').val("fetchers");
    $('input[name="id"]').val(id);
    $("#rfid_add_modal_title").html("scan fetcher&apos;s rfid");
    $("#rfid_scan_add_modal").modal("show");
  });
  $(document).on("click",".delete_rfid_fetcher",function(e) {
    var datastr = "<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash();?>"+"&id="+e.target.id+"&type=fetchers";
    alertify.confirm('REMOVE RFID', 'Are you sure you want to remove the rfid of this fetcher?<br> This action is irreversible.', function(){
      $.ajax({
        type: "POST",
        url: "<?php echo base_url("rfid_ajax/delete"); ?>",
        data: datastr,
        cache: false,
        success: function(data) {
          show_fetcher_list();
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
          alertify.success("You have successfully added the rfid of the fetcher.");  
          show_fetcher_list();
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
  $(document).on("click",".edit_fetcher",function(e) {
      var id = e.target.id;
      show_fetcher_data(id);
  });
  $(".ui").dropdown("clear");


  $(document).on("click",".fetcher",function(e) {
    $("#fetcher_modal").modal("show");
  });

  $(document).on("click",".delete_fetcher",function(e) {
    var datastr = "<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash();?>"+"&id="+e.target.id;
    alertify.confirm('DELETE fetcher', 'Are you sure you want to delete this fetcher in the list?<br> This action is irreversible.', function(){
      $.ajax({
        type: "POST",
        url: "<?php echo base_url("fetcher_ajax/delete"); ?>",
        data: datastr,
        cache: false,
        dataType: "json",
        success: function(data) {
          show_fetcher_list();
          alertify.success(data.id + ' has been deleted.');
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
  function show_fetcher_data(id) {
    $.ajax({
      type: "GET",
      url: "<?php echo base_url("fetcher_ajax/get_data"); ?>",
      data: "fetcher_id="+id,
      cache: false,
      dataType: "json",
      beforeSend: function(data) {
        $("#fetcher_students").dropdown('clear');
      },
      success: function(data) {
        console.log(data.has_students);
        $('input[name="fetcher_id"]').val(data.id);
        $('#fetcher_id').html(data.id_string);
        $("#fetcher_edit_modal").modal("show");
        $("#fetcher_students").dropdown('set value',data.students);
      },
      error: function(e) {
        console.log(e);
      }
    });
  }
  $(document).on("submit","#fetcher_edit_form",function(e) {
    e.preventDefault();
    $.ajax({
      url: $(this).attr('action'),
      data: new FormData(this),
      processData: false,
      contentType: false,
      method:"POST",
      dataType: 'json',
      beforeSend: function() {
        $('button[form="fetcher_edit_form"]').prop('disabled', true);
      },
      success: function(data) {
        if(data.is_valid){
          $('#fetcher_edit_modal').modal('hide');
          alertify.success('Saved.');
        }else{
          alertify.error('Students to fetch is required.');
        }
      },
      error: function(e) {
        console.log(e);
      },
      complete: function() {
        $('button[form="fetcher_edit_form"]').prop('disabled', false);
      }
    });
  });

  $(document).on("click",".paging",function(e) {
    show_fetcher_list(e.target.id);
  });

  $(document).on("submit","#fetcher-list-form",function(e) {
    e.preventDefault();
    $('input[name="owner_id"]').removeAttr('value');
    show_fetcher_list();
  });
  show_fetcher_list();
  function show_fetcher_list(page='1',clear=false) {
    var datastr = $("#fetcher-list-form").serialize();
    $.ajax({
      type: "GET",
      url: $("#fetcher-list-form").attr("action"),
      data: datastr+"&page="+page,
      cache: false,
      success: function(data) {
        if(clear){
          $("#search_last_name").val("");
        }
        $("#fetcher-list-table tbody").html(data);
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