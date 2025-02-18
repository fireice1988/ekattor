<?php if (!defined( 'ABSPATH' ) )exit('No Such File');
	global $current_user, $wpdb;
	$current_user_role=$current_user->roles[0];
?>
<!-- This form is used for Add New Parent -->
<div id="formresponse"></div>
<form name="ParentEntryForm" id="ParentEntryForm" method="post">
	<div class="wpsp-card">
		<div class="wpsp-card-head">
			<h3 class="wpsp-card-title">New Parent Entry</h3>			
		</div>
		<div class="wpsp-card-body">
		<div class="wpsp-col-md-6">
			<?php wp_nonce_field( 'ParentRegister', 'pregister_nonce', '', true ) ?>	
			<div class="wpsp-row">
					<div class="wpsp-col-md-4">
						<div class="wpsp-form-group">
							<label class="wpsp-label" for="firstname">Firstname <span class="wpsp-required">*</span></label>
							<input type="text" class="wpsp-form-control" id="firstname" name="firstname" placeholder="First Name">
						</div>
					</div>
					<div class="wpsp-col-md-4">
						<div class="wpsp-form-group">
							<label class="wpsp-label" for="middlename">Middlename <span class="wpsp-required">*</span></label>
							<input type="text" class="wpsp-form-control" id="middlename" name="middlename" placeholder="Middle Name">
						</div>
					</div>
					<div class="wpsp-col-md-4">
						<div class="wpsp-form-group">
							<label class="wpsp-label" for="lastname">Lastname <span class="wpsp-required">*</span></label>
							<input type="text" class="wpsp-form-control" id="lastname" name="lastname" placeholder="Last Name">
						</div>
					</div>
			</div>
			
			<div class="wpsp-form-group">
				<label class="wpsp-label" for="Username">Username <span class="wpsp-required">*</span></label>
				<input type="text" class="wpsp-form-control" id="Username" name="Username" placeholder="Parent Username">
			</div>
			<div class="wpsp-form-group">
				<label class="wpsp-label" for="Email">Email address <span class="wpsp-required">*</span></label>
				<input type="email" class="wpsp-form-control" id="Email" name="Email" placeholder="parent Email">
			</div>
			<div class="wpsp-form-group">
				<label class="wpsp-label" for="Password">Password <span class="wpsp-required">*</span></label>
				<input type="password" class="wpsp-form-control" id="Password" name="Password" placeholder="Password">
			</div>
			<div class="wpsp-form-group">
				<label for="ConfirmPassword">Confirm Password <span class="wpsp-required">*</span></label>
				<input type="password" class="wpsp-form-control" id="ConfirmPassword" name="ConfirmPassword" placeholder="Confirm Password">
			</div>
			<div class="wpsp-form-group">
				<label class="wpsp-label" for="educ">Education</label>
				<input type="text" class="wpsp-form-control" id="Qual" name="Qual" placeholder="Highest Education Degree">
			</div>
			<div class="wpsp-form-group">
				<label class="wpsp-label" for="dateofbirth">Date of Birth</label>
				<input type="text" class="wpsp-form-control select_date" id="Dob" name="Dob" placeholder="Date of Birth">
			</div>
			<div class="wpsp-form-group">
				<label class="wpsp-label" for="displaypicture">Profile Image</label>
				<input type="file" name="displaypicture" id="displaypicture">
				<p id="test" style="color:red"></p>
			</div>
		</div>
		<div class="wpsp-col-md-6">	
			<div class="wpsp-form-group parent-student-list">
				<label class="wpsp-label" for="position">Select Student</label>
				<?php 
				$class_table	=	$wpdb->prefix."wpsp_class"; 
				$classQuery		=	"select cid,c_name from $class_table";
				if( $current_user_role=='teacher' ) {
					$cuserId	=	intval($current_user->ID);
					$classQuery	=	"select cid,c_name from $class_table where teacher_id=$cuserId";														
				}
				$classList		=	$wpdb->get_results( $classQuery );
				?>
				 <select name="child_list[]" id="child_list" multiple class="wpsp-form-control">
					<?php foreach( $classList as $classkey=>$classvalue ) { ?>
						<optgroup label="Class Name:<?php echo $classvalue->c_name; ?>">
							<?php 
								$student_table		=	$wpdb->prefix."wpsp_student"; 
								$studentList		=	$wpdb->get_results("select wp_usr_id,s_fname from $student_table where class_id=$classvalue->cid");
								foreach( $studentList as $studentkey=> $studentvalue ) {
							?>
							<option value="<?php echo intval($studentvalue->wp_usr_id); ?>"><?php echo $studentvalue->s_fname; ?></option>
								<?php } ?>
						</optgroup>
					<?php } ?>
				</select> 
			</div>
			<div class="wpsp-form-group wpsp-gender-field">
				<label class="wpsp-label" for="Class">Gender</label> <br/>
				<div class="radio">
					<input type="radio" name="Gender" value="Male" checked="checked">
					<label for="Male">Male</label>
				</div>
				<div class="radio">
					<input type="radio" name="Gender" value="Female">
					<label for="Female">Female</label>
				</div>	
				<div class="radio">
					<input type="radio" name="Gender" value="Other">
					<label for="Female">Other</label>
				</div>													
			</div>												
			<div class="wpsp-form-group">
				<label class="wpsp-label" for="position">Profession</label>
				<input type="text" class="wpsp-form-control" id="profession" name="Profession" placeholder="profession">
			</div>
			<div class="wpsp-form-group">
				<label class="wpsp-label" for="Address" >Current Address</label>
				<textarea name="Address" class="wpsp-form-control" rows="4"></textarea>											
			</div>
			<div class="wpsp-form-group">
				<label class="wpsp-label" for="Address" >Permanent Address</label>
				<textarea name="pAddress" class="wpsp-form-control" rows="5"></textarea>											
			</div>
			<div class="wpsp-form-group">
				<label class="wpsp-label" for="Country">Country</label>
				<?php $countrylist = wpsp_county_list();?>
				<select class="wpsp-form-control" id="Country" name="country">
					<option value="">Select Country</option>
					<?php 
					foreach( $countrylist as $key=>$value ) { ?>
						<option value="<?php echo $value;?>"><?php echo $value;?></option>
					<?php	
					}
					?>
				</select>
			</div>
			
			<div class="wpsp-row">
				<div class="wpsp-col-md-6">
					<div class="wpsp-form-group">
						<label class="wpsp-label" for="Zipcode">Zipcode</label>
						<input type="text" class="wpsp-form-control" id="Zipcode" name="zipcode" placeholder="Zipcode">
					</div>
				</div>
				<div class="wpsp-col-md-6">
					<div class="wpsp-form-group">
						<label class="wpsp-label" for="phone">Phone</label>
						<input type="text" class="wpsp-form-control" id="phone" name="Phone" placeholder="Phone Number">
					</div>
				</div>
			</div>
			<div class="wpsp-form-group">
				<label class="wpsp-label" for="bloodgroup">Blood Group</label>
				<select class="wpsp-form-control" id="Bloodgroup" name="Bloodgroup">
					<option value="">Select Blood Group</option>
					<option value="O+">O +</option>
					<option value="O-">O -</option>
					<option value="A+">A +</option>
					<option value="A-">A -</option>
					<option value="B+">B +</option>
					<option value="B-">B -</option>
					<option value="AB+">AB +</option>
					<option value="AB-">AB -</option>
				</select>
			</div>	
		</div>
		<div class="wpsp-col-md-12">
			<button type="submit" class="wpsp-btn wpsp-btn-primary" id="parentform">Submit</button>
		</div>
	</div>
	</div>
</form>
<!-- End of Add New Parent Form -->