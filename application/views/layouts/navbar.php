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
        <a class="navbar-brand" href="#"></a>
      </div>
      <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav">
          <li><a href="'.base_url("admin").'">Home</a></li>
          <li><a href="#" id="rfid_add_load_credits">Add load</a></li>
          <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Students
            <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="'.base_url("admin/students").'">List of Students</a></li>
              <li><a href="#" class="rfid_scan_add" id="students">Add Students</a></li>
              ';
              
              echo '
            </ul>
          </li>
          ';
          
          echo '
          <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Teachers
            <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="'.base_url("admin/teachers").'">List of Teachers</a></li>
              <li><a href="#" class="rfid_scan_add" id="teachers">Add Teachers</a></li>
              <li><a href="#" id="class_list">List of Classes</a></li>
              <li><a href="#" id="class_add" >Add a Class</a></li>
              
            </ul>
          </li>
          ';

          echo '
          <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Guardians
            <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="'.base_url("student/").'">List of Guardians</a></li>
              <li><a href="#" id="register_guardian">Add Guardians</a></li>
            </ul>
          </li>
          ';
          
          echo '
          <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Canteen
            <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="'.base_url("admin/canteen").'">List of Canteen</a></li>
              <li><a href="#" id="add_canteen">Add Canteen</a></li>
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
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Guards
            <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="'.base_url("admin/guards").'">List of Guards</a></li>
              <li><a href="#" class="rfid_scan_add" id="guards">Add Guards</a></li>
              ';
              
              echo '
            </ul>
          </li>
        ';
        echo '

          <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
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
        <a class="navbar-brand" href="#"></a>
      </div>
      <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav">
          <li><a href="'.base_url().'">Home</a></li>
          <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Students
            <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="'.base_url("home/student").'">My Students</a></li>
            </ul>
          </li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
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
        <a class="navbar-brand" href="#"></a>
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
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
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
}
?>