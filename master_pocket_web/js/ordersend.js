//產生XMLHttpRequest物件
let xhr = new XMLHttpRequest();
let xhrOrderList = new XMLHttpRequest();
let cartSubmit = document.querySelector('.cart_submit');

// let cartProduct = document.querySelectorAll('.cart_product');
let cartProductColor = document.querySelectorAll('.cart_product_color');
let orderProductPrice = document.querySelectorAll('.cart_product_price');
let orderProductNumber = document.querySelectorAll('.cart_product_number');

let orderListurl = "";
let sendOrderList = "";
cartSubmit.addEventListener('click', () => {
  //---判斷會員id---//
  //---判斷有沒有登入---//
  if (Object.entries(MEMBER_INFO).length){
    //註冊callback function 
    //---送訂單總表orders---///
    if(!cartProduct.length){
      alert('請先加入商品')
      return
    }
    xhr.onload = function () {
      if (xhr.status == 200) {
        // document.querySelector("#idMsg").textContent = xhr.responseText;
        //console.log("----", xhr.responseText)
        for (let i = 0; i < cartProduct.length; i++) {
          orderListurl = "./php/order/orderlist.php";
          xhrOrderList.open("POST", orderListurl, true);
          //送出資料
          xhrOrderList.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
          sendOrderList = `order_no=${+xhr.responseText}&mem_no=${MEMBER_INFO.mem_no}&product_name_color=${cartProductColor[i].textContent}&order_product_price=${orderProductPrice[i].textContent}&order_product_num=${orderProductNumber[i].textContent}`;
          xhrOrderList.send(sendOrderList);

          // console.log(xhr.responseText);
          // console.log(cartProduct)
        };
        location.href = './mall.html';
        alert('訂單已送出');
      } else {
        alert(xhr.statusText);
      }
    }

    let cartNewTotal = document.querySelector('.cart_price_total');
    let shipAddr = document.querySelector('#ship_addr');
    let receiverTel = document.querySelector('#receiver_tel');
    let receiverName = document.querySelector('#receiver_name');

    let url = "./php/order/order.php";
    xhr.open("POST", url, true);
    //送出資料
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    let sendProductPrice = `product_price=${cartNewTotal.textContent}&mem_no=${MEMBER_INFO.mem_no}&ship_addr=${shipAddr.value}&receiver_name=${receiverName.value}&receiver_tel=${receiverTel.value}`;
    xhr.send(sendProductPrice);
    // console.log(sendProductPrice);

    //---送訂單明細order_item---//
    
    // xhrOrderList.onload = function () {
    //   if (xhrOrderList.status == 200) {
    //     // document.querySelector("#idMsg").textContent = xhr.responseText;
    //     // alert('ok');
    //     console.log("orderlist", xhrOrderList.responseText)
    //   } else {
    //     alert(xhrOrderList.statusText);
    //   }
    // }

    //成功送出資料後清除填入的資訊
    shipAddr.value = "";
    receiverTel.value = "";
    receiverName.value = "";

    cartNewTotal.textContent = 0;
    //成功送出資料後清除頁面商品
    document.querySelector('.cart_list').innerHTML = "";
    //成功送出資料後清除storage裡的資料
    storage.clear();
  }else{
    alert('請先登入會員');
  }
});