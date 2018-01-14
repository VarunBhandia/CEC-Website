<?php
    include("serverblog.php"); 
    $sqlcat = "SELECT * FROM category";
    $resultcat = mysqli_query($conn, $sqlcat );
    $rowcat = mysqli_fetch_assoc($resultcat);
    $sqltest = "SELECT * FROM cec-blog";
    $resulttest = mysqli_query($conn, $sqltest );
    $rowtest = mysqli_fetch_assoc($resulttest);
    var_dump($resultcat);
    echo '<br>';
    var_dump($rowcat); 
    echo $rowcat['name'];

?>
<!DOCTYPE HTML>
<html>
	<head>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
		<script src="../admin/editor.js"></script>
		<script>
			$(document).ready(function() {
				$("#txtEditor").Editor();
			});
		</script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
		<link href="../admin/editor.css" type="text/css" rel="stylesheet"/>
		<title>Admin-Blog-Writing</title>
        <style>
            .txtarea
            {
                width: 70%;
                height: 20vh;
            }
    
            .main-admin-heading
            {
                margin-left: 1vh
            }
            
            .go-back
            {
                padding-top: 2em;
                
            }
        </style>
	</head>
	<body>
        <script>
            var category_index;
        </script>            
        <div class="row">
            <div class="col-md-11">
                <h1 class="main-admin-heading">Admin Blog</h1>
            
            </div>
            
            
            <div class="col-md-1">
                <div class="go-back">
                    <a href="http://localhost/cec-Website/admin/index.php" class="btn btn-info">Back</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <?php 
                $rowtest['id'];
                $edit_id = $_POST['id'];
                if(isset($_POST['edit']))
                {
                    $sqlblog = "SELECT * FROM cec-blog where id='$edit_id'"; 
                    $resultblog = mysqli_query($conn, $sqlblog );
                    $rowblog = mysqli_fetch_assoc($resultblog);
                }
                
                ?>
                <form method="POST" action="" enctype="multipart/form-data" data-toggle="validator" role="form" id="fileForm">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-5">
                                <label for="" class="control-label">Topic Title</label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control"  name="title" placeholder="Enter Your Title" required value="<?php echo $rowblog['Topic'];?>">
                            </div>
                        </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-5">
                                <label for="" class="">Please Select An Image For Your Topic Featured Image. </label>
                            </div>
                            <div class="col-md-4">
                                <input type="file" class=""  name="image" id="image">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Description" class="control-label">Description/ Content</label>
                        <div class="col-lg-12 nopadding">
                            <textarea id="txtEditor" class="textdescription" name="texteditor22">
                                <?php echo $rowblog['Texteditor']; ?><?php if($_GET['action'] == 'edit'){echo $post_content;}?>
                            </textarea>
                        </div>
                        <small id="emailHelp" class="form-text text-muted">Please Enter Your Topic Descriptions. </small>
                    </div>
                   <?php
                    if(isset($_POST['edit']))
                    {?>
                       <input type="hidden" name="edit_id" value="<?php echo $row['id']; ?>">
                       <input id="blogSubmit" name="edit_submit" type="submit" class="btn btn-primary submit_data" value="Update">
                    <?php
                    }else{
                    ?>
                    <input id="blogSubmit" name="edit_submit" type="submit" class="btn btn-primary submit_data" value="Submit">
                    <input id="blogSave" name="edit_submit" type="submit" class="btn btn-primary submit_data" value="Save">
                    <?php }?>
                    
                    
                    
                    <input type="hidden" name="texteditor" value="<?php echo $row['Texteditor']; ?>" id="texteditor">
                </form>
            </div>
            <div class="col-md-3"></div>
        </div>
        <script>
			$(document).ready(function() {
				//$("#txtEditor").Editor();
				$(".submit_data").click(function(){
                   var value = $(".Editor-editor").html(); 
                   $("#texteditor").val(value);
                });
			});
			
			$("texteditor").val();
		</script>
        <script>
			$(document).ready(function() {
				<?php
			    	if(isset($_POST['edit'])){?>
				 	$("#txtEditor").Editor("setText", '<?php echo $row['Texteditor'];?>');
				<?php }else
                    {	?>			
                        //$("#txtEditor").Editor();
                    <?php } ?>
				 $(".submit_data").click(function(){
                   var value = $(".Editor-editor").html(); 
                   $("#texteditor").val(value);
                });
			});
			$("texteditor").val();
		</script>
        
        <?php
        $image_name = $_FILES['image']['name'];
                    $tmp_name = $_FILES['image']['tmp_name'];
                    $location = 'C:/xampp/htdocs/DocConsult/Doctor-tip-Blog/line-control-master/doctor-tips-images/';
                    move_uploaded_file($tmp_name,$location.$image_name);
                    
        if(isset($_POST['edit_submit']))
        {                      
            $Topic = $_POST['title'];
            $Texteditor = htmlspecialchars($_POST['texteditor']);
            $imagename = $image_name;
            $Category = $_POST['Category'];
            $edit_id = $_POST['edit_id'];
            $sqlcond = "SELECT * FROM cec-blog where Category = '$Category'";
            $resultcond = mysqli_query($conn, $sqlcond);
            $rowcond = mysqli_fetch_assoc($resultcond);
            
            if($_POST['edit_submit'] == 'Update')
            {
                $status = 1;
                $sql = "update cec-blog set Topic = '$Topic', Texteditor = '$Texteditor', imagename = '$imagename', status = '$status', Category = '$Category', modified_time=now() where id = '$edit_id' ";
                $message = "Successfully Update !! ";
            }
            else
            {
                if($_POST['edit_submit'] == 'Submit')
                {
                    $status = 1;
                    $sql = "INSERT INTO cec-blog (Topic,Texteditor,imagename,status,Category, modified_time) VALUES ('$Topic','$Texteditor','$imagename','$status','$Category', NOW())";
                    if (mysqli_query($sql) === TRUE) 
                    {
                        //print $sql = "INSERT INTO cec-blog (Topic,Texteditor,imagename,status,Category, modified_time) VALUES ('$Topic','$Texteditor','$imagename','$status','$Category', NOW())";
                        $message = "New record created successfully ";
                        echo $message; 
                        echo $status;
                        $url_re =  base_url_admin."admin-blog/Doctor_Tip-dashboard.php";
                        echo "<script>location.href = '".$url_re."'</script>";
                    }
                    else {echo "Error: ";}
                }
                
                elseif($_POST['edit_submit'] == 'Save')
                {
                    $status = 2;
                    $sql = "INSERT INTO cec-blog (Topic,Texteditor,imagename,status,Category, modified_time) VALUES ('$Topic','$Texteditor','$imagename','$status','$Category', NOW())";
                    if (mysqli_query($sql) === TRUE) {
                        $message = "New record Saveds successfully "; 
                        //echo $status;
                        $url_re =  base_url_admin."admin-blog/Doctor_Tip-dashboard.php";
                        echo "<script>location.href = '".$url_re."'</script>";
                    }
                else {echo "Error: ";}
                } 
            }
        }      
        ?>
        <script>
            function restore()
            {
               category_index = document.getElementById('category').value;
            }
            //console.log(category_index);
        </script>
        
    </body>
</html>
