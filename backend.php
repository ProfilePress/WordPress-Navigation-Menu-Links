<?php

namespace ProfilePress\Nav_Menu_Links;


if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}


class PP_Nav_Items
{
    public $db_id = 0;
    public $object = 'ppnavlog';
    public $object_id;
    public $menu_item_parent = 0;
    public $type = 'custom';
    public $title;
    public $url;
    public $target = '';
    public $attr_title = '';
    public $classes = array();
    public $xfn = '';
}

class Backend
{

    private static $instance = null;

    public function __construct()
    {

        /* Add a metabox in admin menu page */
        add_action('admin_head-nav-menus.php', array($this, 'add_nav_menu_metabox'));

        /* Modify the "type_label" */
        add_filter('wp_setup_nav_menu_item', array($this, 'nav_menu_type_label'));
    }


    public function add_nav_menu_metabox()
    {
        add_meta_box('ppnavmenu', __('ProfilePress Links', 'pp_nml'), array($this, 'nav_menu_metabox'), 'nav-menus', 'side', 'default');
    }

    public function nav_menu_metabox($object)
    {
        global $nav_menu_selected_id;

        $elems = array(
            '#pp-login#' => __('Log In', 'pp_nml'),
            '#pp-logout#' => __('Log Out', 'pp_nml'),
            '#pp-signup#' => __('Sign Up', 'pp_nml'),
            '#pp-editprofile#' => __('Edit Profile', 'pp_nml'),
            '#pp-myprofile#' => __('My Profile', 'pp_nml'),
            '#pp-loginout#' => __('Login', 'pp_nml') . ' | ' . __('Log Out', 'pp_nml'),
        );


        $elems_obj = array();
        foreach ($elems as $value => $title) {
            $elems_obj[$title] = new PP_Nav_Items();
            $elems_obj[$title]->object_id = esc_html($value);
            $elems_obj[$title]->title = esc_html($title);
            $elems_obj[$title]->url = esc_html($value);
        }

        $walker = new \Walker_Nav_Menu_Checklist(array());
        ?>
        <div id="pp-links" class="pplinksdiv">

            <div id="tabs-panel-pp-links-all" class="tabs-panel tabs-panel-view-all tabs-panel-active">
                <ul id="pp-linkschecklist" class="list:pp-links categorychecklist form-no-clear">
                    <?php echo walk_nav_menu_tree(array_map('wp_setup_nav_menu_item', $elems_obj), 0,
                        (object)array('walker' => $walker)); ?>
                </ul>
            </div>

            <div class="button-controls">
			<span class="add-to-menu">
				<input type="submit"<?php disabled($nav_menu_selected_id, 0); ?> class="button-secondary submit-add-to-menu right" value="<?php esc_attr_e('Add to Menu'); ?>" name="add-pp-links-menu-item" id="submit-pp-links"/>
				<span class="spinner"></span>
			</span>

                <div id="help-login-links"><br/><br/>
                    <p><strong>Do not change the value of the "URL" field.</strong></p>
                    <p><?php printf('Love this plugin? Check out <a href="%s" target="_blank">ProfilePress</a>, a shortcode based WordPress form builder that makes building custom login, registration, password reset forms stupidly simple with lots of other perks', 'https://profilepress.net/pricing/'); ?>
                        .
                    <p>
                </div>
            </div>

        </div>
        <?php
    }

    public function nav_menu_type_label($menu_item)
    {
        $elems = array(
            '#pp-login#',
            '#pp-logout#',
            '#pp-signup#',
            '#pp-editprofile#',
            '#pp-myprofile#',
            '#pp-loginout#'
        );
        if (isset($menu_item->object, $menu_item->url) &&
            'custom' == $menu_item->object &&
            in_array($menu_item->url, $elems)
        ) {
            $menu_item->type_label = __('ProfilePress Links', 'pp_nml');
        }

        return $menu_item;
    }

    public static function get_instance()
    {
        // If the single instance hasn't been set, set it now.
        if (null == self::$instance) {
            self::$instance = new self;
        }

        return self::$instance;
    }
}