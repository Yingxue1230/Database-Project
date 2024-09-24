<html>
<head>
    <title>Trail</title>
    <link rel="stylesheet" href="trail.css">
  </head>
<body>
  <button onclick="window.location.href='index_admin.php'">Return</button>
<main>
  <h1>Trail</h1>
  <?php  
  require('./config/db.inc.php');
    #show information of audit trails
    $sql="SELECT Username,Audit_time,Type,Table_name FROM Trail";
    $result=mysqli_query($conn,$sql);
    $num=mysqli_num_rows($result);
    if($num>0){
        echo "<table>";
        echo "<tr><th>Username</th><th>Audit time</th><th>Action type</th><th>Table name</th></tr>";
        #print the results
        while($row = mysqli_fetch_assoc($result)){
            echo "<tr>";
            echo "<td>".$row['Username']."</td>";
            echo "<td>".$row['Audit_time']."</td>";
            echo "<td>".$row['Type']."</td>";
            echo "<td>".$row['Table_name']."</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
  ?>
</main>
</body>
</html>