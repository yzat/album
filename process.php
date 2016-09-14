<?php
require __DIR__."/database_class/db_bez_ses.php";
$target=$_REQUEST['target'];
$back=array();

if($target=='avtorizasia_user'){
//         echo "<pre>"; print_r(@$_POST); "</pre>";die;
    $login=$_POST['login'];
    $password=md5($_POST['password']);
    $db->where('login',$login);
    $db->where('password',$password);
    $data=$db->get('admin');
    if(count($data)>0){
        $back['error']=0;
        $db->where('login',$login);
        $db->where('password',$password);
        $data=$db->getOne('admin');
//            print_r($data);
        $_SESSION['user_id']=$data['id'];
        $_SESSION['user']='i_user_in_this_website';
    }else{
        $back['error']=1;
        $back['result']='Не корректно ввели логин и пароль!';
    }
}


  echo json_encode($back);

?>