$(function() {
  /* To Remove Scrolling On number Fields  */
  $(document).on("wheel", "input[type=number]", function(e) {
    $(this).blur();
  });
  /* End To Remove Scrolling On number Fields  */

  /* Form Validation */
  $("form[id^='form_']").each(function() {
    $(this).validate({
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
  /* End Form Validation */

  /* Additional Methods for Validation  */

  jQuery.validator.addMethod(
    "pan",
    function(value, element) {
      return this.optional(element) || /^[A-Z]{5}\d{4}[A-Z]{1}$/.test(value);
    },
    "Please enter a valid PAN"
  );
  jQuery.validator.addMethod(
    "gst",
    function(value, element) {
      return (
        this.optional(element) ||
        /^([0-9]{2}[A-Z]{4}([A-Z]{1}|[0-9]{1})[0-9]{4}[A-Z]{1}([A-Z]|[0-9]){3}){0,15}$/.test(
          value
        )
      );
    },
    "Please enter a valid GST Number"
  );
  jQuery.validator.addMethod(
    "website",
    function(value, element) {
      return (
        this.optional(element) ||
        /^((https?|ftp|smtp):\/\/)?(www.)?[a-z0-9]+\.[a-z]+(\/[a-zA-Z0-9#]+\/?)*$/.test(
          value
        )
      );
    },
    "Please enter a valid Website url"
  );
  jQuery.validator.addMethod(
    "email",
    function(value, element) {
      return (
        this.optional(element) ||
        /^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i.test(value)
      );
    },
    "Please enter a valid Email"
  );
  jQuery.validator.addMethod(
    "pin",
    function(value, element) {
      return this.optional(element) || /^(\d{6})$/.test(value);
    },
    "Please enter a valid PIN Code"
  );
  jQuery.validator.addMethod(
    "mobile",
    function(value, element) {
      return this.optional(element) || /^[6-9]\d{9}$/.test(value);
    },
    "Please enter a valid Mobile Number"
  );
  jQuery.validator.addMethod(
    "votar",
    function(value, element) {
      return this.optional(element) || /^([a-zA-Z]){3}([0-9]){7}?$/.test(value);
    },
    "Please enter a valid Votar ID"
  );
  jQuery.validator.addMethod(
    "aadhar",
    function(value, element) {
      return this.optional(element) || /^\d{12}$/.test(value);
    },
    "Please enter a valid Aadhar Number"
  );

  /* End Additional Methods for Validation  */
});
