<?php
include("serverblog.php");
?>
<head>
    <link href="css/cs.css" rel="stylesheet" type="text/css">
    <link href="css/responsive.css" rel="stylesheet" type="text/css">
    <link href="css/newcs.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="team_details.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <style>
        
    </style>
</head>
        <?php include("sidebar.php"); ?>
        <div id="main">

<div class="tab-content">
    <div class="row">
		<div class="col-sm-12 col-xs-12"> 
			<div class="col-sm-12 col-xs-12">

<?php
                $sqltest = "SELECT * FROM `team`";
                $resulttest = mysqli_query($conn, $sqltest );
                ?>
                <div class="row">
                    <div class="col-md-10">
                        <h1><strong>Team Members</strong></h1>
                    </div>
                    <div class="col-md-1" style="padding-top: 2em;">
                        <!-- Trigger/Open The Modal -->
                        <button id="myBtn" class="btn btn-info">Add New</button>
                        <!-- The Modal -->
                        <div id="myModal" class="modal">

                          <!-- Modal content -->
                          <div class="modal-content">
                              <form class="team-form row" method="POST" action="">
                                  <div class="close">&times;</div>
                                  <div class="row">
                                      <div class="team-form-div-border col-sm-4" >
                                          <div class="team-form-div-tag" >NAME</div>
                                      </div>
                                      <div class="col-sm-8">
                                          <input type="text" class="team-form-input" name="name" required>
                                      </div>
                                  </div>
                                  <div class="row">
                                      <div class="team-form-div-border col-sm-4" >
                                          <div class="team-form-div-tag" >POST</div>
                                      </div>
                                      <div class="col-sm-8">
                                          <input type="text" class="team-form-input" name="post" required>
                                      </div>
                                  </div>
                                  <div class="row">
                                      <div class="team-form-div-border col-sm-4" >
                                          <div class="team-form-div-tag" >YEAR</div>
                                      </div>
                                      <div class="col-sm-8">
                                          <input type="text" class="team-form-input" name="year" required>
                                      </div>
                                  </div>
                                  <div class="row">
                                      <div class="team-form-div-border col-sm-4" >
                                          <div class="team-form-div-tag" >IMAGE</div>
                                      </div>
                                      <div class="col-sm-8">
                                          <input type="file" class="team-form-input" name="image" required>
                                      </div>
                                  </div>
                                  <input id="team" name="team_add" type="submit" class="btn btn-primary submit_data" value="Add">

                              </form>

                          </div>

                        </div>

                        <script>
                        // Get the modal
                        var modal = document.getElementById('myModal');

                        // Get the button that opens the modal
                        var btn = document.getElementById("myBtn");

                        // Get the <span> element that closes the modal
                        var span = document.getElementsByClassName("close")[0];

                        // When the user clicks the button, open the modal 
                        btn.onclick = function() {
                            modal.style.display = "block";
                        }

                        // When the user clicks on <span> (x), close the modal
                        span.onclick = function() {
                            modal.style.display = "none";
                        }

                        // When the user clicks anywhere outside of the modal, close it
                        window.onclick = function(event) {
                            if (event.target == modal) {
                                modal.style.display = "none";
                            }
                        }
                        </script>

                    </div>
                </div>
                </div></div></div>
    <div class="row">			
        <hr>
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="row contentTable " > 
                <div class="table-responsive col-sm-12">
                    <table class="teamsList" >
                        <thead  style="font-weight: 700">
                            <tr style="color: #333333; background-color: white; cursor:pointer">    
                                <td>Name</td>
                                <td>Year</td>
                                <td>Post</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($resulttest) 
                            {
                                while($rowtest = mysqli_fetch_assoc($resulttest)){    ?>
                            <tr>
                                <td><?php echo $rowtest['name'] ?></td>
                                <td><?php echo $rowtest['year'] ?></td>
                                <td><?php echo $rowtest['post'] ?></td>
                            </tr>
                            <?php }}  ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-2"></div>
    </div>
    <hr>
</div>
<?php
            if($_POST['team_add'] == 'Add')
            {
            $name = $_POST['name'];
            $post = $_POST['post'];
            $year = $_POST['year'];
            $image = $_POST['image'];
                $sqlteam = "INSERT INTO team (name,post,year,img) VALUES ('$name','$post','$year','$image')";
                print $sqlteam;
                $resultteam = mysqli_query($conn, $sqlteam);

            }

?>
</div>