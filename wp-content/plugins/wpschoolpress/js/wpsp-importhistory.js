$(document).ready(function(){
	$('#import').dataTable({
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
				
	$(document).on('click','.undoimport',function(){			
		var id = $(this).attr('value');	
		var data=new Array();
		data.push({name:'id',value:id},{name:'action',value:'undoImport'});
		$.ajax({
			type: "POST",
			url: ajax_url,	
			data:data,
			beforeSend:function(){
				$.fn.notify('loader',{'desc':'Removing rows!'});
			},
			success: function(res) {
			   $.fn.notify('success',{'desc':'Rows removed successfully'});
			   //location.reload();
			},
			complete:function(){
				$('.pnloader').remove();
			}
		});
	});               
			
});