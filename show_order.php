<?php session_start();
// تاكد اذا المستخدم مسجل دخول او لا
if (!isset($_SESSION['user:id'])){
    header("Location: login.php ");
    exit();
}
include "inc/db.php";

if(isset($_GET['id']) && !empty($_GET['id'])){

    $order_id = (int)$_GET['id'];
    $user_id = $_SESSION['user:id'];
    $stmt = $conn->prepare("SELECT * FROM excuses JOIN student ON excuses.student_id = student.student_id JOIN course ON excuses.course_id = course.course_id JOIN teatcher ON excuses.teatcher_id = teatcher.teatcher_id WHERE excuses.excuse_id = '$order_id'");
    $stmt->execute();
    $row = $stmt->fetch();

    if(empty($row)){
        header("Location: home.php ");
        exit();
    }

}else{
    header("Location: home.php ");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Order details</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/datepicker3.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">

    <!--Custom Font-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<style>
	.navbar-custom {
    background: #e9ecf2;
    height: 60px;
	border-bottom: inset;
    border-bottom-color: #292929c9;
}
</style>
<nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse"><span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span></button>
            <!-- <a class="navbar-brand" href="#">ARMS</a> -->
            <img src="img/New_Logo_ARMS.png" alt="" srcset="" width="160">

        </div>
    </div><!-- /.container-fluid -->
</nav>
<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">

    <ul class="nav menu">
        <li ><a href="home.php"><em class="fa fa-dashboard">&nbsp;</em> HOME </a></li>
        <li><a href="add_excuse.php"><em class="fa fa-plus">&nbsp;</em> Add Excuse</a></li>
        <li><a href="Follow_Excuse.php"><em class="fa fa-calendar">&nbsp;</em> Follow Excuses</a></li>
        <li><a href="logout.php"><em class="fa fa-power-off">&nbsp;</em> Logout</a></li>
    </ul>
</div><!--/.sidebar-->

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="#">
                    <em class="fa fa-home"></em>
                </a></li>
            <li class="active">Order details</li>
        </ol>
    </div><!--/.row-->

    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Order details</h3>
        </div>
    </div><!--/.row-->


    <div class="container">


        <div class="panel panel-info">
            <div class="panel-heading">Order info</div>
            <div class="panel-body">

   

            <div class="form-group">
                <label for="exampleInputEmail1">Student Name </label>
                <input type="text" name="disabled" readonly value="<?php echo $row['student_name']?>" class="form-control">
            </div>

            <div class="form-group">
                <label for="exampleInputEmail1">Student ID </label>
                <input type="text" name="disabled" readonly value="<?php echo $row['student_id']?>" class="form-control">
            </div>

            <div class="form-group">
                <label for="exampleInputEmail1">Dept </label>
                <input type="text" name="disabled" readonly value="<?php echo $row['Depart']?>" class="form-control">
            </div>


            <div class="form-group">
                <label for="exampleInputEmail1">Course Name </label>
                <input type="text" class="form-control" readonly value="<?php echo $row['course_name']?>" name="course" required>
            </div>

            <div class="form-group">
                <label for="exampleInputPassword1">Instructor Name</label>
                <input type="text" class="form-control" readonly value="<?php echo $row['teatcher_name']?>" name="instructor" required >
            </div>

            <div class="form-group">
                <label for="exampleInputPassword1">Absent Date</label>
                <input type="text" class="form-control" name="date" readonly value="<?php echo $row['date_submit']?>" required >
            </div>

            <div class="form-group">
                <label for="exampleInputPassword1">Absent Day</label>
                <input type="text" class="form-control" name="date" readonly value="<?php echo date('l',strtotime($row['date_submit']))?>" required >
            </div>

            <div class="form-group">
                <label for="exampleInputPassword1">Excuse File  </label> <i class="fa fa-file-o"></i>  <a href="uploads/<?php echo $row['file_excuse']?>" class="btn-link"> download </a>
            </div>

            <?php if(!empty($row['comment'])):?>
            <div class="form-group">
                <label for="exampleInputPassword1">Comment </label>
                <textarea class="form-control" name="comment" readonly  rows="6"><?php echo $row['comment']?></textarea>
            </div>
            <?php endif; ?>

                <?php if(!empty($row['reason_refuse']) && $row['state'] == 3):?>
            <div class="form-group">
                <label for="exampleInputPassword1">Reason of Refuse </label>
                <textarea class="form-control" name="comment" readonly  rows="6" style="border-color: #bf1818;"><?php echo $row['reason_refuse']?></textarea>
            </div>
            <?php endif; ?>


      

            </div>
        </div>

        <br>

    </div>

    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/chart.min.js"></script>
    <script src="js/chart-data.js"></script>
    <script src="js/easypiechart.js"></script>
    <script src="js/easypiechart-data.js"></script>
    <script src="js/bootstrap-datepicker.js"></script>
    <script src="js/custom.js"></script>
    <script>
        window.onload = function () {
            var chart1 = document.getElementById("line-chart").getContext("2d");
            window.myLine = new Chart(chart1).Line(lineChartData, {
                responsive: true,
                scaleLineColor: "rgba(0,0,0,.2)",
                scaleGridLineColor: "rgba(0,0,0,.05)",
                scaleFontColor: "#c5c7cc"
            });
        };
    </script>

</body>
</html>