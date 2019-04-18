<?php if(!defined('ABSPATH')) exit;
$extable = $wpdb->prefix."wpsp_exam";
$examname = $examsdate = $examedate = $classid = $examid = '';
$subjectid = array();

if(isset($_GET['id'])){	
	$examid = intval($_GET['id']);	
	$wpsp_exams = $wpdb->get_results( "select * from $extable where eid='$examid'");	
	foreach($wpsp_exams as $examdata){		
	 $classid = $examdata->classid;		
	$examname = $examdata->e_name;		
	$examsdate = $examdata->e_s_date;		
	$examedate = $examdata->e_e_date;		
	$subjectid = explode( ",",$examdata->subject_id);	
	}
}$label = isset($_GET['id']) ? 'Update Exam Information' : 'Add Exam Information';
$formname = isset($_GET['id']) ? 'ExamEditForm' : 'ExamEntryForm';
$buttonname = isset($_GET['id']) ? 'Update' : 'Submit';
?>
<!-- This form is used for Add/Update New Exam Information -->
<div id="formresponse"></div>
<form name="
	<?php echo $formname;?>" action="#" 
	id="<?php echo $formname;?>" method="post">
	<div class="wpsp-row">
	<div class="wpsp-col-xs-12">
		<div class="wpsp-card">
			<div class="wpsp-card-head">
				<h3 class="wpsp-card-title">
					<?php echo $label; ?>
				</h3>				
			</div> 
			<div class="wpsp-card-body">
				<div class="wpsp-row">
					<div class="wpsp-col-lg-4 wpsp-col-md-6 wpsp-col-sm-6 wpsp-col-xs-12">
						<div class="wpsp-form-group">
							<input type="hidden"  id="wpsp_locationginal" value="<?php echo admin_url();?>"/>
								<label class="wpsp-label" for="Name">Class Name 
									<span class="wpsp-required">*</span>
									<?php if($current_user_role=='teacher') {} else {?>
								</label>
							<?php }?>
								<?php								
								$classQuery	=	"select cid,c_name from $ctable";							
								if($current_user_role=='teacher') {									
								$cuserId		=	intval($current_user->ID);								
								$classQuery		=	"select cid,c_name from $ctable where teacher_id=$cuserId";	
								}
								$wpsp_classes 	=	$wpdb->get_results( $classQuery );
								
								if($current_user_role=='teacher') {
								echo ' : '.$wpsp_classes[0]->c_name;
								echo '<input type="hidden" name="class_name" id="class_name" value="'.$wpsp_classes[0]->cid.'">';
								echo '</label>';
										} 		
								else {	?>
									<select name="class_name" id="class_name" class="wpsp-form-control">
										<option value="">Select Class</option>
										<?php	foreach($wpsp_classes as $value) {
											$classlistid = intval($value->cid);?>
										<option value="<?php echo intval($value->cid);?>" 
											<?php if($classlistid == $classid) echo "selected"; ?>>
											<?php echo $value->c_name;?>
										</option>
										<?php }	?>
									</select>
									<?php } ?>
								</div>
							</div>
							<div class="wpsp-col-lg-4 wpsp-col-md-6 wpsp-col-sm-6 wpsp-col-xs-12">
								<div class="wpsp-form-group">
									<label class="wpsp-label" for="Name">Exam Name 
										<span class="wpsp-required">*</span>
									</label>
									<input type="text" class="wpsp-form-control" ID="ExName" name="ExName" placeholder="Exam Name" value="<?php echo $examname; ?>">
									</div>
								</div>
								<div class="wpsp-col-lg-4 wpsp-col-md-6 wpsp-col-sm-6 wpsp-col-xs-12">
									<div class="wpsp-form-group">
										<label class="wpsp-label" for="Name">Exam Start Date 
											<span class="wpsp-required">*</span>
										</label>
										<input type="text" class="wpsp-form-control hasDatepicker" ID="ExStart" name="ExStart" placeholder="Exam Start date" value="<?php echo $examsdate; ?>">
										</div>
									</div>
									<div class="wpsp-col-lg-4 wpsp-col-md-6 wpsp-col-sm-6 wpsp-col-xs-12">
										<div class="wpsp-form-group">
											<label class="wpsp-label" for="Name">Exam End Date 
												<span class="wpsp-required">*</span>
											</label>
											<input type="text" class="wpsp-form-control ExEnd hasDatepicker" ID="ExEnd" name="ExEnd" placeholder="Exam End date" value="<?php echo $examedate; ?>">
											</div>
										</div>
										<div class="wpsp-col-lg-8 wpsp-col-md-12 wpsp-col-sm-12 wpsp-col-xs-12">
											<div class="wpsp-form-group exam-subject-list">
												<label class="wpsp-label" for="Name">Subject Name </label>
												<input type="checkbox" name="subjectall" value="All" class="exam-all-subjects wpsp-checkbox" id="all">
													<label for="all" class="wpsp-checkbox-label">All</label>
													<div class="exam-class-list">
														<?php $sub_table = $wpdb->prefix."wpsp_subject";
														if($current_user_role=='teacher') {
															$classid = $wpsp_classes[0]->cid;
														}									
														if(!empty($classid)){											
															$subjectlist	=	$wpdb->get_results("select sub_name,id from $sub_table where class_id=$classid");
															foreach($subjectlist as $svalue){ ?>
														<input type="checkbox" name="subjectid[]" value="<?php echo $svalue->id; ?>" class="exam-subjects wpsp-checkbox" id="subject-<?php echo $svalue->id;?>"
															<?php if(in_array($svalue->id, $subjectid)){ ?> checked 
															<?php } ?> >
															<label for="subject-<?php echo $svalue->id;?>" class="wpsp-checkbox-label">
																<?php echo $svalue->sub_name;?>
															</label>
															<?php											} } ?>
														</div>
													</div>
										</div>
									</div>
											<?php if(!empty($examid)){ ?>
											<input type="hidden" ID="ExamID" name="ExamID" value="<?php echo $examid; ?>">
											<?php } ?>
												<div class="wpsp-row">
													<div class="wpsp-col-xs-12">
														<button type="submit" class="wpsp-btn wpsp-btn-success" id="e_submit">
															<?php echo $buttonname; ?>
														</button>
														<a href="<?php echo wpsp_admin_url();?>sch-exams" class="wpsp-btn wpsp-dark-btn" >Back
														</a>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								</form>
								<!-- End of Add/Update Exam Form -->