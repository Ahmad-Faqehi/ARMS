<?php session_start();
// تاكد اذا المستخدم مسجل دخول او لا
if (!isset($_SESSION['staff:id'])){
    header("Location: login.php ");
    exit();
}
include "../inc/db.php";

if(isset($_GET['id']) && !empty($_GET['id'])){

    $order_id = (int)$_GET['id'];
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
            <img src="../img/New_Logo_ARMS.png" alt="" srcset="" width="160">

        </div>
    </div><!-- /.container-fluid -->
</nav>
<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">

    <ul class="nav menu">
        <li><a href="home.php"><em class="fa fa-dashboard">&nbsp;</em> HOME </a></li>
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
                <label for="exampleInputPassword1">Excuse File  </label> <i class="fa fa-file-o"></i>  <a href="../uploads/<?php echo $row['file_excuse']?>" class="btn-link"> download </a>
            </div>

            <?php if(!empty($row['comment'])):?>
            <div class="form-group">
                <label for="exampleInputPassword1">Comment </label>
                <textarea class="form-control" name="comment" readonly  rows="6"><?php echo $row['comment']?></textarea>
            </div>
            <?php endif; ?>


                <div class="text-center">
                <?php
                if($row['state'] == 1):
                ?>

                    <a href="" data-toggle="modal" data-target="#exampleModal"  class="btn btn-success">Accept</a>
                    <a href="" data-toggle="modal" data-target="#exampleModalLabelCa" class="btn btn-danger">Refusal</a>

                <?php else: ?>
                <a href="" data-toggle="modal" data-target="#exampleModalLabelEdit"  class="btn btn-primary">Edit Status</a>
                <?php endif; ?>


                </div>
            </div>
        </div>


        <br>

    </div>

    <!-- Modal Accept -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Accept Excuse</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure to accept this excuse?
                    <br>

                    <small>An email containing the excuse details will be sent to  <b>Dr. <?php echo $row['teatcher_name']?> </b> automatically </small>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <a href="accept.php?id=<?=$order_id?>" id="link_cancel" class="btn btn-primary">Yes</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Refused -->
    <div class="modal fade" id="exampleModalLabelCa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelCa" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Refused the Excuse</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form action="refusesd.php" method="post">
                        <input type="hidden" name="order" value="<?=$order_id?>">
                        <label>The Reason of Refuse</label>
                        <textarea class="form-control" name="comment" rows="6" placeholder="Write here the reason of refuse"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                    <input type="submit" class=" btn btn-primary" name="refuse" value="Send">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <div class="modal fade" id="exampleModalLabelEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelEdit" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Status of Excuse</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="edit.php" method="post">
                        <label> Excuse Status: </label>
                        <select class="form-control form-control-sm country" name="select">
                            <option value="0">...</option>
                            <option value="1">Pending</option>
                            <option value="2">Accepted</option>
                            <option value="3">Refused</option>
                        </select>
                        <br>
                        <div id="xhide">
                        <label>The Reason of Refuse</label>
                        <textarea class="form-control" name="comment" rows="6" placeholder="Write here the reason of refuse"></textarea>
                </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <input type="hidden" value="<?=$order_id?>" name="order_id">
                    <input type="submit" class="btn btn-primary" value="Edit" name="update">
                </div>
                </form>
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
         $("#xhide").hide();
    </script>

    
    <script>
$(document).ready(function(){
    $("select.country").change(function(){
        var selectedCountry = $(this).children("option:selected").val();
        
        if( selectedCountry == 3){
            $("#xhide").show();
        }else{
            $("#xhide").hide();
        }

    });
});
 
</script>
 
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