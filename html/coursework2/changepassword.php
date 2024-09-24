<?php
session_start();

if(isset($_POST['back'])){
  if($_SESSION['username']=='daniels'){
    echo "<script>location.href='./index_admin.php'</script>";
  } else {
    echo "<script>location.href='./index.php'</script>";
  }
}
?>
<html>
<head>
    <title>change password</title>
    <link rel="stylesheet" href="changepassword.css">
  </head>
<body>
  <form method="post">
    <input type="hidden" name="back" value="true">
    <button type="submit">Return</button>
  </form>
<main>
  <h1>Change password</h1>
  <form action="changepassword.php" method="post" class="second-form">
    Username:<input type="text" name="username" /><br/>
    Old password:<input type="password" name="oldpwd"><br>
    New password:<input type="password" name="newpwd"><br>
    Confirm new password:<input type="password" name="newpwd2"><br>
    <input type="submit" name="submit" value="submit">
  </form>
  <?php  
  require('./config/db.inc.php');
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username=$_POST['username'];
    $oldpwd=$_POST['oldpwd'];
    $newpwd=$_POST['newpwd'];
    $newpwd2=$_POST['newpwd2'];
    
    #check if new password entered match
    if ($newpwd!==$newpwd2){
      echo "The new password entered does not match";
      exit;
    }

    #check if username and password are correct
    $sql="SELECT * FROM officer WHERE Username='$username' AND Password='$oldpwd'";
    $result=mysqli_query($conn,$sql);
    $num=mysqli_num_rows($result);
    if($num!==1){#username and password don't match
      echo 'Incorrect old password';
      exit;
    }else{
      #update password using new password
      $sql="UPDATE officer SET Password='$newpwd' WHERE Username='$username'";
      if(!mysqli_query($conn,$sql)){
         echo 'Password modification failed';
         exit;
      }
      echo 'Password modification successful';
    }

    #record audit trail
    $type="Change password";
    $username=$_SESSION['username'];
    $tablename="officer";
    $add_audit="INSERT INTO Trail(Username,Type,Audit_time,Table_name) VALUES ('$username','$type',NOW(),'$tablename')";
    $add_audit_result=mysqli_query($conn,$add_audit); 

  }
  ?>
</main>
</body>
</html>