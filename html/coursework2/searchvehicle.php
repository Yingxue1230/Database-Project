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
    <title>Search vehicle</title>
    <link rel="stylesheet" href="searchvehicle.css">
  </head>
<body>
  <form method="post">
    <input type="hidden" name="back" value="true">
    <button type="submit">Return</button>
  </form>
<main>
  <h1>Search vehicle</h1>
  <form action="searchvehicle.php" method="post" class="second-form">
    Enter vehicle licence:<input type="text" name="vehicle_licence" /><br/>
    <input type="submit" name="submit" value="submit">
  </form>
  <?php  
  require('./config/db.inc.php');
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vehicle_licence=$_POST['vehicle_licence'];
    #search information of vehicle using table Vehicle, Ownership and People
    $sql="SELECT Vehicle.Vehicle_licence,Vehicle.Vehicle_type,Vehicle.Vehicle_colour,People.People_name,People.People_licence
    FROM Vehicle
    LEFT JOIN Ownership ON Vehicle.Vehicle_ID=Ownership.Vehicle_ID
    LEFT JOIN People ON Ownership.People_ID=People.People_ID
    WHERE Vehicle.Vehicle_licence='$vehicle_licence'";
    $result=mysqli_query($conn,$sql);
    $num=mysqli_num_rows($result);
    if($num<1){#can't find the vehicle
        echo "cannot find the vehicle";
        exit;
    }else{
      #print the results  
      echo '<H2>Search Results:</h2>';
      echo mysqli_num_rows($result)." result(s)<br/><br/>";
      echo "<table class='result-table'>";
      echo "<tr><th>Vehicle licence</th><th>Vehicle type</th><th>Vehicle colour</th><th>Owner's name</th><th>Owner's licence</th></tr>";
      while($row = mysqli_fetch_assoc($result)){
        echo "<tr>";
        echo "<td>".$row['Vehicle_licence']."</td>";
        echo "<td>".$row['Vehicle_type']."</td>";
        echo "<td>".$row['Vehicle_colour']."</td>";
        echo "<td>".($row['People_name']?$row['People_name']:"unknown")."</td>";
        echo "<td>".($row['People_licence']?$row['People_licence']:"unknown")."</td>";
        echo "</tr>";
      }
      echo "</table>";
    }
  }
  ?>
</main>
</body>
</html>