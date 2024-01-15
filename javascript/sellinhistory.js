loadData();

document.getElementById("openFilter").onclick = function() {

    document.querySelector(".sh-search-filter").style.left = "0px";
    document.querySelector(".sh-search-filter").style.transition = "0.5s";
    document.body.style.overflow = "hidden";

}

document.getElementById("closeFilter").onclick = function() {
    document.querySelector(".sh-search-filter").style.left = "-300px";
    document.querySelector(".sh-search-filter").style.transition = "0.5s";
    document.body.style.overflow = "auto";
}

function loadData() {
    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var text = r.responseText;
            document.getElementById("History").innerHTML = text;
            setpagination();
            changeStatus();
            details();
        }
    }

    r.open("GET", "processes/sellingHistory/loadHistory.php", true);
    r.send();
}

function setpagination() {

    var paginationBtns = document.getElementsByClassName("page-link");

    for (var x = 0; x < paginationBtns.length; x++) {

        paginationBtns[x].onclick = function(evt) {
            var form = new FormData();
            form.append("from", document.getElementById("fromDate").value);
            form.append("to", document.getElementById("toDate").value);
            form.append("invoice", document.getElementById("invoice").value);
            form.append("page_id", evt.target.getAttribute("data-pageID"));

            var r = new XMLHttpRequest();
            r.onreadystatechange = function() {
                if (r.readyState == 4) {
                    var text = r.responseText;
                    document.getElementById("History").innerHTML = text;
                    setpagination();
                    changeStatus();
                    details();
                }
            }

            r.open("POST", "processes/sellingHistory/loadHistory.php", true);
            r.send(form);

        }

    }

}

document.getElementById("search").onclick = function() {

    // alert(document.getElementById("fromDate").value);

    var form = new FormData();
    form.append("from", document.getElementById("fromDate").value);
    form.append("to", document.getElementById("toDate").value);
    form.append("invoice", document.getElementById("invoice").value);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var text = r.responseText;
            document.getElementById("History").innerHTML = text;
            setpagination();
            changeStatus();
            details();
        }
    }

    r.open("POST", "processes/sellingHistory/loadHistory.php", true);
    r.send(form);

}

document.getElementById("clear").onclick = function() {
    document.getElementById("fromDate").value = "";
    document.getElementById("toDate").value = "";
    document.getElementById("invoice").value = "";
}

function changeStatus() {

    var statusSelectors = document.querySelectorAll("#status");

    for (var x = 0; x < statusSelectors.length; x++) {

        statusSelectors[x].onchange = function(evt) {
            var form = new FormData();
            form.append("oid", evt.target.closest(".row").getAttribute("data-invoice"));
            form.append("status", evt.target.value);

            var r = new XMLHttpRequest();
            r.onreadystatechange = function() {
                if (r.readyState == 4) {
                    var text = r.responseText;
                    if (text == "1") {
                        swal({
                            title: "Status Changed",
                            icon: "success",
                            button: "Ok",
                        });
                    } else {
                        swal({
                            title: text,
                            icon: "error",
                            button: "Ok",
                        });
                        // }
                    }
                }

            }

            r.open("POST", "processes/sellingHistory/changeStatus.php", true);
            r.send(form);

        }

    }
}

function details() {
    var detailBtns = document.querySelectorAll("#ItemDetails");

    for (var x = 0; x < detailBtns.length; x++) {

        detailBtns[x].onclick = function(evt) {
            window.open("adminInvoice.php?oid=" + evt.target.closest(".row").getAttribute("data-invoice"));
        }

    }
}