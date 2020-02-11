function $id(id) {
  return document.getElementById(id);
}
const memId = document.getElementById('memId');
const memName = document.getElementById('memName');
const memEmail = document.getElementById('memEmail');
const memPhone = document.getElementById('memPhone');
const memAddr = document.getElementById('memAddr');
const headshot = document.getElementById('acceptImg');

function checkLogin() {
  fetch("./php/member/isLogin.php")
    .then(res => res.json())
    .then(json => {
      if (json.status === "success") {
        memId.value = json.data.mem_id
        memName.value = json.data.mem_name 
        memEmail.value = json.data.mem_email
        memPhone.value = json.data.mem_tel
        memAddr.value = json.data.mem_addr
        if(json.data.headshot)headshot.src = `./userImg/${json.data.headshot}`
        getOrderList(json.data.mem_no)
      }
    })
    .catch(err => console.log(err));
}
//================member update=======================//
const updateBtn = document.getElementById('memberbtn');
updateBtn.addEventListener('click', memUpdate)
function memUpdate() {
  let src = headShot ? headShot.replace(/\&/g, "%26").replace(/\+/g, "%2B") : MEMBER_INFO.headshot
  fetch('./php/member/member_update.php', {
    method: 'POST',
    body: new URLSearchParams(`mem_id=${MEMBER_INFO.mem_id}&mem_no=${MEMBER_INFO.mem_no}&mem_name=${memName.value}&mem_tel=${memPhone.value}&mem_email=${memEmail.value}&mem_addr=${memAddr.value}&headshot=${src}&file_type=${fileType}&file_ext=${fileExt}`)
  })
    .then(res=>res.json())
    .then(json=>{
      if(json.status === 'success'){
        document.getElementById('mem_id').textContent = memName.value
        alert(json.content)
      }
    })
    .catch(err=>console.log(err))
}
//=====================order list===============================//
const tableOrder = document.querySelector('.table_oder');
function getOrderList(memNo){
  fetch('./php/member/orderList.php',{
    method: 'POST',
    body: new URLSearchParams(`mem_no=${memNo}`)
  })
    .then(res=>res.json())
    .then(json=>{
      if(json.status === 'success')order_temp(json.data)
    })
    .catch(err=>console.log(err))
}


const tableProduct = document.querySelector('.table_order_special')
function getOrderProduct(){
  fetch('./php/member/orderProduct.php',{
    method: 'POST',
    body: new URLSearchParams(`order_no=${+this.innerText}`)
  })
    .then(res=>res.json())
    .then(json=>{
      if(json.status === 'success')order_temp1(json.data)
    })
    .catch(err=>console.log(err))
}
function deleteOrder(){
  let dom = document.querySelector(`#order_${this.dataset.index}`);
  tableOrder.removeChild(dom)
  let productDom = document.querySelectorAll(`.product_${this.dataset.order}`);
  if(productDom)[...productDom].forEach(dom => tableProduct.removeChild(dom))
  fetch('./php/member/deleteItem.php',{
    method: 'POST',
    body: new URLSearchParams(`order_no=${this.dataset.order}`)
  })
    .then(res=>res.json())
    .then(json=>alert(json.content))
    .catch(err=>console.log(err))
}

function order_temp(data) {
  data.forEach((info, index)=>{
    let tr = document.createElement('tr');
    tr.id = `order_${index}`
    tr.innerHTML = `
    <td class='cretDate'>${info.cret_date}</td>
    <td class="order_no">0000${info.order_no}</td>
    <td>${info.atr_date ? info.atr_date : ''}</td>
    <td>${info.cel_date ? info.cel_date : ''}</td>
    <td>
      <div class="th3_box">
        <span class="delete_oder" data-index=${index} data-order=${info.order_no}>
          <img src="./img/icon/delete.0df56913.svg" alt="" width="14">
          <img src="./img/icon/delete_on.70d3ed1f.svg" alt="" width="14">
        </span>
      </div>
    </td>
    `
    tableOrder.appendChild(tr)
    const getOrder = document.querySelectorAll('.table_oder .order_no');
    getOrder.forEach(dom=>dom.addEventListener('click', getOrderProduct))
    const deleteBtn = document.querySelector(`#order_${index} .delete_oder`);
    deleteBtn.addEventListener('click', deleteOrder)
  })
}

function order_temp1(data) {
  let oldTr = document.querySelectorAll('.table_order_special>tr')
  if(oldTr){
    [...oldTr].forEach(dom=>{
      tableProduct.removeChild(dom)
    })
  }
  data.forEach(info=>{
    const tr = document.createElement('tr')
    tr.className = `product_${info.order_no}`
    tr.innerHTML = `
    <tr>
      <td>${info.product_name_color}</td>
      <td>${info.order_product_num}</td>
      <td>${info.order_product_price * info.order_product_num}</td>
    </tr>
    `
    tableProduct.appendChild(tr)
  })
}
checkLogin()


