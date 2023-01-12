// スムーススクロール
$(function(){
    $('a[href^="#"]').click(function(){
        const speed = 800;
        const href= $(this).attr("href");
        const target = $(href == "#" || href == "" ? 'html' : href);
        const position = target.offset().top-90;
        
        $("html, body").animate({scrollTop:position}, speed, "swing");
        return false;
    });
});

// スクロールアニメーション
window.addEventListener("scroll", function(){

  // 固定ボタン表示/非表示
  const fixedBtn = document.getElementById("fixed_btn");
  const introduction = document.getElementById("introduction");
  const contact = document.getElementById("contact");

  let introductionPosition = introduction.getBoundingClientRect().top;
  let contactPosition = contact.getBoundingClientRect().top;
  let screenPosition = window.innerHeight;
  
  if(contactPosition*1.1 < screenPosition){
    fixedBtn.classList.add("hidden");
  } else if(introductionPosition*1.1 < screenPosition){
    fixedBtn.classList.remove("hidden");
  } else {
    fixedBtn.classList.add("hidden");
  }

});

// youtubeモーダル
$(function(){
  $('.js-modal-video').modalVideo({
    channel: 'youtube',
    youtube: {
      autoplay: 0
    }
  });
});

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
