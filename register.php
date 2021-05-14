<?php
include "inc/db.php";
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lumino - Login</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/datepicker3.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="row">
    <div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
        <div class="login-panel panel panel-default">
            <div class="panel-heading">Register</div>
            <div class="panel-body">
                <?php

                if(isset($_POST['add'])) {

                     $stu_id = $_POST["stu_id"];

                     $full_name = $_POST["name"];
                     $depart = $_POST["depart"];
                     $password = $_POST["password"];
                     $re_password = $_POST["repassword"];

                     $num_user = $conn->query("select count(*) from  student where username = '$stu_id' ")->fetchColumn();



                     if($password !== $re_password){
                         echo '<div class="alert alert-danger" role="alert">
                                    Password must be same
                                 </div>';

                     }elseif ($num_user != 0){

                         echo '<div class="alert alert-warning" role="alert">
                                    This Student ID is already exist!! <a href="login.php" class="btn-link">sing in</a>
                                 </div>';

                     }else{
                         $stmt = $conn->prepare("INSERT INTO `student` (`id`, `password`, `Name`, `Depart`) VALUES ( '$stu_id','$password','$full_name','$depart') ");
                         $executed = $stmt->execute();
                         if($executed == true){

                             echo '<div class="alert alert-success" role="alert">
                                    You resisted successfully. To login click <a href="login.php" class="btn-link"> here </a>
                                 </div>';

                         }
                     }
                }
                ?>

                <form action="" method="post">
                    <fieldset>

                        <div class="form-group">
                            <label>Full Name</label>
                            <input class="form-control" placeholder="Full name" name="name" type="text">
                        </div>

                        <div class="form-group">
                            <label>Student ID</label>
                            <input class="form-control" placeholder="Student ID" name="stu_id" type="text">
                        </div>

                        <div class="form-group">
                            <label>Depart</label>
                            <select class="form-control" name="depart">
                                <option value="CS">CS</option>
                                <option value="IT">IT</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Password</label>
                            <input class="form-control" placeholder="Password" name="password" type="password" value="">
                        </div>

                        <div class="form-group">
                            <label>Re-Password</label>
                            <input class="form-control" placeholder="Re-Password" name="repassword" type="password" value="">
                        </div>

                        <input type="submit" value="Register" name="add" class="btn btn-primary">
                </form>
                <div class="" style="padding-top: 15px">
                   already have account? <a href="login.php" class="btn-link">Login</a>
                </div>
            </div>
        </div>
    </div><!-- /.col-->
</div><!-- /.row -->


<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
