<?php
include("serverblog.php");
?>
<head>
    <link href="css/cs.css" rel="stylesheet" type="text/css">
    <link href="css/responsive.css" rel="stylesheet" type="text/css">
    <link href="css/newcs.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <style>
        .patientsList {
    border-collapse: collapse;
    width: 100%;
    margin-left: 0px;
    max-height: 400px;
    overflow: auto;
}

 .patientsList td {
    text-align: left;
    padding: 15px;
    font-size: 14px;
    color: #828282;
}


.patientsList tr:nth-child(odd){
	background-color: #f2f2f2;
}
    </style>
</head>
<div class="tab-content">
    <div class="row">
		<div class="col-sm-12 col-xs-12"> 
			<div class="col-sm-12 col-xs-12">

<?php
                $sqltest = "SELECT * FROM `cec-blog`";
                $resulttest = mysqli_query($conn, $sqltest );
                if($_POST['update'] == 'Publish')
                {
                    $row_id = $_POST['id'];
                    echo $row_id;
                    $sqlblog = "UPDATE `cec-blog` SET status = '1' WHERE id = '$row_id' ";
                    print $sqlblog;
                    $resultblog = mysqli_query($conn, $sqlblog );
                    //$rowblog = mysqli_fetch_assoc($resultblog);
                    $result3 = mysqli_query($conn,$sqlblog);                                        
                }
                ?>
                
                <div class="row">
                    <div class="col-md-10">
                        <h1><strong>Recent Blogs</strong></h1>
                    </div>
                    <div class="col-md-1">
                        <h5><a href="http://localhost/cec-Website/admin/blog-writing.php" class="btn btn-info">Create a Blog</a></h5>
                    </div>
                </div>
                </div></div></div>
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
                            if ($resulttest) 
                            {
                                while($rowtest = mysqli_fetch_assoc($resulttest)){    ?>
                            <tr>
                                <td><?php echo $rowtest['id'] ?></td>		
                                <td ><?php echo $rowtest['Topic'] ?></td>
                                <td><?php
                                        $category = $rowtest['Category'];
                                        $sql1 = "SELECT * FROM `category` WHERE id = $category";
                                        echo $category;                                          
                                        $result1 = mysqli_query($conn,$sql1);
                                        $row1 = mysqli_fetch_assoc($result1);
                                        echo $sql1;                                          
                                        echo $row1['name'] ; ?>
                                </td>
                                <td ><?php echo $rowtest['modified_time'] ?></td>
                                <td ><?php 
                                        if( $rowtest['status'] == 1)
                                        {echo "Published";}
                                    else {echo "Saved";}?>
                                </td>
                                <td>
                                    <?php 
                                        if( $rowtest['status'] == 1){
                                    ?>
                                    <form method="post" action="http://localhost/cec-Website/admin/blog-writing.php">
                                        <input class="btn btn-info" type="hidden" name="id" value="<?php echo $rowtest['id']; ?>">
                                        <input class="btn btn-info" type="submit" name="edit" value="Edit">
                                    </form>
                                    <?php
                                        } else {
                                    ?>
                                    <form method="post">
                                        <input class="btn btn-info" type="hidden" name="id" value="<?php echo $rowtest['id']; ?>">
                                        <input formaction="http://localhost/cec-Website/admin/blog-writing.php" class="btn btn-info" type="submit" name="edit" value="Edit"><br>
                                        <input class="btn btn-info" type="submit" name="update" value="Publish">
                                    </form>
                                    <?php } ?>
                                </td>
                            </tr>
                            <?php }}  ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-2"></div>
    </div>
    <hr>
</div>