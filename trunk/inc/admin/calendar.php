<?php $test=new WPUF_Main();?>
<!DOCTYPE html>
<html lang="en">
<head>
<script>
 jQuery(document).ready(function($) {
  var currentTime = new Date()

  var twoDigitMonth = currentTime.getMonth() +1 +"";if(twoDigitMonth.length==1)  twoDigitMonth="0" +twoDigitMonth;
  var twoDigitDate = currentTime.getDate()+"";if(twoDigitDate.length==1) twoDigitDate="0" +twoDigitDate;
  var date = currentTime.getFullYear()+ "-" + twoDigitMonth + "-" + twoDigitDate;

  var calendar = $('#calendar').fullCalendar({ 
    editable: true,
    header: {
    left: 'prev,next today',
    center: 'title',
    right: 'month,agendaWeek,agendaDay'
   },
   eventLimit: {
        'agenda': 3, // adjust to 6 only for agendaWeek/agendaDay
        'default': true // give the default value to other views
    },
   events: <?php echo $test->calendar_events()?>,
   // Convert the allDay from string to boolean
   eventRender: function(event, element, view) {
    if (event.allDay === 'true') {
     event.allDay = true;
    } else {
     event.allDay = false;
    }
   },
   selectable: true,
   selectHelper: true,
   select: function(start, end, allDay) {
   var title = prompt('Event Title:');
   var url = "<?php echo admin_url().'admin.php?page=Test-class';?>";

   if (title) {
   var start = moment(start).format('YYYY-MM-DD');
   //var end = $.fullCalendar.formatDate(end, "yyyy-MM-dd HH:mm:ss");
   if(start<date){
    alert("* Date must be today or greater then today!");
    return false;
   }
   $.ajax({
   url: the_ajax_script.ajaxurl,
   data: {
            action:'the_ajax_script',
            title:title,
            start:start,
            url:url
        },
   type: "POST",
   success: function(data) {
   if(data!=''){alert(data);setTimeout(function(){window.location.reload(1);}, 2000);}
   }
   });
   calendar.fullCalendar('renderEvent',
   {
   title: title,
   start: start,
   //end: end,
   allDay: allDay
   },
   true // make the event "stick"
   );
   }
   calendar.fullCalendar('unselect');
   }
   
  });
  
 });
</script>
</head>
<body>
<div id='calendar'></div>
<!-- <span id="erdate" style="display:none; color:#F00">* You can book only 3 events on particular date!</span> -->
</body>
</html>