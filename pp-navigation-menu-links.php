<?php

/*
Plugin Name: WordPress Navigation Menu Links
Plugin URI: https://profilepress.net
Description: Add ProfilePress login, registration, password reset, edit profile, my profile and logout links to WordPress navigation menu.
Version: 1.0.3
Author: Agbonghama Collins
Author URI: http://w3guy.com
License: GPL2
Text Domain: pp_nml
Domain Path: /languages/
*/


namespace ProfilePress\Nav_Menu_Links;

include 'backend.php';
include 'frontend.php';

add_action('plugins_loaded', 'pp_nml_plugin_load_textdomain');
function pp_nml_plugin_load_textdomain()
{
    load_plugin_textdomain('pp_nml', false, dirname(plugin_basename(__FILE__)) . '/languages');
}

add_action('plugins_loaded', 'ProfilePress\Nav_Menu_Links\load_plugin');

function load_plugin()
{
    Backend::get_instance();
    Frontend::get_instance();
}