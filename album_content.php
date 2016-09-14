<?php
require __DIR__."/database_class/db_bez_ses.php";
$album_id=$_GET['album_id'];
$db->where('id',$album_id);
$album_data=$db->getOne('albums');

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
            ?>)
        </div>
    </div>
    <div class="row" >
        <div class="col-sm-9">
            <p class="album_desc_con">
                <img class="main_image_con" src="uploads/gallery_images/<?php echo $album_data['album_image'];?>">
                <?php echo $album_data['album_description'];?>
            </p>
        </div>
    </div>

<div class="container" >
    <div class="row" >
        <div class="col-sm-9">
            <div class="panel panel-default">
                <div class="panel-heading"><h3>Gallery</h3></div>
                <div class="panel-body" id="list_gallery_images">
                    <script>
                            $('#list_gallery_images').load('list_gal_images.php?album_id=<?php echo $album_id;?>');
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
