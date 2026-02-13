<?php
class SMD_Admin_Actions {

    public function __construct() {

    add_filter( 'post_row_actions', [ $this, 'add_duplicate_link' ], 10, 2 );

    // ADD THIS FOR PAGES
    add_filter( 'page_row_actions', [ $this, 'add_duplicate_link' ], 10, 2 );
}


    public function add_duplicate_link( $actions, $post ) {

        if ( ! current_user_can( 'edit_posts' ) ) return $actions;

        $url = wp_nonce_url(
            admin_url( 'admin.php?action=smd_duplicate&post=' . $post->ID ),
            'smd_duplicate_' . $post->ID
        );

        $actions['smd_duplicate'] = '<a href="' . esc_url($url) . '">Duplicate xN</a>';

        return $actions;
    }
}
