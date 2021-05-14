<?php
session_start();
// تاكد اذا المستخدم مسجل دخول او لا
if (!isset($_SESSION['staff:id'])) {
    header("Location: login.php ");
    exit();
}

include "../inc/db.php";


if(isset($_POST['update'])):

$order_id = (int)$_POST['order_id'];
$states = (int)$_POST['select'];
$comment = "";
if(isset($_POST['comment']) && !empty($_POST['comment'])){
    
    $comment = htmlspecialchars($_POST['comment']);

}

$stmt = $conn->prepare(" UPDATE `excuses` SET `state`= $states , `reason_refuse` = '$comment' WHERE excuse_id = $order_id");

if($stmt->execute()){
    header("Location: all_Excuse.php");
    exit();
}

endif;
