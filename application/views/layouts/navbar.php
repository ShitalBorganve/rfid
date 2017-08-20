<?php

if($navbar_type=="admin"){
  echo '
  <nav class="navbar navbar-inverse">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span> 
        </button>
        <a class="navbar-brand" href="javascript:void(0)"></a>
      </div>
      <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav">
          <li><a href="'.base_url("admin").'">Home</a></li>';
          
          // echo '<li><a href="javascript:void(0)" id="rfid_add_load_credits">Add load</a></li>';
          echo '<li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0)">Students
            <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="'.base_url("admin/students").'">List of Students</a></li>
              <li><a href="javascript:void(0)" class="rfid_scan_add" id="students">Add Students</a></li>
              ';
              
              echo '
            </ul>
          </li>
          ';
          
          echo '
          <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0)">Teachers
            <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="'.base_url("admin/teachers").'">List of Teachers</a></li>
              <li><a href="javascript:void(0)" class="rfid_scan_add" id="teachers">Add Teachers</a></li>
              
            </ul>
          </li>
          ';

          echo '
          <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0)">Classes
            <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="'.base_url("admin/classes").'">List of Classes</a></li>
              <li><a href="javascript:void(0)" id="class_add" >Add a Class</a></li>
              
            </ul>
          </li>
          ';

          echo '
          <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0)">Non-Teaching
            <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="'.base_url("admin/staffs").'">List of Staffs</a></li>
              <li><a href="javascript:void(0)" class="rfid_scan_add" id="staffs">Add Staff</a></li>
              
            </ul>
          </li>
          ';



          
/*          echo '
          <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0)">Canteen
            <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="'.base_url("admin/canteen").'">List of Canteen</a></li>
              <li><a href="javascript:void(0)" id="add_canteen">Add Canteen</a></li>
              ';
              
              echo '
            </ul>
          </li>

        ';
*/

        echo '
        </ul>
        <ul class="nav navbar-nav navbar-right"> ';


        echo '
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0)">Guardians
          <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="'.base_url("admin/guardians").'">List of Guardians</a></li>
            <li><a href="javascript:void(0)" id="register_guardian">Add Guardians</a></li>
          </ul>
        </li>
        ';

        echo '
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0)">Fetchers
          <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="'.base_url("admin/fetchers").'">List of Fetchers</a></li>
            <li><a href="javascript:void(0)" class="rfid_scan_add" id="fetchers">Add Fetcher</a></li>
          </ul>
        </li>
        ';

        // echo '<li><a href="javascript:void(0)" id="fetchers">Fetchers</a></li>';

        echo '
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0)">Gate Logs
          <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="'.base_url("admin/gatelogs/students").'">Students</a></li>
            <li><a href="'.base_url("admin/gatelogs/teachers").'">Teachers</a></li>
            <li><a href="'.base_url("admin/gatelogs/staffs").'">Non-Teaching Staffs</a></li>
            <li><a href="'.base_url("admin/gatelogs/fetchers").'">Fetchers</a></li>
            
          </ul>
        </li>
        ';

        echo '

          <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0)">
            &nbsp;<span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li>';
              if($navbar_is_logged_in){
                echo '<a href="javascript:void(0)" class="change_password" id="admins"><span class="glyphicon glyphicon-cog"></span> Change Password</a>';
                echo '<a href="javascript:void(0)" id="send-sms-admin" class="send-sms"><span class="glyphicon glyphicon glyphicon-send"></span> Send SMS <span class="badge"></span></a>';
                // echo '<a href="javascript:void(0)" id="send-sms-admin">Send SMS <span class="badge">'.$sms_module_sms_left.'</span></a>';
                echo '<a href="'.base_url("admin/sms").'"><span class="glyphicon glyphicon glyphicon-envelope"></span> SMS Threads</a>';
                echo '<a href="javascript:void(0)" id="gate_change_password"><span class="glyphicon glyphicon-cog"></span> Change Gate Password</a>';
                // echo '<a href="javascript:void(0)" id="change_school_ name"><span class="glyphicon glyphicon-cog"></span> '.$school_name.'</a>';
                echo '<a href="'.base_url("$navbar_type/logout").'"><span class="glyphicon glyphicon-log-out"></span> Logout</a>';
              }else{
                echo '<a href="'.base_url("$navbar_type/login").'"><span class="glyphicon glyphicon-log-in"></span> Login</a>';
              }
              echo '</li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  ';

}elseif ($navbar_type=="home"){
  echo '
  <nav class="navbar navbar-inverse">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span> 
        </button>
        <a class="navbar-brand" href="javascript:void(0)"></a>
      </div>
      <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav">
          <li><a href="'.base_url().'">Home</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0)">
          <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li>
              <a href="javascript:void(0)" class="email_settings" id="guardians"><span class="glyphicon glyphicon-cog"></span> Email Settings</a>
              <a href="javascript:void(0)" class="change_password" id="guardians"><span class="glyphicon glyphicon-cog"></span> Change Password</a>
              <a href="'.base_url("home/logout").'"><span class="glyphicon glyphicon-log-out"></span> Logout</a>
            ';
            echo '</li>
          </ul>
        </li>
        </ul>
      </div>
    </div>
  </nav>
  ';
}elseif ($navbar_type=="canteen") {
  echo '
  <nav class="navbar navbar-inverse">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span> 
        </button>
        <a class="navbar-brand" href="javascript:void(0)"></a>
      </div>
      <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav">
          <li><a href="'.base_url($navbar_type).'">Home</a></li>
          <li><a href="'.base_url("$navbar_type/items").'">Items</a></li>
          <li><a href="'.base_url("$navbar_type/sales").'">Sales</a></li>
          <li><a href="'.base_url("$navbar_type/receiving").'">Receiving</a></li>
          <li><a href="'.base_url("$navbar_type/expenses").'">Expenses</a></li>
          <li><a href="'.base_url("$navbar_type/reports").'">Reports</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0)">
            <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li>';
              if($navbar_is_logged_in){
                echo '<a href="'.base_url("$navbar_type/logout").'"><span class="glyphicon glyphicon-log-out"></span> Logout</a>';
              }else{
                echo '<a href="'.base_url("$navbar_type/login").'"><span class="glyphicon glyphicon-log-in"></span> Login</a>';
              }
              echo '</li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  ';
}elseif ($navbar_type=="jbtech") {

    echo '
    <nav class="navbar navbar-inverse">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span> 
          </button>
          <a class="navbar-brand" href="javascript:void(0)"></a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
          <ul class="nav navbar-nav">
            <li><a href="'.base_url("jbtech").'">Home</a></li>
            <li><a href="'.base_url("jbtech/students").'">Students</a></li>
            <li><a href="'.base_url("jbtech/teachers").'">Teachers</a></li>
            <li><a href="'.base_url("jbtech/staffs").'">Non-Teaching Staffs</a></li>
            <li><a href="'.base_url("jbtech/fetchers").'">Fetchers</a></li>

            ';
            

          echo '
          </ul>
          <ul class="nav navbar-nav navbar-right"> ';

          echo '

            <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0)">
              &nbsp;<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li>';
                if($navbar_is_logged_in){
                  echo '<a href="javascript:void(0)" class="change_password"><span class="glyphicon glyphicon-cog"></span> Change Password</a>';
                  echo '<a href="javascript:void(0)" id="reset_admin_password"><span class="glyphicon glyphicon-cog"></span> Reset Admin Password</a>';
                  echo '<a href="javascript:void(0)" id="add_admin"><span class="glyphicon glyphicon-user"></span> Add Admin Account</a>';
                  echo '<a href="'.base_url("$navbar_type/logout").'"><span class="glyphicon glyphicon-log-out"></span> Logout</a>';
                }else{
                  echo '<a href="'.base_url("$navbar_type/login").'"><span class="glyphicon glyphicon-log-in"></span> Login</a>';
                }
                echo '</li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    ';


  
}elseif ($navbar_type=="teacher") {

    echo '
    <nav class="navbar navbar-inverse">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span> 
          </button>
          <a class="navbar-brand" href="javascript:void(0)"></a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
          <ul class="nav navbar-nav">
            <li><a href="'.base_url("teacher").'">Home</a></li>';
            
            // echo '<li><a href="javascript:void(0)" id="rfid_add_load_credits">Add load</a></li>';
            echo '<li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0)">Students
              <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="'.base_url("teacher").'">List of Students</a></li>
                <li><a href="'.base_url("teacher/gatelogs").'">Gate logs</a></li>
                ';
                
                echo '
              </ul>
            </li>
            ';
            


          echo '
          </ul>
          <ul class="nav navbar-nav navbar-right"> ';
          


          echo '

            <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0)">
              &nbsp;<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li>';
                if($navbar_is_logged_in){
                  echo '<a href="javascript:void(0)" id="send-sms-teacher" class="send-sms"><span class="glyphicon glyphicon glyphicon-send"></span> Send SMS</a>';
                  echo '<a href="'.base_url("teacher/sms").'"><span class="glyphicon glyphicon glyphicon-envelope"></span> SMS Threads</a>';
                  echo '<a href="javascript:void(0)" class="change_password" id="teachers"><span class="glyphicon glyphicon-cog"></span> Change Password</a>';
                  echo '<a href="'.base_url("$navbar_type/logout").'"><span class="glyphicon glyphicon-log-out"></span> Logout</a>';
                }else{
                  echo '<a href="'.base_url("$navbar_type/login").'"><span class="glyphicon glyphicon-log-in"></span> Login</a>';
                }
                echo '</li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    ';
}
?>