<?php
include'db.php';
$config=$db->query("SELECT * FROM config WHERE id='1'")->fetch(PDO::FETCH_ASSOC);
$ip=$_SERVER['REMOTE_ADDR'];
$id=isset($_POST['id'])?filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT):filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$emailtrap=isset($_POST['emailtrap'])?filter_input(INPUT_POST,'emailtrap',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'emailtrap',FILTER_SANITIZE_STRING);
$email=isset($_POST['email'])?filter_input(INPUT_POST,'email',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'email',FILTER_SANITIZE_STRING);
$name=isset($_POST['name'])?filter_input(INPUT_POST,'name',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'name',FILTER_SANITIZE_STRING);
$business=isset($_POST['business'])?filter_input(INPUT_POST,'business',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'business',FILTER_SANITIZE_STRING);
$review=isset($_POST['review'])?filter_input(INPUT_POST,'review',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'review',FILTER_SANITIZE_STRING);
if($emailtrap==''){
    $q=$db->prepare("INSERT INTO content (contentType,ip,title,email,name,business,notes,status,ti) VALUES('testimonials',:ip,:title,:email,:name,:business,:notes,'unapproved',:ti)");
    $q->execute(array(':ip'=>$ip,':title'=>$name.' - '.$business,':email'=>$email,':name'=>$name,':business'=>$business,':notes'=>$review,':ti'=>time()));
    $e=$db->errorInfo();
    if(is_null($e[2])){
        echo'<div class="alert alert-success">Thank you for your Testimonial, it will be added once an Administrator Approves it.</div>';
    }else{
        echo'<div class="alert alert-danger">There was an Issue adding your Testimonial.</div>';
    }
}else{
    echo'<div class="alert alert-info">Spammers and Email Harvesters not welcome.</div>';
}
