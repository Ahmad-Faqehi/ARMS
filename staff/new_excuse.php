<?php session_start();
// تاكد اذا المستخدم مسجل دخول او لا
if (!isset($_SESSION['staff:id'])){
    header("Location: login.php ");
    exit();
}
include "../inc/db.php";

function getState($state){


    switch ($state){

        case 1:
            $state = "Pending";
            break;

        case 2:
            $state = "Accepted";
            break;

        case 3:
            $state = "Refused";
            break;

    }
    return $state;
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Follow - Excuse</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/font-awesome.min.css" rel="stylesheet">
    <link href="../css/datepicker3.css" rel="stylesheet">
    <link href="../css/styles.css" rel="stylesheet">

    <!--Custom Font-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="../js/html5shiv.js"></script>
    <script src="../js/respond.min.js"></script>
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
        <li><a href="home.php"><em class="fa fa-dashboard">&nbsp;</em> HOME </a></li>
        <li class="active"><a href="new_excuse.php"><em class="fa fa-plus">&nbsp;</em> Browse New Excuses</a></li>
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
            <li class="active">Follow New Excuses</li>
        </ol>
    </div><!--/.row-->

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Follow New Excuse</h1>
        </div>
    </div><!--/.row-->


    <div class="container">



        <div class="row">
            <div class="col-lg-12">

                <?php
                $stmt = $conn->prepare("SELECT * FROM excuses JOIN student ON excuses.student_id = student.student_id JOIN course ON excuses.course_id = course.course_id JOIN teatcher ON excuses.teatcher_id = teatcher.teatcher_id WHERE  excuses.state = 1");
                $stmt->execute();
                $rows = $stmt->fetchAll();

                ?>

                <div class="panel panel-default">
                    <div class="panel-heading">New Excuses</div>
                    <div class="panel-body">
                        
                        <table class="table">

                            <thead>
                            <tr>
                                <th>Order Number</th>
                                <th>Student Name</th>
                                <th>Course Name</th>
                                <th>Instructors Name</th>
                                <th>  </th>
                            </tr>
                            </thead>

                            <tbody>


                            <?php
                            if(!empty($rows)):

                                foreach ($rows as $row) {
                                    ?>
                                    <tr>
                                        <td><?php echo $row['excuse_id']?></td>
                                        <td><?php echo $row['student_name']?></td>
                                        <td><?php echo $row['course_name']?></td>
                                        <td><?php echo $row['teatcher_name']?></td>
                                        <td> <a href="show_order.php?id=<?php echo $row['excuse_id']?>" class="btn-link">Show Details</a>  </td>
                                    </tr>
                                    <?php
                                }
                            endif;
                            ?>


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cancel Order</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are sure to cancel this order?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <a href="" id="link_cancel" class="btn btn-primary">Yes</a>
                </div>
            </div>
        </div>
    </div>

    <script src="../js/jquery-1.11.1.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/chart.min.js"></script>
    <script src="../js/chart-data.js"></script>
    <script src="../js/easypiechart.js"></script>
    <script src="../js/easypiechart-data.js"></script>
    <script src="../js/bootstrap-datepicker.js"></script>
    <script src="../js/custom.js"></script>
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

    <script>

        function f(id) {

            var a = document.getElementById('link_cancel');
            a.href = "Follow_Excuse.php?cancel="+id;
        }

    </script>

</body>
</html>