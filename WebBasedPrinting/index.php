<?php
include 'includes/dashboard_header.php';
include 'includes/config.php';

session_start();
if (!isset($_SESSION['email'])){
    header("location: login");
}

 ?>

 <?php
  $error = '';
   if (isset($_POST['btn_add']))
   {
        try {
          $sql = "
               INSERT INTO users (fname, lname, username, password, email, status, account_type)
                VALUES (:fname, :lname, :username, :password, :email, :status, :account_type)
          ";
          $statement = $pdo->prepare($sql);
          $statement->execute(
                array(
                  ':fname' => $_POST['firstname'],
                  ':lname' => $_POST['lastname'],
                  ':username'  => $_POST['username'],
                  ':password'  => $_POST['password'],
                  ':email' => $_POST['email'],
                  ':status'  => 'Active',
                  ':account_type'  => $_POST['account_type']
                )
          );
          header("location: index");
        } catch (Exception $e) {
            $error = "Error: " . $e;
        }

   }

?>

<div class="wrapper">

    <div class="sidebar" data-color="purple" data-image="assets/img/sidebar-5.jpg">
    	<div class="sidebar-wrapper">
            <div class="logo">
                <a href="index.php" class="simple-text">
                  <?php if ($_SESSION['account_type'] == 'Administrator') { ?>
                      Welcome Administrator
                  <?php } else { ?>
                      Web Based Printing & Monitoring System
                    <?php } ?>
                </a>
            </div>
            <ul class="nav">
                <li class="active">
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
                <li>
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
                  <div class="col-md-12">
                    <?php
                        if ($error) {
                           echo '<div class="alert alert-danger" role="alert">' . $error . '</div>';
                        }
                     ?>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="card">
                        <div class="header">
                          <?php if ($_SESSION['account_type'] == 'Administrator') { ?>
                            <div class="col-md-12" style="text-align: center;">
                              <h4 class="title">List of Users</h4>
                              <p class="category">Modify here...</p>
                              <!-- <form method="post">
                                <input type="button" name="btnActiveUser" class="btn btn-fill btn-sm btn-success" data-toggle="modal" data-target="#activeUser" value="Active Users">
                                <input type="button" name="btnInactiveUser" class="btn btn-fill btn-sm btn-danger" data-toggle="modal" data-target="#activeUser" value="Inactive Users">
                              </form> -->
                            </div>
                            <div class="col-md-0">
                              <a href="#" class="btn btn-info pull-right btn-fill btn-sm" data-toggle="modal" data-target="#addAccount">
                                <i class="pe-7s-plus"></i> Add
                              </a>
                            </div>
                            <div class="col-md-1">
                              <div class="form-group">
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
                          <?php } else {?>
                            <div class="col-md-12" style="text-align: center;">
                                <h4 class="title">History of your Printing Activities</h4>
                                <p class="category">Here are all your activities</p>
                            </div>
                            <div class="col-md-12">
                              <div class="form-group pull-right" style="margin-top: 10px; margin-right: 13px;">
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
                          <?php } ?>
                        </div>
                        <div class="content table-responsive table-full-width" id="mytable">
                            <table  class="table table-hover table-striped">
                              <?php if ($_SESSION['account_type'] == 'Administrator') { ?>
                                    <thead>
                                        <th>ID</th>
                                      <th>Firstname</th>
                                      <th>Lastname</th>
                                      <th>Username</th>
                                      <th>Email</th>
                                      <th>Status</th>
                                      <th>Update</th>
                                      <th>Delete</th>
                                    </thead>
                                    <tbody>
                                      <?php
                                      // <----------------- DISPLAY DATA ------------------------->

                                          $sql = "SELECT * FROM users WHERE account_type = :account_type ORDER BY status = :status DESC";
                                          $statement = $pdo->prepare($sql);
                                          $statement->execute(
                                                array(
                                                  ':account_type' => 'User',
                                                  ':status' =>  'Active'
                                                )
                                          );
                                       ?>
                                      <?php while ($row = $statement->fetch(PDO::FETCH_OBJ)){ ?>
                                           <tr>
                                             <td><?php echo $row->id; ?></td>
                                             <td><?php echo $row->fname; ?></td>
                                             <td><?php echo $row->lname; ?></td>
                                             <td><?php echo $row->username; ?></td>
                                             <td><?php echo $row->email; ?></td>
                                             <td>
                                               <?php
                                                   if ($row->status == 'Active'){
                                                       echo "<div class='label label-success'>Active</div>";
                                                   } else {
                                                       echo "<div class='label label-danger'>Inactive</div>";
                                                   }
                                               ?>
                                             </td>
                                             <td><a href="update_profile.php?update=<?= $row->id; ?>" class="btn btn-warning btn-fill btn-xs"><i class="pe-7s-edit"></i> Update</a></td>
                                             <td><a href="delete_profile.php?delete=<?php echo $row->id; ?>" class="btn btn-danger btn-fill btn-xs"><i class="pe-7s-delete-user"></i> Delete</a></td>
                                           </tr>
                                        <?php } ?>

                                    </tbody>
                              <?php } else { ?>
                                    <thead>
                                      <th>Date</th>
                                      <th>Filename</th>
                                      <th>Time</th>
                                      <th>Paper size</th>
                                      <th>No. Pages</th>
                                    </thead>
                                    <tbody>
                                      <?php
                                      // Fetch All the user_files
                                          $sql = "SELECT * FROM user_printing WHERE user_id = :user_id ORDER BY id DESC";
                                          $statement = $pdo->prepare($sql);
                                          $statement->execute(
                                                array(
                                                  ':user_id' =>  $_SESSION['id']
                                                )
                                          );
                                       ?>
                                       <?php while ($row = $statement->fetch(PDO::FETCH_OBJ)) { ?>
                                          <tr>
                                            <td><?php echo $row->date; ?></td>
                                            <td><?php echo $row->filename; ?></td>
                                            <td><?php echo $row->time; ?></td>
                                            <td><?php echo $row->paper_size; ?></td>
                                            <td><?php echo $row->no_pages; ?></td>
                                          </tr>
                                          <?php } ?>
                                    </tbody>
                              <?php } ?>
                            </table>
                            <div class="pagination-container" style="margin-left: 10px;">
                                <nav>
                                   <ul class="pagination"></ul>
                                </nav>
                            </div>
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


<!-- ========================= ADD MODAL ======================= -->
<div id="addAccount" class="modal fade">
 <form method="post">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">Add Account</h4>
          </div>
          <div class="modal-body">

              <div class="row">
                  <div class="col-md-6">
                      <div class="form-group">
                          <label>Username</label>
                          <input name="username" class="form-control" type="text" required/>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label>Password</label>
                          <input name="password" class="form-control" type="password" required/>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label>Firstname</label>
                          <input name="firstname" class="form-control" type="text" required/>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label>Lastname</label>
                          <input name="lastname" class="form-control" type="text" required/>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label>Email</label>
                          <input name="email" class="form-control" type="email" required/>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label>Account Type</label>
                          <select name="account_type" class="form-control" required>
                            <option selected disabled>--SELECT--</option>
                              <option>Administrator</option>
                              <option>User</option>
                          </select>
                      </div>
                  </div>
              </div>
          </div>
          <div class="modal-footer">
              <input type="submit" class="btn btn-info btn-fill btn-sm" name="btn_add" value="Add"/>
          </div>
      </div>
    </div>
  </form>
</div>



<!-- ========================= ACTIVE USERS MODAL ======================= -->
<div id="activeUser" class="modal fade">
 <form method="post">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">List of All Active Users</h4>
          </div>
          <div class="modal-body">
              <div class="row">
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="content table-responsive table-full-width" id="mytable">
                        <table  class="table table-hover table-striped">
                          <thead>
                              <th>ID</th>
                              <th>Firstname</th>
                              <th>Lastname</th>
                              <th>Username</th>
                              <th>Email</th>
                              <th>Status</th>
                              <th>Update</th>
                              <th>Delete</th>
                          </thead>
                          <tbody>

                            <?php
                            // <----------------- DISPLAY ACTIVE USER DATA ------------------------->
                                $sql = "
                                        SELECT * FROM users
                                        WHERE
                                        account_type = :account_type
                                        AND status = :status
                                        ORDER BY id DESC
                                      ";
                                $statement = $pdo->prepare($sql);
                                $statement->execute(
                                      array(
                                        ':account_type' => 'User',
                                        ':status' => 'Active'
                                      )
                                );
                             ?>
                            <?php while ($row = $statement->fetch(PDO::FETCH_OBJ)){ ?>
                                 <tr>
                                   <td><?php echo $row->id; ?></td>
                                   <td><?php echo $row->fname; ?></td>
                                   <td><?php echo $row->lname; ?></td>
                                   <td><?php echo $row->username; ?></td>
                                   <td><?php echo $row->email; ?></td>
                                   <td>
                                     <?php
                                         if ($row->status == 'Active'){
                                             echo "<div class='label label-success'>Active</div>";
                                         } else {
                                             echo "<div class='label label-danger'>Inactive</div>";
                                         }
                                      ?>
                                   </td>
                                   <td><a href="update_profile.php?update=<?= $row->id; ?>" class="btn btn-warning btn-fill btn-xs"><i class="pe-7s-edit"></i> Update</a></td>
                                   <td><a href="delete_profile.php?delete=<?php echo $row->id; ?>" class="btn btn-danger btn-fill btn-xs"><i class="pe-7s-delete-user"></i> Delete</a></td>
                                 </tr>
                              <?php } ?>
                          </tbody>
                    </div>
                  </div>
              </div>
          </div>
      </div>
    </form>
</div>


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
