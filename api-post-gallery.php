<?php

/**
 * Plugin Name: API Post Gallery
 * Description: Fetches posts from an external API and displays them on a WordPress page
 * Version: 1.1.0
 * Author: Amin Pak
 * Author URI: https://aminpak.com/
 */


if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

define('APG_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('APG_PLUGIN_URL', plugin_dir_url(__FILE__));

require_once APG_PLUGIN_PATH . 'includes/api-fetch.php';
require_once APG_PLUGIN_PATH . 'includes/shortcode-functions.php';

/**
 * Enqueues plugin-specific styles and scripts.
 * 
 * This function handles the inclusion of the plugin's CSS and JavaScript files, ensuring they are loaded on the WordPress site. 
 * It includes the Slick Slider library for carousel features and the plugin's custom styling and functionality.
 */
function apg_enqueue_assets()
{
    // Enqueue custom plugin styles
    wp_enqueue_style('apg-styles', APG_PLUGIN_URL . 'assets/css/style.css', array(), '1.0');

    // Enqueue Slick Slider CSS
    wp_enqueue_style('slick-css', APG_PLUGIN_URL . 'assets/css/slick.min.css', array(), '1.0');
    wp_enqueue_style('slick-theme-css', APG_PLUGIN_URL . 'assets/css/slick-theme.min.css', array(), '1.0');

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
