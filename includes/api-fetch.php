<?php

/**
 * Fetches posts from an external API and caches the results.
 * 
 * This function attempts to retrieve a list of posts from a specified API endpoint. 
 * If the posts are already cached (stored in a WordPress transient), it returns the cached version to improve performance.
 * If not, it fetches fresh data from the API, caches it, and then returns the data.
 * 
 * @return array An array of posts fetched from the external API or an empty array on failure.
 */

function fetch_api_posts()
{
    $transient_key = 'apg_api_posts';
    $cached_posts = get_transient($transient_key);

    if ($cached_posts) {
        return $cached_posts;
    }

    $response = wp_remote_get('https://jsonplaceholder.org/posts');
    if (is_wp_error($response)) {
        return [];
    }

    $posts = json_decode(wp_remote_retrieve_body($response), true);
    // Cache the results for 12 hours to reduce API calls and improve site performance
    set_transient($transient_key, $posts, HOUR_IN_SECONDS * 12);

    return $posts;
}

//Fetches detailed information for a single post from an external API to show in a modal.
function apg_fetch_post_details()
{
    $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;
    $response = wp_remote_get('https://jsonplaceholder.org/posts/' . $post_id);

    if (is_wp_error($response)) {
        wp_send_json_error('Failed to fetch post details');
        return;
    }
    $post_details = json_decode(wp_remote_retrieve_body($response), true);

    if (!empty($post_details)) {
        wp_send_json_success($post_details); // Send the details to the client-side
    } else {
        wp_send_json_error('Post details are empty');
    }
}

add_action('wp_ajax_fetch_post_details', 'apg_fetch_post_details');
add_action('wp_ajax_nopriv_fetch_post_details', 'apg_fetch_post_details');

// Load Font Awesome to plugin if not loaded
function apg_check_font_awesome()
{
    $font_awesome_version = '6';

    // Check if Font Awesome handle is not already registered or enqueued
    if (!wp_style_is('apg-font-awesome', 'registered') && !wp_style_is('apg-font-awesome', 'enqueued')) {
        echo '<script src="https://kit.fontawesome.com/b53022b73f.js" crossorigin="anonymous"></script>';
    }
}
add_action('wp_enqueue_scripts', 'apg_check_font_awesome', 5); // Priority 5 to run early
