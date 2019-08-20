
(function ($) {
    // "use strict";

        $("form[id^='form_']").submit(function(e){
        if ($("form[id^='form_']").valid()) {
            var btn = $("form[id^='form_']").find(':submit');
            btn.text('Please Wait ...').prop('disabled', true);
        }
        });
   
        $("form[id^='form_']").validate({
            rules: {
                // 'checkbox': {
                //     required: true
                // },
                // 'gender': {
                //     required: true
                // }
            },
            highlight: function (input) {
                $(input).parents('.form-line').addClass('error');
            },
            unhighlight: function (input) {
                $(input).parents('.form-line').removeClass('error');
            },
            errorPlacement: function (error, element) {
                $(element).parents('.form-group').append(error);
            }
        });
})(jQuery);