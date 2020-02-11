
let login_sw1 = document.getElementById("login_sw1");
let mem_login_btn = document.getElementById("mem_login_btn");
let mem_sign_btn = document.getElementById("mem_sign_btn");
let login_move_box = document.getElementById("login_move_box ");
let login_sw1_ani1 = document.getElementById("login_sw1_ani1");
let login_sw1_ani2 = document.getElementById("login_sw1_ani2");
let sw1_word1 = document.getElementById("sw1_word1");
let sw1_word2 = document.getElementById("sw1_word2");
let member_login_in_send = document.querySelector(".mem_login_in_send");
let sign_mem_up_input = document.querySelector(".sign_up_input");
let login_sw2 = document.getElementById("login_sw2");
// sign in
mem_login_btn.addEventListener("click", function() {
  login_move_box.classList.add("active1");
  login_move_box.classList.remove("active2");
  member_login_in_send.classList.add("active1");
  sign_mem_up_input.classList.add("active");
});
// sign up
mem_sign_btn.addEventListener("click", function() {
  login_move_box.classList.add("active2");
  login_move_box.classList.remove("active1");
  member_login_in_send.classList.remove("active1");
  sign_mem_up_input.classList.remove("active");
});
login_sw1.addEventListener("click", function() {
  login_sw1_ani1.classList.add("active3");
  sw1_word1.classList.add("active4");
  login_sw1_ani2.classList.remove("active5");
  sw1_word2.classList.remove("active6");
  member_login_in_send.classList.remove("active7");
  sign_mem_up_input.classList.remove("active");
});
login_sw2.addEventListener("click", function() {
  login_sw1_ani2.classList.add("active5");
  sw1_word2.classList.add("active6");
  login_sw1.classList.remove("active");
  login_sw1_ani1.classList.remove("active3");
  sw1_word1.classList.remove("active4");
  member_login_in_send.classList.add("active7");
  sign_mem_up_input.classList.add("active");
});

// ================light box================================
let open_sign_ligh1 = document.getElementById("open_sign_ligh1");
let mem_mask3 = document.getElementById("mem_mask3");
let liclose3 = document.getElementById("liclose3");
let memlibox3 = document.getElementById("memlibox3");
let light_box_title3 = document.getElementById("light_box_title3");
let member_sign_up =document.getElementById("member_sign_up");

open_sign_ligh1.addEventListener("click", function() {
  mem_mask3.classList.add("active_for_mask3");
  memlibox3.classList.add("active_for_memlibox3");
  memlibox3.classList.remove("closeani3");
});

liclose3.addEventListener("click", function() {
  mem_mask3.classList.remove("active_for_mask3");
  memlibox3.classList.add("closeani3");
});

mem_mask3.addEventListener("click", function() {
  mem_mask3.classList.remove("active_for_mask3");
  memlibox3.classList.add("closeani3");
});

light_box_title3.addEventListener("click", function() {
  mem_mask3.classList.remove("active_for_mask3");
  memlibox3.classList.add("closeani3");
});

member_sign_up.addEventListener("click",function(){
  mem_mask3.classList.remove("active_for_mask3");
  memlibox3.classList.add("closeani3");
});
// ===================member_change_img====================================
let headshot, fileType, fileExt;
function showImg(thisimg) {
  let file = thisimg.files[0];
  fileType = file.type
  fileExt = file.name.split('.').pop()
  if (window.FileReader) {
    let files = new FileReader();
    let showimg = document.getElementById("show_sign_img");
    files.onloadend = function(e) {
      showimg.src = e.target.result;
      headshot = e.target.result;
    };
    files.readAsDataURL(file);
  }
}

// =============================test==================
