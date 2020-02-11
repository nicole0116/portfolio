
    var outBox = document.getElementById("outBox");
    var insideBox = document.getElementById("insideBox");

    function showBox(e) {
        outBox.style.opacity = "0.8";
        outBox.style.zIndex = "11";
        outBox.style.visibility = "visible";
        insideBox.style.opacity = "1";
        insideBox.style.visibility = "visible";
        outBox.style.width = "100%";
            outBox.style.height = "100%";
        e ? e.stopPropagation() : event.cancelBubble = true;
    };

    function closeBox() {
        insideBox.style.opacity = "0";
        insideBox.style.visibility = "hidden";
        outBox.style.opacity = "0";
        outBox.style.zIndex = "-1";

    };

    if (insideBox.style.opacity = "1") {
        outBox.onclick = function (e) {
            insideBox.style.opacity = "0";
            insideBox.style.visibility = "hidden";
            outBox.style.opacity = "0";
            outBox.style.width = "0";
            outBox.style.height = "0";
        }
    }


    function init() {
        var insideBox = document.getElementById("insideBox");
        btns = document.getElementsByClassName("showUp");
        for (i = 0; i < btns.length; i++) {
            btns[i].onclick = showBox;
        }
        btnsCross = document.getElementById("closeDown");
        btnsCross.onclick = closeBox;
        insideBox.addEventListener("click", function (e) {
            e.stopPropagation();
        })

        insideBox.onclick = function (e) {
            e.stopPropagation();
        };

    }
    window.onload = init;