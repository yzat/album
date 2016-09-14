<?php
require __DIR__."/../database_class/database.php";
$nowTime=time();

$db->orderBy("list_order","desc");
$data=$db->get('albums');
//var_dump($data);
?>
<link rel="stylesheet" href="../css/style_sort.css">
<script id="sample" src="../js/sort_albums.js" ></script>

<button type="button" class="btn btn-success button_back" href="#" onclick="javascript:back_load_albums();return false;" >Назад</button>
<?php
    foreach($data as $row):
?>
    <div id="listOrder_<?php echo $row['id'];?>" class="col-sm-2 well  tile ">
        <div class="panel panel-primary">
            <div class="panel-body body" >
                <img src="../uploads/main_image/<?php echo $row['album_image'];?>" class="img-responsive main_image"  alt="Image">
            </div>
            <div class="panel-footer" style="max-height: 10;">
                <?php echo $row['album_name'];?>
            </div>
        </div>
    </div>
<?php
    endforeach;
?>

