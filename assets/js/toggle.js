// for toggle bar hide and show...
var side = document.querySelector("#sidebar ");
var main = document.querySelector("#main-content");
var togg = document.querySelector("#toggle");
var width = window.innerWidth;
$("#toggle").click(function () {
    if (side.clientWidth == 0) {
        // $("#sidebar").toggle()
        side.style.width      = "200px";
        main.style.marginLeft = "200px";
        // side.style.width      = (width - 200) + "px";
        $("#sidebar").show();
      } else {

        side.style.width      = "0";
        main.style.marginLeft = "0";
        // main.style.width      = width + "px";
        $("#sidebar").hide();

        }
    });
