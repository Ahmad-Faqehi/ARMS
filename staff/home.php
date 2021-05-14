<?php 

session_start();
// تاكد اذا المستخدم مسجل دخول او لا
if (!isset($_SESSION['staff:id'])){
    header("Location: login.php ");
    exit();
}
include "../inc/db.php";

// $ACCEPTED =  $conn->query("select count(*) from  excuses where state = '2'")->fetchColumn();
// $REFUSED =  $conn->query("select count(*) from  excuses where state = '3'")->fetchColumn();
$PENDING =  $conn->query("select count(*) from  excuses where state = '1'")->fetchColumn();
// $TOTAL  =  $conn->query("select count(*) from  excuses ")->fetchColumn();
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>HOME</title>
	<link href="../css/bootstrap.min.css" rel="stylesheet">
	<link href="../css/font-awesome.min.css" rel="stylesheet">
	<link href="../css/datepicker3.css" rel="stylesheet">
	<link href="../css/styles.css" rel="stylesheet">
	
	<!--Custom Font-->
	<link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
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
		<div class="divider"></div>

        <ul class="nav menu">
            <li class="active"><a href="home.php"><em class="fa fa-dashboard">&nbsp;</em> HOME </a></li>
            <li><a href="new_excuse.php"><em class="fa fa-plus">&nbsp;</em> Browse New Excuses</a></li>
            <li><a href="all_Excuse.php"><em class="fa fa-calendar">&nbsp;</em> Browse All Excuses</a></li>
            <li><a href="logout.php"><em class="fa fa-power-off">&nbsp;</em> Logout</a></li>
        </ul>
		
	</div><!--/.sidebar-->
		
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#">
					<em class="fa fa-home"></em>
				</a></li>
				<li class="active">HOME</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Staff Home Page</h1>
			</div>
		</div><!--/.row-->

        <div class="panel panel-container">

            <div class="row">

                <div class="col-xs-12 col-md-12 col-lg-12 no-padding">
                    <div class="panel panel-orange panel-widget border-right">
                        <div class="row no-padding"><em class="fa fa-xl fa-clock-o color-orange"></em>
                            <div class="large"><?php echo $PENDING?></div>
                            <div class="text-muted">TOTAL EXCUSES PENDING</div>
                        </div>
                    </div>
                </div>


            </div><!--/.row-->
        </div>


        <div class="row" style="padding-top: 10px">

            <div class="col-lg-12 text-center">
				
                <a href="new_excuse.php" class=" btn btn-primary" style="width: 70%"><i class="fa fa-file-text-o"></i> Browse New Excuses </a>
                <br>
                <br>
                <a href="all_Excuse.php" class=" btn btn-primary" style="width: 70%"> <i class="fa fa-file-text-o"></i> Browse All Excuses </a>

            </div>
        </div><!--/.row-->

			
			
	
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