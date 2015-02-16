<?php
        $old=get_option( 'new_date' );  // Get database date
        $newdate=date("d-m-Y", strtotime($old));
?>
<script type="text/javascript">
  jQuery(document).ready(function ($) {

    var unavailableDates = ["<?php echo $newdate;?>"];

    function unavailable(date) {  // Hide sunday and holiday days
        var day = date.getDay();
        dmy = ("0"+date.getDate()).slice(-2) + "-" + ("0"+(date.getMonth()+1)).slice(-2) + "-" + date.getFullYear();
        if ($.inArray(dmy, unavailableDates) == -1) {
            return [true, ""];
           // return [(day > 0), ''];
        } else {
            return [false, "", "Unavailable"];
        }
    }

    $( "#txtedate" ).datepicker({
      changeMonth: true,//this option for allowing user to select month
      changeYear: true, //this option for allowing user to select from year range
      beforeShowDay: unavailable,
      minDate:0
    });
  }

);
</script>
<?php
			echo $this->frontappointments_list();
?>