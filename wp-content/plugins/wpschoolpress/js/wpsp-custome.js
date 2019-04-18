/*
	01. Sidebar Drop Down Navigation
	02. Sidebar Scroll 
	03. Dropdown Toggle 
	04. Sidebar mobile slide effect
	05. Date Picker  
	06. Custome Popup 
*/

jQuery(document).ready(function($) {

	
	/*  01. Sidebar Drop Down Navigation  */
    $('.wpsp-navigation li:has(ul)').prepend('<span class="wpsp-droparrow"></span>');
	$('.wpsp-droparrow').click(function() {		
		$(this).siblings('.sub-menu').slideToggle('slow');
		$(this).toggleClass('up');
	}); 
	
	/* 02. Sidebar Scroll */
	$(".sidebarScroll").slimScroll({
		height: "100%",
		//position: "right",
		size: "6px",
		//color: "rgba(0,0,0,0.3)"
	});
	
	 	
	/* 03. Dropdown Toggle*/
	$('.wpsp-dropdown-toggle').click(function() {
//		$('.wpsp-dropdown-toggle').toggleClass('wpsp-dropdown-active');
		//if(!$(this).hasClass('wpsp-dropdown-active')) { 
		//if(!$(this).hasClass('wpsp-dropdown-active')) {
//			alert('test');

        	$(this).toggleClass('wpsp-dropdown-active');
			$(this).siblings('.wpsp-dropdown').slideToggle('slow');
			$(this).parents('.wpsp-dropdownmain').toggleClass('wpsp-dropdown-open');
			
//		}else{
//	alert('new');
//		$('.wpsp-dropdown-toggle').removeClass('wpsp-dropdown-active');
	//	}
    });
	
	
	$(document).mouseup(function (e){
    var container = $(".wpsp-dropdown-open");
    if (!container.is(e.target) && container.has(e.target).length === 0){		
       $('.wpsp-dropdown').fadeOut();
		$('.wpsp-dropdown-toggle').removeClass('wpsp-dropdown-active');
		$('.wpsp-dropdownmain').removeClass('wpsp-dropdown-open');
    }
});

/*	var $dropdown = $('.wpsp-dropdown, .wpsp-dropdown-open');
	$(document).on('click', function (e) {
	   if (!$dropdown.is(e.target) && $dropdown.has(e.target).length === 0)  {
//		$('.wpsp-dropdown').fadeOut();
		$('.wpsp-dropdown-toggle').removeClass('wpsp-dropdown-active');	  
	  }
	});*/

	
	/* 04. Sidebar mobile slide effect */
	$(".wpsp-menuIcon").click(function() {
        $(this).toggleClass("wpsp-close"), $(".wpsp-sidebar").toggleClass("wpsp-slideMenu"), $("body").toggleClass("wpsp-bodyFix");
    });
	$(".wpsp-overlay").click(function() {
		$('.wpsp-menuIcon').removeClass("wpsp-close"), $(".wpsp-sidebar").removeClass("wpsp-slideMenu"), $(".wpsp-bodyFix").removeClass("wpsp-bodyFix");			
	}); 


	/* 05. Date Picker */
	  $("#datetimepicker1").datepicker({ 
	        autoclose: true, 
	        todayHighlight: true
	  }).datepicker('update', new Date());


	/* 06. Custome Popup */
	$('.wpsp-popclick').off('click'); 
	$(document).ready(function(){
		 $('body').on('click', '.wpsp-popclick', function () {	
			var linkAttrib = $(this).attr('data-pop');
			$('#' + linkAttrib).addClass("wpsp-popVisible");
			$('body').addClass('wpsp-bodyFixed')
		});

	})
	
	
	$('.wpsp-closePopup, .wpsp-popup-cancel, .wpsp-overlayer').click(function() {				
		$('body').removeClass('wpsp-bodyFixed');
		$("#SavingModal").css("display", "none");
		$("#WarningModal").css("display", "none");
		$("#SuccessModal").css("display", "none");
		$("#DeleteModal").css("display", "none");
		$('.wpsp-popupMain').removeClass("wpsp-popVisible");
	});

	$('input[type=file]').change(function() {
            var val = this.value,
            filename = val.split('\\').pop();
            $(this).closest('.wpsp-btn-file').next('.text').text(filename);
    });

	$('.wpsp-closeLoading, .wpsp-preLoading-onsubmit').click(function() {			
		$('.wpsp-preLoading-onsubmit').css('display', 'none');
	});
	
	
	$(window).load(function() {
			$('.wpsp-preLoading').fadeOut(); 
	})
});