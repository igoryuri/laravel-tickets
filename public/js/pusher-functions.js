var pusher = new Pusher('ae380c3a2d0583455cc6', {
    cluster: 'us2',
    encrypted: false
});
var channel = pusher.subscribe('new.ticket');
channel.bind('App\\Events\\NewTicket', callServer)

function callServer() {
    $('#btn_refresh').addClass('ani-pulse')
    $.ajax({
        url: "/bioclin/ajaxdata", success: function (test) {
            $("#table_refresh").html(test);
            $('#btn_refresh').removeClass('ani-pulse')
        }
    });
}