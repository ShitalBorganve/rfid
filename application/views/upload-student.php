<!DOCTYPE html>
<html>
<head>
<?php echo '<title>'.$title.'</title>'.$meta_scripts.$css_scripts; ?>
<style>

</style>
</head>

<body>
<?php echo $navbar_scripts; ?>
<div class="container-fluid" ng-app="myApp" ng-controller="myController">
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    
        <h1 style="text-align: center;">
          Import Students from CSV Data
        </h1>
        <div class="row">
          <div class="col-sm-4 col-sm-offset-4">
            <form action="javascript:void(0);" id="upload-student-form" enctype="multipart/form-data" method="post" accept-charset="utf-8" ng-if="!has_uploaded">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
            <div class="form-group">
              <label>Format:</label>
              <a href="<?= base_url("import-format/student-export-format.csv"); ?>" class="form-control">Download</a>
              <p class="help-block"></p>
            </div>
            <div class="form-group">
              <label></label>
              <input type="file" name="student_csv" size="20" class="form-control" accept=".csv">
              <p class="help-block" id="student_csv_help-block"></p>
            </div>
            <button type="submit" class="btn btn-primary" form="upload-student-form">Upload</button>
            <?= form_close(); ?>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-4 col-sm-offset-4">
            <div ng-if="!(exported_data|isEmpty)" ng-cloak>
              <b>
                Validated: {{ rowIndex }} of {{ exported_data.length }} students.
              </b><br>
              <span>Valid: {{numberOfErrors}}</span><br>
              <span>Invalid: {{numberOfSuccess}}</span><br>
              <label for="">Filter:</label>
              <select ng-model="filterRowsBy" ng-change="toggleRows(this)" class="form-control">
                <option value="all">All</option>
                <option value="success">Valid</option>
                <option value="danger">Invalid</option>
              </select><br>
              <b ng-if="is_complete_validation()" ng-cloak>
                <a href="javascript:void(0);" class="btn btn-primary" ng-click="importRows()">Start Importing</a>
              </b>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <div class="table-responsive">
              <table class="table table-bordered" ng-if="!(exported_data|isEmpty)" ng-cloak>
                <thead>
                  <tr>
                    <th style="text-align:center"></th>
                    <th ng-repeat="column in columns" style="text-align:center">{{column.name}}</th>
                  </tr>
                </thead>
                <tbody>
                  <tr ng-repeat="item in exported_data" ng-class="item.status" ng-if="filterRowsBy=='all'||item.status==filterRowsBy">
                    <td>
                      <button ng-click="show_error(item)" class="btn btn-danger" ng-if="item.status=='danger'">SHOW ERRORS</button>
                    </td>
                    <td ng-repeat="column in columns">{{ item[column.value] }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
    </div>
  </div>
  <!-- Add Canteen Users Modal -->
  <div id="upload-error-modal" class="modal fade" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lg">

      <!-- Modal content-->
      <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">ERRORS</h4>
      </div>
        <div class="modal-body">
          <p ng-repeat="error in errors">{{error}}</p>
        </div>
        <div class="modal-footer">
         
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>

    </div>
  </div>
</div>

</div>


<?php echo $modaljs_scripts; ?>
<?php echo $js_scripts; ?>
<?php echo '<script type="text/javascript" src="'.base_url("assets/js/angular.min.js").'"></script>'; ?>
<script>

var app = angular.module('myApp', []);
app.filter('isEmpty', function () {
    var bar;
    return function (obj) {
        for (bar in obj) {
            if (obj.hasOwnProperty(bar)) {
                return false;
            }
        }
        return true;
    };
});
app.controller('myController', function($scope, $http, $sce, $window) {

  $(document).on("submit", "#upload-student-form", function(e) {
    $scope.columns = [];
    $scope.rows = [];
    $scope.exported_data = [];
    e.preventDefault();
    $scope.numberOfErrors = 0;
    $scope.numberOfSuccess = 0;
    $scope.has_uploaded = true;
    $.ajax({
      url: base_url+"student_ajax/upload",
      data: new FormData(this),
      processData: false,
      contentType: false,
      method: "POST",
      dataType: "json",
      beforeSend: function() {
        $("button[form='upload-student-form']").prop('disabled', true);
        $scope.columns = [];
        $scope.rows = [];
        $scope.exported_data = [];
      },
      success: function(data) {
        $scope.has_uploaded = true;
        $scope.exported_data = data.exported_data;
        $scope.columns = data.columns;
        $scope.validate_upload();
      },
      error: function(e) {
        console.log(e);
        $scope.has_uploaded = false;
      },
      complete: function() {
        $("button[form='upload-student-form']").prop('disabled', false);
        $scope.has_uploaded = true;
      }
    })
  });
  //validate_upload
  $scope.rowIndex = 0;
  $scope.validRows = [];
  $scope.numberOfErrors = 0;
  $scope.numberOfSuccess = 0;
  $scope.has_uploaded = false;
  $scope.filterRowsBy = "all";
  $scope.csrf_name = "<?php echo $this->security->get_csrf_token_name();?>";
  $scope.csrf_value = "<?php echo $this->security->get_csrf_hash();?>";
  $scope.validate_upload = function() {
    if($scope.exported_data.length!=$scope.rowIndex){
        $scope.exported_data[$scope.rowIndex][$scope.csrf_name] = $scope.csrf_value;
        let data = $scope.exported_data[$scope.rowIndex];
        $scope.formerrors = {};
        $scope.submit = true; 
        $http({
          method: 'POST',
          url: base_url+"student_ajax/validate_upload",
          data: $.param(data),
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          }
        }).then(function(response) {
          $scope.submit = false;
          $scope.exported_data[$scope.rowIndex]["status"] = response.data.is_valid ? "success": "danger";
          if(response.data.is_valid){
            $scope.numberOfErrors++;
          }else{
            $scope.numberOfSuccess++;
          }
          $scope.exported_data[$scope.rowIndex]["compiled_errors"] = response.data.compiled_errors;
          if($scope.exported_data.length==$scope.rowIndex){
            // $scope.rowIndex++;
          }else{
            $scope.rowIndex++;
            setTimeout(() => {
              $scope.validate_upload();
            }, 250);
          }
        }, function(rejection) {
          setTimeout(() => {
            $scope.validate_upload();
          }, 250);
          $scope.submit = false;
        });
    }
  }

  $scope.show_error = function(data) {
    $scope.errors = [];
    $scope.errors = data.compiled_errors;
    $('#upload-error-modal').modal('show');
  }

  $scope.is_complete_validation = function() {
    return $scope.exported_data.length==$scope.rowIndex;
  }

  $scope.importRows = function() {
    $scope.validRows = $scope.exported_data.filter( item => item.status == "success" );
    alertify.confirm('START IMPORTING', 'This will only import valid students. Continue?', function(){
      
    },
    function(){
      // alertify.error('Cancelled')
    });
  }

  $scope.toggleRows = function(data) {
    $scope.filterRowsBy = data.filterRowsBy;
  }

});
</script>
</body>
</html>