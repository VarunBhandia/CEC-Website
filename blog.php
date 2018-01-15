<?php include("admin/functions.php"); 
    $topic = $_GET['topic'];
    $blog_id = $_GET['id'];
    $category = $_GET['category'];
    ?>

<html>
    <head>
        <title><?php echo $topic; ?></title> 
<!--
        <link href="navbar.css" type="text/css" rel="stylesheet">
        <link href="blog.css" type="text/css" rel="stylesheet">
--><meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link href="css/navbar.css" type="text/css" rel="stylesheet">
        <link href="css/recent-posts.css" type="text/css" rel="stylesheet">
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.html"></script>
    <script type="text/javascript" src="js/jquery.1.11.1.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script type="text/javascript" src="js/bootstrap.js"></script>
    <script type="text/javascript" src="js/SmoothScroll.js"></script>
    <script type="text/javascript" src="js/jquery.isotope.js"></script>
        <link href="css/blog_latest.css" type="text/css" rel="stylesheet">
    </head>
    <body>
<div class="topnav" id="myTopnav">
    <a href="index.php" style="padding-left: 3em;">HOME</a>
    <a href="" style="padding-left: 3em;">ABOUT</a>
    <a href="recent-posts.php" style="padding-left: 3em;">BLOG</a>
    <a href="events.php" style="padding-left: 3em;" >ACTIVITIES</a>
    <a href="" style="padding-left: 3em;">TEAM</a>
    <a href="alumini-main-page.php" style="padding-left: 3em;" class="active">ALUMINI</a>
    <a href="contact-us.php" style="padding-left: 3em;">CONTACT</a>
    <a href="" data-toggle="dropdown" class="dropdown-toggle" style="padding-left: 3em;">
        MORE LINKS
        <ul class="dropdown-menu" >
                    <li><a href="http://www.iitr.ac.in/departments/CE/pages/index.html" target="_blank" class="page-scroll">More on Department</a></li>
                    <li><a href="http://www.iitr.ac.in/" target="_blank" class="page-scroll">IITR Website</a></li>
                    <li><a href="http://goo.gl/forms/exZV6mgrnw" target="_blank" class="page-scroll">Alumni Form</a></li>
                    <li><a href="https://docs.google.com/forms/d/14vWlUQ2_KIhHYIW_gwf3Of353FLmPmMPw9VfHnBC5E0/viewform?embedded=true" target="_blank" class="page-scroll">Survey Form</a></li>
                </ul>
    </a>
    <a href="javascript:void(0);" style="font-size:15px;" class="icon" onclick="myFunction()">&#9776;</a>
</div>
<script>
function myFunction() {
    var x = document.getElementById("myTopnav");
    if (x.className === "topnav") {
        x.className += " responsive";
    } else {
        x.className = "topnav";
    }
}
</script>

        <div class="container">
            <center>
                <div class="row">
                    <div class="blog-image-background">
                    </div>
                </div>
            </center>
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <div class="article">
                        <div class="article-header">
                            <div class="article-heading">
                                <?php echo $topic; ?>
                            </div>
                            <div class="article-category">
                                <?php echo $category; ?>
                            </div>
                        </div>
                        <div class="article-desc">
                            <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. In risus ligula, hendrerit eget nisl sit amet, porttitor ullamcorper nunc. Sed in mauris non ipsum ornare pretium vel sit amet diam. Nam hendrerit lacinia augue in efficitur. Praesent faucibus purus lacus, nec porta ipsum ultrices at. Morbi a mauris interdum, tempor orci eget, facilisis purus. Integer vehicula lobortis ex, non tristique lectus fringilla vitae. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Sed vitae purus vitae tellus eleifend condimentum. Cras ullamcorper pulvinar metus, ut porta metus tincidunt ut. Morbi ornare arcu ante, sit amet sollicitudin libero vestibulum tempus. Praesent sit amet eros ac sem tincidunt lobortis. Vivamus in facilisis turpis, non maximus dolor. Suspendisse blandit turpis at dui imperdiet, at ornare urna blandit. Donec quis interdum odio, non suscipit nulla. Curabitur volutpat sit amet libero eu pellentesque. Donec auctor augue nec pharetra euismod.
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. In risus ligula, hendrerit eget nisl sit amet, porttitor ullamcorper nunc. Sed in mauris non ipsum ornare pretium vel sit amet diam. Nam hendrerit lacinia augue in efficitur. Praesent faucibus purus lacus, nec porta ipsum ultrices at. Morbi a mauris interdum, tempor orci eget, facilisis purus. Integer vehicula lobortis ex, non tristique lectus fringilla vitae. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Sed vitae purus vitae tellus eleifend condimentum. Cras ullamcorper pulvinar metus, ut porta metus tincidunt ut. Morbi ornare arcu ante, sit amet sollicitudin libero vestibulum tempus. Praesent sit amet eros ac sem tincidunt lobortis. Vivamus in facilisis turpis, non maximus dolor. Suspendisse blandit turpis at dui imperdiet, at ornare urna blandit. Donec quis interdum odio, non suscipit nulla. Curabitur volutpat sit amet libero eu pellentesque. Donec auctor augue nec pharetra euismod.
                            
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. In risus ligula, hendrerit eget nisl sit amet, porttitor ullamcorper nunc. Sed in mauris non ipsum ornare pretium vel sit amet diam. Nam hendrerit lacinia augue in efficitur. Praesent faucibus purus lacus, nec porta ipsum ultrices at. Morbi a mauris interdum, tempor orci eget, facilisis purus. Integer vehicula lobortis ex, non tristique lectus fringilla vitae. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Sed vitae purus vitae tellus eleifend condimentum. Cras ullamcorper pulvinar metus, ut porta metus tincidunt ut. Morbi ornare arcu ante, sit amet sollicitudin libero vestibulum tempus. Praesent sit amet eros ac sem tincidunt lobortis. Vivamus in facilisis turpis, non maximus dolor. Suspendisse blandit turpis at dui imperdiet, at ornare urna blandit. Donec quis interdum odio, non suscipit nulla. Curabitur volutpat sit amet libero eu pellentesque. Donec auctor augue nec pharetra euismod.
                            
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. In risus ligula, hendrerit eget nisl sit amet, porttitor ullamcorper nunc. Sed in mauris non ipsum ornare pretium vel sit amet diam. Nam hendrerit lacinia augue in efficitur. Praesent faucibus purus lacus, nec porta ipsum ultrices at. Morbi a mauris interdum, tempor orci eget, facilisis purus. Integer vehicula lobortis ex, non tristique lectus fringilla vitae. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Sed vitae purus vitae tellus eleifend condimentum. Cras ullamcorper pulvinar metus, ut porta metus tincidunt ut. Morbi ornare arcu ante, sit amet sollicitudin libero vestibulum tempus. Praesent sit amet eros ac sem tincidunt lobortis. Vivamus in facilisis turpis, non maximus dolor. Suspendisse blandit turpis at dui imperdiet, at ornare urna blandit. Donec quis interdum odio, non suscipit nulla. Curabitur volutpat sit amet libero eu pellentesque. Donec auctor augue nec pharetra euismod.
                            
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. In risus ligula, hendrerit eget nisl sit amet, porttitor ullamcorper nunc. Sed in mauris non ipsum ornare pretium vel sit amet diam. Nam hendrerit lacinia augue in efficitur. Praesent faucibus purus lacus, nec porta ipsum ultrices at. Morbi a mauris interdum, tempor orci eget, facilisis purus. Integer vehicula lobortis ex, non tristique lectus fringilla vitae. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Sed vitae purus vitae tellus eleifend condimentum. Cras ullamcorper pulvinar metus, ut porta metus tincidunt ut. Morbi ornare arcu ante, sit amet sollicitudin libero vestibulum tempus. Praesent sit amet eros ac sem tincidunt lobortis. Vivamus in facilisis turpis, non maximus dolor. Suspendisse blandit turpis at dui imperdiet, at ornare urna blandit. Donec quis interdum odio, non suscipit nulla. Curabitur volutpat sit amet libero eu pellentesque. Donec auctor augue nec pharetra euismod.
                            </p>
                        </div>
                        <hr>
                        <div class="next-prev">
                            <div class="row">
                                <div class="col-md-6">
                                    <P>PREVIOUS POST</P>
                                </div>
                                <div class="col-md-6">
                                    <P>NEXT POST</P>
                                </div>
                            </div>
                            </div>
                    </div>
                </div>
                <div class="col-md-2"></div>
            </div>
            <div class="row">
                <div class="blog-slider">
                </div>
            </div>
        </div>
            
    </body>
</html>