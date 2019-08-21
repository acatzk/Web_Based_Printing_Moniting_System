<?php

date_default_timezone_set('Asia/Singapore');
$date = date("m/d/Y");
$time = date("h:i:s a");

$name = $_POST['filename'];
$size = $_POST['papersize'];
$page = $_POST['numOfPages'];

$sql = "
      INSERT INTO user_printing (user_id, date, date2, filename, time, paper_size, no_pages)
      VALUES (:user_id, :date, :date2, :filename, :time, :paper_size, :no_pages)
";

$statement = $pdo->prepare($sql);
$statement->execute(
      array(
        ':user_id'  =>  $_SESSION['id'],
        ':date'     =>  $date,
        ':date2'     =>  $date,
        ':filename' =>  $name,
        ':time'     =>  $time,
        ':paper_size' => $size,
        ':no_pages' => $page
      )
);
header('location: index');

 ?>
