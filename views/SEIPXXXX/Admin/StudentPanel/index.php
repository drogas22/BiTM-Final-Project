<?php
if(!isset($_SESSION) )session_start();
include_once('../../../../vendor/autoload.php');
use App\BITM\SEIPXXXX\Admin\Auth;
use App\BITM\SEIPXXXX\Admin\Admin;
use App\BITM\SEIPXXXX\Student\Student;

use App\BITM\SEIPXXXX\Message\Message;
use App\BITM\SEIPXXXX\Utility\Utility;


$obj = new Admin();

$allData = $obj->index();


if(!isset($_SESSION)){
    session_start();
}
$msg = Message::getMessage();


if(isset($_SESSION['mark']))  unset($_SESSION['mark']);


################## search  block 1 of 5 start ##################
if(isset($_REQUEST['search']) )$someData =  $obj->searchIndex($_REQUEST);
$availableKeywords=$obj->getAllKeywordsIndex();
$comma_separated_keywords= '"'.implode('","',$availableKeywords).'"';
################## search  block 1 of 5 end ##################



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
$someData = $obj->indexPaginator($page,$itemsPerPage);

$serial = (($page-1) * $itemsPerPage) +1;

####################### pagination code block#1 of 2 end #########################################


################## search  block 2 of 5 start ##################

if(isset($_REQUEST['search']) ) {
    $someData = $obj->searchIndex($_REQUEST);
    $serial = 1;
}
################## search  block 2 of 5 end ##################

?>



<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student - Active List</title>
    <link rel="stylesheet" href="../../../../resource/assets/css/bootstrap.min.css">

    <script src="../../../../resource/assets/js/bootstrap.js"></script>


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



    <!-- required for search, block3 of 5 start -->

<!--    <link rel="stylesheet" href="../../../../resource/assets/css/jquery-ui.css">-->
    <script src="../../../../resource/assets/bootstrap/js/jquery-3.1.1.min.js"></script>
    <script src="../../../../resource/assets/bootstrap/js/jquery-ui.js"></script>

    <!-- required for search, block3 of 5 end -->


</head>
<body>


<div class="container">

    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="../Authentication/logout.php">Log Out</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div
        </div><!-- /.container-fluid -->
    </nav>

    <?php echo "<div style='height: 30px; text-align: center'> <div class='alert-success ' id='message'> $msg </div> </div>"; ?>



    <!-- required for search, block 4 of 5 start -->
    <form id="searchForm" action="index.php"  method="get" style="margin-top: 5px; margin-bottom: 10px;text-align: right ">
        <input type="text" value="" id="searchID" name="search" placeholder="Search" width="60" >
        <input type="checkbox"  name="byName"   checked  > Name
        <input type="checkbox"  name="byDate"  checked >By Email
        <input hidden type="submit" class="btn-primary" value="search">
    </form>
    <!-- required for search, block 4 of 5 end -->


    <form action="" method="post" id="multiple" style="padding-top: 30px">





        <h1 style="text-align: center" ">Student List(<?php echo count($allData) ?>)</h1>

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
                <th>Institution</th>
                <th>Image</th>
            </tr>

            <?php
            // $serial= 1;
            foreach($someData as $oneData){

                if($serial%2) $bgColor = "#cccccc";
                else $bgColor = "#ffffff";

                echo "

                  <tr  style='background-color: $bgColor'>

                      <td style='padding-left: 6%'><input type='checkbox' class='checkbox' name='mark[]' value='$oneData->id'></td>

                     <td style='width: 10%; text-align: center'>$serial</td>
                     <td style='width: 10%; text-align: center'>$oneData->id</td>
                     <td>$oneData->student_name</td>
                     <td>$oneData->email</td>
                     <td>$oneData->phone</td>
                     <td>$oneData->gender</td>
                     <td>$oneData->course</td>
                     

                    <td>
                       <a href='view.php?email=$oneData->email' class='btn btn-info'>View</a>
                       
                            
                       
                       <a href='delete.php?email=$oneData->email' class='btn btn-danger'>Delete</a>
                       
                       <a href='trash.php?id=$oneData->id' class='btn btn-success'>Trash</a>
                       <br>
                       

                     </td>
                  </tr>
              ";
                $serial++;
            }
            ?>

        </table>

    </form>

    <!--  ######################## pagination code block#2 of 2 start ###################################### -->
    <div align="left" class="container">
        <ul class="pagination">

            <?php

            $pageMinusOne  = $page-1;
            $pagePlusOne  = $page+1;

            if($page>$pages) Utility::redirect("index.php?Page=$pages");

            if($page>1)  echo "<li><a href='index.php?Page=$pageMinusOne'>" . "Previous" . "</a></li>";
            for($i=1;$i<=$pages;$i++)
            {
                if($i==$page) echo '<li class="active"><a href="">'. $i . '</a></li>';
                else  echo "<li><a href='?Page=$i'>". $i . '</a></li>';

            }
            if($page<$pages) echo "<li><a href='index.php?Page=$pagePlusOne'>" . "Next" . "</a></li>";

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
        document.forms[1].action="deletemultiple.php";
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


<!-- required for search, block 5 of 5 start -->
<script>

    $(function() {
        var availableTags = [

            <?php
            echo $comma_separated_keywords;
            ?>
        ];
        // Filter function to search only from the beginning of the string
        $( "#searchID" ).autocomplete({
            source: function(request, response) {

                var results = $.ui.autocomplete.filter(availableTags, request.term);

                results = $.map(availableTags, function (tag) {
                    if (tag.toUpperCase().indexOf(request.term.toUpperCase()) === 0) {
                        return tag;
                    }
                });

                response(results.slice(0, 15));

            }
        });


        $( "#searchID" ).autocomplete({
            select: function(event, ui) {
                $("#searchID").val(ui.item.label);
                $("#searchForm").submit();
            }
        });


    });

</script>
<!-- required for search, block5 of 5 end -->



</body>
</html>