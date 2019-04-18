$(document).ready(function(){	
		var table	=	$('#teacher_table').dataTable({
			language: {
			    paginate: {
			      next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>', 
			      previous: '<i class="fa fa-angle-double-left" aria-hidden="true"></i>'
			    },
			    search: "",
			    searchPlaceholder: "Search..."

			  },
			"dom": '<"wpsp-dataTable-top"f>rt<"wpsp-dataTable-bottom"<"wpsp-length-info"li>p<"clear">>',
			"order": [],
			"columnDefs": [ {
			  "targets"  : 'nosort',
			  "orderable": false, 			  
            }],
            drawCallback: function(settings) {
			   var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
			   pagination.toggle(this.api().page.info().pages > 1);
			},
			responsive: true			
		});
		
		$("#wpsp_leave_days").on("click", ".wpsp-popclick", function(){
		    var linkAttrib = $(this).attr('data-pop');			
			$('#' + linkAttrib).addClass("wpsp-popVisible");
			$('body').addClass('wpsp-bodyFixed')
		});
	        
		$('.dropdown-menu').click(function(e) {
			e.stopPropagation();
		});
		
		$("#Dob").datepicker({
			autoclose: true,
			dateFormat: date_format,
			todayHighlight: true,
			changeMonth: true,
			changeYear: true,
			maxDate: 0,
			yearRange: "-50:+0",
		});
		
		$( "#Doj" ).datepicker({
			autoclose: true,
			dateFormat: date_format,
			todayHighlight: true,
    		changeMonth: true,
            changeYear: true,
			maxDate: 0,
			beforeShow: function(input, inst) {
				$(document).off('focusin.bs.modal');
			},
			onClose:function(){
				$(document).on('focusin.bs.modal');
			},
			onSelect: function( selectedDate ) {
				$( ".Dol" ).datepicker( "option", "minDate", selectedDate );
			}
  		});
		
		$( "#Dol" ).datepicker({
			autoclose: true,
			dateFormat: date_format, 
			todayHighlight: true,  
			changeMonth: true,
			changeYear: true,
			beforeShow: function(input, inst) {
				$(document).off('focusin.bs.modal');
			},
			onClose:function(){
				$(document).on('focusin.bs.modal');
			},
			onSelect: function( selectedDate ) {
				$( ".Doj" ).datepicker( "option", "maxDate", selectedDate );
			}
  		});
		
		$('#ClassID').change(function () {
			$('#TeacherClass').submit();
		});
	
		$("#displaypicture").change(function(){	
			var id = $(this).attr('id'); 
			
			var fsize = document.getElementById(id).files[0].size;
			var fileName = $(this).val();
			var maxsize = 3 * 1024 * 1024; 			
			if( fsize > maxsize ) {
				$('#test').html( 'File Size should be less than 3 MB, Please select another file');
				$(this).val('');
			}	
			var fileExtension = fileName.substring(fileName.lastIndexOf('.') + 1);
			if($.inArray(fileExtension, ['jpg','jpeg']) == -1) { 
				$('#test').html( 'Please select either jpg or jpeg file');
				$(this).val('');				
			}
			imagePreview(this); // Use Image Preview
		});
		
		/* Image Preview Function */
		function imagePreview(input) { 
			if (input.files) {
				var reader = new FileReader(); 
					reader.onload = function (e) {
					$('#img_preview_teacher')
						.attr('src', e.target.result)
						.width(112)
						.height(112);
					}	
					reader.readAsDataURL(input.files[0]);	
			}
			
		}
		
	$("#TeacherEditForm").validate({
		rules: {
				firstname: "required",Address: "required",lastname: "required",
				Username: {
					required: true,
					minlength: 5
				},
				Password: {
					required: true,
					minlength: 4
				},
				ConfirmPassword: {
					required: true,
					minlength: 4,
					equalTo: "#Password"
				},
				Email: {
					required: true,
					email: true
				},
				Phone: {					
					number:true,	
					minlength: 7
				},
				zipcode:{required: true,number:true},
				whours: "required"
			},
			messages: {
				firstname: "Please Enter Teacher Name",Address: "Please Enter current Address",lastname: "Please Enter Last Name",
				Username: {
					required: "Please enter a username",
					minlength: "Username must consist of at least 5 characters"
				},
				Password: {
					required: "Please provide a password",
					minlength: "Password must be at least 5 characters long"
				},
				Confirm_password: {
					required: "Please provide a password",
					minlength: "Password must be at least 5 characters long",
					equalTo: "Please enter the same password as above"
				},
				Email: "Please enter a valid email address",
			},
        submitHandler: function (form) {
			    var myform = document.getElementById("TeacherEditForm");	
				var data = new FormData();
				var fdata = $('#TeacherEditForm').serializeArray();
				var ufile = $('#displaypicture')[0].files[0];
				data.append('action', 'UpdateTeacher');
				data.append('displaypicture', ufile);
				$.each(fdata, function (key, input) {
					data.append(input.name, input.value);
				});
				data.append('data',fdata);
				$.ajax({
						type: "POST",
						url: ajax_url,
						data: data,
						cache: false,
						processData: false, 
						contentType: false,
						beforeSend:function () {
							$('#u_teacher').attr('disabled','disabled');
							$("#SavingModal").css("display", "block");	
						},
						success: function(rdata) { 
							if(rdata=='success0')
							{	
								$(".wpsp-popup-return-data").html('Teacher Updated successfully !');
								$("#SuccessModal").css("display", "block");
								$("#SavingModal").css("display", "none");
								$("#SuccessModal").addClass("wpsp-popVisible");
								var  wpsp_pageURL= $('#wpsp_locationginal').val();
								var delay = 1000;
								var url =  wpsp_pageURL+"/admin.php?page=sch-teacher";
								var timeoutID = setTimeout(function() {
								window.location.href = url;
								}, delay);	
								$('#TeacherEditForm').trigger("reset");	
								$('#u_teacher').attr('disabled','disabled');	
							}
							else
							{
								$(".wpsp-popup-return-data").html(rdata);
								$("#SavingModal").css("display", "none");
								$("#WarningModal").css("display", "block");
								$("#WarningModal").addClass("wpsp-popVisible");
							}
						},
						error:function () {
								$("#SavingModal").css("display", "none");
								$("#WarningModal").css("display", "block");
								$("#WarningModal").addClass("wpsp-popVisible");
						},
						complete:function(){
							$('.pnloader').remove();	
						}
				});
				
				
		}        
    });
	$("#TeacherEntryForm").validate({
			rules: {
				firstname: "required",Address: "required",lastname: "required",
				Username: {
					required: true,
					minlength: 5
				},
				Password: {
					required: true,
					minlength: 4
				},
				ConfirmPassword: {
					required: true,
					minlength: 4,
					equalTo: "#Password"
				},
				// displaypicture: {
				// 	required: true,
				// }, 
				Email: {
					required: true,
					email: true
				},
				Phone: {					
					number:true,	
					minlength: 7
				},
				zipcode:{required: true,number:true},
				whours: "required"
			},
			messages: {
				firstname: "Please Enter Teacher Name",Address: "Please Enter current Address",lastname: "Please Enter Last Name",
				Username: {
					required: "Please enter a username",
					minlength: "Username must consist of at least 5 characters"
				},
				Password: {
					required: "Please provide a password",
					minlength: "Password must be at least 5 characters long"
				},
				// displaypicture: {
				// 	required: "Please Upload Profile Image",
				// },
				Confirm_password: {
					required: "Please provide a password",
					minlength: "Password must be at least 5 characters long",
					equalTo: "Please enter the same password as above"
				},
				Email: "Please enter a valid email address",
			},
			submitHandler: function(form){
				var data = new FormData();
				var fdata=$('#TeacherEntryForm').serializeArray();
				var ufile = $('#displaypicture')[0].files[0];
				data.append('displaypicture', ufile);
				data.append('action', 'AddTeacher');
				
				$.each(fdata,function(key,input){
						data.append(input.name,input.value);
				});
				data.append('data',fdata);
				$.ajax({
						type: "POST",
						url: ajax_url,
						data: data,
						cache: false,
						processData: false, 
						contentType: false,
						beforeSend:function () {
							$("#SavingModal").css("display", "block");
							$('#teacherform').attr("disabled", 'disabled');							
						},
						success: function(rdata) {
							$('#teacherform').removeAttr('disabled');
							if(rdata=='success')
							{
								$(".wpsp-popup-return-data").html('Teacher added successfully !');
								$("#SuccessModal").css("display", "block");
								$("#SavingModal").css("display", "none");
								$("#SuccessModal").addClass("wpsp-popVisible");
								var  wpsp_pageURL= $('#wpsp_locationginal').val();
								var delay = 1000;
								var url =  wpsp_pageURL+"/admin.php?page=sch-teacher";
								var timeoutID = setTimeout(function() {
								window.location.href = url;
								}, delay);	
							}
							else
							{
								$(".wpsp-popup-return-data").html(rdata);
								$("#SavingModal").css("display", "none");
								$("#WarningModal").css("display", "block");
								$("#WarningModal").addClass("wpsp-popVisible");
							}
						},
						error:function () {
							$("#SavingModal").css("display", "none");
							$("#WarningModal").css("display", "block");
							$("#WarningModal").addClass("wpsp-popVisible");
							$('#teacherform').removeAttr('disabled');
						},
						complete:function(){
							$('.pnloader').remove();
							$('#teacherform').removeAttr('disabled');
						} 
				});
			}		
		});
		
		$(document).on('click','.ViewTeacher',function(e) {	
			e.preventDefault();
			var data=[];
			var tid=$(this).data('id');
			data.push(
						{name: 'action', value: 'TeacherPublicProfile'},
						{name: 'id', value: tid}
					 );
			jQuery.post(ajax_url, data, function(pdata) {
				$('#ViewModalContent').html(pdata);	
				$(this).click();
			});
		});
		
		$('#AddTeacher').on('click',function(e){
			e.preventDefault();
			$('#AddModal').modal('show');
		});
		
		$('#TeacherEntryForm').submit(function(e){
			e.preventDefault();
		});
		
		$('#TeacherImportForm').submit(function(e){
			e.preventDefault();
		});	
		
		$("#selectall").click(function(){
			if($(this).prop("checked")==true){
				$(".tcrowselect").prop('checked',true);
			}else{
				$(".tcrowselect").prop("checked",false);
			}
		});
		
		$(".tcrowselect").click(function () {
		   if ($(this).prop("checked") != true) {
			   $("#selectall").prop("checked", false);
		   }
		});

		$(document).on('click','#d_teacher',function(e) { 	
			var tid = $(this).data('id');
			$("#teacherid").val(tid);
			$("#DeleteModal").css("display", "block");
		});
		
		$(document).on('click','.ClassDeleteBt',function(e) { 
			var tid = $('#teacherid').val();
			var data = [];				
			data.push({
				name: 'action',
				value: 'DeleteTeacher'
			}, {
				name: 'tid',
				value: tid
			});
			jQuery.post(ajax_url, data, function(cddata) {
				 if (cddata == 'success') {
				  location.reload();
				 } else {
					$(".wpsp-popup-return-data").html('Operation failed.Something went wrong!');
					$("#SavingModal").css("display", "none");
					$("#WarningModal").css("display", "block");
					$("#WarningModal").addClass("wpsp-popVisible");
				 }
			});	 
	    });
	
		$('#bulkaction').change(function(){
			var op=$(this).val();
			if(op=='bulkUsersDelete'){
				var uids = $('input[name^="UID"]').map(function() {
						if($(this).prop('checked')==true)
						return this.value;
				}).get();
				if(uids.length==0){
					$(".wpsp-popup-return-data").html('No user selected!');
					$("#SavingModal").css("display", "none");
					$("#WarningModal").css("display", "block");
					$("#WarningModal").addClass("wpsp-popVisible");
					return false;	
				} else {	
					$("#DeleteModal").css("display", "block");	
					$(document).on('click','.ClassDeleteBt',function(e) { 
					var data=new Array();
						data.push({name:'action',value:'bulkDelete'});
						data.push({name:'UID',value:uids});
						data.push({name:'type',value:'teacher'});
						jQuery.post(ajax_url, data, function(cddata) {
							 if (cddata == 'success') {
								location.reload();	
							 } else {
								$(".wpsp-popup-return-data").html('Operation failed.Something went wrong!');
								$("#SavingModal").css("display", "none");
								$("#WarningModal").css("display", "block");
								$("#WarningModal").addClass("wpsp-popVisible");
							 }	 
						});	 
					});
				}
			}
		});
		
		$("#selectall").click(function(){
			if($(this).prop("checked")==true){
				$(".tcrowselect").prop('checked',true);
			}else{
				$(".tcrowselect").prop("checked",false);
			}
		});	
});