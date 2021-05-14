<?php
session_start();

if (isset($_SESSION['staff:id'])){
    
    unset($_SESSION['staff:id']);
}
header("Location: login.php");