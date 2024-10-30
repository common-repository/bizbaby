<?php

/**
 * BizBaby
 *
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://bizbaby.com
 * @since             1.0.0
 * @package           BizbabyPackage
 *
 * @wordpress-plugin
 * Plugin Name:       BizBaby
 * Plugin URI:        https://bizbaby.com
 * Description:       Integrate forms from Bizbaby into your website effortlessly. You can use shortcodes, blocks, or widgets.
 * Version:           1.0.0
 * Author:            BizBaby
 * Author URI:        https://bizbaby.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       bizbaby
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}
/**
 * Plugin options
 */
define('BIZBABY_INTEGRATION_KEY', 'bizbaby_integration_key');
define('BIZBABY_INTEGRATION_TOKEN', 'bizbaby_integration_token'); // Bearer token
define('BIZBABY_NOTICE_FIELD', 'bizbaby_admin_notice_message');
define('BIZBABY_ORGANIZATION_NAME', 'bizbaby_organization_name');
define('BIZBABY_ORGANIZATION_ID', 'bizbaby_organization_id');
define('BIZBABY_ORGANIZATION_PLAN', 'bizbaby_organization_plan');
define('BIZBABY_ORGANIZATION_MONTHLY_MEMBERSHIP', 'bizbaby_organization_plan');
define('BIZBABY_ORGANIZATION_EMAIL', 'bizbaby_organization_email');
define('BIZBABY_ORGANIZATION_PHONE', 'bizbaby_organization_phone');
define('BIZBABY_ORGANIZATION_ADDRESS', 'bizbaby_organization_address');
define('BIZBABY_ORGANIZATION_SUBDOMAIN', 'bizbaby_organization_subdomain');
define('BIZBABY_LOGIN_ROUTE', 'https://bizbaby.com/login');
define('BIZBABY_SYNC_ROUTE', 'https://bizbaby.com/api/organization');
define('BIZBABY_SYNC_BUSINESS_PLANS_ROUTE', '/api/plans');
define('BIZBABY_REDIRECT', 'admin.php?page=bizbaby_process_redirect');
define('BIZBABY_MAIN_MENU', 'admin.php?page=bizbaby');
define('BIZBABY_HOST', 'https://bizbaby.com');
define('BIZBABY_THEME_SLUG', 'bizbaby');
define('BIZBABY_THEME_NAME', 'BizBaby');
define('BIZBABY_THEME_URL', 'https://bizbaby.com');
define('BIZBABY_THEME_URL_HELP', 'https://bizbaby.com');

define('BIZBABY_ORGANIZATION_INFO_FILTER', 'bizbaby_organization_info_filter');



/**
 * Currently plugin version.
 */
define( 'BIZBABY_PLUGIN_VERSION', '1.0.0' );

define('BIZBABY_PLUGIN_DIR', plugin_dir_path( __FILE__ ));
define('BIZBABY_PLUGIN_URL', plugin_dir_url(__FILE__) . '/');
define('BIZBABY_PLUGIN_FILE', __FILE__);

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-bizbaby-activator.php
 */
function bizbaby_activate() {
    require_once BIZBABY_PLUGIN_DIR . 'includes/class-bizbaby-activator.php';
    Bizbaby_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-bizbaby-deactivator.php
 */
function bizbaby_deactivate() {
    require_once BIZBABY_PLUGIN_DIR . 'includes/class-bizbaby-deactivator.php';
    Bizbaby_Deactivator::deactivate();
}

register_activation_hook( BIZBABY_PLUGIN_FILE, 'bizbaby_activate' );
register_deactivation_hook( BIZBABY_PLUGIN_FILE, 'bizbaby_deactivate' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require BIZBABY_PLUGIN_DIR . 'includes/class-bizbaby.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function bizbaby_run() {

    $plugin = new Bizbaby();
    $plugin->run();

}

bizbaby_run();
