var email;
document.getElementById("varify").onclick = function(evt) {

    email = document.getElementById("email").value;

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
                        evt.target.classList.toggle("d-none");
                        document.getElementById("login").classList.toggle("d-none");
                        document.getElementById("passwordfield").classList.toggle("d-none");
                        document.getElementById("emailfield").classList.toggle("d-none");
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

    r.open("GET", "processes/admin/varifyProcess.php?email=" + email, true);
    r.send();

}
window.onbeforeunload = function(evt) {
    evt.returnValue = "";
}
document.getElementById("login").onclick = function() {

    var form = new FormData();
    form.append("email", email);
    form.append("code", document.getElementById("password").value);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var text = r.responseText;
            if (text == "1") {
                swal({
                        text: "Login Successful",
                        icon: "success",
                        button: true,
                    })
                    .then(() => {
                        window.onbeforeunload = function(evt) {
                            return null;
                        }
                        window.location = "adminPannel.php";
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

    r.open("POST", "processes/admin/varifyCode.php", true);
    r.send(form);
}