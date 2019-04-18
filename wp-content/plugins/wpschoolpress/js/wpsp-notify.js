$(document).ready(function() {		
	$('#notify_table').dataTable({
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
		
	/*Delete Attendance*/  	
	$(document).on('click','.notify-Delete',function(){
			if(confirm("Are you want to delete this entry?")){
			var aid=$(this).attr('data-id');
			if( aid == '' ) {
				$.fn.notify('error',{'desc':'Notification information Missing!'});
			}else{
				var data=[];
				data.push({name: 'action', value: 'deleteNotify'},{name: 'notifyid', value: aid});
				$.ajax({
					type: "POST",
					url: ajax_url,
					data: data,
					beforeSend:function () {
						$.fn.notify('loader',{'desc':'Deleting entry..'});
					},
					success: function(res) {
						$.fn.notify('success',{'desc':'Notification entry deleted successfully..'});
						$( this ).closest( 'tr' ).remove();
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
	/* View Notification */
	$(document).on('click','.notify-view',function() {
		var cid=$(this).attr('data-id');
		if($.isNumeric(cid)){
			var data=[];
			data.push({name: 'action', value: 'getNotify'},{name: 'notifyid', value: cid});
			$.ajax({
				type: "POST",
				url: ajax_url,
				data: data,
				beforeSend:function () {
					$.fn.notify('loader',{'desc':'Loading Notification..'});
				},
				success: function(res) {
					$('#ViewModalContent').html(res);
					$(this).click();
				},
				error:function(){
					$.fn.notify('error',{'desc':'Something went wrong. Try after refreshing page..'});
				},
				complete:function () {
					$('.pnloader').remove();
				}
			});		
		}else{
			$.fn.notify('error',{'desc':"Notification ID Missing.."});
		}
	});
	
	$(document).on('click','#notifySubmit',function() {		
		$("#NotifyEntryForm").validate({
			rules: {				
				subject: {
					required: true,
					minlength: 10
				},
				receiver: "required",
				type: "required"
			},			
			submitHandler: function(form){
				$('#notifySubmit').submit();
			}
		}); 
	});

});