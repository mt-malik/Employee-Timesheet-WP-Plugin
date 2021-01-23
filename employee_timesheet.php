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
 ////////////
//  add_shortcode("hunger_checkout","et_checkout");
//  add_shortcode("hunger_orders","et_my_orders");
 add_action("admin_enqueue_scripts","et_enqueScript");
//  add_action('wp_ajax_payment_charge','et_ajax_page');
//  add_action('wp_ajax_nopriv_payment_charge','et_ajax_page');
  register_activation_hook( __FILE__, "wc_reg_plugin" );
  register_activation_hook( __FILE__, 'my_plugin_activate' );
 
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
//  function et_shortcode(){
//     ob_start();
//     include_once('shortcode.php');
//     return  ob_get_clean();
//  }
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