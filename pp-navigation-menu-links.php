<?php

/*
Plugin Name: WordPress Navigation Menu Links
Plugin URI: http://profilepress.net
Description: Add ProfilePress login, registration, password reset, edit profile, my profile and logout links to WordPress navigation menu.
Version: 1.0.2
Author: Agbonghama Collins
Author URI: http://w3guy.com
License: GPL2
*/


namespace ProfilePress\Nav_Menu_Links;

include 'backend.php';
include 'frontend.php';


add_action( 'plugins_loaded', 'ProfilePress\Nav_Menu_Links\load_plugin' );

function load_plugin() {
	Backend::get_instance();
	Frontend::get_instance();
}