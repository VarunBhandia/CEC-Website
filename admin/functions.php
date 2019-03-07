
<?php 
ini_set("display_errors",'off');
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "cec";

//    $servername = "localhost";
//    $username = "id4848840_varunbhandia";
//    $password = "varunbhandia";
//    $dbname = "id4848840_varuncec";

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    // Check connection
    if (!$conn) 
      {
          die("Connection failed: " . mysqli_connect_error());
      }

function searchconditions($conn,$parm) {
    $sql = "select distinct t1.name, t1.id from `category` as t1 inner join cec-blog as t2 on t1.id = t2.category where t1.name like '%$parm%' group by t1.name limit 5";
    $res = mysqli_query($conn, $sql );
    $rows = array();
    while($r = mysqli_fetch_array($res)){
        $rows[] = $r;
    }
    $res = json_encode($rows);
    return $res;
    echo 'test';
}

function get_category_index($conn){
    $sql = "SELECT * FROM `cec-blog` where status = 1";
    $res = mysqli_query($conn, $sql );
    $result = array();
    while($data = mysqli_fetch_assoc($res))
    {
        $result[] = $data['Topic'];
    }
    return $result;
}

function get_marvel_id($conn){
    $sql = "SELECT * FROM `cec-marvel`";
    $res = mysqli_query($conn, $sql );
    $result = array();
    while($data = mysqli_fetch_assoc($res))
    {
        $result[] = $data['id'];
    }
    return $result;
}

function get_category_id($conn){
    $sql = "SELECT * FROM `cec-blog` where status = 1";
    $res = mysqli_query($conn, $sql );
    $result = array();
    while($data = mysqli_fetch_assoc($res))
    {
        $result[] = $data['Category'];
    }
    return $result;
}

function get_blog_id($conn){
    $sql = "SELECT * FROM `cec-blog` where status = 1";
    $res = mysqli_query($conn, $sql );
    $result = array();
    while($data = mysqli_fetch_assoc($res))
    {
        $result[] = $data['id'];
    }
    return $result;
}

function get_related_posts($categoryid,$conn){
    $sql = "SELECT * FROM `cec-blog` WHERE Category = '$categoryid'";
    $res = mysqli_query($conn, $sql );
    $result = array();
    while($data = mysqli_fetch_assoc($res))
    {
        $result[] = $data['id'];
    }
    return $result;
}

function get_team_name($conn){
    $sql = "SELECT * FROM `team`";
    $res = mysqli_query($conn, $sql );
    $result = array();
    while($data = mysqli_fetch_assoc($res))
    {
        $result[] = $data['name'];
    }
    return $result;
}
function get_team_img($conn){
    $sql = "SELECT * FROM `team`";
    $res = mysqli_query($conn, $sql );
    $result = array();
    while($data = mysqli_fetch_assoc($res))
    {
        $result[] = $data['img'];
    }
    return $result;
}
function get_team_link($conn){
    $sql = "SELECT * FROM `team`";
    $res = mysqli_query($conn, $sql );
    $result = array();
    while($data = mysqli_fetch_assoc($res))
    {
        $result[] = $data['link'];
    }
    return $result;
}


?>