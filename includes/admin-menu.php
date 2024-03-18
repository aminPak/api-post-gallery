<?php

/**
 * Adds an admin menu page for the plugin.
 */
function apg_add_admin_menu()
{
    add_menu_page(
        __('API Post Gallery Instructions', 'api-post-gallery'), // Page title
        __('APG Instructions', 'api-post-gallery'), // Menu title
        'manage_options', // Capability
        'apg-instructions', // Menu slug
        'apg_instructions_page_html', // Callback function
        'dashicons-slides', // Icon URL
        6 // Position
    );
}
add_action('admin_menu', 'apg_add_admin_menu');

/**
 * Displays the plugin instructions in the admin menu page.
 */
function apg_instructions_page_html()
{
    // Check user capabilities
    if (!current_user_can('manage_options')) {
        return;
    }

    // Output the settings page content
?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        <p><?php _e('Welcome to the API Post Gallery Plugin!', 'api-post-gallery'); ?></p>
        <p><?php _e("Here's how to use this plugin:", 'api-post-gallery'); ?></p>
        <ol>
            <li><?php _e('Navigate to the posts, pages, or widgets where you want to display the post gallery.', 'api-post-gallery'); ?></li>
            <li><?php _e('Insert the [apg_posts] shortcode in your desired location.', 'api-post-gallery'); ?></li>
        </ol>
        <p><?php _e('For more information and customization options, please visit our <a href="https://github.com/aminPak/api-post-gallery">documentation</a>.', 'api-post-gallery'); ?></p>
    </div>
<?php
}
