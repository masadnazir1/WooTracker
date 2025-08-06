<?php
/*
Plugin Name: FB Pixel WooTracker
Plugin URI: https://github.com/galaxydevpk/fb-pixel-wootracker
Description: Lightweight plugin to integrate Facebook Pixel into your WooCommerce store. Allows easy Pixel ID setup from the WordPress dashboard and tracks 'Purchase' events on successful orders with logging.
Version: 1.0
Author: Muhammad Asad Nazir - GalaxyDevPK
Author URI: https://galaxydev.pk
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: fb-pixel-wootracker
*/


if (!defined('ABSPATH')) exit;

// Load plugin files
define('FBPT_PATH', plugin_dir_path(__FILE__));

require_once FBPT_PATH . 'includes/admin-settings.php';
require_once FBPT_PATH . 'includes/pixel-injector.php';
require_once FBPT_PATH . 'includes/woocommerce-events.php';


register_activation_hook(__FILE__, 'fbpt_create_event_log_table');


// Activation: Create event log table
function fbpt_create_event_log_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'fbpt_event_logs';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
        event_name VARCHAR(50) NOT NULL,
        order_id BIGINT UNSIGNED DEFAULT NULL,
        event_date DATE NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";

 

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta($sql);
    //log the message
    error_log("FBPT: Table $table_name created or updated.");
}