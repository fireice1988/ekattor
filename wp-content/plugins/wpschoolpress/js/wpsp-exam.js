$(document).ready(function() {
	
	updateDate();
	
	function updateDate() {		
		$('#ExStart').datepicker({

			autoclose: true,
			dateFormat: date_format, 
			todayHighlight: true,  
			changeMonth: true,
			changeYear: true,
			startDate: '-0m',
			// beforeShow: function(input, inst) {
			// 	$(document).off('focusin.bs.modal');
			// },
			// onClose:function(){
			// 	$(document).on('focusin.bs.modal');
			// },
			// onSelect: function( selectedDate ) {
			// 	$( "#ExEnd" ).datepicker( "option", "minDate", selectedDate );
			// }
		});
		
			$('#ExStart').on('change', function() {
				 $('#ExEnd').datepicker('remove');
			//console.log('a');
  $('#ExEnd').datepicker({
  		autoclose: true,
  		dateFormat: date_format,
  		todayHighlight: true,  
			changeMonth: true,
			changeYear: true, 
    startDate: $('#ExStart').val(),
    	setStartDate: $('#ExStart').val()
  })
   $('#ExEnd').datepicker('update', $('#ExStart').val());
});

			
	}
	


		$('.select_date').datepicker({autoclose: true,dateFormat: date_format, todayHighlight: true,  changeMonth: true,
			changeYear: true,
			beforeShow: function(input, inst) {
				$(document).off('focusin.bs.modal');
			},
			onClose:function(){
				$(document).on('focusin.bs.modal');
			},		
		});
		
		$('#exam_class_table').dataTable({
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
		
		$("#ExamEntryForm").validate({
			onkeyup:false,
			rules: {
				'class_name': {
					required: true,					
				},
				'ExName': {
					required: true,
					minlength: 2
				},
				
				'ExStart': {
					required:true
				},
				'ExEnd': {
					required:true
				},
			},
			messages: {
				ExamName: {
					required: "Please enter Exam Name",
					minlength: "Exam name must consist of at least 2 characters"
				},
				class_name:{
					required: "Please select class name",
				}
			},
			submitHandler: function(form){
				var data=$('#ExamEntryForm').serializeArray();
				data.push({name: 'action', value: 'AddExam'});
				$.ajax({
						type: "POST",
						url: ajax_url,
						data: data,
						
						success: function(rdata) {
									if(rdata=='success')
									{
										$(".wpsp-popup-return-data").html('Exam Created Successfully !');
										$("#SuccessModal").css("display", "block");
										$("#SavingModal").css("display", "none");
										$("#SuccessModal").addClass("wpsp-popVisible");
										//$.fn.notify('success', {'desc': 'Exam Created Successfully!', autoHide: true, clickToHide: true});
										var  wpsp_pageURL= $('#wpsp_locationginal').val();
										var delay = 1000;
										var url =  wpsp_pageURL+"/admin.php?page=sch-exams";
										var timeoutID = setTimeout(function() {
										window.location.href = url;
										}, delay);
										//$('.formresponse').html("<div class='alert alert-success'>Exam Created Successfully!</div>");
										$('#ExamEntryForm').trigger("reset");
										$('#e_submit').attr('disabled','disabled');
									}
									else
									{
										$(".wpsp-popup-return-data").html(rdata);
										$("#SavingModal").css("display", "none");
										$("#WarningModal").css("display", "block");
										$("#WarningModal").addClass("wpsp-popVisible");
										//$.fn.notify('error', {'desc': rdata, autoHide: true, clickToHide: true });
										//$('.formresponse').html("<div class='alert alert-danger'>"+rdata+"</div>");
									}
						}
				});
			}
		});
		
		
		/*Edit Save */
		$("#ExamEditForm").validate({
			onkeyup:false,
			rules: {
				'class_name': {
					required: true,					
				},
				'ExamID': {
					required: true,
					number:true
				},
				'ExName': {
					required: true,
					minlength: 2
				},
				
				'ExStart': {
					required:true
				},
				'ExEnd': {
					required:true
				},
			
			},
			messages: {
				SName: {
					required: "Please enter Subject Name",
					minlength: "Subject must consist of at least 2 characters"
				},
				class_name:{
					required: "Please select class name",
				}
			},
			submitHandler: function(form){
				var data=$('#ExamEditForm').serializeArray();
				data.push({name: 'action', value: 'UpdateExam'});
				$.ajax({
						type: "POST",
						url: ajax_url,
						data: data,
						success: function(rdata) {
							if(rdata=='updated')								
							{
								$(".wpsp-popup-return-data").html('Exam information updated Successfully !');
								$("#SuccessModal").css("display", "block");
								$("#SavingModal").css("display", "none");
								$("#SuccessModal").addClass("wpsp-popVisible");
								//$.fn.notify('success', {'desc': 'Exam information updated Successfully!', autoHide: true, clickToHide: true});
								var  wpsp_pageURL= $('#wpsp_locationginal').val();
								var delay = 1000;
								var url =  wpsp_pageURL+"/admin.php?page=sch-exams";
								var timeoutID = setTimeout(function() {
								window.location.href = url;
								}, delay);
								//$('.formresponse').html("<div class='alert alert-success'>Exam information updated Successfully!</div>");
								$('#e_submit').attr('disabled','disabled');
							}
							else
							{
								$(".wpsp-popup-return-data").html(rdata);
								$("#SavingModal").css("display", "none");
								$("#WarningModal").css("display", "block");
								$("#WarningModal").addClass("wpsp-popVisible");
								//$.fn.notify('error', {'desc': rdata, autoHide: true, clickToHide: true });
								//$('.formresponse').html("<div class='alert alert-danger'>"+rdata+"</div>");
							}
						}
				});
			}
		
		});
		$(document).on('click','#d_teacher',function(e) { 	
			var eid = $(this).data('id');
			console.log(eid);
			$("#teacherid").val(eid);
			$("#DeleteModal").css("display", "block");
		});
		/* Exam Delete */		
		$(document).on('click','.ClassDeleteBt',function(e) {		
			//var eid=$(this).attr('eid');
var eid = $('#teacherid').val();			
			//$( "#overlay" ).addClass( "overlays" );	
			
				var data=[];
				data.push({name: 'action', value: 'DeleteExam'},{name: 'eid', value: eid});				
				jQuery.post(ajax_url, data, function(cddata) {					
					if(cddata=='deleted') {	
					
						//$('#InfoModalBody').html("<div class='col-md-8 text-green'>Exam deleted successfully!</div>");					
						location.reload();
												
					} else {
						//$('#InfoModalBody').html("<div class='col-md-8 text-red'>"+cddata+"</div>");
						$(".wpsp-popup-return-data").html('Operation failed.Something went wrong!');
					$("#SavingModal").css("display", "none");
					$("#WarningModal").css("display", "block");
					$("#WarningModal").addClass("wpsp-popVisible");
					}
				});
			
		});
	
		
		$(document).on('change','#class_name,#edit_class_name',function(e){	
		
			var data = [];
			$('.action-button').attr('disabled','disabled');			
			data.push({name: 'action', value: 'subjectList'});
			data.push({name: 'ClassID', value: $(this).val()});
			jQuery.post(ajax_url, data, function(subject_list) {			
				var subject_json = $.parseJSON(subject_list);
				var html='';
				$.each(subject_json.subject,function(field,value) {
					html += '<input type="checkbox" name="subjectid[]" value="'+value.id+'" class="exam-subjects wpsp-checkbox" id="subject-'+value.id+'"><label for="subject-'+value.id+'" class="wpsp-checkbox-label">'+value.sub_name+'</label>';
				});
				$('.exam-class-list').html(html);
				$('.action-button').removeAttr('disabled');
				$('.exam-all-subjects').attr('checked', false);
			});
		});		
		
		$(document).on('click','.exam-all-subjects',function(){
			if($(this).prop("checked")==true){
				$(".exam-subjects").prop('checked',true);
			}else{
				$(".exam-subjects").prop("checked",false);
			}
		});
		
		$(document).on('click','.exam-subjects',function() {
			if($(this).prop("checked")==false){
				$(".exam-all-subjects").prop('checked',false);
			}
		});
	});