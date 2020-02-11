(async function (){
  const memTable = document.querySelector('.mem_table tbody')
  const mgrTable = document.querySelector('.mgr_table tbody')

  const members = await fetch('./php/member/backMember.php')
    .then(res=>res.json())
    .then(json=>json.data)
    .catch(err=>console.log(err))
  const managers = await fetch('./php/member/backManager.php')
    .then(res=>res.json())
    .then(json=>json.data)
    .catch(err=>console.log(err))

  const createMemberTables = () => {
    members.forEach((info, index)=>{
      let tr = document.createElement('tr')
      tr.innerHTML = `
      <th scope="row">${info.mem_no}</th>
      <td>${info.mem_id}</td>
      <td>${info.mem_email}</td>
      <td>                          
        <div class="custom-control custom-switch">
          <input type="checkbox" class="custom-control-input member" id="member${index}" name="index_on"
          ${info.mem_status === 1 ? 'checked' : ''}>
          <input type="hidden" name="index_on" class="input_ad_hidden" />
          <label class="custom-control-label" for="member${index}"></label>
        </div>
      </td>
      `
      memTable.appendChild(tr)
    })
  }
  const createManagerTables = () => {
    managers.forEach((info, index)=>{
      let tr = document.createElement('tr')
      tr.innerHTML = `
      <th scope="row">${info.mgr_no}</th>
      <td>${info.mgr_id}</td>
      <td>                          
        <div class="custom-control custom-switch">
          <input type="checkbox" class="custom-control-input manager" id="manager${index}" name="index_on"
          ${info.mgr_sta === 1 ? 'checked' : ''}>
          <input type="hidden" name="index_on" class="input_ad_hidden" />
          <label class="custom-control-label" for="manager${index}"></label>
        </div>
      </td>
      `
      mgrTable.appendChild(tr)
    })
  }
  createMemberTables()
  createManagerTables()

  const controlMemberBtn = [...document.querySelectorAll('.custom-control > .member')]
  const changeMemberStatus = function () {
    let index = controlMemberBtn.indexOf(this)
    memberStatusProxy[index] === 1 ? memberStatusProxy[index] = 0 : memberStatusProxy[index] = 1
  }
  const controlManagerBtn = [...document.querySelectorAll('.custom-control > .manager')]
  const changeManagerStatus = function () {
    let index = controlManagerBtn.indexOf(this)
    managerStatusProxy[index] === 1 ? managerStatusProxy[index] = 0 : managerStatusProxy[index] = 1
  }
  
  const memberStatus = controlMemberBtn.reduce((prev, dom, index)=>{
    dom.addEventListener('click', changeMemberStatus)
    prev[index] = members[index].mem_status
    return prev
  }, {})
  const managerStatus = controlManagerBtn.reduce((prev, dom, index)=>{
    dom.addEventListener('click', changeManagerStatus)
    prev[index] = managers[index].mgr_sta
    return prev
  }, {})

  const memberStatusProxy = new Proxy(memberStatus, {
    get(target, key){
      return target[key]
    },
    set(target, key, val){
      target[key] = val
      fetch('./php/member/changeMemberStatus.php', {
        method: 'POST',
        body: new URLSearchParams(`mem_no=${members[key].mem_no}&mem_status=${val}`)
      })
        .then(res=>res.json())
        .then(json=>json)
        .catch(err=>console.log(err))
    }
  })
  const managerStatusProxy = new Proxy(managerStatus, {
    get(target, key){
      return target[key]
    },
    set(target, key, val){
      target[key] = val
      fetch('./php/member/changeManagerStatus.php', {
        method: 'POST',
        body: new URLSearchParams(`mgr_no=${managers[key].mgr_no}&mgr_sta=${val}`)
      })
        .then(res=>res.json())
        .then(json=>json)
        .catch(err=>console.log(err))
    }
  })

  const modal = document.getElementById('modal')
  document.getElementById('addManager').addEventListener('click', ()=>{
    modal.classList.add('open')
  })
  let modalClose = [...document.querySelectorAll('.modalClose')].forEach(dom=>dom.addEventListener('click', ()=>{
    modal.classList.remove('open')
  }))
  const accountInput = document.getElementById('accountInput')
  const passwordInput = document.getElementById('passwordInput')
  const submitManager = document.getElementById('submitManager')
  submitManager.addEventListener('click', ()=>{
    if(accountInput.value && passwordInput.value){
      fetch('./php/member/signupManager.php', {
        method: 'POST',
        body: new URLSearchParams(`mgr_id=${accountInput.value}&mgr_psw=${passwordInput.value}`)
      })
        .then(res=>res.json())
        .then(json=>{
          if(json.status === 'success'){
            modal.classList.remove('open')
            location.reload()
          }else {
            alert(json.content)
          }
        })
        .catch(err=>console.log(err))
    }
  })

  document.getElementById('managerLogout').addEventListener('click', ()=>{
    fetch('./php/member/logout.php')
      .then(res=>res.json())
      .then(json=>location.reload())
      .catch(err=>console.log(err))
  })
})()