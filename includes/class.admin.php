<?php

// Exit if accessed directly
if ( !defined ( 'ABSPATH' ) ) exit;

if ( !class_exists( 'lbkFc_Admin' ) ) {
    /**
     * Class lbkFc_Admin
     */
    final class lbkFc_Admin {
        /**
         * Setup plugin for admin use
         * 
         * @access private
         * @since 1.0
         * @static
         */
        public function __construct() {
            $this->hooks();
        }

        /**
         * Add the core admin hooks.
         * 
         * @access private
         * @since 1.0
         * @static
         */
        private function hooks() {
            add_action( 'admin_init', array( $this, 'registerScripts' ) );
            add_action( 'admin_menu', array( $this, 'menu' ) );
            add_action( 'admin_init', array( $this, 'register_lbk_fc_general_settings') );
            // add_action( 'init', array( $this, 'registerMetaboxes' ), 99 );
            // add_action( 'plugin_action_links_' . LBK_FC_BASE_NAME, array( $this, 'pluginActionLinks' ), 10, 2 );
            add_filter( 'plugin_action_links', array( $this, 'add_settings_link' ), 10, 2 );
        }

        /**
         * Register settings.
         * 
         * @access private
         * @since 1.0
         * @static
         */
        public function register_lbk_fc_general_settings() { 
            // Register all settings for general settings page 
            register_setting( 'lbk_fc_settings', 'lbk_fc_defaulf_socials' );
            register_setting( 'lbk_fc_settings', 'lbk_fc_setting_data' );

            $social_icons = [
                array(
                    'example' => '1507854875',
                    'placeholder' =>  'Phone number',
                    'help_title' => 'How do I use this?',
                    'help' => 'Enter your country code (in our example 1) and then your number without a leading zero (in our example 507854875)',
                    'slug' => 'Whatsapp',
                    'title' => 'WhatsApp',
                    'color' => '#49E670',
                    'url' => '',
                    'image' => 'whatsapp.svg', 
                ),
                array(
                    'example' => 'InstagramUsername',
                    'placeholder' => 'https://www.instagram.com/yourusername/',
                    'slug' => 'Instagram',
                    'title' => 'Instagram',
                    'color' => '#ffffff',
                    'url' => '',
                    'image' => 'instagram.svg'
                    
                ),
                 array(
                    'example' => 'https://m.me/Coca-Cola/',
                    'placeholder' =>'https://m.me/Coca-Cola/',
                    'slug' => 'Facebook_Messenger',
                    'title' => 'Facebook Messenger',
                    'color' => '#1E88E5',
                    'image' => 'messenger.svg',
                    'url' => '',
                ),
                 array(
                    'example' => 'myusername',
                    'placeholder' => 'User Name', 
                    'slug' => 'Telegram',
                    'title' => 'Telegram',
                    'color' => '#3E99D8',
                    'url' => '',
                    'image' => 'telegram.svg'
                ),
                array(
                    'example' => 'UserID',
                    'placeholder' => 'User Name',
                    'slug' => 'WeChat',
                    'title' => 'WeChat',
                    'color' => '#45DC00',
                    'url' => '',
                    'image' => 'wechat.svg'
                ),
                array(
                    'example' => 'MyTwitterHandle',
                    'placeholder' => 'Twitter',
                    'slug' => 'Twitter',
                    'title' => 'Twitter',
                    'color' => '#1ab2e8',
                    'image' => 'twitter.svg',
                    'url' => ''
                ),
                array(
                    'example' => 'https://goo.gl/maps/4m93C84v2DC2',
                    'placeholder' => 'Maps link',
                    'slug' => 'Google_Maps',
                    'title' => 'Google Map',
                    'color' => '#37AA66',
                    'url' => '',
                    'image' => 'maps.svg'
                ),
                array(
                    'example' => 'https://workspace.slack.com/',
                    'placeholder' => 'Slack',
                    'slug' => 'Slack',
                    'title' => 'Slack',
                    'color' => '#3f0e40',
                    'url' => '',
                    'image' => 'slack.svg'
                ),
                array(
                    'example' => '+1507854875',
                    'placeholder' => 'Phone number',
                    'help_title' => 'How do I use this?',
                    'help' => 'Enter your country code (in our example +1) and then your number without a leading zero (in our example 507854875)',
                    'slug' => 'Phone',
                    'title' => 'Phone',
                    'color' => '#03E78B',
                    'attr'  => 'phone-number',
                    'url'  => '',
                    'image' => 'phone.svg'
                ),
                array(
                    'example' => 'someone@example.com',
                    'placeholder' => 'Email',
                    'slug' => 'Email',
                    'title' => 'Email',
                    'color' => '#FF485F',
                    'url'  => '',
                    'image' => 'email.svg'
                ),
                array(
                    'example' => 'myusername',
                    'placeholder' => 'Skype',
                    'title' => 'Skype',
                    'slug' => 'Skype',
                    'color' => '#03A9F4',
                    'url' => '',
                    'image' => 'skype.svg'
                ),
                array(
                    'example' => 'myusername',
                    'placeholder' => 'Username',
                    'slug' => 'Snapchat',
                    'title' => 'Snapchat',
                    'color' => '#FFE81D',
                    'url' => '',
                    'image' => 'snapchat.svg'
                ),
                array(
                    'example' => '@TikTok_username',
                    'placeholder' => 'https://www.tiktok.com/@yourusername',
                    'slug' => 'TikTok',
                    'title' => 'TikTok',
                    'color' => '#000100',
                    'url' => '',
                    'image' => 'tiktok.svg'
                ),
                array(
                    'example' => '@TikTok_username',
                    'placeholder' => 'https://www.youtube.com/c/youtubeid',
                    'slug' => 'YouTube',
                    'title' => 'YouTube',
                    'color' => '#000100',
                    'url' => '',
                    'image' => 'youtube.svg'
                ),
            ];

            if( empty( get_option('lbk_fc_defaulf_socials') ) ) {
                update_option('lbk_fc_defaulf_socials', serialize($social_icons));
            }

            $fc_options = array(
                'list_socials' => array(),
                'fc_position' => 'right-bottom',
                'social_icon_size' => '35px',
                'toggle_icon_effect' => 'fade',
                'fc_trigger' => array(
                                 'state' => 'open',
                                 'delay' => array(
                                                    'status'=> false,
                                                    'time' => '5'
                                                ),
                                ),
                'disable_on_pages' => array()
            );
            if( empty( get_option('lbk_fc_setting_data') ) ) {
                update_option('lbk_fc_setting_data', serialize($fc_options));
            }
            
        }

        /**
         * Callback to add the settings link to the plugin action links.
         * 
         * @access private
         * @since 1.0
         * @static
         * 
         * @param $links
         * @param $file
         * 
         * @return array
         */
        public function pluginActionLinks( $links, $file ) {}
        
        /**
         * Register the scripts used in the admin
         * 
         * @access private
         * @since 1.0
         * @static
         */
        public function registerScripts() {
            wp_register_script( 'lbk_fc_admin_script', LBK_FC_URL . 'assets/js/admin.js', array( 'jquery', 'wp_color-picker' ), lbkFc::VERSION, true );
            wp_register_style( 'lbk_fc_admin_style', LBK_FC_URL . 'assets/css/admin.css', array( 'wp-color-picker' ), lbkFc::VERSION );
        }

        /**
         * Callback to add plugin as a submenu page of the Options page.
         * 
         * This also adds the action to enqueue the scripts to be loaded on plugin's admin page only.
         * 
         * @access private
         * @since 1.0
         * @static
         */
        public function menu() {
            $page = add_submenu_page( 
                'options-general.php',
                esc_html__( 'LBK Fixed Contact', 'lbk-fc' ),
                esc_html__( 'LBK Fixed Contact', 'lbk-fc' ),
                'manage_options',
                'lbk-fixed-contact',
                array( $this, 'page' )
            );

            add_action( 'admin_print_styles-' . $page, array( $this, 'enqueueScripts' ) );
        }

        /**
         * Enqueue the scripts.
         * 
         * @access private
         * @since 1.0
         * @static
         */
        public function enqueueScripts() {
            wp_enqueue_script( 'lbk_fc_admin_script' );
            wp_enqueue_style( 'lbk_fc_admin_style' );
        }

        /**
         * Callback used to render the admin options page.
         * 
         * @access private
         * @since 1.0
         * @static
         */
        public function page() {
            include LBK_FC_PATH . 'includes/inc.admin-options-page.php';
        }

        /**
         * Add a link to the settings page
         * 
         * @access public
         * @since 1.0
         * @static
         */
        public function add_settings_link( $links, $file ) {
            if (
                strrpos( $file, '/lbk-fixed-contact.php' ) === ( strlen( $file ) - 22 ) &&
                current_user_can( 'manage_options' )
            ) {
                $settings_link = sprintf( '<a href="%s">%s</a>', admin_url( 'options-general.php?page=lbk-fixed-contact' ), __( 'Settings', 'lbk-fc' ) );
                $links = (array) $links;
                $links['lbksvc_settings_link'] = $settings_link;
            }

            return $links;
        }
    }

    new lbkFc_Admin();
}