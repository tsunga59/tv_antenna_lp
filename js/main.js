<<<<<<< HEAD
// ロード後アニメーション
// window.addEventListener("load", function() {

//     const top = document.querySelector(".top");
//     top.classList.remove("hidden");
//     top.classList.add("loaded");

//     setTimeout(function() {

//         const fixedBtn = document.getElementById("fixed_btn");
//         const fixedBtnSP = document.getElementById("fixed_btn_sp");

//         fixedBtn.classList.add("appear");
//         fixedBtnSP.classList.add("appear");

//     }, 1000);

// });

// window.addEventListener("scroll", function() {
//     // ヘッダー固定
//     const header = document.getElementById("header");
//     const main = document.getElementById("main");
//     const screenTop = window.screenTop;
//     const mainTop = main.getBoundingClientRect().top;
//     if (mainTop < screenTop + 80) {
//         header.classList.add("fixed");
//     } else {
//         header.classList.remove("fixed");
//     }
// });

=======
>>>>>>> origin/develop
// スムーススクロール
$(function(){
    $('a[href^="#"]').click(function(){
        const speed = 800;
        const href= $(this).attr("href");
        const target = $(href == "#" || href == "" ? 'html' : href);
<<<<<<< HEAD
        const position = target.offset().top;
=======
        const position = target.offset().top-90;
>>>>>>> origin/develop
        
        $("html, body").animate({scrollTop:position}, speed, "swing");
        return false;
    });
});

<<<<<<< HEAD
// ハンバーガーメニュー
const header = document.getElementById("header");
const menuBtn = document.getElementById("menu_btn");
let menuOpen = false;
menuBtn.addEventListener("click", function() {
    if (!menuOpen) {
        header.classList.add("open");
        menuOpen = true;
    } else {
        header.classList.remove("open");
        menuOpen = false;
    }
});

// window.addEventListener("scroll", function() {

//     // フェードイン
//     let fadeInObj = document.querySelectorAll('.fade_in');
    
//     for (let i = 0; i < fadeInObj.length; i++) {
        
//       const objPosition = fadeInObj[i].getBoundingClientRect().top;
    
//       if (objPosition < screenPosition * 0.7) {
//           fadeInObj[i].classList.add('scroll_in');
//       } else {
//           // fadeInObj[i].classList.remove('scroll_in');
//       }
    
//     }

// });
=======
// お問い合わせフォームバリデーション
$(function(){
    var validator = $('.contact_form').validate({
      rules: {
        "お名前": "required",
        "電話番号": "required",
        "メールアドレス": "required",
      },
      messages: {   
        "お名前": {
          required: "お名前を入力してください",
        },   
        "電話番号": {
          required: "電話番号を入力してください",
        },   
        "メールアドレス": {
            required: "メールアドレスを入力してください",
            email: "メールアドレスを正しく入力してください。",
        },
      },
    });
});
>>>>>>> origin/develop
