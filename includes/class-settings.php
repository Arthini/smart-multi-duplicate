<?php
class SMD_Settings {

    private $max_limit = 5;

    public function __construct() {
        add_action( 'admin_menu', [ $this, 'menu' ] );
        add_action( 'admin_init', [ $this, 'register' ] );
    }

    public function menu() {
        add_options_page(
            'Smart Multi Duplicate',
            'Smart Multi Duplicate',
            'manage_options',
            'smd-settings',
            [ $this, 'settings_page' ]
        );
    }

    public function settings_page() {
        ?>
        <div class="wrap">
            <h1>Smart Multi Duplicate Settings</h1>
            <form method="post" action="options.php">
                <?php
                settings_fields('smd_settings_group');
                do_settings_sections('smd-settings');
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    public function register() {

        register_setting(
            'smd_settings_group',
            'smd_duplicate_count',
            [
                'sanitize_callback' => function($value){
                    return min(intval($value), 5);
                }
            ]
        );

        add_settings_section(
            'smd_main',
            'Duplicate Settings',
            null,
            'smd-settings'
        );

        add_settings_field(
            'smd_duplicate_count',
            'Default Duplicate Count (Max 5)',
            [ $this, 'count_field' ],
            'smd-settings',
            'smd_main'
        );
    }

    public function count_field() {
        $value = get_option('smd_duplicate_count', 1);
        echo '<input type="number" min="1" max="5" name="smd_duplicate_count" value="' . esc_attr($value) . '">';
    }
}
