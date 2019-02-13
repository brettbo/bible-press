<?php // Bible Press - Admin Menu



// disable direct file access
if ( ! defined( 'ABSPATH' ) ) {
	
	exit;
	
}



// add sub-level administrative menu
function bible_press_add_sublevel_menu() {
	
	/*
	
	add_submenu_page(
		string   $parent_slug,
		string   $page_title,
		string   $menu_title,
		string   $capability,
		string   $menu_slug, 
		callable $function = ''
	);
	
	*/
	
	add_submenu_page(
		'options-general.php',
		'Bible Press Settings',
		'Bible Press',
		'manage_options',
		'bible_press',
		'bible_press_display_settings_page'
	);
	
}
add_action( 'admin_menu', 'bible_press_add_sublevel_menu' );
