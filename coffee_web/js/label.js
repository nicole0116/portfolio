let open = document.getElementsByClassName('open');
let m_b = document.getElementsByClassName('m_b');
window.onload = function () {
    open[0].style.display = "block";
    open[0].style.opacity = "1";
}
function show() {
    let openName = this.id.charAt(2);
    for (let j = 0; j < open.length; j++) {
        if (openName == j + 1) {
            open[j].style.opacity = "1";
        } else {
            open[j].style.opacity = "0";
        }
    }
}
for (var i = 0; i < m_b.length; i++) {
    m_b[i].addEventListener("click",show,false)
}