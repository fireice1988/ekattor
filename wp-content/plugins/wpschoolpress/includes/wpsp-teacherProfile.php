<?php if (!defined( 'ABSPATH' ) )exit('No Such File');
    $teacher_table=$wpdb->prefix."wpsp_teacher";
    $class_table=$wpdb->prefix."wpsp_class";
    $users_table=$wpdb->prefix."users";
    $tid=intval($_GET['id']);
    $msg =  '';
    if(isset($_GET['edit']) && sanitize_text_field($_GET['edit'])=='true')
    {
        if($current_user_role == 'administrator' || ($current_user_role == 'teacher' && sanitize_text_field($current_user->ID) == $tid)){
            $edit=true;
        }else{
            $edit=false;
        }
        if (isset( $_POST['tedit_nonce'] ) && wp_verify_nonce( sanitize_text_field($_POST['tedit_nonce']), 'TeacherEdit' )){
            ob_start();
            wpsp_UpdateTeacher();
            $msg = ob_get_clean();
        }
    }
    else{
        $edit=false;
    }
    $tinfo=$wpdb->get_row("select teacher.*,user.user_email from $teacher_table teacher LEFT JOIN $users_table user ON user.ID=teacher.wp_usr_id where teacher.wp_usr_id='$tid'");
    if(!empty($tinfo)){
    ?>
<div id="formresponse">
    <?php echo $msg; ?>
</div>
<div class="wpsp-row">
<?php if($edit) { ?>
<form name="TeacherEditForm" id="TeacherEditForm" method="POST" enctype="multipart/form-data">
<?php } ?>
    <div class="wpsp-col-xs-12">
        <div class="wpsp-card">
            <div class="wpsp-card-head">
                <h3 class="wpsp-card-title">Personal Details</h3>
                <h5 class="wpsp-card-subtitle"><?php echo $tinfo->first_name.' '.$tinfo->middle_name.' '.$tinfo->last_name;?></h5>
            </div>
            <div class="wpsp-card-body">    
                <div class="wpsp-row">
                        <div class="wpsp-col-lg-3 wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">
                            <div class="wpsp-form-group">
                                <label class="wpsp-label">Profile Image</label>
                                <div class="wpsp-profileUp">
                                    <?php 
                                    $loc_avatar =   get_user_meta($tid,'simple_local_avatar',true);
                                    $img_url    =   $loc_avatar ? $loc_avatar['full'] : WPSP_PLUGIN_URL.'img/default_avtar.jpg';
									?>
                                    <img class="wpsp-upAvatar" id="img_preview_teacher" src="<?php echo $img_url;?>">
                                    <div class="wpsp-upload-button">
                                        <?php if($edit) { ?>
                                            <i class="fa fa-camera"></i>
                                            <input type="file" name="displaypicture" class="wpsp-file-upload" id="displaypicture">
                                            
                                        <?php } ?>
                                    </div>  
                                </div>
                                <p class="wpsp-form-notes">* Only JPEG and JPG supported, * Max 3 MB Upload </p>
                                <label id="displaypicture-error" class="error" for="displaypicture" style="display: none;">Please Upload Profile Image</label>
                                <p id="test" style="color:red"></p>
                            </div>
                        </div>
                        <div class="wpsp-col-lg-9 wpsp-col-md-8 wpsp-col-sm-12 wpsp-col-xs-12">
                            <div class="wpsp-form-group">
                                <label class="wpsp-label" for="gender">Gender</label>
                                <div class="wpsp-radio-inline">
                                    <?php if($edit){?>
                                        <div class="wpsp-radio">
                                            <input type="radio" name="Gender" <?php if($tinfo->gender=='Male') echo "checked";?> value="Male">
                                            <label for="Male">Male</label>
                                        </div>
                                        <div class="wpsp-radio">
                                            <input type="radio" name="Gender" <?php if($tinfo->gender=='Female') echo "checked";?> value="Female">
                                            <label for="Female">Female</label>
                                        </div>
                                        <div class="wpsp-radio">
                                            <input type="radio" name="Gender" <?php if($tinfo->gender=='other') echo "checked";?> value="other">
                                            <label for="other">Other</label>
                                        </div>
                                        <?php }
                                        else{
                                                echo $tinfo->gender;
                                        }       
                                    ?>
                                </div>
                            </div>
                        </div>
                        <?php wp_nonce_field( 'TeacherRegister', 'tregister_nonce', '', true ) ?>
                        <div class="clearfix wpsp-ipad-show"></div>
                        <div class="wpsp-col-lg-3 wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">
                            <div class="wpsp-form-group">
                                <label class="wpsp-label" for="firstname">First Name <span class="wpsp-required">*</span></label>
                                <input type="text" class="wpsp-form-control" value="<?php echo $tinfo->first_name;?>" id="firstname" name="firstname" placeholder="First Name">
                                <input type="hidden" id="wpsp_locationginal" value="<?php echo admin_url();?>" />
                                <input type="hidden" id="UserID" name="UserID" value="<?php echo $tinfo->wp_usr_id; ?>">
                            </div>
                        </div>
                        <div class="wpsp-col-lg-3 wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">
                            <div class="wpsp-form-group">
                                <label class="wpsp-label" for="middlename">Middle Name</label>
                                <input type="text" class="wpsp-form-control" id="name" name="middlename" value="<?php echo $tinfo->middle_name ;?>" placeholder="Middle Name">
                            </div>
                        </div>
                        <div class="wpsp-col-lg-3 wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">
                            <div class="wpsp-form-group">
                                <label class="wpsp-label" for="lastname">Last Name
                                    <?php if( $edit ) {?><span class="wpsp-required">*</span>
                                        <?php }?>
                                            </span>
                                </label>
                                <input type="text" class="wpsp-form-control" id="name" name="lastname" value="<?php echo $tinfo->last_name; ?>" placeholder="Last Name">
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="wpsp-col-lg-3 wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">
                            <div class="wpsp-form-group">
                                <label class="wpsp-label" for="dateofbirth">Date of Birth</label>
                                <?php if($edit){?>
                                     <input type="text" class="wpsp-form-control select_date datepicker" value="<?php if($tinfo->dob == "0000-00-00"){ } else { echo wpsp_viewDate($tinfo->dob);} ?>" id="Dob" name="Dob" placeholder="Date of Birth">
                                    <?php } else {
                                        echo wpsp_viewDate($tinfo->dob);
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="wpsp-col-lg-3 wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">
                            <div class="wpsp-form-group">
                                <label class="wpsp-label" for="Email">Email Address<span class="wpsp-required"> *</span></label>
                                <?php if($edit) { ?>
                                    <input type="email" class="wpsp-form-control" id="Email" name="Email" value="<?php echo $tinfo->user_email; ?>" placeholder="Teacher Email">
                                    <?php } else echo $tinfo->user_email; ?>
                            </div>
                        </div>
                        <div class="wpsp-col-lg-3 wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">
                            <div class="wpsp-form-group">
                                <label class="wpsp-label" for="address">Current Address<span class="wpsp-required"> *</label>
                                <?php if($edit) { ?>
                                <textarea name="Address" class="wpsp-form-control" rows="1"><?php echo $tinfo->address; ?></textarea>
                                <?php } else  echo $tinfo->address; ?>
                            </div>
                        </div>
                        <div class="wpsp-col-lg-3 wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">
                            <div class="wpsp-form-group">
                                <label class="wpsp-label" for="CityName">City Name</label>
                                <?php if($edit) { ?>
                                <input type="text" class="wpsp-form-control" id="CityName" name="city" placeholder="City Name" value="<?php echo $tinfo->city;?>">
                                <?php } else  echo $tinfo->city; ?>
                            </div>
                        </div>  
                        <div class="wpsp-col-lg-3 wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">
                            <div class="wpsp-form-group">
                                <label class="wpsp-label" for="Country">Country</label>
                                <?php if($edit) { $countrylist = wpsp_county_list(); ?>
                                <select class="wpsp-form-control" id="Country" name="country">
                                    <option value="">Select Country</option>
                                    <?php 
                                        foreach( $countrylist as $key=>$value ) { ?>
                                    <option value="<?php echo $value;?>" <?php echo selected( $tinfo->country, $value ); ?>><?php echo $value;?></option>
                                    <?php }?>
                                </select>
                                <?php } else echo $stinfo->country; ?>
                            </div>
                        </div>
                        <div class="wpsp-col-lg-3 wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">
                            <div class="wpsp-form-group">
                                <label class="wpsp-label" for="Zip Code">Pin Code<span class="wpsp-required"> *</label></label>
                                <?php if($edit) { ?>
                                <input type="text" name="zipcode" class="wpsp-form-control" value="<?php echo $tinfo->zipcode; ?>">
                                <?php } else  echo $stinfo->zipcode;
                                    ?>
                            </div>
                        </div>  
                        <div class="wpsp-col-lg-3 wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">
                            <div class="wpsp-form-group">
                                <label class="wpsp-label" for="Phone">Phone Number</label>
                                <?php if($edit) { ?>
                                <input type="text" class="wpsp-form-control" id="Phone" name="Phone" value="<?php echo $tinfo->phone; ?>" placeholder="(XXX)-(XXX)-(XXXX)">
                                <?php } else echo $tinfo->phone; ?>
                            </div>
                        </div>
                        <div class="wpsp-col-lg-3 wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">
                            <div class="wpsp-form-group">
                            <label class="wpsp-label" for="Blood">Blood Group</label>
                            <?php   if($edit) { ?>
                            <select class="wpsp-form-control" id="Bloodgroup" name="Bloodgroup">
                                <option value="">Select Blood Group</option>
                                <option <?php if($tinfo->bloodgrp=='O+') echo "selected"; ?> value="O+">O +</option>
                                <option <?php if($tinfo->bloodgrp=='O-') echo "selected"; ?> value="O-">O -</option>
                                <option <?php if($tinfo->bloodgrp=='A+') echo "selected"; ?> value="A+">A +</option>
                                <option <?php if($tinfo->bloodgrp=='A-') echo "selected"; ?> value="A-">A -</option>
                                <option <?php if($tinfo->bloodgrp=='B+') echo "selected"; ?> value="B+">B +</option>
                                <option <?php if($tinfo->bloodgrp=='B-') echo "selected"; ?> value="B-">B -</option>
                                <option <?php if($tinfo->bloodgrp=='AB+') echo "selected"; ?> value="AB+">AB +</option>
                                <option <?php if($tinfo->bloodgrp=='AB-') echo "selected"; ?> value="AB-">AB -</option>
                            </select>
                            <?php
                                }
                                else
                                    echo $tinfo->bloodgrp;
                                ?>
                            </div>  
                        </div>
                        <div class="wpsp-col-lg-3 wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">
                            <div class="wpsp-form-group">
                                <label class="wpsp-label" for="Qualification">Qualification</label>
                                <?php if($edit) { ?>
                                <input type="text" class="wpsp-form-control" id="Qual" name="Qual" value="<?php echo $tinfo->qualification; ?>" placeholder="Qualification">
                                <?php } else echo $tinfo->qualification; ?> 
                            </div>  
                        </div>
                        <div class="wpsp-col-xs-12">
                            <?php if($edit){ ?> 
                                    <button type="submit" id="u_teacher" class="wpsp-btn wpsp-btn-success">Next</button>
                                   <!--  <a href='<?php echo wpsp_admin_url();?>sch-teacher' class="wpsp-btn wpsp-dark-btn">Back</a> -->
                                    
                            <?php }else {   ?>
                                    <a href="?id=<?php echo $tinfo->wp_usr_id; ?>&edit=true" type="button" class="wpsp-btn wpsp-btn-sm wpsp-btn-warning"><i class="icon dashicons dashicons-edit wpsp-edit-icon"></i></a>
                                    <a data-original-title="Remove this user" type="button" class="wpsp-btn wpsp-btn-sm wpsp-btn-danger"><i class="icon dashicons dashicons-trash wpsp-delete-icon"></i></a>
                            <?php } ?>
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
                            <label class="wpsp-label" for="Join">Joining Date (mm/dd/yyyy)</label>
                            <?php  if($edit) {?>
                            <input type="text" class="wpsp-form-control select_date" value="<?php if(wpsp_viewDate($tinfo->doj) == "0000-00-00"){ }else { echo wpsp_viewDate($tinfo->doj);} ?>" id="Doj" name="Doj" placeholder="Date of Join">
                            <?php } else echo wpsp_viewDate($tinfo->doj); ?>
                        </div>
                    </div>
                    <div class="wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">
                        <div class="wpsp-form-group">
                            <label class="wpsp-label" for="Releaving">Leaving Date (mm/dd/yyyy)</label>
                            <?php  if($edit) { ?>
                            <input type="text" class="wpsp-form-control select_date" value="<?php if(wpsp_viewDate($tinfo->dol) == "0000-00-00"){}else { echo wpsp_viewDate($tinfo->dol);} ?>" id="Dol" name="dol" placeholder="Date of Leave">
                            <?php } else echo wpsp_viewDate($tinfo->dol); ?>
                        </div>
                    </div>
                    <div class="wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">
                        <div class="wpsp-form-group">
                            <label class="wpsp-label" for="Working">Working Hours</label>
                            <?php  if($edit) { ?>
                            <input type="text" name="whours" class="wpsp-form-control" value="<?php echo $tinfo->whours; ?>">
                            <?php } else echo $tinfo->whours; ?>
                        </div>
                    </div>
                    <div class="wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">
                        <div class="wpsp-form-group">
                            <label class="wpsp-label" for="Position">Current Position</label>
                            <?php if($edit){ ?>
                            <input type="text" class="wpsp-form-control" id="Position" name="Position" value="<?php echo $tinfo->position; ?>" placeholder="Position">
                            <?php } else 
                                    echo $tinfo->position;
                            ?> 
                        </div>
                    </div>
                    <div class="wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">
                        <div class="wpsp-form-group">
                            <label class="wpsp-label" for="Employee">Employee Code</label>
                                <?php 
                                if($edit){
                                    if($current_user_role=='administrator'){                                        
                                ?>
                                    <input type="text" class="wpsp-form-control" id="Empcode" name="Empcode" value="<?php echo $tinfo->empcode; ?>" placeholder="Empcode">
                                <?php } } else{
                                echo $tinfo->empcode;}
                                ?> 
                        </div>
                    </div>
                    <div class="wpsp-col-xs-12">
                    <?php if($edit){ ?> 
                            <button type="submit" id="u_teacher" class="wpsp-btn wpsp-btn-success">Update</button>
                            <a href='<?php echo wpsp_admin_url();?>sch-teacher' class="wpsp-btn wpsp-dark-btn">Back</a>     
                    <?php }else {   ?>
                            <a href="?id=<?php echo $tinfo->wp_usr_id; ?>&edit=true" type="button" class="btn btn-sm btn-warning"><i class="glyphicon glyphicon-edit"></i></a>
                            <a data-original-title="Remove this user" type="button" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-remove"></i></a>
                    <?php } ?>
                    </form>
                    </div> 
                    </div> 
                </div>
            </div>
        </div>
    </div>                  
<?php } 
else { echo "Sorry!No data retrived"; } ?>
<!--<a href="javascript:;" id="sucess_teacher" class="wpsp-popclick" data-pop="SuccessModal" title="Delete" style="display:none;">a</a> -->
<div class="wpsp-popupMain wpsp-popVisible" id="SuccessModal" data-pop="SuccessModal" style="display:none;">
		  <div class="wpsp-overlayer"></div> 
		  <div class="wpsp-popBody wpsp-alert-body"> 
		    <div class="wpsp-popInner">
		    	<a href="javascript:;" class="wpsp-closePopup"></a>
				<div class="wpsp-popup-cont wpsp-alertbox wpsp-alert-success">
					<div class="wpsp-alert-icon-box"> 
						<i class="icon wpsp-icon-tick-mark"></i>
					</div>
					<div class="wpsp-alert-data">
						<input type="hidden" name="teacherid" id="teacherid">
						<h4>Success</h4>
						<p>Data Saved Successfully.</p>
					</div>
					
				</div>
		    </div>
		  </div>
</div>
