<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>

<div id="login-bizbaby"></div>
<script data-id="bizbaby-snippet"
        data-api="<?php echo
            sprintf(
            // translators: Placeholder is a constant host url from config
                '%s', esc_html(BIZBABY_HOST)
            );
        ?>/api/snippet"
        src="<?php echo
            sprintf(
            // translators: Placeholder is a constant host url from config
                '%s', esc_html(BIZBABY_HOST)
            );
        ?>/api/snippet/login?key=<?php echo
            sprintf(
            // translators: Placeholder is a key from config
                '%s',
                esc_html(Bizbaby_OptionsHelper::get_integration_key())
            );
        ?>"
        data-container="#login-bizbaby"
>
</script>
