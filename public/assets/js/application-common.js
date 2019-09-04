/* Count Notification */

$(function() {
  if ($(".countli").length) {
    $("#label-count").html($(".countli").length);
  } else {
    $("#label-count").html();
  }
});

/* End Count Notification */
