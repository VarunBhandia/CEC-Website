<html>
    <head>
        <title>CEC HOMEPAGE</title> 
        <link href="blog.css" type="text/css" rel="stylesheet">
        <link href="css/navbar.css" type="text/css" rel="stylesheet">
    </head>
    <style type="text/css">
        .paratitle{
            text-transform: uppercase;
            color:#684cc4;
            font-family:sans-serif;
            font-weight:bolder;
            
        }
        #about,#blog,#team{
            position:relative;
            margin-left:150px;
            margin-right:150px;
            display:block;
            margin-top:50px;
            font-family:sans-serif;
            font-size: 20px;
        }
        #contact{
            
            margin-left: 150px;
            }
        footer{
            background-color: #0426d3;
            margin-left:0px;
            margin-top:150px;
            padding:10px;
            line-height: 30px;
            text-transform:capitalize;
            color:white;
            letter-spacing: 2px;
            font-size: 20px;
        }
        .bloghead{
            display:inline-block;
            position:relative;
            margin:0px;
            float:left;
            color:white;
            
        }
        .bloghead{
            position:relative;
            margin-left:0px;
            margin-top:1px;
            margin-right:0px;
            margin-bottom:5px;
            display:inline;
        }
        .paratitle{
            display: inline;
        }
        .buttons{
            display: inline;
        
        }
        .buttons ul li{
            float:left;
            color:black;
            border:6px solid black;
            border-radius: 50%;
            margin: 2px;
            list-style-type: none;
        }
        .buttons a:link,a:visited,a:active{
            color:black;
        }
        .span{
            border:6px solid black;
            border-radius: 50%;
            margin: 2px;
        }
        #wrapper{
            border: 2px solid black;
            width:100%;
            position:relative;
            float:left;
            overflow:hidden;
            margin-right:10px;
            
            
        }
        #boxOne,#boxTwo,#boxThree{
            position:relative;
            width:100%;
            margin:20px;
            border:1px solid blue;
        }
        .cover2{
            padding:0px;
            margin:3px;
            width:300px;
            position:relative;
            display:inline;
        }
        .cContent{
            background-color:#0426d3;
            position:relative;
            width:40%;
        }
        #blog{
            margin-bottom:100px;
            position:relative;
        }
    </style>
    <body>
        <?php include("navbar.php"); ?>
        <div id="about">
            <div class="paratitle">About us</div>
            <p>Civil Engineering Consortium is a Student Affair Committee of department of Civil Engineering, that is responsible to promote safe and intellectually stimulating learning environment that encourages not only the academic success of civil engineering students but also focus on personal development, sports and other extracurriculars student activities. With the chain of activities going round the year, students get ample opportunity to flash, flourosh and furnish their talents.</p>
        
        </div>
        <div id="blog">
            <div class="paratitle">blog<br></div>
            <div id="wrapper">
                <div id="boxOne" class="content">
                    <div class="cover2"><img src="img/cover3.jpg" width="100%"></div>
                    <div class="cContent"></div>
                </div>
                <div id="boxTwo" class="content">
                </div>
                <div id="boxThree" class="content">
                </div>
            </div>
        
        </div>
    

               
            
    
    
        <footer>
            <div id="contact">
                <p>Contact<br>Phone +91 9999 9999999<br>Email abc@gmaiil.com</p>
            
            
          
            </div>
        
        </footer>
    
    </body>








</html>