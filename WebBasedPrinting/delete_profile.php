<?php
include 'includes/dashboard_header.php';
include 'includes/config.php';

session_start();
if (!isset($_SESSION['email'])){
    header("location: login");
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
                        <i class="pe-7s-back"></i>
                        <p>Back</p>
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


        <?php

          $statement = $pdo->prepare("SELECT * FROM users WHERE id = :id");
          $statement->execute(
                array(
                  ':id' => $_GET['delete']
                )
          );
          while ($row = $statement->fetch(PDO::FETCH_OBJ)){
              $username = $row->username;
          }

          if (isset($_POST['btnYes']))
          {
               $sql = "UPDATE users SET status = :status WHERE id = :id";
               $statement = $pdo->prepare($sql);
               $statement->execute(
                     array(
                       ':id'  =>  $_GET['delete'],
                       ':status'  => 'Inactive'
                     )
               );
               header("location: index");

          }
         ?>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                  <div id="addAccount">
                   <form method="post">
                      <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <a href="index" class="close">&times;</a>
                                <h4 class="modal-title">Are you sure you want to delete <?= "@".$username; ?>? </h4>
                            </div>
                            <div class="modal-footer" style="text-align: center;">
                                <input type="submit" class="btn btn-info btn-fill btn-lg" name="btnYes" value="Yes"/>
                                <a href="index" class="btn btn-default btn-fill btn-lg">No</a>
                            </div>
                        </div>
                      </div>
                    </form>
                  </div>
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


<?php include 'includes/dashboard_footer.php'; ?>
