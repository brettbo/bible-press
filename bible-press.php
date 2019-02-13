<?php
/*
Plugin Name:  Bible Press
Description:  Displays a complete transtation of the Bible from any language provided you have the Paratext database.
Plugin URI:   https://profiles.wordpress.org/
Author:       Brett Boesch
Version:      1.0
Text Domain:  bible-press
Domain Path:  /languages
License:      GPL v2 or later
License URI:  https://www.gnu.org/licenses/gpl-2.0.txt
*/



// disable direct file access
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


// load text domain
function bible_press_load_textdomain() {
	
	load_plugin_textdomain( 'bible-press', false, plugin_dir_path( __FILE__ ) . 'languages/' );
	
}
add_action( 'plugins_loaded', 'bible_press_load_textdomain' );



register_activation_hook( __FILE__, 'bible_press_install' );
// register_activation_hook( __FILE__, 'bible_press_install_data' );
register_deactivation_hook( __FILE__, 'bible_press_uninstall_data' );


// new admin panel
define( 'BIBLE_PRESS_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

function bible_press_forms_init() {
	if ( is_admin() ) {
		require_once BIBLE_PRESS_PLUGIN_PATH . 'admin/settings-page.php';
		require_once BIBLE_PRESS_PLUGIN_PATH . 'admin/database.php';
		new Bible_Press_Forms_Options();
	}
		
	require_once BIBLE_PRESS_PLUGIN_PATH  . 'includes/core-functions.php';

}
add_action('plugins_loaded', 'bible_press_forms_init');



// Register style sheet.

function register_plugin_styles() {		
	
	wp_enqueue_style ( 'bible_press', plugins_url( "public/css/bible-press.css", __FILE__ ), array(), null, 'screen' );
	wp_enqueue_script( 'bible_press', plugins_url( "public/js/bible-press.js", __FILE__ ), array(), null, true );

}
add_action( 'wp_enqueue_scripts', 'register_plugin_styles' );


function bible_press_install() {

    if ( ! current_user_can( 'activate_plugins' ) )
        return;
    $plugin = isset( $_REQUEST['plugin'] ) ? $_REQUEST['plugin'] : '';
    check_admin_referer( "activate-plugin_{$plugin}" );
}

/*

// if admin area
if ( is_admin() ) {

	// include plugin dependencies
	require_once plugin_dir_path( __FILE__ ) . 'admin/admin-menu.php';
	require_once plugin_dir_path( __FILE__ ) . 'admin/settings-page.php';
	require_once plugin_dir_path( __FILE__ ) . 'admin/settings-register.php';
    require_once plugin_dir_path( __FILE__ ) . 'admin/settings-callbacks.php';
    require_once plugin_dir_path( __FILE__ ) . 'admin/settings-validate.php';

	
}

require_once plugin_dir_path( __FILE__ ) . 'includes/core-functions.php';
*/


// default plugin options
function bible_press_options_default() {

	return array(
		'page_title'     => esc_html__( 'Powered by WordPress', 'bible-press' ),
		'old_testament_title' => esc_html__( 'Old Testament', 'bible-press' ),
		'new_testament_title' => esc_html__( 'New Testament', 'bible-press' ),
		'import_filename'   =>  esc_html__('test.sql', 'bible-press' ),
		'custom_style' => 'enable',
	);

}


/*
function bible_press_import_default() {
	return array(
		'import_filename'   => 'test.sql',
	);
}
*/


