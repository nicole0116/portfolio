var bg = document.getElementsByClassName('f_bg')[0];

function labar(){
    var x = window.pageYOffset;

    // console.log(x);
    if (x<50){
        bg.style.height = 200+'px';
    }else if (x>1700){
       
        bg.style.height = x +600 + 'px';
    }else{
        bg.style.height = x +300 + 'px';
    }
}

function init(){
    if (window.innerWidth >=1200){
        window.addEventListener('scroll',labar,false);
    }
    // }else if (window.innerWidth <= 767){
    //     window.addEventListener('scroll',labar_xs,false);
    // }
    bg.style.height = '0px';
}

window.addEventListener('load',init,false);


