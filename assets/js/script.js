/** @format */

jQuery(document).ready(function ($) {
  $("#show-unused-media-button").on("click", function (event) {
    // Prevent the default action (which may cause a page refresh)
    event.preventDefault();

    // Create a form to submit
    var form = $("<form>", {
      method: "POST",
      action: window.location.href, // Submit to the current page
    });

    // Add a hidden input to indicate the request
    form.append(
      $("<input>", {
        type: "hidden",
        name: "show_unused_media",
        value: "1",
      })
    );

    // Append the form to the body and submit it
    $("body").append(form);
    form.submit();
  });
});
