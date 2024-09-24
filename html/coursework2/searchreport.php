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
    <title>Search report</title>
    <link rel="stylesheet" href="searchreport.css">
  </head>
<body>
  <form method="post">
    <input type="hidden" name="back" value="true">
    <button type="submit">Return</button>
  </form>
<main>
  <h1>Search report</h1>
  <form action="searchreport.php" method="post" class="second-form">
    Name:<input type="text" name="name" /><br/>
    Licence number:<input type="text" name="licence_number" /><br/>
    Vehicle licence:<input type="text" name="vehicle_licence" /><br/>
    Date of incident:<input type="date" name="incident_date" /><br/>
    <input type="submit" name="submit" value="submit">
  </form>
  <a href="editreport.php">
     <button class="edit-btn">Edit</button>
  </a>
  <?php  
  require('./config/db.inc.php');
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name=$_POST['name'];
    $licence_number=$_POST['licence_number'];
    $vehicle_licence=$_POST['vehicle_licence'];
    $incident_date=$_POST['incident_date'];
    
    #you can enter any condition to search report
    $conditions = [];
    $params = [];

    if(!empty($name)){
        $conditions[]="LOWER(People.People_name) LIKE LOWER('%$name%')";
        $params[]="%$name%";
    }

    if(!empty($licence_number)){
        $conditions[]="LOWER(People.People_licence) LIKE LOWER('%$licence_number%')";
        $params[]="%$licence_number%";
    }

    if(!empty($vehicle_licence)){
        $conditions[]="LOWER(Vehicle.Vehicle_licence) LIKE LOWER('%$vehicle_licence%')";
        $params[]="%$vehicle_licence%";
    }

    if(!empty($incident_date)){
        $conditions[]="Incident.Incident_Date = '$incident_date'";
        $params[]=$incident_date;
    }

    #search people by name or licence number or vehicle licence or incident date
    $sql="SELECT Incident_ID,People_name,People_licence,Vehicle_licence,Incident_Date,Incident_Report FROM People,Vehicle,Incident WHERE People.People_ID=Incident.People_ID AND Vehicle.Vehicle_ID=Incident.Vehicle_ID AND (" . implode(" OR ", $conditions) . ")";
    $result=mysqli_query($conn,$sql);
    $num=mysqli_num_rows($result);
    if($num<1){
        echo "cannot find the report";
        exit;
    }else{
        echo '<H2>Search Results:</h2>';
        #print the amount of results
        echo mysqli_num_rows($result)." result(s)<br/><br/>";
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

  }
  ?>
</main>
</body>
</html>




