<?php
    require __DIR__."/../database_class/database.php";
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

    <script src="../js/jquery_min.js"></script>
    <script src="../js/jquery-ui.min.js"></script>
<!--    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>-->
<!--    <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>-->
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/function_log_reg.js"></script>
    <script src="../js/function_form.js"></script>

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
                    <li class="active"><a href="ad_index.php">Albums</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="logout.php" ><span class="glyphicon glyphicon-log-out"></span> exit</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid text-center">
        <div class="row content">
            <div class="col-sm-2 sidenav">
                <div class="row">
                    <div class="well">
                        <p>ADS</p>
                    </div>
                    <div class="well">
                        <p>ADS</p>
                    </div>
                </div>
            </div>
            <div class="container col-sm-7 text-left">
                <h1>Welcome</h1>
                <div class="row " id="list_albums"></div><br>
            </div>
            <script>
                $('#list_albums').load("list_albums.php?pn=1");
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
    </footer>
    <!-- Modal for add album-->
    <div class="modal fade" id="add_album" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h2>Add Album</h2>
                </div>
                <div class="modal-body">
                    <form id="form_add_album" action="javascript:void(0);" onSubmit="javascript:add_album(this);return false;" role="form">
                        <div class="form-group">
                            <label for="name">Album Name:</label>
                            <input type="text" name="album_name" maxlength="20" class="form-control" id="name" required>
                            <input type="hidden" name="creat_date" value="<?php echo $nowTime;?>" class="form-control" >
                            <input type="hidden" name="target" value="add_new_album" class="form-control" >
                        </div>
                        <div class="form-group">
                            <label for="creat">Album Creat Date:</label>
                            <input type="date" name="album_creat_date" class="form-control" id="creat">
                        </div>
                        <div class="form-group">
                            <label for="file">Album File:</label>
                            <input type="file" name="album_file" class="form-control" id="file">
                        </div>
                        <div class="form-group">
                            <label for="comment">Album Comment:</label>
                            <textarea name="album_desc" class="form-control" rows="10"  id="comment" placeholder="Add description"></textarea>
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
                            <input type="text" name="album_name" value="" maxlength="20" class="form-control" id="album_name" required>
                            <input type="hidden" name="old_main_image" value=""  id="album_image" >
                            <input type="hidden" name="album_id" value=""  id="album_id" >
                            <input type="hidden" name="move" value="" id="move">
                            <input type="hidden" name="target" value="edit_album"  >
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

