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
          <input type="hidden" name="id">

            <div class="form-group">

              <label for="rfid"></label>
              <div class="col-sm-12">
                <input type="text" class="form-control" name="rfid" placeholder="Scan RFID using RFID Reader..." autocomplete="off">
                <p class="help-block" id="rfid_scan_help-block"></p>
              </div>

            </div>

            <div class="form-group">

            <label class="col-sm-12" for="last_name">Valid Until:</label>

            </div>

             <div class="form-group">
              
              <div class="col-sm-12">
                <select class="" name="valid_m" required>
                  <option value="">MM</option>
                  ';
                  for ($i=1; $i <= 12; $i++) { 
                    echo '<option value="'.$i.'">'.sprintf("%02d",$i).'</option>';
                  }
                  echo '
                </select>
                /
                <select class="" name="valid_d" required>
                  <option value="">DD</option>
                  ';
                  for ($i=1; $i <= 31; $i++) { 
                    echo '<option value="'.$i.'">'.sprintf("%02d",$i).'</option>';
                  }
                  echo '
                </select>
                /
                <select class="" name="valid_y" required>
                  <option value="">YYYY</option>
                  ';
                  for ($i=date("Y"); $i <= (date("Y")+20); $i++) { 
                    echo '<option value="'.$i.'">'.sprintf("%04d",$i).'</option>';
                  }
                  echo '
                </select>
                <p class="help-block" id="rfid_valid_date_help-block"></p>
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
            <!-- <input type="hidden" class="form-control rfid_scanned_add" name="rfid"> -->


            <div class="form-group">
              <label class="col-sm-2" for="class_id">Class:</label>
              <div class="col-sm-10"> 
                <select class="ui search form-control" name="class_id" data-live-search="true" id="student_add_select_class">
                  <option value="">Select a Class</option>
                  ';
                  foreach ($classes_list["result"] as $class_data) {
                    echo '<option value="'.$class_data->id.'" data-grade="'.$class_data->grade.'">'.$class_data->class_name.'</option>';
                  }

                  echo '
                </select>

                <p class="help-block" id="student_class_id_help-block"></p>
                <input type="hidden" id="grade" name="grade">
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2" for="lrn_number">LRN Number:</label>
              <div class="col-sm-10"> 
                <input type="text" class="form-control" name="lrn_number" placeholder="Enter LRN Number">
                <p class="help-block" id="student_lrn_number_help-block"></p>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2" for="first_name">First Name:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="first_name" placeholder="Enter First Name">
                <p class="help-block" id="student_first_name_help-block"></p>
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
              <label class="col-sm-2" for="last_name">Last Name:</label>
              <div class="col-sm-10"> 
                <input type="text" class="form-control" name="last_name" placeholder="Enter Last Name">
                <p class="help-block" id="student_last_name_help-block"></p>
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
              <label class="col-sm-2" for="contact_number">Contact Number:</label>
              <div class="col-sm-10"> 
                <input type="text" class="form-control" name="contact_number" placeholder="Enter Contact Number">
                <p class="help-block" id="student_contact_number_help-block"></p>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2" for="guardian_name">Gender:</label>
              <div class="col-sm-10"> 
                <select name="gender" class="form-control" required>
                  <option value="MALE">MALE</option>
                  <option value="FEMALE">FEMALE</option>
                </select>
                <p class="help-block" id="student_gender_help-block"></p>
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
              <label class="col-sm-2" for="age_as_of_august">Age as of August 31st(of the current year):</label>
              <div class="col-sm-10">
                <input type="number" class="form-control" name="age_as_of_august" placeholder="Enter Age">
                <p class="help-block" id="student_age_help-block"></p>
              </div>
              
            </div>

            <div class="form-group">
              <label class="col-sm-2" for="mother_tongue">Mother Tongue:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="mother_tongue" placeholder="Enter Mother Tongue">
                <p class="help-block" id="student_mother_tongue_help-block"></p>
              </div>
              
            </div>

            <div class="form-group">
              <label class="col-sm-2" for="ethnic_group">Ethnic Group:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="ethnic_group" placeholder="Enter Ethnic Group">
                <p class="help-block" id="student_ethnic_group_help-block"></p>
              </div>
              
            </div>

            <div class="form-group">
              <label class="col-sm-2" for="religion">Religion:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="religion" placeholder="Enter Religion">
                <p class="help-block" id="student_religion_help-block"></p>
              </div>
              
            </div>

            <div class="form-group">
              <label class="col-sm-2" for="address">Address:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="address" placeholder="Enter Address">
                <p class="help-block" id="student_address_help-block"></p>
              </div>
              
            </div>

            <div class="form-group">
              <label class="col-sm-2" for="is_transferee">Transferee:</label>
              <div class="col-sm-10">
                <label class="radio-inline"><input type="radio" name="is_transferee" value="1" checked>Yes</label>
                <label class="radio-inline"><input type="radio" name="is_transferee" value="0">No</label>
                <p class="help-block" id="student_is_transferee_help-block"></p>
              </div>
              
            </div>

            <div class="form-group">
              <label class="col-sm-2" for="last_school_attended">Last School Attended:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="last_school_attended" placeholder="Enter Last School Attended">
                <p class="help-block" id="student_last_school_attended_help-block"></p>
              </div>
              
            </div>

            <div class="form-group">
              <label class="col-sm-2" for="last_year_attended">Last Year Attended:</label>
              <div class="col-sm-10">
                <input type="number" class="form-control" name="last_year_attended" placeholder="Enter Last Year Attended">
                <p class="help-block" id="student_last_year_attended_help-block"></p>
              </div>
              
            </div>

            <div class="form-group">
              <label class="col-sm-2" for="last_grade_attended">Last Grade Attended:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="last_grade_attended" placeholder="Enter Last Grade Attended">
                <p class="help-block" id="student_last_grade_attended_help-block"></p>
              </div>
              
            </div>

            <div class="form-group">
              <label class="col-sm-2" for="last_track_strand">Last Track - Strand:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="last_track_strand" placeholder="Enter Last Track - Strand">
                <p class="help-block" id="student_last_track_strand_help-block"></p>
              </div>
              
            </div>

            <div class="form-group">
              <label class="col-sm-2" for="academic_track">Academic Track:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="academic_track" placeholder="Enter Academic Track">
                <p class="help-block" id="student_academic_track_help-block"></p>
              </div>
              
            </div>

            <div class="form-group">
              <label class="col-sm-2" for="tech_voc_track">Technical-Vocational Livelihood Track:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="tech_voc_track" placeholder="Enter Technical-Vocational Livelihood Track">
                <p class="help-block" id="student_tech_voc_track_help-block"></p>
              </div>
              
            </div>

            <div class="form-group">
              <label class="col-sm-2" for="fathers_last_name">Father&apos;s Last Name:</label>
              <div class="col-sm-10"> 
                <input type="text" class="form-control" name="fathers_last_name" placeholder="Enter Father&apos;s Last Name">
                <p class="help-block" id="student_fathers_last_name_help-block"></p>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2" for="fathers_middle_name">Father&apos;s Middle Name:</label>
              <div class="col-sm-10"> 
                <input type="text" class="form-control" name="fathers_middle_name" placeholder="Enter Father&apos;s Middle Name">
                <p class="help-block" id="student_fathers_middle_name_help-block"></p>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2" for="fathers_first_name">Father&apos;s First Name:</label>
              <div class="col-sm-10"> 
                <input type="text" class="form-control" name="fathers_first_name" placeholder="Enter Father&apos;s First Name">
                <p class="help-block" id="student_fathers_first_name_help-block"></p>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2" for="fathers_contact_number">Fathers&apos;s Contact Number:</label>
              <div class="col-sm-10"> 
                <input type="text" class="form-control" name="fathers_contact_number" placeholder="Enter Fathers&apos;s Contact Number">
                <p class="help-block" id="student_fathers_contact_number_help-block"></p>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2" for="fathers_address">Fathers&apos;s Address:</label>
              <div class="col-sm-10"> 
                <input type="text" class="form-control" name="fathers_address" placeholder="Enter Fathers&apos;s Address">
                <p class="help-block" id="student_fathers_address_help-block"></p>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2" for="mothers_last_name">Mother&apos;s Last Name:</label>
              <div class="col-sm-10"> 
                <input type="text" class="form-control" name="mothers_last_name" placeholder="Enter Mother&apos;s Last Name">
                <p class="help-block" id="student_mothers_last_name_help-block"></p>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2" for="mothers_middle_name">Mother&apos;s Middle Name:</label>
              <div class="col-sm-10"> 
                <input type="text" class="form-control" name="mothers_middle_name" placeholder="Enter Mother&apos;s Middle Name">
                <p class="help-block" id="student_mothers_middle_name_help-block"></p>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2" for="mothers_first_name">Mother&apos;s First Name:</label>
              <div class="col-sm-10"> 
                <input type="text" class="form-control" name="mothers_first_name" placeholder="Enter Mother&apos;s First Name">
                <p class="help-block" id="student_mothers_first_name_help-block"></p>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2" for="mothers_contact_number">Mother&apos;s Contact Number:</label>
              <div class="col-sm-10"> 
                <input type="text" class="form-control" name="mothers_contact_number" placeholder="Enter Mother&apos;s Contact Number">
                <p class="help-block" id="student_mothers_contact_number_help-block"></p>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2" for="mothers_address">Mother&apos;s Address:</label>
              <div class="col-sm-10"> 
                <input type="text" class="form-control" name="mothers_address" placeholder="Enter Mother&apos;s Address">
                <p class="help-block" id="student_mothers_address_help-block"></p>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2" for="is_living_with_parents">Living with parents?:</label>
              <div class="col-sm-10"> 
                <label class="radio-inline"><input type="radio" name="is_living_with_parents" value="1" checked>Yes</label>
                <label class="radio-inline"><input type="radio" name="is_living_with_parents" value="0">No</label>
                <p class="help-block" id="student_is_living_with_parents_help-block"></p>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2" for="guardian">Guardians Contact Number:</label>
              <div class="col-sm-8"> 
                <select class="ui search dropdown form-control" name="guardian_id" id="add_student_guardian">
                  <option value="">Select a Guardians Contact Number</option>
                </select>

                <p class="guardian_id_help-block"></p>
              </div>
              <div class="col-sm-2"> 
                <button type="button" class="btn btn-default btn-block" id="add_guardian">Add</button>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2" for="student_photo">Photo:</label>
              <div class="col-sm-10">
              <input type="file" name="student_photo" size="20" class="form-control" accept="image/*">
                <p class="help-block" id="student_photo_help-block"></p>
              </div>
            </div>

          </form></p>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" form="student_add_form">Submit</button>
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
              <label class="col-sm-2" for="last_name">Last Name:</label>
              <div class="col-sm-10"> 
                <input type="text" class="form-control" name="last_name" placeholder="Enter Last Name">
                <p class="help-block" id="teacher_last_name_help-block"></p>
              </div>
            </div>

            
            <div class="form-group">
              <label class="col-sm-2" for="first_name">First Name:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="first_name" placeholder="Enter First Name">
                <p class="help-block" id="teacher_first_name_help-block"></p>
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
              <label class="col-sm-2" for="guardian_name">Gender:</label>
              <div class="col-sm-10"> 
                <select name="gender" class="form-control" required>
                  <option value="MALE">MALE</option>
                  <option value="FEMALE">FEMALE</option>
                </select>
                <p class="help-block" id="teacher_gender_help-block"></p>
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
              <label class="col-sm-2" for="address">Address:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="address" placeholder="Enter Address">
                <p class="help-block" id="teacher_address_help-block"></p>
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
                  for ($i=1940; $i <= date("Y"); $i++) { 
                    echo '<option value="'.$i.'">'.sprintf("%04d",$i).'</option>';
                  }
                  echo '
                </select>
                <p class="help-block" id="teacher_bday_help-block"></p>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2" for="blood_type">Blood Type:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="blood_type" placeholder="Enter Blood Type">
                <p class="help-block" id="teacher_blood_type_help-block"></p>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2" for="sss">SSS:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="sss" placeholder="Enter SSS">
                <p class="help-block" id="teacher_sss_help-block"></p>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2" for="philhealth">PhilHealth:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="philhealth" placeholder="Enter PhilHealth">
                <p class="help-block" id="teacher_philhealth_help-block"></p>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2" for="pagibig">Pag-IBIG:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="pagibig" placeholder="Enter Pag-IBIG">
                <p class="help-block" id="teacher_pagibig_help-block"></p>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2" for="tin">TIN:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="tin" placeholder="Enter TIN">
                <p class="help-block" id="teacher_tin_help-block"></p>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2" for="dept_head">Department Head:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="dept_head" placeholder="Enter Department Head">
                <p class="help-block" id="teacher_dept_head_help-block"></p>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2" for="dept_head_number">Department Head Contact Number:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="dept_head_number" placeholder="Enter Department Head Contact Number">
                <p class="help-block" id="teacher_dept_head_number_help-block"></p>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2" for="in_case_name">In Case of Emergency Contact:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="in_case_name" placeholder="Enter Contact Name">
                <p class="help-block" id="teacher_in_case_name_help-block"></p>
              </div>              
            </div>

            <div class="form-group">
              <label class="col-sm-2" for="in_case_contact_number">Person Contact Number:</label>
              <div class="col-sm-10"> 
                <input type="text" class="form-control" name="in_case_contact_number" placeholder="Enter Contact Number">
              <p class="help-block" id="teacher_in_case_contact_number_help-block"></p>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2" for="in_case_address">Person Address:</label>
              <div class="col-sm-10"> 
                <input type="text" class="form-control" name="in_case_address" placeholder="Enter Address">
              <p class="help-block" id="teacher_in_case_address_help-block"></p>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2" for="teacher_photo">Photo:</label>
              <div class="col-sm-10">
              <input type="file" name="teacher_photo" size="20" class="form-control" accept="image/*">
                <p class="help-block" id="teacher_photo_help-block"></p>
              </div>
            </div>

          </form></p>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" form="teacher_add_form">Submit</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>

    </div>
  </div>

  ';




  echo '

  <!--Add Staffs Modal -->
  <div id="staffs_add_modal" class="modal fade" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lg">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add staff</h4>
        </div>
        <div class="modal-body">
          <p>'.form_open_multipart("staff_ajax/add",'id="staff_add_form" class="form-horizontal"').'
            <input type="hidden" class="form-control rfid_scanned_add" name="rfid">

            <div class="form-group">
              <label class="col-sm-2" for="position">Position:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="position" placeholder="Enter Position">
                <p class="help-block" id="staff_position_help-block"></p>
              </div>
            </div>
            
            <div class="form-group">
              <label class="col-sm-2" for="last_name">Last Name:</label>
              <div class="col-sm-10"> 
                <input type="text" class="form-control" name="last_name" placeholder="Enter Last Name">
                <p class="help-block" id="staff_last_name_help-block"></p>
              </div>
            </div>
            

            <div class="form-group">
              <label class="col-sm-2" for="first_name">First Name:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="first_name" placeholder="Enter First Name">
                <p class="help-block" id="staff_first_name_help-block"></p>
              </div>
              
            </div>

            <div class="form-group">
              <label class="col-sm-2" for="middle_name">Middle Name:</label>
              <div class="col-sm-10"> 
                <input type="text" class="form-control" name="middle_name" placeholder="Enter Middle Name">
                <p class="help-block" id="staff_middle_name_help-block"></p>
              </div>
            </div>
            
            <div class="form-group">
              <label class="col-sm-2" for="suffix">Suffix:</label>
              <div class="col-sm-10"> 
                <input type="text" class="form-control" name="suffix" placeholder="Enter Suffix (Jr. III etc.)">
                <p class="help-block" id="staff_suffix_help-block"></p>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2" for="gender">Gender:</label>
              <div class="col-sm-10"> 
                <select name="gender" class="form-control" required>
                  <option value="MALE">MALE</option>
                  <option value="FEMALE">FEMALE</option>
                </select>
                <p class="help-block" id="staff_gender_help-block"></p>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2" for="contact_number">Contact Number:</label>
              <div class="col-sm-10"> 
                <input type="text" class="form-control" name="contact_number" placeholder="Enter Contact Number">
                <p class="help-block" id="staff_contact_number_help-block"></p>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2" for="address">Address:</label>
              <div class="col-sm-10"> 
                <input type="text" class="form-control" name="address" placeholder="Enter Address">
                <p class="help-block" id="staff_address_help-block"></p>
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
                  for ($i=1940; $i <= date("Y"); $i++) { 
                    echo '<option value="'.$i.'">'.sprintf("%04d",$i).'</option>';
                  }
                  echo '
                </select>
                <p class="help-block" id="staff_bday_help-block"></p>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2" for="blood_type">Blood Type:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="blood_type" placeholder="Enter Blood Type">
                <p class="help-block" id="staff_blood_type_help-block"></p>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2" for="sss">SSS:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="sss" placeholder="Enter SSS">
                <p class="help-block" id="staff_sss_help-block"></p>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2" for="philhealth">PhilHealth:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="philhealth" placeholder="Enter PhilHealth">
                <p class="help-block" id="staff_philhealth_help-block"></p>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2" for="pagibig">Pag-IBIG:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="pagibig" placeholder="Enter Pag-IBIG">
                <p class="help-block" id="staff_pagibig_help-block"></p>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2" for="tin">TIN:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="tin" placeholder="Enter TIN">
                <p class="help-block" id="staff_tin_help-block"></p>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2" for="dept_head">Department Head:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="dept_head" placeholder="Enter Department Head">
                <p class="help-block" id="staff_dept_head_help-block"></p>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2" for="dept_head_number">Department Head Contact Number:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="dept_head_number" placeholder="Enter Department Head Contact Number">
                <p class="help-block" id="staff_dept_head_number_help-block"></p>
              </div>
            </div>


            <div class="form-group">
              <label class="col-sm-2" for="in_case_name">In Case of Emergency Contact:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="in_case_name" placeholder="Enter Contact Name">
                <p class="help-block" id="staff_in_case_name_help-block"></p>
              </div>
              
            </div>
            

            <div class="form-group">
              <label class="col-sm-2" for="in_case_contact_number">Person Contact Number:</label>
              <div class="col-sm-10"> 
                <input type="text" class="form-control" name="in_case_contact_number" placeholder="Enter Contact Number">
              <p class="help-block" id="staff_in_case_contact_number_help-block"></p>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2" for="in_case_address">Person Address:</label>
              <div class="col-sm-10"> 
                <input type="text" class="form-control" name="in_case_address" placeholder="Enter Address">
              <p class="help-block" id="staff_in_case_address_help-block"></p>
              </div>
            </div>


            <div class="form-group">
              <label class="col-sm-2" for="staff_photo">Photo:</label>
              <div class="col-sm-10">
              <input type="file" name="staff_photo" size="20" class="form-control" accept="image/*">
                <p class="help-block" id="staff_photo_help-block"></p>
              </div>
            </div>

          </form></p>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" form="staff_add_form">Submit</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>

    </div>
  </div>

  ';


  echo '

  <!--Add fetcher Modal -->
  <div id="fetchers_add_modal" class="modal fade" role="dialog" tabindex="-1">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add Fetchers</h4>
        </div>
        <div class="modal-body" style="min-height: 300px;">
          <p>'.form_open_multipart("fetcher_ajax/add",'id="fetcher_add_form" class="form-horizontal"').'
            <!-- <input type="hidden" class="form-control rfid_scanned_add" name="rfid"> -->

            <div class="form-group">
              <label class="col-sm-3" for="student_id">Students to Fetch:</label>
              <div class="col-sm-9"> 
                <select class="ui fluid search dropdown" multiple="" name="fetcher_student_id[]">
                  <option value="">Last Name</option>
                </select>
                <p class="help-block" id="fetcher_student_id_help-block"></p>
              </div>
            </div>

          </form></p>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" form="fetcher_add_form">Submit</button>
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
                <input type="text" class="form-control" name="rfid" placeholder="Scan RFID using RFID Reader..." autocomplete="off">
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
          <input type="hidden" name="auto">
          <div class="form-group">
            <label class="col-sm-4" for="guardian_last_name">Guardian Last Name:</label>
            <div class="col-sm-8"> 
              <input type="text" class="form-control" name="guardian_last_name" placeholder="Enter Guardian Last Name" id="add_guardian_last_name">
              <p class="help-block" id="add_guardian_last_name_help-block"></p>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-4" for="guardian_middle_name">Guardian Middle Name:</label>
            <div class="col-sm-8"> 
              <input type="text" class="form-control" name="guardian_middle_name" placeholder="Enter Guardian Middle Name" id="add_guardian_middle_name">
              <p class="help-block" id="add_guardian_middle_name_help-block"></p>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-4" for="guardian_first_name">Guardian First Name:</label>
            <div class="col-sm-8"> 
              <input type="text" class="form-control" name="guardian_first_name" placeholder="Enter Guardian First Name" id="add_guardian_first_name">
              <p class="help-block" id="add_guardian_first_name_help-block"></p>
            </div>
          </div>

          <input type="hidden" class="form-control" name="guardian_name" placeholder="Enter Guardian Name" id="add_guardian_name">

          <div class="form-group">
            <label class="col-sm-4" for="guardian_name">Guardian&apos;s Address:</label>
            <div class="col-sm-8"> 
              <input type="text" class="form-control" name="guardian_address" placeholder="Enter Guardian&apos;s Address" id="add_guardian_address">
              <p class="help-block" id="add_guardian_address_help-block"></p>
            </div>
          </div>




          <div class="form-group">
            <label class="col-sm-4" for="email_address">Email Address:</label>
            <div class="col-sm-8"> 
              <input type="text" class="form-control" name="email_address" placeholder="Enter Email Address" id="add_guardian_email_address">
              <p class="help-block" id="add_email_address_help-block"></p>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-4" for="contact_number">Contact Number:</label>
            <div class="col-sm-8"> 
              <input type="text" class="form-control" name="contact_number" placeholder="Enter Contact Number" id="add_guardian_contact_number">
              <p class="help-block" id="add_contact_number_help-block"></p>
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
              <p class="help-block" id="add_subscription_help-block"></p>
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
  <!-- Add Class Modal -->
  <div id="class_add_modal" class="modal fade" role="dialog" tabindex="-1">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="rfid_add_modal_title">Add class</h4>
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
                <input type="text" class="form-control" name="class_name" placeholder="Enter Class Name" id="add_class_name">
                <p class="help-block" id="class_name_help-block"></p>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-4" for="grade">Grade or Year:</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="grade" placeholder="Enter Grade or Year" id="add_class_grade">
                <p class="help-block" id="grade_help-block"></p>
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
      echo '<input type="hidden" name="sender" value="admin">';
      echo '
      <div class="form-group">
        <label class="col-sm-4" for="type_recipient">Send to:</label>
        <div class="col-sm-8">
          <select name="type_recipient" class="form-control">
            <option value="teachers_students">Teachers and Students of the class</option>
            <option value="teachers">Teachers of the class</option>
            <option value="students">Students of the class</option>
            <option value="guardian">Students Guardian&apos;s of the class</option>
            <option value="members">All members of the class including Student&apos;s Guardian</option>
            <option value="staffs">All non-teaching staffs</option>
            <option value="all_teachers_students">All Students and Teachers</option>
            <option value="all_teachers">All Teachers</option>
            <option value="all_students">All Students</option>
            <option value="all_guardians">All Student&apos;s Guardians</option>
            <option value="all_members">All members including Student&apos;s Guardian</option>
          </select>
          <p class="help-block" id="type_recipient_help-block"></p>
        </div>
      </div>

      <div class="form-group">
        <label class="col-sm-4" for="message">Message:</label>
        <div class="col-sm-8">
          <textarea class="form-control" name="message" style="resize: vertical;" placeholder="Enter your message." rows="3">&#10;&#10;&#10;FROM: '.$app_config->client_name.'</textarea>
          <p class="help-block" id="message_help-block"></p>
        </div>
      </div>


      <div class="form-group" id="send-to-container">
        <label class="col-sm-4" for="sms_recipient">Send to Class:</label>
        <div class="col-sm-8">
          <select class="ui fluid search dropdown" multiple="" name="class_id[]">
          </select>
          <p class="help-block" id="class_id_help-block"></p>
        </div>
      </div>

      ';
      echo '<span id="smsapi-message-max" data-balloon-pos="right" data-balloon-length="fit">SMS Remaining: <b id="smsapi-message-left"></b></span>';
      echo '</form>';

      echo '</div>
      <div class="modal-footer">
        <img src="'.base_url("assets/images/loading.gif").'" style="width:3rem;height:3rem;display:none" class="loading"></img>
        <button type="submit" class="btn btn-primary" form="sms-form">Submit</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

';



echo '
<!-- SMS list Modal -->
<div id="sms-list-modal" class="modal fade" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">SMS Status of Message ID: <span id="message_id_txt"></span></h4>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <table class="table table-hover sms_list_table">
            <thead>
              <tr>
                <th>Message</th>
                <th>Mobile Number</th>
                <th>Recipient</th>
                <th>Recipient&apos;s Name</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default no-notif" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

';



echo '
<!-- Change Password Modal -->
<div id="gate_change_password-modal" class="modal fade" role="dialog" tabindex="-1">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="change_password-modal-title">Change Gate Password</h4>
      </div>
      <div class="modal-body">
        <p>
        '.form_open("admin_ajax/gate_change_password",'id="gate_change_password-form" class="form-horizontal"').'
        <input type="hidden" name="id" value="1">
        <input type="hidden" name="type" value="app_config">
        <div class="form-group">
          <label class="col-sm-4" for="current_password">Current Password:</label>
          <div class="col-sm-8"> 
            <input type="password" class="form-control" name="current_password" placeholder="Enter Current Password">
            <p class="help-block" id="gate_current_password_help-block"></p>
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-4" for="new_password">New Password:</label>
          <div class="col-sm-8"> 
            <input type="password" class="form-control" name="new_password" placeholder="Enter New Password">
            <p class="help-block" id="gate_new_password_help-block"></p>
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-4" for="confirm_password">Confirm New Password:</label>
          <div class="col-sm-8"> 
            <input type="password" class="form-control" name="confirm_password" placeholder="Enter Confirm New Password">
            <p class="help-block" id="gate_confirm_password_help-block"></p>
          </div>
        </div>


        </form>
        </p>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" form="gate_change_password-form">Submit</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

';


echo '
<!--RFID Scan to Load up Student Modal -->
<div id="change_school_name_modal" class="modal fade" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-sm">

    <!-- Modal content-->
    <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title">Change school name</h4>
    </div>
      <div class="modal-body">
        <p>
        '.form_open("admin/change_school_name",'id="change_school_name_form"').'

          <div class="form-group">
            <label for="change_school_name"></label>
            <div class="col-sm-12">
              <input type="text" class="form-control" name="school_name" placeholder="Enter School Name">
              <p class="help-block" id="school_name_help-block"></p>
            </div>
          </div>


        </form>
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" form="change_school_name_form">Save</button>
      </div>
    </div>

  </div>
</div>

';


}elseif ($modals_sets=="teacher") {
    echo '
  <!-- SMS Modal -->
  <div id="sms-modal-teacher" class="modal fade" role="dialog" tabindex="-1">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Send SMS</h4>
        </div>
        <div class="modal-body">';
        echo form_open("sms_ajax/send",'id="sms-form" class="form-horizontal"');
        echo '<input type="hidden" name="sender" value="teacher">';
        echo '<input type="hidden" name="class_id[]" value="'.$teacher_data->class_id.'">';
        echo '
        <div class="form-group">
          <label class="col-sm-4" for="type_recipient">Send to:</label>
          <div class="col-sm-8">
            <select name="type_recipient" class="form-control">
              <option value="students">Students of the class</option>
              <option value="guardian">Students Guardian&apos;s of the class</option>
              <option value="members">All members of the class including Student&apos;s Guardian</option>
            </select>
            <p class="help-block" id="type_recipient_help-block"></p>
          </div>
        </div>


        <div class="form-group">
          <label class="col-sm-4" for="message">Message:</label>
          <div class="col-sm-8">
            <textarea class="form-control" name="message" style="resize: vertical;" placeholder="Enter your message." rows="3">&#10;&#10;&#10;FROM: '.$app_config->client_name.'</textarea>
            <p class="help-block" id="message_help-block"></p>
          </div>
        </div>
        ';

        echo '</form>';

        echo '<span data-balloon="SMS has 1000 Max Messages per Day and will reset in 12MN." data-balloon-pos="right" data-balloon-length="large">SMS Remaining: <b id="smsapi-message-left"></b></span>';
        echo '</div>
        <div class="modal-footer">
          <img src="'.base_url("assets/images/loading.gif").'" style="width:3rem;height:3rem;display:none" class="loading"></img>
          <button type="submit" class="btn btn-primary" form="sms-form">Submit</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>

    </div>
  </div>

  ';


  echo '
  <!-- SMS list Modal -->
  <div id="sms-list-modal" class="modal fade" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lg">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">SMS Status of Message ID: <span id="message_id_txt"></span></h4>
        </div>
        <div class="modal-body">
          <table class="table table-hover sms_list_table">
            <thead>
              <tr>
                <th>Message</th>
                <th>Mobile Number</th>
                <th>Recipient</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default no-notif" data-dismiss="modal">Close</button>
        </div>
      </div>

    </div>
  </div>

  ';
}elseif ($modals_sets=="home") {
  echo '
  <!-- Email Settings -->
  <div id="email_settings-modal" class="modal fade" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lg">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Email Settings</h4>
        </div>
        <div class="modal-body">
        '.form_open("guardian_ajax/email_settings",'id="guardian_email_settings_form" class="form-horizontal"').'
        <input type="hidden" name="id" value="'.$login_user_data->id.'">

          <div class="form-group">
            <label class="col-sm-4" for="email_address">Email Address:</label>
            <div class="col-sm-8"> 
              <input type="text" class="form-control" name="email_address" value="'.$login_user_data->email_address.'" placeholder="Enter Email Address">
              <p class="help-block" id="email_settings_email_address_help-block"></p>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-4" for="email_subscription">Subscription:</label>
            <div class="col-sm-8"> 
              <div class="checkbox">
                <label><input type="checkbox" name="email_subscription" value="1" ';
                if($login_user_data->email_subscription=="1"){
                  echo "checked";
                }
                echo '> Email Subscription</label>
              </div>
              <p class="help-block"></p>
            </div>
          </div>

        </form>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" form="guardian_email_settings_form">Submit</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>

    </div>
  </div>

  ';
}elseif ($modals_sets=="jbtech") {

  echo '
  <!-- Change Password Modal -->
  <div id="reset_admin_password-modal" class="modal fade" role="dialog" tabindex="-1">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" id="change_password-modal-title">admin password reset</h4>
        </div>
        <div class="modal-body">
          <p>
          '.form_open("admin_ajax/reset_password",'id="reset_admin_password-form" class="form-horizontal"').'

          <div class="form-group">
            <label class="col-sm-4" for="username">Email Address:</label>
            <div class="col-sm-8"> 
              <select class="ui search dropdown" name="id" id="select_admin_username">
                <option value="">Select Admin Username</option>
              </select>
              <p class="help-block" id="reset_admin_username_help-block"></p>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-4" for="email_address">Email Address:</label>
            <div class="col-sm-8"> 
              <input type="text" class="form-control" name="email_address" placeholder="Enter Email Address">
              <p class="help-block" id="reset_admin_password_help-block"></p>
            </div>
          </div>


          </form>
          </p>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" form="reset_admin_password-form">Submit</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>

    </div>
  </div>

  ';


  echo '
  <!-- Change Password Modal -->
  <div id="add_admin-modal" class="modal fade" role="dialog" tabindex="-1">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" id="change_password-modal-title">add admin account</h4>
        </div>
        <div class="modal-body">
          <p>
          '.form_open("admin_ajax/add_account",'id="add_admin-form" class="form-horizontal"').'

          <div class="form-group">
            <label class="col-sm-4" for="username">Username:</label>
            <div class="col-sm-8"> 
              <input type="text" class="form-control" name="username" placeholder="Enter Email Address">
              <p class="help-block" id="add_admin_username_help-block"></p>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-4" for="email_address">Email Address:</label>
            <div class="col-sm-8"> 
              <input type="text" class="form-control" name="email_address" placeholder="Enter Email Address">
              <p class="help-block" id="add_admin_email_address_help-block"></p>
            </div>
          </div>


          </form>
          </p>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" form="add_admin-form">Submit</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>

    </div>
  </div>

  ';

  
}

// var_dump();

echo '
<!-- Change Password Modal -->
<div id="change_password-modal" class="modal fade" role="dialog" tabindex="-1">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="change_password-modal-title">Change Password</h4>
      </div>
      <div class="modal-body">
        <p>
        '.form_open("accounts/change_password",'id="change_password-form" class="form-horizontal"').'
        <input type="hidden" name="type" id="change_password_type">
        <input type="hidden" name="id" value="'.$login_user_data->id.'">

        <div class="form-group">
          <label class="col-sm-4" for="current_password">Current Password:</label>
          <div class="col-sm-8"> 
            <input type="password" class="form-control" name="current_password" placeholder="Enter Current Password">
            <p class="help-block" id="current_password_help-block"></p>
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-4" for="new_password">New Password:</label>
          <div class="col-sm-8"> 
            <input type="password" class="form-control" name="new_password" placeholder="Enter New Password">
            <p class="help-block" id="new_password_help-block"></p>
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-4" for="confirm_password">Confirm New Password:</label>
          <div class="col-sm-8"> 
            <input type="password" class="form-control" name="confirm_password" placeholder="Enter Confirm New Password">
            <p class="help-block" id="confirm_password_help-block"></p>
          </div>
        </div>


        </form>
        </p>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" form="change_password-form">Submit</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

';



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