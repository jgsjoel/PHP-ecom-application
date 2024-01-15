addtoCart();
addtowatchlist();

function addtoCart() {

    var cartBtns = document.getElementsByClassName("atcrt");

    for (var x = 0; x < cartBtns.length; x++) {

        cartBtns[x].onclick = function(evt) {

            var productId = evt.target.getAttribute('data-id');

            var r = new XMLHttpRequest();
            r.onreadystatechange = function() {
                if (r.readyState == 4) {
                    var text = r.responseText;
                    if (text == "1") {
                        window.location = "cart.php";
                    } else if (text == "2") {
                        alert("There was an error!");
                    } else if (text == "3") {
                        alert("please login first");
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

function addtowatchlist() {


    var watchBtns = document.getElementsByClassName("atwl");

    for (var x = 0; x < watchBtns.length; x++) {

        watchBtns[x].onclick = function(evt) {

            var productId = evt.target.getAttribute('data-id');

            var r = new XMLHttpRequest();
            r.onreadystatechange = function() {
                if (r.readyState == 4) {
                    var text = r.responseText;
                    if (text == "1") {
                        window.location = "watchlist.php";
                    } else if (text == "3") {
                        alert("please login first");
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

function loadmessages(pid) {

    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var text = r.responseText;
            document.getElementById("messageBox").innerHTML = text;
        }
    };

    r.open("GET", "processes/singleproduct/loadFeedback.php?pid=" + pid, true);
    r.send();

}

var prodImg = document.getElementsByClassName("prodPic");

for (var x = 0; x < prodImg.length; x++) {

    prodImg[x].onclick = function(evt) {

        document.getElementById("mainImg").src = evt.target.src;

    }

}

// getting product details when purchasing
document.getElementById("buyNow").onclick = function(evt) {

    var pid = evt.target.getAttribute("data-id");
    var qty = document.getElementById("qty").value;

    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var text = r.responseText;
            if (text == "3") {
                alert("Please login first");
            } else {
                var obj;
                try {
                    obj = JSON.parse(text);

                    var form = document.createElement('form');
                    form.setAttribute('method', 'POST');
                    form.setAttribute('action', 'http://localhost/Final_viva_project/processes/singleproduct/pay.php');

                    for (var key in obj) {
                        // if (postData.hasOwnProperty(key)) {
                        var input = document.createElement('input');
                        input.setAttribute('type', 'hidden');
                        input.setAttribute('name', key);
                        input.setAttribute('value', obj[key]);
                        form.appendChild(input);
                        // }
                    }

                    document.body.appendChild(form);
                    form.submit();

                } catch (error) {
                    alert(text + "ok");

                }
            }
        }
    }

    r.open("GET", "processes/singleproduct/getItemDetails.php?pid=" + pid + "&qty=" + qty, true);
    r.send();

}

// test notify function

function testNotify(order_id, payhere_amount) {

    var form = new FormData();
    form.append("order_id", order_id);
    form.append("payhere_amount", payhere_amount);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var text = r.responseText;
            alert(text);
        }
    }

    r.open("POST", "processes/singleproduct/notify.php", true);
    r.send(form);
}