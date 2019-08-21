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


 ?>
    <!-- PHP FILES HERE -->
    <div  class="col-md-8 pull-left">
      <!-- <embed src="#toolbar=1" type="application/pdf" width="100%" height="700px;" id="filePDF" onLoad="printIt('filePDF')"> -->
      <iframe src="<?= $printfile; ?>#toolbar=1" width="100%" height="667px;" name="objAdobePrint" id="objAdobePrint" frameborder=0>
      </iframe>
    </div>

    <div class="container">
        <div class="row">
            <div class="pull-right">
                <div id="print">
                 <form method="post">
                    <div class="modal-dialog" style="width: 350px;">
                      <div class="modal-content">
                          <div class="modal-header">
                              <a href="upload_print.php" class="close">&times;</a>
                              <h4 class="modal-title">Print Settings</h4>
                          </div>
                         <div class="modal-body">
                              <div class="row">
                                   <div class="col-md-12">
                                      <div class="form-group">
                                          <label>Filename</label>
                                          <input name="filename" id="filename" class="form-control" type="text" value="<?= $filename; ?>" disabled required/>
                                      </div>
                                  </div>
                                  <div class="col-md-12">
                                      <div class="form-group">
                                          <label>Paper Size</label>
                                            <select class="form-control" name="papersize" id="papersize" required>
                                                  <option disabled selected></option>
                                                  <option>Letter</option>
                                                  <option>Tabloid</option>
                                                  <option>Legal</option>
                                                  <option>Statement</option>
                                                  <option>Executive</option>
                                                  <option>A3</option>
                                                  <option>A4</option>
                                                  <option>A5</option>
                                                  <option>B4 (JIS)</option>
                                                  <option>B5 (JIS)</option>
                                            </select>
                                      </div>
                                  </div>
                                  <div class="col-md-12">
                                      <div class="form-group">
                                          <label>No. Pages</label>
                                            <input name="numOfPages" id="numOfPages" class="form-control" type="text" required/>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <div class="modal-footer">
                              <button name="btnPrint" type="submit" id="printthis" class="hidden" class="btn btn-primary btn-fill btn-sm" >Save History</button>
                              <button type="button" onclick="javascript: savehistory();  printfile();" class="btn btn-primary btn-fill btn-sm">Print File</button>
                              <a href="files" class="btn btn-default btn-fill btn-sm">Cancel</a>
                          </div>
                      </div>
                    </div>
                  </form>
                </div>
            </div>
        </div>
    </div>

    <?php include 'includes/dashboard_footer.php'; ?>

    <script>

        function printfile() {

          window.frames['objAdobePrint'].focus();
          window.frames['objAdobePrint'].print();

        }

        function savehistory(){
            var btn = document.getElementById("printthis");
            // btn.click();
        }

    </script>

  <?php

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
        //header('location: index');
      }

  }

   ?>
