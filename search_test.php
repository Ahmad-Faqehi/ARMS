<?php
include "inc/db.php";
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Search Page</title>
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
            <div class="panel-heading">Search</div>
            <div class="panel-body">

                <form action="" method="post">
                    <fieldset>
                        <div class="form-group">
                            <label>Student ID</label>
                            <input class="form-control" placeholder="Student ID" name="username" type="text" autofocus="">
                        </div>

                        <input type="submit" value="Go" class="btn btn-primary" name="Go">
                    </fieldset>
                </form>
                <?php
                if(isset($_POST['Go'])) {

                    $stu_id = $_POST['username'];

                    $stmt = $conn->prepare("SELECT * FROM excuses JOIN student ON excuses.student_id = student.student_id JOIN course ON excuses.course_id = course.course_id JOIN teatcher ON excuses.teatcher_id = teatcher.teatcher_id WHERE excuses.student_id = '$stu_id'");
                    $stmt->execute();
                    $rows = $stmt->fetchAll();

                    if(!empty($rows)): ?>

                    <div style="padding-top: 20px">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th scope="col">Student ID</th>
                                <th scope="col">Student Name</th>
                                <th scope="col">Course</th>
                                <th scope="col">Teacher</th>
                                <th scope="col">Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($rows as $row): ?>
                            <tr>
                                <th scope="row"><?php echo $row['user_id']?></th>
                                <td><?php echo $row['student_name'] ?></td>
                                <td><?php echo $row['course_name'] ?></td>
                                <td><?php echo $row['teatcher_name'] ?></td>
                                <td><?php echo $row['date_submit'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                  <?php  endif;

                }
                ?>
            </div>
        </div>
    </div><!-- /.col-->
</div><!-- /.row -->


<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
