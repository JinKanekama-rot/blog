$(function(){
    $('#searchBtn').on('click', function(){
        var value = $('#code').val();
        if (value != ''){
            $.ajax({
                url: "/imports/search",
                type: "POST",
                dataType: 'json',
                data: { zipCode: value }
            }).done(function(data){
                if (data != false) {
                    $('#prefecture').html(data['Import']['prefectureOfKanji']);
                    $('#city').html(data['Import']['cityOfKanji']);
                    $('#town').html(data['Import']['townOfKanji']);
                } else {
                    alert("入力された郵便番号は存在しません。");
                }
            }).fail(function(XMLHttpRequest, textStatus, errorThrown){
                alert("エラーが発生しました。");
                console.log("XMLHttpRequest : " + XMLHttpRequest.status);
                console.log("textStatus     : " + textStatus);
                console.log("errorThrown    : " + errorThrown.message);
            });
        }   
    });

});