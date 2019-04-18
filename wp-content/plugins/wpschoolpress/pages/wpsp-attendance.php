<?php
if (!defined( 'ABSPATH' ) )exit('No Such File');
wpsp_header();
	if( is_user_logged_in() ) {
		global $current_user, $wpdb;
		$current_user_role=$current_user->roles[0];
		if($current_user_role=='administrator' || $current_user_role=='teacher')
		{
			wpsp_topbar();
			wpsp_sidebar();
			wpsp_body_start();
		?>
		<div class="wpsp-card">			
						<div class="wpsp-card-head">                   
							<h3 class="wpsp-card-title">Attendance Report</h3>							
							<hr>	                    
						</div>

						<div class="wpsp-card-body text-black">
							<div class="wpsp-row">				
							<div class="wpsp-col-lg-5 wpsp-col-md-5 wpsp-col-sm-12 wpsp-col-xs-12" id="AttendanceEnterForm">
							<h3 class="wpsp-card-title">Attendance</h3>
							<div class="line_box">
									<div class="wpsp-form-group">
										<label for="Class">Select Class </label>
											<select name="classid" id="AttendanceClass" class="wpsp-form-control">
												<option value="">Select Class</option>
													<?php 
													if(isset($_POST['classid']) && intval($_POST['classid'])!='')
														$selid=intval($_POST['classid']);
													else 
														if($current_user_role=='teacher'){
															$current_user_id = get_current_user_id();
								
														$selid=0;
													$ctname=$wpdb->prefix.'wpsp_class';
													$clt=$wpdb->get_results("select `cid`,`c_name` from `$ctname` where teacher_id = '$current_user_id' ");
													foreach($clt as $cnm){?>
														<option value="<?php echo $cnm->cid;?>" <?php if($cnm->cid==$selid) echo "selected";?>><?php echo $cnm->c_name;?></option>
													<?php } 	
														} else {
														$selid=0;
													$ctname=$wpdb->prefix.'wpsp_class';
													$clt=$wpdb->get_results("select `cid`,`c_name` from `$ctname`");
													foreach($clt as $cnm){?>
														<option value="<?php echo $cnm->cid;?>" <?php if($cnm->cid==$selid) echo "selected";?>><?php echo $cnm->c_name;?></option>
													<?php } } ?>

											</select>
											<span class="clserror wpsp-text-red">Please select Class</span>
									</div>
									<div class="wpsp-form-group">
										<label for="date">Date </label>
										<input type="text" class="wpsp-form-control select_date" id="AttendanceDate" value="<?php if(isset($_POST['entry_date'])) { echo $_POST['entry_date']; } else { echo date('m/d/Y'); }?>" name="entry_date">
										<span class="clsdate">Please select Date</span>
									</div>
									<div class="wpsp-row wpsp-text-center">
										<div class="wpsp-col-sm-12">
											<div class="wpsp-form-group">
												<button id="AttendanceEnter" name="attendance" class="wpsp-btn wpsp-btn-success">Add/Update</button>
												<button id="Attendanceview" name="attendanceview" class="wpsp-btn wpsp-btn-primary">View</button>
											</div>
										</div>
									</div>
									<div class="wpsp-row">
										<div class="wpsp-col-lg-12 wpsp-col-md-12 wpsp-col-sm-12 wpsp-form-group wpsp-text-red" id="wpsp-error-msg" style="margin-top:0px;">
										</div>
									</div>
								</div>
							</div>

							<div class="wpsp-col-lg-6 wpsp-col-lg-offset-1 wpsp-col-md-5 wpsp-col-md-offset-1 wpsp-col-sm-12 wpsp-col-xs-12 AttendanceView">
								<?php
									$class_names		=	$c_stcount	=	$attendance	=	array();
									$class_table		=	$wpdb->prefix."wpsp_class";
									$student_table		=	$wpdb->prefix."wpsp_student";
									$attendance_table	=	$wpdb->prefix."wpsp_attendance";
									$class_info			=	$wpdb->get_results("select cid,c_name from $class_table");
									foreach($class_info as $cls){
										$class_names[$cls->cid]=$cls->c_name;
									}
									$classwise_count	=	$wpdb->get_results("select class_id, count(*) as count from $student_table GROUP BY class_id",ARRAY_A);
									foreach($classwise_count as $clwc){
										$c_stcount[$clwc['class_id']]	=	$clwc['count'];
									}

									$date_today	=	date('Y-m-d');
									$attendance_info	=	$wpdb->get_results("select class_id, absents from $attendance_table where date='$date_today'");
									foreach($attendance_info as $attend){
										$absents	=	json_decode($attend->absents);
										$present	=	$c_stcount[$attend->class_id]-count($absents);
										$percent	=	round(($present*100)/$c_stcount[$attend->class_id]);
										$attendance[$attend->class_id]	=	array('present'=>$present,'percentage'=>$percent);
									}
								?>
								<div class="wpsp-col-sm-12">
									<h3 class="wpsp-card-title">View Attendance Report</h3>
									<div class="line_box">
										<div class="box-body">
											<?php
												foreach($class_names as $clid=>$cln){
												$css_class='';
												if(isset($attendance[$clid])){
													if($attendance[$clid]['percentage']==100)
														$css_class="wpsp-progress-bar-success";
													else if($attendance[$clid]['percentage']<100 && $attendance[$clid]['percentage']>70)
														$css_class="wpsp-progress-bar-warning";
													else if($attendance[$clid]['percentage']<=70)
														$css_class="wpsp-progress-bar-danger";
													else
														$css_class="wpsp-progress-bar-info";
												}
											?>
												<div class="wpsp-progress-group">
														<span class="wpsp-progress-text"><?php echo $cln;?></span>
														<span class="wpsp-progress-number"><?php if(isset($attendance[$clid])){ echo $attendance[$clid]['present']; }?>/<?php echo (isset($c_stcount[$clid]))?$c_stcount[$clid]:'0';?></span>
														<div class="wpsp-progress sm">
															<div class="wpsp-progress-bar <?php echo $css_class;?>" style="width: <?php echo (isset($attendance[$clid]))?$attendance[$clid]['percentage']:'0'; ?>%">
															</div>
														</div>
												</div>
											<?php } ?>
										</div>
									</div>
								</div>
						</div>
					</div>	
					
		<div class="modal modal-wide" id="AddModal" tabindex="-1" role="dialog" aria-labelledby="AddModal" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content" id="AddModalContent">
				</div>
			</div>
		</div>
	
	
	</div>
</div>
		

	 	<?php
			wpsp_body_end();
			wpsp_footer();
		}
		else if($current_user_role=='parent')
		{
			wpsp_topbar();
			wpsp_sidebar();
			wpsp_body_start();
			$parent_id=$current_user->ID;
			$student_table=$wpdb->prefix."wpsp_student";
			$class_table=$wpdb->prefix."wpsp_class";
			$att_table=$wpdb->prefix."wpsp_attendance";
			$students=$wpdb->get_results("select wp_usr_id, class_id, s_fname from $student_table where parent_wp_usr_id='$parent_id'");
			$child=array();
			foreach($students as $childinfo){
				$child[]=array('student_id'=>$childinfo->wp_usr_id,'name'=>$childinfo->s_fname,'class_id'=>$childinfo->class_id);
			}
			?>

			<!-- <section class="content-header">
				<h1>Attendance</h1>
				<ol class="breadcrumb">
					<li><a href="<?php echo site_url('sch-dashboard'); ?> "><i class="fa fa-homme"></i> Dashboard</a> </li>
					<li><a href="<?php echo site_url('sch-attendance'); ?>">Attendance</a></li>
				</ol>
			</section> -->
			<div class="wpsp-card">
<div class="wpsp-card-body">
			<!-- <section class="content"> -->
				<!-- <div class="tabbable-line"> -->
					<div class="tabSec wpsp-nav-tabs-custom" id="verticalTab">
						<div class="tabList">
							<ul class="wpsp-resp-tabs-list">					
						<?php $i=0; foreach($child as $ch) { ?>
							<li class="wpsp-tabing <?php echo ($i==0)?'wpsp-resp-tab-active':''?>"><a href="#<?php echo str_replace(' ', '', $ch['name'].$i );?>"  data-toggle="tab"><?php echo $ch['name'];?></a></li>
							<?php $i++; } ?>
					</ul>
					</div>
					<div class="wpsp-tabBody wpsp-resp-tabs-container">	
						<?php
						$i=0;
						foreach($child as $ch) {
							$st_id 		=	$ch['student_id'];
							$st_class	=	$ch['class_id'];
							?>

							<div class="tab-pane wpsp-tabMain <?php echo ($i==0)?'active':''?>" id="<?php echo str_replace(' ', '', $ch['name'].$i );?>">
								<div class="sa" style="margin-top: 60px;">
                                <?php	echo $att_info=wpsp_AttReport($st_id); ?>
                            </div>
							</div>
						<?php
						$i++; }
						?>
					</div>
				</div>
				<!-- </div> -->
			</div></div>
			<?php
				$startdate	=	isset( $_POST['search_from_date'])  ? sanitize_text_field($_POST['search_from_date']) : '';
				$todate		=	isset( $_POST['search_to_date'] ) ? sanitize_text_field($_POST['search_to_date']) : '';
			?>
<div class="wpsp-card">
<div class="wpsp-card-body">
			<div class="content" id="searchattendance">
				<div class='wpsp-panel wpsp-panel-info'>
					<div class='wpsp-panel-heading'><h3 class='wpsp-panel-title'>Search Attendance</h3></div>
					<div class='wpsp-panel-body'>
						<form name="search_student_attendance" method="post">
							<div class="wpsp-form-group wpsp-col-lg-12 wpsp-col-md-12 wpsp-col-sm-12">
								<label for="search_date" class="wpsp-col-md-2 wpsp-control-label">Select From Date</label>
								<div class="wpsp-col-md-2"><input type="text" name="search_from_date" id="search_from_date" class="select_date wpsp-form-control" value="<?php echo $startdate; ?>"></div>
							</div>
							<div class="wpsp-form-group wpsp-col-lg-12 wpsp-col-md-12 wpsp-col-sm-12">	
								<label for="search_date" class="wpsp-col-md-2 control-label">Select To Date</label>
								<div class="wpsp-col-md-2"><input type="text" name="search_to_date" id="search_to_date" class="select_date wpsp-form-control" value="<?php echo $todate; ?>"></div>
							</div>

							<div class="wpsp-col-md-4 cwpsp-ol-md-offset-2">											
								<button name="viewattendance" id="view-attendance" class="wpsp-btn wpsp-btn-primary" type="submit" value="viewattendance">View</button>
							</div>
						</form>

						<?php						
						if( !empty( $startdate ) && !empty( $todate ) ) {
							$date_from	=	strtotime($startdate);
							$date_to	=	strtotime($todate);
							$att_table	=	$wpdb->prefix."wpsp_attendance";
						?>
							<table class="wpsp-table" >
								<tr>
									<th>Date</th>
									<?php 
										foreach( $child as $ch ) {
											echo '<th>'.$ch['name'].'</th>';
										}
									?>
								</tr>
								<?php
								for ( $i=$date_from; $i<=$date_to; $i+=86400 ) {
									$cdate	=	date("Y-m-d", $i);
									echo '<tr><td>'.$cdate.'</td>';
										foreach( $child as $ch ) {
											$classID			=	$ch['class_id'];
											$get_attendance		=	$wpdb->get_row("select *from $att_table where class_id=$classID AND date='$cdate'", ARRAY_A);
											$attendance_status	=	'Not Added Yet'.$get_attendance['absents'];

											if( !empty( $get_attendance ) && isset( $get_attendance['absents'] ) && $get_attendance['absents']=='Nil' ) {
													$attendance_status	=	'Present';
											} else {
												$attendance_list	=	json_decode( $get_attendance['absents'] );
												$studentId			=	$ch['student_id'];
												if( !empty( $attendance_list  ) ) {
													foreach( $attendance_list as $key => $value ) {
														if( $value->sid == $studentId ) {
															$attendance_status = '<span class="label label-danger">Absent</span> '.$value->reason;
															break;
														} else {
															$attendance_status = 'Present';
														}
													}
												}		
											}
											echo '<td>'.$attendance_status.'</td>'; 
										}
									echo '</tr>';
								}?>
							</table>
						<?php }?>
					</div>
				</div>
			</div>
				</div>
			</div>

		<!-- 	<div class="modal fade" id="ViewModal" tabindex="-1" role="dialog" aria-labelledby="ViewModal" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content" id="ViewModalContent">
					</div>
				</div>
			</div> -->
			<?php
			wpsp_body_end();
			wpsp_footer();
		}else if($current_user_role=='student'){
			wpsp_topbar();
			wpsp_sidebar();
			wpsp_body_start();
			$st_id=$current_user->ID;
			?>
			<!-- <section class="content-header">
				<h1>Attendance</h1>
				<ol class="breadcrumb">
					<li><a href="<?php echo site_url('sch-dashboard'); ?> "><i class="fa fa-home"></i> Dashboard</a></li>
					<li><a href="<?php echo site_url('sch-attendance'); ?>">Attendance</a></li>
				</ol>
			</section> -->
			<section class="content">
				<?php
					//	echo $att_info=wpsp_AttReport($st_id);
global $wpdb;
	$att_table = $wpdb->prefix . "wpsp_attendance";
	$st_table = $wpdb->prefix . "wpsp_student";
	$class_table = $wpdb->prefix . "wpsp_class";
	$ser = '%' . $st_id . '%';
	$stinfo = $wpdb->get_row("select st.class_id, st.s_rollno , CONCAT_WS(' ', st.s_fname, st.s_mname, st.s_lname ) AS full_name, c.c_name, c.c_sdate, c.c_edate from $st_table st LEFT JOIN $class_table c ON c.cid=st.class_id where st.wp_usr_id='$st_id'");
	$att_info = $wpdb->get_row("select count(*) as count from $att_table WHERE absents LIKE '$ser'");
	$stinfo->c_edate = wpsp_ViewDate($stinfo->c_edate);
	$stinfo->c_sdate = wpsp_ViewDate($stinfo->c_sdate);
	$loc_avatar = get_user_meta($st_id, 'simple_local_avatar', true);
	$img_url = $loc_avatar ? $loc_avatar['full'] : WPSP_PLUGIN_URL . 'img/avatar.png';
	$attendance_days = $wpdb->get_results("select *from $att_table where class_id=$stinfo->class_id");
	$present_days = 0;
	foreach($attendance_days as $days => $attendance)
	{
		if ($attendance->absents == 'Nil')
		{
			$present_days++;
		}
		else
		{
			$absents = json_decode($attendance->absents, true);
			if (array_search($st_id, array_column($absents, 'sid')) !== False)
			{
			}
			else
			{
				$present_days++;
			}
		}
	}
	$working_days = $present_days + $att_info->count;
	
	$content = "<div class='wpsp-panel-body'>	
					<div class='wpsp-userpic'style='margin-top: 0;'>
						 <img src='$img_url' height='150px' width='150px' class='img img-circle'/>
					</div>
					<div class='wpsp-userDetails'> 
						<table class='wpsp-table'>
							<tbody>
								<tr>
									<td colspan='2'><strong>Name: </strong>$stinfo->full_name</td>
									
								</tr>
								
								<tr>
									<td><strong>Class: </strong>$stinfo->c_name</td>
									<td><strong>Roll No. : </strong>$stinfo->s_rollno</td>
									
								</tr>
								
								<tr>
									<td><strong>Class Start: </strong> $stinfo->c_sdate </td>
									<td><strong>Class End : </strong>$stinfo->c_edate</td>
									
								</tr>
								
								<tr>
									<td><strong>Number of Absent days: </strong>$att_info->count</td>
									<td><strong>Number of Present days: </strong>$present_days</td>
								</tr>
								<tr>	
									<td colspan='2'><strong>Number of Attendance days: </strong>$working_days</td>
								</tr>
								
							</tbody>
						</table>
					</div>
				</div>";
	
	echo $content;
	
				?>

			</section>

			<div class="modal fade" id="ViewModal" tabindex="-1" role="dialog" aria-labelledby="ViewModal" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content" id="ViewModalContent">
					</div>
				</div>
			</div>
			<?php
			wpsp_body_end();
			wpsp_footer();
		}
	}else{
		include_once( WPSP_PLUGIN_PATH .'/includes/wpsp-login.php');
	}
?>