<?php
if(!isset($_SESSION) )session_start();
include_once('../../../../vendor/autoload.php');

use App\BITM\SEIPXXXX\Admin\Auth;
use App\BITM\SEIPXXXX\Admin\Admin;
use App\BITM\SEIPXXXX\Student\Student;

use App\BITM\SEIPXXXX\Message\Message;
use App\BITM\SEIPXXXX\Utility\Utility;
$obj = new Student();
$obj->setData($_GET);
$oneData = $obj->view();


if(isset($_GET['Yes'])&& $_GET['Yes']==1)
    $obj->delete();
    $_GET['Yes']= 0;


?>



<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book Title - Single Book Information</title>
    <link rel="stylesheet" href="../../../resource/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../resource/css/bootstrap-theme.min.css">
    <link href="../../../../resource/bootstrap/css/style.css" rel="stylesheet">
    <script src="../../../resource/js/bootstrap.min.js"></script>


    <style>

        td{
            border: 0px;
        }

        table{
            border: 1px;
        }

        tr{
            height: 30px;
        }
    </style>



</head>
<body>


<div class="container">
    <h1 style="text-align: center">Are You Want To Permanently Delete The Following Record?</h1>

    <table class="table table-striped table-bordered" cellspacing="0px">


        <tr>
            <th style='width: 10%; text-align: center'>ID</th>
            <th>Student Name</th>
            <th>Email </th>
            <th>Phone </th>
            <th>Gender </th>
            <th>Course </th>
        </tr>

        <?php

        echo "

                  <tr >
                     <td>$oneData->id</td>
                     <td>$oneData->student_name</td>
                     <td>$oneData->email</td>
                     <td>$oneData->phone</td>
                     <td>$oneData->gender</td>
                     <td>$oneData->course</td>
                  </tr>
              ";

        ?>

    </table>

    <a href='delete.php?id=<?php echo $oneData->id ?>&Yes=1' class='btn btn-group-lg btn-info'>Yes</a>
    <a href='index.php' class='btn btn-group-lg btn-info'>No</a>

</div>

</body>
</html>