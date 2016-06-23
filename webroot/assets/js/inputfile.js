$('#profile_picture_path').change(function() {
     var file = $('#profile_picture_path').prop('files')[0];
     if ( file.type == 'image/png' || file.type == 'image/jpg' || file.type == 'image/jpeg') {
         //空のimgタグにプレビューを挿入
         var fr = new FileReader();
         fr.onload = function() {
             $('#preview').attr('src', fr.result ).css('display','inline');
             $('#label').text('');
         }
         fr.readAsDataURL(file);
       } else {
         $('#preview').attr('src', '').css('display','none');
         $('#label').text('You can choose only jpg or png file');
       }
       //display: none;で隠したinputタグのfile情報をphotoCoverに渡す
         $('#photoCover').val($('#profile_picture_path').val().replace("C:\\fakepath\\", ""));
 });