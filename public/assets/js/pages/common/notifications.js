function showNotification(
    type,
    text,
    placementFrom,
    placementAlign,
    animateEnter,
    animateExit,
    offsetx,
    offsety
  ) {
    $.notify(
      {
        message: text
      },
      {
        type: type,
        allow_dismiss: false,
        newest_on_top: true,
        delay: 2000,
        placement: {
          from: placementFrom,
          align: placementAlign
        },
        animate: {
          enter: "animated " + (animateEnter ? animateEnter : "fadeInUp"),
          exit: "animated " + (animateExit ? animateExit : "fadeOutDown")
        },
        offset: {
          x: offsetx ? offsetx : 25,
          y: offsety ? offsety : 25
        },
        template:
          '<div data-notify="container" class="text-center col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
          '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
          '<span data-notify="icon"></span> ' +
          '<span data-notify="title">{1}</span> ' +
          '<span data-notify="message">{2}</span>' +
          '<div class="progress" data-notify="progressbar">' +
          '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
          "</div>" +
          '<a href="{3}" target="{4}" data-notify="url"></a>' +
          "</div>"
      }
    );
  }
  