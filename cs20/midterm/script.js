function image_hover_listener() {
  img = $(".item > *:not(:hover)");

  $(document).ready(function () {
    img.mouseenter(function () {
      blur_and_display($(".item > *:not(:hover)"));
    });
    img.mouseleave(function () {
      img.removeAttr("style");
    });
  });
}

function blur_and_display(item) {
  item.css({ filter: "blur(4px)" });
  // item.blur()
}

image_hover_listener();
