addtowatchlist();
addtoCart();

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
                        swal({
                            title: "There was an error!",
                            icon: "error",
                            button: "Ok",
                        });
                    } else if (text == "3") {
                        swal({
                            title: "Please login to your account first",
                            icon: "warning",
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

            r.open("GET", "processes/cart/addToCart.process.php?pid=" + productId, true);
            r.send();

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
                        swal({
                            title: 'Successfully added',
                            icon: "success",
                            button: "Ok",
                        });
                    } else if (text == "3") {
                        swal({
                            title: 'Please login first',
                            icon: "warning",
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

            r.open("GET", "processes/watchlist/addtowatchlist.php?pid=" + productId, true);
            r.send();


        }


    }

}