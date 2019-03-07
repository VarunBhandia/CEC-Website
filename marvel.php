<?php include("admin/functions.php"); 
$marvel_id = $_GET['id'];
$sql = "SELECT * FROM `cec-marvel` WHERE id = '$marvel_id'";
$result = mysqli_query($conn, $sql ); 
$row = mysqli_fetch_assoc($result);
?>

<html>
    <head>
        <title><?php echo $caption; ?></title>
        <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon">    
        <!-- Bootstrap -->
        <link rel="stylesheet" type="text/css"  href="css/bootstrap.css">
        <!-- Stylesheet
================================================== -->
        <link rel="stylesheet" type="text/css"  href="css/style.css">
        <link rel="stylesheet" type="text/css" href="css/responsive.css">
        <link rel="stylesheet" href="css/cobox.css">
        <script type="text/javascript" src="js/modernizr.custom.js"></script>
        <script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
        <link href="css/blog.css" type="text/css" rel="stylesheet">
        <link href="css/navbar.css" type="text/css" rel="stylesheet">

        <link href="css/blog_latest.css" type="text/css" rel="stylesheet">
    </head>
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
                        <!-- <li><a href="alumini-main-page.php" style="padding-left: 3em;padding-right: 2em;" >ALUMINI</a></li> -->
                        <li><a href="contact-us.php" style="padding-left: 3em;padding-right: 2em;" >CONTACT</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container">
            <div class="row">
<!--                <div class="col-md-2"></div>-->
                <div class="col-md-12">
                    <h2><?php echo $row['caption']; ?></h2>
                    <img class="marvel-img" src="https://images3.alphacoders.com/823/82317.jpg" style="width: 100%;">
                    <div class="article-desc">

                        <!--                            <?php echo $desc; ?>-->

                    </div>
                    <div class="greybox">

                    </div>                        
                    <!--
<div class="next-prev">
<div class="row">
<div class="col-md-6">
<a href="">
<p class="prevpost">PREVIOUS POST</p>
</a>
</div>
<div class="col-md-6"><a href="">
<p class="nxtpost">NEXT POST</p></a>
</div>
</div>
</div>
-->
                </div>
<!--                <div class="col-md-2"></div>-->
            </div>
        </div>
        <?php include("footer.php"); ?>

    </body>
</html>