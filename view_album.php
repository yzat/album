<?php
require __DIR__."/database_class/db_bez_ses.php";
$album_id=$_GET['album_id'];
$nowTime=time();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/content_style.css">

    <script src="js/jquery_min.js"></script>
    <!--    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>-->
    <!--    <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>-->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/function_log_reg.js"></script>
    <script src="js/zoom_image.js"></script>
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
                <a class="navbar-brand" href="index.php">GAL</a>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav">
                    <li><a href="index.php">Albums</a></li>
                    <li class="active"><a href="view_album.php?album_id=<?php echo $album_id;?>">View</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#" data-toggle="modal" data-target="#log_in"><span class="glyphicon glyphicon-log-in"></span></a></li>
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
<!-- Modal for log in-->
    <div id="log_in" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">log in</h4>
                </div>
                <div class="modal-body">
                    <!--form send in reg_process.php-->
                    <form action="javascript:void(0)" onSubmit="javascript:login_avtoriz()" role="form" id="login_avtoriz">
                        <div class="form-group">
                            <label for="login">login:</label>
                            <input type="text" name="login" class="form-control" id="login_av">
                        </div>
                        <div class="form-group">
                            <label for="pwd">Password:</label>
                            <input type="password" name="password" class="form-control" id="pwd_av">
                            <input type="hidden" name="target" value="avtorizasia_user" class="form-control" >
                        </div>
                        <div class="checkbox">
                            <label><input type="checkbox"> Remember me</label>
                        </div>
                        <button type="submit" class="btn btn-success">log in</button><br/><br/>
                        <p id="login_error"></p>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div><!--end div modal-form for login-->
</body>
</html>

