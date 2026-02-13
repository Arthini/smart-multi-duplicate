<?php
/**
 * Plugin Name: Smart Multi Duplicate
 * Description: Duplicate posts, pages, and CPTs multiple times with smart naming and safety limits.
 * Version: 1.0.0
 * Author: Arthu
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'SMD_PATH', plugin_dir_path( __FILE__ ) );

require_once SMD_PATH . 'includes/class-settings.php';
require_once SMD_PATH . 'includes/class-admin-actions.php';
require_once SMD_PATH . 'includes/class-duplicate-handler.php';

new SMD_Settings();
new SMD_Admin_Actions();
new SMD_Duplicate_Handler();
