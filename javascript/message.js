const myModal = new bootstrap.Modal(document.getElementById('clientChatModal'));

document.getElementById("openChat").onclick = function() {

    myModal.show();
    setTimer();

}

document.getElementById("msgSend").onclick = function() {

    var form = new FormData();
    form.append("msg", document.getElementById("msgInput").value);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var text = r.responseText;
            if (text == "1") {
                loadMessages();
            }
        }
    };

    r.open("POST", "processes/message/customerProcess.php", true);
    r.send(form);

}

function loadMessages() {

    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var text = r.responseText;
            document.getElementById("chatSection").innerHTML = text;
        }
    };

    r.open("GET", "processes/message/loadCostomerChat.php", true);
    r.send();

}

function setTimer() {
    setInterval(loadMessages, 1000);
}