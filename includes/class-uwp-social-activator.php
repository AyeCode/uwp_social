<?php
/**
 * Fired during plugin activation
 *
 * @link       http://wpgeodirectory.com
 * @since      1.0.0
 *
 * @package    Users_WP
 * @subpackage Users_WP/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Users_WP
 * @subpackage Users_WP/includes
 * @author     GeoDirectory Team <info@wpgeodirectory.com>
 */
class UWP_Social_Activator
{

    /**
     * @since    1.0.0
     */
    public static function activate()
    {
        self::create_tables();
        self::add_default_options();
    }

    public static function add_default_options()
    {
        
    }

    public static function create_tables()
    {
        
    }
}