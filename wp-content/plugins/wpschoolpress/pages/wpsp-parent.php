<?php
if (!defined( 'ABSPATH' ) )exit('No Such File');
wpsp_header();
	if( is_user_logged_in() ) {
		global $current_user, $wp_roles, $wpdb;
		//get_currentuserinfo();
		foreach ( $wp_roles->role_names as $role => $name ) :
		if ( current_user_can( $role ) )
			$current_user_role =  $role;
		endforeach;
		if($current_user_role=='administrator' || $current_user_role=='teacher')
		{
			wpsp_topbar();
			wpsp_sidebar();
			wpsp_body_start();
			if(isset($_GET['tab']) && sanitize_text_field($_GET['tab'])=='addparent')
				{
					include_once( WPSP_PLUGIN_PATH.'/includes/wpsp-parentForm.php');
				} else {
						include_once( WPSP_PLUGIN_PATH .'/includes/wpsp-parentList.php');
			?>
			<!-- Modal for View-->
			<div class="wpsp-popupMain" id="ViewModal">
			  <div class="wpsp-overlayer"></div> 
			  <div class="wpsp-popBody"> 
				<div class="wpsp-popInner">
					<a href="javascript:;" class="wpsp-closePopup"></a>
					<div id="ViewModalContent"></div> 
				</div>
			  </div>
			</div>
			<!-- /.modal -->
			<?php if($current_user_role=='administrator'){?>
				<div class="modal modal-wide" id="AddModal" tabindex="-1" role="dialog" aria-labelledby="AddModal" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="col-lg-12 col-md-12">
							<?php //include_once( WPSP_PLUGIN_PATH.'/includes/wpsp-parentForm.php'); ?>
							</div>							
						</div>
					</div>
				</div><!-- /.modal -->
						<?php } if($current_user_role=='administrator'){?>
				<div class="modal modal-wide" id="ImportModal" tabindex="-1" role="dialog" aria-labelledby="ImportModal" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="col-md-12">
								<div class="box box-info">
									<div class="box-header">
										<!--<h3 class="box-title">Import Parents</h3>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
									</div><!-- /.box-header -->
									<form action="#" name="ImportDetails" id="ImportDetails">
										<div class="form-group">
											<?php wp_nonce_field( 'UserImport', 'import_nonce', '', true ) ?>
											<input type="hidden" name="userType" value="2">
										</div>
									</form>
									<?php do_action('wpsp_parent_import_html'); ?>                                       									
								</div>
							</div>					
						</div>
					</div>
				</div><!-- /.modal -->				
			<?php
		}
		}
			wpsp_body_end();
			wpsp_footer();
		}if($current_user_role=='parent' || $current_user_role=='student' ) {
			wpsp_topbar();
			wpsp_sidebar();
			wpsp_body_start();
			$parent_id	=	intval($current_user->ID);
			$label	=	'Your Profile';
			if( $current_user_role=='student' ) {
				$student_id		=	intval($current_user->ID);
				$student_table	=	$wpdb->prefix."wpsp_student";
				$parent_info	=	$wpdb->get_row("select parent_wp_usr_id from $student_table where wp_usr_id='$student_id'");
				$parent_id		=	intval($parent_info->parent_wp_usr_id);	
				$label	=	'Parent Profile';				
			}
			?>
				<?php
					if($parent_id>0){
					//	wpsp_ParentPublicProfile($parent_id, 0);
						global $wpdb;
	$student_table = $wpdb->prefix . "wpsp_student";
	$users_table = $wpdb->prefix . "users";
	if ($pid == '') 
		$pid = intval($parent_id);
	if (!empty($pid)) $where = "where p.parent_wp_usr_id='$pid'";
	$button = isset($_POST['button']) ? sanitize_text_field($_POST['button']) : $button;
	$pinfo = $wpdb->get_row("select p.*, CONCAT_WS(' ', p_fname, p_mname, p_lname ) AS full_name ,u.user_email from $student_table p LEFT JOIN $users_table u ON u.ID=p.parent_wp_usr_id $where");
	$loc_avatar = get_user_meta($pid, 'simple_local_avatar', true);
	$img_url = $loc_avatar ? $loc_avatar['full'] : WPSP_PLUGIN_URL . 'img/avatar.png';
	
	if (!empty($pinfo))
	{
		$profile = "
				<div class='wpsp-panel-body'>
					<div class='wpsp-userpic'style='margin-top: 0;'>
						<img src='$img_url' height='150px' width='150px' class='img img-circle'/>
					</div>
					<div class='wpsp-userDetails'> 
						<table class='wpsp-table'>
							<tbody>
								<tr>
									<td colspan='2'><strong>Full Name: </strong>$pinfo->p_fname $pinfo->p_mname $pinfo->p_lname </td>
									
								</tr>
								<tr>
									<td><strong>Email: </strong>$pinfo->user_email</td>
									<td><strong>Gender: </strong>$pinfo->p_gender</td>
								</tr>
								
								<tr>
									<td><strong>Education: </strong>$pinfo->p_edu</td>
									<td><strong>Profession: </strong>$pinfo->p_profession</td>
								</tr>
																
								<tr>
									<td  colspan='2'><strong>Blood Group: </strong> $pinfo->p_bloodgrp</td>
								</tr>								
							</tbody>
						</table>	
					</div>
				</div>";
	}
	else
	{
		$profile = "No data retrived!..";
	}
	echo apply_filters('wpsp_parent_profile', $profile, intval($pid));
	
					}else{
						echo "<p>Parent profile not linked with this account, Kindly contact to School!</p>";
					}
				?>			
			<?php
			wpsp_body_end();
			wpsp_footer();
		}
	}
	else {
		include_once( WPSP_PLUGIN_PATH.'/includes/wpsp-login.php');
	}
	?>