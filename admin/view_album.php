<?php
require __DIR__."/../database_class/database.php";
$album_id=$_GET['album_id'];
$nowTime=time();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/content_style.css">
    <link rel="stylesheet" href="../css/jquery-ui.css">
    <link rel="stylesheet" href="../css/style_sort.css">


    <script src="../js/jquery_min.js"></script>
    <script src="../js/jquery-ui.min.js"></script>
    <!--    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>-->
    <!--    <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>-->
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/function_log_reg.js"></script>
    <script src="../js/function_form.js"></script>
    <script id="sample" src="../js/sort_albums.js" ></script>

</head>
<script>$.ajaxPrefilter(function( options, originalOptions, jqXHR ) { options.async = true; });</script>
<body>
<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="ad_index.php">GAL</a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
                <li><a href="ad_index.php">Albums</a></li>
                <li class="active"><a href="view_album.php?album_id=<?php echo $album_id;?>">View</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="logout.php" ><span class="glyphicon glyphicon-log-out"></span> exit</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid text-center">
    <div class="row content">
        <div class="container col-sm-9 text-left">
            <div class="row " id="album_content"></div><br>
        </div>
        <script>
            $('#album_content').load("album_content.php?album_id=<?php echo $album_id;?>");
        </script>
        <div class="col-sm-3 sidenav">
            <div class="well">
                <p>ADS</p>
            </div>
            <div class="well">
                <p>ADS</p>
            </div>
        </div>
    </div>
</div>
<footer class="container-fluid text-center">
    <p>Footer Text</p>
    <p>Footer Text</p>
    <p>Footer Text</p>
    <p>Footer Text</p>
    <p>Footer Text</p>
</footer>
<!-- Modal for add image in gallery-->
<div class="modal fade" id="modal_add_gallery_image" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h2>Add In Gallery Image</h2>
            </div>
            <div class="modal-body">
                <form id="form_add_image_gallery" action="javascript:void(0);" onSubmit="javascript:add_image_gallery(this);return false;" role="form">
                    <div class="form-group">
                        <label for="name">Image Name:</label>
                        <input type="text" name="image_desc" maxlength="20" class="form-control" id="name">
                        <input type="hidden" name="album_id" value="<?php echo $album_id;?>" class="form-control" >
                        <input type="hidden" name="target" value="add_image_in_gallery" class="form-control" >
                    </div>
                    <div class="form-group">
                        <label for="image">Choose Image:</label>
                        <input type="file" name="image" class="form-control" id="image" required>
                    </div>
                    <button type="submit" class="btn btn-success">Save</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
</div><!--end div modal-->

<!-- Modal for sort image in gallery-->
<div class="modal fade" id="modal_sort_images" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content modal_content_width">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Sort Image</h4>
            </div>
            <div class="modal-body">
                <div class="row sort_images" id="<?php echo $album_id;?>">
                <?php
                    $db->where('album_id',$album_id);
                    $db->orderBy("list_order","desc");
                    $gal_images=$db->get('album_gallery');
                    foreach($gal_images as $row):
                ?>
                    <div id="OrderImg_<?php echo $row['id'];?>" class="col-sm-2 well_gal  tile_gal gal_img">
                        <div class="panel panel-primary">
                            <div class="panel-body " >
                                <img src="../uploads/gallery_images/<?php echo $row['image_gallery'];?>" class="img-responsive main_image"  alt="Image">
                            </div>
                        </div>
                    </div>
                <?php
                    endforeach;
                ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn_close_gal" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
</div><!--end div modal-->

<!-- Modal for edit image_desc in gallery-->
<div class="modal fade" id="modal_edit_image_desc" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Image</h4>
            </div>
            <div class="modal-body">
                <form id="form_edit_image_desc_gal" role="form" action="javascript:void(0);" onSubmit="javascript:edit_image_in_gallery();return false;">
                    <div class="form-group">
                        <label for="image_desc">Image Name:</label>
                        <input type="text" name="image_desc" maxlength="20" value="" class="form-control" id="image_desc_gal">
                        <input type="hidden" name="image_id" value="" class="form-control" id="image_id_gal">
                        <input type="hidden" name="album_id" value="" class="form-control" id="album_id_gal">
                        <input type="hidden" name="target" value="edit_image_desc_in gallery" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-default">Edit</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn_close_gal" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
</div><!--end div modal-->
<!-- Modal for zoom image in gallery-->
<div class="modal fade" id="modal_view_full_zoom" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><span id="image_desc_in_modal"></span></h4>
            </div>
            <img id="zoom_img" style="width:100%;">
        </div>
    </div>
</div><!--end div modal-->
<!-- Modal for edit album-->
<div class="modal fade" id="modal_edit_album" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Album</h4>
            </div>
            <div class="modal-body">
                <form id="form_edit_album" action="javascript:void(0);" onSubmit="javascript:send_data_for_edit_album(this);return false;" role="form">
                    <div class="form-group">
                        <label for="name">Album Name:</label>
                        <input type="text" name="album_name" value="" maxlength="16" class="form-control" id="album_name" required>
                        <input type="hidden" name="old_main_image" value=""  id="album_image" >
                        <input type="hidden" name="album_id" value=""  id="album_id" >
                        <input type="hidden" name="target" value="edit_album">
                        <input type="hidden" name="move" value="" id="move">
                    </div>
                    <div class="form-group">
                        <label for="file">Album File:</label>
                        <input type="file" name="new_main_img" class="form-control" id="file">
                    </div>
                    <div class="form-group">
                        <label for="comment">Album Comment:</label>
                        <textarea name="album_desc" class="form-control" rows="10" value=""  id="album_description" placeholder="Add description" ></textarea>
                    </div>
                    <button type="submit" class="btn btn-success">Save</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
</div><!--end div modal-->

</body>
</html>

