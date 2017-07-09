<?php
if(!isset($_SESSION) )session_start();
include_once('../../../vendor/autoload.php');
use App\BITM\SEIPXXXX\Student\Student;
use App\BITM\SEIPXXXX\Message\Message;
use App\BITM\SEIPXXXX\Utility\Utility;
echo "<center>";
$obj= new Student();
$obj->setData($_SESSION);
$singleUser = $obj->view();

foreach($singleUser as $oneUser){
    echo $oneUser . "<br>";
}

echo "</center>";
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../../../resource/assets/css/bootstrap.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="../../../resource/assets/css/style.css">
    <link rel="stylesheet" href="../../../resource/assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="../../../resource/assets/css/owl.theme.default.min.css">
    <script type="text/javascript" src="../../../resource/assets/js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="../../../resource/assets/js/bootstrap.js"></script>
    <script src="../../../resource/assets/js/owl.carousel.min.js"></script>


</head>
<body>

<table>


</table>

</body>
</html>

<nav>
    <ul>
        <li> <a href= "Authentication/logout.php" > LOGOUT </a></li>
    </ul>
</nav>
