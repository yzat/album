<?php
    session_start();
    unset($_SESSION['user']);
    if(empty($_SESSION['user'])){
        echo "<script>window.location.href='../index.php'</script>";
    }
?>