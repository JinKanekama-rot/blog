$(function(){
    let target;
    let $this;

    //モーダルフェイドイン
    $('.display').on('click',function(){
        $this = $(this);
        target = $this.attr('id');
        $('.'+ target).addClass('show').fadeIn();
    });
    //モーダルフェイドアウト 
    $('.end').on('click',function(){
        $('.popup').fadeOut();
    });

    const popups = $('.popup');

    //スライドショー
    $('.next').click(() => {
        popups.eq(target).fadeOut();
        target = ++target % popups.length;
        popups.eq(target).addClass('show').fadeIn();

    })

    $('.rev').click(() => {
        popups.eq(target).fadeOut();
        target = --target % popups.length;
        popups.eq(target).fadeIn();

    })
});
