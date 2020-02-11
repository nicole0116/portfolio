const container = document.getElementById("app");
const hamburger = document.querySelector(".nav_hamburger");
const layoutShot = document.getElementById('user_shot');
let MEMBER_INFO = {};
(async function() {
  const navLists = document.querySelectorAll(".nav_list > li");
  const userStatus = document.querySelector(".status");
  const userName = document.getElementById("mem_id");
  const userLogout = document.getElementById("mem_logout");
  hamburger.addEventListener("click", () => container.classList.toggle("nav_open"));
  userLogout.addEventListener("click", logOut);
  function checkLogin() {
    return new Promise(resolve => {
      fetch("./php/member/isLogin.php")
        .then(res => res.json())
        .then(json => {
          if (json.status === "success") {
            userStatus.classList.add("logout");
            if(json.data.headshot){
              layoutShot.src = `./userImg/${json.data.headshot}`
            }
            userName.innerText = json.data.mem_name || json.data.mem_id;
            resolve(json.data);
          }
        })
        .catch(err => console.log(err));
    });
  }
  function logOut() {
    fetch("./php/member/logout.php")
      .then(res => res.json())
      .then(json => location.replace("./member_login.html"))
      .catch(err => console.log(err));
  }
  function setListClass() {
    const locationHref = location.href
      .split("/")
      .pop()
      .split(".")
      .shift();
    const currentList = [...navLists].find(
      dom => dom.dataset.name === locationHref
    );
    if (currentList) currentList.classList.add("active");
  }
  background();
  setListClass();
  MEMBER_INFO = await checkLogin();
})();
