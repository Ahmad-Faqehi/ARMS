<?php
session_start();
// تاكد اذا المستخدم مسجل دخول او لا
if (!isset($_SESSION['staff:id'])) {
    header("Location: login.php ");
    exit();
}

include "../inc/db.php";

include "../vendor/autoload.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;



if(isset($_GET['id'])) {


    $order_id = (int)$_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM excuses JOIN student ON excuses.student_id = student.student_id JOIN course ON excuses.course_id = course.course_id JOIN teatcher ON excuses.teatcher_id = teatcher.teatcher_id WHERE excuses.excuse_id = '$order_id'");
    $stmt->execute();
    $row = $stmt->fetch();
    extract($row);

    // اكتب هنا الائميل
    $email_address = "";

    // اكتب هنا الباسورد حق الائميل
    $email_password = "";

    $title_Email = " Absent Excuse For " . $course_name . " Course.";
    $html_body = "
    
    <!DOCTYPE html>
<html lang=\"ar\" dir=\"ltr\">
<head>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <title>Email</title>
    <style>



     body {
      direction: ltr;
        -webkit-font-smoothing: antialiased;
        font-size: 14px;
        line-height: 1.4;
        margin: 0;
        padding: 0;
        -ms-text-size-adjust: 100%;
        -webkit-text-size-adjust: 100%; 
      }
      .body {

        width: 100%; 
      }
      h1,
      h3,
      h4 {
        color: #000000;
        font-weight: 400;
        line-height: 1.4;
        margin: 0;
        margin-bottom: 30px; 
      }

      h1 {
        font-size: 35px;
        font-weight: 300;
        text-align: center;
        text-transform: capitalize; 
      }





      h2{
        color: #0a0a0a;
    font-weight: normal;
    font-size: revert;
      }
      .xlg{
        font-size: x-large;
      }
      .red{
        color: red;
      }
      .btn {
        box-sizing: border-box;
        width: 100%; }
        .btn > tbody > tr > td {
          padding-bottom: 15px; }
        .btn table {
          width: auto; 
      }
      .btn {

        display: inline-block;
    font-weight: 400;
    color: #212529;
    text-align: center;
    vertical-align: middle;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    background-color: transparent;
    border: 1px solid transparent;
    padding: .375rem .75rem;
    font-size: 1.3rem;
    line-height: 1.5;
    border-radius: .25rem;
    transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
      }
      .btn-primary {
        background-color: #3498db;
        border-color: #3498db;
        color: #ffffff; 
      }
      .last {
        margin-bottom: 0; 
      }

      .first {
        margin-top: 0; 
      }

      .align-center {
        text-align: center; 
      }


      .mt3 {
        margin-top: 30px; 
      }

      hr {
        border: 0;
        border-bottom: 1px solid #f6f6f6;
        margin: 20px 0; 
      }

      .info{
        font-size: 18px;
        
      }
      span{ font-weight: bold ;}
      

    </style>
</head>
<body>

    <div class=\"container align-center mt3\">

       <h1>
         Absent Excuse
        <br>
        
        </h1>
       
        
       <hr>
       <h2 class=\"xlg\">Excuse Details:</h2>
                 <div class=\"info\">
          Course Name: <span> $course_name </span>
            <br>
             Absent Date : <span> $date_submit </span>
          </div> 

       <br>
       <hr>
       <h2 class=\"xlg\">Student Details:</h2>
      
      
          <div class=\"info\">
          Student Name: <span> $student_name </span>
            <br>
             Student ID: <span> $student_id </span>
            <br>
             Dept: <span> $Depart </span>
          </div> 
          
          <br>
          <center>
          Download File Excuse: <a href='http://localhost/arms/uploads/$file_excuse'class='btn-primary' > Download </a>
         </center>
      </div>

      <br>
      
    </div>
    
</body>
</html>
    ";


    $mail = new PHPMailer;
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = $email_address;
    $mail->Password = $email_password;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to
    $mail->setFrom($email_address, 'ARMS');
    $mail->addAddress($email);     // Add a recipient
    $mail->CharSet = "UTF-8";
  //  $mail->SMTPDebug  = 2;
    $mail->isHTML(true);                                  // Set email format
    $mail->Subject = $title_Email;
    $mail->Body = $html_body;

    if($mail->send()){
        $stmt = $conn->prepare(" UPDATE `excuses` SET `state`= 2 WHERE excuse_id = $order_id");
        $stmt->execute();
        header("Location: all_Excuse.php ");
        exit();

    }else{
       header("Location: home.php ");
    }
}
header("Location: all_Excuse.php ");
exit();