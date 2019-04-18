$(document).ready(function(){       

    $("#sessions_template").change(function() {

        if($(this).val()=="new") {

            $('#enter_sessions').show();

            $('#select_template').hide();

        } else {

            $('#enter_sessions').hide();

            $('#select_template').show();

        }

    });

    

    $('#deleteTimetable').click(function()  {

        var cid=$(this).attr('data-id');

        if(confirm("Are you sure want to delete class Timetable?") == true) {

            var ttDetails= [];

            ttDetails.push({name: 'cid' , value: cid });

            ttDetails.push({name: 'action', value: 'deletTimetable'});

            jQuery.post(ajax_url, ttDetails, function(stat) {

                if(stat=='deleted') {

                    $("#TimetableContainer").html("<div class='alert alert-info'>Class Timetable deleted Successfully..</div>");

                }

            });

        }

    });
$(document).on('click', '.daleteid', function(){
	    var $isthis = $(this);
	    var cid=$(this).attr('data-id');
		var rid=$(this).attr('data-rowid');
		//console.log(cid);
		//console.log(rid);
		 if(confirm("Are you sure want to delete this sloat?") == true) {
			var ttDetails= [];
            ttDetails.push({name: 'cid' , value: cid });
			ttDetails.push({name: 'rid' , value: rid });
            ttDetails.push({name: 'action', value: 'deletsloat'});
            jQuery.post(ajax_url, ttDetails, function(stat) {
                console.log(stat);
                console.log($isthis);
                
                if(stat=='deleted') {
					//$("#TimetableContainer").html("<div class='alert alert-info'>Class Timetable deleted Successfully..</div>");
                    $isthis.parent().remove();
                }
            });
        }
	
});
        $("#timetable_form").validate({

            rules: {

                noh: {
                    required: true,
                },
                sessions_template:{
                    required: true,
                },
                wpsp_class_name:{
                    required: true,
                },               
            },
            messages: {
                noh:{
                    required: "Please enter number of sessions",
                },
                sessions_template:{
                    required: "Please enter number of sessions",
                },
                wpsp_class_name:{
                    required: "Please select class",
                }
            }
        });

    $('.item').draggable({

        revert:true,
        scroll: true,

        proxy:'clone'

    });

    

    $('.drop').droppable({

        accept: '.item',

        onDragEnter:function(){

            $(this).addClass('over');

        },

        onDragLeave:function(){

            $(this).removeClass('over');

        },

        onDrop:function(e,source) {         

                       $(this).removeClass('over');
            if ($(source).hasClass('assigned')){
                $(this).append(source);
            } else {
                var seid = $(this).data('sessionid');
                var rowid = $(this).closest('tr').attr('id');
                var c = $(source).clone().removeClass('item').addClass('wpsp-assigned-item assigned item1');
                var d = c.append('<a href="javascript:void(0)" class="daleteid wpsp-tt-delete-icon" data-id="'+seid+'" data-rowid="'+rowid+'"  ></a>');
                $(this).empty().append(c);
                c.draggable({
                    revert:true
                });
            }

            

             $('#ajax_response').html("<p class='wpsp-bg-green'>Saving..</p>");
            var cid=$('#class_id').val();
            var tid=$(this).attr('tid');    
            var sessionid=$(this).data('sessionid');    
            var sid=$(source).attr('id');
            var day=$(this).closest('tr').attr('id');
            var deletesid=$('#datavalue').attr('data-sessionid');
            var deleterid=$('#datavalue').attr('data-rowid');
            var ttDetails= [];
            ttDetails.push({name: 'cid' , value: cid });
            ttDetails.push({name: 'sessionid' , value: sessionid });
            ttDetails.push({name: 'tid' , value: tid });
            ttDetails.push({name: 'sid' , value: sid });
            ttDetails.push({name: 'day' , value: day });
            ttDetails.push({name: 'deletesid' , value: deletesid });
            ttDetails.push({name: 'deleterid' , value: deleterid });
            ttDetails.push({name: 'action', value: 'save_timetable'});
            jQuery.post(ajax_url, ttDetails, function(stat1) {
                var arr = stat1.split(',');
                var count = arr.length;
                if(count==2) {
					var classname = arr[0];
					var stat = arr[1];
				} else {
					stat = stat1;
				}
                if(stat=='true' || stat=='updated') {
					if(count==2) {
						$('#ajax_response_exist').html("<p class='wpsp-bg-yellow'> This Teacher also assigned to class </p>"+classname);
					} else {
                        $('#ajax_response_exist').html('');
                    }
					
                    $('#ajax_response').html("<p class='wpsp-bg-green'>Saved..</p>");
                } else {
                    $('#ajax_response').html("<p class='wpsp-bg-red'> Not Saved..</p>");
                }
			});

        }

    });

    

    $('.removesubject').droppable({

        accept:'.assigned',

        onDragEnter:function(e,source){

            $(source).addClass('trash');

        },

        onDragLeave:function(e,source){

            $(source).removeClass('trash');

        },

        onDrop:function(e,source){

            $(source).remove();

        }

    });

    

    $('#print_timetable').click(function() {

        var divToPrint=document.getElementById("timetable_table");

        newWin= window.open("","Timetable Print");

        newWin.document.write('<style>table{border-collapse: collapse;}table,th,td{border: 1px solid black;}td.break{border:0;}tr.break{border:1px solid #000;}</style>');

        newWin.document.write(divToPrint.outerHTML);

        newWin.print();

        newWin.close();

    });

    

    $('.daytype').change(function () {

        if( this.value == 0 ) {

            $('.dayval').show();

            $('.daynam').hide();

        } else {

            $('.daynam').show();

            $('.dayval').hide();

        }

    });



    $('#ClassID').change(function(){

       $('#TimetableClass').submit();

    });

        

    $('.wp-delete-timetable').click(function() {

        if( confirm("Are you sure want to delete class Timetable?") == true ) {

            var tid = $(this).data('id');   

            var data=[];

            data.push({name: 'action', value: 'deletTimetable'},{name: 'cid', value: tid});

            $.ajax({

                type: "POST",

                url: ajax_url,

                data: data,

                beforeSend: function () {

                  //  $.fn.notify('loader', {'desc': 'Deleting image..'});

                },

                success: function (pdata) {

                    if( pdata=='deleted'){
                        $(".wpsp-popup-return-data").html('Time Table Deleted Successfully');
                                $("#SuccessModal").css("display", "block");
                                $("#SavingModal").css("display", "none");
                                $("#SuccessModal").addClass("wpsp-popVisible");

                        //$.fn.notify('success',{'desc':'Time Table Deleted Successfully'});
                            }
                    else{
                        $(".wpsp-popup-return-data").html('Try Again Later');
                                $("#SavingModal").css("display", "none");
                                $("#WarningModal").css("display", "block");
                                $("#WarningModal").addClass("wpsp-popVisible");
                        //$.fn.notify('error',{'desc':'Try Again Later'});
                        }                        

                },

                complete: function () {

                    $('.pnloader').remove();

                }

            })

        }   

    });
    
    $('#wpsp-dd-tt-table').dataTable({
        "paging":   false,
        "ordering": false,
        "searching": false,
        "info":     false  
    });
    

    $('#timetable_table').dataTable({
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




function Popup(data) {

    var mywindow = window.open('', 'Timetable Print', 'height=400,width=600');

    mywindow.document.write(data);

    mywindow.document.close(); // necessary for IE >= 10

    mywindow.focus(); // necessary for IE >= 10

    mywindow.print();

    mywindow.close();

    return true;

}


/* Custom Tab Js */
    $('#verticalTab').easyResponsiveTabs({
    type: 'vertical',
    width: 'auto',
    fit: true
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