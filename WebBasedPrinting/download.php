<?php

include 'includes/config.php';
session_start();

if (isset($_GET['download']))
{
    $path = $_GET['download'];
    $statement = $pdo->prepare('SELECT * FROM user_files WHERE path = :path AND id = :id');
    $statement->execute(
        array(
          ':path' => $path,
          ':id' =>  $_SESSION['id']
        )
    );

    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($path) . '"');
    header('Content-Length: ' . filesize($path));
    readfile($path);
}

 ?>
