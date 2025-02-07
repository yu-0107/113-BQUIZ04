<?php include_once "db.php";

$chk=$Mem->count($_GET);

if($chk){
    echo 1;
    $_SESSION['login']=$_POST['acc'];
}else{
    echo 0;
}