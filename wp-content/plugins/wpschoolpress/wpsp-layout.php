<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;
/* This function used in wpsp_header() call this function */
function wpsp_customcss(){
  global $current_user, $wp_roles, $current_user_name;
  $current_user_role=$current_user->roles[0];
  if($current_user_role=='administrator'){
  echo "<style>
    .owncls { display:none !important;} 
    .content-wrapper, .right-side, .main-footer{margin-left:0px;}
    #wpfooter{position: relative !important;}
    #adminmenumain{display:none !important;}
    #wpadminbar{display:none !important;} 
    </style>";  
  }else {
    echo "<style>
    .update-nag {display:none !important;} 
    #wpadminbar{display:none !important;} 
    #adminmenumain{display:none !important;}  
    #wpcontent, #wpfooter{margin-left: 0;}
    #wpcontent{padding-left:0px;}
    #wpfooter{position: relative !important;}
    </style>";
  }
}
/* This function used Header print custom css. */
function wpsp_header(){
    echo "<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src='https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js'></script>
        <script src='https://oss.maxcdn.com/respond/1.4.2/respond.min.js'></script>
    <![endif]-->";
    echo "</head>";

    wpsp_customcss();
}
/* This function used for Topbar Return School Quote,Sologan,Number of Messages,Notification,User Photo, User basic settings. */
function wpsp_topbar()
{
    global $current_user, $wpdb, $wpsp_settings_data,$post,$current_user_name;  
    $loc_avatar = get_user_meta( $current_user->ID,'simple_local_avatar',true);
  $role   = isset( $current_user->roles[0] ) ? $current_user->roles[0] : '';
  $url = site_url()."/wp-content/plugins/wpschoolpress/img/wpschoolpresslogo.jpg";
    $img_url  = $loc_avatar ? $loc_avatar['full'] : WPSP_PLUGIN_URL.'img/avatar.png'; 
  $schoolname = isset( $wpsp_settings_data['sch_name'] ) && !empty( $wpsp_settings_data['sch_name'] ) ? $wpsp_settings_data['sch_name'] : __( 'WPSchoolPress','WPSchoolPress' );
  $imglogo  = isset( $wpsp_settings_data['sch_logo'] ) ? $wpsp_settings_data['sch_logo'] : $url;
  $schoolyear = isset( $wpsp_settings_data['sch_wrkingyear'] ) ? $wpsp_settings_data['sch_wrkingyear'] : '';
  $postname = isset( $post->post_name ) ? $post->post_name :'';
  $roles    = $current_user->roles; 
  $query      = '';
  $current_user_name  = $current_user->user_login;
  if( in_array( 'teacher', $roles ) ) {
    $table  = $wpdb->prefix."wpsp_teacher";
    $query  = "SELECT CONCAT_WS(' ', first_name, middle_name, last_name ) AS full_name FROM $table WHERE wp_usr_id=$current_user->ID";
  } else if( in_array( 'student', $roles ) ) {
    $table  =   $wpdb->prefix."wpsp_student";
    $query  = "SELECT CONCAT_WS(' ', s_fname, s_mname, s_lname ) AS full_name FROM $table WHERE wp_usr_id=$current_user->ID";
  } else if( in_array( 'parent', $roles ) ) {
    $table  =   $wpdb->prefix."wpsp_student";
    $query  = "SELECT CONCAT_WS(' ', p_fname, p_mname, p_lname ) AS full_name FROM $table WHERE parent_wp_usr_id=$current_user->ID";
  }
  if( !empty( $query ) ) {
    $full_name = $wpdb->get_var( $query );
    $current_user_name  = !empty( $full_name ) ? $full_name : $current_user_name;
  }
  ?>
  <div class="wpsp-body <?php if($roles[0]=='administrator') {echo "mainadmin";}?><?php echo $postname;?>">
    <?php /*<div class="wpsp-loader"><img class="wpsp-loader-img" id="img_preview1" src="<?php echo plugins_url( 'img/wpsp-loading.png', __FILE__  ); ?>"></div>*/?>
    <div class="wpsp-preLoading">
      <div class="wpsp-bookshelf_wrapper">   
          <ul class="wpsp-books_list">
            <li class="wpsp-book_item wpsp-first"></li>
            <li class="wpsp-book_item wpsp-second"></li>
            <li class="wpsp-book_item wpsp-third"></li>
            <li class="wpsp-book_item wpsp-fourth"></li>
            <li class="wpsp-book_item wpsp-fifth"></li>
            <li class="wpsp-book_item wpsp-sixth"></li>
          </ul>
          <div class="wpsp-shelf"></div>
      </div>
    </div>
      <header class='wpsp-header'>
        <!-- Logo -->
          <a href='<?php site_url('wp-admin/admin.php?page=sch-dashboard'); ?>' class='wpsp-logo'>
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class='wpsp-logo-mini'>
            <?php //if( !empty($imglogo) ) { 

              ?>
              <img src="<?php echo  $imglogo; ?>" class="img wpsp-school-logo" width="45px" height="40px">
              <!-- <img src="<?php echo $imglogo; ?>" class="img wpsp-school-logo" style="" width="45px" height="40px"> -->
            <?php //} ?>
          </span>
          <!-- logo for regular state and mobile devices -->
          <span class='wpsp-schoolname'><?php echo $schoolname;?></span>
        </a>
        <div class="wpsp-head">
      <div class="wpsp-menuIcon"><span></span></div>
      <h3 class="wpsp-customeMsg">“Live as if you were to die tomorrow. Learn as if you were to live forever.”</h3>
          <div class="wpsp-righthead">
            <div class="wpsp-head-action">
            <!--   <div class="wpsp-message wpsp-dropdownmain">
                <a href="#" class="wpsp-dropdown-toggle" >
                  <i class="icon wpsp-email"></i><?php $totalMsg = wpsp_UnreadCount(); ?>
                  <span class="wpsp-count"><?php echo $totalMsg; ?></span>
                </a>
                <div class="wpsp-dropdown wpsp-dropdown-md">
                  <div class="wpsp-drop-title">You have 4 new messages</div>
                  <div class="wpsp-messagelist">
                        <a href="#">
                            <div class="wpsp-user-img"> <img src="<?php echo plugins_url( 'img/pawandeep.jpg', __FILE__  ); ?>" alt="user" /></div>
                            <div class="wpsp-mail-contnet">
                                <h5 class="wpsp-mail-username">Pavan kumar</h5> <span class="wpsp-mail-desc">Just see the my admin!</span> <span class="wpsp-mail-time">9:30 AM</span> </div>
                        </a>
                        <a href="#">
                            <div class="wpsp-user-img"> <img src="<?php echo plugins_url( 'img/sonu.jpg', __FILE__  ); ?>" alt="user" /></div>
                            <div class="wpsp-mail-contnet">
                                <h5 class="wpsp-mail-username">Sonu Nigam</h5> <span class="wpsp-mail-desc">I've sung a song! See you at</span> <span class="wpsp-mail-time">9:10 AM</span> </div>
                        </a>
                        <a href="#">
                            <div class="wpsp-user-img"> <img src="<?php echo plugins_url( 'img/arijit.jpg', __FILE__  ); ?>" alt="user" /></div>
                            <div class="wpsp-mail-contnet">
                                <h5 class="wpsp-mail-username">Arijit Sinh</h5> <span class="wpsp-mail-desc">I am a singer!</span> <span class="wpsp-mail-time">9:08 AM</span> </div>
                        </a>
                        <a href="#">
                            <div class="wpsp-user-img"> <img src="<?php echo plugins_url( 'img/pawandeep.jpg', __FILE__  ); ?>" alt="user" /></div>
                            <div class="wpsp-mail-contnet">
                                <h5 class="wpsp-mail-username">Pavan kumar</h5> <span class="wpsp-mail-desc">Just see the my admin!</span> <span class="wpsp-mail-time">9:30 AM</span> </div>
                        </a>
                        <a class="wpsp-view-all" href="javascript:void(0);"> <strong>See all messages</strong></a>
                    </div> 
                </div>
              </div> -->
             <!--  <div class="wpsp-notification wpsp-dropdownmain">
                <a class="wpsp-dropdown-toggle" href="#"><i class="icon wpsp-bell"></i><span class="wpsp-count">8</span></a>
                <div class="wpsp-dropdown wpsp-dropdown-md ">
                  <div class="wpsp-drop-title">You have 8 new notifications</div>
                  <ul class="wpsp-messagelist">
                       <li><a href="#">Lorem Ipsum is simply dummy text</a></li>
                       <li><a href="#">Lorem Ipsum is simply dummy text</a></li>
                       <li><a href="#">Lorem Ipsum is simply dummy text</a></li>
                       <li><a href="#">Lorem Ipsum is simply dummy text</a></li>
                       <li><a class="wpsp-view-all" href="javascript:void(0);"> <strong>See all notifications</strong></a></li>
                  </ul>   
                </div>
              </div> -->
            </div>
         
            <div class="wpsp-userMain wpsp-dropdownmain ">
              <div class="wpsp-profile-pic wpsp-dropdown-toggle">
                <img src='<?php echo $img_url; ?>' class='wpsp-userPic' alt='User Image' />
                <span class="wpsp-username"><?php echo $current_user_name;?></span>
              </div>
              <div class="wpsp-dropdown">
                <ul>
                  <?php if($roles[0]=='administrator') {?> <li class='wpsp-back-wp'><a href='<?php echo admin_url(); ?>'>Back to wp-admin</a></li><?php }?>
                 <!--  <li><a href='#'>Edit Profile</a></li> -->
                  <?php echo "<li><a href='".site_url('wp-admin/admin.php?page=sch-changepassword')."'>".__('Change Password','WPSchoolPress')."</a></li>"; ?>
       
                  <li><a href='<?php echo wp_logout_url();?>'>Sign out</a></li>
                  
                  <?php if ( !empty($schoolyear ) ) { ?>
                    <button class="btn">Academic year <span class="badge"> <?php echo $schoolyear; ?></span></button>
                  <?php } ?>
                </ul>        
              </div>
            </div>
           </div>          
        </div>                
      </header>
<?php 
}
/* This function used for Left-Sidebar */
function wpsp_sidebar()
{
  global $current_user, $wp_roles, $current_user_name;
  $current_user_role=$current_user->roles[0];
  //$page=get_the_title();
  $page = $_GET['page'] ?  ltrim(strstr($_GET['page'],'-'),'-') : '';     
  $dashboard_page=$message_page=$student_page=$teacher_page=$parent_page=$class_page=$attendance_page=$subject_page=$mark_page=$exam_page=$event_page=$timetable_page=$import_page=$notify_page=$sms_page=$transport_page=$settings_page=$settings_general_page=$settings_wrkhours_page=$settings_subfield_page=$leave_page=$teacher_attendance_page=$settings_chgpw_page = $viewpayment= $addpayment =$payment_page_main='';
  switch( $page )
  {
    case 'dashboard':
    $dashboard_page="active";
    break;
    case 'messages':
    $message_page="active";
    break;
    case 'student':
    $student_page="active";
    break;
    case 'teacher':
    $teacher_page="active";
    break;
    case 'parent':
    $parent_page="active";
    break;
    case 'class':
    $class_page="active";
    break;
    case 'attendance':
    $attendance_page="active";
    break;
    case 'subject':
    $subject_page="active";
    break;
    case 'exams':
    $exam_page="active";
    break;
  case 'marks':
    $mark_page="active";
    break;
    case 'importhistory':
    $import_page="active";
    break;
  case 'notify':
    $notify_page="active";
    break;
  case 'payment':
    if( isset( $_GET['type'] ) && $_GET['type'] =='addpayment' ) 
    $addpayment="active";
    else
    $viewpayment="active";
    $payment_page_main = "class='treeview active'";
    break;
    case 'events':
    $event_page="active";
    break;
    case 'transport':
      $transport_page="active";
      break;
    case 'leavecalendar':
        $leave_page="active";
        break;
    case 'timetable' :
        $timetable_page='active';
        break;
  case 'settings':
    $settings_page="class='treeview active'";
    if(isset($_GET['sc']) && $_GET['sc']=='subField')
      $settings_subfield_page="active";
    else if(isset($_GET['sc']) && $_GET['sc']=='WrkHours')
      $settings_wrkhours_page="active";   
    else
      $settings_general_page="active";
    break;
  case 'changepassword' :
        $settings_chgpw_page="active";
        break;
  case 'teacherattendance':
    $teacher_attendance_page="active";
    break;
  } 
  
  $loc_avatar=get_user_meta($current_user->ID,'simple_local_avatar',true);
  if( $current_user->ID == 1 )
  $img_url  =   WPSP_PLUGIN_URL.'img/admin.png';  
 else
  $img_url  = $loc_avatar ? $loc_avatar['full'] : WPSP_PLUGIN_URL.'img/avatar.png';
  echo "<!-- Left side column. contains the logo and sidebar -->
      <div class='wpsp-overlay'></div>
      <aside class='wpsp-sidebar ifnotadmin'> 
      <div class='sidebarScroll'> 
        <ul class='wpsp-navigation'>       
            <li class='".$dashboard_page."'>
             <a href='".site_url('wp-admin/admin.php?page=sch-dashboard')."'>
                <i class='dashicons dashicons-dashboard icon'></i>
                <span>".__('Dashboard','WPSchoolPress')."</span>
              </a>
            </li>
            <li class='".$teacher_page."'>
              <a href='".site_url('wp-admin/admin.php?page=sch-teacher')."'>
                <i class='dashicons dashicons-businessman icon'></i>
                <span>".__('Teachers','WPSchoolPress')."</span>
              </a>
            </li>
            <li class='".$student_page."'>
              <a href='".site_url('wp-admin/admin.php?page=sch-student')."'>
                <i class='dashicons dashicons-id icon'></i>
                <span>".__('Students','WPSchoolPress')."</span>
              </a>
            </li>
            
            <li class='".$parent_page."'>
              <a href='".site_url('wp-admin/admin.php?page=sch-parent')."'>
                <i class='dashicons dashicons-groups icon'></i>
                <span>".__('Parents','WPSchoolPress')."</span>
              </a>
            </li>
      <li class='has-submenu ".$class_page."'>
        <a href='".site_url('wp-admin/admin.php?page=sch-class')."'>
          <i class='dashicons dashicons-welcome-widgets-menus icon'></i>
          <span>".__('Classes','WPSchoolPress')."</span>
        </a>
        <ul class='sub-menu'>
        <li class='".$class_page."'>
              <a href='".site_url('wp-admin/admin.php?page=sch-class')."'>
                <span>".__('Classes','WPSchoolPress')."</span>
              </a>
            </li>
            <li class='".$subject_page."'>
              <a href='".site_url('wp-admin/admin.php?page=sch-subject')."'>
                <span>".__('Subjects','WPSchoolPress')."</span>
              </a>
            </li>";
            if($current_user_role=='administrator'){
           echo "<li class='".$settings_subfield_page."'>
              <a href='".site_url('wp-admin/admin.php?page=sch-settings&sc=subField')."'>".__('Subject Mark Fields','WPSchoolPress')."</a>
            </li>";
          }
           echo "<li class='".$mark_page."'>
              <a href='".site_url('wp-admin/admin.php?page=sch-marks')."'>
                <span>".__('Marks','WPSchoolPress')."</span>
              </a>
            </li>
            <li class='".$exam_page."'>
              <a href='".site_url('wp-admin/admin.php?page=sch-exams')."'>
                <span>".__('Exams','WPSchoolPress')."</span>
              </a>
            </li>
            <li class='".$timetable_page."'>
              <a href='".site_url('wp-admin/admin.php?page=sch-timetable')."'>
                <span>".__('Time Table','WPSchoolPress')."</span>
              </a>
            </li> 
          </ul>
      </li>
      <li class='has-submenu ".$attendance_page."'>
        <a href='".site_url('wp-admin/admin.php?page=sch-attendance')."'>
          <i class='dashicons dashicons-clipboard icon'></i>
          <span>".__('Attendance','WPSchoolPress')."</span>
        </a> 
        <ul class='sub-menu'>
          <li><a href='".site_url('wp-admin/admin.php?page=sch-attendance')."'>
            <span>".__('Students Attendance','WPSchoolPress')."</span>
          </a></li>";
      
        if($current_user_role=='administrator' || $current_user_role=='teacher'){
          echo "<li class='".$teacher_attendance_page."'>
            <a href='".site_url('wp-admin/admin.php?page=sch-teacherattendance')."'>
             <span>".__('Teachers Attendance','WPSchoolPress')."</span>
            </a>
           </li>";
        }
          
      echo"</ul>      
      </li>       
      
      <li class='".$event_page."'>
        <a href='".site_url('wp-admin/admin.php?page=sch-events')."'>
          <i class='dashicons dashicons-calendar-alt icon'></i><span>".__('Events','WPSchoolPress')."</span>
        </a>
            </li>
       ";
      
    if($current_user_role=='administrator' || $current_user_role=='teacher') {
        echo "
        <li class='".$notify_page."'>
        <a href='".site_url('wp-admin/admin.php?page=sch-notify')."'>
          <i class='icon wpsp-notify'></i><span>".__('Notify','WPSchoolPress')."</span>
        </a>
      </li>";
     echo "<li class='".$transport_page."'>
        <a href='".site_url('wp-admin/admin.php?page=sch-transport')."'>
          <i class='icon wpsp-school-bus'></i><span>".__('Transport','WPSchoolPress')."</span>
        </a>
       </li>";
    }
  
  echo "<li class='has-submenu ".$settings_page."'>
      <a href='#'>
      <i class='dashicons dashicons-admin-generic'></i>
      <span>".__('General Settings','WPSchoolPress')."</span>
      </a>
      <ul class='sub-menu'>";
       if($current_user_role=='administrator'){   
      echo "<li class='".$settings_general_page."'>
          <a href='".site_url('wp-admin/admin.php?page=sch-settings')."'>
          <span>".__('Settings','WPSchoolPress')."</span></a>
          </li>";
          
      echo "<li class='".$settings_wrkhours_page."'>
          <a href='".site_url('wp-admin/admin.php?page=sch-settings&sc=WrkHours')."'>
          <span>".__('Working Hours','WPSchoolPress')."</span></a>
          </li>";
     }  
  echo "<li class='".$leave_page."'>
      <a href='".site_url('wp-admin/admin.php?page=sch-leavecalendar')."'>
      <span>".__('Leave Calendar','WPSchoolPress')."</span></a></li>";
        
     if($current_user_role=='administrator' || $current_user_role=='teacher') {
      echo "<li class='" . $import_page . "'>
          <a href='" . site_url('wp-admin/admin.php?page=sch-importhistory') . "'>
            <span>". __('Import History', 'WPSchoolPress') . "</span>
          </a>
           </li>   
         ";
      }  
        echo "</ul>
            </li>";   
  echo "</ul>
        </div>
      </aside>";
}
/* This function used for Header Breadcrumb */
function wpsp_body_start()
{
  $result = $_GET['page'] ?  ltrim(strstr($_GET['page'],'-'),'-') : ''; // This variable return URL Part. for ex: dashboard 
  $base_url  = wpsp_admin_url(); // This Variable Print Base URL
  global $current_user;
  $current_user_role = $current_user->roles[0];
  switch($result)
  {
    case 'dashboard':
      $pagetitle = 'Dashboard';
      break;
    case 'messages':
      $pagetitle = 'Messages';
      $addurl = $base_url.'sch-message&tab=addmessage'; 
      break;  
    case 'teacher':
      $pagetitle = 'Teacher'; 
      $addurl = $base_url.'sch-teacher&tab=addteacher'; 
      break;
    case 'student':
      $pagetitle = 'Student'; 
      $addurl = $base_url.'sch-student&tab=addstudent';       
      break;
    case 'parent':
      $pagetitle = 'Parent';
      $addurl = $base_url.'sch-student&tab=addstudent';   
      break;  
    case 'class':
      $pagetitle = 'Class';
      $addurl = $base_url.'sch-class&tab=addclass';       
      break; 
    case 'attendance':
      $pagetitle = 'Attendance';
      $addurl = $base_url.'sch-attendance'; 
      break;
    case 'teacherattendance':
      $pagetitle = 'Teacher Attendance';  
      $addurl = $base_url.'sch-teacherattendance';      
      break;      
    case 'subject':
      $pagetitle = 'Subject'; 
      $addurl = $base_url.'sch-subject&tab=addsubject&classid=1';     
      break;
    case 'exams':
      $pagetitle = 'Exam';
      $addurl = $base_url.'sch-exams&tab=addexam';  
      break;    
    case 'marks':
      $pagetitle = 'Marks';
      $addurl = $base_url.'sch-marks';    
      break;  
    case 'importhistory':
      $pagetitle = 'Import History';      
      break;
    case 'notify':
      $pagetitle = 'Notify';
      $addurl = $base_url.'sch-notify&ac=add';  
      break;
      case 'payment':
      if(isset($_GET['type']) && $_GET['type'] =='addpayment'):
          $pagetitle = 'Payment';       
      endif;
      break;  
    case 'events':
      $pagetitle = 'Events';      
      break;      
    case 'transport':
      $pagetitle = 'Transport';
      //$addurl = $base_url.'sch-transport';
      $addurl ='';    
      break;      
    case 'leavecalendar':
      $pagetitle = 'Leave Calendar';
      $addurl = $base_url.'sch-transport';    
      break;      
    case 'timetable' :
      $pagetitle = 'Timetable';
      $breadcum = $base_url.'sch-timetable'; 
      $addurl = $base_url.'sch-timetable&ac=add';   
      break;  
    case 'subField':
      $pagetitle = 'SubField';
      $addurl = $base_url.'sch-transport';      
      break;      
    case 'WrkHours':
      $pagetitle = 'WorkHours'; 
    //  $addurl = $base_url.'sch-settings&sc=WrkHours';     
      break;      
    case 'settings':
      $pagetitle = 'Settings';
     // $addurl = $base_url.'sch-settings';     
      break;  
    case 'changepassword' :
      $pagetitle = 'Change Password';     
      break;
  } 
  // echo $addurl;
   //echo $result;
     if($_GET['sc'] == 'subField'){
   $pagetitle="Subject Mark Fields";
              } 
                else if($_GET['sc'] == 'WrkHours'){
   $pagetitle="Working Hours";
              } else {
               $pagetitle;
            }
  echo "<!-- Content Wrapper. Contains page content -->
      <div class='wpsp-wrapper'>        
        <!-- Main content -->
        <section class='wpsp-container'>
      <div class='wpsp-pageHead'>
        <h1 class='wpsp-pagetitle'>$pagetitle</h1>
        <div class='wpsp-right'>
          <ol class='wpsp-breadcrumb'> <div class='".$result."'></div>";
            if(!empty($result == 'dashboard')):
              echo "<li><a href='".$base_url."sch-dashboard'>Home</a></li>";
            endif;
            echo "<li><a href='".$base_url."sch-dashboard'>Dashboard</a></li>";
            if(!empty($result != 'dashboard')):
              if($_GET['sc'] == 'subField'){
              echo "<li><span class='active'> Subject Mark Fields</span></li>";
              } 
              else if($_GET['sc'] == 'WrkHours')
              {
                echo "<li><span class='active'> Working Hours</span></li>";
              }
              else if($result == 'timetable')
              {
                echo "<li><a href=$breadcum><span class='active'> $pagetitle</span></a></li>"; 
              }
              else {
              echo "<li><a href=$addur><span class='active'> $pagetitle</span></a></li>";
            }
            endif;
          echo '</ol>';
          
            if(!empty($addurl)):
              
              if(($current_user_role == 'teacher')):
                  if($result == 'notify' || $result == 'settings' ){
                echo "<a class=' wpsp-btn wpsp-popclick' href='$addurl'><i class='fa fa-plus-circle'></i> Create New</a>";
              }
              endif;
              if(($current_user_role=='administrator')):

                  if($result == 'teacherattendance' || $result == 'attendance' || $result == 'marks' || $_GET['tab'] == 'addteacher' || $_GET['tab'] == 'addstudent'  || $_GET['tab'] == 'addclass' || $_GET['tab'] == 'addsubject' || $result == 'leavecalendar' || $_GET['tab'] == 'addexam' || $_GET['ac'] == 'add' ||  $result == 'settings'){


                  }
                    else{
                echo "<a class='wpsp-btn $current_user_role' href='$addurl'><i class='fa fa-plus-circle'></i> Create New</a>";
              }
              endif;
            endif;
            if(empty($addurl) && ($current_user_role == 'teacher' || $current_user_role == 'administrator') && ($result == 'notify' ||  $result == 'settings' )):
             
              if($result == 'settings'){
                if($_GET['sc'] == 'WrkHours'){} else {

                //echo "<a class='wpsp-popclick wpsp-btn' data-pop='addFieldModal' id='AddFieldsButton'><i class='fa fa-plus-circle'></i> Create New</a>";
              }
              }
             
                else{
                  echo  $result;

                echo "<a class='wpsp-btn wpsp-popclick' data-pop='ViewModal' id='AddNew'><i class='fa fa-plus-circle'></i> Create New</a>";  
                }
                

              
            endif;
        echo "</div>
      </div>";   
}
/* This function used for footer copyright section */
function wpsp_body_end()
{
  echo "<footer class='wpsp-footer'>
        <p>Copyright &copy;".date('Y')." <a href='http://wpschoolpress.com' target='_blank'>WPSchoolPress</a>. All rights reserved. <span class='wpsp-right'>WPSchoolPress Version ".WPSP_PLUGIN_VERSION."</span></p></footer>
    <!-- Control Sidebar -->
    </section><!-- /.wpsp-container -->
  </div><!-- /.wpsp-wrapper --> 
</div><!-- ./wrapper -->";
}
/* This function used for return footer script */
function wpsp_footer()
{
   echo "<script>
      jQuery(function($) {    
        ajax_url ='".admin_url( 'admin-ajax.php' )."';
        date_format='mm/dd/yy';
        $('.content-wrapper').on('click',function(){
          $('.control-sidebar').removeClass('control-sidebar-open');
        });
        $('body').addClass('wpschoolpress');
		$('html').removeClass('wp-toolbar');
      });
    </script>";
      do_action( 'wpsp_footer_script' );
      require_once (WPSP_PLUGIN_PATH . 'includes/wpsp-popup.php');
      echo "</div>

        <div id='overlay'>
        </div>    
    </body>
    </html>";
}
/* This function used for print Admin URL */
function wpsp_admin_url(){
 $admin_link = site_url('wp-admin/admin.php?page=');
  
    return $admin_link;
}  
?>