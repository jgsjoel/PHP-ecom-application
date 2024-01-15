loadWatchList();


function setpaginationFun() {

    var paginationBtns = document.getElementsByClassName('page-link');

    for (var x = 0; x < paginationBtns.length; x++) {

        paginationBtns[x].onclick = function(evt) {

            var product_id = evt.target.getAttribute('data-pageID');

            var r = new XMLHttpRequest();
            r.onreadystatechange = function() {
                if (r.readyState == 4) {
                    var text = r.responseText;
                    document.getElementById("items").innerHTML = text;
                    setpaginationFun();
                    setRemFunction();
                    addToCart();
                }
            };

            r.open("GET", "processes/watchlist/loadWatchlistItems.php?page_id=" + product_id, true);
            r.send();

        }

    }

}

function loadWatchList(id) {

    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var text = r.responseText;
            document.getElementById("items").innerHTML = text;
            setpaginationFun();
            setRemFunction();
            addToCart();
        }
    };

    r.open("GET", "processes/watchlist/loadWatchlistItems.php?page_id=" + id, true);
    r.send();
}

function setRemFunction() {

    var removeBtns = document.getElementsByClassName("RemBtn");

    for (var x = 0; x < removeBtns.length; x++) {

        removeBtns[x].onclick = function(evt) {
            var prodId = evt.target.closest('.card').getAttribute('data-prodId');

            var r = new XMLHttpRequest();
            r.onreadystatechange = function() {
                if (r.readyState == 4) {
                    var text = r.responseText;
                    if (text == "1") {
                        swal({
                            title: "Product has been removed",
                            icon: "success",
                            button: "Ok",
                        });
                        loadWatchList();
                    } else if (text == "2") {
                        window.location = "watchlist.php";
                    } else {
                        swal({
                            title: text,
                            icon: "warning",
                            button: "Ok",
                        });
                    }
                }
            };

            r.open("GET", "processes/watchlist/removefromWatchlist.php?pid=" + prodId, true);
            r.send();
        }

    }

}

function addToCart() {
    var addToCartBtns = document.getElementsByClassName("addTc");

    for (var x = 0; x < addToCartBtns.length; x++) {

        addToCartBtns[x].onclick = function(evt) {
            var prodId = evt.target.closest('.card').getAttribute('data-prodId');

            var r = new XMLHttpRequest();
            r.onreadystatechange = function() {
                if (r.readyState == 4) {
                    var text = r.responseText;
                    if (text == "1") {
                        window.location = "cart.php";
                    } else if (text == "2") {
                        swal({
                            title: "There was an error!",
                            icon: "error",
                            button: "Ok",
                        });
                    } else {
                        swal({
                            title: text,
                            icon: "warning",
                            button: "Ok",
                        });
                    }
                }
            };

            r.open("GET", "processes/cart/addToCart.process.php?pid=" + prodId, true);
            r.send();


        }

    }
}