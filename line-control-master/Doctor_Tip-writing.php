<?php
//ini_set("display_errors",'off');
require("C:/xampp/htdocs/DocConsult/doc_panel/functions/functions.php");
$con = mysqli_connect('localhost','root','');
if(!$con)
{
    echo 'Not Connected to Server';
}
if(!mysqli_select_db($con,'docconsu_db'))
{   
    echo 'Database not selected';
}
print_r($_POST);
?>
<?php print_r($_POST); ?>
<!DOCTYPE HTML>
<html>
	<head>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
		<script src="editor.js"></script>
		<script>
			$(document).ready(function() {
				$("#txtEditor").Editor();
			});
		</script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
		<link href="editor.css" type="text/css" rel="stylesheet"/>
		<title>Doctor's Tip</title>
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
                    <a href="http://localhost/DocConsult/doctor-tip-Blog/line-control-master/Doctor_Tip-dashboard.php" class="btn btn-info">Back</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <?php 
                echo $row['id'];
                $edit_id = $_POST['id'];
                if(isset($_POST['edit']))
                {
                    //$edit_id = $_POST['id'];
                    $sql = "SELECT * FROM doctor_tip1 where id='$edit_id'"; 
                    $result = $con->query($sql);
                    $row = mysqli_fetch_assoc($result);
                    
                } 
                ?>
                <form method="POST" action="" enctype="multipart/form-data" data-toggle="validator" role="form" id="fileForm">
                    <div class="form-group">
                        <label for="" class="control-label">Topic Title</label>
                        <input type="text" class="form-control"  name="title" placeholder="Enter Your Title" required value="<?php echo $row['Topic'];?>">
                        <small id="" class="form-text text-muted">Please Enter Your Topic Title .</small>
                    </div>
                    <div class="form-group">
                        <label for="" class="">Please Select An Image For Your Topic Featured Image. </label>
                        <input type="file" class=""  name="image" id="image">
                    </div>
                        <div class="form-group">
                            <label for="select" class="control-label">Select A Category:</label>
                            <select class="form-control" onchange="restore()" id="category" name="Category" value="<?php echo $row['Category'];?>" required>
                                <?php
                                        $category = $row['Category'];
                                        $sql1 = "SELECT * from condition WHERE id = $category";
                                        $result1 = mysqli_query($conn, $sql1);
                                            while($row1 = mysqli_fetch_assoc($result1))
                                            {
                                                echo $row1['name'] ;
                                            } ?>

                                <?php echo $row['Category'];?>
                                <option value="">Select A Category</option>
                                <?php
                                $sql11 = "SELECT * FROM `condition";
                                $category_res11 = $functions->getdistrict($sql11);
                                foreach($category_res11 as $cat_r11)
                                {	
                                    if($cat_blog11 == $cat_r11['id']){$sel11 = 'selected';}else{$sel11 = '';}				
                                    echo "<option value='".$cat_r11['id']."' $sel11>".$cat_r11['name']."</option>";
                                }?>
                            </select>
                            <?php if (isset($row['Category'])) {
                                ?>
                                    <script>
                                        $(document).ready(function(){
                                            document.getElementById('category').value = "<?php echo $row['Category'];?>";
                                        });
                                    </script>
                            <?php } ?>
                        </div>
                    <div class="form-group">
                        <label for="Description" class="control-label">Description/ Content</label>
                        <div class="col-lg-12 nopadding">
                            <textarea id="txtEditor" class="textdescription" name="texteditor22">
                                <?php echo $row['Texteditor']; ?><?php if($_GET['action'] == 'edit'){echo $post_content;}?>
                            </textarea>
                        </div>
                        <small id="emailHelp" class="form-text text-muted">Please Enter Your Topic Descriptions. </small>
                    </div>
                    <input id="blogSubmit" name="edit_submit" type="submit" class="btn btn-primary submit_data" value="Submit">
                    <input id="blogSave" name="edit_submit" type="submit" class="btn btn-primary submit_data" value="Save">

                    <input type="hidden" name="texteditor" value="<?php echo $row['Texteditor']; ?>" id="texteditor">
                </form>
            </div>
            <div class="col-md-3"></div>
        </div>
        
        <?php
        $image_name = $_FILES['image']['name'];
                    $tmp_name = $_FILES['image']['tmp_name'];
                    $location = 'C:/xampp/htdocs/DocConsult/Doctor-tip-Blog/line-control-master/doctor-tips-images/';
                    move_uploaded_file($tmp_name,$location.$image_name);
                    
        if(isset($_POST['edit_submit']))
        {
            if($_POST['edit_submit'] == 'Submit')
            {
                $status = 1;
            }else{
                $status = 2;
            }
    
            $Topic = $_POST['title'];
            $Texteditor = $_POST['texteditor'];
            $imagename = $image_name;
            $Category= $_POST['Category'];
            $sql = "INSERT INTO doctor_tip1 (Topic,Texteditor,imagename,status,Category, modified_time) VALUES ('$Topic','$Texteditor','$imagename','$status','$Category', NOW())";
            if ($con->query($sql) === TRUE) {
                echo "New record created successfully "; 
                echo "svhch".$status;
             } 
            else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
            //die();
        }

$con->close();
                
        ?>
            <script>
                if("<?php echo $_POST['edit_submit'] ?>" == "Submit"){
                    window.location.href = "http://localhost/DocConsult/doctor-tip-Blog/line-control-master/Doctor_Tip-dashboard.php";
                    
                   }
        </script>
        <script>
                if("<?php echo $_POST['edit_submit'] ?>" == "Save"){
                   
                    window.location.href = "http://localhost/DocConsult/doctor-tip-Blog/line-control-master/Doctor_Tip-dashboard.php";
                    
                   }
        </script>
        <script>
            function restore()
            {
               category_index = document.getElementById('category').value;
            }
            //console.log(category_index);
        </script>
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
    </body>
</html>
