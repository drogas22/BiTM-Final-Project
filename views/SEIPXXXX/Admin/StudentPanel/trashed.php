<?php
if(!isset($_SESSION) )session_start();
include_once('../../../../vendor/autoload.php');

use App\BITM\SEIPXXXX\Admin\Auth;
use App\BITM\SEIPXXXX\Admin\Admin;
use App\BITM\SEIPXXXX\Student\Student;

use App\BITM\SEIPXXXX\Message\Message;
use App\BITM\SEIPXXXX\Utility\Utility;

$obj = new Student();

$allData = $obj->trashed();


$msg = Message::getMessage();



if(isset($_SESSION['mark']))  unset($_SESSION['mark']);





######################## pagination code block#1 of 2 start ######################################
$recordCount= count($allData);


if(isset($_REQUEST['Page']))   $page = $_REQUEST['Page'];
else if(isset($_SESSION['Page']))   $page = $_SESSION['Page'];
else   $page = 1;

$_SESSION['Page']= $page;




if(isset($_REQUEST['ItemsPerPage']))   $itemsPerPage = $_REQUEST['ItemsPerPage'];
else if(isset($_SESSION['ItemsPerPage']))   $itemsPerPage = $_SESSION['ItemsPerPage'];
else   $itemsPerPage = 3;

$_SESSION['ItemsPerPage']= $itemsPerPage;


$pages = ceil($recordCount/$itemsPerPage);
$someData = $obj->trashedPaginator($page,$itemsPerPage);

$serial = (($page-1) * $itemsPerPage) +1;

####################### pagination code block#1 of 2 end #########################################





?>



<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student - Trashed List</title>
    <link rel="stylesheet" href="../../../../resource/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../../resource/assets/bootstrap/css/bootstrap-theme.min.css">
    <script src="../../../../resource/assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="../../../../resource/assets/bootstrap/js/jquery-3.1.1.min.js"></script>


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

    <?php echo "<div style='height: 30px; text-align: center'> <div  class='bg-warning' id='message'> $msg </div> </div>"; ?>



    <form action="recovermultiple.php" method="post" id="multiple" style="padding-top: 10px">


        <div class="navbar"?>
            <a href="index.php?Page=1"   class="btn btn-info role="button"> View Active List</a> &nbsp;&nbsp;&nbsp;

            <button type="button" class="btn btn-danger" id="delete">Delete  Selected</button>&nbsp;&nbsp;&nbsp;
            <button type="submit" class="btn btn-success">Recover Selected</button>

        </div>


    <h1 style="text-align: center" >Student - Trashed List(<?php echo count($allData) ?>)</h1>

    <table class="table table-striped table-bordered" cellspacing="0px">


        <tr>
            <th>Select all  <input id="select_all" type="checkbox" value="select all"></th>

            <th style='width: 10%; text-align: center'>Serial Number</th>
            <th style='width: 10%; text-align: center'>ID</th>
            <th>Student Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Gender</th>
            <th>Course</th>

        </tr>

        <?php
        //$serial= 1;
        foreach($someData as $oneData){

            if($serial%2) $bgColor = "#cccccc";
            else $bgColor = "#ffffff";

            echo "

                  <tr  style='background-color: $bgColor'>

                     <td style='padding-left: 6%'><input type='checkbox' class='checkbox' name='mark[]' value='$oneData->id'></td>

                     <td style='width: 10%; text-align: center'>$oneData->id</td>
                     <td>$oneData->student_name</td>
                     <td>$oneData->email</td>
                     <td>$oneData->phone</td>
                     <td>$oneData->gender</td>
                     <td>$oneData->course</td>

                    <td>
                       <a href='view.php?id=$oneData->id' class='btn btn-info'>View</a>
                       
                       <a href='recover.php?id=$oneData->id' class='btn btn-success'>Recover</a>
                       <a href='delete.php?email=$oneData->email' class='btn btn-danger'>Delete</a>

                     </td>
                      </tr>
              ";
            $serial++;
        }
        ?>

    </table>

    <!--  ######################## pagination code block#2 of 2 start ###################################### -->
    <div align="left" class="container">
        <ul class="pagination">

            <?php

            $pageMinusOne  = $page-1;
            $pagePlusOne  = $page+1;

            if($page>$pages) Utility::redirect("trashed.php?Page=$pages");

            if($page>1)  echo "<li><a href='trashed.php?Page=$pageMinusOne'>" . "Previous" . "</a></li>";


            for($i=1;$i<=$pages;$i++)
            {
                if($i==$page) echo '<li class="active"><a href="">'. $i . '</a></li>';
                else  echo "<li><a href='?Page=$i'>". $i . '</a></li>';

            }


            if($page<$pages) echo "<li><a href='trashed.php?Page=$pagePlusOne'>" . "Next" . "</a></li>";

            ?>

            <select  class="form-control"  name="ItemsPerPage" id="ItemsPerPage" onchange="javascript:location.href = this.value;" >
                <?php
                if($itemsPerPage==3 ) echo '<option value="?ItemsPerPage=3" selected >Show 3 Items Per Page</option>';
                else echo '<option  value="?ItemsPerPage=3">Show 3 Items Per Page</option>';

                if($itemsPerPage==4 )  echo '<option  value="?ItemsPerPage=4" selected >Show 4 Items Per Page</option>';
                else  echo '<option  value="?ItemsPerPage=4">Show 4 Items Per Page</option>';

                if($itemsPerPage==5 )  echo '<option  value="?ItemsPerPage=5" selected >Show 5 Items Per Page</option>';
                else echo '<option  value="?ItemsPerPage=5">Show 5 Items Per Page</option>';

                if($itemsPerPage==6 )  echo '<option  value="?ItemsPerPage=6"selected >Show 6 Items Per Page</option>';
                else echo '<option  value="?ItemsPerPage=6">Show 6 Items Per Page</option>';

                if($itemsPerPage==10 )   echo '<option  value="?ItemsPerPage=10"selected >Show 10 Items Per Page</option>';
                else echo '<option  value="?ItemsPerPage=10">Show 10 Items Per Page</option>';

                if($itemsPerPage==15 )  echo '<option  value="?ItemsPerPage=15"selected >Show 15 Items Per Page</option>';
                else    echo '<option  value="?ItemsPerPage=15">Show 15 Items Per Page</option>';
                ?>
            </select>
        </ul>
    </div>
    <!--  ######################## pagination code block#2 of 2 end ###################################### -->

</div>


<script>
    jQuery(function($) {
        $('#message').fadeOut (550);
        $('#message').fadeIn (550);
        $('#message').fadeOut (550);
        $('#message').fadeIn (550);
        $('#message').fadeOut (550);
        $('#message').fadeIn (550);
        $('#message').fadeOut (550);
    })

    $('#delete').on('click',function(){
        document.forms[0].action="deletemultiple.php";
        $('#multiple').submit();
    });



    //select all checkboxes
    $("#select_all").change(function(){  //"select all" change
        var status = this.checked; // "select all" checked status
        $('.checkbox').each(function(){ //iterate all listed checkbox items
            this.checked = status; //change ".checkbox" checked status
        });
    });

    $('.checkbox').change(function(){ //".checkbox" change
//uncheck "select all", if one of the listed checkbox item is unchecked
        if(this.checked == false){ //if this item is unchecked
            $("#select_all")[0].checked = false; //change "select all" checked status to false
        }

//check "select all" if all checkbox items are checked
        if ($('.checkbox:checked').length == $('.checkbox').length ){
            $("#select_all")[0].checked = true; //change "select all" checked status to true
        }
    });

</script>

</body>
</html>