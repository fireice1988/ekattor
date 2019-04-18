<?php if (!defined( 'ABSPATH' ) ) exit('No Such File');
$student_table = $wpdb->prefix."wpsp_student";
$class_table = $wpdb->prefix."wpsp_class";
$users_table = $wpdb->prefix."users";
$sid = intval($_GET['id']);$edit = true;$msg = '';
if( isset($_GET['edit']) && sanitize_text_field($_GET['edit'])=='true' && ($current_user_role=='administrator' || $current_user_role=='teacher' ) && (isset( $_POST['sedit_nonce'] ) && wp_verify_nonce( sanitize_text_field($_POST['sedit_nonce']), 'StudentEdit' ) ) )  {
    ob_start();
    wpsp_UpdateStudent();
}
$stinfo  =  $wpdb->get_row("select * from $student_table where wp_usr_id='$sid'");
//print_r($stinfo);
if( !empty( $stinfo ) ) {
    $loc_avatar=get_user_meta($sid,'simple_local_avatar',true);
    $img_url= $loc_avatar ? $loc_avatar['full'] : WPSP_PLUGIN_URL.'img/default_avtar.jpg';
     $parentid   =   intval($stinfo->parent_wp_usr_id);
    if( !empty( $parentid ) ) {
        $parentInfo =   get_user_by( 'id', $parentid );
        $parentEmail =  isset( $parentInfo->data->user_email ) ? $parentInfo->data->user_email : '';
        //Update Parent Profile Picture
        $parent_loc_avatar=get_user_meta($parentid,'simple_local_avatar',true); 
        $parent_img_url= $parent_loc_avatar ? $parent_loc_avatar['full'] : WPSP_PLUGIN_URL.'img/default_avtar.jpg';
    }
?>
<div id="formresponse"></div>
<form name="StudentEditForm" id="StudentEditForm" method="post" enctype="multipart/form-data" novalidate="novalidate">
    <div class="wpsp-col-xs-12">
        <div class="wpsp-card">
            <div class="wpsp-card-head">
                <h3 class="wpsp-card-title">Personal Details</h3>                
            </div>
            <div class="wpsp-card-body">
                    <?php wp_nonce_field( 'StudentRegister', 'sregister_nonce', '', true ) ?>
                    <div class="wpsp-row">
                        <div class="wpsp-col-lg-3 wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">
                            <div class="wpsp-form-group">
                                <label class="wpsp-label displaypicture">Profile Image</label>
                                <div class="wpsp-profileUp">
                                    <img src="<?php echo $img_url;?>" id="img_preview" onchange="imagePreview(this);" height="150px" width="150px" class="wpsp-upAvatar" />
                                    <div class="wpsp-upload-button"><i class="fa fa-camera"></i>
                                        <input name="displaypicture" class="wpsp-file-upload upload" id="displaypicture" type="file" accept="image/jpg, image/jpeg" />
                                    </div>
                                </div>
                                <p class="wpsp-form-notes">* Only JPEG and JPG supported, * Max 3 MB Upload </p>
                                <label id="displaypicture-error" class="error" for="displaypicture" style="display: none;">Please Upload Profile Image</label>
                                <p id="test" style="color:red" class="validation-error-displaypicture"></p>
                            </div>
                        </div>
                        <input type="hidden" id="studID" name="wp_usr_id" value="<?php echo $sid;?>">
                        <input type="hidden" name="parentid" value="<?php echo $stinfo->parent_wp_usr_id;?>">
                        <div class="wpsp-col-lg-3 wpsp-col-md-3 wpsp-col-sm-12 wpsp-col-xs-12">
                            <div class="wpsp-form-group">
                                <label class="wpsp-label" for="gender">Gender</label>
                                <div class="wpsp-radio-inline">
                                    <div class="wpsp-radio">
                                        <input type="radio" name="s_gender" <?php if(strtolower($stinfo->s_gender)=='male') echo "checked"?> value="Male" checked="checked">
                                        <label for="Male">Male</label>
                                    </div>
                                    <div class="wpsp-radio">
                                        <input type="radio" name="s_gender" <?php if(strtolower($stinfo->s_gender)=='female') echo "checked"; ?> value="Female">
                                        <label for="Female">Female</label>
                                    </div>
                                    <div class="wpsp-radio">
                                        <input type="radio" name="s_gender" <?php if(strtolower($stinfo->s_gender)=='other') echo "checked"; ?> value="other">
                                        <label for="other">Other</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix wpsp-ipad-show"></div>
                        <div class="wpsp-col-lg-3 wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">
                            <div class="wpsp-form-group">
                                <label class="wpsp-label" for="firstname">First Name <span class="wpsp-required">*</span></label>
                                <input type="text" class="wpsp-form-control" id="firstname" value="<?php echo !empty( $stinfo->s_fname ) ? $stinfo->s_fname : $stinfo->s_fname; ?>" name="s_fname" placeholder="First Name">
                                <?php wp_nonce_field( 'StudentEdit', 'sedit_nonce', '', true ) ?>
                                    <input type="hidden" id="studID" name="wp_usr_id" value="<?php echo $sid;?>">
                            </div>
                        </div>
                        <div class="wpsp-col-lg-3 wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">
                            <div class="wpsp-form-group">
                                <label class="wpsp-label" for="middlename">Middle Name </label>
                                <input type="text" class="wpsp-form-control" value="<?php echo !empty( $stinfo->s_mname ) ? $stinfo->s_mname : $stinfo->s_mname; ?>" id="middlename" name="s_mname" placeholder="Middle Name">
                            </div>
                        </div>
                        <div class="wpsp-col-lg-3 wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">
                            <div class="wpsp-form-group">
                                <label class="wpsp-label" for="lastname">Last Name <span class="wpsp-required">*</span></label>
                                <input type="text" class="wpsp-form-control" id="lastname" value="<?php echo !empty( $stinfo->s_lname ) ? $stinfo->s_lname : $stinfo->s_lname; ?>" name="s_lname" placeholder="Last Name" required="required">
                            </div>
                        </div>
                        <div class="wpsp-col-lg-3 wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">
                            <div class="wpsp-form-group">
                                <label class="wpsp-label" for="dateofbirth">Date of Birth</label>
                                <input type="text" class="wpsp-form-control select_date" value="<?php echo !empty( $stinfo->s_dob ) ? wpsp_ViewDate($stinfo->s_dob) : ''; ?>" id="Dob" name="s_dob" placeholder="mm/dd/yyyy">
                            </div>
                        </div>
                        <div class="wpsp-col-lg-3 wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">
                            <div class="wpsp-form-group">
                                <label class="wpsp-label" for="bloodgroup">Blood Group</label>
                                <select class="wpsp-form-control" id="Bloodgroup" name="s_bloodgrp">
                                    <option value="">Select Blood Group</option>
                                    <option <?php if ($stinfo->s_bloodgrp == 'O+') echo "selected"; ?> value="O+">O +</option>
                                    <option <?php if ($stinfo->s_bloodgrp == 'O-') echo "selected"; ?> value="O-">O -</option>
                                    <option <?php if ($stinfo->s_bloodgrp == 'A+') echo "selected"; ?> value="A+">A +</option>
                                    <option <?php if ($stinfo->s_bloodgrp == 'A-') echo "selected"; ?> value="A-">A -</option>
                                    <option <?php if ($stinfo->s_bloodgrp == 'B+') echo "selected"; ?> value="B+">B +</option>
                                    <option <?php if ($stinfo->s_bloodgrp == 'B-') echo "selected"; ?> value="B-">B -</option>
                                    <option <?php if ($stinfo->s_bloodgrp == 'AB+') echo "selected"; ?> value="AB+">AB +</option>
                                    <option <?php if ($stinfo->s_bloodgrp == 'AB-') echo "selected"; ?> value="AB-">AB -</option>
                                </select>
                            </div>
                               </div>
                            <div class="wpsp-col-lg-3 wpsp-col-md-3 wpsp-col-sm-4 wpsp-col-xs-12">
                                <div class="wpsp-form-group">
                                        <label class="wpsp-label" for="s_p_phone">Phone Number</label>
                                        <input type="text" class="wpsp-form-control" id="s_p_phone" name="s_p_phone" value="<?php echo $stinfo->p_phone;?>" placeholder="Phone Number" onkeypress='return event.keyCode == 8 || event.keyCode == 46
 || event.keyCode == 37 || event.keyCode == 39 || event.charCode >= 48 && event.charCode <= 57'>
                                        <small>(Please enter country code with mobile number)</small>
                                        <input type="hidden" name="parentid" id="parentid" value="<?php echo $stinfo->parent_wp_usr_id;?>"/>
                                    </div>

                            
                        </div>
                        <div class="wpsp-col-xs-12">
                            <hr />
                            <h4 class="card-title mt-5">Address</h4>
                        </div>
                        <div class="wpsp-col-xs-12">
                            <div class="wpsp-form-group">
                                <label class="wpsp-label" for="Address">Current Address <span class="wpsp-required">*</span></label>
                                <input type="text" name="s_address" class="wpsp-form-control" rows="4" id="current_address" value="<?php echo $stinfo->s_address; ?>" placeholder="Street Address" />
                            </div>
                        </div>
                        <div class="wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">
                            <div class="wpsp-form-group ">
                                <label class="wpsp-label" for="CityName">City Name</label>
                                <input type="text" class="wpsp-form-control" id="current_city" value="<?php echo $stinfo->s_city; ?>" name="s_city" placeholder="City Name">
                            </div>
                        </div>
                        <div class="wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">
                            <div class="wpsp-form-group">
                                <label class="wpsp-label" for="Country">Country</label>
                                <?php $countrylist = wpsp_county_list(); ?>
                                    <select class="wpsp-form-control" id="current_country" name="s_country">
                                        <option value="">Select Country</option>
                                        <?php foreach ($countrylist as $key => $value) { ?>
                                            <option value="<?php echo $value; ?>" <?php echo selected($stinfo->s_country, $value); ?>>
                                                <?php echo $value; ?>
                                            </option>
                                            <?php
                                            }
                                            ?>
                                    </select>
                            </div>
                        </div>
                        <div class="wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">
                            <div class="wpsp-form-group">
                                <label class="wpsp-label" for="Pincode">Pin Code<span class="wpsp-required">*</span></label>
                                <input type="text" class="wpsp-form-control" id="current_pincode" value="<?php echo $stinfo->s_zipcode; ?>" name="s_zipcode" placeholder="Pin Code">
                            </div>
                        </div>
                        <div class="wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">
                            <div class="wpsp-form-group">
                                <input type="checkbox" id="sameas" value="1" onclick="sameAsAbove()">
                                <label for="sameas"> Same as Above </label>
                            </div>
                        </div>
                        <div class="wpsp-col-xs-12">
                            <div class="wpsp-form-group">
                                <div class="wpsp-form-group">
                                    <label for="PermanentAddress">Permanent Address</label>
                                    <input type="text" class="wpsp-form-control" rows="5" id="permanent_address" value="<?php echo $stinfo->s_paddress;?>" name="s_paddress">
                                </div>
                            </div>
                        </div>
                        <div class="wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">
                            <div class="wpsp-form-group">
                                <label for="City">City</label>
                                <input type="text" class="wpsp-form-control" id="permanent_city" value="<?php echo $stinfo ->s_pcity; ?>" name="s_pcity" placeholder="City Name">
                            </div>
                        </div>
                        <div class="wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">
                            <div class="wpsp-form-group">
                                <label for="Country">Country</label>
                                <?php $countrylist = wpsp_county_list(); ?>
                                    <select class="wpsp-form-control" id="permanent_country" name="s_pcountry">
                                        <option value="">Select Country</option>
                                        <?php foreach ($countrylist as $key => $value) { ?>
                                            <option value="<?php echo $value; ?>" <?php echo selected($stinfo->s_pcountry, $value); ?>>
                                                <?php echo $value; ?>
                                            </option>
                                            <?php
                                            }
                                            ?>
                                    </select>
                            </div>
                        </div>
                        <div class="wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">
                            <div class="wpsp-form-group">
                                <label for="Pincode">Pin Code<span class="wpsp-required">*</span></label>
                                <input type="text" class="wpsp-form-control" id="permanent_pincode" value="<?php echo $stinfo->s_pzipcode;?>" name="s_pzipcode" placeholder="Pin Code">
                            </div>
                        </div>
                        <div class="wpsp-col-xs-12">
                            <button type="submit" class="wpsp-btn wpsp-btn-success" id="studentform">Next</button>&nbsp;&nbsp;
                            
                        </div>
                    </div>
            </div>
        </div>
    </div>
    <div class="wpsp-col-xs-12">
        <div class="wpsp-card">
            <div class="wpsp-card-head">
                <h3 class="wpsp-card-title">Parent Detail</h3>                
            </div>
            <div class="wpsp-card-body">
                <div class="wpsp-row">
                    <div class="wpsp-col-lg-3 wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">
                        <div class="wpsp-form-group">
                            <input type="hidden" id="wpsp_locationginal" value="<?php echo admin_url();?>" />
                            <label class="customUpload btnUpload  wpsp-label">Profile Image</label>
                            <div class="wpsp-profileUp">
                                <?php if($parent_img_url == ""){?>
                                     <img class="wpsp-upAvatar" id="img_preview1"  onchange="imagePreview(this);" src="<?php echo plugins_url();?>/wpschoolpress/img/default_avtar.jpg">
                               <!--  <img class="wpsp-upAvatar" id="img_preview1" onchange="imagePreview(this);" src="<?php echo $parent_img_url;?>"> -->
                            <?php } else {?>
                                <img class="wpsp-upAvatar" id="img_preview1" onchange="imagePreview(this);" src="<?php echo $parent_img_url;?>">
                            <?php }?>
                                <div class="wpsp-upload-button"><i class="fa fa-camera"></i>
                                    <input name="p_displaypicture" class="wpsp-file-upload" id="p_displaypicture" type="file" accept="image/jpg, image/jpeg" />
                                </div>
                            </div>
                            <p class="wpsp-form-notes">* Only JPEG and JPG supported, * Max 3 MB Upload </p>
                            <label id="pdisplaypicture-error" class="error" for="pdisplaypicture" style="display: none;">
                                Please Upload Profile Image</label>
                            <p id="test" style="color:red"></p>
                        </div>
                    </div>
                    <div class="wpsp-col-lg-9 wpsp-col-md-8 wpsp-col-sm-12 wpsp-col-xs-12">
                        <div class="wpsp-form-group">
                            <label class="wpsp-label" for="p_gender">Gender</label>
                            <div class="wpsp-radio-inline">
                                <div class="wpsp-radio">
                                    <input type="radio" name="p_gender" <?php if (strtolower($stinfo->p_gender) == 'male') echo "checked" ?> value="Male" checked="checked">
                                    <label for="Male">Male</label>
                                </div>
                                <div class="wpsp-radio">
                                    <input type="radio" name="p_gender" <?php if (strtolower($stinfo->p_gender) == 'female') echo "checked"; ?> value="Female">
                                    <label for="Female">Female</label>
                                </div>
                                <div class="wpsp-radio">
                                    <input type="radio" name="p_gender" <?php if (strtolower($stinfo->p_gender) == 'other') echo "checked"; ?> value="other">
                                    <label for="other">Other</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix wpsp-ipad-show"></div>
                    <div class="wpsp-col-lg-3 wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">
                        <div class="wpsp-form-group">
                            <label class="wpsp-label" for="firstname">First Name</label>
                            <input type="text" class="wpsp-form-control" id="firstname" value="<?php echo!empty($stinfo->p_fname) ? $stinfo->p_fname : ''; ?>" name="p_fname" placeholder="Parent First Name">
                        </div>
                    </div>
                    <div class="wpsp-col-lg-3 wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">
                        <div class="wpsp-form-group">
                            <label class="wpsp-label" for="middlename">Middle Name</label>
                            <input type="text" class="wpsp-form-control" id="middlename" value="<?php echo!empty($stinfo->p_mname) ? $stinfo->p_mname : ''; ?>" name="p_mname" placeholder="Parent Middle Name" >
                        </div>
                    </div>
                    <div class="wpsp-col-lg-3 wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">
                        <div class="wpsp-form-group">
                            <label class="wpsp-label" for="lastname">Last Name </label>
                            <input type="text" class="wpsp-form-control" id="lastname" value="<?php echo!empty($stinfo->p_lname) ? $stinfo->p_lname : ''; ?>" name="p_lname" placeholder="Parent Last Name">
                        </div>
                    </div>
                    <div class="clearfix"></div>
                   <!--  <div class="wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">
                        <div class="wpsp-form-group">
                            <label class="wpsp-label" for="pEmail">Email Address</label>
                            <input class="wpsp-form-control chk-email" id="pEmail" name="pEmail" placeholder="Parent Email" type="email" value="<?php echo $parentEmail; ?>">
                        </div>
                    </div> -->
                    <div class="wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">
                        <div class="wpsp-form-group">
                            <label class="wpsp-label" for="p_edu">Education</label>
                            <input type="text" class="wpsp-form-control" value="<?php echo $stinfo->p_edu; ?>" name="p_edu" placeholder="Parent Education">
                        </div>
                    </div>
                    <div class="wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">
                        <div class="wpsp-form-group">
                            <label class="wpsp-label" for="p_profession">Profession</label>
                            <input type="text" class="wpsp-form-control" name="p_profession" value="<?php echo $stinfo->p_profession; ?>" placeholder="Parent Profession">
                        </div>
                    </div>
                    <div class="wpsp-col-lg-4 wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">
                        <div class="wpsp-form-group">
                            <label for="phone">Phone</label>
                            <input type="text" class="wpsp-form-control" id="phone" value="<?php echo $stinfo->s_phone; ?>" name="s_phone" placeholder="Phone Number" >
                        </div>
                    </div>
                     <div class="clearfix"></div>
                    <div class="wpsp-col-lg-4 wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">
                        <div class="wpsp-form-group">
                            <label for="bloodgroup">Blood Group (Optional)</label>
                            <select class="wpsp-form-control" id="Bloodgroup" name="p_bloodgrp">
                                <option value="">Select Blood Group</option>
                                <option <?php if ($stinfo->p_bloodgrp == 'O+') echo "selected"; ?> value="O+">O +</option>
                                <option <?php if ($stinfo->p_bloodgrp == 'O-') echo "selected"; ?> value="O-">O -</option>
                                <option <?php if ($stinfo->p_bloodgrp == 'A+') echo "selected"; ?> value="A+">A +</option>
                                <option <?php if ($stinfo->p_bloodgrp == 'A-') echo "selected"; ?> value="A-">A -</option>
                                <option <?php if ($stinfo->p_bloodgrp == 'B+') echo "selected"; ?> value="B+">B +</option>
                                <option <?php if ($stinfo->p_bloodgrp == 'B-') echo "selected"; ?> value="B-">B -</option>
                                <option <?php if ($stinfo->p_bloodgrp == 'AB+') echo "selected"; ?> value="AB+">AB +</option>
                                <option <?php if ($stinfo->p_bloodgrp == 'AB-') echo "selected"; ?> value="AB-">AB -</option>
                            </select>
                        </div>
                    </div>
                    <div class="wpsp-col-xs-12">
                        <button type="submit" class="wpsp-btn wpsp-btn-success" id="studentform">Next</button>&nbsp;&nbsp;
                     
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="wpsp-col-xs-12">
        <div class="wpsp-card">
            <div class="wpsp-card-head">
                <h3 class="wpsp-card-title">School Details</h3>                
            </div>
            <div class="wpsp-card-body">
                <div class="wpsp-row">
                    <div class="wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">
                        <div class="wpsp-form-group">
                            <label class="wpsp-label" for="dateofbirth">Date of Join (mm/dd/yyyy)</label>
                            <input type="text" class="wpsp-form-control select_date" id="Doj" value="<?php echo !empty( $stinfo->s_doj ) ? wpsp_ViewDate($stinfo->s_doj) : '' ; ?>" name="s_doj" placeholder="Date of Join">
                        </div>
                    </div>
                    <div class="wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">
                        <div class="wpsp-form-group">
                            <label class="wpsp-label" for="Class">Class</label>
                            <?php $class_table = $wpdb->prefix . "wpsp_class";
                                  $classes = $wpdb->get_results("select cid,c_name from $class_table");?>
                                <select class="wpsp-form-control" name="Class">
                                    <option value="">Select Class</option>
                                    <?php foreach ($classes as $class) {?>
                                        <option value="<?php echo $class->cid; ?>" <?php if ($stinfo->class_id == $class->cid) echo 'selected'; ?>>
                                            <?php echo $class->c_name; ?>
                                        </option>
                                    <?php }?>
                                </select>
                                <input type="hidden" name="prev_select_class" value="<?php echo $stinfo->class_id;?>">
                        </div>
                    </div>
                    <div class="wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">
                        <div class="wpsp-form-group">
                            <label class="wpsp-label" for="dateofbirth">Roll Number <span class="wpsp-required">*</span></label>
                            <input type="text" class="wpsp-form-control" id="Rollno" value="<?php echo $stinfo->s_rollno; ?>" name="s_rollno" placeholder="Roll Number">
                        </div>
                    </div>
                </div>
                <div class="">
                    <button type="submit" class="wpsp-btn wpsp-btn-success" id="studentform">Update</button>&nbsp;&nbsp;
                    <a href="<?php echo wpsp_admin_url();?>sch-student" class="wpsp-btn wpsp-dark-btn">Back</a>
                </div>
            </div>
        </div>
    </div>
</form>
<?php } else { echo "Sorry! No data retrieved";} ?>