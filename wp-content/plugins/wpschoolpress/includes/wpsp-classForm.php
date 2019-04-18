<?php
if (!defined( 'ABSPATH' ) )exit('No Such File');
$ctable=$wpdb->prefix."wpsp_class";
$teacher_table=	$wpdb->prefix."wpsp_teacher";
$teacher_data = $wpdb->get_results("select wp_usr_id,CONCAT_WS(' ', first_name, middle_name, last_name ) AS full_name from $teacher_table order by tid");
$classname	= $classnumber	= $classcapacity = $classlocation = $classstartingdate = $classendingdate= $teacherid = '';
if( isset( $_GET['id']) ) {
	$classid =	intval($_GET['id']);
	$wpsp_classes =$wpdb->get_results("select * from $ctable where cid='$classid'");
		
	foreach ($wpsp_classes as $wpsp_editclass) {
		$classname=$wpsp_editclass->c_name;	
		$classnumber=$wpsp_editclass->c_numb;	
		$classcapacity=$wpsp_editclass->c_capacity;
		$classlocation=$wpsp_editclass->c_loc;
		$classstartingdate=$wpsp_editclass->c_sdate;
		$classendingdate=$wpsp_editclass->c_edate;
		$teacherid=$wpsp_editclass->teacher_id;
	}
}
$label			=	isset( $_GET['id'] ) ? 'Update Class Information' : 'Add Class Information';
$formname		=	isset( $_GET['id'] ) ? 'ClassEditForm' : 'ClassAddForm';
$buttonname	    =	isset( $_GET['id'] ) ? 'Update' : 'Submit';
?>
<!-- This form is used for Add/Update Class -->
<div id="formresponse"></div>
<form name="<?php echo $formname;?>" id="<?php echo $formname; ?>" method="post">			
	<?php if( isset( $_GET['id']) ) { ?>
		<input type="hidden" name="cid" value="<?php echo $classid;?>">
	<?php } ?>
	<div class="wpsp-row">
	<div class="wpsp-col-xs-12">
		<div class="wpsp-card">                    
			<div class="wpsp-card-head">
				<h3 class="wpsp-card-title"><?php echo $label; ?></h3>   
			</div> 
			<div class="wpsp-card-body">
				 <?php wp_nonce_field( 'ClassAction', 'caction_nonce', '', true ) ?>                             
				<div class="wpsp-row"> 
					<div class="wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">
						<div class="wpsp-form-group ">
							<label class="wpsp-label" for="Name">Class Name<span class="wpsp-required"> *</span></label>
							<input type="text" class="wpsp-form-control"  name="Name" placeholder="Class Name" value="<?php echo $classname; ?>">
						</div> 
					</div>
					<div class="wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">
					   <div class="wpsp-form-group">
							<label class="wpsp-label" for="Number">Class Number<span class="wpsp-required"> *</span></label>
							<input type="text" class="wpsp-form-control"  name="Number" placeholder="Class Number" value="<?php echo $classnumber; ?>">
							<input type="hidden"  id="wpsp_locationginal" value="<?php echo admin_url();?>"/>
						</div> 
					</div>
					<div class="wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">
						<div class="wpsp-form-group">
							<label class="wpsp-label" for="Capacity">Class Capacity<span class="wpsp-required"> *</span></label>
							<input type="text" pattern="[0-9]*" class="wpsp-form-control numbers"  name="capacity" placeholder="Class Capacity" id="c_capacity" value="<?php echo $classcapacity; ?>" min="0">
						</div> 
					</div>
					<div class="wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">
						<div class="wpsp-form-group">
						   <label class="wpsp-label" for="Selectteacher">Class Teacher<span> (Incharge)</span></label>
							<select name="ClassTeacherID" class="wpsp-form-control">
								<option value="">Select Teacher </option>
								<?php foreach ($teacher_data as $teacher_list) {
									$teacherlistid= $teacher_list->wp_usr_id;
								?>
									<option value="<?php echo $teacherlistid;?>" <?php if($teacherlistid == $teacherid) echo "selected"; ?> ><?php echo $teacher_list->full_name;?></option>
								<?php } ?>
							</select>
						</div> 
					</div>
					<div class="wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">
						<div class="wpsp-form-group">
							<label class="wpsp-label" for="Starting">Class Starting on<span class="wpsp-required"> *</span></label>
							<input type="text" class="wpsp-form-control select_date wpsp-start-date" name="Sdate" placeholder="Class Starting date" value="<?php echo $classstartingdate; ?>">
						</div> 
					</div>
					<div class="wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">
						<div class="wpsp-form-group">
							<label class="wpsp-label" for="Ending">Class Ending on<span class="wpsp-required"> *</span></label>
							<input type="text" class="wpsp-form-control select_date wpsp-end-date" name="Edate" placeholder="Class Ending date" value="<?php echo $classendingdate; ?>">				
						</div> 
					</div>
					<div class="wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">
						<div class="wpsp-form-group">
								<label class="wpsp-label" for="Location">Class Location</label>
								<input type="text" class="wpsp-form-control" name="Location" placeholder="Class Location" value="<?php echo $classlocation; ?>">
						</div> 
					</div>
					<div class="wpsp-col-xs-12 wpsp-btnsubmit-section">
						<button type="submit" class="wpsp-btn wpsp-btn-success" id="c_submit"><?php echo $buttonname; ?></button>
						<a href="<?php echo wpsp_admin_url();?>sch-class" class="wpsp-btn wpsp-dark-btn" >Back</a>	
					</div>
				</div>
			</div>
		</div>		
	</div>
</div>
</form>
<!-- End of Add/Update New Class Form --> 	