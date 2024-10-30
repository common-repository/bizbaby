<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>

<div id="service-request-bizbaby"></div>
<script data-container="#service-request-bizbaby"
        data-height="260px"
        data-width="340px"
        data-id="bizbaby-snippet"
        data-api="<?php echo esc_url(BIZBABY_HOST); ?>/api/snippet"
        src="<?php echo esc_url(BIZBABY_HOST); ?>/api/snippet/service-request?key=<?php echo esc_url(Bizbaby_OptionsHelper::get_integration_key()); ?>">
</script>
