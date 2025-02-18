<?php if (!defined( 'ABSPATH' ) )
exit('No Such File');	
$subjectid=intval($_GET['id']);	
$teacher_table=	$wpdb->prefix."wpsp_teacher";
$classnumber =	$wpdb->prefix."wpsp_class";
$teacher_data = $wpdb->get_results("select * from $teacher_table");	
$subtable=$wpdb->prefix."wpsp_subject";	
$wpsp_subjects =$wpdb->get_results("select * from $subtable where id='$subjectid'");	
foreach ($wpsp_subjects as $subject_data) {		
	$subid = $subject_data->id;		
	$classid = $subject_data->class_id;		
	$subname = $subject_data->sub_name;		
	$subcode = $subject_data->sub_code;		
	$subteacherid = $subject_data->sub_teach_id;		
	$subbookname = $subject_data->book_name;	
}
?>
<!-- This form is used for Edit Subject Details -->
<div class="formresponse"></div>
<form action="" name="SubjectEditForm"  id="SEditForm" method="post">	
	<div class="wpsp-col-xs-12">		
		<div class="wpsp-card">                    			
			<div class="wpsp-card-head">				 
				<h3 class="wpsp-card-title">Edit Subject Details</h3>				 				
			</div>	
			<div class="wpsp-card-body">				
				<div class="wpsp-col-md-12 line_box">					
					<div class="wpsp-row">
			<?php $wpsp_class =$wpdb->get_results("select c_name from $classnumber where cid='$classid'");


					?>	
					<label class="wpsp-labelMain" for="Name">Class Name : <?php echo $wpsp_class[0]->c_name;?></label>
				</div></div></div>
			<input type="hidden" name="cid" value="<?php echo $subid;?>">			
			<div class="wpsp-card-body">				
				<div class="wpsp-col-md-12 line_box">					
					<div class="wpsp-row">						
						<div class="wpsp-col-lg-3 wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">							
							<div class="wpsp-form-group">								
								<label class="wpsp-label" for="Name">Subject <span class="wpsp-required"> *</span></label>
								<input type="text"   class="wpsp-form-control" ID="EditSName" name="EditSName" placeholder="Subject Name" value="<?php echo $subname;?>">								
								<input type="hidden" class="wpsp-form-control" value="<?php echo $subid;?>" id="SRowID" name="SRowID">								
								<input type="hidden" class="wpsp-form-control" value="" id="ESClassID" name="ClassID">
								<input type="hidden" id="wpsp_locationginal1" value="<?php echo admin_url();?>"/>		
							</div>						
						</div>							
						<div class="wpsp-col-lg-3 wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">							
							<div class="wpsp-form-group">								
								<label class="wpsp-label" for="Name">Subject Code</label>								
								<input type="text" class="wpsp-form-control" ID="EditSCode" name="EditSCode" placeholder="Subject Code" value="<?php echo $subcode;?>">							</div>			
							</div>						
							<div class="wpsp-col-lg-3 wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">							<div class="wpsp-form-group">								
								<label class="wpsp-label" for="Name">Subject Teacher<span> (Incharge)</span></label>	
								<select name="EditSTeacherID" id="EditSTeacherID" class="wpsp-form-control">			
									<option value="">Select Teacher </option>									
									<?php foreach ($teacher_data as $teacher_list) { 										$teacherlistid= $teacher_list->wp_usr_id;?>										<option value="<?php echo $teacherlistid;?>" 
										<?php if($teacherlistid == $subteacherid) echo "selected"; ?> >
										<?php echo $teacher_list->first_name ." ". $teacher_list->last_name;?>
											
										</option>									
										<?php } ?>								
									</select>							
								</div>							
							</div>						
							<div class="wpsp-col-lg-3 wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">							<div class="wpsp-form-group">								
								<label class="wpsp-label" for="BName">Book Name</label>								
								<input type="text" class="wpsp-form-control" name="EditBName" id="EditBName" placeholder="Book Name" value="<?php echo $subbookname;?>">							
							</div>						
						</div>					
					</div>				
				</div>				
				<div class="wpsp-col-md-12">					
					<input type="submit" id="SEditSave" class="wpsp-btn wpsp-btn-success" value="Update">					<a href="<?php echo wpsp_admin_url();?>sch-subject" class="wpsp-btn wpsp-dark-btn" >Back</a>	
				</div>			
			</div>		
		</div>	
	</div>
</form><!-- End of Edit Subject Details Form --> 			