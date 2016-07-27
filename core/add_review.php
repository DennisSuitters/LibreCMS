<?php
include'db.php';
$config=$db->query("SELECT * FROM config WHERE id='1'")->fetch(PDO::FETCH_ASSOC);
$ip=$_SERVER['REMOTE_ADDR'];
$id=isset($_POST['id'])?filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT):filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$emailtrap=isset($_POST['emailtrap'])?filter_input(INPUT_POST,'emailtrap',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'emailtrap',FILTER_SANITIZE_STRING);
$rating=isset($_POST['rating'])?filter_input(INPUT_POST,'rating',FILTER_SANITIZE_NUMBER_INT):filter_input(INPUT_GET,'rating',FILTER_SANITIZE_NUMBER_INT);
$email=isset($_POST['email'])?filter_input(INPUT_POST,'email',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'email',FILTER_SANITIZE_STRING);
$name=isset($_POST['name'])?filter_input(INPUT_POST,'name',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'name',FILTER_SANITIZE_STRING);
$review=isset($_POST['review'])?filter_input(INPUT_POST,'review',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'review',FILTER_SANITIZE_STRING);
if($emailtrap==''){
    if(filter_var($email,FILTER_VALIDATE_EMAIL)){
        $q=$db->prepare("INSERT INTO comments (contentType,rid,ip,email,name,notes,cid,status,ti) VALUES('review',:rid,:ip,:email,:name,:notes,:cid,'unapproved',:ti)");
        $q->execute(array(':rid'=>$id,':ip'=>$ip,':email'=>$email,':name'=>$name,':notes'=>$review,':cid'=>$rating,':ti'=>time()));
        $e=$db->errorInfo();
        if(is_null($e[2])){
            echo'<div class="alert alert-success">Thank you for your Review, it will be added once an Administrator Approves it.</div>';
        }else{
            echo'<div class="alert alert-danger">There was an Issue adding your Review.</div>';
        }
    }else{
        echo'<div class="alert alert-info">Spammers and Email Harvesters not welcome.</div>';
    }
}else{
    echo'<div class="alert alert-info">Spammers and Email Harvesters not welcome.</div>';
}
