$(function () {
  /* To Remove Scrolling On number Fields  */
  $(document).on('wheel', 'input[type=number]', function (e) {
    $(this).blur()
  })
  /* End To Remove Scrolling On number Fields  */

  /* Form Validation */
  $("form[id^='form_']").each(function () {
    $(this).validate({
      rules: {
        terms: {
          required: function (elem) {
            return $('input.select:checked').length > 0
          }
        }
      },
      highlight: function (input) {
        $(input).parents('.form-line').addClass('error')
      },
      unhighlight: function (input) {
        $(input).parents('.form-line').removeClass('error')
      },
      errorPlacement: function (error, element) {
        $(element).parents('.form-group').append(error)
      }
    })
  })
  /* End Form Validation */

  /* Additional Methods for Validation  */

  jQuery.validator.addMethod(
    'pan',
    function (value, element) {
      return this.optional(element) || /^[A-Z]{5}\d{4}[A-Z]{1}$/.test(value)
    },
    'Please enter a valid PAN'
  )
  jQuery.validator.addMethod(
    'gst',
    function (value, element) {
      return (
        this.optional(element) ||
        /^([0-9]{2}[A-Z]{4}([A-Z]{1}|[0-9]{1})[0-9]{4}[A-Z]{1}([A-Z]|[0-9]){3}){0,15}$/.test(
          value
        )
      )
    },
    'Please enter a valid GST Number'
  )
  jQuery.validator.addMethod(
    'website',
    function (value, element) {
      return (
        this.optional(element) ||
        /^((https?|ftp|smtp):\/\/)?(www.)?[a-z0-9]+(\.[a-z]{2,}){1,3}(#?\/?[a-zA-Z0-9#]+)*\/?(\?[a-zA-Z0-9-_]+=[a-zA-Z0-9-%]+&?)?$/.test(
          value
        )
      )
    },
    'Please enter a valid Website url'
  )
  jQuery.validator.addMethod(
    'email',
    function (value, element) {
      return (
        this.optional(element) ||
        /^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i.test(value)
      )
    },
    'Please enter a valid Email'
  )
  jQuery.validator.addMethod(
    'pin',
    function (value, element) {
      return this.optional(element) || /^(\d{6})$/.test(value)
    },
    'Please enter a valid PIN Code'
  )
  jQuery.validator.addMethod(
    'mobile',
    function (value, element) {
      // return this.optional(element) || /^[6-9]\d{9}$/.test(value);
      // return this.optional(element) || /^\d*$/.test(value);
      // return this.optional(element) || /^\d{10,}$/.test(value);
      return this.optional(element) || /^[1-9]\d{9,11}?$/.test(value)
    },
    'Please enter a valid Contact number'
  )
  jQuery.validator.addMethod(
    'aadhaarvoter',
    function (value, element) {
      return (
        this.optional(element) ||
        /^([A-Z]){3}([0-9]){7}$|^(\d){12}$/.test(value)
      )
    },
    'Please enter a valid Aadhaar or Voter number'
  )
  jQuery.validator.addMethod(
    'aadhaar',
    function (value, element) {
      return this.optional(element) || /^\d{12}$/.test(value)
    },
    'Please enter a valid Aadhaar number'
  )
  jQuery.validator.addMethod(
    'voter',
    function (value, element) {
      return this.optional(element) || /^([A-Z]){3}([0-9]){7}$/.test(value)
    },
    'Please enter a valid Voter number'
  )
  jQuery.validator.addMethod(
    'time',
    function (value, element) {
      return (
        this.optional(element) ||
        /(1[0-2]|0?[1-9]):([0-5][05]) ?([AP][M])/.test(value)
      )
    },
    'Please enter a valid Time'
  )

  /* End Additional Methods for Validation  */
})
