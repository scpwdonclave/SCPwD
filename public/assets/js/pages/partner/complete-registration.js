$(function() {
  $("#form_complete_registration").each(function() {
    // <- selects every <form> on page
    $(this).validate({
      // <- initialize validate() on each form
      rules: {
        terms: {
          required: function(elem) {
            return $("input.select:checked").length > 0;
          }
        }
      },
      highlight: function(input) {
        $(input)
          .parents(".form-line")
          .addClass("error");
      },
      unhighlight: function(input) {
        $(input)
          .parents(".form-line")
          .removeClass("error");
      },
      errorPlacement: function(error, element) {
        $(element)
          .parents(".form-group")
          .append(error);
      }
    });
  });
});
