<?php
/*
Plugin Name: UsersWP - Social Login
Plugin URI: https://userswp.io
Description: Social login add-on for UsersWP.
Version: 1.0.7
Author: AyeCode Ltd
Author URI: https://userswp.io
License: GPL-2.0+
License URI: http://www.gnu.org/licenses/gpl-2.0.txt
Text Domain: uwp-social
Domain Path: /languages
Requires at least: 3.1
Tested up to: 5.0
Update URL: https://userswp.io
Update ID: 326
*/
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

define( 'UWP_SOCIAL_VERSION', '1.0.7' );

define( 'UWP_SOCIAL_PATH', plugin_dir_path( __FILE__ ) );

define( 'UWP_SOCIAL_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

define( 'UWP_SOCIAL_HYBRIDAUTH_ENDPOINT', UWP_SOCIAL_PLUGIN_URL . 'vendor/hybridauth/' );

class UsersWP_Social {

    private static $instance;

    /**
     * Plugin Version
     */
    private $version = UWP_SOCIAL_VERSION;

    private $file;

    private $plugin_dir;

    private $plugin_url;

    private $includes_dir;

    private $includes_url;

    /**
     * Plugin Title
     */
    public $title = 'UsersWP - Social';


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

        // paths
        $this->file         = __FILE__;
        $this->basename     = apply_filters( 'uwp_social_plugin_basenname', plugin_basename( $this->file ) );
        $this->plugin_dir   = apply_filters( 'uwp_social_plugin_dir_path',  plugin_dir_path( $this->file ) );
        $this->plugin_url   = apply_filters( 'uwp_social_plugin_dir_url',   plugin_dir_url ( $this->file ) );

        // includes
        $this->includes_dir = apply_filters( 'uwp_social_includes_dir', trailingslashit( $this->plugin_dir . 'includes'  ) );
        $this->includes_url = apply_filters( 'uwp_social_includes_url', trailingslashit( $this->plugin_url . 'includes'  ) );

    }

    private function setup_actions() {
        if (class_exists( 'UsersWP' )) {
            add_action('wp_enqueue_scripts', array($this, 'enqueue_styles'));
            add_action('login_enqueue_scripts', array($this, 'enqueue_styles'));
        }
        do_action( 'uwp_social_setup_actions' );
        if(is_admin()){
            add_action( 'admin_init', array( $this, 'activation_redirect' ) );
            add_filter( 'uwp_settings_general_uninstall', array( $this, 'uwp_social_settings_uninstall' ), 10, 1 );
        }
        add_action( 'init', array($this, 'load_textdomain') );
    }

    public function enqueue_styles() {

        wp_enqueue_style( 'uwp_social_styles', plugin_dir_url( __FILE__ ) . 'public/assets/css/styles.css', array(), $this->version, 'all' );
        
    }

    /**
     * Load the textdomain.
     */
    public function load_textdomain() {
        load_plugin_textdomain( 'uwp-social', false, basename( dirname( __FILE__ ) ) . '/languages' );
    }

    private function includes() {


        $errors = uwp_social_check_plugin_requirements();

        if ( empty ( $errors ) ) {

            require_once dirname( __FILE__ ) . '/includes/helpers.php';
            require_once dirname( __FILE__ ) . '/includes/social.php';
            require_once dirname( __FILE__ ) . '/includes/widgets.php';
            require_once dirname( __FILE__ ) . '/includes/errors.php';
            require_once dirname( __FILE__ ) . '/includes/linking.php';

            do_action( 'uwp_social_include_files' );

            if ( ! is_admin() )
                return;

            require_once dirname( __FILE__ ) . '/admin/settings.php';
            do_action( 'uwp_social_include_admin_files' );
        }


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

        wp_safe_redirect( admin_url( 'admin.php?page=uwp_social' ) );
        exit;
    }

    public function uwp_social_settings_uninstall($uninstall){
        $uninstall['uwp_uninstall_social_data'] = array(
            'id'   => 'uwp_uninstall_social_data',
            'name' => __( 'UsersWP - Social', 'uwp-social' ),
            'desc' => __( 'Remove all data when deleted?', 'uwp-social' ),
            'type' => 'checkbox',
            'std'  => '1',
            'class' => 'uwp_label_inline',
        );

        return $uninstall;
    }

}



function activate_uwp_social($network_wide) {
    if (is_multisite()) {
        if ( ! function_exists( 'is_plugin_active_for_network' ) ) {
            require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
        }

        // Network active.
        if ( is_plugin_active_for_network( 'userswp/userswp.php' ) ) {
            $network_wide = true;
        }
        if ($network_wide) {
            $main_blog_id = (int) get_network()->site_id;
            // Switch to the new blog.
            switch_to_blog( $main_blog_id );

            require_once('includes/activator.php');
            UWP_Social_Activator::activate();

            // Restore original blog.
            restore_current_blog();
        } else {
            require_once('includes/activator.php');
            UWP_Social_Activator::activate();
        }
    } else {
        require_once('includes/activator.php');
        UWP_Social_Activator::activate();
    }
}
register_activation_hook( __FILE__, 'activate_uwp_social' );


function init_uwp_social() {

    $errors = uwp_social_check_plugin_requirements();

    if ( empty ( $errors ) ) {
        UsersWP_Social::get_instance();
    }

}
add_action( 'plugins_loaded', 'init_uwp_social', apply_filters( 'uwp_social_action_priority', 10 ) );



// -------------------------
// Plugin requirement check
// -------------------------
function uwp_social_check_plugin_requirements()
{
    $errors = array ();

    $name = get_file_data( __FILE__, array ( 'Plugin Name' ) );

    if ( ! class_exists( 'UsersWP' ) ) {
        $errors[] =  '<b>'.$name[0].'</b>'.__( ' addon requires <a href="https://wordpress.org/plugins/userswp/" target="_blank">UsersWP</a> plugin.', 'uwp-social' );
    }
    

    return $errors;

}

add_action( 'admin_notices', 'uwp_social_check_admin_notices', 0 );
function uwp_social_check_admin_notices()
{
    $errors = uwp_social_check_plugin_requirements();

    if ( empty ( $errors ) )
        return;

    // Suppress "Plugin activated" notice.
    unset( $_GET['activate'] );

    printf(
        '<div class="error"><p>%1$s</p>
        </div>',
        join( '</p><p>', $errors )
    );

}