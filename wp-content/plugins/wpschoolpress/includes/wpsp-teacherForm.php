<?php if (!defined( 'ABSPATH' ) )exit('No Such File');?>
<!-- This form is used for Add New Teacher -->
<div id="formresponse"></div>             
<form name="TeacherEntryForm" id="TeacherEntryForm" method="post">
   <div class="wpsp-row">   
        <div class="wpsp-col-sm-12">
            <div class="wpsp-card">                    
                 <div class="wpsp-card-head">
                    <h3 class="wpsp-card-title">Personal Details</h3>                     
                </div>    
                <div class="wpsp-card-body">
                    <?php wp_nonce_field( 'TeacherRegister', 'tregister_nonce', '', true ) ?> 
                    <div class="wpsp-row">    
                        <div class="wpsp-col-lg-3 wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">    
                            <div class="wpsp-form-group">
                                <label class="wpsp-label">Profile Image</label>
                                <div class="wpsp-profileUp">
                                    <img class="wpsp-upAvatar" id="img_preview_teacher"  src="<?php echo WPSP_PLUGIN_URL . 'img/default_avtar.jpg'?>">
                                    <div class="wpsp-upload-button"><i class="fa fa-camera"></i><input name="displaypicture" class="wpsp-file-upload" id="displaypicture" type="file" accept="image/jpg, image/jpeg" /></div>
                                </div>
                                <p class="wpsp-form-notes">* Only JPEG and JPG supported, * Max 3 MB Upload </p>
                                <label id="displaypicture-error" class="error" for="displaypicture" style="display: none;">Please Upload Profile Image</label>
                                <p id="test" style="color:red"></p></div>
                        </div>
                        <div class="wpsp-col-lg-9 wpsp-col-md-8 wpsp-col-sm-12 wpsp-col-xs-12">
                            <div class="wpsp-form-group">
                                <label class="wpsp-label" for="gender">Gender</label>
                                <div class="wpsp-radio-inline">
                                    <div class="wpsp-radio">
                                        <input type="radio" name="Gender" value="Male" checked="checked" id="Male">
                                        <label for="Male">Male</label>
                                    </div>
                                    <div class="wpsp-radio">
                                        <input type="radio" name="Gender" value="Female" id="Female">
                                        <label for="Female">Female</label>
                                    </div>
                                    <div class="wpsp-radio">
                                        <input type="radio" name="Gender" value="other" id="other">
                                        <label for="other">Other</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix wpsp-ipad-show"></div>                                        
                        <div class="wpsp-col-lg-3 wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">
                            <div class="wpsp-form-group">
                                <label class="wpsp-label" for="firstname">First Name <span class="wpsp-required">*</span></label>
                                <input type="text" class="wpsp-form-control" id="firstname" name="firstname" placeholder="First Name">
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
                                <input type="text" class="wpsp-form-control" id="lastname" name="lastname" placeholder="Last Name">
                            </div>    
                        </div>
                        <div class="clearfix"></div>
                        <div class="wpsp-col-lg-3 wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">
                            <div class="wpsp-form-group">
                                <label class="wpsp-label" for="dateofbirth">Date of Birth</label>
                                <input type="text" class="wpsp-form-control select_date" id="Dob" name="Dob" placeholder="mm/dd/yyyy" readonly>
                            </div>
                        </div>  
                        <div class="wpsp-col-lg-3 wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">
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
                        <div class="wpsp-col-lg-3 wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">
                            <div class="wpsp-form-group">
                                <label class="wpsp-label" for="phone">Phone</label>
                                <input type="text" class="wpsp-form-control" id="phone" name="Phone" placeholder="(XXX)-(XXX)-(XXXX)">
                            </div> 
                        </div>   
                        <div class="wpsp-col-lg-3 wpsp-col-md-8 wpsp-col-sm-8 wpsp-col-xs-12">
                            <div class="wpsp-form-group">
                                <label class="wpsp-label" for="educ">Qualification</label>
                                <input type="text" class="wpsp-form-control" id="Qual" name="Qual" placeholder="Highest Education Degree">
                            </div>
                        </div>                                     
                        <div class="wpsp-col-xs-12">
                            <hr />
                            <h4 class="card-title mt-5">Address</h4>
                        </div>
                        <div class="wpsp-col-xs-12">
                            <div class="wpsp-form-group">
                                <label class="wpsp-label" for="Address" >Street Address <span class="wpsp-required">*</span></label>
                                <input type="text" name="Address" class="wpsp-form-control" placeholder="Street Address" />
                            </div>
                        </div>
                        <div class="wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">
                           <div class="wpsp-form-group ">
                                <label class="wpsp-label" for="CityName">City Name</label>
                                <input type="text" class="wpsp-form-control" id="CityName" name="city" placeholder="City Name" >
                            </div> 
                        </div>
                        <div class="wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">
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
                        </div>
                        <div class="wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">
                            <div class="wpsp-form-group">
                                <label class="wpsp-label" for="Zipcode">Pin Code<span class="wpsp-required">*</span></label>
                                <input type="text" class="wpsp-form-control" id="Zipcode" name="zipcode" placeholder="Pin Code">
                            </div>    
                        </div>
                        <div class="wpsp-col-xs-12 wpsp-hidden-xs">
                            <button type="submit" class="wpsp-btn wpsp-btn-success" id="teacherform">Next</button>&nbsp;&nbsp;
                        </div>                                        
                    </div>                                    
                </div>
        </div>
    </div>
    <div class="wpsp-col-md-6 wpsp-col-sm-12">
        <div class="wpsp-card">                    
            <div class="wpsp-card-head">
                <h3 class="wpsp-card-title">Account Information</h3>
            </div>    
            <div class="wpsp-card-body">                                
               <div class="wpsp-form-group">
                    <label class="wpsp-label" for="Email">Email Address <span class="wpsp-required">*</span></label>
                    <input type="email" class="wpsp-form-control" id="Email" name="Email" placeholder="Email">
                </div>
                <div class="wpsp-form-group">
                    <label class="wpsp-label" for="Username">Username <span class="wpsp-required">*</span></label>
                    <input type="text" class="wpsp-form-control" id="Username" name="Username" placeholder="Username">
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
                    <button type="submit" class="wpsp-btn wpsp-btn-success" id="teacherform">Next</button>&nbsp;&nbsp;
                </div>
            </div>
        </div>
    </div>
    <div class="wpsp-col-md-6 wpsp-col-sm-12">
        <div class="wpsp-card">                    
            <div class="wpsp-card-head">
                <h3 class="wpsp-card-title">School Details</h3>                 
            </div> 
            <div class="wpsp-card-body">   
                <div class="wpsp-form-group">
                    <label class="wpsp-label" for="Doj">Joining Date</label>
                    <input type="text" class="wpsp-form-control select_date Doj" id="Doj" name="Doj" value="" placeholder="mm/dd/yyyy" readonly>
                </div>
                <div class="wpsp-form-group">
                    <label class="wpsp-label" for="Dol">Leaving Date</label>
                    <input type="text" class="wpsp-form-control select_date Dol" id="Dol" name="dol" value="" placeholder="mm/dd/yyyy" readonly>
                </div>
                <div class="wpsp-form-group">
                    <label class="wpsp-label" for="position">Current Position</label>
                    <input type="text" class="wpsp-form-control" id="Position" name="Position" placeholder="Designation">
                </div>
                <div class="wpsp-row">
                    <div class="wpsp-col-md-6 wpsp-col-xs-12">
                        <div class="wpsp-form-group">
                            <label class="wpsp-label" for="empcode">Employee Code</label>
                            <input type="text" class="wpsp-form-control" id="EmpCode" name="EmpCode" placeholder="Employee Code">
                        </div>        
                    </div>
                    <div class="wpsp-col-md-6 wpsp-col-xs-12">
                        <div class="wpsp-form-group">
                            <label class="wpsp-label" for="whours">Working Hours</label>
                            <input type="text" class="wpsp-form-control" id="whours" name="whours" placeholder="Working Hours">
                        </div>        
                    </div>
                </div>
                <div class="wpsp-btnsubmit-section">
                    <button type="submit" class="wpsp-btn wpsp-btn-success" id="teacherform">Submit</button>&nbsp;&nbsp;
                    <a href="<?php echo wpsp_admin_url();?>sch-teacher" class="wpsp-btn wpsp-dark-btn">Back</a>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
<!-- End of Add New Teacher Form -->