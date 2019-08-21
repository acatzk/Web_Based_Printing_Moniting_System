
<?php

include 'includes/config.php';
include 'includes/dashboard_header.php';
session_start();

if (!isset($_SESSION['email'])){
    header("location: login");
}

if (isset($_GET['print']))
{
    $sql = "SELECT * FROM user_files WHERE id = :id AND user_id = :user_id";
    $statement = $pdo->prepare($sql);
    $statement->execute(
        array(
          ':id' => $_GET['print'],
          ':user_id'  =>  $_SESSION['id']
        )
    );

    while ($row = $statement->fetch(PDO::FETCH_OBJ))
    {
        $filename = $row->filename;
        $printfile = $row->path;
    }
}

if (isset($_POST['btnPrint']))
{

    date_default_timezone_set('Asia/Singapore');
    $date = date("m/d/Y");
    $time = date("h:i:s a");

    $sql = "SELECT * FROM user_printing WHERE date = :date AND user_id = :user_id";
    $statement = $pdo->prepare($sql);
    $statement->execute(
          array(
            ':date' =>  $date,
            ':user_id'  =>  $_SESSION['id']
          )
    );

    $count = $statement->rowCount();

    if ($count >= 10) {
        echo '<script>alert("You exceeds the limit of TEN (10) printing activities per day!")</script>';
    } else {
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
            ':filename' =>  $filename,
            ':time'     =>  $time,
            ':paper_size' => $_POST['papersize'],
            ':no_pages' =>  $_POST['numOfPages']
          )
      );
      header('location: index');
    }

}

 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document Printing</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <script src="https://mozilla.github.io/pdf.js/build/pdf.js"></script>
    <title>PDF File</title>
  </head>
  <body>

    <div class="top-bar">
        <button class="btn" id="prev-page">
              <i class="fa fa-arrow-circle-left"></i> Prev Page
        </button>
        <button class="btn" id="next-page">
              Next Page <i class="fa fa-arrow-circle-right"></i>
        </button>

        <span class="page-info">
            Page <span id="page-num"></span> of <span id="page-count"></span>
        </span>
    </div>

    <canvas id="pdf-render">
    </canvas>

    <script src="pdfviewer/pdf.js"></script>
    <script src="pdfviewer/main.js"></script>

  </body>
</html>







<!--?php include 'includes/dashboard_footer.php'; ?-->
