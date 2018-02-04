
<?php 
ini_set("display_errors",'off');
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "cec";
    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    // Check connection
    if (!$conn) 
      {
          die("Connection failed: " . mysqli_connect_error());
      }
?>