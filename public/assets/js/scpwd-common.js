$(function(){

    /* To Remove Scrolling On number Fields  */
    $(document).on("wheel", "input[type=number]", function (e) {
        $(this).blur();
    });
    /* End To Remove Scrolling On number Fields  */

});