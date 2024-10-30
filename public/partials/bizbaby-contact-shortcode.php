<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<div id="chat-bizbaby"></div>
<script data-id="bizbaby-snippet"
        data-container="#chat-bizbaby"
        data-api="<?php echo sprintf(
            // translators: Placeholder is a constant host url from config
            '%s', esc_html(BIZBABY_HOST)
        );
        ?>/api/snippet"
        src="<?php echo sprintf(
            // translators: Placeholder is a constant host url from config
            '%s', esc_html(BIZBABY_HOST)
        );
        ?>/api/snippet/chat?key=<?php echo sprintf(
            // translators: Placeholder is a token from config
            '%s', esc_html(Bizbaby_OptionsHelper::get_integration_token())
        ) ?>">
</script>
