<?php $test=new WPUF_Main();?>
<html lang="en">
<head>
<script>
   jQuery(document).ready(function($) {
  //  var a="<?php echo plugins_url().'/Testplugin/admin/events.php';?>";
    var calendar = $('#calendar').fullCalendar({
     editable: true,
     header: {
      left: 'prev,next today',
      center: 'title',
      right: 'month,agendaWeek,agendaDay'
     },
    
     events: <?php echo $test->frontcal_events()?>,
     // Convert the allDay from string to boolean
     eventRender: function(event, element, view) {
     // console.log(event);
      if (event.allDay === 'true') {
       event.allDay = true;
      } else {
       event.allDay = false;
      }
     },
     selectable: false,
     selectHelper: true

    });
    
   });
  </script>
</head>  
<body>
<div id='calendar'></div>
<!-- <span id="erdate" style="display:none; color:#F00">* You can book only 3 events on particular date!</span> -->
</body>
</html>