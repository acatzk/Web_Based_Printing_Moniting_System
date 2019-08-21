<?php
	session_start();
	unset($_SESSION["name"]);
  unset($_SESSION["username"]);
  unset($_SESSION["account_type"]);
  unset($_SESSION["email"]);
	header("location: login");
?>
