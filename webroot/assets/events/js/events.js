  $(document).ready(function(){
  google.maps.event.addDomListener(window, 'load', initialize);
  $('#confirm').attr('disabled', false);
});

 function initialize() {
       //searchTextFieldを取得し変数に格納
     var input = document.getElementById('searchTextField');

     var options = {
       //フィリピン国内のみ表示するよう指定
         componentRestrictions: {country: 'ph'}
     };

     var autocomplete = new google.maps.places.Autocomplete(input, options);
     google.maps.event.addListener(autocomplete, 'place_changed', function () {
         $('#loading').css('display', 'inline');
         var place = autocomplete.getPlace();
         //場所名と緯度経度を取得
         $('#place_name').attr('value', place.name);
         $('#lat').attr('value', place.geometry.location.lat());
         $('#lng').attr('value', place.geometry.location.lng());
         $('#loading').css('display', 'none');
         if (  $('#title').val()         !=='' 
            && $('#date').val()          !=='' 
            && $('#starting_time').val() !=='' 
            && $('#detail').val()        !=='') 
         {
         $('#confirm').attr('disabled', false);
            }
         });
 }

 //Placeに何か変更があった場合confirmを無効にする
 $('#searchTextField').keydown(function() {
     $('#confirm').attr('disabled', true);
 });

 //3つある画像のプレビューを共通の関数で処理するためにそれぞれのidを取得する関数
 $('.pic').change(function(){
     console.log('preview振り分け');
     var picId = $(this).attr('id');
     preview(picId);
 });
 //実際に画像のプレビューを行う関数
 function preview(id) {
     console.log('preview');
     var file = $('#' + id).prop('files')[0];
     var num = id.slice(-1);
     var previewId = 'preview' + num;
     var labelId = 'label' + num;
     var photoCoverId = 'photoCover' + num;
     //png, jpg, jpegのどれにも一致しない場合注意文を表示
     if ( file.type == 'image/png' || file.type == 'image/jpg' || file.type == 'image/jpeg') {
         //空のimgタグにプレビューを挿入
         var fr = new FileReader();
         fr.onload = function() {
             $('#' + previewId).attr('src', fr.result ).css('display','inline');
             $('#' + labelId).text('');
         }
         fr.readAsDataURL(file);
       } else {
         $('#' + previewId).attr('src', '').css('display','none');
         $('#' + labelId).text('You can choose only jpg or png file');
       }
       //display: none;で隠したinputタグのfile情報をphotoCoverに渡す
         $('#' + photoCoverId).val($('#' + id).val().replace("C:\\fakepath\\", ""));
     }

$('.form-control').change(function() {
    if (       $('#title').val()         !=='' 
            && $('#date').val()          !=='' 
            && $('#starting_time').val() !=='' 
            && $('#detail').val()        !==''
            && $('#place_name').val()    !==''
            && $('#lat').val()           !==''
            && $('#lng').val()           !=='') 
         {
         $('#confirm').attr('disabled', false);
            } else {
              $('#confirm').attr('disabled', true);
            }
        });
    