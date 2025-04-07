/** @format */

(function ($) {
  
  $(document).ready(function () {
    $(".bubbly-button").click(function (e) {
      e.preventDefault();
      $(this).removeClass("animate");
      $(this).addClass("animate");
      setTimeout(
        function () {
          $(this).removeClass("animate");
        }.bind(this),
        700
      );
    });
  });
})(jQuery);
