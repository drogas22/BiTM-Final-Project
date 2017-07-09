<?php
include_once('../../../../vendor/autoload.php');
use App\BITM\SEIPXXXX\Student\Student;
use App\BITM\SEIPXXXX\Student\Auth;
use App\BITM\SEIPXXXX\Message\Message;
use App\BITM\SEIPXXXX\Utility\Utility;
$auth= new Auth();
$status= $auth->setData($_POST)->is_exist();
if($status){
    Message::setMessage("<div class='alert alert-danger'>
    <strong>Taken!</strong> Email has already been taken. </div>");
    return Utility::redirect($_SERVER['HTTP_REFERER']);
}else{
    $_POST['email_token'] = md5(uniqid(rand()));
    $obj= new Student();
    $obj->setData($_POST)->store();
    
    require '../../../../vendor/phpmailer/phpmailer/PHPMailerAutoload.php';
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPDebug  = 0;
    $mail->SMTPAuth   = true;
    $mail->SMTPSecure = "ssl";
    $mail->Host       = "smtp.gmail.com";
    $mail->Port       = 465;
    $mail->AddAddress($_POST['email']);
    $mail->Username="lexmasure@gmail.com";
    $mail->Password="tsatsouline2";
    $mail->SetFrom('lexmasure@gmail.com','Leader Of TeamCoder');
    $mail->AddReplyTo("lexmasure@gmail.com","Leader Of TeamCoder");
    $mail->Subject    = "Your Account Activation Link";
    $message =  "
       Please click this link to verify your account:
       http://localhost/FinalProject_BiTM_B59_TeamCoder/views/SEIPXXXX/Student/Profile/emailverification.php?email=".$_POST['email']."&email_token=".$_POST['email_token'];
    $mail->MsgHTML($message);
    $mail->Send();
}
