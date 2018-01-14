<?php
include("serverblog.php"); 

function searchconditions($parm) {
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

function get_category_index(){
    $sql = "SELECT * FROM doctor_tip1 INNER JOIN `condition` ON doctor_tip1.Category = `condition`.id";
    $result = mysqli_query($conn, $sql );
    $result = array();
    while($data = mysqli_fetch_assoc($result))
    {
        $result[] = $data['name'];
    }
    return $result;
}

?>