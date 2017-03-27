$(document).on("submit","#rfid_scan_add_load_credit_form",function(e) {
	e.preventDefault();
	$.ajax({
		type: "POST",
		url: $("#rfid_scan_add_load_credit_form").attr("action"),
		data: $("#rfid_scan_add_load_credit_form :input").serialize(),
		cache: false,
		dataType: "json",
		success: function(data) {
			// alert(data.full_name);
			$("#rfid_scan_add_load_credit_form")[0].reset();
			if(data.is_valid){
				$("#rfid_scan_add_load_credits_modal").modal("hide");
				$('input[name="rfid_id"]').val(data.rfid_data.id);
				$("#add_load_credits_display-photo").attr("src",data.display_photo);
				$("#add_load_credits_full_name").html(data.full_name);
				$("#add_load_credits_remaining_load").html(data.rfid_data.load_credits);

				$("#add_load_credits_data_modal").modal("show");

				$("#rfid_scan_add_load_credits_form")[0].reset();
				$(".help-block").html("");
			}else{
				$('#rfid_scan_add_load_credits_help-block').html("RFID is not valid or available.");
			}
		}
	});
});



$(document).on("click","#rfid_add_load_credits",function(e) {
	$("#rfid_scan_add_load_credits_modal").modal("show");
});


$(document).on("submit","#add_load_credits_form",function(e) {
	e.preventDefault();
	$.ajax({
		type: "POST",
		url: $("#add_load_credits_form").attr("action"),
		data: $("#add_load_credits_form").serialize(),
		cache: false,
		dataType: "json",
		success: function(data) {
			$("#add_load_credits_form")[0].reset();
			$("#add_load_credits_data_modal").modal("hide");
			$("#alert-modal").modal("show");
			$("#alert-modal-title").html("Add Load to a Student");
			$("#alert-modal-body p").html("You have successfully added a load a student's load credits.");
		}
	});
});



$(document).on("click","#register_guardian",function(e) {
	$("#register_guardian_modal").modal("show");
});

$(document).on("submit","#register_guardian_form",function(e) {
	e.preventDefault();
	$("button[form='register_guardian_form']").prop('disabled', true);
	$.ajax({
		type: "POST",
		url: $("#register_guardian_form").attr("action"),
		data: $("#register_guardian_form").serialize(),
		cache: false,
		dataType: "json",
		success: function(data) {
			$("button[form='register_guardian_form']").prop('disabled', false);
			$("#guardian_name_help-block").html(data.guardian_name_error);
			$("#email_address_help-block").html(data.email_address_error);
			$("#contact_number_help-block").html(data.contact_number_error);
			if(data.is_valid){
				$("#register_guardian_form")[0].reset();
				$(".help-block").html("");
				$("#alert-modal").modal("show");
				$("#alert-modal-title").html("Add Guardian");
				$("#alert-modal-body p").html("You have successfully registered a guardian.");
			}
		}
	});
});


$(document).on("click",".rfid_scan_add",function(e) {
	$("#rfid_scan_add_modal").modal("show");
	$('input[name="rfid_scan_add"]').attr("autofocus","true");
	$("#rfid_add_modal_title").html("Add "+e.target.id);
	$('input[name="type"]').val(e.target.id);
});

$('#rfid_scan_add_modal').on('hidden.bs.modal', function (e) {
	$('input[name="rfid_scan_add"]').removeAttr("autofocus");
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
			// alert(data);
			if(data.is_valid){
				$(".rfid_scanned_add").val(data.rfid_scanned_add);
				// $("#rfid_scan_add_modal").modal("hide");
				// $("#students_add_modal").modal("show");
				$("#rfid_scan_add_form")[0].reset();
				$("#"+data.type+"_add_modal").modal("show");
				$(".help-block").html("");
			}else{
				$("#rfid_scan_add_form")[0].reset();
				$("#rfid_scan_help-block").html("RFID is not valid or available.");
			}
		}
	});
});

$(document).on("submit","#student_add_form", function(e) {
	e.preventDefault();
	$("button[form='student_add_form']").prop('disabled', true);
	$.ajax({
		url: $(this).attr('action'),
		data: new FormData(this),
		processData: false,
		contentType: false,
		method:"POST",
		dataType: "json",
		success: function(data){
			$("button[form='student_add_form']").prop('disabled', false);
			// alert(data);
			if(data.is_valid){
				$("#student_add_form")[0].reset();
				$(".help-block").html("");
				// $("#students_add_modal").modal("hide");

				if(data.is_successful){
					$("#students_add_modal").modal("hide");
					$("#alert-modal").modal("show");
					// $("#rfid_scan_add_modal").modal("show");
					
					$("#alert-modal-title").html("Add Student");
					$("#alert-modal-body p").html("You have successfully added a student in the list.");
				}
			}else{
				$("#student_first_name_help-block").html(data.first_name_error);
				$("#student_last_name_help-block").html(data.last_name_error);
				$("#student_middle_name_help-block").html(data.middle_name_error);
				$("#student_suffix_help-block").html(data.suffix_error);
				$("#student_bday_help-block").html(data.bday_error);
				$("#student_guardian_id_help-block").html(data.guardian_id_error);
				$("#student_class_id_help-block").html(data.class_id_error);
				$("#student_photo_help-block").html(data.photo_error);
			}
		}
	})
});



$(document).on("submit","#teacher_add_form", function(e) {
	e.preventDefault();
	$("button[form='teacher_add_form']").prop('disabled', true);
	$.ajax({
		url: $(this).attr('action'),
		data: new FormData(this),
		processData: false,
		contentType: false,
		method:"POST",
		dataType: "json",
		success: function(data){
			$("button[form='teacher_add_form']").prop('disabled', false);
			// alert(data);
			if(data.is_valid){
				$("#teacher_add_form")[0].reset();
				$(".help-block").html("");

				if(data.is_successful){
					$("#teachers_add_modal").modal("hide");
					$("#alert-modal").modal("show");
					$("#alert-modal-title").html("Add teacher");
					$("#alert-modal-body p").html("You have successfully added a teacher in the list.");
				}
			}else{
				$("#teacher_first_name_help-block").html(data.first_name_error);
				$("#teacher_last_name_help-block").html(data.last_name_error);
				$("#teacher_middle_name_help-block").html(data.middle_name_error);
				$("#teacher_suffix_help-block").html(data.suffix_error);
				$("#teacher_bday_help-block").html(data.bday_error);
				$("#teacher_guardian_id_help-block").html(data.guardian_id_error);
				$("#teacher_photo_help-block").html(data.photo_error);
			}
		}
	})
});

$(document).on("submit","#guard_add_form", function(e) {
	e.preventDefault();
	$("button[form='guard_add_form']").prop('disabled', true);
	$.ajax({
		url: $(this).attr('action'),
		data: new FormData(this),
		processData: false,
		contentType: false,
		method:"POST",
		dataType: "json",
		success: function(data){
			$("button[form='guard_add_form']").prop('disabled', false);
			// alert(data);
			if(data.is_valid){
				$("#guard_add_form")[0].reset();
				$(".help-block").html("");

				if(data.is_successful){
					$("#guards_add_modal").modal("hide");
					$("#alert-modal").modal("show");
					$("#alert-modal-title").html("Add guard");
					$("#alert-modal-body p").html("You have successfully added a guard in the list.");
				}
			}else{
				$("#guard_first_name_help-block").html(data.first_name_error);
				$("#guard_last_name_help-block").html(data.last_name_error);
				$("#guard_middle_name_help-block").html(data.middle_name_error);
				$("#guard_suffix_help-block").html(data.suffix_error);
				$("#guard_bday_help-block").html(data.bday_error);
				$("#guard_guardian_id_help-block").html(data.guardian_id_error);
				$("#guard_photo_help-block").html(data.photo_error);
			}
		}
	})
});




$(document).on("submit","#app-login",function(e) {
	e.preventDefault();
	$.ajax({
		type: "POST",
		url: $("#app-login").attr("action"),
		data: $("#app-login").serialize(),
		cache: false,
		dataType: "json",
		success: function(data) {
			if(data.is_valid){
				window.location = data.redirect;
			}else{
				$("#account_help-block").html(data.account_error);
				$("#account_password_help-block").html(data.account_password_error);
			}
			// alert(data);
		}
	});
});

$(document).on("click","#add_canteen",function(e) {
	$("#add_canteen_modal").modal("show");
});

$(document).on("submit","#add_canteen_form",function(e) {
	e.preventDefault();
	$('button[form="add_canteen_form"]').prop('disabled', true);
	$.ajax({
		type: "POST",
		url: $("#add_canteen_form").attr("action"),
		data: $("#add_canteen_form").serialize(),
		cache: false,
		dataType: "json",
		success: function(data) {
			$('button[form="add_canteen_form"]').prop('disabled', false);
			if(data.is_valid){

			}
		}
	});
});

$(document).on("click","#class_add",function(e) {
	$("#class_add_modal").modal("show");
});

$(document).on("submit","#class_add_form",function(e) {
	e.preventDefault();
	$('button[form="class_add_form"]').prop('disabled', true);
	$.ajax({
		type: "POST",
		url: $("#class_add_form").attr("action"),
		data: $("#class_add_form").serialize(),
		cache: false,
		dataType: "json",
		success: function(data) {
			// alert(data);
			if(data.is_valid){
				$("#class_add_form")[0].reset();
				$("#alert-modal").modal("show");
				$(".help-block").html("");
			}else{
				$("#class_adviser_help-block").html(data.class_adviser_error);
				$("#class_name_help-block").html(data.class_name_error);
				$("#class_room_help-block").html(data.class_room_error);
				$("#class_schedule_help-block").html(data.class_schedule_error);
			}
			$('button[form="class_add_form"]').prop('disabled', false);
		}
	});
});

$("#datepicker_from,#datepicker_to").datepicker();

