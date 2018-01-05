<?php 
//require("C:/xampp/htdocs/DocConsult/doc_panel/functions/functions.php");
require("C:/xampp/htdocs/DocConsult/functions/functions.php");
include("C:/xampp/htdocs/DocConsult/doc_panel/mainframe.php");
include('C:/xampp/htdocs/DocConsult/doc_panel/searching-header.php'); 
?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "docconsu_db";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM doctor_tip1";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$blog_id = $row['id'];
$category_id = $row['Category']
?>
<style>
    .btn:hover{
        color: #FF3366;
    }
    
    }
    .read-more-state {
  display: none;
        
}

.read-more-target {
    
  opacity: 0;
    
  max-height: 0;
  font-size: 0;
  transition: .25s ease;
    display: none
    
    
}

.read-more-state:checked ~ .read-more-wrap .read-more-target {
  opacity: 1;
  font-size: inherit;
  max-height: 999em;
    display: block;
    transition: .25s ease;
    
}

.read-more-state ~ .btn:before {
  content: 'Show more';
}

.read-more-state:checked ~ .btn:before {
  content: 'Show less';
}

.read-more-trigger {
  cursor: pointer;
  display: inline-block;
  padding: 0 .5em;
  color: #666;
  font-size: .9em;
  line-height: 2;
  border: 1px solid #ddd;
  border-radius: .25em;
}

</style>
<body style="background-color: #F5F5F5; font-family: 'Open Sans', sans-serif;">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div>
                    <input style="display: none;"type="checkbox" class="read-more-state" id="post-2"/>
                    <center><h3>Topics</h3><hr></center>
                    <div class="read-more-wrap">
                        <div>
                            <?php
    //$category = $row['Category'];
    //echo $category;
    //$sql1 = "SELECT * FROM `condition`";
    //$result1 = mysqli_query($conn, $sql1);
    //while($row1 = mysqli_fetch_assoc($result1))
    //{
        //echo $category;
        //echo $row1['name'] ;
    //} 
                            ?>
                            <?php
                            $all_category = $functions->get_category_index();
                            echo $base_url;
                            $cnt_category = count($all_category);
                            //print_r($all_category);
                            for($i = 0; $i <40; $i++)
                            {
                                $cur_cat1 = preg_replace("![^a-z0-9]+!i", "-", $all_category[$i]);
                                $cur_cat_cnt = strlen($all_category[$i]);
                                //echo $cur_cat_cnt;
                                //$doc_spec = $doc_specss = ucwords($all_category[$i]);			
                                //if($cur_cat_cnt >= 25){$doc_specss .= '...';}

                                print "<div class='col-md-3' style='text-align: center;'><strong><br><a href='".base_url."topics/topics.php?id=".($i+1)."&name=".$cur_cat1."' class='btn btn-primary city_button'style='width: 100%;transition: .5s;overflow:hidden; text-overflow: ellipsis;'>".$all_category[$i]."</a><br></strong></div>";
                            }
                            ?>
                        </div>
                        <div class="read-more-target"><?php
                            for($i = 40; $i <$cnt_category ; $i++)
                            {
                                print "<div class='col-md-3' style='text-align: center;'><strong><br><a href='http://localhost/docconsult/Doctor-tip-Blog/line-control-master/Doctor_Tip-blogs.php?id=".$i."&name=".$all_category[$i]."' class='btn btn-primary city_button'style='width: 100%;transition: .5s;overflow:hidden; text-overflow: ellipsis;'>".$all_category[$i]."</a><br></strong></div>";
                            }
                            ?>
                        </div>
                    </div>
                    <label for="post-2" class='btn btn-primary city_button'style='width: 100%;transition: .5s;    margin-top: 18px; '></label>
                </div>
                <hr>
                <h2>&nbsp;</h2>
            </div>
        </div>
    </div>
    <?php
    mysqli_close($conn);
    include 'footer.php';
    ?>


