<?php

/**
 * @package     API_Post_Gallery
 * Plugin Name: API Post Gallery
 * Description: Fetches posts from an external API and displays them on a WordPress page
 * Version: 1.2.0
 * Author: Amin Pak
 * Author URI: https://aminpak.com/
 * Text Domain: api-post-gallery
 * License: GNU GENERAL PUBLIC LICENSE  Version 3
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 */
define('API_POST_GALLERY_VERSION', '1.2.0');
define('APG_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('APG_PLUGIN_URL', plugin_dir_url(__FILE__));

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-api-post-gallery-activator.php
 */
function activate_api_post_gallery()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-api-post-gallery-activator.php';
    API_Post_Gallery_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-api-post-gallery-deactivator.php
 */
function deactivate_api_post_gallery()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-api-post-gallery-deactivator.php';
    API_Post_Gallery_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_api_post_gallery');
register_deactivation_hook(__FILE__, 'deactivate_api_post_gallery');

/**
 * Includes the necessary plugin files for specific functionalities:
 * - api-fetch.php: Handles the retrieval of post data from the API endpoint.
 * - shortcode-functions.php: Manages the structuring and registration of the shortcode for displaying posts.
 * - admin-menu.php: Code for admin menu.
 */

require_once APG_PLUGIN_PATH . 'includes/api-fetch.php';
require_once APG_PLUGIN_PATH . 'includes/shortcode-functions.php';
require_once APG_PLUGIN_PATH . 'includes/admin-menu.php';

/**
 * Enqueues plugin-specific styles and scripts.
 * 
 * This function handles the inclusion of the plugin's CSS and JavaScript files, ensuring they are loaded on the WordPress site. 
 * It includes the Slick Slider library for carousel features and the plugin's custom styling and functionality.
 */
function apg_enqueue_assets()
{
    // Enqueue Slick Slider CSS
    wp_enqueue_style('slick-css', APG_PLUGIN_URL . 'assets/css/slick.min.css', array(), '1.0');

    // Enqueue custom plugin styles
    wp_enqueue_style('apg-styles', APG_PLUGIN_URL . 'assets/css/style.css', array(), '1.0');

    // Enqueue Slick Slider and custom plugin JavaScript with jQuery dependency
    wp_enqueue_script('slick-js', APG_PLUGIN_URL . 'assets/js/slick.min.js', array('jquery'), '1.0', true);
    wp_enqueue_script('apg-script', APG_PLUGIN_URL . 'assets/js/script.js', array('jquery'), '1.0', true);

    // Enqueue AJAX javascript codes
    wp_enqueue_script('apg-ajax-script', APG_PLUGIN_URL . 'assets/js/apg-ajax.js', array('jquery'), null, true);
    wp_localize_script('apg-ajax-script', 'apgAjax', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('apg_nonce'),
    ));
}
add_action('wp_enqueue_scripts', 'apg_enqueue_assets');
