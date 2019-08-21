<?php include 'includes/header.php'; ?>
<?php include 'includes/config.php'; ?>
<?php

session_start();

if (isset($_SESSION['email'])){
    header("location: index.php");
}


$error = '';
if(isset($_POST['login_user']))
{

     $sql = "SELECT * FROM users WHERE username = :username AND password = :password AND account_type = :account_type";
     $statement = $pdo->prepare($sql);
     $statement ->execute(
          array(
            ':username' =>  $_POST['username_user'],
            ':password' =>  $_POST['password_user'],
            ':account_type' => 'User'
          )
     );

     $count = $statement->rowCount();
     if ($count > 0){
          $result = $statement->fetchAll();
          foreach ($result as $row) {
            if ($row['status'] == 'Active'){
                  $_SESSION['id']  =  $row['id'];
                  $_SESSION['fname']  =  $row['fname'];
                  $_SESSION['lname']  =  $row['lname'];
                  $_SESSION['username'] = $row['username'];
                  $_SESSION['email'] = $row['email'];
                  $_SESSION['account_type'] = $row['account_type'];
                  header("location: index");
            } else {
                $error = 'Your account is being disabled. Contact your Administrator';
            }
          }
     } else {
        $error = 'Invalid User to access';
     }

}

if(isset($_POST['login_admin']))
{
     $sql = "SELECT * FROM users WHERE username = :username AND password = :password AND account_type = :account_type";
     $statement = $pdo->prepare($sql);
     $statement->execute(
          array(
            ':username' =>  $_POST['username_admin'],
            ':password' =>  $_POST['password_admin'],
            ':account_type' => 'Administrator'
          )
     );

     $count = $statement->rowCount();
     if ($count > 0){
          $result = $statement->fetchAll();
          foreach ($result as $row) {
              if ($row['status'] == 'Active'){
                    $_SESSION['id']  =  $row['id'];
                    $_SESSION['fname']  =  $row['fname'];
                    $_SESSION['lname']  =  $row['lname'];
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['account_type'] = $row['account_type'];
                    header("location: index");
              } else {
                  $error = 'Your account is being disabled. Contact your Co-Administrator';
              }
          }
     } else {
        $error = 'Invalid Admin to access';
     }

}

 ?>


	<div class="limiter" style="position: fixed;">
		<div class="container-login100">
			<div class="login100-more" style="background-image: url('images/RedMountain.jpg');">
          <h1 class="login100-form-title p-b-59" style="text-align: center; margin-top: 200px; color: #fff; font-size: 80px;">Web Based Printing</h1>
          <h1 class="login100-form-title p-b-59" style="text-align: center; color: #fff; font-size: 50px; font-family: sans-serif;">Monitoring System</h1>
      </div>
			<div class="wrap-login100 p-l-50 p-r-50 p-t-72 p-b-50" style="margin-top: 150px;">
				<form method="POST" class="login100-form validate-form">
  					<span class="login100-form-title p-b-59"><span class="fa fa-users"></span> Login Accounts</span>
            <?php
                  if ($error) {
                      echo '<div class="alert alert-danger" role="alert">' . $error . '</div>';
                  }
             ?>
  					<div class="container-login100-form-btn">
  						<div class="wrap-login100-form-btn">
  							<div class="login100-form-bgbtn"></div>
  							<button class="login100-form-btn" type="submit" data-toggle="modal" data-target="#loginUser">
                    <a href="" style="color: white;" data-toggle="modal" data-target="#loginUser">Login User</a>
                </button>
  						</div>
  						<a href="#" class="dis-block txt3 hov1 p-r-30 p-t-10 p-b-10 p-l-30" data-toggle="modal" data-target="#loginAdmin">
  							Login Admin
  						</a>
  					</div>
				</form>
			</div>
		</div>
	</div>


<!--  LOGIN ADMINISTRATOR -->
  <div id="loginAdmin" class="modal fade">
   <form method="post">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title"><span class="fa fa-user"></span> Login Administrator</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                      <div class="wrap-input100 validate-input" data-validate="Username is required">
                        <span class="label-input100">Username</span>
                        <input class="input100" type="text" name="username_admin" placeholder="Username...">
                        <span class="focus-input100"></span>
                      </div>
                      <div class="wrap-input100 validate-input" data-validate = "Password is required">
                        <span class="label-input100">Password</span>
                        <input class="input100" type="password" name="password_admin" placeholder="*************">
                        <span class="focus-input100"></span>
                      </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="button" class="btn btn-default btn-sm" data-dismiss="modal" value="Cancel" style="cursor: pointer;"/>
                <input type="submit" class="btn btn-primary btn-sm" name="login_admin" value="Login" style="cursor: pointer;"/>
            </div>
        </div>
      </div>
    </form>
  </div>


  <!--  LOGIN USER -->
    <div id="loginUser" class="modal fade">
     <form method="post">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title"><span class="fa fa-user"></span> Login User</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              </div>
              <div class="modal-body">
                  <div class="row">
                      <div class="col-md-12">
                        <div class="wrap-input100 validate-input" data-validate="Username is required">
                          <span class="label-input100">Username</span>
                          <input class="input100" type="text" name="username_user" placeholder="Username...">
                          <span class="focus-input100"></span>
                        </div>
                        <div class="wrap-input100 validate-input" data-validate = "Password is required">
                          <span class="label-input100">Password</span>
                          <input class="input100" type="password" name="password_user" placeholder="*************">
                          <span class="focus-input100"></span>
                        </div>
                      </div>
                  </div>
              </div>
              <div class="modal-footer">
                  <input type="button" class="btn btn-default btn-sm" data-dismiss="modal" value="Cancel" style="cursor: pointer;"/>
                  <input type="submit" class="btn btn-primary btn-sm" name="login_user" value="Login" style="cursor: pointer;"/>
              </div>
          </div>
        </div>
      </form>
    </div>


<?php include 'includes/footer.php'; ?>
