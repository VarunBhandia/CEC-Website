<?php

require_once("config.php");
session_start();
class Functions{
    
   
	public function __construct(){

		$connect=new Config();

		$this->db=$connect->connection();
			$connect_blog=new Config_blog();
		$this->db_blog=$connect_blog->connection();

				date_default_timezone_set("Asia/Kolkata");
	}

    public function get_patient_mob() {
    
    $sql = "select * from phone_no where patient phone_no='$phone_no'";
    $res = $this->db->query($sql);

    if($res->num_rows > 0){
        $dataselect = $res->fetch_assoc();
        return  $dataselect['phone_no'];
    }
}


public function get_doctor_mob() {
    
    $sql = "select * from phone_no where doctors phone_no='$phone_no'";
    $res = $this->db->query($sql);

    if($res->num_rows > 0){
        $dataselect = $res->fetch_assoc();
        return  $dataselect['phone_no'];
    }
}

	public function host_base_url(){
		if(!$_SERVER['SERVER_NAME']='localhost'){
			echo LOCALHOST;
		}
		else{
			echo base_url;
		}
	}
	public function start_session(){

		return session_start();

	}


public function getdistricts()
{
	
	$res=$this->db->query("select DISTINCT city from clinic order by city");
	
	$rows = array();
	while($r = mysqli_fetch_array($res)){
		$rows[] = $r;
	}
	$res = json_encode($rows);
	return $res;
}


public function getlocation($query)
{
    
	$res=$this->db->query($query);
	
	$rows = array();
	while($r = mysqli_fetch_array($res)){
		$rows[] = $r;
	}
	$res = json_encode($rows);
	return $res;
	
}

public function find_trending_blogs(){
        $period=date("Ym");
        $period_last = $period - 1;
        
     $data = $this->db_blog->query(" SELECT id FROM ( SELECT id FROM wp_posts where post_type= 'post' AND post_status='publish' ORDER BY id DESC LIMIT 3 ) sub ORDER BY id ASC
");
        
        if($data->num_rows > 0)
        {
            $str='';
            $count=0;
            
            while($res=$data->fetch_assoc())
            {
               // echo $count;
                if($count<3){
                    
                $id = $res['id'];               
            $post_name = $this->db_blog->query("SELECT * FROM `wp_posts` where ID = '$id'");
            $post_name = $post_name->fetch_assoc();
               
            $author_id = $post_name['post_author'];
            $author_name = $this->db_blog->query("SELECT * FROM `wp_users` where ID = '$author_id'");
            $author_name = $author_name->fetch_assoc();    
            $featured_image_id = $this->db_blog->query("SELECT meta_value from `wp_postmeta` where post_id='$id' and meta_key='_thumbnail_id'");
            $featured_image_id = $featured_image_id->fetch_assoc();
            $featured_image_id=$featured_image_id['meta_value'];
            //echo $featured_image_id;
            $featured_image = $this->db_blog->query("select * from `wp_posts` where ID='$featured_image_id'");
        
                if($count ==0){
                    $str.='<div class="col-sm-4 col-sm-offset-0 col-xs-12 col-xs-offset-0" style="text-align:center">';
                  
                }
                else{
                    $str .= '<div class="col-sm-4 col-sm-offset-0 col-xs-12 col-xs-offset-0" style="text-align:center">';
                }
                if($featured_image->num_rows > 0)
                {
                    $featured_image = $featured_image->fetch_assoc();
                    $featured_image = $featured_image['guid'];
                    $str.='<img class=" blogs-image" src ="'; $str.=$featured_image; $str.=' ">';
                }
                else
                {
                    $str.='<img class=" blogs-image" src ="'; $str.='http://forseadiscovery.eu/sites/default/files/attachments/images/logo_blogger.jpg'; $str.=' ">';
                }
                    $str.='
                        <a target="blank" href = "blog/';
                        $str.=$post_name['post_name'];
            $str.='">
                        <p class=" blogs-info provider-title">'; $str.=$post_name['post_title']; 
                        $str.= '</p></a>
                        
                    </div>';
                    $count = $count +1;
                }
                
            }
            $str.='';
        }
        return $str;
    }


    /*public function find_trending_blogs(){
        $period=date("Ym");
        $period_last = $period - 1;
        
        $data = $this->db_blog->query("SELECT DISTINCT id FROM `wp_post_views` where type='4' AND (period = '$period' OR period='$period_last') ORDER BY `count` DESC");
        
        if($data->num_rows > 0)
        {
            $str='';
            $count=0;
            
            while($res=$data->fetch_assoc())
            {
               // echo $count;
                if($count<3){
                    
                $id = $res['id'];				
        	$post_name = $this->db_blog->query("SELECT * FROM `wp_posts` where ID = '$id'");
        	$post_name = $post_name->fetch_assoc();
        	   
        	$author_id = $post_name['post_author'];
        	$author_name = $this->db_blog->query("SELECT * FROM `wp_users` where ID = '$author_id'");
        	$author_name = $author_name->fetch_assoc();    
        	$featured_image_id = $this->db_blog->query("SELECT meta_value from `wp_postmeta` where post_id='$id' and meta_key='_thumbnail_id'");
        	$featured_image_id = $featured_image_id->fetch_assoc();
        	$featured_image_id=$featured_image_id['meta_value'];
        	//echo $featured_image_id;
        	$featured_image = $this->db_blog->query("select * from `wp_posts` where ID='$featured_image_id'");
        
                if($count ==0){
                    $str.='<div class="col-sm-4 col-sm-offset-0 col-xs-12 col-xs-offset-0" style="text-align:center">';
                  
                }
                else{
                    $str .= '<div class="col-sm-4 col-sm-offset-0 col-xs-12 col-xs-offset-0" style="text-align:center">';
                }
                if($featured_image->num_rows > 0)
                {
                    $featured_image = $featured_image->fetch_assoc();
                    $featured_image = $featured_image['guid'];
                    $str.='<img class=" blogs-image" src ="'; $str.=$featured_image; $str.=' ">';
                }
                else
                {
                    $str.='<img class=" blogs-image" src ="'; $str.='http://forseadiscovery.eu/sites/default/files/attachments/images/logo_blogger.jpg'; $str.=' ">';
                }
                    $str.='
		        		<a target="blank" href = "blog/';
		        		$str.=$post_name['post_name'];
        	$str.='">
		        		<p class=" blogs-info provider-title">'; $str.=$post_name['post_title']; 
		        		$str.= '</p></a>
		        		
		        	</div>';
		        	$count = $count +1;
                }
                
            }
            $str.='';
        }
        return $str;
    }*/
    public function getById($id, $table){
		$res = $this->db->query("SELECT * FROM `$table` WHERE id='{$id}'");

		$str = '';

			if($res->num_rows > 0){

				return $res->fetch_assoc();

		}

	}
	public function getByDoctorId($id, $table){

		$res = $this->db->query("SELECT * FROM `$table` WHERE doctor_id='{$id}'");

		$str = '';

			if($res->num_rows > 0){

				return $res->fetch_assoc();

		}

	}
	
public function doctor_login($username, $password,$remember) {

    $password = sha1($password);
	
    if($remember){
        $member = base64_encode(base64_encode($username));
        $fresh_log = base64_encode(base64_encode(base64_encode($password)));
        $hour = time() + 3600 * 24 * 30;
        setcookie("member",$member,$hour,"/");
        setcookie("fresh_log",$fresh_log,$hour,"/");
    }
    $res=  $this->db->query("SELECT * FROM `doctors` where  `phone_no` = '$username' AND `password` = '$password' AND `type` = 'Doctor' AND status != 'Suspended' ");
    if($res->num_rows > 0){
            
            $data = $res->fetch_assoc();
            if($data['status']=='Suspended'){
                
                return false;
            }
            session_start();
            $_SESSION['login_success'] = TRUE;
            $_SESSION['name'] = $data['name']; 
            $_SESSION['login_id'] = $data['id'];
            $_SESSION['email'] = $data['email'];
            $_SESSION['profile_image'] = $data['image'];
            $_SESSION['last_login_timestamp'] = time();
            $_SESSION['doc_details'] = $data;
            
            echo "<script> window.location.href='".base_url_doc."dashboard.php'; </script>";
    }
    else
    {
       return FALSE;
    }
}
	
public function patient_login($username, $password){
	    
        $password = sha1($password);
        $res=  $this->db->query("SELECT * FROM `patient` where  `phone_no` = '$username' AND `password` = '$password' ");
   
        if($res->num_rows > 0){
                session_start();
           
                $data = $res->fetch_assoc();
                $_SESSION['login_success'] = TRUE;
                $_SESSION['patient_name'] = $data['name']; 
                $_SESSION['patient_login_id'] = $data['id'];
                $_SESSION['patient_email'] = $data['email'];
                $_SESSION['patinet_profile_image'] = $data['image'];
                $_SESSION['patient_last_login_timestamp'] = time();
                $_SESSION['patient_details'] = $data;
                $_SESSION['patient_phone_no']=$data['phone_no'];
               // return TRUE;
                //header('Location: '.base_url_doc.'calender.php');
                echo "<script> window.location.href='".base_url_patient."dashboard.php'; </script>";
        }
        else
        {
           return FALSE;
        }
}    
	
public function getcategoryname($id){
	$result = $this->db->query("SELECT * FROM category where id='$id'");
		while($row=mysqli_fetch_assoc($result)) {
			$resultset[] = $row;
		}		
		if(!empty($resultset))
			return $resultset;
}    
public function getpractice($doc_id){
	$result = $this->db->query("SELECT * FROM practice where doctor_id='$doc_id'");
		while($row=mysqli_fetch_assoc($result)) {
			$resultset[] = $row;
		}		
		if(!empty($resultset))
			return $resultset;
}

public function getpractice_new($doc_id, $clinic_id){
	
    $sql = "SELECT * FROM practice where doctor_id='$doc_id' and clinic_id = '$clinic_id' ";
    $result = $this->db->query($sql);
	while($row=mysqli_fetch_assoc($result)) {
		$resultset[] = $row;
	}		
	if(!empty($resultset))
		return $resultset;
}

public function getpractice_first($doc_id){
	
    $sql = "SELECT * FROM practice where doctor_id='$doc_id' order by id ";
    $result = $this->db->query($sql);
	$var = 0;
	
	if($result->num_rows > 0)
	{
    	while($row = mysqli_fetch_assoc($result)) {
    		$sql1 = "select * from clinic where doctor_id = '$doc_id' order by id asc limit 1 ";
    		$query = $this->db->query($sql1);
    		
    		if($query->num_rows > 0 ){
    		    return $query->fetch_assoc();
    		}else{
		    	if($row['clinic_id'])
		    	{
    		    	$sql2 = "select * from clinic where id = ".$row['clinic_id']." order by id ";
    		        $query2 = $this->db->query($sql2);
        		    
        		    return $query2->fetch_assoc();
		    	}else{
		    	    return true;
		    	}    
    		}
    	}
    	
	}
	return true;
}

public function getcategoryid($category){
	$result = $this->db->query("SELECT * FROM category where category='$category'");
		while($row=mysqli_fetch_assoc($result)) {
			$resultset[] = $row;
		}		
		if(!empty($resultset))
			return $resultset;
}
public function consultation($city, $location, $type){

$result = $this->db->query("SELECT * FROM doctors where city='$city' and location='$location' and category='$type'");
		while($row=mysqli_fetch_assoc($result)) {
			$resultset[] = $row;
		}		
		if(!empty($resultset))
			return $resultset;

		
	}
	
public function consultation_nolocation($city, $type){

$result = $this->db->query("SELECT * FROM doctors where city='$city' and category='$type'");
		while($row=mysqli_fetch_assoc($result)) {
			$resultset[] = $row;
		}		
		if(!empty($resultset))
			return $resultset;

		
	}	
public function getdoctors($city, $location, $type, $page, $gender,$experience,$price,$day){

    $result = $this->db->query("SELECT DISTINCT district FROM `area_name` WHERE `pincode` = '$pincode' ");
    if($result->num_rows>0)
    {
        $rslt=$result->fetch_assoc();
    }
    $resultset=array();
    if($rslt["district"]==$city){
        
        if($location=='')
        {
      //      echo "condition1";
        	$docs = array();
        	$result = $this->db->query("SELECT * FROM doctors where  pincode='$pincode' and category='$type'");
        	    if($result->num_rows){
            		while($row=mysqli_fetch_assoc($result)) {
            			array_push($resultset,$row);
            			$docs[$row['id']]=1;
            		}
        	        
        	    }
        	for($i=5;$i>0;$i--){
        	$temp1 = $pincode - $i;
        	
        	$result = $this->db->query("SELECT * FROM doctors where  pincode='$temp1' and category='$type'");
        		if($result->num_rows){
            		while($row=mysqli_fetch_assoc($result)) {
            			if(!array_key_exists($row['id'],$docs)){
            			array_push($resultset,$row);
            			$docs[$row['id']]=1;
            			}
            		}
        		    
        		}
        	}
        	for($i=5;$i>0;$i--){
        	$temp1 = $pincode + $i;
        	
        	$result = $this->db->query("SELECT * FROM doctors where  pincode='$temp1' and category='$type'");
        		if($result->num_rows){
        		while($row=mysqli_fetch_assoc($result)) {
        			if(!array_key_exists($row['id'],$docs)){
        			array_push($resultset,$row);
        			$docs[$row['id']]=1;
        			}
        		}
        		    
        		}
        	}

        	if($city)
        	{
        //	    echo "condition2";
        		$result = $this->db->query("SELECT * FROM doctors where  city='$city' and category='$type'");
        		if($result->num_rows){
        		while($row=mysqli_fetch_assoc($result)) {
        			if(!array_key_exists($row['id'],$docs)){
        			array_push($resultset,$row);
        			$docs[(string)$row['id']]=1;
        			}
        		}
        		    
        		}
        	}
        }
        else{//echo "condition3";
        $result = $this->db->query("SELECT * FROM doctors where city='$city' and location='$location' and category='$type'");
                if($result->num_rows){
        		while($row=mysqli_fetch_assoc($result)) {
        			array_push($resultset,$row);
        		}}
        }
        
    }
    else
    {
       // $search = $search1 = '';
        $search =" and t1.status != 'Suspended' ";
        $search1 = " and t1.status != 'Suspended' ";
        $gender = ucwords($gender);
        if($gender != '' and $gender != 'All'){$search .= " and t1.gender = '$gender' ";}
        $experience_start = $experience-5;
        if($experience != '' and $experience > 0){$search .= " and t1.experience >= $experience_start and t1.experience <= ".$experience." ";}
        if($experience != '' && $experience == 0){$search .= " and t1.experience > 0 ";}

        if($price != '' or $day != 'all' and $day != '')
        {
            if($gender != '' and $gender != 'All'){$search1 .= " and t1.gender = '$gender' ";}
            if($experience != '' and $experience > 0){$search1 .= " and t1.experience >= $experience_start and t1.experience <= ".$experience." ";}
            if($experience != '' && $experience == 0){$search1 .= " and experience > 0 ";}
            if($location != ''){$search1 .= " and t1.city = '$city' and t1.category='$type' and t1.location = '$location' ";}else{
                $search1 .= " and t1.city = '$city' and t1.category='$type' ";
            }
            
            if($day == 'today' and $day != ''){
                //SELECT UNIX_TIMESTAMP(DATE_SUB(STR_TO_DATE(SUBSTRING_INDEX(`monday`, '-', 1),'%h:%i%p'),INTERVAL 19800 SECOND)) AS `memberfirst`, SUBSTRING_INDEX(`monday`, '-', -1) AS `memberlast` from practice
                //SELECT UNIX_TIMESTAMP(DATE_SUB(STR_TO_DATE('5:00PM', '%h:%i%p'),INTERVAL 19800 SECOND))
                
                $current_day = strtolower(date('l'));
                $current_day1 = $current_day.'1';
               //print $cur_time = strtotime(date('h:iA'));
                $today_search = " , UNIX_TIMESTAMP(DATE_SUB(STR_TO_DATE(SUBSTRING_INDEX(`$current_day`, '-', 1),'%h:%i%p'),INTERVAL 19800 SECOND)) AS `from`, UNIX_TIMESTAMP(DATE_SUB(STR_TO_DATE(SUBSTRING_INDEX(`$current_day`, '-', -1),'%h:%i%p'),INTERVAL 19800 SECOND)) AS `to` ";
                $today_search .= " , UNIX_TIMESTAMP(DATE_SUB(STR_TO_DATE(SUBSTRING_INDEX(`$current_day1`, '-', 1),'%h:%i%p'),INTERVAL 19800 SECOND)) AS `from1`, UNIX_TIMESTAMP(DATE_SUB(STR_TO_DATE(SUBSTRING_INDEX(`$current_day1`, '-', -1),'%h:%i%p'),INTERVAL 19800 SECOND)) AS `to1` ";
            
                $search1 .= " and t3.$current_day != ''  "; 
            }
            elseif($day != 'all' and $day != ''){
                $search1 .= " and t3.$day != '' ";
            }
            
            $price_val = explode('-',$price);
            $sql_price = "SELECT t1.* $today_search FROM `doctors` as t1 
                    left join practice as t3 
                    on t3.doctor_id = t1.id where t3.consult between ".$price_val[0]." and ".$price_val[1]." $search1  group by t1.id";
        }
        
        if($location)
        {
            //echo "condition4";
            if($price != ''){$sql = $sql_price;}else{$sql ="SELECT t1.* FROM doctors as t1 inner join practice as t2 on t1.id=t2.doctor_id where t1.city='$city' and t1.location='$location' and t1.category='$type' $search group by t1.id  ";}
            
            $result = $this->db->query($sql);
            if($result->num_rows){
        	while($row=mysqli_fetch_assoc($result)) {
    			array_push($resultset,$row);
    		}}
        }
        else
        {
             //echo "condition5";
            
            if($price != ''){$sql1 = $sql_price;}else{$sql1 = "SELECT t1.* FROM doctors as t1 inner join practice as t2 on t1.id=t2.doctor_id where t1.city='$city' and t1.category='$type' $search group by t1.id  ";}
            $result = $this->db->query($sql1);
            if($result->num_rows){
            	while($row=mysqli_fetch_assoc($result)) {
        			array_push($resultset,$row);
        		}
            }
        }
    }
    
	if(!empty($resultset))
		return $resultset;
}

public function getdoctors_bypage($city, $location, $type,$pincode,$page,$gender,$experience,$price,$day)
{
    $resultset=array();
    $start = ($page*10)-10;
    /*$result = $this->db->query("SELECT DISTINCT district FROM `area_name` WHERE `pincode` = '$pincode'");
    if($result->num_rows>0)
    {
      //  echo "got pin";
        $rslt=$result->fetch_assoc();
    }
    //echo $type;
    
     if($rslt["district"]==$city){
        
       
       if($location=='')
        {
      //      echo "condition1";
        	$docs = array();
        // 	$result = $this->db->query("SELECT * FROM doctors where  pincode='$pincode' and category='$type' LIMIT 10 OFFSET $start");
        // 	    if($result->num_rows){
        //     		while($row=mysqli_fetch_assoc($result)) {
        //     			array_push($resultset,$row);
        //     			$docs[$row['id']]=1;
        //     		}
        	        
        // 	    }
        // 	for($i=5;$i>0;$i--){
        // 	$temp1 = $pincode - $i;
        	
        // 	$result = $this->db->query("SELECT * FROM doctors where  pincode='$temp1' and category='$type' LIMIT 10 OFFSET $start");
        // 		if($result->num_rows){
        //     		while($row=mysqli_fetch_assoc($result)) {
        //     			if(!array_key_exists($row['id'],$docs)){
        //     			array_push($resultset,$row);
        //     			$docs[$row['id']]=1;
        //     			}
        //     		}
        		    
        // 		}
        // 	}
        // 	for($i=5;$i>0;$i--){
        // 	$temp1 = $pincode + $i;
        	
        // 	$result = $this->db->query("SELECT * FROM doctors where  pincode='$temp1' and category='$type' LIMIT 10 OFFSET $start");
        // 		if($result->num_rows){
        // 		while($row=mysqli_fetch_assoc($result)) {
        // 			if(!array_key_exists($row['id'],$docs)){
        // 			array_push($resultset,$row);
        // 			$docs[$row['id']]=1;
        // 			}
        // 		}
        		    
        // 		}
        // 	}
        	//print_r($docs);
        	if($city)
        	{
        //	    echo "condition2";
        		$result = $this->db->query("SELECT * FROM doctors where  city='$city' and category='$type' LIMIT 10 OFFSET $start");
        		if($result->num_rows){
        		while($row=mysqli_fetch_assoc($result)) {
        			if(!array_key_exists($row['id'],$docs)){
        			array_push($resultset,$row);
        			$docs[(string)$row['id']]=1;
        			}
        		}
        		    
        		}
        	}
        }
        else{//echo "condition3";
        $result = $this->db->query("SELECT * FROM doctors where city='$city' and location='$location' and category='$type' LIMIT 10 OFFSET $start");
                if($result->num_rows){
        		while($row=mysqli_fetch_assoc($result)) {
        			array_push($resultset,$row);
        		}}
        }
        
    }*/
    //$search ='';
    $search =" and t1.status != 'Suspended' ";
    $search1 = " and t1.status != 'Suspended' ";
    $gender = ucwords($gender);
    if($gender != '' and $gender != 'All'){$search .= " and t1.gender = '$gender' ";}
    $experience_start = $experience-5;
    if($experience != '' and $experience > 0){$search .= " and t1.experience >= $experience_start and t1.experience <= ".$experience." ";}
    if($experience != '' && is_numeric($experience) == 0){$search .= " and t1.experience > 0 ";}
    if($price != '' or $day != 'all' and $day != '')
    {
        if($gender != '' and $gender != 'All'){$search1 .= " and t1.gender = '$gender' ";}
        if($experience != '' and $experience > 0){$search1 .= " and t1.experience >= $experience_start and t1.experience <= ".$experience." ";}
        if($experience != '' && is_numeric($experience) == 0){$search .= " and experience > 0 ";}
        
        if($location != ''){$search1 .= " and t1.city = '$city' and t1.category='$type' and t1.location = '$location' ";}
        else{
            $search1 .= " and t1.city = '$city' and t1.category='$type' ";
        }
        
        if($day == 'today' and $day != ''){
                
            $current_day = strtolower(date('l'));
            $current_day1 = $current_day.'1';
           //print $cur_time = strtotime(date('h:iA'));
            $today_search = " , UNIX_TIMESTAMP(DATE_SUB(STR_TO_DATE(SUBSTRING_INDEX(`$current_day`, '-', 1),'%h:%i%p'),INTERVAL 19800 SECOND)) AS `from`, UNIX_TIMESTAMP(DATE_SUB(STR_TO_DATE(SUBSTRING_INDEX(`$current_day`, '-', -1),'%h:%i%p'),INTERVAL 19800 SECOND)) AS `to` ";
            $today_search .= " , UNIX_TIMESTAMP(DATE_SUB(STR_TO_DATE(SUBSTRING_INDEX(`$current_day1`, '-', 1),'%h:%i%p'),INTERVAL 19800 SECOND)) AS `from1`, UNIX_TIMESTAMP(DATE_SUB(STR_TO_DATE(SUBSTRING_INDEX(`$current_day1`, '-', -1),'%h:%i%p'),INTERVAL 19800 SECOND)) AS `to1` ";
        
            $search1 .= " and t3.$current_day != ''  "; 
        }
        elseif($day != 'all' and $day != ''){
            $search1 .= " and t3.$day != '' ";
        }
        $price_val = explode('-',$price);
        $sql_price = "SELECT t1.* $today_search FROM `doctors`  as t1 
                left join practice as t3 
                on t3.doctor_id = t1.id where t3.consult between ".$price_val[0]." and ".$price_val[1]." $search1  group by t1.id  LIMIT 10 OFFSET $start ";
    }
    
    if($location)
    {
        if($price != ''){$sql = $sql_price;}else{$sql = "SELECT t1.* FROM doctors as t1 inner join practice as t2 on t1.id=t2.doctor_id where t1.city='$city' and t1.location='$location' and t1.category='$type' $search group by t1.id  LIMIT 10 OFFSET $start";}
        $result = $this->db->query($sql);
        if($result->num_rows){
        	while($row=mysqli_fetch_assoc($result)) {
    			array_push($resultset,$row);
    		}
        }
    }
    
    elseif($location!='' && $type=='')
    {
        if($price != ''){$sql1 = $sql_price;}else{$sql1 = "SELECT t1.* FROM doctors as t1 inner join practice as t2 on t1.id=t2.doctor_id where t1.city='$city' and t1.location='$location' $search group by t1.id  LIMIT 10 OFFSET $start";}
        $result = $this->db->query($sql1);
        if($result->num_rows){
        	while($row=mysqli_fetch_assoc($result)) {
    			array_push($resultset,$row);
    		}
        }
    }
    else
    {
        if($price != ''){$sql = $sql_price;}else{$sql = "SELECT t1.* FROM doctors as t1 inner join practice as t2 on t1.id=t2.doctor_id where t1.city='$city' and t1.category='$type' $search group by t1.id  LIMIT 10 OFFSET $start";} 
        
        $result = $this->db->query($sql);
        if($result->num_rows){
        	while($row=mysqli_fetch_assoc($result)) {
    			array_push($resultset,$row);
    		}
        }
    }

	if(!empty($resultset))
		return $resultset;
}


public function getdoctorprofile($doc_id){

$result = $this->db->query("SELECT * FROM doctors where id='$doc_id'");
		while($row=mysqli_fetch_assoc($result)) {
			$resultset[] = $row;
		}		
		if(!empty($resultset))
			return $resultset;

		
	}
	
public function getclinicprofile($clinic_id){

$result = $this->db->query("SELECT * FROM clinic where id='$clinic_id'");
		while($row=mysqli_fetch_assoc($result)) {
			$resultset[] = $row;
		}		
		if(!empty($resultset))
			return $resultset;

		
	}	
public function sortmale($city,$location,$type){

$result = $this->db->query("SELECT * FROM doctors where city='$city' and location='$location' and category='$type' and gender='Male'");
		while($row=mysqli_fetch_assoc($result)) {
			$resultset[] = $row;
		}		
		if(!empty($resultset))
			return $resultset;

		
	}
	
public function sortmale_nolocation($city,$type){

$result = $this->db->query("SELECT * FROM doctors where city='$city'and category='$type' and gender='Male'");
		while($row=mysqli_fetch_assoc($result)) {
			$resultset[] = $row;
		}		
		if(!empty($resultset))
			return $resultset;

		
	}	

public function experience($city,$location,$type){

$result = $this->db->query("SELECT * FROM doctors where city='$city' and location='$location' and category='$type'");
		while($row=mysqli_fetch_assoc($result)) {
			$resultset[] = $row;
		}		
		if(!empty($resultset))
			return $resultset;

		
	}
	
public function experience_nolocation($city,$type){

$result = $this->db->query("SELECT * FROM doctors where city='$city' and category='$type'");
		while($row=mysqli_fetch_assoc($result)) {
			$resultset[] = $row;
		}		
		if(!empty($resultset))
			return $resultset;

		
	}	
public function sortfemale($city,$location,$type){

$result = $this->db->query("SELECT * FROM doctors where city='$city' and location='$location' and category='$type' and gender='Female'");
		while($row=mysqli_fetch_assoc($result)) {
			$resultset[] = $row;
		}		
		if(!empty($resultset))
			return $resultset;

		
	}
	
public function sortfemale_nolocation($city,$type){

$result = $this->db->query("SELECT * FROM doctors where city='$city'and category='$type' and gender='Female'");
		while($row=mysqli_fetch_assoc($result)) {
			$resultset[] = $row;
		}		
		if(!empty($resultset))
			return $resultset;

		
	}	

public function getdoctorsbycategory($city, $type){

$result = $this->db->query("SELECT * FROM doctors where city='$city' and category='$type'");
		while($row=mysqli_fetch_assoc($result)) {
			$resultset[] = $row;
		}		
		if(!empty($resultset))
			return $resultset;

		
	}

public function allow_for($clinic_id,$doc_id){
    
    $res = $this->db->query("select allow from practice where doctor_id='$doc_id' and clinic_id='$clinic_id'");
    if($res->num_rows > 0){
        $data = $res->fetch_assoc();
        return $data['allow'];
    }
    return false;
}	

public function get_doctors_by_clinicid($clinic_id){
    
    $res = $this->db->query("select secondary_doctor from clinic where id='$clinic_id'");
    if($res->num_rows > 0){
        
        while($data=$res->fetch_assoc()){
            $result = json_decode($data['secondary_doctor'],true);
            foreach($result as $value){
                
                $res1 = $this->db->query("select be_name,image,name,specialization from doctors where id='$value' and status!='Suspended'");
                if($res1->num_rows > 0){
                    while($data1=$res1->fetch_assoc()){
                        //print_r($data1['specialization']);
                        $spec = json_decode($data1['specialization'],true);
                        foreach($spec as $key=>$sp1)
    			{
    				if($key==0){
    					$doc_specliaztion = $sp1['specialization'];
    					if(is_numeric($doc_specliaztion)){
    		    			$doc_specliaztion_l = $this->get_data_by_id($doc_specliaztion, $table = 'speciality', $field = 'specialization');
    		    			$doc_specliaztion = $doc_specliaztion_l[0];
    					}else{
    					    $doc_specliaztion = $doc_specliaztion;
    					}	
    				}	
    			}
                        //print_r ($spec);
                        $doc_info[] = array("id"=>$value,"be_name"=>$data1['be_name'],"name"=>$data1['name'],"image"=>$data1['image'],"doc_id"=>$value,"speciality"=>$doc_specliaztion);
                    }
                }
            }
        }
    }
    return $doc_info;
}

public function get_clinic_by_doctorid($doc_id){
    $resultset=array();
    $res = $this->db->query("select clinic from doctors where id='$doc_id'");
    while($data=$res->fetch_assoc()){
        
        $clinic = json_decode($data['clinic'],true);
    }
        
    foreach($clinic as $clinic_id){
        $clinc_id = $clinic_id['clinic_id'];
        $result = $this->db->query("SELECT * FROM clinic where id='$clinc_id'");
		while($row=mysqli_fetch_assoc($result)) {
			$resultset[] = $row;
		    }		
		
			
        }
           
    return $resultset;
}
public function get_sec_clinic_by_doctorid($doc_id)
{
    $result = $this->db->query("SELECT * FROM doctors where id='$doc_id'");
		while($row=mysqli_fetch_assoc($result)) {
			$resultset[] = $row;
		}		
		if(!empty($resultset))
			return $resultset;

}
public function get_sec_clinic_details($scid){
     $result = $this->db->query("SELECT * FROM clinic where id='$scid'");
		while($row=mysqli_fetch_assoc($result)) {
			$resultset[] = $row;
		}		
		if(!empty($resultset))
			return $resultset;
}
public function getslotby_clinicid($doc_id,$clinic_id,$date){
    
    $result = $this->db->query("SELECT * FROM practice where doctor_id='$doc_id' and clinic_id='$clinic_id'");
		while($row=mysqli_fetch_assoc($result)) {
			$resultset[] = $row;
		}		
		if(!empty($resultset))
			return $resultset;
    
}
public function getappointment_slot($doc_id,$date){
    
   
    $result = $this->db->query("SELECT app_time,app_date FROM appointments where doctor_id='$doc_id' and app_date='$date' and status!='Cancel' ");
		while($row=mysqli_fetch_assoc($result)) {
			$resultset[] = $row;
		}
		
		if(!empty($resultset))
			return $resultset;
}
public function check_existing_user($phone){
    $result = $this->db->query("SELECT * FROM patient where phone_no='$phone' and id=parent_id and parent_id>0");
		while($row=mysqli_fetch_assoc($result)) {
			$resultset[] = $row;
		}		
		if(!empty($resultset))
			return $resultset;
}
public function get_patient_id()
{
	$res=$this->db->query("select * from patient order by patient_id DESC Limit 1");

	if(@$res->num_rows>0)
	{
		$data=$res->fetch_assoc();
		return $data['patient_id'];
	}
}
public function search_child_accounts($parent_id){
    $result = $this->db->query("SELECT * FROM patient where parent_id='$parent_id' and parent_id>0");
		while($row=mysqli_fetch_assoc($result)) {
			$resultset[] = $row;
		}		
		if(!empty($resultset))
			return $resultset;
}

public function get_patient_details($patient_id,$parent){
    $result = $this->db->query("SELECT * FROM patient where id='$patient_id' and parent_id='$parent' ");
		while($row=mysqli_fetch_assoc($result)) {
			$resultset[] = $row;
		}		
		if(!empty($resultset)) 
		    return $resultset;
}

 public function randomCode($length) {

                    $key = '';

                    $keys = array_merge(range(0, 9), range('a', 'z'), range('A', 'Z'));



                    for ($i = 0; $i < $length; $i++) {

                    $key .= $keys[array_rand($keys)];

                    }

                    return $key;

    }

	public function randomCodeNum($length) {

                    $key = '';

                    $keys = array_merge(range(0, 9));

                    for ($i = 0; $i < $length; $i++) {

                    $key .= $keys[array_rand($keys)];

                    }

                    return $key;

    }

	public function signup_otp($phone_no) {

                    $ren=$this->randomCode(10);
	$verification_pin = $this->randomCodeNum(6);
	$sms = 'Your Docconsult.in Verification OTP '.$verification_pin;
		$sms = str_replace("<", "", $sms);
		 $sms = str_replace(">", "", $sms);
		 $sms = rawurlencode($sms);
     //$send_sms_url = 'http://www.sms.jprinfotech.com/api/sendhttp.php?authkey=4296AbkgvkyLHP2b584bb4a2&mobiles='.$phone_no.'&message='.$sms.'&sender='.sender_id.'&route=4';
     //$send_sms_url='http://login.cheapsmsbazaar.com/vendorsms/pushsms.aspx?user=docconsult&password=aks120109&msisdn='.$phone_no.'&sid='.sender_id.'&msg='.$sms.'&fl=0&gwid=2';
       $send_sms_url='http://sms.digialaya.com/API/SMSHttp.aspx?UserId=docconsultadmin&pwd=pwd2017&Message='.$sms.'&Contacts='.$phone_no.'&SenderId=DOCCON&ServiceName=SMSTRANS&StartTime=';
     $send_sms_url = str_replace(" ", "%20", $send_sms_url);
     
     $ch = curl_init();
     $timeout = 5;
     curl_setopt($ch, CURLOPT_URL, $send_sms_url);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
     curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
     curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
     curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
     curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
     $data = curl_exec($ch);
     curl_close($ch);
     return $verification_pin;

    }
    
public function signup_patient($name,$em,$phone,$city,$state,$country,$gen,$dob,$pass){
    $date = date("Y-m-d");
    $check = $this->db->query("select * from patient where phone_no = '$phone'");
    if($check->num_rows==0){
        
    
    $pass = sha1($pass);
    
    $res2 = $this->db->query("select MAX(patient_id) as patient_max_id from patient");
    
    
    
    $data2 = $res2->fetch_assoc();
    $patient_id=$data2['patient_max_id']+1;
    
    $res = $this->db->query("insert into patient(dob,patient_id,name,email,password,phone_no,city,state,country,gender,date) values('$dob','$patient_id','$name','$em','$pass','$phone','$city','$state','$country','$gen','$date')");
    $res3 = $this->db->query("select max(id) as max_id from patient");
    $data3 = $res3->fetch_assoc();
    $id = $data3['max_id'];
    $this->db->query("update patient set parent_id = '$id' where id = '$id' ");
    if($res){
		
		$msg.='<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: linear-gradient(to right, #2D9CDB, #2F5894);">
	<tr>
		<td></td>
		<td class="header container">
			<div style="max-width: 630px;    margin: 0 auto;    display: block;">
			<table>
				<tr>
					<td><a href="'.base_url.'"><img src="'.base_url.'/image/logo.png" alt="logo" ></a></td>
				</tr>
			</table>
			</div>
		</td>
		<td></td>
	</tr>
</table>

<!---content demo -->
<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: #f5f5fa; ">
	<tr>
		<td></td>
		<td class="header container">
			<div style="max-width: 600px;    margin: 0 auto;    display: block;">
			<table>
					<tr>
						<td>
						<br>
							<h3>Dear, '.$tag.$name.'</h3>
							<h3>Welcome To <a href="'.base_url.'">DocConsult</a></h3>
							<p class="lead">You have successfully created your account with us.</p><br><br>
							<p class="lead">Regards,</br>
							Team Docconsult</p>
						</td>
					</tr>
				</table>
			</div>			
		</td>
		<td></td>
	</tr>
</table>
<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: linear-gradient(to right, #2D9CDB, #2F5894);">
	<tr>
		<td></td>
		<td class="header container">
			
			<div style="max-width: 630px;    margin: 0 auto;    display: block;">
			<table>
				<tr>
					<td>
                   <a href="'.base_url.'"><img src="'.base_url.'/image/logo.png" alt="logo" ></a>
					<p style="  font-size: 12px;     margin: 2px 10px;  color:#fff;">Contact NO : <strong> 0141-2785199</strong></p>
					<p style="  font-size: 12px;      margin: 2px 10px;  color:#fff;">Email: <strong><a href="emailto:service@docconsult.in" style="color:#fff;">service@docconsult.in</a></strong></p>
					<p style="   font-size: 12px;     margin: 2px 10px;  color:#fff;">Copyright © 2017 DocConsult | All Right Reserved 2016</p>	</td>
					
					<p style="float: right; text-align: right; margin-right: 0px; margin-top: 60px;">
                                                        <a href="https://www.facebook.com/docconsult/"><img src="'.base_url.'image/F.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a> 
                                                        <a href="https://twitter.com/Docconsult12"><img src="'.base_url.'image/T.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a>
                                                        <a href="https://www.youtube.com/channel/UCroHJE8lYtX3Wz9j233Dtwg"><img src="'.base_url.'image/Y.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a>
                                                        <a href="https://www.instagram.com/docconsultservices/"><img src="'.base_url.'image/I.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a> 
                                                        <a href="https://www.linkedin.com/in/docconsult-services-a70a72134/"><img src="'.base_url.'image/L.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a></br>
                                                        </p></td>
				</tr>
			</table>
			</div>
			
		</td>
		<td></td>
	</tr>
</table>';
		
        
       /* $msg = '<div style="width:100%; height:100%; margin:0;" >

	<div style="width:90%; float:left; height:70px;padding:30px;">

		<span style="width:50%;float:left"> <a href="https://docconsult.in"><img src="https://docconsult.in/image/logo.png"  style="height:70px"/></span></a>

		<span style="width:50%; text-align:right;float:left;font-size: 17px;">  <br /><b> </span>

	</div>

	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">'.$tag.$name.', <br></div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Welcome To docconsult.in</div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">You have successfully created your account with us. </div>
	
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Thank You</div>';*/
	
	
	$msg_admin ='<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: linear-gradient(to right, #2D9CDB, #2F5894);">
	<tr>
		<td></td>
		<td class="header container">
			
			<div style="max-width: 650px;    margin: 0 auto;    display: block;">
		<a href="'.base_url.'"><img src="'.base_url.'/image/logo.png" alt="logo" ></a>
			</div>
			
		</td>
		<td></td>
	</tr>
</table>

<!---content demo -->
<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: #f5f5fa; ">
	<tr>
		<td></td>
		<td class="header container">
			
			<div style="max-width: 630px;    margin: 0 auto;    display: block;">
			<table>
					<tr>
						<td>
						<br>
							<h3>Hello , Admin </h3>
							<p class="lead">New Patient Create An account in <a href="'.base_url.'">DocConsult</a></p>
						</td>
					</tr>
				</table>
			</div>			
		</td>
		<td></td>
	</tr>
</table>
<!---content demo End-->
<table class="head-wrap" style="width: 650px;    background: #f5f5fa;    margin: 0 auto; ">
	<tr>
		<td></td>
		<td class="header container">
			<div style="max-width: 630px;    margin: 0 auto;    display: block;">
				<table>
                      <tr>
                       <td style="border-bottom: 1px dashed #777777; width: 100%;">
                     <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;   min-width: 180px; font-weight: bold;   text-align: left;  float:left;">Patient Name :
                    </span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;     "><a href="https://www.docconsult.in/?id = '.$id.'">'.$name.'</a></span>
                    </td>
                        
                      </tr>
                       <tr>
                       <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
                       <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;  min-width: 180px;font-weight: bold;   text-align: left;   float:left;">Email:
                    </span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;      ">'.$em.'</span></td>
                        
                      </tr>
                      <tr>
                       <td style="border-bottom: 1px dashed #777777; width: 100%;">
                       <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;min-width: 180px; font-weight: bold;   text-align: left;  float:left;">Mobile No :

                    </span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;    ">'.$phone. '</span></td>
                        
                      </tr>
                      
                      
                      <tr>
                       <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
                       <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;  min-width: 180px;font-weight: bold;   text-align: left;   float:left;">Date of Birth :
                    </span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;      ">'.$dob.'</span></td>
                        
                      </tr>
                      <tr>
                       <td style="border-bottom: 1px dashed #777777; width: 100%;">
                       <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;min-width: 180px; font-weight: bold;   text-align: left;  float:left;">Gender :

                    </span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;    ">'.$gen. '</span></td>
                        
                      </tr>
                      
                      
                       <tr>
                       <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
                       <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;   min-width: 180px; font-weight: bold;  text-align: left;   float:left;">City:

                    </span><span style="text-decoration: none; color: #666;  padding: 10px 0;      text-align: center;     ">'.$city.'</span></td>
                        
                      </tr>
					<tr>	
						<td></td><td></td>
					</tr>
				</table>
			</div>
		
			<div  style="max-width: 630px;     margin: 0 auto;    display: block;">
				<table>
					<tr>
						<td>
						
						    <h4>Thank You </h4>
							
						</td>
						</tr>
					
					
						<td></td>
					</tr>
				</table>
			</div>
		</td>
		<td></td>		<!---Footer End--->
	</tr>	
</table>

<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: linear-gradient(to right, #2D9CDB, #2F5894);">
	<tr>
		<td></td>
		<td class="header container">
			
			<div style="max-width: 630px;    margin: 0 auto;    display: block;">
			<table>
				<tr>
					<td>
                    <a href="'.base_url.'"><img src="'.base_url.'/image/logo.png" alt="logo" ></a>
                    <p style="  font-size: 12px;     margin: 2px 10px;  color:#fff;">Contact NO : <strong> 0141-2785199</strong></p>
                    <p style="  font-size: 12px;      margin: 2px 10px;  color:#fff;">Email: <strong><a href="emailto:service@docconsult.in" style="color:#fff;">service@docconsult.in</a></strong></p>
                    <p style="   font-size: 12px;     margin: 2px 10px;  color:#fff;">Copyright © 2017 DocConsult | All Right Reserved 2016</p> </td>
                    
                    <td style="text-align: right;    width: 50%;">
                    <p style="float: right; text-align: right; margin-right: 0px; margin-top: 60px;">
                                                        <a href="https://www.facebook.com/docconsult/"><img src="'.base_url.'image/F.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a> 
                                                        <a href="https://twitter.com/Docconsult12"><img src="'.base_url.'image/T.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a>
                                                        <a href="https://www.youtube.com/channel/UCroHJE8lYtX3Wz9j233Dtwg"><img src="'.base_url.'image/Y.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a>
                                                        <a href="https://www.instagram.com/docconsultservices/"><img src="'.base_url.'image/I.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a> 
                                                        <a href="https://www.linkedin.com/in/docconsult-services-a70a72134/"><img src="'.base_url.'image/L.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a></br>
                                                        </p></td>
				</tr>
			</table>
			</div>
			
		</td>
		<td></td>
	</tr>
</table>';
	
/*	$msg_admin = '<div style="width:100%; height:100%; margin:0;" >

	<div style="width:90%; float:left; height:70px;padding:30px;">

		<span style="width:50%;float:left"> <a href="https://docconsult.in"><img src="https://docconsult.in/image/logo.png"  style="height:70px"/></span></a>

		<span style="width:50%; text-align:right;float:left;font-size: 17px;">  <br /><b> </span>

	</div>

	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Name: '.$name.', <br></div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Mobile no: '.$phone. '</div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Email: '.$em.', <br></div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">City:'.$city.', <br></div>
    <div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Have successfully created his/her Patient account with us. </div>';*/
	
  
    $this->foremail($em,$msg,'kavitajha.docconsult@gmail.com','Docconsult appointment');
	$this->foremail('kavitajha.docconsult@gmail.com',$msg_admin,'kavitajha.docconsult@gmail.com','New Appointment');
  
  
        //$this->foremail($em,$msg,'service@docconsult.in','SignUp With Docconsult');
     //  $this->foremail('info@docconsult.in',$msg_admin,'service@docconsult.in','New SignUp of Patient');
        
        $msg_prefix = ' successfully done on Docconsult with mobile number '.$phone ;
        $sms = 'Hi '.$name.' Your signup has been '.$msg_prefix.' you can login here '.base_url;
		$sms = str_replace("<", "", $sms);
		 $sms = str_replace(">", "", $sms);
		 $sms = rawurlencode($sms);
     //$send_sms_url = 'http://www.sms.jprinfotech.com/api/sendhttp.php?authkey=4296AbkgvkyLHP2b584bb4a2&mobiles='.$phone_no.'&message='.$sms.'&sender='.sender_id.'&route=4';
     //$send_sms_url='http://login.cheapsmsbazaar.com/vendorsms/pushsms.aspx?user=docconsult&password=aks120109&msisdn='.$phone_no.'&sid='.sender_id.'&msg='.$sms.'&fl=0&gwid=2';
     $send_sms_url='http://sms.digialaya.com/API/SMSHttp.aspx?UserId=docconsultadmin&pwd=pwd2017&Message='.$sms.'&Contacts='.$phone.'&SenderId=DOCCON&ServiceName=SMSTRANS&StartTime=';
     $send_sms_url = str_replace(" ", "%20", $send_sms_url);
     
     $ch = curl_init();
     $timeout = 5;
     curl_setopt($ch, CURLOPT_URL, $send_sms_url);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
     curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
     curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
     curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
     curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
     $data = curl_exec($ch);
     curl_close($ch);
     
     return TRUE;   
    }
}  

else{
    $mssge = "User Already Exist";
    return $mssge;
    
}
}    

public function signup_doc($tag,$spec,$name,$em,$phone,$city,$state,$country,$gen,$dob,$pass){

	$date_create = date("Y-m-d h:i:s");

    $check = $this->db->query("select * from doctors where phone_no = '$phone'");
    $cat = $this->db->query("select id from category where category='$spec'");
    if($cat->num_rows>0){
        $cat_id = $cat->fetch_assoc();
        $cat=$cat_id['id'];
    }
    if($check->num_rows==0){
        
    $pass=sha1($pass);
    $specs[] = array("specialization"=>$spec); 
    $specs1 = json_encode($specs);
    
    $type="doctor";
    
    if($gen == 'Male'){$doc_img = "Doctor_male.png";}elseif($gen == 'Female'){$doc_img = "Doctor_female.png";}
    
	
	$res = $this->db->query("insert into doctors (type,be_name,dob,name,email,password,phone_no,city,state,country,gender,specialization,category,date_creation,image) values('$type','$tag','$dob','$name','$em','$pass','$phone','$city','$state','$country','$gen','$specs1','$cat','$date_create','$doc_img')");
    if($res){
        
    
    $blog_pass=md5($pass);
    $blog_date=date("Y-m-d H:i:s");
    $res2=$this->db_blog->query("insert into wp_users(user_login,user_pass,user_nicename,user_email,user_registered,user_status,display_name) values('$phone','$blog_pass','$phone','$em','$blog_date','0','$name')");
    $id_blog1 = $this->db_blog->query("select * from wp_users where user_login='$phone'");
    $id_blog = $id_blog1->fetch_assoc();
    $id_blog=$id_blog['ID'];
    $meta_value='a:1:{s:6:"author";b:1;}';
    $res1=$this->db_blog->query("insert into wp_usermeta(user_id,meta_key,meta_value) values('$id_blog','wp_capabilities','$meta_value')");
    if($res1){
        
        
        
		$msg.='<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: linear-gradient(to right, #2D9CDB, #2F5894);">
		<tr>
			<td></td>
			<td class="header container">
				
				<div style="max-width: 630px;    margin: 0 auto;    display: block;">
				<table>
					<tr>
						<td><a href="'.base_url.'"><img src="'.base_url.'/image/logo.png" alt="logo" ></a></td>
					</tr>
				</table>
				</div>
				
			</td>
			<td></td>
		</tr>
	</table>
	
	<!---content demo -->
	<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: #f5f5fa; ">
		<tr>
			<td></td>
			<td class="header container">
				
				<div style="max-width: 600px;    margin: 0 auto;    display: block;">
				<table>
						<tr>
							<td>
							<br>
								<h3>Dear, '.$tag.$name.'</h3>
								<h3>Welcome To <a href="'.base_url.'">DocConsult</a></h3>

								<p class="lead">You have successfully created your account with us.</p>

                                 <h4>Thank You For Using DocConsult.</h4>

								<p class="lead">Regards,</p>
                            <p class="lead">Docconsult Team</p>	
							</td>
						</tr>
					</table>
				</div>			
			</td>
			<td></td>
		</tr>
	</table>	
	<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: linear-gradient(to right, #2D9CDB, #2F5894);">
    <tr>
        <td></td>
        <td class="header container">
            
            <div style="max-width: 630px;    margin: 0 auto;    display: block;">
            <table>
                <tr>
                    <td>
                   <a href="'.base_url.'"><img src="'.base_url.'/image/logo.png" alt="logo" ></a>
                    <p style="  font-size: 12px;     margin: 2px 10px;  color:#fff;">Contact NO : <strong> 0141-2785199</strong></p>
                    <p style="  font-size: 12px;      margin: 2px 10px;  color:#fff;">Email: <strong><a href="emailto:service@docconsult.in" style="color:#fff;">service@docconsult.in</a></strong></p>
                    <p style="   font-size: 12px;     margin: 2px 10px;  color:#fff;">Copyright © 2017 DocConsult | All Right Reserved 2016</p> </td>
                    
                    <td style="text-align: right;    width: 50%;">
                    <p style="float: right; text-align: right; margin-right: 0px; margin-top: 60px;">
                                                        <a href="https://www.facebook.com/docconsult/"><img src="'.base_url.'image/F.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a> 
                                                        <a href="https://twitter.com/Docconsult12"><img src="'.base_url.'image/T.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a>
                                                        <a href="https://www.youtube.com/channel/UCroHJE8lYtX3Wz9j233Dtwg"><img src="'.base_url.'image/Y.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a>
                                                        <a href="https://www.instagram.com/docconsultservices/"><img src="'.base_url.'image/I.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a> 
                                                        <a href="https://www.linkedin.com/in/docconsult-services-a70a72134/"><img src="'.base_url.'image/L.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a></br>
                                                        </p></td>
                </tr>
            </table>
            </div>
            
        </td>
        <td></td>
    </tr>
</table>';
	require_once("phpmailer/PHPMailerAutoload.php");
	
	$mail = new PHPMailer();
	$mailhost = mailhost;
	$smtpUser = smtpUser;
	$smtpPassword = smtpPassword;
	
	$subject = 'SignUp With DocConsult';
	$from = "service@docconsult.in";
	$mail->IsSMTP();
	$mail->Host = $mailhost;
	$mail->SMTPAuth = true;
	$mail->Username = $smtpUser;
	
	$mail->Password = $smtpPassword;
	
	//$mail->SMTPSecure = "ssl";  //ssl or tls
	$mail->Port = 587; // 25 or 465 or 587
	$mail->From = $from;
	$mail->FromName = $name;
	$mail->AddReplyTo($from);
	$mail->AddAddress($em);
	$mail->IsHTML(true);
	$mail->Subject = $subject;
	$mail->Body = $msg;
	if($mail->Send())
	{
		//print 'OK mail Sent !!!';
	}	
	//$this->foremail($em,$msg,'service@docconsult.in','SignUp With Docconsult');		
			
		   /* $msg = '<div style="width:100%; height:100%; margin:0;" >
	
		<div style="width:90%; float:left; height:70px;padding:30px;">
	
			<span style="width:50%;float:left"> <a href="https://docconsult.in"><img src="https://docconsult.in/image/logo.png"  style="height:70px"/></span></a>
	
			<span style="width:50%; text-align:right;float:left;font-size: 17px;">  <br /><b> </span>
	
		</div>
	
		<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">'.$tag.$name.', <br></div>
		<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Welcome To docconsult.in</div>
		<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">You have successfully created your account with us. </div>
		
		<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Thank You</div>';*/
		
		
		
			$msg_admin ='<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: linear-gradient(to right, #2D9CDB, #2F5894);">
		<tr>
			<td></td>
			<td class="header container">
				
				<div style="max-width: 650px;    margin: 0 auto;    display: block;">
		<a href="'.base_url.'"><img src="'.base_url.'/image/logo.png" alt="logo" ></a>
				</div>
				
			</td>
			<td></td>
		</tr>
	</table>
	
	<!---content demo -->
	<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: #f5f5fa; ">
		<tr>
			<td></td>
			<td class="header container">
				
				<div style="max-width: 630px;    margin: 0 auto;    display: block;">
				<table>
						<tr>
							<td>
							<br>
								<h3>Hello, Admin </h3>
								<p class="lead">New Doctor Create An Account in <a href="https://www.docconsult.in/">Docconsult.in</a></p>
							</td>
						</tr>
					</table>
				</div>			
			</td>
			<td></td>
		</tr>
	</table>
	<!---content demo End-->
	<table class="head-wrap" style="width: 650px;    background: #f5f5fa;    margin: 0 auto; ">
		<tr>
			<td></td>
			<td class="header container">
				
				<!-- content -->
				<div style="max-width: 630px;    margin: 0 auto;    display: block;">
					<table>
	  <tr>
	   <td style="border-bottom: 1px dashed #777777; width: 100%;">
	 <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;   min-width: 180px; font-weight: bold;   text-align: left;  float:left;">Patient Name :
	</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;text-transform:capitalize">'.$tag.$name.'</span>
	</td>
		
	  </tr>
	   <tr>
	   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
	   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;  min-width: 180px;font-weight: bold;   text-align: left;   float:left;">Email:
	</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;      ">'.$em.'</span></td>
		
	  </tr>
	  <tr>
	   <td style="border-bottom: 1px dashed #777777; width: 100%;">
	   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;min-width: 180px; font-weight: bold;   text-align: left;  float:left;">Mobile No :
	
	</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;    ">'.$phone.'</span></td>
		
	  </tr>
	  
	  <tr>
	   <td style="border-bottom: 1px dashed #777777; width: 100%;">
	   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;min-width: 180px; font-weight: bold;   text-align: left;  float:left;">Gender
	
	</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;    ">'.$gen. '</span></td>
		
	  </tr>
	  
	   <tr>
	   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
	   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;   min-width: 180px; font-weight: bold;  text-align: left;   float:left;">City:
	
	</span><span style="text-decoration: none; color: #666;  padding: 10px 0;      text-align: center;     ">'.$city.'</span></td>
		
	  </tr>
	  
	  
				
						<tr>	
							<td></td><td></td>
						</tr>
					</table>
				</div>
				<!-- COLUMN WRAP -->
				
				<div  style="max-width: 630px;     margin: 0 auto;    display: block;">
					<table>
						<tr>
							<td>
								<p class="lead">Have successfully created his/her Doctor account with us.</p>
								 <h4>Thank You </h4>
								
								
							</td>
							</tr>
						
						
							<td></td>
						</tr>
					</table>
				</div>
			</td>
			<td></td>		<!---Footer End--->
		</tr>	
	</table>
	
	<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: linear-gradient(to right, #2D9CDB, #2F5894);">
    <tr>
        <td></td>
        <td class="header container">
            
            <div style="max-width: 630px;    margin: 0 auto;    display: block;">
            <table>
                <tr>
                    <td>
                  <a href="'.base_url.'"><img src="'.base_url.'/image/logo.png" alt="logo" ></a>
                    <p style="  font-size: 12px;     margin: 2px 10px;  color:#fff;">Contact NO : <strong> 0141-2785199</strong></p>
                    <p style="  font-size: 12px;      margin: 2px 10px;  color:#fff;">Email: <strong><a href="emailto:service@docconsult.in" style="color:#fff;">service@docconsult.in</a></strong></p>
                    <p style="   font-size: 12px;     margin: 2px 10px;  color:#fff;">Copyright © 2017 DocConsult | All Right Reserved 2016</p> </td>
                    
                    <td style="text-align: right;    width: 50%;">
                    <p style="float: right; text-align: right; margin-right: 0px; margin-top: 60px;">
                                                        <a href="https://www.facebook.com/docconsult/"><img src="'.base_url.'image/F.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a> 
                                                        <a href="https://twitter.com/Docconsult12"><img src="'.base_url.'image/T.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a>
                                                        <a href="https://www.youtube.com/channel/UCroHJE8lYtX3Wz9j233Dtwg"><img src="'.base_url.'image/Y.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a>
                                                        <a href="https://www.instagram.com/docconsultservices/"><img src="'.base_url.'image/I.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a> 
                                                        <a href="https://www.linkedin.com/in/docconsult-services-a70a72134/"><img src="'.base_url.'image/L.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a></br>
                                                        </p></td>
                </tr>
            </table>
            </div>
            
        </td>
        <td></td>
    </tr>
</table>';



	$mail_1 = new PHPMailer();
	$name = "Doc Consult";
	$subject = 'New SignUp of doctor';
	$from = "service@docconsult.in";
	$mail_1->IsSMTP();
	$mail_1->Host = $mailhost;
	$mail_1->SMTPAuth = true;
	$mail_1->Username = $smtpUser;
	$mail_1->Password = $smtpPassword;
	//$mail->SMTPSecure = "ssl";  //ssl or tls
	$mail_1->Port = 587; // 25 or 465 or 587
	$mail_1->From = $from;
	
	$mail_1->FromName = $name;
	$mail_1->AddReplyTo($from);
	$mail_1->AddAddress("info@docconsult.in");
	$mail_1->IsHTML(true);
	$mail_1->Subject = $subject;
	$mail_1->Body = $msg_admin;
	if($mail_1->Send())
	{
		//print "2 Mail Sent";
	}else{
		//echo 'Not Sent';
	}
	//$this->foremail('info@docconsult.in',$msg_admin,'service@docconsult.in','New SignUp of doctor');	
		/*	$msg_admin = '<div style="width:100%; height:100%; margin:0;" >
	
		<div style="width:90%; float:left; height:70px;padding:30px;">
	
			<span style="width:50%;float:left"> <a href="https://docconsult.in"><img src="https://docconsult.in/image/logo.png"  style="height:70px"/></span></a>
	
			<span style="width:50%; text-align:right;float:left;font-size: 17px;">  <br /><b> </span>
	
		</div>
	
		<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Name: '.$tag.$name.', <br></div>
		<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Mobile no :'.$phone. '</div>
		<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Have successfully created his/her Doctor account with us. </div>';*/
			
			$msg_prefix = ' successfully done on Docconsult with mobile number '.$phone;
			$sms = 'Hi '.$tag.$name.' Your signup has been '.$msg_prefix.' you can login here '.base_url;
			$sms = str_replace("<", "", $sms);
			 $sms = str_replace(">", "", $sms);
			 $sms = rawurlencode($sms);
		 //$send_sms_url = 'http://www.sms.jprinfotech.com/api/sendhttp.php?authkey=4296AbkgvkyLHP2b584bb4a2&mobiles='.$phone_no.'&message='.$sms.'&sender='.sender_id.'&route=4';
		 //$send_sms_url='http://login.cheapsmsbazaar.com/vendorsms/pushsms.aspx?user=docconsult&password=aks120109&msisdn='.$phone_no.'&sid='.sender_id.'&msg='.$sms.'&fl=0&gwid=2';
		   $send_sms_url='http://sms.digialaya.com/API/SMSHttp.aspx?UserId=docconsultadmin&pwd=pwd2017&Message='.$sms.'&Contacts='.$phone.'&SenderId=DOCCON&ServiceName=SMSTRANS&StartTime=';
		 $send_sms_url = str_replace(" ", "%20", $send_sms_url);
		 
		 $ch = curl_init();
		 $timeout = 5;
		 curl_setopt($ch, CURLOPT_URL, $send_sms_url);
		 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		 curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
		 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
		 curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
		 curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		 curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		 $data = curl_exec($ch);
		 curl_close($ch);
        
        
        return TRUE;
    	}
    }
}  

else{
    return false;
    
}
}
public function check_existing_number($phone_no){
    
    
    $res = $this->db->query("SELECT * FROM doctors where phone_no = '$phone_no'");
    
    //return $res->num_rows;
    if($res->num_rows > 0){
        
        $ren=$this->randomCode(10);
	$verification_pin = $this->randomCodeNum(6);
	//$msg = "sucess";
    //return $msg;
	//$res=$this->db->query("insert into patient(name,email,password,phone_no,city,gender,status,age,token,image,dob) values('$name','$email','$password','$phone_no','$city','$gender','Pending','$age','$verification_pin','patient_avatar-male.jpg','$dob')");
	$res1=$this->db->query("UPDATE doctors SET token = '$verification_pin' WHERE phone_no = '$phone_no'");
	if(@$res1)
	{
		$sms = 'Your Docconsult.in Verification OTP '.$verification_pin;
		$sms = str_replace("<", "", $sms);
		 $sms = str_replace(">", "", $sms);
		 $sms = rawurlencode($sms);
     //$send_sms_url = 'http://www.sms.jprinfotech.com/api/sendhttp.php?authkey=4296AbkgvkyLHP2b584bb4a2&mobiles='.$phone_no.'&message='.$sms.'&sender='.sender_id.'&route=4';
       $send_sms_url='http://sms.digialaya.com/API/SMSHttp.aspx?UserId=docconsultadmin&pwd=pwd2017&Message='.$sms.'&Contacts='.$phone_no.'&SenderId=DOCCON&ServiceName=SMSTRANS&StartTime=';

     $send_sms_url = str_replace(" ", "%20", $send_sms_url);
     
     $ch = curl_init();
     $timeout = 5;
     curl_setopt($ch, CURLOPT_URL, $send_sms_url);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
     curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
     curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
     curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
     curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
     $data = curl_exec($ch);
     curl_close($ch);
     return TRUE;
		
	
        
    }
}
else {
    
    //$msg= "Phone no. doesn't exist in our records";
    return False;
}

}


public function check_existing_number_patient($phone_no){
    
    
    $res = $this->db->query("SELECT * FROM patient where phone_no = '$phone_no'");
    
    //return $res->num_rows;
    if($res->num_rows > 0){
        
        $ren=$this->randomCode(10);
	$verification_pin = $this->randomCodeNum(6);
	//$msg = "sucess";
    //return $msg;
	//$res=$this->db->query("insert into patient(name,email,password,phone_no,city,gender,status,age,token,image,dob) values('$name','$email','$password','$phone_no','$city','$gender','Pending','$age','$verification_pin','patient_avatar-male.jpg','$dob')");
	$res1=$this->db->query("UPDATE patient SET token = '$verification_pin' WHERE phone_no = '$phone_no'");
	if(@$res1)
	{
		$sms = 'Your Docconsult.in Verification OTP is : '.$verification_pin;
		$sms = str_replace("<", "", $sms);
		 $sms = str_replace(">", "", $sms);
		 $sms = rawurlencode($sms);
     //$send_sms_url = 'http://www.sms.jprinfotech.com/api/sendhttp.php?authkey=4296AbkgvkyLHP2b584bb4a2&mobiles='.$phone_no.'&message='.$sms.'&sender='.sender_id.'&route=4';
       $send_sms_url='http://sms.digialaya.com/API/SMSHttp.aspx?UserId=docconsultadmin&pwd=pwd2017&Message='.$sms.'&Contacts='.$phone_no.'&SenderId=DOCCON&ServiceName=SMSTRANS&StartTime=';

     $send_sms_url = str_replace(" ", "%20", $send_sms_url);
     
     $ch = curl_init();
     $timeout = 5;
     curl_setopt($ch, CURLOPT_URL, $send_sms_url);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
     curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
     curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
     curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
     curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
     $data = curl_exec($ch);
     curl_close($ch);
     return TRUE;
		
	
        
    }
}
else {
    
    //$msg= "Phone no. doesn't exist in our records";
    return False;
}

}

public function change_password($pass,$conf,$otp,$phone){
     $conf = sha1($conf);
    
    
    $res = $this->db->query("UPDATE doctors set password='$conf' where phone_no='$phone' and token='$otp'");
    
    $res1 = $this->db->query("select * from doctors where phone_no='$phone' and token='$otp'");
    if($res1->num_rows > 0){
         echo "<script> window.location.href ='".base_url."?reset_success=1'</script>";
      
    }
    else {
        echo "<script> window.location.href ='".base_url."?reset_failed=1'</script>";
    }
}

public function change_password_patient($pass,$conf,$otp,$phone){
    $conf = sha1($conf);
    
    $res = $this->db->query("UPDATE patient set password='$conf' where phone_no='$phone' and token='$otp'");
    
    $res1 = $this->db->query("select * from patient where phone_no='$phone' and token='$otp'");
    if($res1->num_rows > 0){
         echo "<script> window.location.href ='".base_url."?reset_success=1'</script>";
      
    }
    else {
        echo "<script> window.location.href ='".base_url."?reset_failed=1'</script>";
    }
}

public function getarea($city)
{
    $result = $this->db->query("SELECT distinct area FROM clinic WHERE city = '$city' order by area");
		while($row=mysqli_fetch_assoc($result)) {
			$resultset[] = $row;
		}		
		
		$res = json_encode($resultset);
	    return $res;
// 		if(!empty($resultset))
// 			return $resultset;
}

public function display_bp()
{
	
	$patient_id=$_SESSION['patient_login_id'];
	$tday=date("Y-m-d");
 if(@$_POST['start'])
      {
      	$start=$_POST['start'];
      	$end=$_POST['end'];
	  	$res=$this->db->query("select * from manage_health where patient_id='$patient_id'and systolic!='' and date >= '$start' and date <= '$end' ");
	  }
	  else
	  {
	  $res=$this->db->query("select * from manage_health where patient_id='$patient_id' and systolic!='' ");	
	  }
	

	
	$str='  <div class="col-sm-12" style="margin-top: 10px;">
        					<table class="table table-responsive patient-panel-table">
        						<tr style="font-weight: bold;">
        							<td>Patient Name</td>
        							<td>Systolic</td>
        							<td>Diastolic</td>
        							<td>Date</td>
        							<td>Time</td>
        							<td>Action</td>
        						</tr>';
	if($res->num_rows > 0)
	{
		while($data1=$res->fetch_assoc())
		{   
		
		
			$str.=' <tr>
			                            <td>'.$data1['patient_name'].'</td>
                                        <td>'.$data1['systolic'].'</td>
                                        <td>'.$data1['diastolic'].'</td>
                                        <td>'.$data1['time'].'</td>
                                        <td>'.$data1['date'].'</td><td> <a href="'.base_url_patient.'health_record/?delete='.$data1['id'].'&re=blood"  class="confirmation"><i class="material-icons">delete</i></a>
								  &nbsp &nbsp<a href="'.base_url_patient.'health_record/?edit='.$data1['id'].'&type=blood" class="confirmation"><i class="material-icons">create</i></a></td>
								    </tr>
                                   ';
		
		}	
		
	}
	
	$str.='</table>';
	 return $str;
}
public function insert_into_patient_doctorblob($patient_id,$doctor_id)
{
    $res = $this->db->query("select * from patient where patient_id='$patient_id'");
    $data = $res->fetch_assoc();
    $all_doctors = json_decode($data['doctor_id'],TRUE);
    $flag = 0;
    $d = array();
    if(empty($all_doctors))
    {
        $d[0] = $doctor_id;
        $d = json_encode($d);
        $res = $this->db->query("update patient set doctor_id='$d' where patient_id='$patient_id'");
    }
    else
    {
        $count = count($all_doctors);
        if($count==0)
        {
            $d[0] = $doctor_id;
            $d = json_encode($d);
            $res = $this->db->query("update patient set doctor_id='$d' where patient_id='$patient_id'");
        }
        else
        {
            
            for($i=0; $i<$count; $i++)
            {
                if($doctor_id==$all_doctors[i])
                    $flag = 1;
            }
            if($flag == 0)
            {
            $all_doctors[$count] = $doctor_id;
            $all_doctors = json_encode($all_doctors);
            $res = $this->db->query("update patient set doctor_id='$all_doctors' where patient_id='$patient_id'");
            
            }
        }
    }
        
}
public function insert_into_doctor_patientblob($doctor_id,$patient_id)
{
    $res = $this->db->query("select * from doctors where id='$doctor_id'");
    $data = $res->fetch_assoc();
    $all_doctors = json_decode($data['patients_added'],TRUE);
    $flag = 0;
    $d = array();
    if(empty($all_doctors))
    {
        $d[0] = $patient_id;
        $d = json_encode($d);
        $res = $this->db->query("update doctors set patients_added='$d' where id='$doctor_id'");
    }
    else
    {
        $count = count($all_doctors);
        if($count==0)
        {
            $d[0] = $patient_id;
            $d = json_encode($d);
            $res = $this->db->query("update doctors set patients_added='$d' where id='$doctor_id'");
        }
        else
        {
            
            for($i=0; $i<$count; $i++)
            {
                if($patient_id==$all_doctors[i])
                    $flag = 1;
            }
            if($flag == 0)
            {
            $all_doctors[$count] = $patient_id;
            $all_doctors = json_encode($all_doctors);
            $res = $this->db->query("update doctors set patients_added='$all_doctors' where id='$doctor_id'");
            
            }
        }
    }
    
}
public function patient_final_register($app_id){
    $que=$this->db->query("update appointments set status='pending' where id='$app_id'");
    $data1=$this->db->query("select * from appointments where id='$app_id'");
    $data=$data1->fetch_assoc();
    $pid=$data['patient_id'];
    $name=$data['patient_name'];
    $pemail=$data['patient_email'];
    $phone=$data['phone_no'];
    $area=$data['area'];
    $doctor_id=$data['doctor_id'];
    $app_time=$data['app_time'];
    $app_date=$data['app_date'];
    $pass=sha1($phone);
    $cid=$data['clinic_id'];
    $cdetails=$this->db->query("select name from clinic where id='$cid'");
    $cdetails=$cdetails->fetch_assoc();
    $clinic_name=$cdetails['name'];
    
    
    $d=$this->db->query("insert into patient(patient_id,name,email,password,phone_no,area) values('$pid','$name','$pemail','$pass','$phone','$area')");
    
    $doctors =  $this->insert_into_patient_doctorblob($pid,$doctor_id);
    $patients = $this->insert_into_doctor_patientblob($doctor_id,$pid);
    
    $insert_token=$this->db->query("INSERT INTO `token` (`id`, `app_id`, `patient_id`, `patient_name`, `doctor_id`, `app_time`, `app_date`,`clinic_name`,`token_no`,`status`)
    VALUES (NULL, '$app_id', '$pid', '$name', '$doctor_id', '$app_time', '$app_date','$clinic_name','1','pending');");
	$shuffle=$this->token_shuffle($app_date,$doctor_id);
	
	
	$msg.='<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: linear-gradient(to right, #2D9CDB, #2F5894);">
	<tr>
		<td></td>
		<td class="header container">
			
			<div style="max-width: 630px;    margin: 0 auto;    display: block;">
			<table>
				<tr>
					<td><a href="'.base_url.'"><img src="'.base_url.'/image/logo.png" alt="logo" ></a></td>	
				</tr>
			</table>
			</div>
			
		</td>
		<td></td>
	</tr>
</table>

<!---content demo -->
<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: #f5f5fa; ">
	<tr>
		<td></td>
		<td class="header container">
			
			<div style="max-width: 600px;    margin: 0 auto;    display: block;">
			<table>
					<tr>
						<td>
						<br>
							<h3>Dear '.$name.', </h3>
							<h3>Welcome To <a href="https://www.docconsult.in/">docconsult.in</a></h3>
							<p class="lead">You have successfully Fixed your Appointment at <a href="https://www.docconsult.in/">docconsult.in</a>.</p>
							
							<h4>Thank You For Using Docconsult.</h4>
							<<p class="lead">Regards,</p>
                            <p class="lead">Docconsult Team</p>
						</td>
					</tr>
				</table>
			</div>			
		</td>
		<td></td>
	</tr>
</table>
<!---content demo End-->
<table class="head-wrap" style="width: 650px;    background: #f5f5fa;    margin: 0 auto; ">
	<tr>
		<td></td>
		<td class="header container">			
			<div  style="max-width: 600px;     margin: 0 auto;    display: block;">
				<table>
					<tr>
					
						<td>
							<h4>Thank You For Using Docconsult.</h4>
							<p class="lead">Regards,</p>
                            <p class="lead">Docconsult Team</p>
						</td>
					</tr>
						
						
				</table>
			</div>
		</td>
		<td></td>		<!---Footer End--->
	</tr>	
</table>

<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: linear-gradient(to right, #2D9CDB, #2F5894);">
	<tr>
		<td></td>
		<td class="header container">
			
			<div style="max-width: 630px;    margin: 0 auto;    display: block;">
			<table>
				<tr>
					<td><a href="'.base_url.'"><img src="'.base_url.'/image/logo.png" alt="logo" ></a>
					<p style="  font-size: 12px;     margin: 2px 10px;  color:#fff;">Contact NO : <strong> 0141-2785199</strong></p>
					<p style="  font-size: 12px;      margin: 2px 10px;  color:#fff;">Email: <strong><a href="emailto:service@docconsult.in" style="color:#fff;">service@docconsult.in</a></strong></p>
					<p style="   font-size: 12px;     margin: 2px 10px;  color:#fff;">Copyright © 2017 DocConsult | All Right Reserved 2016</p>	</td>
					
					<td style="text-align: right;    width: 50%;">
					<p style="float: right; text-align: right; margin-right: 0px; margin-top: 60px;">
                                                        <a href="https://www.facebook.com/docconsult/"><img src="'.base_url.'image/F.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a> 
                                                        <a href="https://twitter.com/Docconsult12"><img src="'.base_url.'image/T.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a>
                                                        <a href="https://www.youtube.com/channel/UCroHJE8lYtX3Wz9j233Dtwg"><img src="'.base_url.'image/Y.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a>
                                                        <a href="https://www.instagram.com/docconsultservices/"><img src="'.base_url.'image/I.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a> 
                                                        <a href="https://www.linkedin.com/in/docconsult-services-a70a72134/"><img src="'.base_url.'image/L.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a></br>
                                                        </p></td>
				</tr>
			</table>
			</div>
			
		</td>
		<td></td>
	</tr>
</table>';
		
/*	$msg = '<div style="width:100%; height:100%; margin:0;" >

	<div style="width:90%; float:left; height:70px;padding:30px;">

		<span style="width:50%;float:left"> <a href="https://docconsult.in"><img src="https://docconsult.in/image/logo.png"  style="height:70px"/></span></a>

		<span style="width:50%; text-align:right;float:left;font-size: 17px;">  <br /><b> </span>

	</div>

	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Dear '.$name.', <br></div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Welcome To docconsult.in</div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">You have successfully Fixed your Appointment at Docconsult. </div>
	
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Thank You</div>';*/
	
	


$msg_admin ='<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: linear-gradient(to right, #2D9CDB, #2F5894);">
	<tr>
		<td></td>
		<td class="header container">
			
			<div style="max-width: 650px;    margin: 0 auto;    display: block;">
		<a href="'.base_url.'"><img src="'.base_url.'/image/logo.png" alt="logo" ></a>
			</div>
			
		</td>
		<td></td>
	</tr>
</table>

<!---content demo -->
<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: #f5f5fa; ">
	<tr>
		<td></td>
		<td class="header container">
			
			<div style="max-width: 630px;    margin: 0 auto;    display: block;">
			<table>
					<tr>
						<td>
						<br>
							<h3>Hello , Admin </h3>
							<p class="lead">New Doctor Create An Account in <a href="https://www.docconsult.in/">Docconsult.in</a></p>					
								
						</td>
					</tr>
				</table>
			</div>			
		</td>
		<td></td>
	</tr>
</table>
<!---content demo End-->
<table class="head-wrap" style="width: 650px;    background: #f5f5fa;    margin: 0 auto; ">
	<tr>
		<td></td>
		<td class="header container">
			
			<!-- content -->
			<div style="max-width: 630px;    margin: 0 auto;    display: block;">
				<table>
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
 <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;   min-width: 180px; font-weight: bold;   text-align: left;  float:left;">Patient Name :
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;     ">'.$name.'</span>
</td>
    
  </tr>
   <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;  min-width: 180px;font-weight: bold;   text-align: left;   float:left;">Email:
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;      ">'.$pemail. '</span></td>
    
  </tr>
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;min-width: 180px; font-weight: bold;   text-align: left;  float:left;">Mobile No :

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;    ">'.$phone.'</span></td>
    
  </tr>
  
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;min-width: 180px; font-weight: bold;   text-align: left;  float:left;">Gender:

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;    ">'.$gen. '</span></td>
    
  </tr>
  
   <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;   min-width: 180px; font-weight: bold;  text-align: left;   float:left;">City:

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;      text-align: center;     ">'.$area.'</span></td>
    
  </tr>
  
  
  			
					<tr>	
						<td></td><td></td>
					</tr>
				</table>
			</div>
			<!-- COLUMN WRAP -->
			
			<div  style="max-width: 630px;     margin: 0 auto;    display: block;">
				<table>
					<tr>
						<td>
							<p class="lead">Have successfully fixed his/her appointment on Docconsult.</p>
							
					        <h4>Thank You </h4>
							
						</td>
						</tr>
					
					
						<td></td>
					</tr>
				</table>
			</div>
		</td>
		<td></td>		<!---Footer End--->
	</tr>	
</table>

<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: linear-gradient(to right, #2D9CDB, #2F5894);">
	<tr>
		<td></td>
		<td class="header container">
			
			<div style="max-width: 630px;    margin: 0 auto;    display: block;">
			<table>
				<tr>
					<td><a href="'.base_url.'"><img src="'.base_url.'/image/logo.png" alt="logo" ></a>
					<p style="  font-size: 12px;     margin: 2px 10px;  color:#fff;">Contact NO : <strong> 0141-2785199</strong></p>
					<p style="  font-size: 12px;      margin: 2px 10px;  color:#fff;">Email: <strong><a href="emailto:service@docconsult.in" style="color:#fff;">service@docconsult.in</a></strong></p>
					<p style="   font-size: 12px;     margin: 2px 10px;  color:#fff;">Copyright © 2017 DocConsult | All Right Reserved 2016</p>	</td>
					
					<td style="text-align: right;    width: 50%;">
					<p style="float: right; text-align: right; margin-right: 0px; margin-top: 60px;">
                                                        <a href="https://www.facebook.com/docconsult/"><img src="'.base_url.'image/F.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a> 
                                                        <a href="https://twitter.com/Docconsult12"><img src="'.base_url.'image/T.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a>
                                                        <a href="https://www.youtube.com/channel/UCroHJE8lYtX3Wz9j233Dtwg"><img src="'.base_url.'image/Y.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a>
                                                        <a href="https://www.instagram.com/docconsultservices/"><img src="'.base_url.'image/I.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a> 
                                                        <a href="https://www.linkedin.com/in/docconsult-services-a70a72134/"><img src="'.base_url.'image/L.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a></br>
                                                        </p></td>
				</tr>
			</table>
			</div>
			
		</td>
		<td></td>
	</tr>
</table>';
	
/*	$msg_admin = '<div style="width:100%; height:100%; margin:0;" >

	<div style="width:90%; float:left; height:70px;padding:30px;">

		<span style="width:50%;float:left"> <a href="https://docconsult.in"><img src="https://docconsult.in/image/logo.png"  style="height:70px"/></span></a>

		<span style="width:50%; text-align:right;float:left;font-size: 17px;">  <br /><b> </span>

	</div>

	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Name: '.$name.', <br></div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Mobile no :'.$phone. '</div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Have successfully fixed his/her appointment on Docconsult. </div>';*/
	
	$this->foremail($pemail,$msg,'services@docconsult.in','Docconsult appointment');
	$this->foremail('info@docconsult.in',$msg_admin,'services@docconsult.in','New Appointment');

return true;
	
}

public function patient_final_register_request_for_call($app_id){
    $que=$this->db->query("update request_for_call set status='pending' where id='$app_id'");
//     $data1=$this->db->query("select * from appointments where id='$app_id'");
//     $data=$data1->fetch_assoc();
//     $pid=$data['patient_id'];
//     $name=$data['patient_name'];
//     $pemail=$data['patient_email'];
//     $phone=$data['phone_no'];
//     $area=$data['area'];
//     $doctor_id=$data['doctor_id'];
//     $app_time=$data['app_time'];
//     $app_date=$data['app_date'];
//     $pass=sha1($phone);
//     $cid=$data['clinic_id'];
//     $cdetails=$this->db->query("select name from clinic where id='$cid'");
//     $cdetails=$cdetails->fetch_assoc();
//     $clinic_name=$cdetails['name'];
    
    
//     $d=$this->db->query("insert into patient(patient_id,name,email,password,phone_no,area) values('$pid','$name','$pemail','$pass','$phone','$area')");
    
//     $doctors =  $this->insert_into_patient_doctorblob($pid,$doctor_id);
//     $patients = $this->insert_into_doctor_patientblob($doctor_id,$pid);
    
//     $insert_token=$this->db->query("INSERT INTO `token` (`id`, `app_id`, `patient_id`, `patient_name`, `doctor_id`, `app_time`, `app_date`,`clinic_name`,`token_no`,`status`) VALUES (NULL, '$app_id', '$pid', '$name', '$doctor_id', '$app_time', '$app_date','$clinic_name','1','pending');");
// 	$shuffle=$this->token_shuffle($app_date,$doctor_id);
// //	header("Location: ".base_url);

	
}

public function token_shuffle($date,$doc_id)
{
       if($this->db->query("SET @i=0;") && $this->db->query("UPDATE `token` SET token_no = @i:=@i+1 WHERE app_date='$date' and doctor_id='$doc_id' and status!='Cancel'  ORDER BY app_time;") )
    {
        $i=0;
    }
   // $update_token=$this->db->multi_query("SET @i=0; UPDATE `token` SET token_no = @i:=@i+1 WHERE app_date='$date' and doctor_id='$doc_id'  ORDER BY app_time;");
}
public function check_otp_new($app_id,$otp){
    $res=$this->db->query("select * from appointments where id='$app_id' and token='$otp' ");
    if($res->num_rows > 0){
        
        return true;
    }
    else{
        
        return false;
    }
}

public function check_otp_new_request_for_call($app_id,$otp){
    $res=$this->db->query("select * from request_for_call where id='$app_id' and token='$otp' ");
    if($res->num_rows > 0){
        
        return true;
    }
    else{
        
        return false;
    }
}

public function selectByClinicid($cid){
    $res=$this->db->query("select * from clinic where id='$cid'");
    if($res->num_rows >0){
        return $res->fetch_assoc();
    }
}
public function new_patient_appointment($patient_id,$parent_id,$app_time,$name,$email,$phone_no,$area,$symptoms,$date,$cid,$did){
    //'$name','$email','$app_time','$date','$did','$phone_no','$patient_id','$cid','Cancel','$otp','$area'
    $otp=$this->randomCodeNum(6);
    //$otp="123456";
    $ap=$this->db->query("insert into appointments(parent_id,patient_name,patient_email,app_time,app_date,doctor_id,phone_no,patient_id,clinic_id,status,token,area) values('$parent_id','$name','$email','$app_time','$date','$did','$phone_no','$patient_id','$cid','Cancel','$otp','$area')");
    $activity_name = "Add Appointment";
    $date = date("Y-m-d");
    $time = date("h:i");
    $res = $this->db->query("insert into activity(name,patient_id,doctor_id,action,date,time) values('$activity_name','$name','$did','added','$date','$time')");
    // if($ap){
    // return '$'.$otp;
    // }
    // else{
    //     return "failed";
    // }
    
        $doctor=$this->getById($did,"doctors");
		$doctor_name=$doctor['name'];
		$clinic=$this->selectByClinicid($cid);
	//$msg = 'Dear%20'.$name.',%20Appointment%20at%20Dr.%20'.$doctor_name.'%20has%20been%20fixed%20successfully.%20Date%20:%20'.$date.'%20Time%20:%20'.$time.'.%20By%20DocConsult.in';
	$msg='Your Docconsult.in Verification OTP '.$otp;
		$msg = str_replace("<", "", $msg);
		 $msg = str_replace(">", "", $msg);
		 $msg = rawurlencode($msg);
		
     //$send_sms_url = 'http://www.sms.jprinfotech.com/api/sendhttp.php?authkey=4296AbkgvkyLHP2b584bb4a2&mobiles='.$phone_no.'&message='.$msg.'&sender='.sender_id.'&route=4';
       $send_sms_url='http://sms.digialaya.com/API/SMSHttp.aspx?UserId=docconsultadmin&pwd=pwd2017&Message='.$msg.'&Contacts='.$phone_no.'&SenderId=DOCCON&ServiceName=SMSTRANS&StartTime=';
     $send_sms_url = str_replace(" ", "%20", $send_sms_url);
     
     $ch = curl_init();
     $timeout = 5;
     curl_setopt($ch, CURLOPT_URL, $send_sms_url);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
     curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
     curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
     curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
     curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
     $data = curl_exec($ch);
     curl_close($ch);
     
     $data=$this->db->query("Select * from appointments order by id DESC LIMIT 1");
     $app_id=$data->fetch_assoc();
     $app_id=$app_id['id'];
     return $app_id;
     
    
    
}


public function new_patient_appointment_request_for_call($patient_id,$parent_id,$app_time,$name,$email,$phone_no,$area,$symptoms,$date,$cid,$did){
    //'$name','$email','$app_time','$date','$did','$phone_no','$patient_id','$cid','Cancel','$otp','$area'
    $otp=$this->randomCodeNum(6);
    //$otp="123456";
    $ap=$this->db->query("insert into request_for_call(parent_id,patient_name,patient_email,app_time,app_date,doctor_id,phone_no,patient_id,clinic_id,status,token,area) values('$parent_id','$name','$email','$app_time','$date','$did','$phone_no','$patient_id','$cid','Cancel','$otp','$area')");
    $activity_name = "Add Request for call";
    $date = date("Y-m-d");
    $time = date("h:i");
    $res = $this->db->query("insert into activity(name,patient_id,doctor_id,action,date,time) values('$activity_name','$name','$did','added','$date','$time')");
    // if($ap){
    // return '$'.$otp;
    // }
    // else{
    //     return "failed";
    // }
    
        $doctor=$this->getById($did,"doctors");
		$doctor_name=$doctor['name'];
		$clinic=$this->selectByClinicid($cid);
	//$msg = 'Dear%20'.$name.',%20Appointment%20at%20Dr.%20'.$doctor_name.'%20has%20been%20fixed%20successfully.%20Date%20:%20'.$date.'%20Time%20:%20'.$time.'.%20By%20DocConsult.in';
	$msg='Your Docconsult.in Verification OTP is '.$otp;
		$msg = str_replace("<", "", $msg);
		 $msg = str_replace(">", "", $msg);
		 $msg = rawurlencode($msg);
		
     //$send_sms_url = 'http://www.sms.jprinfotech.com/api/sendhttp.php?authkey=4296AbkgvkyLHP2b584bb4a2&mobiles='.$phone_no.'&message='.$msg.'&sender='.sender_id.'&route=4';
       $send_sms_url='http://sms.digialaya.com/API/SMSHttp.aspx?UserId=docconsultadmin&pwd=pwd2017&Message='.$msg.'&Contacts='.$phone_no.'&SenderId=DOCCON&ServiceName=SMSTRANS&StartTime=';
     $send_sms_url = str_replace(" ", "%20", $send_sms_url);
     
     $ch = curl_init();
     $timeout = 5;
     curl_setopt($ch, CURLOPT_URL, $send_sms_url);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
     curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
     curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
     curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
     curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
     $data = curl_exec($ch);
     curl_close($ch);
     
     $data=$this->db->query("Select * from request_for_call where phone_no='$phone_no' order by id DESC LIMIT 1");
     $app_id=$data->fetch_assoc();
     $app_id=$app_id['id'];
     return $app_id;
     
    
    
}

public function existing_patient_requestforcall($patient_id,$parent_id,$app_time,$name,$email,$phone_no,$area,$city,$symptoms,$date,$cid,$did) {
    
	$otp=$this->randomCodeNum(6);
	$ap=$this->db->query("insert into request_for_call(parent_id,patient_name,patient_email,app_time,app_date,doctor_id,phone_no,patient_id,clinic_id,status,token,area,symptoms) values('$parent_id','$name','$email','$app_time','$date','$did','$phone_no','$patient_id','$cid','Cancel','$otp','$area','$symptoms')");
	$activity_name = "Add Request for call";
	$date = date("Y-m-d");
	$time = date("h:i");
	$res = $this->db->query("insert into activity(name,patient_id,doctor_id,action,date,time) values('$activity_name','$name','$did','added','$date','$time')");
	
	$doctor=$this->getById($did,"doctors");
	$doctor_name=$doctor['name'];
	$clinic=$this->selectByClinicid($cid);
	$sms='Your Docconsult.in Verification OTP '.$otp;
	$sms = str_replace("<", "", $sms);
	$sms = str_replace(">", "", $sms);
	$sms = rawurlencode($sms);
	
	$send_sms_url='http://sms.digialaya.com/API/SMSHttp.aspx?UserId=docconsultadmin&pwd=pwd2017&Message='.$sms.'&Contacts='.$phone_no.'&SenderId=DOCCON&ServiceName=SMSTRANS&StartTime=';
	$send_sms_url = str_replace(" ", "%20", $send_sms_url);
	
	$ch = curl_init();
	$timeout = 5;
	curl_setopt($ch, CURLOPT_URL, $send_sms_url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
	curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	$data = curl_exec($ch);
	curl_close($ch);
	
	$data=$this->db->query("Select * from request_for_call where phone_no='$phone_no' order by id DESC LIMIT 1");
	$app_id=$data->fetch_assoc();
	$app_id=$app_id['id'];
	return $app_id;
}

public function existing_patient_appointment($patient_id,$parent_id,$app_time,$name,$email,$phone_no,$area,$city,$symptoms,$date,$cid,$did){
    
    //print $patient_id.$parent_id.$app_time.$name.$email.$phone_no.$area.$symptoms.$date.$cid.$did;
    // print "insert into appointments(parent_id,patient_name,patient_email,app_time,app_date,doctor_id,phone_no,patient_id,clinic_id,status,token,area) values('$parent_id','$name','$email','$app_time','$date','$did','$phone_no','$patient_id','$cid','Cancel','$otp','$area')";
    // die();
    $otp=$this->randomCodeNum(6);
    //$otp="123456";
    $ap=$this->db->query("insert into appointments(parent_id,patient_name,patient_email,app_time,app_date,doctor_id,phone_no,patient_id,clinic_id,status,token,area,symptoms) values('$parent_id','$name','$email','$app_time','$date','$did','$phone_no','$patient_id','$cid','Cancel','$otp','$area','$symptoms')");
    $activity_name = "Add Appointment";
    $date = date("Y-m-d");
    $time = date("h:i");
    $res = $this->db->query("insert into activity(name,patient_id,doctor_id,action,date,time) values('$activity_name','$name','$did','added','$date','$time')");
    // if($ap){
    // return '$'.$otp;
    // }
    // else{
    //     return "failed";
    // }
    
        $doctor=$this->getById($did,"doctors");
		$doctor_name=$doctor['name'];
		$clinic=$this->selectByClinicid($cid);
	//$msg = 'Dear%20'.$name.',%20Appointment%20at%20Dr.%20'.$doctor_name.'%20has%20been%20fixed%20successfully.%20Date%20:%20'.$date.'%20Time%20:%20'.$time.'.%20By%20DocConsult.in';
	$sms='Your Docconsult.in Verification OTP '.$otp;
		$sms = str_replace("<", "", $sms);
		 $sms = str_replace(">", "", $sms);
		 $sms = rawurlencode($sms);
		
     //$send_sms_url = 'http://www.sms.jprinfotech.com/api/sendhttp.php?authkey=4296AbkgvkyLHP2b584bb4a2&mobiles='.$phone_no.'&message='.$msg.'&sender='.sender_id.'&route=4';
       $send_sms_url='http://sms.digialaya.com/API/SMSHttp.aspx?UserId=docconsultadmin&pwd=pwd2017&Message='.$sms.'&Contacts='.$phone_no.'&SenderId=DOCCON&ServiceName=SMSTRANS&StartTime=';
     $send_sms_url = str_replace(" ", "%20", $send_sms_url);
     
     $ch = curl_init();
     $timeout = 5;
     curl_setopt($ch, CURLOPT_URL, $send_sms_url);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
     curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
     curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
     curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
     curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
     $data = curl_exec($ch);
     curl_close($ch);
     
     $data=$this->db->query("Select * from appointments where phone_no='$phone_no' order by id DESC LIMIT 1");
     $app_id=$data->fetch_assoc();
     $app_id=$app_id['id'];
     return $app_id;
     
    
}

public function existing_patient_resend_otp($phone_no, $app_id){
    
    $otp=$this->randomCodeNum(6);
    //$otp="123456";
    $ap=$this->db->query("update appointments set token = '$otp' where id = '$app_id' ");

    
        //$doctor=$this->getById($did,"doctors");
       // $doctor_name=$doctor['name'];
       // $clinic=$this->selectByClinicid($cid);
    //$msg = 'Dear%20'.$name.',%20Appointment%20at%20Dr.%20'.$doctor_name.'%20has%20been%20fixed%20successfully.%20Date%20:%20'.$date.'%20Time%20:%20'.$time.'.%20By%20DocConsult.in';
     $sms='Your Docconsult.in Verification OTP '.$otp;
     $sms = str_replace("<", "", $sms);
     $sms = str_replace(">", "", $sms);
     $sms = rawurlencode($sms);
        
     //$send_sms_url = 'http://www.sms.jprinfotech.com/api/sendhttp.php?authkey=4296AbkgvkyLHP2b584bb4a2&mobiles='.$phone_no.'&message='.$msg.'&sender='.sender_id.'&route=4';
       $send_sms_url='http://sms.digialaya.com/API/SMSHttp.aspx?UserId=docconsultadmin&pwd=pwd2017&Message='.$sms.'&Contacts='.$phone_no.'&SenderId=DOCCON&ServiceName=SMSTRANS&StartTime=';
     $send_sms_url = str_replace(" ", "%20", $send_sms_url);
     
     $ch = curl_init();
     $timeout = 5;
     curl_setopt($ch, CURLOPT_URL, $send_sms_url);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
     curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
     curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
     curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
     curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
     $data = curl_exec($ch);
     curl_close($ch);
     
     // $data=$this->db->query("Select * from appointments order by id DESC LIMIT 1");
     // $app_id=$data->fetch_assoc();
     // $app_id=$app_id['id'];
     // return $app_id;     
    
}


public function existing_patient_resend_otp_request_call($phone_no, $app_id){
    
    $otp=$this->randomCodeNum(6);
    //$otp="123456";
    $ap=$this->db->query("update request_for_call set token = '$otp' where id = '$app_id' ");

    
        //$doctor=$this->getById($did,"doctors");
       // $doctor_name=$doctor['name'];
       // $clinic=$this->selectByClinicid($cid);
    //$msg = 'Dear%20'.$name.',%20Appointment%20at%20Dr.%20'.$doctor_name.'%20has%20been%20fixed%20successfully.%20Date%20:%20'.$date.'%20Time%20:%20'.$time.'.%20By%20DocConsult.in';
     $sms='Your Docconsult.in Verification OTP '.$otp;
     $sms = str_replace("<", "", $sms);
     $sms = str_replace(">", "", $sms);
     $sms = rawurlencode($sms);
        
     //$send_sms_url = 'http://www.sms.jprinfotech.com/api/sendhttp.php?authkey=4296AbkgvkyLHP2b584bb4a2&mobiles='.$phone_no.'&message='.$msg.'&sender='.sender_id.'&route=4';
       $send_sms_url='http://sms.digialaya.com/API/SMSHttp.aspx?UserId=docconsultadmin&pwd=pwd2017&Message='.$sms.'&Contacts='.$phone_no.'&SenderId=DOCCON&ServiceName=SMSTRANS&StartTime=';
     $send_sms_url = str_replace(" ", "%20", $send_sms_url);
     
     $ch = curl_init();
     $timeout = 5;
     curl_setopt($ch, CURLOPT_URL, $send_sms_url);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
     curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
     curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
     curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
     curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
     $data = curl_exec($ch);
     curl_close($ch);
     
     // $data=$this->db->query("Select * from appointments order by id DESC LIMIT 1");
     // $app_id=$data->fetch_assoc();
     // $app_id=$app_id['id'];
     // return $app_id;     
    
}

public function patient_existing_register($app_id){
    
     $que=$this->db->query("update appointments set status='pending' where id='$app_id'");
    $data1=$this->db->query("select * from appointments where id='$app_id'");
    $data=$data1->fetch_assoc();
    $pid=$data['patient_id'];
    $aid=$data['id'];
    $name=$data['patient_name'];
    $pemail=$data['patient_email'];
    $phone=$data['phone_no'];
    $area=$data['area'];
    $doctor_id=$data['doctor_id'];
    $app_time=$data['app_time'];
    $app_date=$data['app_date'];
    $pass=sha1($phone);
    $cid=$data['clinic_id'];
    $cdetails=$this->db->query("select name,address from clinic where id='$cid'");
    $cdetails=$cdetails->fetch_assoc();
    $clinic_name=$cdetails['name'];
    $insert_token=$this->db->query("INSERT INTO `token` (`id`, `app_id`, `patient_id`, `patient_name`, `doctor_id`, `app_time`, `app_date`,`clinic_name`,`token_no`,`status`) VALUES (NULL, '$app_id', '$pid', '$name', '$doctor_id', '$app_time', '$app_date','$clinic_name','1','pending');");
	$shuffle=$this->token_shuffle($app_date,$doctor_id);
	$doc_details = $this->getById($data['doctor_id'],'doctors');
	$pat_details = $this->getById($data['patient_id'],'patient');
	
     $msg_doc = '<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: linear-gradient(to right, #2D9CDB, #2F5894);">
	<tr>
		<td></td>
		<td class="header container">
			
			<div style="max-width: 630px;    margin: 0 auto;    display: block;">
			<table>
				<tr>
					<td><a href="'.base_url.'"><img src="'.base_url.'/image/logo.png" alt="logo" ></a></td>
					<td align="right"><h6 class="collapse"></h6></td>
				</tr>
			</table>
			</div>
			
		</td>
		<td></td>
	</tr>
</table>

<!---content demo -->
<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: #f5f5fa; ">
	<tr>
		<td></td>
		<td class="header container">
			
			<div style="max-width: 630px;    margin: 0 auto;    display: block;">
			<table>
					<tr>
						<td>
						<br>
							<h3>Hello &nbsp;'.$pat_details['name'].', </h3>
							<p class="lead">One appointment has been generated for you.</p>
							
							
						</td>
					</tr>
				</table>
			</div>			
		</td>
		<td></td>
	</tr>
</table>
<!---content demo End-->
<table class="head-wrap" style="width: 650px;    background: #f5f5fa;    margin: 0 auto; ">
	<tr>
		<td></td>
		<td class="header container">
			
			<!-- content -->
			<div style="max-width: 630px;    margin: 0 auto;    display: block;">
				<table>
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"><span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;   min-width: 180px; font-weight: bold;   text-align: left;  float:left;">Appointment ID:
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;     ">&nbsp;'.$aid.'</span>
</td>
  </tr>
  
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;min-width: 180px; font-weight: bold;   text-align: left;  float:left;">Appointment Date:

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;    ">&nbsp;'.$app_date.'</span></td>
    
  </tr>
   <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;   min-width: 180px; font-weight: bold;  text-align: left;   float:left;">Appointment Time:

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;      text-align: center;     ">&nbsp;'.$app_time.'</span></td>
    
  </tr>
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;  min-width: 180px;font-weight: bold;   text-align: left;   float:left;">Doctor name:
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;      "> &nbsp;'.$doc_details['name'].'</span></td>
    
  </tr>
 <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
   <span style="text-decoration: none; color: #666;    padding: 3px 0 5px 0;min-width: 180px; font-weight: bold; margin-right: 10px;  text-align: left;  float:left;">Clinic Name:

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     margin-right: 10px;  text-align: center;   ">&nbsp;'.$clinic_name.'</span></td>
    
  </tr>
   
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
   <span style="text-decoration: none; color: #666;    padding: 3px 0 5px 0;min-width: 180px; font-weight: bold; margin-right: 10px;  text-align: left;  float:left;">Clinic Area:

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     margin-right: 10px;  text-align: center;   ">&nbsp;'.$area.'</span></td>
    
  </tr>
  
  	<tr>
  <td>
  <h3 style="margin:5px 0 5px 0;">Patient Details </h3>
  </td>
  </tr>			
									
		
   <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;  min-width: 180px;font-weight: bold;   text-align: left;   float:left;">Patient name:
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;      "> &nbsp;'.$pat_details['name'].' </span></td>
    
  </tr>
   <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;  min-width: 180px;  font-weight: bold; margin-right: 10px;  text-align: left;   float:left;">Patient Email:

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     margin-right: 10px;  text-align: center;     ">&nbsp;'.$pat_details['email'].'</span></td>
    
  </tr>
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;  min-width: 180px; font-weight: bold; margin-right: 10px;  text-align: left;   float:left;">Patient Mobile:


</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     margin-right: 10px;  text-align: center;      ">&nbsp;'.$pat_details['phone_no'].'</span></td>
    
  </tr>
  
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;  min-width: 180px; font-weight: bold; margin-right: 10px;  text-align: left;   float:left;">Patient Gender:


</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     margin-right: 10px;  text-align: center;      ">&nbsp;'.$pat_details['gender'].'</span></td>
    
  </tr>
  
   <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;  min-width: 180px;  font-weight: bold; margin-right: 10px;  text-align: left;   float:left;">city:

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     margin-right: 10px;  text-align: center;     ">&nbsp;'.$pat_details['city'].'</span></td>
    
  </tr>
  					
					<tr>	
						<td></td><td></td>
					</tr>
				</table>
			</div>
			<!-- COLUMN WRAP -->
			
			<div  style="max-width: 630px;     margin: 0 auto;    display: block;">
				<table>
					<tr>
					
						<td>
						    <h4>Thank You For Using Docconsult.</h4>
							<p class="lead">Regards,</p>
                            <p class="lead">Docconsult Team</p>
						</td>
					</tr>
						
						<tr>
						<td>
							<div style="margin:30px 0"><a href="#" class="cancel" style="padding: 10px 20px;background-color: #2D9CDB;
    color: #fff;
    border: 1px solid #2D9CDB;border-radius: 5px;text-decoration: none; font-family: "Open Sans", sans-serif;">Cancel</a>
	
</div>
							
						</td>
						<td>
							<div style="margin:30px 0">
<a href="#" class="reschedule" style="padding: 10px 20px;background-color: #2D9CDB; color: #fff;border: 1px solid #2D9CDB;border-radius: 5px;text-decoration: none; font-family: "Open Sans", sans-serif;">Reschedule</a>
</div>
							
						</td>
						<td></td>
					</tr>
				</table>
			</div>
		</td>
		<td></td>		<!---Footer End--->
	</tr>	
</table>


<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: linear-gradient(to right, #2D9CDB, #2F5894);">
	<tr>
		<td></td>
		<td class="header container">
			
			<div style="max-width: 630px;    margin: 0 auto;    display: block;">
			<table>
				<tr>
					<td><a href="'.base_url.'"><img src="'.base_url.'/image/logo.png" alt="logo" ></a>
					<p style="  font-size: 12px;     margin: 2px 10px;  color:#fff;">Contact NO : <strong> 0141-2785199</strong></p>
					<p style="  font-size: 12px;      margin: 2px 10px;  color:#fff;">Email: <strong><a href="emailto:service@docconsult.in" style="color:#fff;">service@docconsult.in</a></strong></p>
					<p style="   font-size: 12px;     margin: 2px 10px;  color:#fff;">Copyright © 2017 DocConsult | All Right Reserved 2016</p>	</td>
					
					<td style="text-align: right;    width: 50%;">
					<p style="float: right; text-align: right; margin-right: 0px; margin-top: 60px;">
                                                        <a href="https://www.facebook.com/docconsult/"><img src="'.base_url.'image/F.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a> 
                                                        <a href="https://twitter.com/Docconsult12"><img src="'.base_url.'image/T.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a>
                                                        <a href="https://www.youtube.com/channel/UCroHJE8lYtX3Wz9j233Dtwg"><img src="'.base_url.'image/Y.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a>
                                                        <a href="https://www.instagram.com/docconsultservices/"><img src="'.base_url.'image/I.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a> 
                                                        <a href="https://www.linkedin.com/in/docconsult-services-a70a72134/"><img src="'.base_url.'image/L.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a></br>
                                                        </p></td>
				</tr>
			</table>
			</div>
			
		</td>
		<td></td>
	</tr>
</table>';
	
		/*$msg_doc='<div style="width:100%; height:100%; margin:0;" >

	<div style="width:90%; float:left; height:70px;padding:30px;">

		<span style="width:50%;float:left"> <a href="https://docconsult.in"><img src="https://docconsult.in/image/logo.png"  style="height:70px"/></span></a>

		<span style="width:50%; text-align:right;float:left;font-size: 17px;">  <br /><b> </span>

	</div>

	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Hello &nbsp;'.$doc_details['be_name'].$doc_details['name'].', <br></div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">One appointment has been generated for you.</div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Patient name: &nbsp;'.$pat_details['name'].' </div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Patient mobile no: &nbsp;'.$phone.' </div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Appointment Date: &nbsp;'.$app_date.' </div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Appointment Time: &nbsp;'.$app_time.' </div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Area: &nbsp;'.$area.' </div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Clinic: &nbsp;'.$clinic_name.' </div>
	
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Thank You</div>';*/
	
	
	$msg_pat = '<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: linear-gradient(to right, #2D9CDB, #2F5894);">
	<tr>
		<td></td>
		<td class="header container">
			
			<div style="max-width: 630px;    margin: 0 auto;    display: block;">
			<table>
				<tr>
					<td><a href="'.base_url.'"><img src="'.base_url.'/image/logo.png" alt="logo" ></a></td>
					<td align="right"><h6 class="collapse"></h6></td>
				</tr>
			</table>
			</div>
			
		</td>
		<td></td>
	</tr>
</table>

<!---content demo -->
<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: #f5f5fa; ">
	<tr>
		<td></td>
		<td class="header container">
			
			<div style="max-width: 630px;    margin: 0 auto;    display: block;">
			<table>
					<tr>
						<td>
						<br>
							<h3>Hello &nbsp;'.$pat_details['name'].', </h3>
							<p class="lead">Your appointment has been generated with Docconsult.</p>
							
							
						</td>
					</tr>
				</table>
			</div>			
		</td>
		<td></td>
	</tr>
</table>
<!---content demo End-->
<table class="head-wrap" style="width: 650px;    background: #f5f5fa;    margin: 0 auto; ">
	<tr>
		<td></td>
		<td class="header container">
			
			<!-- content -->
			<div style="max-width: 630px;    margin: 0 auto;    display: block;">
				<table>
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"><span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;   min-width: 180px; font-weight: bold;   text-align: left;  float:left;">Appointment ID:
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;     ">&nbsp;'.$aid.'</span>
</td>
  </tr>
 
   <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;  min-width: 180px;font-weight: bold;   text-align: left;   float:left;">Patient name:
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;      "> &nbsp;'.$pat_details['name'].' </span></td>
    
  </tr>
   <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;  min-width: 180px;  font-weight: bold; margin-right: 10px;  text-align: left;   float:left;">Patient Email:

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     margin-right: 10px;  text-align: center;     ">&nbsp;'.$pat_details['email'].'</span></td>
    
  </tr>
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;  min-width: 180px; font-weight: bold; margin-right: 10px;  text-align: left;   float:left;">Patient Mobile:


</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     margin-right: 10px;  text-align: center;      ">&nbsp;'.$pat_details['phone_no'].'</span></td>
    
  </tr>
  
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;  min-width: 180px; font-weight: bold; margin-right: 10px;  text-align: left;   float:left;">Patient Gender:


</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     margin-right: 10px;  text-align: center;      ">&nbsp;'.$pat_details['gender'].'</span></td>
    
  </tr>
  
   <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;  min-width: 180px;  font-weight: bold; margin-right: 10px;  text-align: left;   float:left;">city:

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     margin-right: 10px;  text-align: center;     ">&nbsp;'.$pat_details['city'].'</span></td>
    
  </tr>
  <tr>
  <td>
  <h3 style="margin:5px 0 5px 0;">Appointment Details </h3>
  </td>
  </tr>
   <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;  min-width: 180px;font-weight: bold;   text-align: left;   float:left;">Doctor name:
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;      "> &nbsp;'.$doc_details['name'].'</span></td>
    
  </tr>
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;min-width: 180px; font-weight: bold;   text-align: left;  float:left;">Appointment Date:

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;    ">&nbsp;'.$app_date.'</span></td>
    
  </tr>
   <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;   min-width: 180px; font-weight: bold;  text-align: left;   float:left;">Appointment Time:

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;      text-align: center;     ">&nbsp;'.$app_time.'</span></td>
    
  </tr>
 
 <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
   <span style="text-decoration: none; color: #666;    padding: 3px 0 5px 0;min-width: 180px; font-weight: bold; margin-right: 10px;  text-align: left;  float:left;">Clinic Name:

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     margin-right: 10px;  text-align: center;   ">&nbsp;'.$clinic_name.' </span></td>
    
  </tr>
   
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
   <span style="text-decoration: none; color: #666;    padding: 3px 0 5px 0;min-width: 180px; font-weight: bold; margin-right: 10px;  text-align: left;  float:left;">Clinic Area:

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     margin-right: 10px;  text-align: center;   ">&nbsp;'.$area.'</span></td>
    
  </tr>
  
  				
									
							
							
					<tr>	
						<td></td><td></td>
					</tr>
				</table>
			</div>
			<!-- COLUMN WRAP -->
			
			<div  style="max-width: 630px;     margin: 0 auto;    display: block;">
				<table>
					<tr>
					
						<td>
							<h4>Thank You For Using Docconsult.</h4>
							<p class="lead">Regards,</p>
                            <p class="lead">Docconsult Team</p>
						</td>
					</tr>
						
						<tr>
						<td>
							<div style="margin:30px 0"><a href="#" class="cancel" style="padding: 10px 20px;background-color: #2D9CDB;
    color: #fff;
    border: 1px solid #2D9CDB;border-radius: 5px;text-decoration: none; font-family: "Open Sans", sans-serif;">Cancel</a>
	
</div>
							
						</td>
						<td>
							<div style="margin:30px 0">
<a href="#" class="reschedule" style="padding: 10px 20px;background-color: #2D9CDB; color: #fff;border: 1px solid #2D9CDB;border-radius: 5px;text-decoration: none; font-family: "Open Sans", sans-serif;">Reschedule</a>
</div>
							
						</td>
						<td></td>
					</tr>
				</table>
			</div>
		</td>
		<td></td>		<!---Footer End--->
	</tr>	
</table>


<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: linear-gradient(to right, #2D9CDB, #2F5894);">
	<tr>
		<td></td>
		<td class="header container">
			
			<div style="max-width: 630px;    margin: 0 auto;    display: block;">
			<table>
				<tr>
					<td><a href="'.base_url.'"><img src="'.base_url.'/image/logo.png" alt="logo" ></a>
					<p style="  font-size: 12px;     margin: 2px 10px;  color:#fff;">Contact NO : <strong> 0141-2785199</strong></p>
					<p style="  font-size: 12px;      margin: 2px 10px;  color:#fff;">Email: <strong><a href="emailto:service@docconsult.in" style="color:#fff;">service@docconsult.in</a></strong></p>
					<p style="   font-size: 12px;     margin: 2px 10px;  color:#fff;">Copyright © 2017 DocConsult | All Right Reserved 2016</p>	</td>
					
					<td style="text-align: right;    width: 50%;">
					<p style="float: right; text-align: right; margin-right: 0px; margin-top: 60px;">
                                                        <a href="https://www.facebook.com/docconsult/"><img src="'.base_url.'image/F.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a> 
                                                        <a href="https://twitter.com/Docconsult12"><img src="'.base_url.'image/T.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a>
                                                        <a href="https://www.youtube.com/channel/UCroHJE8lYtX3Wz9j233Dtwg"><img src="'.base_url.'image/Y.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a>
                                                        <a href="https://www.instagram.com/docconsultservices/"><img src="'.base_url.'image/I.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a> 
                                                        <a href="https://www.linkedin.com/in/docconsult-services-a70a72134/"><img src="'.base_url.'image/L.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a></br>
                                                        </p></td>
				</tr>
			</table>
			</div>
			
		</td>
		<td></td>
	</tr>
</table>';
	
	
	
	
	
/*	$msg_pat='<div style="width:100%; height:100%; margin:0;" >

	<div style="width:90%; float:left; height:70px;padding:30px;">

		<span style="width:50%;float:left"> <a href="https://docconsult.in"><img src="https://docconsult.in/image/logo.png"  style="height:70px"/></span></a>

		<span style="width:50%; text-align:right;float:left;font-size: 17px;">  <br /><b> </span>

	</div>

	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Hello &nbsp;'.$pat_details['name'].', <br></div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Your appointment has been generated with Docconsult.</div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Doctor name: &nbsp;'.$doc_details['name'].' </div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Appointment Date: &nbsp;'.$app_date.' </div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Appointment Time: &nbsp;'.$app_time.' </div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Area: &nbsp;'.$area.' </div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Clinic: &nbsp;'.$clinic_name.' </div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Clinic Address: &nbsp;'.$cdetails['address'].' </div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Thank You</div>';*/
	
	
	
	
$msg_admin = '<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: linear-gradient(to right, #2D9CDB, #2F5894);">
	<tr>
		<td></td>
		<td class="header container">
			
			<div style="max-width: 630px;    margin: 0 auto;    display: block;">
			<table>
				<tr>
					<td><a href="'.base_url.'"><img src="'.base_url.'/image/logo.png" alt="logo" ></a></td>
					<td align="right"><h6 class="collapse"></h6></td>
				</tr>
			</table>
			</div>
			
		</td>
		<td></td>
	</tr>
</table>
<!---content demo -->
<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: #f5f5fa; ">
	<tr>
		<td></td>
		<td class="header container">
			
			<div style="max-width: 630px;    margin: 0 auto;    display: block;">
			<table>
					<tr>
						<td>
						<br>
							<h3>Hello, Admin</h3>
							<p class="lead">An appointment has been generated with <a href="https://www.docconsult.in/">Docconsult.in</a></p>
							
							
						</td>
					</tr>
				</table>
			</div>			
		</td>
		<td></td>
	</tr>
</table>
<!---content demo End-->
<table class="head-wrap" style="width: 650px;    background: #f5f5fa;    margin: 0 auto; ">
	<tr>
		<td></td>
		<td class="header container">
			
			<!-- content -->
			<div style="max-width: 630px;    margin: 0 auto;    display: block;">
				<table>
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"><span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;   min-width: 180px; font-weight: bold;   text-align: left;  float:left;">Appointment ID:
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;     ">&nbsp;'.$aid.'</span>
</td>
    
  </tr>
  
  <tr>
  <td>
  <h3 style="margin:5px 0 5px 0;">Patient Details</h3>
  </td>
  </tr>
  
  
   <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;  min-width: 180px;font-weight: bold;   text-align: left;   float:left;">Patient name:
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;      ">&nbsp;'.$pat_details['name'].'</span></td>
    
  </tr>
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"><span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;min-width: 180px; font-weight: bold;   text-align: left;  float:left;">Patient  Email:

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;    ">&nbsp;'.$pat_details['email'].'</span></td>
    
  </tr>
   <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;   min-width: 180px; font-weight: bold;  text-align: left;   float:left;">Patient Mobile:

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;      text-align: center;     ">&nbsp;'.$pat_details['phone_no'].'</span></td>
    
  </tr>
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"><span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;   min-width: 180px; font-weight: bold;   text-align: left;   float:left;">Gender :

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;      text-align: center;     ">&nbsp;'.$pat_details['gender'].'</span></td>
    
  </tr>
  
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;   min-width: 180px; font-weight: bold;   text-align: left;   float:left;">Patient Area :

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;      text-align: center;      ">&nbsp;'.$pat_details['city'].'</span></td>
    
  </tr>
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;   min-width: 180px; font-weight: bold;   text-align: left;   float:left;">Area :

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;      text-align: center;      ">&nbsp;'.$area.'</span></td>
    
  </tr>
 
  <tr>
  <td>
  <h3 style="margin:5px 0 5px 0;">Doctor Details</h3>
  </td>
  </tr>
  
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"><span style="text-decoration: none; color: #666;    padding: 3px 0 5px 0;min-width: 180px; font-weight: bold; margin-right: 10px;  text-align: left;  float:left;">Doctor name:

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     margin-right: 10px;  text-align: center;   ">'.$doc_details['name'].' </span></td>
    
  </tr>
   <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"><span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;  min-width: 180px;  font-weight: bold; margin-right: 10px;  text-align: left;   float:left;">Doctor Email:

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     margin-right: 10px;  text-align: center;     ">'.$doc_details['email'].'</span></td>
    
  </tr>
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"><span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;  min-width: 180px; font-weight: bold; margin-right: 10px;  text-align: left;   float:left;">Doctor Mobile:


</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     margin-right: 10px;  text-align: center;      ">'.$doc_details['phone_no'].'</span></td>
    
  </tr>
  
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"><span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;min-width: 180px; font-weight: bold;   text-align: left;  float:left;">Appointment Date:

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;    ">&nbsp;'.$app_date.'</span></td>
    
  </tr>
   <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;   min-width: 180px; font-weight: bold;  text-align: left;   float:left;">Appointment Time:

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;      text-align: center;     ">&nbsp;'.$app_time.'</span></td>
    
  </tr>
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"><span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;   min-width: 180px; font-weight: bold;   text-align: left;   float:left;">Clinic Name:

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;      text-align: center;     ">&nbsp;'.$clinic_name.'</span></td>
    
  </tr>
   <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"><span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;   min-width: 180px; font-weight: bold;  text-align: left;   float:left;">Clinic Address:

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;      text-align: center;     ">&nbsp;'.$cdetails['address'].'</span></td>
    
  </tr>
  
 
	
					<tr>	
						<td></td><td></td>
					</tr>
				</table>
			</div>
			<!-- COLUMN WRAP -->
			
			<div  style="max-width: 630px;     margin: 0 auto;    display: block;">
				<table>
					<tr>
					
						<td>
						    <h4>Thank You For Using Docconsult.</h4>
							<p class="lead">Regards,</p>
                            <p class="lead">Docconsult Team</p>
						</td>
					</tr>
						
						<tr>
						<td>
							<div style="margin:30px 0"><a href="#" class="cancel" style="padding: 10px 20px;background-color: #2D9CDB;
    color: #fff;
    border: 1px solid #2D9CDB;border-radius: 5px;text-decoration: none; font-family: "Open Sans", sans-serif;">Cancel</a>
	
</div>
							
						</td>
						<td>
							<div style="margin:30px 0">
<a href="#" class="reschedule" style="padding: 10px 20px;background-color: #2D9CDB;    color: #fff;    border: 1px solid #2D9CDB;border-radius: 5px;text-decoration: none; font-family: "Open Sans", sans-serif;">Reschedule</a>
</div>
						
						</td>
						<td></td>
					</tr>
				</table>
			</div>
		</td>
		<td></td>		<!---Footer End--->
	</tr>	
</table>


<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: linear-gradient(to right, #2D9CDB, #2F5894);">
	<tr>
		<td></td>
		<td class="header container">
			
			<div style="max-width: 630px;    margin: 0 auto;    display: block;">
			<table>
				<tr>
					<td><a href="'.base_url.'"><img src="'.base_url.'/image/logo.png" alt="logo" ></a>
					<p style="  font-size: 12px;     margin: 2px 10px;  color:#fff;">Contact NO : <strong> 0141-2785199</strong></p>
					<p style="  font-size: 12px;      margin: 2px 10px;  color:#fff;">Email: <strong><a href="emailto:service@docconsult.in" style="color:#fff;">service@docconsult.in</a></strong></p>
					<p style="   font-size: 12px;     margin: 2px 10px;  color:#fff;">Copyright © 2017 DocConsult | All Right Reserved 2016</p>	</td>
					
					<td style="text-align: right;    width: 50%;">
					<p style="float: right; text-align: right; margin-right: 0px; margin-top: 60px;">
                                                        <a href="https://www.facebook.com/docconsult/"><img src="'.base_url.'image/F.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a> 
                                                        <a href="https://twitter.com/Docconsult12"><img src="'.base_url.'image/T.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a>
                                                        <a href="https://www.youtube.com/channel/UCroHJE8lYtX3Wz9j233Dtwg"><img src="'.base_url.'image/Y.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a>
                                                        <a href="https://www.instagram.com/docconsultservices/"><img src="'.base_url.'image/I.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a> 
                                                        <a href="https://www.linkedin.com/in/docconsult-services-a70a72134/"><img src="'.base_url.'image/L.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a></br>
                                                        </p></td>
				</tr>
			</table>
			</div>
			
		</td>
		<td></td>
	</tr>
</table>';


	
/*	$msg_admin='<div style="width:100%; height:100%; margin:0;" >

	<div style="width:90%; float:left; height:70px;padding:30px;">

		<span style="width:50%;float:left"> <a href="https://docconsult.in"><img src="https://docconsult.in/image/logo.png"  style="height:70px"/></span></a>

		<span style="width:50%; text-align:right;float:left;font-size: 17px;">  <br /><b> </span>

	</div>

	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Hello admin <br></div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">An appointment has been generated with Docconsult.</div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Doctor name: &nbsp;'.$doc_details['name'].' </div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Doctor mobile no: &nbsp;'.$doc_details['phone_no'].' </div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Patient name: &nbsp;'.$pat_details['name'].' </div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Patient mobile no: &nbsp;'.$phone.' </div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Appointment Date: &nbsp;'.$app_date.' </div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Appointment Time: &nbsp;'.$app_time.' </div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Area: &nbsp;'.$area.' </div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Clinic: &nbsp;'.$clinic_name.' </div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Clinic Address: &nbsp;'.$cdetails['address'].' </div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Thank You</div>';
	*/
	
	  
        $this->foremail($doc_details['email'],$msg_doc,'service@docconsult.in','An appointment has been generated for you - DOCCONSULT'); //for doctor
        $this->foremail('info@docconsult.in',$msg_admin,'service@docconsult.in','An appointment has been generated'); //for admin
        $this->foremail($pemail,$msg_pat,'service@docconsult.in','An appointment has been generated for you - DOCCONSULT'); //for patient
    
    $fordocsms = ' generated for '.$pat_details['name'].' at '.$clinic_name.'on '.$app_date.' at '.$app_time;
    $forpatientsms = ' confirmed with '.$doc_details['be_name'].$doc_details['name'].' at '.$clinic_name.'on '.$app_date.' at '.$app_time;
		
	$sms1='Hi '.$doc_details['be_name'].$doc_details['name'].' Your Appointment has been '.$fordocsms.' you can login here '.base_url;
    $sms='Hi '.$pat_details['name'].' Your Appointment has been '.$forpatientsms.' you can login here '.base_url;
     
     $sms = str_replace("<", "", $sms);
     $sms = str_replace(">", "", $sms);
     $sms = rawurlencode($sms);
        
     //$send_sms_url = 'http://www.sms.jprinfotech.com/api/sendhttp.php?authkey=4296AbkgvkyLHP2b584bb4a2&mobiles='.$phone_no.'&message='.$msg.'&sender='.sender_id.'&route=4';
       $send_sms_url='http://sms.digialaya.com/API/SMSHttp.aspx?UserId=docconsultadmin&pwd=pwd2017&Message='.$sms.'&Contacts='.$phone.'&SenderId=DOCCON&ServiceName=SMSTRANS&StartTime=';
     $send_sms_url = str_replace(" ", "%20", $send_sms_url);
     
     $sms1 = str_replace("<", "", $sms1);
     $sms1 = str_replace(">", "", $sms1);
     $sms1= rawurlencode($sms1);
        
     //$send_sms_url = 'http://www.sms.jprinfotech.com/api/sendhttp.php?authkey=4296AbkgvkyLHP2b584bb4a2&mobiles='.$phone_no.'&message='.$msg.'&sender='.sender_id.'&route=4';
     $send_sms_url1='http://sms.digialaya.com/API/SMSHttp.aspx?UserId=docconsultadmin&pwd=pwd2017&Message='.$sms1.'&Contacts='.$doc_details['phone_no'].'&SenderId=DOCCON&ServiceName=SMSTRANS&StartTime=';
     $send_sms_url1 = str_replace(" ", "%20", $send_sms_url1);
     
     
     $ch1 = curl_init();
     $timeout = 5;
     curl_setopt($ch1, CURLOPT_URL, $send_sms_url1);
     curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);
     curl_setopt($ch1, CURLOPT_SSL_VERIFYHOST,false);
     curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER,false);
     curl_setopt($ch1, CURLOPT_MAXREDIRS, 10);
     curl_setopt($ch1, CURLOPT_FOLLOWLOCATION, 1);
     curl_setopt($ch1, CURLOPT_CONNECTTIMEOUT, $timeout);
     $data1 = curl_exec($ch1);
     curl_close($ch1);
     
     $ch = curl_init();
     $timeout = 5;
     curl_setopt($ch, CURLOPT_URL, $send_sms_url);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
     curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
     curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
     curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
     curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
     $data = curl_exec($ch);
     curl_close($ch);
	
	
    return true;
}


public function patient_existing_register_request_for_call($app_id){
    
    $que=$this->db->query("update request_for_call set status='pending' where id='$app_id'");
    $data1=$this->db->query("select * from request_for_call where id='$app_id'");
    $data=$data1->fetch_assoc();
    $pid=$data['patient_id'];
    $name=$data['patient_name'];
    $pemail=$data['patient_email'];
    $phone=$data['phone_no'];
    $rarea=$data['area'];
    $doctor_id=$data['doctor_id'];
    $app_time=$data['app_time'];
    $app_date=$data['app_date'];
    $token=$data['token'];
    $pass=sha1($phone);
    $cid=$data['clinic_id'];
    $cdetails=$this->db->query("select name,address from clinic where id='$cid'");
    $cdetails=$cdetails->fetch_assoc();
    $clinic_name=$cdetails['name'];
    $clinic_area=$cdetails['area'];
    $clinic_address=$cdetails['address'];
    $doc_details = $this->getById($data['doctor_id'],'doctors');
	$pat_details = $this->getById($data['patient_id'],'patient');
	
	
	  $msg_doc = '<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: linear-gradient(to right, #2D9CDB, #2F5894);">
	<tr>
		<td></td>
		<td class="header container">
			
			<div style="max-width: 630px;    margin: 0 auto;    display: block;">
			<table>
				<tr>
					<td><a href="'.base_url.'"><img src="'.base_url.'/image/logo.png" alt="logo" ></a></td>
					<td align="right"><h6 class="collapse"></h6></td>
				</tr>
			</table>
			</div>
			
		</td>
		<td></td>
	</tr>
</table>

<!---content demo -->
<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: #f5f5fa; ">
	<tr>
		<td></td>
		<td class="header container">
			
			<div style="max-width: 630px;    margin: 0 auto;    display: block;">
			<table>
					<tr>
						<td>
						<br>
							<h3>Hello &nbsp;'.$doc_details['be_name'].$doc_details['name'].', </h3>
							<p class="lead">One Request For call has been generated for you with <b>Docconsult</b> on &nbsp;<b>'.$app_date.'</b> at &nbsp;<b>'.$app_time.' </b></p>
							
							
						</td>
					</tr>
				</table>
			</div>			
		</td>
		<td></td>
	</tr>
</table>
<!---content demo End-->
<table class="head-wrap" style="width: 650px;    background: #f5f5fa;    margin: 0 auto; ">
	<tr>
		<td></td>
		<td class="header container">
			
			<!-- content -->
			<div style="max-width: 630px;    margin: 0 auto;    display: block;">
				<table>
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"><span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;   min-width: 180px; font-weight: bold;   text-align: left;  float:left;">Request A Call Token Number:
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;     ">&nbsp;'. $token.'</span>
</td>
  </tr>
  
  	<tr>
  <td>
  <h3 style="margin:5px 0 5px 0;">Patient Details </h3>
  </td>
  </tr>			
									
		
   <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;  min-width: 180px;font-weight: bold;   text-align: left;   float:left;">Patient name:
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;      ">&nbsp;'.$name.'</span></td>
    
  </tr>
   <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;  min-width: 180px;  font-weight: bold; margin-right: 10px;  text-align: left;   float:left;">Patient Email:

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     margin-right: 10px;  text-align: center;     ">&nbsp;'. $pemail.'</span></td>
    
  </tr>
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;  min-width: 180px; font-weight: bold; margin-right: 10px;  text-align: left;   float:left;">Patient Mobile:


</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     margin-right: 10px;  text-align: center;      ">&nbsp;'.$phone.'</span></td>
    
  </tr>
  
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;  min-width: 180px; font-weight: bold; margin-right: 10px;  text-align: left;   float:left;">Patient Gender:
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     margin-right: 10px;  text-align: center;      ">&nbsp;'.$pat_details['gender'].'</span></td>
    
  </tr>
  
   <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;  min-width: 180px;  font-weight: bold; margin-right: 10px;  text-align: left;   float:left;">city:

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     margin-right: 10px;  text-align: center;     ">&nbsp;'.$rarea.'</span></td>
    
  </tr>
  
  	<tr>
  <td>
  <h3 style="margin:5px 0 5px 0;">Doctor Details </h3>
  </td>
  </tr>	

  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;  min-width: 180px;font-weight: bold;   text-align: left;   float:left;">Doctor name:
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;      "> &nbsp;'.$doc_details['name'].'</span></td>
    
  </tr>
 <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
   <span style="text-decoration: none; color: #666;    padding: 3px 0 5px 0;min-width: 180px; font-weight: bold; margin-right: 10px;  text-align: left;  float:left;">Clinic Name:

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     margin-right: 10px;  text-align: center;   ">&nbsp;'.$clinic_name.'</span></td>
    
  </tr>
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
   <span style="text-decoration: none; color: #666;    padding: 3px 0 5px 0;min-width: 180px; font-weight: bold; margin-right: 10px;  text-align: left;  float:left;">Clinic Address:

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     margin-right: 10px;  text-align: center;   ">&nbsp;'.$clinic_address.'</span></td>
    
  </tr>
   
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
   <span style="text-decoration: none; color: #666;    padding: 3px 0 5px 0;min-width: 180px; font-weight: bold; margin-right: 10px;  text-align: left;  float:left;">Clinic Area:

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     margin-right: 10px;  text-align: center;   ">&nbsp;'. $rarea.'</span></td>
    
  </tr>
  
  
  					
							
					<tr>	
						<td></td><td></td>
					</tr>
				</table>
			</div>
			<!-- COLUMN WRAP -->
			
			<div  style="max-width: 630px;     margin: 0 auto;    display: block;">
				<table>
					<tr>
					
						<td>
					        <h4>Thank You For Using Docconsult.</h4>
							<p class="lead">Regards,</p>
                            <p class="lead">Docconsult Team</p>
						</td>
					</tr>
				</table>
			</div>
		</td>
		<td></td>		<!---Footer End--->
	</tr>	
</table>


<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: linear-gradient(to right, #2D9CDB, #2F5894);">
	<tr>
		<td></td>
		<td class="header container">
			
			<div style="max-width: 630px;    margin: 0 auto;    display: block;">
			<table>
				<tr>
					<td><a href="'.base_url.'"><img src="'.base_url.'/image/logo.png" alt="logo" ></a>
					<p style="  font-size: 12px;     margin: 2px 10px;  color:#fff;">Contact NO : <strong> 0141-2785199</strong></p>
					<p style="  font-size: 12px;      margin: 2px 10px;  color:#fff;">Email: <strong><a href="emailto:service@docconsult.in" style="color:#fff;">service@docconsult.in</a></strong></p>
					<p style="   font-size: 12px;     margin: 2px 10px;  color:#fff;">Copyright © 2017 DocConsult | All Right Reserved 2016</p>	</td>
					
					<td style="text-align: right;    width: 50%;">
					<p style="float: right; text-align: right; margin-right: 0px; margin-top: 60px;">
                                                        <a href="https://www.facebook.com/docconsult/"><img src="'.base_url.'image/F.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a> 
                                                        <a href="https://twitter.com/Docconsult12"><img src="'.base_url.'image/T.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a>
                                                        <a href="https://www.youtube.com/channel/UCroHJE8lYtX3Wz9j233Dtwg"><img src="'.base_url.'image/Y.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a>
                                                        <a href="https://www.instagram.com/docconsultservices/"><img src="'.base_url.'image/I.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a> 
                                                        <a href="https://www.linkedin.com/in/docconsult-services-a70a72134/"><img src="'.base_url.'image/L.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a></br>
                                                        </p></td>
				</tr>
			</table>
			</div>
			
		</td>
		<td></td>
	</tr>
</table>';
	
	
/*	$msg_doc='<div style="width:100%; height:100%; margin:0;" >

	<div style="width:90%; float:left; height:70px;padding:30px;">

		<span style="width:50%;float:left"> <a href='.base_url.'><img src="https://docconsult.in/image/logo.png"  style="height:70px"/></a></span>

		<span style="width:50%; text-align:right;float:left;font-size: 17px;">  <br /><b> </span>

	</div>

	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Hello &nbsp;'.$doc_details['be_name'].$doc_details['name'].', <br></div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">One Request For call has been generated for you with <b>Docconsult</b> on &nbsp;<b>'.$app_date.'</b> at &nbsp;<b>'.$app_time.' </b></div></div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Patient name: &nbsp;'.$pat_details['name'].' </div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Patient mobile no: &nbsp;'.$phone.' </div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Date: &nbsp;'.$app_date.' </div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Time: &nbsp;'.$app_time.' </div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Area: &nbsp;'.$area.' </div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Clinic: &nbsp;'.$clinic_name.' </div>
	
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Thank You</div>';*/
	
	
	 $msg_pat = '<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: linear-gradient(to right, #2D9CDB, #2F5894);">
	<tr>
		<td></td>
		<td class="header container">
			
			<div style="max-width: 630px;    margin: 0 auto;    display: block;">
			<table>
				<tr>
					<td><a href="'.base_url.'"><img src="'.base_url.'/image/logo.png" alt="logo" ></a></td>
					<td align="right"><h6 class="collapse"></h6></td>
				</tr>
			</table>
			</div>
			
		</td>
		<td></td>
	</tr>
</table>

<!---content demo -->
<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: #f5f5fa; ">
	<tr>
		<td></td>
		<td class="header container">
			
			<div style="max-width: 630px;    margin: 0 auto;    display: block;">
			<table>
					<tr>
						<td>
						<br>
							<h3>Hello &nbsp;'.$pat_details['name'].',</h3>
							<p class="lead">Your Request For call has been generated with <b>Docconsult</b> on &nbsp;<b>'.$app_date.'</b> at &nbsp;<b>'.$app_time.' </b></p>
							
								
						</td>
					</tr>
				</table>
			</div>			
		</td>
		<td></td>
	</tr>
</table>
<!---content demo End-->
<table class="head-wrap" style="width: 650px;    background: #f5f5fa;    margin: 0 auto; ">
	<tr>
		<td></td>
		<td class="header container">
			
			<!-- content -->
			<div style="max-width: 630px;    margin: 0 auto;    display: block;">
				<table>
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"><span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;   min-width: 180px; font-weight: bold;   text-align: left;  float:left;">Request A Call Token Number :
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;     ">&nbsp;'. $token.'</span>
</td>
  </tr>

  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;  min-width: 180px;font-weight: bold;   text-align: left;   float:left;">Doctor name:
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;      "> &nbsp;'.$doc_details['name'].'</span></td>
    
  </tr>
 <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
   <span style="text-decoration: none; color: #666;    padding: 3px 0 5px 0;min-width: 180px; font-weight: bold; margin-right: 10px;  text-align: left;  float:left;">Clinic Name:

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     margin-right: 10px;  text-align: center;   ">&nbsp;'.$clinic_name.'</span></td>
    
  </tr>
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
   <span style="text-decoration: none; color: #666;    padding: 3px 0 5px 0;min-width: 180px; font-weight: bold; margin-right: 10px;  text-align: left;  float:left;">Clinic Address:

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     margin-right: 10px;  text-align: center;   ">&nbsp;'.$clinic_address.'</span></td>
    
  </tr>
   
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
   <span style="text-decoration: none; color: #666;    padding: 3px 0 5px 0;min-width: 180px; font-weight: bold; margin-right: 10px;  text-align: left;  float:left;">Clinic Area:

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     margin-right: 10px;  text-align: center;   ">&nbsp;'. $rarea.'</span></td>
    
  </tr>
  
  	<tr>
  <td>
  <h3 style="margin:5px 0 5px 0;">Patient Details </h3>
  </td>
  </tr>			
									
		
   <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;  min-width: 180px;font-weight: bold;   text-align: left;   float:left;">Patient name:
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;      ">&nbsp;'.$name.'</span></td>
    
  </tr>
   <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;  min-width: 180px;  font-weight: bold; margin-right: 10px;  text-align: left;   float:left;">Patient Email:

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     margin-right: 10px;  text-align: center;     ">&nbsp;'. $pemail.'</span></td>
    
  </tr>
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;  min-width: 180px; font-weight: bold; margin-right: 10px;  text-align: left;   float:left;">Patient Mobile:


</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     margin-right: 10px;  text-align: center;      ">&nbsp;'.$phone.'</span></td>
    
  </tr>
  
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;  min-width: 180px; font-weight: bold; margin-right: 10px;  text-align: left;   float:left;">Patient Gender:
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     margin-right: 10px;  text-align: center;      ">&nbsp;'.$pat_details['gender'].'</span></td>
    
  </tr>
  
   <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;  min-width: 180px;  font-weight: bold; margin-right: 10px;  text-align: left;   float:left;">city:

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     margin-right: 10px;  text-align: center;     ">&nbsp;'.$rarea.'</span></td>
    
  </tr>
  
 							
					<tr>	
						<td></td><td></td>
					</tr>
				</table>
			</div>
			<!-- COLUMN WRAP -->
			
			<div  style="max-width: 630px;     margin: 0 auto;    display: block;">
				<table>
					<tr>
					
					<td>
							<h4>Thank You For Using Docconsult.</h4>
							<p class="lead">Regards,</p>
                            <p class="lead">Docconsult Team</p>
						</td>
					</tr>
				</table>
			</div>
		</td>
		<td></td>		<!---Footer End--->
	</tr>	
</table>


<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: linear-gradient(to right, #2D9CDB, #2F5894);">
	<tr>
		<td></td>
		<td class="header container">
			
			<div style="max-width: 630px;    margin: 0 auto;    display: block;">
			<table>
				<tr>
					<td><a href="'.base_url.'"><img src="'.base_url.'/image/logo.png" alt="logo" ></a></a>
					<p style="  font-size: 12px;     margin: 2px 10px;  color:#fff;">Contact NO : <strong> 0141-2785199</strong></p>
					<p style="  font-size: 12px;      margin: 2px 10px;  color:#fff;">Email: <strong><a href="emailto:service@docconsult.in" style="color:#fff;">service@docconsult.in</a></strong></p>
					<p style="   font-size: 12px;     margin: 2px 10px;  color:#fff;">Copyright © 2017 DocConsult | All Right Reserved 2016</p>	</td>
					
					<td style="text-align: right;    width: 50%;">
					<p style="float: right; text-align: right; margin-right: 0px; margin-top: 60px;">
                                                        <a href="https://www.facebook.com/docconsult/"><img src="'.base_url.'image/F.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a> 
                                                        <a href="https://twitter.com/Docconsult12"><img src="'.base_url.'image/T.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a>
                                                        <a href="https://www.youtube.com/channel/UCroHJE8lYtX3Wz9j233Dtwg"><img src="'.base_url.'image/Y.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a>
                                                        <a href="https://www.instagram.com/docconsultservices/"><img src="'.base_url.'image/I.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a> 
                                                        <a href="https://www.linkedin.com/in/docconsult-services-a70a72134/"><img src="'.base_url.'image/L.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a></br>
                                                        </p></td>
				</tr>
			</table>
			</div>
			
		</td>
		<td></td>
	</tr>
</table>';

	
	/*$msg_pat='<div style="width:100%; height:100%; margin:0;" >

	<div style="width:90%; float:left; height:70px;padding:30px;">

		<span style="width:50%;float:left"> <a href='.base_url.'><img src="https://docconsult.in/image/logo.png"  style="height:70px"/></a></span>

		<span style="width:50%; text-align:right;float:left;font-size: 17px;">  <br /><b> </span>

	</div>

	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Hello &nbsp;'.$pat_details['name'].', <br></div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Your Request For call has been generated with <b>Docconsult</b> on &nbsp;<b>'.$app_date.'</b> at &nbsp;<b>'.$app_time.' </b></div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Doctor name: &nbsp;'.$doc_details['name'].' </div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Date: &nbsp;'.$app_date.' </div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Time: &nbsp;'.$app_time.' </div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Area: &nbsp;'.$area.' </div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Clinic : &nbsp;'.$clinic_name.' </div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Clinic Address : &nbsp;'.$cdetails['address'].' </div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Thank You</div>';*/
	
	
	
	
	 $msg_admin = '<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: linear-gradient(to right, #2D9CDB, #2F5894);">
	<tr>
		<td></td>
		<td class="header container">
			
			<div style="max-width: 630px;    margin: 0 auto;    display: block;">
			<table>
				<tr>
					<td><a href="'.base_url.'"><img src="'.base_url.'/image/logo.png" alt="logo" ></a></td>
					<td align="right"><h6 class="collapse"></h6></td>
				</tr>
			</table>
			</div>
			
		</td>
		<td></td>
	</tr>
</table>

<!---content demo -->
<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: #f5f5fa; ">
	<tr>
		<td></td>
		<td class="header container">
			
			<div style="max-width: 630px;    margin: 0 auto;    display: block;">
			<table>
					<tr>
						<td>
						<br>
							<h3Hello Admin <br></h3>
							<p class="lead">Request For call has been generated with Docconsult on &nbsp;<b>'.$app_date.'</b> at &nbsp;<b>'.$app_time.' </b></p>
							
							
						</td>
					</tr>
				</table>
			</div>			
		</td>
		<td></td>
	</tr>
</table>
<!---content demo End-->
<table class="head-wrap" style="width: 650px;    background: #f5f5fa;    margin: 0 auto; ">
	<tr>
		<td></td>
		<td class="header container">
			
			<!-- content -->
			<div style="max-width: 630px;    margin: 0 auto;    display: block;">
				<table>
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"><span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;   min-width: 180px; font-weight: bold;   text-align: left;  float:left;">Request A Call Token Number :
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;     ">&nbsp;'. $token.'</span>
</td>
  </tr>
  
  <tr>
  <td>
  <h3 style="margin:5px 0 5px 0;">Doctor Details </h3>
  </td>
  </tr>	

  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;  min-width: 180px;font-weight: bold;   text-align: left;   float:left;">Doctor name:
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;      "> &nbsp;'.$doc_details['name'].'</span></td>
    
  </tr>
 <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
   <span style="text-decoration: none; color: #666;    padding: 3px 0 5px 0;min-width: 180px; font-weight: bold; margin-right: 10px;  text-align: left;  float:left;">Clinic Name:

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     margin-right: 10px;  text-align: center;   ">&nbsp;'.$clinic_name.'</span></td>
    
  </tr>
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
   <span style="text-decoration: none; color: #666;    padding: 3px 0 5px 0;min-width: 180px; font-weight: bold; margin-right: 10px;  text-align: left;  float:left;">Clinic Address:

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     margin-right: 10px;  text-align: center;   ">&nbsp;'.$clinic_address.'</span></td>
    
  </tr>
   
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
   <span style="text-decoration: none; color: #666;    padding: 3px 0 5px 0;min-width: 180px; font-weight: bold; margin-right: 10px;  text-align: left;  float:left;">Clinic Area:

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     margin-right: 10px;  text-align: center;   ">&nbsp;'. $rarea.'</span></td>
    
  </tr>
 	<tr>
  <td>
  <h3 style="margin:5px 0 5px 0;">Patient Details </h3>
  </td>
  </tr>			
									
		
   <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;  min-width: 180px;font-weight: bold;   text-align: left;   float:left;">Patient name:
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;      ">&nbsp;'.$name.'</span></td>
    
  </tr>
   <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;  min-width: 180px;  font-weight: bold; margin-right: 10px;  text-align: left;   float:left;">Patient Email:

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     margin-right: 10px;  text-align: center;     ">&nbsp;'. $pemail.'</span></td>
    
  </tr>
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;  min-width: 180px; font-weight: bold; margin-right: 10px;  text-align: left;   float:left;">Patient Mobile:


</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     margin-right: 10px;  text-align: center;      ">&nbsp;'.$phone.'</span></td>
    
  </tr>
  
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;  min-width: 180px; font-weight: bold; margin-right: 10px;  text-align: left;   float:left;">Patient Gender:
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     margin-right: 10px;  text-align: center;      ">&nbsp;'.$pat_details['gender'].'</span></td>
    
  </tr>
  
   <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;  min-width: 180px;  font-weight: bold; margin-right: 10px;  text-align: left;   float:left;">city:

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     margin-right: 10px;  text-align: center;     ">&nbsp;'.$rarea.'</span></td>
    
  </tr>
  
  
 							
					<tr>	
						<td></td><td></td>
					</tr>
				</table>
			</div>
			<!-- COLUMN WRAP -->
			
			<div  style="max-width: 630px;     margin: 0 auto;    display: block;">
				<table>
					<tr>
					
						<td>
							<h4>Thank You For Using Docconsult.</h4>
							<p class="lead">Regards,</p>
                            <p class="lead">Docconsult Team</p>
						</td>
					</tr>
				</table>
			</div>
		</td>
		<td></td>		<!---Footer End--->
	</tr>	
</table>


<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: linear-gradient(to right, #2D9CDB, #2F5894);">
	<tr>
		<td></td>
		<td class="header container">
			
			<div style="max-width: 630px;    margin: 0 auto;    display: block;">
			<table>
				<tr>
					<td><a href="'.base_url.'"><img src="'.base_url.'/image/logo.png" alt="logo" ></a>
					<p style="  font-size: 12px;     margin: 2px 10px;  color:#fff;">Contact NO : <strong> 0141-2785199</strong></p>
					<p style="  font-size: 12px;      margin: 2px 10px;  color:#fff;">Email: <strong><a href="emailto:service@docconsult.in" style="color:#fff;">service@docconsult.in</a></strong></p>
					<p style="   font-size: 12px;     margin: 2px 10px;  color:#fff;">Copyright © 2017 DocConsult | All Right Reserved 2016</p>	</td>
					
					<td style="text-align: right;    width: 50%;">
					<p style="float: right; text-align: right; margin-right: 0px; margin-top: 60px;">
                                                        <a href="https://www.facebook.com/docconsult/"><img src="'.base_url.'image/F.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a> 
                                                        <a href="https://twitter.com/Docconsult12"><img src="'.base_url.'image/T.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a>
                                                        <a href="https://www.youtube.com/channel/UCroHJE8lYtX3Wz9j233Dtwg"><img src="'.base_url.'image/Y.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a>
                                                        <a href="https://www.instagram.com/docconsultservices/"><img src="'.base_url.'image/I.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a> 
                                                        <a href="https://www.linkedin.com/in/docconsult-services-a70a72134/"><img src="'.base_url.'image/L.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a></br>
                                                        </p></td>
				</tr>
			</table>
			</div>
			
		</td>
		<td></td>
	</tr>
</table>';

	
	/*$msg_admin='<div style="width:100%; height:100%; margin:0;" >

	<div style="width:90%; float:left; height:70px;padding:30px;">

		<span style="width:50%;float:left"> <a href='.base_url.'><img src="https://docconsult.in/image/logo.png"  style="height:70px"/></a></span>

		<span style="width:50%; text-align:right;float:left;font-size: 17px;">  <br /><b> </span>

	</div>

	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Hello admin <br></div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Request For call has been generated with Docconsult on &nbsp;<b>'.$app_date.'</b> at &nbsp;<b>'.$app_time.' </b></div></div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Doctor name: &nbsp;'.$doc_details['name'].' </div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Doctor mobile no: &nbsp;'.$doc_details['phone_no'].' </div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Patient name: &nbsp;'.$pat_details['name'].' </div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Patient mobile no: &nbsp;'.$phone.' </div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Area: &nbsp;'.$area.' </div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Clinic: &nbsp;'.$clinic_name.' </div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Clinic Address: &nbsp;'.$cdetails['address'].' </div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Thank You</div>';*/

        $this->foremail($doc_details['email'],$msg_doc,'service@docconsult.in','Request for call has been generated for you - DOCCONSULT'); //for doctor
        $this->foremail('info@docconsult.in',$msg_admin,'service@docconsult.in','Request for call has been generated'); //for admin
        $this->foremail($pemail,$msg_pat,'service@docconsult.in','Request for call has been generated for you - DOCCONSULT'); //for patient
        
    
    $fordocsms = ' generated for '.$pat_details['name'].' at '.$clinic_name.' on '.$app_date.' at '.$app_time;
    $forpatientsms = ' confirmed for call with '.$doc_details['be_name'].$doc_details['name'].' at '.$clinic_name.' on '.$app_date.' at '.$app_time;
	 
	 	
	 $sms1='Hi '.$doc_details['be_name'].$doc_details['name'].' Your Request has been '.$fordocsms.' you can login here '.base_url;
     $sms='Hi '.$pat_details['name'].' Your Request has been '.$forpatientsms.' you can login here '.base_url;
     $sms = str_replace("<", "", $sms);
     $sms = str_replace(">", "", $sms);
     $sms = rawurlencode($sms);
     
     $sms1 = str_replace("<", "", $sms1);
     $sms1 = str_replace(">", "", $sms1);
     $sms1 = rawurlencode($sms1);
        
     //$send_sms_url = 'http://www.sms.jprinfotech.com/api/sendhttp.php?authkey=4296AbkgvkyLHP2b584bb4a2&mobiles='.$phone_no.'&message='.$msg.'&sender='.sender_id.'&route=4';
       $send_sms_url='http://sms.digialaya.com/API/SMSHttp.aspx?UserId=docconsultadmin&pwd=pwd2017&Message='.$sms.'&Contacts='.$phone.'&SenderId=DOCCON&ServiceName=SMSTRANS&StartTime=';
        $send_sms_url1='http://sms.digialaya.com/API/SMSHttp.aspx?UserId=docconsultadmin&pwd=pwd2017&Message='.$sms1.'&Contacts='.$doc_details['phone_no'].'&SenderId=DOCCON&ServiceName=SMSTRANS&StartTime=';
    
     $send_sms_url = str_replace(" ", "%20", $send_sms_url);
     $send_sms_url1 = str_replace(" ", "%20", $send_sms_url1);
     
     $ch = curl_init();
     $timeout = 5;
     curl_setopt($ch, CURLOPT_URL, $send_sms_url);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
     curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
     curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
     curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
     curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
     $data = curl_exec($ch);
     curl_close($ch);
     
     
     /*$send_sms_url1 = str_replace(" ", "%20", $send_sms_url1);
     
     $ch1 = curl_init();
     $timeout = 5;
     curl_setopt($ch1, CURLOPT_URL, $send_sms_url1);
     curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);
     curl_setopt($ch1, CURLOPT_SSL_VERIFYHOST,false);
     curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER,false);
     curl_setopt($ch1, CURLOPT_MAXREDIRS, 10);
     curl_setopt($ch1, CURLOPT_FOLLOWLOCATION, 1);
     curl_setopt($ch1, CURLOPT_CONNECTTIMEOUT, $timeout);
     $data = curl_exec($ch1);
     curl_close($ch1);*/
	
    return true;
}

public function change_patient_live_status($patient_id){
    $this->db->query("update patient set live_status=1,engaged_status=0 where id='$patient_id'");
}
public function insert_online_query($query,$specialisation,$patient_id,$patient_name){
    $this->db->query("insert into online_queries(query_message,specialization,author_name,author_id,status) values('$query','$specialisation','$patient_name','$patient_id','0')");
    $last_id = $this->db->query("select * from online_queries where author_id='$patient_id' order by id desc limit 1");
    $ret = $last_id->fetch_assoc();
    $ret = $ret['id'];
    return $ret;
}
public function change_query_status($new_status,$query_id)
{
    $this->db->query("update online_queries set status=$new_status where id='$query_id'");
}
public function get_doc_cat($dis,$area)
{
    $arr = array();
    $res = $this->db->query("select category.category as category from category,(SELECT DISTINCT category FROM doctors WHERE city = '" .$dis . "' and type = 'doctor' ) as t where t.category = category.id");
    $res1 = $this->db->query("select name from doctors where city = '$dis' and location = '$area'");
    $res2 = $this->db->query("select name from doctors where city = '$dis'");
    if($res->num_rows>0)
    {
        $count=$res->num_rows;
        for($i=0;$i<$count;$i++)
        {
            $data = $res->fetch_assoc();
            
            $arr[$data["category"]]=1;
        }
    }
    if($res1->num_rows>0)
    {
        $count=$res1->num_rows;
        for($i=0;$i<$count;$i++)
        {
            $data = $res1->fetch_assoc();
            $arr[$data["name"]]=1;
        }
    }
    if($res2->num_rows>0)
    {
        $count=$res2->num_rows;
        for($i=0;$i<$count;$i++)
        {
            $data = $res2->fetch_assoc();
            
            $arr[$data["name"]]=1;
        }
    }
    
   $keys = json_encode(array_keys($arr));
    
   return $keys;
}

/*public function get_doc_cat1($dis,$area)
{
    if(!empty($area)){
    
    $arr = array();
    //$res = $this->db->query("select category.category as category from category inner join doctors on category.id=doctors.category inner join practice on doctors.id=practice.doctor_id where doctors.location='$area' and doctors.city='$dis' and doctors.status != 'Suspended' group by practice.doctor_id ");
    $res = $this->db->query("select category.category as category from category,(SELECT DISTINCT category FROM doctors WHERE city = '" .$dis . "' and location = '$area' and type = 'doctor' and status!='Suspended' ) as t where t.category = category.id");
    // if(!empty($area)){
    // $res1 = $this->db->query("select id,category, name,image from doctors where city = '$dis' and location = '$area'");
    // }
    $res2 = $this->db->query("select doctors.id as id ,doctors.category as category, doctors.name as name,doctors.image as image,doctors.location as location, doctors.type as doc_type  from doctors inner join practice on doctors.id=practice.doctor_id and doctors.city = '$dis' and doctors.location='$area' and doctors.status != 'Suspended' group by doctors.id");
    $res_clinic = $this->db->query("select * from clinic where city='$dis' and area='$area'");
    if($res->num_rows > 0){
        
        while($data = $res->fetch_assoc()){
            
            $arr1['type']="Speciality";
            $arr1['category']=$data['category'];
            $arr1['image']='';
            $arr[] = $arr1;
        }
    }
    
    // if($res1->num_rows > 0){
        
    //     while($data = $res1->fetch_assoc()){
    //         $category = $data['category'];
    //         $cat = $this->db->query("select category from category where id='$category'");
    //         $cat_data=$cat->fetch_assoc();
    //         $arr2['type']=$cat_data['category'];
    //         $arr2['image']=$data['image'];
    //         $arr2['category']=$data['name'];
    //          $arr[] = $arr2;
    //     }
    // }
    
    if($res2->num_rows > 0){
        
        while($data = $res2->fetch_assoc()){
            $category = $data['category'];
            $cat = $this->db->query("select category from category where id='$category'");
            $cat_data=$cat->fetch_assoc();
            $arr3['type']=$cat_data['category'];
            $arr3['image']=$data['image'];
            $arr3['id']=$data['id'];
            $arr3['locate']=$data['location'];
            $arr3['doc_type']=$data['doc_type'];
            $arr3['category']=$data['name'];
             $arr[] = $arr3;
        }
    }
    
    if($res_clinic->num_rows > 0){
        
        while($data = $res_clinic->fetch_assoc()){
            $arr4['type']="Clinic";
            $arr4['image']=$data['image'];
            $arr4['id']=$data['id'];
            $arr4['category']=$data['name'];
            $arr[]=$arr4;
        }
    }
    
   $keys = json_encode($arr);
    }  
    
    else {
        
        $arr = array();
        //$res = $this->db->query("select category.category as category from category inner join doctors on category.id=doctors.category inner join practice on doctors.id=practice.doctor_id where doctors.city='$dis' group by practice.doctor_id");
    $res = $this->db->query("select category.category as category from category,(SELECT DISTINCT category FROM doctors WHERE city = '" .$dis . "' and type = 'doctor' ) as t where t.category = category.id");
    // if(!empty($area)){
    // $res1 = $this->db->query("select id,category, name,image from doctors where city = '$dis' and location = '$area'");
    // }
    $res2 = $this->db->query("select doctors.id as id ,doctors.category as category, doctors.name as name,doctors.image as image,doctors.location as location, doctors.type as doc_type from doctors inner join practice on doctors.id=practice.doctor_id and doctors.city = '$dis' and doctors.status != 'Suspended' group by doctors.id");
        $res_clinic = $this->db->query("select * from clinic where city='$dis'");

    if($res->num_rows > 0){
        
        while($data = $res->fetch_assoc()){
            
            $arr1['type']="Speciality";
            $arr1['category']=$data['category'];
            $arr1['image']='';
            $arr[] = $arr1;
        }
    }
    
    // if($res1->num_rows > 0){
        
    //     while($data = $res1->fetch_assoc()){
    //         $category = $data['category'];
    //         $cat = $this->db->query("select category from category where id='$category'");
    //         $cat_data=$cat->fetch_assoc();
    //         $arr2['type']=$cat_data['category'];
    //         $arr2['image']=$data['image'];
    //         $arr2['category']=$data['name'];
    //          $arr[] = $arr2;
    //     }
    // }
    
    if($res2->num_rows > 0){
        
        while($data = $res2->fetch_assoc()){
            $category = $data['category'];
            $cat = $this->db->query("select category from category where id='$category'");
            $cat_data=$cat->fetch_assoc();
            $arr3['type']=$cat_data['category'];
            $arr3['image']=$data['image'];
            $arr3['id']=$data['id'];
            $arr3['locate']=$data['location'];
            $arr3['doc_type']=$data['doc_type'];
            $arr3['category']=$data['name'];
             $arr[] = $arr3;
        }
    }
    
    if($res_clinic->num_rows > 0){
        
        while($data = $res_clinic->fetch_assoc()){
            $arr4['type']="Clinic";
            $arr4['image']=$data['image'];
            $arr4['id']=$data['id'];
            $arr4['category']=$data['name'];
            $arr[]=$arr4;
        }
    }
    
   $keys = json_encode($arr);
        
    }
    
   return $keys;
}*/

public function get_doc_cat1($dis,$area)
{
    $arr = array();
    
      

    if(!empty($area))
	{
    //$res = $this->db->query("select category.category as category from category inner join doctors on category.id=doctors.category inner join practice on doctors.id=practice.doctor_id where doctors.location='$area' and doctors.city='$dis' and doctors.status != 'Suspended' group by practice.doctor_id ");
    $res = $this->db->query("select category.category as category from category,(SELECT DISTINCT category FROM doctors WHERE city = '" .$dis . "' and location = '$area' and type = 'doctor' and status!='Suspended' ) as t where t.category = category.id");
    // if(!empty($area)){
    // $res1 = $this->db->query("select id,category, name,image from doctors where city = '$dis' and location = '$area'");
    // }
    $res2 = $this->db->query("select doctors.id as id ,doctors.category as category, doctors.name as name,doctors.image as image,doctors.location as location, doctors.type as doc_type, doctors.be_name as bename from doctors inner join practice on doctors.id=practice.doctor_id and doctors.city = '$dis' and doctors.location='$area' and doctors.status != 'Suspended' group by doctors.id");
    $res_clinic = $this->db->query("select * from clinic where city='$dis' and area='$area'");
    if($res->num_rows > 0){
        
        while($data = $res->fetch_assoc()){
            
            $arr1['type']="Speciality";
            $arr1['category']=$data['category'];
            $arr1['image']='';
            $arr[] = $arr1;
        }
    }
    
    // if($res1->num_rows > 0){
        
    //     while($data = $res1->fetch_assoc()){
    //         $category = $data['category'];
    //         $cat = $this->db->query("select category from category where id='$category'");
    //         $cat_data=$cat->fetch_assoc();
    //         $arr2['type']=$cat_data['category'];
    //         $arr2['image']=$data['image'];
    //         $arr2['category']=$data['name'];
    //          $arr[] = $arr2;
    //     }
    // }
    
    if($res2->num_rows > 0){
        
        while($data = $res2->fetch_assoc()){
            $category = $data['category'];
            $cat = $this->db->query("select category from category where id='$category'");
            $cat_data=$cat->fetch_assoc();
            $arr3['type']=$cat_data['category'];
            $arr3['image']=base_url_image.'dp/'.$data['image'];
            $arr3['doctor_name']= "/Doctor";
            $arr3['id']=$data['id'];
            $arr3['locate']=$data['location'];
            $arr3['doc_type']=$data['doc_type'];
            $bename= rtrim($data['bename'],'.');
            $arr3['category']=$bename." ".$data['name'];

            //$arr3['category']=$data['name'];
            
            //$arr3['bename']=$bename;
             $arr[] = $arr3;
        }
        $arr3['category']="Doctors";
        $arr3['bename']='';
        $arr3['type']='';
        $arr3['image']='';
        $arr3['id']='';
        $arr3['locate']='';
        $arr3['doc_type']='';
        $arr3['doctor_name']= "";
        $arr[]=$arr3;
    }
    
    if($res_clinic->num_rows > 0){
        
        while($data = $res_clinic->fetch_assoc()){
            $arr4['type']="Clinic";
            $arr4['image']=base_url_image.'dp-clinic/'.$data['image'];
            $arr4['id']=$data['id'];
            $arr4['category']=$data['name'];
            $arr[]=$arr4;
        }
            $arr4['type']="";
            $arr4['image']='';
            $arr4['id']='';
            $arr4['category']='Clinic';
            $arr[]=$arr4;
    }
    

        $sql = "select services from doctors where location = '$area' and city = '$dis' and services != '' ";
        $query = $this->db->query($sql);
        if($query->num_rows > 0) { 
        while($row = $query->fetch_assoc())
        {

            $doc_services = $row['services'];
            $doc_service[] = json_decode($doc_services,true);
        }
        //print_r($doc_service);
        foreach($doc_service as $serv){

            foreach ($serv as $key => $service_in) {
                
                if(is_numeric($service_in['service'])){

                    $values[] = $service_in['service'];
                }
            }
        }
        
        if(count($values) > 0)
        {
            $values = array_unique($values);
            $values = implode(',',$values);

            $service_sql = "select * from services_for_seo_use where id in ($values)";
            $service_query = $this->db->query($service_sql);
            while($rows = $service_query->fetch_assoc())
            {
                 $service_result['type']='Service';
                $service_result['category'] = $rows['services'];
                $service_result['image']='';
                $arr[] = $service_result;
            }
        }
    }
        $sql_spec = "select specialization from doctors where location = '$area' and city = '$dis' and specialization != '' ";
        $query_s = $this->db->query($sql_spec);
        if($query_s->num_rows > 0){
        while($row = $query_s->fetch_assoc())
        {

            $doc_sepec = $row['specialization'];
            $doc_sepecs[] = json_decode($doc_sepec,true);
        }
        //print_r($doc_sepecs);
        foreach($doc_sepecs as $serv1){

            foreach ($serv1 as $key => $doc_sepec_in) {
                
                if(is_numeric($doc_sepec_in['specialization'])){

                    $values1[] = $doc_sepec_in['specialization'];
                }
            }
        }
        if(count($values1) > 0)
        {
            $values1 = array_unique($values1);
            $values1 = implode(',',$values1);

            $doc_sepec_sql = "select * from speciality where id in ($values1)";
            $doc_sepec_query = $this->db->query($doc_sepec_sql);
            while($rows = $doc_sepec_query->fetch_assoc())
            {
                 $doc_sepec_result['type']='Specialization';
                $doc_sepec_result['category'] = $rows['specialization'];
                $doc_sepec_result['image']='';
                $arr[] = $doc_sepec_result;
            }
        }
    }
   $keys = json_encode($arr);
    }  
    
    else {
        
        
        //$res = $this->db->query("select category.category as category from category inner join doctors on category.id=doctors.category inner join practice on doctors.id=practice.doctor_id where doctors.city='$dis' group by practice.doctor_id");
    $res = $this->db->query("select category.category as category from category,(SELECT DISTINCT category FROM doctors WHERE city = '" .$dis . "' and type = 'doctor' ) as t where t.category = category.id");
    // if(!empty($area)){
    // $res1 = $this->db->query("select id,category, name,image from doctors where city = '$dis' and location = '$area'");
    // }
    $res2 = $this->db->query("select doctors.id as id ,doctors.category as category, doctors.name as name,doctors.image as image,doctors.location as location, doctors.type as doc_type,doctors.be_name as bename from doctors inner join practice on doctors.id=practice.doctor_id and doctors.city = '$dis' and doctors.status != 'Suspended' group by doctors.id");
        $res_clinic = $this->db->query("select * from clinic where city='$dis'");

    if($res->num_rows > 0){
        
        while($data = $res->fetch_assoc()){
            
            $arr1['type']="Speciality";
            $arr1['category']=$data['category'];
            $arr1['image']='';
            $arr[] = $arr1;
        }
    }
    
    // if($res1->num_rows > 0){
        
    //     while($data = $res1->fetch_assoc()){
    //         $category = $data['category'];
    //         $cat = $this->db->query("select category from category where id='$category'");
    //         $cat_data=$cat->fetch_assoc();
    //         $arr2['type']=$cat_data['category'];
    //         $arr2['image']=$data['image'];
    //         $arr2['category']=$data['name'];
    //          $arr[] = $arr2;
    //     }
    // }
    
    if($res2->num_rows > 0){
        
        while($data = $res2->fetch_assoc()){
            $category = $data['category'];
            $cat = $this->db->query("select category from category where id='$category'");
            $cat_data=$cat->fetch_assoc();
            $arr3['type']=$cat_data['category'];
            $arr3['image']=base_url_image.'dp/'.$data['image'];
            $arr3['id']=$data['id'];
            $arr3['locate']=$data['location'];
            $arr3['doc_type']=$data['doc_type'];
            $arr3['category']=$data['name'];
            $arr3['doctor_name']= "/Doctor";
            //$bename= rtrim($data['bename'],'.');
            //$arr3['bename']=$bename;
            $bename= rtrim($data['bename'],'.');
            $arr3['category']=$bename." ".$data['name'];
            //$arr3['category']=$data['name'];

             $arr[] = $arr3;
        }
        $arr3['category']="Doctors";
        $arr3['bename']='';
        $arr3['type']='';
        $arr3['image']='';
        $arr3['id']='';
        $arr3['locate']='';
        $arr3['doc_type']='';
        $arr3['doctor_name']= "";
        $arr[]=$arr3;
    }
    
    if($res_clinic->num_rows > 0){
        
        while($data = $res_clinic->fetch_assoc()){
            $arr4['type']="Clinic";
            $arr4['image']=base_url_image.'dp-clinic/'.$data['image'];
            $arr4['id']=$data['id'];
            $arr4['category']=$data['name'];
            $arr[]=$arr4;
        }
            $arr4['type']="";
            $arr4['image']='';
            $arr4['id']='';
            $arr4['category']='Clinic';
            $arr[]=$arr4;
    }

        $sql = "select services from doctors where city = '$dis' and services != '' ";
        $query = $this->db->query($sql);
        if($query->num_rows > 0) 
        {
            while($row = $query->fetch_assoc())
            {

                $doc_services = $row['services'];
                $doc_service[] = json_decode($doc_services,true);
            }
            //print_r($doc_service);
            foreach($doc_service as $serv){

                foreach ($serv as $key => $service_in) {
                    
                    if(is_numeric($service_in['service'])){

                        $values[] = $service_in['service'];
                    }
                }
            }
            if(count($values) > 0)
            {
                $values = array_unique($values);
                $values = implode(',',$values);

                $service_sql = "select * from services_for_seo_use where id in ($values)";
                $service_query = $this->db->query($service_sql);
                while($rows = $service_query->fetch_assoc())
                {
                     $service_result['type']='Service';
                    $service_result['category'] = $rows['services'];
                   $service_result['image']='';
                    $arr[] = $service_result; 
                }
            }
            
        }
        $sql_spec = "select specialization from doctors where city = '$dis' ";
        $query_s = $this->db->query($sql_spec);
        if($query_s->num_rows > 0) 
        {
            while($row = $query_s->fetch_assoc())
            {

                $doc_sepec = $row['specialization'];
                $doc_sepecs[] = json_decode($doc_sepec,true);
            }
            //print_r($doc_service);
            foreach($doc_sepecs as $serv1){

                foreach ($serv1 as $key => $doc_sepec_in) {
                    
                    if(is_numeric($doc_sepec_in['specialization'])){

                        $values1[] = $doc_sepec_in['specialization'];
                    }
                }
            }
            if(count($values1) > 0)
            {
                $values1 = array_unique($values1);
                $values1 = implode(',',$values1);

                $doc_sepec_sql = "select * from speciality where id in ($values1)";
                $doc_sepec_query = $this->db->query($doc_sepec_sql);
                while($rows = $doc_sepec_query->fetch_assoc())
                {
                     $doc_sepec_result['type']='Specialization';
                    $doc_sepec_result['category'] = $rows['specialization'];
                    $doc_sepec_result['image']='';
                    $arr[] = $doc_sepec_result;
                }
            } 
        }
   $keys = json_encode($arr);
        
    }
    
   return $keys;
}



public function getdoctorsalt($city,$loc,$type,$pin,$page,$gender,$experience,$price){
    // echo "hi!!!";
    $start = ($page*10)-10;
    $arr = array();
    $dict =array();
    $cat=-1;
    $res = $this->db->query("SELECT DISTINCT district FROM `area_name` WHERE `pincode` = '$pin' and district='$city'");
    if($res->num_rows>0)
    {
        $res = $this->db->query("SELECT * FROM `doctors` WHERE city='$city' and name like '%".$type."%' ORDER BY LOCATE('$type', name)");
        if($res->num_rows>0)
        {
            $count=$res->num_rows;
            for($i=0;$i<$count;$i++)
            {
                $data = $res->fetch_assoc();
                if(!array_key_exists($data['id'],$dict))
                {
                    array_push($arr,$data);
                    $dict[$data['id']]=1;
                }
                if($cat==-1)
                {
                    $cat = $data['category'];
                }
                
            }
            
        }
        if(!empty($loc))
        {
            if($cat!=-1)
            {
                $res = $this->db->query("SELECT * FROM `doctors` WHERE location='$loc' and category='$cat'");
                if($res->num_rows>0)
                {
                    $count=$res->num_rows;
                    for($i=0;$i<$count;$i++)
                    {
                        $data = $res->fetch_assoc();
                        if(!array_key_exists($data['id'],$dict))
                        {
                            array_push($arr,$data);
                            $dict[$data['id']]=1;
                        }
                    }
                    
                }
                
                $res = $this->db->query("SELECT * FROM `doctors` WHERE pincode='$pin' and category='$cat'");
                if($res->num_rows>0)
                {
                    $count=$res->num_rows;
                    for($i=0;$i<$count;$i++)
                    {
                        $data = $res->fetch_assoc();
                        if(!array_key_exists($data['id'],$dict))
                        {
                            array_push($arr,$data);
                            $dict[$data['id']]=1;
                        }
                    }
                    
                }
                for($i=1;$i<=5;$i++)
                {
                    $res = $this->db->query("SELECT * FROM `doctors` WHERE pincode='".intval($pin)-$i."'and category='$cat'");
                    if($res->num_rows>0)
                    {
                        $count=$res->num_rows;
                        for($i=0;$i<$count;$i++)
                        {
                            $data = $res->fetch_assoc();
                            if(!array_key_exists($data['id'],$dict))
                            {
                                array_push($arr,$data);
                                $dict[$data['id']]=1;
                            }
                        }
                        
                    }
                }
                for($i=1;$i<=5;$i++)
                {
                    $res = $this->db->query("SELECT * FROM `doctors` WHERE pincode='".intval($pin)+$i."' and category='$cat'");
                    if($res->num_rows>0)
                    {
                        $count=$res->num_rows;
                        for($i=0;$i<$count;$i++)
                        {
                            $data = $res->fetch_assoc();
                            if(!array_key_exists($data['id'],$dict))
                            {
                                array_push($arr,$data);
                                $dict[$data['id']]=1;
                            }
                        }
                        
                    }
                }
                $res = $this->db->query("SELECT * FROM `doctors` WHERE city='$city' and category='$cat'");
                if($res->num_rows>0)
                {
                    $count=$res->num_rows;
                    for($i=0;$i<$count;$i++)
                    {
                        $data = $res->fetch_assoc();
                        if(!array_key_exists($data['id'],$dict))
                        {
                            array_push($arr,$data);
                            $dict[$data['id']]=1;
                        }
                    }
                    
                }
            }
            else
            {
                $res = $this->db->query("SELECT * FROM `doctors` WHERE location='$loc'");
                if($res->num_rows>0)
                {
                    $count=$res->num_rows;
                    for($i=0;$i<$count;$i++)
                    {
                        $data = $res->fetch_assoc();
                        if(!array_key_exists($data['id'],$dict))
                        {
                            array_push($arr,$data);
                            $dict[$data['id']]=1;
                        }
                    }
                    
                }
                
            $res = $this->db->query("SELECT * FROM `doctors` WHERE pincode='$pin'");
            if($res->num_rows>0)
            {
                $count=$res->num_rows;
                for($i=0;$i<$count;$i++)
                {
                    $data = $res->fetch_assoc();
                    if(!array_key_exists($data['id'],$dict))
                    {
                        array_push($arr,$data);
                        $dict[$data['id']]=1;
                    }
                }
                
            }
            for($i=1;$i<=5;$i++)
            {
                $res = $this->db->query("SELECT * FROM `doctors` WHERE pincode='".intval($pin)-$i."'");
                if($res->num_rows>0)
                {
                    $count=$res->num_rows;
                    for($i=0;$i<$count;$i++)
                    {
                        $data = $res->fetch_assoc();
                        if(!array_key_exists($data['id'],$dict))
                        {
                            array_push($arr,$data);
                            $dict[$data['id']]=1;
                        }
                    }
                    
                }
            }
            for($i=1;$i<=5;$i++)
            {
                $res = $this->db->query("SELECT * FROM `doctors` WHERE pincode='".intval($pin)+$i."'");
                if($res->num_rows>0)
                {
                    $count=$res->num_rows;
                    for($i=0;$i<$count;$i++)
                    {
                        $data = $res->fetch_assoc();
                        if(!array_key_exists($data['id'],$dict))
                        {
                            array_push($arr,$data);
                            $dict[$data['id']]=1;
                        }
                    }
                    
                }
            }
            $res = $this->db->query("SELECT * FROM `doctors` WHERE city='$city'");
            if($res->num_rows>0)
            {
                $count=$res->num_rows;
                for($i=0;$i<$count;$i++)
                {
                    $data = $res->fetch_assoc();
                    if(!array_key_exists($data['id'],$dict))
                    {
                        array_push($arr,$data);
                        $dict[$data['id']]=1;
                    }
                }
                
            }
                
            }
            
        }
        
    }
    else
    {
        $search = $search1 = '';
        if($gender != '' and $gender != 'all'){$search .= " and gender = '$gender' ";}
        if($experience != '' and $experience > 0){$search .= " and experience between '$experience' and '".($experience-5)."' ";}
        if($experience == 0){$search .= " and experience >= 0 ";}
        
        if($price != '')
        {
            if($gender != '' and $gender != 'all'){$search1 .= " and t1.gender = '$gender' ";}
            if($experience != '' and $experience > 0){$search1 .= " and t1.experience between '$experience' and '".($experience-5)."' ";}
            if($location != ''){$search1 .= " and t1.city = '$city' and t1.category='$type' and t1.location = '$location' ";}else{
                $search1 .= " and t1.city = '$city' and t1.name='$type' ";
            }
            $price_val = explode('-',$price);
            $sql_price = "SELECT t1.* FROM `doctors` as t1 
                    left join practice as t3 
                    on t3.doctor_id = t1.id where t3.consult between ".$price_val[0]." and ".$price_val[1]." $search1  group by t1.id";
        }
        
        if($price == ''){
            $sql_city = "SELECT * FROM `doctors` WHERE city='$city' and name like '%".$type."%' $search ";}else{
               $sql_city = $sql_price;
            }
        $res = $this->db->query($sql_city);
        if($res->num_rows>0)
        {
            $count=$res->num_rows;
            for($i=0;$i<$count;$i++)
            {
                $data = $res->fetch_assoc();
                if(!array_key_exists($data['id'],$dict))
                {
                    array_push($arr,$data);
                    $dict[$data['id']]=1;
                }
                if($cat==-1)
                {
                    $cat = $data['category'];
                }
            }
            
        }
        if(!empty($loc))
        {
            if($price == ''){
                $sql_loc = "SELECT * FROM `doctors` WHERE location='$loc' and category='$cat' $search ";}else{
                $sql_loc = $sql_price;
            }
            
            $res = $this->db->query($sql_loc);
            if($res->num_rows>0)
            {
                $count=$res->num_rows;
                for($i=0;$i<$count;$i++)
                {
                    $data = $res->fetch_assoc();
                    if(!array_key_exists($data['id'],$dict))
                    {
                        array_push($arr,$data);
                        $dict[$data['id']]=1;
                    }
                }
                
            }
            
        }
        
        if($price == ''){
            $sql_1 = "SELECT * FROM `doctors` WHERE city='$city' category='$cat' $search ";}else{
            $sql_1 = $sql_price;
        }
        $res = $this->db->query($sql_1);
        if($res->num_rows>0)
        {
            $count=$res->num_rows;
            for($i=0;$i<$count;$i++)
            {
                $data = $res->fetch_assoc();
                if(!array_key_exists($data['id'],$dict))
                {
                    array_push($arr,$data);
                    $dict[$data['id']]=1;
                }
            }
            
        }
        
    }
    return $arr;

}

public function showclinic($id){
    
    $status = $this->getById($id,'doctors');
    $res2 = $this->db->query("select clinic from doctors where id='$id'");
    while($data=$res2->fetch_assoc()){
        
        $clinic = json_decode($data['clinic'],true);
    }
    
    foreach($clinic as $cids){
        $c_ids[] = $cids['clinic_id'];
    }
    $cids = implode(',',$c_ids);
   
    $sql= "select * from clinic where id in($cids) ";
    $res = $this->db->query($sql);
    $str='';
    if($res->num_rows > 0){
        
        $i = 1;
        while($data=$res->fetch_assoc()){
            if($data['landmark'] == ''){$l_mark = "";}else{$l_mark = '<b>Landmark - '.$data['landmark'].'</b>, ';}
            if($data['area'] == ''){$area = "";}else{$area = $data['area'].', ';}
            if($data['city'] == ''){$city = "";}else{$city = $data['city'];}
            if($data['registration_fee'] != 0){$clic_fee = '<strong>Registration Fees - '.$data['registration_fee'].'</strong><br>';}else{$clic_fee ='';}
            
            $prac_details = $this->getpractice_new($id, $data['id']); 
            $consult = '';
            $doc_timing1 = $doc_timing2 = $doc_timing3 = $doc_timing4 = $doc_timing5 = $doc_timing6 = $doc_timing7 = $week_name = '';
            $timing_week = $timing_week2 = $timing_week3 = $timing_week4 = $timing_week5 = $timing_week6 = $timing_week7= '';
        	foreach($prac_details as $keys=>$prac)
        	{
        	    $consult = $prac['consult'];
        	   
                $doc_timing1 = $doc_timing2 = $doc_timing3 = $doc_timing4 = $doc_timing5 = $doc_timing6 = $doc_timing7 = $week_name = '';
                $timing_week = $timing_week2 = $timing_week3 = $timing_week4 = $timing_week5 = $timing_week6 = $timing_week7= '';
                
                if($prac['check1'] != ''){
                    
                    $day_name = explode(',',$prac['check1']);
                    $k= 0;
                    foreach($day_name as $days){
                       
                        $week_name = explode(',',$prac['check1']);
                        if($k == 0){
                            foreach($week_name as $week_d){
                                $timing_week .= substr($week_d,0,3).', ';
                            }
                        }
                        $timing_week = trim($timing_week, ", ");
                        $doc_timing1 = $timing_week;
                        $doc_timing1 .= "<br>".$prac[$days];
                        if($prac[$days.'1'] != ''){
                            $doc_timing1 .= ' <b>| </b>'.$prac[$days.'1'];
                        }    
                    
                        $k++;
                    }
                }
                if($prac['check2'] != ''){
                    $day_name = explode(',',$prac['check2']);
                    $k= 0;
                   
                    foreach($day_name as $days){
                        
                        $week_name = explode(',',$prac['check2']);
                        if($k == 0){
                            foreach($week_name as $week_d){
                                $timing_week2 .= substr($week_d,0,3).', ';
                            }
                        }
                        $timing_week2 = trim($timing_week2, ", ");
                        $doc_timing2 = "<br>".$timing_week2;
                        $doc_timing2 .= "<br>".$prac[$days];
                        if($prac[$days.'1'] != ''){
                            $doc_timing2 .= ' <b>| </b>'.$prac[$days.'1'];
                        }
                    
                        $k++;
                    }
                }
                if($prac['check3'] != ''){
                    $day_name = explode(',',$prac['check3']);
                    $k= 0;
                    foreach($day_name as $days){
                        
                        $week_name = explode(',',$prac['check3']);
                        if($k == 0){
                            foreach($week_name as $week_d){
                                $timing_week3 .= substr($week_d,0,3).', ';
                            }
                        }
                        $timing_week3 = trim($timing_week3, ", ");
                        $doc_timing3 = "<br>".$timing_week3;
                        $doc_timing3 .= "<br>".$prac[$days];
                        if($prac[$days.'1'] != ''){
                            $doc_timing3 .= ' <b>| </b>'.$prac[$days.'1'];
                        }    
                    
                        $k++;
                    }
                }
                if($prac['check4'] != ''){
                    $day_name = explode(',',$prac['check4']);
                    $k= 0;
                    foreach($day_name as $days){
                        
                        $week_name = explode(',',$prac['check4']);
                        if($k == 0){
                            foreach($week_name as $week_d){
                                $timing_week4 .= substr($week_d,0,3).', ';
                            }
                        }
                        $timing_week4 = trim($timing_week4, ", ");
                        $doc_timing4 = "<br>".$timing_week4;
                        $doc_timing4 .= "<br>".$prac[$days];
                        if($prac[$days.'1'] != ''){
                            $doc_timing4 .= ' <b>| </b>'.$prac[$days.'1'];
                        }
                    
                        $k++;
                    }
                }
                if($prac['check5'] != ''){
                    $day_name = explode(',',$prac['check5']);
                    $k= 0;
                    foreach($day_name as $days){
                        
                        $week_name = explode(',',$prac['check5']);
                        if($k == 0){
                            foreach($week_name as $week_d){
                                $timing_week5 .= substr($week_d,0,3).', ';
                            }
                        }
                        $timing_week5 = trim($timing_week5, ", ");
                        $doc_timing5 = "<br>".$timing_week5;
                        $doc_timing5 .= "<br>".$prac[$days];
                        if($prac[$days.'1'] != ''){
                            $doc_timing5 .= ' <b>| </b>'.$prac[$days.'1'];
                        }
                    
                        $k++;
                    }
                }
                if($prac['check6'] != ''){
                    $day_name = explode(',',$prac['check6']);
                    $k= 0;
                    foreach($day_name as $days){
                        
                        $week_name = explode(',',$prac['check6']);
                        if($k == 0){
                            foreach($week_name as $week_d){
                                $timing_week6 .= substr($week_d,0,3).', ';
                            }
                        }
                        $timing_week6 = trim($timing_week6, ", ");
                        $doc_timing6 = "<br>".$timing_week6;
                        $doc_timing6 .= "<br>".$prac[$days];
                        if($prac[$days.'1'] != ''){
                            $doc_timing6 .= ' <b>| </b>'.$prac[$days.'1'];
                        }
                    
                        $k++;
                    }
                }
                if($prac['check7'] != ''){
                    $day_name = explode(',',$prac['check7']);
                    $k= 0;
                    foreach($day_name as $days){
                        
                        $week_name = explode(',',$prac['check7']);
                        if($k == 0){
                            foreach($week_name as $week_d){
                                $timing_week7 .= substr($week_d,0,3).', ';
                            }
                        }
                        $timing_week7 = trim($timing_week7, ", ");
                        $doc_timing7 = "<br>".$timing_week7;
                        $doc_timing7 .= "<br>".$prac[$days];
                        if($prac[$days.'1'] != ''){
                            $doc_timing7 .= ' <b>| </b>'.$prac[$days.'1'];
                        }
                    
                        $k++;
                    }
                }
        	}
        	if(!empty($doc_timing1)){
        	    $doc_tim = '<div style="margin-left:5px;text-transform:capitalize"><span class="glyphicon glyphicon-time"></span>
                                '.$doc_timing1.$doc_timing2.'<br>'.$doc_timing3.$doc_timing4.$doc_timing5.$doc_timing6.$doc_timing7.'</span> 
                                
                                </div>';
        	    
        	}else{$doc_tim = '';}
        	
            if($i > 3){$style="height:530px;overflow: hidden;";}
            if($consult != 0){$doc_fee = '<strong><i class="fa fa-inr" aria-hidden="true"></i> Consultancy Fees  - '.$consult.'</strong><br>';}else{$doc_fee ='';}
            $c_nme = str_replace('&','and',$data['name']);
            //$c_nme = str_replace(' ','-',$c_nme);
            //$c_nme = str_replace("'",'',$c_nme);
            $c_nme = preg_replace("![^a-z0-9]+!i", "-", $c_nme);
            $city = str_replace('&','and',$city);
            $city = str_replace(' ','-',$city);
            $city = str_replace("'",'',$city);
            $str .= '<div class="row">
                       <div class="col-sm-12 class_height"  id="clinic-see-more" style="'.$style.'">
                        <div class="row" style="">
                            <div class="col-sm-10 col-sm-offset-1 clinic_cards " style="margin-left:22px">
                                <div class="row">
                                 <div class="col-sm-7 clinic-card_sp">
                						<div class="clinic-name" style="color:#666;">
                						    <p style="font-size:1.5em">
                						    <a class="clinic_name" href="'.base_url.$city.'/Clinic/'.$c_nme.'/'.$data['id'].'/" ><b>'.$data['name']. '</b></a><br><span class="clinic_address">'.$l_mark.$area.$city.'</span><br>
                							</p>
                							<div>
                							'.$doc_fee.'
                							<a target="blank" href="http://www.google.com/maps/place/'.$data['latitude'].','.$data['longitude'].'" class="get_direction">View on Map</a>
                							</div>
                						</div>
                					</div>
                                <div class="col-sm-5">';
                                
                                
                                    //$str.= '<span class="clinic_day"><b>Doctor Timing</b> <br> <p><big>Open 24X7</big></p></span></br>';
                                
            				$str.=	'<span class="clinic_day"><b class="doc_time">Doctor Timing</b> '.$doc_tim.'</span>';
                                
            				$str.=	'</div>
                                    
            					   <div class="col-sm-6 clinic-card_sp"><ul class="div-row">';
            							
            							$imgs=$data['benner'];
                                        $value=0;
                                        if($imgs != ''){
                                            $gal = explode(',',$imgs);
                                            $value = count($gal);
                                        }
                    					if($value != 0)
                    					{
                            				for($gal_i = 0; $gal_i <=$value-1; $gal_i++){
                            				
                                            $str.= '<li class="clinic_pic">
                                                <img src="'.base_url.'image/clinic-gallery/'.$gal[$gal_i].'" class="clinic_image"/>
                                                </li>';
                                            
                            				}
                    					}

            				$str.=	'		</ul></div>	
                						<div class="col-sm-6" align="right">
                							<div class="col-sm-12" align="right">';
                			 $form_hidden = '<input type="hidden" name="cid" value="'.$data['id'].'">
                			                 <input type="hidden" name="did" value="'.$_GET['id'].'">
                			                 <input type="hidden" name="date" value="'.date('Y-m-d').'">
                			                 <input type="hidden" name="time" value="'.date('h:i A').'">
                			                 <input type="hidden" name="request_for_call" value="true">';
                			 if($data['allow'] == 1 && $status['status']!='Suspended'){
                			    
                			    if($prac['allow'] == 1 && $status['status']!='Suspended'){
                			        $str .=	'<form method="GET" action="'.base_url.'appointmentfilldata.php"><center><input type="hidden" name="cid" value="'.$data['id'].'"><input type="hidden" name="id" value="'.$_GET['id'].'"><input type="submit" name ="book_an_appointment" class="clinic_call_now" value="Book an Appointment"></center></form>';
                			    }
                			    elseif($prac['allow'] == 2 && $status['status']!='Suspended'){
                                    $str .= '<form method="GET" action="'.base_url.'bookappointment.php">'.$form_hidden.'<center><input type="submit" name ="req_for_call" class="clinic_call_now" value="Request for Call"></center></form>';            			        
                			    }
                			 }if($data['allow'] == 2 && $status['status']!='Suspended'){
                			    
                			     $str .= '<form method="GET" action="'.base_url.'bookappointment.php">'.$form_hidden.'<center><input type="submit" name ="req_for_call" class="clinic_call_now" value="Request for Call"></center></form>';
                			 }
                			 $str .=	'</div>
                						</div>
                				</div>
                			</div>
                		</div>
                	</div>
                   </div>';
                  
                    if($i > 3){
                        $str .= '<div class="row"><p id="clinic_view_more" >View More<span class="caret" style="font-size: 10px; margin-left: 5px;"></span></p></div>';
                    }   
                  
        
            $i++;
        }
    }
    return $str;
}

public function add_new_member($patient_name,$email,$phone_no,$area,$parent_id,$gender,$dob){
    
    $result = $this->db->query("select * from patient where patient_id='$parent_id' and parent_id='$parent_id'");
    $data_res = $result->fetch_assoc();
    
    $res = $this->db->query("select max(patient_id) as patient_id from patient ");
    $data=$res->fetch_assoc();
    $patient_id = $data['patient_id']+1;
    $date = date('Y-m-d');
    // echo $patient_id;
    // echo $email;
    // echo $area;
    $res1 = $this->db->query("insert into patient(name,patient_id,email,phone_no,city,parent_id,gender,dob,date)values('$patient_name','$patient_id','$email',$phone_no,'$area','$parent_id','$gender', '$dob', '$date')");
    
    if($res1){
        
        /*$msg = '<div style="width:100%; height:100%; margin:0;" >

	<div style="width:90%; float:left; height:70px;padding:30px;">

		<span style="width:50%;float:left"> <a href="https://docconsult.in"><img src="https://docconsult.in/image/logo.png"  style="height:70px"/></span></a>

		<span style="width:50%; text-align:right;float:left;font-size: 17px;">  <br /><b> </span>

	</div>

	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Hello '.$patient_name.', <br></div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Welcome To docconsult.in</div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">You have successfully added yourself to '.$data_res['name'].' account on Docconsult. </div>
	
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Thank You</div>';*/
	
	
	$msg = '<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: linear-gradient(to right, #2D9CDB, #2F5894);">
	<tr>
		<td></td>
		<td class="header container">
			
			<div style="max-width: 630px;    margin: 0 auto;    display: block;">
			<table>
				<tr>
					<td><a href="'.base_url.'"><img src="'.base_url.'/image/logo.png" alt="logo" ></a></td>
					
				</tr>
			</table>
			</div>
			
		</td>
		<td></td>
	</tr>
</table>

<!---content demo -->
<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: #f5f5fa; ">
	<tr>
		<td></td>
		<td class="header container">
			
			<div style="max-width: 600px;    margin: 0 auto;    display: block;">
			<table>
					<tr>
						<td>
						<br>
							<h3>Hello '.$patient_name.', </h3>
							<h3>Welcome To <a href="https://www.docconsult.in/>docconsult.in</a></h3>
							<p class="lead">You have successfully added yourself to '.$data_res['name'].' account on Docconsult. </p>
							<h4>Thank You For Using Docconsult.</h4>
							<p class="lead">Regards,</p>
                            <p class="lead">Docconsult Team</p>	
						</td>
					</tr>
				</table>
			</div>			
		</td>
		<td></td>
	</tr>
</table>
<!---content demo End-->
<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: linear-gradient(to right, #2D9CDB, #2F5894);">
	<tr>
		<td></td>
		<td class="header container">
			
			<div style="max-width: 630px;    margin: 0 auto;    display: block;">
			<table>
				<tr>
					<td><a href="'.base_url.'"><img src="'.base_url.'/image/logo.png" alt="logo" ></a>
					<p style="  font-size: 12px;     margin: 2px 10px;  color:#fff;">Contact NO : <strong> 0141-2785199</strong></p>
					<p style="  font-size: 12px;      margin: 2px 10px;  color:#fff;">Email: <strong><a href="emailto:service@docconsult.in" style="color:#fff;">service@docconsult.in</a></strong></p>
					<p style="   font-size: 12px;     margin: 2px 10px;  color:#fff;">Copyright © 2017 DocConsult | All Right Reserved 2016</p>	</td>
					
					<td style="text-align: right;    width: 50%;">
					<p style="float: right; text-align: right; margin-right: 0px; margin-top: 60px;">
                                                        <a href="https://www.facebook.com/docconsult/"><img src="'.base_url.'image/F.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a> 
                                                        <a href="https://twitter.com/Docconsult12"><img src="'.base_url.'image/T.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a>
                                                        <a href="https://www.youtube.com/channel/UCroHJE8lYtX3Wz9j233Dtwg"><img src="'.base_url.'image/Y.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a>
                                                        <a href="https://www.instagram.com/docconsultservices/"><img src="'.base_url.'image/I.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a> 
                                                        <a href="https://www.linkedin.com/in/docconsult-services-a70a72134/"><img src="'.base_url.'image/L.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a></br>
                                                        </p></td>
				</tr>
			</table>
			</div>
			
		</td>
		<td></td>
	</tr>
</table>';
	
	/*$msg_parent = '<div style="width:100%; height:100%; margin:0;" >

	<div style="width:90%; float:left; height:70px;padding:30px;">

		<span style="width:50%;float:left"> <a href="https://docconsult.in"><img src="https://docconsult.in/image/logo.png"  style="height:70px"/></span></a>

		<span style="width:50%; text-align:right;float:left;font-size: 17px;">  <br /><b> </span>

	</div>

	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Hello '.$data_res['name'].', <br></div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Greetings from docconsult.in</div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">'.$patient_name.' added successfully to your account on Docconsult. </div>
	
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Thank You</div>';*/



    $msg_parent = '<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: linear-gradient(to right, #2D9CDB, #2F5894);">
    <tr>
        <td></td>
        <td class="header container">
            
            <div style="max-width: 630px;    margin: 0 auto;    display: block;">
            <table>
                <tr>
                    <td><a href="'.base_url.'"><img src="'.base_url.'/image/logo.png" alt="logo" ></a></td>
                    
                </tr>
            </table>
            </div>
            
        </td>
        <td></td>
    </tr>
</table>

<!---content demo -->
<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: #f5f5fa; ">
    <tr>
        <td></td>
        <td class="header container">
            
            <div style="max-width: 600px;    margin: 0 auto;    display: block;">
            <table>
                    <tr>
                        <td>
                        <br>
                            <h3>Hello '.$data_res['name'].', <br></h3>
                            <h3>Greetings from <a href="https://www.docconsult.in/>docconsult.in</a></h3>
                            <p class="lead">'.$patient_name.' added successfully to your account on Docconsult.</p>
                            <br>
                            <h4>Thank You For Using Docconsult.</h4>
                            <p class="lead">Regards,</p>
                            <p class="lead">Docconsult Team</p>
                            
                        </td>
                    </tr>
                </table>
            </div>          
        </td>
        <td></td>
    </tr>
</table>
<!---content demo End-->

<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: linear-gradient(to right, #2D9CDB, #2F5894);">
    <tr>
        <td></td>
        <td class="header container">
            
            <div style="max-width: 630px;    margin: 0 auto;    display: block;">
            <table>
                <tr>
                    <td><a href="'.base_url.'"><img src="'.base_url.'/image/logo.png" alt="logo" ></a>
                    <p style="  font-size: 12px;     margin: 2px 10px;  color:#fff;">Contact NO : <strong> 0141-2785199</strong></p>
                    <p style="  font-size: 12px;      margin: 2px 10px;  color:#fff;">Email: <strong><a href="emailto:service@docconsult.in" style="color:#fff;">service@docconsult.in</a></strong></p>
                    <p style="   font-size: 12px;     margin: 2px 10px;  color:#fff;">Copyright © 2017 DocConsult | All Right Reserved 2016</p> </td>
                    
                    <td style="text-align: right;    width: 50%;">
                    <p style="float: right; text-align: right; margin-right: 0px; margin-top: 60px;">
                                                        <a href="https://www.facebook.com/docconsult/"><img src="'.base_url.'image/F.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a> 
                                                        <a href="https://twitter.com/Docconsult12"><img src="'.base_url.'image/T.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a>
                                                        <a href="https://www.youtube.com/channel/UCroHJE8lYtX3Wz9j233Dtwg"><img src="'.base_url.'image/Y.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a>
                                                        <a href="https://www.instagram.com/docconsultservices/"><img src="'.base_url.'image/I.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a> 
                                                        <a href="https://www.linkedin.com/in/docconsult-services-a70a72134/"><img src="'.base_url.'image/L.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a></br>
                                                        </p></td>
                </tr>
            </table>
            </div>
            
        </td>
        <td></td>
    </tr>
</table>';





	
	/*$msg_admin = '<div style="width:100%; height:100%; margin:0;" >

	<div style="width:90%; float:left; height:70px;padding:30px;">

		<span style="width:50%;float:left"> <a href="'.base_url.'"><img src="'.base_url.'/image/logo.png" alt="logo" ></a></span>

		<span style="width:50%; text-align:right;float:left;font-size: 17px;">  <br /><b> </span>

	</div>

	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Name: '.$patient_name.', <br></div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Mobile no :'.$phone_no. '</div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Have successfully added himself/herself to '.$data_res['name'].'-'.$data_res['phone_no'].' account. </div>';*/








    $msg_admin = '<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: linear-gradient(to right, #2D9CDB, #2F5894);">
    <tr>
        <td></td>
        <td class="header container">
            
            <div style="max-width: 650px;    margin: 0 auto;    display: block;">
        <a href="'.base_url.'"><img src="'.base_url.'/image/logo.png" alt="logo" ></a>
            </div>
            
        </td>
        <td></td>
    </tr>
</table>

<!---content demo -->
<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: #f5f5fa; ">
    <tr>
        <td></td>
        <td class="header container">
            
            <div style="max-width: 630px;    margin: 0 auto;    display: block;">
            <table>
                    <tr>
                        <td>
                        <br>
                            <h3>Hello , Admin <br></h3> 
                        </td>
                    </tr>
                </table>
            </div>          
        </td>
        <td></td>
    </tr>
</table>
<!---content demo End-->
<table class="head-wrap" style="width: 650px;    background: #f5f5fa;    margin: 0 auto; ">
    <tr>
        <td></td>
        <td class="header container">
            
            <!-- content -->
            <div style="max-width: 630px;    margin: 0 auto;    display: block;">
                <table>
  
   <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;   min-width: 180px; font-weight: bold;  text-align: left;   float:left;">Patient name:

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;      text-align: center;     ">'.$patient_name.', </span></td>
    
  </tr>
   
 
   <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;   min-width: 180px; font-weight: bold;  text-align: left;   float:left;">Patient mobile no :

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;      text-align: center;     ">  '.$phone_no. '/span></td>
    
  </tr>
   
                
                    <tr>    
                        <td></td><td></td>
                    </tr>
                </table>
            </div>
            <!-- COLUMN WRAP -->
            
            <div  style="max-width: 630px;     margin: 0 auto;    display: block;">
                <table>
                    <tr>
                        <td> <p class="lead">Have successfully added himself/herself to '.$data_res['name'].'-'.$data_res['phone_no'].' account. </p>
                             <h4>Thank You, For Using Docconsult.</h4>
                             <p class="lead">Regreds , <br>
                             DocConsult Team</p>
                        </td>
                        </tr>
                    </tr>
                </table>
            </div>
        </td>
        <td></td>       <!---Footer End--->
    </tr>   
</table>

<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: linear-gradient(to right, #2D9CDB, #2F5894);">
    <tr>
        <td></td>
        <td class="header container">
            
            <div style="max-width: 630px;    margin: 0 auto;    display: block;">
            <table>
                <tr>
                    <td><a href="'.base_url.'"><img src="'.base_url.'/image/logo.png" alt="logo" ></a>
                    <p style="  font-size: 12px;     margin: 2px 10px;  color:#fff;">Contact NO : <strong> 0141-2785199</strong></p>
                    <p style="  font-size: 12px;      margin: 2px 10px;  color:#fff;">Email: <strong><a href="emailto:service@docconsult.in" style="color:#fff;">service@docconsult.in</a></strong></p>
                    <p style="   font-size: 12px;     margin: 2px 10px;  color:#fff;">Copyright © 2017 DocConsult | All Right Reserved 2016</p> </td>
                    
                    <td style="text-align: right;    width: 50%;">
                    <p style="float: right; text-align: right; margin-right: 0px; margin-top: 60px;">
                                                        <a href="https://www.facebook.com/docconsult/"><img src="'.base_url.'image/F.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a> 
                                                        <a href="https://twitter.com/Docconsult12"><img src="'.base_url.'image/T.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a>
                                                        <a href="https://www.youtube.com/channel/UCroHJE8lYtX3Wz9j233Dtwg"><img src="'.base_url.'image/Y.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a>
                                                        <a href="https://www.instagram.com/docconsultservices/"><img src="'.base_url.'image/I.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a> 
                                                        <a href="https://www.linkedin.com/in/docconsult-services-a70a72134/"><img src="'.base_url.'image/L.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a></br>
                                                        </p></td>
                </tr>
            </table>
            </div>
            
        </td>
        <td></td>
    </tr>
</table>';
	
	
	
	 
	 
	 $this->foremail($data_res['email'],$msg_parent,'kavitajha.docconsult@gmail.com','Member added with Docconsult');
        $this->foremail($email,$msg,'kavitajha.docconsult@gmail.com','Member added with Docconsult');
        $this->foremail('kavitajha.docconsult@gmail.com',$msg_admin,'kavitajha.docconsult@gmail.com','Member added with Docconsult');
	
	  //  $this->foremail($data_res['email'],$msg_parent,'service@docconsult.in','Member added with Docconsult');
       // $this->foremail($email,$msg,'service@docconsult.in','Member added with Docconsult');
       // $this->foremail('info@docconsult.in',$msg_admin,'service@docconsult.in','Member added with Docconsult');
    
    return TRUE;
}
}
public function clinic_count_feedback($clinic_id){
    
    $res=$this->db->query("select count(*) as count from feedback where doctor_id='$clinic_id' ");	
    
    $data=$res->fetch_assoc();
    
    return $data['count'];
}

public function clinic_feedback_front($clinic_id)
{
    
	//$patient_id=@$_SESSION['patient_login_id'];
	
	//$res=$this->db->query("select * from feedback where clinic_id='$clinic_id' and clinic_id='' order by date DESC");	
	
    $doc_query =$this->db->query("select name from doctors where id='$clinic_id' ");
    $doc_data = $doc_query->fetch_assoc();
        
	$res=$this->db->query("select * from feedback where doctor_id='$clinic_id' order by date DESC limit 5 ");	 

	$count=0;
    $num =1;
	$str='';
                                 
	if($res->num_rows> 0)
	{
		while($data=$res->fetch_assoc())
		{   
	    (float)$stars= ($data['rate']+$data['rate1']+$data['rate2']+$data['rate3'])/4; 
		$whole = floor($stars);
		(float) $decimal = $stars-$whole;
		  $date = strtotime($data['date']);
		  
		  $date1 = date('d-m-Y',$date);
		  $res1 = $this->getById($data['patient_id'],'patient');
			$str.=' <div class="feed_card  shadow">
        					    <h4 class="pull-left"><b>'.$res1['name'].'</b> <small style="font-size:10px">on &nbsp'. $date1.'</small></h4>
        					    <div class="col-sm-6 col-xs-12  star-rating-widget pull-right">
        					            <h4 style="float:right">';
        					 for($i=1;$i<=5;$i++){
        					     
        					     if($whole>=$i){
        					       $str.= ' <i class="fa fa-star stars"></i>';
        					       
        					     }
        					     elseif($i>$whole && $decimal!=0){
        					         $str.= ' <i class="fa fa-star-half-empty stars"></i>';
        					         $decimal=0;
        					     }
        					     
        					     else{
        					        $str.= '<i class="fa fa-star-o stars"></i>';
        					     }
        					 }           
 				                
        					   $str.='        </h4>
        					        </div>
        					    
        					    <div class="clearfix"></div>
        					        <div class="row nopadding" >
        					            <div class="col-sm-3 col-xs-6 rate-type-widget">
        					                <h6><img src="image/plugin.png" width="30px" height="30px"> <b>'.$data['rate3'].'</b></h6>
        					                <h6>  Facilities</h6>
        					            </div>
        					            <div class="col-sm-3 col-xs-6 rate-type-widget punctuality">
        					                <h6><img src="image/value.png" width="30px" height="30px"> <strong>'.$data['rate2'].'</strong></h6>
        					                <h6> value </h6>
        					            </div>
        					            <div class="col-sm-3 col-xs-6 rate-type-widget">
        					                <h6><img src="image/clieanliness.png" width="30px" height="30px"> <strong>'.$data['rate1'].'</strong></h6>
        					                <h6> Cleanliness</h6>
        					            </div>
        					            <div class="col-sm-3 col-xs-6 rate-type-widget knowledge" >
        					                <h6><img src="image/services.png" width="30px" height="30px"> <strong>'.$data['rate'].'</strong></h6>
        					                <h6>Services</h6>
        					            </div>
        					        </div>
        					        
        					        <div class="col-sm-12" style="padding: 0 0 0 12px;">
        					            <p style="font-size:12px">'.$data['description'];
        					            if($data['reply']){
        					            
        					            $str.='<div class="col-sm-12 feed_reply">
        					                <span class="reply_heading"><strong><small>Reply by Dr. '.$doc_data['name'].'</small></strong></span>'.$data['reply'].'
        					                
        					                </div>';
        					            }
        					   $str.='         
        					            </p>
        					        </div>
        					    </div>
        				
			
			
                                   ';
			}	
			$num++ ;
			
			}	
	
	
	
	 return $str;
	
}

public function count_feedback($doc_id){
    
    $res=$this->db->query("select count(*) as count from feedback where doctor_id='$doc_id' ");	
    
    $data=$res->fetch_assoc();
    
    return $data['count'];
}
public function feedback_front($doc_id)
{
    
	//$patient_id=@$_SESSION['patient_login_id'];
	
	//$res=$this->db->query("select * from feedback where patient_id='$patient_id' and doctor_id='' order by date DESC");	
	
    $doc_query =$this->db->query("select name from doctors where id='$doc_id' ");
    $doc_data = $doc_query->fetch_assoc();
        
	$res=$this->db->query("select * from feedback where doctor_id='$doc_id' order by date DESC limit 5 ");	 

	$count=0;
    $num =1;
	$str='';
                                 
	if($res->num_rows> 0)
	{
		while($data=$res->fetch_assoc())
		{   
	    (float)$stars= ($data['rate']+$data['rate1']+$data['rate2']+$data['rate3'])/4; 
		$whole = floor($stars);
		(float) $decimal = $stars-$whole;
		  $date = strtotime($data['date']);
		  
		  $date1 = date('d-m-Y',$date);
		  $res1 = $this->getById($data['patient_id'],'patient');
			$str.=' <div class="feed_card  shadow">
        					    <h4 class="pull-left"><b>'.$res1['name'].'</b> <small style="font-size:10px">on &nbsp'. $date1.'</small></h4>
        					    <div class="col-sm-6 col-xs-12  star-rating-widget pull-right">
        					            <h4 style="float:right">';
        					 for($i=1;$i<=5;$i++){
        					     
        					     if($whole>=$i){
        					       $str.= ' <i class="fa fa-star stars"></i>';
        					       
        					     }
        					     elseif($i>$whole && $decimal!=0){
        					         $str.= ' <i class="fa fa-star-half-empty stars"></i>';
        					         $decimal=0;
        					     }
        					     
        					     else{
        					        $str.= '<i class="fa fa-star-o stars"></i>';
        					     }
        					 }           
        					                
        					                
        					           
        					                
        					            
        					                
        					   $str.='        </h4>
        					        </div>
        					    
        					    <div class="clearfix"></div>
        					        <div class="row nopadding" >
        					            <div class="col-sm-3 col-xs-6 rate-type-widget">
        					                <h6><i class="glyphicon glyphicon-user"></i> <b>'.$data['rate3'].'</b></h6>
        					                <h6>Staff</h6>
        					            </div>
        					            <div class="col-sm-3 col-xs-6 rate-type-widget punctuality">
        					                <h6><i class="glyphicon glyphicon-time"></i> <strong>'.$data['rate2'].'</strong></h6>
        					                <h6>On Time</h6>
        					            </div>
        					            <div class="col-sm-3 col-xs-6 rate-type-widget">
        					                <h6><i class="glyphicon glyphicon-question-sign"></i> <strong>'.$data['rate1'].'</strong></h6>
        					                <h6>Productive</h6>
        					            </div>
        					            <div class="col-sm-3 col-xs-6 rate-type-widget knowledge" >
        					                <h6><i class="fa fa-lightbulb-o"></i> <strong>'.$data['rate'].'</strong></h6>
        					                <h6>Knowledge</h6>
        					            </div>
        					        </div>
        					        
        					        <div class="col-sm-12" style="padding: 0 0 0 12px;">
        					            <p style="font-size:12px">'.$data['description'];
        					            if($data['reply']){
        					            
        					            $str.='<div class="col-sm-12 feed_reply">
        					                <span class="reply_heading"><strong><small>Reply by Dr. '.$doc_data['name'].'</small></strong></span>'.$data['reply'].'
        					                
        					                </div>';
        					            }
        					   $str.='         
        					            </p>
        					        </div>
        					    </div>
        				
			
			
                                   ';
			}	
			$num++ ;
			
			}	
	
	
	
	 return $str;
	
}

public function add_profile_hits($id){
    $date=date('Y-m-d');
    
    $res = $this->db->query("select * from hits where doctor_id='$id' and date='$date'");
    
    if($res->num_rows > 0){
        
        $data = $res->fetch_assoc();
        
        $hits = $data['hits']+1;
        $res1 = $this->db->query("update hits set hits='$hits' where doctor_id='$id' and date='$date' ");
    }
    
    else {
        
        $res1 = $this->db->query("insert into hits(hits,date,doctor_id) values('1','$date','$id')");
    }
}

public function show_doc_name($id){
    
    $res = $this->db->query("select be_name,name,specialization,image from doctors where id='$id'");
    
    $data = $res->fetch_assoc();
    return $data;
}

public function show_clinic_name($id){
    
    $res = $this->db->query("select name from clinic where id='$id'");
    $data = $res->fetch_assoc();
    return $data['name'];
}

public function check_patient_exist_by_phone($phone){
    
    $check = $this->db->query("select * from patient where phone_no = '$phone'");
    $num = $check->num_rows;
    if($num  > 0){
        return $check->fetch_assoc();
    }else{
        return false;
    }    
}
public function check_doctor_exist_by_phone($phone){
    
    $check = $this->db->query("select * from doctors where phone_no = '$phone'");
    $num = $check->num_rows;
    if($num  > 0){
        return $check->fetch_assoc();
    }else{
        return false;
    }    
}

public function send_otp_new_patient($phone, $otp){
   // echo $otp;
    $msg='Your Docconsult.in Verification OTP '.$otp;
    $msg = str_replace("<", "", $msg);
    $msg = str_replace(">", "", $msg);
    $msg = rawurlencode($msg);
		
     //$send_sms_url = 'http://www.sms.jprinfotech.com/api/sendhttp.php?authkey=4296AbkgvkyLHP2b584bb4a2&mobiles='.$phone_no.'&message='.$msg.'&sender='.sender_id.'&route=4';
       $send_sms_url='http://sms.digialaya.com/API/SMSHttp.aspx?UserId=docconsultadmin&pwd=pwd2017&Message='.$msg.'&Contacts='.$phone.'&SenderId=DOCCON&ServiceName=SMSTRANS&StartTime=';
     $send_sms_url = str_replace(" ", "%20", $send_sms_url);
     
     $ch = curl_init();
     $timeout = 5;
     curl_setopt($ch, CURLOPT_URL, $send_sms_url);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
     curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
     curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
     curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
     curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
     $data = curl_exec($ch);
     curl_close($ch);
     return true;
}

public function insert_appointment_new_patient($app_time,$name,$email,$phone_no,$area,$symptoms,$date,$cid,$did, $gender, $dob, $age)
{
	$date = date('Y-m-d');
	$pass = sha1($phone_no);
	$d=$this->db->query("insert into patient(name, email, password, phone_no, area, gender, dob, age, date) 
	values('$name','$email','$pass','$phone_no','$area', '$gender', '$dob', '$age', '$date')");

	$query = $this->db->query("select * from patient order by id desc limit 1 ");
	$res1 = $query->fetch_assoc();
    $table_id = $res1['id'];

    $res2 = $this->db->query("select MAX(patient_id) as patient_max_id from patient");    
    $data2 = $res2->fetch_assoc();
    $patient_id = $data2['patient_max_id']+1;

    $this->db->query("update patient set patient_id = '$patient_id', parent_id = '$table_id' where id = '$table_id' ");


	
	$ap=$this->db->query("insert into appointments(parent_id, patient_name, patient_email, app_time, app_date, doctor_id, phone_no, patient_id, clinic_id, status, area,symptoms) 
	values('$table_id','$name','$email','$app_time','$date','$did','$phone_no','$patient_id','$cid','Pending', '$area','$symptoms')");
	
	$activity_name = "Add Appointment";
	$date = date("Y-m-d");
	$time = date("h:i");
	$res = $this->db->query("insert into activity(name,patient_id,doctor_id,action,date,time) values('$activity_name','$name','$did','added','$date','$time')");


	$doctors =  $this->insert_into_patient_doctorblob($patient_id,$did);
    $patients = $this->insert_into_doctor_patientblob($did,$patient_id);
    
    $data1=$this->db->query("Select * from appointments where patient_id = '$patient_id' and phone_no = '$phone_no' order by id DESC LIMIT 1");
    $app_id=$data1->fetch_assoc();
    $app_id=$app_id['id'];
    
    $cdetails=$this->db->query("select name from clinic where id='$cid'");
    $cdetails=$cdetails->fetch_assoc();
    $clinic_name=$cdetails['name'];
    
    $insert_token=$this->db->query("INSERT INTO `token` (`id`, `app_id`, `patient_id`, `patient_name`, `doctor_id`, `app_time`, `app_date`,`clinic_name`,`token_no`,`status`) 
    VALUES (NULL, '$app_id', '$patient_id', '$name', '$did', '$app_time', '$date','$clinic_name','1','pending');");
	$shuffle=$this->token_shuffle($app_date,$did);
	
	$doc_details = $this->getById($did,'doctors');
    $clinic_details = $this->getById($cid,'clinic');
    
   /* $msg_doc='<div style="width:100%; height:100%; margin:0;" >

	<div style="width:90%; float:left; height:70px;padding:30px;">

		<span style="width:50%;float:left"> <a href="https://docconsult.in"><img src="https://docconsult.in/image/logo.png"  style="height:70px"/></span></a>

		<span style="width:50%; text-align:right;float:left;font-size: 17px;">  <br /><b> </span>

	</div>

	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Hello &nbsp;'.$doc_details['be_name'].$doc_details['name'].', <br></div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">One Appointment has been generated for you with <b>Docconsult</b> 
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Patient name: &nbsp;'.$res1['name'].' </div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Patient mobile no: &nbsp;'.$phone_no.' </div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Appointment Date: &nbsp;'.$date.' </div>
    <div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Appointment Time: &nbsp;'.$app_time.' </div>
    <div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Area: &nbsp;'.$area.' </div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Clinic: &nbsp;'.$clinic_details['name'].' </div>
	
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Thank You</div>';*/




    $msg = '<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: linear-gradient(to right, #2D9CDB, #2F5894);">
    <tr>
        <td></td>
        <td class="header container">
            
            <div style="max-width: 650px;    margin: 0 auto;    display: block;">
        <a href="'.base_url.'"><img src="'.base_url.'/image/logo.png" alt="logo" ></a>
            </div>
            
        </td>
        <td></td>
    </tr>
</table>

<!---content demo -->
<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: #f5f5fa; ">
    <tr>
        <td></td>
        <td class="header container">
            
            <div style="max-width: 630px;    margin: 0 auto;    display: block;">
            <table>
                    <tr>
                        <td>
                        <br>
                            <h3>Hello &nbsp;'.$doc_details['be_name'].$doc_details['name'].', <br></h3>
                            <p class="lead">One Appointment has been generated for you with <b>Docconsult</b>
                            </p> 
                        </td>
                    </tr>
                </table>
            </div>          
        </td>
        <td></td>
    </tr>
</table>
<!---content demo End-->
<table class="head-wrap" style="width: 650px;    background: #f5f5fa;    margin: 0 auto; ">
    <tr>
        <td></td>
        <td class="header container">
            
            <!-- content -->
            <div style="max-width: 630px;    margin: 0 auto;    display: block;">
                <table>
<tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
 <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;   min-width: 180px; font-weight: bold;   text-align: left;  float:left;">Request A Call ID :
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;     ">&nbsp;'.$token.'</span>
</td>
    
  </tr>

  <tr>
   <td >
   <h4>Patient Details</h4>
   </td> 
  </tr>
  
   <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;   min-width: 180px; font-weight: bold;  text-align: left;   float:left;">Patient name:

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;      text-align: center;     ">&nbsp;'.$res1['name'].'</span></td>
    
  </tr>
   <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;   min-width: 180px; font-weight: bold;  text-align: left;   float:left;">Patient Gender  :

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;      text-align: center;     ">&nbsp;'.$gender.' </span></td>
    
  </tr>
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;   min-width: 180px; font-weight: bold;  text-align: left;   float:left;">Patient Email  :

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;      text-align: center;     ">&nbsp;'.$email.' </span></td>
    
  </tr>
   <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;   min-width: 180px; font-weight: bold;  text-align: left;   float:left;">Patient mobile no :

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;      text-align: center;     ">  &nbsp;'.$phone_no.'/span></td>
    
  </tr>
   <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;   min-width: 180px; font-weight: bold;  text-align: left;   float:left;">Area  :

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;      text-align: center;     ">&nbsp;'.$area.' </span></td>
    
  </tr>
                <tr>
   <td >
   <h4>Appointments Details</h4>
   </td> 
  </tr>

  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;  min-width: 180px;font-weight: bold;   text-align: left;   float:left;">Doctor Name :
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;      ">&nbsp;'.$doc_details['be_name'].$doc_details['name'].'</span></td>
    
  </tr>
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;min-width: 180px; font-weight: bold;   text-align: left;  float:left;">Appointment Date: 

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;    "> &nbsp;'.$date.' </span></td>
    
  </tr>
  
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;min-width: 180px; font-weight: bold;   text-align: left;  float:left;">Appointment Time: 

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;    "> &nbsp;'.$app_time.'  </span></td>
    
  </tr>
  
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;min-width: 180px; font-weight: bold;   text-align: left;  float:left;">Clinic Name:

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;    "> &nbsp;'.$clinic_details['name'].' </span></td>
    
  </tr>
  
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;min-width: 180px; font-weight: bold;   text-align: left;  float:left;">Clinic Address :

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;    "> &nbsp;'.$clinic_details['address'].'</span></td>
    
  </tr>
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;min-width: 180px; font-weight: bold;   text-align: left;  float:left;">Clinic area :

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;    "> &nbsp;'.$clinic_details['city'].'</span></td>
    
  </tr>
           
                    <tr>    
                        <td></td><td></td>
                    </tr>
                </table>
            </div>
            <!-- COLUMN WRAP -->
            
            <div  style="max-width: 630px;     margin: 0 auto;    display: block;">
                <table>
                    <tr>
                        <td>
                             <h4>Thank You, For Using Docconsult.</h4>
                             <p class="lead">Regreds , <br>
                             DocConsult Team</p>
                        </td>
                        </tr>
                    </tr>
                </table>
            </div>
        </td>
        <td></td>       <!---Footer End--->
    </tr>   
</table>

<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: linear-gradient(to right, #2D9CDB, #2F5894);">
    <tr>
        <td></td>
        <td class="header container">
            
            <div style="max-width: 630px;    margin: 0 auto;    display: block;">
            <table>
                <tr>
                    <td><a href="'.base_url.'"><img src="'.base_url.'/image/logo.png" alt="logo" ></a>
                    <p style="  font-size: 12px;     margin: 2px 10px;  color:#fff;">Contact NO : <strong> 0141-2785199</strong></p>
                    <p style="  font-size: 12px;      margin: 2px 10px;  color:#fff;">Email: <strong><a href="emailto:service@docconsult.in" style="color:#fff;">service@docconsult.in</a></strong></p>
                    <p style="   font-size: 12px;     margin: 2px 10px;  color:#fff;">Copyright © 2017 DocConsult | All Right Reserved 2016</p> </td>
                    
                    <td style="text-align: right;    width: 50%;">
                    <p style="float: right; text-align: right; margin-right: 0px; margin-top: 60px;">
                                                        <a href="https://www.facebook.com/docconsult/"><img src="'.base_url.'image/F.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a> 
                                                        <a href="https://twitter.com/Docconsult12"><img src="'.base_url.'image/T.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a>
                                                        <a href="https://www.youtube.com/channel/UCroHJE8lYtX3Wz9j233Dtwg"><img src="'.base_url.'image/Y.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a>
                                                        <a href="https://www.instagram.com/docconsultservices/"><img src="'.base_url.'image/I.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a> 
                                                        <a href="https://www.linkedin.com/in/docconsult-services-a70a72134/"><img src="'.base_url.'image/L.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a></br>
                                                        </p></td>
                </tr>
            </table>
            </div>
            
        </td>
        <td></td>
    </tr>
</table>';

	
	/*$msg_pat='<div style="width:100%; height:100%; margin:0;" >

	<div style="width:90%; float:left; height:70px;padding:30px;">

		<span style="width:50%;float:left"> <a href="https://docconsult.in"><img src="https://docconsult.in/image/logo.png"  style="height:70px"/></span></a>

		<span style="width:50%; text-align:right;float:left;font-size: 17px;">  <br /><b> </span>

	</div>

	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Hello &nbsp;'.$res1['name'].', <br></div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Your Appointment has been generated with <b>Docconsult</b> 
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Doctor name: &nbsp;'.$doc_details['be_name'].$doc_details['name'].' </div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Appointment Date: &nbsp;'.$date.' </div>
    <div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Appointment Time: &nbsp;'.$app_time.' </div>
    <div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Area: &nbsp;'.$area.' </div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Clinic: &nbsp;'.$clinic_details['name'].' </div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Clinic Address: &nbsp;'.$clinic_details['address'].' </div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Thank You</div>';


*/



$msg_pat = '<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: linear-gradient(to right, #2D9CDB, #2F5894);">
    <tr>
        <td></td>
        <td class="header container">
            
            <div style="max-width: 650px;    margin: 0 auto;    display: block;">
        <a href="'.base_url.'"><img src="'.base_url.'/image/logo.png" alt="logo" ></a>
            </div>
            
        </td>
        <td></td>
    </tr>
</table>

<!---content demo -->
<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: #f5f5fa; ">
    <tr>
        <td></td>
        <td class="header container">
            
            <div style="max-width: 630px;    margin: 0 auto;    display: block;">
            <table>
                    <tr>
                        <td>
                        <br>
                            <h3>Hello &nbsp;'.$res1['name'].',<br></h3>
                            <p class="lead">Your Appointment has been generated with <b>Docconsult</b>
                            </p> 
                        </td>
                    </tr>
                </table>
            </div>          
        </td>
        <td></td>
    </tr>
</table>
<!---content demo End-->
<table class="head-wrap" style="width: 650px;    background: #f5f5fa;    margin: 0 auto; ">
    <tr>
        <td></td>
        <td class="header container">
            
            <!-- content -->
            <div style="max-width: 630px;    margin: 0 auto;    display: block;">
                <table>
<tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
 <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;   min-width: 180px; font-weight: bold;   text-align: left;  float:left;">Request A Call ID :
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;     ">&nbsp;'.$token.'</span>
</td>
    
  </tr>

   <tr>
   <td >
   <h4>Appointments Details</h4>
   </td> 
  </tr>

  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;  min-width: 180px;font-weight: bold;   text-align: left;   float:left;">Doctor Name :
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;      ">&nbsp;'.$doc_details['be_name'].$doc_details['name'].'</span></td>
    
  </tr>
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;min-width: 180px; font-weight: bold;   text-align: left;  float:left;">Appointment Date: 

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;    "> &nbsp;'.$date.' </span></td>
    
  </tr>
  
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;min-width: 180px; font-weight: bold;   text-align: left;  float:left;">Appointment Time: 

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;    "> &nbsp;'.$app_time.'  </span></td>
    
  </tr>
  
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;min-width: 180px; font-weight: bold;   text-align: left;  float:left;">Clinic Name:

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;    "> &nbsp;'.$clinic_details['name'].' </span></td>
    
  </tr>
  
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;min-width: 180px; font-weight: bold;   text-align: left;  float:left;">Clinic Address :

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;    "> &nbsp;'.$clinic_details['address'].'</span></td>
    
  </tr>
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;min-width: 180px; font-weight: bold;   text-align: left;  float:left;">Clinic area :

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;    "> &nbsp;'.$clinic_details['city'].'</span></td>
    
  </tr>
  <tr>
   <td >
   <h4>Patient Details</h4>
   </td> 
  </tr>
  
   <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;   min-width: 180px; font-weight: bold;  text-align: left;   float:left;">Patient name:

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;      text-align: center;     ">&nbsp;'.$res1['name'].'</span></td>
    
  </tr>
   <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;   min-width: 180px; font-weight: bold;  text-align: left;   float:left;">Patient Gender  :

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;      text-align: center;     ">&nbsp;'.$gender.' </span></td>
    
  </tr>
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;   min-width: 180px; font-weight: bold;  text-align: left;   float:left;">Patient Email  :

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;      text-align: center;     ">&nbsp;'.$email.' </span></td>
    
  </tr>
   <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;   min-width: 180px; font-weight: bold;  text-align: left;   float:left;">Patient mobile no :

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;      text-align: center;     ">  &nbsp;'.$phone_no.'/span></td>
    
  </tr>
   <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;   min-width: 180px; font-weight: bold;  text-align: left;   float:left;">Area  :

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;      text-align: center;     ">&nbsp;'.$area.' </span></td>
    
  </tr>
               
                    <tr>    
                        <td></td><td></td>
                    </tr>
                </table>
            </div>
            <!-- COLUMN WRAP -->
            
            <div  style="max-width: 630px;     margin: 0 auto;    display: block;">
                <table>
                    <tr>
                        <td>
                             <h4>Thank You, For Using Docconsult.</h4>
                             <p class="lead">Regreds , <br>
                             DocConsult Team</p>
                        </td>
                        </tr>
                    </tr>
                </table>
            </div>
        </td>
        <td></td>       <!---Footer End--->
    </tr>   
</table>

<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: linear-gradient(to right, #2D9CDB, #2F5894);">
    <tr>
        <td></td>
        <td class="header container">
            
            <div style="max-width: 630px;    margin: 0 auto;    display: block;">
            <table>
                <tr>
                    <td><a href="'.base_url.'"><img src="'.base_url.'/image/logo.png" alt="logo" ></a>
                    <p style="  font-size: 12px;     margin: 2px 10px;  color:#fff;">Contact NO : <strong> 0141-2785199</strong></p>
                    <p style="  font-size: 12px;      margin: 2px 10px;  color:#fff;">Email: <strong><a href="emailto:service@docconsult.in" style="color:#fff;">service@docconsult.in</a></strong></p>
                    <p style="   font-size: 12px;     margin: 2px 10px;  color:#fff;">Copyright © 2017 DocConsult | All Right Reserved 2016</p> </td>
                    
                    <td style="text-align: right;    width: 50%;">
                    <p style="float: right; text-align: right; margin-right: 0px; margin-top: 60px;">
                                                        <a href="https://www.facebook.com/docconsult/"><img src="'.base_url.'image/F.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a> 
                                                        <a href="https://twitter.com/Docconsult12"><img src="'.base_url.'image/T.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a>
                                                        <a href="https://www.youtube.com/channel/UCroHJE8lYtX3Wz9j233Dtwg"><img src="'.base_url.'image/Y.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a>
                                                        <a href="https://www.instagram.com/docconsultservices/"><img src="'.base_url.'image/I.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a> 
                                                        <a href="https://www.linkedin.com/in/docconsult-services-a70a72134/"><img src="'.base_url.'image/L.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a></br>
                                                        </p></td>
                </tr>
            </table>
            </div>
            
        </td>
        <td></td>
    </tr>
</table>';
	
	/*$msg_admin='<div style="width:100%; height:100%; margin:0;" >

	<div style="width:90%; float:left; height:70px;padding:30px;">

		<span style="width:50%;float:left"> <a href="https://docconsult.in"><img src="https://docconsult.in/image/logo.png"  style="height:70px"/></span></a>

		<span style="width:50%; text-align:right;float:left;font-size: 17px;">  <br /><b> </span>

	</div>

	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Hello admin <br></div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">One Appoitment has been generated with <b>Docconsult</b> 
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Doctor name: &nbsp;'.$doc_details['be_name'].$doc_details['name'].' </div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Doctor mobile no: &nbsp;'.$doc_details['phone_no'].' </div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Patient name: &nbsp;'.$res1['name'].' </div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Patient mobile no: &nbsp;'.$phone_no.' </div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Appointment Date: &nbsp;'.$date.' </div>
    <div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Appointment Time: &nbsp;'.$app_time.' </div>
    <div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Area: &nbsp;'.$area.' </div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Clinic: &nbsp;'.$clinic_details['name'].' </div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Clinic Address: &nbsp;'.$clinic_details['address'].' </div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Thank You</div>';
*/


$msg_doc = '<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: linear-gradient(to right, #2D9CDB, #2F5894);">
    <tr>
        <td></td>
        <td class="header container">
            
            <div style="max-width: 650px;    margin: 0 auto;    display: block;">
        <a href="'.base_url.'"><img src="'.base_url.'/image/logo.png" alt="logo" ></a>
            </div>
            
        </td>
        <td></td>
    </tr>
</table>

<!---content demo -->
<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: #f5f5fa; ">
    <tr>
        <td></td>
        <td class="header container">
            
            <div style="max-width: 630px;    margin: 0 auto;    display: block;">
            <table>
                    <tr>
                        <td>
                        <br>
                            <h3>Hello , Admin<br></h3>
                            <p class="lead">One Appoitment has been generated with <b>Docconsult</b></b>
                            </p> 
                        </td>
                    </tr>
                </table>
            </div>          
        </td>
        <td></td>
    </tr>
</table>
<!---content demo End-->
<table class="head-wrap" style="width: 650px;    background: #f5f5fa;    margin: 0 auto; ">
    <tr>
        <td></td>
        <td class="header container">
            
            <!-- content -->
            <div style="max-width: 630px;    margin: 0 auto;    display: block;">
                <table>
<tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
 <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;   min-width: 180px; font-weight: bold;   text-align: left;  float:left;">Request A Call ID :
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;     ">&nbsp;'.$token.'</span>
</td>
    
  </tr>

  <tr>
   <td >
   <h4>Patient Details</h4>
   </td> 
  </tr>
  
   <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;   min-width: 180px; font-weight: bold;  text-align: left;   float:left;">Patient name:

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;      text-align: center;     ">&nbsp;'.$res1['name'].'</span></td>
    
  </tr>
   <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;   min-width: 180px; font-weight: bold;  text-align: left;   float:left;">Patient Gender  :

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;      text-align: center;     ">&nbsp;'.$gender.' </span></td>
    
  </tr>
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;   min-width: 180px; font-weight: bold;  text-align: left;   float:left;">Patient Email  :

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;      text-align: center;     ">&nbsp;'.$email.' </span></td>
    
  </tr>
   <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;   min-width: 180px; font-weight: bold;  text-align: left;   float:left;">Patient mobile no :

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;      text-align: center;     ">  &nbsp;'.$phone_no.'/span></td>
    
  </tr>
   <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;   min-width: 180px; font-weight: bold;  text-align: left;   float:left;">Area  :

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;      text-align: center;     ">&nbsp;'.$area.' </span></td>
    
  </tr>
                <tr>
   <td >
   <h4>Appointments Details</h4>
   </td> 
  </tr>

  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;  min-width: 180px;font-weight: bold;   text-align: left;   float:left;">Doctor Name :
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;      ">&nbsp;'.$doc_details['be_name'].$doc_details['name'].'</span></td>
    
  </tr>
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;min-width: 180px; font-weight: bold;   text-align: left;  float:left;">Appointment Date: 

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;    "> &nbsp;'.$date.' </span></td>
    
  </tr>
  
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;min-width: 180px; font-weight: bold;   text-align: left;  float:left;">Appointment Time: 

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;    "> &nbsp;'.$app_time.'  </span></td>
    
  </tr>
  
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;min-width: 180px; font-weight: bold;   text-align: left;  float:left;">Clinic Name:

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;    "> &nbsp;'.$clinic_details['name'].' </span></td>
    
  </tr>
  
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;min-width: 180px; font-weight: bold;   text-align: left;  float:left;">Clinic Address :

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;    "> &nbsp;'.$clinic_details['address'].'</span></td>
    
  </tr>
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;min-width: 180px; font-weight: bold;   text-align: left;  float:left;">Clinic area :

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;    "> &nbsp;'.$clinic_details['city'].'</span></td>
    
  </tr>
           
                    <tr>    
                        <td></td><td></td>
                    </tr>
                </table>
            </div>
            <!-- COLUMN WRAP -->
            
            <div  style="max-width: 630px;     margin: 0 auto;    display: block;">
                <table>
                    <tr>
                        <td>
                             <h4>Thank You, For Using Docconsult.</h4>
                             <p class="lead">Regreds , <br>
                             DocConsult Team</p>
                        </td>
                        </tr>
                    </tr>
                </table>
            </div>
        </td>
        <td></td>       <!---Footer End--->
    </tr>   
</table>

<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: linear-gradient(to right, #2D9CDB, #2F5894);">
    <tr>
        <td></td>
        <td class="header container">
            
            <div style="max-width: 630px;    margin: 0 auto;    display: block;">
            <table>
                <tr>
                    <td><a href="'.base_url.'"><img src="'.base_url.'/image/logo.png" alt="logo" ></a>
                    <p style="  font-size: 12px;     margin: 2px 10px;  color:#fff;">Contact NO : <strong> 0141-2785199</strong></p>
                    <p style="  font-size: 12px;      margin: 2px 10px;  color:#fff;">Email: <strong><a href="emailto:service@docconsult.in" style="color:#fff;">service@docconsult.in</a></strong></p>
                    <p style="   font-size: 12px;     margin: 2px 10px;  color:#fff;">Copyright © 2017 DocConsult | All Right Reserved 2016</p> </td>
                    
                    <td style="text-align: right;    width: 50%;">
                    <p style="float: right; text-align: right; margin-right: 0px; margin-top: 60px;">
                                                        <a href="https://www.facebook.com/docconsult/"><img src="'.base_url.'image/F.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a> 
                                                        <a href="https://twitter.com/Docconsult12"><img src="'.base_url.'image/T.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a>
                                                        <a href="https://www.youtube.com/channel/UCroHJE8lYtX3Wz9j233Dtwg"><img src="'.base_url.'image/Y.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a>
                                                        <a href="https://www.instagram.com/docconsultservices/"><img src="'.base_url.'image/I.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a> 
                                                        <a href="https://www.linkedin.com/in/docconsult-services-a70a72134/"><img src="'.base_url.'image/L.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a></br>
                                                        </p></td>
                </tr>
            </table>
            </div>
            
        </td>
        <td></td>
    </tr>
</table>';


	

	
	 $this->foremail($doc_details['email'],$msg_doc,'	kavitajha.docconsult@gmail.com','Appointment has been generated for you - DOCCONSULT'); //for doctor
        $this->foremail('	kavitajha.docconsult@gmail.com',$msg_admin,'	kavitajha.docconsult@gmail.com','Appointment has been generated'); //for admin
        $this->foremail($email,$msg_pat,'	kavitajha.docconsult@gmail.com','Appointment has been generated for you - DOCCONSULT'); //for patient

      //  $this->foremail($doc_details['email'],$msg_doc,'service@docconsult.in','Appointment has been generated for you - DOCCONSULT'); //for doctor
      //  $this->foremail('info@docconsult.in',$msg_admin,'service@docconsult.in','Appointment has been generated'); //for admin
       // $this->foremail($email,$msg_pat,'service@docconsult.in','Appointment has been generated for you - DOCCONSULT'); //for patient

        
    $fordocsms = ' generated for '.$res1['name'].' at '.$clinic_details['name'].'on '.$date.' at '.$app_time;
    $forpatientsms = ' confirmed with '.$doc_details['be_name'].$doc_details['name'].' at '.$clinic_details['name'].'on '.$date.' at '.$app_time;
		
	$sms1='Hi '.$doc_details['be_name'].$doc_details['name'].' Your Appointment has been '.$fordocsms.' you can login here '.base_url;
    $sms='Hi '.$res1['name'].' Your Appointment has been '.$forpatientsms.' you can login here '.base_url;
     
     $sms = str_replace("<", "", $sms);
     $sms = str_replace(">", "", $sms);
     $sms = rawurlencode($sms);
        
     //$send_sms_url = 'http://www.sms.jprinfotech.com/api/sendhttp.php?authkey=4296AbkgvkyLHP2b584bb4a2&mobiles='.$phone_no.'&message='.$msg.'&sender='.sender_id.'&route=4';
       $send_sms_url='http://sms.digialaya.com/API/SMSHttp.aspx?UserId=docconsultadmin&pwd=pwd2017&Message='.$sms.'&Contacts='.$phone_no.'&SenderId=DOCCON&ServiceName=SMSTRANS&StartTime=';
     $send_sms_url = str_replace(" ", "%20", $send_sms_url);
     
     $sms1 = str_replace("<", "", $sms1);
     $sms1 = str_replace(">", "", $sms1);
     $sms1= rawurlencode($sms1);
        
     //$send_sms_url = 'http://www.sms.jprinfotech.com/api/sendhttp.php?authkey=4296AbkgvkyLHP2b584bb4a2&mobiles='.$phone_no.'&message='.$msg.'&sender='.sender_id.'&route=4';
     $send_sms_url1='http://sms.digialaya.com/API/SMSHttp.aspx?UserId=docconsultadmin&pwd=pwd2017&Message='.$sms1.'&Contacts='.$doc_details['phone_no'].'&SenderId=DOCCON&ServiceName=SMSTRANS&StartTime=';
     $send_sms_url1 = str_replace(" ", "%20", $send_sms_url1);
     
     
     $ch1 = curl_init();
     $timeout = 5;
     curl_setopt($ch1, CURLOPT_URL, $send_sms_url1);
     curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);
     curl_setopt($ch1, CURLOPT_SSL_VERIFYHOST,false);
     curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER,false);
     curl_setopt($ch1, CURLOPT_MAXREDIRS, 10);
     curl_setopt($ch1, CURLOPT_FOLLOWLOCATION, 1);
     curl_setopt($ch1, CURLOPT_CONNECTTIMEOUT, $timeout);
     $data1 = curl_exec($ch1);
     curl_close($ch1);
     
     $ch = curl_init();
     $timeout = 5;
     curl_setopt($ch, CURLOPT_URL, $send_sms_url);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
     curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
     curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
     curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
     curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
     $data = curl_exec($ch);
     curl_close($ch);    
        
}

public function insert_request_call_new_patient($app_time,$name,$email,$phone_no,$area,$symptoms,$date,$cid,$did, $gender, $dob, $age)
{
	$date = date('Y-m-d');
	$pass = sha1($phone_no);
	$d=$this->db->query("insert into patient(name, email, password, phone_no, area, gender, dob, age, date) 
                        values('$name','$email','$pass','$phone_no','$area', '$gender', '$dob', '$age', '$date')");

	$query = $this->db->query("select * from patient order by id desc limit 1 ");
	$res1 = $query->fetch_assoc();
    $table_id = $res1['id'];

    $res2 = $this->db->query("select MAX(patient_id) as patient_max_id from patient");    
    $data2 = $res2->fetch_assoc();
    $patient_id = $data2['patient_max_id']+1;

    $this->db->query("update patient set patient_id = '$patient_id', parent_id = '$table_id' where id = '$table_id' ");


	
	$ap=$this->db->query("insert into request_for_call(parent_id, patient_name, patient_email, app_time, app_date, doctor_id, phone_no, patient_id, clinic_id, status, area,symptoms) 
	values('$table_id','$name','$email','$app_time','$date','$did','$phone_no','$patient_id','$cid','Pending', '$area','$symptoms')");
	
	$activity_name = "Add Request for call";
	$date = date("Y-m-d");
	$time = date("h:i");
	$res = $this->db->query("insert into activity(name,patient_id,doctor_id,action,date,time) values('$activity_name','$name','$did','added','$date','$time')");


	$doctors =  $this->insert_into_patient_doctorblob($patient_id,$did);
    $patients = $this->insert_into_doctor_patientblob($did,$patient_id);
    
    $doc_details = $this->getById($did,'doctors');
    $clinic_details = $this->getById($cid,'clinic');
    
    /*$msg_doc='<div style="width:100%; height:100%; margin:0;" >

	<div style="width:90%; float:left; height:70px;padding:30px;">

		<span style="width:50%;float:left"> <a href="https://docconsult.in"><img src="https://docconsult.in/image/logo.png"  style="height:70px"/></span></a>

		<span style="width:50%; text-align:right;float:left;font-size: 17px;">  <br /><b> </span>

	</div>

	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Hello &nbsp;'.$doc_details['be_name'].$doc_details['name'].', <br></div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">One Request For call has been generated for you with <b>Docconsult</b> on &nbsp;<b>'.$date.'</b> at &nbsp;<b>'.$app_time.' </b></div></div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Patient name: &nbsp;'.$res1['name'].' </div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Patient mobile no: &nbsp;'.$phone_no.' </div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Area: &nbsp;'.$area.' </div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Clinic: &nbsp;'.$clinic_details['name'].' </div>
	
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Thank You</div>';*/

$msg_doc = '<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: linear-gradient(to right, #2D9CDB, #2F5894);">
    <tr>
        <td></td>
        <td class="header container">
            
            <div style="max-width: 650px;    margin: 0 auto;    display: block;">
        <a href="'.base_url.'"><img src="'.base_url.'/image/logo.png" alt="logo" ></a>
            </div>
            
        </td>
        <td></td>
    </tr>
</table>

<!---content demo -->
<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: #f5f5fa; ">
    <tr>
        <td></td>
        <td class="header container">
            
            <div style="max-width: 630px;    margin: 0 auto;    display: block;">
            <table>
                    <tr>
                        <td>
                        <br>
                            <h3>Hello &nbsp;'.$doc_details['be_name'].$doc_details['name'].', <br></h3>
                            <p class="lead">One Request For call has been generated for you with <b>Docconsult</b> on &nbsp;<b>'.$date.'</b> at &nbsp;<b>'.$app_time.' </b>
                            </p> 
                        </td>
                    </tr>
                </table>
            </div>          
        </td>
        <td></td>
    </tr>
</table>
<!---content demo End-->
<table class="head-wrap" style="width: 650px;    background: #f5f5fa;    margin: 0 auto; ">
    <tr>
        <td></td>
        <td class="header container">
            
            <!-- content -->
            <div style="max-width: 630px;    margin: 0 auto;    display: block;">
                <table>
<tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
 <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;   min-width: 180px; font-weight: bold;   text-align: left;  float:left;">Request A Call ID :
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;     ">&nbsp;'.$token.'</span>
</td>
    
  </tr>

  <tr>
   <td >
   <h4>Patient Details</h4>
   </td> 
  </tr>
  
   <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;   min-width: 180px; font-weight: bold;  text-align: left;   float:left;">Patient name:

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;      text-align: center;     "> &nbsp;'.$res1['name'].'</span></td>
    
  </tr>
   <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;   min-width: 180px; font-weight: bold;  text-align: left;   float:left;">Patient Gender  :

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;      text-align: center;     ">&nbsp;'.$gender.' </span></td>
    
  </tr>
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;   min-width: 180px; font-weight: bold;  text-align: left;   float:left;">Patient Email  :

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;      text-align: center;     ">&nbsp;'.$email.' </span></td>
    
  </tr>
   <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;   min-width: 180px; font-weight: bold;  text-align: left;   float:left;">Patient mobile no :

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;      text-align: center;     "> &nbsp;'.$phone_no.'</span></td>
    
  </tr>
   <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;   min-width: 180px; font-weight: bold;  text-align: left;   float:left;">Area  :

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;      text-align: center;     ">&nbsp;'.$area.' </span></td>
    
  </tr>
                <tr>
   <td >
   <h4>Appointments Details</h4>
   </td> 
  </tr>

  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;  min-width: 180px;font-weight: bold;   text-align: left;   float:left;">Doctor Name :
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;      ">&nbsp;'.$doc_details['be_name'].$doc_details['name'].'</span></td>
    
  </tr>
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;min-width: 180px; font-weight: bold;   text-align: left;  float:left;">Clinic Name:

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;    "> &nbsp;'.$clinic_details['name'].' </span></td>
    
  </tr>
  
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;min-width: 180px; font-weight: bold;   text-align: left;  float:left;">Clinic Address :

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;    "> &nbsp;'.$clinic_details['address'].'</span></td>
    
  </tr>
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;min-width: 180px; font-weight: bold;   text-align: left;  float:left;">Clinic area :

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;    "> &nbsp;'.$clinic_details['city'].'</span></td>
    
  </tr>
            
                    <tr>    
                        <td></td><td></td>
                    </tr>
                </table>
            </div>
            <!-- COLUMN WRAP -->
            
            <div  style="max-width: 630px;     margin: 0 auto;    display: block;">
                <table>
                    <tr>
                        <td>
                             <h4>Thank You, For Using Docconsult.</h4>
                             <p class="lead">Regreds , <br>
                             DocConsult Team</p>
                        </td>
                        </tr>
                    </tr>
                </table>
            </div>
        </td>
        <td></td>       <!---Footer End--->
    </tr>   
</table>

<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: linear-gradient(to right, #2D9CDB, #2F5894);">
    <tr>
        <td></td>
        <td class="header container">
            
            <div style="max-width: 630px;    margin: 0 auto;    display: block;">
            <table>
                <tr>
                    <td><a href="'.base_url.'"><img src="'.base_url.'/image/logo.png" alt="logo" ></a>
                    <p style="  font-size: 12px;     margin: 2px 10px;  color:#fff;">Contact NO : <strong> 0141-2785199</strong></p>
                    <p style="  font-size: 12px;      margin: 2px 10px;  color:#fff;">Email: <strong><a href="emailto:service@docconsult.in" style="color:#fff;">service@docconsult.in</a></strong></p>
                    <p style="   font-size: 12px;     margin: 2px 10px;  color:#fff;">Copyright © 2017 DocConsult | All Right Reserved 2016</p> </td>
                    
                    <td style="text-align: right;    width: 50%;">
                    <p style="float: right; text-align: right; margin-right: 0px; margin-top: 60px;">
                                                        <a href="https://www.facebook.com/docconsult/"><img src="'.base_url.'image/F.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a> 
                                                        <a href="https://twitter.com/Docconsult12"><img src="'.base_url.'image/T.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a>
                                                        <a href="https://www.youtube.com/channel/UCroHJE8lYtX3Wz9j233Dtwg"><img src="'.base_url.'image/Y.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a>
                                                        <a href="https://www.instagram.com/docconsultservices/"><img src="'.base_url.'image/I.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a> 
                                                        <a href="https://www.linkedin.com/in/docconsult-services-a70a72134/"><img src="'.base_url.'image/L.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a></br>
                                                        </p></td>
                </tr>
            </table>
            </div>
            
        </td>
        <td></td>
    </tr>
</table>';






    $msg_pat = '<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: linear-gradient(to right, #2D9CDB, #2F5894);">
    <tr>
        <td></td>
        <td class="header container">
            
            <div style="max-width: 650px;    margin: 0 auto;    display: block;">
        <a href="'.base_url.'"><img src="'.base_url.'/image/logo.png" alt="logo" ></a>
            </div>
            
        </td>
        <td></td>
    </tr>
</table>

<!---content demo -->
<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: #f5f5fa; ">
    <tr>
        <td></td>
        <td class="header container">
            
            <div style="max-width: 630px;    margin: 0 auto;    display: block;">
            <table>
                    <tr>
                        <td>
                        <br>
                            <h3>Hello &nbsp;'.$res1['name'].',</h3>
                            <p class="lead">Your Request For call has been generated with <b>Docconsult</b> on &nbsp;<b>'.$date.'</b> at &nbsp;<b>'.$app_time.' </b>
                            </p> 
                        </td>
                    </tr>
                </table>
            </div>          
        </td>
        <td></td>
    </tr>
</table>
<!---content demo End-->
<table class="head-wrap" style="width: 650px;    background: #f5f5fa;    margin: 0 auto; ">
    <tr>
        <td></td>
        <td class="header container">
            
            <!-- content -->
            <div style="max-width: 630px;    margin: 0 auto;    display: block;">
                <table>
<tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
 <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;   min-width: 180px; font-weight: bold;   text-align: left;  float:left;">Request A Call ID :
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;     ">&nbsp;'.$token.'</span>
</td>
    
  </tr>
                <tr>
   <td >
   <h4>Appointments Details</h4>
   </td> 
  </tr>

  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;  min-width: 180px;font-weight: bold;   text-align: left;   float:left;">Doctor Name :
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;      ">&nbsp;'.$doc_details['be_name'].$doc_details['name'].'</span></td>
    
  </tr>
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;min-width: 180px; font-weight: bold;   text-align: left;  float:left;">Clinic Name:

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;    "> &nbsp;'.$clinic_details['name'].' </span></td>
    
  </tr>
  
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;min-width: 180px; font-weight: bold;   text-align: left;  float:left;">Clinic Address :

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;    "> &nbsp;'.$clinic_details['address'].'</span></td>
    
  </tr>
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;min-width: 180px; font-weight: bold;   text-align: left;  float:left;">Clinic area :

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;    "> &nbsp;'.$clinic_details['city'].'</span></td>
    
  </tr>
  


 <tr>
   <td >
   <h4>Patient Details</h4>
   </td> 
  </tr>
  
   <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;   min-width: 180px; font-weight: bold;  text-align: left;   float:left;">Patient name:

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;      text-align: center;     "> &nbsp;'.$res1['name'].'</span></td>
    
  </tr>
   <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;   min-width: 180px; font-weight: bold;  text-align: left;   float:left;">Patient Gender  :

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;      text-align: center;     ">&nbsp;'.$gender.' </span></td>
    
  </tr>
   <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;   min-width: 180px; font-weight: bold;  text-align: left;   float:left;">Patient mobile no :

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;      text-align: center;     "> &nbsp;'.$phone_no.'</span></td>
    
  </tr>
   <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;   min-width: 180px; font-weight: bold;  text-align: left;   float:left;">Area  :

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;      text-align: center;     ">&nbsp;'.$area.' </span></td>
    
  </tr>

   

  
  
           
                    <tr>    
                        <td></td><td></td>
                    </tr>
                </table>
            </div>
            <!-- COLUMN WRAP -->
            
            <div  style="max-width: 630px;     margin: 0 auto;    display: block;">
                <table>
                    <tr>
                        <td>
                             <h4>Thank You, For Using Docconsult.</h4>
                             <p class="lead">Regreds , <br>
                             DocConsult Team</p>
                        </td>
                        </tr>
                    </tr>
                </table>
            </div>
        </td>
        <td></td>       <!---Footer End--->
    </tr>   
</table>

<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: linear-gradient(to right, #2D9CDB, #2F5894);">
    <tr>
        <td></td>
        <td class="header container">
            
            <div style="max-width: 630px;    margin: 0 auto;    display: block;">
            <table>
                <tr>
                    <td><a href="'.base_url.'"><img src="'.base_url.'/image/logo.png" alt="logo" ></a>
                    <p style="  font-size: 12px;     margin: 2px 10px;  color:#fff;">Contact NO : <strong> 0141-2785199</strong></p>
                    <p style="  font-size: 12px;      margin: 2px 10px;  color:#fff;">Email: <strong><a href="emailto:service@docconsult.in" style="color:#fff;">service@docconsult.in</a></strong></p>
                    <p style="   font-size: 12px;     margin: 2px 10px;  color:#fff;">Copyright © 2017 DocConsult | All Right Reserved 2016</p> </td>
                    
                    <td style="text-align: right;    width: 50%;">
                    <p style="float: right; text-align: right; margin-right: 0px; margin-top: 60px;">
                                                        <a href="https://www.facebook.com/docconsult/"><img src="'.base_url.'image/F.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a> 
                                                        <a href="https://twitter.com/Docconsult12"><img src="'.base_url.'image/T.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a>
                                                        <a href="https://www.youtube.com/channel/UCroHJE8lYtX3Wz9j233Dtwg"><img src="'.base_url.'image/Y.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a>
                                                        <a href="https://www.instagram.com/docconsultservices/"><img src="'.base_url.'image/I.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a> 
                                                        <a href="https://www.linkedin.com/in/docconsult-services-a70a72134/"><img src="'.base_url.'image/L.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a></br>
                                                        </p></td>
                </tr>
            </table>
            </div>
            
        </td>
        <td></td>
    </tr>
</table>';

	
	/*$msg_pat='<div style="width:100%; height:100%; margin:0;" >

	<div style="width:90%; float:left; height:70px;padding:30px;">

		<span style="width:50%;float:left"> <a href="https://docconsult.in"><img src="https://docconsult.in/image/logo.png"  style="height:70px"/></span></a>

		<span style="width:50%; text-align:right;float:left;font-size: 17px;">  <br /><b> </span>

	</div>

	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Hello &nbsp;'.$res1['name'].', <br></div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Your Request For call has been generated with <b>Docconsult</b> on &nbsp;<b>'.$date.'</b> at &nbsp;<b>'.$app_time.' </b></div></div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Doctor name: &nbsp;'.$doc_details['be_name'].$doc_details['name'].' </div>
    <div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Area: &nbsp;'.$area.' </div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Clinic: &nbsp;'.$clinic_details['name'].' </div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Clinic Address: &nbsp;'.$clinic_details['address'].' </div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Thank You</div>';*/
	
	/*$msg_admin='<div style="width:100%; height:100%; margin:0;" >

	<div style="width:90%; float:left; height:70px;padding:30px;">

		<span style="width:50%;float:left"> <a href="https://docconsult.in"><img src="https://docconsult.in/image/logo.png"  style="height:70px"/></span></a>

		<span style="width:50%; text-align:right;float:left;font-size: 17px;">  <br /><b> </span>

	</div>

	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Hello admin <br></div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">One Request For call has been generated with <b>Docconsult</b> on &nbsp;<b>'.$date.'</b> at &nbsp;<b>'.$app_time.' </b></div></div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Doctor name: &nbsp;'.$doc_details['be_name'].$doc_details['name'].' </div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Doctor mobile no: &nbsp;'.$doc_details['phone_no'].' </div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Patient name: &nbsp;'.$res1['name'].' </div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Patient mobile no: &nbsp;'.$phone_no.' </div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Area: &nbsp;'.$area.' </div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Clinic: &nbsp;'.$clinic_details['name'].' </div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Clinic Address: &nbsp;'.$clinic_details['address'].' </div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Thank You</div>';*/




    $msg_admin = '<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: linear-gradient(to right, #2D9CDB, #2F5894);">
    <tr>
        <td></td>
        <td class="header container">
            
            <div style="max-width: 650px;    margin: 0 auto;    display: block;">
        <a href="'.base_url.'"><img src="'.base_url.'/image/logo.png" alt="logo" ></a>
            </div>
            
        </td>
        <td></td>
    </tr>
</table>

<!---content demo -->
<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: #f5f5fa; ">
    <tr>
        <td></td>
        <td class="header container">
            
            <div style="max-width: 630px;    margin: 0 auto;    display: block;">
            <table>
                    <tr>
                        <td>
                        <br>
                            <h3>Hello , Admin</h3>
                            <p class="lead">One Request For call has been generated with <b>Docconsult</b> on &nbsp;<b>'.$date.'</b> at &nbsp;<b>'.$app_time.' 
                            </b>
                            </p> 
                        </td>
                    </tr>
                </table>
            </div>          
        </td>
        <td></td>
    </tr>
</table>
<!---content demo End-->
<table class="head-wrap" style="width: 650px;    background: #f5f5fa;    margin: 0 auto; ">
    <tr>
        <td></td>
        <td class="header container">
            
            <!-- content -->
            <div style="max-width: 630px;    margin: 0 auto;    display: block;">
                <table>
<tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
 <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;   min-width: 180px; font-weight: bold;   text-align: left;  float:left;">Request A Call ID :
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;     ">&nbsp;'.$token.'</span>
</td>
    
  </tr>
                <tr>
   <td >
   <h4>Appointments Details</h4>
   </td> 
  </tr>

  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;  min-width: 180px;font-weight: bold;   text-align: left;   float:left;">Doctor Name :
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;      ">&nbsp;'.$doc_details['name'].'</span></td>
    
  </tr>
   <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;  min-width: 180px;font-weight: bold;   text-align: left;   float:left;">Doctor mobile no :
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;      ">&nbsp;'.$doc_details['phone_no'].'</span></td>
    
  </tr>
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;min-width: 180px; font-weight: bold;   text-align: left;  float:left;">Clinic Name:

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;    "> &nbsp;'.$clinic_details['name'].' </span></td>
    
  </tr>
  
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;min-width: 180px; font-weight: bold;   text-align: left;  float:left;">Clinic Address :

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;    "> &nbsp;'.$clinic_details['address'].'</span></td>
    
  </tr>
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;min-width: 180px; font-weight: bold;   text-align: left;  float:left;">Clinic area :

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;    "> &nbsp;'.$clinic_details['city'].'</span></td>
    
  </tr>
  


 <tr>
   <td >
   <h4>Patient Details</h4>
   </td> 
  </tr>
  
   <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;   min-width: 180px; font-weight: bold;  text-align: left;   float:left;">Patient name:

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;      text-align: center;     "> &nbsp;'.$res1['name'].'</span></td>
    
  </tr>
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;   min-width: 180px; font-weight: bold;  text-align: left;   float:left;">Patient Email :

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;      text-align: center;     ">'.$patient_email.'</span></td>
    
  </tr>
   <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;   min-width: 180px; font-weight: bold;  text-align: left;   float:left;">Patient mobile no :

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;      text-align: center;     "> &nbsp;'.$phone_no.'</span></td>
    
  </tr>
   <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;   min-width: 180px; font-weight: bold;  text-align: left;   float:left;">Area  :

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;      text-align: center;     ">&nbsp;'.$area.' </span></td>
    
  </tr>
   

  
  
                    <tr>    
                        <td></td><td></td>
                    </tr>
                </table>
            </div>
            <!-- COLUMN WRAP -->
            
            <div  style="max-width: 630px;     margin: 0 auto;    display: block;">
                <table>
                    <tr>
                        <td>
                             <h4>Thank You, For Using Docconsult.</h4>
                             <p class="lead">Regreds , <br>
                             DocConsult Team</p>
                        </td>
                        </tr>
                    </tr>
                </table>
            </div>
        </td>
        <td></td>       <!---Footer End--->
    </tr>   
</table>

<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: linear-gradient(to right, #2D9CDB, #2F5894);">
    <tr>
        <td></td>
        <td class="header container">
            
            <div style="max-width: 630px;    margin: 0 auto;    display: block;">
            <table>
                <tr>
                    <td><a href="'.base_url.'"><img src="'.base_url.'/image/logo.png" alt="logo" ></a>
                    <p style="  font-size: 12px;     margin: 2px 10px;  color:#fff;">Contact NO : <strong> 0141-2785199</strong></p>
                    <p style="  font-size: 12px;      margin: 2px 10px;  color:#fff;">Email: <strong><a href="emailto:service@docconsult.in" style="color:#fff;">service@docconsult.in</a></strong></p>
                    <p style="   font-size: 12px;     margin: 2px 10px;  color:#fff;">Copyright © 2017 DocConsult | All Right Reserved 2016</p> </td>
                    
                    <td style="text-align: right;    width: 50%;">
                    <p style="float: right; text-align: right; margin-right: 0px; margin-top: 60px;">
                                                        <a href="https://www.facebook.com/docconsult/"><img src="'.base_url.'image/F.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a> 
                                                        <a href="https://twitter.com/Docconsult12"><img src="'.base_url.'image/T.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a>
                                                        <a href="https://www.youtube.com/channel/UCroHJE8lYtX3Wz9j233Dtwg"><img src="'.base_url.'image/Y.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a>
                                                        <a href="https://www.instagram.com/docconsultservices/"><img src="'.base_url.'image/I.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a> 
                                                        <a href="https://www.linkedin.com/in/docconsult-services-a70a72134/"><img src="'.base_url.'image/L.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a></br>
                                                        </p></td>
                </tr>
            </table>
            </div>
            
        </td>
        <td></td>
    </tr>
</table>';


	
	$this->foremail($doc_details['email'],$msg_doc,'kavitajha.docconsult@gmail.com','Request For Call has been generated for you - DOCCONSULT'); //for doctor
        $this->foremail('kavitajha.docconsult@gmail.com',$msg_admin,'kavitajha.docconsult@gmail.com','Request For Call has been generated'); //for admin
        $this->foremail($email,$msg_pat,'kavitajha.docconsult@gmail.com','Request For Call has been generated for you - DOCCONSULT'); //for patient
	
      //  $this->foremail($doc_details['email'],$msg_doc,'service@docconsult.in','Request For Call has been generated for you - DOCCONSULT'); //for doctor
      //  $this->foremail('info@docconsult.in',$msg_admin,'service@docconsult.in','Request For Call has been generated'); //for admin
       // $this->foremail($email,$msg_pat,'service@docconsult.in','Request For Call has been generated for you - DOCCONSULT'); //for patient

    $fordocsms = ' generated for '.$res1['name'].' at '.$clinic_details['name'].'on '.$date.' at '.$app_time;
    $forpatientsms = ' confirmed with '.$doc_details['be_name'].$doc_details['name'].' at '.$clinic_details['name'].'on '.$date.' at '.$app_time;
		
	$sms1='Hi '.$doc_details['be_name'].$doc_details['name'].' Your Request has been '.$fordocsms.' you can login here '.base_url;
    $sms='Hi '.$res1['name'].' Your Request has been '.$forpatientsms.' you can login here '.base_url;
     
     $sms = str_replace("<", "", $sms);
     $sms = str_replace(">", "", $sms);
     $sms = rawurlencode($sms);
        
     //$send_sms_url = 'http://www.sms.jprinfotech.com/api/sendhttp.php?authkey=4296AbkgvkyLHP2b584bb4a2&mobiles='.$phone_no.'&message='.$msg.'&sender='.sender_id.'&route=4';
       $send_sms_url='http://sms.digialaya.com/API/SMSHttp.aspx?UserId=docconsultadmin&pwd=pwd2017&Message='.$sms.'&Contacts='.$phone_no.'&SenderId=DOCCON&ServiceName=SMSTRANS&StartTime=';
     $send_sms_url = str_replace(" ", "%20", $send_sms_url);
     
     $sms1 = str_replace("<", "", $sms1);
     $sms1 = str_replace(">", "", $sms1);
     $sms1= rawurlencode($sms1);
        
     //$send_sms_url = 'http://www.sms.jprinfotech.com/api/sendhttp.php?authkey=4296AbkgvkyLHP2b584bb4a2&mobiles='.$phone_no.'&message='.$msg.'&sender='.sender_id.'&route=4';
     $send_sms_url1='http://sms.digialaya.com/API/SMSHttp.aspx?UserId=docconsultadmin&pwd=pwd2017&Message='.$sms1.'&Contacts='.$doc_details['phone_no'].'&SenderId=DOCCON&ServiceName=SMSTRANS&StartTime=';
     $send_sms_url1 = str_replace(" ", "%20", $send_sms_url1);
     
     
     /*$ch1 = curl_init();
     $timeout = 5;
     curl_setopt($ch1, CURLOPT_URL, $send_sms_url1);
     curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);
     curl_setopt($ch1, CURLOPT_SSL_VERIFYHOST,false);
     curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER,false);
     curl_setopt($ch1, CURLOPT_MAXREDIRS, 10);
     curl_setopt($ch1, CURLOPT_FOLLOWLOCATION, 1);
     curl_setopt($ch1, CURLOPT_CONNECTTIMEOUT, $timeout);
     $data1 = curl_exec($ch1);
     curl_close($ch1);*/
     
     $ch = curl_init();
     $timeout = 5;
     curl_setopt($ch, CURLOPT_URL, $send_sms_url);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
     curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
     curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
     curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
     curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
     $data = curl_exec($ch);
     curl_close($ch);
	
	
    
    
    if($d){
        return true;
    }
}
public function patient_login_after_appoitment($username, $password){
	    
    $password = sha1($password);
   
    $res=  $this->db->query("SELECT * FROM `patient` where  `phone_no` = '$username' ");

    if($res->num_rows > 0)
    {
        session_start();
   
        $data = $res->fetch_assoc();
        $_SESSION['login_success'] = TRUE;
        $_SESSION['patient_name'] = $data['name']; 
        $_SESSION['patient_login_id'] = $data['id'];
        $_SESSION['patient_email'] = $data['email'];
        $_SESSION['patinet_profile_image'] = $data['image'];
        $_SESSION['patient_last_login_timestamp'] = time();
        $_SESSION['patient_details'] = $data;
        $_SESSION['patient_phone_no']=$data['phone_no'];
       // return TRUE;
        //header('Location: '.base_url_doc.'calender.php');
        echo "<script> window.location.href='".base_url_patient."appointment.php'; </script>";
    }
    else
    {
       return false;
    }
} 

public function seo_services($speciality,$city){
    // $str=$speciality;
$str="";
    $res = $this->db->query("Select services from services_for_seo_use where speciality='$speciality' order by rand() limit 5");
   
    if($res->num_rows > 0){
       $str = 'A '.$speciality.' provides services including';
      
        while($data=$res->fetch_assoc()){
            
            $str .= ", ".$data['services'];
        }
        $str.=". Mentioned are ".$speciality." in ".$city.".";
    }
    
    return $str;
}

public function get_doc_cat_list($dis,$area)
{
    $arr = array();
    $search = '';
    $lmt = 'limit 20';
    if($area != '')
    {
        $search = " and location = '$area' ";
        $lmt = 'limit 15';
    }
    $res = $this->db->query("select category.category as category from category,(SELECT DISTINCT category FROM doctors WHERE city = '" .$dis . "' AND type = 'Doctor' $search) as t where t.category = category.id order by rand() $lmt");
   
    if($res->num_rows>0)
    {
        $count=$res->num_rows;
        for($i=0;$i<$count;$i++)
        {
            $data = $res->fetch_assoc();
            $arr[$data["category"]]=1;
        }
    }
   $keys = json_encode(array_keys($arr));
   return $keys;
}

public function get_doc_specialization_list($dis,$area,$limit)
{
    $arr = array();
    $search = '';
    $lmt = ' limit '.$limit;
    if($area != '')
    {
        $search = " and location = '$area' ";
        $lmt = ' limit 20';
    }
	
	$sql = "select specialization from doctors where city = '$dis' and type = 'Doctor' $search  order by rand() $lmt";
	$res = $this->db->query($sql);
	
	if($res->num_rows > 0)
	{
		while($rows = $res->fetch_assoc())	
		{
			$data = json_decode($rows['specialization'],true);
			for($k =0; $k< count($data); $k++)
			{
				if($k == 0)
				{
					$data1[] = $data[$k];
				}
				else{
					$data2[] = $data[$k];
				}
			}
			//$data[] = json_decode($rows['specialization'],true);
		}			
	}
	foreach($data1 as $key => $value){
		
		foreach($value as $ky => $val){
			
				 $results[] =  $val;
		}
    }
	foreach($data2 as $key1 => $value_1){
		
		foreach($value_1 as $ky1 => $val_1){
				 $results_1[] =  $val_1;
		}
    }
	
	$last_values = array_unique($results);
	$last_values_1 = array_unique($results_1);
   
	foreach($last_values as $spe)
	{
		if(is_numeric($spe))
		{
			$ids[] = $spe;
		}
		else
		{
			$not_ids[] = '';//$spe;
		}
	}
	foreach($last_values_1 as $spe_1)
	{
		if(is_numeric($spe_1))
		{
			$ids_1[] = $spe_1;
		}
		else
		{
			$not_ids_1[] = '';//$spe;
		}
	}
	$ids = implode(',',$ids);
	if($ids != ''){
		$speliz_result = $this->get_data_by_id($ids, $table = 'speciality', $field = 'specialization');
	}
	$ids_1 = implode(',',$ids_1);
	if($ids_1 != ''){
		$speliz_result_1 = $this->get_data_by_id($ids_1, $table = 'speciality', $field = 'specialization');
	}
	
	foreach($speliz_result as $doc_splizz) { 
		$ids_val[] = $doc_splizz;
	}
	foreach($speliz_result_1 as $doc_splizzz) { 
		if(!in_array($doc_splizzz,$ids_val))
		{
			$ids_val[] = $doc_splizzz.'-Speciality';
		}	
	}
		
	$keys = $ids_val;//array_merge($not_ids,$ids_val);
	$keys = array_unique($keys);
	return $keys;
}
public function get_doc_treatments_list($dis,$area,$type)
{
    $arr = $ids = $not_ids = array();
    $search = '';
    $lmt = ' limit 25';
    if($area != '')
    {
        if($type == 'doctors')
			$search = " and type = 'Doctor' and location = '$area' ";
		else	
			$search = " and area = '$area' ";
		
        $lmt = ' limit 20';
    }
	
	$sql = "select services from $type where city = '$dis' $search  order by rand() $lmt";
	$res = $this->db->query($sql);
	
	if($res->num_rows > 0)
	{
		while($rows = $res->fetch_assoc())	
		{
			$data[] = json_decode($rows['services'],true);
			
		}			
	}
	foreach($data as $key => $value){
		
		foreach($value as $ky => $val){
			
			foreach($val as $res){
			
				 $results[] =  $res;
			}	
			
		}
    }
	
	$last_values = array_unique($results);
   
	foreach($last_values as $spe)
	{
		if(is_numeric($spe))
		{
			$ids[] = $spe;
		}
		else
		{
			$not_ids[] = '';//$spe;
		}
	}
	$ids = implode(',',$ids);
	if($ids != ''){
		$speliz_result = $this->get_data_by_id($ids, $table = 'services_for_seo_use', $field = 'services');
	}  
	
	$k = 0;
	foreach($speliz_result as $doc_splizz) 
	{ 
		if($k < 11){
			$ids_val[] = $doc_splizz;
		}else{
			break;
		}
		$k++;	
	} 
		
	$keys = $ids_val;//array_merge($not_ids,$ids_val);
	$keys = array_unique($keys);
	return $keys;
}

public function get_clinic_specility_list($dis,$area)
{
    $arr = array();
    $search = '';
    $lmt = ' limit 25';
    if($area != '')
    {
        $search = " and area = '$area' ";
        $lmt = ' limit 20';
    }
	
	$sql = "select t1.category from clinic_category as t1 inner join clinic as t2 on t1.id = t2.category where city = '$dis' $search group by t2.category order by rand() $lmt";
	$res = $this->db->query($sql);
	
	if($res->num_rows > 0)
	{
		while($rows = $res->fetch_assoc())	
		{
			$data[] = $rows['category'];
			
		}			
	}
	return $data;
}

public function get_doc_treatments_list_by_specialiaztion($dis,$area,$type)
{
    $arr = array();
    $search = '';
    $lmt = ' limit 25';
    if($area != '')
    {
        //$search = " and location = '$area' ";
        $lmt = ' limit 20';
    }
	
	$sql = "select services from doctors where city = '$dis' and type = 'Doctor' and category = '$type' $search  order by rand() $lmt";
	$res = $this->db->query($sql);
	
	if($res->num_rows > 0)
	{
		while($rows = $res->fetch_assoc())	
		{
			$data[] = json_decode($rows['services'],true);
			
		}			
	}
	foreach($data as $key => $value){
		
		foreach($value as $ky => $val){
			
			foreach($val as $res){
			
				 $results[] =  $res;
			}	
			
		}
    }
	
	$last_values = array_unique($results);
   
	foreach($last_values as $spe)
	{
		if(is_numeric($spe))
		{
			$ids[] = $spe;
		}
		else
		{
			$not_ids[] = $spe;
		}
	}
	$ids = implode(',',$ids);
	if($ids != ''){
		$speliz_result = $this->get_data_by_id($ids, $table = 'services_for_seo_use', $field = 'services');
	}  
	
	$k = 0;
	foreach($speliz_result as $doc_splizz) 
	{ 
		if($k < 11){
			$ids_val[] = $doc_splizz;
		}else{
			break;
		}
		$k++;	
	} 
		
	$keys = array_merge($not_ids,$ids_val);
	$keys = array_unique($keys);
	return $keys;
}

public function get_city_index(){
    $res = $this->db->query("select DISTINCT t1.city from doctors as t1 join practice as t2 on t1.id = t2.doctor_id where t1.city != '' ");
    $result = array();
    while($data = $res->fetch_assoc())
    {
        $result[] = $data['city'];
    }
    return $result;
}

public function get_area_index($city){
    $res = $this->db->query("select DISTINCT t1.location from doctors as t1 join practice as t2 on t1.id = t2.doctor_id where t1.city = '$city' and t1.location != '' ");
    $result = array();
    while($data = $res->fetch_assoc())
    {
        $result[] = $data['location'];
    }
    return $result;
}

public function insert_feedback($p_name, $pemail, $pphone, $knowledge, $helpfulness, $punctuality, $staff, $review, $recommendDoctor, $did, $pid){
    
    $date = date('Y-m-d');
    $res1 = $this->db->query("insert into feedback(name, email, description, rate, rate1, rate2, rate3, recommend, date, patient_id, doctor_id, flag)
                        values('$p_name', '$pemail', '$review', '$knowledge','$helpfulness','$punctuality', '$staff', '$recommendDoctor',  '$date', '$pid', '$did', '1')");
    
    $doc_details = $this->getById($did,'doctors');

    $msg = '<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: linear-gradient(to right, #2D9CDB, #2F5894);">
    <tr>
        <td></td>
        <td class="header container">
            
            <div style="max-width: 650px;    margin: 0 auto;    display: block;">
        <a href="'.base_url.'"><img src="'.base_url.'/image/logo.png" alt="logo" ></a>
            </div>
            
        </td>
        <td></td>
    </tr>
</table>

<!---content demo -->
<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: #f5f5fa; ">
    <tr>
        <td></td>
        <td class="header container">
            
            <div style="max-width: 630px;    margin: 0 auto;    display: block;">
            <table>
                    <tr>
                        <td>
                        <br>
                            <h3>Hello '.$p_name.'</h3>
                            <p class="lead"><strong>Thank You!</strong> For Submitting Your Feedback for '.$doc_details['be_name'].$doc_details['name'].'.<br>
                            </p>
                        </td>
                    </tr>
                </table>
            </div>          
        </td>
        <td></td>
    </tr>
</table>
<!---content demo End-->
<table class="head-wrap" style="width: 650px;    background: #f5f5fa;    margin: 0 auto; ">
    <tr>
        <td></td>
        <td class="header container">
            
            <!-- content -->
            <div style="max-width: 630px;    margin: 0 auto;    display: block;">
                <table>
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
 <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;   min-width: 180px; font-weight: bold;   text-align: left;  float:left;">User Name :
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;     "><a href="https://www.docconsult.in/?id = '.$id.'">'.$p_name.'</a></span>
</td>
    
  </tr>
   <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;  min-width: 180px;font-weight: bold;   text-align: left;   float:left;">Email:
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;      ">'.$pemail.'</span></td>
    
  </tr>
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;min-width: 180px; font-weight: bold;   text-align: left;  float:left;">Mobile No :

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;    ">'.$pphone.'</span></td>
    
  </tr>
  
  
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;  min-width: 180px;font-weight: bold;   text-align: left;   float:left;">Review : Birth :
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;      ">'.$review.'</span></td>
    
  </tr>
                </table>
            </div>
            <!-- COLUMN WRAP -->
            
            <div  style="max-width: 630px;     margin: 0 auto;    display: block;">
                <table>
                    <tr>
                        <td>
                            <h4>Thank You For Using Docconsult.</h4>
                            <p class="lead">Regards,</p>
                            <p class="lead">Docconsult Team</p>
                            
                        </td>
                        </tr>
                    
                    
                        <td></td>
                    </tr>
                </table>
            </div>
        </td>
        <td></td>       <!---Footer End--->
    </tr>   
</table>

<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: linear-gradient(to right, #2D9CDB, #2F5894);">
    <tr>
        <td></td>
        <td class="header container">
            
            <div style="max-width: 630px;    margin: 0 auto;    display: block;">
            <table>
                <tr>
                    <td><a href="'.base_url.'"><img src="'.base_url.'/image/logo.png" alt="logo" ></a>
                    <p style="  font-size: 12px;     margin: 2px 10px;  color:#fff;">Contact NO : <strong> 0141-2785199</strong></p>
                    <p style="  font-size: 12px;      margin: 2px 10px;  color:#fff;">Email: <strong><a href="emailto:service@docconsult.in" style="color:#fff;">service@docconsult.in</a></strong></p>
                    <p style="   font-size: 12px;     margin: 2px 10px;  color:#fff;">Copyright © 2017 DocConsult | All Right Reserved 2016</p> </td>
                    
                    <td style="text-align: right;    width: 50%;">
                   <p style="float: right; text-align: right; margin-right: 0px; margin-top: 60px;">
                                                        <a href="https://www.facebook.com/docconsult/"><img src="'.base_url.'image/F.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a> 
                                                        <a href="https://twitter.com/Docconsult12"><img src="'.base_url.'image/T.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a>
                                                        <a href="https://www.youtube.com/channel/UCroHJE8lYtX3Wz9j233Dtwg"><img src="'.base_url.'image/Y.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a>
                                                        <a href="https://www.instagram.com/docconsultservices/"><img src="'.base_url.'image/I.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a> 
                                                        <a href="https://www.linkedin.com/in/docconsult-services-a70a72134/"><img src="'.base_url.'image/L.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a></br>
                                                        </p></td>
                </tr>
            </table>
            </div>
            
        </td>
        <td></td>
    </tr>
</table>';
    
   /* $msg = '<div style="width:100%; height:100%; margin:0;" >

	<div style="width:90%; float:left; height:70px;padding:30px;">

		<span style="width:50%;float:left"> <a href="https://docconsult.in"><img src="https://docconsult.in/image/logo.png"  style="height:70px"/></span></a>

		<span style="width:50%; text-align:right;float:left;font-size: 17px;">  <br /><b> </span>

	</div>

	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Hello '.$p_name.'<br></div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;"><strong>Thank You!</strong> For Submitting Your Feedback for '.$doc_details['be_name'].$doc_details['name'].'.<br></div>';
*/





$msg_admin = '<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: linear-gradient(to right, #2D9CDB, #2F5894);">
    <tr>
        <td></td>
        <td class="header container">
            
            <div style="max-width: 650px;    margin: 0 auto;    display: block;">
        <a href="'.base_url.'"><img src="'.base_url.'/image/logo.png" alt="logo" ></a>
            </div>
            
        </td>
        <td></td>
    </tr>
</table>

<!---content demo -->
<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: #f5f5fa; ">
    <tr>
        <td></td>
        <td class="header container">
            
            <div style="max-width: 630px;    margin: 0 auto;    display: block;">
            <table>
                    <tr>
                        <td>
                        <br>
                            <h3>Hello, Admin<br></h3>
                            <p class="lead">A Feedback has been submitted for <b> '.$doc_details['be_name'].$doc_details['name'].' </b> by, <br></p>
                        </td>
                    </tr>
                </table>
            </div>          
        </td>
        <td></td>
    </tr>
</table>
<!---content demo End-->
<table class="head-wrap" style="width: 650px;    background: #f5f5fa;    margin: 0 auto; ">
    <tr>
        <td></td>
        <td class="header container">
            
            <!-- content -->
            <div style="max-width: 630px;    margin: 0 auto;    display: block;">
                <table>
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
 <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;   min-width: 180px; font-weight: bold;   text-align: left;  float:left;">User Name :
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;     "><a href="https://www.docconsult.in/?id = '.$id.'">'.$p_name.'</a></span>
</td>
    
  </tr>
   <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;  min-width: 180px;font-weight: bold;   text-align: left;   float:left;">Email:
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;      ">'.$pemail.'</span></td>
    
  </tr>
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;min-width: 180px; font-weight: bold;   text-align: left;  float:left;">Mobile No :

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;    ">'.$pphone.'</span></td>
    
  </tr>
  
  
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;  min-width: 180px;font-weight: bold;   text-align: left;   float:left;">Review : Birth :
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;      ">'.$review.'</span></td>
    
  </tr>
                </table>
            </div>
            <!-- COLUMN WRAP -->
            
            <div  style="max-width: 630px;     margin: 0 auto;    display: block;">
                <table>
                    <tr>
                        <td>
                            <h4>Thank You For Using Docconsult.</h4>
                            <p class="lead">Regards,</p>
                            <p class="lead">Docconsult Team</p>
                        </td>
                        </tr>
                    
                    
                        <td></td>
                    </tr>
                </table>
            </div>
        </td>
        <td></td>       <!---Footer End--->
    </tr>   
</table>

<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: linear-gradient(to right, #2D9CDB, #2F5894);">
    <tr>
        <td></td>
        <td class="header container">
            
            <div style="max-width: 630px;    margin: 0 auto;    display: block;">
            <table>
                <tr>
                    <td><a href="'.base_url.'"><img src="'.base_url.'/image/logo.png" alt="logo" ></a>
                    <p style="  font-size: 12px;     margin: 2px 10px;  color:#fff;">Contact NO : <strong> 0141-2785199</strong></p>
                    <p style="  font-size: 12px;      margin: 2px 10px;  color:#fff;">Email: <strong><a href="emailto:service@docconsult.in" style="color:#fff;">service@docconsult.in</a></strong></p>
                    <p style="   font-size: 12px;     margin: 2px 10px;  color:#fff;">Copyright © 2017 DocConsult | All Right Reserved 2016</p> </td>
                    
                    <td style="text-align: right;    width: 50%;">
                   <p style="float: right; text-align: right; margin-right: 0px; margin-top: 60px;">
                                                        <a href="https://www.facebook.com/docconsult/"><img src="'.base_url.'image/F.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a> 
                                                        <a href="https://twitter.com/Docconsult12"><img src="'.base_url.'image/T.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a>
                                                        <a href="https://www.youtube.com/channel/UCroHJE8lYtX3Wz9j233Dtwg"><img src="'.base_url.'image/Y.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a>
                                                        <a href="https://www.instagram.com/docconsultservices/"><img src="'.base_url.'image/I.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a> 
                                                        <a href="https://www.linkedin.com/in/docconsult-services-a70a72134/"><img src="'.base_url.'image/L.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a></br>
                                                        </p></td>
                </tr>
            </table>
            </div>
            
        </td>
        <td></td>
    </tr>
</table>';
    
  /*  $msg_admin = '<div style="width:100%; height:100%; margin:0;" >

	<div style="width:90%; float:left; height:70px;padding:30px;">

		<span style="width:50%;float:left"> <a href="https://docconsult.in"><img src="https://docconsult.in/image/logo.png"  style="height:70px"/></span></a>

		<span style="width:50%; text-align:right;float:left;font-size: 17px;">  <br /><b> </span>

	</div>
    <div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Hello Admin,<br></div>
    <div style="width:90%;float:left;margin-top:20px;padding-left:26px;">A Feedback has been submitted for <b> '.$doc_details['be_name'].$doc_details['name'].' </b> by, <br></div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Name: '.$p_name.'<br></div>
    <div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Mobile-no: '.$pphone.'<br></div>
    <div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Email: '.$pemail.'<br></div>
    <div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Message: '.$review.'<br></div>';*/




$msg_doc = '<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: linear-gradient(to right, #2D9CDB, #2F5894);">
    <tr>
        <td></td>
        <td class="header container">
            
            <div style="max-width: 650px;    margin: 0 auto;    display: block;">
        <a href="'.base_url.'"><img src="'.base_url.'/image/logo.png" alt="logo" ></a>
            </div>
            
        </td>
        <td></td>
    </tr>
</table>

<!---content demo -->
<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: #f5f5fa; ">
    <tr>
        <td></td>
        <td class="header container">
            
            <div style="max-width: 630px;    margin: 0 auto;    display: block;">
            <table>
                    <tr>
                        <td>
                        <br>
                            <h3>Hello, '.$doc_details['be_name'].$doc_details['name'].'<br></h3>
                            <p class="lead">A Feedback has been submitted by, <br></p>
                        </td>
                    </tr>
                </table>
            </div>          
        </td>
        <td></td>
    </tr>
</table>
<!---content demo End-->
<table class="head-wrap" style="width: 650px;    background: #f5f5fa;    margin: 0 auto; ">
    <tr>
        <td></td>
        <td class="header container">
            
            <!-- content -->
            <div style="max-width: 630px;    margin: 0 auto;    display: block;">
                <table>
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
 <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;   min-width: 180px; font-weight: bold;   text-align: left;  float:left;">User Name :
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;     "><a href="https://www.docconsult.in/?id = '.$id.'">'.$p_name.'</a></span>
</td>
    
  </tr>
   <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;  min-width: 180px;font-weight: bold;   text-align: left;   float:left;">Email:
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;      ">'.$pemail.'</span></td>
    
  </tr>
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;min-width: 180px; font-weight: bold;   text-align: left;  float:left;">Mobile No :

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;    ">'.$pphone.'</span></td>
    
  </tr>
  
  
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;  min-width: 180px;font-weight: bold;   text-align: left;   float:left;">Review : Birth :
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;      ">'.$review.'</span></td>
    
  </tr>
                </table>
            </div>
            <!-- COLUMN WRAP -->
            
            <div  style="max-width: 630px;     margin: 0 auto;    display: block;">
                <table>
                    <tr>
                        <td>
                           <h4>Thank You For Using Docconsult.</h4>
                            <p class="lead">Regards,</p>
                            <p class="lead">Docconsult Team</p>
                            
                        </td>
                        </tr>
                    
                    
                        <td></td>
                    </tr>
                </table>
            </div>
        </td>
        <td></td>       <!---Footer End--->
    </tr>   
</table>

<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: linear-gradient(to right, #2D9CDB, #2F5894);">
    <tr>
        <td></td>
        <td class="header container">
            
            <div style="max-width: 630px;    margin: 0 auto;    display: block;">
            <table>
                <tr>
                    <td><a href="'.base_url.'"><img src="'.base_url.'/image/logo.png" alt="logo" ></a>
                    <p style="  font-size: 12px;     margin: 2px 10px;  color:#fff;">Contact NO : <strong> 0141-2785199</strong></p>
                    <p style="  font-size: 12px;      margin: 2px 10px;  color:#fff;">Email: <strong><a href="emailto:service@docconsult.in" style="color:#fff;">service@docconsult.in</a></strong></p>
                    <p style="   font-size: 12px;     margin: 2px 10px;  color:#fff;">Copyright © 2017 DocConsult | All Right Reserved 2016</p> </td>
                    
                    <td style="text-align: right;    width: 50%;">
                    <p style="float: right; text-align: right; margin-right: 0px; margin-top: 60px;">
                                                        <a href="https://www.facebook.com/docconsult/"><img src="'.base_url.'image/F.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a> 
                                                        <a href="https://twitter.com/Docconsult12"><img src="'.base_url.'image/T.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a>
                                                        <a href="https://www.youtube.com/channel/UCroHJE8lYtX3Wz9j233Dtwg"><img src="'.base_url.'image/Y.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a>
                                                        <a href="https://www.instagram.com/docconsultservices/"><img src="'.base_url.'image/I.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a> 
                                                        <a href="https://www.linkedin.com/in/docconsult-services-a70a72134/"><img src="'.base_url.'image/L.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a></br>
                                                        </p></td>
                </tr>
            </table>
            </div>
            
        </td>
        <td></td>
    </tr>
</table>';


    
   /* $msg_doc = '<div style="width:100%; height:100%; margin:0;" >

	<div style="width:90%; float:left; height:70px;padding:30px;">

		<span style="width:50%;float:left"> <a href="https://docconsult.in"><img src="https://docconsult.in/image/logo.png"  style="height:70px"/></span></a>

		<span style="width:50%; text-align:right;float:left;font-size: 17px;">  <br /><b> </span>

	</div>
    <div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Hello, '.$doc_details['be_name'].$doc_details['name'].'<br></div>
    <div style="width:90%;float:left;margin-top:20px;padding-left:26px;">A Feedback has been submitted by, <br></div>
   <div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Name: '.$p_name.'<br></div>
    <div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Mobile-no: '.$pphone.'<br></div>
    <div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Email: '.$pemail.'<br></div>
    <div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Message: '.$review.'<br></div>';
    
    */
  
    
    
     $this->foremail($doc_details['email'],$msg_doc,' kavitajha.docconsult@gmail.com','Feedback-Docconsult');                    
    $this->foremail($pemail,$msg,' kavitajha.docconsult@gmail.com','Acknowledgement For feedback- Docconsult');
    $this->foremail('kavitajha.docconsult@gmail.com',$msg_admin,'  kavitajha.docconsult@gmail.com','Feedback-Docconsult');  
    
   // $this->foremail($doc_details['email'],$msg_doc,'service@docconsult.in','Feedback-Docconsult');                    
  //  $this->foremail($pemail,$msg,'service@docconsult.in','Acknowledgement For feedback- Docconsult');
   // $this->foremail('info@docconsult.in',$msg_admin,'service@docconsult.in','Feedback-Docconsult');  
    
    $sms_string = ' successfully submitted for '.$doc_details['be_name'].$doc_details['name'];
    $sms = 'Hi '.$p_name.' Your Feedback has been '.$sms_string.' you can login here www.docconsult.in' ;
		$sms = str_replace("<", "", $sms);
		 $sms = str_replace(">", "", $sms);
		 $sms = rawurlencode($sms);
     //$send_sms_url = 'http://www.sms.jprinfotech.com/api/sendhttp.php?authkey=4296AbkgvkyLHP2b584bb4a2&mobiles='.$phone_no.'&message='.$sms.'&sender='.sender_id.'&route=4';
     //$send_sms_url='http://login.cheapsmsbazaar.com/vendorsms/pushsms.aspx?user=docconsult&password=aks120109&msisdn='.$phone_no.'&sid='.sender_id.'&msg='.$sms.'&fl=0&gwid=2';
       $send_sms_url='http://sms.digialaya.com/API/SMSHttp.aspx?UserId=docconsultadmin&pwd=pwd2017&Message='.$sms.'&Contacts='.$pphone.'&SenderId=DOCCON&ServiceName=SMSTRANS&StartTime=';
     $send_sms_url = str_replace(" ", "%20", $send_sms_url);
     
     $ch = curl_init();
     $timeout = 5;
     curl_setopt($ch, CURLOPT_URL, $send_sms_url);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
     curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
     curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
     curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
     curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
     $data = curl_exec($ch);
     curl_close($ch);
    
    $sms_string1 = ' successfully generated by '.$p_name;
    $sms1 = 'Hi '.$doc_details['be_name'].$doc_details['name'].' Your Feedback has been '.$sms_string1.' you can login here www.docconsult.in' ;
		$sms1 = str_replace("<", "", $sms1);
		 $sms1 = str_replace(">", "", $sms1);
		 $sms1 = rawurlencode($sms1);
     //$send_sms_url = 'http://www.sms.jprinfotech.com/api/sendhttp.php?authkey=4296AbkgvkyLHP2b584bb4a2&mobiles='.$phone_no.'&message='.$sms.'&sender='.sender_id.'&route=4';
     //$send_sms_url='http://login.cheapsmsbazaar.com/vendorsms/pushsms.aspx?user=docconsult&password=aks120109&msisdn='.$phone_no.'&sid='.sender_id.'&msg='.$sms.'&fl=0&gwid=2';
       $send_sms_url1='http://sms.digialaya.com/API/SMSHttp.aspx?UserId=docconsultadmin&pwd=pwd2017&Message='.$sms1.'&Contacts='.$doc_details['name'].'&SenderId=DOCCON&ServiceName=SMSTRANS&StartTime=';
     $send_sms_url1 = str_replace(" ", "%20", $send_sms_url1);
     
     $ch1 = curl_init();
     $timeout = 5;
     curl_setopt($ch, CURLOPT_URL, $send_sms_url1);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
     curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
     curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
     curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
     curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
     $data = curl_exec($ch1);
     curl_close($ch1);
    
    return TRUE;
}

public function insert_clinic_feedback($p_name, $pemail, $pphone, $knowledge, $helpfulness, $punctuality, $staff, $review, $recommendDoctor, $did, $pid){
    
    $date = date('Y-m-d');
    $res1 = $this->db->query("insert into clinic_feedback(name, email, description, rate, rate1, rate2, rate3, recommend, date, patient_id, clinic_id, flag)
                        values('$p_name', '$pemail', '$review', '$knowledge','$helpfulness','$punctuality', '$staff', '$recommendDoctor',  '$date', '$pid', '$did', '1')");
                        
    $clinic_details = $this->getById($did,'clinic');
    $doc_id = json_decode($clinic_details['secondary_doctor'],true);
    $doc_details = $this->getById($doc_id[0],'doctors');
    
   /* $msg = '<div style="width:100%; height:100%; margin:0;" >

	<div style="width:90%; float:left; height:70px;padding:30px;">

		<span style="width:50%;float:left"> <a href="https://docconsult.in"><img src="https://docconsult.in/image/logo.png"  style="height:70px"/></span></a>

		<span style="width:50%; text-align:right;float:left;font-size: 17px;">  <br /><b> </span>

	</div>

	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Hello '.$p_name.'<br></div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;"><strong>Thank You!</strong> For Submitting Your Feedback for <b> '.$clinic_details['name'].'.</b><br></div>';*/



$msg = '<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: linear-gradient(to right, #2D9CDB, #2F5894);">
    <tr>
        <td></td>
        <td class="header container">
            
            <div style="max-width: 650px;    margin: 0 auto;    display: block;">
        <a href="'.base_url.'"><img src="'.base_url.'/image/logo.png" alt="logo" ></a>
            
        </td>
        <td></td>
    </tr>
</table>

<!---content demo -->
<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: #f5f5fa; ">
    <tr>
        <td></td>
        <td class="header container">
            
            <div style="max-width: 630px;    margin: 0 auto;    display: block;">
            <table>
                    <tr>
                        <td>
                        <br>
                            <h3>Hello '.$p_name.'</h3>
                            <p class="lead"><strong>Thank You!</strong> For Submitting Your Feedback for <b> '.$clinic_details['name'].'.</b><br></p>
                        </td>
                    </tr>
                </table>
            </div>          
        </td>
        <td></td>
    </tr>
</table>
<!---content demo End-->
<table class="head-wrap" style="width: 650px;    background: #f5f5fa;    margin: 0 auto; ">
    <tr>
        <td></td>
        <td class="header container">
            
            <!-- content -->
            <div style="max-width: 630px;    margin: 0 auto;    display: block;">
                <table>
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
 <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;   min-width: 180px; font-weight: bold;   text-align: left;  float:left;">User Name :
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;     "><a href="https://www.docconsult.in/?id = '.$id.'">'.$p_name.'</a></span>
</td>
    
  </tr>
   <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;  min-width: 180px;font-weight: bold;   text-align: left;   float:left;">Email:
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;      ">'.$pemail.'</span></td>
    
  </tr>
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;min-width: 180px; font-weight: bold;   text-align: left;  float:left;">Mobile No :

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;    ">'.$pphone.'</span></td>
    
  </tr>
  
  
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;  min-width: 180px;font-weight: bold;   text-align: left;   float:left;">Review : Birth :
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;      ">'.$review.'</span></td>
    
  </tr>
                </table>
            </div>
            <!-- COLUMN WRAP -->
            
            <div  style="max-width: 630px;     margin: 0 auto;    display: block;">
                <table>
                    <tr>
                        <td>
                            
                            <h4>Thank You For Using Docconsult.</h4>
                            <p class="lead">Regards,</p>
                            <p class="lead">Docconsult Team</p>
                            
                        </td>
                        </tr>
                    
                    
                        <td></td>
                    </tr>
                </table>
            </div>
        </td>
        <td></td>       <!---Footer End--->
    </tr>   
</table>

<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: linear-gradient(to right, #2D9CDB, #2F5894);">
    <tr>
        <td></td>
        <td class="header container">
            
            <div style="max-width: 630px;    margin: 0 auto;    display: block;">
            <table>
                <tr>
                    <td><a href="'.base_url.'"><img src="'.base_url.'/image/logo.png" alt="logo" ></a>
                    <p style="  font-size: 12px;     margin: 2px 10px;  color:#fff;">Contact NO : <strong> 0141-2785199</strong></p>
                    <p style="  font-size: 12px;      margin: 2px 10px;  color:#fff;">Email: <strong><a href="emailto:service@docconsult.in" style="color:#fff;">service@docconsult.in</a></strong></p>
                    <p style="   font-size: 12px;     margin: 2px 10px;  color:#fff;">Copyright © 2017 DocConsult | All Right Reserved 2016</p> </td>
                    
                    <td style="text-align: right;    width: 50%;">
                    <p style="float: right; text-align: right; margin-right: 0px; margin-top: 60px;">
                                                        <a href="https://www.facebook.com/docconsult/"><img src="'.base_url.'image/F.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a> 
                                                        <a href="https://twitter.com/Docconsult12"><img src="'.base_url.'image/T.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a>
                                                        <a href="https://www.youtube.com/channel/UCroHJE8lYtX3Wz9j233Dtwg"><img src="'.base_url.'image/Y.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a>
                                                        <a href="https://www.instagram.com/docconsultservices/"><img src="'.base_url.'image/I.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a> 
                                                        <a href="https://www.linkedin.com/in/docconsult-services-a70a72134/"><img src="'.base_url.'image/L.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a></br>
                                                        </p></td>
                </tr>
            </table>
            </div>
            
        </td>
        <td></td>
    </tr>
</table>';





    /*
    $msg_admin = '<div style="width:100%; height:100%; margin:0;" >

	<div style="width:90%; float:left; height:70px;padding:30px;">

		<span style="width:50%;float:left"> <a href="https://docconsult.in"><img src="https://docconsult.in/image/logo.png"  style="height:70px"/></span></a>

		<span style="width:50%; text-align:right;float:left;font-size: 17px;">  <br /><b> </span>

	</div>
    <div style="width:90%;float:left;margin-top:20px;padding-left:26px;">A Feedback has been submitted for <b> '.$clinic_details['name'].' </b> by, <br></div>
    <div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Name: '.$p_name.'<br></div>
    <div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Mobile-no: '.$pphone.'<br></div>
    <div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Email: '.$pemail.'<br></div>
    <div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Message: '.$review.'<br></div>';*/





$msg_admin = '<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: linear-gradient(to right, #2D9CDB, #2F5894);">
    <tr>
        <td></td>
        <td class="header container">
            
            <div style="max-width: 650px;    margin: 0 auto;    display: block;">
      <a href="'.base_url.'"><img src="'.base_url.'/image/logo.png" alt="logo" ></a>
            </div>
            
        </td>
        <td></td>
    </tr>
</table>

<!---content demo -->
<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: #f5f5fa; ">
    <tr>
        <td></td>
        <td class="header container">
            
            <div style="max-width: 630px;    margin: 0 auto;    display: block;">
            <table>
                    <tr>
                        <td>
                        <br>
                            <h3>Hello, Admin</h3>
                            <p class="lead">A Feedback has been submitted for <b> '.$clinic_details['name'].' </b> by, <br></p>
                        </td>
                    </tr>
                </table>
            </div>          
        </td>
        <td></td>
    </tr>
</table>
<!---content demo End-->
<table class="head-wrap" style="width: 650px;    background: #f5f5fa;    margin: 0 auto; ">
    <tr>
        <td></td>
        <td class="header container">
            
            <!-- content -->
            <div style="max-width: 630px;    margin: 0 auto;    display: block;">
                <table>
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
 <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;   min-width: 180px; font-weight: bold;   text-align: left;  float:left;">User Name :
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;     "><a href="https://www.docconsult.in/?id = '.$id.'">'.$p_name.'</a></span>
</td>
    
  </tr>
   <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;  min-width: 180px;font-weight: bold;   text-align: left;   float:left;">Email:
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;      ">'.$pemail.'</span></td>
    
  </tr>
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;min-width: 180px; font-weight: bold;   text-align: left;  float:left;">Mobile No :

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;    ">'.$pphone.'</span></td>
    
  </tr>
  
  
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;  min-width: 180px;font-weight: bold;   text-align: left;   float:left;">Review : Birth :
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;      ">'.$review.'</span></td>
    
  </tr>
                </table>
            </div>
            <!-- COLUMN WRAP -->
            
            <div  style="max-width: 630px;     margin: 0 auto;    display: block;">
                <table>
                    <tr>
                        <td>
                            
                            <h4>Thank You </h4>
                            
                            
                        </td>
                        </tr>
                    
                    
                        <td></td>
                    </tr>
                </table>
            </div>
        </td>
        <td></td>       <!---Footer End--->
    </tr>   
</table>

<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: linear-gradient(to right, #2D9CDB, #2F5894);">
    <tr>
        <td></td>
        <td class="header container">
            
            <div style="max-width: 630px;    margin: 0 auto;    display: block;">
            <table>
                <tr>
                    <td><a href="'.base_url.'"><img src="'.base_url.'/image/logo.png" alt="logo" ></a>
                    <p style="  font-size: 12px;     margin: 2px 10px;  color:#fff;">Contact NO : <strong> 0141-2785199</strong></p>
                    <p style="  font-size: 12px;      margin: 2px 10px;  color:#fff;">Email: <strong><a href="emailto:service@docconsult.in" style="color:#fff;">service@docconsult.in</a></strong></p>
                    <p style="   font-size: 12px;     margin: 2px 10px;  color:#fff;">Copyright © 2017 DocConsult | All Right Reserved 2016</p> </td>
                    
                    <td style="text-align: right;    width: 50%;">
                   <p style="float: right; text-align: right; margin-right: 0px; margin-top: 60px;">
                                                        <a href="https://www.facebook.com/docconsult/"><img src="'.base_url.'image/F.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a> 
                                                        <a href="https://twitter.com/Docconsult12"><img src="'.base_url.'image/T.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a>
                                                        <a href="https://www.youtube.com/channel/UCroHJE8lYtX3Wz9j233Dtwg"><img src="'.base_url.'image/Y.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a>
                                                        <a href="https://www.instagram.com/docconsultservices/"><img src="'.base_url.'image/I.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a> 
                                                        <a href="https://www.linkedin.com/in/docconsult-services-a70a72134/"><img src="'.base_url.'image/L.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a></br>
                                                        </p></td>
                </tr>
            </table>
            </div>
            
        </td>
        <td></td>
    </tr>
</table>';



$msg_doc = '<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: linear-gradient(to right, #2D9CDB, #2F5894);">
    <tr>
        <td></td>
        <td class="header container">
            
            <div style="max-width: 650px;    margin: 0 auto;    display: block;">
        <a href="'.base_url.'"><img src="'.base_url.'/image/logo.png" alt="logo" ></a>
            
        </td>
        <td></td>
    </tr>
</table>

<!---content demo -->
<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: #f5f5fa; ">
    <tr>
        <td></td>
        <td class="header container">
            
            <div style="max-width: 630px;    margin: 0 auto;    display: block;">
            <table>
                    <tr>
                        <td>
                        <br>
                            <h3>Hello, '.$doc_details['be_name'].$doc_details['name'].'<br></h3>
                            <p class="lead">A Feedback has been submitted for <b>'.$clinic_details['name'].'</b> by,</p>
                        </td>
                    </tr>
                </table>
            </div>          
        </td>
        <td></td>
    </tr>
</table>
<!---content demo End-->
<table class="head-wrap" style="width: 650px;    background: #f5f5fa;    margin: 0 auto; ">
    <tr>
        <td></td>
        <td class="header container">
            
            <!-- content -->
            <div style="max-width: 630px;    margin: 0 auto;    display: block;">
                <table>
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
 <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;   min-width: 180px; font-weight: bold;   text-align: left;  float:left;">User Name :
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;     "><a href="https://www.docconsult.in/?id = '.$id.'">'.$p_name.'</a></span>
</td>
    
  </tr>
   <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;  min-width: 180px;font-weight: bold;   text-align: left;   float:left;">Email:
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;      ">'.$pemail.'</span></td>
    
  </tr>
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;min-width: 180px; font-weight: bold;   text-align: left;  float:left;">Mobile No :

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;    ">'.$pphone.'</span></td>
    
  </tr>
  
  
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;  min-width: 180px;font-weight: bold;   text-align: left;   float:left;">Review : Birth :
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;      ">'.$review.'</span></td>
    
  </tr>
                </table>
            </div>
            <!-- COLUMN WRAP -->
            
            <div  style="max-width: 630px;     margin: 0 auto;    display: block;">
                <table>
                    <tr>
                        <td>
                           
                            <h4>Thank You For Using Docconsult.</h4>
                            <p class="lead">Regards,</p>
                            <p class="lead">Docconsult Team</p>
                            
                        </td>
                        </tr>
                    
                    
                        <td></td>
                    </tr>
                </table>
            </div>
        </td>
        <td></td>       <!---Footer End--->
    </tr>   
</table>

<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: linear-gradient(to right, #2D9CDB, #2F5894);">
    <tr>
        <td></td>
        <td class="header container">
            
            <div style="max-width: 630px;    margin: 0 auto;    display: block;">
            <table>
                <tr>
                    <td><a href="'.base_url.'"><img src="'.base_url.'/image/logo.png" alt="logo" ></a>
                    <p style="  font-size: 12px;     margin: 2px 10px;  color:#fff;">Contact NO : <strong> 0141-2785199</strong></p>
                    <p style="  font-size: 12px;      margin: 2px 10px;  color:#fff;">Email: <strong><a href="emailto:service@docconsult.in" style="color:#fff;">service@docconsult.in</a></strong></p>
                    <p style="   font-size: 12px;     margin: 2px 10px;  color:#fff;">Copyright © 2017 DocConsult | All Right Reserved 2016</p> </td>
                    
                    <td style="text-align: right;    width: 50%;">
                    <p style="float: right; text-align: right; margin-right: 0px; margin-top: 60px;">
                                                        <a href="https://www.facebook.com/docconsult/"><img src="'.base_url.'image/F.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a> 
                                                        <a href="https://twitter.com/Docconsult12"><img src="'.base_url.'image/T.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a>
                                                        <a href="https://www.youtube.com/channel/UCroHJE8lYtX3Wz9j233Dtwg"><img src="'.base_url.'image/Y.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a>
                                                        <a href="https://www.instagram.com/docconsultservices/"><img src="'.base_url.'image/I.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a> 
                                                        <a href="https://www.linkedin.com/in/docconsult-services-a70a72134/"><img src="'.base_url.'image/L.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a></br>
                                                        </p></td>
                </tr>
            </table>
            </div>
            
        </td>
        <td></td>
    </tr>
</table>';


    
    /*$msg_doc = '<div style="width:100%; height:100%; margin:0;" >

	<div style="width:90%; float:left; height:70px;padding:30px;">

		<span style="width:50%;float:left"> <a href="https://docconsult.in"><img src="https://docconsult.in/image/logo.png"  style="height:70px"/></span></a>

		<span style="width:50%; text-align:right;float:left;font-size: 17px;">  <br /><b> </span>

	</div>
    <div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Hello, '.$doc_details['be_name'].$doc_details['name'].'<br></div>
    <div style="width:90%;float:left;margin-top:20px;padding-left:26px;">A Feedback has been submitted for <b>'.$clinic_details['name'].'</b> by, <br></div>
   <div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Name: '.$p_name.'<br></div>
    <div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Mobile-no: '.$pphone.'<br></div>
    <div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Email: '.$pemail.'<br></div>
    <div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Message: '.$review.'<br></div>';*/
    
     
      
       $this->foremail($doc_details['email'],$msg_doc,' kavitajha.docconsult@gmail.com','Clinic Feedback-Docconsult');                    
    $this->foremail($pemail,$msg,' kavitajha.docconsult@gmail.com','Acknowledgement For Clinic feedback- Docconsult');
    $this->foremail(' kavitajha.docconsult@gmail.com',$msg_admin,' kavitajha.docconsult@gmail.com','Clinic Feedback-Docconsult');    
    
    
   // $this->foremail($doc_details['email'],$msg_doc,'service@docconsult.in','Clinic Feedback-Docconsult');                    
    //$this->foremail($pemail,$msg,'service@docconsult.in','Acknowledgement For Clinic feedback- Docconsult');
   // $this->foremail('info@docconsult.in',$msg_admin,'service@docconsult.in','Clinic Feedback-Docconsult');    
    
                        
    return TRUE;
}

public function insert_company_feedback($p_name, $pemail, $pphone,$rate_cmpny ,$knowledge, $helpfulness, $punctuality, $staff, $review, $recommendDoctor, $pid){
    
    $date = date('Y-m-d');
    $res1 = $this->db->query("insert into company_feedback(name, email, description,rate_company ,rate, rate1, rate2, rate3,recommend, date, patient_id, flag)
                        values('$p_name', '$pemail', '$review','$rate_cmpny' ,'$knowledge','$helpfulness','$punctuality', '$staff', '$recommendDoctor', '$date', '$pid', '1')");
                        
    // $clinic_details = $this->getById($did,'clinic');
    // $doc_id = json_decode($clinic_details['secondary_doctor'],true);
    // $doc_details = $this->getById($doc_id[0],'doctors');


      $msg = '<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: linear-gradient(to right, #2D9CDB, #2F5894);">
    <tr>
        <td></td>
        <td class="header container">
            
            <div style="max-width: 650px;    margin: 0 auto;    display: block;">
       <a href="'.base_url.'"><img src="'.base_url.'/image/logo.png" alt="logo" ></a>
            </div>
            
        </td>
        <td></td>
    </tr>
</table>

<!---content demo -->
<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: #f5f5fa; ">
    <tr>
        <td></td>
        <td class="header container">
            
            <div style="max-width: 630px;    margin: 0 auto;    display: block;">
            <table>
                    <tr>
                        <td>
                        <br>
                            <h3>Hello '.$p_name.'</h3>
                            <p class="lead">Thank You!</strong> For Submitting Your Feedback for <b> DOCCONSULT</b>.</p>
                        </td>
                    </tr>
                </table>
            </div>          
        </td>
        <td></td>
    </tr>
</table>
<!---content demo End-->
<table class="head-wrap" style="width: 650px;    background: #f5f5fa;    margin: 0 auto; ">
    <tr>
        <td></td>
        <td class="header container">
            
            <!-- content -->
            <div style="max-width: 630px;    margin: 0 auto;    display: block;">
                <table>
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
 <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;   min-width: 180px; font-weight: bold;   text-align: left;  float:left;">User Name :
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;     "><a href="https://www.docconsult.in/?id = '.$id.'">'.$p_name.'</a></span>
</td>
    
  </tr>
   <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;  min-width: 180px;font-weight: bold;   text-align: left;   float:left;">Email:
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;      ">'.$pemail.'</span></td>
    
  </tr>
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;min-width: 180px; font-weight: bold;   text-align: left;  float:left;">Mobile No :

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;    ">'.$pphone.'</span></td>
    
  </tr>
  
  
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;  min-width: 180px;font-weight: bold;   text-align: left;   float:left;">Review : Birth :
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;      ">'.$review.'</span></td>
    
  </tr>
                </table>
            </div>
            <!-- COLUMN WRAP -->
            
            <div  style="max-width: 630px;     margin: 0 auto;    display: block;">
                <table>
                    <tr>
                        <td>
                            <h4>Thank You For Using Docconsult.</h4>
                            <p class="lead">Regards,</p>
                            <p class="lead">Docconsult Team</p>
                            
                        </td>
                        </tr>
                    
                    
                        <td></td>
                    </tr>
                </table>
            </div>
        </td>
        <td></td>       <!---Footer End--->
    </tr>   
</table>

<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: linear-gradient(to right, #2D9CDB, #2F5894);">
    <tr>
        <td></td>
        <td class="header container">
            
            <div style="max-width: 630px;    margin: 0 auto;    display: block;">
            <table>
                <tr>
                    <td><a href="'.base_url.'"><img src="'.base_url.'/image/logo.png" alt="logo" ></a>
                    <p style="  font-size: 12px;     margin: 2px 10px;  color:#fff;">Contact NO : <strong> 0141-2785199</strong></p>
                    <p style="  font-size: 12px;      margin: 2px 10px;  color:#fff;">Email: <strong><a href="emailto:service@docconsult.in" style="color:#fff;">service@docconsult.in</a></strong></p>
                    <p style="   font-size: 12px;     margin: 2px 10px;  color:#fff;">Copyright © 2017 DocConsult | All Right Reserved 2016</p> </td>
                    
                    <td style="text-align: right;    width: 50%;">
                    <p style="float: right; text-align: right; margin-right: 0px; margin-top: 60px;">
                                                        <a href="https://www.facebook.com/docconsult/"><img src="'.base_url.'image/F.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a> 
                                                        <a href="https://twitter.com/Docconsult12"><img src="'.base_url.'image/T.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a>
                                                        <a href="https://www.youtube.com/channel/UCroHJE8lYtX3Wz9j233Dtwg"><img src="'.base_url.'image/Y.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a>
                                                        <a href="https://www.instagram.com/docconsultservices/"><img src="'.base_url.'image/I.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a> 
                                                        <a href="https://www.linkedin.com/in/docconsult-services-a70a72134/"><img src="'.base_url.'image/L.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a></br>
                                                        </p></td>
                </tr>
            </table>
            </div>
            
        </td>
        <td></td>
    </tr>
</table>';
    
    /*$msg = '<div style="width:100%; height:100%; margin:0;" >

	<div style="width:90%; float:left; height:70px;padding:30px;">

		<span style="width:50%;float:left"> <a href="https://docconsult.in"><img src="https://docconsult.in/image/logo.png"  style="height:70px"/></span></a>

		<span style="width:50%; text-align:right;float:left;font-size: 17px;">  <br /><b> </span>

	</div>

	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Hello '.$p_name.'<br></div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;"><strong>Thank You!</strong> For Submitting Your Feedback for <b> DOCCONSULT</b>.<br></div>';*/

      $msg_admin = '<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: linear-gradient(to right, #2D9CDB, #2F5894);">
    <tr>
        <td></td>
        <td class="header container">
            
            <div style="max-width: 650px;    margin: 0 auto;    display: block;">
       <a href="'.base_url.'"><img src="'.base_url.'/image/logo.png" alt="logo" ></a>
            </div>
            
        </td>
        <td></td>
    </tr>
</table>

<!---content demo -->
<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: #f5f5fa; ">
    <tr>
        <td></td>
        <td class="header container">
            
            <div style="max-width: 630px;    margin: 0 auto;    display: block;">
            <table>
                    <tr>
                        <td>
                        <br>
                            <h3>Hello '.$p_name.'</h3>
                            <p class="lead">A Feedback has been submitted for <b> DOCCONSULT </b> by,</p>
                        </td>
                    </tr>
                </table>
            </div>          
        </td>
        <td></td>
    </tr>
</table>
<!---content demo End-->
<table class="head-wrap" style="width: 650px;    background: #f5f5fa;    margin: 0 auto; ">
    <tr>
        <td></td>
        <td class="header container">
            
            <!-- content -->
            <div style="max-width: 630px;    margin: 0 auto;    display: block;">
                <table>
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
 <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;   min-width: 180px; font-weight: bold;   text-align: left;  float:left;">User Name :
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;     "><a href="https://www.docconsult.in/?id = '.$id.'">'.$p_name.'</a></span>
</td>
    
  </tr>
   <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;  min-width: 180px;font-weight: bold;   text-align: left;   float:left;">Email:
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;      ">'.$pemail.'</span></td>
    
  </tr>
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;min-width: 180px; font-weight: bold;   text-align: left;  float:left;">Mobile No :

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;    ">'.$pphone.'</span></td>
    
  </tr>
  
  
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;  min-width: 180px;font-weight: bold;   text-align: left;   float:left;">Review : Birth :
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;      ">'.$review.'</span></td>
    
  </tr>
                </table>
            </div>
            <!-- COLUMN WRAP -->
            
            <div  style="max-width: 630px;     margin: 0 auto;    display: block;">
                <table>
                    <tr>
                        <td>

                            <h4>Thank You For Using Docconsult.</h4>
                            <p class="lead">Regards,</p>
                            <p class="lead">Docconsult Team</p>
                            
                        </td>
                        </tr>
                    
                    
                        <td></td>
                    </tr>
                </table>
            </div>
        </td>
        <td></td>       <!---Footer End--->
    </tr>   
</table>

<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: linear-gradient(to right, #2D9CDB, #2F5894);">
    <tr>
        <td></td>
        <td class="header container">
            
            <div style="max-width: 630px;    margin: 0 auto;    display: block;">
            <table>
                <tr>
                    <td><a href="'.base_url.'"><img src="'.base_url.'/image/logo.png" alt="logo" ></a>
                    <p style="  font-size: 12px;     margin: 2px 10px;  color:#fff;">Contact NO : <strong> 0141-2785199</strong></p>
                    <p style="  font-size: 12px;      margin: 2px 10px;  color:#fff;">Email: <strong><a href="emailto:service@docconsult.in" style="color:#fff;">service@docconsult.in</a></strong></p>
                    <p style="   font-size: 12px;     margin: 2px 10px;  color:#fff;">Copyright © 2017 DocConsult | All Right Reserved 2016</p> </td>
                    
                    <td style="text-align: right;    width: 50%;">
                    <p style="float: right; text-align: right; margin-right: 0px; margin-top: 60px;">
                                                        <a href="https://www.facebook.com/docconsult/"><img src="'.base_url.'image/F.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a> 
                                                        <a href="https://twitter.com/Docconsult12"><img src="'.base_url.'image/T.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a>
                                                        <a href="https://www.youtube.com/channel/UCroHJE8lYtX3Wz9j233Dtwg"><img src="'.base_url.'image/Y.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a>
                                                        <a href="https://www.instagram.com/docconsultservices/"><img src="'.base_url.'image/I.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a> 
                                                        <a href="https://www.linkedin.com/in/docconsult-services-a70a72134/"><img src="'.base_url.'image/L.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a></br>
                                                        </p></td>
                </tr>
            </table>
            </div>
            
        </td>
        <td></td>
    </tr>
</table>';
    
   /* $msg_admin = '<div style="width:100%; height:100%; margin:0;" >

	<div style="width:90%; float:left; height:70px;padding:30px;">

		<span style="width:50%;float:left"> <a href="https://docconsult.in"><img src="https://docconsult.in/image/logo.png"  style="height:70px"/></span></a>

		<span style="width:50%; text-align:right;float:left;font-size: 17px;">  <br /><b> </span>

	</div>
    <div style="width:90%;float:left;margin-top:20px;padding-left:26px;">A Feedback has been submitted for <b> DOCCONSULT </b> by, <br></div>
    <div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Name: '.$p_name.'<br></div>
    <div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Mobile-no: '.$pphone.'<br></div>
    <div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Email: '.$pemail.'<br></div>
    <div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Message: '.$review.'<br></div>';*/
    
   
    
     $this->foremail($pemail,$msg,'kavitajha.docconsult@gmail.co','Acknowledgement For feedback- Docconsult');
    $this->foremail('kavitajha.docconsult@gmail.co',$msg_admin,'kavitajha.docconsult@gmail.co','Feedback-Docconsult');   
    
    
    //$this->foremail($pemail,$msg,'service@docconsult.in','Acknowledgement For feedback- Docconsult');
    //$this->foremail('info@docconsult.in',$msg_admin,'service@docconsult.in','Feedback-Docconsult');    
    
                        
    return TRUE;
}

public function insert_feedback_without_login($p_name, $pemail, $pphone, $knowledge, $helpfulness, $punctuality, $staff, $review, $recommendDoctor, $did, $pid){
    
    $date = date('Y-m-d');
    
    $res2 = $this->db->query("select id from patient where phone_no = '$pphone' and password!= '' order by id asc limit 1");
    
    if($res2->num_rows > 0){
        
        $d1 = $res2->fetch_assoc();
        $p_id = $d1['id']; 
        
        $res4 = $this->db->query("insert into feedback(name, email, description, rate, rate1, rate2, rate3, recommend, date, patient_id, doctor_id, flag)
                values('$p_name', '$pemail', '$review', '$knowledge','$helpfulness','$punctuality', '$staff', '$recommendDoctor',  '$date', '$p_id', '$did', '1')");    
    }else{
        
        $pass = sha1($pphone);
    	$d=$this->db->query("insert into patient(name, email, password, phone_no, date) 
    	                        values('$p_name', '$pemail', '$pass', '$pphone', '$date')");
    
    	$query = $this->db->query("select id from patient order by id desc limit 1 ");
    	$res1 = $query->fetch_assoc();
        $table_id = $res1['id'];
    
        $res3 = $this->db->query("select MAX(patient_id) as patient_max_id from patient");    
        $data3 = $res3->fetch_assoc();
        $patient_id = $data3['patient_max_id']+1;
    
        $this->db->query("update patient set patient_id = '$patient_id', parent_id = '$table_id' where id = '$table_id' ");       
        
        $this->db->query("insert into feedback(name, email, description, rate, rate1, rate2, rate3, recommend, date, patient_id, doctor_id, flag)
        values('$p_name', '$pemail', '$review', '$knowledge','$helpfulness','$punctuality', '$staff', '$recommendDoctor',  '$date', '$table_id', '$did', '1')");
    }
    
    
    $doc_details = $this->getById($did,'doctors');

     $msg = '<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: linear-gradient(to right, #2D9CDB, #2F5894);">
    <tr>
        <td></td>
        <td class="header container">
            
            <div style="max-width: 650px;    margin: 0 auto;    display: block;">
        <a href="'.base_url.'"><img src="'.base_url.'/image/logo.png" alt="logo" ></a>
            </div>
            
        </td>
        <td></td>
    </tr>
</table>

<!---content demo -->
<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: #f5f5fa; ">
    <tr>
        <td></td>
        <td class="header container">
            
            <div style="max-width: 630px;    margin: 0 auto;    display: block;">
            <table>
                    <tr>
                        <td>
                        <br>
                            <h3>Hello '.$p_name.'</h3>
                            <p class="lead">Thank You!</strong> For Submitting Your Feedback for <b>'.$doc_details['be_name'].$doc_details['name'].'</b>.<br></p>
                        </td>
                    </tr>
                </table>
            </div>          
        </td>
        <td></td>
    </tr>
</table>
<!---content demo End-->
<table class="head-wrap" style="width: 650px;    background: #f5f5fa;    margin: 0 auto; ">
    <tr>
        <td></td>
        <td class="header container">
            
            <!-- content -->
            <div style="max-width: 630px;    margin: 0 auto;    display: block;">
                <table>
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
 <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;   min-width: 180px; font-weight: bold;   text-align: left;  float:left;">User Name :
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;     "><a href="https://www.docconsult.in/?id = '.$id.'">'.$p_name.'</a></span>
</td>
    
  </tr>
   <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;  min-width: 180px;font-weight: bold;   text-align: left;   float:left;">Email:
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;      ">'.$pemail.'</span></td>
    
  </tr>
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;min-width: 180px; font-weight: bold;   text-align: left;  float:left;">Mobile No :

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;    ">'.$pphone.'</span></td>
    
  </tr>
  
  
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;  min-width: 180px;font-weight: bold;   text-align: left;   float:left;">Review : Birth :
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;      ">'.$review.'</span></td>
    
  </tr>
    

                    <tr>    
                        <td></td><td></td>
                    </tr>
                </table>
            </div>
            <!-- COLUMN WRAP -->
            
            <div  style="max-width: 630px;     margin: 0 auto;    display: block;">
                <table>
                    <tr>
                        <td>
                           
                            <h4>Thank You For Using Docconsult.</h4>
                            <p class="lead">Regards,</p>
                            <p class="lead">Docconsult Team</p>
                            
                        </td>
                        </tr>
                    
                    
                        <td></td>
                    </tr>
                </table>
            </div>
        </td>
        <td></td>       <!---Footer End--->
    </tr>   
</table>

<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: linear-gradient(to right, #2D9CDB, #2F5894);">
    <tr>
        <td></td>
        <td class="header container">
            
            <div style="max-width: 630px;    margin: 0 auto;    display: block;">
            <table>
                <tr>
                    <td><a href="'.base_url.'"><img src="'.base_url.'/image/logo.png" alt="logo" ></a>
                    <p style="  font-size: 12px;     margin: 2px 10px;  color:#fff;">Contact NO : <strong> 0141-2785199</strong></p>
                    <p style="  font-size: 12px;      margin: 2px 10px;  color:#fff;">Email: <strong><a href="emailto:service@docconsult.in" style="color:#fff;">service@docconsult.in</a></strong></p>
                    <p style="   font-size: 12px;     margin: 2px 10px;  color:#fff;">Copyright © 2017 DocConsult | All Right Reserved 2016</p> </td>
                    
                    <td style="text-align: right;    width: 50%;">
                    <p style="float: right; text-align: right; margin-right: 0px; margin-top: 60px;">
                                                        <a href="https://www.facebook.com/docconsult/"><img src="'.base_url.'image/F.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a> 
                                                        <a href="https://twitter.com/Docconsult12"><img src="'.base_url.'image/T.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a>
                                                        <a href="https://www.youtube.com/channel/UCroHJE8lYtX3Wz9j233Dtwg"><img src="'.base_url.'image/Y.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a>
                                                        <a href="https://www.instagram.com/docconsultservices/"><img src="'.base_url.'image/I.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a> 
                                                        <a href="https://www.linkedin.com/in/docconsult-services-a70a72134/"><img src="'.base_url.'image/L.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a></br>
                                                        </p></td>
                </tr>
            </table>
            </div>
            
        </td>
        <td></td>
    </tr>
</table>';

    
   /* $msg = '<div style="width:100%; height:100%; margin:0;" >

	<div style="width:90%; float:left; height:70px;padding:30px;">

		<span style="width:50%;float:left"> <a href="https://docconsult.in"><img src="https://docconsult.in/image/logo.png"  style="height:70px"/></span></a>

		<span style="width:50%; text-align:right;float:left;font-size: 17px;">  <br /><b> </span>

	</div>

	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Hello '.$p_name.'<br></div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;"><strong>Thank You!</strong> For Submitting Your Feedback for <b>'.$doc_details['be_name'].$doc_details['name'].'</b>.<br></div>';*/


    $msg_admin = '<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: linear-gradient(to right, #2D9CDB, #2F5894);">
    <tr>
        <td></td>
        <td class="header container">
            
            <div style="max-width: 650px;    margin: 0 auto;    display: block;">
        <a href="'.base_url.'"><img src="'.base_url.'/image/logo.png" alt="logo" ></a>
            </div>
            
        </td>
        <td></td>
    </tr>
</table>

<!---content demo -->
<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: #f5f5fa; ">
    <tr>
        <td></td>
        <td class="header container">
            
            <div style="max-width: 630px;    margin: 0 auto;    display: block;">
            <table>
                    <tr>
                        <td>
                        <br>
                            <h3>Hello, '.$doc_details['be_name'].$doc_details['name'].'<br></h3>
                            <p class="lead">A Feedback has been submitted for <b> '.$doc_details['be_name'].$doc_details['name'].' </b> by,  <br></p>
                
                            
                            
                        </td>
                    </tr>
                </table>
            </div>          
        </td>
        <td></td>
    </tr>
</table>
<!---content demo End-->
<table class="head-wrap" style="width: 650px;    background: #f5f5fa;    margin: 0 auto; ">
    <tr>
        <td></td>
        <td class="header container">
            
            <!-- content -->
            <div style="max-width: 630px;    margin: 0 auto;    display: block;">
                <table>
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
 <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;   min-width: 180px; font-weight: bold;   text-align: left;  float:left;">User Name :
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;     "><a href="https://www.docconsult.in/?id = '.$id.'">'.$p_name.'</a></span>
</td>
    
  </tr>
   <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;  min-width: 180px;font-weight: bold;   text-align: left;   float:left;">Email:
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;      ">'.$pemail.'</span></td>
    
  </tr>
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;min-width: 180px; font-weight: bold;   text-align: left;  float:left;">Mobile No :

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;    ">'.$pphone.'</span></td>
    
  </tr>
  
  
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;  min-width: 180px;font-weight: bold;   text-align: left;   float:left;">Review : Birth :
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;      ">'.$review.'</span></td>
    
  </tr>
    
           
                    <tr>    
                        <td></td><td></td>
                    </tr>
                </table>
            </div>
            <!-- COLUMN WRAP -->
            
            <div  style="max-width: 630px;     margin: 0 auto;    display: block;">
                <table>
                    <tr>
                        <td>
                           
                            <h4>Thank You For Using Docconsult.</h4>
                            <p class="lead">Regards,</p>
                            <p class="lead">Docconsult Team</p>
                            
                        </td>
                        </tr>
                    
                    
                        <td></td>
                    </tr>
                </table>
            </div>
        </td>
        <td></td>       <!---Footer End--->
    </tr>   
</table>

<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: linear-gradient(to right, #2D9CDB, #2F5894);">
    <tr>
        <td></td>
        <td class="header container">
            
            <div style="max-width: 630px;    margin: 0 auto;    display: block;">
            <table>
                <tr>
                    <td><a href="'.base_url.'"><img src="'.base_url.'/image/logo.png" alt="logo" ></a>
                    <p style="  font-size: 12px;     margin: 2px 10px;  color:#fff;">Contact NO : <strong> 0141-2785199</strong></p>
                    <p style="  font-size: 12px;      margin: 2px 10px;  color:#fff;">Email: <strong><a href="emailto:service@docconsult.in" style="color:#fff;">service@docconsult.in</a></strong></p>
                    <p style="   font-size: 12px;     margin: 2px 10px;  color:#fff;">Copyright © 2017 DocConsult | All Right Reserved 2016</p> </td>
                    
                    <td style="text-align: right;    width: 50%;">
                  <p style="float: right; text-align: right; margin-right: 0px; margin-top: 60px;">
                                                        <a href="https://www.facebook.com/docconsult/"><img src="'.base_url.'image/F.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a> 
                                                        <a href="https://twitter.com/Docconsult12"><img src="'.base_url.'image/T.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a>
                                                        <a href="https://www.youtube.com/channel/UCroHJE8lYtX3Wz9j233Dtwg"><img src="'.base_url.'image/Y.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a>
                                                        <a href="https://www.instagram.com/docconsultservices/"><img src="'.base_url.'image/I.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a> 
                                                        <a href="https://www.linkedin.com/in/docconsult-services-a70a72134/"><img src="'.base_url.'image/L.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a></br>
                                                        </p></td>
                </tr>
            </table>
            </div>
            
        </td>
        <td></td>
    </tr>
</table>';
    
    /*$msg_admin = '<div style="width:100%; height:100%; margin:0;" >

	<div style="width:90%; float:left; height:70px;padding:30px;">

		<span style="width:50%;float:left"> <a href="https://docconsult.in"><img src="https://docconsult.in/image/logo.png"  style="height:70px"/></span></a>

		<span style="width:50%; text-align:right;float:left;font-size: 17px;">  <br /><b> </span>

	</div>
        
    <div style="width:90%;float:left;margin-top:20px;padding-left:26px;">A Feedback has been submitted for <b> '.$doc_details['be_name'].$doc_details['name'].' </b> by, <br></div>
    <div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Name: '.$p_name.'<br></div>
    <div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Mobile-no: '.$pphone.'<br></div>
    <div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Email: '.$pemail.'<br></div>
    <div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Message: '.$review.'<br></div>';
*/

    $msg_doc = '<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: linear-gradient(to right, #2D9CDB, #2F5894);">
    <tr>
        <td></td>
        <td class="header container">
            
            <div style="max-width: 650px;    margin: 0 auto;    display: block;">
      <a href="'.base_url.'"><img src="'.base_url.'/image/logo.png" alt="logo" ></a>
            </div>
            
        </td>
        <td></td>
    </tr>
</table>

<!---content demo -->
<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: #f5f5fa; ">
    <tr>
        <td></td>
        <td class="header container">
            
            <div style="max-width: 630px;    margin: 0 auto;    display: block;">
            <table>
                    <tr>
                        <td>
                        <br>
                            <h3>Hello, '.$doc_details['be_name'].$doc_details['name'].'<br></h3>
                            <p class="lead">A Feedback has been submitted by, <br></p>
                
                            
                             
                        </td>
                    </tr>
                </table>
            </div>          
        </td>
        <td></td>
    </tr>
</table>
<!---content demo End-->
<table class="head-wrap" style="width: 650px;    background: #f5f5fa;    margin: 0 auto; ">
    <tr>
        <td></td>
        <td class="header container">
            
            <!-- content -->
            <div style="max-width: 630px;    margin: 0 auto;    display: block;">
                <table>
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
 <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;   min-width: 180px; font-weight: bold;   text-align: left;  float:left;">User Name :
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;     "><a href="https://www.docconsult.in/?id = '.$id.'">'.$p_name.'</a></span>
</td>
    
  </tr>
   <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;  min-width: 180px;font-weight: bold;   text-align: left;   float:left;">Email:
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;      ">'.$pemail.'</span></td>
    
  </tr>
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;min-width: 180px; font-weight: bold;   text-align: left;  float:left;">Mobile No :

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;    ">'.$pphone.'</span></td>
    
  </tr>
  
  
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;  min-width: 180px;font-weight: bold;   text-align: left;   float:left;">Review : Birth :
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;      ">'.$review.'</span></td>
    
  </tr>
    
          
                    <tr>    
                        <td></td><td></td>
                    </tr>
                </table>
            </div>
            <!-- COLUMN WRAP -->
            
            <div  style="max-width: 630px;     margin: 0 auto;    display: block;">
                <table>
                    <tr>
                        <td>
                           
                            <h4>Thank You For Using Docconsult.</h4>
                            <p class="lead">Regards,</p>
                            <p class="lead">Docconsult Team</p>
                            
                        </td>
                        </tr>
                    
                    
                        <td></td>
                    </tr>
                </table>
            </div>
        </td>
        <td></td>       <!---Footer End--->
    </tr>   
</table>

<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: linear-gradient(to right, #2D9CDB, #2F5894);">
    <tr>
        <td></td>
        <td class="header container">
            
            <div style="max-width: 630px;    margin: 0 auto;    display: block;">
            <table>
                <tr>
                    <td><a href="'.base_url.'"><img src="'.base_url.'/image/logo.png" alt="logo" ></a>
                    <p style="  font-size: 12px;     margin: 2px 10px;  color:#fff;">Contact NO : <strong> 0141-2785199</strong></p>
                    <p style="  font-size: 12px;      margin: 2px 10px;  color:#fff;">Email: <strong><a href="emailto:service@docconsult.in" style="color:#fff;">service@docconsult.in</a></strong></p>
                    <p style="   font-size: 12px;     margin: 2px 10px;  color:#fff;">Copyright © 2017 DocConsult | All Right Reserved 2016</p> </td>
                    
                    <td style="text-align: right;    width: 50%;">
                    <p style="float: right; text-align: right; margin-right: 0px; margin-top: 60px;">
                                                        <a href="https://www.facebook.com/docconsult/"><img src="'.base_url.'image/F.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a> 
                                                        <a href="https://twitter.com/Docconsult12"><img src="'.base_url.'image/T.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a>
                                                        <a href="https://www.youtube.com/channel/UCroHJE8lYtX3Wz9j233Dtwg"><img src="'.base_url.'image/Y.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a>
                                                        <a href="https://www.instagram.com/docconsultservices/"><img src="'.base_url.'image/I.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a> 
                                                        <a href="https://www.linkedin.com/in/docconsult-services-a70a72134/"><img src="'.base_url.'image/L.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a></br>
                                                        </p></td>
                </tr>
            </table>
            </div>
            
        </td>
        <td></td>
    </tr>
</table>';
    
   /* $msg_doc = '<div style="width:100%; height:100%; margin:0;" >

	<div style="width:90%; float:left; height:70px;padding:30px;">

		<span style="width:50%;float:left"> <a href="https://docconsult.in"><img src="https://docconsult.in/image/logo.png"  style="height:70px"/></span></a>

		<span style="width:50%; text-align:right;float:left;font-size: 17px;">  <br /><b> </span>

	</div>
    <div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Hello, '.$doc_details['be_name'].$doc_details['name'].'<br></div>
    <div style="width:90%;float:left;margin-top:20px;padding-left:26px;">A Feedback has been submitted by, <br></div>
    <div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Name: '.$p_name.'<br></div>
    <div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Mobile-no: '.$pphone.'<br></div>
    <div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Email: '.$pemail.'<br></div>
    <div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Message: '.$review.'<br></div>';*/
    
    $this->foremail($doc_details['email'],$msg_doc,'service@docconsult.in','Feedback-Docconsult');                    
    $this->foremail($pemail,$msg,'service@docconsult.in','Acknowledgement For feedback- Docconsult');
    $this->foremail('info@docconsult.in',$msg_admin,'service@docconsult.in','Feedback-Docconsult');  
    
    $sms_string = ' successfully submitted for '.$doc_details['be_name'].$doc_details['name'];
    $sms = 'Hi '.$p_name.' Your Feedback has been '.$sms_string.' you can login here www.docconsult.in' ;
		$sms = str_replace("<", "", $sms);
		 $sms = str_replace(">", "", $sms);
		 $sms = rawurlencode($sms);
     //$send_sms_url = 'http://www.sms.jprinfotech.com/api/sendhttp.php?authkey=4296AbkgvkyLHP2b584bb4a2&mobiles='.$phone_no.'&message='.$sms.'&sender='.sender_id.'&route=4';
     //$send_sms_url='http://login.cheapsmsbazaar.com/vendorsms/pushsms.aspx?user=docconsult&password=aks120109&msisdn='.$phone_no.'&sid='.sender_id.'&msg='.$sms.'&fl=0&gwid=2';
       $send_sms_url='http://sms.digialaya.com/API/SMSHttp.aspx?UserId=docconsultadmin&pwd=pwd2017&Message='.$sms.'&Contacts='.$pphone.'&SenderId=DOCCON&ServiceName=SMSTRANS&StartTime=';
     $send_sms_url = str_replace(" ", "%20", $send_sms_url);
     
     $ch = curl_init();
     $timeout = 5;
     curl_setopt($ch, CURLOPT_URL, $send_sms_url);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
     curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
     curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
     curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
     curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
     $data = curl_exec($ch);
     curl_close($ch);
    
    $sms_string1 = ' successfully generated by '.$p_name;
    $sms1 = 'Hi '.$doc_details['be_name'].$doc_details['name'].' Your Feedback has been '.$sms_string1.' you can login here www.docconsult.in' ;
		$sms1 = str_replace("<", "", $sms1);
		 $sms1 = str_replace(">", "", $sms1);
		 $sms1 = rawurlencode($sms1);
     //$send_sms_url = 'http://www.sms.jprinfotech.com/api/sendhttp.php?authkey=4296AbkgvkyLHP2b584bb4a2&mobiles='.$phone_no.'&message='.$sms.'&sender='.sender_id.'&route=4';
     //$send_sms_url='http://login.cheapsmsbazaar.com/vendorsms/pushsms.aspx?user=docconsult&password=aks120109&msisdn='.$phone_no.'&sid='.sender_id.'&msg='.$sms.'&fl=0&gwid=2';
       $send_sms_url1='http://sms.digialaya.com/API/SMSHttp.aspx?UserId=docconsultadmin&pwd=pwd2017&Message='.$sms1.'&Contacts='.$doc_details['name'].'&SenderId=DOCCON&ServiceName=SMSTRANS&StartTime=';
     $send_sms_url1 = str_replace(" ", "%20", $send_sms_url1);
     
     $ch1 = curl_init();
     $timeout = 5;
     curl_setopt($ch, CURLOPT_URL, $send_sms_url1);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
     curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
     curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
     curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
     curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
     $data = curl_exec($ch1);
     curl_close($ch1);
    
    return TRUE;
}

public function insert_clinic_feedback_without_login($p_name, $pemail, $pphone, $knowledge, $helpfulness, $punctuality, $staff, $review, $recommendDoctor, $did, $pid){
    
    $date = date('Y-m-d');
    
    $res2 = $this->db->query("select id from patient where phone_no = '$pphone' and password!= '' order by id asc limit 1");
    
    if($res2->num_rows > 0){
        
        $d1 = $res2->fetch_assoc();
        $p_id = $d1['id']; 
        
        $res4 = $this->db->query("insert into clinic_feedback(name, email, description, rate, rate1, rate2, rate3, recommend, date, patient_id, clinic_id, flag)
                values('$p_name', '$pemail', '$review', '$knowledge','$helpfulness','$punctuality', '$staff', '$recommendDoctor',  '$date', '$p_id', '$did', '1')");    
    }else{
        
        $pass = sha1($pphone);
    	$d=$this->db->query("insert into patient(name, email, password, phone_no, date) 
    	                        values('$p_name', '$pemail', '$pass', '$pphone', '$date')");
    
    	$query = $this->db->query("select id from patient order by id desc limit 1 ");
    	$res1 = $query->fetch_assoc();
        $table_id = $res1['id'];
    
        $res3 = $this->db->query("select MAX(patient_id) as patient_max_id from patient");    
        $data3 = $res3->fetch_assoc();
        $patient_id = $data3['patient_max_id']+1;
    
        $this->db->query("update patient set patient_id = '$patient_id', parent_id = '$table_id' where id = '$table_id' ");       
        
        $this->db->query("insert into clinic_feedback(name, email, description, rate, rate1, rate2, rate3, recommend, date, patient_id, clinic_id, flag)
        values('$p_name', '$pemail', '$review', '$knowledge','$helpfulness','$punctuality', '$staff', '$recommendDoctor',  '$date', '$table_id', '$did', '1')");
    }
    
    $clinic_details = $this->getById($did,'clinic');
    $doc_id = json_decode($clinic_details['secondary_doctor'],true);
    $doc_details = $this->getById($doc_id[0],'doctors');


    $msg = '<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: linear-gradient(to right, #2D9CDB, #2F5894);">
    <tr>
        <td></td>
        <td class="header container">
            
            <div style="max-width: 650px;    margin: 0 auto;    display: block;">
        <a href="'.base_url.'"><img src="'.base_url.'/image/logo.png" alt="logo" ></a>
            </div>
            
        </td>
        <td></td>
    </tr>
</table>

<!---content demo -->
<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: #f5f5fa; ">
    <tr>
        <td></td>
        <td class="header container">
            
            <div style="max-width: 630px;    margin: 0 auto;    display: block;">
            <table>
                    <tr>
                        <td>
                        <br>
                            <h3>Hello '.$p_name.'</h3>
                            <p class="lead"><strong>Thank You!</strong> For Submitting Your Feedback for <b> '.$clinic_details['name'].'.</p>
                        </td>
                    </tr>
                </table>
            </div>          
        </td>
        <td></td>
    </tr>
</table>
<!---content demo End-->
<table class="head-wrap" style="width: 650px;    background: #f5f5fa;    margin: 0 auto; ">
    <tr>
        <td></td>
        <td class="header container">
            
            <!-- content -->
            <div style="max-width: 630px;    margin: 0 auto;    display: block;">
                <table>
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
 <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;   min-width: 180px; font-weight: bold;   text-align: left;  float:left;">User Name :
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;     "><a href="https://www.docconsult.in/?id = '.$id.'">'.$p_name.'</a></span>
</td>
    
  </tr>
   <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;  min-width: 180px;font-weight: bold;   text-align: left;   float:left;">Email:
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;      ">'.$pemail.'</span></td>
    
  </tr>
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;min-width: 180px; font-weight: bold;   text-align: left;  float:left;">Mobile No :

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;    ">'.$pphone.'</span></td>
    
  </tr>
  
  
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;  min-width: 180px;font-weight: bold;   text-align: left;   float:left;">Review : Birth :
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;      ">'.$review.'</span></td>
    
  </tr>
    
              
                    <tr>    
                        <td></td><td></td>
                    </tr>
                </table>
            </div>
            <!-- COLUMN WRAP -->
            
            <div  style="max-width: 630px;     margin: 0 auto;    display: block;">
                <table>
                    <tr>
                        <td>
                         
                            <h4>Thank You For Using Docconsult.</h4>
                           <p class="lead">Regards,</p>
                            <p class="lead">Docconsult Team</p>
                            
                        </td>
                        </tr>
                    
                    
                        <td></td>
                    </tr>
                </table>
            </div>
        </td>
        <td></td>       <!---Footer End--->
    </tr>   
</table>

<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: linear-gradient(to right, #2D9CDB, #2F5894);">
    <tr>
        <td></td>
        <td class="header container">
            
            <div style="max-width: 630px;    margin: 0 auto;    display: block;">
            <table>
                <tr>
                    <td><a href="#"><img style="height:70px" src="https://docconsult.in/image/logo.png" ></a>
                    <p style="  font-size: 12px;     margin: 2px 10px;  color:#fff;">Contact NO : <strong> 0141-2785199</strong></p>
                    <p style="  font-size: 12px;      margin: 2px 10px;  color:#fff;">Email: <strong><a href="emailto:service@docconsult.in" style="color:#fff;">service@docconsult.in</a></strong></p>
                    <p style="   font-size: 12px;     margin: 2px 10px;  color:#fff;">Copyright © 2017 DocConsult | All Right Reserved 2016</p> </td>
                    
                    <td style="text-align: right;    width: 50%;">
                    <p style="float: right; text-align: right; margin-right: 0px; margin-top: 60px;">
                                                        <a href="https://www.facebook.com/docconsult/"><img src="'.base_url.'image/F.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a> 
                                                        <a href="https://twitter.com/Docconsult12"><img src="'.base_url.'image/T.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a>
                                                        <a href="https://www.youtube.com/channel/UCroHJE8lYtX3Wz9j233Dtwg"><img src="'.base_url.'image/Y.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a>
                                                        <a href="https://www.instagram.com/docconsultservices/"><img src="'.base_url.'image/I.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a> 
                                                        <a href="https://www.linkedin.com/in/docconsult-services-a70a72134/"><img src="'.base_url.'image/L.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a></br>
                                                        </p></td>
                </tr>
            </table>
            </div>
            
        </td>
        <td></td>
    </tr>
</table>';






    /*
    $msg = '<div style="width:100%; height:100%; margin:0;" >

	<div style="width:90%; float:left; height:70px;padding:30px;">

		<span style="width:50%;float:left"> <a href="https://docconsult.in"><img src="https://docconsult.in/image/logo.png"  style="height:70px"/></span></a>

		<span style="width:50%; text-align:right;float:left;font-size: 17px;">  <br /><b> </span>

	</div>

	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Hello '.$p_name.'<br></div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;"><strong>Thank You!</strong> For Submitting Your Feedback for <b> '.$clinic_details['name'].'.</b><br></div>';*/


    $msg_admin = '<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: linear-gradient(to right, #2D9CDB, #2F5894);">
    <tr>
        <td></td>
        <td class="header container">
            
            <div style="max-width: 650px;    margin: 0 auto;    display: block;">
      <a href="'.base_url.'"><img src="'.base_url.'/image/logo.png" alt="logo" ></a>
            </div>
            
        </td>
        <td></td>
    </tr>
</table>

<!---content demo -->
<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: #f5f5fa; ">
    <tr>
        <td></td>
        <td class="header container">
            
            <div style="max-width: 630px;    margin: 0 auto;    display: block;">
            <table>
                    <tr>
                        <td>
                        <br>
                            <h3>Hello '.$p_name.'</h3>
                            <p class="lead">A Feedback has been submitted for <b> '.$clinic_details['name'].' </b> by,</p>
                
                            
                           
                        </td>
                    </tr>
                </table>
            </div>          
        </td>
        <td></td>
    </tr>
</table>
<!---content demo End-->
<table class="head-wrap" style="width: 650px;    background: #f5f5fa;    margin: 0 auto; ">
    <tr>
        <td></td>
        <td class="header container">
            
            <!-- content -->
            <div style="max-width: 630px;    margin: 0 auto;    display: block;">
                <table>
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
 <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;   min-width: 180px; font-weight: bold;   text-align: left;  float:left;">User Name :
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;     "><a href="https://www.docconsult.in/?id = '.$id.'">'.$p_name.'</a></span>
</td>
    
  </tr>
   <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;  min-width: 180px;font-weight: bold;   text-align: left;   float:left;">Email:
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;      ">'.$pemail.'</span></td>
    
  </tr>
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;min-width: 180px; font-weight: bold;   text-align: left;  float:left;">Mobile No :

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;    ">'.$pphone.'</span></td>
    
  </tr>
  
  
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;  min-width: 180px;font-weight: bold;   text-align: left;   float:left;">Review : Birth :
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;      ">'.$review.'</span></td>
    
  </tr>
    
          
                    <tr>    
                        <td></td><td></td>
                    </tr>
                </table>
            </div>
            <!-- COLUMN WRAP -->
            
            <div  style="max-width: 630px;     margin: 0 auto;    display: block;">
                <table>
                    <tr>
                        <td>
                          
                            <h4>Thank You For Using Docconsult.</h4>
                            <p class="lead">Regards,</p>
                            <p class="lead">Docconsult Team</p>
                            
                        </td>
                        </tr>
                    
                    
                        <td></td>
                    </tr>
                </table>
            </div>
        </td>
        <td></td>       <!---Footer End--->
    </tr>   
</table>

<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: linear-gradient(to right, #2D9CDB, #2F5894);">
    <tr>
        <td></td>
        <td class="header container">
            
            <div style="max-width: 630px;    margin: 0 auto;    display: block;">
            <table>
                <tr>
                    <td><a href="'.base_url.'"><img src="'.base_url.'/image/logo.png" alt="logo" ></a>
                    <p style="  font-size: 12px;     margin: 2px 10px;  color:#fff;">Contact NO : <strong> 0141-2785199</strong></p>
                    <p style="  font-size: 12px;      margin: 2px 10px;  color:#fff;">Email: <strong><a href="emailto:service@docconsult.in" style="color:#fff;">service@docconsult.in</a></strong></p>
                    <p style="   font-size: 12px;     margin: 2px 10px;  color:#fff;">Copyright © 2017 DocConsult | All Right Reserved 2016</p> </td>
                    
                    <td style="text-align: right;    width: 50%;">
                    <p style="float: right; text-align: right; margin-right: 0px; margin-top: 60px;">
                                                        <a href="https://www.facebook.com/docconsult/"><img src="'.base_url.'image/F.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a> 
                                                        <a href="https://twitter.com/Docconsult12"><img src="'.base_url.'image/T.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a>
                                                        <a href="https://www.youtube.com/channel/UCroHJE8lYtX3Wz9j233Dtwg"><img src="'.base_url.'image/Y.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a>
                                                        <a href="https://www.instagram.com/docconsultservices/"><img src="'.base_url.'image/I.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a> 
                                                        <a href="https://www.linkedin.com/in/docconsult-services-a70a72134/"><img src="'.base_url.'image/L.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a></br>
                                                        </p></td>
                </tr>
            </table>
            </div>
            
        </td>
        <td></td>
    </tr>
</table>';
    
    /*$msg_admin = '<div style="width:100%; height:100%; margin:0;" >

	<div style="width:90%; float:left; height:70px;padding:30px;">

		<span style="width:50%;float:left"> <a href="https://docconsult.in"><img src="https://docconsult.in/image/logo.png"  style="height:70px"/></span></a>

		<span style="width:50%; text-align:right;float:left;font-size: 17px;">  <br /><b> </span>

	</div>
    <div style="width:90%;float:left;margin-top:20px;padding-left:26px;">A Feedback has been submitted for <b> '.$clinic_details['name'].' </b> by, <br></div>
    <div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Name: '.$p_name.'<br></div>
    <div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Mobile-no: '.$pphone.'<br></div>
    <div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Email: '.$pemail.'<br></div>
    <div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Message: '.$review.'<br></div>';
    */


    $msg_doc = '<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: linear-gradient(to right, #2D9CDB, #2F5894);">
    <tr>
        <td></td>
        <td class="header container">
            
            <div style="max-width: 650px;    margin: 0 auto;    display: block;">
        <a href="'.base_url.'"><img src="'.base_url.'/image/logo.png" alt="logo" ></a>
            </div>
            
        </td>
        <td></td>
    </tr>
</table>

<!---content demo -->
<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: #f5f5fa; ">
    <tr>
        <td></td>
        <td class="header container">
            
            <div style="max-width: 630px;    margin: 0 auto;    display: block;">
            <table>
                    <tr>
                        <td>
                        <br>
                            <h3>Hello, '.$doc_details['be_name'].$doc_details['name'].'<br></h3>
                            <p class="lead">A Feedback has been submitted for <b>'.$clinic_details['name'].'</b> by, </p>
                
                            
                            
                        </td>
                    </tr>
                </table>
            </div>          
        </td>
        <td></td>
    </tr>
</table>
<!---content demo End-->
<table class="head-wrap" style="width: 650px;    background: #f5f5fa;    margin: 0 auto; ">
    <tr>
        <td></td>
        <td class="header container">
            
            <!-- content -->
            <div style="max-width: 630px;    margin: 0 auto;    display: block;">
                <table>
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
 <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;   min-width: 180px; font-weight: bold;   text-align: left;  float:left;">User Name :
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;     "><a href="https://www.docconsult.in/?id = '.$id.'">'.$p_name.'</a></span>
</td>
    
  </tr>
   <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;  min-width: 180px;font-weight: bold;   text-align: left;   float:left;">Email:
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;      ">'.$pemail.'</span></td>
    
  </tr>
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;min-width: 180px; font-weight: bold;   text-align: left;  float:left;">Mobile No :

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;    ">'.$pphone.'</span></td>
    
  </tr>
  
  
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;  min-width: 180px;font-weight: bold;   text-align: left;   float:left;">Review : Birth :
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;      ">'.$review.'</span></td>
    
  </tr>
    
         
                    <tr>    
                        <td></td><td></td>
                    </tr>
                </table>
            </div>
            <!-- COLUMN WRAP -->
            
            <div  style="max-width: 630px;     margin: 0 auto;    display: block;">
                <table>
                    <tr>
                        <td>
                          
                            <h4>Thank You For Using Docconsult.</h4>
                            <p class="lead">Regards,</p>
                            <p class="lead">Docconsult Team</p>
                            
                        </td>
                        </tr>
                    
                    
                        <td></td>
                    </tr>
                </table>
            </div>
        </td>
        <td></td>       <!---Footer End--->
    </tr>   
</table>

<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: linear-gradient(to right, #2D9CDB, #2F5894);">
    <tr>
        <td></td>
        <td class="header container">
            
            <div style="max-width: 630px;    margin: 0 auto;    display: block;">
            <table>
                <tr>
                    <td><a href="'.base_url.'"><img src="'.base_url.'/image/logo.png" alt="logo" ></a>
                    <p style="  font-size: 12px;     margin: 2px 10px;  color:#fff;">Contact NO : <strong> 0141-2785199</strong></p>
                    <p style="  font-size: 12px;      margin: 2px 10px;  color:#fff;">Email: <strong><a href="emailto:service@docconsult.in" style="color:#fff;">service@docconsult.in</a></strong></p>
                    <p style="   font-size: 12px;     margin: 2px 10px;  color:#fff;">Copyright © 2017 DocConsult | All Right Reserved 2016</p> </td>
                    
                    <td style="text-align: right;    width: 50%;">
                    <p style="float: right; text-align: right; margin-right: 0px; margin-top: 60px;">
                                                        <a href="https://www.facebook.com/docconsult/"><img src="'.base_url.'image/F.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a> 
                                                        <a href="https://twitter.com/Docconsult12"><img src="'.base_url.'image/T.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a>
                                                        <a href="https://www.youtube.com/channel/UCroHJE8lYtX3Wz9j233Dtwg"><img src="'.base_url.'image/Y.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a>
                                                        <a href="https://www.instagram.com/docconsultservices/"><img src="'.base_url.'image/I.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a> 
                                                        <a href="https://www.linkedin.com/in/docconsult-services-a70a72134/"><img src="'.base_url.'image/L.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a></br>
                                                        </p></td>
                </tr>
            </table>
            </div>
            
        </td>
        <td></td>
    </tr>
</table>';

    /*$msg_doc = '<div style="width:100%; height:100%; margin:0;" >

	<div style="width:90%; float:left; height:70px;padding:30px;">

		<span style="width:50%;float:left"> <a href="https://docconsult.in"><img src="https://docconsult.in/image/logo.png"  style="height:70px"/></span></a>

		<span style="width:50%; text-align:right;float:left;font-size: 17px;">  <br /><b> </span>

	</div>
    <div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Hello, '.$doc_details['be_name'].$doc_details['name'].'<br></div>
    <div style="width:90%;float:left;margin-top:20px;padding-left:26px;">A Feedback has been submitted for <b>'.$clinic_details['name'].'</b> by, <br></div>
    <div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Name: '.$p_name.'<br></div>
    <div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Mobile-no: '.$pphone.'<br></div>
    <div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Email: '.$pemail.'<br></div>
    <div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Message: '.$review.'<br></div>';*/
    
    $this->foremail($doc_details['email'],$msg_doc,'service@docconsult.in','Clinic Feedback-Docconsult');                    
    $this->foremail($pemail,$msg,'service@docconsult.in','Acknowledgement For Clinic feedback- Docconsult');
    $this->foremail('info@docconsult.in',$msg_admin,'service@docconsult.in','Clinic Feedback-Docconsult');   
    
    return TRUE;
}


public function insert_company_feedback_without_login($p_name, $pemail, $pphone,$rate_cmpny,$knowledge, $helpfulness, $punctuality, $staff, $review, $recommendDoctor, $pid){
    
    $date = date('Y-m-d');
    
    $res2 = $this->db->query("select id from patient where phone_no = '$pphone' and password!= '' order by id asc limit 1");
    
    if($res2->num_rows > 0){
        
        $d1 = $res2->fetch_assoc();
        $p_id = $d1['id']; 
        
        $res4 = $this->db->query("insert into company_feedback(name, email, description,rate_company,rate, rate1, rate2, rate3, recommend, date, patient_id, flag)
                values('$p_name', '$pemail', '$review',$rate_cmpny,'$knowledge','$helpfulness','$punctuality', '$staff', '$recommendDoctor',  '$date', '$p_id', '1')");    
    }else{
        
        $pass = sha1($pphone);
    	$d=$this->db->query("insert into patient(name, email, password, phone_no, date) 
    	                        values('$p_name', '$pemail', '$pass', '$pphone', '$date')");
    
    	$query = $this->db->query("select id from patient order by id desc limit 1 ");
    	$res1 = $query->fetch_assoc();
        $table_id = $res1['id'];
    
        $res3 = $this->db->query("select MAX(patient_id) as patient_max_id from patient");    
        $data3 = $res3->fetch_assoc();
        $patient_id = $data3['patient_max_id']+1;
    
        $this->db->query("update patient set patient_id = '$patient_id', parent_id = '$table_id' where id = '$table_id' ");       
        
        $this->db->query("insert into company_feedback(name, email, description,rate_company,rate, rate1, rate2, rate3, recommend, date, patient_id, flag)
        values('$p_name', '$pemail', '$review',$rate_cmpny,'$knowledge','$helpfulness','$punctuality', '$staff', '$recommendDoctor',  '$date', '$table_id', '1')");
    }
    
    // $clinic_details = $this->getById($did,'clinic');
    // $doc_id = json_decode($clinic_details['secondary_doctor'],true);
    // $doc_details = $this->getById($doc_id[0],'doctors');
    
   /* $msg = '<div style="width:100%; height:100%; margin:0;" >

	<div style="width:90%; float:left; height:70px;padding:30px;">

		<span style="width:50%;float:left"> <a href="https://docconsult.in"><img src="https://docconsult.in/image/logo.png"  style="height:70px"/></span></a>

		<span style="width:50%; text-align:right;float:left;font-size: 17px;">  <br /><b> </span>

	</div>

	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Hello '.$p_name.'<br></div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;"><strong>Thank You!</strong> For Submitting Your Feedback for <b> DOCCONSULT</b>.<br></div>';*/
	
	$msg ='<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: linear-gradient(to right, #2D9CDB, #2F5894);">
	<tr>
		<td></td>
		<td class="header container">
			
			<div style="max-width: 650px;    margin: 0 auto;    display: block;">
		<a href="'.base_url.'"><img src="'.base_url.'/image/logo.png" alt="logo" ></a>
			</div>
			
		</td>
		<td></td>
	</tr>
</table>

<!---content demo -->
<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: #f5f5fa; ">
	<tr>
		<td></td>
		<td class="header container">
			
			<div style="max-width: 630px;    margin: 0 auto;    display: block;">
			<table>
					<tr>
						<td>
						<br>
							<h3>Hello '.$p_name.'</h3>
							
						</td>
					</tr>
				</table>
			</div>			
		</td>
		<td></td>
	</tr>
</table>
<!---content demo End-->
<table class="head-wrap" style="width: 650px;    background: #f5f5fa;    margin: 0 auto; ">
	<tr>
		<td></td>
		<td class="header container">
			
			<!-- content -->
			<div style="max-width: 630px;    margin: 0 auto;    display: block;">
				<table>
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
 <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;   min-width: 180px; font-weight: bold;   text-align: left;  float:left;">Full Name :
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;     ">'.$p_name.'</span>
</td>
    
  </tr>
   <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;  min-width: 180px;font-weight: bold;   text-align: left;   float:left;">Email:
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;      ">'.$pemail.'</span></td>
    
  </tr>
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;min-width: 180px; font-weight: bold;   text-align: left;  float:left;">Mobile No :

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;    ">'.$pphone.'</span></td>
    
  </tr>
  
   <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;   min-width: 180px; font-weight: bold;  text-align: left;   float:left;">Message :

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;      text-align: center;     ">'.$review.'</span></td>
    
  </tr>
  
  
  			
				
				</table>
			</div>
			<!-- COLUMN WRAP -->
			
			<div  style="max-width: 630px;     margin: 0 auto;    display: block;">
				<table>
					<tr>
						<td>
						     <h4>Thank You, For Using Docconsult.</h4>
							<p class="lead">A Feedback has been submitted for <b> DOCCONSULT</b><br></p>
						</td>
						</tr>
					</tr>
				</table>
			</div>
		</td>
		<td></td>		<!---Footer End--->
	</tr>	
</table>

<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: linear-gradient(to right, #2D9CDB, #2F5894);">
	<tr>
		<td></td>
		<td class="header container">
			
			<div style="max-width: 630px;    margin: 0 auto;    display: block;">
			<table>
				<tr>
					<td><a href="'.base_url.'"><img src="'.base_url.'/image/logo.png" alt="logo" ></a>
					<p style="  font-size: 12px;     margin: 2px 10px;  color:#fff;">Contact NO : <strong> 0141-2785199</strong></p>
					<p style="  font-size: 12px;      margin: 2px 10px;  color:#fff;">Email: <strong><a href="emailto:service@docconsult.in" style="color:#fff;">service@docconsult.in</a></strong></p>
					<p style="   font-size: 12px;     margin: 2px 10px;  color:#fff;">Copyright © 2017 DocConsult | All Right Reserved 2016</p>	</td>
					
					<td style="text-align: right;    width: 50%;">
					<p style="float: right; text-align: right; margin-right: 0px; margin-top: 60px;">
                                                        <a href="https://www.facebook.com/docconsult/"><img src="'.base_url.'image/F.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a> 
                                                        <a href="https://twitter.com/Docconsult12"><img src="'.base_url.'image/T.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a>
                                                        <a href="https://www.youtube.com/channel/UCroHJE8lYtX3Wz9j233Dtwg"><img src="'.base_url.'image/Y.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a>
                                                        <a href="https://www.instagram.com/docconsultservices/"><img src="'.base_url.'image/I.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a> 
                                                        <a href="https://www.linkedin.com/in/docconsult-services-a70a72134/"><img src="'.base_url.'image/L.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a></br>
                                                        </p></td>
				</tr>
			</table>
			</div>
			
		</td>
		<td></td>
	</tr>
</table>';
	
	
    
   /* $msg_admin = '<div style="width:100%; height:100%; margin:0;" >

	<div style="width:90%; float:left; height:70px;padding:30px;">

		<span style="width:50%;float:left"> <a href="https://docconsult.in"><img src="https://docconsult.in/image/logo.png"  style="height:70px"/></span></a>

		<span style="width:50%; text-align:right;float:left;font-size: 17px;">  <br /><b> </span>

	</div>
    <div style="width:90%;float:left;margin-top:20px;padding-left:26px;">A Feedback has been submitted for <b> DOCCONSULT</b> by, <br></div>
    <div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Name: '.$p_name.'<br></div>
    <div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Mobile-no: '.$pphone.'<br></div>
    <div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Email: '.$pemail.'<br></div>
    <div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Message: '.$review.'<br></div>';*/
    
    $msg_admin ='<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: linear-gradient(to right, #2D9CDB, #2F5894);">
	<tr>
		<td></td>
		<td class="header container">
			
			<div style="max-width: 650px;    margin: 0 auto;    display: block;">
		<a href="'.base_url.'"><img src="'.base_url.'/image/logo.png" alt="logo" ></a>
			</div>
			
		</td> 
		<td></td>
	</tr>
</table>

<!---content demo -->
<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: #f5f5fa; ">
	<tr>
		<td></td>
		<td class="header container">
			
			<div style="max-width: 630px;    margin: 0 auto;    display: block;">
			<table>
					<tr>
						<td>
						<br>
							<h3>Hello, Admin</h3>
							
						</td>
					</tr>
				</table>
			</div>			
		</td>
		<td></td>
	</tr>
</table>
<!---content demo End-->
<table class="head-wrap" style="width: 650px;    background: #f5f5fa;    margin: 0 auto; ">
	<tr>
		<td></td>
		<td class="header container">
			
			<!-- content -->
			<div style="max-width: 630px;    margin: 0 auto;    display: block;">
				<table>
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
 <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;   min-width: 180px; font-weight: bold;   text-align: left;  float:left;">Full Name :
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;     ">'.$InputName.'</span>
</td>
  </tr>
  
   <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;  min-width: 180px;font-weight: bold;   text-align: left;   float:left;">Email:
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;      ">'.$InputEmail.'</span></td>
  </tr>
  
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;min-width: 180px; font-weight: bold;   text-align: left;  float:left;">Mobile No :

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;    ">'.$InputCno.'</span></td>
  </tr>
  
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;min-width: 180px; font-weight: bold;   text-align: left;  float:left;">Interest :

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;    ">'.$InputInt.'</span></td>
  </tr>
  
   <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;   min-width: 180px; font-weight: bold;  text-align: left;   float:left;">Message :
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;      text-align: center;     ">'.$InputMessage.'</span></td>
  </tr>
  
  
  		
					<tr>	
						<td></td><td></td>
					</tr>
				</table>
			</div>
			<!-- COLUMN WRAP -->
			
			<div  style="max-width: 630px; margin: 0 auto; display: block;">
				<table>
					<tr>
						<td>
						     <h4>Thank You, For Using Docconsult.</h4>
							<p class="lead">A Feedback has been submitted for <b> DOCCONSULT</b> <br></p>
						</td>
						</tr>
					</tr>
				</table>
			</div>
		</td>
		<td></td>		<!---Footer End--->
	</tr>	
</table>

<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: linear-gradient(to right, #2D9CDB, #2F5894);">
	<tr>
		<td></td>
		<td class="header container">
			
			<div style="max-width: 630px;    margin: 0 auto;    display: block;">
			<table>
				<tr>
					<td><a href="'.base_url.'"><img src="'.base_url.'/image/logo.png" alt="logo" ></a>
					<p style="  font-size: 12px;     margin: 2px 10px;  color:#fff;">Contact NO : <strong> 0141-2785199</strong></p>
					<p style="  font-size: 12px;      margin: 2px 10px;  color:#fff;">Email: <strong><a href="emailto:service@docconsult.in" style="color:#fff;">service@docconsult.in</a></strong></p>
					<p style="   font-size: 12px;     margin: 2px 10px;  color:#fff;">Copyright © 2017 DocConsult | All Right Reserved 2016</p>	</td>
					
					<td style="text-align: right;    width: 50%;">
					<p style="float: right; text-align: right; margin-right: 0px; margin-top: 60px;">
                                                        <a href="https://www.facebook.com/docconsult/"><img src="'.base_url.'image/F.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a> 
                                                        <a href="https://twitter.com/Docconsult12"><img src="'.base_url.'image/T.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a>
                                                        <a href="https://www.youtube.com/channel/UCroHJE8lYtX3Wz9j233Dtwg"><img src="'.base_url.'image/Y.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a>
                                                        <a href="https://www.instagram.com/docconsultservices/"><img src="'.base_url.'image/I.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a> 
                                                        <a href="https://www.linkedin.com/in/docconsult-services-a70a72134/"><img src="'.base_url.'image/L.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a></br>
                                                        </p></td>
				</tr>
			</table>
			</div>
			
		</td>
		<td></td>
	</tr>
</table>';
    
    
    
             $this->foremail($pemail,$msg,'service@docconsult.in','Acknowledgement For feedback- Docconsult');
             $this->foremail('info@docconsult.in',$msg_admin,'service@docconsult.in','Feedback-Docconsult');   
    
    return TRUE;
}

public function feedback_front_load_more($doc_id,$limit,$offset)
{
    
	//$patient_id=@$_SESSION['patient_login_id'];
	
	//$res=$this->db->query("select * from feedback where patient_id='$patient_id' and doctor_id='' order by date DESC");	
	
    $doc_query =$this->db->query("select name from doctors where id='$doc_id' ");
    $doc_data = $doc_query->fetch_assoc();
        
	$res=$this->db->query("select * from feedback where doctor_id='$doc_id' order by date DESC limit $limit offset $offset");	

	$count=0;
    $num =1;
	$str='';
                                 
	if($res->num_rows> 0)
	{
		while($data=$res->fetch_assoc())
		{   
	    (float)$stars= ($data['rate']+$data['rate1']+$data['rate2']+$data['rate3'])/4; 
		$whole = floor($stars);
		(float) $decimal = $stars-$whole;
		  $date = strtotime($data['date']);
		  
		  $date1 = date('d-m-Y',$date);
		  $res1 = $this->getById($data['patient_id'],'patient');
		  
		  $str.=' <div class="feed_card  shadow">
        					    <h4 class="pull-left"><b>'.$res1['name'].'</b> <small style="font-size:10px">on &nbsp'. $date1.'</small></h4>
        					    <div class="col-sm-6 col-xs-12  star-rating-widget pull-right">
        					            <h4 style="float:right">';
        					 for($i=1;$i<=5;$i++){
        					     
        					     if($whole>=$i){
        					       $str.= ' <i class="fa fa-star stars"></i>';
        					       
        					     }
        					     elseif($i>$whole && $decimal!=0){
        					         $str.= ' <i class="fa fa-star-half-empty stars"></i>';
        					         $decimal=0;
        					     }
        					     
        					     else{
        					        $str.= '<i class="fa fa-star-o stars"></i>';
        					     }
        					 }           
        					                
        					                
        					           
        					                
        					            
        					                
        					   $str.='        </h4>
        					        </div>
        					        
        					         <div class="clearfix"></div>
        					        <div class="row nopadding">
        					            <div class="col-sm-3 col-xs-6 rate-type-widget">
        					                <h6><i class="glyphicon glyphicon-user"></i> <b>'.$data['rate3'].'</b></h6>
        					                <h6>Staff</h6>
        					            </div>
        					            <div class="col-sm-3 col-xs-6 rate-type-widget punctuality">
        					                <h6><i class="glyphicon glyphicon-time"></i> <strong>'.$data['rate2'].'</strong></h6>
        					                <h6>On Time</h6>
        					            </div>
        					            <div class="col-sm-3 col-xs-6 rate-type-widget">
        					                <h6><i class="glyphicon glyphicon-question-sign"></i> <strong>'.$data['rate1'].'</strong></h6>
        					                <h6>Productive</h6>
        					            </div>
        					            <div class="col-sm-3 col-xs-6 rate-type-widget knowledge" >
        					                <h6><i class="fa fa-lightbulb-o"></i> <strong>'.$data['rate'].'</strong></h6>
        					                <h6>Knowledge</h6>
        					            </div>
        					            <div class="col-sm-12" style="padding:0 0 0 12px">
        					            <p style="font-size:12px">'.$data['description'];
        					            if($data['reply']){
        					            
        					            $str.='<div class="col-sm-12 feed_reply">
        					                <span class="reply_heading"><strong><small>Reply by Dr. '.$doc_data['name'].'</small></strong></span>'.$data['reply'].'
        					                
        					                </div>';
        					            }
        					   $str.='         
        					            </p>
        					        </div>
        					        </div>
        					        
        					        
        					    </div>
        				
		
        					       
			
			
                                   ';
			}	
			$num++ ;
			
			}	
	
	
	
	 return $str;
	
}

public function get_signup_speciality($type){
    
    $res = $this->db->query("select distinct speciality from speciality where category='$type' order by speciality asc ");
    $str="";
    while($data=$res->fetch_assoc()){
        $str.="<option value='".$data['speciality']."'>".$data['speciality']."</option>";
    }
    
    return $str;
}

public function get_signup_state($country){
    
    $res = $this->db->query("select state from state_name where country='$country'");
    $str="";
    while($data=$res->fetch_assoc()){
        $str.="<option value='".$data['state']."'>".$data['state']."</option>";
    }
    
    return $str;
}

public function get_signup_city($query){
    
    $res = $this->db->query($query);
   
   while($data=$res->fetch_assoc()){
       $result[]=$data;
   }
        
    
    return $result;
}

public function for_appointment_timing($doc_id,$clinic_id){
    
    
$doc_timing = '';
		
		$practice = $this->getpractice_new($doc_id, $clinic_id);
        $consult = '';
    	foreach($practice as $keys=>$prac)
    	{
    	    $consult = $prac['consult'];
    	   
            $doc_timing1 = $doc_timing2 = $doc_timing3 = $doc_timing4 = $doc_timing5 = $doc_timing6 = $doc_timing7 = $week_name = '';
            $timing_week = $timing_week2 = $timing_week3 = $timing_week4 = $timing_week5 = $timing_week6 = $timing_week7= '';
            
            
            if($prac['check1'] != ''){
                $day_name = explode(',',$prac['check1']);
                $k= 0;
                foreach($day_name as $days){
                   
                    $week_name = explode(',',$prac['check1']);
                    if($k == 0){
                        foreach($week_name as $week_d){
                            $timing_week .= substr($week_d,0,3).', ';
                        }
                    }
                    $timing_week = trim($timing_week, ", ");
                    $doc_timing1 = $timing_week;
                    $doc_timing1 .= "<br>".$prac[$days];
                    if($prac[$days.'1'] != ''){
                        $doc_timing1 .= ' <b>| </b>'.$prac[$days.'1'];
                    }    
                
                    $k++;
                }
            }
            if($prac['check2'] != ''){
                $day_name = explode(',',$prac['check2']);
                $k= 0;
               
                foreach($day_name as $days){
                    
                    $week_name = explode(',',$prac['check2']);
                    if($k == 0){
                        foreach($week_name as $week_d){
                            $timing_week2 .= substr($week_d,0,3).', ';
                        }
                    }
                    $timing_week2 = trim($timing_week2, ", ");
                    $doc_timing2 = "<br>".$timing_week2;
                    $doc_timing2 .= "<br>".$prac[$days];
                    if($prac[$days.'1'] != ''){
                        $doc_timing2 .= ' <b>| </b>'.$prac[$days.'1'];
                    }
                
                    $k++;
                }
            }
            if($prac['check3'] != ''){
                $day_name = explode(',',$prac['check3']);
                $k= 0;
                foreach($day_name as $days){
                    
                    $week_name = explode(',',$prac['check3']);
                    if($k == 0){
                        foreach($week_name as $week_d){
                            $timing_week3 .= substr($week_d,0,3).', ';
                        }
                    }
                    $timing_week3 = trim($timing_week3, ", ");
                    $doc_timing3 = "<br>".$timing_week3;
                    $doc_timing3 .= "<br>".$prac[$days];
                    if($prac[$days.'1'] != ''){
                        $doc_timing3 .= ' <b>| </b>'.$prac[$days.'1'];
                    }    
                
                    $k++;
                }
            }
            if($prac['check4'] != ''){
                $day_name = explode(',',$prac['check4']);
                $k= 0;
                foreach($day_name as $days){
                    
                    $week_name = explode(',',$prac['check4']);
                    if($k == 0){
                        foreach($week_name as $week_d){
                            $timing_week4 .= substr($week_d,0,3).', ';
                        }
                    }
                    $timing_week4 = trim($timing_week4, ", ");
                    $doc_timing4 = "<br>".$timing_week4;
                    $doc_timing4 .= "<br>".$prac[$days];
                    if($prac[$days.'1'] != ''){
                        $doc_timing4 .= ' <b>| </b>'.$prac[$days.'1'];
                    }
                
                    $k++;
                }
            }
            if($prac['check5'] != ''){
                $day_name = explode(',',$prac['check5']);
                $k= 0;
                foreach($day_name as $days){
                    
                    $week_name = explode(',',$prac['check5']);
                    if($k == 0){
                        foreach($week_name as $week_d){
                            $timing_week5 .= substr($week_d,0,3).', ';
                        }
                    }
                    $timing_week5 = trim($timing_week5, ", ");
                    $doc_timing5 = "<br>".$timing_week5;
                    $doc_timing5 .= "<br>".$prac[$days];
                    if($prac[$days.'1'] != ''){
                        $doc_timing5 .= ' <b>| </b>'.$prac[$days.'1'];
                    }
                
                    $k++;
                }
            }
            if($prac['check6'] != ''){
                $day_name = explode(',',$prac['check6']);
                $k= 0;
                foreach($day_name as $days){
                    
                    $week_name = explode(',',$prac['check6']);
                    if($k == 0){
                        foreach($week_name as $week_d){
                            $timing_week6 .= substr($week_d,0,3).', ';
                        }
                    }
                    $timing_week6 = trim($timing_week6, ", ");
                    $doc_timing6 = "<br>".$timing_week6;
                    $doc_timing6 .= "<br>".$prac[$days];
                    if($prac[$days.'1'] != ''){
                        $doc_timing6 .= ' <b>| </b>'.$prac[$days.'1'];
                    }
                
                    $k++;
                }
            }
            if($prac['check7'] != ''){
                $day_name = explode(',',$prac['check7']);
                $k= 0;
                foreach($day_name as $days){
                    
                    $week_name = explode(',',$prac['check7']);
                    if($k == 0){
                        foreach($week_name as $week_d){
                            $timing_week7 .= substr($week_d,0,3).', ';
                        }
                    }
                    $timing_week7 = trim($timing_week7, ", ");
                    $doc_timing7 = "<br>".$timing_week7;
                    $doc_timing7 .= "<br>".$prac[$days];
                    if($prac[$days.'1'] != ''){
                        $doc_timing7 .= ' <b>| </b>'.$prac[$days.'1'];
                    }
                
                    $k++;
                }
            }
    	}
    	
    $doc_tim = '<span style="font-size: 12px;"> Doctor Timing</span> <br>
                            <span class="glyphicon glyphicon-time" style="font-size: 12px;"></span> <span class="profile_card_education">
                            '.$doc_timing1.$doc_timing2.$doc_timing3.$doc_timing4.$doc_timing5.$doc_timing6.$doc_timing7.' 
                            
                            </span>';	
  return $doc_tim;  
    
}

public function show_sec_doctor_in_clinic_by_clinic_id($clinic_id)
{
    //echo $clinic_id;
    $res = $this->db->query("select * from clinic where id='$clinic_id'");
    $data = $res->fetch_assoc();
    $sec_doctor = json_decode($data['secondary_doctor'],TRUE);
    $doc_cnt = count($sec_doctor);
    $str = '';
    $ky = 1;
    
    $str .= '<input type="hidden" id="doc_cnt" value="3">
             <input type="hidden" id="ldoc_cnt" value="3">
              <div class="row">   
             <div class="col-sm-12 class_height"  id="clinic-see-more">
             <div class="row" style="" id="doctor_data">';
    foreach($sec_doctor as $doc_id)
    {
       if($ky < 4){
        // echo $doc_id;
        $doctor = $this->getById($doc_id,"doctors");
        $doc_name = $doctor['be_name'].' '.$doctor['name'];
        $doc_name1 = str_replace(" ",'-',$doctor['type'].' '.$doctor['name']);
        $doc_name1 = preg_replace("![^a-z0-9]+!i", "-", $doc_name1);
        $doc_phone = $doctor['phone_no'];
        $doc_image = $doctor['image'];
        $location_d = trim($doctor['location']);
        $location_d = preg_replace("![^a-z0-9]+!i", "-", $location_d);
        $city_d = trim($doctor['city']);
        $city_d = preg_replace("![^a-z0-9]+!i", "-", $city_d);
        
        $sp=json_decode($doctor['specialization'],true);
        $spe1 = '';
//         foreach($sp as $key=>$sp1)
// 		{
// 			if($key==0){
// 			    $spe1 = $sp1['specialization'];
// 			}	
		
// 		}
		
		foreach($sp as $key=>$sp1)
		{
			if($key==0){
				$doc_specliaztion = $sp1['specialization'];
				if(is_numeric($doc_specliaztion)){
	    			$doc_specliaztion_l = $this->get_data_by_id($doc_specliaztion, $table = 'speciality', $field = 'specialization');
	    		  	$doc_specliaztion = $doc_specliaztion_l[0];
				}else{
				   $doc_specliaztion = $doc_specliaztion;
				}	
			}	
		}
		
		$doc_specliaztion = preg_replace("![^a-z0-9]+!i", "-", $doc_specliaztion);
		
		$edu = json_decode($doctor['education'],true);
		$i = $d = 1;
		$cnt = count($edu);
		$doc_edu = '';
// 		foreach($edu as $key=>$educat)
// 		{
// 			$doc_edu .= $educat['qualification'];
// 			if($i != $cnt){
// 				$doc_edu .= ", ";
// 			}else{$doc_edu.= " ";}
// 			$i++;
// 		}

        foreach($edu as $edu_doc) {
    		$doc_degree_list = $doc_degree_list_new = $doc_degree_result = $doc_degz = '';

    		if(is_numeric($edu_doc['qualification'])){
    			$doc_degree_list = $edu_doc['qualification'];
    		}else{
    			$doc_degree_list_new = $edu_doc['qualification'];
    		}
    		
    		// Display Degree Name
    		if($doc_degree_list != ''){
    			$doc_degree_result = $this->get_data_by_id($doc_degree_list, $table = 'degree', $field = 'degree');
    		}
    		
    		foreach($doc_degree_result as $doc_degz) {
    			$doc_edu.= $doc_degz; 
    		}
    		
    		if($doc_degree_list_new){
    			$doc_edu.= "".$doc_degree_list_new."";
    		}
			if($d < 3)
			{
				if($i != $cnt){
					$doc_edu.= ", ";
				}
			}else{
				$doc_edu.= " ";
			}	
			$i++;
			
			if($d > 2){break;}
			$d++;
    	}




		
		$doc_timing = '';
		
		$practice = $this->getpractice_new($doctor['id'], $clinic_id);
        $consult = '';
    	foreach($practice as $keys=>$prac)
    	{
    	    $consult = $prac['consult'];
    	   
            $doc_timing1 = $doc_timing2 = $doc_timing3 = $doc_timing4 = $doc_timing5 = $doc_timing6 = $doc_timing7 = $week_name = '';
            $timing_week = $timing_week2 = $timing_week3 = $timing_week4 = $timing_week5 = $timing_week6 = $timing_week7= '';
            
            
            if($prac['check1'] != ''){
                $day_name = explode(',',$prac['check1']);
                $k= 0;
                foreach($day_name as $days){
                   
                    $week_name = explode(',',$prac['check1']);
                    if($k == 0){
                        foreach($week_name as $week_d){
                            $timing_week .= substr($week_d,0,3).', ';
                        }
                    }
                    $timing_week = trim($timing_week, ", ");
                    $doc_timing1 = $timing_week;
                    $doc_timing1 .= "<br>".$prac[$days];
                    if($prac[$days.'1'] != ''){
                        $doc_timing1 .= ' <b>| </b>'.$prac[$days.'1'];
                    }    
                
                    $k++;
                }
            }
            if($prac['check2'] != ''){
                $day_name = explode(',',$prac['check2']);
                $k= 0;
               
                foreach($day_name as $days){
                    
                    $week_name = explode(',',$prac['check2']);
                    if($k == 0){
                        foreach($week_name as $week_d){
                            $timing_week2 .= substr($week_d,0,3).', ';
                        }
                    }
                    $timing_week2 = trim($timing_week2, ", ");
                    $doc_timing2 = "<br>".$timing_week2;
                    $doc_timing2 .= "<br>".$prac[$days];
                    if($prac[$days.'1'] != ''){
                        $doc_timing2 .= ' <b>| </b>'.$prac[$days.'1'];
                    }
                
                    $k++;
                }
            }
            if($prac['check3'] != ''){
                $day_name = explode(',',$prac['check3']);
                $k= 0;
                foreach($day_name as $days){
                    
                    $week_name = explode(',',$prac['check3']);
                    if($k == 0){
                        foreach($week_name as $week_d){
                            $timing_week3 .= substr($week_d,0,3).', ';
                        }
                    }
                    $timing_week3 = trim($timing_week3, ", ");
                    $doc_timing3 = "<br>".$timing_week3;
                    $doc_timing3 .= "<br>".$prac[$days];
                    if($prac[$days.'1'] != ''){
                        $doc_timing3 .= ' <b>| </b>'.$prac[$days.'1'];
                    }    
                
                    $k++;
                }
            }
            if($prac['check4'] != ''){
                $day_name = explode(',',$prac['check4']);
                $k= 0;
                foreach($day_name as $days){
                    
                    $week_name = explode(',',$prac['check4']);
                    if($k == 0){
                        foreach($week_name as $week_d){
                            $timing_week4 .= substr($week_d,0,3).', ';
                        }
                    }
                    $timing_week4 = trim($timing_week4, ", ");
                    $doc_timing4 = "<br>".$timing_week4;
                    $doc_timing4 .= "<br>".$prac[$days];
                    if($prac[$days.'1'] != ''){
                        $doc_timing4 .= ' <b>| </b>'.$prac[$days.'1'];
                    }
                
                    $k++;
                }
            }
            if($prac['check5'] != ''){
                $day_name = explode(',',$prac['check5']);
                $k= 0;
                foreach($day_name as $days){
                    
                    $week_name = explode(',',$prac['check5']);
                    if($k == 0){
                        foreach($week_name as $week_d){
                            $timing_week5 .= substr($week_d,0,3).', ';
                        }
                    }
                    $timing_week5 = trim($timing_week5, ", ");
                    $doc_timing5 = "<br>".$timing_week5;
                    $doc_timing5 .= "<br>".$prac[$days];
                    if($prac[$days.'1'] != ''){
                        $doc_timing5 .= ' <b>| </b>'.$prac[$days.'1'];
                    }
                
                    $k++;
                }
            }
            if($prac['check6'] != ''){
                $day_name = explode(',',$prac['check6']);
                $k= 0;
                foreach($day_name as $days){
                    
                    $week_name = explode(',',$prac['check6']);
                    if($k == 0){
                        foreach($week_name as $week_d){
                            $timing_week6 .= substr($week_d,0,3).', ';
                        }
                    }
                    $timing_week6 = trim($timing_week6, ", ");
                    $doc_timing6 = "<br>".$timing_week6;
                    $doc_timing6 .= "<br>".$prac[$days];
                    if($prac[$days.'1'] != ''){
                        $doc_timing6 .= ' <b>| </b>'.$prac[$days.'1'];
                    }
                
                    $k++;
                }
            }
            if($prac['check7'] != ''){
                $day_name = explode(',',$prac['check7']);
                $k= 0;
                foreach($day_name as $days){
                    
                    $week_name = explode(',',$prac['check7']);
                    if($k == 0){
                        foreach($week_name as $week_d){
                            $timing_week7 .= substr($week_d,0,3).', ';
                        }
                    }
                    $timing_week7 = trim($timing_week7, ", ");
                    $doc_timing7 = "<br>".$timing_week7;
                    $doc_timing7 .= "<br>".$prac[$days];
                    if($prac[$days.'1'] != ''){
                        $doc_timing7 .= ' <b>| </b>'.$prac[$days.'1'];
                    }
                
                    $k++;
                }
            }
    	}
    	if(!empty($doc_timing1)){
    	    $doc_tim = '<span style="font-size: 12px;"> Doctor Timing</span> <br>
                            <span class="glyphicon glyphicon-time" style="font-size: 12px;"></span> <span class="profile_card_education">
                            '.$doc_timing1.$doc_timing2.$doc_timing3.$doc_timing4.$doc_timing5.$doc_timing6.$doc_timing7.' 
                            
                            </span>';
    	    
    	}else{$doc_tim = '';}
        $str .= '<div class="col-sm-12 clinic_cards " >
                    <div class="row">
                        <div class="col-sm-2 clinic_doc_img">
                            <img class="doctor_clinic_card_image" src="'.base_url_image.'dp/'.$doctor['image'].'">
                        </div>  
                     
                        <div class="col-sm-5">
                          <p class="profile_card_name"><a target="blank" href="'.base_url.$city_d.'/'.$location_d.'/'.$doc_specliaztion.'/'.$doc_name1.'/'.$doc_id.'/">'.$doc_name.' </a><br>
                              <small style="">'.$doc_specliaztion.'</small> <br>
                              <span class="profile_card_education">'.$doc_edu.' </span><br>
                              <span class="profile_card_name">'.$data['name'].'</span><br>
                          </p>';
                    if($consult > 0){     
                        $str .= '<span class="profile_card_education">Consultancy Fees :- Rs. '.$consult.'/- </span><br>';
                    }
                    $str .= '    </div>
                        <div class="col-sm-5" style="text-transform:capitalize">'.$doc_tim.'</div>
                        
                    </div>
                    <div class="row ">
                       <div class="col-sm-5 col-sm-offset-1">
                            <div class="clinic-name" style="color:#666;"><p style="font-size:1.5em">
                            
                                
                                
                            </div>
                        </div>
                    <div class="col-sm-5 col-sm-offset-1" align="center">';
                    if($data['allow'] == 1 && $doctor['status']!='Suspended'){
                        if($prac['allow'] == 1 && $doctor['status']!='Suspended'){
                            $str .= '<div><center>  <a href="'.base_url.'appointment_fill_data.php?cid='.$_GET['cid'].'&did='.$doc_id.'"  class=" btn btn-primary book-appointment-button-profilepage clinic_call_now" >Book An Appointment</a>  </div>';
                        }elseif($prac['allow'] == 2 && $doctor['status']!='Suspended'){
                           $str .= '<div><a href="'.base_url.'bookappointment.php?cid='.$_GET['cid'].'&did='.$doc_id.'&date='.date('Y-m-d').'&time='.date('h:i:A').'&request_for_call=true"  class=" btn btn-primary book-appointment-button-profilepage clinic_call_now" >Request for Call</a>  </div>'; 
                        }
                    }
                    elseif($data['allow'] == 2 && $doctor['status']!='Suspended'){
                        $str .= '<div><a href="'.base_url.'bookappointment.php?cid='.$_GET['cid'].'&did='.$doc_id.'&date='.date('Y-m-d').'&time='.date('h:i:A').'&request_for_call=true"  class=" btn btn-primary book-appointment-button-profilepage clinic_call_now" >Request for Call</a></center></div>';
                    }
                    elseif($data['allow'] == 3 && $doctor['status']!='Suspended'){
                        $str .= '<div><center><button class="clinic_call_now" >On Call Available</button></center></div>';
                    }

                    $str .= '    </div>
                    </div>
                </div>';
                
       }    
       $ky++;        
    }
    $str .= '</div>
             </div>
             </div>';
    if($doc_cnt > 3){
        $str .= '<div class="clearfix"></div><div id="loadDocrors" class="clinic_view_more">View More</div>';
    }
    return $str;
}

public function load_clinic_doctor_data($clinic_id , $limit, $offset)
{
    //echo $clinic_id;
    $sql = "select * from clinic where id='$clinic_id'";
    $res = $this->db->query($sql);
    $data = $res->fetch_assoc();
    $sec_doctor = json_decode($data['secondary_doctor'],TRUE);
   
    for($k=0; $k<$offset; $k++){unset($sec_doctor[$k]);}
    $doc_count = count($sec_doctor);
    $str = '';
    $k = 1;
        
    foreach($sec_doctor as $doc_id)
    {
        if($k <= $limit)
        {
            $doctor = $this->getById($doc_id,"doctors");
            $doc_name = $doctor['name'];
            $doc_phone = $doctor['phone_no'];
            $doc_image = $doctor['image'];
            
            $sp=json_decode($doctor['specialization'],true);
            $spe1 = '';
            foreach($sp as $key=>$sp1)
    		{
    			if($key==0){$spe1 = $sp1['specialization'];}	
    		}
    		
    		$edu = json_decode($doctor['education'],true);
    		$i = 1;
    		$cnt = count($edu);
    		$doc_edu = '';
    		foreach($edu as $key=>$educat)
    		{
    			$doc_edu .= $educat['qualification'];
    			if($i != $cnt){
    				$doc_edu .= ", ";
    			}else{$doc_edu.= " ";}
    			$i++;
    		}
    		
    		$doc_timing = '';
		
    		$practice=$this->getpractice_new($doctor['id'], $clinic_id);
            $consult = '';
        	foreach($practice as $keys=>$prac)
        	{
        	    $consult = $prac['consult'];
        	   
                $doc_timing1 = $doc_timing2 = $doc_timing3 = $doc_timing4 = $doc_timing5 = $doc_timing6 = $doc_timing7 = $week_name = '';
                $timing_week = $timing_week2 = $timing_week3 = $timing_week4 = $timing_week5 = $timing_week6 = $timing_week7= '';
                
                
                if($prac['check1'] != ''){
                    $day_name = explode(',',$prac['check1']);
                    $k= 0;
                    foreach($day_name as $days){
                       
                        $week_name = explode(',',$prac['check1']);
                        if($k == 0){
                            foreach($week_name as $week_d){
                                $timing_week .= substr($week_d,0,3).', ';
                            }
                        }
                        $timing_week = trim($timing_week, ", ");
                        $doc_timing1 = $timing_week;
                        $doc_timing1 .= "<br>".$prac[$days];
                        if($prac[$days.'1'] != ''){
                            $doc_timing1 .= ' <b>| </b>'.$prac[$days.'1'];
                        }    
                    
                        $k++;
                    }
                }
                if($prac['check2'] != ''){
                    $day_name = explode(',',$prac['check2']);
                    $k= 0;
                   
                    foreach($day_name as $days){
                        
                        $week_name = explode(',',$prac['check2']);
                        if($k == 0){
                            foreach($week_name as $week_d){
                                $timing_week2 .= substr($week_d,0,3).', ';
                            }
                        }
                        $timing_week2 = trim($timing_week2, ", ");
                        $doc_timing2 = "<br>".$timing_week2;
                        $doc_timing2 .= "<br>".$prac[$days];
                        if($prac[$days.'1'] != ''){
                            $doc_timing2 .= ' <b>| </b>'.$prac[$days.'1'];
                        }
                    
                        $k++;
                    }
                }
                if($prac['check3'] != ''){
                    $day_name = explode(',',$prac['check3']);
                    $k= 0;
                    foreach($day_name as $days){
                        
                        $week_name = explode(',',$prac['check3']);
                        if($k == 0){
                            foreach($week_name as $week_d){
                                $timing_week3 .= substr($week_d,0,3).', ';
                            }
                        }
                        $timing_week3 = trim($timing_week3, ", ");
                        $doc_timing3 = "<br>".$timing_week3;
                        $doc_timing3 .= "<br>".$prac[$days];
                        if($prac[$days.'1'] != ''){
                            $doc_timing3 .= ' <b>| </b>'.$prac[$days.'1'];
                        }    
                    
                        $k++;
                    }
                }
                if($prac['check4'] != ''){
                    $day_name = explode(',',$prac['check4']);
                    $k= 0;
                    foreach($day_name as $days){
                        
                        $week_name = explode(',',$prac['check4']);
                        if($k == 0){
                            foreach($week_name as $week_d){
                                $timing_week4 .= substr($week_d,0,3).', ';
                            }
                        }
                        $timing_week4 = trim($timing_week4, ", ");
                        $doc_timing4 = "<br>".$timing_week4;
                        $doc_timing4 .= "<br>".$prac[$days];
                        if($prac[$days.'1'] != ''){
                            $doc_timing4 .= ' <b>| </b>'.$prac[$days.'1'];
                        }
                    
                        $k++;
                    }
                }
                if($prac['check5'] != ''){
                    $day_name = explode(',',$prac['check5']);
                    $k= 0;
                    foreach($day_name as $days){
                        
                        $week_name = explode(',',$prac['check5']);
                        if($k == 0){
                            foreach($week_name as $week_d){
                                $timing_week5 .= substr($week_d,0,3).', ';
                            }
                        }
                        $timing_week5 = trim($timing_week5, ", ");
                        $doc_timing5 = "<br>".$timing_week5;
                        $doc_timing5 .= "<br>".$prac[$days];
                        if($prac[$days.'1'] != ''){
                            $doc_timing5 .= ' <b>| </b>'.$prac[$days.'1'];
                        }
                    
                        $k++;
                    }
                }
                if($prac['check6'] != ''){
                    $day_name = explode(',',$prac['check6']);
                    $k= 0;
                    foreach($day_name as $days){
                        
                        $week_name = explode(',',$prac['check6']);
                        if($k == 0){
                            foreach($week_name as $week_d){
                                $timing_week6 .= substr($week_d,0,3).', ';
                            }
                        }
                        $timing_week6 = trim($timing_week6, ", ");
                        $doc_timing6 = "<br>".$timing_week6;
                        $doc_timing6 .= "<br>".$prac[$days];
                        if($prac[$days.'1'] != ''){
                            $doc_timing6 .= ' <b>| </b>'.$prac[$days.'1'];
                        }
                    
                        $k++;
                    }
                }
                if($prac['check7'] != ''){
                    $day_name = explode(',',$prac['check7']);
                    $k= 0;
                    foreach($day_name as $days){
                        
                        $week_name = explode(',',$prac['check7']);
                        if($k == 0){
                            foreach($week_name as $week_d){
                                $timing_week7 .= substr($week_d,0,3).', ';
                            }
                        }
                        $timing_week7 = trim($timing_week7, ", ");
                        $doc_timing7 = "<br>".$timing_week7;
                        $doc_timing7 .= "<br>".$prac[$days];
                        if($prac[$days.'1'] != ''){
                            $doc_timing7 .= ' <b>| </b>'.$prac[$days.'1'];
                        }
                    
                        $k++;
                    }
                }
        	}
        	if(!empty($doc_timing1)){
        	    $doc_tim = '<span style="font-size: 12px;"> Doctor Timing</span> <br>
                                <span class="glyphicon glyphicon-time" style="font-size: 12px;"></span> <span class="profile_card_education">
                                '.$doc_timing1.$doc_timing2.$doc_timing3.$doc_timing4.$doc_timing5.$doc_timing6.$doc_timing7.' 
                                
                                </span>';
        	    
        	}else{$doc_tim = '';}
            
            $str .= '<div class="col-sm-10 col-sm-offset-1 clinic_cards " >
                        <div class="row">
                            <div class="col-sm-2">
                                <img class="doctor_clinic_card_image" src="doc_panel/image/'.$doctor['image'].'">
                            </div>  
                         
                            <div class="col-sm-6">
                              <p class="profile_card_name"><a target="blank" href="doc_profile.php?id='.$doc_id.'">Dr. '.$doc_name.' </a><br>
                                  <small style="">'.$spe1.'</small> <br>
                                  <span class="profile_card_education">'.$doc_edu.' </span><br>
                                  <span class="profile_card_name">'.$data['name'].'</span><br>
                              </p>
                            
                              <span class="profile_card_education">Consultancy Fees :- Rs. '.$consult.'/- </span><br>
        
                            </div>
                            <div class="col-sm-4">'.$doc_tim.'</div>
                            
                        </div>
                        <div class="row ">
                           <div class="col-sm-5 col-sm-offset-1">
                                <div class="clinic-name" style="color:#666;"><p style="font-size:1.5em">
                                </div>
                            </div>
                                <div class="col-sm-5 col-sm-offset-1" align="right">
                                 <center>   <div><button class="clinic_call_now" >Book An Appointment</button></div></center>  
                                </div>
                        </div>
                    </div>';
        }
         $k++;
    }
  
    if($limit>$doc_count){?>
        <script>$("#loadDocrors").hide();</script>
    <?php
        
    }
    return $str;
}
public function check_user_first_feedback($phone,$did){
    
    $sql = "select t1.patient_id from feedback as t1 inner join patient as t2 on t1.patient_id = t2.id where t2.phone_no = '$phone' and t1.doctor_id=$did and t1.flag = '1' ";
    $query = $this->db->query($sql);
    $num = $query->num_rows;

    return $num;
}

public function check_user_first_clinic_feedback($phone,$did){
    
    $sql = "select t1.patient_id from clinic_feedback as t1 inner join patient as t2 on  t1.patient_id = t2.id where t2.phone_no = '$phone' and t1.clinic_id=$did and t1.flag = '1' ";
    $query = $this->db->query($sql);
    $num = $query->num_rows;

    return $num;
}

public function check_user_first_company_feedback($phone){
    
    $sql = "select t1.patient_id from company_feedback as t1 inner join patient as t2 on t1.patient_id = t2.id where t2.phone_no = '$phone' and t1.flag = '1' ";
    
    $query = $this->db->query($sql);
    $num = $query->num_rows;

    return $num;
}


public function get_tag(){
    
    $str="";
    $res = $this->db->query("select prefix from Doctor_prefix");
    while($data = $res->fetch_assoc() ){
        
        $str.="<option value=".$data['prefix']." >".$data['prefix']."</option>";
    }
    
    return $str;
    
}

public function foremail($email,$msg,$fromAdd,$subjct)
{
	require_once("phpmailer/PHPMailerAutoload.php");
	$mail = new PHPMailer();
	$mailhost = "docconsult.in";
	$smtpUser = "mail@docconsult.in";
	$smtpPassword = "telekast@123";
	
	$name = "Docconsult";
	$subject = $subjct;
	$from = $fromAdd;
	$mail->IsSMTP();
	$mail->Host = $mailhost;
	$mail->SMTPAuth = true;
	$mail->Username = $smtpUser;
	$mail->Password = $smtpPassword;
	//$mail->SMTPSecure = "ssl";  //ssl or tls
	$mail->Port = 25; // 25 or 465 or 587
	$mail->From = $from;
	$mail->FromName = $name;
	$mail->AddReplyTo($from);
	$mail->AddAddress($email);
	$mail->IsHTML(true);
	$mail->Subject = $subject;
	$mail->Body = $msg;
	$mail->Send();
	return true;		
}

function get_data_by_id($value, $table, $field)
{
    $sql = "select $field from $table where id in($value)";
    $query = $this->db->query($sql);
    while($row = $query->fetch_assoc()){
        $result[] = $row[$field];
    }
    return $result;
}

function contact_us($InputName,$InputEmail,$InputCno,$InputInt,$InputMessage) {
     $date = date("Y-m-d");
    $res = $this->db->query("insert into contact (name,email,phone,interest,msg,date) values('$InputName','$InputEmail','$InputCno','$InputInt','$InputMessage','$date')");
    /*$msg = '<div style="width:100%; height:100%; margin:0;" >

	<div style="width:90%; float:left; height:70px;padding:30px;">

		<span style="width:50%;float:left"> <a href="https://docconsult.in"><img src="https://docconsult.in/image/logo.png"  style="height:70px"/></span></a>

		<span style="width:50%; text-align:right;float:left;font-size: 17px;">  <br /><b> </span>

	</div>

	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Hello '.$InputName.'<br></div>
	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;"><strong>Thank You!</strong> For Getting In touch With Us. We Will Contact You Soon.<br></div>';
    */
    
    $msg ='<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: linear-gradient(to right, #2D9CDB, #2F5894);">
	<tr>
		<td></td>
		<td class="header container">
			
			<div style="max-width: 650px;    margin: 0 auto;    display: block;">
		<a href="'.base_url.'"><img src="'.base_url.'/image/logo.png" alt="logo" ></a>
			</div>
			
		</td>
		<td></td>
	</tr>
</table>

<!---content demo -->
<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: #f5f5fa; ">
	<tr>
		<td></td>
		<td class="header container">
			
			<div style="max-width: 630px;    margin: 0 auto;    display: block;">
			<table>
					<tr>
						<td>
						<br>
							<h3>Hello '.$InputName.'</h3>
							
						</td>
					</tr>
				</table>
			</div>			
		</td>
		<td></td>
	</tr>
</table>
<!---content demo End-->
<table class="head-wrap" style="width: 650px;    background: #f5f5fa;    margin: 0 auto; ">
	<tr>
		<td></td>
		<td class="header container">
			
			<!-- content -->
			<div style="max-width: 630px;    margin: 0 auto;    display: block;">
				<table>
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
 <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;   min-width: 180px; font-weight: bold;   text-align: left;  float:left;">Full Name :
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;     ">'.$InputName.'</span>
</td>
    
  </tr>
   <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;  min-width: 180px;font-weight: bold;   text-align: left;   float:left;">Email:
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;      ">'.$InputEmail.'</span></td>
    
  </tr>
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;min-width: 180px; font-weight: bold;   text-align: left;  float:left;">Mobile No :

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;    ">'.$InputCno.'</span></td>
    
  </tr>
  
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;min-width: 180px; font-weight: bold;   text-align: left;  float:left;">Interest :

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;    ">'.$InputInt.'</span></td>
    
  </tr>
  
   <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;   min-width: 180px; font-weight: bold;  text-align: left;   float:left;">Message :

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;      text-align: center;     ">'.$InputMessage.'</span></td>
    
  </tr>
  
  
  				
					<tr>	
						<td></td><td></td>
					</tr>
				</table>
			</div>
			<!-- COLUMN WRAP -->
			
			<div  style="max-width: 630px;     margin: 0 auto;    display: block;">
				<table>
					<tr>
						<td>
						     <h4>Thank You, For Using Docconsult.</h4>
							<p class="lead">Getting In touch With Us. We Will Contact You As Soon As Possible.<br></p>
						</td>
						</tr>
					</tr>
				</table>
			</div>
		</td>
		<td></td>		<!---Footer End--->
	</tr>	
</table>

<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: linear-gradient(to right, #2D9CDB, #2F5894);">
	<tr>
		<td></td>
		<td class="header container">
			
			<div style="max-width: 630px;    margin: 0 auto;    display: block;">
			<table>
				<tr>
					<td><a href="'.base_url.'"><img src="'.base_url.'/image/logo.png" alt="logo" ></a>
					<p style="  font-size: 12px;     margin: 2px 10px;  color:#fff;">Contact NO : <strong> 0141-2785199</strong></p>
					<p style="  font-size: 12px;      margin: 2px 10px;  color:#fff;">Email: <strong><a href="emailto:service@docconsult.in" style="color:#fff;">service@docconsult.in</a></strong></p>
					<p style="   font-size: 12px;     margin: 2px 10px;  color:#fff;">Copyright © 2017 DocConsult | All Right Reserved 2016</p>	</td>
					
					<td style="text-align: right;    width: 50%;">
					<p style="float: right; text-align: right; margin-right: 0px; margin-top: 60px;">
                                                        <a href="https://www.facebook.com/docconsult/"><img src="'.base_url.'image/F.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a> 
                                                        <a href="https://twitter.com/Docconsult12"><img src="'.base_url.'image/T.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a>
                                                        <a href="https://www.youtube.com/channel/UCroHJE8lYtX3Wz9j233Dtwg"><img src="'.base_url.'image/Y.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a>
                                                        <a href="https://www.instagram.com/docconsultservices/"><img src="'.base_url.'image/I.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a> 
                                                        <a href="https://www.linkedin.com/in/docconsult-services-a70a72134/"><img src="'.base_url.'image/L.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a></br>
                                                        </p></td>
				</tr>
			</table>
			</div>
			
		</td>
		<td></td>
	</tr>
</table>';
    
    
   /* $msg_admin = '<div style="width:100%; height:100%; margin:0;" >

	<div style="width:90%; float:left; height:70px;padding:30px;">

		<span style="width:50%;float:left"> <a href="https://docconsult.in"><img src="https://docconsult.in/image/logo.png"  style="height:70px"/></span></a>

		<span style="width:50%; text-align:right;float:left;font-size: 17px;">  <br /><b> </span>

	</div>

	<div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Name '.$InputName.'<br></div>
    <div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Mobile-no '.$InputCno.'<br></div>
    <div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Email '.$InputEmail.'<br></div>
    <div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Interest '.$InputInt.'<br></div>
    <div style="width:90%;float:left;margin-top:20px;padding-left:26px;">Message '.$InputMessage.'<br></div>';*/
    
    
    
    
    $msg_admin = '<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: linear-gradient(to right, #2D9CDB, #2F5894);">
	<tr>
		<td></td>
		<td class="header container">
			
			<div style="max-width: 650px;    margin: 0 auto;    display: block;">
		<a href="'.base_url.'"><img src="'.base_url.'/image/logo.png" alt="logo" ></a>
			</div>
			
		</td>
		<td></td>
	</tr>
</table>

<!---content demo -->
<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: #f5f5fa; ">
	<tr>
		<td></td>
		<td class="header container">
			
			<div style="max-width: 630px;    margin: 0 auto;    display: block;">
			<table>
					<tr>
						<td>
						<br>
							<h3>Hello , Admin</h3>
							
						</td>
					</tr>
				</table>
			</div>			
		</td>
		<td></td>
	</tr>
</table>
<!---content demo End-->
<table class="head-wrap" style="width: 650px;    background: #f5f5fa;    margin: 0 auto; ">
	<tr>
		<td></td>
		<td class="header container">
			
			<!-- content -->
			<div style="max-width: 630px;    margin: 0 auto;    display: block;">
				<table>
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
 <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;   min-width: 180px; font-weight: bold;   text-align: left;  float:left;">Full Name :
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;     ">'.$InputName.'</span>
</td>
    
  </tr>
   <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;  min-width: 180px;font-weight: bold;   text-align: left;   float:left;">Email:
</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;      ">'.$InputEmail.'</span></td>
    
  </tr>
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;min-width: 180px; font-weight: bold;   text-align: left;  float:left;">Mobile No :

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;    ">'.$InputCno.'</span></td>
    
  </tr>
  
  <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;">
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;min-width: 180px; font-weight: bold;   text-align: left;  float:left;">Interest :

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;     text-align: center;    ">'.$InputInt.'</span></td>
    
  </tr>
  
   <tr>
   <td style="border-bottom: 1px dashed #777777; width: 100%;"> 
   <span style="text-decoration: none; color: #666;     padding: 3px 0 5px 0;   min-width: 180px; font-weight: bold;  text-align: left;   float:left;">Message :

</span><span style="text-decoration: none; color: #666;  padding: 10px 0;      text-align: center;     ">'.$InputMessage.'</span></td>
    
  </tr>
  
  
  		
					<tr>	
						<td></td><td></td>
					</tr>
				</table>
			</div>
			<!-- COLUMN WRAP -->
			
			<div  style="max-width: 630px;     margin: 0 auto;    display: block;">
				<table>
					<tr>
						<td>
						     <h4>Thank You, For Using Docconsult.</h4>
                             <p class="lead">Regards,</p>
                            <p class="lead">Docconsult Team</p>
						</td>
						</tr>
					</tr>
				</table>
			</div>
		</td>
		<td></td>		<!---Footer End--->
	</tr>	
</table>

<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: linear-gradient(to right, #2D9CDB, #2F5894);">
	<tr>
		<td></td>
		<td class="header container">
			
			<div style="max-width: 630px;    margin: 0 auto;    display: block;">
			<table>
				<tr>
					<td><a href="'.base_url.'"><img src="'.base_url.'/image/logo.png" alt="logo" ></a>
					<p style="  font-size: 12px;     margin: 2px 10px;  color:#fff;">Contact NO : <strong> 0141-2785199</strong></p>
					<p style="  font-size: 12px;      margin: 2px 10px;  color:#fff;">Email: <strong><a href="emailto:service@docconsult.in" style="color:#fff;">service@docconsult.in</a></strong></p>
					<p style="   font-size: 12px;     margin: 2px 10px;  color:#fff;">Copyright © 2017 DocConsult | All Right Reserved 2016</p>	</td>
					
					<td style="text-align: right;    width: 50%;">
					<p style="float: right; text-align: right; margin-right: 0px; margin-top: 60px;">
														<a href="https://www.facebook.com/docconsult/"><img src="'.base_url.'image/F.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a> 
														<a href="https://twitter.com/Docconsult12"><img src="'.base_url.'image/T.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a>
														<a href="https://www.youtube.com/channel/UCroHJE8lYtX3Wz9j233Dtwg"><img src="'.base_url.'image/Y.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a>
														<a href="https://www.instagram.com/docconsultservices/"><img src="'.base_url.'image/I.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a> 
														<a href="https://www.linkedin.com/in/docconsult-services-a70a72134/"><img src="'.base_url.'image/L.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a></br>
														</p></td>
				</tr>
			</table>
			</div>
			
		</td>
		<td></td>
	</tr>
</table>';
    
   
     $this->foremail($InputEmail,$msg,'service@docconsult.in','Acknowledgement For contact- Docconsult');
      $this->foremail('info@docconsult.in',$msg_admin,'service@docconsult.in','Contact Us-Docconsult');
    
    return true;
}

public function update_function($query)
{
    $res = $this->db->query($query);
    return $res;
}

public function display_doctor_education_in_html($id)
{
	$education = $this->get_data_by_id($id, $table = 'doctors', $field = 'education');
    $edu_detail = $education[0];
    $educations = json_decode($edu_detail,true);
	foreach($educations as $edu) {
	
		$doc_degree_list = $doc_degree_list_new = $doc_degree_result = $doc_degz = '';
		$doc_college_list = $doc_college_list_new = $doc_colege_result = $doc_colzz = '';
		
		if(is_numeric($edu['qualification'])){
			$doc_degree_list = $edu['qualification'];
		}else{
			$doc_degree_list_new = $edu['qualification'];
		}
		
		if(is_numeric($edu['collage'])){
			$doc_college_list = $edu['collage'];
		}else{
			$doc_college_list_new = $edu['collage'];
		}
		
		// Display Degree Name
		echo '<li class="inner-tag-value" style="padding-top:0px;"><i class="glyphicon glyphicon-education"></i> ';
		echo'<span class="value-inner-data">';
		
		if($doc_degree_list != ''){
			$doc_degree_result = $this->get_data_by_id($doc_degree_list, $table = 'degree', $field = 'degree');
		}
		
		foreach($doc_degree_result as $doc_degz) {
			echo $doc_degz; 
		}
		
		if($doc_degree_list_new){
			echo "".$doc_degree_list_new."";
		}
		
		// Display College Name
		if($doc_college_list != ''){
			$doc_colege_result = $this->get_data_by_id($doc_college_list, $table = 'collage', $field = 'college');
		}   
		foreach($doc_colege_result as $doc_colzz) { 
			echo' from ';
			echo $doc_colzz; 
		}
		if($doc_college_list_new){
			echo' from ';
			echo "".$doc_college_list_new."";
		}
		
		if($edu['year'] != ''){
			echo ' in ';
			echo $edu['year'];
		}
		echo '</span></li>';	
	}
}

public function free_demo_display(){
    
    $res = $this->db->query("select display from free_demo_display where id='1'");
    $data = $res->fetch_assoc();
    if($data['display']=='Yes'){
        return true;
    }
    else {
        return false;
    }
}


public function get_all_clinics($city, $location, $type,$page,$gender,$experience,$price,$day)
{	
    $resultset = array();
    $start = ($page*10)-10;
	
	if($start < 0){
		$start = 0;
	}
    
	$category_id = $this->clinic_category_id($type);
	$search = '';
	
	if(ucfirst($location) == 'Clinic'){
		$location = '';
	}
	
    if($location != '')
    {
		$sql = "SELECT * FROM clinic as t1 where t1.city='$city' and t1.area='$location' $search group by t1.id  LIMIT 10 OFFSET $start";
        $result = $this->db->query($sql);
        if($result->num_rows){
        	while($row=mysqli_fetch_assoc($result)) {
    			array_push($resultset,$row);
    		}
        }
    }
    elseif($location!='' && $type=='')
    {
		$sql = "SELECT t1.* FROM clinic as t1 where t1.city='$city' and t1.area='$location' $search group by t1.id  LIMIT 10 OFFSET $start";
        $result = $this->db->query($sql);
        if($result->num_rows){
        	while($row=mysqli_fetch_assoc($result)) {
    			array_push($resultset,$row);
    		}
        }
    }
    else
    {      	
		if($type != '')
		{
			$sql = "SELECT t1.* FROM clinic as t1 inner join clinic_category as t2 on t1.category = t2.id where t1.city='$city' and t1.category = '$category_id' $search group by t1.id  LIMIT 10 OFFSET $start";
		}
		else
		{
			$sql = "SELECT t1.* FROM clinic as t1 where t1.city='$city' $search group by t1.id  LIMIT 10 OFFSET $start";        }
        $result = $this->db->query($sql);
        if($result->num_rows){
        	while($row=mysqli_fetch_assoc($result)) {
    			array_push($resultset,$row);
    		}
        }
    }
	
	if(!empty($resultset))
		return $resultset;
}
public function get_total_clinic_record($city, $location, $type,$page,$gender,$experience,$price,$day)
{
	if($location != '')
    {
		$search = " and t1.area='$location' ";
	}
	if($type != '')
	{
		$total_sql = "select t1.* FROM clinic as t1 inner join clinic_category as t2 on t1.category = t2.id where t1.city='$city' and t1.category = '$category_id' $search";
	}
	else
	{
		$total_sql = "SELECT * FROM clinic as t1 where t1.city='$city'  $search ";        
	}
	$total_res = $this->db->query($total_sql);
	$total_no = $total_res->num_rows;
	
	return $total_no;
}

public function clinic_category_id($name)
{		
	$sql = "select id from clinic_category where name = '$name' ";
    $query = $this->db->query($sql);
	if($query->num_rows > 0)
	{
		while($row = $query->fetch_assoc()){
			$result = $row;
		}
	}	
    return $result['id'];
}

// Shorten a URL
public function url_small($url)
{
	//This is the URL you want to shorten
	$longUrl = $url;
	$apiKey = 'AIzaSyDgGjQStthF4wRdjqa6KnGVk4swa-R_U2s';
	//Get API key from : http://code.google.com/apis/console/

	$postData = array('longUrl' => $longUrl, 'key' => $apiKey);
	$jsonData = json_encode($postData);

	$curlObj = curl_init();

	curl_setopt($curlObj, CURLOPT_URL, 'https://www.googleapis.com/urlshortener/v1/url?key='.$apiKey);
	curl_setopt($curlObj, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curlObj, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($curlObj, CURLOPT_HEADER, 0);
	curl_setopt($curlObj, CURLOPT_HTTPHEADER, array('Content-type:application/json'));
	curl_setopt($curlObj, CURLOPT_POST, 1);
	curl_setopt($curlObj, CURLOPT_POSTFIELDS, $jsonData);

	$response = curl_exec($curlObj);

	//change the response json string to object
	$json = json_decode($response);
	curl_close($curlObj);
	return $json->id;
}

public function search_by_service_counts($city,$loc,$serv,$page,$gender,$experience,$price,$day) {
    
    $doc_id=array();
    $res = $this->db->query("select id from services_for_seo_use where services='$serv'");
    //print "select id from services_for_seo_use where services='$serv'";
    if(!empty($loc)){
    $res1 = $this->db->query("select id,services from doctors where city='$city' and location='$loc' and services!=''");
}
else {
    $res1 = $this->db->query("select id,services from doctors where city='$city' and services!=''");
}

    if($res->num_rows > 0){

        $serv_id = $res->fetch_assoc();


    }

    if($res1->num_rows > 0){

        while($data = $res1->fetch_assoc()){

            $services = json_decode($data['services'],true);
            
            /*foreach ($services as $key => $value) {
                if($serv_id['id'] == $value['service']){
					$doc_id[]=$data['id'];
				}
            }*/
			foreach ($services as $key => $value) {
               
			   	$sqls = "select services from services_for_seo_use where id = '".$value['service']."' ";
				$query_serive = $this->db->query($sqls);
				$result_servie = $query_serive->fetch_assoc();
				if(trim($serv) == $result_servie['services'])
				{				
                    $doc_id[] = $data;
            	}                
            }
            
        }
    }
    return count($doc_id);
} 

public function search_by_service($city,$loc,$serv,$page,$gender,$experience,$price,$day) {
    
    $start = ($page*10)-10;
    $doc_id=array();
	$serv = trim($serv);
    $res = $this->db->query("select id from services_for_seo_use where services='$serv'");
    //print "select id from services_for_seo_use where services='$serv'";
    if(!empty($loc)){
        $res1 = $this->db->query("select * from doctors where city='$city' and location='$loc' and services!='' ");
    }
    else {
        $res1 = $this->db->query("select * from doctors where city='$city' and services!=''  ");
    }

    if($res->num_rows > 0){

        $serv_id = $res->fetch_assoc();
    }

    if($res1->num_rows > 0){

        while($data = $res1->fetch_assoc())
		{
            $services = json_decode($data['services'],true);
            
            foreach ($services as $key => $value) {
               
			   	$sqls = "select services from services_for_seo_use where id = '".$value['service']."' ";
				$query_serive = $this->db->query($sqls);
				$result_servie = $query_serive->fetch_assoc();
				if(trim($serv) == $result_servie['services'])
				{				
                    $doc_id[] = $data;
            	}                
            }
            
        }
    }
    $doc_id = array_slice($doc_id, $start, 10, true);
    return $doc_id;
} 

public function search_by_specialization_counts($city,$loc,$serv,$page,$gender,$experience,$price,$day) {
    $doc_id=array();
    $res = $this->db->query("select id from speciality where specialization='$serv'");
    if(!empty($loc)){
        $res1 = $this->db->query("select id,specialization from doctors where city='$city' and location='$loc' and specialization!=''");
    }
    else {
        $res1 = $this->db->query("select id,specialization from doctors where city='$city' and specialization!=''");
    }

    if($res->num_rows > 0){

        $serv_id = $res->fetch_assoc();


    }

    if($res1->num_rows > 0){

        while($data = $res1->fetch_assoc()){

            $services = json_decode($data['specialization'],true);
           
            
			
			foreach ($services as $key => $value) 
			{
				$sqls = "select specialization from speciality where id = '".$value['specialization']."' ";
				$query_serive = $this->db->query($sqls);
				$result_servie = $query_serive->fetch_assoc();
				
				if(trim($serv) == $result_servie['specialization'])
				{	
					$doc_id[] = $data;
				}
            }
        }
    }
   
    return count($doc_id);
}
public function search_by_specialization($city,$loc,$serv,$page,$gender,$experience,$price,$day) {
    
    $start = ($page*10)-10;
    $doc_id=array();
    $res = $this->db->query("select id from speciality where specialization='$serv'");
        if(!empty($loc)){
        $res1 = $this->db->query("select * from doctors where city='$city' and location='$loc' and specialization!=''");
    }
    else {
        $res1 = $this->db->query("select * from doctors where city='$city' and specialization!=''");
    }

    if($res->num_rows > 0){

        $serv_id = $res->fetch_assoc();


    }

    if($res1->num_rows > 0){

        while($data = $res1->fetch_assoc()){

            $services = json_decode($data['specialization'],true);
           
            foreach ($services as $key => $value) 
			{
				$sqls = "select specialization from speciality where id = '".$value['specialization']."' ";
				$query_serive = $this->db->query($sqls);
				$result_servie = $query_serive->fetch_assoc();
				
				if(trim($serv) == $result_servie['specialization'])
				{	
					$doc_id[] = $data;
				}
            }
            
        }
    }
    $doc_id = array_slice($doc_id, $start, 10, true);
    return $doc_id;
}

public function search_doc_by_city_loc($city,$loc,$page,$gender,$fil_exper,$filter_price,$fil_day) {

    $start = ($page*10)-10;
    $resultset = array();

if(!empty($loc)){
	$res = $this->db->query("select DISTINCT t2.doctor_id ,t1.* from doctors as t1 inner join practice as t2 on t1.id = t2.doctor_id where t1.city='$city' and t1.location='$loc' LIMIT 10 OFFSET $start");
}
else {
    $res = $this->db->query("select DISTINCT t2.doctor_id ,t1.* from doctors as t1 inner join practice as t2 on t1.id = t2.doctor_id where t1.city='$city' LIMIT 10 OFFSET $start");
    //print "select * from doctors where city='$city' LIMIT 10 OFFSET $start";
    //die();   
}

if($res->num_rows > 0){

while($data=$res->fetch_assoc()){

    $arr[] = $data;

}
    
}
return $arr;
}


public function search_doc_by_city_loc_counts($city,$loc,$page,$gender,$fil_exper,$filter_price,$fil_day) {

	if(!empty($loc)){
		$res = $this->db->query("select DISTINCT t2.doctor_id ,t1.* from doctors as t1 inner join practice as t2 on t1.id = t2.doctor_id where t1.city='$city' and t1.location='$loc' ");
	}
	else {
		$res = $this->db->query("select DISTINCT t2.doctor_id ,t1.* from doctors as t1 inner join practice as t2 on t1.id = t2.doctor_id where t1.city='$city' ");
		//id,type,location,city,category,be_name
		//print "select id from doctors where city='$city'";
	}

	if($res->num_rows > 0){
		while($data=$res->fetch_assoc()){
		 $arr[] = $data;
			// $doc_id['id']=$data['id'];
			// $doc_id['type']=$data['type'];
			// $doc_id['location']=$data['location'];
			// $doc_id['be_name']=$data['be_name'];
			// $doc_id['category'] = $data['category'];
		
			// $res1 = $this->db->query("Select category from category where id='$cat'");
			// while($data1 = $res1->fetch_assoc()){
		
			//     $doc_id['category']=$data1['ca']
			// }
		}
	}
 	return $arr;
}


}
$functions = new Functions();

 ?>    