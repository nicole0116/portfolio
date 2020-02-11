function $id(id) {
  return document.getElementById(id);
}
const btnLogin = $id("btnLogin");
const btnSignup = $id('member_sign_up')
btnLogin.addEventListener("click", login);
btnSignup.addEventListener('click', signup)

//--------------------顯示登入者資訊
function showMemInfo(json) {
  const userStatus = document.querySelector(".status");
  const userName = document.getElementById("mem_id");
  if (json.status === "success") {
    MEMBER_INFO = json.data;
    userStatus.classList.add("logout");
    userName.innerText = json.data.mem_name || json.data.mem_id;
    location.replace("./member.html");
  } else {
    alert(json.content);
  }
}

// --------------------到server端做登入
function login() {
  var memId = $id("memId").value;
  var memPsw = $id("memPsw").value;
  //-------------使用ajax方法到Server端資料
  fetch('./php/member/login.php',{
    headers: {
      'Accept': 'application/json',
      'Content-Type': 'application/json'
    },
    method: "POST",
    body: JSON.stringify({
      mem_id: memId,
      mem_psw: memPsw
    })
  }).then(res=>res.json())
  .then(json=>showMemInfo(json))
  .catch(err=>console.log(err))
}

function signup(){
  const memId = $id("memId_s");
  const memPsw = $id("memPsw_s");
  const memEmail = $id('memEmail')

  if(memId && memPsw && memEmail){
    fetch('./php/member/signup.php',{
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json'
      },
      method: "POST",
      body: JSON.stringify({
        mem_id: memId.value,
        mem_psw: memPsw.value,
        mem_email: memEmail.value,
        headshot,
        file_type: fileType,
        file_ext: fileExt
      })
    }).then(res=>res.json())
    .then(json=>{
      alert(json.content)
      if(json.status === 'success'){
        memId.value = ''
        memPsw.value = ''
        memEmail.value = ''
      }
    })
    .catch(err=>console.log(err))
  }
}
