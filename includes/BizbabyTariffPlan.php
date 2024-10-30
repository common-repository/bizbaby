<?php

class Bizbaby_TariffPlan
{
    private $plan;
    public $allPlans;

    const RULES = [
        'login'       => 'integrate_client_login',
        'contact'     => 'integrate_contact_form',
        'jobs'        => 'integrate_order_and_job_forms',
        'appointment' => 'integrate_order_and_job_forms'
    ];

    const TIMOUT = 10; // 1 day in sec 86400

    public function __construct()
    {
        $this->plan = $this->getPlan();
        $this->allPlans = get_option('bizbaby_plans');
    }

    public function getPrice()
    {
        return $this->plan['price'];
    }

    public function getName()
    {
        return $this->plan['name'];
    }

    /**
     * Check if tariff allow use this snippet
     * @param $snippet
     * @return bool
     */
    public function can($snippet)
    {
        if (!isset(self::RULES[$snippet])) {
            return false;
        }
        if (!$this->plan) {
            return false;
        }
        $planOptions = $this->plan['options'];
        if (!is_array($this->plan) || !in_array('integrate_with_wordpress_plugin', array_column($planOptions, 'name'))) {
            return false;
        }

        if (in_array(self::RULES[$snippet], array_column($planOptions, 'name'))) {
            return true;
        }
        return false;
    }

    /**
     * Get first plan name for specific action
     *
     * @since 1.0.0
     *
     * @param $snippet string
     * @return false|string
     */
    public function nearestAvailablePlanFor($snippet)
    {
        if (!isset(self::RULES[$snippet])) {
            return false;
        }
        $tariffName = false;
        foreach ($this->allPlans as $tariff) {
            if (isset($tariff['options']) && is_array($tariff['options'])) {
                foreach ($tariff['options'] as $option) {
                    if ($option['name'] === self::RULES[$snippet]) {
                        $tariffName = $tariff['name'];
                        break 2;
                    }
                }
            }
        }
        return "<a class=\"em\" href=\"" . BIZBABY_HOST . "/price\">" . $tariffName . "</a>";
    }

    /**
     * Get plan or options from db or if it outdated
     * update it from bizbaby
     *
     * @return false|mixed|null
     */
    private function getPlan()
    {
        $lastUpdate = get_option('bizbaby_plan_last_updated');
        $plan = get_option('bizbaby_plan');
        if ($lastUpdate < time() - self::TIMOUT || !$plan) {
            $plan = $this->loadPlan();
            if ($plan) {
                update_option('bizbaby_plan_last_updated', time());
                update_option('bizbaby_plan', $plan['current_plan']);
                update_option('bizbaby_plans', $plan['data']);
                return $plan['current_plan'];
            }
            return null;
        }

        return $plan;
    }

    private function loadPlan()
    {
        $token = Bizbaby_OptionsHelper::get_integration_token();
        $url = BIZBABY_HOST . BIZBABY_SYNC_BUSINESS_PLANS_ROUTE;

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
                return json_decode(wp_remote_retrieve_body($response), true);
            }
        }
        return false;
    }
}
