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
              <label>Required Format:</label>
              <a href="<?= base_url("import-format/student-export-format.csv"); ?>" class="form-control">Download</a>
              <p class="help-block">Do not touch the way field names are written.</p>
            </div>
            <div class="form-group">
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
                <span ng-if="currentTask=='validating'">Validating</span><span ng-if="currentTask=='importing'">Importing</span>: {{ rowIndex }} of {{ exported_data.length }} students.
              </b><br>
              <span><span ng-if="currentTask=='validating'">Valid</span><span ng-if="currentTask=='importing'">Success</span>: {{numberOfSuccess}}</span><br>
              <span><span ng-if="currentTask=='validating'">Invalid</span><span ng-if="currentTask=='importing'">Have Errors</span>: {{numberOfErrors}}</span><br>
              <label for="">Filter:</label>
              <select ng-model="filterRowsBy" ng-change="toggleRows(this)" class="form-control">
                <option value="all">All</option>
                <option value="success">Valid</option>
                <option value="danger">Invalid</option>
              </select><br>
              <div class="btn-group">
                <a href="javascript:void(0);" class="btn btn-success" ng-click="importRows()" ng-if="isCompleteValidation() && numberOfSuccess!=0">Start Importing</a>
                <a href="javascript:void(0);" onclick="location.reload()" class="btn btn-primary">Reupload CSV</a>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <div class="table-responsive">
              <span ng-if="!(exported_data|isEmpty)" ng-cloak><b><i>* Note</i></b>: <span>green</span> rows <b ng-bind="greenStatus"></b>, <span>red</span> rows <b ng-bind="redStatus"></b> </span>
              <table class="table table-bordered" ng-if="!(exported_data|isEmpty)" ng-cloak>
                <thead>
                  <tr>
                    <th style="text-align:center"></th>
                    <th ng-repeat="column in columns" style="text-align:center" title="{{column.name}}">{{column.name|limitTo:15}}</th>
                  </tr>
                </thead>
                <tbody>
                  <tr ng-repeat="(index,item) in exported_data | filter:test" ng-class="item.status" ng-if="filterRowsBy=='all'||item.status==filterRowsBy">
                    <td>
                      <button ng-click="showErrors(item,index)" class="btn btn-danger" ng-if="item.status=='danger'">SHOW ERRORS</button>
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
          <p ng-repeat="error in errors track by $index">
            <span ng-bind-html="deliberatelyTrustDangerousSnippet(error)"></span>
            <button class="btn btn-primary" ng-if="error=='Guardian is not registered.'" ng-click="addGuardianForm()">ADD GUARDIAN</button>
            <button class="btn btn-primary" ng-if="error=='Class is not registered.'" ng-click="addClassForm()">ADD CLASS</button>
          </p>
          <p style="color:red">
            <b><i>* Note: If you add the guardian or class using this window, you must reupload your csv file in order to revalidate the data.</i></b>
          </p>
        </div>
        <div class="modal-footer">
         
          <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
        </div>
      </div>

    </div>
  </div>
</div>

</div>


<?php echo $modaljs_scripts; ?>
<?php echo $js_scripts; ?>
<?php echo '<script type="text/javascript" src="'.base_url("assets/js/angular.min.js").'"></script>'; ?>
<?php echo '<script type="text/javascript" src="'.base_url("assets/js/angular-sanitize.min.js").'"></script>'; ?>
<script>

var app = angular.module('myApp', ['ngSanitize']);
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
    $scope.greenStatus = "are valid";
    $scope.redStatus = "are invalid";
    $scope.currentTask = "validating";
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
        $('#student_csv_help-block').html("");
      },
      success: function(data) {
        $scope.has_uploaded = true;
        $scope.exported_data = data.exported_data;
        $scope.columns = data.columns;
        $scope.validateUpload();
      },
      error: function(e) {
        console.log(e);
        $('#student_csv_help-block').html(e.responseJSON.error);
        $scope.has_uploaded = false;
      },
      complete: function() {
        $("button[form='upload-student-form']").prop('disabled', false);
        $scope.has_uploaded = true;
      }
    })
  });
  $scope.rowIndex = 0;
  $scope.importIndex = 0;
  $scope.validRows = [];
  $scope.numberOfErrors = 0;
  $scope.numberOfSuccess = 0;
  $scope.has_uploaded = false;
  $scope.importComplete = false;
  $scope.filterRowsBy = "all";
  $scope.rowData = {};
  $scope.csrf_name = "<?php echo $this->security->get_csrf_token_name();?>";
  $scope.csrf_value = "<?php echo $this->security->get_csrf_hash();?>";
  $scope.validateUpload = function(specificIndex) {
    hasSpecificindex = ((typeof specificIndex !== 'undefined') && specificIndex !== "");
    if($scope.exported_data.length!=$scope.rowIndex || hasSpecificindex){
        let index = hasSpecificindex ? specificIndex : $scope.rowIndex;
        $scope.exported_data[index][$scope.csrf_name] = $scope.csrf_value;
        let data = $scope.exported_data[index];
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
          $scope.exported_data[index]["status"] = response.data.is_valid ? "success": "danger";
          if(response.data.is_valid){
            $scope.numberOfSuccess++;
          }else{
            $scope.numberOfErrors++;
          }
          $scope.exported_data[index]["compiled_errors"] = response.data.compiled_errors;
          if($scope.exported_data.length==index){
            
          }else{
            if(hasSpecificindex){
              
            }else{
              $scope.rowIndex++;
              setTimeout(() => {
                $scope.validateUpload();
              }, 250);
            }
          }
        }, function(rejection) {
          setTimeout(() => {
            $scope.validateUpload();
          }, 250);
          $scope.submit = false;
        });
    }else{
      alertify.success('Validation Complete');
    }
  }
  
  $scope.reValidateRow = function(data,index) {
    $scope.validateUpload(index);
  }

  $scope.showErrors = function(data,index) {
    $scope.rowData = $scope.exported_data[index];
    $scope.errors = [];
    $scope.errors = data.compiled_errors;
    $('#upload-error-modal').modal('show');
  }

  $scope.addGuardianForm = function() {
    // console.log($scope.rowData);
    let guardian_name = $scope.rowData.guardian_last_name + " " + $scope.rowData.guardian_first_name + " " + $scope.rowData.guardian_middle_name;
    $('#register_guardian_modal').modal('show');
    $('#add_guardian_last_name').val($scope.rowData.guardian_last_name);
    $('#add_guardian_middle_name').val($scope.rowData.guardian_middle_name);
    $('#add_guardian_first_name').val($scope.rowData.guardian_first_name);
    $('#add_guardian_name').val(guardian_name);
    $('#add_guardian_address').val($scope.rowData.guardian_address);
    $('#add_guardian_contact_number').val($scope.rowData.guardian_contact_number);
  }
  $scope.addClassForm = function() {
    $('#class_add_modal').modal('show');
    // console.log($scope.rowData);
    $('#add_class_name').val($scope.rowData.class_name);
    $('#add_class_grade').val($scope.rowData.grade);
  }

  $scope.isCompleteValidation = function() {
    return $scope.exported_data.length==$scope.rowIndex;
  }

  $scope.importRows = function() {
    $scope.validRows = $scope.exported_data.filter( item => item.status == "success" );
    alertify.confirm('START IMPORTING', 'This will only import valid students. Continue?', function(){
      angular.forEach($scope.validRows, function(value, key) {
        $scope.validRows[key].status = "";
        $scope.validRows[key].student_photo = "";
      });
      $scope.rowIndex = 0;
      $scope.greenStatus = "are added";
      $scope.redStatus = "have errors";
      $scope.$apply(function () {
          $scope.exported_data = {};
          $scope.exported_data = $scope.validRows;
      });
      $scope.currentTask = "importing";
      $scope.numberOfErrors = 0;
      $scope.numberOfSuccess = 0;
      $scope.importComplete = false;
      $scope.addStudent();
    },
    function(){
      // alertify.error('Cancelled')
    });
  }

$scope.addStudent = function(specificIndex) {
    hasSpecificindex = ((typeof specificIndex !== 'undefined') && specificIndex !== "");
    if($scope.exported_data.length!=$scope.rowIndex || hasSpecificindex){
        let index = hasSpecificindex ? specificIndex : $scope.rowIndex;
        $scope.exported_data[index][$scope.csrf_name] = $scope.csrf_value;
        let data = $scope.exported_data[index];
        $scope.formerrors = {};
        $scope.submit = true; 
        $http({
          method: 'POST',
          url: base_url+"student_ajax/add",
          data: $.param(data),
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          }
        }).then(function(response) {
          $scope.submit = false;
          $scope.exported_data[index]["status"] = response.data.is_valid ? "success": "danger";
          if(response.data.is_valid){
            $scope.numberOfSuccess++;
          }else{
            $scope.numberOfErrors++;
          }
          $scope.exported_data[index]["compiled_errors"] = response.data.compiled_errors;
          if($scope.exported_data.length==index){
            // $scope.rowIndex++;
          }else{
            if(hasSpecificindex){

            }else{
              $scope.rowIndex++;
              setTimeout(() => {
                $scope.addStudent();
              }, 250);
            }
          }
        }, function(rejection) {
          setTimeout(() => {
            $scope.addStudent();
          }, 250);
          $scope.submit = false;
        });
    }else{
      alertify.success('Importing Complete');
      $scope.importComplete = true;
    }
  }

  $scope.toggleRows = function(data) {
    $scope.filterRowsBy = data.filterRowsBy;
  }

  $scope.deliberatelyTrustDangerousSnippet = function(data) {
    return $sce.trustAsHtml(data);
  };

});
</script>
</body>
</html>