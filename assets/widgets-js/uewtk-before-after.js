/** @format */

jQuery(document).ready(function ($) {
  // Initialize slider
  const container = $(".uewtk-compare-container");
  const handle = container.find(".uewtk-compare-handle");
  const beforeImg = container.find(".uewtk-compare-before");
  const afterImg = container.find(".uewtk-compare-after");
  const labels = container.find(".uewtk-compare-overlay");
  let isDragging = false;

  // Set initial positions
  const containerWidth = container.width();
  const containerHeight = container.height();
  const initialPosition = containerWidth / 2;

  // Initialize both images
  handle.css("left", initialPosition + "px");
  beforeImg.css(
    "clip",
    `rect(0px, ${initialPosition}px, ${containerHeight}px, 0px)`
  );
  afterImg.css(
    "clip",
    `rect(0px, ${containerWidth}px, ${containerHeight}px, ${initialPosition}px)`
  );

  // Mouse events
  handle.on("mousedown touchstart", function (e) {
    isDragging = true;
    container.addClass("active");
    e.preventDefault();
  });

  $(document)
    .on("mousemove touchmove", function (e) {
      if (!isDragging) return;

      // Get dimensions
      const currentWidth = container.width();
      const currentHeight = container.height();
      const containerOffset = container.offset().left;

      // Calculate position
      const mouseX =
        (e.pageX || e.originalEvent.touches[0].pageX) - containerOffset;
      const newPosition = Math.max(0, Math.min(mouseX, currentWidth));

      // Update elements
      handle.css("left", newPosition + "px");
      beforeImg.css(
        "clip",
        `rect(0px, ${newPosition}px, ${currentHeight}px, 0px)`
      );
      afterImg.css(
        "clip",
        `rect(0px, ${currentWidth}px, ${currentHeight}px, ${newPosition}px)`
      );

      // Update labels
      labels.css(
        "background-color",
        mouseX > currentWidth / 2
          ? "rgba(0, 0, 0, 0.3)"
          : "rgba(54, 52, 52, 0.3)"
      );
    })
    .on("mouseup touchend", function () {
      isDragging = false;
      container.removeClass("active");
    });

  // Handle window resize
  $(window).on("resize", function () {
    const currentWidth = container.width();
    const currentHeight = container.height();
    const currentPosition = parseInt(handle.css("left"));

    handle.css("left", Math.min(currentPosition, currentWidth) + "px");
    beforeImg.css(
      "clip",
      `rect(0px, ${Math.min(
        currentPosition,
        currentWidth
      )}px, ${currentHeight}px, 0px)`
    );
    afterImg.css(
      "clip",
      `rect(0px, ${currentWidth}px, ${currentHeight}px, ${Math.min(
        currentPosition,
        currentWidth
      )}px)`
    );
  });
});
