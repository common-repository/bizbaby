<?php


/**
 * Exposes a wrapper around all the options that we register within the plugin.
 *
 * @since      1.0.0
 * @package    Bizbaby
 * @author     Andrey Gurkovskii <polopolaw@gmail.com>
 */
class Bizbaby_OptionsHelper
{
    /**
     * @return mixed
     * @since      1.0.0
     */
    public static function get_integration_key()
    {
        return get_option(BIZBABY_INTEGRATION_KEY, null);
    }

    /**
     * @param string $value
     * @return bool
     * @since      1.0.0
     */
    public static function set_integration_key($value)
    {
        return update_option(BIZBABY_INTEGRATION_KEY, $value);
    }

    /**
     * @param string $value
     * @return bool
     */
    public static function set_organization_name($value)
    {
        return update_option(BIZBABY_ORGANIZATION_NAME, $value);
    }

    /**
     * @param string $value
     * @return bool
     */
    public static function set_organization_id($value)
    {
        return update_option(BIZBABY_ORGANIZATION_ID, $value);
    }

    /**
     * @param string $value
     * @return bool
     */
    public static function set_integration_token($value)
    {
        return update_option(BIZBABY_INTEGRATION_TOKEN, $value);
    }

    /**
     * Get organization name
     * @return string|null
     */
    public static function get_organization_name()
    {
        return get_option(BIZBABY_ORGANIZATION_NAME);
    }

    /**
     * @since 1.0.0
     * @return mixed
     */
    public static function bizbaby_get_organization_plan()
    {
        return get_option(BIZBABY_ORGANIZATION_PLAN);
    }

    /**
     * @since 1.0.0
     * @return mixed
     */
    public static function bizbaby_get_organization_monthly_membership()
    {
        return get_option(BIZBABY_ORGANIZATION_MONTHLY_MEMBERSHIP);
    }

    /**
     * Get organisation id
     *
     * @since 1.0.0
     * @return string|null
     */
    public static function get_organization_id()
    {
        return get_option(BIZBABY_ORGANIZATION_ID);
    }

    /**
     * Get auth token for requests to bizbaby.com
     *
     * @since 1.0.0
     * @return string|null
     */
    public static function get_integration_token()
    {
        return get_option(BIZBABY_INTEGRATION_TOKEN);
    }

    /**
     * @since 1.0.0
     * @return mixed
     */
    public static function bizbaby_get_phone()
    {
        return get_option(BIZBABY_ORGANIZATION_PHONE);
    }

    /**
     * @since 1.0.0
     * @return mixed
     */
    public static function bizbaby_get_email()
    {
        return get_option(BIZBABY_ORGANIZATION_EMAIL);
    }

    /**
     * @since 1.0.0
     * @return mixed
     */
    public static function bizbaby_get_address()
    {
        return get_option(BIZBABY_ORGANIZATION_ADDRESS);
    }

    /**
     * @since 1.0.0
     * @return mixed
     */
    public static function bizbaby_get_subdomain()
    {
        return get_option(BIZBABY_ORGANIZATION_SUBDOMAIN);
    }

    /**
     * @since 1.0.0
     * @param $data array
     * @return void
     */
    public static function update_company_data($data)
    {
        self::set_integration_key(isset($data['integration_key']) ? sanitize_text_field($data['integration_key']) : "");
        update_option(BIZBABY_ORGANIZATION_EMAIL, isset($data['email']) ? sanitize_text_field($data['email']) : "");
        update_option(BIZBABY_ORGANIZATION_NAME, isset($data['name']) ? sanitize_text_field($data['name']) : "");
        update_option(BIZBABY_ORGANIZATION_PHONE, isset($data['phone']) ? sanitize_text_field($data['phone']) : "");
        update_option(BIZBABY_ORGANIZATION_ADDRESS, isset($data['address']) ? sanitize_text_field($data['address']) : "");
        update_option(BIZBABY_ORGANIZATION_SUBDOMAIN, isset($data['subdomain']) ? sanitize_text_field($data['subdomain']) : "");
    }

}
