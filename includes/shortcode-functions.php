<?php

/**
 * Handles the rendering of posts fetched from an external API via a shortcode in WordPress.
 * 
 * This file contains functions responsible for fetching posts from an external API and rendering
 * them within a WordPress page through a shortcode. The shortcode [apg_posts] can be used to display
 * the posts in a slider format.
 */

/**
 * Renders the posts fetched from an external API as a slider.
 * 
 * This function outputs HTML markup for displaying posts as a slider on the front end. It makes use of
 * transient caching to store the fetched posts temporarily to reduce load times and API calls.
 * 
 * @return string The HTML content to be displayed through the shortcode.
 */
function apg_render_posts_shortcode()
{
    $posts = fetch_api_posts(); // Fetch posts from the API.
    ob_start();

    if (!empty($posts)) {
        echo '<div class="apg-posts-slider">'; // Wrapper for the posts slider.
        echo '<div class="apg-posts-container">'; // Container for individual posts.

        foreach ($posts as $post) {
            // Extract the first 15 words from the post content for an excerpt.
            $words = explode(' ', strip_tags($post['content']));
            $excerpt = implode(' ', array_slice($words, 0, 15));

            // Format the post publication date.
            $timestamp = strtotime($post['publishedAt']);
            $formattedDate = date('F j, Y', $timestamp);

            // Construct the HTML for each post item.
            echo '<div class="apg-post-item">';
            echo '<div class="apg-carousel-thumbnail">';
            echo '<a href="' . esc_url($post['url']) . '" title="' . esc_attr($post['title']) . '" target="_blank">';
            echo '<img loading="lazy" decoding="async" src="' . esc_url($post['thumbnail']) . '" class="apg-thumbnail-img" alt="' . esc_attr($post['title']) . '">';
            echo '</a></div>';
            echo '<div class="apg-carousel-desc">';
            echo '<h4 class="apg-carousel-title"><a href="' . esc_url($post['url']) . '" title="' . esc_attr($post['title']) . '" target="_blank">' . esc_html($post['title']) . '</a></h4>';
            echo '<div class="apg-carousel-meta">';
            echo '<span class="apg-meta-item"><span>' . esc_html($formattedDate) . '</span></span>';
            echo '<span class="apg-meta-item"><span> | ' . esc_html($post['category']) . '</span></span>';
            echo '</div><div class="apg-carousel-excerpt">';
            echo '<p>' . esc_html($excerpt) . '...</p></div>';
            echo '<div class="cta-btn"><a href="' . esc_url($post['url']) . '" class="apg-read-more" target="_blank">Read more <span class="dashicons dashicons-arrow-right-alt2"></span></a></div>';
            echo '</div></div>';
        }

        // Slider navigation and progress bar.
        echo '</div><div class="progress"><div class="progress-bar"></div></div>';
        echo '<div class="apg-buttons"><button class="apg-slider-prev"><span class="dashicons dashicons-arrow-left-alt"></span></button>';
        echo '<button class="apg-slider-next"><span class="dashicons dashicons-arrow-right-alt"></span></button></div>';
        echo '</div>'; // Close the wrapper for the posts slider.
    }

    return ob_get_clean();
}
add_shortcode('apg_posts', 'apg_render_posts_shortcode'); // Register the shortcode [apg_posts].
