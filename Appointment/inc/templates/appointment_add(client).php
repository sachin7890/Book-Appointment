<?php 
/** 
* @author     Jack Mason 
* @website    volunteer @ http://www.osipage.com , web access application and bookmarking tool.   
* @copyright free script 
* @created    2013 
* @Language  PHP 
* This script is free and can  be used anywhere, no attribution required 
*/ 

global $wpdb,$current_user;
$table=$wpdb->prefix.'Appointments';

//get_currentuserinfo();
$user=$current_user->user_login;

$admin_email = get_option('email_address');

$lastId = $wpdb->get_var("SELECT max(appointment_id) FROM $table"); // Get last inserted id

$res=$wpdb->get_results("SELECT * from $table WHERE appointment_id='".$lastId."'");

foreach($res as $val){

  $a=$val->email_id;
  $dat=$val->date_of_apointment;
}

$attachments = get_posts( array(
    'post_type' => 'attachment',
    'posts_per_page' => 1,
    'post_status' => null,
    'post_mime_type' => 'image'
    ) );

    foreach ( $attachments as $attachment ) {
        $img=wp_get_attachment_image( $attachment->ID, 'thumbnail' );
    }    

$url=site_url(); 

/* 
Change your message body in the given $subjectPara variables.  
$subjectPara1 means 'first paragraph in message body', $subjectPara2 means'first paragraph in message body', 
if you don't want more than 1 para, just put NULL in unused $subjectPara variables. 
*/ 

$subtitle=" Hi ".$user;
$subjectPara1 = 'New appointment successfully booked on <strong>'.$dat.'</strong>'; 
$subjectPara2 = 'Please click here to show <a href="'.$url.'">Appointments</a> !'; 
$subjectPara3 = 'Thank you'; 

$message = '<!DOCTYPE HTML>'. 
'<head>'. 
'<meta http-equiv="content-type" content="text/html">'. 
'<title>Appointment notification</title>'. 
'</head>'. 
'<body style="width:100%;">'. 
'<div id="header" style="width: 60%;margin: 0 auto;padding: 10px;color: #fff;text-align: center;background-color: #FFFFFF;font-family: Open Sans,Arial,sans-serif;">'.$img.' 
</div>'. 

'<div id="outer" style="width: 78%;margin: 0 auto;margin-top: 10px;">'.  
   '<div id="inner" style="width: 78%;margin: 0 auto;background-color: #fff;font-family: Open Sans,Arial,sans-serif;font-size: 13px;font-weight: normal;line-height: 1.4em;color: #444;margin-top: 10px;">'. 
       '<p>'.$subtitle.'</p>'.
       '<p>'.$subjectPara1.'</p>'. 
       '<p>'.$subjectPara2.'</p>'. 
       '<p>'.$subjectPara3.'</p>'.  
   '</div>'.   
'</div>'. 

'<div id="footer" style="width: 60%;height: 40px;margin: 0 auto;text-align: center;padding: 10px;font-family: Verdena;background-color: #EAEAEA;">'. 
   'All rights reserved by <a href="http://www.djsoutsourcing.com" target="_blank">Djs outsourcing</a> 2014'. 
'</div>'. 
'</body>'; 

$subtitle=" Hi Admin";
$subjectPara1 = 'New appointment successfully added by <strong>'.$user.'</strong> User.'; 
//$subjectPara2 = 'Please click here to show <a href="'.$url.'">Appointments</a> !'; 
$subjectPara3 = 'Thank you'; 

$message1 = '<!DOCTYPE HTML>'. 
'<head>'. 
'<meta http-equiv="content-type" content="text/html">'. 
'<title>Appointment notification</title>'. 
'</head>'. 
'<body style="width:100%;">'. 
'<div id="outer" style="width: 78%;margin: 0 auto;margin-top: 10px;">'.  
   '<div id="inner" style="width: 78%;margin: 0 auto;background-color: #fff;font-family: Open Sans,Arial,sans-serif;font-size: 13px;font-weight: normal;line-height: 1.4em;color: #444;margin-top: 10px;">'. 
       '<p>'.$subtitle.'</p>'.
       '<p>'.$subjectPara1.'</p>'. 
       /*'<p>'.$subjectPara2.'</p>'.*/ 
       '<p>'.$subjectPara3.'</p>'.  
   '</div>'.   
'</div>'. 

'<div id="footer" style="width: 60%;height: 40px;margin: 0 auto;text-align: center;padding: 10px;font-family: Verdena;background-color: #EAEAEA;">'. 
   'All rights reserved by <a href="http://www.djsoutsourcing.com" target="_blank">Djs outsourcing</a> 2014'. 
'</div>'. 
'</body>'; 

/*EMAIL TEMPLATE ENDS*/ 


$to      = $a;             // give to email address 
$subject = 'New Appointment';  //change subject of email 
$from    = $admin_email;                           // give from email address 
// mandatory headers for email message, change if you need something different in your setting. 
$headers  = "From: " . $from . "\r\n"; 
$headers .= "Reply-To: {$from}\r\n"; 
$headers1 = "Reply-To: {$to} \r\n";
$headers .= "MIME-Version: 1.0\r\n"; 
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n"; 
$headers1 .= "Content-Type: text/html; charset=ISO-8859-1\r\n"; 

//echo $message1.'\n';
//echo $message;

//die();

// Remember, mail function may not work in PHP localhost setup but the email template can be used anywhere like (PHPmailer, swiftmailer, PHPMail classes etc.) 
// Sending mail 
wp_mail($to, $subject, $message, $headers);
wp_mail($from,$subject,$message1,$headers1);
?>