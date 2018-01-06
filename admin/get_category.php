<?php 
require('../functions/functions.php');
$res = $functions->searchconditions($_GET['condi']);
echo $res;
?>