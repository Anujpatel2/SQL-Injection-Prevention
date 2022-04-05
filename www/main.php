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
$db = "login";

$user = $_POST['username'];
$pass = $_POST['password'];
$technique = $_POST['techniques'];

// Create connection
$connection_mysql = mysqli_connect($servername, $username, $password, $db);
$sql = sprintf("SELECT username, password FROM users WHERE username = '%s' AND password = '%s';", $user, $pass);


if ($technique == '1') {
  //Technique 1: Parameterized Queries

  $stmt = $connection_mysql->prepare("SELECT username, password FROM users WHERE username = ? AND password = ?;");
  $stmt->bind_param('ss', $user, $pass);
  // 's' specifies the variable type => 'string'  $stmt->execute();
  $stmt->execute();
  if (mysqli_connect_errno()) {
    echo("connection is not set");
  }
  else {
    if ($result = $stmt->get_result()) {
      while ($row = $result->fetch_assoc()) {
      }
      if (mysqli_num_rows($result) > 0) {
        echo '<h2> User is Authenticated</h2>';
      }
      else {
        echo "<h2>User not authenticated!</h2>";
      }
    }

    $result->free_result();
  }
}
else if ($technique == '2') { //   //Technique 2: Escaping
  $escape_username = mysqli_real_escape_string($connection_mysql, $user);
  $escape_password = mysqli_real_escape_string($connection_mysql, $pass);

  $query = sprintf("SELECT username, password FROM users WHERE username = '%s' AND password = '%s';", $escape_username, $escape_password);

  if (mysqli_connect_errno()) {
    echo("connection is not set");
  }
  else {
    if ($result = $connection_mysql->query($query)) {
      while ($row = $result->fetch_row()) {
      // printf("%s\n", $row[0]);  
      }
      if (mysqli_num_rows($result) > 0) {
        echo '<h2> User is Authenticated</h2>';
      }
      else {
        echo "<h2>User not authenticated!</h2>";
      }
    }
    $result->free_result();
  }
}
else if ($technique == '3') {
  //Technique 3: Hashing User Input

  $user = mysqli_real_escape_string($connection_mysql, $user);
  $query = "SELECT * FROM users WHERE username = '$user'";

  $val = mysqli_query($connection_mysql, $query);
  if (mysqli_num_rows($val) > 0) {

    $row = mysqli_fetch_assoc($val);

    $hashed_password = $row['password'];
    echo(var_dump($hashed_password)); //right value
    echo'<br>';
    echo(var_dump($pass)); //right value
    //using password_verify --> even w/ string values substituted returns false
    //so I don't know if its storing properly or something else
    $passwordCheck = password_verify($pass, $hashed_password);
    echo(var_dump($passwordCheck));

    if(! $passwordCheck){
      echo'<h2>User is not authenticated</h2>';
    }else{
      echo'Passwords match';
      echo'<h2>User is authenticated</h2>';
    }
  }
}
else if ($technique == '4') {
  //Technique 4: filter_var() Function
  $email_username = $user;
  if (mysqli_connect_errno()) {
    echo("connection is not set");
  }
  else {
    $email_username = filter_var($user, FILTER_SANITIZE_EMAIL);
    if (filter_var($email_username, FILTER_VALIDATE_EMAIL)) {
      if ($result = $connection_mysql->query($sql)) {
        if (mysqli_num_rows($result) > 0) {
          echo '<h2> User is Authenticated</h2>';
        }
        else {
          echo "<h2>User not authenticated!</h2>";
        }
        $result->free_result();
      }
    }
    echo('Invalid email');
    echo "<h2>User not authenticated!</h2>";
  }
}
else if ($technique == '5') {
  //Technique 5: Regex Utilization
  $validate = "/(and|or|union|where|limit|group by|select|\'|hex|substr|\s)/i";

  if (mysqli_connect_errno()) {
    echo("connection is not set");
  }
  else {
    if ((preg_match($validate, $user)) || (preg_match($validate, $pass))) {
      echo '<h2> Incorrect Input, You used invalid characters</h2>';
    }
    else {
      if ($result = $connection_mysql->query($sql)) {
        if (mysqli_num_rows($result) > 0) {
          echo '<h2> User is Authenticated</h2>';
        }
        else {
          echo "<h2>User not authenticated!</h2>";
        }
        $result->free_result();
      }
    }
  }
}
else if ($technique == 6) {
  if ($result = $connection_mysql->query($sql)) {
    if (mysqli_num_rows($result) > 0) {
      //username ' #
      echo '<h2> User is Authenticated</h2>';
    }
    else {
      //  enter username and --> ' or '1'='1
      echo "<h2>User not authenticated!</h2>";
    }
    $result->free_result();
  }
}

mysqli_close($connection_mysql);


?>

</body>

</html>