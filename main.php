<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Dashboard</title>
</head>
<style>
  body {
  background-color: lightblue;
}

h1 {
  color: black;
  text-align: center;
}

p {
  font-family: verdana;
  font-size: 20px;
}
</style>
<body>



<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$db ="login";

$user=$_POST['username'];
$pass=$_POST['password'];


// Create connection
$conn = new mysqli($servername, $username, $password,$db);
$query = sprintf("SELECT username, password FROM users WHERE username=%s AND password=%s;", $user,$pass);
if ($conn -> multi_query($query)) {
  do {
      if (!$conn -> more_results()){
        break;
      }
      /* store the result set in PHP */
      if ($result = $conn->store_result()) {
          while ($row = $result->fetch_row()) {
              printf("%s\n", $row[0]);
          }
          print('<h2>User is authenticated</h2>');
      }
      
      /* print divider */
      if ($conn->more_results()) {
          echo '<h2>Incorrect Password</h2>';
      }
      
  } while ($conn->next_result());
}


$conn -> close();

?>

</body>

</html>