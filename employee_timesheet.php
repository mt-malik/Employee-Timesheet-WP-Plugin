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
 add_shortcode("employee_profile","et_shortcode");
 add_shortcode("employee_timesheet","et_timesheet");
 ////////////
//  add_shortcode("hunger_checkout","et_checkout");
//  add_shortcode("hunger_orders","et_my_orders");
//  add_action("admin_enqueue_scripts","et_enqueScript");
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
    $hunger = $wpdb->prefix."hunger";
    $orders = $wpdb->prefix."orders";
   //  $wpdb->query("CREATE TABLE `$hunger` ( `id` INT NOT NULL AUTO_INCREMENT , `title` VARCHAR(100) NOT NULL , `description` VARCHAR(100) NOT NULL , `price` INT NOT NULL , `type` VARCHAR(100) NOT NULL , `image` VARCHAR(100) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;");
   //  $wpdb->query("ALTER TABLE `$hunger` ADD `meal_type` VARCHAR(100) NOT NULL AFTER `type`;");
   //  $wpdb->query("CREATE TABLE `$orders` ( `id` INT NOT NULL AUTO_INCREMENT , `email` VARCHAR(100) NOT NULL , `delivery_address` VARCHAR(100) NOT NULL , `second_delivery_address` VARCHAR(100) NULL DEFAULT NULL , `billing_address` VARCHAR(100) NOT NULL , `order_data` TEXT NOT NULL , `price` VARCHAR(10) NOT NULL , `ctmid` VARCHAR(256) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;");
   //  $wpdb->query("ALTER TABLE `$orders` ADD `charge` TEXT NOT NULL AFTER `ctmid`;");
   //  $wpdb->query("ALTER TABLE `$orders` ADD `user_data` TEXT NOT NULL AFTER `id`;");
   //  $wpdb->query("ALTER TABLE `$orders` ADD `user_id` INT NOT NULL AFTER `id`;");
    
    
  }
 function et_adminmenu(){
    add_menu_page('Employee Timesheet','Employee Timesheet','administrator','et_settings','et_settings');
    add_submenu_page("et_settings","Employees","Employees","administrator","et_employees","et_employees");
    add_submenu_page("et_settings","TimeSheets","TimeSheets","administrator","et_timesheets","et_timesheets");
 }
//  function et_shortcode(){
//     ob_start();
//     include_once('shortcode.php');
//     return  ob_get_clean();
//  }
 function et_shortcode(){
    ob_start();
    include_once('employee_profile_page.php');
    return  ob_get_clean();
 }
 function et_timesheet(){
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
//////////////////
 function et_checkout(){
    ob_start();
    include_once('checkout.php');
    return  ob_get_clean();
 }
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