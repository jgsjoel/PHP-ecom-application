var modal = new bootstrap.Modal(document.getElementById('forgotPasswordModel'));

document.getElementById("change1").addEventListener("click", function() {
    change();
});

document.getElementById("change2").addEventListener("click", function() {
    change();
});

function change() {

    document.getElementById("signinbox").classList.toggle("d-none");
    document.getElementById("signupbox").classList.toggle("d-none");

}


document.getElementById("login").addEventListener("click", function() {
    var email = document.getElementById("email1").value;
    var password = document.getElementById("password1").value;

    var ischecked = document.getElementById("remember").checked;

    var form = new FormData();
    form.append("email", email);
    form.append("password", password);
    form.append("ischecked", ischecked);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var text = r.responseText;
            if (text == "1") {
                window.location = "index.php";
            } else {
                swal({
                    title: text,
                    icon: "warning",
                    button: "Ok",
                });
            }
        }
    };

    r.open("POST", "processes/login-Register/loginProcess.php", true);
    r.send(form);


});

document.getElementById("signUp").addEventListener("click", function() {
    var fname = document.getElementById("fname").value;
    var lname = document.getElementById("lname").value;
    var email = document.getElementById("email2").value;
    var password1 = document.getElementById("spassword1").value;
    var password2 = document.getElementById("spassword2").value;

    var form = new FormData();
    form.append("fname", fname);
    form.append("lname", lname);
    form.append("email", email);
    form.append("password1", password1);
    form.append("password2", password2);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var text = r.responseText;
            if (text == "1") {
                swal({
                    title: "Register Complete!",
                    icon: "success",
                    button: "Ok",
                });
                change();
            } else {
                swal({
                    title: text,
                    icon: "warning",
                    button: "Ok",
                });
            }
        }
    };

    r.open("POST", "processes/login-Register/registerUser.php", true);
    r.send(form);


});


document.getElementById("frgtPassBtn").addEventListener("click", function() {

    var email = document.getElementById("email1").value;

    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var text = r.responseText;
            if (text == "1") {
                swal({
                        text: "A varification code has been sent to your email",
                        icon: "info",
                        button: true,
                    })
                    .then(() => {
                        modal.show();
                    });
            } else {
                swal({
                    title: "Invalid Email",
                    icon: "error",
                    button: "Ok",
                });
            }
        }
    };

    r.open("GET", "processes/login-Register/forPassProcess.php?email=" + email, true);
    r.send();

});

document.getElementById("showPas1").addEventListener("click", function() {

    var textfield = document.getElementById("newPass1");
    if (textfield.type == "password") {
        this.text = "Hide";
        textfield.type = "text";
    } else {
        this.text = "Show";
        textfield.type = "password";
    }

});

document.getElementById("showPas2").addEventListener("click", function() {

    var textfield = document.getElementById("newPass2");
    if (textfield.type == "password") {
        this.text = "Hide";
        textfield.type = "text";
    } else {
        this.text = "Show";
        textfield.type = "password";
    }

});

document.getElementById("changepassword").addEventListener('click', function() {

    var form = new FormData();
    form.append("code", document.getElementById("variNum").value);
    form.append("email", document.getElementById("email1").value);
    form.append("password1", document.getElementById("newPass1").value);
    form.append("password2", document.getElementById("newPass2").value);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var text = r.responseText;
            if (text == "1") {
                modal.hide();
                swal({
                    title: "Pasword has been Changed",
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

    r.open("POST", "processes/login-Register/changePassword.php", true);
    r.send(form);

});