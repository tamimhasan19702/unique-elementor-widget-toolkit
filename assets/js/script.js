/** @format */

jQuery(document).ready(function ($) {
  $("#mark-unused-images-button").on("click", function (event) {
    // Prevent the default action (which may cause a page refresh)
    event.preventDefault();

    // Toggle the background color of .author-self elements within .wp-list-table.media
    $(".wp-list-table.media .author-self").each(function () {
      // Check the current background color
      if ($(this).css("background-color") === "rgba(255, 0, 0, 0.1)") {
        // If it's already red, remove the background color
        $(this).css("background-color", "");
      } else {
        // If it's not red, set the background color to subtle red
        $(this).css("background-color", "rgba(255, 0, 0, 0.1)");
      }
    });

    // Optional: Log the action for debugging
    console.log("Mark Unused Images button clicked");
  });
});
