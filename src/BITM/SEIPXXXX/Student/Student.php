<?php
namespace App\BITM\SEIPXXXX\Student;
use App\BITM\SEIPXXXX\Message\Message;
use App\BITM\SEIPXXXX\Utility\Utility;
use App\BITM\SEIPXXXX\Model\Database as DB;
use PDO;


class Student extends DB{
    public $table="student";
    public $student_name="";
    public $email="";
    public $phone="";
    public $course="";
    public $institution="";
    public $image="";
    public $soft_deleted="";
    public $gender="";
    public $password="";
    public $id="";
    public $email_token="";

    public function __construct(){
        parent::__construct();
    }

    public function setData($data=array()){

        if(array_key_exists('id',$data)){
            $this->id=$data['id'];
        }

        if(array_key_exists('student_name',$data)){
            $this->student_name=$data['student_name'];
        }

        if(array_key_exists('email',$data)){
            $this->email=$data['email'];
        }

        if(array_key_exists('password',$data)){
            $this->password=md5($data['password']);
        }

        if(array_key_exists('phone',$data)){
            $this->phone=$data['phone'];
        }

        if(array_key_exists('gender',$data)){
            $this->gender=$data['gender'];
        }

        if(array_key_exists('course',$data)){
            $this->course=$data['course'];
        }

        if(array_key_exists('email_token',$data)){
            $this->email_token=$data['email_token'];
        }


        return $this;
    }





    public function store() {


       $dataArray= array(':student_name'=>$this->student_name,':email'=>$this->email,':password'=>$this->password,
            ':phone'=>$this->phone,':gender'=>$this->gender,':course'=>$this->course,':email_token'=>$this->email_token);


        $query="INSERT INTO `coaching`.`student` (`student_name` , `email`, `password`, `phone`, `gender`, `course`,`email_verified`) 
VALUES (:student_name, :email, :password,:phone, :gender, :course, :email_token)";

        $STH=$this->conn->prepare($query);

        $result = $STH->execute($dataArray);
        
        if ($result) {
            Message::message("
                <div class=\"alert alert-success\">
                            <strong>Success!</strong> Data has been stored successfully, Please check your email and active your account.
                </div>");
            return Utility::redirect($_SERVER['HTTP_REFERER']);
        } else {
            Message::message("
                <div class=\"alert alert-danger\">
                            <strong>Failed!</strong> Data has not been stored successfully.
                </div>");
            return Utility::redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function change_password(){
        $query="UPDATE `coaching`.`student` SET `password`=:password  WHERE `coaching`.`email` =:email";
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

    public function view(){
        $query=" SELECT * FROM student WHERE email = '$this->email' ";
       // Utility::dd($query);
        $STH =$this->conn->query($query);
        $STH->setFetchMode(PDO::FETCH_OBJ);
        return $STH->fetch();

    }// end of view()

    public function delete()
    {
    $sql = "DELETE FROM  student where id=".$this->id;
    $result = $this->conn->exec($sql);
    if($result){
        Message::message("Success! data has been Deleted Successfully") ;
    }
    else{
        Message::message("Failed! data has not been Deleted") ;
    }
    Utility::redirect("index.php");     // This change Not included in Class Video
    //header("Location: {$_SERVER['HTTP_REFERER']}");

    }

    public function trashed()
    {

        $sql = "Select * from student WHERE soft_deleted='Yes'";

        $STH = $this->conn->query($sql);
        $STH->setFetchMode(PDO::FETCH_OBJ);
        return $STH->fetchAll();

    }



    public function trash()
    {
        $dataArray = array("Yes");

        $sql = "UPDATE  student SET soft_deleted=? where id=" . $this->id;

        $STH = $this->conn->prepare($sql);

        $result = $STH->execute($dataArray);

        if ($result) {
            Message::message("Success! data has been Soft Deleted Successfully");
        } else {
            Message::message("Failed! data has not been Soft Deleted");
        }


        Utility::redirect("trashed.php");     // This change Not included in Class Video

    }

    public function updateInfo()
    {
        $dataArray = array($this->user_name, $this->date_of_birth);

        $sql = "UPDATE  birthday SET user_name=?, date_of_birth=? where id=" . $this->id;

        $STH = $this->DBH->prepare($sql);

        $result = $STH->execute($dataArray);

        if ($result) {
            Message::message("Success! data has been Updated Successfully");
        } else {
            Message::message("Failed! data has not been Updated.");
        }


        Utility::redirect("index.php");     // This change Not included in Class Video

    }

    public function recover()
    {
        $dataArray = array("No");

        $sql = "UPDATE  student SET soft_deleted=? where id=" . $this->id;

        $STH = $this->conn->prepare($sql);

        $result = $STH->execute($dataArray);

        if ($result) {
            Message::message("Success! data has been Recovered Successfully");
        } else {
            Message::message("Failed! data has not been Recovered");
        }


        Utility::redirect("index.php");     // This change Not included in Class Video

    }


    public function validTokenUpdate(){
        $query="UPDATE `coaching`.`student` SET  `email_verified`='".'Yes'."' WHERE `student`.`email` ='$this->email'";
        $result=$this->conn->prepare($query);
        $result->execute();

        if($result){
            Message::message("
             <div class=\"alert alert-success\">
             <strong>Success!</strong> Email verification has been successful. Please login now!
              </div>");
        }
        else {
            echo "Error";
        }
        return Utility::redirect('../../../../views/SEIPXXXX/Student/Profile/signup.php');
    }

    public function update(){

        $query="UPDATE `coaching`.`student` SET `student_name`=:student_name, `email` =:email, `password` = :password, `phone` = :phone, `course` = :course 
    WHERE `student`.`email_verified` = :email_verified";

        $result=$this->conn->prepare($query);

        $result->execute(array(':firstName'=>$this->student_name,':email'=>$this->email,':password'=>$this->password,':phone'=>$this->phone,
 ':course'=>$this->course,':email_token'=>$this->email_token));

        if($result){
            Message::message("
             <div class=\"alert alert-info\">
             <strong>Success!</strong> Data has been updated  successfully.
              </div>");
        }
        else {
            echo "Error";
        }
        return Utility::redirect($_SERVER['HTTP_REFERER']);
    }

}

