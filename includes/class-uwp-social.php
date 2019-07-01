<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class UsersWP_Social {

    private static $instance;

    /**
     * Plugin Version
     */
    private $version = UWP_SOCIAL_VERSION;


    public static function get_instance() {
        if ( ! isset( self::$instance ) && ! ( self::$instance instanceof UsersWP_Social ) ) {
            self::$instance = new UsersWP_Social;
            self::$instance->setup_globals();
            self::$instance->includes();
            self::$instance->setup_actions();
        }

        return self::$instance;
    }

    private function __construct() {
        self::$instance = $this;
    }

    private function setup_globals() {

    }

    private function setup_actions() {
        if (class_exists( 'UsersWP' )) {
            add_action('wp_enqueue_scripts', array($this, 'enqueue_styles'));
            add_action('login_enqueue_scripts', array($this, 'enqueue_styles'));
        }
        do_action( 'uwp_social_setup_actions' );
        if(is_admin()){
            add_action( 'admin_init', array( $this, 'activation_redirect' ) );
            add_filter( 'uwp_get_settings_pages', array( $this, 'uwp_socail_get_settings_pages' ), 10, 1 );
        }
        add_action( 'init', array($this, 'load_textdomain') );
    }

    public function enqueue_styles() {

        wp_enqueue_style( 'uwp_social_styles', UWP_SOCIAL_PLUGIN_URL . 'public/assets/css/styles.css', array(), $this->version, 'all' );

    }

    /**
     * Load the textdomain.
     */
    public function load_textdomain() {
        load_plugin_textdomain( 'uwp-social', false, basename( UWP_SOCIAL_PATH ) . '/languages' );
    }

    private function includes() {

        require_once UWP_SOCIAL_PATH . '/includes/helpers.php';
        require_once UWP_SOCIAL_PATH . '/includes/social.php';
        require_once UWP_SOCIAL_PATH . '/includes/widgets.php';
        require_once UWP_SOCIAL_PATH . '/includes/errors.php';
        require_once UWP_SOCIAL_PATH . '/includes/linking.php';

        do_action( 'uwp_social_include_files' );

        if ( ! is_admin() )
            return;

        do_action( 'uwp_social_include_admin_files' );

    }

    public function uwp_socail_get_settings_pages($settings){
        $settings[] = include( UWP_SOCIAL_PATH . '/admin/class-uwp-settings-social.php' );
        return $settings;
    }

    /**
     * Redirect to the social settings page on activation.
     *
     * @since 1.0.0
     */
    public function activation_redirect() {
        // Bail if no activation redirect
        if ( !get_transient( '_uwp_social_activation_redirect' ) ) {
            return;
        }

        // Delete the redirect transient
        delete_transient( '_uwp_social_activation_redirect' );

        // Bail if activating from network, or bulk
        if ( is_network_admin() || isset( $_GET['activate-multi'] ) ) {
            return;
        }

        wp_safe_redirect( admin_url( 'admin.php?page=userswp&tab=uwp-social' ) );
        exit;
    }

}