<html>
    <head>
        <title>CEC HOMEPAGE</title> 
<!--
        <link href="navbar.css" type="text/css" rel="stylesheet">
        <link href="blog.css" type="text/css" rel="stylesheet">
--><meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <style type="text/css">
        .blog-image-background
        {
            width:70vw;
            height:60vh;
            background-image: url("data:image/jpeg;base64,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");
            
        }
        .article
        {
         width: 50vw;   
        }
        
        .article-header
        {
                margin-top: -25vh;
                background-color: #3c4298;
                height: 25vh;
        }
        
        .article-heading
        {
                color: white;
    font-size: 2.5em;
    padding-top: 10vh;
    padding-left: 2vw;
        }
        
        .article-category
        {
            padding-left: 2vw;
    color: white;
        }
        
        .article-desc
        {
/*
            width: 50vw;
            margin-left: 25vw;
*/
        }
    </style>
    <body>
<!--
        <div class="container">
            <div class="navbar">
                <ul>
                    <li><a href="INDEX.html" >home</a></li>
                    <li><a href="#about">about</a></li>
                    <li><a href="#blog">blog</a></li>
                    <li><a href="#" name="team">team</a></li>
                    <li><a href="#" name="contact">contact</a></li>
                    <li><a href="#">more links</a></li>
                </ul>
            </div>
            
        
        </div>
-->
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
                                Article Name
                            </div>
                            <div class="article-category">
                                CATEGORY
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