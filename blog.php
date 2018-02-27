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
                      <li><a href="recent-posts.php" style="padding-left: 3em;padding-right: 2em;">BLOG</a></li>
                      <li><a href="events.php" style="padding-left: 3em;padding-right: 2em;">ACTIVITIES</a></li>
                      <li><a href="team.php" style="padding-left: 3em;padding-right: 2em;">TEAM</a></li>
                      <li><a href="alumini-main-page.php" style="padding-left: 3em;padding-right: 2em;" >ALUMINI</a></li>
                      <li><a href="contact-us.php" style="padding-left: 3em;padding-right: 2em;" >CONTACT</a></li>
                      <li class="dropdown morelinks">
                      <a class="dropdown-toggle" data-toggle="dropdown" href="#">MORE LINKS <span class="caret"></span></a>
                      <ul class="dropdown-menu">
                          <li><a href="#">Page 1-3</a></li>
                      </ul>
                    </li>
                  </ul>
                </div>
              </div>
        </nav>

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