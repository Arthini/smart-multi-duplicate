<?php
class SMD_Duplicate_Handler {

    private $max_limit = 5;

    public function __construct() {
        add_action( 'admin_action_smd_duplicate', [ $this, 'duplicate' ] );
    }

    public function duplicate() {

        if ( ! isset($_GET['post']) ) return;

        $post_id = intval($_GET['post']);

        if ( ! wp_verify_nonce($_GET['_wpnonce'], 'smd_duplicate_' . $post_id) ) {
            wp_die('Security check failed');
        }

        $count = get_option('smd_duplicate_count', 1);
        $count = min($count, $this->max_limit);

        $original = get_post($post_id);

        for ($i = 1; $i <= $count; $i++) {

            $new_post_id = wp_insert_post([
                'post_title'   => $original->post_title . ' - Copy ' . $i,
                'post_content' => $original->post_content,
                'post_status'  => 'draft',
                'post_type'    => $original->post_type,
            ]);

            // Copy meta
            $meta = get_post_meta($post_id);
            foreach ($meta as $key => $values) {
                foreach ($values as $value) {
                    add_post_meta($new_post_id, $key, maybe_unserialize($value));
                }
            }

            // Copy featured image
            $thumbnail = get_post_thumbnail_id($post_id);
            if ($thumbnail) {
                set_post_thumbnail($new_post_id, $thumbnail);
            }
        }

        wp_redirect( admin_url('edit.php?post_type=' . $original->post_type) );
        exit;
    }
}
