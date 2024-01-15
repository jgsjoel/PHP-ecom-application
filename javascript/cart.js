var qtySelectors = document.getElementsByClassName("qty-select");

for (var x = 0; x < qtySelectors.length; x++) {

    qtySelectors[x].onchange = function(evt) {

        var form = new FormData();
        form.append('pid', evt.target.closest('.card').getAttribute('data-productId'));
        form.append('qty', evt.target.value);
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
                            window.location = "cart.php";
                        });
                } else {
                    swal({
                        title: text,
                        icon: "error",
                        button: "Ok",
                    })
                }
            }
        };

        r.open("POST", "processes/cart/cartControler.php", true);
        r.send(form);

    }

}


var watchListBtns = document.getElementsByClassName("atwl");

for (var x = 0; x < watchListBtns.length; x++) {

    watchListBtns[x].onclick = function(evt) {
        var productId = evt.target.closest('.card').getAttribute('data-productId');

        var r = new XMLHttpRequest();
        r.onreadystatechange = function() {
            if (r.readyState == 4) {
                var text = r.responseText;
                if (text == "1") {
                    window.location = "watchlist.php";
                    // alert(text);
                } else {
                    alert(text);
                }
            }
        };

        r.open("GET", "processes/watchlist/addToWatchlist.php?pid=" + productId, true);
        r.send();

    }

}

var removeFWlBtns = document.getElementsByClassName("remfwl");

for (var x = 0; x < removeFWlBtns.length; x++) {

    removeFWlBtns[x].onclick = function(evt) {
        var productId = evt.target.closest('.card').getAttribute('data-productId');

        var r = new XMLHttpRequest();
        r.onreadystatechange = function() {
            if (r.readyState == 4) {
                var text = r.responseText;
                if (text == 1) {
                    swal({
                            title: "Product has been removed successfully.",
                            icon: "success",
                            button: "Ok",
                        })
                        .then(() => {
                            window.location = "cart.php";
                        });
                } else {
                    swal({
                        title: text,
                        icon: "error",
                        button: "Ok",
                    })
                }
            }
        };

        r.open("GET", "processes/cart/cartControler.php?pid=" + productId, true);
        r.send();

    }

}

//check out process
document.getElementById("checkout").onclick = function() {

    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var text = r.responseText;
            try {
                var obj = JSON.parse(text);

                var form = document.createElement('form');
                form.setAttribute('method', 'POST');
                form.setAttribute('action', 'http://localhost/Final_viva_project/processes/cart/pay.php');

                for (var key in obj) {
                    var input = document.createElement('input');
                    input.setAttribute('type', 'hidden');
                    input.setAttribute('name', key);
                    input.setAttribute('value', obj[key]);
                    form.appendChild(input);
                }

                document.body.appendChild(form);
                form.submit();

            } catch (error) {
                alert(text);
            }
        }
    };

    r.open("GET", "processes/cart/getCartDetails.php", true);
    r.send();

}

function testNotify(order_id) {

    var form = new FormData();
    form.append("order_id", order_id);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var text = r.responseText;
            alert(text);
        }
    };

    r.open("POST", "processes/cart/notify.php", true);
    r.send(form);

}