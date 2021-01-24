<?php
/**
 * Plugin Name: Employee Timesheet
 * Description: Employee Timesheet
 * Plugin URI:  
 * Version:     1.0.0
 * Author:      M Tauseef
 * Author URI:  
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
 add_action('init','et_init');
 add_action('admin_menu','et_adminmenu');
 add_shortcode("employee_profile","et_profile_shortcode");
 add_shortcode("employee_timesheet","et_timesheet_shortcode");
 add_action("admin_enqueue_scripts","et_enqueScript");
  register_activation_hook( __FILE__, "wc_reg_plugin" );
  register_activation_hook( __FILE__, 'my_plugin_activate' );
//   add_action( 'init', 'create_post_type' );
  add_action('init', 'create_timesheet_post_type');
 
 function et_init(){
    @session_start();
 }
 function my_plugin_activate() {
   add_role( 'custom_role', 'employee', get_role( 'subscriber' )->capabilities );
}
  function wc_reg_plugin(){
    global $wpdb;
    $employee = $wpdb->prefix."employee";
    $wpdb->query("CREATE TABLE `$employee` ( `id` INT NOT NULL AUTO_INCREMENT , `job_title` VARCHAR(100) NOT NULL, `address` VARCHAR(100) NOT NULL , `image` VARCHAR(100) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;");
    $wpdb->query("ALTER TABLE `$employee` ADD `user_data` TEXT NOT NULL AFTER `id`;");
    $wpdb->query("ALTER TABLE `$employee` ADD `user_id` INT NOT NULL AFTER `id`;");
    $wpdb->query("ALTER TABLE `$employee` CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT, CHANGE `job_title` `job_title` VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL, CHANGE `address` `address` VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL, CHANGE `image` `image` VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL;");
    $timesheet = $wpdb->prefix."timesheets";
    $wpdb->query("CREATE TABLE `$timesheet` ( `id` INT NOT NULL AUTO_INCREMENT , `employee_id` INT NOT NULL , `date` DATE NOT NULL , `day` VARCHAR(100) NOT NULL , `status` VARCHAR(255) NULL DEFAULT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;");
     $wpdb->query("ALTER TABLE `$timesheet` ADD `worked_hours` VARCHAR(100) NOT NULL AFTER `day`;");
   //  $wpdb->query("CREATE TABLE `$timesheet` ( `id` INT NOT NULL AUTO_INCREMENT , `employee_id` INT NOT NULL , `date` DATE NOT NULL , `mon` VARCHAR(100) NULL DEFAULT NULL , `tue` VARCHAR(100) NULL DEFAULT NULL , `wed` VARCHAR(100) NULL DEFAULT NULL , `thu` VARCHAR(100) NULL DEFAULT NULL , `fri` VARCHAR(100) NULL DEFAULT NULL , `sat` VARCHAR(100) NULL DEFAULT NULL , `status` VARCHAR(255) NULL DEFAULT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;");
   //  $wpdb->query("ALTER TABLE `$timesheet` ADD `charge` TEXT NOT NULL AFTER `ctmid`;");
   //  $wpdb->query("ALTER TABLE `$timesheet` ADD `user_data` TEXT NOT NULL AFTER `id`;");
   //  $wpdb->query("ALTER TABLE `$timesheet` ADD `user_id` INT NOT NULL AFTER `id`;");
    
    
  }
 function et_adminmenu(){
    // add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
    add_menu_page('Employee Timesheet','Employee Timesheet','administrator','et_settings','et_settings','dashicons-welcome-widgets-menus');
    add_submenu_page("et_settings","Employees","Employees","administrator","et_employees","et_employees");
    add_submenu_page("et_settings","TimeSheets","TimeSheets","administrator","et_timesheets","et_timesheets");

    add_menu_page('Time Sheets','Time Sheets','administrator','et_timesheet','et_timesheet','dashicons-media-spreadsheet');
    add_submenu_page("et_timesheet","Add Sheet","Add Sheet","administrator","et_add_sheet","et_add_sheet");
    add_submenu_page("et_timesheet","Pending Sheets","Pending Sheets","administrator","et_sheet_pending","et_sheet_pending");
    add_submenu_page("et_timesheet","Rejected Sheets","Rejected Sheets","administrator","et_sheet_rejected","et_sheet_rejected");
 }
 function set_default_meta($post_ID){
   if ( $_GET['post_type'] == 'timesheet' ) {
      // $current_field_value = get_post_meta($post_ID,'Monday',true);
      $default_meta = ''; // value
      // if ($current_field_value == '' && !wp_is_post_revision($post_ID)){
      //       add_post_meta($post_ID,'Monday',$default_meta,true);
      // }
      add_post_meta($post_ID,'Monday',$default_meta,true);
      add_post_meta($post_ID,'Tuesday',$default_meta,true);
      add_post_meta($post_ID,'Wednesday',$default_meta,true);
      add_post_meta($post_ID,'Thursday',$default_meta,true);
      add_post_meta($post_ID,'Friday',$default_meta,true);
      add_post_meta($post_ID,'Saturday',$default_meta,true);
      add_post_meta($post_ID,'Sunday',$default_meta,true);
      $args =array(
               'key' => '_color',
               'value' => 'white',
               'compare' => '!='
            );

      $fields = array(
				'_1' => 'a',
				'_2' => 'b',
				'_3' => 'c',
				'_4' => 'd',
				'_5' => 'e'
         );
      add_post_meta($post_ID,'Emp',$fields,true);
      // //Add these to show in post
      // $meta = get_post_meta(get_the_ID(), '', true);
      // print_r($meta);
   }
   return $post_ID;
}
add_action('wp_insert_post','set_default_meta');


function custom_element_grid_class_meta_box($post){
   $meta_element_class = get_post_meta($post->ID, 'custom_element_grid_class_meta_box', true); //true ensures you get just one value instead of an array
   ?>
<label>Choose the size of the element : </label>

<select name="custom_element_grid_class" id="custom_element_grid_class">
   <option value="normal" <?php selected( $meta_element_class, 'normal' ); ?>>normal</option>
   <option value="square" <?php selected( $meta_element_class, 'square' ); ?>>square</option>
   <option value="wide" <?php selected( $meta_element_class, 'wide' ); ?>>wide</option>
   <option value="tall" <?php selected( $meta_element_class, 'tall' ); ?>>tall</option>
</select>
<?php
}

//Show meta fields in the content of post
function theme_slug_filter_the_content( $content ) {
   // $custom_content = 'YOUR CONTENT GOES HERE';
   // $custom_content .= $content;
   // return $custom_content;
   // $meta = get_post_meta(get_the_ID(), '', true);
   // print_r($meta);
   $post_metas = get_post_meta(get_the_ID());
   $post_metas = array_combine(array_keys($post_metas), array_column($post_metas, '0'));
   echo "<pre>";
   print_r($post_metas);
   echo "</pre>";
}
add_filter( 'the_content', 'theme_slug_filter_the_content' );

function create_timesheet_post_type() {
   $labels = array(
      'name'=> __('TimeSheets'),
      'singular_name'  => __('Timesheet'),
      );
      $args = array(
      'labels'         => $labels,
      'public'         => true,
      'has_archive'    => true,
      'menu_position'  => 5,
      'description'    => 'Employee Worked per day.',
      'rewrite'        =>
      array('slug' => 'timesheets'),
      'supports'       =>
      array( 'title',
      'comments', 'editor', 'custom-fields', 'timesheets'),
      );
       
      register_post_type('Timesheet', $args);
}

//Main Plugin Menu
 function et_profile_shortcode(){
    ob_start();
    include_once('employee_profile_page.php');
    return  ob_get_clean();
 }
 function et_timesheet_shortcode(){
    ob_start();
    include_once('timesheet_page.php');
    return  ob_get_clean();
 }
 function et_settings(){
   include_once("settings.php");
 }
 function et_employees(){
   include_once("employees.php");
}
function et_timesheets(){
   include_once("timesheets.php");
}
//CPT Menu
function et_timesheet(){
   include_once("timesheets.php");
}
function et_add_sheet(){
   include_once("add_sheet.php");
}
function et_sheet_pending(){
   include_once("timesheets.php");
}
function et_sheet_rejected(){
   include_once("timesheets.php");
}
//////////////////
 function et_ajax_page(){
    include_once("ajax.php");
    die();
 }
 function et_my_orders(){
    ob_start();
    include_once('my_orders.php');
    return  ob_get_clean();
 }
 function et_enqueScript(){
    wp_enqueue_media();
 }