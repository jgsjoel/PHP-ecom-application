const myModal = new bootstrap.Modal(document.getElementById('chatModal'));
loadusers();

function loadusers(input, pid) {

    var input = document.getElementById("input").value;

    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var text = r.responseText;
            document.getElementById("userDetails").innerHTML = text;
            setpagination();
            statusChange();
            setchatFun();
        }
    };

    r.open("GET", "processes/manageusers/loadUsers.php?input=" + input + "&page_id=" + pid, true);
    r.send()
}

function setpagination() {

    var paginationBtns = document.getElementsByClassName("page-link");

    for (var x = 0; x < paginationBtns.length; x++) {

        paginationBtns[x].onclick = function(evt) {
            loadusers(input, evt.target.getAttribute('data-pageID'));
        }

    }

}

document.getElementById("search").onclick = function() {
    loadusers(document.getElementById("input").value);
}


function statusChange() {
    var btns = document.getElementsByClassName("block-unblock");

    for (var x = 0; x < btns.length; x++) {

        btns[x].onclick = function(evt) {

            var email = evt.target.closest("tr").getAttribute('data-email');

            var r = new XMLHttpRequest();
            r.onreadystatechange = function() {
                if (r.readyState == 4) {
                    var text = r.responseText;
                    if (text == "1") {
                        evt.target.classList.remove("btn-primary");
                        evt.target.classList.add("btn-success");
                        evt.target.innerText = "Unblock";
                    } else if (text == "2") {
                        evt.target.classList.remove("btn-success");
                        evt.target.classList.add("btn-primary");
                        evt.target.innerText = "Block";
                    } else {
                        alert(text);
                    }
                }
            };

            r.open("GET", "processes/manageusers/statusChange.php?email=" + email, true);
            r.send()

        }

    }
}

var clientEmail;

function setchatFun() {

    var chatBtns = document.querySelectorAll("#chatbtn");

    for (var x = 0; x < chatBtns.length; x++) {

        chatBtns[x].onclick = function(evt) {

            clientEmail = evt.target.closest("tr").getAttribute('data-email');
            myModal.show();
            setTimer();
        }

    }

}

document.getElementById("msgSend").onclick = function() {

    var form = new FormData();
    form.append("email", clientEmail);
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

    r.open("POST", "processes/message/adminChat.php", true);
    r.send(form);

}

function loadMessages() {

    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var text = r.responseText;
            document.getElementById("messageArea").innerHTML = text;
        }
    };

    r.open("GET", "processes/message/loadAdminChat.php?email=" + clientEmail, true);
    r.send();

}

function setTimer() {
    setInterval(loadMessages, 1000);
}