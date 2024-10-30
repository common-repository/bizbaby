<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>

<div id="job-request-bizbaby"></div>
<script data-container="#job-request-bizbaby"
        data-id="bizbaby-snippet"
        data-api="<?php echo esc_url(BIZBABY_HOST); ?>/api/snippet"
        src="<?php echo esc_url(BIZBABY_HOST); ?>/api/snippet/job-request?key=<?php echo esc_url(Bizbaby_OptionsHelper::get_integration_key()); ?>">
</script>