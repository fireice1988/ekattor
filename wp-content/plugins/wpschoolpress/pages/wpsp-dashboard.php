<?php
if (!defined( 'ABSPATH' ) )exit('No Such File');
	
    wpsp_header(); 
    if( is_user_logged_in() ) { 
    	global $current_user, $wp_roles, $wpdb;
    	//get_currentuserinfo();
    	foreach ($wp_roles->role_names as $role => $name) :
    	if (current_user_can($role))
    		$current_user_role = $role;
    	endforeach;
		if( $current_user_role == 'administrator' || $current_user_role == 'teacher' || $current_user_role == 'parent' || $current_user_role == 'student' ) {
			wpsp_topbar();
			wpsp_sidebar();
			wpsp_body_start(); 
			global $wpdb;
			$user_table		=	$wpdb->prefix."users";
			$student_table		=	$wpdb->prefix."wpsp_student";
			$teacher_table		=	$wpdb->prefix."wpsp_teacher";
			$class_table		=	$wpdb->prefix."wpsp_class";
			$attendance_table	=	$wpdb->prefix."wpsp_attendance";
			$usercount = $wpdb->get_row("SELECT count(sid) as countstudent FROM $student_table
  JOIN $user_table ON $user_table.ID = $student_table.wp_usr_id");
			$teachercount = $wpdb->get_row("SELECT count(tid) as countteacher FROM $teacher_table
  JOIN $user_table ON $user_table.ID = $teacher_table.wp_usr_id");
			$parentscount = $wpdb->get_row("SELECT count(sid) as countparents FROM $student_table
  JOIN $user_table ON $user_table.ID = $student_table.parent_wp_usr_id");
			
			$users_count		=	$wpdb->get_row("SELECT(SELECT COUNT(*)FROM $student_table )AS stcount,(SELECT COUNT(*)FROM $teacher_table) AS tcount,(SELECT COUNT(DISTINCT parent_wp_usr_id) FROM $student_table where `parent_wp_usr_id`!='') AS pcount,(SELECT COUNT(*) FROM $class_table) AS clcount");
		?>
		<?php /*
		<section class="content-header">
			<h1>Dashboard</h1>
			<ol class="breadcrumb">
				<li><a href="<?php echo wpsp_admin_url();?>sch-dashboard"><i class="fa fa-dashboard"></i><?php  _e( 'Home', 'WPSchoolPress'); ?></a></li>
				<li class="active"><?php _e( 'Dashboard', 'WPSchoolPress'); ?> </li>
			</ol>
		</section> */?>
		
			<div class="wpsp-row">
				<div class="wpsp-col-sm-3 wpsp-col-xs-6">
					<a class="wpsp-colorBox" href="<?php echo wpsp_admin_url();?>sch-student">
						<span class="wpsp-colorBox-title">Students</span>	
						<h4 class="wpsp-colorBox-head"><?php echo isset( $usercount->countstudent ) ?  intval($usercount->countstudent) : 0; ?><sup>+</sup></h4>
					</a>
				</div>
				<div class="wpsp-col-sm-3 wpsp-col-xs-6">
					<a class="wpsp-colorBox wpsp-orangebox wpsp-teacherInfo" href="<?php echo wpsp_admin_url();?>sch-teacher">
						<span class="wpsp-colorBox-title">Teachers</span>	
						<h4 class="wpsp-colorBox-head"><?php echo isset($teachercount->countteacher)  ?  intval($teachercount->countteacher) : 0; ?><sup>+</sup></h4>
					</a>
				</div>
				<div class="wpsp-col-sm-3 wpsp-col-xs-6">
					<a class="wpsp-colorBox wpsp-yellowbox wpsp-parentsInfo" href="<?php echo wpsp_admin_url();?>sch-parent">
						<span class="wpsp-colorBox-title">Parents</span>	
						<h4 class="wpsp-colorBox-head"><?php echo isset($parentscount->countparents) ?  intval($parentscount->countparents) : 0; ?><sup>+</sup></h4>
					</a>
				</div>
				<div class="wpsp-col-sm-3 wpsp-col-xs-6">
					<a class="wpsp-colorBox wpsp-greenbox wpsp-classInfo" href="<?php echo wpsp_admin_url();?>sch-class">
						<span class="wpsp-colorBox-title">Classes</span>	
						<h4 class="wpsp-colorBox-head"><?php echo isset(  $users_count->clcount ) ?  intval($users_count->clcount) : 0; ?><sup>+</sup></h4>
					</a>
				</div>
			</div>
			<!-- Info boxes -->
					    
			<div class="wpsp-row">
				<!-- Left col -->
				<div class="wpsp-col-lg-8  wpsp-col-xs-12">
					<div class="wpsp-card">	
						<div class="wpsp-card-head">
							<div class="wpsp-left">
								<h3 class="wpsp-card-title">Activities Calender</h3>							
							</div>														
							<ul class="wpsp-cards-indicators wpsp-right">
								<li><span class="wpsp-indic wpsp-blue-indic"></span> Events</li>
								<li><span class="wpsp-indic wpsp-red-indic"></span> Exams</li>
								<li><span class="wpsp-indic wpsp-green-indic"></span> Holidays</li>
							</ul>
						</div>					
						
						<div class="wpsp-card-body">						
							<div id="multiple-events"></div>
						</div>
					</div>
				</div>
				<div class="wpsp-col-lg-4  wpsp-col-xs-12">
					<div class="wpsp-card">						
						<div class="wpsp-card-head">
							<h3 class="wpsp-card-title">Exams</h3>						
						</div>
						<div class="wpsp-card-body">
							<?php if($current_user_role == 'student' ) { 
								$current_user_id = get_current_user_id();
								//echo 'Your User ID is: ' .$current_user_id;
								$Student_table=$wpdb->prefix."wpsp_student";
								$examinfo=$wpdb->get_row("select class_id from $Student_table where wp_usr_id = '$current_user_id'");
								//print_r($examinfo);
								 $examinfo->class_id;

									$exam_table=$wpdb->prefix."wpsp_exam";
								$examinfo=$wpdb->get_results("select * from $exam_table where classid = '$examinfo->class_id' order by e_s_date DESC");
								?>
							<table class="wpsp-table">
								<thead>
									<tr>
										<th>Date</th>
										<th>Exam</th>		
									</tr>
								</thead>
								<tbody>							
									<?php foreach($examinfo as $exam) { ?>
										<tr>
											<td><?php echo wpsp_ViewDate($exam->e_s_date)." TO ".wpsp_ViewDate($exam->e_e_date);?></td>
											<td><?php echo $exam->e_name; ?></td>
										</tr>
									<?php } ?>
								</tbody>
							</table>

<?php } else {?>
							<?php
									$exam_table=$wpdb->prefix."wpsp_exam";
								$examinfo=$wpdb->get_results("SELECT u.*, c.*
FROM wp_wpsp_exam u
INNER JOIN wp_wpsp_class c ON u.classid= c.cid
order by u. e_s_date DESC");
								?>
							<table class="wpsp-table">
								<thead>
									<tr>
										<th>Date</th>
										<th>Exam</th>		
									</tr>
								</thead>
								<tbody>							
									<?php foreach($examinfo as $exam) { ?>
										<tr>
											<td><?php echo wpsp_ViewDate($exam->e_s_date)." TO ".wpsp_ViewDate($exam->e_e_date);?></td>
											<td><?php echo $exam->e_name."(".$exam->c_name.")"; ?></td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						<?php } ?> 
						</div>						
					</div>
				</div>
		</div>		
	<div id="eventContent" title="Event Details" style="display:none;">
		<div class="modal-content">
			<span class="close">&times;</span>
			<h4>Event Name :  <span id="viewEventTitle"></span></h4>
    Start: <span id="eventStart"></span><br>
    End: <span id="eventEnd"></span><br>
   
    
</div>
</div>
	<?php 
		wpsp_body_end();
		wpsp_footer();
	} else {
		echo WPSP_PERMISSION_MSG;
	}  
 } else {
    include_once( WPSP_PLUGIN_PATH .'/includes/wpsp-login.php');
	}
?>