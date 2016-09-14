//функция для авторизации на сайт index.php не в админ части
function login_avtoriz(){
    var data=$('#login_avtoriz').serialize();
//    alert(qw);
    $.ajax({
        url: "process.php",
        type: "POST",
        data: data,
        enctype: 'multipart/form-data',
        dataType: 'json',
        processData: false,  // tell jQuery not to process the data
//        contentType: false   // tell jQuery not to set contentType
        }).done(function (data) {
            //alert(data.error);
            if (data.error == '0') {
              window.location.href = "admin/ad_index.php";
              $('#login_avtoriz').trigger('close');
              $('#login_avtoriz')[0].reset();
            }else{
                if(data.error=='1'){
                    $('#login_error').html(data.result).css('color','red');
                    $('#login_av').css("border","red solid 2px").click(function(){
                        $('#login_error').html('<p id=login_error></p>');
                        $('#login_av').css("border","grey solid 2px");
                    });
                    $('#login_error').html(data.result).css('color','red');
                    $('#pwd_av').css("border","red solid 2px").click(function(){
                        $('#login_error').html('<p id=login_error></p>');
                        $('#pwd_av').css("border","grey solid 2px");
                    });
                }
            }
    });
}
    

//функция для регистрации пользователя index.php не в админ части
function registration(){
    $.ajax({
            url: "process.php",
            type: "POST",
            data: $('#reginfo').serialize(),
            enctype: 'multipart/form-data',
            dataType: 'json',
//            processData: false,  // tell jQuery not to process the data
//            contentType: false   // tell jQuery not to set contentType
          }).done(function (data) {
            //alert(data.error);
            if (data.error == '0') {
              window.location.href = "admin/ad_index.php";
              $('#sign_up').trigger('close');
            }
            else {
                if(data.result==1){
                    $('#pass2-error').html(data.error).css('color','red');
                    $('#login').css("border","red solid 2px").click(function(){
                        $('#pass2-error').html('<p id=pass2-error></p>');
                        $('#login').css("border","grey solid 2px");
                    });
                }
                if(data.result==2){
                    $('#pass2-error').html(data.error).css('color','red');
                    $('#pwd1,#pwd2').css("border","red solid 2px").click(function(){
                        $('#pwd1,#pwd2').css("border","grey solid 2px");
                        $('#pass2-error').html('<p id=pass2-error></p>');
                    });
                }
                if(data.result==3){
                    $('#pass2-error').html(data.error).css('color','red');
                    $('#email').css("border","red solid 2px").click(function(){
                        $('#email').css("border","grey solid 2px");
                        $('#pass2-error').html('<p id=pass2-error></p>');
                    });
                }
            }
            console.log("PHP Output:");
            console.log(data);
          });
          return false;
}
