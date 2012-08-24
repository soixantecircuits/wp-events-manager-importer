<?php
/*
Plugin Name: Events Manager Importer
Plugin URI: http://asso-ela.com/
Description: Import your .xlsx into Events Manager like you want.
Version: 1.0
Author: Soixante Circuits
Author URI: http://soixantecircuits.fr/
License: GPL
*/

function plugin_active($plugin){
	return in_array( $plugin, apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) );
}

if (is_admin()){
	require_once("inc/admin/classes/emi.class.php");
	require_once("inc/admin/classes/emi_post.class.php");
	require_once("inc/admin/classes/emi_event.class.php");
	require_once("inc/admin/classes/emi_location.class.php");
	require_once("inc/admin/classes/emi_setup.class.php");
	require_once("inc/admin/classes/emi_save_manager.class.php");
	require_once("inc/admin/classes/emi_manager.class.php");
	require_once("inc/admin/emi_controller.class.php");
}

function emiStart() {
	if (is_admin()&&plugin_active('events-manager/events-manager.php')){
		$EmiController = new EmiController();
	}
	else if(!plugin_active('events-manager/events-manager.php')){
		require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		deactivate_plugins('wp-events-manager-importer/emi.php');
	}
}

function emiInstall(){
	ob_start();
		$Setup=new EMI_Setup();
	ob_clean();
}

function emi_admin_notice(){
	ob_start();
		$Emi = new EMI();
		$notice = $Emi->get_notice();
	ob_clean();
	if (!empty($notice)){
		echo '<div class="error"><p>'.$Emi->get_notice().'</p></div>';
	}
}

function emi_load_admin_scripts() {
	$pluginAdminDir = WP_PLUGIN_URL.'/'.basename(dirname(__FILE__)).'/inc/admin/resources';
	wp_enqueue_style('emi_style', $pluginAdminDir.'/css/style.css');
	wp_enqueue_style('emi_lightness', $pluginAdminDir.'/css/lightness.css');
	wp_enqueue_script('emi_droparea', $pluginAdminDir.'/javascript/dropfile/dropfile.js');
	wp_enqueue_script('emi_data_tables', $pluginAdminDir . '/javascript/jquery.dataTables.js', null, '1.9.3', true);
	wp_enqueue_script('emi_preview_script', $pluginAdminDir . '/javascript/preview_script.js', null, '1.0', true);
	wp_enqueue_script('emi_upload_script', $pluginAdminDir . '/javascript/upload_script.js', null, '1.0', true);
}

function emi_language_call() {
	load_plugin_textdomain( 'emi', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}


add_action('init', 'emiStart',100);
add_action('plugins_loaded', 'emi_language_call');
register_activation_hook( __FILE__, "emiInstall");
add_action('admin_notices', 'emi_admin_notice');
?>

