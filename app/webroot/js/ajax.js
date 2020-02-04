$(function(){
    //prefectureセレクタが選択された時の非同期処理
    $('#prefecture').on('change', function(){
        var preVal = $(this).val();
        $.ajax({
            url: "/imports/cityShow",
            type: "POST",
            dataType: 'json',
            data: { prefecture: preVal }
        }).done(function(data){
            //map で option タグのオブジェクトを生成しておいて、ループの外で append　する
            var arr = $.map(data, function(val, index) {
                $option = $("<option>", {value: val, text:val});
                return $option;
            });
            //子要素を削除してから追加
            $('#city').empty().append(arr);
            $('#town').empty();
        }).fail(function(XMLHttpRequest, textStatus, errorThrown){
            alert("エラーが発生しました。");
            console.log("XMLHttpRequest : " + XMLHttpRequest.status);
            console.log("textStatus     : " + textStatus);
            console.log("errorThrown    : " + errorThrown.message);
        });
    });

    //cityセレクタが選択された時の非同期処理
    $('#city').on('change', function(){
        var cityVal = $(this).val();
        $.ajax({
            url: "/imports/townShow",
            type: "POST",
            dataType: 'json',
            data: { city: cityVal }
        }).done(function(data){
            var arr = $.map(data, function(val, index) {
                $option = $("<option>", {value: val, text:val});
                return $option;
            });
            $('#town').empty().append(arr);
        }).fail(function(XMLHttpRequest, textStatus, errorThrown){
            alert("エラーが発生しました。");
            console.log("XMLHttpRequest : " + XMLHttpRequest.status);
            console.log("textStatus     : " + textStatus);
            console.log("errorThrown    : " + errorThrown.message);
        });
    });
});