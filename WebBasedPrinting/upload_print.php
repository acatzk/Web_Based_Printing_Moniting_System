<?php
include 'includes/dashboard_header.php';
include 'includes/config.php';


session_start();
if (!isset($_SESSION['email'])){
    header("location: login");
}

 ?>

 <?php
    if (isset($_POST['choose_file']))
    {

        $sql = "SELECT * FROM user_files WHERE filename = :filename AND user_id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(
            array(
              ':filename' =>  $_POST['doc_name'],
              ':user_id'  =>  $_SESSION['id']
            )
        );

        $count = $stmt->rowCount();
        if ($count > 0)
        {
            echo '<script>alert("File name already exist!")</script>';
        }
        else
        {
          try {
              $date = date("m/d/y");
              $user_id  = $_SESSION['id'];
              $doc_name = $_POST['doc_name'];
              $name = $_FILES['myfile']['name'];
              $tmp_name = $_FILES['myfile']['tmp_name'];

              $statement = $pdo->prepare("INSERT INTO user_files (user_id, date, filename, path) VALUES (:user_id, :date, :filename, :path)");

              $location = "documents/$name";
              move_uploaded_file($tmp_name, $location);
              $statement->execute(
                    array(
                      ':user_id'  =>  $user_id,
                      ':date'   =>  $date,
                      ':filename' =>  $doc_name,
                      ':path' =>  $location
                    )
              );
              echo '<script>alert("Successfully Added File!")</script>';
          } catch (\Exception $e) {
            echo '<script>alert("The file exceeds the limit of 8388608 bytes!")</script>';
          }
        }
    }

  ?>



<div class="wrapper">

    <div class="sidebar" data-color="purple" data-image="assets/img/sidebar-5.jpg">
    	<div class="sidebar-wrapper">
            <div class="logo">
                <a href="index" class="simple-text">
                    <?php if ($_SESSION['account_type'] == 'Administrator') { ?>
                        Welcome Administrator
                    <?php } else { ?>
                        Web Based Printing & Monitoring System
                      <?php } ?>
                </a>
            </div>

            <ul class="nav">
                <li>
                    <a href="index">
                        <i class="pe-7s-graph"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li>
                    <a href="profile">
                        <i class="pe-7s-user"></i>
                        <?php if ($_SESSION['account_type'] == 'Administrator') { ?>
                            <p>Admin Profile</p>
                        <?php } else { ?>
                            <p>User Profile</p>
                        <?php } ?>
                    </a>
                </li>
                <li class="active">
                    <?php if ($_SESSION['account_type'] == 'Administrator') { ?>
                          <a href="files">
                              <i class="pe-7s-note2"></i>
                              <p>Reports</p>
                          </a>
                    <?php } else { ?>
                          <a href="files">
                              <i class="pe-7s-paperclip"></i>
                              <p>Upload & Print</p>
                          </a>
                    <?php } ?>
                </li>
                <li>
                    <a href="logout">
                        <i class="pe-7s-door-lock"></i>
                        <p>Log out</p>
                    </a>
                </li>
            </ul>
    	   </div>
    </div>

    <div class="main-panel">
        <nav class="navbar navbar-default navbar-fixed">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example-2">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="profile">
                      <i class="pe-7s-user"></i>
                      <?php echo $_SESSION['fname'] . " " . $_SESSION['lname']; ?>
                      <small style="font-size: 15px; color: #aaa;"><?php echo "@".$_SESSION['username'];  ?></small>
                    </a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-left">
                        <li>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-dashboard"></i>
								                <p class="hidden-lg hidden-md">Dashboard</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a href="logout">
                                <p>Log out</p>
                            </a>
                        </li>
						             <li class="separator hidden-lg"></li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="content">
            <div class="container-fluid">
              <div class="row">
                <?php if ($_SESSION['account_type'] == 'User') { ?>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Add Your Files here</h4>
                                <p class="category">Upload files here</p>
                            </div>
                            <div class="content">
                              <form method="post" enctype="multipart/form-data">
                                  <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Filename</label>
                                            <input name="doc_name" class="form-control" type="text" required/>
                                        </div>
                                        <div class="form-group">
                                          <style media="screen">
                                             .filestyle{
                                                padding: 5px;
                                                background: #eee;
                                                border-radius: 4px;
                                                border: 1px solid #ddd;
                                                cursor: pointer;
                                             }
                                             .filestyle:hover{
                                               background: #ddd;
                                               border: 1px solid #aaa;
                                             }
                                             .filestyle.focus{
                                               background: #bbb;
                                               border: 1px solid #aaa;
                                             }
                                          </style>
                                            <input type="file" class="filestyle" class="form-control" name="myfile" required>
                                        </div>
                                        <button type="submit" name="choose_file" class="btn btn-info btn-fill" style="width: 100%;">
                                              <i class="pe-7s-upload pull-left"></i> Upload Now!
                                        </button>
                                    </div>
                                  </div>
                              </form>
                            </div>
                        </div>
                    </div>
                  <?php } ?>

              <?php if ($_SESSION['account_type'] == 'User') { ?>

                <?php

                    $sql = "SELECT * FROM user_files WHERE user_id = :user_id ORDER BY id DESC";
                    $statement = $pdo->prepare($sql);
                    $statement->execute(
                        array(
                          ':user_id'  =>  $_SESSION['id']
                        )
                    );

                 ?>
                <div class="col-md-8">
                  <div class="card">
                      <div class="header">
                         <div class="col-md-12" style="text-align: center;">
                             <h4 class="title">List of Your Files</h4>
                             <p class="category">Uploaded Files</p>
                         </div>
                        <div class="col-md-12">
                          <div class="form-group pull-right">
                              <select class="form-control" id="maxRows" name="state" style="width: 150px;">
                                  <option value="5000">Show All</option>
                                  <option value="5">5</option>
                                  <option value="10">10</option>
                                  <option value="20">20</option>
                                  <option value="25">25</option>
                                  <option value="50">50</option>
                                  <option value="75">75</option>
                                  <option value="100">100</option>
                              </select>
                          </div>
                        </div>
                      </div>
                      <div class="content">

                        <div class="content table-responsive table-full-width" id="mytable">
                            <table class="table table-hover table-striped">
                                <thead>
                                  <th>Date</th>
                                  <th>Filename</th>
                                  <th>Print</th>
                                  <th>Download</th>
                                  <th>Remove</th>
                                </thead>
                                <tbody>
                                  <?php while ($row = $statement->fetch(PDO::FETCH_OBJ)) { ?>
                                    <tr>
                                          <td><?php echo $row->date; ?></td>
                                          <td><?php echo $row->filename; ?></td>
                                          <td>
                                            <a  href="sample.php?print=<?= $row->id; ?>"  class="btn btn-success btn-fill btn-xs">
                                              <i class="pe-7s-print"></i> Print File
                                            </a>
                                          </td>
                                          <td>
                                            <a href="download.php?download=<?= $row->path; ?>" class="btn btn-info btn-fill btn-xs">
                                              <i class="pe-7s-cloud-download"></i> Download
                                            </a>
                                          </td>
                                          <td>
                                            <a href="removeFile.php?remove=<?= $row->id; ?>" class="btn btn-danger btn-fill btn-xs" id="remove">
                                              <i class="pe-7s-delete-user" ></i> Remove
                                            </a>
                                          </td>
                                    </tr>
                                  <?php } ?>
                                  </tbody>
                              </table>
                              <div class="pagination-container">
                                  <nav>
                                    <ul class="pagination"></ul>
                                  </nav>
                              </div>
                          </div>
                      </div>
                      </div>
                  </div>
                <?php } ?>
            </div>
            <div class="row">
                <?php if ($_SESSION['account_type'] == 'Administrator') { ?>

                <?php
                  $month = "";
                  $year = "";
                  $output = '';
                  $datee = date("m/d/Y");
                    if (isset($_POST['btnsearchgeneral']))
                    {

                        $month = $_POST['month'];
                        $year = $_POST['year'];
                        $sql = '
                                SELECT user_printing.date, users.fname, users.lname, user_printing.filename,
                                user_printing.time, user_printing.paper_size, user_printing.no_pages
                                FROM user_printing INNER JOIN users ON users.id = user_printing.user_id
                                WHERE user_printing.date LIKE :date AND user_printing.date2 LIKE :date2
                                ORDER BY user_printing.id DESC
                              ';

                        $statement = $pdo->prepare($sql);
                        $statement->execute(
                              array(
                                ':date' => "$month/%",
                                ':date2'  => "%/$year"
                              )
                        );

                        $count = $statement->rowCount();
                        if ($count == 0){
                            $output = '<div class="label label-danger">There was no data found!</div>';
                        } else {
                              while ($row = $statement->fetch(PDO::FETCH_OBJ)) {
                                  $output .= '<tr>';
                                        $output .= '<td>'.$row->date.'</td>';
                                       $output .= '<td>'.$row->fname.'</td>';
                                       $output .= '<td>'.$row->lname.'</td>';
                                        $output .= '<td>'.$row->filename.'</td>';
                                        $output .= '<td>'.$row->time.'</td>';
                                        $output .= '<td>'.$row->paper_size.'</td>';
                                        $output .= '<td>'.$row->no_pages.'</td>';
                                   $output .= '</tr>';
                              }
                        }

                    }

                    if (isset($_POST['btnsearchindividual']))
                    {
                          $month = $_POST['month'];
                          $year = $_POST['year'];
                          $user_id  = $_POST['username'];
                          $sql = '
                                  SELECT user_printing.date, users.fname, users.lname, user_printing.filename,
                                  user_printing.time, user_printing.paper_size, user_printing.no_pages
                                  FROM user_printing INNER JOIN users ON users.id = user_printing.user_id
                                  WHERE user_printing.date LIKE :date AND user_printing.date2 LIKE :date2
                                  AND users.id = :id ORDER BY user_printing.id DESC
                                ';

                          $statement = $pdo->prepare($sql);
                          $statement->execute(
                                array(
                                  ':date' => "$month/%",
                                  ':date2'  => "%/$year",
                                  ':id' =>  $user_id
                                )
                          );

                          $count = $statement->rowCount();
                          if ($count == 0){
                              $output = '<div class="label label-danger">There was no data found!</div>';
                          } else {
                                while ($row = $statement->fetch(PDO::FETCH_OBJ)) {
                                    $output .= '<tr>';
                                          $output .= '<td>'.$row->date.'</td>';
                                         $output .= '<td>'.$row->fname.'</td>';
                                         $output .= '<td>'.$row->lname.'</td>';
                                          $output .= '<td>'.$row->filename.'</td>';
                                          $output .= '<td>'.$row->time.'</td>';
                                          $output .= '<td>'.$row->paper_size.'</td>';
                                          $output .= '<td>'.$row->no_pages.'</td>';
                                     $output .= '</tr>';
                                }
                          }
                    }


                  ?>
                   <div class="row">

                     <!--  GENERAL MONTHLY AND YEARLY REPORT -->
                     <div class="col-md-5 col-sm-5 col-lg-5">
                           <div class="panel panel-info">
                             <div class="panel-heading" style="text-align: center;"><label>General Month & Year Report</labe></div>
                             <div class="panel-body">
                                   <form method="post">
                                      <div class="row">
                                         <div class="col-md-5">
                                             <div class="form-group">
                                                 <p>Month</p>
                                                 <select name="month"  class="form-control" required>
                                                     <option selected></option>
                                                      <option value="01">January</option>
                                                      <option value="02">February</option>
                                                      <option value="03">March</option>
                                                      <option value="04">April</option>
                                                      <option value="05">May</option>
                                                      <option value="06">June</option>
                                                      <option value="07">July</option>
                                                      <option value="08">August</option>
                                                      <option value="09">September</option>
                                                      <option value="10">October</option>
                                                      <option value="11">November</option>
                                                      <option value="12">December</option>
                                                 </select>
                                             </div>
                                         </div>
                                         <div class="col-md-5">
                                             <div class="form-group">
                                                 <p>Year</p>
                                                 <input type="text" name="year" class="form-control"  required value="<?= $year; ?>"/>
                                             </div>
                                         </div>
                                         <input type="submit" name="btnsearchgeneral" value="Search"  class="btn btn-info btn-fill btn-sm" style="margin-top: 36px;" />
                                      </div>
                                   </form>
                             </div>
                         </div>
                     </div>

                     <!--  INDIVIDUAL MONTHLY AND YEARLY REPORT -->
                     <div class="col-md-7 col-sm-6 col-lg-7">
                           <div class="panel panel-success">
                             <div class="panel-heading" style="text-align: center;" style="background-color: #fff !important;"><label>Individual Month & Year Report</labe></div>
                             <div class="panel-body">
                                   <form method="post">
                                      <div class="row">
                                         <div class="col-md-4 col-lg-4 col-sm-4">
                                           <div class="form-group">
                                             <?php
                                                  $sql = "
                                                      SELECT * FROM users WHERE
                                                      account_type = :account_type
                                                  ";
                                                  $statement = $pdo->prepare($sql);
                                                  $statement->execute(
                                                        array(
                                                          ':account_type'  => 'User'
                                                        )
                                                  );
                                              ?>
                                               <p>Username</p>
                                               <select name="username" class="form-control" required>
                                                   <option selected></option>
                                                   <?php while ($row = $statement->fetch(PDO::FETCH_OBJ)) { ?>
                                                      <option value="<?= $row->id; ?>"><?= $row->username; ?></option>
                                                   <?php } ?>
                                               </select>
                                           </div>
                                         </div>
                                         <div class="col-md-3 col-lg-3 col-sm-3">
                                             <div class="form-group">
                                                 <p>Month</p>
                                                 <select name="month"  class="form-control" required>
                                                     <option selected></option>
                                                      <option value="01">January</option>
                                                      <option value="02">February</option>
                                                      <option value="03">March</option>
                                                      <option value="04">April</option>
                                                      <option value="05">May</option>
                                                      <option value="06">June</option>
                                                      <option value="07">July</option>
                                                      <option value="08">August</option>
                                                      <option value="09">September</option>
                                                      <option value="10">October</option>
                                                      <option value="11">November</option>
                                                      <option value="12">December</option>
                                                 </select>
                                             </div>
                                         </div>
                                         <div class="col-md-3 col-lg-3 col-sm-3">
                                             <div class="form-group">
                                                 <p>Year</p>
                                                 <input type="text" name="year" class="form-control"  required value="<?= $year; ?>"/>
                                             </div>
                                         </div>
                                         <div class="col-md-1" style="margin-top: 38px; margin-left: 20px;">
                                           <div class="form-group">
                                              <input type="submit" name="btnsearchindividual" value="Search"  class="btn btn-success btn-fill btn-sm pull-right" />
                                           </div>
                                         </div>
                                      </div>
                                   </form>
                             </div>
                         </div>
                     </div>
                   </div>

                   <div class="col-md-12">
                     <div class="card">
                         <div class="header">
                           <div class="row">
                               <div class="col-md-12">
                                  <h3 class="title" style="text-align: center;">Montly Report Activities</h3>
                               </div>
                               <div class="col-md-4 pull-right">
                                  <input type="submit" style="margin: 2px;" name="export" value="Export" class="btn btn-fill btn-success btn-md pull-right">
                                  <input type="submit" style="margin: 2px;" name="printer" onclick="printReport('printThisFileReport')" value="Print" class="btn btn-fill btn-info btn-md pull-right">
                               </div>
                               <div class="col-md-4 pull-left">
                                 <div class="form-group pull-left" style="display: flex;">
                                     <select class="form-control" id="maxRows" name="state" style="width: 150px;">
                                         <option value="5000">Show All</option>
                                         <option value="5">5</option>
                                         <option value="10">10</option>
                                         <option value="20">20</option>
                                         <option value="25">25</option>
                                         <option value="50">50</option>
                                         <option value="75">75</option>
                                         <option value="100">100</option>
                                     </select>
                                 </div>
                               </div>
                           </div>
                         </div>
                         <div class="content">
                           <div class="content table-responsive table-full-width" id="printThisFileReport">
                               <table class="table table-hover table-striped" id="mytable">
                                   <thead>
                                     <th>Date</th>
                                     <th>Firstname</th>
                                     <th>Lastname</th>
                                     <th>Filename</th>
                                     <th>Time</th>
                                     <th>Paper size</th>
                                     <th>No. Pages</th>
                                   </thead>
                                   <tbody>
                                       <?= $output; ?>
                                     </tbody>
                                 </table>
                                 <div class="pagination-container">
                                     <nav>
                                       <ul class="pagination"></ul>
                                     </nav>
                                 </div>
                             </div>
                          </div>
                         </div>
                     </div>



                <?php } ?>
            </div>
          </div>
        </div>

        <footer class="footer">
              <div class="container-fluid">
                  <p class="copyright pull-right">
                      &copy; <script>document.write(new Date().getFullYear())</script> <a href="#">Web Based Printing</a>
                  </p>
              </div>
        </footer>
    </div>
</div>




<!-- ========================= PRINT MODAL ======================= -->
<div id="print" class="modal fade">
 <form method="post">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">Print File</h4>
          </div>
          <div class="modal-body">
              <div class="row">
                  <div class="col-md-12">
                      <div class="form-group">
                          <label>Date</label>
                          <input name="date" class="form-control" type="text" required enabled value=""/>
                      </div>
                  </div>
                  <div class="col-md-12">
                      <div class="form-group">
                          <label>Filename</label>
                            <input name="filename" class="form-control" type="text" enabled required value=""/>
                      </div>
                  </div>
              </div>
          </div>
          <div class="modal-footer">
              <input type="submit" class="btn btn-info btn-fill btn-sm" name="btnPrint" value="Print Now"/>
          </div>
      </div>
    </div>
  </form>
</div>


<?php

//  FOR EXPORTING FILES HERE
if (isset($_POST['export']))
{
    header("Content-Type: application/vnd.msword");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre=check=0");
    header("content-disposition: attachment; filename=sampleword.doc");
}

 ?>
<script type="text/javascript">
     function printReport(el){
         var restorepage = document.body.innerHTML;
         var printcontent = document.getElementById(el).innerHTML;
         document.body.innerHTML = printcontent;
         window.print();
         document.body.innerHTML = restorepage;
     }
</script>

<?php include 'includes/dashboard_footer.php'; ?>

<script>
  var table = '#mytable'
  $('#maxRows').on('change', function(){
      $('.pagination').html('')
      var trnum = 0
      var maxRows = parseInt($(this).val())
      var totalRows = $(table + ' tbody tr').length
      $(table + ' tr:gt(0)').each(function(){
          trnum++
          if (trnum > maxRows){
             $(this).hide()
          }
          if (trnum <= maxRows){
             $(this).show()
          }
      })
      if (totalRows > maxRows){
          var pagenum = Math.ceil(totalRows/maxRows)
          for (var i = 1; i <= pagenum;) {
              $('.pagination').append('<li data-page="' + i + '">\<span>' + i++ + '<span class="sr-only">(current)</span></span>\</li>').show()
          }
      }
      $('.pagination li:first-child').addClass('active')
      $('.pagination li').on('click', function(){
           var pageNum = $(this).attr('data-page')
           var trIndex = 0;
           $('.pagination li').removeClass('active')
           $(this).addClass('active')
           $(table + ' tr:gt(0)').each(function(){
              trIndex++
              if(trIndex > (maxRows * pageNum) || trIndex <= ((maxRows * pageNum) - maxRows)){
                  $(this).hide()
              } else {
                $(this).show()
              }
           })
      })
  })

</script>
