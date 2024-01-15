var inputPara;
var catePara;
window.onload = function() {
    var url = new URL(window.location.href);
    var searchInput = url.searchParams.get("input");
    var searchCategory = url.searchParams.get("category");
    inputPara = searchInput;
    catePara = searchCategory;
    LoadItems();
}

document.getElementById("openFilter").onclick = function(evt) {
    document.querySelector(".search-filter").style.left = "0px";
    document.querySelector(".search-filter").style.transition = "0.5s";
    document.body.style.overflow = "hidden";
}

document.getElementById("closeFilter").addEventListener("click", function() {
    document.querySelector(".search-filter").style.left = "-300px";
    document.querySelector(".search-filter").style.transition = "0.5s";
    document.body.style.overflow = "auto";
});

document.getElementById("clear").onclick = function() {
    document.getElementById("pricehigh").checked = false;
    document.getElementById("pricelow").checked = false;
    document.getElementById("from").value = "";
    document.getElementById("to").value = "";
}

function LoadItems(pid) {

    var priceHTL;
    if (document.getElementById("pricehigh").checked) {
        priceHTL = 1;
    } else if (document.getElementById("pricelow").checked) {
        priceHTL = 2;
    }

    var from = document.getElementById("from").value;
    var to = document.getElementById("to").value;

    var form = new FormData();
    form.append("priceHTL", priceHTL);
    form.append("from", from);
    form.append("to", to);
    form.append("input", inputPara);
    form.append("category", catePara);
    form.append("page_id", pid);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var text = r.responseText;
            document.getElementById("products").innerHTML = text;
            addtoCart();
            addtowatchlist();
            setpaginationFun();
        }
    };

    r.open("POST", "processes/search/searchFilter.php", true);
    r.send(form);

}

document.getElementById("filter").onclick = function() {
    LoadItems();
}

function addtowatchlist() {

    var watchBtns = document.getElementsByClassName("atwl");

    for (var x = 0; x < watchBtns.length; x++) {

        watchBtns[x].onclick = function(evt) {

            var productId = evt.target.closest('.card').getAttribute('data-prodId');

            var r = new XMLHttpRequest();
            r.onreadystatechange = function() {
                if (r.readyState == 4) {
                    var text = r.responseText;
                    if (text == "1") {
                        alert("Successfully added");
                    } else {
                        alert(text);
                    }
                }
            };

            r.open("GET", "processes/watchlist/addtowatchlist.php?pid=" + productId, true);
            r.send();


        }


    }

}

function addtoCart() {

    var cartBtns = document.getElementsByClassName("atcrt");

    for (var x = 0; x < cartBtns.length; x++) {

        cartBtns[x].onclick = function(evt) {

            var productId = evt.target.closest('.card').getAttribute('data-prodId');

            var r = new XMLHttpRequest();
            r.onreadystatechange = function() {
                if (r.readyState == 4) {
                    var text = r.responseText;
                    if (text == "1") {
                        window.location = "cart.php";
                    } else if (text == "2") {
                        alert("There was an error!");
                    } else {
                        alert(text);
                    }
                }
            };

            r.open("GET", "processes/cart/addToCart.process.php?pid=" + productId, true);
            r.send();

        }


    }


}

function setpaginationFun() {

    var paginationBtns = document.getElementsByClassName('page-link');

    for (var x = 0; x < paginationBtns.length; x++) {

        paginationBtns[x].onclick = function(evt) {
            LoadItems(evt.target.getAttribute('data-pageID'));
        }

    }

}