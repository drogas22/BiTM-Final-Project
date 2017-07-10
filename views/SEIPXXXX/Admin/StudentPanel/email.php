<?php



if(!isset($_SESSION)) session_start();
include_once('../../../../vendor/autoload.php');
require '../../../../vendor/phpmailer/phpmailer/PHPMailerAutoload.php';

######## PLEASE PROVIDE Your Gmail Info. -  (ALLOW LESS SECURE APP ON GMAIL SETTING ) ########

$yourGmailAddress = 'lexmasure@gmail.com';
$yourGmailPassword = 'tsatsouline2';

##############################################################################################



use App\BITM\SEIPXXXX\Student\Student;
use App\BITM\SEIPXXXX\Utility\Utility;
use App\BITM\SEIPXXXX\Message\Message;


$obj= new Student();
$obj->setData($_GET);
$singleUser = $obj->view();

/*if(isset($_REQUEST['list'])) {
    $list = 1;
    $recordSet = $city->index();

}
else {
    $list= 0;
    $city->setData($_REQUEST);
    $singleItem = $city->view();
}

*/?>



<!DOCTYPE html>

<head>
    <title>Email This To A Friend</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../../../../resource/assets/css/bootstrap.min.css">
    <script src="../../../../resource/assets/css/bootstrap.min.js"></script>
    <script src="../../../resource//js/jquery-3.1.1.min.js"></script>


    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>

    <script>tinymce.init({
            selector: 'textarea',  // change this value according to your HTML

            menu: {
                table: {title: 'Table', items: 'inserttable tableprops deletetable | cell row column'},
                tools: {title: 'Tools', items: 'spellchecker code'}

            }
        });


    </script>


</head>

<body>

<div class="container">
    <h2>Email This To A Student</h2>
    <form  role="form" method="post" action="email.php<?php if(isset($_REQUEST['id'])) echo "?id=".$_REQUEST['id']; else echo "?list=1";?>">
        <div class="form-group">
            <label for="Name">Name:</label>
            <input type="text"  name="name"  class="form-control" id="name" value="<?php echo $singleUser->student_name ?>">
            <label for="Email">Email Address:</label>
            <input type="text"  name="email"  class="form-control" id="email" value="<?php echo $singleUser->email ?>" >

            <label for="Subject">Subject:</label>
<!--            <input type="text"  name="subject"  class="form-control" id="subject" value="--><?php //if($list){echo "List of Cities recommendation";} else {echo "A single City recommendation";} ?><!--">-->
            <label for="body">Body:</label>
            <textarea   rows="8" cols="160"  name="body" >
<?php
//if($list){
//
//$trs="";
//$sl=0;
//
//    printf("<table><tr> <td width='50'><strong>Serial</strong></td><td width='50'><strong>ID</strong></td><td width='250'><strong>City</strong></td></tr>");
//
//    foreach($recordSet as $row) {
//
//    $id = $row->id;
//    $cityName = $row->city_name;
//
//    $sl++;
//    printf("<tr><td width='50'>%d</td><td width='250'>%s</td><td width='250'>%s</td></tr>",$sl,$id,$cityName);
//
//
//     }
//     printf("</table>");
//
//}
//else
//{
//    printf("I'm recommending You: [<strong>City ID: </strong>%s, <strong>City Name: </strong>%s]",$singleItem->id,$singleItem->city_name);
//
//}
//?>
            </textarea>

        </div>

        <input class="btn-lg btn-primary" type="submit" value="Send Email">

    </form>


<?php
if(isset($_REQUEST['email'])&&isset($_REQUEST['subject'])) {

    date_default_timezone_set('Etc/UTC');

    //Create a new PHPMailer instance
    $mail = new PHPMailer;
    //Tell PHPMailer to use SMTP
    $mail->isSMTP();
    //Enable SMTP debugging
    // 0 = off (for production use)
    // 1 = client messages
    // 2 = client and server messages
    $mail->SMTPDebug = 0;
    //Ask for HTML-friendly debug output
    $mail->Debugoutput = 'html';
    //Set the hostname of the mail server
    $mail->Host = 'smtp.gmail.com';
    // use
    // $mail->Host = gethostbyname('smtp.gmail.com');
    // if your network does not support SMTP over IPv6
    //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
    $mail->Port = 587; //587
    //Set the encryption system to use - ssl (deprecated) or tls
    $mail->SMTPSecure = 'tls'; //tls
    //Whether to use SMTP authentication
    $mail->SMTPAuth = true;
    //Username to use for SMTP authentication - use full email address for gmail
    $mail->Username = $yourGmailAddress;
    //Password to use for SMTP authentication
    $mail->Password = $yourGmailPassword;
    //Set who the message is to be sent from
    $mail->setFrom($yourGmailAddress, 'BITM PHP');
    //Set an alternative reply-to address
    $mail->addReplyTo($yourGmailAddress, 'BITM PHP');
    //Set who the message is to be sent to

    //echo $_REQUEST['email']; die();

    $mail->addAddress($_REQUEST['email'], $_REQUEST['name']);
    //Set the subject line
    $mail->Subject = $_REQUEST['subject'];
    //Read an HTML message body from an external file, convert referenced images to embedded,
    //convert HTML into a basic plain-text alternative body
    //$mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
    //Replace the plain text body with one created manually
    $mail->AltBody = 'This is a plain-text message body';

    $mail->Body = $_REQUEST['body'];
    

    if (!$mail->send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
        Message::message("<strong>Success!</strong> Email has been sent successfully.");

        ?>
        <script type="text/javascript">
            window.location.href = 'index.php';
        </script>
        <?php


    }

}


?>



</div>
</body>


</html>