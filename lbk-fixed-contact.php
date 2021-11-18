<?php
/**
 * LBK Fixed Contact
 * 
 * @package LBK Fixed Contact
 * @author LBK
 * @copyright 2021 LBK
 * @license GPL-2.0-or-later
 * @category plugin
 * @version 1.0.0
 * 
 * @wordpress-plugin
 * Plugin Name:       LBK Fixed Contact
 * Plugin URI:        https://lbk.vn/fixed-contact
 * Description:       LBK Fixed Contact always appear on the website
 * Version:           1.0.0
 * Requires at least: 1.0.0
 * Requires PHP:      7.4
 * Author:            LBK
 * Author             URI: https://facebook.com/vuong.briki
 * Text Domain:       lbk-fc
 * License:           GPLv2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain path:       /languages/
 * 
 * LBK Fixed Contact is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *  
 * LBK Fixed Contact is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *  
 * You should have received a copy of the GNU General Public License
 * along with LBK Fixed Contact. If not, see <http://www.gnu.org/licenses/>.
*/

// Die if accessed directly
if ( !defined('ABSPATH') ) die( 'What are you doing here? You silly human!' );

if ( !class_exists('lbkFc') ) {
    /**
     * class lbkFc
     */
    final class lbkFc {
        /**
         * Current version
         * 
         * @since 1.0
         * @var string
         */
        const VERSION = '1.0.0';

        /**
         * Stores the instance of this class
         * 
         * @access private
         * @since 1.0
         * @static
         * 
         * @var lbkFc
         */
        private static $instance;

        /**
         * A dummny contructor to prevent the class from being loaded more than once
         * 
         * @access public
         * @since 1.0
         */
        public function __construct() { 
            /** Do nothing here */
        }

        /**
         * @access private
         * @since 1.0
         * @static
         * 
         * @return lbkFc
         */
        public static function instance() {
            if ( !isset( self::$instance ) && !( self::$instance instanceof lbkFc ) ) {
                self::$instance = new lbkFc();

                self::defineConstants();
                self::includes();
                self::hooks();

                // self::loadTextdomain();
            }

            return self::$instance;
        }

        /**
         * Define the plugin constants.
         * 
         * @access private
         * @since 1.0
         * @static
         */
        private static function defineConstants() {
            define( 'LBK_FC_DIR_NAME', plugin_basename( dirname( __FILE__ ) ) );
            define( 'LBK_FC_BASE_NAME', plugin_basename( __FILE__ ) );
            define( 'LBK_FC_PATH', plugin_dir_path( __FILE__ ) );
            define( 'LBK_FC_URL', plugin_dir_url( __FILE__ ) );
        }

        /**
         * Includes the plugin dependency files.
         * 
         * @access private
         * @since 1.0
         * @static
         */
        private static function includes() {
            if ( is_admin() ) {
                require_once( LBK_FC_PATH . 'includes/class.admin.php' );
            }
            require_once( LBK_FC_PATH . 'includes/ajax-admin.php' );
            require_once( LBK_FC_PATH . 'includes/template.php' );
        }

        /**
         * Add the core action filter hook.
         * 
         * @access private
         * @since 1.0
         * @static
         */
        private static function hooks() {
            wp_enqueue_style( 'lbk-fc-style', LBK_FC_URL . 'assets/css/style.css', array( 'wp-color-picker' ), lbkFc::VERSION );
            wp_enqueue_script( 'lbk-fc', LBK_FC_URL . 'assets/js/frontend.js', array( 'jquery' ), lbkFc::VERSION, 'all' );
        }

        /**
         * Call back for the `wp_enqueue_scripts` action.
         * 
         * Register add enqueue CSS and javascript files for frontend
         * 
         * @access private
         * @since 1.0
         * @static
         */
        public static function enqueueScripts() {
            // If SCRIPT_DEBUG is set and TRUE load the non-minifed JS files, otherwise, load the minifed files.
            $min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

        }

        /**
         * Prints out inline CSS after the core CSS file to allow overriding core styles via options.
         * 
         * @access private
         * @since 1.0
         * @static
         */
        public static function inlineCSS() {

        }
    } // end class
    
    /**
     * The main function reponsible for returning the LBK Fixed Contact instance to function everywhere.
     * 
     * Use this function like you would a global variable, except without needing to declare the global.
     * 
     * Example: <?php $instance = lbkFc(); ?>
     * 
     * @access public
     * @since 1.0
     * 
     * @return lbkFc
     */
    function lbkFc() {
        return lbkFc::instance();
    }

    // Start LBK Fixed Contact
    add_action( 'plugins_loaded', 'lbkFc' );
}