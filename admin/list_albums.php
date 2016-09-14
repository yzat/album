<?php
    require __DIR__."/../database_class/database.php";
    $nowTime=time();

    $db->orderBy("list_order","desc");
    $data=$db->get('albums');

?>

<button type="button" class="btn btn-success" data-toggle="modal" data-target="#add_album" id="button_add">add</button>
<?php
foreach($data as $key=>$row):
    $description=$row['album_description'];
    $desc= htmlspecialchars_decode($description);
    $description=strip_tags($desc,'<br/>');
?>
    <div class="col-sm-2 <?php echo $key;?>" id="album_<?php echo $row['id'];?>">
        <div class="panel panel-primary">
            <div class="dropdown">
                <a  class="dropdown-toggle"  data-toggle="dropdown">
                    <span class="glyphicon glyphicon-menu-hamburger" id="icon_menu"></span>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="#" onclick="javascript:edit_album(this);return false;"
                           data-album_id="<?php echo $row['id'];?>"
                           data-album_name="<?php echo $row['album_name'];?>"
                           data-album_description="<?php echo $description;?>"
                           data-album_image="<?php echo $row['album_image'];?>"
                           data-move="from_ad_index"
                           data-toggle="modal"
                           data-target="#modal_edit_album"
                        >
                            Редактировать
                        </a>
                    </li>
                    <li>
                        <a href="#"  onclick="javascript:sort_albums();return false;">
                            Сортировать
                        </a>
                    </li>
                    <li>
                        <a href="#" onclick="javascript:return confirm('Вы действительно хотите удалить?') && delete_album(this);return false;"
                           data-album_image="<?php echo $row['album_image'];?>"
                           data-album_id="<?php echo $row['id'];?>"
                        >
                            Удалить
                        </a>
                    </li>
                </ul>
            </div>
            <a href="view_album.php?album_id=<?php echo $row['id'];?>">
				<div class="panel-body body" >
					<img src="../uploads/main_image/<?php echo $row['album_image'];?>" class="img-responsive main_image"  alt="Image">
				</div>
				<div class="panel-footer" style="max-height:10;">
					<?php echo $row['album_name'];?>
				</div>
			</a>
        </div>
    </div>
<?php
endforeach;

?>
<div class="container pagination">
    <div class="row">
        <div id="pagination_controls"><?php echo $paginationCtrls;?></div>
    </div>

</div>