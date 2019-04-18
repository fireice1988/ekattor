<?php
if (!defined( 'ABSPATH' ) )exit('No Such File');
wpsp_header();
	if( is_user_logged_in() ) {
		global $current_user, $wpdb;
		$current_user_role=$current_user->roles[0];
		if( $current_user_role=='administrator' || $current_user_role=='teacher' ) {
			wpsp_topbar();
			wpsp_sidebar();
			wpsp_body_start();
			$class_id		=	$subject_id	=	$exam_id=0;
			$proversion		=	wpsp_check_pro_version();
			$proclass		=	!$proversion['status'] && isset( $proversion['class'] )? $proversion['class'] : '';
			$protitle		=	!$proversion['status'] && isset( $proversion['message'] )? $proversion['message']	: '';
			$prodisable		=	!$proversion['status'] ? 'disabled="disabled"'	: '';			
			if(	isset(  $_POST['MarkAction']  ) ){
				$class_id	=	intval($_POST['ClassID']);
				$subject_id	=	intval($_POST['SubjectID']);
				$exam_id	=	intval($_POST['ExamID']);
			}
			$ctname		=	$wpdb->prefix.'wpsp_class';
			$classQuery	=	"select `cid`,`c_name` from `$ctname`";
			$msg		=	'Please Add Class Before Adding Marks';
			if( $current_user_role=='teacher' ) {
				$cuserId	=	intval($current_user->ID);
				//$classQuery	=	"select cid,c_name from $ctname where teacher_id=$cuserId";
				$classQuery	=	"SELECT DISTINCT c.cid,c.c_name FROM wp_wpsp_class c
								INNER JOIN wp_wpsp_subject s ON s.class_id= c.cid
								WHERE s.sub_teach_id =$cuserId";
				$msg		=	'Please Ask Principal To Assign Class';
			}
			$clt	=	$wpdb->get_results( $classQuery );
		?>
		<?php 						$wpsp_settings_table	=	$wpdb->prefix."wpsp_settings";
							$wpsp_settings_edit		=	$wpdb->get_results("SELECT * FROM $wpsp_settings_table" );	
							foreach( $wpsp_settings_edit as $sdat ) {
									$settings_data[$sdat->option_name]	=	$sdat->option_value;
									
								} 
?>
			<div class="wpsp-card">
				<div class="wpsp-card-head">                    
                    <h3 class="wpsp-card-title">Students Marks</h3>                    
                </div>
                 <div class="wpsp-card-body">	                 	
						<?php if( empty( $clt ) ) {
							echo '<div class="wpsp-text-red col-lg-2">'.$msg.'</div>';
						} else { ?>
						<form class="wpsp-form-horizontal" id="MarkForm" action="" method="post" enctype="multipart/form-data">
							<div class="wpsp-row">
							<div class="wpsp-col-lg-3 wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">
								<div class="wpsp-form-group">
									<label class="wpsp-label"><?php _e( 'Class', 'WPSchoolPress' ); ?></label>  
										<select name="ClassID"  id="ClassID" class="wpsp-form-control" required>
											<option value=""><?php _e( 'Select Class', 'WPSchoolPress' ); ?> </option>
											<?php foreach( $clt as $cnm ) { ?>
													<option value="<?php echo intval($cnm->cid);?>" <?php if($cnm->cid==$class_id) echo "selected";?>><?php echo $cnm->c_name;?></option>
											<?php }	?>
										</select>
								</div>
							</div>
							<div class="wpsp-col-lg-3 wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">
								<div class="wpsp-form-group">
								<label class="wpsp-label"><?php _e( 'Exam', 'WPSchoolPress'); ?></label>
									<select name="ExamID" class="wpsp-form-control" id="ExamID" required>
										<?php
										if( $exam_id > 0 ) {
											$examtable	=	$wpdb->prefix.'wpsp_exam';
											$examlist	=	$wpdb->get_results("select eid,e_name from $examtable where classid=$class_id");													
											foreach( $examlist as $exam ) { ?>
												<option value="<?php echo intval($exam->eid);?>" <?php if($exam->eid==$exam_id) echo "selected";?>><?php echo $exam->e_name;?></option>
											<?php }
										} else { ?>
											<option value=""><?php _e( 'Select Exam', 'WPSchoolPress' ); ?> </option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="wpsp-col-lg-3 wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">
								<div class="wpsp-form-group">
								<label class="wpsp-label"><?php _e( 'Subject', 'WPSchoolPress'); ?> </label>
									<?php
									$examtable	=	$wpdb->prefix.'wpsp_exam';	
									if( $exam_id!= '' ) {	
										$subjectID		=	$wpdb->get_var("select subject_id from $examtable where eid=$exam_id");
										$subjectlist	=	explode( ",", $subjectID );	
									}?>
										<select name="SubjectID"  id="SubjectID" class="wpsp-form-control" required>
										<?php if( $subject_id>0 ) {												
											$sub_tbl	=	$wpdb->prefix."wpsp_subject";
											$subInfo	=	$wpdb->get_results("select sub_name,id from $sub_tbl where class_id=$class_id");
											foreach( $subInfo as $sub_list ) {
												if( in_array( $sub_list->id, $subjectlist ) ) {
													echo "<option value='".$sub_list->id."'". selected( $subject_id, $sub_list->id, false ).">".$sub_list->sub_name."</option>";
												}
											}
										} else { ?>
											<option value=""><?php _e( 'Select Subject', 'WPSchoolPress' ); ?></option>
										<?php } ?>
										</select>
								</div>
							</div>	 
							<div class="wpsp-col-lg-3 wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12 <?php echo $proclass;?>" title="<?php echo $protitle;?>" <?php echo $prodisable; ?>>
								<div class="wpsp-form-group">
									<label class="wpsp-label"><?php _e( 'Attach CSV', 'WPSchoolPress'); ?></label>
									<span wpsp-tooltip="<?php echo $protitle; ?>">
										<div class="wpsp-btn wpsp-btn-file" <?php echo $prodisable; ?>> 
										<span><i class="fa fa-file-text-o"></i> Attach CSV file</span>						
										<input type="file" name="MarkCSV" class="<?php echo $proclass;?> wpsp-form-control" title="<?php echo $protitle;?>" <?php echo $prodisable; ?>> 
										</div>
									</span>
									<span class="text"></span>
											<!-- <input class="wpsp-input-file" name="importcsv" id="importcsv" type="file"> -->
											 <!-- <label tabindex="0" for="my-file" class="wpsp-input-file-trigger"><i class="fa fa-file-text-o"></i> Attach CSV file</label> -->
								<!-- <label class="wpsp-label"><?php _e( 'Attach CSV', 'WPSchoolPress'); ?></label> -->
									<!-- <input type="file" name="MarkCSV" class="<?php echo $proclass;?>" title="<?php echo $protitle;?>" <?php echo $prodisable; ?>> -->									
								</div>
							</div>
														
							<div class="wpsp-col-sm-8">
								<div class="wpsp-form-group">
									<button type="submit" class="wpsp-btn wpsp-btn-success MarkAction update-btn" name="MarkAction"  value="Add Marks"><?php _e( 'Add/Update', 'WPSchoolPress'); ?> </button>
									<span wpsp-tooltip="<?php echo $protitle; ?>">
									<button type="submit" name="MarkAction" class="wpsp-btn wpsp-dark-btn update-btn MarkAction <?php echo $proclass;?>" <?php echo $prodisable; ?> value="ImportCSV"><?php _e( 'Upload CSV', 'WPSchoolPress'); ?></button>
									</span>
									<button name="MarkAction" class="wpsp-btn wpsp-btn-primary update-btn" id="viewmarks" value="View Marks"><?php _e( 'View Marks', 'WPSchoolPress'); ?> </button>
								</div>
							</div>	
							</div>								
						</form>					
						<?php
					// 	if(isset($_POST['MarkAction']) && sanitize_text_field($_POST['MarkAction'])=='ImportCSV'){

					// 	die('aaaaa');
					// }

							if(isset($_POST['MarkAction']) && sanitize_text_field($_POST['MarkAction'])=='Add Marks'){							
								
								$mark_entered	=	'';
								//Get Extra Fields
								$extra_tbl		=	$wpdb->prefix."wpsp_mark_fields";
								$extra_fields	=	$wpdb->get_results("select * from $extra_tbl where subject_id='$subject_id'");
								if( wpsp_IsMarkEntered( $class_id,$subject_id,$exam_id ) ) {
									$wpsp_marks		=	wpsp_GetMarks($class_id,$subject_id,$exam_id);
									$mark_entered	=	1;
									$wpsp_exmarks	=	wpsp_GetExMarks($subject_id,$exam_id);
									foreach($wpsp_exmarks as $exmark){
										$extra_marks[$exmark->student_id][$exmark->field_id]=$exmark->mark;
									}
								}
							?>
							<div id="mark_entry" class="col-md-12 col-lg-12 col-sm-12">
								<?php if( $mark_entered ==1 ) {	?>
									<h3 class="wpsp-card-title"><?php _e( 'Marks Already Entered update here!', 'WPSchoolPress'); ?></h3><br/>
								<?php } else {	?>
									<h3 class="wpsp-card-title"><?php _e( 'Enter Marks', 'WPSchoolPress'); ?></h3>
								<?php }	?>
								<div class="">
									<form class="form-horizontal group-border-dashed" id="AddMarkForm" action="" style="border-radius: 0px;" method="post">
										<input class="form-control" type="hidden" value="<?php echo intval($subject_id);?>" name="SubjectID">  
										<input class="form-control" type="hidden" value="<?php echo intval($class_id);?>" name="ClassID">  
										<input class="form-control" type="hidden" value="<?php echo intval($exam_id);?>" name="ExamID">  
										<table class="wpsp-table" cellspacing="0" width="100%" style="width: 100%;">
											<thead>
												<tr>													
													<th><?php _e( 'RollNo.', 'WPSchoolPress'); ?></th>
													<th><?php _e( 'Name', 'WPSchoolPress' ); ?></th>
													<!-- <th><?php _e( 'Mark', 'WPSchoolPress' );?></th> -->
													<?php  if($settings_data['markstype'] == "Number") 
										{?>
										<th><?php _e( 'Marks', 'WPSchoolPress' );?></th> 
									<?php }
								else {?> 
											<th><?php _e( 'Grade', 'WPSchoolPress' );?></th>
								<?php }	?>
									<th><?php _e( 'Remarks', 'WPSchoolPress');?></th>
													<?php if(!empty($extra_fields)){
														foreach($extra_fields as $extf){
													?>
													<th><?php echo $extf->field_text;?></th>
													<?php } } ?>
												</tr>
											</thead>
											<tbody>
											<?php
											if($mark_entered==1)
											{
												$stable		=	$wpdb->prefix."wpsp_student";
												$sno		=	1;
												$getslist	=	$wpdb->get_results("select * from $stable WHERE class_id=$class_id order by CAST('s_rollno' as SIGNED)");
												
												if (empty($getslist)) {
													echo "<tr><td>".__( 'No Students to retrive', 'WPSchoolPress')."</td></tr>";
													
												}else {
												foreach ($getslist as $student ) {													
													$usid		=	intval($student->wp_usr_id);
													$stroll		=	$student->s_rollno;
													$stfullname	=	$student->s_fname.' '.$student->s_mname.' '.$student->s_lname;
													$marktable	=	$wpdb->prefix."wpsp_mark";													
													$getmark	=	$wpdb->get_row("select * from $marktable WHERE class_id=$class_id AND student_id=$usid AND subject_id=$subject_id AND exam_id=$exam_id ");
													$getmarkid		=	isset( $getmark->mid ) ? $getmark->mid : '';
													if( empty($getmark) ) {
															$mark_data	=	array( 'subject_id'=>$subject_id,'class_id'=>$class_id,'student_id'=>$usid,'exam_id'=>$exam_id );
															$m_ins		=	$wpdb->insert($marktable,$mark_data);
															if( $wpdb->insert_id )
																$getmarkid = $wpdb->insert_id;																
													}
													?>
													<tr>
														<td class="number"><?php echo $stroll;?></td>
														<td class="number"><?php echo $stfullname;?></td>
														<td class="sch_mark">
														<?php  if($settings_data['markstype'] == "Number") 
														{
															$classvar = "class='numbers wpsp-form-control'";
														}
														else 
														{
															$classvar = "class='textboxvalue wpsp-form-control'";
														}
														?>							
															<input type="text" <?php  echo  $classvar;?> id="v_marks" value="<?php echo $getmark->mark;  ?>" name="marks[<?php echo $getmarkid;?>][]">
														</td>

															<td class="sch_remarks">														
															<input type="text" class="textcls wpsp-form-control"  value="<?php echo $getmark->remarks;  ?>" name="remarks[<?php echo $getmarkid;?>][]">
														<!-- 	<input type="text" class="textcls" id="v_remarks" value="<?php echo $getmark->mark;  ?>" name="remarks[<?php echo $getmarkid;?>][]"> -->
														</td>
														<?php if(!empty($extra_fields)){
															
															foreach($extra_fields as $extf){
															?>
																<td><input type="text" class="numbers wpsp-form-control"id="v_exmark" min="0" name="exmarks[<?php echo $usid;?>][<?php echo $extf->field_id;?>]" value="<?php echo $extra_marks[$usid][$extf->field_id];?>"></td>
														<?php } } ?>
													</tr>
												<?php
													$sno++;	
												}
												echo "<input type='hidden' name='update' value='true'>";
											}
											}else{
												global $wpdb;
												$stable		=	$wpdb->prefix."wpsp_student";
												$getslist	=	$wpdb->get_results("select * from $stable WHERE class_id=$class_id order by CAST('rollno' as SIGNED)");
												$sno		=	1;
												if (empty($getslist)) {
													echo "<tr><td>".__( 'No Students to retrive', 'WPSchoolPress')."</td></tr>";
													
												}else {
												foreach( $getslist as $slist ) {
												?>
													<tr>
														<!-- <td class="number"><?php //echo $sno; ?></td> -->
														<td class="number"><?php echo $slist->s_rollno;?></td>
														<td class="number"><?php echo $slist->s_fname.' '.$slist->s_mname.' '.$slist->s_lname;?></td>
														<td class="sch_mark">
																<?php  if($settings_data['markstype'] == "Number") 
								{
										$classvar = "class='numbers markbox wpsp-form-control'";
								}
								else { 
											$classvar = "class='textboxvalue markbox wpsp-form-control'";
								}
									?>
															<input type="text" <?php  echo  $classvar;?> min="0" value="" name="marks[<?php echo $slist->wp_usr_id;?>][]">
														</td>
													<td class="sch_remarks">														
															<input type="text" class="textcls wpsp-form-control"  value="" name="remarks[<?php echo $slist->wp_usr_id;?>][]">
														<!-- 	<input type="text" class="textcls" id="v_remarks" value="<?php echo $getmark->mark;  ?>" name="remarks[<?php echo $getmarkid;?>][]"> -->
														</td>
														<?php if(!empty($extra_fields)){
															foreach($extra_fields as $extf){
															?>
																<td><input type="text" class="numbers wpsp-form-control" id="v_exmark1" min="0" name="exmarks[<?php echo $slist->wp_usr_id;?>][<?php echo $extf->field_id;?>]"></td>
															</td>
  
															<?php } } ?> 
													</tr>			
												<?php
													$sno++;
												}	
											}
											?>
											<?php 
											if(empty($getslist) && $mark_entered=='0'){
													 echo "<tr><td>".__( 'No Students to retrive', 'WPSchoolPress')."</td></tr>";
												}else { ?>
												
												<?php }} ?>
											</tbody>
										</table>
										<div class="wpsp-row">
											<div class="wpsp-col-md-12">
												<input  type="submit" class="wpsp-btn wpsp-btn-success" id="AddMark_Submit" name="AddMark_Submit"  value="Save Marks">
											</div>
										</div>

									</form>
								</div>
							</div>
							<?php
								} 
								else if(isset($_POST['MarkAction']) && sanitize_text_field($_POST['MarkAction'])=='View Marks')
								{
									include_once( WPSP_PLUGIN_PATH .'/includes/wpsp-viewMark.php');									
								}else{
									do_action( 'wpsp_marks_actions' );
								}
							?>
						<?php } ?>	
					</div>
				</div>
						
		
		<?php
			wpsp_body_end();
			wpsp_footer();
		}else if( $current_user_role=='parent' ) {
			wpsp_topbar();
			wpsp_sidebar();
			wpsp_body_start();
				global $wpdb;
				$parent_id		=	intval($current_user->ID);
				$student_table	=	$wpdb->prefix."wpsp_student";
				$class_table	=	$wpdb->prefix."wpsp_class";
				$students		=	$wpdb->get_results("select st.wp_usr_id, st.class_id, CONCAT_WS(' ', st.s_fname, st.s_mname, st.s_lname ) AS full_name,cl.c_name from $student_table st LEFT JOIN $class_table cl ON cl.cid=st.class_id where st.parent_wp_usr_id='$parent_id'");
				$child			=	array();
				foreach($students as $childinfo){
					$child[]=array(	'student_id'	=>	$childinfo->wp_usr_id,
									'name'			=>	$childinfo->full_name,
									'class_id'		=>	$childinfo->class_id,
									'class_name'	=>	$childinfo->c_name	);
				}
				?>
				<?php /*<section class="content-header">
					<h1> <?php _e( 'Marks', 'WPSchoolPress' ); ?> </h1>
					<ol class="breadcrumb">
						<li><a href="<?php echo wpsp_admin_url();?>sch-dashboard"><i class="fa fa-dashboard"></i> <?php _e( 'Dashboard', 'WPSchoolPress'); ?></a></li>
						<li><a href="<?php echo wpsp_admin_url();?>sch-marks"><?php _e( 'Marks', 'WPSchoolPress' ); ?> </a></li>
					</ol>
				</section> */?>
				
				<div class="wpsp-card">
					<div class="wpsp-card-head">                    
                    <h3 class="wpsp-card-title">Students Marks</h3>                   
                </div>
				<div class="wpsp-card-body">
					<div class="tabbable-line">
						<div class="tabSec wpsp-nav-tabs-custom" id="verticalTab"> 
							<div class="tabList">
							<ul class="wpsp-resp-tabs-list">						
							<?php $i=0; foreach($child as $ch) { ?>
								<li class="wpsp-tabing <?php echo ($i==0)?'active':''?>"><!-- <a href="#<?php echo 'student'.$i;?>"  data-toggle="tab"> --><?php echo $ch['name'];?><!-- </a> --></li>
								<?php $i++; } ?>
							</ul>
							</div>
						<div class="wpsp-tabBody wpsp-resp-tabs-container">
							<?php 
							$i=0;
							foreach( $child as $ch ) {
								$ch_class=$ch['class_id'];
							?>
							<div class="tab-pane wpsp-tabMain <?php echo ($i==0)?'active':''?>" id="<?php echo 'student'.$i;?>">
								
								<?php
								$student_id	=	$ch['student_id'];
								wpsp_MarkReport( $student_id );
								?>								
							<?php
							$i++;
							}
							?>
						
						</div>
					</div>
				</div>
			</div>
			</div>
			</div>	
			</div>	
							
			
			<?php
			wpsp_body_end();
			wpsp_footer();
		}else if( $current_user_role=='student' ) {
			wpsp_topbar();
			wpsp_sidebar();
			wpsp_body_start();
			$student_id=intval($current_user->ID);
			?>
			<?php /*<section class="content-header">
				<h1><?php _e( 'Marks', 'WPSchoolPress' ); ?></h1>
				<ol class="breadcrumb">
					<li><a href="<?php echo wpsp_admin_url();?>sch-dashboard"><i class="fa fa-dashboard"></i> <?php _e( 'Dashboard', 'WPSchoolPress'); ?></a></li>
					<li><a href="<?php echo wpsp_admin_url();?>sch-marks"><?php _e( 'Marks', 'WPSchoolPress' ); ?> </a></li>
				</ol>
			</section> */?>
			<div class="wpsp-card">
				<div class="wpsp-card-head">
            		<h3 class="wpsp-card-title">Your Marks</h3>                    
        		</div>
				<div class="wpsp-card-body">
					<div class="gap-top-bottom">
						<?php	wpsp_MarkReport($student_id); ?>
					</div>
				</div>
			</div>
	<?php
			wpsp_body_end();
			wpsp_footer();
		}
	}
	else{
		//Include Login Section
		include_once( WPSP_PLUGIN_PATH .'/includes/wpsp-login.php');
	}
	?>