//漢堡選單微修
var navBtn = document.querySelector("#navBtn");
var navBar = document.querySelector(".sidebar");

navBtn.addEventListener("click", function () {
  if (navBar.style.marginLeft == "0px") {
    navBar.style.marginLeft = "-200px";

  } else {
    navBar.style.marginLeft = "0px";
  }

  window.addEventListener("resize", function () {
    if (window.innerWidth > 991) {
      navBar.style.marginLeft = "0px";
    } else {
      navBar.style.marginLeft = "-200px";
    }
  })
})


//nav標籤
var navItem = document.querySelectorAll(".nav-item");
var backTable = document.querySelectorAll(".backTable");

backTable[0].style.display = "block";
for (var i = 0; i < navItem.length; i++) {
  navItem[i].addEventListener("click", function () {
    for (var j = 0; j < backTable.length; j++) {
      backTable[j].style.display = "none";
      if (document.body.offsetWidth > 991) {
        navBar.style.marginLeft = "0px";

      } else {
        navBar.style.marginLeft = "-200px";
      }
    }
    var backNum = this.id.substr((this.id.length) - 1) - 1;
    backTable[`${backNum}`].style.display = "block";
    lightBoxContent.style.display = "none";
    lightBoxContentAdd.style.display = "none";
  })

}



























//mall
var back_product_input = document.getElementById("back_product_input");
var back_product_add = document.getElementById("back_product_add");
var mall_add = document.querySelector(".mall_add");
var lightBoxContentAdd = document.getElementById("lightBox_content_add");
var lightBoxContent = document.getElementById("lightBox_content");
var customSwitch1 = document.querySelector("#customSwitch1");
var customSwitch2 = document.querySelector("#customSwitch2");




// function mall_del() { 

// alert("del")
// for (var i = 0; i < mallProductObj.length; i++) {
//   if (mallProductObj[i].product_no == this.id.substr(3)) 
  
//     // console.log(mallProductObj[i].product_no)
//     trStrS += `<tr>`
//     trStrS += `<th>商品編號</th>`
//     trStrS += `<td>${mallProductObj[i].product_no}<input type="hidden" name="product_no" value="${mallProductObj[i].product_no}"></td>`
//   }
 
// }//刪除單一商品表單



function mall_Add() { //新增商品表單
  lightBoxContentAdd.style.display = "block";
  backTable[3].style.display = "none";

  var input_ad_hidden = document.getElementsByClassName('input_ad_hidden')[0];
  input_ad_hidden.disabled = false;
  customSwitch1.addEventListener("change", function () {
    if (customSwitch1.checked) {
      input_ad_hidden.disabled = true;
    } else {
      input_ad_hidden.disabled = false;
    }
    console.log(customSwitch1.value)
  })

  var input_pdu_hidden = document.getElementsByClassName('input_pdu_hidden')[0];
  input_pdu_hidden.disabled = false;
  customSwitch2.addEventListener("change", function () {
    if (customSwitch2.checked) {

      input_pdu_hidden.disabled = true;

    } else {
      input_pdu_hidden.disabled = false;

    }
    console.log(customSwitch2.value)
  })

}

function mall_edit() { //修改商品表單
  var trStrS;
  lightBoxContent.style.display = "block";
  backTable[3].style.display = "none";

  back_product_input.innerHTML = "";
  for (var i = 0; i < mallProductObj.length; i++) {
    if (mallProductObj[i].product_no == this.id.substr(3)) {
      // console.log(mallProductObj[i].product_no)
      trStrS += `<tr>`
      trStrS += `<th>商品編號</th>`
      trStrS += `<td>${mallProductObj[i].product_no}<input type="hidden" name="product_no" value="${mallProductObj[i].product_no}"></td>`
      trStrS += `</tr>`
      trStrS += `<tr>`
      trStrS += `<th>商品價格</th>`
      trStrS += `<td><input type="text" name="product_price" value="${mallProductObj[i].product_price}"></td>`
      trStrS += `</tr>`
      trStrS += `<tr>`
      trStrS += `<th>商品圖片</th>`
      trStrS += `<td><input type="file" name="product_src"></input>
      <input type="hidden" name="product_src_hidden" value="${mallProductObj[i].product_src}">
      </td>`
      trStrS += `</tr>`
      trStrS += `<tr>`
      trStrS += `<th>商品顏色</th>`
      trStrS += `<td><input type="text" name="product_color" value="${mallProductObj[i].product_color}"></td>`
      trStrS += `</tr>`
      trStrS += `<tr>`
      trStrS += `<th>商品說明</th>`
      trStrS += `<td><input type="text" name="product_desc" value="${mallProductObj[i].product_desc}"  style='width:100%'></td>`
      trStrS += `</tr>`
      trStrS += `<tr>`
      trStrS += `<th>商品類別</th>`
      trStrS += `<td>${mallProductObj[i].product_type}</td>`
      trStrS += `</tr>`
      trStrS += `<th>商品背景</th>`
      trStrS += `<td><input type="file" name="product_bg_src"></input>
      <input type="hidden" name="product_bg_hidden" value="${mallProductObj[i].product_bg_src}">
      </td>`
      trStrS += `</tr>`
      trStrS += `<tr>`
      trStrS += `<th>商品輪播圖</th>`
      trStrS += `<td><input type="file" name="product_slide_img"></input>
      <input type="hidden" name="product_slide_hidden" value="${mallProductObj[i].product_slide_img}">
      </td>`
      trStrS += `</tr>`
      trStrS += `<tr>`
      trStrS += `<th>首頁廣告狀態</th>`
      trStrS += `<td><div class="custom-control custom-switch">
        <input type="checkbox" class="custom-control-input ad_edit" id="customSwitch1_edit_${i}" name="index_on" value="1">
        <input type="hidden" name="index_on" class="input_ad_edit_hidden" value="0">
        <label class="custom-control-label" for="customSwitch1_edit_${i}"></label>
      </div></td>`
      trStrS += `</tr>`
      trStrS += `<th>上下架狀態</th>`
      trStrS += `<td><div class="custom-control custom-switch">
        <input type="checkbox" class="custom-control-input ad_pdu" id="customSwitch2_edit_${i}" name="product_on" checked value="1">
        <input type="hidden" name="product_on" class="input_pdu_edit_hidden" value="0">
        <label class="custom-control-label" for="customSwitch2_edit_${i}"></label>
      </div></td>`
      trStrS += `</tr>`
      trStrS += `<tr>`
      trStrS += `<th colspan="2" style="text-align: center;background-color: #fff;border-bottom: none;border-color:#c8ced3;"><input type="submit" name="submit" value="送出"></th>`
      trStrS += `</tr>`


     

      // trStrS += `<tr>`
      // trStrS += `<th colspan="2" style="text-align: center;border-bottom: none;background-color: #fff;border-color:#c8ced3;color:#333" class="text_del">刪除此筆資料</th>`
      // trStrS += `</tr>`


      trStrS = trStrS.substring(9);
      back_product_input.innerHTML = trStrS;

      var text_del = document.getElementsByClassName('text_del')[0];
      console.log(text_del.textContent);



   
      var delNum = mallProductObj[i].product_no;
      var del_content = document.querySelector("#del_content input");
        
    
      text_del.addEventListener("click",function(){
         console.log(del_content)
         del_content.value = delNum;
      
        // trStrS_del = `<input type="hidden" name="product_no" value="mallProductObj[${delNum}].product_no"></input>`;

        // del_content.innerHTML = trStrS_del;
    
        
       
   
        document.getElementById("delForm").submit();
        
      });






      var input_ad_edit_hidden = document.getElementsByClassName('input_ad_edit_hidden')[0];
      var ad_edit = document.getElementsByClassName('ad_edit')[0];
      console.log(ad_edit);

      if (mallProductObj[i].index_on == 1) {
        ad_edit.checked = true
        input_ad_edit_hidden.disabled = true;
        console.log(input_ad_edit_hidden);
      }else{
        ad_edit.checked = false
        input_ad_edit_hidden.disabled = false;
      }
      ad_edit.addEventListener("change", function () {
        // console.log(document.getElementById(`ad_edit`).checked)
      
        if (ad_edit.checked == true) {
          input_ad_edit_hidden.disabled = true;
          console.log(input_ad_edit_hidden);
        } else {
          input_ad_edit_hidden.disabled = false;
          // console.log(mallProductObj[0].index_on);
          console.log(input_ad_edit_hidden);
          // console.log(0);
        }
       
      })




      var input_pdu_edit_hidden = document.getElementsByClassName('input_pdu_edit_hidden')[0];
      var ad_pdu = document.getElementsByClassName('ad_pdu')[0];
      console.log(ad_pdu);

      if (mallProductObj[i].product_on == 1) {
        ad_pdu.checked = true
        input_pdu_edit_hidden.disabled = true;
        console.log(input_pdu_edit_hidden);
      }else{
        ad_pdu.checked = false
        input_pdu_edit_hidden.disabled = false;
      }

      ad_pdu.addEventListener("change", function () {
             
        if (ad_pdu.checked == true) {
          input_pdu_edit_hidden.disabled = true;
          console.log(input_pdu_edit_hidden);
        } else {
          input_pdu_edit_hidden.disabled = false;
          // console.log(mallProductObj[0].index_on);
          console.log(input_pdu_edit_hidden);
          // console.log(0);
        }
       
      })
    }
  }

}




// var mallSwitch2 = document.querySelector("#mallSwitch2");
function mallList() {
  let xhr = new XMLHttpRequest();
  xhr.onload = function () {
    if (xhr.status == 200) {
      mallProductObj = JSON.parse(xhr.responseText);
      // document.getElementById("back_product").innerHTML = xhr.responseText;
      var trStr = ''; //動態拼接table

      for (var i = 0; i < mallProductObj.length; i++) {
        trStr += '<tr">'; //拼接處規範的表格形式
        trStr += `<td data-th="商品編號">${mallProductObj[i].product_no}</td>`;

        trStr += `<td data-th="商品名稱" style='word-break:break-all'>${mallProductObj[i].product_name}</td>`;
        trStr += `<td data-th="商品價格">${mallProductObj[i].product_price}</td>`;
        trStr += `<td data-th="商品圖片" style='word-break:break-all'"><img width="100" src="${mallProductObj[i].product_src}"></td>`;
        trStr += `<td data-th="商品顏色">${mallProductObj[i].product_color}</td>`;
        trStr += `<td data-th="商品說明" style='word-break:break-all;'>${mallProductObj[i].product_desc}</td>`;
        trStr += `<td data-th="商品類別" style='word-break:break-all'>${mallProductObj[i].product_type}</td>`;
        trStr += `<td data-th="商品背景" style='word-break:break-all'"><img width="100" src="${mallProductObj[i].product_bg_src}"></td>`;
        trStr += `<td data-th="商品輪播圖" style='word-break:break-all'"><img width="100" src="${mallProductObj[i].product_slide_img}"></td>`;
        trStr += `<td data-th="首頁廣告狀態" style='word-break:break-all'">
        <div class="custom-control custom-switch ">
          <input type="checkbox" class="custom-control-input mallSwitch1" name="index_on"  id="mallSwitch1_${i}" checked value="${mallProductObj[i].index_on}" disabled>
          <label class="custom-control-label" for="mallSwitch1_${i}" ></label>
        
        </div>
        
        </td>`;  // <p>${mallProductObj[i].index_on}</p>
        trStr += `<td data-th="上下架狀態" style='word-break:break-all'">
        <div class="custom-control custom-switch">
          <input type="checkbox" class="custom-control-input mallSwitch2" id="mallSwitch2_${i}" name="product_on" checked value="${mallProductObj[i].product_on}" disabled>
          <label class="custom-control-label" for="mallSwitch2_${i}" ></label>
          <p>
        </td>`;//${mallProductObj[i].product_on}</p>


        trStr += `<td data-th="設定"><span class="mall_modify" id="pdu${mallProductObj[i].product_no}">編輯</span>`;
        trStr += '</tr>';

      }
      document.getElementById("back_product").innerHTML = trStr;

      for (var i = 0; i < mallProductObj.length; i++) {

        if (document.getElementById(`mallSwitch1_${i}`).value == 1) {
          document.getElementById(`mallSwitch1_${i}`).checked = true;
        } else {
          document.getElementById(`mallSwitch1_${i}`).checked = false;
        }

        if (document.getElementById(`mallSwitch2_${i}`).value == 1) {
          document.getElementById(`mallSwitch2_${i}`).checked = true;
        } else {
          document.getElementById(`mallSwitch2_${i}`).checked = false;
        }
      }
    } else {
      alert(xhr.status);
    }
    for (var i = 0; i < mallProductObj.length; i++) {
      var mallModify = document.querySelectorAll('.mall_modify');
      mallModify[i].addEventListener('click', mall_edit);
    }
  }

  //設定好所要連結的程式
  let url = "./php/mall/back_product.php";
  xhr.open("get", url, true);
  xhr.send(null);
}

mall_add.addEventListener("click", mall_Add, false)
window.addEventListener("load", mallList, false);

//新增商品預設開關
window.addEventListener("load", function () {
  customSwitch1.checked = false;
  customSwitch2.checked = false;

})