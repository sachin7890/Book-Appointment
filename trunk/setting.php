<!DOCTYPE html>
<html lang="en">
<head>
<script type="text/javascript">
jQuery(document).ready(function($){
$( "#new_date" ).datepicker({
      changeMonth: true,//this option for allowing user to select month
      changeYear: true, //this option for allowing user to select from year range
      minDate:0
    });
});
</script>
<head>
<div class="wrap">
<h2>Settings</h2>

<form method="post" action="options.php">
    <?php settings_fields( 'baw-settings-group' ); ?>
    <?php do_settings_sections( 'baw-settings-group' ); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row">Email address</th>
        <td><input type="email" name="email_address" value="<?php echo esc_attr( get_option('email_address') ); ?>" /></td>
        </tr>
         
        <tr valign="top">
        <th scope="row">Check holiday/leave</th>
        <td><input type="text" name="new_date" id="new_date" value="<?php echo esc_attr( get_option('new_date') ); ?>" /></td>
        </tr>
        
        <tr valign="top">
        <th scope="row">Booking perday</th>
        <td><input type="text" name="booking_perday" value="<?php echo esc_attr( get_option('booking_perday') ); ?>" /></td>
        </tr>

        <tr valign="top">
        <th scope="row">Upload Image</th>
		<td><label for="upload_image">
		<input id="upload_image" type="text" size="36" name="upload_image" value="<?php echo esc_attr( get_option('upload_image') ); ?>" />
		<input id="upload_image_button" type="button" value="Upload Image" />
		<br />Enter an URL or upload an image for the logo.
		</label>
		</td>
        </tr>
    </table>
    <?php submit_button(); ?>
</form>
</div>
<?php
        $this->get_image();
?>