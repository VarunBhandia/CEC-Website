
<?php 
ini_set("display_errors",'off');
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "cec";

//    $servername = "localhost";
//    $username = "constru4";
//    $password = "ATul@9893399437";
//    $dbname = "constru4_clone1";

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    // Check connection
    if (!$conn) 
      {
          die("Connection failed: " . mysqli_connect_error());
      }
?>