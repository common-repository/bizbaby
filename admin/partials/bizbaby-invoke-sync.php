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
    <h2 class="page-title"><?php echo esc_html__('Plug-in: BizBaby', 'bizbaby') ?></h2>
    <div class="bizbaby-container">
        <div class="sync">
            <div class="sync__column">
                <h2><?php echo esc_html__('Business Info', 'bizbaby') ?> </h2>
                <div class="sync__column-datalist datalist">
                    <div class="datalist__row">
                        <div class="datalist__row-title">Company Name:</div>
                        <div class="datalist__row-value"><?php echo
                            sprintf(
                            // translators: Placeholder is organization name
                                '%s',
                                esc_html(Bizbaby_OptionsHelper::get_organization_name() ?? "Not Sync")
                            );
                        ?></div>
                    </div>
                    <div class="datalist__row">
                        <div class="datalist__row-title">Business Email:</div>
                        <div class="datalist__row-value"><?php echo
                            sprintf(
                            // translators: Placeholder is organization email
                                '%s',
                                esc_html(Bizbaby_OptionsHelper::bizbaby_get_email() ?? "Not Sync")
                            );
                        ?></div>
                    </div>
                    <div class="datalist__row">
                        <div class="datalist__row-title">Business Phone Number:</div>
                        <div class="datalist__row-value"><?php echo
                            sprintf(
                            // translators: Placeholder is organization phone number
                                '%s',
                                esc_html(Bizbaby_OptionsHelper::bizbaby_get_phone() ?? "Not Sync")
                            );
                        ?></div>
                    </div>
                    <div class="datalist__row">
                        <div class="datalist__row-title">Business Address:</div>
                        <div class="datalist__row-value"><?php echo
                            sprintf(
                            // translators: Placeholder is organization address
                                '%s',
                                esc_html(Bizbaby_OptionsHelper::bizbaby_get_address() ?? "Not Sync")
                            );
                        ?></div>
                    </div>
                    <div class="datalist__hint">
                        If you would like to change this business information, please login into your BizBaby account and change it there.
                    </div>
                </div>
                <a target="_blank" href="<?php echo
                    sprintf(
                    // translators: Placeholder is bizbaby host url
                        '%s',
                        esc_url(BIZBABY_HOST)
                    );
                ?>/dashboard">
                    <div class="bizbaby-btn thin">
                        <?php echo esc_html__('Go to BizBaby Account', 'bizbaby') ?>
                    </div>
                </a>
                <hr>
                <h2><?php echo esc_html__('Business Info', 'bizbaby') ?> </h2>
                <div class="sync__column-datalist datalist">
                    <div class="datalist__row">
                        <div class="datalist__row-title">Plan:</div>
                        <div class="datalist__row-value"><?php echo
                            sprintf(
                            // translators: Placeholder is tariff name
                                '%s',
                                esc_html($params['tariff']->getName())
                            );
                        ?></div>
                    </div>
                    <div class="datalist__row">
                        <div class="datalist__row-title">Monthly membership:</div>
                        <div class="datalist__row-value">$<?php echo
                            sprintf(
                            // translators: Placeholder is tariff price
                                '%s',
                                esc_html($params['tariff']->getPrice())
                            );
                        ?></div>
                    </div>
                </div>
            </div>
            <?php if (!$params['sync_status']['status']): ?>
                <div class="sync__column">
                    <h2><?php echo esc_html__('Information in BizBaby', 'bizbaby') ?> </h2>
                    <div class="sync__column-datalist datalist <?php if (!$params['sync_status']['status']): ?>danger<?php endif; ?>">
                        <div class="datalist__row">
                            <div class="datalist__row-title">Company Name:</div>
                            <div class="datalist__row-value"><?php echo
                                sprintf(
                                // translators: Placeholder is company name
                                    '%s',
                                    esc_html($params['sync_status']['name'])
                                );
                            ?>
                            </div>
                        </div>
                        <div class="datalist__row">
                            <div class="datalist__row-title">Business Email:</div>
                            <div class="datalist__row-value"><?php echo
                                sprintf(
                                // translators: Placeholder is company email
                                    '%s',
                                    esc_html($params['sync_status']['email'])
                                );
                            ?></div>
                        </div>
                        <div class="datalist__row">
                            <div class="datalist__row-title">Business Phone Number:</div>
                            <div class="datalist__row-value"><?php echo
                                sprintf(
                                // translators: Placeholder is company phone number
                                    '%s',
                                    esc_html($params['sync_status']['phone'])
                                );
                            ?></div>
                        </div>
                        <div class="datalist__row">
                            <div class="datalist__row-title">Business Address:</div>
                            <div class="datalist__row-value"><?php echo
                                sprintf(
                                // translators: Placeholder is company phone address
                                    '%s',
                                    esc_html($params['sync_status']['address'])
                                );
                            ?></div>
                        </div>
                        <?php if (!$params['sync_status']['status']): ?>
                            <div class="datalist__hint">
                                Warning, some of your business information in BizBaby have changed. Would you like to update it here to match?
                            </div>
                        <?php endif ?>
                        <div class="datalist__hint">
                            When you click “Update Business Info”, it will be automatically updated in your BizBaby wordpress template as well.
                        </div>
                    </div>
                    <div class="input-container">
                        <form action="<?php echo
                            sprintf(
                            // translators: Placeholder is site admin url
                                '%s',
                                esc_url(admin_url('admin-post.php'))
                            );
                        ?>" method="POST">
                            <input type="hidden" name="action" value="sync_company_data">
                            <?php wp_nonce_field('bizbaby_sync_company', 'bizbaby_nonce_field'); ?>
                            <button class="bizbaby-btn thin"><?php echo esc_html__('Update Business Info', 'bizbaby') ?></button>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
