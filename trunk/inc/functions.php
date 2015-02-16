<?php
class Sub //extends WPUF_Main
{
	public $menu;
	public function __construct()
	{
		//parent::__construct();
	}
	public function menu()
	{
		$menu.='<li><a href='.admin_url().'admin.php?page=Test-class&new=calendar.php>Calendar</a></li> | ';
		$menu.='<li><a href='.admin_url().'admin.php?page=Test-class&new=list_appointments.php>List of Appoinments</a></li> | ';
		//$menu.='<li><a href='.admin_url().'admin.php?page=Test-class&new=manage_appointments.php>Manage Appointment</a></li> | ';	
		$menu.='<li><a href='.admin_url().'admin.php?page=Test-class&new=appointment.php>Add Appointment</a></li> | ';
		$menu.='<li><a href='.admin_url().'admin.php?page=Test-class&new=setting.php>Setting</a></li>';
	 	//$menu.='<li><a href='.admin_url().'admin.php?page=Test-class&new=email-template.php>Templates</a></li>';
	 	return $menu;
	}
	public function status()
	{
		return array('Pending','Approved','Rejected','Completed');
	}
	public function check_page()
	{	
		if(isset($_REQUEST['page']) && $_REQUEST['page'] == "Test-class" && $_REQUEST['new']=="")
		{
			require_once dirname(__FILE__).'/admin/calendar.php';
		}
		if(isset($_REQUEST['page']) && $_REQUEST['page'] == "Test-class" && $_REQUEST['new']=="calendar.php")
		{
			require_once dirname(__FILE__).'/admin/calendar.php';
		}
		/*if(isset($_REQUEST['page']) && $_REQUEST['page'] == "Test-class" && $_REQUEST['new']=="manage_appointments.php")
		{
			require_once dirname(__FILE__).'/admin/manage_appointments.php';
			//unset($_REQUEST['google']);
		}*/
		if(isset($_REQUEST['page']) && $_REQUEST['page'] == "Test-class" && $_REQUEST['new']=="list_appointments.php")
		{
			require_once dirname(__FILE__).'/admin/list_appointments.php';
			//unset($_REQUEST['google']);
		}
		if(isset($_REQUEST['page']) && $_REQUEST['page'] == "Test-class" && $_REQUEST['new']=="appointment.php")
		{
			require_once dirname(__FILE__).'/admin/appointment.php';
		}
		/*if(isset($_REQUEST['page']) && $_REQUEST['page'] == "Test-class" && $_REQUEST['new']=="approval.php")
		{
			require_once dirname(__FILE__).'/admin/approval.php';
		}
		if(isset($_REQUEST['page']) && $_REQUEST['page'] == "Test-class" && $_REQUEST['new']=="rejection.php")
		{
			require_once dirname(__FILE__).'/admin/rejection.php';
		}*/
		if(isset($_REQUEST['page']) && $_REQUEST['page'] == "Test-class" && $_REQUEST['new']=="setting.php")
		{
			require_once dirname(dirname(__FILE__)).'/setting.php';
		}
		/*if(isset($_REQUEST['page']) && $_REQUEST['page'] == "Test-class" && $_REQUEST['new']=="email-template.php")
		{
			require_once dirname(__FILE__).'/admin/email-template.php';
		}*/
	}

	/*public function manage_appointments(){
		global $wpdb;
		$html;

		$table_name = $wpdb->prefix . 'Appointments';
		$user=get_userdata(1);
	    $id=$user->ID;

	    if(is_admin()){
	    $data=$wpdb->get_results($wpdb->prepare("SELECT * from $table_name where status=%d",0));
		$rows=count($data);
		if($rows>0)
			{
		$html.='<table border="1" style="width:95%;text-align:center;" cellspacing="0">';
		$html.='<tr>
				<th>ID</th>
				<th>Name of Appointments</th>
				<th>Date of Appointments</th>
				<th>Email</th>
				<th>Userid</th>
				<th colspan="2">Options</th>
		</tr>';		
		foreach($data as $key => $val){
				$st=$val->status;
		$html.='<tr>
			<td>'.$val->appointment_id.'</td>
			<td>'.$val->appointment_name.'</td>
			<td>'.$val->date_of_apointment.'</td>
			<td>'.$val->email_id.'</td>
			<td>'.$val->user_id.'</td>
			<td><a href="admin.php?page=Test-class&new=approval.php&apid='.$val->appointment_id.'&userid='.$val->user_id.'" style="color:green;font-weight:bold;" onclick="return confirm(\'Appontement is going to be approval?\');">Approve</a></td>
			<td><a href="admin.php?page=Test-class&new=rejection.php&apid='.$val->appointment_id.'&userid='.$val->user_id.'" onclick="return confirm(\'Are you sure want to reject?\');" style="color:red;font-weight:bold;">Reject</a></td>
			<tr>';		
		}
		}
		else
		{
			echo "<span style='color:red'>* No records not found...</span>";
		}
	}
	$html.='</table>';
	return $html;
	}*/

	/*public function approval_request()
	{
			extract($_REQUEST);

			global $wpdb;

			$tablename=$wpdb->prefix. 'Appointments';
			$tb=$wpdb->prefix.'events';

			$query=$wpdb->query("Update $tablename SET `status`='1' where appointment_id='".$apid."'");

			$qr=$wpdb->query("Update $tb SET `status`='1' where appointment_id='".$apid."'");

			if($query==true && $qr==true){
				require_once dirname(__FILE__).'/templates/appointment_approval(admin).php';
				echo '<META HTTP-EQUIV="Refresh" Content="0; URL=admin.php?page=Test-class&new=manage_appointments.php">';
			}
			else{
				echo "error";
				exit();
			}
	}*/

	/*public function rejection_request()
	{
			extract($_REQUEST);

			global $wpdb;
			$tablename=$wpdb->prefix. 'Appointments';
			$tb=$wpdb->prefix.'events';

			$query=$wpdb->query("Update $tablename SET `status`='2' where appointment_id='".$apid."'");
			$qr=$wpdb->query("Update $tb SET `status`='2' where appointment_id='".$apid."'");

			if($query==true && $qr==true){
				require_once dirname(__FILE__).'/templates/appointment_delete(admin).php';
				echo '<META HTTP-EQUIV="Refresh" Content="0; URL=admin.php?page=Test-class&new=manage_appointments.php">';
			}
			else{
				echo "error";
				exit();
			}
	}*/

	public function calendar_events()
	{
		global $wpdb;
		$userid=get_current_user_id(); // Current user id
		//$tb= $wpdb->prefix.'events';
		$table= $wpdb->prefix.'Appointments';
		 // Execute the query
		$resultat = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table WHERE status not in('%s')",'Rejected'));
		 // sending the encoded result to success page
		$data=json_encode($resultat);
	    return $data;
	}

	public function frontcal_events()
	{
		global $wpdb;
		$tb= $wpdb->prefix.'events';

		$table= $wpdb->prefix.'Appointments';
		$userid=get_current_user_id(); // Current user id
	 	// Execute the query
		$resultat = $wpdb->get_results($wpdb->prepare("SELECT start,title from $table where status not in('%s') and user_id ='%d'",'Rejected',$userid));
		 // sending the encoded result to success page
		$data=json_encode($resultat);
		return $data;
	}

	public function cal_event()
	{
	  global $wpdb;

 	  $admin_email = get_option( 'email_address' ); // Get admin email address

	  $table_name = $wpdb->prefix.'Appointments';
	//  $tb= $wpdb->prefix.'events';

	  $total=get_option('booking_perday');

	  $url=admin_url().'admin.php?page=Test-class';

	  //$id=get_current_user_id();  /* Get current user id*/

	  extract($_POST);   // Convert html input name as a variable

	  //$dat=date('Y-m-d',strtotime($start));
	 if ( current_user_can( 'administrator' ) ) {
	  $id=get_current_user_id();  /* Get current user id*/

	  $abc=$wpdb->get_var("SELECT count(start) from $table_name WHERE start='".$start."'");
	  if($abc>=$total){
	        echo "* You can book only {$total} events on particular date!";
	        exit();
	    }
	  else{
	  $wpdb->query($wpdb->prepare(
			 "INSERT INTO $table_name(title,start,email,phone,user_id,status)
			  VALUES (%s,%s,%s,%s,%d,%s)
			 ", $title,$start,$admin_email,NULL,$id,'Approved'
	  	));

	  $lastid=$wpdb->insert_id;   // Get last insert id

	  $URL=$url."&new=list_appointments.php&apid=".$lastid;

	 $status=$wpdb->update($table_name,array('url'=>$URL),
	  				array('app_id'=>$lastid),
	  				array('%s'),
	  				array('%d') 
	  				);

	  if($status)
	  	{
	  		echo "* New appointment added! ";
	  	}
	  	else
  		{ 
  			echo "* Something going wrong! ";
  			exit();
  		}
  		die();
	  }
	}
  }

  public function appointments_list()
  {
	  //$admin=get_super_admins());
	global $wpdb,$html;

	$table_name = $wpdb->prefix . 'Appointments';
	//$tb=$wpdb->prefix.'events';

	if(current_user_can('administrator')){

	$userid=get_current_user_id();
    
	$data=$wpdb->get_results($wpdb->prepare("Select * from $table_name",NULL));
	$rows=count($data);
	if($rows>0)
	{
	$html.='<form action='.$_SERVER['REQUEST_URI'].' name="e_frm" method="post">';
	$html.='<table border="1" style="width:95%;text-align:center;" cellspacing="0">
	<tr>
			<th>ID</th>
			<th>Name of Appointments</th>
			<th>Date of Appointments</th>
			<th>Email</th>
			<th>Userid</th>
			<th>Phone</th>
			<th>Status</th>
			<th>Options</th>
	</tr>';
		
	foreach($data as $key => $val){
		$st=$val->status;
        if(isset($_REQUEST['apid']) && $_REQUEST['apid']==$val->app_id)
        {
          $id=$_REQUEST['apid'];
       
          $html.='<tr>
            <td>'.$val->app_id.'</td>
            <input type="hidden" name="txtuid" value='.$val->user_id.'>
            <td><input type="text" name="txteappname" value="'.$val->title.'"/></td>
            <td><input type="text" name="txtedate" value="'.$val->start.'" id="txtedate"/></td>
            <td><input type="text" name="txteemail" value="'.$val->email.'"></td>
            <td>'.$val->user_id.'</td>
            <td>'.$val->phone.'</td>';
            $html.='<td><select name="estatus">';
            foreach($this->status() as $val)
            {
            	if($val == $st)
            	{
            		$s='selected="selected"';
            	}
            	else
            	{
            		$s='';
            	}
            	$html .= "<option {$s} value='{$val}'>";
				$html .= $val;
				$html .= '</option>';
            }
        	$html.='</select></td>
            <td>
            <input type="submit" value="Update" name="ebtnup" class="button-primary"/>
            <input type="submit" value="Cancel" name="ebtncan" class="button-primary"/>
            </td>
          </tr>';
        }
        else{
	
		$html.='<tr>
		<td>'.$val->app_id.'</td>
		<td>'.$val->title.'</td>
		<td>'.$val->start.'</td>
		<td>'.$val->email.'</td>
		<td>'.$val->user_id.'</td>
		<td>'.$val->phone.'</td>';
		$html.='<td>';
		if($val->status == "Pending"){$html.='<label style="color:orange;font-weight:bold;">'.$val->status.'</label>';}
		if($val->status == "Approved"){$html.='<label style="color:blue;font-weight:bold;">'.$val->status.'</label>';}
		if($val->status == "Rejected"){$html.='<label style="color:red;font-weight:bold;">'.$val->status.'</label>';}
		if($val->status == "Completed"){$html.='<label style="color:green;font-weight:bold;">'.$val->status.'</label>';}
		$html.='<td>';
		$html.="<a href=admin.php?page=Test-class&new=list_appointments.php&apid=".$val->app_id."&userid=".$val->user_id." class='button-primary'>Edit</a>";
		'</tr>';	
		}
	  }
	}
	else
	{
		$html.="<label style='color:red;'>* Appointment list not available...</label>";
	}

$html.='</table>';
$html.='</form>';
  }
 return $html;
  }

  public function action()
  {
  	global $wpdb;
  	$table_name = $wpdb->prefix . 'Appointments';
	//$tb=$wpdb->prefix.'events';
  	$a=$_SERVER['REQUEST_URI'];
  	$sb= explode("&", $a);

  	if(is_admin())
	{
		
		extract($_REQUEST);
		$total=get_option('booking_perday'); // Total no of events perday booked
		if(isset($ebtnup))
		{
  
	    $e_id=$_REQUEST['apid'];
	    $name=trim($_REQUEST['txteappname']);
	    $dt=date('Y-m-d',strtotime(trim($_REQUEST['txtedate'])));
	    $em=trim($_REQUEST['txteemail']);
	   // die($dt);
	    $ph=trim($_REQUEST['txtephone']);
	    $uid=trim($_REQUEST['txtuid']);
	    $status = $_REQUEST['estatus'];
  
	    if($dt<date('Y-m-d')){           /* Date must not less than today date */
	      echo "<p>* Date must be today or grater than today date!</p>";
	      exit();
	    }
	    if(!preg_match("/^[a-zA-Z -]+$/", $name)){ /* match only string not numeric value */
	        echo "<p>* Number not alowed!</p>";
	        exit();
	    }

	    $abc=$wpdb->get_var("SELECT count(start) from $table_name WHERE start='".$dt."'");
  		
     	 if($abc>=$total){
            echo "<p>* You can book only {$total} events on particular date!</p>";
            exit();
        }
        else
        {
	    	$query=$wpdb->update($table_name,array('title'=>trim($name),'start'=>$dt,'email'=>$em,'status'=>$status),
	    				array('app_id'=>$e_id,'user_id'=>$uid),
	    				array('%s','%s','%s','%s'),
	    				array('%d','%d')
	    			);
		    if($query==true)
		    {
		       if($status=='Approved')
	    		{
	    			require_once dirname(__FILE__).'/templates/appointment_approval(user).php';
	   
	    		}
	    		if($status == "Rejected")
	    		{
	    			require_once dirname(__FILE__).'/templates/appointment_delete(admin).php';
	    		}

		       require_once dirname(__FILE__).'/templates/appointment_update(admin).php';
		       print "<script>alert('* Appointment is updated!')</script>";
		       print '<META HTTP-EQUIV="Refresh" Content="0; URL='.$sb[0].'&'.$sb[1].'">';
		    }

		    else{
		          print '<META HTTP-EQUIV="Refresh" Content="0; URL='.$sb[0].'">';
		    }

		}
	}

	if(isset($ebtncan))
	{
		print '<META HTTP-EQUIV="Refresh" Content="0; URL='.$sb[0].'&'.$sb[1].'">';
		exit();
	}
  }
}

public function frontappointments_list()
{
	global $wpdb,$html;
    $table_name = $wpdb->prefix . 'Appointments';
   // $tb=$wpdb->prefix.'events';
   // $userid=get_current_user_id();

    $url=$_SERVER['REDIRECT_URL'];
    $a=explode("/", $url);

   // print_r($_SERVER);
  if(is_user_logged_in())
  {
	  $userid=get_current_user_id();
	  $userdata = get_userdata($userid);
	  $email = $userdata->user_email;

	  $data=$wpdb->get_results($wpdb->prepare("SELECT * from $table_name where user_id=%d",$userid));
	  $rows=count($data);
	  if($rows>0)
	  { //echo "<pre>";
	      //print_r($_SERVER);
	  $html.='<form action='.$_SERVER['REQUEST_URI'].' name="e_frm" method="post">';
	  $html.='<table border="1" style="width:900px;">
	  <tr>
	      <th>ID</th>
	      <th>Name of Appointments</th>
	      <th>Date of Appointments</th>
	      <th>Email</th>
	      <th>Phone</th>
	      <th>Status</th>
	      <th colspan="2">Options</th>
	  </tr>';
   
	  foreach($data as $key => $val){
	        $st=$val->status;
	        if(isset($_REQUEST['appid']) && $_REQUEST['appid']==$val->app_id)
	        {
	          $id=$_REQUEST['appid'];

	          $html.='<tr>
	            <td>'.$val->app_id.'</td>
	            <input type="hidden" name="txtid" value="'.$id.'" readonly/>
	            <td><input type="text" name="txteappname" value="'.$val->title.'" required/></td>
	            <td><input type="text" name="txtedate" value="'.$val->start.'" required id="txtedate"/></td>
	            <td><input type="text" name="txteemail" value="'.$email.'"></td>
	            <td><input type="text" name="txtephone" value="'.$val->phone.'"></td>';
	            $html.='<td>';
	            if($st=='Pending'){$html.='<span style="color:orange;font-weight:bold;">Pending</span>';}
	            if($st=='Approved'){$html.='<span style="color:blue;font-weight:bold;">Approved</span>';}
	            if($st=='Rejected'){$html.='<span style="color:red;font-weight:bold;">Rejected</span>';}
	            if($st=='Completed'){$html.='<span style="color:green;font-weight:bold;">Completed</span>';}
	        	$html.='</td>
	            <td>
	            <input type="submit" value="Update" name="btnup"/>
	            <input type="submit" value="Cancel" name="btncan"/>
	            </td>
	          </tr>';

	        }
	        else{

	    $html.='<tr>
	    <td>'.$val->app_id.'</td>
	    <td>'.$val->title.'</td>
	    <td>'.$val->start.'</td>
	    <td>'.$email.'</td>
	    <td>'.$val->phone.'</td>';
	    $html.='<td>';
	    if($st=='Pending'){$html.='<span style="color:#FFAD21;font-weight:bold;">Pending</span>';}
	    elseif($st=='Approved'){$html.='<span style="color:blue;font-weight:bold;">Approved</span>';}
	    elseif($st=='Rejected'){$html.='<span style="color:red;font-weight:bold;">Rejected</span>';}
	    elseif($st=='Completed'){$html.='<span style="color:green;font-weight:bold;">Completed</span>';}
		$html.='</td>';
	    $html.='<td>';
	    if($st!='Rejected')
	    {
		    $html.='<a href='.$_SERVER['REDIRECT_URL'].'?appid='.$val->app_id.'&userid='.$val->user_id.'>Edit</a> |';
		    $html.='<a href='.$_SERVER['REDIRECT_URL'].'?apid='.$val->app_id.'&userid='.$val->user_id.' onclick="return confirm(\'Are you sure want to delete?\');">Delete</a>';
		}
		$html.='</td></tr>';  
		}
	  }
    }
 }
else
 {
      echo "* No records found!";
      exit();
 }
	 $html.='</table>'; 
	 $html.='</form>';
	 return $html;	
}
	
	public function manage_front_action()
	{
		global $wpdb;
    	$table_name = $wpdb->prefix . 'Appointments';
    	//$tb=$wpdb->prefix.'events';
    	
    	$a=$_SERVER['REQUEST_URI'];
		 // die($a);
		$sb= explode("?", $a);


    	if(is_user_logged_in()){

			if(isset($_REQUEST['apid'])){

				//require_once dirname(__FILE__).'/templates/appointment_delete(user).php';
	    		
			    $id=$_REQUEST['apid'];
			    $userid=get_current_user_id();

			    $url=$_SERVER['REQUEST_URI'];

			    $arr=explode("&", $url);

			    $res=$wpdb->update($table_name,array('status'=>'Rejected'),
		    			array('app_id'=>$id,'user_id'=>$userid),
		    			array('%s'),
		    			array('%d','%d')
		    	 );

			    if($res==true){
			    	require_once dirname(__FILE__).'/templates/appointment_delete(user).php';
			        echo '<META HTTP-EQUIV="Refresh" Content="0; URL='.$arr[0].'">';
			    }
			}

		if(isset($_REQUEST['btnup'])){
			
		    $userid=get_current_user_id();
		    $total=get_option('booking_perday'); // Total no of events perday booked

		    $e_id=$_REQUEST['txtid'];
		    $name=trim($_REQUEST['txteappname']);
		    $dt=date('Y-m-d',strtotime(trim($_REQUEST['txtedate'])));
		   // die($dt);
		    $em=trim($_REQUEST['txteemail']);
		    $ph=trim($_REQUEST['txtephone']);

		   // die($e_id);

		    if($dt<date('Y-m-d')){           /* Date must not less than today date */
		      echo "<p>* Date must be today or grater than today date!</p>";
		      exit();
		    }
		    if(!preg_match("/^[a-zA-Z -]+$/", $name)){ /* match only string not numeric value */
		        echo "<p>* Number not alowed!</p>";
		        exit();
		    }

		    $abc=$wpdb->get_var("SELECT count(start) from $table_name WHERE start='".$dt."' and user_id='$userid'");
		  
		    if($abc>=$total){
		        echo "<p>* You can book only {$total} events on particular date!</p>";
		        exit();
		    }
		    else
		    {
		   	$udata = wp_update_user( array( 'ID' => $userid, 'user_email' => $em ) ); 
		   
		    $query=$wpdb->update($table_name,array('title'=>trim($name),'start'=>$dt,'email'=>sanitize_email($em),'phone'=>trim($ph)),
		    				array('app_id'=>$e_id,'user_id'=>$userid),
		    				array('%s','%s','%s','%s'),
		    				array('%d','%d')
		    			); 
		   
		    if($query==true && $udata==true){
		       require_once dirname(__FILE__).'/templates/appointment_update(user).php';

		       print "<script>alert('* Appointment is updated!')</script>";
		       print '<META HTTP-EQUIV="Refresh" Content="0; URL='.$sb[0].'">';
		    }
		    else{
		          print '<META HTTP-EQUIV="Refresh" Content="0; URL='.$sb[0].'">';
		    }
		  }
		 
		 }

		 if(isset($_REQUEST['btncan']))  // Redirect to page
		 {
		 	print '<META HTTP-EQUIV="Refresh" Content="0; URL='.$sb[0].'">';
		 	exit();
		 }

		}		 
	}

	public function user_validation($username, $password, $email, $website, $first_name, $last_name, $nickname, $bio)
	{
		global $reg_errors,$html;
		extract($_POST);
		$reg_errors = new WP_Error;
		if ( isset($_POST['submit'] ) ) {
		if ( empty( $username ) || empty( $password ) || empty( $email ) ) {
    		$reg_errors->add('field', 'Required form field is missing');
		}

		if ( 4 > strlen( $username ) ) {
    		$reg_errors->add( 'username_length', 'Username too short. At least 4 characters is required' );
		}

		if ( username_exists( $username ) ){
    		$reg_errors->add('user_name', 'Sorry, that username already exists!');

		} 

		if ( ! validate_username( $username ) ) {
    		$reg_errors->add( 'username_invalid', 'Sorry, the username you entered is not valid' );
		}

		if ( 5 > strlen( $password ) ) {
        	$reg_errors->add( 'password', 'Password length must be greater than 5' );
    	}

    	if ( !is_email( $email ) ) {
    		$reg_errors->add( 'email_invalid', 'Email is not valid' );
		}

		if ( email_exists( $email ) ) {
   			 $reg_errors->add( 'email', 'Email Already in use' );
		}

		if ( ! empty( $website ) ) {
    		if ( ! filter_var( $website, FILTER_VALIDATE_URL ) ) {
        $reg_errors->add( 'website', 'Website is not a valid URL' );
    		}
		}

		if ( is_wp_error( $reg_errors ) ) {
 
    	foreach ( $reg_errors->get_error_messages() as $error ) {
     
        echo '<div>';
        echo '<strong>ERROR</strong>:';
        echo $error . '<br/>';
        echo '</div>';
         
    	}
    	}
	}
}	

	public function confirm_mail($email,$admin_email,$userid)
	{
		$to      = $email;
	    $from    = $admin_email; 
	    $subject = "Confirmation mail";
	    $content = 
	    ' <div id="header" style="margin: 0 auto;padding: 10px;color: #fff;text-align: center;background-color: #FFFFFF;font-family: Open Sans,Arial,sans-serif;">'.$img.'  
	    <div id="outer" style="margin: 0 auto;margin-top: 10px;text-align: left;">'.  
	   '<div id="inner" style="margin: 0 auto;background-color: #fff;font-family: Open Sans,Arial,sans-serif;font-size: 13px;font-weight: normal;line-height: 1.4em;color: #444;margin-top: 10px;">'. 
	       '<p>Hi '.$username.'</p>'.
	       '<p>Please click here <a href='.plugin_dir_url(dirname(__FILE__ )).'inc/confirm_mail.php?id='.$userid.' target=blank>Link</a> to confirm mail. </p>'. 
	       '<p>Thank you.</p>'.  
	   '</div>'.   
	'</div>'.
	      $headers.= "From: {$from} \r\n"; 
		  $headers.= "Reply-To: {$from}\r\n"; 
		  $headers.= "MIME-Version: 1.0\r\n";
		  $headers.= "Content-Type: text/html; charset=ISO-8859-1\r\n";

	}

	public function complete_registration() {
    global $reg_errors, $username, $password, $email, $website, $first_name, $last_name, $nickname, $bio;
    extract($_POST);
    if ( isset($_POST['submit'] ) ) {
    $admin_email = get_option('admin_email');
    $attachments = get_posts( array(
    'post_type' => 'attachment',
    'posts_per_page' => 1,
    'post_status' => null,
    'post_mime_type' => 'image'
    ) );

    foreach ( $attachments as $attachment ) {
        $img=wp_get_attachment_image( $attachment->ID, 'thumbnail' );
    }          

    if ( 1 > count( $reg_errors->get_error_messages() ) ) {
        $userdata = array(
        'user_login'    =>   $username,
        'user_email'    =>   sanitize_email($email),
        'user_pass'     =>   $password,
        'user_url'      =>   $website,
        'first_name'    =>   $first_name,
        'last_name'     =>   $last_name,
        'nickname'      =>   $nickname,
        'description'   =>   $bio,
        );

      // Confirmation mail send
        
      

      $user    = wp_insert_user( $userdata );
      echo '* Registration complete. Please check your mail to confirm email adress. <br/>* Click here to <a href="' . get_site_url() . '/wp-login.php">Wp-login</a>.'; 

	  $this->confirm_mail($email,$admin_email,$user);
      wp_mail($to, $subject, $content, $headers);
    }
  }
}

/*public function get_id($id)
{
	global $html;
	if($id){
			$html.="* Congratulations, Your email address sucessfully verified! <br/>";
			$html.="Thank you.";
	}
	else{
			$html.="error";
			exit();	
	}
	return $html;
}
*/
public function get_image()
{
	$attachments = get_posts( array(
    'post_type' => 'attachment',
    'posts_per_page' => 1,
    'post_status' => null,
    'post_mime_type' => 'image'
) );

foreach ( $attachments as $attachment ) {
    echo wp_get_attachment_image( $attachment->ID, 'thumbnail' );
}
}

/*public function emailtemplate_validation($template_code,$template_subject,$template_text)
{
	extract($_POST);
	global $reg_errors,$html;
	$reg_errors = new WP_Error;
	if ( trim(empty( $template_code ) ))
	{
    	$reg_errors->add('Required', 'Template name field is missing');
	}
	if(trim(empty( $template_subject )))
	{
		$reg_errors->add('Required', 'Template subject field is missing');
	}
	if(trim(empty( $template_text ) ))
	{
		$reg_errors->add('Required', 'Template content field is missing');
	}
	if ( is_wp_error( $reg_errors ) ) {
 
    	foreach ( $reg_errors->get_error_messages() as $error ) {
     
        echo '<div style="box-shadow:0 1px 1px 0;border-left:2px solid #7ad03a;padding: 6px 10px;margin:2px 20px;background-color:#fff;">';
        echo '<strong>ERROR</strong>:';
        echo $error . '<br/>';
        echo '</div>';
         
    	}
    }
}
public function email_store()  // Template created
{
	extract($_POST);
	global $wpdb,$reg_errors;
	//$reg_errors = new WP_Error;
	$table=$wpdb->prefix."email_templates";

	if(isset($btnsubmit))
	{	
		$this->emailtemplate_validation($template_code,$template_subject,$template_text);
		if ( 1 > count( $reg_errors->get_error_messages() ) ){
		$true=$wpdb->query("INSERT INTO {$table} (`temp_code`,`temp_content`,`temp_style`,`temp_subject`) VALUES ('{$template_code}','{$template_text}','{$template_style}','{$template_subject}')");	
		if($true==true){
			echo '<div style="box-shadow:0 1px 1px 0;border-left:2px solid #7ad03a;padding: 6px 10px;margin:2px 20px;background-color:#fff;"><strong>* New Email Template Created.</strong></div>';
		}
		else{echo mysql_error();exit();
		}
	}
}
}

public function update_template(){    // Template updated

	extract($_POST);
	global $wpdb,$reg_errors;
	//$reg_errors = new WP_Error;
	$table=$wpdb->prefix."email_templates";
	if(isset($btnupdate))
	{
		$true=$wpdb->query("UPDATE $table SET `temp_code`='{$template_code}',`temp_content`='{$template_text}',`temp_style`='{$template_styles}',`temp_subject`='{$template_subject}' WHERE `temp_id`='{$tempid}'");	
		if($true==true){
			echo '<div style="box-shadow:0 1px 1px 0;border-left:2px solid #7ad03a;padding: 6px 10px;margin:2px 20px;background-color:#fff;"><strong>* Template Updated</strong></div>';
		}
		else{echo mysql_error();exit();
	}
}

}

public function get_templates_name()
{
	global $wpdb;
    $table=$wpdb->prefix."email_templates";

    $templates_name=$wpdb->get_results("SELECT * from {$table}");
    
    foreach ($templates_name as $key => $value) {
                echo "<option value='$value->temp_id'>".$value->temp_code."</option>";
    }
}

public function getcustomer_name(){

	global $wpdb;	
	$table=$wpdb->prefix."users";
	$users=get_userdata(1); // Admin user id
	$name=$wpdb->get_var("SELECT user_login from {$table} WHERE ID!='{$users->ID}'");
	return $name;
}

public function getcustomer_pwd(){

	global $wpdb;	
	$table=$wpdb->prefix."users";
	$users=get_userdata(1); // Admin user id
	$pwd=$wpdb->get_var("SELECT user_pass from {$table} WHERE ID!='{$users->ID}'");
	return $pwd;
}

public function getcustomer_email()
{
	global $wpdb;	
	$table=$wpdb->prefix."users";
	$users=get_userdata(1); // Admin user id
	$id=$wpdb->get_var("SELECT ID from {$table} WHERE ID!='{$users->ID}'");
	$email="<a href=".plugins_url()."/Test/shortcodes/confirm_mail.php?id={$id} target=blank>Link</a>";
	return $email;
}

public function getappname()
{
	global $wpdb;	
	$table=$wpdb->prefix."Appointments";
	//$users=get_userdata(1); // Admin user id
	$user=get_current_user_id();
	$appname=$wpdb->get_var("SELECT `appointment_name` from {$table} WHERE user_id='{$user}'");
	return $appname;
}

public function getappdate()
{
	global $wpdb;	
	$table=$wpdb->prefix."Appointments";
	//$users=get_userdata(1); // Admin user id
	$user=get_current_user_id();
	$appdate=$wpdb->get_var("SELECT `date_of_apointment` from {$table} WHERE user_id='{$user}'");
	return $appdate;
}

public function image_code() {

	$attachments = get_posts( array(
    'post_type' => 'attachment',
    'posts_per_page' => 1,
    'post_status' => null,
    'post_mime_type' => 'image'
) );

foreach ( $attachments as $attachment ) {
	$link=$attachment->guid;
}	
   // $args = shortcode_atts( array( 'url' => FALSE ), $atts  );
    $img  = esc_url( $link );
  //  $url  = $args['url'] ? esc_url( $args['url'] ) : $img;

    return "<img src='$img' style='width:300px;height:150px;'/>";
}*/

}
?>