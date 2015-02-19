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
<div id="wpbody">
    <div class="wrap">
        <h2><?php _e('Appointments Settings') ?></h2>
        <hr>
        <form action="options.php" method="post">
            <?php settings_fields( 'baw-settings-group' ); ?>
        <table class="form-table">
        <tr valign="top">
            <th scope="row"><?php _e('Email address');?></th>
            <td><input type="email" name="baw-settings-group[email_address]" value="<?php echo esc_attr( $this->options['email_address'] ); ?>" /></td>
        </tr>
         
        <tr valign="top">
            <th scope="row"><?php _e('Block holiday/leave');?></th>
            <td><input type="text" name="baw-settings-group[new_date]" id="new_date" value="<?php echo esc_attr( $this->options['new_date'] ); ?>" /></td>
        </tr>
        
        <tr valign="top">
            <th scope="row"><?php _e('Booking perday');?></th>
            <td><input type="text" name="baw-settings-group[booking_perday]" value="<?php echo esc_attr( $this->options['booking_perday'] ); ?>" /></td>
        </tr>

        <tr valign="top">
        <th scope="row"><?php _e('Upload Image');?></th>
        <td>
            <label for="upload_image">
            <input id="upload_image" type="text" size="36" name="baw-settings-group[upload_image]" value="<?php echo esc_attr( $this->options['upload_image'] ); ?>" />
            <input id="upload_image_button" type="button" value="Upload Image" />
            <br />Enter an URL or upload an image for the logo.
            </label>
        </td>
        </tr>
    </table>
<p class="submit"><input type="submit" value="<?php _e('Save Changes') ?>" class="button button-primary" id="submit" name="submit"></p>
</form>
<?php if(isset($this->options['upload_image'])):?><img src="<?php echo esc_attr( $this->options['upload_image'] );?>" class="imglogo"><?php endif;?>
</div>
    <div class="clear"></div>
</div>
<div class="clear"></div>