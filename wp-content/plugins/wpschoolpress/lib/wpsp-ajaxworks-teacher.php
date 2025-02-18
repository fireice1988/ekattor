<?php
if (!defined('ABSPATH')) exit('No Such File');
/* This function is used for Add Teacher */
function wpsp_AddTeacher()
{
	global $wpdb;
	if (!isset($_POST['tregister_nonce']) || !wp_verify_nonce(sanitize_text_field($_POST['tregister_nonce']) , 'TeacherRegister'))
	{
		echo "Unauthorized Submission";
		exit;
	}
	wpsp_Authenticate();
	if (wpsp_CheckUsername(sanitize_user($_POST['Username']) , true) === true)
	{
		echo "Given User Name Already Exists!";
		exit;
	}
	if (email_exists(sanitize_email($_POST['Email'])))
	{
		echo "Given Email ID Already registered!";
		exit;
	}
	$wpsp_teacher_table = $wpdb->prefix . "wpsp_teacher";
	$firstname = sanitize_text_field($_POST['firstname']);
	$middlename = sanitize_text_field($_POST['middlename']);
	$lastname = sanitize_text_field($_POST['lastname']);
	$gender = sanitize_text_field($_POST['Gender']);
	$address = sanitize_text_field($_POST['Address']);
	$city = sanitize_text_field($_POST['city']);
	$phone = sanitize_text_field($_POST['Phone']);
	$qual = sanitize_text_field($_POST['Qual']);
	$position = sanitize_text_field($_POST['Position']);
	$bloodgroup = sanitize_text_field($_POST['Bloodgroup']);
	$empcode = sanitize_text_field($_POST['EmpCode']);
	$dob = !empty($_POST['Dob']) ? date('Y-m-d', strtotime(sanitize_text_field($_POST['Dob']))) : '';
	$doj = !empty($_POST['Doj']) ? date('Y-m-d', strtotime(sanitize_text_field($_POST['Doj']))) : '';
	$country = sanitize_text_field($_POST['country']);
	$zipcode = intval($_POST['zipcode']);
	if (!empty($empcode))
	{
		$result = $wpdb->get_row("SELECT *FROM $wpsp_teacher_table WHERE empcode='$empcode'", ARRAY_A);
		if (count($result) > 0)
		{
			echo "You have already assign same Employee Code to another Employee";
			exit;
		}
	}
	$userInfo = array(
		'user_login' => sanitize_user($_POST['Username']) ,
		'user_pass' => sanitize_text_field($_POST['Password']) ,
		'first_name' => sanitize_text_field($firstname) ,
		'user_email' => sanitize_email($_POST['Email']) ,
		'role' => 'teacher'
	);
	$user_id = wp_insert_user($userInfo);
	if (!is_wp_error($user_id))
	{
		// send registration mail
		$msg = 'Hello ' . $firstname;
		$msg.= '<br />Your are registered as teacher at <a href="' . site_url() . '">School</a><br /><br />';
		$msg.= 'Your Login details are below.<br />';
		$msg.= 'Your User Name is : ' . sanitize_user($_POST['Username']) . '<br />';
		$msg.= 'Your Password is : ' . sanitize_text_field($_POST['Password']) . '<br /><br />';
		$msg.= 'Please Login by clicking <a href="' . site_url() . '/sch-dashboard">Here </a><br /><br />';
		$msg.= 'Thanks,<br />' . get_bloginfo('name');
		wpsp_send_mail(sanitize_email($_POST['Email']) , 'User Registered', $msg);
		$teacher_data = array(
			'wp_usr_id' => $user_id,
			'first_name' => $firstname,
			'middle_name' => $middlename,
			'last_name' => $lastname,
			'address' => $address,
			'city' => $city,
			'country' => $country,
			'zipcode' => $zipcode,
			'empcode' => $empcode,
			'dob' => $dob,
			'doj' => $doj,
			'dol' => !empty($_POST['dol']) ? date('Y-m-d', strtotime(sanitize_text_field($_POST['dol']))) : '',
			'whours' => sanitize_text_field($_POST['whours']) ,
			'phone' => $phone,
			'qualification' => $qual,
			'gender' => $gender,
			'bloodgrp' => $bloodgroup,
			'position' => $position
		);
		$tch_ins = $wpdb->insert($wpsp_teacher_table, $teacher_data);
		if ($tch_ins)
		{
			do_action('wpsp_teacher_created', $user_id, $teacher_data);
		}
		if (!empty($_FILES['displaypicture']['name']))
		{	
			if (!function_exists('wp_handle_upload')) require_once (ABSPATH . 'wp-admin/includes/file.php');
			$mimes = array(
				'jpg|jpeg|jpe' => 'image/jpeg',
				'png' => 'image/png'
			);
			$avatar = wp_handle_upload($_FILES['displaypicture'], array(
				'mimes' => $mimes,
				'test_form' => false
			));
			if (isset($avatar['error']))
			{
				$msg = "<div class='col-md-12 col-lg-12'><div class='alert alert-danger'>Please upload a valid image file for the avatar.</div></div>";
			}
			else
			if (empty($avatar['file']))
			{
				switch ($avatar['error'])
				{
				case 'File type does not meet security guidelines. Try another.':
					add_action('user_profile_update_errors', create_function('$a', '$a->add("avatar_error",__("Please upload a valid image file for the avatar.","wpsp_teacher_photo_edit"));'));
					$msg = "<div class='col-md-12 col-lg-12'><div class='alert alert-danger'>Please upload a valid image file for the avatar.</div></div>";
					break;
				default:
					add_action('user_profile_update_errors', create_function('$a', '$a->add("avatar_error","<strong>".__("There was an error uploading the avatar:","wpsp_teacher_photo_edit")."</strong> ' . esc_attr($avatar['error']) . '");'));
					$msg = "<div class='col-md-12 col-lg-12'><div class='alert alert-danger'>There was an error uploading the avatar</div></div>";
				}
				return;
			}
			else{
				update_user_meta($user_id, 'displaypicture', array(
					'full' => $avatar['url']
				));
				update_user_meta($user_id, 'simple_local_avatar', array(
					'full' => $avatar['url']
				));
			}
		}
		if ($tch_ins)
		{
			$msg = "success";
		}
		else
		{
			$msg = "Oops! Something went wrong try again.";
		}
	}
	else
	{
		if (is_wp_error($user_id))
		{
			$msg = $user_id->get_error_message();
		}
	}
	echo $msg;
	wp_die();
}
/* This function is used for View Teacher Profile Information */
function wpsp_TeacherPublicProfile()
{
	global $wpdb;
	$tid = $_POST['id'];
	$teacher_table = $wpdb->prefix . "wpsp_teacher";
	$users_table = $wpdb->prefix . "users";
	$tinfo = $wpdb->get_row("select teacher.*,user.user_email from $teacher_table teacher LEFT JOIN $users_table user ON user.ID=teacher.wp_usr_id where teacher.wp_usr_id='$tid'");
	$loc_avatar = get_user_meta($tid, 'simple_local_avatar', true);
	$img_url = $loc_avatar ? $loc_avatar['full'] : WPSP_PLUGIN_URL . 'img/avatar.png';
	if (!empty($tinfo))
	{
		$profile = "<div class='wpsp-panel-body'>
					<div class='wpsp-userpic'>
						<img src='$img_url' height='150px' width='150px' class='wpsp-img-round'/>
					</div>
					<div class='wpsp-userDetails'>
						<table class='wpsp-table'>
							<tr>
								<td><strong>Full Name:</strong> $tinfo->first_name $tinfo->middle_name $tinfo->last_name</td>
								<td><strong>Gender: </strong> $tinfo->gender</td>
							</tr>
							<tr>
								<td><strong>Date of Birth: </strong>" . wpsp_ViewDate($tinfo->dob) . "</td>
								<td><strong>Email: </strong> $tinfo->user_email</td>	
							</tr>
							<tr>	
								<td><strong>Phone Number: </strong> $tinfo->phone</td>
								<td><strong>Blood Group: </strong> $tinfo->bloodgrp</td>
							</tr>
							<tr>
								<td><strong>Position: </strong> $tinfo->position</td>
								<td><strong>Qualification: </strong> $tinfo->qualification</td>
							</tr>
							<tr>
								<td colspan='2'><strong>Address: </strong> $tinfo->address, $tinfo->city, $tinfo->country, $tinfo->zipcode</td>
							</tr>
						
							<tr>
								<td><strong>Joining Date: </strong> " . wpsp_ViewDate($tinfo->doj) . "</td>
								<td><strong>Leaving Date: </strong> " . wpsp_ViewDate($tinfo->dol) . "</td>
							</tr>
							<tr>
								<td><strong>Working Hours: </strong> $tinfo->whours</td>
								<td><strong>Employee Code : </strong> $tinfo->empcode</td>
							</tr>
						</table>						
					</div>											
					</div>
				</div>
			</div>					
		</div>";
	}
	else
	{
		$profile = "No data retrived!..";
	}
	echo apply_filters('wpsp_teacher_profile', $profile, intval($tid));
	wp_die();
}
/* This function is used for Update Teacher Information */
function wpsp_UpdateTeacher()
{
	wpsp_Authenticate();
	/*if (email_exists(sanitize_email($_POST['Email'])))
	{
		echo "Given Email ID Already registered!";
		exit;
	}*/
	global $wpdb;
	$wpsp_teacher_table = $wpdb->prefix . "wpsp_teacher";
	$user_id = intval($_POST['UserID']);
	if (!wpsp_UpdateAccess('teacher', $user_id))
	{
		return false;
	}
	$errors = wpsp_validation(array(
		sanitize_text_field($_POST['firstname']) => 'required',
		sanitize_text_field($_POST['Address']) => 'required',
		sanitize_text_field($_POST['lastname']) => 'required',
		sanitize_email($_POST['Email']) => 'required|email'
	));
	if (is_array($errors))
	{
		echo "<div class='col-md-12'><div class='alert alert-danger'>";
		foreach($errors as $error)
		{
			echo "<li>" . $error . "</li>";
		}
		echo "</div></div>";
		return false;
	}
	$firstname = sanitize_text_field($_POST['firstname']);
	$middlename = sanitize_text_field($_POST['middlename']);
	$lastname = sanitize_text_field($_POST['lastname']);
	$email = sanitize_email($_POST['Email']);
	$gender = sanitize_text_field($_POST['Gender']);
	$address = sanitize_text_field($_POST['Address']);
	$phone = sanitize_text_field($_POST['Phone']);
	$qual = sanitize_text_field($_POST['Qual']);
	$bloodgroup = sanitize_text_field($_POST['Bloodgroup']);
	$country = sanitize_text_field($_POST['country']);
	$city = sanitize_text_field($_POST['city']);
	$zipcode = intval($_POST['zipcode']);
	$position = sanitize_text_field($_POST['Position']);
	$empcode = sanitize_text_field($_POST['Empcode']);
	$whours = sanitize_text_field($_POST['whours']);
	$dob = !empty($_POST['Dob']) ? wpsp_StoreDate(sanitize_text_field($_POST['Dob'])) : '';
	$doj = !empty($_POST['Doj']) ? wpsp_StoreDate(sanitize_text_field($_POST['Doj'])) : '';
	if (wpsp_CurrentUserRole() == 'administrator')
	{
		$empcode = sanitize_text_field($_POST['Empcode']);
		$teacher_data = array(
			'first_name' => $firstname,
			'middle_name' => $middlename,
			'last_name' => $lastname,
			'address' => $address,
			'country' => $country,
			'city' => $city,
			'zipcode' => $zipcode,
			'empcode' => $empcode,
			'dob' => $dob,
			'doj' => $doj,
			'phone' => $phone,
			'qualification' => $qual,
			'gender' => $gender,
			'bloodgrp' => $bloodgroup,
			'position' => $position,
			'dol' => !empty($_POST['dol']) ? date('Y-m-d', strtotime(sanitize_text_field($_POST['dol']))) : '',
			'whours' => sanitize_text_field($_POST['whours'])
		);
		$wpsp_tch_upd = $wpdb->update($wpsp_teacher_table, $teacher_data, array(
			'wp_usr_id' => $user_id
		));
	}
	else
	{
		$teacher_data = array(
			'first_name' => $firstname,
			'middle_name' => $middlename,
			'last_name' => $lastname,
			'address' => $address,
			'paddress' => $paddress,
			'country' => $country,
			'city' => $city,
			'zipcode' => $zipcode,
			'dob' => $dob,
			'doj' => $doj,
			'phone' => $phone,
			'qualification' => $qual,
			'gender' => $gender,
			'bloodgrp' => $bloodgroup,
			'position' => $position,
		);
		$wpsp_tch_upd = $wpdb->update($wpsp_teacher_table, $teacher_data, array(
			'wp_usr_id' => $user_id
		));
	}
	if ($email != '')
	{
		$tch_upd_email = wp_update_user(array(
			'ID' => $user_id,
			'user_email' => $email
		));
		
	}
	if ($wpsp_tch_upd)
	{
		do_action('wpsp_teacher_updated', intval($user_id) , $teacher_data);
	}
	if (!function_exists('wp_handle_upload'))
	{
		require_once (ABSPATH . 'wp-admin/includes/file.php');
	}
	if (!empty($_FILES['displaypicture']['name']))
	{
		$mimes = array(
			'jpg|jpeg|jpe' => 'image/jpeg',
			'png' => 'image/png'
		);
		$avatar = wp_handle_upload($_FILES['displaypicture'], array(
			'mimes' => $mimes,
			'test_form' => false
		));
		if (isset($avatar['error']))
		{
			$msg = "<div class='col-md-12 col-lg-12'><div class='alert alert-danger'>Please upload a valid image file for the avatar.</div></div>";
		}
		else if (empty($avatar['file']))
		{
			switch ($avatar['error'])
			{
			case 'File type does not meet security guidelines. Try another.':
				add_action('user_profile_update_errors', create_function('$a', '$a->add("avatar_error",__("Please upload a valid image file for the avatar.","wpsp_teacher_photo_edit"));'));
				$msg = "<div class='col-md-12 col-lg-12'><div class='alert alert-danger'>Please upload a valid image file for the avatar.</div></div>";
				break;
			default:
				add_action('user_profile_update_errors', create_function('$a', '$a->add("avatar_error","<strong>".__("There was an error uploading the avatar:","wpsp_teacher_photo_edit")."</strong> ' . esc_attr($avatar['error']) . '");'));
				$msg = "<div class='col-md-12 col-lg-12'><div class='alert alert-danger'>There was an error uploading the avatar</div></div>";
			}
			return;
		}
		else
		{
			update_user_meta($user_id, 'displaypicture', array(
				'full' => $avatar['url']
			));
			update_user_meta($user_id, 'simple_local_avatar', array(
				'full' => $avatar['url']
			));
		}
	}
	if (!$wpsp_tch_upd && is_wp_error($tch_upd_email))
	{
		$msg = "<div class='col-md-12 col-lg-12'><div class='alert alert-danger'>Oops! Something went wrong try again.</div></div>";
	}
	elseif (is_wp_error($tch_upd_email))
	{
		$msg = "<div class='col-md-12 col-lg-12'><div class='alert alert-warning'>" . $tch_upd_email->get_error_message() . "</div></div>";
	}
	
	if (is_wp_error($wpsp_tch_upd))
	{
		$msg =  $stu_upd->get_error_message() ;
	}
	else
	{
		$msg = "success";
	}
	echo $msg;
}
?>