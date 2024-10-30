<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://bizbaby.com
 * @since      1.0.0
 *
 * @package    Bizbaby
 * @subpackage Bizbaby/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Bizbaby
 * @subpackage Bizbaby/includes
 * @author     Andrey Gurkovskii <polopolaw@gmail.com>
 */
class Bizbaby
{

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Bizbaby_Loader $loader Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string $plugin_name The string used to uniquely identify this plugin.
     */
    protected $plugin_name;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string $version The current version of the plugin.
     */
    protected $version;

    /**
     * @since    1.0.0
     * @access   protected
     * @var Bizbaby_TariffPlan $tariff Maintain licence rules
     */
    protected $tariff;

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function __construct()
    {
        if (defined('BIZBABY_PLUGIN_VERSION')) {
            $this->version = BIZBABY_PLUGIN_VERSION;
        } else {
            $this->version = '1.0.0';
        }
        $this->plugin_name = 'bizbaby';

        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();

    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - Bizbaby_Loader. Orchestrates the hooks of the plugin.
     * - Bizbaby_i18n. Defines internationalization functionality.
     * - Bizbaby_Admin. Defines all hooks for the admin area.
     * - Bizbaby_Public. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function load_dependencies()
    {

        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-bizbaby-loader.php';

        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-bizbaby-i18n.php';

        /**
         * Exposes a wrapper around all the options that we register within the plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/Bizbaby_OptionsHelper.php';

        /**
         * Tool for render notices in admin panel
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/BizbabyAdminNotice.php';

        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-bizbaby-admin.php';

        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-bizbaby-public.php';

        /**
         * The class for operate with tariff plan. Resolving licence abilities for shortcodes
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/BizbabyTariffPlan.php';


        $this->loader = new Bizbaby_Loader();
    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the Bizbaby_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function set_locale()
    {

        $plugin_i18n = new Bizbaby_i18n();

        $this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');

    }

    /**
     * Register all the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_admin_hooks()
    {
        $plugin_admin = new Bizbaby_Admin(
            $this->get_plugin_name(),
            $this->get_version(),
            $this->get_slug(),
        );

        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');
        // menu
		$this->loader->add_action('admin_menu', $plugin_admin, 'add_admin_page');

		// handlers
        $this->loader->add_action('admin_post_sync_company_data', $plugin_admin, 'sync_company_data');
        $this->loader->add_action('admin_post_logout', $plugin_admin, 'bizbaby_logout');

        add_action('admin_notices', array(new Bizbaby_AdminNotice(), 'displayAdminNotice'));
    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_public_hooks()
    {
        $plugin_public = new Bizbaby_Public($this->get_plugin_name(), $this->get_version());

        add_shortcode('bizbaby_shortcode', array($plugin_public, 'add_shortcode'));
        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');

    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function run()
    {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @return    string    The name of the plugin.
     * @since     1.0.0
     */
    public function get_plugin_name()
    {
        return $this->plugin_name;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @return    Bizbaby_Loader    Orchestrates the hooks of the plugin.
     * @since     1.0.0
     */
    public function get_loader()
    {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @return    string    The version number of the plugin.
     * @since     1.0.0
     */
    public function get_version()
    {
        return $this->version;
    }

    /**
     * Get the title of the admin page in the WordPress admin menu.
     *
     * @return string
     */

    /**
     * Get the slug used by the admin page.
     *
     * @return string
     */
    public function get_slug()
    {
        return 'bizbaby';
    }

}
