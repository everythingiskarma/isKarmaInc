function clock() {
    var now = new Date();
    var h = now.getUTCHours();
    var m = now.getUTCMinutes();
    var s = now.getUTCSeconds();

    var ampm = h >= 12 ? 'PM' : 'AM';
    h = h % 12;
    h = h ? h : 12;

    h = (h < 10 ? '0' : '') + h;
    m = (m < 10 ? '0' : '') + m;
    s = (s < 10 ? '0' : '') + s;

    var time = h + ':' + m + ':' + s + ' ' + ampm + ' UTC';
    $("clock").text(time);
}

setInterval(clock, 1000);
clock();
