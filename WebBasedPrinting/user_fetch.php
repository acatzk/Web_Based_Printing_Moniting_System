<?php
include 'includes/config.php';

$query = '';

$output = array();

$query .= "
    SELECT * FROM users
";


if(isset($_POST["search"]["value"]))
{
	$query .= '(email LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR username LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR fname LIKE "%'.$_POST["search"]["value"].'%") ';
}


if(isset($_POST["order"]))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY id DESC ';
}

if($_POST["length"] != -1)
{
	$query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}


$statement = $pdo->prepare($query);

$statement->execute();

$result = $statement->fetchAll();

$data = array();

$filtered_rows = $statement->rowCount();

foreach($result as $row)
{
	$status = '';
	if($row["status"] == 'Active')
	{
		$status = '<span class="label label-success">Active</span>';
	}
	else
	{
		$status = '<span class="label label-danger">Inactive</span>';
	}
	$sub_array = array();
	$sub_array[] = $row['id'];
	$sub_array[] = $row['fname'];
	$sub_array[] = $row['lname'];
  $sub_array[] = $row['username'];
  $sub_array[] = $row['email'];
	$sub_array[] = $status;
	$sub_array[] = '<button type="button" name="update" id="'.$row["id"].'" class="btn btn-warning btn-xs update">Update</button>';
	$sub_array[] = '<button type="button" name="delete" id="'.$row["id"].'" class="btn btn-danger btn-xs delete" data-status="'.$row["status"].'">Delete</button>';
	$data[] = $sub_array;
}

$output = array(
  	"draw"				=>	intval($_POST["draw"]),
  	"recordsTotal"  	=>  $filtered_rows,
  	"recordsFiltered" 	=> 	get_total_all_records($connect),
  	"data"    			=> 	$data
);

echo json_encode($output);

function get_total_all_records($connect)
{
  	$statement = $pdo->prepare("SELECT * FROM users");
  	$statement->execute();
  	return $statement->rowCount();
}


 ?>
