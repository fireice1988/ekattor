<?php
if (!defined( 'ABSPATH' ) )exit('No Such File');
wpsp_header(); ?>
<?php
	if( is_user_logged_in() ) {
		global $current_user, $wpdb;
		$current_user_role=$current_user->roles[0];
		wpsp_topbar(); 
		wpsp_sidebar();
		wpsp_body_start();
		if($current_user_role=='administrator' || $current_user_role=='teacher')
		{
		?>	
		<div class="wpsp-card">
		<div class="wpsp-card-head">                    
            <h3 class="wpsp-card-title">Event calendar </h3>            
        </div>
         <div class="wpsp-card-body">							
			<div id="calendar"></div>
		<div class="wpsp-popupMain" id="eventPop">
		  <div class="wpsp-overlayer"></div> 
		  <div class="wpsp-popBody"> 		   
		    <div class="wpsp-popInner">		    	
		    	<a href="javascript:;" class="wpsp-closePopup"></a>
		    	<div class="wpsp-popup-body">
		    		<div class="wpsp-panel-heading">
						<h3 class="wpsp-panel-title">Add Event</h3>
					</div>
		    		<div class="wpsp-popup-cont">
		    		<div id="response"></div>
					
						<form name="calevent_entry" method="post" class="form-horizontal" id="calevent_entry">
							<div class="wpsp-col-sm-6 wpsp-col-xs-12">   
								<div class="wpsp-form-group">
									<label class="wpsp-label">Start Date <span class="wpsp-required">*</span></label>
									<input type="hidden"  id="wpsp_locationginal" value="<?php echo admin_url();?>"/>
									<input type="text" name="sdate" class="wpsp-form-control sdate" id="sdate">
								</div>
							</div>
							<div class="wpsp-col-sm-6">
								<div class="wpsp-form-group">
									<label class="wpsp-label">Start Time <span class="wpsp-required">*</span></label>
									<input type="text" name="stime" class="wpsp-form-control stime" id="stime">
								</div>
							</div>							
							<div class="wpsp-col-sm-6">
								<div class="wpsp-form-group">
									<label class="wpsp-label">End Date <span class="wpsp-required">*</span></label>
									<input type="text" name="edate" class="wpsp-form-control edate" id="edate">
								</div>
							</div>
							
							<div class="wpsp-col-sm-6">
								<div class="wpsp-form-group">
									<label class="wpsp-label">End Time <span class="wpsp-required">*</span></label>
									<input type="text" name="etime" class="wpsp-form-control etime" id="etime">
								</div>
							</div>
							<div class="wpsp-col-sm-12">
								<div class="wpsp-form-group">
									<label class="wpsp-label">Title *</label>
									<input type="text" name="evtitle" class="wpsp-form-control" id="evtitle">
								</div>
							</div>
							<div class="wpsp-col-sm-12">
								<div class="wpsp-form-group">
									<label class="wpsp-label">Description</label>
									<textarea name="evdesc" class="wpsp-form-control" id="evdesc"></textarea>
								</div>
							</div>
							<div class="wpsp-col-sm-6"> 
								<div class="wpsp-form-group">
								<label class="wpsp-label">Type</label>
									<select class="wpsp-form-control" id="evtype" name="evtype">
										<option value="0">External(Show to all)</option>
										<option value="1">Internal(Show to teachers only)</option>
									</select>
									<input type="hidden" name="evid" class="wpsp-form-control" id="evid">
								</div>
							</div>
							<div class="wpsp-col-sm-6"> 
								<div class="wpsp-form-group">
									<label class="wpsp-label">Color</label>
									<select name="evcolor" class="wpsp-form-control" id="evcolor">
										<option class="bg-blue" value="">Default</option>
										<!-- <option class="bg-red" value="#f56954">Red</option>
										<option class="bg-green" value="#00a65a">Green</option>
										<option  class="bg-purple" value="#932ab6">Purple</option>
										<option class="bg-orange" value="#ff851b">Orange</option> -->
									</select>
								</div>
							</div>
						</form>
						<div class="wpsp-col-sm-12">
							<button type="button" id="calevent_save" class="wpsp-btn wpsp-btn-success">Save </button>
							<button type="button" class="wpsp-btn wpsp-dark-btn" data-dismiss="modal" >Cancel</button>							
						</div>
						</div>
					</div>
					</div>
				</div> 
		    </div>

		     <!-- popup -->
		    <div class="wpsp-popupMain" id="editeventPop">
			  <div class="wpsp-overlayer"></div>
			  <div class="wpsp-popBody">  		   
			    <div class="wpsp-popInner">		    	
			    		<a href="javascript:;" class="wpsp-closePopup"></a>
						<div class="wpsp-popup-body">
			    		<div class="wpsp-panel-heading">
							<h3 class="wpsp-panel-title" id="viewEventTitle"></h3>
						</div>
			    		<div class="wpsp-popup-cont">		    		
			    		<div class="wpsp-col-md-6">
			    			<div class="wpsp-form-group">
								<label class="wpsp-labelMain">Start : </label> <span id="eventStart"> </span>
							</div>
						</div>
						<div class="wpsp-col-md-6">
							<div class="wpsp-form-group">
								<label class="wpsp-labelMain">End : </label> <span id="eventEnd"> </span>
							</div>
						</div>
						<div class="wpsp-col-md-12">
							<div class="wpsp-form-group">
							<label>Description : </label> <span id="eventDesc"> </span>
							</div>
						</div>
						<?php if($current_user_role=='administrator'){?>
						<div class="wpsp-col-md-12">
							<button class="wpsp-btn wpsp-btn-success" id="editEvent">Edit Event</button>
							<button class="wpsp-btn wpsp-btn-danger" id="deleteEvent">Delete</button>
							<button type="button" class="wpsp-btn wpsp-dark-btn" data-dismiss="modal">Cancel</button>
						</div>
					<?php }?>
			    	</div>
			    </div>
			</div>
			</div>		
		</div>
		     <!-- popup-end -->
		  </div>
		</div>	
			
		<?php  }else if($current_user_role=='parent' || $current_user_role='student'){ ?>
		<div class="wpsp-card">
			<div class="wpsp-card-head">                    
        		<h3 class="wpsp-card-title">Event calendar</h3>         		
    		</div>
			<div class="wpsp-card-body">
				<div id="calendar"></div>
		<div class="wpsp-popupMain" id="editeventPop">
		  <div class="wpsp-overlayer"></div> 
		  <div class="wpsp-popBody"> 		  
		    <div class="wpsp-popInner">		    
		    		<a href="javascript:;" class="wpsp-closePopup"></a>
		    		<div class="wpsp-popBody"> 
		    		<div class="wpsp-panel-heading">
						<h3 class="wpsp-panel-title" id="viewEventTitle"></h3>
					</div>
		    			<div class="wpsp-popup-cont">		    			
		    			<div class="col-md-6">
		    				<div class="wpsp-form-group">
									<label class="wpsp-labelMain">Start : </label> <span id="eventStart"> </span>
							</div>
						</div>
							<div class="col-md-6">
								<div class="wpsp-form-group">
									<label class="wpsp-labelMain">End : </label> <span id="eventEnd"> </span>
								</div>
							</div>
							<div class="col-md-12">
								<div class="wpsp-form-group">
									<label>Description : </label> <span id="eventDesc"> </span>
								</div>					
							</div>
		    	</div>
		    </div>
		</div>
		</div>
		</div>
		</div>
		</div>
	<?php }
		wpsp_body_end();
		wpsp_footer();
	}
	else{
		//Include Login Section
		include_once( WPSP_PLUGIN_PATH .'/includes/wpsp-login.php');
	}
?>