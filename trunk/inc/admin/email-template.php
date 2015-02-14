<?php
            $test=new WPUF_Main();
           //echo $test->getcustomer_name();
            global $wpdb;
            $table=$wpdb->prefix."email_templates";
            if($_POST['slt_template']!=0)
            {   
                $emailid=$_POST['slt_template'];
                $a=$wpdb->get_results("SELECT `temp_code`,`temp_content`,`temp_style`,`temp_subject` from 
                    {$table} WHERE `temp_id`='{$emailid}'");
               foreach($a as $val)
               {
                  $code=$val->temp_code;
                  $subject=$val->temp_subject;
                  $style=$val->temp_style;
                  $content=$val->temp_content;
               }
        }
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 
	<style type="text/css">
	input[type="text"]{width: 430px;}
    table,tr,td{margin: 2px 5px 0 10px;padding: 5px;}
    form{width: 800px;}
    <?php if(isset($_POST['btnupdate']))echo trim($_POST['template_styles']);?>
	</style>
	<title>New Email Template</title>
</head>
<body>
<form method="post">
	<h2>New Template</h2>
<table cellspacing="0" class="form-list">
    <input type="hidden" value="<?php echo $emailid;?>" name="tempid">
<tbody>
<tr>
        <td><label for="slt_template">Select Templates :-</label></td>
        <td>
            <select name="slt_template" id="slt_template">
                <option value="0">-Select Templates-</option>
                <?php  
                        $test->get_templates_name();
                ?>
            </select>
        </td>
</tr>
<tr>
    <td></td>
    <td><input type="submit" name="btnload" value="Load Template" class="button-primary"></td>
</tr>
<tr>
    <td><label for="template_code">Template Name <span>*</span></label></td>
    <td>
        <input id="template_code" name="template_code" type="text" value="<?php if($_POST['slt_template']!=0)echo trim($code);?>" <?php if($_POST['slt_template']!=0)echo "required";?>/>            
    </td>
</tr>
<tr>
	<td><label for="template_subject">Template Subject <span>*</span></label></td>
	<td><input id="template_subject" name="template_subject" type="text" value="<?php if($_POST['slt_template']!=0) echo trim($subject);?>" <?php if($_POST['slt_template']!=0)echo "required";?>/></td>
  <td><input type="button" name="btnsortcode" id="btnsortcode" value="Insert Sortcode" class="button-primary"></td>
</tr>
<tr>
     <td><label for="template_text">Template Content <span>*</span></label></td>
    <td>
        <textarea id="template_text" name="template_text" title="Template Content" rows="10" cols="50" onchange="getClickPosition()"<?php if($_POST['slt_template']!=0)echo "required";?>/><?php if($_POST['slt_template']!=0) echo trim($content);?>
        </textarea>            
    </td>
 </tr>
<tr >
    <td><label for="template_styles">Template Styles</label></td>
    <td>
        <textarea id="template_styles" name="template_styles" rows="10" cols="50"><?php if($_POST['slt_template']!=0) echo trim($style);?>
        </textarea>
    </td>
</tr>
<tr>
	<td></td>
	<td>
        <?php if($_POST['slt_template']!=0)
        {?>
        <input type="submit" name="btnupdate" value="Update Template" class="button-primary">
        <?php 
        }
        else{
        ?>
        <input type="submit" name="btnsubmit" value="Save Template" class="button-primary">
    <?php }?>
    </td>
</tr>
</tbody>
</table>
</form>
</body>

<script type="text/javascript">
jQuery(document).on('click', '#btnsortcode', function () {
   // alert("hh");
});
</script>

</html>
<?php
$test->email_store();  // Save template

$test->update_template();
/*die();
if(isset($_POST['btnupdate']))
{
    $id=$_POST['tempid'];
    $table=$wpdb->prefix.'email_templates';

    $name = do_shortcode( '[cname]' );
    $pwd = do_shortcode( '[password]' );
    $logo = do_shortcode( '[logo-link]' );
    $link = do_shortcode( '[email-link]' );
    $app = do_shortcode( '[appname]' );
    $date = do_shortcode( '[appdate]' );
    $content='';

    $results=$wpdb->get_results("SELECT * from $table WHERE `temp_id`='$id'");
    foreach($results as $key => $val)
    {
       $content.=$val->temp_content;
       if( has_shortcode( $content, 'logo-link' ) ) {
           $content=str_replace('[logo-link]', $logo, $content);  
        }
       if( has_shortcode( $message, 'cname' ) ) {
           $content=str_replace('[cname]', $name, $content);  
        }
       if(  has_shortcode( $message, 'password' ) )
       {
          $content=str_replace('[password]', $pwd, $content);
       }
       if(  has_shortcode( $message, 'email-link' ) )
       {
          $content=str_replace('[email-link]', $link, $content);
       }
       if(  has_shortcode( $message, 'appname' ) )
       {
          $content=str_replace('[appname]', $app, $content);
       }
       if(  has_shortcode( $message, 'appdate' ) )
       {
          $content=str_replace('[appdate]', $date, $content);
       }
    }
    $site=site_url();
    $message  = sprintf(__('New user registration on your site %s:'), $site) . "\r\n\r\n";     
    $message .= sprintf(__('Username: %s'), $name) . "\r\n\r\n";     
    $message .= sprintf(__('E-mail: %s'), $link) . "\r\n";     //Send admin notification email  
      
   // @wp_mail(get_option('admin_email'), sprintf(__('[%s] New User Registration'), $site), $message) ; 
    
    $message = str_ireplace('[cname]',$name, $content);
    $message = str_ireplace('[password]',$pwd, $message);     
    $message = str_ireplace('[email-link]',$link, $message);     
    $message = str_ireplace('[logo-link]',$logo, $message);
    $message = str_ireplace('[appname]',$app, $message);
     $message = str_ireplace('[appdate]',$date, $message);
    $headers  = 'MIME-Version: 1.0' . "\r\n";     
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";



    die($message);

    wp_mail($user_email, 'Social Wendy Insider Access', $message, $headers); 
}*/