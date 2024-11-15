import $ from 'jquery';

$(document).ready(function() {
    const alerts = $('.fade-in');

    alerts.each(function() {
        const alert = $(this);

        setTimeout(function() {
            alert.removeClass('fade-in').addClass('fade-out');
        }, 2500);

        alert.on('animationend', function(event) {
            if (event.originalEvent.animationName === "fadeOut") {
                alert.remove();
            }
        });
    });
});