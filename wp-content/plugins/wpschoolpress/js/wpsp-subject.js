$(document).ready(function() {
    var table   =$('.subjectdataTable').dataTable({
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
    $('#listofsubjects').dataTable({
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
   
    $("#AddSubjectButton").click(function() {
        $("#SClassName").text($("#ClassID option:selected").text());
        $("#SCID").val($("#ClassID").val());
        $("#AddSubjectModal").modal('show');
    });
    $("#ClassID").change(function() {
        $("#SubjectList-Form").submit();
    });
    $("#ShowExtraFields").click(function() {
        $(".SubjectExtraDetails").toggle();
    });

    if($.trim($('#ClassID').val()) == 'all'){
         $('#subdisable').attr('disabled','disabled');
    } else {
         $('#subdisable').attr('disabled',false);
    }

    $("#SubjectEntryForm").validate({
        onkeyup: false,
        ignore: [],
        rules: {
            'SNames[]': {
                required: true,
                minlength: 2
            },
            'SCID': {
                required: true,
                number: true
            },
            STeacherID: {
                number: true
            }
        },
        messages: {
            SName: {
                required: "Please enter Subject Name",
                minlength: "Subject must consist of at least 2 characters"
            },
            SCID: {
                required: "Class ID missing please refresh"
            }
        },
        submitHandler: function(form) {
            var data = $('#SubjectEntryForm').serializeArray();
            data.push({
                name: 'action',
                value: 'AddSubject'
            });
            $.ajax({
                type: "POST",
                url: ajax_url,
                data: data,

                success: function(rdata) {
                    if (rdata == 'success') {
						//$.fn.notify('success', {'desc': 'Subject created successfully!', autoHide: true, clickToHide: true});
						$(".wpsp-popup-return-data").html('Subject created successfully !');
								$("#SuccessModal").css("display", "block");
								$("#SavingModal").css("display", "none");
								$("#SuccessModal").addClass("wpsp-popVisible");
                        var  wpsp_pageURL= $('#wpsp_locationginal1').val();
                        var delay = 1000;
                        var url =  wpsp_pageURL+"/admin.php?page=sch-subject";
                        var timeoutID = setTimeout(function() {
                        window.location.href = url;
                        }, delay); 
						$('#s_submit').attr('disabled','disabled');
                     //   $('.formresponse').html("<div class='alert alert-success'>Subject Created Successfully!</div>");
                        $('#SubjectEntryForm').trigger("reset");
                    } else {
						//$.fn.notify('error', {'desc': rdata, autoHide: true, clickToHide: true });
						$(".wpsp-popup-return-data").html(rdata);
								$("#SavingModal").css("display", "none");
								$("#WarningModal").css("display", "block");
								$("#WarningModal").addClass("wpsp-popVisible");
                       // $('.formresponse').html("<div class='alert alert-danger'>" + rdata + "</div>");
                    }
                }
            });

        }
    });

    /*Edit Subject Modal */
    $(".EditSubjectLink").click(function() {
        var sid = $(this).attr('sid');
        var SDetails = [];
        SDetails.push({
            name: 'action',
            value: 'SubjectInfo'
        });
        SDetails.push({
            name: 'sid',
            value: sid
        });
        $.ajax({
            type: "POST",
            url: ajax_url,
            data: SDetails,
            beforeSend: function() {
                //$('#formresponse').html("Saving..");
				//$('#u_teacher').attr('disabled','disabled');
				$("#SavingModal").css("display", "block");
				$('#u_teacher').attr("disabled", 'disabled');
            },
            success: function(subject_details) {
                var sdatapar = $.parseJSON(subject_details);
                if (typeof sdatapar == 'object') {
                    $('#SRowID').val(sdatapar.id);
                    $('#ESClassID').val(sdatapar.class_id);
                    $('#EditSCode').val(sdatapar.sub_code);
                    $('#EditSName').val(sdatapar.sub_name);
                    $('#EditBName').val(sdatapar.book_name);
                    try {
                        $("#EditSTeacherID option[value=" + sdatapar.sub_teach_id + "]").attr('selected', 'selected');
                    } catch (e) {
                        //
                    }
                    $('#EditSubjectModal').modal('show');
					$('#u_teacher').attr('disabled','disabled');
                } else {
                    $('#InfoModalTitle').text("Error Information!");
                    $('#InfoModalBody').html("<h3>Sorry! No data retrived!</h3><span class='text-muted'>You can refresh page and try again</span>");
                    $('#InfoModal').modal('show');
                }
            },
            error: function() {
                $('#InfoModalTitle').text("Error Information!");
                $('#InfoModalBody').html("<h3>Sorry! File not reachable!</h3><span class='text-muted'>Check your internet connection!</span>");
                $('#InfoModal').modal('show');
            }
        });
    });
    /*Edit Save */
    $("#SEditForm").validate({
        onkeyup: false,
        rules: {
            EditSName: {
                required: true,
                minlength: 2
            },

            EditSTeacherID: {
                number: true
            }
        },
        messages: {
            SName: {
                required: "Please enter Subject Name",
                minlength: "Subject must consist of at least 2 characters"
            }
        },
        submitHandler: function(form) {
            var data = $('#SEditForm').serializeArray();
            data.push({
                name: 'action',
                value: 'UpdateSubject'
            });
            $.ajax({
                type: "POST",
                url: ajax_url,
                data: data,
                success: function(rdata) {
                    if (rdata == 'updated') {
						//$.fn.notify('success', {'desc': 'Subject information updated Successfully!', autoHide: true, clickToHide: true});
						$(".wpsp-popup-return-data").html('Subject information updated Successfully !');
								$("#SuccessModal").css("display", "block");
								$("#SavingModal").css("display", "none");
								$("#SuccessModal").addClass("wpsp-popVisible");
                        var  wpsp_pageURL= $('#wpsp_locationginal1').val();
                        var delay = 1000;
                        var url =  wpsp_pageURL+"/admin.php?page=sch-subject";
                        var timeoutID = setTimeout(function() {
                        window.location.href = url;
                        }, delay); 
						$('#SEditSave').attr('disabled','disabled');
                    } else {
						$(".wpsp-popup-return-data").html(rdata);
								$("#SavingModal").css("display", "none");
								$("#WarningModal").css("display", "block");
								$("#WarningModal").addClass("wpsp-popVisible");
                        //$.fn.notify('error', {'desc': rdata, autoHide: true, clickToHide: true });
                        $('#SEditSave').attr('disabled',false);
                    }
                }
            });
        }
    });
	$(document).on('click','#d_teacher',function(e) { 	
			var sid = $(this).data('id');
			
			$("#teacherid").val(sid);
			$("#DeleteModal").css("display", "block");
		});
    /* Subject Delete */
    $(document).on('click', '.ClassDeleteBt', function(e) {
			var sid = $('#teacherid').val();
            var data = [];
            data.push({
                name: 'action',
                value: 'DeleteSubject'
            }, {
                name: 'sid',
                value: sid
            });
            jQuery.post(ajax_url, data, function(cddata) {
                if (cddata == 'deleted') {
                  location.reload();
                } else {
                 
				   $(".wpsp-popup-return-data").html('Operation failed.Something went wrong!');
					$("#SavingModal").css("display", "none");
					$("#WarningModal").css("display", "block");
					$("#WarningModal").addClass("wpsp-popVisible");
                }
            });
       
                
      
    });
    /*
    $(document).on('click','#SubjectDeleteConfirm',function(e){
    	var data=[];
    	data.push({name: 'action', value: 'DeleteSubject'},{name: 'sid', value: sid});
    	sid='0';
    	jQuery.post(ajax_url, data, function(cddata) {
    		if(cddata=='deleted'){
    			$('#InfoModalBody').html("<div class='col-md-8 alert alert-success'>Subject deleted successfully!</div>");
    			location.reload();
    		}
    		else{
    			$('#InfoModalBody').html("<div class='col-md-8 alert alert-danger'>"+cddata+"</div>");
    		}
    	});
    });
    $('.modal').on('hidden.bs.modal', function (e) {
    	//location.reload();
    }); */
});
 /* Custom Tab Js */
    $('#verticalTab').easyResponsiveTabs({
    type: 'vertical',
    width: 'auto',
    fit: true
    //$.fn.dataTable.tables( {visible: true, api: true} ).columns.adjust();
    
    });
       

    if($(window).width() < 991){        //alert('test');

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
    

    jQuery(window).resize(function() {
  if(jQuery(window).width() > 991){ 
    //alert('test'); 
    if( !$('#verticalTab').find('.wpsp-resp-tab-active').length){ 
        //alert('test');
        $('.wpsp-resp-tabs-list .wpsp-resp-tab-item:first-child').click(); 
    }
} 
});