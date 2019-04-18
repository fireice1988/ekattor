<?php 
if (!defined( 'ABSPATH' ) )exit('No Such File');
$subjectclassid =	intval($_GET['classid']);
$teacher_table=	$wpdb->prefix."wpsp_teacher";
$teacher_data = $wpdb->get_results("select * from $teacher_table");
$class_table	=	$wpdb->prefix."wpsp_class";
$classQuery		=	$wpdb->get_results("select * from $class_table where cid='$subjectclassid'");
foreach($classQuery as $classdata){
	$cid= intval($classdata->cid);
}
?>
<!-- This form is used for Add New Subject Form -->
<div class="formresponse"></div>
<form name="SubjectEntryForm" action="#" id="SubjectEntryForm" method="post">
		<div class="wpsp-card">                    
				<div class="wpsp-card-head">
					<div class="wpsp-row">
						<div class="wpsp-col-xs-12">
						 <h3 class="wpsp-card-title">New Subject Entry</h3>						 
						</div>
					</div>
				</div>  
					
				<input type="hidden"  id="wpsp_locationginal1" value="<?php echo admin_url();?>"/>
				<div class="wpsp-card-body">
					<div class="wpsp-row">
					<div class="wpsp-col-md-12 line_box">	
						<?php wp_nonce_field( 'SubjectRegister', 'subregister_nonce', '', true ); ?>
						<div class="wpsp-row">
						<div class="wpsp-col-lg-12 wpsp-col-md-12 wpsp-col-sm-12 wpsp-col-xs-12">
							<div class="wpsp-form-group">
								<label class="wpsp-label" for="Name">Class 
									<span class="wpsp-required"> *</span> </label>
								<select name="SCID" id="SCID" class="wpsp-form-control" required>
								<option value="" ><?php echo "Please Select Class"?></option>
								<?php											
								foreach($sel_class as $classes) { ?>
									<option value="<?php echo intval($classes->cid);?>" <?php if($sel_classid==$classes->cid) echo "selected"; ?>><?php echo $classes->c_name;?></option>
								<?php } ?>
									
							</select>
							<!-- <?php foreach($classQuery as $classdata){
								$cid= $classdata->cid; ?>
								<label class="wpsp-labelMain" for="Name">Class Name : <?php if($cid == $subjectclassid) echo $classdata->c_name;?></label>

									<input type="hidden" class="wpsp-form-control" id="SCID" name="SCID" value="<?php if($cid == $subjectclassid) echo $classdata->cid;?>">
								<?php } ?> -->
							</div>	
						</div>
						</div>
						<?php for($i=1;$i<=5;$i++){?>
						<div class="wpsp-row">
								<div class="wpsp-col-lg-3 wpsp-col-md-6 wpsp-col-sm-6 wpsp-col-xs-12">
									<div class="wpsp-form-group">
									<label class="wpsp-label" for="Name">Subject <?php echo $i;?><?php if($i=='1') { ?>
									<span class="wpsp-required"> *</span> </label>
									<?php } ?>
									<input type="text" class="wpsp-form-control" name="SNames[]" placeholder="Subject Name">
									</div>
								</div>
								
								<div class="wpsp-col-lg-3 wpsp-col-md-6 wpsp-col-sm-6 wpsp-col-xs-12">
									<div class="wpsp-form-group">
										<label class="wpsp-label" for="Name">Subject Code</label>
										<input type="text" class="wpsp-form-control" name="SCodes[]" placeholder="Subject Code">
									</div>
								</div>
								<div class="wpsp-col-lg-3 wpsp-col-md-6 wpsp-col-sm-6 wpsp-col-xs-12">
									<div class="wpsp-form-group">
									<label class="wpsp-label" for="Name">Subject Teacher<span> (Incharge)</span></label>
									<select name="STeacherID[]" class="wpsp-form-control">
										<option value="">Select Teacher </option>
											<?php 
											foreach ($teacher_data as $teacher_list) { 
												$teacherlistid= $teacher_list->wp_usr_id;?>		
												<option value="<?php echo $teacherlistid;?>" ><?php echo $teacher_list->first_name ." ". $teacher_list->last_name;?></option>
												<?php
											}
											?>
									</select>
									</div>
								</div>
								<div class="wpsp-col-lg-3 wpsp-col-md-6 wpsp-col-sm-6 wpsp-col-xs-12">
									<div class="wpsp-form-group">
										<label class="wpsp-label" for="BName">Book Name</label>
										<input type="text" class="wpsp-form-control" name="BNames[]" placeholder="Book Name">
									</div>
								</div>
								<?php if($i!='5') { ?>
								<hr style="border-top:1px solid #5C779E"/>
								<?php }?>	
							
						</div>		
						<?php } ?>											
					</div>
					<div class="wpsp-col-md-12">
						<button type="submit" class="wpsp-btn wpsp-btn-success" id="s_submit">Submit</button> 
						 <a href="<?php echo wpsp_admin_url();?>sch-subject" class="wpsp-btn wpsp-dark-btn" >Back</a>
					</div>
				</div>
			</div>				
		</div>
</form>
<!-- End of Add Subject Form -->