
//漢堡選單
let menu = document.getElementById("hamburger_icon_content");
let btn_1 = document.getElementById("hamburger_down_list_1");
let btn_2 = document.getElementById("hamburger_down_list_2");

function hamburger() {
    let hamburger = document.getElementById("hamburger_icon_content");
    menu.classList.toggle("show");
    if (menu.classList.contains("show") == false) {
        btn_1.classList.remove("show_bt");
        btn_2.classList.remove("show_bt");
    }
}

function hamburger_bt1() {
    btn_1.classList.toggle("show_bt");
    if (btn_1.classList.contains("show_bt")) {
        btn_2.classList.remove("show_bt")
    }
}

function hamburger_bt2() {
    btn_2.classList.toggle("show_bt");
    if (btn_2.classList.contains("show_bt")) {
        btn_1.classList.remove("show_bt")
    }
}


    document.getElementById('hamburger_icon').onclick = hamburger;
    document.getElementById('hamburger_down_bt1').onclick = hamburger_bt1;
    document.getElementById('hamburger_down_bt2').onclick = hamburger_bt2;

