<head>
    <link href="http://localhost/docconsult/doc_panel/cs.css" rel="stylesheet" type="text/css">
    <link href="http://localhost/docconsult/doc_panel/responsive.css" rel="stylesheet" type="text/css">
    <link href="http://localhost/docconsult/doc_panel/css/newcs.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

</head>
<div class="tab-content">
    <div class="row">
		<div class="col-sm-12 col-xs-12"> 
			<div class="col-sm-12 col-xs-12">
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
if($_POST['update'] == 'Publish')
{
    $row_id = $_POST['id'];
    echo $row_id;
    $sql3 = "UPDATE doctor_tip1 SET status = '1' WHERE id = '$row_id' ";
    $result3 = mysqli_query($conn, $sql3);                                        
}
                
if(isset($_POST['search_condition']))
{
    $search_id = $_POST['search_condition'];
    $search = " where Category = '$search_id' ";
}else{
    $search = '';
}
$sql = "SELECT * FROM doctor_tip1 $search ";

$result = mysqli_query($conn, $sql);
                ?>
                <div class="row">
                    <div class="col-md-10">
                        <h1><strong>Recent Blogs</strong></h1>
                    </div>
                    <div class="col-md-1">
                        <h5><a href="<?php echo base_url_admin; ?>admin-blog/Doctor_Tip-writing.php" class="btn btn-info">Create a Blog</a></h5>
                    </div>
                </div>
                </div></div></div>
    <div>
        <form id="searchForm" method="post">
            <select id="condition-search" onchange="this.form.submit()" name="search_condition">

            </select>
        </form>
        <script>
            $("#condition-search").select2({
  ajax: {
    url: "http://localhost/DocConsult/get_condition.php",
    dataType: 'json',
    delay: 250,
    data: function (params) {
      return {
        condi: params.term
      };
    },
    processResults: function (data, params) {
        var data =$.map(data, function(obj) {
                        obj.text = obj.text || obj.name ;
                        return obj;
                        });
      return {
        results: data,
      };
    },
    cache: true
  },
  placeholder: 'Search for a condition',
});
document.getElementById('condition-search').nextSibling.style.width="70%";
            $("#condition-search").on("select2:select", function (e) { 
                
                
                console.log(document.getElementById("condition-search").options[document.getElementById("condition-search").selectedIndex].value);
                
            
            });
        </script>
    </div>
                <div class="row">
				
				<hr>
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <div class="row contentTable " > 
                        <div class="table-responsive col-sm-12">
                            <table class="patientsList" >
                                <thead  style="font-weight: 700">
                                    <tr style="color: #333333; background-color: white; cursor:pointer">    
                                        <td>Id</td>		
                                        <td >Post Title</td>
                                        <td>Category</td>
										<td >Time</td>
                                        <td >Status</td>
                                        <td>Action</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (mysqli_num_rows($result) > 0) {
                                        // output data of each row
                                        while($row = mysqli_fetch_assoc($result)) { 
                                    ?>
                                    <tr>
                                        <td><?php echo $row['id'] ?></td>		
										<td ><?php echo $row['Topic'] ?></td>
										<td><?php
                                        
                                        $category = $row['Category'];
                                            //echo $category;
                                        $sql1 = "SELECT * FROM `condition` WHERE id = $category";
                                        $result1 = mysqli_query($conn, $sql1);
                                            while($row1 = mysqli_fetch_assoc($result1))
                                            {
                                                //echo $category;
                                                echo $row1['name'] ;
                                            } ?>
                                        </td>
										<td ><?php echo $row['modified_time'] ?></td>
										<td >
                                            <?php 
                                        if( $row['status'] == 1)
                                        {
                                            echo "Published";
                                        }
                                            else 
                                            {
                                                echo "Saved";
                                            }
                                            ?>
                                        </td>
										<td>
                                            
                                                <?php 
                                            if( $row['status'] == 1)
                                            {
                                                ?>
                                            <form method="post" action="<?php echo base_url_admin; ?>admin-blog/Doctor_Tip-writing.php">
                                            <input class="btn btn-info" type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                <input class="btn btn-info" type="submit" name="edit" value="Edit">
                                                </form><?php
                                            }
                                            else 
                                            {
                                                ?>
                                            <form method="post">
                                            <input class="btn btn-info" type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                <input formaction="<?php echo base_url_admin; ?>admin-blog/Doctor_Tip-writing.php" class="btn btn-info" type="submit" name="edit" value="Edit"><br>
                                                <input class="btn btn-info" type="submit" name="update" value="Publish">
                                            </form>
                                                <?php
                                            }
                                            
                                            ?>
                                                
                                            
                                        </td>
                                    </tr>
                                    <?php  
                                        }}else{ 
                                    ?>
                                    <tr ng-if="list.length == 0">
                                        <td colspan="7">
                                            No Records Found.
                                        </td>
                                    </tr>
                                    <?php 
                                    } mysqli_close($conn); 
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    </div>
                    <div class="col-md-2"></div>
    </div>
    <hr>
    </div>