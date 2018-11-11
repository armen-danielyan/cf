<?php class cfOptions {
    public function __construct() {
        if ( is_admin() ) {
            add_action( 'admin_menu', array( 'cfOptions', 'addAdminMenu' ) );
            add_action( 'admin_init', array( 'cfOptions', 'register_settings' ) );
        }
    }

    public static function getThemeOptions() {
        return get_option( 'theme_options' );
    }

    public static function getThemeOption( $id ) {
        $options = self::getThemeOptions();
        if ( isset( $options[ $id ] ) ) {
            return $options[ $id ];
        }
    }

    public static function addAdminMenu() {
        add_menu_page(
            'CF Settings',
            'CF Setting',
            'manage_options',
            'cf-settings',
            array( 'cfOptions', 'createAdminPage' )
        );
    }

    public static function register_settings() {
        register_setting( 'theme_options', 'theme_options', array( 'cfOptions', 'sanitize' ) );
    }

    public static function sanitize( $options ) {
        if ( $options ) {
            if ( ! empty( $options['cf_dashboard_greet'] ) ) {
                $options['cf_dashboard_greet'] = sanitize_text_field( $options['cf_dashboard_greet'] );
            } else {
                unset( $options['cf_dashboard_greet'] );
            }

            if ( ! empty( $options['cf_your_total_footer'] ) ) {
                $options['cf_your_total_footer'] = sanitize_text_field( $options['cf_your_total_footer'] );
            } else {
                unset( $options['cf_your_total_footer'] );
            }
        }

        return $options;
    }

    public static function createAdminPage() { ?>
        <div class="wrap">
            <h1>Theme Options</h1>

            <form method="post" action="options.php">
                <?php settings_fields( 'theme_options' ); ?>
                <table class="form-table wpex-custom-admin-login-table">
                    <tr valign="top">
                        <th scope="row">Dashboard greeting</th>
                        <td>
                            <?php $value = self::getThemeOption( 'cf_dashboard_greet' ); ?>
                            <input style="width: 50%;" type="text" name="theme_options[cf_dashboard_greet]"
                                   value="<?php echo esc_attr( $value ); ?>">
                        </td>
                    </tr>

                    <tr valign="top">
                        <th scope="row">Your total text</th>
                        <td>
                            <?php $value = self::getThemeOption( 'cf_your_total_footer' ); ?>
                            <input style="width: 50%;" type="text" name="theme_options[cf_your_total_footer]"
                                   value="<?php echo esc_attr( $value ); ?>">
                        </td>
                    </tr>
                </table>

                <?php submit_button(); ?>
            </form>
        </div>
    <?php }
}
