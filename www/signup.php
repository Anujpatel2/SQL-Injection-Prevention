<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$db ="login";

$user=$_POST['email'];
$pass=$_POST['password'];


//Technique 1: Parameterized Queries
// Create connection
$conn = new mysqli($servername, $username, $password,$db);
// $sql = "INSERT INTO users (username, password)
// VALUES ('John', 'john@example.com')";
// $hashuser = hash('sha256', $user);
// $hashpassword = hash('sha256', $pass);
$user=password_hash($user, PASSWORD_BCRYPT,array('cost' => 12));
$pass=password_hash($pass, PASSWORD_BCRYPT,array('cost' => 12));

$sql = sprintf("INSERT INTO users (username, password) VALUE ('%s','%s')", $user,$pass);

if ($conn->query($sql) === TRUE) {
  echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn -> close();

?>