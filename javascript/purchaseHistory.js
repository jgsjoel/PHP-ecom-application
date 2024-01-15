const myModal = new bootstrap.Modal(document.getElementById('FeedbaclModal'));

loadItems();

document.getElementById("openFilter").onclick = function() {

    document.querySelector(".search-filter").style.left = "0px";
    document.querySelector(".search-filter").style.transition = "0.5s";
    document.body.style.overflow = "hidden";

}

document.getElementById("closeFilter").onclick = function() {
    document.querySelector(".search-filter").style.left = "-300px";
    document.querySelector(".search-filter").style.transition = "0.5s";
    document.body.style.overflow = "auto";
}

function loadItems() {

    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var text = r.responseText;
            document.getElementById("History").innerHTML = text;
            setpaginationFun();
            addfeedbackFunct();
        }
    }

    r.open("GET", "processes/purchaseHistory/loadDetails.php", true);
    r.send();
}

document.getElementById("search").onclick = function() {

    var form = new FormData();
    form.append("oid", document.getElementById("invoice").value);
    form.append("date", document.getElementById("date").value);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var text = r.responseText;
            document.getElementById("History").innerHTML = text;
            setpaginationFun();
            addfeedbackFunct();
        }
    }

    r.open("POST", "processes/purchaseHistory/loadDetails.php", true);
    r.send(form);

}

function setpaginationFun() {

    var paginationBtns = document.getElementsByClassName('page-link');

    for (var x = 0; x < paginationBtns.length; x++) {

        paginationBtns[x].onclick = function(evt) {

            var form = new FormData();
            form.append("oid", document.getElementById("invoice").value);
            form.append("date", document.getElementById("date").value);
            form.append("page_id", evt.target.getAttribute("data-pageID"));

            var r = new XMLHttpRequest();
            r.onreadystatechange = function() {
                if (r.readyState == 4) {
                    var text = r.responseText;
                    document.getElementById("History").innerHTML = text;
                    setpaginationFun();
                    addfeedbackFunct();
                }
            }

            r.open("POST", "processes/purchaseHistory/loadDetails.php", true);
            r.send(form);

        }

    }

}

document.getElementById("clear").onclick = function() {
    document.getElementById("invoice").value = "";
    document.getElementById("date").selectedIndex = "0";
    loadItems();
}

var prod_id;

function addfeedbackFunct() {

    var feedbackBtns = document.querySelectorAll(".feedback");

    for (var x = 0; x < feedbackBtns.length; x++) {

        feedbackBtns[x].onclick = function(evt) {
            var pid = evt.target.closest(".card").getAttribute("data-prodId");
            prod_id = pid;
            myModal.show();
        }

    }

}

document.getElementById("saveFeedback").onclick = function() {

    var form = new FormData();
    form.append("pid", prod_id);
    form.append("feedback", document.getElementById("feedbackMsg").value);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var text = r.responseText;
            if (text == "1") {
                swal({
                        title: "Update Complete.",
                        icon: "success",
                        button: "Ok",
                    })
                    .then(() => {
                        myModal.hide();
                    });
            } else {
                swal({
                    title: text,
                    icon: "error",
                    button: "Ok",
                });
            }
        }
    }

    r.open("POST", "processes/purchaseHistory/saveFeedback.php", true);
    r.send(form);


}