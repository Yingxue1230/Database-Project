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
    <title>Search people</title>
    <link rel="stylesheet" href="searchpeople.css">
  </head>
<body>
  <form method="post">
    <input type="hidden" name="back" value="true">
    <button type="submit">Return</button>
  </form>
<main>
  <h1>Search people</h1>
  <form action="searchpeople.php" method="post" class="second-form">
    Enter name or licence number:<input type="text" name="name_or_licence_number" /><br/>
    <input type="submit" name="submit" value="submit">
  </form>
  <?php  
  require('./config/db.inc.php');
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name_or_licence_number=$_POST['name_or_licence_number'];
   
    #search people by name or licence number
    $sql="SELECT * FROM People WHERE LOWER(People_name) LIKE LOWER('%$name_or_licence_number%') or LOWER(People_licence) LIKE LOWER('%$name_or_licence_number%')";
    $result=mysqli_query($conn,$sql);
    $num=mysqli_num_rows($result);


    if($num<1){
        echo "Cannot find the person";
        exit;
    }else{
        echo '<H2>Search Results:</h2>';
        #print the amount of results
        echo mysqli_num_rows($result)." result(s)<br/><br/>";
        echo "<table class='result-table'>";
        echo "<tr><th>Name</th><th>Address</th><th>Licence number</th></tr>";
        #print the results
        while($row = mysqli_fetch_assoc($result)){
          echo "<tr>";
          echo "<td>".$row['People_name']."</td>";
          echo "<td>".$row['People_address']."</td>";
          echo "<td>".$row['People_licence']."</td>";
          echo "</tr>";
        }
        echo "</table>";
    }
  }
  ?>
</main>
</body>
</html>