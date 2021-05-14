<?php session_start();
// تاكد اذا المستخدم مسجل دخول او لا
if (!isset($_SESSION['user:id'])){
    header("Location: login.php ");
    exit();
}
include "inc/db.php";
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ADD - Excuse</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/datepicker3.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
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

            <img src="img/New_Logo_ARMS.png" alt="" srcset="" width="160">

        </div>
    </div><!-- /.container-fluid -->
</nav>
<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">

    <ul class="nav menu">
        <li ><a href="home.php"><em class="fa fa-dashboard">&nbsp;</em> HOME </a></li>
        <li class="active"><a href="add_excuse.php"><em class="fa fa-plus">&nbsp;</em> Add Excuse</a></li>
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
            <li class="active">Add Excuse</li>
        </ol>
    </div><!--/.row-->

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Add Excuse</h1>
        </div>
    </div><!--/.row-->


    <div class="container">

        <?php
        $user_id = $_SESSION['user:id'];
        $stmt = $conn->prepare("SELECT * FROM `student` WHERE  student_id = $user_id");
        $stmt->execute();
        $row = $stmt->fetch();

        if(isset($_POST['add'])){

            $date = $_POST['date'];
            $file_name = $_FILES['file']['name'];
            $file_temp = $_FILES['file']['tmp_name'];
            $comment = $_POST['comment'];

            if(empty($date)){

                echo '<div class="alert alert-danger" role="alert">
               Please choose the date 
                </div>';


            }else{

            


            if(!empty($_POST['class'])) {


                $fileNameCmps = explode(".", $file_name);
                $fileExtension = strtolower(end($fileNameCmps));
                $newFileName = md5(time() . $file_name) . '.' . $fileExtension;

                $allowedfileExtensions = array('jpg', 'jpeg', 'png', 'pdf', 'docx', 'doc');

                $uploadFileDir = 'uploads/';

                if (in_array($fileExtension, $allowedfileExtensions)) {


                    $dest_path = $uploadFileDir . $newFileName;
                    if (move_uploaded_file($file_temp, $dest_path)) {

                        $stmtz = $conn->prepare("INSERT INTO `excuses`(`student_id`, `course_id`, `teatcher_id`, `date_submit`, `file_excuse`, `comment`, `state`) 
                                                        VALUES (:user_id,:course,:instructor,:xdate,:newFileName,:comment,:states)
                                                        ");

                        foreach ($_POST['class'] as $instructor=>$course){


                        $stmtz->bindValue(':user_id', $user_id);
                        $stmtz->bindValue(':course', $course);
                        $stmtz->bindValue(':instructor', $instructor);
                        $stmtz->bindValue(':xdate', $date);
                        $stmtz->bindValue(':newFileName', $newFileName);
                        $stmtz->bindValue(':comment', $comment);
                        $stmtz->bindValue(':states', 1);
                        $stmtz->execute();

                        
                        }
                        
                        echo '<div class="alert alert-success" role="alert">
                             Your request has been sent successfully
                            </div>';

                    } else {
                        echo '<div class="alert alert-warning" role="alert">
                            There is Error Please try again
                            </div>';
                    }

                } else {
                    echo '<div class="alert alert-danger" role="alert">
                            Your file is not accepted 
                            </div>';
                }
            }else{
                echo '<div class="alert alert-danger" role="alert">
                            Your have choose one course at less
                            </div>';
            }
        }
    }

        ?>

        <form action="" method="post"   enctype="multipart/form-data">

            <div class="form-group">
                <label for="exampleInputEmail1">Student Name </label>
                <input type="text" name="disabled" readonly value="<?php echo $row['student_name']?>" class="form-control">
            </div>

            <div class="form-group">
                <label for="exampleInputEmail1">Student ID </label>
                <input type="text" name="disabled" readonly value="<?php echo $row['student_id']?>" class="form-control">
            </div>


            <div class="form-group">
                <label for="exampleInputEmail1">Dept. </label>
                <input type="text" name="disabled" readonly value="<?php echo $row['Depart']?>" class="form-control">
            </div>








            <!-- Todo: Start new change here -->
            <?php if(!isset($_GET['day']) || empty($_GET['day'])): ?>


            <div class="form-group">
                <label for="exampleInputEmail1">Choose the day you was absent </label>
                <select class="form-control form-control-lg days" id="day" required>
                        <option value="Sunday">Sunday</option>
                        <option value="Monday">Monday</option>
                        <option value="Tuesday">Tuesday</option>
                        <option value="Wednesday">Wednesday</option>
                        <option value="Thursday">Thursday</option>
                </select>
            </div>

            <a href="?day=Sunday" id="get_day" class="btn btn-primary"> Search </a>
            <?php endif; ?>

            
            <?php if(isset($_GET['day']) || !empty($_GET['day'])): ?>

            <?php
            $day = $_GET['day'];
            $stmt_day = $conn->prepare("SELECT * FROM studentCourseTable JOIN student ON studentCourseTable.student_id = student.student_id JOIN course ON studentCourseTable.course_id = course.course_id JOIN teatcher ON studentCourseTable.teacher_id = teatcher.teatcher_id WHERE studentCourseTable.student_id = '$user_id' and studentCourseTable.course_day = '$day' ");
            $stmt_day->execute();
            $rows_day = $stmt_day->fetchAll();
            if(empty($rows_day)){
                echo  '<div class="alert alert-warning" role="alert">
                             You do not have classes on <b>'. $day.'</b>
                             Please <a href="add_excuse.php" class="btn-link">try again</a>
                            </div>';
                die();
            }
            ?>

            <div class="form-group">
                <label for="exampleInputEmail1">Choose the courses </label>
                <div class="panel-body">

                    <ul class="todo-list">
                        <?php foreach ($rows_day as $val): ?>
                        <li class="todo-list-item">
                            <div class="checkbox">
                            
                                <input type="checkbox" id="checkbox-course-<?php echo $val['course_id'] ?>" name="class[<?php echo $val['teacher_id']?>]" value="<?php echo $val['course_id']?>">

                                <label for="checkbox-course-<?php echo $val['course_id'] ?>"><?php echo $val['course_name']?> | Dr. <b><?php echo $val['teatcher_name']?></b></label>
                            </div>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>

            <div class="form-group">
                <label for="exampleInputPassword1">Absent Date</label>
                <input type="date" class="form-control" id="date1" name="date" required  >
            </div>

            <div class="form-group">
                <label for="exampleInputPassword1">Excuse File <span> (PDF, DOC, DOCX) </span></label>
                <input type="file" name="file" id="exampleInputPassword1" required>
            </div>

            <div class="form-group">
                <label for="exampleInputPassword1">Comment <span style="color: #0000008c" >(option)</span></label>
                <textarea class="form-control" name="comment" rows="6"></textarea>
            </div>



            <button type="submit" name="add" class="btn btn-primary">Submit</button>
            <?php endif; ?>
        </form>

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

        $('select.days').change(function () {
             var selectedDay = $(this).children("option:selected").val();
            $("#get_day").attr("href", "?day="+selectedDay)
        });
    </script>


    <script>
        function dayToNum(day) {

            switch (day) {

                case 'Sunday':
                    day = 0;
                    break;

                case 'Monday':
                    day = 1;
                    break;

                case 'Tuesday':
                    day = 2;
                    break;

                case 'Wednesday':
                    day = 3;
                    break;

                case 'Thursday':
                    day = 4;
                    break;

                default:
                    day = 0;


            }
            return day;
        }


        flatpickr("#date1", {
            dateFormat: "Y-m-d",
            maxDate: "today",
            disable: [
                function(date) {
                    // disable every multiple of 8
                    return (date.getDay() !== dayToNum('<?php echo $_GET['day']?>') );
                }
            ]
        });


    </script>

    <script>
        $('#hid').hide();
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