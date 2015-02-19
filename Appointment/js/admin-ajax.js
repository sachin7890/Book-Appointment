 jQuery(document).ready(function($){
    $("#btnadd").click(function() {
                 
    /*  Get today date */
    var currentTime = new Date()

    var twoDigitMonth = currentTime.getMonth() +1 +"";if(twoDigitMonth.length==1)  twoDigitMonth="0" +twoDigitMonth;
    var twoDigitDate = currentTime.getDate()+"";if(twoDigitDate.length==1) twoDigitDate="0" +twoDigitDate;
    var date = twoDigitMonth + "/" + twoDigitDate + "/" + currentTime.getFullYear();

    /* End date */

    var dt=$('#dtpicker').val(); 
    var app=$('#txtappt').val();
    var email=$('#txtemail').val();
    var phone=$('#txtphone').val();


    if(dt.length==0){$('#erdate').fadeIn(2000);$('#erdate').fadeOut('slow');return false;}
    else if(dt<date){$('#errdate').fadeIn(2000);$('#errdate').fadeOut('slow');return false;}
    else if(app.length==0){$('#erappt').fadeIn(2000);$('#erappt').fadeOut('slow');return false;}
    else if(app.match(/^[0-9]+$/)){$('#erappt1').fadeIn(2000);$('#erappt1').fadeOut('slow');return false;}
    else if(email.length==0 || !email.match(/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i)){jQuery('#eremail').fadeIn(2000);jQuery('#eremail').fadeOut('slow');return false;}
    else
 
    var dataString = 'dtpicker='+ dt + '&txtappt=' + app + '&txtemail=' + email + '&txtphone=' + phone;

    var data = {
      url:ajaxurl,
      action: 'test_response',
      date: dt,
      app: app,
      email: email,
      phone: phone
    };
    // the_ajax_script.ajaxurl is a variable that will contain the url to the ajax processing file
    $.post(the_ajax_script.ajaxurl, data, function(response) {
    alert(response);
    document.getElementById("frm").reset();return false;
    });
    return false;

    });

$("#add").click(function(){

    var currentTime = new Date()

    var twoDigitMonth = currentTime.getMonth() +1 +"";if(twoDigitMonth.length==1)  twoDigitMonth="0" +twoDigitMonth;
    var twoDigitDate = currentTime.getDate()+"";if(twoDigitDate.length==1) twoDigitDate="0" +twoDigitDate;
    var date = twoDigitMonth + "/" + twoDigitDate + "/" + currentTime.getFullYear();
    
    var dt=$('#dtpicker').val(); 
    var app=$('#txtappt').val();
    //var email=$('#txtemail').val();
    var phone=$('#txtphone').val();

    if(dt.length==0){$('#erdate').fadeIn(2000);$('#erdate').fadeOut('slow');return false;}
    else if(dt<date){$('#errdate').fadeIn(2000);$('#errdate').fadeOut('slow');return false;}
    else if(app.length==0){$('#erappt').fadeIn(2000);$('#erappt').fadeOut('slow');return false;}
    else if(app.match(/^[0-9]+$/)){$('#erappt1').fadeIn(2000);$('#erappt1').fadeOut('slow');return false;}
    else if(phone.length!=10 || isNaN(phone)){$('#erephn').fadeIn(2000);$('#erephn').fadeOut('slow');return false;}
    else

    var dataString = 'dtpicker='+ dt + '&txtappt=' + app + '&txtphone=' + phone;
    
    var data = {
      action: 'front_response',
      date: dt,
      app:  app,
      phone: phone
    };
    // the_ajax_script.ajaxurl is a variable that will contain the url to the ajax processing file
    $.post(the_ajax_script.ajaxurl, data, function(response) {
       alert(response);document.getElementById("frm").reset();
    });
    return false;

});

$('#upload_image_button').click(function() {
formfield = $('#upload_image').attr('name');
tb_show('', 'media-upload.php?type=image&TB_iframe=true');
return false;
});

window.send_to_editor = function(html) {
imgurl = $('img',html).attr('src');
$('#upload_image').val(imgurl);
tb_remove();
}

var str=location.href.toLowerCase();

$(".navigation li a").each(function() {

if (str.indexOf(this.href.toLowerCase()) > -1) {

 $("li.highlight").removeClass("highlight");

$(this).parent().addClass("highlight");

 }

});


});