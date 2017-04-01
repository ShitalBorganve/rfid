<?php

if($modals_sets=="admin"){



  echo '
  <!--RFID Scan to Add Student Modal -->
  <div id="rfid_scan_add_modal" class="modal fade" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-sm">

      <!-- Modal content-->
      <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="rfid_add_modal_title">Add students</h4>
      </div>
        <div class="modal-body">
          <p>
          '.form_open("rfid_ajax/scan_add",'id="rfid_scan_add_form"').'
          <input type="hidden" name="type">

            <div class="form-group">

              <label for="rfid_scan_add"></label>
              <div class="col-sm-12">
                <input type="text" class="form-control" name="rfid_scan_add" placeholder="Scan RFID using RFID Scanner..." autocomplete="off">
                <p class="help-block" id="rfid_scan_help-block"></p>
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

  echo '

  <!--Add Student Modal -->
  <div id="students_add_modal" class="modal fade" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lg">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add Students</h4>
        </div>
        <div class="modal-body">
          <p>'.form_open_multipart("student_ajax/add",'id="student_add_form" class="form-horizontal"').'
            <input type="hidden" class="form-control rfid_scanned_add" name="rfid">
            <div class="form-group">
              <label class="col-sm-2" for="first_name">First Name:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="first_name" placeholder="Enter First Name">
                <p class="help-block" id="student_first_name_help-block"></p>
              </div>
              
            </div>
            
            <div class="form-group">
              <label class="col-sm-2" for="last_name">Last Name:</label>
              <div class="col-sm-10"> 
                <input type="text" class="form-control" name="last_name" placeholder="Enter Last Name">
                <p class="help-block" id="student_last_name_help-block"></p>
              </div>
            </div>
            
            <div class="form-group">
              <label class="col-sm-2" for="middle_name">Middle Name:</label>
              <div class="col-sm-10"> 
                <input type="text" class="form-control" name="middle_name" placeholder="Enter Middle Name">
                <p class="help-block" id="student_middle_name_help-block"></p>
              </div>
            </div>
            
            <div class="form-group">
              <label class="col-sm-2" for="suffix">Suffix:</label>
              <div class="col-sm-10"> 
                <input type="text" class="form-control" name="suffix" placeholder="Enter Suffix (Jr. III etc.)">
                <p class="help-block" id="student_suffix_help-block"></p>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2" for="last_name">Birth Date:</label>
              <div class="col-sm-10">
                <select class="" name="bday_m" required>
                  <option value="">MM</option>
                  ';
                  for ($i=1; $i <= 12; $i++) { 
                    echo '<option value="'.$i.'">'.sprintf("%02d",$i).'</option>';
                  }
                  echo '
                </select>
                /
                <select class="" name="bday_d" required>
                  <option value="">DD</option>
                  ';
                  for ($i=1; $i <= 31; $i++) { 
                    echo '<option value="'.$i.'">'.sprintf("%02d",$i).'</option>';
                  }
                  echo '
                </select>
                /
                <select class="" name="bday_y" required>
                  <option value="">YYYY</option>
                  ';
                  for ($i=1980; $i <= date("Y"); $i++) { 
                    echo '<option value="'.$i.'">'.sprintf("%04d",$i).'</option>';
                  }
                  echo '
                </select>
                <p class="help-block" id="student_bday_help-block"></p>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2" for="contact_number">Contact Number:</label>
              <div class="col-sm-10"> 
                <input type="text" class="form-control" name="contact_number" placeholder="Enter Contact Number">
                <p class="help-block" id="student_contact_number_help-block"></p>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2" for="guardian">Guardians Email:</label>
              <div class="col-sm-8"> 
                <select class="ui search dropdown form-control" name="guardian_id">
                  <option value="">Select a Guardians Email</option>
                  ';
                  foreach ($guardians_list["result"] as $guardian_data) {
                    echo '<option value="'.$guardian_data->id.'">'.$guardian_data->email_address.'</option>';
                  }

                  echo '
                </select>

                <p class="guardian_id_help-block"></p>
              </div>
              <div class="col-sm-2"> 
                <button type="button" class="btn btn-default btn-block" id="add_guardian">Add</button>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2" for="class_id">Class:</label>
              <div class="col-sm-10"> 
                <select class="ui search dropdown form-control" name="class_id" data-live-search="true">
                  <option value="">Select a Class</option>
                  ';
                  foreach ($classes_list["result"] as $class_data) {
                    echo '<option value="'.$class_data->id.'">'.$class_data->class_name.'</option>';
                  }

                  echo '
                </select>

                <p class="help-block" id="student_class_id_help-block"></p>
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
          <button type="submit" class="btn btn-primary" form="student_add_form">Add Student</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>

    </div>
  </div>

  ';



  echo '

  <!--Add Teachers Modal -->
  <div id="teachers_add_modal" class="modal fade" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lg">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add teachers</h4>
        </div>
        <div class="modal-body">
          <p>'.form_open_multipart("teacher_ajax/add",'id="teacher_add_form" class="form-horizontal"').'
            <input type="hidden" class="form-control rfid_scanned_add" name="rfid">
            <div class="form-group">
              <label class="col-sm-2" for="first_name">First Name:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="first_name" placeholder="Enter First Name">
                <p class="help-block" id="teacher_first_name_help-block"></p>
              </div>
              
            </div>
            
            <div class="form-group">
              <label class="col-sm-2" for="last_name">Last Name:</label>
              <div class="col-sm-10"> 
                <input type="text" class="form-control" name="last_name" placeholder="Enter Last Name">
                <p class="help-block" id="teacher_last_name_help-block"></p>
              </div>
            </div>
            
            <div class="form-group">
              <label class="col-sm-2" for="middle_name">Middle Name:</label>
              <div class="col-sm-10"> 
                <input type="text" class="form-control" name="middle_name" placeholder="Enter Middle Name">
                <p class="help-block" id="teacher_middle_name_help-block"></p>
              </div>
            </div>
            
            <div class="form-group">
              <label class="col-sm-2" for="suffix">Suffix:</label>
              <div class="col-sm-10"> 
                <input type="text" class="form-control" name="suffix" placeholder="Enter Suffix (Jr. III etc.)">
                <p class="help-block" id="teacher_suffix_help-block"></p>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2" for="contact_number">Contact Number:</label>
              <div class="col-sm-10"> 
                <input type="text" class="form-control" name="contact_number" placeholder="Enter Contact Number">
                <p class="help-block" id="teacher_contact_number_help-block"></p>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2" for="last_name">Birth Date:</label>
              <div class="col-sm-10">
                <select class="" name="bday_m" required>
                  <option value="">MM</option>
                  ';
                  for ($i=1; $i <= 12; $i++) { 
                    echo '<option value="'.$i.'">'.sprintf("%02d",$i).'</option>';
                  }
                  echo '
                </select>
                /
                <select class="" name="bday_d" required>
                  <option value="">DD</option>
                  ';
                  for ($i=1; $i <= 31; $i++) { 
                    echo '<option value="'.$i.'">'.sprintf("%02d",$i).'</option>';
                  }
                  echo '
                </select>
                /
                <select class="" name="bday_y" required>
                  <option value="">YYYY</option>
                  ';
                  for ($i=1980; $i <= date("Y"); $i++) { 
                    echo '<option value="'.$i.'">'.sprintf("%04d",$i).'</option>';
                  }
                  echo '
                </select>
                <p class="help-block" id="teacher_bday_help-block"></p>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2" for="class_id">Class:</label>
              <div class="col-sm-8"> 
                <select class="ui search dropdown form-control" name="class_id" data-live-search="true">
                  <option value="">Select a Class</option>
                  ';
                  foreach ($classes_list["result"] as $class_data) {
                    echo '<option value="'.$class_data->id.'">'.$class_data->class_name.'</option>';
                  }

                  echo '
                </select>
                <p class="help-block" id="teacher_class_id_help-block"></p>
              </div>
              <div class="col-sm-2"> 
                <button class="btn btn-block btn-default" type="button">Add</button>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2" for="teacher_photo">Photo:</label>
              <div class="col-sm-10">
              <input type="file" name="teacher_photo" size="20" class="form-control">
                <p class="help-block" id="teacher_photo_help-block"></p>
              </div>
            </div>

          </form></p>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" form="teacher_add_form">Add Teacher</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>

    </div>
  </div>

  ';




  echo '

  <!--Add Guards Modal -->
  <div id="guards_add_modal" class="modal fade" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lg">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add guards</h4>
        </div>
        <div class="modal-body">
          <p>'.form_open_multipart("guard_ajax/add",'id="guard_add_form" class="form-horizontal"').'
            <input type="hidden" class="form-control rfid_scanned_add" name="rfid">
            <div class="form-group">
              <label class="col-sm-2" for="first_name">First Name:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="first_name" placeholder="Enter First Name">
                <p class="help-block" id="guard_first_name_help-block"></p>
              </div>
              
            </div>
            
            <div class="form-group">
              <label class="col-sm-2" for="last_name">Last Name:</label>
              <div class="col-sm-10"> 
                <input type="text" class="form-control" name="last_name" placeholder="Enter Last Name">
                <p class="help-block" id="guard_last_name_help-block"></p>
              </div>
            </div>
            
            <div class="form-group">
              <label class="col-sm-2" for="middle_name">Middle Name:</label>
              <div class="col-sm-10"> 
                <input type="text" class="form-control" name="middle_name" placeholder="Enter Middle Name">
                <p class="help-block" id="guard_middle_name_help-block"></p>
              </div>
            </div>
            
            <div class="form-group">
              <label class="col-sm-2" for="suffix">Suffix:</label>
              <div class="col-sm-10"> 
                <input type="text" class="form-control" name="suffix" placeholder="Enter Suffix (Jr. III etc.)">
                <p class="help-block" id="guard_suffix_help-block"></p>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2" for="last_name">Birth Date:</label>
              <div class="col-sm-10">
                <select class="" name="bday_m" required>
                  <option value="">MM</option>
                  ';
                  for ($i=1; $i <= 12; $i++) { 
                    echo '<option value="'.$i.'">'.sprintf("%02d",$i).'</option>';
                  }
                  echo '
                </select>
                /
                <select class="" name="bday_d" required>
                  <option value="">DD</option>
                  ';
                  for ($i=1; $i <= 31; $i++) { 
                    echo '<option value="'.$i.'">'.sprintf("%02d",$i).'</option>';
                  }
                  echo '
                </select>
                /
                <select class="" name="bday_y" required>
                  <option value="">YYYY</option>
                  ';
                  for ($i=1980; $i <= date("Y"); $i++) { 
                    echo '<option value="'.$i.'">'.sprintf("%04d",$i).'</option>';
                  }
                  echo '
                </select>
                <p class="help-block" id="guard_bday_help-block"></p>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2" for="student_photo">Photo:</label>
              <div class="col-sm-10">
              <input type="file" name="student_photo" size="20" class="form-control">
                <p class="help-block" id="guard_photo_help-block"></p>
              </div>
            </div>

          </form></p>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" form="guard_add_form">Add Guard</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>

    </div>
  </div>

  ';




  echo '
  <!--RFID Scan to Load up Student Modal -->
  <div id="rfid_scan_add_load_credits_modal" class="modal fade" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-sm">

      <!-- Modal content-->
      <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Load to a Student</h4>
      </div>
        <div class="modal-body">
          <p>
          '.form_open("rfid_ajax/rfid_scan_add_load_credit",'id="rfid_scan_add_load_credit_form"').'

            <div class="form-group">

              <label for="rfid_scan_add_load_credits"></label>
              <div class="col-sm-12">
                <input type="text" class="form-control" name="rfid" placeholder="Scan RFID using RFID Scanner..." autocomplete="off">
                <p class="help-block" id="rfid_scan_add_load_credits_help-block"></p>
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

  echo '
  <!-- Load up Student Modal -->
  <div id="add_load_credits_data_modal" class="modal fade" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lg">

      <!-- Modal content-->
      <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Load to a Student</h4>
      </div>
        <div class="modal-body">
          <p>
          '.form_open("rfid/add_load_credits",'id="add_load_credits_form"').'
          <input name="rfid_id" type="hidden">
          <div class="row">

            <div class="col-sm-3">
              <img src="" class="img-responsive" alt="Student Photo" id="add_load_credits_display-photo">
            </div>
            <div class="col-sm-9">
                <table class="table">
                  <tbody>
                    <tr>
                      <th>Name:</th>
                      <td><span id="add_load_credits_full_name"></span></td>
                    </tr>
                    <tr>
                      <th>Remaining Load:</th>
                      <td><span id="add_load_credits_remaining_load"></span></td>
                    </tr>
                    <tr>
                      <th>Add Load:</th>
                      <td><input type="number" name="load_credits" class="form-control" step="0.01" min="1" placeholder="Enter Amount" required>
                      <p class="help-block" id="load_credits_help-block"></p>
                      </td>
                    </tr>
                  </tbody>
                </table>
            </div>

          </div>


          </form>
          </p>
        </div>
        <div class="modal-footer">
         
          <button type="submit" class="btn btn-primary" form="add_load_credits_form">Submit</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>

    </div>
  </div>

  ';



  echo '
  <!-- Add Guardian Modal -->
  <div id="register_guardian_modal" class="modal fade" role="dialog" tabindex="-1">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Register A Guardian</h4>
        </div>
        <div class="modal-body">
          <p>'.form_open("guardian_ajax/register",'id="register_guardian_form" class="form-horizontal"');


          echo '

          <div class="form-group">
            <label class="col-sm-4" for="guardian_name">Guardian Name:</label>
            <div class="col-sm-8"> 
              <input type="text" class="form-control" name="guardian_name" placeholder="Enter Guardian Name">
              <p class="help-block" id="guardian_name_help-block"></p>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-4" for="email_address">Email Address:</label>
            <div class="col-sm-8"> 
              <input type="text" class="form-control" name="email_address" placeholder="Enter Email Address">
              <p class="help-block" id="email_address_help-block"></p>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-4" for="contact_number">Contact Number:</label>
            <div class="col-sm-8"> 
              <input type="text" class="form-control" name="contact_number" placeholder="Enter Contact Number">
              <p class="help-block" id="contact_number_help-block"></p>
            </div>
          </div>



          <div class="form-group">
            <label class="col-sm-4" for="email_subscription">Subscription:</label>
            <div class="col-sm-8"> 
              <div class="checkbox">
                <label><input type="checkbox" name="email_subscription" value="1"> Email Subscription</label>
              </div>
              <div class="checkbox">
                <label><input type="checkbox" name="sms_subscription" value="1"> SMS Subscription</label>
              </div>
              <p class="help-block" id="contact_number_help-block"></p>
            </div>
          </div>
          ';

          echo '</form></p>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" form="register_guardian_form">Submit</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>

    </div>
  </div>

  ';


  echo '
  <!-- Add Canteen Modal -->
  <div id="add_canteen_modal" class="modal fade" role="dialog" tabindex="-1">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Canteen</h4>
      </div>
        <div class="modal-body">
          <p>
          '.form_open("canteen_ajax/add",'id="add_canteen_form" class="form-horizontal"').'

          <div class="form-group">
            <label class="col-sm-4" for="canteen_name">Canteen Name:</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" name="canteen_name" placeholder="Enter Canteen Name" required>
              <p class="help-block" id="canteen_name_help-block"></p>
            </div>
            
          </div>

          <div class="form-group">
            <label class="col-sm-4" for="canteen_address">Address:</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" name="canteen_address" placeholder="Enter Canteen Address" required>
              <p class="help-block" id="canteen_address_help-block"></p>
            </div>
            
          </div>

          <div class="form-group">
            <label class="col-sm-4" for="canteen_contact_number">Contact Number:</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" name="canteen_contact_number" placeholder="Enter Canteen Contact Number" required>
              <p class="help-block" id="canteen_contact_number_help-block"></p>
            </div>
            
          </div>


          </form>
          </p>
        </div>
        <div class="modal-footer">
         
          <button type="submit" class="btn btn-primary" form="add_canteen_form">Submit</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>

    </div>
  </div>

  ';

  echo '
  <!-- Add Canteen Users Modal -->
  <div id="add_canteen_users_modal" class="modal fade" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lg">

      <!-- Modal content-->
      <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Canteen</h4>
      </div>
        <div class="modal-body">
          <p>
          '.form_open("canteen_ajax/add_users",'id="add_canteen_users_form" class="form-horizontal"').'

          <div class="form-group">
            <label class="col-sm-4" for="canteen_username">Username:</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" name="canteen_username" placeholder="Enter Username" required>
              <p class="help-block" id="canteen_username_help-block"></p>
            </div>
          </div>


          <div class="form-group">
            <label class="col-sm-4" for="canteen_password">Password:</label>
            <div class="col-sm-8">
              <input type="password" class="form-control" name="canteen_password" placeholder="Enter Password" autocomplete="new-password" required>
              <p class="help-block" id="canteen_password_help-block"></p>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-4" for="canteen_confirm_password">Confirm Password:</label>
            <div class="col-sm-8">
              <input type="password" class="form-control" name="canteen_confirm_password" placeholder="Confirm Password" autocomplete="new-password" required>
              <p class="help-block" id="canteen_confirm_password_help-block"></p>
            </div>
          </div>

          </form>
          </p>
        </div>
        <div class="modal-footer">
         
          <button type="submit" class="btn btn-primary" form="add_canteen_users_form">Submit</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>

    </div>
  </div>

  ';


  echo '
  <!-- Add Clas Modal -->
  <div id="class_add_modal" class="modal fade" role="dialog" tabindex="-1">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="rfid_add_modal_title">Add students</h4>
      </div>
        <div class="modal-body">
          <p>
          '.form_open("class_ajax/add",'id="class_add_form"  class="form-horizontal"').'

            <div class="form-group">
              <label class="col-sm-4" for="class_adviser">Class Adviser:</label>
              <div class="col-sm-8">
              ';
              echo '
                <select class="ui search dropdown form-control" name="class_adviser" data-live-search="true">
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
                <input type="text" class="form-control" name="class_name" placeholder="Enter Class Name">
                <p class="help-block" id="class_name_help-block"></p>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-4" for="class_room">Classroom:</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="class_room" placeholder="Enter Classroom">
                <p class="help-block" id="class_room_help-block"></p>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-4" for="class_schedule">Class Schedule:</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="class_schedule" placeholder="Enter Class Schedule">
                <p class="help-block" id="class_schedule_help-block"></p>
              </div>
            </div>

          </form>
          </p>
        </div>
        <div class="modal-footer">
         
          <button type="submit" class="btn btn-primary" form="class_add_form">Submit</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>

    </div>
  </div>

  ';

  echo '
<!-- SMS Modal -->
<div id="sms-modal" class="modal fade" role="dialog" tabindex="-1">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Send SMS</h4>
      </div>
      <div class="modal-body">';
      echo form_open("sms_ajax/send",'id="sms-form" class="form-horizontal"');

      echo '
      <div class="form-group">
        <label class="col-sm-4" for="type_recipient">Send to:</label>
        <div class="col-sm-8">
          <select name="type_recipient" class="form-control">
            <option value="all">Teachers and Students of the class</option>
            <option value="teachers">Teachers of the class</option>
            <option value="students">Students of the class</option>
          </select>
          <p class="help-block" id="first_name_help-block"></p>
        </div>
      </div>

      <div class="form-group">
        <label class="col-sm-4" for="sms_message">Message:</label>
        <div class="col-sm-8">
          <textarea class="form-control" name="message" placeholder="Enter your message."></textarea>
          <p class="help-block" id="first_name_help-block"></p>
        </div>
      </div>


      <div class="form-group">
        <label class="col-sm-4" for="sms_recipient">Send to:</label>
        <div class="col-sm-8">
          <select class="ui fluid search dropdown" multiple="" name="class_id[]">
          </select>
          <p class="help-block" id="first_name_help-block"></p>
        </div>
      </div>

      ';

      echo '</form>';

      echo '</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

';
}

// var_dump();

echo '
<!-- Alert Modal -->
<div id="alert-modal" class="modal fade" role="dialog" tabindex="-1">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="alert-modal-title">Modal Header</h4>
      </div>
      <div class="modal-body" id="alert-modal-body">
        <p>Some text in the modal.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

';

?>