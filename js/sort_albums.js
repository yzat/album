    $(document).ready(function(){
        $(function () {
            $(".grid").sortable({
                tolerance: 'pointer',
                revert: 'invalid',
                placeholder: ' well placeholder tile',
                forceHelperSize: true,
                update:function(){
                    var order=$(this).sortable('serialize')+'&target=edit_listOrder';
                    $.post("process.php", order, function(theResponse){
                    });

                }
            });
        });
    });
// for sort image in gallery
    $(document).ready(function(){
        $(function () {
            $(".sort_images").sortable({
                tolerance: 'pointer',
                revert: 'invalid',
                placeholder: ' well_gal placeholder_gal tile_gal',
                forceHelperSize: true,
                update:function(){
                    var order=$(this).sortable('serialize')+'&target=edit_listOrder_gallery_image';
                    $.post("process.php", order, function(theResponse){
                        $('.close,.btn_close_gal').click(function(){
                            var album_id=$('.sort_images').attr('id');
                            $('#list_gallery_images').load('list_gal_images.php?album_id='+album_id);
                        });
                    });

                }
            });
        });
    });
