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
    <title>Add report</title>
    <link rel="stylesheet" href="addreport.css">
  </head>
<body>
  <form method="post">
    <input type="hidden" name="back" value="true">
    <button type="submit">Return</button>
  </form> 
<main>
  <h1>Add report</h1>
  <form action="addreport.php" method="post" class="second-form">
    Date of incident:<input type="date" name="incident_date" required/><br/>
    Incident report:<input type="text" name="incident_report" /><br/>
    Vehicle type:<input type="text" name="vehicle_type" /><br/>
    Vehicle colour:<input type="text" name="vehicle_colour" /><br/>
    Vehicle licence:<input type="text" name="vehicle_licence" /><br/>
    Person's name:<input type="text" name="person_name" /><br/>
    Person's address:<input type="text" name="person_address" /><br/>
    Person's licence number:<input type="text" name="person_licence" /><br/>
    <label for="offence">Offence description:</label>
    <select name="offence" required>

    <?php
    #set options of descriptions from table Offence
    require('./config/db.inc.php');
    $offence_query="SELECT Offence_ID, Offence_description FROM Offence";
    $result1=mysqli_query($conn,$offence_query);
    $offence_id="";
    while($row = mysqli_fetch_assoc($result1)){
      $description=$row['Offence_description'];
      $offence_id=$row['Offence_ID'];
      echo "<option value='$offence_id'>$description</option>";
    }
    ?>
    </select><br/>
    <input type="submit" name="submit" value="submit">
  </form>
  <?php  
  require('./config/db.inc.php');
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $incident_date=$_POST['incident_date'];
    $incident_report=$_POST['incident_report'];
    $vehicle_type=$_POST['vehicle_type'];
    $vehicle_colour=$_POST['vehicle_colour'];
    $vehicle_licence=$_POST['vehicle_licence'];
    $person_name=$_POST['person_name'];
    $person_address=$_POST['person_address'];
    $person_licence=$_POST['person_licence'];
    $offence_id=$_POST['offence'];
    
    #Check if the input value is empty
    if (empty($incident_date) || empty($incident_report) || empty($vehicle_type) || empty($vehicle_colour) || empty($vehicle_licence) || empty($person_name) || empty($person_address) || empty($person_licence) || empty($offence_id)) {
      echo "Please fill in all fields!";
      exit;
    }
    
    #check if the person exists
    $sql = "SELECT * FROM People WHERE People_licence='$person_licence'";
    $result=mysqli_query($conn,$sql);
    $num=mysqli_num_rows($result);
    
    #if the person exists, get People_ID
    if($num>0){
       $row = $result->fetch_assoc();
       $person_id = $row['People_ID'];
    }else{
       #if the person doesn't exist, insert person into table 'People'
       $add_person_query="INSERT INTO People(People_name,People_address,People_licence) VALUES ('$person_name','$person_address','$person_licence')";
       $add_person_result=mysqli_query($conn,$add_person_query);
       $person_id=mysqli_insert_id($conn);#get People_ID
    }

    #record audit trail
    $type="Add people";
    $username=$_SESSION['username'];
    $tablename="People";
    $add_audit="INSERT INTO Trail(Username,Type,Audit_time,Table_name) VALUES ('$username','$type',NOW(),'$tablename')";
    $add_audit_result=mysqli_query($conn,$add_audit); 

    #check if the vehicle exists
    $check_vehicle_query="SELECT * FROM Vehicle WHERE Vehicle_licence='$vehicle_licence'";
    $check_vehicle_result=mysqli_query($conn,$check_vehicle_query);
    $num1=mysqli_num_rows($check_vehicle_result);
    
    #if the vehicle exists, get Vehicle_ID
    if($num1>0){
       $row = $check_vehicle_result->fetch_assoc();
       $vehicle_id = $row['Vehicle_ID'];
    }else{
       #if the vehicle doesn't exist, insert vehicle into table 'Vehicle'
       $add_vehicle_query="INSERT INTO Vehicle(Vehicle_type,Vehicle_colour,Vehicle_licence) VALUES ('$vehicle_type','$vehicle_colour','$vehicle_licence')";
       $add_vehicle_result=mysqli_query($conn,$add_vehicle_query);
       $vehicle_id=mysqli_insert_id($conn);#get Vehicle_ID
    }

    #record audit trail
    $type="Add vehicle";
    $username=$_SESSION['username'];
    $tablename="Vehicle";
    $add_audit="INSERT INTO Trail(Username,Type,Audit_time,Table_name) VALUES ('$username','$type',NOW(),'$tablename')";
    $add_audit_result=mysqli_query($conn,$add_audit); 

    #insert information into table 'Incident'
    $add_incident_query="INSERT INTO Incident(Vehicle_ID,People_ID,Incident_Date,Incident_Report,Offence_ID) VALUES ('$vehicle_id','$person_id','$incident_date','$incident_report','$offence_id')";
    $add_incident_result=mysqli_query($conn,$add_incident_query);

    if($add_incident_result){
      echo "New incident added successfully";
    }else{
      echo "Cannot add new incident";
    }

    #record audit trail
    $type="Add report";
    $username=$_SESSION['username'];
    $tablename="Incident";
    $add_audit="INSERT INTO Trail(Username,Type,Audit_time,Table_name) VALUES ('$username','$type',NOW(),'$tablename')";
    $add_audit_result=mysqli_query($conn,$add_audit); 

    }
  ?>

</main>
</body>
</html>