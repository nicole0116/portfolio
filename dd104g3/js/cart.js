window.addEventListener('load', () => {
  //***---購物車商品滑入特效---***///
  let cartProduct = document.querySelectorAll('.cart_product');
  for (let j = 0; j < cartProduct.length; j++) {
    window.setTimeout(() => {
      cartProduct[j].setAttribute('style', 'opacity:1;left:0%;transition:all .8s;')
    }, 200 * j);
  }
});

//***---欄位focus---***//
let cardNum1 = document.querySelectorAll('.cart_inputnum1');
for (let i = 0; i < cardNum1.length; i++) {
  cardNum1[i].addEventListener('input', (e) => {
    if (e.target.value.length == 4) {
      e.target.nextElementSibling.focus();
    } else if (e.target.value.length == 0) {
      e.target.previousElementSibling.focus();
    };
  });
};

//---creditcard rotate---//
// let creditCatdRotate = document.querySelector('#creditcardCCV');
// creditCatdRotate.addEventListener('click',()=>
// {
//   document.querySelector('.creidcard_rotate').setAttribute('style', 'transform:rotateY(180deg);transition:.5s');
  
// })

//***---從storage取出資料到購物車---***//
let storage = sessionStorage;

//--先把myCartList取出來--//
let getMyCartList = storage.getItem(`myCartList`);
let cartProducts;
if(getMyCartList){
  cartProducts = getMyCartList.substr(0, getMyCartList.length - 1).split(',');
}
// console.log(cartProducts);

let total = 0;
for (let key in cartProducts) {
  //--跑迴圈將每一項點選的商品取出來--//
  let productInfo = storage.getItem(cartProducts[key]).split(',');
  // console.log(productInfo);
  //--將以選購商品金額加總--//
  total += (parseInt(productInfo[3]) * parseInt(productInfo[5]));
  // console.log(productInfo);

  //--將取出的資料寫進HTML結構中--//
  let addProduct = document.createElement('div');
  document.querySelector('.cart_list').appendChild(addProduct).innerHTML = `
    <div class="cart_product">
      <div class="cart_product_img">
        <img src="${productInfo[0]}" alt="">
      </div>
      <div class="cart_product_message">
        <p class="cart_product_color">${productInfo[1]}${productInfo[2]}</p>
        <span>$</span><span class="cart_product_price">${productInfo[3]}</span>
        <p>商品介紹 : ${productInfo[4]}</p>
      </div>
      <div class="cart_product_qty">
        <button class="cart_cut_product"> - </button>
        <p class="cart_product_number">${productInfo[5]}</p>
        <button class="cart_add_product"> + </button>
      </div>
    </div>`;

}
//--秀出初始加總後的金額並寫進總計欄--//
document.querySelector('.cart_price_total').textContent = total;

//--加減商品數量--//
let cartProduct = document.querySelectorAll('.cart_product');
let cutProductBtn = document.querySelectorAll('.cart_cut_product');
let addProductBtn = document.querySelectorAll('.cart_add_product');
let productNumber = document.querySelectorAll('.cart_product_number');
for (let k = 0; k < cartProduct.length; k++) {
  let productValue = parseInt(productNumber[k].textContent);
  cutProductBtn[k].addEventListener('click', () => {

    if (productValue == 1) {
      confirm('確定刪除商品嗎？');
      cartProduct[k].parentNode.removeChild(cartProduct[k]);

      storage.removeItem(cartProducts[k]);
      storage[`myCartList`] = storage[`myCartList`].replace(`${cartProducts[k]},`, '');
      ////////------------搞定-------------//////////

    } else {
      productValue--;
      productNumber[k].textContent = productValue;
      // console.log(cartProducts[k]);
    }
  });
  // console.log(cartProducts[k]);
  addProductBtn[k].addEventListener('click', () => {
    productValue++;
    productNumber[k].textContent = productValue;
  });
}

//--計算調整後的購物車總金額--//
for (let i = 0; i < cartProduct.length; i++) {
  cutProductBtn[i].addEventListener('click', () => {
    let cartNewTotal = document.querySelector('.cart_price_total');
    let cartProductN = document.querySelectorAll('.cart_product');
    let newProductPrice = document.querySelectorAll('.cart_product_price');
    let newProductNumber = document.querySelectorAll('.cart_product_number');
    let newTotal = 0;
    for (let n = 0; n < cartProductN.length; n++) {
      newTotal += (parseInt(newProductPrice[n].textContent) * parseInt(newProductNumber[n].textContent));
    }
    cartNewTotal.textContent = newTotal;
  });
  addProductBtn[i].addEventListener('click', () => {
    let cartNewTotal = document.querySelector('.cart_price_total');
    let cartProductN = document.querySelectorAll('.cart_product');
    let newProductPrice = document.querySelectorAll('.cart_product_price');
    let newProductNumber = document.querySelectorAll('.cart_product_number');
    let newTotal = 0;
    for (let n = 0; n < cartProductN.length; n++) {
      newTotal += (parseInt(newProductPrice[n].textContent) * parseInt(newProductNumber[n].textContent));
    }
    cartNewTotal.textContent = newTotal;
  });
}