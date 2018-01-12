<!DOCTYPE html>
<html>
<head>
<!--
<style>

.topnav {
  overflow: hidden;
    padding-top: 1.5em;
        padding-right: 2em;}

.topnav a {
  float: left;
  display: block;
  color: black;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
    font-size: 1.1em;
    font-weight: 600;
}

.topnav a:hover {
  text-decoration:line-through;
            text-decoration-color:#d3c6ff ;
            text-shadow: 10px;
            text-decoration-style:solid;
            color: #9da0cb;
}

.active {
  background-color:;
  color: white;
}

.topnav .icon {
  display: none;
}

@media screen and (max-width: 600px) {
  .topnav a:not(:first-child) {display: none;}
  .topnav a.icon {
    float: right;
    display: block;
  }
}

@media screen and (max-width: 600px) {
  .topnav.responsive {position: relative;}
  .topnav.responsive .icon {
    position: absolute;
    right: 0;
    top: 0;
  }
  .topnav.responsive a {
    float: none;
    display: block;
    text-align: left;
  }

}
</style>
-->
</head>
<body>

<div class="topnav" id="myTopnav">
    <a href="../CEC-Website/index.php" style="padding-left: 3em;">HOME</a>
    <a href="" style="padding-left: 3em;">ABOUT</a>
    <a href="../CEC-Website/recent-posts.php" style="padding-left: 3em;">BLOG</a>
    <a href="../CEC-Website/events.php" style="padding-left: 3em;" >ACTIVITIES</a>
    <a href="../CEC-Website/contact-us.php" style="padding-left: 3em;">TEAM</a>
    <a href="../CEC-Website/alumini-main-page.php" style="padding-left: 3em;">ALUMINI</a>
    <a href="" style="padding-left: 3em;">CONTACT</a>

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

</body>
</html>
