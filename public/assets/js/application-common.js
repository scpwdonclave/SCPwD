/* Count Notification */
function countlevel() {
  if ($(".countli").length) {
    $("#label-count").html($(".countli").length);
  } else {
    $("#label-count").html("");
    $("#notification_header").remove();
  }
}

$(function() {
  countlevel();
});

/* End Count Notification */
