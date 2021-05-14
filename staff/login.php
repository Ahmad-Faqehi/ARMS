<?php
include "../inc/db.php";
session_start();
// تاكد اذا المستخدم مسجل دخول او لا
if (isset($_SESSION['staff:id'])){
    exit(header("Location: home.php "));
}
exit(header("Location: ../login.php "));
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Staff Login</title>
	<link href="../css/bootstrap.min.css" rel="stylesheet">
	<link href="../css/datepicker3.css" rel="stylesheet">
	<link href="../css/styles.css" rel="stylesheet">
	<!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="../js/respond.min.js"></script>
    <![endif]-->
</head>
<body>
	<div class="row">
		<div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
			<div class="login-panel panel panel-default">
				<div class="panel-heading text-center" style="font-size:x-large"> Staff Log in</div>
				<div class="panel-body">
                    <?php
                    if(isset($_POST['login'])) {

                        $staff_user = $_POST['username'];
                        $password = $_POST['password'];

                        if(empty($password) || empty($staff_user)){
                            echo '<div class="alert alert-danger" role="alert">
                                    Input must be not empty
                                 </div>';

                        }else{

                            $stm = $conn->prepare(" select * from staff where staff_user = '$staff_user' ");
                            $stm->execute();
                            $count = $stm->rowCount();

                            if ($count != 0){

                                $row = $stm->fetch();

                                if($row['staff_pass'] === $password){

                                    $_SESSION['staff:id'] = $row['staff_id'];
                                    header("Location: home.php");
                                    exit();
                                }else{
                                    echo '<div class="alert alert-danger" role="alert">
                                    Username or password  is incorrect
                                 </div>';
                                }

                            }else{

                                echo '<div class="alert alert-danger" role="alert">
                                    username or password  is incorrect
                                 </div>';

                            }

                        }

                    }
                    ?>
					<form action="" method="post">
						<fieldset>
							<div class="form-group">
								<input class="form-control" placeholder="Student ID" name="username" type="text" autofocus="">
							</div>
							<div class="form-group">
								<input class="form-control" placeholder="Password" name="password" type="password" value="">
							</div>
                            <br>
                            <center>
							<input type="submit" value="Login" class="btn btn-info" name="login">
                            </center>
						</fieldset>
					</form>
                    <div class="" style="padding-top: 15px">
                        <!-- <a href="#" class="btn-link">Forgot password?</a> -->
                    </div>
				</div>
			</div>
		</div><!-- /.col-->
	</div><!-- /.row -->	
	

<script src="../js/jquery-1.11.1.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
</body>
</html>
