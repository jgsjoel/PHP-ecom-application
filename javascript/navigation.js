document.getElementById("openNav").addEventListener("click", function() {
    document.querySelector(".navgation-options").style.right = "0px";
    document.querySelector(".navgation-options").style.transition = "0.5s";
    document.body.style.overflow = "hidden";
});

document.getElementById("closeNav").addEventListener("click", function() {
    document.querySelector(".navgation-options").style.right = "-300px";
    document.querySelector(".navgation-options").style.transition = "0.5s";
    document.body.style.overflow = "auto";
});

document.getElementById("openSearch").addEventListener("click", function() {

    var container = document.querySelector(".dropdown-search-container");

    if (container.offsetTop == "-55") {
        document.querySelector(".dropdown-search-container").style.top = "50px";
        document.querySelector(".dropdown-search-container").style.transition = "0.5s";
    } else {
        document.querySelector(".dropdown-search-container").style.top = "-120px";
        document.querySelector(".dropdown-search-container").style.transition = "0.5s";
    }
});

window.onscroll = function() {
    document.querySelector(".dropdown-search-container").style.top = "-120px";
    document.querySelector(".dropdown-search-container").style.transition = "0.5s";
}