<?php
function searchconditions($parm) {
    $res=$this->db->query("select distinct t1.name, t1.id from `category` as t1 inner join cec-blog as t2 on t1.id = t2.category where t1.name like '%$parm%' group by t1.name limit 5");
        
    $rows = array();
    while($r = mysqli_fetch_array($res)){
        $rows[] = $r;
    }
    $res = json_encode($rows);
    return $res;
    echo 'test';
}
?>