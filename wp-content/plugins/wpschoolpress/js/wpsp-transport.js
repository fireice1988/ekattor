$(document).ready(function() {

    $('#transport_table').dataTable({
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

    $('#AddNew').click(function() {
        var data = new Array();
        data.push({
            name: 'action',
            value: 'addTransport'
        });
        $.ajax({
            type: "GET",
            url: ajax_url,
            data: data,
            success: function(form) {
                $('#ViewModalContent').html(form);
                $(this).click();
            },
            complete: function() {
                $('.pnloader').remove();
                $(this).click();
            },
            error: function() {
                               $(".wpsp-popup-return-data").html('Something went wrong..');
                                $("#SavingModal").css("display", "none");
                                $("#WarningModal").css("display", "block");
                                $("#WarningModal").addClass("wpsp-popVisible");
                // $.fn.notify('error', {
                //     'desc': 'Something went wrong..'
                // });
            }
        })
    });
    $('.EditTrans').click(function() {
        var id = $(this).attr('data-id');
        var data = new Array();
        data.push({
            name: 'action',
            value: 'updateTransport'
        }, {
            name: 'id',
            value: id
        });
        $.ajax({
            type: "GET",
            url: ajax_url,
            data: data,
            success: function(form) {
                $('#ViewModalContent').html(form);
            },
            complete: function() {
                $('.pnloader').remove();
                $(this).click();
            },
            error: function() {
                                $(".wpsp-popup-return-data").html('Something went wrong..');
                                $("#SavingModal").css("display", "none");
                                $("#WarningModal").css("display", "block");
                                $("#WarningModal").addClass("wpsp-popVisible");
                // $.fn.notify('error', {
                //     'desc': 'Somethng went wrong..'
                // });
            }
        })
    });
    $('.ViewTrans').click(function() {
        var id = $(this).attr('data-id');
        var data = new Array();
        data.push({
            name: 'action',
            value: 'viewTransport'
        }, {
            name: 'id',
            value: id
        });
        $.ajax({
            type: "GET",
            url: ajax_url,
            data: data,
          
            success: function(form) {
                $('#ViewModalContent').html(form);
            },
            complete: function() {
                $('.pnloader').remove();
                $(this).click();
            },
            error: function() {
                $(".wpsp-popup-return-data").html('Something went wrong..');
                                $("#SavingModal").css("display", "none");
                                $("#WarningModal").css("display", "block");
                                $("#WarningModal").addClass("wpsp-popVisible");
                // $.fn.notify('error', {
                //     'desc': 'Somethng went wrong..'
                // });
            }
        })
    });
    $(document).on('click', '#TransSubmit', function(e) {
        e.preventDefault();
        var data = $('#TransEntryForm').serializeArray();
        data.push({
            name: 'action',
            value: 'addTransport'
        });
        $.ajax({
            type: "POST",
            url: ajax_url,
            data: data,
            beforeSend: function() {
                $.fn.notify('loader', {
                    'desc': 'Saving data..'
                });
            },
            success: function(res) {
                if (res == 'success') {
                    // $.fn.notify('success', {
                    //     'desc': 'Transport details saved successfully..'
                    // });
                                 $(".wpsp-popup-return-data").html('Transport details saved successfully.');
                                $("#SuccessModal").css("display", "block");
                                $("#SavingModal").css("display", "none");
                                $("#SuccessModal").addClass("wpsp-popVisible");
                    $('#TransModalBody').html('');
                    $('#TransModal').modal('hide');
                    var delay = 1000;
                    setTimeout(function() {
                        location.reload(true);
                    }, delay);
                } else {
                    // $.fn.notify('error', {
                    //     'desc': res
                    // });
                    $(".wpsp-popup-return-data").html(res);
                                $("#SavingModal").css("display", "none");
                                $("#WarningModal").css("display", "block");
                                $("#WarningModal").addClass("wpsp-popVisible");
                }
            },
            complete: function() {
                $('.pnloader').remove();
            },
            error: function() {
                // $.fn.notify('error', {
                //     'desc': 'Somethng went wrong..'
                // });
                                $(".wpsp-popup-return-data").html('Somethng went wrong..');
                                $("#SavingModal").css("display", "none");
                                $("#WarningModal").css("display", "block");
                                $("#WarningModal").addClass("wpsp-popVisible");
            }
        })
    })
    $(document).on('click', '#TransUpdate', function(e) {
        e.preventDefault();
        var data = $('#TransEditForm').serializeArray();
        data.push({
            name: 'action',
            value: 'updateTransport'
        });
        $.ajax({
            type: "POST",
            url: ajax_url,
            data: data,
            
            success: function(res) {
                if (res == 'success') {
                    // $.fn.notify('success', {
                    //     'desc': 'Transport details saved successfully..'
                    // });
                    (".wpsp-popup-return-data").html('Transport details saved successfully.');
                                $("#SuccessModal").css("display", "block");
                                $("#SavingModal").css("display", "none");
                                $("#SuccessModal").addClass("wpsp-popVisible");
                    $('#TransModalBody').html('');
                    $('#TransModal').modal('hide');
                    var delay = 1000;
                    setTimeout(function() {
                        location.reload(true);
                    }, delay);

                } else {
                    // $.fn.notify('error', {
                    //     'desc': res
                    // });
                     $(".wpsp-popup-return-data").html(res);
                                $("#SavingModal").css("display", "none");
                                $("#WarningModal").css("display", "block");
                                $("#WarningModal").addClass("wpsp-popVisible");
                }
            },
            complete: function() {
                $('.pnloader').remove();
            },
            error: function() {
                // $.fn.notify('error', {
                //     'desc': 'Somethng went wrong..'
                // });
                                $(".wpsp-popup-return-data").html('Somethng went wrong..');
                                $("#SavingModal").css("display", "none");
                                $("#WarningModal").css("display", "block");
                                $("#WarningModal").addClass("wpsp-popVisible");
            }
        })
    });
    // $('.DeleteTrans').click(function() {
    //     var transid = $(this).attr('data-id');
    //     $('#TransModal').modal('show');
    //     $('#TransModalTitle').text("Confirm your action");
    //     $('#TransModalBody').html("<h3>Are you want to delete Transport details?</h3><div class='pull-right'><div class='btn btn-default' data-dismiss='modal' id='ConfirmCancel'>Cancel</div>&nbsp; <div class='btn btn-danger' data-id=" + transid + " id='DeleteTransConfirm'>Confirm</div></div>");

    // })
        $(document).on('click','#d_teacher',function(e) {   
            var id = $(this).data('id');
            console.log(id);
            $("#teacherid").val(id);
            $("#DeleteModal").css("display", "block");
        });
    $(document).on('click', '.ClassDeleteBt', function() {
       // var id = $(this).attr('data-id');
       var id = $('#teacherid').val();
        var data = new Array();
        data.push({
            name: 'action',
            value: 'deleteTransport'
        }, {
            name: 'id',
            value: id
        });
        $.ajax({
            type: "POST",
            url: ajax_url,
            data: data,
           
            success: function(res) {
                if (res == 'success') {
                    //$('#ClassDeleteBt').html('');
                   // $('.ClassDeleteBt').modal('hide');
                    location.reload();
                } else {
                   $(".wpsp-popup-return-data").html('Somethng went wrong..');
                                $("#SavingModal").css("display", "none");
                                $("#WarningModal").css("display", "block");
                                $("#WarningModal").addClass("wpsp-popVisible");

                }
            },
            complete: function() {
                $('.pnloader').remove();

            },
            error: function() {
                $(".wpsp-popup-return-data").html('Somethng went wrong..');
                                $("#SavingModal").css("display", "none");
                                $("#WarningModal").css("display", "block");
                                $("#WarningModal").addClass("wpsp-popVisible");
            }
        })
    });
});