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
$connection_mysql = mysqli_connect($servername, $username, $password,$db);
$sql = sprintf("SELECT username, password FROM users WHERE username = '%s' AND password = '%s';", $user,$pass);


if(mysqli_connect_errno()){
    echo("connection is not set");
}else{
   do{
      if ($result=mysqli_store_result($connection_mysql)){
          
         while ($row=mysqli_fetch_row($result)){
            printf("%s\n",$row[0]);
         }
         mysqli_free_result($connection_mysql);

      }
   }while (mysqli_next_result($connection_mysql));
}
mysqli_close($connection_mysql);
$conn -> close();

?>

</body>

</html>