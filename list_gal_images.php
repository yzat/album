<?php
require __DIR__."/database_class/db_bez_ses.php";
$album_id=$_GET['album_id'];
//get gallery images this album
$db->where('album_id',$album_id);
$db->orderBy("list_order","desc");
$gal_images=$db->get('album_gallery');

    foreach($gal_images as $image):
?>
        <div class="panel panel-default img_content">
             <a href="#"  onclick="javascript:zoom_image_gall(this);return false;"
                        data-image="<?php echo $image['image_gallery'];?>"
                        data-image_desc="<?php echo $image['image_desc'];?>"
                        data-toggle="modal"
                        data-target="#modal_view_full_zoom">
                <div class="panel-heading panel_head_gal">
                    <?php echo $image['image_desc'];?>
                </div>
                <div class="gal_body">
                    <img src="uploads/gallery_images/<?php echo $image['image_gallery'];?>" class="img-responsive gal_image"  alt="Image">
                </div>
            </a>
        </div>

    <?php
endforeach;
?>
