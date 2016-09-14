<?php
require __DIR__."/../database_class/database.php";
$album_id=$_GET['album_id'];
$db->where('id',$album_id);
$album_data=$db->getOne('albums');
//get count images in gallery
$db->where('album_id',$album_id);
$count_images=$db->getValue('album_gallery',"count(*)");

?>
<div class="container">
    <div class="row" >
        <div class="col-sm-4">
        </div>
        <div class="col-sm-5">
            <h1><?php echo $album_data['album_name'];?></h1>
            (<?php
            $creat_date=$album_data['album_creat_date'];
            echo $CreatDate = date("d-m-Y", strtotime($creat_date));

            $description=$album_data['album_description'];
            $desc= htmlspecialchars_decode($description);
            $description=strip_tags($desc,'<br/>');
            ?>)
            <a href="#" onclick="javascript:edit_album(this);return false;"
               data-album_id="<?php echo $album_data['id'];?>"
               data-album_name="<?php echo $album_data['album_name'];?>"
               data-album_description="<?php echo $description;?>"
               data-album_image="<?php echo $album_data['album_image'];?>"
               data-move="from_album_content"
               data-toggle="modal"
               data-target="#modal_edit_album">
               <img src="../images/edit.png" id="icon_edit_album_content">
            </a>
        </div>
    </div>
    <div class="row" >
        <div class="col-sm-9">
            <p class="album_desc_con">
                <img class="main_image_con" src="../uploads/gallery_images/<?php echo $album_data['album_image'];?>">
                <?php echo $album_data['album_description'];?>
            </p>
        </div>
    </div>

<div class="container" >
    <div class="row" >
        <div class="col-sm-9">
            <div class="panel panel-default">
                <div class="panel-heading"><h3>Gallery</h3>
                    <span id="count_images">(кол-во изображений: <?php echo  $count_images ;?>)</span>
                    <a data-toggle="modal" data-target="#modal_sort_images">
                        <img src="../images/sort.png" id="icon_sort_galImg">
                    </a>
                    <a data-toggle="modal" data-target="#modal_add_gallery_image" >
                        <img src="../images/add.png" id="icon_add_galImg">
                    </a>
                </div>
                <div class="panel-body" id="list_gallery_images">
                    <script>
                            $('#list_gallery_images').load('list_gal_images.php?album_id=<?php echo $album_id;?>');
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
