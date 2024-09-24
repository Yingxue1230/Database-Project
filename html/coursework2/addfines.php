<?php
session_start();

?>
<html>
<head>
    <title>Add fines</title>
    <link rel="stylesheet" href="addfines.css">
  </head>
<body>
  <button onclick="window.location.href='index_admin.php'">Return</button>
<main>
  <h1>Add fines</h1>
  <form action="addfines.php" method="post" class="second-form">
  <label for="incident">Incident ID:</label>
  <select name="incident" required>
  <?php
    require('./config/db.inc.php');
    $incident_query="SELECT Incident_ID FROM Incident WHERE NOT EXISTS (SELECT * FROM Fines WHERE Incident.Incident_ID = Fines.Incident_ID)";
    $result1=mysqli_query($conn,$incident_query);
    $incident_id="";
    while($row = mysqli_fetch_assoc($result1)){
      $incident_id=$row['Incident_ID'];
      echo "<option value='$incident_id'>$incident_id</option>";
    }
    ?>
    </select><br/>
    Fine amount:<input type="text" name="fine_amount" required/><br/>
    <label for="point">Fine points:</label>
    <select name="point" id="point" multiple required>
      <option value="0">0</option>
      <option value="1">1</option>
      <option value="2">2</option>
      <option value="3">3</option>
      <option value="4">4</option>
      <option value="5">5</option>
      <option value="6">6</option>
      <option value="7">7</option>
      <option value="8">8</option>
      <option value="9">9</option>
      <option value="10">10</option>
      <option value="11">11</option>
      <option value="12">12</option>
    </select>
    <input type="submit" name="submit" value="submit">
  </form>
  <?php  
  require('./config/db.inc.php');
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $incident_id=$_POST['incident'];
    $fine_amount=$_POST['fine_amount'];
    $fine_point=$_POST['point'];

    #check if the input value is empty
    if (empty($incident_id) || $fine_amount === ""  || $fine_point === "") {
      echo "Please fill in all fields!";
      exit;
    }

    #insert incident_id,fine_amount and fine_point into table fines
    $add_fines_query="INSERT INTO Fines(Fine_Amount,Fine_Points,Incident_ID) VALUES ('$fine_amount','$fine_point','$incident_id')";
    $add_fines_result=mysqli_query($conn,$add_fines_query);

    #check if added successfully
    if($add_fines_result){
      echo "Fines added successfully";
    }else{
      echo "Cannot add fines";
    }

    #record audit trail
    $type="Add fines";
    $username=$_SESSION['username'];
    $tablename="Fines";
    $add_audit="INSERT INTO Trail(Username,Type,Audit_time,Table_name) VALUES ('$username','$type',NOW(),'$tablename')";
    $add_audit_result=mysqli_query($conn,$add_audit); 
  }
  ?>

  <?php  
  require('./config/db.inc.php');
    #search the information of incidence connected with table "People" and "Vehicle" and "Fines"
    $sql="SELECT Incident.Incident_ID,People_name,People_licence,Vehicle_licence,Incident_Date,Incident_Report,Fine_Amount,Fine_Points
    FROM Incident
    LEFT JOIN People ON Incident.People_ID=People.People_ID
    LEFT JOIN Vehicle ON Incident.Vehicle_ID=Vehicle.Vehicle_ID
    LEFT JOIN Fines ON Incident.Incident_ID=Fines.Incident_ID";
    $result=mysqli_query($conn,$sql);
    $num=mysqli_num_rows($result);
    if($num>0){
        echo '<H2>Search Results:</h2>';
        echo "<table>";
        echo "<tr><th>Incident ID</th><th>Name</th><th>Licence number</th><th>Vehicle licence</th><th>Date of incident</th><th>Incident report</th><th>Fines</th><th>Fine points</th></tr>";
        #print the results
        while($row = mysqli_fetch_assoc($result)){
            echo "<tr>";
            echo "<td>".$row['Incident_ID']."</td>";
            echo "<td>".$row['People_name']."</td>";
            echo "<td>".$row['People_licence']."</td>";
            echo "<td>".$row['Vehicle_licence']."</td>";
            echo "<td>".$row['Incident_Date']."</td>";
            echo "<td>".$row['Incident_Report']."</td>";
            echo "<td>".$row['Fine_Amount']."</td>";
            echo "<td>".$row['Fine_Points']."</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
  ?>
</main>
</body>
</html>