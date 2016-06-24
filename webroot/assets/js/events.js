
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
    