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
    <title>Add vehicle</title>
    <link rel="stylesheet" href="addvehicle.css">
  </head>
<body>
  <form method="post">
    <input type="hidden" name="back" value="true">
    <button type="submit">Return</button>
  </form>
<main>
  <h1>Add vehicle</h1>
  <form action="addvehicle.php" method="post" class="second-form">
    Vehicle licence:<input type="text" name="vehicle_licence" /><br/>
    Vehicle make and model:<input type="text" name="vehicle_type" /><br/>
    Vehicle colour:<input type="text" name="vehicle_colour" /><br/>
    Owner's name:<input type="text" name="owner_name" /><br/>
    Owner's address:<input type="text" name="owner_address" /><br/>
    Owner's licence number:<input type="text" name="owner_licence" /><br/>
    <input type="submit" name="submit" value="submit">
  </form>
  <?php  
  require('./config/db.inc.php');
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vehicle_licence=$_POST['vehicle_licence'];
    $vehicle_type=$_POST['vehicle_type'];
    $vehicle_colour=$_POST['vehicle_colour'];
    $owner_name=$_POST['owner_name'];
    $owner_address=$_POST['owner_address'];
    $owner_licence=$_POST['owner_licence'];
    
    #Check if the input value is empty
    if (empty($vehicle_licence) || empty($vehicle_type) || empty($vehicle_colour) || empty($owner_name) || empty($owner_address) || empty($owner_licence)) {
      echo "Please fill in all fields!";
      exit;
    }
  
    #check if the owner exists
    $sql = "SELECT People_ID FROM People WHERE People_licence='$owner_licence'";
    $result=mysqli_query($conn,$sql);
    $num=mysqli_num_rows($result);
    
    if($num>0){
       $row = $result->fetch_assoc();
       $owner_id = $row['People_ID'];#if exists, get People_ID
    }else{
      #insert new owner if not exists 
       $add_owner_query ="INSERT INTO People(People_name,People_address,People_licence) VALUES ('$owner_name','$owner_address','$owner_licence')";
       $add_owner_result=mysqli_query($conn,$add_owner_query);
       $owner_id=mysqli_insert_id($conn);
    }

    #record audit trail
    $type="Add people";
    $username=$_SESSION['username'];
    $tablename="People";
    $add_audit="INSERT INTO Trail(Username,Type,Audit_time,Table_name) VALUES ('$username','$type',NOW(),'$tablename')";
    $add_audit_result=mysqli_query($conn,$add_audit); 

    #insert vehicle with provided details
    $add_vehicle_query="INSERT INTO Vehicle(Vehicle_licence,Vehicle_type,Vehicle_colour) VALUES ('$vehicle_licence','$vehicle_type','$vehicle_colour')";
    $add_vehicle_result=mysqli_query($conn,$add_vehicle_query);
    if ($add_vehicle_result) {
      $vehicle_id=mysqli_insert_id($conn);

      #insert ownership record
      $add_ownership_query="INSERT INTO Ownership(People_ID,Vehicle_ID) VALUES ('$owner_id','$vehicle_id')";
      $add_ownership_result=mysqli_query($conn,$add_ownership_query);

      if($add_ownership_result){
        echo "New vehicle added successfully";
      }else{
        echo "Cannot add new vehicle";
      }
    }

    #record audit trail
    $type="Add vehicle";
    $username=$_SESSION['username'];
    $tablename="Vehicle";
    $add_audit="INSERT INTO Trail(Username,Type,Audit_time,Table_name) VALUES ('$username','$type',NOW(),'$tablename')";
    $add_audit_result=mysqli_query($conn,$add_audit); 


    }
  ?>
</main>
</body>
</html>