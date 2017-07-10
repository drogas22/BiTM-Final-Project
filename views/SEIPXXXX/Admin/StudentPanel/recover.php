<?php
if(!isset($_SESSION) )session_start();
include_once('../../../../vendor/autoload.php');

use App\BITM\SEIPXXXX\Admin\Auth;
use App\BITM\SEIPXXXX\Admin\Admin;
use App\BITM\SEIPXXXX\Student\Student;

use App\BITM\SEIPXXXX\Message\Message;
use App\BITM\SEIPXXXX\Utility\Utility;

$obj=new Student();
$obj->setData($_GET);
$obj->recover();