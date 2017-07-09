<?php


namespace App\BITM\SEIPXXXX\Admin;
use App\BITM\SEIPXXXX\Message\Message;
use App\BITM\SEIPXXXX\Utility\Utility;
use App\BITM\SEIPXXXX\Model\Database as DB;
use PDO;
class Admin extends DB
{

    public $id;
    public $name;
    public $email;
    public $password;
    public $result;
    public function __construct(){
        parent::__construct();
    }

    public function setData($data=array()){
        if(array_key_exists('name',$data)){
            $this->name=$data['name'];
        }
        if(array_key_exists('email',$data)){
            $this->email=$data['email'];
        }
        if(array_key_exists('password',$data)){
            $this->password=md5($data['password']);
        }
        if(array_key_exists('result',$data)){
            $this->result=$data['result'];
        }

        return $this;
    }
    public function storeResult(){

        $dataArray = array($this->result);

        $sql = "Insert into student(result)VALUES (?) where id = ".$this->id;

        $statementHandle = $this->conn->prepare($sql);
        $result2 = $statementHandle->execute($dataArray);

        if($result2){

            Message::message("Congrats! Data has been inserted");
        }
        else{

            Message::message("Failed! Data has not been inserted");
        }
        // Utility::redirect("adminIndex.php");


    }
    public function store()
    {

        $dataArray = array($this->email, $this->password, $this->name);

        $sql = "Insert into admin(email,password,name)VALUES (?,?,?)";

        $statementHandle = $this->conn->prepare($sql);
        $result = $statementHandle->execute($dataArray);

        if ($result) {

            Message::message("Congrats! Admin has been created");
        } else {

            Message::message("Failed! Admin has not been created");
        }
        Utility::redirect("indexAdmin.php");

    }


    public function change_password(){
        $query="UPDATE `coaching`.`admin` SET `password`=:password  WHERE `admin`.`email` =:email";
        $result=$this->conn->prepare($query);
        $result->execute(array(':password'=>$this->password,':email'=>$this->email));

        if($result){
            Message::message("
             <div class=\"alert alert-info\">
             <strong>Success!</strong> Password has been updated  successfully.
              </div>");
        }
        else {
            echo "Error";
        }

    }

    //end of change_password

    public function index()
    {

        $sql = "Select * from student WHERE soft_deleted='No'";

        $STH = $this->conn->query($sql);
        $STH->setFetchMode(PDO::FETCH_OBJ);
        return $STH->fetchAll();

    }
//    public function indexAdmin()
//    {
//
//        $sql = "Select * from admin WHERE soft_deleted='No'";
//
//        $STH = $this->conn->query($sql);
//        $STH->setFetchMode(PDO::FETCH_OBJ);
//        return $STH->fetchAll();
//
//    }
    //end of index

    public function view(){
        $query = "Select * from student WHERE id=" .$this->id;
        // Utility::dd($query);
        $STH =$this->conn->query($query);
        $STH->setFetchMode(PDO::FETCH_OBJ);
        return $STH->fetch();

    }// end of view()



    public function indexPaginator($page=1,$itemsPerPage=3){
        try{

            $start = (($page-1) * $itemsPerPage);
            if($start<0) $start = 0;
            $sql = "SELECT * from student  WHERE soft_deleted = 'No' LIMIT $start,$itemsPerPage";



        }catch (PDOException $error){

            $sql = "SELECT * from student  WHERE soft_deleted = 'No'";

        }

        $STH = $this->conn->query($sql);

        $STH->setFetchMode(PDO::FETCH_OBJ);

        $arrSomeData  = $STH->fetchAll();
        return $arrSomeData;


    }

    public function indexPaginatorAdmin($page=1,$itemsPerPage=3){
        try{

            $start = (($page-1) * $itemsPerPage);
            if($start<0) $start = 0;
            $sql = "SELECT * from admin  WHERE soft_deleted = 'No' LIMIT $start,$itemsPerPage";



        }catch (PDOException $error){

            $sql = "SELECT * from admin  WHERE soft_deleted = 'No'";

        }

        $STH = $this->conn->query($sql);

        $STH->setFetchMode(PDO::FETCH_OBJ);

        $arrSomeData  = $STH->fetchAll();
        return $arrSomeData;


    }

    public function listSelectedData($selectedIDs){



        foreach($selectedIDs as $id){

            $sql = "Select * from student  WHERE id=".$id;


            $STH = $this->conn->query($sql);

            $STH->setFetchMode(PDO::FETCH_OBJ);

            $someData[]  = $STH->fetch();

        }


        return $someData;


    }

    public function listSelectedDataAdmin($selectedIDs){



        foreach($selectedIDs as $id){

            $sql = "Select * from admin  WHERE id=".$id;


            $STH = $this->conn->query($sql);

            $STH->setFetchMode(PDO::FETCH_OBJ);

            $someData[]  = $STH->fetch();

        }


        return $someData;


    }

    public function searchIndexAdmin($requestArray){
        $sql = "";
        if( isset($requestArray['byName']) && isset($requestArray['byDate']) )  $sql = "SELECT * FROM `admin` WHERE `soft_deleted` ='No' AND (`name` LIKE '%".$requestArray['search']."%' OR `email` LIKE '%".$requestArray['search']."%')";
        if(isset($requestArray['byName']) && !isset($requestArray['byDate']) ) $sql = "SELECT * FROM `admin` WHERE `soft_deleted` ='No' AND `name` LIKE '%".$requestArray['search']."%'";
        if(!isset($requestArray['byName']) && isset($requestArray['byDate']) )  $sql = "SELECT * FROM `admin` WHERE `soft_deleted` ='No' AND `name` LIKE '%".$requestArray['search']."%'";

        $STH  = $this->conn->query($sql);
        $STH->setFetchMode(PDO::FETCH_OBJ);
        $someData = $STH->fetchAll();

        return $someData;

    }

    public function searchIndex($requestArray){
        $sql = "";
        if( isset($requestArray['byName']) && isset($requestArray['byDate']) )  $sql = "SELECT * FROM `student` WHERE `soft_deleted` ='No' AND (`student_name` LIKE '%".$requestArray['search']."%' OR `course` LIKE '%".$requestArray['search']."%')";
        if(isset($requestArray['byName']) && !isset($requestArray['byDate']) ) $sql = "SELECT * FROM `student` WHERE `soft_deleted` ='No' AND `student_name` LIKE '%".$requestArray['search']."%'";
        if(!isset($requestArray['byName']) && isset($requestArray['byDate']) )  $sql = "SELECT * FROM `student` WHERE `soft_deleted` ='No' AND `student_name` LIKE '%".$requestArray['search']."%'";

        $STH  = $this->conn->query($sql);
        $STH->setFetchMode(PDO::FETCH_OBJ);
        $someData = $STH->fetchAll();

        return $someData;

    }

  /*  public function getAllKeywordsIndexAdmin()
    {
        $_allKeywords = array();
        $WordsArr = array();

        $allData = $this->indexAdmin();

        foreach ($allData as $oneData) {
            $_allKeywords[] = trim($oneData->name);
        }

        $allData = $this->indexAdmin();


        foreach ($allData as $oneData) {

            $eachString= strip_tags($oneData->name);
            $eachString=trim( $eachString);
            $eachString= preg_replace( "/\r|\n/", " ", $eachString);
            $eachString= str_replace("&nbsp;","",  $eachString);

            $WordsArr = explode(" ", $eachString);

            foreach ($WordsArr as $eachWord){
                $_allKeywords[] = trim($eachWord);
            }
        }
        // for each search field block end




        // for each search field block start
        $allData = $this->indexAdmin();

        foreach ($allData as $oneData) {
            $_allKeywords[] = trim($oneData->name);
        }
        $allData = $this->indexAdmin();

        foreach ($allData as $oneData) {

            $eachString= strip_tags($oneData->name);
            $eachString=trim( $eachString);
            $eachString= preg_replace( "/\r|\n/", " ", $eachString);
            $eachString= str_replace("&nbsp;","",  $eachString);
            $WordsArr = explode(" ", $eachString);

            foreach ($WordsArr as $eachWord){
                $_allKeywords[] = trim($eachWord);
            }
        }
        // for each search field block end


        return array_unique($_allKeywords);


    }*/

    public function getAllKeywordsIndex()
    {
        $_allKeywords = array();
        $WordsArr = array();

        $allData = $this->index();

        foreach ($allData as $oneData) {
            $_allKeywords[] = trim($oneData->student_name);
        }

        $allData = $this->index();


        foreach ($allData as $oneData) {

            $eachString= strip_tags($oneData->student_name);
            $eachString=trim( $eachString);
            $eachString= preg_replace( "/\r|\n/", " ", $eachString);
            $eachString= str_replace("&nbsp;","",  $eachString);

            $WordsArr = explode(" ", $eachString);

            foreach ($WordsArr as $eachWord){
                $_allKeywords[] = trim($eachWord);
            }
        }
        // for each search field block end




        // for each search field block start
        $allData = $this->index();

        foreach ($allData as $oneData) {
            $_allKeywords[] = trim($oneData->student_name);
        }
        $allData = $this->index();

        foreach ($allData as $oneData) {

            $eachString= strip_tags($oneData->student_name);
            $eachString=trim( $eachString);
            $eachString= preg_replace( "/\r|\n/", " ", $eachString);
            $eachString= str_replace("&nbsp;","",  $eachString);
            $WordsArr = explode(" ", $eachString);

            foreach ($WordsArr as $eachWord){
                $_allKeywords[] = trim($eachWord);
            }
        }
        // for each search field block end


        return array_unique($_allKeywords);


    }// get all keywords



}