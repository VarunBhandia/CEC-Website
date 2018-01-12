<!DOCTYPE html>
<html>
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
