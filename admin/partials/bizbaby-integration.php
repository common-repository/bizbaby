<?php
/**
 * Provide shortcode instructions markup
 *
 * @link       https://bizbaby.com
 * @since      1.0.0
 *
 * @package    Bizbaby
 * @subpackage Bizbaby/admin/partials
 */
?>

<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>

<div class="bizbaby-root">
    <h2 class="page-title"><?php echo esc_html__('Integration & Links', 'bizbaby') ?></h2>
    <div class="bizbaby-cards">
        <div class="bizbaby-card cabinet">
            <div class="bizbaby-card__content">
                <div class="bizbaby-card__title">
                    <h2><?php echo esc_html__('Personal Cabinet', 'bizbaby') ?></h2>
                </div>
                <div class="bizbaby-card__columns">
                    <div class="card-column">
                        <span class="em"><a href="https://<?php echo
                            sprintf(
                            // translators: Placeholder is a plugin url subdomain
                                '%s',
                                esc_html(Bizbaby_OptionsHelper::bizbaby_get_subdomain())
                            );
                        ?>.bizbaby.com"><?php echo sprintf(
                                // translators: Placeholder is a plugin url subdomain
                                    '%s',
                                    esc_html(Bizbaby_OptionsHelper::bizbaby_get_subdomain())
                                );
                        ?>.bizbaby.com</a></span>
                    </div>
                    <div class="card-column">
                        <div class="card-column__content">
                            <p>Personal cabinet allows your customers to login and manage their appointments, jobs, payment methods and more.</p>
                        </div>
                        <div class="card-column__install">
                            <button type="button" class="copy-shortcode" data-shortcode='https://business_domain.bizbaby.com'>Copy Link to Cabinet</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bizbaby-card appointments">
            <?php if (!$params['tariff']->can('appointment')) : ?>
                <span class="plan-lock">To unlock, upgrade to <?php echo
                    sprintf(
                    // translators: Placeholder is nearest available plan for appointment
                        '%s',
                        esc_html($params['tariff']->nearestAvailablePlanFor('appointment'))
                    );
                ?> plan</span>
            <?php endif; ?>
            <div class="bizbaby-card__content <?php if (!$params['tariff']->can('appointment')):?> lock <?php endif; ?>">
                <div class="bizbaby-card__title">
                    <h2><?php echo esc_html__('Appointments', 'bizbaby') ?></h2>
                </div>
                <div class="bizbaby-card__columns">
                    <div class="card-column">
                        <img src="<?php echo
                            sprintf(
                            // translators: Placeholder is bizbaby plugin url
                                '%s',
                                esc_url(BIZBABY_PLUGIN_URL)
                            );
                        ?>admin/img/appointment.webp" alt="Appointment form" width="100%">
                    </div>
                    <div class="card-column">
                        <div class="card-column__content">
                            <p>Form to process appointments, such as in person consultation. Or simple service appointments that don’t require quote, like cutting grass or home cleaning.</p>
                            <p>Appointments usually take from less than an hour to a few hours to complete.</p>
                            <p>Customer sees a <b>Total</b> during the form submission process. Payment is processed by the merchant, when service is being performed or on it’s completion.</p>
                            <p>Customer will receive an email confirmation when order is submitted and when payment is processed.</p>
                        </div>
                        <div class="card-column__install">
                            <p>To install it, either use <a target="_blank" href="<?php echo
                                sprintf(
                                // translators: Placeholder is bizbaby theme url
                                    '%s',
                                    esc_url($this->bizbaby_theme_url())
                                );
                            ?>">BizBaby Theme</a> and select it to show in the web page header. Or copy it by pressing button below and paste it in your
                                custom theme where you want it to show up.</p>
                            <button class="copy-shortcode" data-shortcode='[bizbaby_shortcode type="appointment"]' type="button">Copy Shortcode</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bizbaby-card job-requests">
            <?php if (!$params['tariff']->can('jobs')) : ?>
                <span class="plan-lock">To unlock, upgrade to <?php echo
                    sprintf(
                    // translators: Placeholder is nearest available plan for jobs
                        '%s',
                        esc_html($params['tariff']->nearestAvailablePlanFor('jobs'))
                    );
                ?> plan</span>
            <?php endif; ?>
            <div class="bizbaby-card__content <?php if (!$params['tariff']->can('jobs')):?> lock <?php endif; ?>">
                <div class="bizbaby-card__title">

                    <h2><?php echo esc_html__('Job Requests', 'bizbaby') ?></h2>
                </div>
                <div class="bizbaby-card__columns">
                    <div class="card-column">
                        <img src="<?php echo
                            sprintf(
                            // translators: Placeholder is a bizbaby plugin url
                                '%s',
                                esc_url(BIZBABY_PLUGIN_URL)
                            );
                        ?>/admin/img/job.webp" alt="Jobs request form" width="100%">
                    </div>
                    <div class="card-column">
                        <div class="card-column__content">
                            <p>Form to process requests for jobs. Projects that require quote approvals, scheduling visits, and sending invoices.</p>
                            <p>Job Projects usually take a days to months to complete. They must be paid by the customer.</p>
                        </div>
                        <div class="card-column__install">
                            <p>To install it, either use <a target="_blank" href="<?php echo
                                sprintf(
                                // translators: Placeholder is a bizbaby theme url
                                    '%s',
                                esc_url($this->bizbaby_theme_url())
                                );
                            ?>">BizBaby Theme</a> and select it to show in the web page header. Or copy it by pressing button below and paste it in your
                                custom theme where you want it to show up.</p>
                            <button class="copy-shortcode" data-shortcode='[bizbaby_shortcode type="jobs"]' type="button">Copy Shortcode</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bizbaby-card login">
            <?php if (!$params['tariff']->can('login')) : ?>
                <span class="plan-lock">To unlock, upgrade to <?php echo
                    sprintf(
                    // translators: Placeholder is nearest available plan for login
                        '%s',
                        esc_html($params['tariff']->nearestAvailablePlanFor('login'))
                    );
                ?> plan</span>
            <?php endif; ?>
            <div class="bizbaby-card__content <?php if (!$params['tariff']->can('login')):?> lock <?php endif; ?>">
                <div class="bizbaby-card__title">
                    <h2><?php echo esc_html__('Login', 'bizbaby') ?></h2>
                </div>
                <div class="bizbaby-card__columns">
                    <div class="card-column">
                        <img src="<?php echo
                            sprintf(
                            // translators: Placeholder is a bizbaby plugin url
                                '%s',
                                esc_url(BIZBABY_PLUGIN_URL)
                            );
                        ?>admin/img/login.webp" alt="Login form" width="100%">
                    </div>
                    <div class="card-column">
                        <div class="card-column__content">
                            <p>Form that will allow your customers to login into their personal cabinet. Place where they can manage their jobs, appointments, quotes, invoices, payment methods and more.</p>
                        </div>
                        <div class="card-column__install">
                            <p>To install it, either use <a target="_blank" href="<?php echo
                                sprintf(
                                // translators: Placeholder is a bizbaby theme url
                                    '%s',
                                    esc_url($this->bizbaby_theme_url())
                                );
                            ?>">BizBaby Theme</a> and select it to show in the web page header. Or copy it by pressing button below and paste it in your
                                custom theme where you want it to show up.</p>
                            <button class="copy-shortcode" data-shortcode='[bizbaby_shortcode type="login"]' type="button">Copy Shortcode</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bizbaby-card contact-form">
            <?php if (!$params['tariff']->can('contact')) : ?>
                <span class="plan-lock">To unlock, upgrade to <?php echo
                    sprintf(
                    // translators: Placeholder is nearest available plan for contact
                        '%s',
                        esc_html($params['tariff']->nearestAvailablePlanFor('contact'))
                    );
                ?> plan</span>
            <?php endif; ?>
            <div class="bizbaby-card__content <?php if (!$params['tariff']->can('contact')):?> lock <?php endif; ?>">
                <div class="bizbaby-card__title">

                    <h2><?php echo esc_html__('Contact Form', 'bizbaby') ?></h2>
                </div>
                <div class="bizbaby-card__columns">
                    <div class="card-column">
                        <img src="<?php echo
                            sprintf(
                            // translators: Placeholder is a bizbaby plugin url
                                '%s',
                                esc_url(BIZBABY_PLUGIN_URL)
                            );
                        ?>admin/img/contact.webp" alt="Contact form" width="100%">
                    </div>
                    <div class="card-column">
                        <div class="card-column__content">
                            <p>Simple contact form that is connected to your Call & Message Center.</p>
                        </div>
                        <div class="card-column__install">
                            <p>To install it, either use <a target="_blank" href="<?php echo
                                sprintf(
                                // translators: Placeholder is a bizbaby theme url
                                    '%s',
                                    esc_url($this->bizbaby_theme_url())
                                );
                            ?>">BizBaby Theme</a> and select it to show in the web page header. Or copy it by pressing button below and paste it in your
                                custom theme where you want it to show up.</p>
                            <button class="copy-shortcode" data-shortcode='[bizbaby_shortcode type="contact"]' type="button">Copy Shortcode</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
