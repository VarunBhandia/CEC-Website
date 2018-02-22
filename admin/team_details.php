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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <style>
        .teamsList {
            border-collapse: collapse;
            width: 100%;
            margin-left: 0px;
            max-height: 400px;
            overflow: auto;
        }

         .teamsList td {
            text-align: left;
            padding: 15px;
            font-size: 14px;
            color: #828282;
        }

        .team-form-div-border{
            
        }
        
        .team-form-input{
                width: 80%;
    margin-top: 1.2em;
    height: 2.5em;
        }
        
        .team-form-div-tag{
            font-family: monospace;
            font-size: 2em;            
        }
        
        .teamsList tr:nth-child(odd){
            background-color: #f2f2f2;
        }
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            padding-top: 100px; /* Location of the box */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }

        /* Modal Content */
        .modal-content {
            height: 20em;
            position: relative;
            background-color: #86adf3;
            margin: auto;
            padding-left: 2em;
            padding-right: 2em;
            padding-top: .5em;
            border: 0px solid #888;
            width: 30%;
            box-shadow: 4px 16px 13px 5px rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19);
            -webkit-animation-name: animatetop;
            -webkit-animation-duration: 0.4s;
            animation-name: animatetop;
            animation-duration: .5s;        
        }

        /* Add Animation */
        @-webkit-keyframes animatetop {
            from {top:-300px; opacity:0} 
            to {top:0; opacity:1}
        }

        @keyframes animatetop {
            from {top:-300px; opacity:0}
            to {top:0; opacity:1}
        }

        /* The Close Button */
        .close {
            color: #01010e;
            float: right;
            font-size: 2.5em;
            font-weight: 1000;
            transition: .5s;        
        }

        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }

        .modal-header {
            padding: 2px 16px;
            background-color: #5cb85c;
            color: white;
        }

        .modal-body {padding: 2px 16px;}

        .modal-footer {
            padding: 2px 16px;
            background-color: #5cb85c;
            color: white;
        }
        .team-form{
            
        }
    </style>
</head>
<div class="tab-content">
    <div class="row">
		<div class="col-sm-12 col-xs-12"> 
			<div class="col-sm-12 col-xs-12">

<?php
                $sqltest = "SELECT * FROM `team`";
                $resulttest = mysqli_query($conn, $sqltest );
//                if($_POST['update'] == 'Publish')
//                {
//                    $row_id = $_POST['id'];
//                    echo $row_id;
//                    $sqlblog = "UPDATE cec-blog SET status = '1' WHERE id = '$row_id' ";
//                    $resultblog = mysqli_query($conn, $sqlblog );
//                    $rowblog = mysqli_fetch_assoc($resultblog);
//                    $result3 = mysqli_query($conn,$sql3);                                        
//                }
                
//                if(isset($_POST['search_condition']))
//                {
//                    $search_id = $_POST['search_condition'];
//                    $search = " where Category = '$search_id' ";
//                }else{$search = '';}
//                $sql = "SELECT * FROM cec-blog $search ";
//                $result = mysqli_query($conn,$sql);
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
                                          <input type="text" class="team-form-input" name="name" required>
                                      </div>
                                  </div>
                                  <div class="row">
                                      <div class="team-form-div-border col-sm-4" >
                                          <div class="team-form-div-tag" >YEAR</div>
                                      </div>
                                      <div class="col-sm-8">
                                          <input type="text" class="team-form-input" name="name" required>
                                      </div>
                                  </div>
                                  <div class="row">
                                      <div class="team-form-div-border col-sm-4" >
                                          <div class="team-form-div-tag" >IMAGE</div>
                                      </div>
                                      <div class="col-sm-8">
                                          <input type="text" class="team-form-input" name="name" required>
                                      </div>
                                  </div>
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