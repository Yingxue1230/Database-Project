<?php
session_start();

?>
<html>
<head>
    <title>Add officer</title>
    <link rel="stylesheet" href="addofficer.css">
  </head>
<body>
  <button onclick="window.location.href='index_admin.php'">Return</button>
<main>
  <h1>Add officer</h1>
  <form action="addofficer.php" method="post">
    Username:<input type="text" name="username" /><br/>
    Password:<input type="password" name="password" /><br/>
    Confirm password:<input type="password" name="confirm_password" /><br/>
    <input type="submit" name="submit" value="submit">
  </form>
  <?php  
  require('./config/db.inc.php');
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $username=$_POST['username'];
      $password=$_POST['password'];
      $confirm_password=$_POST['confirm_password'];

      #Check if the input value is empty
      if (empty($username) || empty($password) || empty($confirm_password)) {
        echo "Please fill in all fields!";
        exit;
      }
    
      #check if password entered match
      if ($password!==$confirm_password){
        echo "The password entered does not match";
        exit;
      }else{
        $sql="INSERT INTO officer(Username,Password) VALUES ('$username','$password')";
        $result=mysqli_query($conn,$sql);
        if ($result){
            echo "New officer added successfully";
        }else{
            echo "Cannot add new officer";
        }
      }

      #record audit trail
      $type="Add officer";
      $username=$_SESSION['username'];
      $tablename="officer";
      $add_audit="INSERT INTO Trail(Username,Type,Audit_time,Table_name) VALUES ('$username','$type',NOW(),'$tablename')";
      $add_audit_result=mysqli_query($conn,$add_audit); 
    
    }  
  ?>
</main>
</body>
</html>