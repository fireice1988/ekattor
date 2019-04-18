<?php if (!defined( 'ABSPATH' ) )exit('No Such File');?>
<!-- This form is used for Add New Student -->
<div id="formresponse"></div>
<form name="StudentEntryForm" id="StudentEntryForm" method="POST" enctype="multipart/form-data"><div class="wpsp-col-xs-12">
    <div class="wpsp-row">
    <div class="wpsp-card">
                <div class="wpsp-card-head">
                    <h3 class="wpsp-card-title">Personal Details</h3>                     
                </div> 
                <div class="wpsp-card-body">
                     <?php wp_nonce_field('StudentRegister', 'sregister_nonce', '', true) ?>                               
                    <div class="wpsp-row">  
                        <div class="wpsp-col-lg-3 wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">    
                                <div class="wpsp-form-group">
                                    <label class="wpsp-label displaypicture">Profile Image</label>
                                    <div class="wpsp-profileUp">
                                        <img class="wpsp-upAvatar" id="img_preview"  src="<?php echo plugins_url();?>/wpschoolpress/img/default_avtar.jpg">
                                        <div class="wpsp-upload-button"><i class="fa fa-camera"></i>
                                        <input name="displaypicture"  class="wpsp-file-upload" id="displaypicture" type="file" accept="image/jpg, image/jpeg" />
                                        </div>
                                    </div>
                                    <p class="wpsp-form-notes">* Only JPEG and JPG supported, * Max 3 MB Upload </p>
                                    <!-- <label id="displaypicture-error" class="error" for="displaypicture" style="display: none;">Please Upload Profile Image</label> -->
                                    <p id="test" style="color:red"></p>                                             
                                </div>
                        </div>
                        <div class="wpsp-col-lg-9 wpsp-col-md-8 wpsp-col-sm-12 wpsp-col-xs-12">
                                <div class="wpsp-form-group">
                                    <label class="wpsp-label" for="gender">Gender</label>
                                    <div class="wpsp-radio-inline">
                                        <div class="wpsp-radio">
                                            <input type="radio" name="s_gender" value="Male" checked="checked" id="Male">
                                            <label for="Male">Male</label>
                                        </div>
                                        <div class="wpsp-radio">
                                            <input type="radio" name="s_gender" value="Female" id="Female">
                                            <label for="Female">Female</label>
                                        </div>
                                        <div class="wpsp-radio">
                                            <input type="radio" name="s_gender" value="other" id="other">
                                            <label for="other">Other</label>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <div class="clearfix wpsp-ipad-show"></div>
                        <input type="hidden"  id="wpsp_locationginal1" value="<?php echo admin_url();?>"/>
                        <div class="clearfix wpsp-ipad-show"></div>                                        
                        <div class="wpsp-col-lg-3 wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">
                            <div class="wpsp-form-group">
                                <label class="wpsp-label" for="firstname">First Name <span class="wpsp-required">*</span></label>
                                <input type="text" class="wpsp-form-control" id="firstname" name="s_fname" placeholder="First Name">
                                <input type="hidden"  id="wpsp_locationginal" value="<?php echo admin_url();?>"/>
                            </div>    
                        </div>
                                
                        <div class="wpsp-col-lg-3 wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">
                            <div class="wpsp-form-group">
                                <label class="wpsp-label" for="middlename">Middle Name</label>
                                <input type="text" class="wpsp-form-control" id="middlename" name="middlename" placeholder="Middle Name">
                            </div>
                        </div>
                                
                        <div class="wpsp-col-lg-3 wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">
                            <div class="wpsp-form-group">
                                <label class="wpsp-label" for="lastname">Last Name <span class="wpsp-required">*</span></label>
                                <input type="text" class="wpsp-form-control" id="lastname" name="s_lname" placeholder="Last Name">
                            </div>    
                        </div>
                        <div class="clearfix"></div>
                        <div class="wpsp-col-lg-3 wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">
                            <div class="wpsp-form-group">
                                <label class="wpsp-label" for="dateofbirth">Date of Birth</label>
                                <input type="text" class="wpsp-form-control select_date" id="Dob" name="s_dob" placeholder="mm/dd/yyyy" readonly>
                            </div>
                        </div>
                        <div class="wpsp-col-lg-3 wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">
                            <div class="wpsp-form-group">
                                <label class="wpsp-label" for="bloodgroup">Blood Group</label>
                                <select class="wpsp-form-control" id="Bloodgroup" name="s_bloodgrp">
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
                        <div class="wpsp-col-lg-3 wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">
                            <div class="wpsp-form-group">
                                        <label class="wpsp-label"  for="s_p_phone">Phone Number</label>
                                        <input type="text" class="wpsp-form-control" id="s_p_phone" name="s_p_phone" placeholder="Phone Number" onkeypress='return event.keyCode == 8 || event.keyCode == 46
 || event.keyCode == 37 || event.keyCode == 39 || event.charCode >= 48 && event.charCode <= 57'>
                                        <small>(Please enter country code with mobile number)</small>
                                    </div>
                                </div>
                        <div class="wpsp-col-xs-12">
                            <hr />
                            <h4 class="card-title mt-5">Address</h4>
                        </div>       
                        <div class="wpsp-col-xs-12">
                            <div class="wpsp-form-group">
                                <label class="wpsp-label" for="Address">Current Address <span class="wpsp-required">*</span></label>
                                <input type="text" name="s_address" class="wpsp-form-control" rows="4" id="current_address" placeholder="Street Address" />
                            </div>
                        </div>       
                        <div class="wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">
                           <div class="wpsp-form-group ">
                                <label class="wpsp-label" for="CityName">City Name</label>
                                <input type="text" class="wpsp-form-control" id="current_city" name="s_city" placeholder="City Name" >
                            </div> 
                        </div>
                        <div class="wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">
                            <div class="wpsp-form-group">
                                <label class="wpsp-label" for="Country">Country</label>
                                <?php $countrylist = wpsp_county_list();?>
                                <select class="wpsp-form-control" id="current_country" name="s_country" >
                                    <option value="">Select Country</option>
                                    <?php 
                                        foreach( $countrylist as $key=>$value ) { ?>
                                    <option value="<?php echo $value;?>"><?php echo $value;?></option>
                                    <?php   
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">
                            <div class="wpsp-form-group">
                                <label class="wpsp-label" for="Zipcode">Pin Code<span class="wpsp-required">*</span></label>
                                <input type="text" class="wpsp-form-control" id="current_pincode" name="s_zipcode" placeholder="Pin Code">
                            </div>    
                        </div>
                        <div class="wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">                
                            <div class="wpsp-form-group">
                                <input type="checkbox"  id="sameas" value="1" class="wpsp-checkbox"> <label for="sameas"> Same as Above </label>
                            </div>
                        </div>  
                        
                        <div class="wpsp-col-xs-12">
                            <div class="wpsp-form-group">
                                <div class="wpsp-form-group">
                                    <label for="Address">Permanent Address</label>
                                    <input type="text" class="wpsp-form-control" rows="5" id="permanent_address" name="s_paddress" placeholder="Permanent Address"> 
                                </div>
                            </div>  
                        </div>  
                        <div class="wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">
                            <div class="wpsp-form-group">
                                <label class="wpsp-label" for="Zipcode">City Name</label>
                                <input type="text " class="wpsp-form-control" id="permanent_city" name="s_pcity" placeholder="City Name">
                            </div>
                        </div>          
                        <div class="wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">
                            <div class="wpsp-form-group">
                                <label class="wpsp-label" for="Zipcode">Country</label>
                                <select class="wpsp-form-control" id="permanent_country"  name="s_pcountry">
                                    <option value="">Select Country</option>
                                    <?php foreach ($countrylist as $key => $value) { ?>
                                        <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">
                            <div class="wpsp-form-group">
                                <label class="wpsp-label" for="Zipcode">Pin Code<span class="wpsp-required">*</span></label> 
                                   <input type="text" class="wpsp-form-control" id="permanent_pincode" name="s_pzipcode" placeholder="Pin Code">
                            </div>
                        </div>  
                              
                        <div class="wpsp-col-xs-12 wpsp-hidden-xs">
                            <button type="submit" class="wpsp-btn wpsp-btn-success" id="studentform">Next</button>&nbsp;&nbsp;
                           <!--  <a href="<?php echo wpsp_admin_url();?>sch-student" class="wpsp-btn wpsp-dark-btn">Back</a> -->
                        </div>        
                    </div>                                    
                </div>
        </div>
    
      <div class="wpsp-row">
       <div class="wpsp-col-xs-12">
        <div class="wpsp-card">                    
            <div class="wpsp-card-head">
                <h3 class="wpsp-card-title">Parent Detail</h3>                 
            </div> 
            
            <div class="wpsp-card-body">
                <div class="wpsp-row"> 
                    <div class="wpsp-col-lg-3 wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">    
                            <div class="wpsp-form-group">
                                <label class="customUpload btnUpload  wpsp-label">Profile Image</label>
                                <div class="wpsp-profileUp">
                                    <img class="wpsp-upAvatar" id="img_preview1"  src="<?php echo plugins_url();?>/wpschoolpress/img/default_avtar.jpg">
                                    <!-- <img class="wpsp-upAvatar" id="img_preview1"  src="http://betatesting87.com/wpschoolpresstest/wp-content/plugins/wpschoolpress/img/default_avtar.jpg"> -->
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
                                        <input type="radio" name="p_gender" value="Male" checked="checked" id="p_Male">
                                        <label for="Male">Male</label>
                                    </div>
                                    <div class="wpsp-radio">
                                        <input type="radio" name="p_gender" value="Female" id="p_Female">
                                        <label for="Female">Female</label>
                                    </div>
                                    <div class="wpsp-radio">
                                        <input type="radio" name="p_gender" value="other" id="p_other">
                                        <label for="other">Other</label>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="clearfix wpsp-ipad-show"></div>                                        
                    <div class="wpsp-col-lg-3 wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">
                        <div class="wpsp-form-group">
                            <label class="wpsp-label" for="firstname">First Name <!-- <span class="wpsp-required">*</span> --></label>
                            <input type="text" class="wpsp-form-control" id="p_firstname" name="p_fname" placeholder="First Name">
                            
                        </div>    
                    </div>
                    <div class="wpsp-col-lg-3 wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">
                        <div class="wpsp-form-group">
                            <label class="wpsp-label" for="middlename">Middle Name</label>
                            <input type="text" class="wpsp-form-control" id="p_middlename" name="p_mname" placeholder="Middle Name">
                        </div>
                    </div>
                    <div class="wpsp-col-lg-3 wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">
                        <div class="wpsp-form-group">
                            <label class="wpsp-label" for="lastname">Last Name <!-- <span class="wpsp-required">*</span> --></label>
                            <input type="text" class="wpsp-form-control" id="p_lastname" name="p_lname" placeholder="Last Name">
                        </div>    
                    </div>
                    <div class="clearfix"></div>
                    
                    
                    <div class="wpsp-col-md-3 wpsp-col-sm-4 wpsp-col-xs-12">                
                        <div class="wpsp-form-group">
                            <label class="wpsp-label" for="Username">Username <!-- <span class="wpsp-required">*</span> --></label>
                            <input type="text" class="wpsp-form-control chk-username" id="p_username" name="pUsername" placeholder="Username">
                        </div>
                    </div>
                    
                    <div class="wpsp-col-md-3 wpsp-col-sm-4 wpsp-col-xs-12">
                        <div class="wpsp-form-group">
                            <label class="wpsp-label" for="Password">Password <!-- <span class="wpsp-required">*</span> --></label>
                            <input type="password" class="wpsp-form-control" id="p_password" name="pPassword" placeholder="Password">
                        </div>
                    </div>
                    
                    <div class="wpsp-col-md-3 wpsp-col-sm-4 wpsp-col-xs-12">
                        <div class="wpsp-form-group">
                            <label class="wpsp-label" for="ConfirmPassword">Confirm Password <!-- <span class="wpsp-required">*</span> --></label>
                            <input type="password" class="wpsp-form-control" id="p_confirmpassword" name="pConfirmPassword"  placeholder="Confirm Password">
                        </div> 
                    </div>
                    
                    <div class="wpsp-col-md-3 wpsp-col-sm-4 wpsp-col-xs-12">
                            <div class="wpsp-form-group">
                                <label class="wpsp-label" for="pbloodgroup">Blood Group</label>
                                <select class="wpsp-form-control" id="p_bloodgroup" name="p_bloodgroup">
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
                    
                    <div class="wpsp-col-md-3 wpsp-col-sm-4 wpsp-col-xs-12">
                        <div class="wpsp-form-group">
                            <label class="wpsp-label" for="pEmail">Email Address<!-- <span class="wpsp-required"> *</span> --></label>
                            <input class="wpsp-form-control chk-email" id="pEmail" name="pEmail" placeholder="Parent Email" type="email">
                        </div>
                    </div>
                    <div class="wpsp-col-md-3 wpsp-col-sm-4 wpsp-col-xs-12">
                            <div class="wpsp-form-group">
                                <label class="wpsp-label" for="phone">Phone</label>
                                <input type="text" class="wpsp-form-control" id="phone" name="s_phone" placeholder="Phone Number">
                            </div> 
                    </div> 
                    <div class="wpsp-col-md-3 wpsp-col-sm-6 wpsp-col-xs-12">
                        <div class="wpsp-form-group">
                            <label class="wpsp-label" for="p_edu">Education</label>
                            <input type="text" class="wpsp-form-control" name="p_edu"  placeholder="Parent Education" id="p_edu">
                        </div>
                    </div>  
                    
                    <div class="wpsp-col-md-3 wpsp-col-sm-6 wpsp-col-xs-12">
                        <div class="wpsp-form-group">
                            <label class="wpsp-label" for="p_profession">Profession</label>
                            <input type="text" class="wpsp-form-control" name="p_profession"  placeholder="Parent Profession" id="p_profession">
                        </div>
                    </div>
                    
                    <div class="wpsp-col-xs-12 wpsp-hidden-xs">
                        <button type="submit" class="wpsp-btn wpsp-btn-success" id="studentform">Next</button>&nbsp;&nbsp;
                        <!-- <a href="<?php echo wpsp_admin_url();?>sch-student" class="wpsp-btn wpsp-dark-btn">Back</a> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
      <div class="wpsp-row">
    <div class="wpsp-col-lg-6 wpsp-col-md-6  wpsp-col-sm-6 wpsp-col-xs-12">
        <div class="wpsp-card">                    
            <div class="wpsp-card-head">
                <h3 class="wpsp-card-title">Account Information</h3>                 
            </div>    
            <div class="wpsp-card-body">                                
               <div class="wpsp-form-group">
                    <label class="wpsp-label" for="Email">Email Address <span class="wpsp-required">*</span></label>
                    <input type="email" class="wpsp-form-control chk-email" id="Email" name="Email" placeholder="Email">
                </div>
                <div class="wpsp-form-group">
                    <label class="wpsp-label" for="Username">Username <span class="wpsp-required">*</span></label>
                    <input type="text" class="wpsp-form-control chk-username" id="Username" name="Username" placeholder="Username">
                </div>
                <div class="wpsp-form-group">
                    <label class="wpsp-label" for="Password">Password <span class="wpsp-required">*</span></label>
                    <input type="password" class="wpsp-form-control" id="Password" name="Password" placeholder="Password">
                </div>
                <div class="wpsp-form-group">
                    <label class="wpsp-label" for="ConfirmPassword">Confirm Password <span class="wpsp-required">*</span></label>
                    <input type="password" class="wpsp-form-control" id="ConfirmPassword" name="ConfirmPassword" placeholder="Confirm Password">
                </div> 
                <div class="wpsp-hidden-xs">
                    <button type="submit" class="wpsp-btn wpsp-btn-success" id="studentform">Next</button>&nbsp;&nbsp;
                    <!-- <a href="<?php echo wpsp_admin_url();?>sch-student" class="wpsp-btn wpsp-dark-btn">Back</a> -->
                </div>
            </div>
        </div>
    </div>  
    <div class="wpsp-col-lg-6 wpsp-col-md-6  wpsp-col-sm-6 wpsp-col-xs-12">
        <div class="wpsp-card">                    
            <div class="wpsp-card-head">
                <h3 class="wpsp-card-title">School Details</h3>                 
            </div> 
            <div class="wpsp-card-body">   
                <div class="wpsp-form-group">
                    <label class="wpsp-label" for="Doj">Joining Date</label>
                    <input type="text" class="wpsp-form-control select_date Doj" id="Doj" name="s_doj" value="<?php echo date('m/d/Y'); ?>" placeholder="mm/dd/yyyy" readonly>
                </div>
         
                <div class="wpsp-row">
                    <div class="wpsp-col-md-12 wpsp-col-xs-12">
                        <div class="wpsp-form-group">
                            <label class="wpsp-label" for="empcode">Class</label>
                            <?php
                            $class_table = $wpdb->prefix . "wpsp_class";
                            $classes = $wpdb->get_results("select cid,c_name from $class_table");
                            ?>
                            <select class="wpsp-form-control" name="Class">
                                <option value="">Select Class</option>
                                <?php
                                foreach ($classes as $class) {
                                    ?>
                                    <option value="<?php echo $class->cid; ?>"><?php echo $class->c_name; ?></option>
                                    <?php
                                }
                                ?>
                            </select> 
                        </div>        
                    </div>
                    <div class="wpsp-col-md-12 wpsp-col-xs-12">
                        <div class="wpsp-form-group">
                            <label class="wpsp-label" for="dateofbirth">Roll Number<span class="wpsp-required"> *</span></label>
                            <input type="text" class="wpsp-form-control" id="Rollno" name="s_rollno" placeholder="Roll Number">
                        </div>  
                    </div>
                </div>
                <div class="wpsp-btnsubmit-section">
                    <button type="submit" class="wpsp-btn wpsp-btn-success" id="studentform">Submit</button>&nbsp;&nbsp;
                    <a href="<?php echo wpsp_admin_url();?>sch-student" class="wpsp-btn wpsp-dark-btn">Back</a>
                </div>
            </div>
        </div>
    </div>
    </div>                                                                                  
</form>       
<!-- End of Add New Student Form -->