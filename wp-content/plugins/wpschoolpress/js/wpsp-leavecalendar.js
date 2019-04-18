$(document).ready(function() {  
    var addDate = '<div class="wpsp-row"><div class="wpsp-col-xs-12"><div class="wpsp-card"><div class="wpsp-panel-heading"><h3 class="wpsp-panel-title">Add Leave Date</h3></div><div class="wpsp-card-body"><div class="wpsp-row"><div class="wpsp-col-md-6"><div class="wpsp-form-group"> <label class="wpsp-label" for="from">From <span class="wpsp-required">*</span></label><input type="text" name="spls" class="wpsp-form-control spls select_date"></div></div><div class="wpsp-col-md-6"><div class="wpsp-form-group"><label class="wpsp-label" for="from">To <span class="wpsp-required">*</span></label><input type="text" name="sple" class="wpsp-form-control sple select_date"></div></div><div class="wpsp-col-md-12"><div class="wpsp-form-group"><label class="wpsp-label" for="from">Reason</label><input type="text" name="splr" class="wpsp-form-control"></div></div>';
    $('#addLeaveDays').click(function() {
        $('#addLeaveDaysBody').toggle();
    });

    $('.leaveAdd').click(function() {
        var cid = $(this).attr('data-id');
        var form = '<form action="" id="addLeaveDateForm" method="post">';
        $('#leaveModalHeader').html("Add Leave Date");
        $('#ViewModalContent').html(form + addDate + '<div class="wpsp-col-xs-12"><input type="hidden" name="ClassID" value="' + cid + '"><input type="submit" class="wpsp-btn wpsp-btn-success" id="addLeaveDateSubmit" value="Submit"> <a href="http://betatesting87.com/wpschoolpresstest/wp-admin/admin.php?page=sch-leavecalendar" class="wpsp-btn wpsp-dark-btn">Cancel</a></div></div></form>');
        $(this).click();
    });

    $('#wpsp_leave_days').dataTable({
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
        "columnDefs": [{
            "targets": 'nosort',
            "orderable": false,
        }],
        drawCallback: function(settings) {
               var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
               pagination.toggle(this.api().page.info().pages > 1);
            },
        responsive: true
    });

    $('.leaveView').click(function() {
        $('#leaveModalHeader').html("Leave Dates");
        $('#ViewModalContent').html('');
        var cid = $(this).attr('data-id');
        var data = [];
        data.push({
            name: 'action',
            value: 'getLeaveDays'
        }, {
            name: 'cid',
            value: cid
        });
        $.ajax({
            type: "POST",
            url: ajax_url,
            data: data,
           
            success: function(res) {
                $('#ViewModalContent').html(res);
                $(this).click();
            },
           
            error: function() {
				$(".wpsp-popup-return-data").html('Operation failed.Something went wrong!');
					$("#SavingModal").css("display", "none");
					$("#WarningModal").css("display", "block");
					$("#WarningModal").addClass("wpsp-popVisible");
                
            }
        });
    });

    $('.leaveDelete').click(function() {
        var lid = $(this).attr('data-id');
        if ($.isNumeric(lid)) {
            $('#leaveModalBody').html("<h4>Are you sure want to delete all dates?</h4><div class='pull-right'><div class='btn btn-default' data-dismiss='modal' id='AllDeleteCancel'>Cancel</div>&nbsp; <div class='btn btn-danger' data-id='" + lid + "' id='AllDeleteConfirm'>Confirm</div></div><div style='clear:both'></div>");
        } else {
            $('#leaveModalBody').html("Class id missing can't delete. Please report it to support for deletion");
        }
        $('#leaveModalHeader').html("Delete all date");
        $('#leaveModal').modal('show');
    });
    $(document).on('click', '.dateDelete', function() {
        var lid = $(this).attr('data-id');
        if ($.isNumeric(lid)) {
            $('#leaveModalBody').html("<h4>Are you sure want to delete this dates?</h4><div class='pull-right'><div class='btn btn-default' data-dismiss='modal' id='DateDeleteCancel'>Cancel</div>&nbsp; <div class='btn btn-danger' data-id='" + lid + "' id='DateDeleteConfirm'>Confirm</div></div><div style='clear:both'></div>");
        } else {
            $('#leaveModalBody').html("Class id missing can't delete. Please report it to support for deletion");
        }
        $('#leaveModalHeader').html("Delete all date");
        $('#leaveModal').modal('show');
    });$(document).on('click','#d_teacher',function(e) { 	
			var cid = $(this).data('id');
			console.log(cid);
			$("#teacherid").val(cid);
			$("#DeleteModal").css("display", "block");
		});
    $(document).on('click', '#AllDeleteConfirm', function() {
        //var cid = $(this).attr('data-id');
		var cid = $('#teacherid').val();
        var data = [];
        data.push({
            name: 'action',
            value: 'deleteAllLeaves'
        }, {
            name: 'cid',
            value: cid
        });
        $.ajax({
            type: "POST",
            url: ajax_url,
            data: data,
           
            success: function(res) {
                if (res == 'success') {
					  location.reload();
                   // var pntype = 'success';
                    //var pntext = "Dates deleted Successfully";
                } else {
                   // var pntype = 'error';
                   // var pntext = res;
					$(".wpsp-popup-return-data").html('Operation failed.Something went wrong!');
								$("#SavingModal").css("display", "none");
								$("#WarningModal").css("display", "block");
								$("#WarningModal").addClass("wpsp-popVisible");
                }
                //$('#leaveModal').modal('hide');
              
            }
        
          
        });

    });
    $(document).on('focus', ".spls", function() {
        $('.spls').datepicker({
            autoclose: true,
            dateFormat: date_format,
            todayHighlight: true,
            changeMonth: true,
            changeYear: true,
            minDate: '0d',
            beforeShow: function(input, inst) {
                $(document).off('focusin.bs.modal');
            },
            onClose: function() {
                $(document).on('focusin.bs.modal');
            }

        });
    });
    $(document).on('focus', ".sple", function() {
        $('.sple').datepicker({
            autoclose: true,
            dateFormat: date_format,
            todayHighlight: true,
            changeMonth: true,
            changeYear: true,
            minDate: '0d',
            beforeShow: function(input, inst) {
                $(document).off('focusin.bs.modal');
            },
            onClose: function() {
                $(document).on('focusin.bs.modal');
            }
        });
    });

    $(document).on('submit', '#addLeaveDateForm', function(e) {
        e.preventDefault();
        var data = $(this).serializeArray();
        data.push({
            name: 'action',
            value: 'addLeaveDay'
        });
        $.ajax({
            type: "POST",
            url: ajax_url,
            data: data,
           
            success: function(res) {
                if (res == 'success') {
                    var pntype = 'success';
                    var pntext = "Dates added Successfully";
                } else {
                    var pntype = 'error';
                    var pntext = res;
                }
                $('#leaveModal').modal('hide');
               
            },
            
            
            error: function() {
               $(".wpsp-popup-return-data").html('Operation failed.Something went wrong!');
								$("#SavingModal").css("display", "none");
								$("#WarningModal").css("display", "block");
								$("#WarningModal").addClass("wpsp-popVisible");
            }
        });

    });
    $(document).on('click', '#DateDeleteConfirm', function() {
        var lid = $(this).attr('data-id');
        var data = [];
        data.push({
            name: 'action',
            value: 'deleteAllLeaves'
        }, {
            name: 'lid',
            value: lid
        });
        $.ajax({
            type: "POST",
            url: ajax_url,
            data: data,
           
            success: function(res) {
                if (res == 'success') {
                    var pntype = 'success';
                    var pntext = 'Date deleted successfully';
                } else {
                    var pntype = 'error';
                    var pntext = res;
                }
                $('#leaveModal').modal('hide');
               
            },
           
            error: function() {
               $(".wpsp-popup-return-data").html('Operation failed.Something went wrong!');
								$("#SavingModal").css("display", "none");
								$("#WarningModal").css("display", "block");
								$("#WarningModal").addClass("wpsp-popVisible");
            }
        });
    });
    
    $("#teacher_table").on("click", ".wpsp-popclick", function(){
            var linkAttrib = $(this).attr('data-pop');          
            $('#' + linkAttrib).addClass("wpsp-popVisible");
            $('body').addClass('wpsp-bodyFixed')
        });
           

    $('#ClassID').change(function() {
        var cid = $(this).val();
        var data = [];
        data.push({
            name: 'action',
            value: 'getClassYear'
        }, {
            name: 'cid',
            value: cid
        });
        $.ajax({
            type: "POST",
            url: ajax_url,
            data: data,
           
            success: function(res) {
                try {
                    var clyear = $.parseJSON(res);
                    $('#CSDate').val(clyear.c_sdate);
                    $('#CEDate').val(clyear.c_edate);
                } catch (e) {

                }
            },
           
            error: function() {
               $(".wpsp-popup-return-data").html('Operation failed.Something went wrong!');
								$("#SavingModal").css("display", "none");
								$("#WarningModal").css("display", "block");
								$("#WarningModal").addClass("wpsp-popVisible");
            }
        });
    })
});