function dashboard() {
    setInterval(timer, 1000)
}

function timer() {

    var r = new XMLHttpRequest();

    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var text = r.responseText;
            document.getElementById("timer").innerHTML = text;
        }
    };

    r.open("GET", "processes/admin/timer.php", true);
    r.send();

}