<?php

class Bizbaby_AdminNotice
{
    public function displayAdminNotice()
    {
        $option = get_option(BIZBABY_NOTICE_FIELD);
        $message = $option['message'] ?? false;
        $noticeLevel = !empty($option['notice-level']) ? $option['notice-level'] : 'notice-error';
        if ($message) {
            printf(
            // translators: First placeholder is notice level, second is notice message
                esc_html__('<div class="notice %1$s is-dismissible"><p>%2$s</p></div>', 'bizbaby'),
                esc_url(admin_url('admin-post.php')),
                esc_html($message)
            );
            delete_option(BIZBABY_NOTICE_FIELD);
        }
    }

    public static function displayError($message)
    {
        self::updateOption($message, 'notice-error');
    }

    public static function displayWarning($message)
    {
        self::updateOption($message, 'notice-warning');
    }

    public static function displayInfo($message)
    {
        self::updateOption($message, 'notice-info');
    }

    public static function displaySuccess($message)
    {
        self::updateOption($message, 'notice-success');
    }

    protected static function updateOption($message, $noticeLevel)
    {
        update_option(BIZBABY_NOTICE_FIELD, array(
            'message'      => $message,
            'notice-level' => $noticeLevel,
        ));
    }
}
