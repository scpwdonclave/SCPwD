$(function($) {
  $("form[id^='form_']").validate({
    rules: {
      spoc_mobile: { mobile: true },
      spoc_email: { email: true }
    }
  });

  $("form[id^='form_']").submit(function(e) {
    if ($("form[id^='form_']").valid()) {
      var btn = $("form[id^='form_']").find(":submit");
      btn.text("Please Wait ...").prop("disabled", true);
    }
  });
});
