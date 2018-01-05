<!DOCTYPE html>
<html lang="en">
<head>
  <title></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style>
      .blog-container
      {
          background-color: white;
          margin-left: 1em;
      }
      .img-blog
      {
          width: 100%;
      }
      .desc-blog
      {
          padding: 16px;
      }
    /* Set height of the grid so .sidenav can be 100% (adjust if needed) */
    .row.content {height: 1500px}
    
    /* Set gray background color and 100% height */
      .sidenav {
      background-color: #eee;
      height: 100%;
      }
      .mainnav {
          padding-top: 1em;
          background-color: #eee;
          height: 100%;
      }
      .Overview{
          font-weight: 400;
          padding-left: 1em;
      }
      .symtoms
      {
          font-size: 1.1em;
      }
      .conditions
      {
          font-weight: 700;
          color: #474747;
      }
      .askquestion
      {
          padding: 16px;
          background-color: white;
          border-color: red;
          margin-top: 2em;
      }
    /* On small screens, set height to 'auto' for sidenav and grid */
    @media screen and (max-width: 767px) {
      .sidenav {
        height: auto;
        padding: 15px;
      }
      .row.content {height: auto;} 
    }
  </style>
</head>
<body>
    <?php 
    $topic_url = $_GET['name'];
    $topic_id = $_GET['id'];
    ?>
<div class="container-fluid">
  <div class="row content">
      <?php
      $servername = "localhost";
      $username = "root";
      $password = "";
      $dbname = "docconsu_db";
      // Create connection
      $conn = mysqli_connect($servername, $username, $password, $dbname);
      // Check connection
      if (!$conn) 
      {
          die("Connection failed: " . mysqli_connect_error());
      }
      $sql = "SELECT * FROM doctor_tip1 where Category = '$topic_id' ";
      $result = mysqli_query($conn, $sql );
      ?>
      <div class="col-sm-9 mainnav">
      <h3 class="Overview">Overview</h3>
          <div class="blog-container">
              <?php
              if (mysqli_num_rows($result) > 0) 
              {
                  while($row = mysqli_fetch_assoc($result)) 
                  {  
                      if($row['status'] == 1)
                      { 
              ?>
              <?php
                          if(empty($row['imagename'])){
              ?> 
              <br>
              <?php
                          }
                          else{
              ?> 
              <img src="http://localhost/docconsult/Doctor-tip-Blog/line-control-master/doctor-tips-images/<?php echo $row['imagename'];?>" class="img-blog">
              <?php
                          }
              ?>
              <div class="desc-blog">
                  <h2 style="color:#FF3366;"><?php 
                          echo $row['Topic']; 
                          echo $topic_id;
                      ?></h2>
                  <h4 class="conditions"> Condition :
                      <?php
                  $category = $row['Category'];
                          $sql1 = "SELECT * FROM `condition` WHERE id = $category";
                          $result1 = mysqli_query($conn, $sql1);
                          while($row1 = mysqli_fetch_assoc($result1))
                          {
                              echo $row1['name'] ;
                          } 
                      ?>
                  </h4>
                  <p class="symtoms" ><?php echo $row['Texteditor'] ?></p>
              </div>
              <?php
                      }
                      else
                      {
                          echo 'Not Written';
                      }
                  }
              } 
              mysqli_close($conn); ?>
          </div>
      </div>
      <div class="col-sm-3 sidenav">
          <div class="askquestion">
              <h1>
                  Ask a FREE Question
              </h1>
          </div>
      </div>
    </div>
    </div>
    </body>
</html>