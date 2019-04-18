	$(document).ready(function(){
		$('#wp-end-time').timepicker({
			 showInputs: false,
			 showMeridian:false
		});
		$('#timepicker1').timepicker({
			showInputs: false,
			showMeridian:false
		});
		
			
		//$("#SettingsInfoForm,#SettingsSocialForm,#SettingsMgmtForm,#SettingsGradeForm,#paytm_setting_form,#sms_settings_form, #payment_settings_form").submit(function(e) {			
			//$("#SettingsInfoForm,#SettingsSocialForm").submit(function(e) {			
				$("#SettingsSocialForm").submit(function(e) {
				e.preventDefault();
			$('.pnloader').remove();
			
			var data 	=	new FormData();
			var fdata	=	$('#SettingsSocialForm').serializeArray();
			
			data.append('action', 'GenSettingsocial');
			
			$.each(fdata,function(key,input){
				data.append(input.name,input.value);
			});
			data.append('data',fdata);
			console.log(fdata);
			jQuery.ajax({
				type:"POST",
				url:ajax_url,
				data:data,
				cache: false,
				processData: false,
				contentType: false,	
				//beforeSend:function() {
				//	$.fn.notify('loader',{'desc':'Saving settings..'});					
				//},
				success:function(ires) {
					if(ires=='success'){
						//console.log('aa');
						var pntype='success';
						var pntext="Information Saved Successfully";
						window.location.reload();
					} else {
						var pntype='error';
						var pntext= ires=='' ? "Something went wrong" : ires;
					}
					$.fn.notify(pntype,{'desc':pntext});
				},
				complete:function(){
					$('.pnloader').remove();
				}
			});

			});	
		$("#SettingsInfoForm").submit(function(e) {			
			
			e.preventDefault();
			$( "#overlay" ).addClass( "overlays" );
			$('.pnloader').remove();
			var formval = document.getElementById("displaypicture");
			var data 	=	new FormData();
			var fdata	=	$('#SettingsInfoForm').serializeArray();
			var file1	=	$('#displaypicture')[0].files[0];
			
			data.append('action', 'GenSetting');
			data.append('displaypicture',file1);

			$.each(fdata,function(key,input){
				data.append(input.name,input.value);
			});
			
			data.append('data',fdata);
		
			jQuery.ajax({
				type:"POST",
				url:ajax_url,
				data:data,
				cache: false,
				processData: false,
				contentType: false,	
				beforeSend:function() {
				//	$.fn.notify('loader',{'desc':'Saving settings..'});
					//$( "#overlay" ).addClass( "overlays" );	
					//$('#setting_submit').attr('disabled',true);	
						$('#u_teacher').attr('disabled','disabled');
							$("#SavingModal").css("display", "block");	
				
				},
				success:function(ires) {
					$('#setting_submit').attr('disabled',false);	
					if(ires=='success'){
						$(".wpsp-popup-return-data").html('Information Saved Successfully');
								$("#SuccessModal").css("display", "block");
								$("#SavingModal").css("display", "none");
								$("#SuccessModal").addClass("wpsp-popVisible");

						// var pntype='success';
						// var pntext="Information Saved Successfully";
						window.location.reload();
					} else {
						$(".wpsp-popup-return-data").html('Something went wrong');
								$("#SavingModal").css("display", "none");
								$("#WarningModal").css("display", "block");
								$("#WarningModal").addClass("wpsp-popVisible");
						//var pntype='error';
					//	var pntext= ires=='' ? "Something went wrong" : ires;
					}
					//$.fn.notify(pntype,{'desc':pntext});
					//$.fn.notify(pntype, {'desc': pntext, autoHide: true, clickToHide: true });
					
				},
				complete:function(){
					$('.pnloader').remove();
					$("#overlay").removeClass("overlays");    
				}
			});
		});
		$("#sms_settings_form").submit(function(e) {	
		
			//alert();
			e.preventDefault();
			$('.pnloader').remove();
			
			var data 	=	new FormData();
			var fdata	=	$('#sms_settings_form').serializeArray();
			
			data.append('action', 'GenSettingsms');
			
			$.each(fdata,function(key,input){
				data.append(input.name,input.value);
			});
			data.append('data',fdata);
			console.log(fdata);
			jQuery.ajax({
				type:"POST",
				url:ajax_url,
				data:data,
				cache: false,
				processData: false,
				contentType: false,	
				beforeSend:function() {
					$.fn.notify('loader',{'desc':'Saving settings..'});					
				},
				success:function(ires) {
					if(ires=='success'){
						console.log('aa');
						var pntype='success';
						var pntext="Information Saved Successfully";
					} else {
						var pntype='error';
						var pntext= ires=='' ? "Something went wrong" : ires;
					}
					$.fn.notify(pntype,{'desc':pntext});
				},
				complete:function(){
					$('.pnloader').remove();
				}
			});
		});
		
		$('#AddGradeForm').validate({
			//e.preventDefault();
			rules: {
				grade_name: { required: true },
				grade_point:{ required: true },
				mark_from: { required: true },
				mark_upto: { required: true },
			},
			messages: {
				grade_name: "Please Enter Grade Name",
				grade_point: "Please Enter Grade Point",
				mark_from : "Please Enter Mark From",
				mark_upto: "Please Enter Mark Upto",
			},
			submitHandler: function(form) {				
				var fdata	=	$('#AddGradeForm').serializeArray();				
				fdata.push({name: 'action', value: 'manageGrade'});				
				jQuery.ajax({
					method:"POST",
					url:ajax_url, 
					data:fdata,
					beforeSend:function(){
						$.fn.notify('loader',{'desc':'Saving grade..'});
						$('#grade_save').attr("disabled", 'disabled');	
					},
					success:function(ires) {
						$('#grade_save').removeAttr('disabled');
						$('#AddGradeForm').trigger("reset");
						if(ires=='success'){
							var pntype='success';
							var pntext="Grade Saved Successfully";
						}
						else{
							var pntype='error';
							var pntext="Something went wrong";
						}
						$.fn.notify(pntype, {'desc': pntext, autoHide: true, clickToHide: true });
						//$.fn.notify(pntype,{'desc':pntext});
					},
					complete:function(){
						$('#grade_save').removeAttr('disabled');
						$('.pnloader').remove();
						$('#AddGradeForm').trigger("reset");
					}
				});
			}
		});

		
			

		
        $('#displaypicture').change(function(){
        	
        	var reader = new FileReader();
        	reader.onload = function (e) {
    			// get loaded data and render thumbnail.
        		$("#image").attr({src:e.target.result,width:150,height:150});
        		$('.sch-remove-logo').show();
        		$('.sch-logo-container').show();
    		};
    		reader.readAsDataURL(this.files[0]);  
        
    });
  
		$('.sch-remove-logo').click( function(e){
			$('#sch_logo_control').val('');
			//$("#image").val('');
			$('.sch-logo-container').hide();
			$('.sch-remove-logo').hide();
			$('.logo-label').html( 'Upload Logo');
		});
		
		$('#wpsp_grade_list, #wpsp_sub_division_table,#wpsp_class_hours').dataTable({
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
	
		$('.DeleteGrade').click(function(){
			var gid=$(this).attr('data-id');
			var gdata=new Array();
			gdata.push({name: 'action', value: 'manageGrade'},{name: 'grade_id', value: gid},{name: 'actype', value: 'delete'});
			jQuery.ajax({
				method:"POST",
				url:ajax_url, 
				data:gdata, 
				success:function(gres) {
					if(gres=='success'){
						$.fn.notify('success', {'desc': 'Grade deleted succesfully!', autoHide: true, clickToHide: true });
						window.location.reload();
					}else
					$.fn.notify('error', {'desc':gres, autoHide: true, clickToHide: true });	
						},
				error:function(){
					$.fn.notify('error', {'desc':'Something went wrong', autoHide: true, clickToHide: true });	
									},
				beforeSend:function(){
					$.fn.notify('loader',{'desc':'Deleting grade..'});
				},
				
				complete:function(){
					$('.pnloader').remove();
				}
			});			
		});
		
		$('#SubFieldsClass').change(function(){
			$('#SubFieldSubject option:gt(0)').remove();
			var sfdata=new Array();
			var cid=$(this).val();
			sfdata.push({name: 'action', value: 'subjectList'},{name: 'ClassID', value: cid});
			jQuery.ajax({
				method:"POST",
				url:ajax_url, 
				data:sfdata, 
				success:function(sfres) {
					var newOptions=$.parseJSON(sfres);
					var $el = $("#SubFieldSubject");					$.each( newOptions.subject,function(field,value) {	
						$el.append($("<option></option>").attr("value", value.id).text(value.sub_name)); 
					});
				},
				error:function(){
					$.fn.notify('error', {'desc':'Something went wrong', autoHide: true, clickToHide: true });	
					},
				beforeSend:function(){
					$.fn.notify('loader',{'desc':'Loading Subjects'});
				},
				complete:function(){
					PNotify.removeAll();
				}
			});
		});
		$('input[type=radio][name=sch_sms_provider]').change(function() {
			var value = this.value;
			$( '.sms_setting_div' ).hide();
			$( '#sms_main_'+value ).show();
		});
		  $("#SubFieldsForm").validate({
        rules: {
            ClassID: {
                required: true,
               
            },
            SubjectID: {
                 required: true,
            },
            FieldName: {
                required: true
               
            }
          },

        messages: {

            ClassID: "Please Select class name",
            SubjectID: "Please Select Subject Name",
            FieldName: "Please enter Field Name"
        },
        /*});*/
		/*$('#SubFieldsForm').submit(function(e){*/
			  submitHandler: function(form) {
			//e.preventDefault();
			 var sfdata = $('#SubFieldsForm').serializeArray();
			//var sfdata=$(this).serializeArray();
			sfdata.push({name: 'action', value: 'addSubField'});
			jQuery.ajax({
				method:"POST",
				url:ajax_url, 
				data:sfdata, 
				success:function(sfres) {
					if(sfres=='success'){
						$('#SubFieldsForm')[0].reset();
						$.fn.notify('success', {'desc': 'Fields added succesfully!', autoHide: true, clickToHide: true });
						
						 $('#AddFieldsModal').html('');
                    $('#AddFieldsModal').modal('hide');
					var delay = 1000;
						 setTimeout(function() {
						location.reload(true);
						}, delay);
						$('#SubFieldsForm .btn-primary').attr('disabled','disabled');
					}else
						$.fn.notify('error', {'desc': sfres, autoHide: true, clickToHide: true });				
						$('#SubFieldsForm .btn-primary').attr('disabled',false);
				},
				error:function(){
					//$.fn.notify('error',{'desc':'Something went wrong'});
					$.fn.notify('error', {'desc': 'Something went wrong', autoHide: true, clickToHide: true });
				},
				beforeSend:function(){
					$.fn.notify('loader',{'desc':'Saving Fields'});
					//$('#SubFieldsForm .btn-primary').attr('disabled','disabled');
				},
				complete:function(){
					$('.pnloader').remove();
				}
			});
		   }
		});
		
		//Subject Fields Update Function
		
		$('.SFUpdate').click(function(){
			var sfid=$(this).attr('data-id');
			var field=$("#"+sfid+"SF").val();
			var sfdata=new Array();
			sfdata.push({name: 'action', value: 'updateSubField'},{name: 'sfid', value: sfid},{name: 'field', value: field});
			jQuery.ajax({
				method:"POST",
				url:ajax_url, 
				data:sfdata, 
				success:function(sfres) {
					if(sfres=='success'){
						$.fn.notify('success', {'desc': 'Field updated succesfully!', autoHide: true, clickToHide: true });
						
						var  wpsp_pageURL= $('#wpsp_locationginal').val();
										var delay = 1000;
										var url =  wpsp_pageURL+"/admin.php?page=sch-settings&sc=subField";
										var timeoutID = setTimeout(function() {
										window.location.href = url;
										}, delay);
					}else
					{
						//$.fn.notify('error', {'desc': sfres, autoHide: true, clickToHide: true });				
							$(".wpsp-popup-return-data").html('Something went wrong!');
					$("#SavingModal").css("display", "none");
					$("#WarningModal").css("display", "block");
					$("#WarningModal").addClass("wpsp-popVisible");
					}
				},
				error:function(){
				//	$.fn.notify('error', {'desc': 'Something went wrong', autoHide: true, clickToHide: true });
					$(".wpsp-popup-return-data").html('Something went wrong!');
					$("#SavingModal").css("display", "none");
					$("#WarningModal").css("display", "block");
					$("#WarningModal").addClass("wpsp-popVisible");
					//$.fn.notify('error',{'desc':'Something went wrong'});
				},
				
				complete:function(){
					$('.pnloader').remove();
				}
			});
		});
		$(document).on('click','#d_teacher',function(e) { 	
			var sfid = $(this).data('id');
			$("#teacherid").val(sfid);
			$("#DeleteModal").css("display", "block");
		});
		//Sub Field delete function
		$(document).on('click','.ClassDeleteBt',function(e) { 
			
			var sfid = $('#teacherid').val();
			
			  
					var sfdata=new Array();
					sfdata.push({name: 'action', value: 'deleteSubField'},{name: 'sfid', value: sfid});
					jQuery.ajax({
						method:"POST",
						url:ajax_url, 
						data:sfdata, 
						success:function(sfres) {
							if(sfres=='success'){
								//$.fn.notify('success', {'desc': 'Field deleted succesfully!', autoHide: true, clickToHide: true });
								//window.location.reload();
								(".wpsp-popup-return-data").html('Update successfully!');
								$("#SuccessModal").css("display", "block");
								$("#SavingModal").css("display", "none");
								$("#SuccessModal").addClass("wpsp-popVisible");
								var  wpsp_pageURL= $('#wpsp_locationginal').val();
										var delay = 1000;
										var url =  wpsp_pageURL+"/admin.php?page=sch-settings&sc=subField";
										var timeoutID = setTimeout(function() {
										window.location.href = url;
										}, delay);
							}else
								$(".wpsp-popup-return-data").html('Operation failed.Something went wrong!');
					$("#SavingModal").css("display", "none");
					$("#WarningModal").css("display", "block");
					$("#WarningModal").addClass("wpsp-popVisible");
														},
						error:function(){
							//$.fn.notify('error', {'desc': 'Something went wrong', autoHide: true, clickToHide: true });
							$(".wpsp-popup-return-data").html('Operation failed.Something went wrong!');
					$("#SavingModal").css("display", "none");
					$("#WarningModal").css("display", "block");
					$("#WarningModal").addClass("wpsp-popVisible");
						}
						
						
					});
               
		});
		/* This function is used for Student/Parent Profile Picture Show Preview */
	$("#displaypicture").change(function(){	
			var id = $(this).attr('id'); 
			imagePreview(this); // Use Image Preview
			$('.validation-error-'+id).html('');
			var fsize = document.getElementById(id).files[0].size;
			var fileName = $(this).val();
			var maxsize = 3 * 1024 * 1024; 			
			if( fsize > maxsize ) {
				$('.validation-error-'+id).html( 'File Size should be less than 3 MB, Please select another file');
				$(this).val('');
			}	
			var fileExtension = fileName.substring(fileName.lastIndexOf('.') + 1);
			if($.inArray(fileExtension, ['jpg','jpeg']) == -1) { 
				$('.validation-error-'+id).html( 'Please select either jpg or jpeg file');
				$(this).val('');				
			}
	});


/* This function is used for Student/Parent Profile Picture Show Preview */
	function imagePreview(input) {
        if (input.files) {
			var reader = new FileReader();
			if(input.id == 'displaypicture'){ 
				reader.onload = function (e) {
					$('#img_preview')
						.attr('src', e.target.result)
						.width(112)
						.height(112);
				}		
			}
			if(input.id == 'p_displaypicture'){
				reader.onload = function (e) {
					$('#img_preview1')
						.attr('src', e.target.result)
						.width(112)
						.height(112);
				}			
			}
			reader.readAsDataURL(input.files[0]);				
        }	
    }	
		/* Custom Tab Js */
		$('#verticalTab').easyResponsiveTabs({
	type: 'vertical',
	width: 'auto',
	fit: true
	});
		if($(window).width() < 991){		//alert('test');

		$('#verticalTab').find('.wpsp-resp-tab-active').removeClass('wpsp-resp-tab-active');
		$('#verticalTab').find('.wpsp-resp-tab-content-active').removeClass('wpsp-resp-tab-content-active').css("display", "");  
		}

		if(jQuery(window).width() < 991){ 
			//alert('test'); 
			if( !$('#verticalTab').find('.wpsp-resp-tab-active').length){ 
				//alert('test');
				$('.wpsp-resp-tabs-list .wpsp-resp-tab-item:first-child').click(); 
			}
		}  
	});
		
	jQuery(window).resize(function() {
  if(jQuery(window).width() > 991){ 
	//alert('test'); 
	if( !$('#verticalTab').find('.wpsp-resp-tab-active').length){ 
		//alert('test');
		$('.wpsp-resp-tabs-list .wpsp-resp-tab-item:first-child').click(); 
	}
}  
}); 
