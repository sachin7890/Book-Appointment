<?php

/*
Plugin Name: Book Appointment
Description: Book your appointment on particular date also manage appointments
Version: 2.0
Author: [Dj's outsourcing]
Author URI: [www.djsoutsourcing.com/]
License: A "Slug" license name e.g. GPL2
*/

/** Loads the WordPress Environment and Template */
require_once dirname(__FILE__).'/inc/functions.php';

class WPUF_Main extends Sub {

    public function __construct() {

        parent::__construct();
        register_activation_hook( __FILE__, array(&$this, 'install') );
       // register_uninstall_hook( __FILE__, array(&$this, 'uninstall') );

        wp_enqueue_script('WPUF_Main',plugin_dir_url(__FILE__).'js/admin-ajax.js',array('jquery'));
        wp_localize_script( 'WPUF_Main', 'the_ajax_script', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )) );  

        add_action('admin_menu',array(&$this, 'test_class_menu'));
        
        $plugin = plugin_basename( __FILE__ );
        add_filter( "plugin_action_links_$plugin", array(&$this,'plugin_add_settings_link' ));
       // add_action( 'admin_enqueue_scripts',array($this,'my_action_javascript'));
  
        add_action('wp_ajax_test_response', array(&$this,'my_action_callback' ));
        add_action('admin_init', array($this,'register_mysettings' ));

        $this->options = get_option('baw-settings-group');

        add_action('init', array(&$this,'wp_gear_manager_admin_scripts'));
        add_action('init', array(&$this,'wp_gear_manager_admin_styles'));
        add_action('wp_ajax_front_response', array($this,'front_ajax' ));
        add_action('init',array(&$this,'manage_front_action'));

        add_shortcode('appointmentshow', array(&$this,'appointment'));
        add_shortcode('calendershow',array(&$this,'front_calendershow'));
        add_shortcode('manage_front_appointmentslist',array(&$this,'front_appointmentslist'));
        add_shortcode('user_register',array(&$this,'front_signup'));
        add_shortcode('cname', array(&$this,'getcustomer_name'));
        add_shortcode('password', array(&$this,'getcustomer_pwd'));
        add_shortcode('email-link', array(&$this,'getcustomer_email'));
        add_shortcode('logo-link', array(&$this,'image_code'));
        add_shortcode('appname', array(&$this,'getappname'));
        add_shortcode('appdate', array(&$this,'getappdate')); 

        add_action('wp_ajax_the_ajax_script', array(&$this,'cal_event'));
        add_action('wp_ajax_nopriv_the_ajax_script', array(&$this,'cal_event'));

        add_filter('auto_update_plugin', array(&$this,'__return_true' ));
        //add_filter( 'auto_update_plugin', array($this,'exclude_plugins_from_auto_update'), 10, 2 );
  }

/*public function exclude_plugins_from_auto_update( $update, $item ) {
    return ( ! in_array( $item->slug, array(
        'Book Appointment',
    ) ) );
}*/

 public function install() {
        global $wpdb;

        flush_rewrite_rules( false );

        $table_name = $wpdb->prefix . 'Appointments';

        $sql2 = "CREATE TABLE IF NOT EXISTS $table_name (
        app_id int(11) NOT NULL AUTO_INCREMENT,
        title varchar(200) NOT NULL,
        start varchar(255) NOT NULL,
        url varchar(100) NOT NULL,
        allDay varchar(10) DEFAULT 'false' NOT NULL, 
        email varchar(200) NOT NULL,
        phone varchar(20) NULL,
        user_id bigint(20),
        status varchar(15) DEFAULT 'Pending' NOT NULL,
        PRIMARY KEY (app_id)
      )";

        $wpdb->query( $sql2 );

      $options = array(
              'email_address' => '',
              'new_date' => '',
              'booking_perday' =>1,
              'upload_image' =>''
      ); 

      if ( get_option( 'baw-settings-group' ) !== false ) {
    // The option already exists, so we just update it.
        update_option( 'baw-settings-group', $options );
      } 
      else
      {
      // The option hasn't been added yet. We'll add it with $autoload set to 'no'.
      add_option( 'baw-settings-group', $options );
      }
  }

  public function get_jqueryui_ver() {
    
    global $wp_version;
    
    if ( version_compare( $wp_version, '3.1', '>=') ) {
      return '1.8.10';
    }
    
    return '1.7.3';
  
  }
  public function test_class_menu() {
     // global $setting;
      add_menu_page( 'Appointment page', 'Appointment Book', 'manage_options', 'Test-class', array( $this, 'appointment_plugin' ));
      add_submenu_page( 'Test-class', __('Users', 'Appointment Book'), __('Users','Appointment Book'), 'manage_options','usermanage-page', array( $this, 'user_menu' ) );
      add_submenu_page( 'Test-class', __('Settings','Appointment Book'), __('Settings','Appointment Book'),'manage_options' ,'appointment_setting', array( $this, 'setting_menu' ));     
  }

  public function appointment_plugin(){
      require_once dirname(__FILE__).'/class-test.php'; 
    }

  public function plugin_add_settings_link( $links ) {
    $settings_link = '<a href="admin.php?page=Test-class">Settings</a>';
    array_push($links, $settings_link );
    return $links;
  }

  public function setting_menu()
  {
      require_once dirname(__FILE__).'/setting.php';
  }

  public function user_menu()
  {
    require_once dirname(__FILE__).'/inc/admin/users.php';
  }

  public function appointment()
  {
    if(is_user_logged_in())
    {
     require_once dirname(__FILE__).'/shortcodes/new-appointment.php';
    }
  }

  public function setting()
  {
    require_once dirname(__FILE__).'/setting.php';
  }

  public function register_mysettings() {
  //register our settings
    register_setting('baw-settings-group','baw-settings-group');
  }

 public function wp_gear_manager_admin_scripts() {
    wp_enqueue_script('media-upload');
    wp_enqueue_script('thickbox');
    wp_enqueue_script('jquery');

    wp_enqueue_script('jquery-ui-datepicker',includes_url().'js/jquery/ui/jquery.ui.datepicker.min.js',array('jquery'));  
    wp_enqueue_script( 'jquery-moment', plugin_dir_url(__FILE__).'js/moment.min.js', array('jquery')); 
    wp_enqueue_script( 'jquery-fullcalendar', plugin_dir_url(__FILE__).'js/fullcalendar.js', array('jquery'));   
    wp_enqueue_script( 'jquery-fullcalendar.min', plugin_dir_url(__FILE__).'js/fullcalendar.min.js', array('jquery')); 
  }

  public function wp_gear_manager_admin_styles() {
    wp_enqueue_style('thickbox');
    wp_enqueue_style('css');

    wp_enqueue_style( 'custom-css', plugin_dir_url(__FILE__).'css/custom.css', false, '');
    wp_enqueue_style( 'jquery-fullcalendar', plugin_dir_url(__FILE__).'css/fullcalendar.css', false, 'v2.1.1');
    wp_enqueue_style( 'jquery-ui', plugin_dir_url(__FILE__).'css/jquery-ui.css', false, 'v1.10.3');
  }
  public function front_signup()
  {
    if(!is_user_logged_in())
    {
      require_once dirname(__FILE__).'/shortcodes/signup.php';
    }
  }

  public function front_calendershow()
  {
    if(is_user_logged_in())
    {
      require_once dirname(__FILE__).'/shortcodes/front_calender.php'; 
    }
  }

  public function front_appointmentslist()
  {
    if(is_user_logged_in())
    {
      require_once dirname(__FILE__).'/shortcodes/front_appointmentlist.php';
    }
  }

  public function my_action_callback() {
    global $wpdb;
  
    $table_name = $wpdb->prefix . 'Appointments';
   // $tb= $wpdb->prefix.'events';
    $total=$this->options['booking_perday'];

    if(current_user_can('administrator')){
    $id=get_current_user_id();
     
    /* Data Get*/
    extract($_POST);
    /* End */

    $dat=date('Y-m-d',strtotime($date)); // convert in yyyy-mm-dd

    /* Check appointment more than 3 on particular date */
    $abc=$wpdb->get_var("SELECT count(start) from $table_name WHERE start='".$dat."'");
    
    if($abc>=$total){
      echo "* You can book only {$total} events on particular date!";
      exit();
    } // End
   else{

    $url=admin_url().'admin.php?page=Test-class';
    $query=$wpdb->query($wpdb->prepare(

      "INSERT into $table_name(title,start,email,phone,user_id,status) 
      VALUES (%s,%s,%s,%s,%s,%s)
      " ,$app,$dat,sanitize_email($email),$phone,$id,'Approved'
  
    ));
      
    $lastid=$wpdb->insert_id;

    $URL=$url."&new=list_appointments.php&app_id=".$lastid."&userid=".$id;

    $qr=$wpdb->update($table_name,array('url'=>$URL),
                        array('app_id'=>$lastid),
                        array('%s'),
                        array('%d')
                      );

    if($query==true && $qr==true){
          echo "* New appointment inserted!";
    }
    else{
          echo "* Something going wrong with database query!";
      }
    die();
    }  
  } 
}

  public function front_ajax(){
    global $wpdb;

    $table_name = $wpdb->prefix . 'Appointments';
  //  $tb= $wpdb->prefix.'events';
    $total=$this->options['booking_perday'];
   // $user=get_userdata(1); // Admin details  
 
    if (is_user_logged_in())
    {
       $userid=get_current_user_id();  // User id details

      //require_once dirname(__FILE__).'/inc/templates/appointment_add(client).php';
      extract($_POST);  /* Data Get*/
     
      $dat=date('Y-m-d',strtotime($date)); // convert in yyyy-mm-dd
      
      $abc=$wpdb->get_var("SELECT count(start) from $table_name WHERE start='".$dat."' and user_id='$userid'");

      if($abc>=$total){
        echo "* You can book only {$total} events on particular date!";
        exit();
      } // End
     else{
      $url=admin_url().'admin.php?page=Test-class';

      $query=$wpdb->query($wpdb->prepare(
        "INSERT into $table_name(title,start,email,phone,user_id,status)
         VALUES (%s,%s,%s,'%s',%s,%s)
        ", $app,$dat,$email,$phone,$userid,'Pending'
      ));
        
      $lastid=$wpdb->insert_id;

      $URL=$url."&new=list_appointments.php&app_id=".$lastid."&userid=".$userid;

      $qr=$wpdb->update($table_name,array('url'=>$URL),
                          array('app_id'=>$lastid),
                          array('%s'),
                          array('%d')
                        );

      if($query==true && $qr==true){
            require_once dirname(__FILE__).'/inc/templates/appointment_add(client).php';
            echo "* Appointment booked!";
      }
      else{
            echo " Something going wrong with database query!";
       }
      die();
     }
  }
}

}
$wpuf = new WPUF_Main();