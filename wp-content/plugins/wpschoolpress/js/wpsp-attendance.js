$(document).ready(function(){
	$( '.clserror' ).hide();
	$( '.clsdate' ).hide();
	
	$(document).on('click','.checkAll',function(e){
	  if($(this).prop("checked")){
		$('input[name=absent\\[\\]]').prop('checked', false);
	  }
	});
	
	$(document).on('click','input[name=absent\\[\\]]',function(e){
	  if($(this).prop("checked")){
		$('.checkAll').prop('checked', false);
	  }
	});
	$('.select_date').datepicker({
		autoclose: true,
		dateFormat: date_format,
		todayHighlight: true,
		changeMonth: true,
		changeYear: true,
		maxDate: 0
	});

	/*Retrive Student List */
	$('#AttendanceEnter').click(function() {
	
		$( '#AttendanceClass' ).parent().parent().find('.clserror').removeClass( 'error' );
		$( '#AttendanceDate' ).parent().parent().find('.clsdate').removeClass( 'error' );
		
		$('#AddModalContent').html('');
		$( '#wpsp-error-msg' ).html('');		
		var cid		=	$('#AttendanceClass').val();
		var date	=	$('#AttendanceDate').val();
		if( cid=='' )
		{
		//	console.log('aaaa');
		$('.clserror').show();
		$( '#AttendanceClass' ).parent().parent().find('.clserror').addClass( 'error' );
	}
		if( date=='' )
		{
			$('.clsdate').show();
			$( '#AttendanceDate' ).parent().parent().find('.clsdate').addClass( 'error' );
		}
		if(cid!='' && date!=''){
			var data=[];
			data.push({name: 'action', value: 'getStudentsList'},{name: 'classid', value: cid},{name:'date',value:date});
			$.ajax({
				type: "POST",
				url: ajax_url,
				data: data,
                beforeSend:function () {
                		//$("#SavingModal").css("display", "block");
                    //$.fn.notify('loader',{'desc':'Loading student list..'});
					$('#AttendanceEnter').attr("disabled", 'disabled');
                },
				success: function( response ) {
					$('#AttendanceEnter').removeAttr('disabled');
					var response_data = jQuery.parseJSON(response);				
					if( response_data.status == 0 ) {

						$( '#wpsp-error-msg' ).html(response_data.msg);
						//$( '#AddModal' ).modal( 'hide' );
						location.reload(true);

					} else {								
						$('#AddModalContent').html(response_data.msg);
					}
				},
                error:function(){
					$('#AttendanceEnter').removeAttr('disabled');
					 $(".wpsp-popup-return-data").html('Something went wrong. Try after refreshing page..');
					$("#SavingModal").css("display", "none");
							$("#WarningModal").css("display", "block");
							$("#WarningModal").addClass("wpsp-popVisible");
							
                   // $.fn.notify('error',{'desc':'Something went wrong. Try after refreshing page..'});
                },
                complete:function () {
					$('#AttendanceEnter').removeAttr('disabled');
                    
                }
			});
            //$('#AddModal').modal('show');
		}
	});

	/* Save Attendance */

	$(document).on('click','#AttendanceSubmit',function(e){
		e.preventDefault();
		var absents=$('input[type="checkbox"]:checked');
		if(absents.length>0){
			var Adata=$("#AttendanceEntryForm").serializeArray();
			Adata.push({name: 'action', value: 'AttendanceEntry'});
			jQuery.post(ajax_url, Adata, function(res) {
				if(res=='success'){
					$('#formresponse').html("<div class='alert alert-success'>Attendance entered successfully!</div>");
				// $(".wpsp-popup-return-data").html('Attendance entered successfully!');
				// 				$("#SuccessModal").css("display", "block");
				// 				$("#SavingModal").css("display", "none");
				// 				$("#SuccessModal").addClass("wpsp-popVisible");
					$('#AttendanceEntryForm').trigger("reset");
					setTimeout(function() {
						//$('#AddModal').modal('hide');
						$(".alert").remove();
						//	location.reload(true);
						 $( "#Attendanceview" ).click();
					}, 2000);

				}
				else if(res=='updated'){
					
					$('#formresponse').html("<div class='alert alert-warning'>Attendance updated successfully!</div>");
					/*setTimeout(function() {
						$('#AddModal').modal('hide');*/
						//$(".alert").remove();
						//$('#AddModal').modal('hide');
						location.reload(true);
					/*}, 1500);*/
				}
				else{
					$(".wpsp-popup-return-data").html(res);
								$("#SavingModal").css("display", "none");
								$("#WarningModal").css("display", "block");
								$("#WarningModal").addClass("wpsp-popVisible");
					//$('#formresponse').html("<div class='alert alert-danger'>"+res+"</div>");
					window.setTimeout(function() {
						$(".alert").fadeTo(500, 0).slideUp(500, function(){
							$(this).remove();
						});
					}, 5000);
				}
			});

		}else{
			 					$(".wpsp-popup-return-data").html('If no absent please select Nil at bottom!');
								$("#SavingModal").css("display", "none");
								$("#WarningModal").css("display", "block");
								$("#WarningModal").addClass("wpsp-popVisible");
			//$('#formresponse').html("<div class='alert alert-danger'>If no absent please select Nil at bottom!</div>");
		}
	});
    /*Delete Attendance*/

    $(document).on('click','.deleteAttendance',function(){
       if(confirm("Are you want to delete this entry?")){
            var aid=$(this).attr('data-id');
            if(!$.isNumeric(aid)){
            	$(".wpsp-popup-return-data").html('Attendance ID Missing!');
					$("#SavingModal").css("display", "none");
							$("#WarningModal").css("display", "block");
							$("#WarningModal").addClass("wpsp-popVisible");
               // $.fn.notify('error',{'desc':'Attendance ID Missing!'});
            }else{
                var data=[];
                data.push({name: 'action', value: 'deleteAttendance'},{name: 'aid', value: aid});
                $.ajax({
                    type: "POST",
                    url: ajax_url,
                    data: data,
                    beforeSend:function () {
                       // $.fn.notify('loader',{'desc':'Deleting entry..'});
                    },
                    success: function(res) {
                    	$(".wpsp-popup-return-data").html('Attendance entry deleted successfully..');
								$("#SuccessModal").css("display", "block");
								$("#SavingModal").css("display", "none");
								$("#SuccessModal").addClass("wpsp-popVisible");
                      //  $.fn.notify('success',{'desc':'Attendance entry deleted successfully..'});
                    },
                    error:function(){
                    	 $(".wpsp-popup-return-data").html('Something went wrong. Try after refreshing page..');
								$("#SavingModal").css("display", "none");
								$("#WarningModal").css("display", "block");
								$("#WarningModal").addClass("wpsp-popVisible");
                        //$.fn.notify('error',{'desc':'Something went wrong. Try after refreshing page..'});
                    },
                    complete:function () {
                        $('.pnloader').remove();
                    }
                });
            }
       }
    });

	/* View Absentees */
	$('.viewAbsentees').click(function(){
		var cid=$(this).attr('data-id');
		if($.isNumeric(cid)){
			var data=[];
			data.push({name: 'action', value: 'getAbsentees'},{name: 'classid', value: cid});
			$.ajax({
				type: "POST",
				url: ajax_url,
				data: data,
				beforeSend:function () {
					//$.fn.notify('loader',{'desc':'Loading absentees..'});
				},
				success: function(res) {
					$('#ViewModalContent').html(res);
				},
				error:function(){
					$(".wpsp-popup-return-data").html('Something went wrong. Try after refreshing page..');
								$("#SavingModal").css("display", "none");
								$("#WarningModal").css("display", "block");
								$("#WarningModal").addClass("wpsp-popVisible");
					//$.fn.notify('error',{'desc':'Something went wrong. Try after refreshing page..'});
				},
				complete:function () {
					$('.pnloader').remove();
				}
			});
			$('#ViewModal').modal('show');
		}else{
								$(".wpsp-popup-return-data").html('Class ID Missing..');
								$("#SavingModal").css("display", "none");
								$("#WarningModal").css("display", "block");
								$("#WarningModal").addClass("wpsp-popVisible");
			//$.fn.notify('error',{'desc':"Class ID Missing.."});
		}
	});
    /* View Absent Dates */
    $(document).on('click','.viewAbsentDates',function(){
        var sid=$(this).attr('data-id');
        if($.isNumeric(sid)){
            var data=[];
            data.push({name: 'action', value: 'getAbsentDates'},{name: 'sid', value: sid});
            $.ajax({
                type: "POST",
                url: ajax_url,
                data: data,
                beforeSend:function () {
                 //   $.fn.notify('loader',{'desc':'Loading absent dates..'});
                },
                success: function(res) {
                    $('#ViewModalContent').html(res);
                },
                error:function(){
                	$(".wpsp-popup-return-data").html('Something went wrong. Try after refreshing page..');
								$("#SavingModal").css("display", "none");
								$("#WarningModal").css("display", "block");
								$("#WarningModal").addClass("wpsp-popVisible");
                   // $.fn.notify('error',{'desc':'Something went wrong. Try after refreshing page..'});
                },
                complete:function () {
                    $('.pnloader').remove();
                }
            });
            $('#ViewModal').modal('show');
        }else{
        	$(".wpsp-popup-return-data").html('Class ID Missing..');
								$("#SavingModal").css("display", "none");
								$("#WarningModal").css("display", "block");
								$("#WarningModal").addClass("wpsp-popVisible");
          //  $.fn.notify('error',{'desc':"Student ID Missing.."});
        }
    });
	
	$( document ).on( 'click', '#Attendanceview', function() {
		
		$( '#AttendanceClass' ).parent().parent().find('.clserror').removeClass( 'error' );
		$( '#AttendanceDate' ).parent().parent().find('.clsdate').removeClass( 'error' );
		
		$( '#wpsp-error-msg' ).html();
		var cid		=	$('#AttendanceClass').val();
		var date	=	$('#AttendanceDate').val();
		if( cid=='' )
			$( '#AttendanceClass' ).parent().parent().find('.clserror').addClass( 'error' );
			/*$('#AttendanceClass').parent().parent().find('label').addClass('error');*/
		if( date=='' )
			/*$('#AttendanceDate').parent().parent().find('label').addClass('error');*/
			$( '#AttendanceDate' ).parent().parent().find('.clsdate').addClass( 'error' );
		if( cid!='' && date!='' ) {
			var data=[];
			data.push({name: 'action', value: 'getStudentsAttendanceList'},{name: 'classid', value: cid},{name:'date',value:date});
			$.ajax({
				type: "POST",
				url: ajax_url,
				data: data,
                beforeSend:function () {
                  //  $.fn.notify('loader',{'desc':'Loading student Attendance list..'});
					$('#Attendanceview').attr("disabled", 'disabled');
                },
				success: function(res) {
					$('#Attendanceview').removeAttr('disabled');
					var response_data =	jQuery.parseJSON(res);					
					if( response_data.status == 0 ) {
							$(".wpsp-popup-return-data").html('Something went wrong. Try after refreshing page..');
								$("#SavingModal").css("display", "none");
								$("#WarningModal").css("display", "block");
								$("#WarningModal").addClass("wpsp-popVisible");	
						//$( '#wpsp-error-msg' ).html(response_data.msg);
						//$( '#AddModal' ).modal( 'hide' );
					} else {
								// $(".wpsp-popup-return-data").html('Sucessfully Attendance Added');
								// $("#SuccessModal").css("display", "block");
								// $("#SavingModal").css("display", "none");
								// $("#SuccessModal").addClass("wpsp-popVisible");								
								 $('.AttendanceView' ).html( response_data.msg );
					}
				},
                error:function(){
					$('#Attendanceview').removeAttr('disabled');
					$(".wpsp-popup-return-data").html('Something went wrong. Try after refreshing page..');
								$("#SavingModal").css("display", "none");
								$("#WarningModal").css("display", "block");
								$("#WarningModal").addClass("wpsp-popVisible");
                    //$.fn.notify('error',{'desc':'Something went wrong. Try after refreshing page..'});
                },
                complete:function () {
					$('#Attendanceview').removeAttr('disabled');
                    //$('.pnloader').remove();
                }
			});            
		}
	});

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