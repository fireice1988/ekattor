<?php
if ( !defined( 'ABSPATH' ) ) exit;
	$att_table=$wpdb->prefix."wpsp_attendance";
	$class_table=$wpdb->prefix."wpsp_class";
    $leave_table=$wpdb->prefix."wpsp_leavedays";
	$get_classes=$wpdb->get_results("select * from $class_table");
    $today=date('Y-m-d');
	?>    
    <h3 class="wpsp-card-title">Attendance Overview</h3>    
	<?php

		foreach( $get_classes as $get_class )
		{
            $date_warning='';
		    $sdate=$get_class->c_sdate;
            $edate=$get_class->c_edate;
            if($sdate=='' || $sdate=='0000-00-00'){
                $sdate=date('Y-m-d');
                $date_warning="*Please enter valid start date.";
            }
            if($edate=='' || $edate=='0000-00-00' || $edate>$today){
                $edate=date('Y-m-d');
            }
			$class_id		=	$get_class->cid;
			$att			=	$wpdb->get_row("SELECT * from $att_table where date='$today' and class_id='$class_id'");
            $check_leave	=	$wpdb->get_row("SELECT * from $leave_table where leave_date='$today' and class_id='$class_id'");			
			if($att) {
                if($att->absents=='Nil')
                    $tot_abs=0;
                if($att->absents!='Nil')
                    $tot_abs=count(json_decode($att->absents));
				if($tot_abs==0) {
				    $box_class="cbox-success";
                }else {
                    $box_class="cbox-danger";
                }				
			?>
            <!-- Absents -->
                <div class="col-md-4">
                    <div class="cbox <?php echo $box_class; ?>">
                        <div class="shape">
                            <div class="shape-text">
                                <?php echo $tot_abs; ?>
                            </div>
                        </div>
                        <div class="cbox-content">
                            <h3>
                                <?php echo $get_class->c_name; ?>
                            </h3>
                            <?php							
                            $work_days=wpsp_AttStatus($sdate,$edate,$class_id);
                            ?>
                            <div class="col-md-12">
                                <span class="col-md-10 PZero">No. of Absents (Today):</span>
                                <span class="label label-info pointer viewAbsentees" data-id="<?php echo $class_id;?>"><?php echo $tot_abs;?></span>
                            </div>
                            <hr>
                            <div class="col-md-12">
                                <span class="col-md-10 PZero" title="<?php echo wpsp_ViewDate($sdate)." - ".wpsp_ViewDate($edate); ?>">No. of Working Days:</span>
                                <span class="label label-info"><?php echo $work_days['wdays'];?></span>
                            </div>
                            <div class="col-md-12">
                                <span class="col-md-10 PZero" title="<?php echo wpsp_ViewDate($sdate)." - ".wpsp_ViewDate($edate); ?>">No. of days not entered:</span>
                                <span class="label label-warning"><?php echo $work_days['not_entered']; ?></span>
                            </div>
                            <div class="col-md-12 red"><?php echo $date_warning;?></div>
                        </div>
                    </div>
                </div>
            <?php
			} else { ?>
				<!-- Not Yet Entered -->
				<div class="col-md-4">
					<div class="cbox cbox-warning">
						<div class="shape">
							<div class="shape-text">								
							</div>
						</div>
						<div class="cbox-content">
							<h3 class="lead">
								<?php echo $get_class->c_name; ?>
							</h3>
                            <?php
                            $work_days=wpsp_AttStatus($sdate,$edate,$class_id);
                            ?>
                            <div class="col-md-12">
                                <span class="col-md-10 PZero">No. of Absents (Today):</span>
                                <span class="label label-danger"><?php echo (count($check_leave)>0)?'N/A':'N/E'; ?></span>
                            </div>
                            <hr>
                            <div class="col-md-12">
                                <span class="col-md-10 PZero" title="<?php echo wpsp_ViewDate($sdate)." - ".wpsp_ViewDate($edate); ?>">No. of Working Days:</span>
                                <span class="label label-info"><?php echo $work_days['wdays'];?></span>
                            </div>
                            <div class="col-md-12">
                                <span class="col-md-10 PZero" title="<?php echo wpsp_ViewDate($sdate)." - ".wpsp_ViewDate($edate); ?>">No. of days not entered:</span>
                                <span class="label label-warning"><?php echo $work_days['not_entered']; ?></span>
                            </div>
                            <?php if(count($check_leave)>0){ ?>
                                    <div class="fa fa-exclamation-triangle text-red text-center col-md-10 MTTen" title="Today is marked as leave!"><?php echo $check_leave->description;?></div>
                            <?php } ?>
						</div>
					</div>
				</div>
			<?php
			}
			unset($attarray);
		}
	?>
    <div class="col-md-12"><span class="label wpsp-label-danger">N/E</span> Not yet Entered <span class="label wpsp-label-danger">N/A</span> Not Applicable(Date is marked as leave)</div>
	<div class="modal fade" id="ViewModal" tabindex="-1" role="dialog" aria-labelledby="ViewModal" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content" id="ViewModalContent">

			</div>
		</div>
	</div>
	