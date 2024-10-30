<?php

/**
 * Provide setup plugin markup
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
    <div class="bizbaby-container">
        <div class="content__header">
            <div class="content__header-wrapper-box">
                <div class="content__header-wrapper-box-title">All tools your business needs *</div>
                <div class="content__header-wrapper-box-desc">*Realistically about 99% of tools your business needs to efficiently
                    communicate with customers, manage employees, provide an amazing service and get paid.
                </div>
                <div class="content__header-wrapper-box-group">
                    <a target="_blank" href="https://bizbaby.com/register">
                        <div class="bizbaby-btn"><?php echo esc_html__('Start Free Trial', 'bizbaby') ?></div>
                    </a>
                    <a href="<?php echo
                        sprintf(
                            // translators: Placeholder is a login url
                            '%s',
                            esc_url(BIZBABY_LOGIN_ROUTE . '?redirect_url=' . admin_url() . BIZBABY_REDIRECT)
                        );
                    ?>">
                        <div class="bizbaby-btn">
                            <?php echo esc_html__('Login to BizBaby', 'bizbaby') ?>
                        </div>
                    </a>
                </div>
                <div class="content__header-wrapper-box-free first">
                    <div>Join <b>over 5,000 small businesses</b> that use BizBaby</div>
                </div>
                <div class="content__header-wrapper-box-free second">
                    <div class="content__header-wrapper-box-free-icon">First 3 month free.</div>
                    <div class="content__header-wrapper-box-free-icon">No card required</div>
                </div>
                <div class="content__header-wrapper-box-free">
                    <div><a target="_blank" href="https://bizbaby.com">Visit BizBaby website</a></div>
                </div>
            </div>
            <div class="content__header-wrapper-box-background">
                <div class="main__page-background"></div>
            </div>
        </div>
        <div class="content__instruction">
            <div class="content__instruction-title">Steps to use BizBaby plugin</div>
            <div class="content__instruction-list">
                <ol>
                    <li>Signup and create your BizBaby business account by clicking “Get Started” button. If you already have an account, you can skip this step.</li>
                    <li>Come back to this plugin page Login to connect your BizBaby business account to your WordPress website.</li>
                    <li>Activate BizBaby WordPress template or copy shortcodes to drop forms into your existing template.</li>
                    <li>Enjoy.</li>
                </ol>
            </div>
        </div>
    </div>
</div>
