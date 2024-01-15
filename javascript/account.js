document.getElementById("profilePic").addEventListener('click', function() {

    document.getElementById("profilePic").onchange = function() {

        var img = document.getElementById("profilePic").files[0];
        document.getElementById("img").src = URL.createObjectURL(img);

        document.getElementById("saveBtn").classList.toggle("d-none");
        document.getElementById("changeBtn").classList.toggle("d-none");

    }

});

document.getElementById("saveBtn").addEventListener('click', function() {

    var form = new FormData();
    form.append("img", document.getElementById("profilePic").files[0]);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var text = r.responseText;
            if (text == "1") {
                swal({
                    title: "Image has been updated ",
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
            document.getElementById("saveBtn").classList.toggle("d-none");
            document.getElementById("changeBtn").classList.toggle("d-none");
        }
    }

    r.open("POST", "processes/profile/saveProfilePic.php", true);
    r.send(form);


});

document.getElementById("editBtn").addEventListener('click', function() {

    document.getElementById("fname").disabled = false;
    document.getElementById("lname").disabled = false;
    document.getElementById("mobile").disabled = false;
    document.getElementById("district").disabled = false;
    document.getElementById("province").disabled = false;
    document.getElementById("address1").disabled = false;
    document.getElementById("address2").disabled = false;
    document.getElementById("city").disabled = false;

    this.classList.toggle("d-none");
    document.getElementById("saveDBtn").classList.toggle("d-none");

});

document.getElementById("saveDBtn").addEventListener('click', function() {

    var form = new FormData();
    form.append("fname", document.getElementById("fname").value);
    form.append("lname", document.getElementById("lname").value);
    form.append("address1", document.getElementById("address1").value);
    form.append("address2", document.getElementById("address2").value);
    form.append("mobile", document.getElementById("mobile").value);
    form.append("province", document.getElementById("province").value);
    form.append("district", document.getElementById("district").value);
    form.append("city", document.getElementById("city").value);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var text = r.responseText;
            if (text == "1") {
                swal({
                    title: "Update Complete",
                    icon: "success",
                    button: "Ok",
                });

                document.getElementById("fname").disabled = true;
                document.getElementById("lname").disabled = true;
                document.getElementById("mobile").disabled = true;
                document.getElementById("district").disabled = true;
                document.getElementById("province").disabled = true;
                document.getElementById("address1").disabled = true;
                document.getElementById("address2").disabled = true;
                document.getElementById("city").disabled = true;

                document.getElementById("saveDBtn").classList.toggle("d-none");
                document.getElementById("editBtn").classList.toggle("d-none");

            } else {
                swal({
                    title: text,
                    icon: "error",
                    button: "Ok",
                });
            }
        }
    }

    r.open("POST", "processes/profile/editProfile.php", true);
    r.send(form);

});