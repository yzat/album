// function for send image_name for view in modal call in list_gal_images.php
function zoom_image_gall(value){
    var image=$(value).data('image');
    var image_desc=$(value).data('image_desc');
    $('#zoom_img').attr('src','uploads/gallery_images/'+image);
    $('#image_desc_in_modal').text(image_desc);
}