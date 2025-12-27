jQuery(function ($) {
  console.log("JS Loaded");

  // Select Image
  $(".defaimas-select").on("click", function (e) {
    e.preventDefault();

    const ptype = $(this).data("ptype");
    const input = $("#defaimas-input-" + ptype);
    const preview = $('.defaimas-preview[data-ptype="' + ptype + '"]');

    let frame = wp.media({
      title: "Select Default Featured Image",
      button: { text: "Use this image" },
      multiple: false,
    });

    frame.on("select", function () {
      const attachment = frame.state().get("selection").first().toJSON();
      input.val(attachment.id);

      const imgUrl =
        attachment.sizes && attachment.sizes.thumbnail
          ? attachment.sizes.thumbnail.url
          : attachment.url;

      preview.html(
        '<img src="' + imgUrl + '" style="max-width:100%; height:auto;">'
      );
    });

    frame.open();
  });

  $(document).on("click", ".defaimas-remove-image", function () {
    const ptype = $(this).data("ptype");
    const input = $("#defaimas-input-" + ptype);
    const preview = $('.defaimas-preview[data-ptype="' + ptype + '"]');

    input.val("");

    preview.animate({ opacity: 0 }, 200, function () {
      preview.html("<em>No Image</em>");
      preview.css("opacity", 0);

      preview.animate({ opacity: 1 }, 200);
    });
  });
});
