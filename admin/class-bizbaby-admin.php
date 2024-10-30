<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://bizbaby.com
 * @since      1.0.0
 *
 * @package    Bizbaby
 * @subpackage Bizbaby/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * @package    Bizbaby
 * @subpackage Bizbaby/admin
 * @author     Andrey Gurkovskii <polopolaw@gmail.com>
 */
class Bizbaby_Admin
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
    private $slug;


    /**
     * Initialize the class and set its properties.
     *
     * @param string $plugin_name The name of this plugin.
     * @param string $version The version of this plugin.
     *
     * @since    1.0.0
     */
    public function __construct(
        string $plugin_name,
        string $version,
        string $slug,
    )
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
        $this->slug = $slug;
    }

    /**
     * Renders the given template if it's readable.
     *
     * @param string $template
     * @param array $params
     * @since    1.0.0
     */
    private function render_template($template, $params = [])
    {

        $template_path = BIZBABY_PLUGIN_DIR . 'admin/partials/' . $template . '.php';

        if (!is_readable($template_path)) {
            return;
        }
        include $template_path;
    }

    /**
     * Add admin page to WP menu
     *
     * @return void
     * @since    1.0.0
     */
    public function add_admin_page()
    {

        $hasConnectedAccount = Bizbaby_OptionsHelper::get_integration_token();

        $main_action = $hasConnectedAccount
            ? array($this, 'bizbaby_invoke_sync_page')
            : array($this, 'show_setup');

        // Create the root menu item.
        $bizbabyIcon = wp_remote_get(BIZBABY_PLUGIN_URL . 'admin/img/icon.svg');
        $icon = isset($bizbabyIcon['body']) ? (string)$bizbabyIcon['body'] : '';
        add_menu_page(
            'Bizbaby',
            esc_html__('Bizbaby', 'bizbaby'),
            'manage_options',
            $this->slug,
            $main_action,
            'data:image/svg+xml;base64,' . base64_encode($icon),
            "15.37649"
        );

        $sub_actions[] = array(
            'parent_slug' => 'options.php',
            'title'       => "",
            'text'        => "",
            'slug'        => 'bizbaby_process_redirect',
            'callback'    => array($this, 'process_redirect_from_bizbaby'),
        );
        if (Bizbaby_OptionsHelper::get_integration_token()) {
            $sub_actions[] = array(
                'title'    => "Integration",
                'text'     => "Integration",
                'slug'     => 'integration',
                'callback' => array($this, 'show_integration_page'),
            );
        }

        $sub_actions[] = array(
            'title'    => "Theme",
            'text'     => "Theme",
            'slug'     => "theme",
            'callback' => array($this, 'bizbaby_get_theme'),
        );

        $sub_actions[] = array(
            'title'    => "Debug",
            'text'     => "Debug",
            'slug'     => "Debug",
            'callback' => array($this, 'debug'),
        );

        foreach ($sub_actions as $sub_action) {
            add_submenu_page(
                $sub_action['parent_slug'] ?? $this->slug,
                'BizBaby - ' . $sub_action['title'],
                $sub_action['text'],
                'manage_options',
                $sub_action['slug'],
                $sub_action['callback']
            );
        }
    }

    /**
     * Redirect user to theme live preview or installation
     *
     * @since 1.0.0
     *
     * @return void
     */
    function bizbaby_get_theme() {
        wp_redirect($this->bizbaby_theme_url());
        exit();
    }

    public function debug()
    {
        $this->render_template("bizbaby-logout");

        echo sprintf(
            // translators: Placeholder is a key from config
                esc_html__('key: %s', 'bizbaby'),
            esc_html(Bizbaby_OptionsHelper::get_integration_key())
            );
        echo sprintf(
            // translators: Placeholder is a token from config
                esc_html__('token: %s', 'bizbaby'),
            esc_html(Bizbaby_OptionsHelper::get_integration_token())
            );
    }

    /**
     * @since 1.0.0
     * @return string
     */
    public function bizbaby_check_theme_installation()
    {
        $installed_themes = wp_get_themes();
        $theme = wp_get_theme();
        if (isset($installed_themes[BIZBABY_THEME_SLUG])) {
            if (BIZBABY_THEME_NAME == $theme->name) {
                return 'activated';
            }
            return 'installed';
        }
        return 'not installed';
    }

    /**
     * Get link for activate or install bizbaby theme
     *
     * @since 1.0.0
     *
     * @param $status
     * @return string
     */
    public function bizbaby_theme_url($status = null)
    {
        if ($status === null) {
            $status = $this->bizbaby_check_theme_installation();
        }
        if ($status === 'activated' || $status === 'installed') {
            return '/wp-admin/themes.php?theme=bizbaby';
        }
        return '/wp-admin/theme-install.php?theme=ollie';
    }

    /**
     * Show page with available shortcodes
     *
     * @since    1.0.0
     */
    public function show_integration_page()
    {
        $this->bizbaby_notify_theme_instalation();
        $tariff = new Bizbaby_TariffPlan();
        $this->render_template('bizbaby-integration', ['tariff' => $tariff]);
    }

    /**
     * Save token from redirect query params from bizbaby
     *
     * @since    1.0.0
     */
    public function process_redirect_from_bizbaby()
    {
        if (
            (! isset( $_GET['_wpnonce'] ) || ! wp_verify_nonce( sanitize_text_field(wp_unslash($_GET['_wpnonce'])), 'bizbaby_nonce_field' )) // nonce verification
            || (!(isset($_GET['token']) && isset($_GET['organisation_id']) && isset($_GET['organisation_name'])))
        ) {
            $errMsg = sprintf(
                // translators: Placeholder is a link to website from config
                esc_html__('Synchronization error, please try again or contact <a href=%s>support</a>.', 'bizbaby'),
                esc_url(BIZBABY_THEME_URL_HELP)
            );
            Bizbaby_AdminNotice::displayError(
                $errMsg,
            );
            wp_safe_redirect(BIZBABY_REDIRECT);
            $this->render_template('bizbaby-admin-display');
            return;
        }

        Bizbaby_OptionsHelper::set_integration_token(sanitize_text_field($_GET['token']));
        Bizbaby_OptionsHelper::set_organization_name(sanitize_text_field($_GET['organisation_name']));
        Bizbaby_OptionsHelper::set_organization_id(sanitize_text_field($_GET['organisation_id']));
        Bizbaby_OptionsHelper::set_integration_key(sanitize_text_field($_GET['key']));

        $this->bizbaby_invoke_sync_page();
    }

    /**
     * Send message if theme not active or not install
     *
     * @since    1.0.0
     */
    public function bizbaby_notify_theme_instalation()
    {
        $themeStatus = $this->bizbaby_check_theme_installation();
        $themeLink = $this->bizbaby_theme_url();
        if ($themeStatus === 'not installed') {
            Bizbaby_AdminNotice::displaySuccess(
                sprintf(
                    // translators: Placeholder is a link to website from config
                    esc_html__('Install the theme for better experience <a href="%s">here</a>.', 'bizbaby'),
                    esc_url($themeLink)
                )
            );
        } elseif ($themeStatus === 'installed') {
            Bizbaby_AdminNotice::displaySuccess(
                sprintf(
                    // translators: Placeholder is a link to website from config
                    esc_html__("Don't forget to activate the Bizbaby theme <a href='%s'>here</a>.", 'bizbaby'),
                    esc_url($themeLink)
                )
            );
        }
    }

    /**
     * Show page with synced data and opportunity to resync data
     *
     * @since    1.0.0
     */
    public function bizbaby_invoke_sync_page()
    {
        $this->bizbaby_notify_theme_instalation();
        $status = $this->bizbaby_check_sync_data_status();
        $tariff = new Bizbaby_TariffPlan();
        $this->render_template('bizbaby-invoke-sync', ['sync_status' => $status, 'tariff' => $tariff]);
    }

    /**
     * Show setup screen. Contain link to log in to BizBaby
     *
     * @since    1.0.0
     */
    public function show_setup()
    {
        $this->render_template('bizbaby-admin-setup');
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Bizbaby_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Bizbaby_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/bizbaby-admin.css', array(), $this->version, 'all');

    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Bizbaby_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Bizbaby_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/bizbaby-admin.js', array('jquery'), $this->version, false);
    }

    /**
     * Get organisation data from bizbaby
     *
     * @since    1.0.0
     */
    public function bizbaby_get_external_data()
    {
        $token = Bizbaby_OptionsHelper::get_integration_token();
        $url = BIZBABY_SYNC_ROUTE;

        $args = array(
            'method'  => 'GET',
            'headers' => array(
                'Authorization' => 'Bearer ' . $token,
                'Content-Type'  => 'application/json'
            ),
        );

        $response = wp_remote_post($url, $args);

        if (is_wp_error($response)) {
            $errMsg = sprintf(
                // translators: Placeholder is a error message
                esc_html__('Sync error: %s', 'bizbaby'),
                esc_html($response->get_error_message())
            );
            Bizbaby_AdminNotice::displayError($errMsg);
        } else {
            $response_code = wp_remote_retrieve_response_code($response);
            if ($response_code === 200 || $response_code === 201) {
                $response_body = json_decode(wp_remote_retrieve_body($response), true);
                return $response_body['data'];
            }
        }

        return false;
    }

    /**
     * Update local organisation data from bizbaby
     *
     * @since    1.0.0
     */
    public function sync_company_data()
    {
        if ($data = $this->bizbaby_get_external_data()) {
            Bizbaby_OptionsHelper::update_company_data($data);
            Bizbaby_AdminNotice::displaySuccess(
                esc_html__("Success sync organization data from bizbaby", 'bizbaby')
            );
        }
        check_admin_referer();
        wp_safe_redirect(sanitize_text_field($_POST['_wp_http_referer']));
    }

    /**
     * Delete sync token and snippet key
     * @return void
     * @since 1.0.0
     */
    public function bizbaby_logout()
    {
        delete_option(BIZBABY_INTEGRATION_KEY);
        delete_option(BIZBABY_INTEGRATION_TOKEN);
        Bizbaby_AdminNotice::displaySuccess(esc_html__("Success logout", "bizbaby"));
        wp_redirect(admin_url('admin.php?page=bizbaby'));
        exit();
    }

    /**
     * Check is remote data equal the local
     *
     * @since    1.0.0
     */
    public function bizbaby_check_sync_data_status()
    {
        $data = $this->bizbaby_get_external_data();

        if ($data !== false) {
            $email = isset($data['email']) ? sanitize_text_field($data['email']) : "";
            $address = isset($data['address']) ? sanitize_text_field($data['address']) : "";
            $phone = isset($data['phone']) ? sanitize_text_field($data['phone']) : "";
            $name = isset($data['name']) ? sanitize_text_field($data['name']) : "";
            $subdomain = isset($data['subdomain']) ? sanitize_text_field($data['subdomain']) : "";
            Bizbaby_OptionsHelper::set_integration_key($data['integration_key']);
            if (
                Bizbaby_OptionsHelper::bizbaby_get_email() === $email &&
                Bizbaby_OptionsHelper::bizbaby_get_subdomain() === $subdomain &&
                Bizbaby_OptionsHelper::bizbaby_get_address() === $address &&
                Bizbaby_OptionsHelper::bizbaby_get_phone() === $phone &&
                Bizbaby_OptionsHelper::get_organization_name() === $name
            ) {
                return array_merge(['status' => true], $data);
            } else {
                return array_merge(['status' => false], $data);
            }
        } else {
            Bizbaby_AdminNotice::displayError(esc_html__("Sync error", "bizbaby"));
            return false;
        }
    }

}
