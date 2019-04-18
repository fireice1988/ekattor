<?php
if (!defined( 'ABSPATH' ) )exit('No Such File');
	wpsp_header();
	if( is_user_logged_in() ) {
		global $current_user, $wp_roles, $wpdb;
		foreach ( $wp_roles->role_names as $role => $name ) :
		if ( current_user_can( $role ) )
			$current_user_role =  $role;
		endforeach;	
		
		wpsp_topbar(); 
		wpsp_sidebar();
		wpsp_body_start();
		$proversion	=	wpsp_check_pro_version();
		//$proversion		=	wpsp_check_pro_version( 'wpsp_sms_version' ); 												
		$proclass		=	!$proversion['status'] && isset( $proversion['class'] )? $proversion['class'] : '';
		$protitle		=	!$proversion['status'] && isset( $proversion['message'] )? $proversion['message']	: '';
		$prodisable		=	!$proversion['status'] ? 'disabled="disabled"'	: '';
		
		// $paymentproversion	=	wpsp_check_pro_version( 'wpsp_payment_version' );
		// $payproclass		=	!$paymentproversion['status'] && isset( $paymentproversion['class'] )? $paymentproversion['class'] : '';
		// $payprotitle		=	!$paymentproversion['status'] && isset( $paymentproversion['message'] )? $paymentproversion['message']	: '';
		// $payprodisable		=	!$paymentproversion['status'] ? 'disabled="disabled"'	: '';
		
		if($current_user_role=='administrator') {
			$ex_field_tbl	=	$wpdb->prefix."wpsp_mark_fields";
			$subject_tbl	=	$wpdb->prefix."wpsp_subject";
			$class_tbl		=	$wpdb->prefix."wpsp_class";
		?>
		<div class="wpsp-card">			
			 
				
							<?php
							if(isset($_GET['sc'])&& sanitize_text_field($_GET['sc'])=='subField') {
								//Fields Edit Section 
								if( isset( $_GET['sid'] ) && intval($_GET['sid'])>0 ) { 
									$subject_id	=	intval($_GET['sid']);
									$fields		=	$wpdb->get_results("select f.*,s.sub_name,c.c_name from $ex_field_tbl f LEFT JOIN $subject_tbl s ON s.id=f.subject_id LEFT JOIN $class_tbl c ON c.cid=s.class_id where f.subject_id=$subject_id");
									?>
									<div class="wpsp-card-body">
								<div class="wpsp-row">
									<div class="wpsp-col-md-12 line_box wpsp-col-lg-12">
										<div class="wpsp-form-group">
										<div class="wpsp-row">										
										<div class="wpsp-col-md-3">											
											<label class="wpsp-labelMain"><?php _e( 'Class:', 'WPSchoolPress'); ?></label> <?php echo $fields[0]->c_name;?>
										</div>										
										<div class="wpsp-col-md-3">											
											<label class="wpsp-labelMain"><?php _e( 'Subject:', 'WPSchoolPress'); ?></label> <?php echo $fields[0]->sub_name;?>
										</div>
										</div>
										<input type="hidden"  id="wpsp_locationginal" value="<?php echo admin_url();?>"/>
										</div>
										<div class="wpsp-row">
										<?php
											if(count($fields)>0){
												$sno=1;
												foreach($fields as $field){ ?>
													
													
														<div class="wpsp-col-sm-6 wpsp-col-md-4">
															<div class="wpsp-form-group smf-inline-form">
															  	<input type="text" id="<?php echo intval($field->field_id);?>SF" value="<?php echo $field->field_text;?>" class="wpsp-form-control">
																<button id="sf_update" class="wpsp-btn wpsp-btn-success  SFUpdate" data-id="<?php echo intval($field->field_id);?>"><span class="dashicons dashicons-yes"></span></button> 
															  	<button id="d_teacher" class="wpsp-btn wpsp-btn-danger  popclick" data-pop="DeleteModal" data-id="<?php echo intval($field->field_id);?>"><i class="icon wpsp-trash"></i></button>
														  </div>
														</div>
											
												<?php $sno++; }
											}else{
												echo "<div class='wpsp-col-md-8 wpsp-col-md-offset-4'>".__( 'No data retrived!', 'WPSchoolPress')."</div>";
											}
										?>
										</div>
										<a href="<?php echo wpsp_admin_url();?>sch-settings&sc=subField" class="wpsp-btn wpsp-dark-btn"><?php _e( 'Back', 'WPSchoolPress'); ?></a>
									</div>

									</div>	
									</div>								
								<?php }else{
								//Subject Mark Extract fields
								$all_fields	=	$wpdb->get_results("select mfields.subject_id, GROUP_CONCAT(mfields.field_text) AS fields,class.c_name,subject.sub_name from $ex_field_tbl mfields LEFT JOIN $subject_tbl subject ON subject.id=mfields.subject_id LEFT JOIN $class_tbl class ON class.cid=subject.class_id group by mfields.subject_id");	
							?>
								<!-- <div class="subject-head">
									<div class="float-right">
										<button class="wpsp-popclick wpsp-btn wpsp-btn-success pull-right gap-bottom" data-pop="addFieldModal" id="AddFieldsButton"><i class="fa fa-plus"></i>&nbsp; Add Fields</button>										
									</div>
								</div>	 -->
							
						<!-- </div> -->
							<div class="wpsp-card-body">
								<div class="wpsp-row">
								<div class="wpsp-col-md-12 wpsp-table-responsive">
								<table id="wpsp_sub_division_table" class="wpsp-table" cellspacing="0" width="100%" style="width:100%">
								<thead>
									<tr>
										<th class="nosort">#</th>
										<th><?php _e( 'Class', 'WPSchoolPress'); ?></th>
										<th><?php _e( 'Subject', 'WPSchoolPress'); ?></th>
										<th><?php _e( 'Fields', 'WPSchoolPress'); ?></th>
										<th><?php _e( 'Action', 'WPSchoolPress'); ?></th>
									</tr>
								</thead>
								<tbody>
									<?php $sno=1;
									foreach($all_fields as $exfield){ ?>
										<tr>
											<td><?php echo $sno; ?></td><td><?php echo $exfield->c_name;?></td><td><?php echo $exfield->sub_name;?></td><td><?php echo $exfield->fields;?></td>
											<td>
												<div class="wpsp-action-col">
												<a href="<?php echo wpsp_admin_url();?>sch-settings&sc=subField&ac=edit&sid=<?php echo $exfield->subject_id;?>" title="Edit"><i class="icon wpsp-edit wpsp-edit-icon"></i></a>
												</div>
											</td>
										</tr>
									<?php $sno++; } ?>
								</tbody>
								<tfoot>
								  <tr>
									<th>#</th>
									<th><?php _e( 'Class', 'WPSchoolPress'); ?></th>
									<th><?php _e( 'Subject', 'WPSchoolPress'); ?></th>
									<th><?php _e( 'Fields', 'WPSchoolPress'); ?></th>
									<th><?php _e( 'Action', 'WPSchoolPress'); ?></th>
								  </tr>
								</tfoot>
							  </table></div>
							  </div>
<!--- Add Field Popup -->
							<div class="wpsp-popupMain" id="addFieldModal" >
							  	<div class="wpsp-overlayer"></div> 
							  	<div class="wpsp-popBody"> 
							  		<div class="wpsp-popInner">
							  			<a href="javascript:;" class="wpsp-closePopup"></a>
							  			<div class="wpsp-panel-heading">
							  				<h3 class="wpsp-panel-title">Add Subject Mark Fields</h3>
							  				</div>
							  				<div class="wpsp-panel-body">							  					
							  							<div class="wpsp-row">								  
												<form action="#" method="POST" name="SubFieldsForm" id="SubFieldsForm">	
																<div class="wpsp-col-md-12 line_box">
																	<div class="wpsp-row">
																		<div class="wpsp-col-lg-12 wpsp-col-md-12 wpsp-col-sm-12 wpsp-col-xs-12">
																			<div class="wpsp-form-group">
																				<?php wp_nonce_field( 'SubjectFields', 'subfields_nonce', '', true ) ?>
																				<label class="wpsp-label" for="Class">Class <span class="wpsp-required">*</span></label>
																				<select name="ClassID" id="SubFieldsClass" class="wpsp-form-control">
																					<option value="">Select Class</option>
																					<?php $classes=$wpdb->get_results("select cid,c_name from $class_tbl");
																						foreach($classes as $class){
																					?>
																						<option value="<?php echo intval($class->cid);?>"><?php echo $class->c_name;?></option>
																						<?php } ?>
																				</select>
																			</div>	
																		</div>
																		<div class="wpsp-col-lg-12 wpsp-col-md-12 wpsp-col-sm-12 wpsp-col-xs-12">
																			<div class="wpsp-form-group">
																				<label class="wpsp-label" for="Subject">Subject <span class="wpsp-required">*</span></label>
																				<select name="SubjectID" id="SubFieldSubject" class="wpsp-form-control">
																					<option value="">Select Subject</option>
																				</select>
																			</div>
																		</div>
																		<div class="wpsp-col-lg-12 wpsp-col-md-12 wpsp-col-sm-12 wpsp-col-xs-12">
																			<div class="wpsp-form-group">
																				<label class="wpsp-label" for="Field">Field <span class="wpsp-required">*</span></label>
																				<input type="text" name="FieldName" class="wpsp-form-control">
																			</div>
																		</div>
																		
																		<div class="wpsp-col-md-12">
																			<button type="submit" class="wpsp-btn wpsp-btn-success">Submit</button>
																			<button type="button" class="wpsp-btn wpsp-dark-btn" data-dismiss="modal">Cancel</button>
																		</div>
																	</div>
																</div>
																	</form>
															</div>
														</div>
													</div>
													</div>
											
											</div>
										<!-- End popup -->
							</div>

							<?php
								}
						} else if(isset($_GET['sc'])&& sanitize_text_field($_GET['sc'])=='WrkHours') {
								//Class Hours
								if(isset($_POST['AddHours'])){
									$workinghour_table	=	$wpdb->prefix."wpsp_workinghours";
									if( empty( $_POST['hname'] ) || empty( $_POST['hstart'] ) || empty( $_POST['hend'])  || sanitize_text_field($_POST['htype'])=='' ) {
										echo "<div class='col-md-12'><div class='alert alert-danger'>".__( 'Please fill all values.', 'WPSchoolPress')."</div></div>";
									} elseif( strtotime( $_POST['hend'] ) <= strtotime( $_POST['hstart'] ) ) {
										echo "<div class='col-md-12'><div class='alert alert-danger'>".__( 'Invalid Class Time.', 'WPSchoolPress')."</div></div>";
									} else {
										$workinghour_namelist = $wpdb->get_var( $wpdb->prepare( "SELECT count( * ) AS total_hour FROM $workinghour_table WHERE HOUR = %s", $_POST['hname'] ) );
										if( $workinghour_namelist > 0 ) {
											echo "<div class='col-md-12'><div class='alert alert-danger'>".__( 'Class Hour Name Already exists.', 'WPSchoolPress')."</div></div>";
										} else {	
					$workinghour_table_data = array('hour'		=>	sanitize_text_field($_POST['hname']),
													'begintime'	=>	sanitize_text_field( $_POST['hstart'] ),
													'endtime'	=>	sanitize_text_field( $_POST['hend'] ),
													'type'		=>	sanitize_text_field( $_POST['htype'] )
													);											
											$ins=$wpdb->insert( $workinghour_table,$workinghour_table_data);
										}							
									}
								}
								if( isset($_GET['ac']) && sanitize_text_field($_GET['ac'])=='DeleteHours' ) {
									$workinghour_table=$wpdb->prefix."wpsp_workinghours";
									$hid=intval($_GET['hid']);
									$del=$wpdb->delete($workinghour_table,array('id'=>$hid));
								}
								//Save hours
								
							?>	
							<div class="wpsp-card-body">
							<form name="working_hour" method="post" action="">
								<div class="wpsp-form-group">
											<h3 class="wpsp-card-title">Class hours</h3>
										</div>
											<div class="wpsp-row">
												<div class="wpsp-col-md-4">
													<div class="wpsp-form-group">
														<label class="wpsp-label">Name</label>
														<input type="text" name="hname" class="wpsp-form-control" placeholder="Hour Name">
													 </div>
												</div>
												<div class="wpsp-col-md-2 wpsp-col-sm-6">
													<div class="wpsp-form-group">
														<label class="wpsp-label">From</label>
														<input type="text" name="hstart" class="wpsp-form-control" placeholder="Start Time" id="timepicker1">
													 </div>
												</div>
												<div class="wpsp-col-md-2 wpsp-col-sm-6">
													<div class="wpsp-form-group">
														<label class="wpsp-label">To</label>
														<input type="text" name="hend" class="wpsp-form-control" placeholder="End Time" id="wp-end-time" data-provide="timepicker">
													 </div>
												</div>
												<div class="wpsp-col-md-4">
													<div class="wpsp-form-group">
														<label class="wpsp-label">Type</label>
														<select name="htype" class="wpsp-form-control">
															<option value="1">Teaching</option>
															<option value="0">Break</option>
														</select>
													 </div>
												</div>
												<div class="wpsp-col-md-12">
													<div class="wpsp-form-group">
														<button type="submit" class="wpsp-btn wpsp-btn-success" name="AddHours" value="AddHours"><i class="fa fa-plus"></i>&nbsp; Add Hour</button>
													</div>
												</div>
											</div>
								</form>
									
									<table class="wpsp-table" id="wpsp_class_hours" cellspacing="0" width="100%" style="width:100%">
										<thead><tr>
											<th> Class Hour </th>
											<th>Begin Time</th>
											<th>End Time</th>
											<th>Type</th>
											<th class="nosort">Action</th>
										</tr> </thead>
										<tbody>
											<?php
												$htypes=array('Break','Teaching');
												$workinghour_table=$wpdb->prefix."wpsp_workinghours";
												$workinghour_list =$wpdb->get_results("SELECT * FROM $workinghour_table") ;
													foreach ($workinghour_list as $single_workinghour) {
														$hourtype=$htypes[$single_workinghour->type]; ?>
													<tr> <td><?php echo stripslashes( $single_workinghour->hour ) ?></td>
															<td><?php echo $single_workinghour->begintime ?></td>
															<td><?php echo $single_workinghour->endtime ?></td>
															<td><?php echo $hourtype ?></td>
															<td>
																<div class="wpsp-action-col">
																	<a href="<?php echo wpsp_admin_url();?>sch-settings&sc=WrkHours&ac=DeleteHours&hid=<?php echo intval($single_workinghour->id); ?>" class="delete"><i class="icon wpsp-trash wpsp-delete-icon"></i></a>
																</div>
															</td>
															</tr>
												<?php 	}
											?>
										</tbody>
										<tfoot>
											<tr>
												<th> Class Hour </th>
												<th>Begin Time</th>
												<th>End Time</th>
												<th>Type</th>
												<th class="nosort">Action</th>
											</tr> 
										</tfoot>
								</table>
								</div>
								<?php 
							}else{
								//General Settings
								$wpsp_settings_table	=	$wpdb->prefix."wpsp_settings";
								$wpsp_settings_edit		=	$wpdb->get_results("SELECT * FROM $wpsp_settings_table" );	
									

								foreach( $wpsp_settings_edit as $sdat ) {
									$settings_data[$sdat->option_name]	=	$sdat->option_value;
								}

							?>
							<div class="wpsp-card-body">
							<div class="tabSec wpsp-nav-tabs-custom" id="verticalTab">
							<div class="tabList">
								<!-- Tabs within a box -->
								<ul class="wpsp-resp-tabs-list">
									<li class="wpsp-tabing" title="Info">Info</li>
									<li class="wpsp-tabing" title="Social">Social</li>
									<li class="wpsp-tabing <?php echo $proclass; ?>" title="<?php echo $protitle;?>" <?php echo $prodisable; ?> title="An overdose in each drop">SMS</li>
									<!-- <li><a href="#school-principal" data-toggle="tab">Principal and Chairman</a></li> -->
									<!-- <li><a href="#grade" data-toggle="tab">Grade</a></li> -->
									<!-- <li><a href="#paymentgateway" data-toggle="tab" class="<?php echo $payproclass; ?>" title="<?php echo $payprotitle;?>" <?php echo $payprodisable; ?>>Payment Gateway</a></li>-->
								</ul>		
							</div>
								<div class="wpsp-tabBody wpsp-resp-tabs-container">
									
									<div class="wpsp-tabMain">
										<form name="schinfo_form" id="SettingsInfoForm" class="wpsp-form-horizontal" method="post">
											<div  class="wpsp-row">
											<div  class="wpsp-form-group">
						                        <div class="wpsp-col-lg-3 wpsp-col-md-4 wpsp-col-sm-6 wpsp-col-xs-12">    
						                            <div class="wpsp-form-group">
						                              <label class="wpsp-label">School Logo</label>
						                             
						                                <div class="wpsp-profileUp">
						                                  <?php 
						                                  $url = site_url()."/wp-content/plugins/wpschoolpress/img/wpschoolpresslogo.jpg";
						                                  ?>
						                                      <img src="<?php  echo isset( $settings_data['sch_logo'] ) ? $settings_data['sch_logo'] : $url;?>" id="img_preview" onchange="imagePreview(this);" height="150px" width="150px" class="wpsp-upAvatar" />
						                                    <div class="wpsp-upload-button"><i class="fa fa-camera"></i>
															<input name="displaypicture" class="wpsp-file-upload" id="displaypicture" type="file" accept="image/jpg, image/jpeg">
						                                    </div>
						                                </div>
						                                <p class="wpsp-form-notes">* Only JPEG and JPG supported, * Max 3 MB Upload </p>
						                                <label id="displaypicture-error" class="error" for="displaypicture" style="display: none;">Please Upload Profile Image</label>
						                                <p id="test" style="color:red"></p>                                               
						                            </div>
						                        </div>
						                        <div class="wpsp-col-lg-3 wpsp-col-md-8 wpsp-col-sm-6 wpsp-col-xs-12">
						                            <div class="wpsp-form-group">
						                            	<label class="wpsp-label"> School Name </label>
						                                <input type="text" name="sch_name"  class="wpsp-form-control" value="<?php echo isset( $settings_data['sch_name'] ) ? $settings_data['sch_name'] : '';?>">
						                            </div>
						                        </div>	
						                        <div class="wpsp-col-lg-3 wpsp-col-md-4 wpsp-col-sm-6 wpsp-col-xs-12">
						                            <div class="wpsp-form-group">
						                                <label class="wpsp-label" for="phone">Phone</label>
						                                <input type="text" class="wpsp-form-control" id="phone" name="Phone" placeholder="(XXX)-(XXX)-(XXXX)">
						                            </div> 
					                        	</div>	
					                        	<div class="wpsp-col-lg-3 wpsp-col-md-4 wpsp-col-sm-6 wpsp-col-xs-12">
						                            <div class="wpsp-form-group">
						                                <label class="wpsp-label" for="phone">Email Address</label>
						                                <input type="text" class="wpsp-form-control" id="email" name="email" placeholder="Email">
						                            </div> 
					                        	</div>					                        
						                        
						                        <div class="wpsp-col-lg-9 wpsp-col-md-12 wpsp-col-sm-12 wpsp-col-xs-12">
						                            <div class="wpsp-form-group">
						                                <label class="wpsp-label" for="Address"> Address <!-- <span class="wpsp-required">*</span> --></label>
						                                <textarea rows="2" cols="45" name="sch_addr" class="wpsp-form-control"><?php echo isset( $settings_data['sch_addr'] ) ? $settings_data['sch_addr'] : '';?></textarea>
						                            </div>
						                        </div>					                       											
											

										
											 <div class="wpsp-col-lg-3 wpsp-col-md-6 wpsp-col-sm-6 wpsp-col-xs-12">
						                            <div class="wpsp-form-group">
													<label class="wpsp-label">City </label>
													<input type="text" name="sch_city" class="wpsp-form-control" value="<?php echo isset( $settings_data['sch_city'] ) ? $settings_data['sch_city'] : '';?>">
												</div>												
											</div>
											 <div class="wpsp-col-lg-3 wpsp-col-md-6 wpsp-col-sm-6 wpsp-col-xs-12">
						                            <div class="wpsp-form-group">
													<label class="wpsp-label">State </label>
													<input type="text" name="sch_state" class="wpsp-form-control" value="<?php echo isset( $settings_data['sch_state'] ) ? $settings_data['sch_state'] : '';?>">
												</div>												
											</div>
											
											  <div class="wpsp-col-lg-3 wpsp-col-md-6 wpsp-col-sm-6 wpsp-col-xs-12">
						                            <div class="wpsp-form-group">			                           
				                                <label class="wpsp-label" for="Country">Country</label>
				                                <select class="wpsp-form-control" id="Country" name="country">
				                                 	<option value="">Select Country</option>
				                                  	<option value="Afghanistan">Afghanistan</option>                       
				                                    <option value="Libya">Libya</option>
				                                    <option value="Liechtenstein">Liechtenstein</option>
				                                    <option value="Lithuania">Lithuania</option>
				                                    <option value="Luxembourg">Luxembourg</option>
				                                    <option value="Macao S.A.R., China">Macao S.A.R., China</option>
				                                    <option value="Macedonia">Macedonia</option>
				                                    <option value="Madagascar">Madagascar</option>
				                                    <option value="Zimbabwe">Zimbabwe</option>   								
				                                </select>                               
				                            </div>
				                        </div>
											
											 <div class="wpsp-col-lg-3 wpsp-col-md-6 wpsp-col-sm-6 wpsp-col-xs-12">
						                            <div class="wpsp-form-group">
													<label class="wpsp-label">Fax</label>
													<input type="text" name="sch_fax"  class="wpsp-form-control" value="<?php echo isset( $settings_data['sch_fax'] ) ? $settings_data['sch_fax'] :'';?>">
												</div>												
											</div>
											
											  <div class="wpsp-col-lg-3 wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">
						                            <div class="wpsp-form-group">
													<label class="wpsp-label">Website</label>
													<input type="text" name="sch_website"  class="wpsp-form-control" value="<?php echo isset( $settings_data['sch_website'] ) ? $settings_data['sch_website'] : '';?>">
													<input type="hidden" name="type"  value="info">
												</div>												
											</div>
											<div class="wpsp-col-lg-3 wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">
						                            <div class="wpsp-form-group">
						                            <label class="wpsp-label">Date Format</label>
						                            <select name="date_format"  class="wpsp-form-control">
														<option value="m/d/Y" <?php echo  isset( $settings_data['date_format'] ) && ( $settings_data['date_format']=='m/d/Y')?'selected':''?>>mm/dd/yyyy</option>
														<option value="Y-m-d" <?php echo  isset( $settings_data['date_format'] ) && ($settings_data['date_format']=='Y-m-d')?'selected':''?> >yyyy-mm-dd</option>
														<option value="d-m-Y" <?php echo  isset( $settings_data['date_format'] ) && ($settings_data['date_format']=='d-m-Y')?'selected':''?>>dd-mm-yyyy</option>
													</select>
												</div>												
											</div>
											<div class="wpsp-col-lg-3 wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">
												   <div class="wpsp-form-group">
													<label class="wpsp-label">Marks Type</label>
													<select name="markstype" class="wpsp-form-control">
														<option value="Number" <?php echo  isset( $settings_data['markstype'] ) && ( $settings_data['markstype']=='Number')?'selected':''?>>Number </option>
														<option value="Grade" <?php echo  isset( $settings_data['markstype'] ) && ($settings_data['markstype']=='Grade')?'selected':''?>>Grade </option>		
													</select>
												</div>
											</div>
											<div class="wpsp-col-lg-12 wpsp-col-md-12 wpsp-col-sm-12 wpsp-col-xs-12">
											<div class="wpsp-form-group <?php echo $proclass; ?>" title="<?php echo $protitle;?>" <?php echo $prodisable; ?>>
													<label class="wpsp-label"><?php _e( 'SMS Setting' ,'WPSchoolPress'); ?></label>
													<input id="absent_sms_alert" type="checkbox" class="wpsp-checkbox ccheckbox <?php echo $proclass; ?> " title="<?php echo $protitle;?>" <?php echo $prodisable; ?> <?php if(isset($settings_data['absent_sms_alert']) && $settings_data['absent_sms_alert']==1) echo "checked"; ?> name="absent_sms_alert" value="1" >
													<label for="absent_sms_alert" class="wpsp-checkbox-label"> <?php _e( 'Send SMS to parent when student absent','WPSchoolPress');?></label>
													<input id="notification_sms_alert" type="checkbox" class="wpsp-checkbox ccheckbox <?php echo $proclass; ?>" title="<?php echo $protitle;?>" <?php echo $prodisable; ?> <?php if(isset($settings_data['notification_sms_alert']) && $settings_data['notification_sms_alert']==1) echo "checked"; ?> name="notification_sms_alert" value="1" >
													<label for="notification_sms_alert" class="wpsp-checkbox-label"> <?php _e( 'Enable SMS Notification','WPSchoolPress');?></label>
												</div>
											</div>
											<div class="wpsp-col-md-12 wpsp-col-sm-12 wpsp-col-xs-12">
												<div class="wpsp-form-group"> 		
													<button type="submit" class="wpsp-btn wpsp-btn-success" id="setting_submit" name="submit" style="margin-top: 20px;!important" > Save  </button>
												</div>
											</div>
								 	</div>
								 	</div>								 
										</form>
									</div>
								
									<div class="wpsp-tabMain">
										<form name="social_form" id="SettingsSocialForm" class="wpsp-form-horizontal" method="post">
											<div class="wpsp-row">
											<div class="wpsp-col-lg-3 wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">
                            					<div class="wpsp-form-group">
													<label class="wpsp-label">Facebook:</label>												
													<input type="text" name="sfb"  class="wpsp-form-control" value="<?php echo isset( $settings_data['sfb'] ) ? $settings_data['sfb'] : '';?>">
												</div>
											</div>
											<div class="wpsp-col-lg-3 wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">
                            					<div class="wpsp-form-group">
													<label class="wpsp-label">Twitter:</label>												
													<input type="text" name="stwitter"  class="wpsp-form-control" value="<?php echo isset( $settings_data['stwitter'] ) ? $settings_data['stwitter'] : '';?>">
												</div>
											</div>
											<div class="wpsp-col-lg-3 wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">
                            					<div class="wpsp-form-group">		
                            						<label class="wpsp-label">Google+:</label>												
													<input type="text" name="sgoogle"  class="wpsp-form-control" value="<?php echo isset( $settings_data['sgoogle'] ) ? $settings_data['sgoogle'] : '';?>">
												</div>
											</div>
											<div class="wpsp-col-lg-3 wpsp-col-md-4 wpsp-col-sm-4 wpsp-col-xs-12">
                            					<div class="wpsp-form-group">
													<label class="wpsp-label">Pinterest:</label>												
													<input type="text" name="spinterest"  class="wpsp-form-control" value="<?php echo isset( $settings_data['spinterest'] ) ? $settings_data['spinterest'] : '';?>">
													<input type="hidden" name="type"  value="social">
												</div>
											</div>
											<div class="wpsp-col-lg-12 wpsp-col-md-12 wpsp-col-sm-12">
                            					<div class="wpsp-form-group">
													<button type="submit" id="s_save" class="wpsp-btn wpsp-btn-success" name="submit"> Save  </button>
												</div>
											</div>
										</div>										
										</form>		
									</div>
									<div class="wpsp-tabMain">
									</div>
								</div>
							</div>
						</div>
					<!-- 	</div> -->
							<?php } ?>
						</div>

			<?php } else if($current_user_role=='parent' || $current_user_role=='student') {
			
				}		
		wpsp_body_end();
		wpsp_footer(); ?>
	<?php	
	}else {
		include_once( WPSP_PLUGIN_PATH.'/includes/wpsp-login.php');
	}
?>