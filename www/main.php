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
$technique=$_POST['techniques'];

//Technique 1: Parameterized Queries
// Create connection
//$conn = new mysqli($servername, $username, $password, $db);
//$query = sprintf("SELECT username, password FROM users WHERE username = '%s' AND password = '%s';", $user,$pass);

$connection_mysql = mysqli_connect($servername, $username, $password,$db);
$sql = sprintf("SELECT username, password FROM users WHERE username = '%s' AND password = '%s';", $user,$pass);

if ($technique == '1'){

  if(mysqli_connect_errno()){
      echo("connection is not set");
  }else{
    // do{
        if ($result = $connection_mysql -> query($sql)){
            // echo('here');
          while ($row = $result -> fetch_row()){
              // printf("%s\n", $row[0]);  
          }
          
        if(mysqli_num_rows($result) > 0){
                echo '<h2> User is Authenticated</h2>';  
        }else{
              echo "<h2>User not authenticated!</h2>";
            }
        }

        $result -> free_result();
        
    // }while(mysqli_next_result($connection_mysql));
  }
} else if ($technique == '2'){
//   //Technique 2: Escaping
  $escape_username= mysqli_real_escape_string($connection_mysql, $user);
  $escape_password = mysqli_real_escape_string($connection_mysql, $pass);

  $query = sprintf("SELECT username, password FROM users WHERE username = '%s' AND password = '%s';", $escape_username,$escape_password);

  if(mysqli_connect_errno()){
      echo("connection is not set");
  }else{
        if ($result = $connection_mysql -> query($query)){
          while ($row = $result -> fetch_row()){
              // printf("%s\n", $row[0]);  
          }
        if(mysqli_num_rows($result) > 0){
                echo '<h2> User is Authenticated</h2>';  
        }else{
              echo "<h2>User not authenticated!</h2>";
            }
        }
        $result -> free_result();
    }
} else if ($technique == '3'){

  // //Technique 3: Hashing User Input
  $hashed_user = password_hash($user, PASSWORD_DEFAULT);
  $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

  $sql2 = sprintf("SELECT username, password FROM users WHERE username = '%s' AND password = '%s';", $hased_user, $hashed_password);

  if(mysqli_connect_errno()){
    echo("connection is not set");
  } else{
      if ($result = $connection_mysql -> query($sql2)){
          // echo('here');
        while ($row = $result -> fetch_row()){
            // printf("%s\n", $row[0]);  
        }
        var_dump($hashed_user);
        var_dump($hashed_password);

        // $options = array('salt' => 'ThisIsTheSaltIProvide.');
        $res = mysqli_fetch_array($sql2);
        $hash = $res['password'];

        if(password_verify($pass, $hash)){
          echo('password is valid');
        }else{
          echo('passwords is not valid');
        }
      // if(mysqli_num_rows($result) > 0){
      //         echo '<h2> User is Authenticated</h2>';  
      // }else{
      //       echo "<h2>User not authenticated!</h2>";
      //     }
       }
  }

  

}
else if ($technique == '4'){
  //Technique 4: filter_var() Function
  $email_username = $user;
  if(mysqli_connect_errno()){
    echo("connection is not set");
  } else{
        $email_username = filter_var($user, FILTER_SANITIZE_EMAIL);            
        
        if (filter_var($email_username, FILTER_VALIDATE_EMAIL)) {
            echo('valid email');
            if ($result = $connection_mysql -> query($sql)){
              if(mysqli_num_rows($result) > 0){
                  echo '<h2> User is Authenticated</h2>';  
              }else{
                echo "<h2>User not authenticated!</h2>";
              }
            }
        } else{
          echo('Invalid email');
        }
        $result -> free_result();
    } 
} else if ($technique == '5'){
  //Technique 5: Regex Utilization
  $validate =  "/(and|or|union|where|limit|group by|select|\'|hex|substr|\s)/i";

  if(mysqli_connect_errno()){
    echo("connection is not set");
  } else{
        if((preg_match($validate, $user)) || (preg_match($validate, $pass))){
          echo '<h2> Incorrect Input, You used invalid characters</h2>';
        } else{
            if ($result = $connection_mysql -> query($sql)){
              if(mysqli_num_rows($result) > 0){
                  echo '<h2> User is Authenticated</h2>';  
              }else{
                echo "<h2>User not authenticated!</h2>";
              }
            }
          }
          $result -> free_result();
        }
  }

mysqli_close($connection_mysql);


?>

</body>

</html>