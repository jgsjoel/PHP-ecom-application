document.getElementById("change_img1").addEventListener('click', function() {

    document.getElementById("img1").onchange = function() {

        var img = document.getElementById("img1").files[0];
        document.getElementById("imgtag1").src = URL.createObjectURL(img);
        alert(URL.createObjectURL(img));

    }

});

document.getElementById("change_img2").addEventListener('click', function() {

    document.getElementById("img2").onchange = function() {

        var img = document.getElementById("img2").files[0];
        document.getElementById("imgtag2").src = URL.createObjectURL(img);
        alert(URL.createObjectURL(img));

    }

});

document.getElementById("change_img3").addEventListener('click', function() {

    document.getElementById("img3").onchange = function() {

        var img = document.getElementById("img3").files[0];
        document.getElementById("imgtag3").src = URL.createObjectURL(img);
        alert(URL.createObjectURL(img));

    }

});

document.getElementById("update").addEventListener('click', function() {

    var prodId = document.getElementById("prodId").value;
    var name = document.getElementById("name").value;
    var price = document.getElementById("price").value;
    var qty = document.getElementById("qty").value;
    var shipping1 = document.getElementById("shipping1").value;
    var shipping2 = document.getElementById("shipping2").value;
    var description = CKEDITOR.instances.description.getData();
    var img1 = document.getElementById("img1").files[0];
    var img2 = document.getElementById("img2").files[0];
    var img3 = document.getElementById("img3").files[0];

    // alert(img1);

    var form = new FormData();
    form.append("proId", prodId);
    form.append("name", name);
    form.append("price", price);
    form.append("qty", qty);
    form.append("shipping1", shipping1);
    form.append("shipping2", shipping2);
    form.append("description", description);
    form.append("img1", img1);
    form.append("img2", img2);
    form.append("img3", img3);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var text = r.responseText;
            if (text == "1") {
                swal({
                    title: "Update Complete!",
                    icon: "success",
                    button: "Ok",
                });

            } else {
                swal({
                    title: text,
                    icon: "error",
                    button: "Ok",
                });
            }
        }
    };

    r.open("POST", "processes/updateProducts.process.php", true);
    r.send(form);

});