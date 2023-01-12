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


// youtubeモーダル
$(function(){
  $('.js-modal-video').modalVideo({channel: 'youtube', youtube: {autoplay: 0}});
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
