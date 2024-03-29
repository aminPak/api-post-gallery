<?php

/**
 * Handles the rendering of posts fetched from an external API via a shortcode in WordPress.
 * This Renders the posts fetched from an external API as a slider
 * within a WordPress page through a shortcode. The shortcode [apg_posts] can be used to display
 * the posts in a slider format.
 *
 * @return string The HTML content to be displayed through the shortcode.
 */

function apg_render_posts_shortcode()
{
    $posts = fetch_api_posts(); // Fetch posts from the API.
    ob_start();

    if (!empty($posts)) {
        echo '<div class="apg-posts-slider">'; // Wrapper for the posts slider.
        echo '<div class="apg-posts-container">';

        foreach ($posts as $post) {
            // Extract the first 12 words from the post content for an excerpt.
            $words = explode(' ', strip_tags($post['content']));
            $excerpt = implode(' ', array_slice($words, 0, 12));

            // Format the post publication date.
            // Assuming $post['publishedAt'] is in the format "dd/mm/yyyy hh:mm:ss"
            $dateString = $post['publishedAt'];

            // Parse the date string according to its format
            $date = DateTime::createFromFormat('d/m/Y H:i:s', $dateString);

            // Check if the datetime was successfully parsed
            if ($date === false) {
                // Handle error: datetime parsing failed
                $formattedDate = "Invalid datetime format"; // Default or error message
            } else {
                // Success: Format the DateTime object as desired
                $formattedDate = $date->format('F j, Y');
            }


            // Construct the HTML for each post item.
            echo '<div class="apg-post-item">';
            echo '<div class="apg-carousel-thumbnail">';
            echo '<a href="#"  title="' . esc_html($post['title']) . '"data-api-post-id="' . esc_html($post['id']) . '">';
            echo '<img loading="lazy" decoding="async" src="' . esc_url($post['thumbnail']) . '" class="apg-thumbnail-img" alt="' . esc_attr($post['title']) . '" title="' . esc_attr($post['title']) . '">';
            echo '</a></div>';
            echo '<div class="apg-carousel-desc">';
            echo '<h4 class="apg-carousel-title"><a href="#" class="apg-post-url" title="' . esc_html($post['title']) . '"data-api-post-id="' . esc_html($post['id']) . '">' . esc_html($post['title']) . '</a></h4>';
            echo '<div class="apg-carousel-meta">';
            echo '<span class="apg-meta-item"><span>' . esc_html($formattedDate) . '</span></span>';
            echo '<span class="apg-meta-item"><span class="apg-meta-cat"> ' . esc_html($post['category']) . '</span></span>';
            echo '</div><div class="apg-carousel-excerpt">';
            echo '<p>' . esc_html($excerpt) . '...</p></div>';
            echo '<div class="cta-btn"><a href="#" class="apg-post-url apg-read-more" title="' . esc_html($post['title']) . '"data-api-post-id="' . esc_html($post['id']) . '">Read more <i aria-hidden="true" class="fas fa-chevron-right"></i></a></div>';
            echo '</div></div>';
        }

        // Slider navigation and progress bar.
        echo '</div><div class="progress"><div class="progress-bar"></div></div>';
        echo '<div class="apg-buttons"><button class="apg-slider-prev"><i class="fa-solid fa-arrow-left"></i></button>';
        echo '<button class="apg-slider-next"><i class="fa-solid fa-arrow-right"></i></button></div>';
        echo '</div>'; // Close the wrapper for the posts slider.
    }
?>
    <!-- Modal for displaying individual post details -->
    <div id="apgModal" class="apg-modal">
        <div class="apg-post-mdl-content">
            <span class="apg-post-mdl-close"><i class="fa-solid fa-xmark"></i></span>
            <div class="apg-post-mdl-meta"><span id="apg-post-date"></span><span id="apg-post-cat"></span></div>
            <img class="apg-post-mdl-img" loading="lazy" />
            <h2 class="apg-post-mdl-slug">Post Slug</h2>
            <h1 class="apg-post-mdl-title">Post Title</h1>
            <div class="apg-post-mdl-body">Post content...</div>
        </div>
    </div>

<?php

    return ob_get_clean();
}
add_shortcode('apg_posts', 'apg_render_posts_shortcode'); // Register the shortcode [apg_posts].