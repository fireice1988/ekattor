$(document).ready(function(){
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
       endDate: "today"
    });
	/*Retrive Teacher List */
	$('#AttendanceEnter').click(function(){
		$('#AddModalContent').html('');		
		var date=$('#AttendanceDate').val();		
		if(date=='')
			$('#AttendanceDate').parent().parent().find('label').addClass('error');
		if( date!='' ) {
			var data=[];
			data.push({name: 'action', value: 'getTeachersList'},{name:'date',value:date});			
			$.ajax({
				type: "POST",
				url: ajax_url,
				data: data,
                beforeSend:function () {
                    //$.fn.notify('loader',{'desc':'Loading Teachers list..'});
                },
				success: function(res) {					
					//$('#AddModalContent').html(res);
					 $('.AttendanceContent').html(res);					 
					 /*$('.attendance-entry').dataTable({
						"order": [],
						"aLengthMenu": [ [100, "All"] ],
						"columnDefs": [ {
						  "targets"  : 'nosort',
						  "orderable": false,
						}],
						responsive: true,
					});*/

				},
                error:function(){
                  //  $.fn.notify('error',{'desc':'Something went wrong. Try after refreshing page..'});
                  $(".wpsp-popup-return-data").html('Operation failed.Something went wrong!');
                    $("#SavingModal").css("display", "none");
                    $("#WarningModal").css("display", "block");
                    $("#WarningModal").addClass("wpsp-popVisible");
                },
                complete:function () {
                   // $('.pnloader').remove();
                }
			});
            //$('#AddModal').modal('show');
		}
	});
	
	/* Save Attendance */
	$(document).on('click','#AttendanceSubmit',function(e){
		e.preventDefault();
		var absents=$('input[type="checkbox"]:checked');
		if(absents.length>0 ) {
			var Adata=$("#AttendanceEntryForm").serializeArray();
			
			Adata.push({name: 'action', value: 'TeacherAttendanceEntry'});
			jQuery.post(ajax_url, Adata, function(res) {
				if(res=='success'){
					//$.fn.notify('success', {'desc': 'Attendance entered successfully!', autoHide: true, clickToHide: true});
                       $(".wpsp-popup-return-data").html('Attendance entered successfully!');
                                $("#SuccessModal").css("display", "block");
                                $("#SavingModal").css("display", "none");
                                $("#SuccessModal").addClass("wpsp-popVisible");
					//$('#formresponse').html("<div class='alert alert-success'>Attendance entered successfully!</div>");
					$('#AttendanceEntryForm').trigger("reset");
					setTimeout(function() {
						//$('#AddModal').modal('hide');
                      //  alert('aaa');
						$(".alert").remove();
                        $("#SuccessModal").css("display", "none");
                         $("#AttendanceView").click();
					}, 2000); 
				}
				else if(res=='updated'){
                    $(".wpsp-popup-return-data").html('Attendance updated successfully!');
                                $("#SuccessModal").css("display", "block");
                                $("#SavingModal").css("display", "none");
                                $("#SuccessModal").addClass("wpsp-popVisible");
					//$.fn.notify('success', {'desc': 'Attendance updated successfully!', autoHide: true, clickToHide: true});
					//$('#formresponse').html("<div class='alert alert-warning'>Attendance updated successfully!</div>");
					setTimeout(function() {
						//$('#AddModal').modal('hide');
						$(".alert").remove();
                        $("#SavingModal").modal('hide');
                        $( "#AttendanceView" ).click();
					}, 1500); 
				}
				else {
                    $(".wpsp-popup-return-data").html('Operation failed.Something went wrong!');
                    $("#SavingModal").css("display", "none");
                    $("#WarningModal").css("display", "block");
                    $("#WarningModal").addClass("wpsp-popVisible");
					//$.fn.notify('error', {'desc': rdata, autoHide: true, clickToHide: true });
					//$('#formresponse').html("<div class='alert alert-danger'>"+res+"</div>");
					/*window.setTimeout(function() {
						$(".alert").fadeTo(500, 0).slideUp(500, function(){
							$(this).remove();
						});
					}, 5000); */
				}
				
			});
		}else{
			$('#formresponse').html("<div class='alert alert-danger'>If no absent please select Nil at bottom!</div>");
		}
	});
    /*Delete Attendance*/
    $(document).on('click','.deleteAttendance',function(){
       if(confirm("Are you want to delete this entry?")){
            var aid=$(this).attr('data-id');
            if( aid == '' ) {
                $.fn.notify('error',{'desc':'Attendance information Missing!'});
            }else{
                var data=[];
                data.push({name: 'action', value: 'TeacherAttendanceDelete'},{name: 'aid', value: aid});
                $.ajax({
                    type: "POST",
                    url: ajax_url,
                    data: data,
                    beforeSend:function () {
                        $.fn.notify('loader',{'desc':'Deleting entry..'});
                    },
                    success: function(res) {
                        $.fn.notify('success',{'desc':'Attendance entry deleted successfully..'});
                    },
                    error:function(){
                        $.fn.notify('error',{'desc':'Something went wrong. Try after refreshing page..'});
                    },
                    complete:function () {
                        $('.pnloader').remove();
                    }
                });
            }
       }
    });
	
	/* View Absentees */
	$('#AttendanceView').click(function() {		
		var selecteddate = $('#AttendanceDate').val();
		if( selecteddate != '' ) {
			var data=[];
            data.push({name: 'action', value: 'TeacherAttendanceView'},{name: 'selectedate', value: selecteddate});
            $.ajax({
                type: "POST",
                url: ajax_url,
                data: data,
                beforeSend:function () {                    
                },
                success: function(res) {
                    $('.AttendanceContent').html(res);
               },
                error:function(){
                     $.fn.notify('error',{'desc':'Something went wrong. Try after refreshing page..'});
                },
                complete:function () {
                    $('.pnloader').remove();
                }
			});
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
                    $.fn.notify('loader',{'desc':'Loading absent dates..'});
                },
                success: function(res) {
                    $('#ViewModalContent').html(res);
                },
                error:function(){
                    $.fn.notify('error',{'desc':'Something went wrong. Try after refreshing page..'});
                },
                complete:function () {
                    $('.pnloader').remove();
                }
            });
            $('#ViewModal').modal('show');
        }else{
            $.fn.notify('error',{'desc':"Teacher ID Missing.."});
        }
    });

    $('#teacherAttendanceTable').dataTable({		
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
});