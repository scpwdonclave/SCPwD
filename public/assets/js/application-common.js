/* Count Notification */
function countlevel() {
  if ($(".countli").length) {
    $("#label-count").html($(".countli").length);
  } else {
    $("#label-count").html("");
    $("#notification_header").remove();
  }
  // console.log($(".countli").length);
}

$(function() {
  countlevel();
});

/* End Count Notification */
