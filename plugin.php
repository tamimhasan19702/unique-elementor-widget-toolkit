<?php

namespace UniqueElementorToolkit;

use UniqueElementorToolkit\PageSettings\Page_Settings;
use UniqueElementorToolkit\Widgets\Unique_Button;
use UniqueElementorToolkit\Widgets\Unique_audio_player;


class Unique_Elementor_Widget_Toolkit
{
    private static $_instance = null;

    public function __construct()
    {

    }

    public static function instance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
            self::$_instance->init();
        }
        return self::$_instance;
    }

    public function init()
    {

        $this->include_files();

        // add actions
        add_action('elementor/frontend/after_register_scripts', [$this, 'widget_scripts']);
        add_action('elementor/widgets/register', [$this, 'register_widgets']);
        add_action('elementor/editor/after_enqueue_scripts', [$this, 'editor_scripts']);
        add_action('elementor/elements/categories_registered', [$this, 'register_category']);
        add_action('admin_enqueue_scripts', [$this, 'uewtk_react_enqueue_scripts']);
        add_action('admin_menu', [$this, 'uewtk_admin_menu']);
        // Register editor style.
        add_action('elementor/editor/after_enqueue_styles', array($this, 'editor_enqueue_styles'));



        // add filters
        add_filter('plugin_action_links_' . UEWTK_BASE, [$this, 'plugin_action_links']);
        add_filter('elementor/icons_manager/additional_tabs', [$this, 'uewtk_add_custom_icons_tab']);

        $this->add_page_settings_controls();
    }



    public function include_files()
    {
        require_once UEWTK_DIR_PATH . 'inc/uewtk_functions.php';

    }



    /**
     * Enqueue widget styles
     *
     * @since 1.0.0
     *
     * @access public
     */
    public function widget_scripts()
    {

        wp_enqueue_style('uewtk-icons', UEWTK_ASSETS . 'css/flaticon-uewtk.css', null, UEWTK_VERSION);
        wp_enqueue_style('uewtk-hover-effect', UEWTK_ASSETS . 'css/uewtk-hover.css', null, UEWTK_VERSION);

        // css
        wp_enqueue_style('uewtk-button-css', UEWTK_ASSETS . 'widgets-css/uewtk-button.css', null, UEWTK_VERSION);



        // js
        wp_enqueue_script('uewtk-button-js', UEWTK_ASSETS . 'widgets-js/uewtk-button.js', ['jquery'], UEWTK_VERSION, true);


    }

    public function editor_enqueue_styles()
    {
        wp_enqueue_style('uewtk-icons', UEWTK_ASSETS . 'css/flaticon-uewtk.css', null, UEWTK_VERSION);
        wp_enqueue_style('uewtk-editor-style', UEWTK_ASSETS . 'css/uewtk-editor.css', null, UEWTK_VERSION);
    }


    public function editor_scripts()
    {
        add_filter('script_loader_tag', [$this, 'editor_scripts_as_a_module'], 10, 2);

    }

    public function editor_scripts_as_a_module($tag, $handle)
    {
        if ('elementor-hello-world-editor' === $handle) {
            $tag = str_replace('<script', '<script type="module"', $tag);
        }
        return $tag;
    }

    public function register_widgets($widgets_manager)
    {


        require_once(__DIR__ . '/widgets/uewtk-button/uewtk-button.php');
        require_once(__DIR__ . '/widgets/uewtk-audio-player/uewtk-audio.player.php');




        $widgets_manager->register(new Unique_Button());
        $widgets_manager->register(new Unique_audio_player());


    }

    private function add_page_settings_controls()
    {
        require_once(__DIR__ . '/page-settings/manager.php');
        new Page_Settings();
    }

    public function register_category()
    {
        \Elementor\Plugin::instance()->elements_manager->add_category(
            'unique-elementor-widget-toolkit',
            [
                'title' => __('Unique Toolkit', 'unique-elementor-widget-toolkit'),
                'icon' => 'font',
                'position' => 2, // Set a low number to position it at the top
            ]
        );
    }

    public function uewtk_react_enqueue_scripts($hook)
    {
        $asset_file = plugin_dir_path(__FILE__) . 'build/index.asset.php';

        if (!file_exists($asset_file)) {
            return;
        }

        $asset = include $asset_file;

        wp_enqueue_script(
            'hello-react-script',
            plugins_url('build/index.js', __FILE__),
            $asset['dependencies'],
            $asset['version'],
            true
        );

        $css_handle = is_rtl() ? 'hello-react-style-rtl' : 'hello-react-style';
        $css_file = is_rtl() ? 'build/index-rtl.css' : 'build/index.css';
        wp_enqueue_style(
            $css_handle,
            plugins_url($css_file, __FILE__),
            array_filter(
                $asset['dependencies'],
                function ($style) {
                    return wp_style_is($style, 'registered');
                }
            ),
            $asset['version']
        );
    }

    public function uewtk_admin_menu()
    {
        add_menu_page(
            __('Unique Toolkit', 'unique-elementor-widget-toolkit'),
            'Unique Toolkit',
            'manage_options',
            'unique-elementor-widget-toolkit',
            [$this, 'uewtk_menu_page'],
            'dashicons-editor-underline',
            6
        );
    }

    public function uewtk_menu_page()
    {
        echo '<div id="root"></div>';
    }


    public function uewtk_add_custom_icons_tab($tabs = [])
    {
        $flat_icons = [
            'flaticon-concentration',
            'flaticon-sharing',
            'flaticon-diagonal',
            'flaticon-search',
            'flaticon-phone-book',
            'flaticon-menu',
            'flaticon-cooperation',
            'flaticon-connections',
            'flaticon-right-arrow',
            'flaticon-merging',
            'flaticon-quotes',
            'flaticon-next-button',
            'flaticon-geometric',
            'flaticon-geometric-1',
            'flaticon-geometric-2',
            'flaticon-geometric-3',
            'flaticon-geometric-4',
            'flaticon-triangle',
            'flaticon-geometric-5',
            'flaticon-3d-shapes',
            'flaticon-geometric-6',
            'flaticon-geometric-7',
            'flaticon-geometric-8',
            'flaticon-megaphone',
            'flaticon-idea',
            'flaticon-contract',
            'flaticon-idea-1',
            'flaticon-customer-feedback',
            'flaticon-solution',
            'flaticon-flag',
            'flaticon-telemarketer',
            'flaticon-networking',
            'flaticon-computer',
            'flaticon-vulnerability',
            'flaticon-half',
            'flaticon-map-location',
            'flaticon-chat',
            'flaticon-call',
            'flaticon-quotation-marks',
        ];

        $tabs['uewtk-custom-icons'] = [
            'name' => 'uewtk-custom-icons',
            'label' => esc_html__('UEWTK Custom Icons', 'unique-elementor-widget-toolkit'),
            'labelIcon' => 'flaticon-sharing',
            'prefix' => '',
            'displayPrefix' => 'uewtk-',
            'url' => plugins_url('/', __FILE__) . 'assets/css/flaticon-uewtk.css',
            'icons' => $flat_icons,
            'ver' => '1.0.0'
        ];
        return $tabs;
    }


    public function plugin_action_links($links)
    {
        $settings_link = '<a href="' . esc_url(admin_url('admin.php?page=unique-elementor-widget-toolkit')) . '">' . esc_html__('Settings', 'unique-elementor-widget-toolkit') . '</a>';
        array_unshift($links, $settings_link);
        return $links;
    }


}

// Instantiate Plugin Class
Unique_Elementor_Widget_Toolkit::instance();