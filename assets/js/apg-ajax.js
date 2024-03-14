jQuery(document).ready(function($) {
    // Handle click events on post URLs to fetch and display post details in a modal.
    $('.apg-post-url').on('click', function() {
        
        var postId = $(this).data('api-post-id');// Retrieve the post ID from the data attribute.

        // Perform an AJAX request to fetch the post details.
        $.ajax({
            url: apgAjax.ajaxurl,
            type: 'POST',
            data: {
                action: 'fetch_post_details',
                post_id: postId,
            },
            success: function(response) {
                if (response.success) {
                    // Populate the modal with the post details
                    $('#apgModal .apg-post-mdl-body').html(response.data.content);
                    $('#apgModal .apg-post-mdl-slug').text(response.data.slug);
                    $('#apgModal .apg-post-mdl-title').text(response.data.title);
                    $('#apgModal #apg-post-date').text(response.data.publishedAt);
                    $('#apgModal #apg-post-cat').text(response.data.category);
                    $('#apgModal .apg-post-mdl-img').attr('src', response.data.image);
                    $('#apgModal .apg-post-mdl-img').attr('title', response.data.title);
                    $('body').addClass('no-scroll');
                    $('#apgModal').fadeIn();
                } else {
                    alert('Failed to fetch post details.');
                }
            }
        });
    });

    // Close modal functionality
    $('.apg-post-mdl-close, #apgModal').on('click', function(e) {
        if (e.target !== this) return;
        $('body').removeClass('no-scroll');
        $('#apgModal').fadeOut();
    });
});
