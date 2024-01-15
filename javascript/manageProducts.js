getData();

document.getElementById("openFilter").addEventListener("click", function() {
    document.querySelector(".side-navigator").style.left = "0px";
    document.querySelector(".side-navigator").style.transition = "0.5s";
    document.body.style.overflow = "hidden";
});

document.getElementById("closeFilter").addEventListener("click", function() {
    document.querySelector(".side-navigator").style.left = "-300px";
    document.querySelector(".side-navigator").style.transition = "0.5s";
    document.body.style.overflow = "auto";
});

document.getElementById("clear").addEventListener('click', function() {

    document.getElementById("searchInput").value = "";
    document.getElementById("priceLow").checked = false;
    document.getElementById("priceHigh").checked = false;
    document.getElementById("active").checked = false;
    document.getElementById("deactive").checked = false;
    document.getElementById("new").checked = false;
    document.getElementById("used").checked = false;
    document.getElementById("instock").checked = false;
    document.getElementById("outofstock").checked = false;

});

function getFilters() {
    var price;
    var status;
    var condition;
    var availability;

    if (document.getElementById("priceLow").checked == true) {
        price = 1;
    } else if (document.getElementById("priceHigh").checked == true) {
        price = 2;
    }

    if (document.getElementById("active").checked == true) {
        status = 1;
    } else if (document.getElementById("deactive").checked == true) {
        status = 2;
    }

    if (document.getElementById("new").checked == true) {
        condition = 1;
    } else if (document.getElementById("used").checked == true) {
        condition = 2;
    }

    if (document.getElementById("instock").checked == true) {
        availability = 1;
    } else if (document.getElementById("outofstock").checked == true) {
        availability = 2;
    }

    var form = new FormData();
    form.append("price", price);
    form.append("status", status);
    form.append("condition", condition);
    form.append("availability", availability);
    form.append("input", document.getElementById("searchInput").value);

    return form;
}


function getData(page_id) {

    var form = getFilters();
    form.append("page_id", page_id);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var text = r.responseText;
            document.getElementById("productData").innerHTML = text;
            pagination();
        }
    };

    r.open("POST", "processes/manageProducts/manageproducts.process.php", true);
    r.send(form);

}

document.getElementById("search").addEventListener('click', function() {

    getData();

});

function deactivate(id) {

    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var text = r.responseText;
            if (text == "1") {
                document.getElementById("statuslable" + id).innerText = "Active";
            } else if (text == "2") {
                document.getElementById("statuslable" + id).innerText = "Deactive";
            }

        }
    };

    r.open("GET", "processes/manageProducts/deactivateProduct.process.php?id=" + id, true);
    r.send();

}

function pagination() {
    var paginationBtns = document.getElementsByClassName("page-link");

    for (var x = 0; x < paginationBtns.length; x++) {

        paginationBtns[x].onclick = function(evt) {

            var pid = evt.target.getAttribute("data-pageId");

            getData(pid);

        }

    }
}