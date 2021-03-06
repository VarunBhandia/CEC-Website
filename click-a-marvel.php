<!DOCTYPE html>
<?php
include("admin/functions.php");
?>
<html>
    <head>
        <title>Click a Marvel</title>
        <meta charset="utf-8">
        <meta name="google-site-verification" content="PcGjUA_gqUBIOTdXZ2LF2p1tUmzcvVtC2rCb7Mu-V1U" />
        <!--[if IE]><meta http-equiv="x-ua-compatible" content="IE=9" /><![endif]-->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Civil Engineering Consortium is the interaction community of the civil engineers on the web, a portal to notify the latest technical advancements of today.">
        <meta name="keywords" content="civil, consortium, engineering, study, group, engineers, technical, iit ,iit roorkee ,roorkee ,uttrakhand ,Varun Bhandia ,ceciitr.co.nf ,ceciitr.com ">
        <meta name="author" content="Varun Bhandia">
        <!-- Favicons
================================================== -->
        <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon">

        <!-- Bootstrap -->
        <link rel="stylesheet" type="text/css"  href="css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="fonts/font-awesome/css/font-awesome.css">
        <!-- Stylesheet
================================================== -->
        <link rel="stylesheet" type="text/css"  href="css/style.css">
        <link rel="stylesheet" type="text/css" href="css/responsive.css">
        <link href="css/recent-posts.css" type="text/css" rel="stylesheet">
        <link href='http://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,100italic,300italic,400italic,700italic,900italic' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,700,300,600,800,400' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="css/cobox.css">
        <script type="text/javascript" src="js/modernizr.custom.js"></script>
        <script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
        <link href="css/blog.css" type="text/css" rel="stylesheet">
        <link href="css/navbar.css" type="text/css" rel="stylesheet">
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.html"></script>
        <script type="text/javascript" src="js/jquery.1.11.1.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script type="text/javascript" src="js/bootstrap.js"></script>
        <script type="text/javascript" src="js/SmoothScroll.js"></script>
        <script type="text/javascript" src="js/jquery.isotope.js"></script>

        <script src="js/owl.carousel.js"></script>

        <!-- Javascripts
================================================== -->
        <script type="text/javascript" src="js/main.js"></script>


        <script src="js/cobox.js"></script>

    </head>

    <style>
        input[type=text],input[type=number] {
            padding:5px;
            height:25px;
            width:400px;
            margin-right:10px;
            border:solid 1px;
            border-radius:5px;
            float:right;     
        }
        input[type=submit] {
            height:35px;
            width:90px;
            background-color:#3c4298;
            padding:5px;
            border:none;
            border-radius:5px;
            color:white
        }

    </style>


    <body>
        <nav class="navbar">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>                        
                    </button>
                    <a class="navbar-brand" style="margin-top: -.5em; padding-left: 5vw;" href="#"><img src="img/cec-logo-c.png" class="new-logo"  />  </a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="index.php" style="padding-left: 3em;padding-right: 2em;">HOME</a></li>
                        <li><a href="events.php" style="padding-left: 3em;padding-right: 2em;">ACTIVITIES</a></li>
                        <li><a href="team.php" style="padding-left: 3em;padding-right: 2em;">TEAM</a></li>
                        <!--<li><a href="alumini-main-page.php" style="padding-left: 3em;padding-right: 2em;" >ALUMINI</a></li>-->
                        <li><a href="contact-us.php" style="padding-left: 3em;padding-right: 2em;" >CONTACT</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container">
            <h3 class="all-heading">CLICK A MARVEL</h3>
            <div class="row">

                <div class="col-md-5"></div>
                <div class="col-md-2">
                    <div class="upload" data-toggle="modal" data-target="#myModal">
                        <img src="img/upload-cloud.png" style="width: 100%;">
                    </div>

                </div>
                <div class="col-md-5"></div>
                <div id="myModal" class="modal fade" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <form enctype='multipart/form-data'  style="width:100%" method="POST" >

                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Upload Image</h4>
                                </div>
                                <div class="modal-body">

                                    <p>
                                        <label>Name</label>
                                        <input type="text" name="name">
                                    </p>
                                    <p>
                                        <label>Enrollment No.</label>
                                        <input type="number" name="enrollment_no">
                                    </p>
                                    <p>
                                        <label>Contact No.</label>
                                        <input type="text" name="contact">
                                    </p>
                                    <p>
                                        <label>Email Id</label>
                                        <input type="text" name="email">
                                    </p>
                                    <p>
                                        <label>Caption</label>
                                        <input type="text" name="caption">
                                    </p>
                                    <p>
                                        <label>Abstract</label>
                                        <input type="text" name="abstract">
                                    </p>
                                    <p>
                                        <input type='file' name= 'img' id='image' >
                                    </p>
                                    <p>
                                    </p>
                                </div>
                                <div class="modal-footer">
                                    <input type=submit name="submit" value="Save">

                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>


                <!--                <div class="col-md-4"></div>-->
            </div>

            <div class="row">

                <?php


                if(isset($_POST['submit'])){

                    $file = $_FILES['file'];
                    $fileName = $_FILES['file']['name'];
                    $fileTmpName = $_FILES['file']['tmp_name'];
                    $fileSize = $_FILES['file']['size'];
                    $fileType = $_FILES['file']['type'];
                    $fileError = $_FILES['file']['error'];

                    $name=$_POST['name'];
                    $image=$_POST['image'];
                    $enrollment_no=$_POST['enrollment_no'];
                    $caption=$_POST['caption'];
                    $contact=$_POST['contact'];
                    $email=$_POST['email'];
                    $abstract=$_POST['abstract'];

                    $fileExt=explode('.',$fileName);
                    $fileActualExt=strtolower(end($fileExt));
                    $allowed = array('jpg','jpeg','png');
                    $fileNameNew = uniqid('',true).".".$fileActualExt;
                    $fileDestination = "img/create_a_marvel/".$fileNameNew;
                    if(move_uploaded_file($fileTmpName,$fileDestination))
                    {}
                    else{
                    }

                    $result = "INSERT INTO `cec-marvel`(`caption`, `name`, `img`, `enrollment_no`, `abstract`, `contact`, `email`) VALUES ('".$name."','".$fileNameNew."',".$enrollment_no.",'".$caption."','".$contact."','".$email."','".$abstract."');";
                    //                    print_r($result); 
                    $result1=mysqli_query($conn,$result);

                    if($result1)
                    {
                        //  echo "successfully uploaded";
                    }
                    else{
                        // echo "upload failed";
                    }}







                $all_marvel_id = get_marvel_id($conn);
                $cnt_marvels = count($all_marvel_id);
                for($i = 0; $i < $cnt_marvels; $i++)
                {
                    $sql_marvel = "SELECT * FROM `cec-marvel` WHERE id = '$all_marvel_id[$i]'";
                    $result_marvel = mysqli_query($conn, $sql_marvel ); 
                    $row_marvel = mysqli_fetch_assoc($result_marvel);
                    $marvel_id = $row_marvel['id'];
                    print "<div class='col-md-4'>
            <div class='thumbnail-posts'>
            <a href='http://cec.iitr.ac.in/marvel.php?id=".$all_marvel_id[$i]."&caption=".$row_marvel['caption']."' target='_blank'>
                <div class='thumbnail-posts-img'>
                    <img src='".$row_marvel['img_compressed']."' style='width:100%'>
                </div>
                <div class='thumbnail-posts-content'>
                    <h5>".$row_marvel['caption']."</h5>
                </div>
            </a>
        </div>
    </div>";                        
                } ?>
            </div>
        </div>

        <?php include("footer.php"); ?>
    </body>
</html>
