<?php
/**
 * Plugin Name: Switcher
 * Description: Switcher between the recently viewed admin page and the recently viewed public page.
 * Version: 1.2
 * Author: Kostya Tereshchuk
 * Author URI: https://wordpress.org/support/users/kostyatereshchuk/
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: switcher
 */


if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}


if (!class_exists('Switcher')) {

    /**
     * @class Switcher
     */
    class Switcher {

        /**
         * Single instance of the class.
         *
         * @var Switcher
         */
        protected static $_instance = null;

        /** Version of Switcher plugin.
         *
         * @var string
         */
        public $version = '1.2';

        /**
         * Switcher instance.
         *
         * @static
         * @return Switcher - Main instance
         */
        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        /**
         * Switcher Constructor.
         */
        public function __construct() {
            add_action( 'wp_enqueue_scripts', array( $this, 'wp_enqueue_scripts' ) );
            add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );

            add_action( 'admin_bar_menu', array( $this, 'admin_bar_menu' ), 0 );
        }

        /**
         * Scripts on the site.
         */
        public function wp_enqueue_scripts() {
            if (is_user_logged_in()) {
                wp_enqueue_script( 'switcher-js', plugins_url( 'assets/js/switcher.js', __FILE__ ), array(), $this->version );
            }
        }

        /**
         * Scripts on the admin panel.
         */
        public function admin_enqueue_scripts() {
            wp_enqueue_script( 'admin-switcher-js', plugins_url( 'assets/admin/js/admin-switcher.js', __FILE__ ), array(), $this->version );
        }

        /**
         * Add Switcher to admin bar.
         *
         * @param WP_Admin_Bar $wp_admin_bar
         */
        function admin_bar_menu( $wp_admin_bar ) {
            $wp_admin_bar->add_menu(
                array(
                    'id'     => 'switcher',
                    'title'  => '<span class="dashicons-before dashicons-controls-repeat" style="display: inline-block; padding: 6px 0; height: 20px;"></span>',
                    'parent' => 'top-secondary',
                    'href'   => is_admin() ? site_url() : admin_url(),
                    'group'  => false,
                    'meta'  => array(),
                )
            );
        }

    }

    Switcher::instance();

}