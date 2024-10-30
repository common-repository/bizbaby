<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://bizbaby.com
 * @since      1.0.0
 *
 * @package    Bizbaby
 * @subpackage Bizbaby/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Bizbaby
 * @subpackage Bizbaby/public
 * @author     Andrey Gurkovskii <polopolaw@gmail.com>
 */
class Bizbaby_Public
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @param string $plugin_name The name of the plugin.
     * @param string $version The version of this plugin.
     * @since    1.0.0
     */
    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/bizbaby-public.css', array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/bizbaby-public.js', array('jquery'), $this->version, false);
    }

    /**
     * @param $attrs
     * @param $content
     * @return bool|string
     */
    function add_shortcode($attrs, $content = null)
    {
        $tariff = new Bizbaby_TariffPlan();

        // Parse shortcode attributes
        $attrs = shortcode_atts(
            array(
                'type' => 'service-order',
            ),
            $attrs
        );

        if (!$tariff->can($attrs['type'])) {
            return "";
        }
        $template = 'bizbaby-' . $attrs['type'] . '-shortcode.php';

        // Include the template file
        ob_start();
        include(BIZBABY_PLUGIN_DIR . "public/partials/$template");
        return ob_get_clean();
    }

}
