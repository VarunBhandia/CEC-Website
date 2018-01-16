<?php include("admin/functions.php"); 
    $topic = $_GET['topic'];
    $blog_id = $_GET['id'];
    $category = $_GET['category'];
    $categoryid = $_GET['catid'];
    $sql = "SELECT * FROM `cec-blog` WHERE id = '$blog_id'";
    $result = mysqli_query($conn, $sql ); 
    $row = mysqli_fetch_assoc($result);
    $desc = $row['Texteditor'];
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
                    <div class="">
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
                                <?php echo $desc; ?>
                            </p>
                        </div>
                        <div class="greybox">
                            
                        </div>                        
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
                    </div>
                </div>
                <div class="col-md-2"></div>
            </div>
            <div class="row">
                <div class="related-posts">
                    <?php
                    $all_related = get_related_posts($categoryid,$conn);
                    $cnt_related_posts = count($all_related);
                    for($i = 0; $i < $cnt_related_posts; $i++)
                    {
                        $sql44 = "SELECT * FROM `cec-blog` WHERE id = '$all_related[$i]'";
                        $result44 = mysqli_query($conn, $sql44 ); 
                        $row44 = mysqli_fetch_assoc($result44);
                        print "<div class='col-md-4'>
                        <div class='thumbnail-posts'>
                        <a href='http://localhost/cec-Website/blog.php?id=".$all_related[$i]."&category=".$category."&topic=".$row44['Topic']."&catid=".$categoryid."' target='_blank'>
                        <div class='thumbnail-posts-img'>
                        <img src='#' style='width:100%'>
                        </div>
                        <div class='thumbnail-posts-content'>
                        <h5>".$row44['Topic']."</h5>
                        </div>
                        </a>
                        </div>
                        </div>";                        
                    }?>

                </div>
            </div>
        </div>
            
    </body>
</html>