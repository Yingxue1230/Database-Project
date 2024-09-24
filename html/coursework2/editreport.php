<?php
session_start();
?>

<html>
<head>
    <title>Edit report</title>
    <link rel="stylesheet" href="editreport.css">
  </head>
<body>
  <button onclick="window.location.href='searchreport.php'">Return</button>
<main>
  <h1>Edit report</h1>
  <form action="editreport.php" method="post" class="second-form">
    <label for="incident">Incident ID:</label>
    <select name="incident" required>
    <?php
        require('./config/db.inc.php');
        $incident_query="SELECT Incident_ID FROM Incident ORDER BY Incident_ID";
        $result1=mysqli_query($conn,$incident_query);
        $incident_id="";
        while($row = mysqli_fetch_assoc($result1)){
        $incident_id=$row['Incident_ID'];
        echo "<option value='$incident_id'>$incident_id</option>";
        }
    ?>
    </select><br/>
    Incident report:<input type="text" name="incident_report" required/><br/>
    <input type="submit" name="submit" value="submit">
  </form>

  <?php  
  require('./config/db.inc.php');
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $incident_id=$_POST['incident'];
    $incident_report=$_POST['incident_report'];

    #check if the input value is empty
    if (empty($incident_report)) {
      echo "Please fill in all fields!";
      exit;
    }

    #update incident report in table 'Incident'
    $update_report_query="UPDATE Incident SET Incident_Report='$incident_report' WHERE Incident_ID='$incident_id'";
    $update_report_result=mysqli_query($conn,$update_report_query);

    #check if editted successfully
    if($update_report_result){
      echo "Edit report successfully";
    }else{
      echo "Cannot edit report";
    }

    #record audit trail
    $type="Edit report";
    $username=$_SESSION['username'];
    $tablename="Incident";
    $add_audit="INSERT INTO Trail(Username,Type,Audit_time,Table_name) VALUES ('$username','$type',NOW(),'$tablename')";
    $add_audit_result=mysqli_query($conn,$add_audit); 
  }
  ?>

  <?php  
  require('./config/db.inc.php');
    #search the information of incident connected with table "People" and "Vehicle" and "Incident"
    $sql="SELECT Incident_ID,People_name,People_licence,Vehicle_licence,Incident_Date,Incident_Report FROM People,Vehicle,Incident WHERE People.People_ID=Incident.People_ID AND Vehicle.Vehicle_ID=Incident.Vehicle_ID";
    $result=mysqli_query($conn,$sql);
    $num=mysqli_num_rows($result);
    if($num<1){
        echo "cannot find the report";
        exit;
    }else{
        echo "<table class='result-table'>";
        echo "<table>";
        echo "<tr><th>Incident ID</th><th>Name</th><th>Licence number</th><th>Vehicle licence</th><th>Date of incident</th><th>Incident report</th></tr>";
        #print the results
        while($row = mysqli_fetch_assoc($result)){
            echo "<tr>";
            echo "<td>".$row['Incident_ID']."</td>";
            echo "<td>".$row['People_name']."</td>";
            echo "<td>".$row['People_licence']."</td>";
            echo "<td>".$row['Vehicle_licence']."</td>";
            echo "<td>".$row['Incident_Date']."</td>";
            echo "<td>".$row['Incident_Report']."</td>";
            echo "</tr>";
          }
        echo "</table>";
    }
  ?>
</main>
</body>
</html>
