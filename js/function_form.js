// function for pagination
function pagination(pagenum){
    $(document).ready(function(){
        $('#list_albums').load("list_albums.php?pn="+pagenum);
    });
}
// function for delete image in gallery call in list_gal_images.php
function delete_image_in_gallery(value){
    var image=$(value).data('image');
    var image_id=$(value).data('image_id');
    var album_id=$(value).data('album_id');
    var sendpost={'image':image,'image_id':image_id,'album_id':album_id,'target':'delete_image_in_gallery'};
    $.ajax({
        url: 'process.php',
        type: 'POST',
        data: sendpost,
        enctype: 'multipart/form-data',
        dataType: 'json',
        success: function (data) {
            if(data.error==0){
                $('#list_gallery_images').load('list_gal_images.php?album_id='+data.album_id);
                $('#count_images').text('кол-во изображений: '+data.count_images);
            }
        }
    });
}
// function for edit image_desc in gallery call in list_gal_images.php
function edit_image_desc(value){
    var image_desc=$(value).data('image_desc');
    var image_id=$(value).data('image_id');
    var album_id=$(value).data('album_id');

    $('#image_desc_gal').val(image_desc);
    $('#image_id_gal').val(image_id);
    $('#album_id_gal').val(album_id);
}
function edit_image_in_gallery(){
    var sendpost=$('#form_edit_image_desc_gal').serialize();
    $.ajax({
        url: 'process.php',
        type: 'POST',
        data: sendpost,
        enctype: 'multipart/form-data',
        dataType: 'json',
        success: function (data) {
            if(data.error==0){
                $('#list_gallery_images').load('list_gal_images.php?album_id='+data.album_id);
                $('#modal_edit_image_desc .close').click();
                $('#form_edit_image_desc_gal')[0].reset();
            }
        }
    });
}
// function for send image_name for view in modal call in list_gal_images.php
function zoom_image_gall(value){
    var image=$(value).data('image');
    var image_desc=$(value).data('image_desc');
    $('#zoom_img').attr('src','../uploads/gallery_images/'+image);
    $('#image_desc_in_modal').text(image_desc);
}
// function for add image in gallery view_album.php
function add_image_gallery(){
    var sendpost=new FormData(document.getElementById('form_add_image_gallery'));
    $.ajax({
        url: 'process.php',
        type: 'POST',
        data: sendpost,
        enctype: 'multipart/form-data',
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function (data) {
            var new_image="<div class='panel panel-default img_content'>"+
                            "<div class='dropdown'>"+
                                "<a  class='dropdown-toggle'  data-toggle='dropdown'>"+
                                    "<span class='glyphicon glyphicon-menu-hamburger' id='icon_gal_menu'></span>"+
                                "</a>"+
                                "<ul class='dropdown-menu'>"+
                                    "<li>"+
                                        "<a href='#' onclick='javascript:edit_image_desc(this);return false;'"+
                                            "data-image_desc='"+data.image_desc+"'"+
                                            "data-image_id='"+data.image_id+"'"+
                                            "data-album_id='"+data.album_id+"'"+
                                            "data-toggle='modal'"+
                                            "data-target='#modal_edit_image_desc'"+
                                        ">"+
                                            "Редактировать"+
                                        "</a>"+
                                    "</li>"+
                                    "<li>"+
                                        "<a href='#' onclick='javascript:return confirm(`Вы действительно хотите удалить?`) && delete_image_in_gallery(this);return false;'"+
                                            "data-image='"+data.image+"'"+
                                            "data-image_id='"+data.image_id+"'"+
                                            "data-album_id='"+data.album_id+"'"+
                                            ">"+
                                            "Удалить"+
                                        "</a>"+
                                    "</li>"+
                                "</ul>"+
                            "</div>"+
                            "<a href='#'  onclick='javascript:zoom_image_gall(this);return false;'"+
                                "data-image='"+data.image+"'"+
                                "data-image_desc='"+data.image_desc+"'"+
                                "data-toggle='modal'"+
                                "data-target='#modal_view_full_zoom'"+
                            ">"+
                                "<div class='panel-heading panel_head_gal'>"+
                                    ""+data.image_desc+""+
                                "</div>"+
                                "<div class='gal_body'>"+
                                    "<img src='../uploads/gallery_images/"+data.image+"' class='img-responsive gal_image'  alt='Image'>"+
                                "</div>"+
                            "</a>"+
                        "</div>";
            $('#list_gallery_images').prepend(new_image);

            var in_sort="<div id='OrderImg_"+data.image_id+"' class='col-sm-2 well_gal  tile_gal gal_img'>"+
                                "<div class='panel panel-primary'>"+
                                    "<div class='panel-body'>"+
                                        "<img src='../uploads/gallery_images/"+data.image+"' class='img-responsive main_image'  alt='Image'>"+
                                    "</div>"+
                                "</div>"+
                            "</div>";
            $('.sort_images').prepend(in_sort);
            $('#count_images').text('кол-во изображений: '+data.count_images);
            $('#modal_add_gallery_image .close').click();
            $('#form_add_image_gallery')[0].reset();
        }
    });
}
// function for edit album in list_albums.php
function edit_album(value){
    var album_id=$(value).data('album_id');
    var album_name=$(value).data('album_name');
    var album_description=$(value).data('album_description');
    var album_image=$(value).data('album_image');
    var move=$(value).data('move');

    $('#album_id').val(album_id);
    $('#album_name').val(album_name);
    $('#album_description').val(album_description);
    $('#album_image').val(album_image);
    $('#move').val(move);

}
function send_data_for_edit_album(){
    var move=$('#move').val();
    if(move=='from_ad_index'){
        var sendpost=new FormData(document.getElementById('form_edit_album'));
        $.ajax({
                url: 'process.php',
                type: 'POST',
                data: sendpost,
                enctype: 'multipart/form-data',
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function (data) {
                    var album_description=data.album_description;
                    var description= album_description.replace(/<\/?[^>]+>/gi, '');
                    var edit_album="<div class='panel panel-primary'>"+
                                        "<div class='dropdown'>"+
                                            "<a  class='dropdown-toggle'  data-toggle='dropdown'>"+
                                                "<span class='glyphicon glyphicon-menu-hamburger' id='icon_menu'></span>"+
                                            "</a>"+
                                            "<ul class='dropdown-menu'>"+
                                                "<li>"+
                                                    "<a href='#' onclick='javascript:edit_album(this);return false;'"+
                                                        "data-album_id='"+data.album_id+"'"+
                                                        "data-album_name='"+data.album_name+"'"+
                                                        "data-album_description='"+description+"'"+
                                                        "data-album_image='"+data.album_image+"'"+
                                                        "data-toggle='modal'"+
                                                        "data-target='#modal_edit_album'"+
                                                        ">"+
                                                        "Редактировать"+
                                                    "</a>"+
                                                "</li>"+
                                                "<li>"+
                                                    "<a href='#'  onclick='javascript:sort_albums();return false;'>"+
                                                        "Сортировать"+
                                                    "</a>"+
                                                "</li>"+
                                                "<li>"+
                                                    "<a href='#' onclick='javascript:return confirm(`Вы действительно хотите удалить?`) && delete_album(this);return false;'"+
                                                        "data-album_image='"+data.album_image+"'"+
                                                        "data-album_id='"+data.album_id+"'"+
                                                        ">"+
                                                        "Удалить"+
                                                    "</a>"+
                                                "</li>"+
                                            "</ul>"+
                                        "</div>"+
                                        "<a href='view_album.php?album_id="+data.album_id+"'>"+
                                            "<div class='panel-body'>"+
                                            "<img src='../uploads/main_image/"+data.album_image+"' class='img-responsive main_image'  alt='Image'>"+
                                            "</div>"+
                                            "<div class='panel-footer' style='max-height: 10;'>"+
                                                ""+data.album_name+""+
                                            "</div>"+
                                        "</a>"+
                                "</div>";
                    $('#album_'+data.album_id).html(edit_album);
                    $('#form_edit_album')[0].reset();
                    $('#modal_edit_album .close').click();
                }
        });
    }else if(move=='from_album_content'){
        var sendpost=new FormData(document.getElementById('form_edit_album'));
        $.ajax({
            url: 'process.php',
            type: 'POST',
            data: sendpost,
            enctype: 'multipart/form-data',
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (data) {
                $('#album_content').load("album_content.php?album_id="+data.album_id);
                $('#form_edit_album')[0].reset();
                $('#modal_edit_album .close').click();
            }
        });
    }
}
// function for delete albums in list_albums.php
function delete_album(value){
    var album_image=$(value).data('album_image');
    var album_id=$(value).data('album_id');
    var sendpost={'album_image':album_image,'album_id':album_id,'target':'delete_album'};
    $.ajax({
        url: 'process.php',
        type: 'POST',
        data: sendpost,
        enctype:'multipart/form-data',
        dataType:'json',
        success: function(data){
                $('#album_'+data.album_id).remove();
            }
        });
}
// function for button Назад in sort.php
function back_load_albums(){
    $('#list_albums').remove();
    $('.col-sm-7').html("<h1>Welcome</h1><div class='row' id='list_albums'></div><br>");
    $('#list_albums').load("list_albums.php");
}

// function for load sort.php from ad_index.php
function sort_albums(){
    $('#list_albums').addClass('grid').load("sort_albums.php");
}
// function for add album
function add_album(){
    var sendpost=new FormData(document.getElementById('form_add_album'));
    $.ajax({
        url: 'process.php',
        type: 'POST',
        data: sendpost,
        enctype:'multipart/form-data',
        contentType: false,
        processData: false,
        dataType:'json',
        success: function(data){
            var NewAlbum="<div class='col-sm-2' id='album_"+data.album_id+"'>"+
                            "<div class='panel panel-primary'>"+
                                "<div class='dropdown'>"+
                                "<a  class='dropdown-toggle'  data-toggle='dropdown'>"+
                                    "<span class='glyphicon glyphicon-menu-hamburger' id='icon_menu'></span>"+
                                "</a>"+
                                "<ul class='dropdown-menu'>"+
                                    "<li>"+
                                        "<a href='#' onclick='javascript:edit_album(this);return false;'"+
                                            "data-album_id='"+data.album_id+"'"+
                                            "data-album_name='"+data.album_name+"'"+
                                            "data-album_description='"+data.album_description+"'"+
                                            "data-album_image='"+data.album_image+"'"+
                                            "data-toggle='modal'"+
                                            "data-target='#modal_edit_album'"+
                                            ">"+
                                            "Редактировать"+
                                        "</a>"+
                                    "</li>"+
                                    "<li>"+
                                        "<a href='#'  onclick='javascript:sort_albums();return false;'>"+
                                            "Сортировать"+
                                        "</a>"+
                                    "</li>"+
                                    "<li>"+
                                        "<a href='#' onclick='javascript:return confirm(`Вы действительно хотите удалить?`) && delete_album(this);return false;'"+
                                            "data-album_image='"+data.album_image+"'"+
                                            "data-album_id='"+data.album_id+"'"+
                                        ">"+
                                            "Удалить"+
                                        "</a>"+
                                    "</li>"+
                                "</ul>"+
                                "</div>"+
                                "<a href='view_album.php?album_id="+data.album_id+"'>"+
                                    "<div class='panel-body'>"+
                                        "<img src='../uploads/main_image/"+data.album_image+"' class='img-responsive main_image'  alt='Image'>"+
                                    "</div>"+
                                    "<div class='panel-footer' style='max-height: 10;'>"+
                                        ""+data.album_name+""+
                                    "</div>"+
                                "</a>"+
                            "</div>"+
                        "</div>";
            $('#list_albums').prepend(NewAlbum);
            $('#add_album .close').click();
            $('#form_add_album')[0].reset();
        }
    });
}; //end funtion
