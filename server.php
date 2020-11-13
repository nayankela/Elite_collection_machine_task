<?php
session_start();
//initialize variables
$id = 0;
$name = "";
$email = "";
$phone= "";
$edit_state = false;

//connect to database
$db = mysqli_connect('localhost', 'root', '', 'crud');

//if save button  is clicked
if (isset($_POST['save'])) {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $phone= $_POST['phone'];
  $dob = $_POST['dob'];

  $query = "INSERT INTO info(name, email,phone,dob) VALUES ('$name', '$email', '$phone', $dob)";
mysqli_query($db, $query);
$_SESSION['msg'] = "Saved Successfully!!!";
header('location: index.php'); // redirect to index page after inserting
}

//update records
if (isset($_POST['update'])) {
  $email =  $_POST['email'];
   $id = $_POST['id'];

mysqli_query($db, "UPDATE info SET email = '$email' WHERE id=$id");
$_SESSION['msg'] = "Edited Successfully!!!";
header('location: index.php'); // redirect to index page after editing

}

//delete records
if (isset($_GET['del'])) {
  $id = $_GET['del'];
  mysqli_query($db, "DELETE FROM info WHERE id=$id");
  $_SESSION['msg'] = "Deleted Successfully!!!";
  header('location: index.php'); // redirect to index page after deleting

}


//retrive records
$results = mysqli_query($db, "SELECT * FROM info");


 ?>
