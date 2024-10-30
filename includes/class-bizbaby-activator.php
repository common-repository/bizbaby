<?php

/**
 * Fired during plugin activation
 *
 * @link       https://bizbaby.com
 * @since      1.0.0
 *
 * @package    Bizbaby
 * @subpackage Bizbaby/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Bizbaby
 * @subpackage Bizbaby/includes
 * @author     Andrey Gurkovskii <polopolaw@gmail.com>
 */
class Bizbaby_Activator
{

    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since    1.0.0
     */
    public static function activate()
    {
        $custom_option = get_option('bizbaby_slogan_option');
        if (empty($custom_option)) {
            update_option('bizbaby_slogan_option', 'We are in Seattle Building Modern Landscapes');
        }

        $shortcodes = array(
            '[bizbaby_shortcode type="login"]'         => 'Login forms',
            '[bizbaby_shortcode type="contact"]'       => 'Contacts form',
            '[bizbaby_shortcode type="jobs"]'          => 'Jobs form',
            '[bizbaby_shortcode type="service-order"]' => 'Services order',
        );

        add_option('bizbaby_form_shortcodes', $shortcodes);
    }

}
