LoadItems();

document.getElementById("reset").onclick = function() {

    document.getElementById("input").value = "";
    document.getElementById("category").value = 0;
    document.getElementById("brand").value = 0;
    document.getElementById("model").value = 0;
    document.getElementById("color").value = 0;
    document.getElementById("condition").value = 0;
    LoadItems();

}

function LoadItems(pid) {

    var form = new FormData();
    form.append("category", document.getElementById("category").value);
    form.append("brand", document.getElementById("brand").value);
    form.append("model", document.getElementById("model").value);
    form.append("color", document.getElementById("color").value);
    form.append("condition", document.getElementById("condition").value);
    form.append("input", document.getElementById("input").value);
    form.append("sort", document.getElementById("sort").value);
    form.append("page_id", pid);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var text = r.responseText;
            document.getElementById("products").innerHTML = text
            setpaginationFun();
            addtowatchlist();
            addtoCart();
        }
    };

    r.open("POST", "processes/advancedSearch/loadItems.php", true);
    r.send(form);

}

document.getElementById("search").onclick = function() {
    LoadItems();
}

function setpaginationFun() {

    var paginationBtns = document.getElementsByClassName('page-link');

    for (var x = 0; x < paginationBtns.length; x++) {

        paginationBtns[x].onclick = function(evt) {
            LoadItems(evt.target.getAttribute('data-pageID'));
        }

    }

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