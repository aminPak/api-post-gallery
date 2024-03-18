jQuery(document).ready(function ($) {
  // Handle click events on post URLs to fetch and display post details in a modal.
  $(".apg-post-url").on("click", function () {
    var postId = $(this).data("api-post-id"); // Retrieve the post ID from the data attribute.

    // Perform an AJAX request to fetch the post details.
    $.ajax({
      url: apgAjax.ajaxurl,
      type: "POST",
      data: {
        action: "fetch_post_details",
        post_id: postId,
      },
      success: function (response) {
        if (response.success) {
          // Populate the modal with the post details
          $("#apgModal .apg-post-mdl-body").html(response.data.content);
          $("#apgModal .apg-post-mdl-slug").text(response.data.slug);
          $("#apgModal .apg-post-mdl-title").text(response.data.title);

          // Parse 'publishedAt' date from 'dd/mm/yyyy' format
          var dateParts = response.data.publishedAt.split("/"); // Split the date into parts
          var year = parseInt(dateParts[2], 10);
          var month = parseInt(dateParts[1], 10) - 1; // Subtract 1 because months are 0-indexed
          var day = parseInt(dateParts[0], 10);
          var publishedDate = new Date(year, month, day);

          // Note: The time will default to 00:00:00 in the local time zone

          // Format the date for display without time
          var options = { year: "numeric", month: "long", day: "numeric" };
          var formattedDate = publishedDate.toLocaleDateString(
            "en-US",
            options
          );

          $("#apgModal #apg-post-date").text(formattedDate);
          $("#apgModal #apg-post-cat").text(response.data.category);
          $("#apgModal .apg-post-mdl-img").attr("src", response.data.image);
          $("#apgModal .apg-post-mdl-img").attr("title", response.data.title);
          $("#apgModal .apg-post-mdl-img").attr("alt", response.data.title);
          $("body").addClass("no-scroll");
          $("#apgModal").fadeIn();
        } else {
          alert("Failed to fetch post details.");
        }
      },
    });
  });

  // Close modal functionality
  $(".apg-post-mdl-close").on("click", function (e) {
    e.stopPropagation();
    $("body").removeClass("no-scroll");
    $("#apgModal").fadeOut();
  });

  // Close modal when clicking outside of it
  $("#apgModal").on("click", function (e) {
    if (e.target !== this) return;
    $("body").removeClass("no-scroll");
    $(this).fadeOut();
  });
});
