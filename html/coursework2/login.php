<?php
session_start();
?>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
  </head>
<body> 
    <main class="container">
    <h1>Login</h1>
    <form  method="post">
        <label for="username">Username:</label>
        <input type="text" name="username" /><br/>
        <label for="password">Password:</label>
        <input type="password" name="password" /><br/><br/>
        <input type="submit" name="submit" value="submit"/>
    </form>
  <?php  
  require('./config/db.inc.php');

  
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    #if user is administrator, enter special index
    if (isset($_POST['username']) && isset($_POST['password'])) {
    $_SESSION['username']=$_POST['username'];
    $_SESSION['password']=$_POST['password'];
    if($_SESSION['username']=='daniels' and $_SESSION['password']=='copper99'){
      echo '<script type="text/javascript">location.href = "./index_admin.php";</script>';
      // exit();
    }else{
      #if user is police officer, enter normal index
        $sql="SELECT * FROM officer WHERE Username='{$_SESSION['username']}' AND Password='{$_SESSION['password']}'";
        $result=mysqli_query($conn,$sql);
        $num=mysqli_num_rows($result);
        if ($num>0){
          echo "successful";
          echo '<script type="text/javascript">location.href = "./index.php";</script>';
        }else{
          echo "Invalid username or password";
          }
      }

      #record audit trail
      $type="Log in";
      $username=$_SESSION['username'];
      $tablename="None";
      $add_audit="INSERT INTO Trail(Username,Type,Audit_time,Table_name) VALUES ('$username','$type',NOW(),'$tablename')";
      $add_audit_result=mysqli_query($conn,$add_audit);
  }
}
  ?>
</main>
</body>
</html>

