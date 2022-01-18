<?php
/*
Plugin Name: Elementor Test Plugin
Plugin URI:
Description:
VErsion: 1.0
Author: LWHHH
Author URI: https://hasin.me
License: GPLv2 or later
Text Domain: elementortestplugin
Domain PAth: /languages/
*/
//use \Elementor\Plugin as Plugin;
if( ! defined( 'ABSPATH' ) ){
    die(__( "Direct Access is not allowed",'elementortestplugin' ) );
}

final class ElementorTestExtention{
    const VERSION="1.0.0";
    const MINIMUM_ELEMENTOR_VERSION="2.0.0";
    const MINIMUM_PHP_VERSION="7.0";

    private static $_instance = null;

    public static function instance() {

        if( is_null( self::$_instance ) ){
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __construct() {
        add_action( 'plugins_loaded', [ $this, 'init' ] );
    }
    public function init() {
        load_plugin_textdomain( 'elementor-test-extention' );

        if(! did_action( 'elementor/loaded' ) ) {
            add_action( 'admin_notices', [$this, 'admin_notice_missing_main_plugin' ] );
            return;
        }

        if( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ){
            add_action('admin_notices', [$this, 'admin_notice_minimum_elementor_version'] );

            return;
        }

        if( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ){
            add_action('admin_notices', [$this, 'admin_notice_minimum_php_version'] );

            return;
        }

        add_action( 'elementor/widgets/widgets_registered', [ $this, 'init_widgets' ] );

    }
    public function init_widgets(){
        require_once( __DIR__ . '/widgets/test-widget.php' );

        \Elementor\Plugin::$instance()->widgets_manager->register_widget_type( new \Elementor_Test_Widget() );
    }
    public function admin_notice_minimum_php_version(){
        if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

        $message = sprintf(
            esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'elementortestplugin' ),
            '<strong>' . esc_html__( 'Elementor Test Extention', 'elementortestplugin' ) . '</strong>',
            '<strong>' . esc_html__('PHP', 'elementortestplugin' ) . '</strong>',
            self::MINIMUM_PHP_VERSION
        );

        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }
    public function admin_notice_minimum_elementor_version(){
        if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

        $message = sprintf(
            esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'elementortestplugin' ),
            '<strong>' . esc_html__( 'Elementor Test Extention', 'elementortestplugin' ) . '</strong>',
            '<strong>' . esc_html__('Elementor', 'elementortestplugin' ) . '</strong>',
            self::MINIMUM_ELEMENTOR_VERSION
        );

        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }
    public function admin_notice_missing_main_plugin(){
        if( isset( $_GET['activate'] ) ){
           unset( $_GET['activate'] );
        }

        $message = sprintf(
            esc_html__('"%1$s" requires "%2$s" to be installed and activated.', 'elementortestplugin' ),
            '<strong>' . esc_html__('Elementor Test Extention', 'elementortestplugin') . '</strong',
            '<strong>' . esc_html__('Elementor', 'elementortestplugin' ) . '</strong>'
        );

        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
    }
    public function includes() {}
}
ElementorTestExtention::instance();