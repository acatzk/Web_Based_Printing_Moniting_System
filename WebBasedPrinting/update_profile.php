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
          // RETRIVE DATA
            $sql = "SELECT * FROM users WHERE id = :id";
            $statement = $pdo->prepare($sql);
            $statement->execute(
                array(
                  ':id' => $_GET['update']
                )
            );
            while ($row = $statement->fetch(PDO::FETCH_OBJ)){
                $username = $row->username;
                $password = $row->password;
                $email = $row->email;
                $firstname = $row->fname;
                $lastname = $row->lname;
                $status = $row->status;
            }

            // UPDATE BUTTON
            $message = '';
            if (isset($_POST['update_profile']))
            {
               $sql = "
                      UPDATE users SET username = :username, password = :password,
                        email = :email, fname = :fname, lname = :lname, status = :status
                         WHERE id = :id
               ";

               $statement = $pdo->prepare($sql);
               $statement->execute(
                     array(
                       ':username' => $_POST['username'],
                       ':password' => $_POST['password'],
                       ':email'  => $_POST['email'],
                       ':fname'  => $_POST['firstname'],
                       ':lname'  => $_POST['lastname'],
                       ':status'  => $_POST['status'],
                       ':id' => $_GET['update']
                     )
               );

               $message = 'Successfully Updated Profile!';
               header("location: index");

            }


         ?>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                  <div class="col-md-8">
                      <div class="card">
                          <div class="header">
                              <h4 class="title">Edit Profile</h4>
                          </div>
                          <div class="content">
                              <form method="post">
                                <?php
                                    if ($message != "") {
                                        echo '<div class="alert alert-success" role="alert">'
                                                . $message .
                                              '</div>';
                                    }
                                 ?>
                                  <div class="row">
                                      <div class="col-md-6">
                                          <div class="form-group">
                                              <label>Username</label>
                                              <input type="text" name="username" class="form-control" value="<?php echo $username ?>">
                                          </div>
                                      </div>
                                      <div class="col-md-6">
                                          <div class="form-group">
                                              <label for="exampleInputEmail1">Email</label>
                                              <input type="email" name="email" class="form-control" value="<?php echo $email; ?>">
                                          </div>
                                      </div>
                                  </div>
                                  <div class="row">
                                      <div class="col-md-6">
                                          <div class="form-group">
                                              <label>First Name</label>
                                              <input type="text" name="firstname" class="form-control" value="<?php echo $firstname; ?>">
                                          </div>
                                      </div>
                                      <div class="col-md-6">
                                          <div class="form-group">
                                              <label>Last Name</label>
                                              <input type="text" name="lastname" class="form-control" value="<?php echo $lastname; ?>">
                                          </div>
                                      </div>
                                  </div>
                                  <div class="row">
                                      <div class="col-md-6">
                                          <div class="form-group">
                                              <label>Password</label>
                                              <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                                          </div>
                                      </div>
                                      <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Status</label>
                                                <select name="status" class="form-control">
                                                  <option selected disabled><?php echo $status; ?></option>
                                                    <option>Active</option>
                                                    <option>Inactive</option>
                                                </select>
                                            </div>
                                      </div>
                                  </div>
                                  <input type="submit" name="update_profile" value="Update Profile" class="btn btn-info btn-fill pull-right">
                                  <div class="clearfix"></div>
                              </form>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-4">
                        <div class="card card-user">
                            <div class="image">
                                <!-- <img src="" alt="..."> -->
                            </div>
                            <div class="content">
                                <div class="author">
                                     <a href="#">
                                    <img  src="assets/img/faces/face-0.jpg" alt="...">
                                      <h4 class="title"><?php echo $firstname . " " . $lastname; ?><br>
                                         <small><?php echo "@".$username; ?></small>
                                      </h4>
                                    </a>
                                </div>
                            </div>
                            <hr>
                            <div class="text-center">
                                <button href="#" class="btn btn-simple"><i class="fa fa-facebook-square"></i></button>
                                <button href="#" class="btn btn-simple"><i class="fa fa-twitter"></i></button>
                                <button href="#" class="btn btn-simple"><i class="fa fa-google-plus-square"></i></button>

                            </div>
                        </div>
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
