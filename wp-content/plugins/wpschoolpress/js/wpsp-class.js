$(document).ready(function() {
     $('input.numbers').bind('keypress', function(e) { 
return ( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57)) ? false : true ;
  })
    updateDate();
    function updateDate() {
		
		$('.wpsp-start-date').datepicker({

			autoclose: true,
			dateFormat: date_format, 
			todayHighlight: true,  
			changeMonth: true,
			changeYear: true,
			startDate: '0m',
			
			
		});
		
		$('.wpsp-start-date').on('change', function() {
			console.log($('.wpsp-start-date').val());
			  $('.wpsp-end-date').datepicker('remove');
			  $('.wpsp-end-date').datepicker({
			  		autoclose: true,
			  		dateFormat: date_format,
			  		todayHighlight: true,  
					changeMonth: true,
					changeYear: true, 
			    	startDate: $('.wpsp-start-date').val(),
			    	setStartDate: $('.wpsp-start-date').val()
			  });
			  $('.wpsp-end-date').datepicker('update', $('.wpsp-start-date').val());
		});

		/*$('.wpsp-start-date').on('changeDate', function() {
			  $('.wpsp-end-date').datepicker('destroy', true);
			  $('.wpsp-end-date').datepicker({
			  		autoclose: true,
			  		dateFormat: date_format,
			  		todayHighlight: true,  
					changeMonth: true,
					changeYear: true, 
			    	startDate: $('.wpsp-start-date').val()
			  })
		});*/
		
		
       
     
    }
    $('#class_table').dataTable({
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

    $("#ClassAddForm").validate({
        rules: {
            Name: {
                required: true,
                minlength: 2,
            },
            Number: {
                 required: true,
            },
            capacity: {
                required: true,
                max: 100
            },
            /*ClassTeacherID: {
                number: true,
            },*/
            
            Sdate: {
                required: true,
            },
            Edate: {

                required: true,

            }

        },

        messages: {

            Name: {

                required: "Please enter class name",

                minlength: "Class must consist of at least 2 characters"

            },
            capacity: {
                max: "Class Out of capacity",
                required: "Please enter class capacity",
            },
            Number: "Please enter class number",
            Sdate: "Please enter Start Date",
            Edate: "Please enter End Date"
         

        },

        submitHandler: function(form) {

            var data = $('#ClassAddForm').serializeArray();

            data.push({
                name: 'action',
                value: 'AddClass'
            });

            $.ajax({

                type: "POST",

                url: ajax_url,

                data: data,

                beforeSend: function() {
                   // $('#c_submit').attr('disabled',true);
                    //$.fn.notify('loader', {'desc': 'Saving data..'});
					$("#SavingModal").css("display", "block");
					$('#c_submit').attr("disabled", 'disabled');	
                },
                success: function(rdata) {
                    if (rdata == 'inserted') {
						
						$(".wpsp-popup-return-data").html('Class created successfully !');
								$("#SuccessModal").css("display", "block");
								$("#SavingModal").css("display", "none");
								$("#SuccessModal").addClass("wpsp-popVisible");
                       // $.fn.notify('success', {'desc': 'Class created successfully!', autoHide: true, clickToHide: true});
                        var  wpsp_pageURL= $('#wpsp_locationginal').val();
                        var delay = 1000;
                        var url =  wpsp_pageURL+"/admin.php?page=sch-class";
                        var timeoutID = setTimeout(function() {
                        window.location.href = url;
                    }, delay);
                    //  $('#ClassAddForm .formresponse').html("<div class='alert alert-success'>Class created successfully!</div>");
                    $('#ClassAddForm').trigger("reset");
                    $('#c_submit').attr('disabled',true); 
                        } else {
							$(".wpsp-popup-return-data").html(rdata);
								$("#SavingModal").css("display", "none");
								$("#WarningModal").css("display", "block");
								$("#WarningModal").addClass("wpsp-popVisible");
                           // $.fn.notify('error', {'desc': rdata, autoHide: true, clickToHide: true });
                            //$('#ClassAddForm .formresponse').html("<div class='alert alert-danger'>" + rdata + "</div>");
                        }
                    },
                complete: function () {
                    //$('.pnloader').remove();
                }
            });
        }
    });




    $("#ClassEditForm").validate({
        rules: {
            Name: {
                required: true,
                minlength: 2,
            },
            capacity: {
                required: true,
                max: 100
            },
            ClassTeacherID: {
                number: true
            },
            Sdate:{
                required: true,
            },
            Edate:{
                required: true,
            }
        },
        messages: {
            Name: {
                required: "Please enter classname",
                minlength: "Class must consist of at least 2 characters"
            },
            capacity: {
                max: "Class Out of capacity"
            }
        },

        submitHandler: function(form) {
            var data = $('#ClassEditForm').serializeArray();
            data.push({
                name: 'action',
                value: 'UpdateClass'
            });
            $.ajax({
                type: "POST",
                url: ajax_url,
                data: data,
                beforeSend: function() {
                    //$('#ClassAddForm .formresponse').html("Saving..");
                   // $('#c_submit').attr('disabled','disabled');
                    //$.fn.notify('loader', {'desc': 'Saving data..'});
					$("#SavingModal").css("display", "block");
					$('#c_submit').attr("disabled", 'disabled');
                },
                success: function(rdata) {
                    if (rdata == 'updated') {
						$(".wpsp-popup-return-data").html('Class updated successfully !');
								$("#SuccessModal").css("display", "block");
								$("#SavingModal").css("display", "none");
								$("#SuccessModal").addClass("wpsp-popVisible");
                        //$.fn.notify('success', {'desc': 'Class updated successfully!', autoHide: true, clickToHide: true});  
                        var  wpsp_pageURL= $('#wpsp_locationginal').val();
                        var delay = 1000;
                        var url =  wpsp_pageURL+"/admin.php?page=sch-class";
                        var timeoutID = setTimeout(function() {
                        window.location.href = url;
                    }, delay);
                        $('#c_submit').attr('disabled','disabled');
                    } else {
						$(".wpsp-popup-return-data").html(rdata);
								$("#SavingModal").css("display", "none");
								$("#WarningModal").css("display", "block");
								$("#WarningModal").addClass("wpsp-popVisible");
                      //  $.fn.notify('error', {'desc': rdata, autoHide: true, clickToHide: true  });
                    }
                },
                complete: function () {
                   // $('.pnloader').remove();
                }
            });
        }
    });



   /* $('.ClassEditBt').on('click', function(e) {

        e.preventDefault();

        var data = [];

        cid = $(this).attr('cid');

        data.push({
            name: 'action',
            value: 'GetClass'
        }, {
            name: 'cid',
            value: cid
        });

        jQuery.post(ajax_url, data, function(pdata) {

            var pardata = JSON.parse(pdata);

            if (typeof pardata == 'object') {

                $('#ClassEditForm input[name=cid]').val(cid);

                $('#ClassEditForm input[name=Name]').val(pardata.c_name);

                $('#ClassEditForm input[name=Number]').val(pardata.c_numb);

                $('#ClassEditForm input[name=Location]').val(pardata.c_loc);

                $('#ClassEditForm input[name=Sdate]').val(pardata.c_sdate);

                $('#ClassEditForm input[name=Edate]').val(pardata.c_edate);

                $('#ClassEditForm input[name=capacity]').val('');

                if (pardata.c_capacity != null)

                    $('#ClassEditForm input[name=capacity]').val(pardata.c_capacity);

                $('#ClassEditForm select[name=ClassTeacherID]').val(pardata.teacher_id);

                $('#EditModal').modal('show');

                updateDate();

            } else {



                $('#InfoModalTitle').text("Error Information!");

                $('#InfoModalBody').html("<h3>Sorry! No data retrived!</h3><span class='text-muted'>You can refresh page and try again</span>");

                $('#InfoModal').modal('show');

            }



        });



    }); */
$(document).on('click','#d_teacher',function(e) { 	
			var cid = $(this).data('id');
			console.log(cid);
			$("#teacherid").val(cid);
			$("#DeleteModal").css("display", "block");
		});
    $(document).on('click','.ClassDeleteBt',function(e) {
      //  var cid = $(this).data('id');
	  			var cid = $('#teacherid').val();
       
            var data = [];
            data.push({
                name: 'action',
                value: 'DeleteClass'
            }, {
                name: 'cid',
                value: cid
            });
           // cid = '0';
            jQuery.post(ajax_url, data, function(cddata) {
                if (cddata == 'success') {
                    //$.fn.notify('success', {'desc': 'Deleted successfully!'});
                    location.reload();
                } else {
					$(".wpsp-popup-return-data").html('Operation failed.Something went wrong!');
					$("#SavingModal").css("display", "none");
					$("#WarningModal").css("display", "block");
					$("#WarningModal").addClass("wpsp-popVisible");
                    //$.fn.notify('error', {'desc': 'Operation failed.Something went wrong!'});
                }
            });
       
    });
});