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




////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////file i.e doctor_api_one.php /////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





public function get_doc_id_by_phone($number) 
{
  
   
    $res = $this->db->query("select * from doctors where phone_no = '$number';");
    
    if($res->num_rows>0)
    {
        $data = $res->fetch_assoc();
        return $data['name'];
    }
}

////doctor api's for android
public function admin_doctor_login($id) {


 $res=  $this->db->query("SELECT * FROM doctors where  id='$id' AND type = 'Doctor' ");
 
   if($res->num_rows > 0){
            //session_start();
       
            $data = $res->fetch_assoc();

            $_SESSION['login_success'] = TRUE;
            $_SESSION['name'] = $data['name']; 
            $_SESSION['login_id'] = $id;
            $_SESSION['email'] = $data['email'];
            $_SESSION['profile_image'] = $data['image'];
            $_SESSION['last_login_timestamp'] = time();
            $_SESSION['doc_details'] = $data;
            $_SESSION['through_admin']= true;
            
            echo "<script> window.location.href='".base_url_doc."dashboard.php'; </script>";
            
          
   }
   else
   {
       return FALSE;
   }
    
    
}

public function admin_doctor_login_blog($id) {

 $res=  $this->db->query("SELECT * FROM doctors where   id='$id' AND type = 'Doctor' ");
 
   if($res->num_rows > 0){
            //session_start();
       
            $data = $res->fetch_assoc();

            $_SESSION['login_success'] = TRUE;
            $_SESSION['name'] = $data['name']; 
            $_SESSION['login_id'] = $id;
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
public function patient_details_chat_box_consult($category)
{
   $sql="SELECT * FROM chat_consult WHERE category='$category' AND answer is NULL;" ; 
   
      $result = $this->db->query("$sql");
         while($row=mysqli_fetch_assoc($result)) {
            $resultset[] = $row;
         }       
         if(!empty($resultset))
            return $resultset;  
}

public function checkdate($todaydate,$todaymonth,$todayyear,$eventdate,$eventmonth,$eventyear)
   {

       if($todayyear>$eventyear)
       {
           return FALSE;
       }
       elseif($todayyear==$eventyear)
       {
      if($todaymonth>$eventmonth)
      {
         return FALSE;
      }
      elseif($todaymonth==$eventmonth)
      {
         if($todaydate>$eventdate)
         {
            return FALSE;
         }
         else
         {
            return TRUE;
         }
      }
      else
      {
         return TRUE;
      }
       }
       else
       {
           return TRUE;
       }

   }

   public function get_welcome_doctor_data($id,$doctors){

   $res=$this->db->query("SELECT * FROM doctors WHERE id = '$id'");
    
    if($res-num_rows > 0)
    {
        
        $data = $res->fetch_assoc();
        $be_name = $data['be_name'];
        $name = $data['name'];
        $image = $data['image'];
        $city = $data['city'];
        $location = $data['location'];
        $name = $data['name'];
        $category = $data['category'];
          return $data;      
        
    }      
}

public function get_welcome_doctor_cat($category_id){
  echo $cat_id = $category_id;


    $res=$this->db->query("SELECT * FROM category WHERE id = '$cat_id'");
    
    if($res-num_rows > 0)
    {
        
       $data1 = $res->fetch_assoc();
        $cat_name= $data1['category'];
          return $data1;      
        
    }  
}





////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////// next file i.e doctor_api_two.php file///////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




public function getcategoryid($category){
    $result = $this->db->query("SELECT * FROM category where category='$category'");
        while($row=mysqli_fetch_assoc($result)) {
            $resultset[] = $row;
        }       
        if(!empty($resultset))
            return $resultset;
}

 public function getByDoctorId($id, $table){

        $res = $this->db->query("SELECT * FROM `$table` WHERE doctor_id='$id'");

        $str = '';

            if($res->num_rows > 0){

                return $res->fetch_assoc();

        }

    }
    
public function doctor_login($username, $password)
   {
      
       $res=  $this->db->query("SELECT * FROM `doctors` where  `phone_no` = '$username' AND `password` = '$password'");
   
   if($res->num_rows > 0){
       
            return TRUE;
            //header('Location: '.base_url_doc.'calender.php');
            
          
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







////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////// next file i.e doctor_api_three.php file///////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




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
        //      echo "condition2";
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
        //  $result = $this->db->query("SELECT * FROM doctors where  pincode='$pincode' and category='$type' LIMIT 10 OFFSET $start");
        //      if($result->num_rows){
        //          while($row=mysqli_fetch_assoc($result)) {
        //              array_push($resultset,$row);
        //              $docs[$row['id']]=1;
        //          }
                    
        //      }
        //  for($i=5;$i>0;$i--){
        //  $temp1 = $pincode - $i;
            
        //  $result = $this->db->query("SELECT * FROM doctors where  pincode='$temp1' and category='$type' LIMIT 10 OFFSET $start");
        //      if($result->num_rows){
        //          while($row=mysqli_fetch_assoc($result)) {
        //              if(!array_key_exists($row['id'],$docs)){
        //              array_push($resultset,$row);
        //              $docs[$row['id']]=1;
        //              }
        //          }
                    
        //      }
        //  }
        //  for($i=5;$i>0;$i--){
        //  $temp1 = $pincode + $i;
            
        //  $result = $this->db->query("SELECT * FROM doctors where  pincode='$temp1' and category='$type' LIMIT 10 OFFSET $start");
        //      if($result->num_rows){
        //      while($row=mysqli_fetch_assoc($result)) {
        //          if(!array_key_exists($row['id'],$docs)){
        //          array_push($resultset,$row);
        //          $docs[$row['id']]=1;
        //          }
        //      }
                    
        //      }
        //  }
            //print_r($docs);
            if($city)
            {
        //      echo "condition2";
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








////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////// next file i.e doctor_api_four.php file//////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




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
public function get_data_by_id($value, $table, $field)
{
    $sql = "select $field from $table where id in($value)";
    $query = $this->db->query($sql);
    while($row = $query->fetch_assoc()){
        $result[] = $row[$field];
    }
    return $result;
}
public function doctor_specialization($doctor_id)
{
   echo "sdgcvahd";
    $ret = $this->db->query("SELECT specialization FROM doctors WHERE id = '$doctor_id' ");
    if($ret->num_rows > 0){
        return $ret->fetch_assoc();
    }
}
 public function getById($id){
        $res = $this->db->query("SELECT * FROM `doctors` WHERE id='{$id}'");

        $str = '';

            if($res->num_rows > 0){

                return $res->fetch_assoc();

        }

    }
    

public function get_doctors_specialization_list($speciality){
    
    if(is_numeric($speciality)){
        $search = "(select speciality from speciality where id = '$speciality')";
    }else{
        $search = "'$speciality'";
    }

    $sql = "select id,specialization from speciality where speciality = $search ";
    $query = $this->db->query($sql);
    if($query->num_rows > 0)
    {
        while($result = $query->fetch_assoc())
        {
            $resultset[] = $result;
        }
    }
    return $resultset;
}
public function get_first_specility_id($speciality){
    
    if(is_numeric($speciality)){
        return $speciality;
    }else{
        $search = "'$speciality'";
    }
    
    $sql = "select id from speciality where speciality = '$speciality' order by id asc limit 1 ";
    $query = $this->db->query($sql);
    if($query->num_rows > 0)
    {
        while($result = $query->fetch_assoc())
        {
            $resultset = $result['id'];
        }
    }
    return $resultset;
}
public function edit_education1($education)
{
   $doc_id=$_SESSION['login_id'];
   
   $res=$this->db->query("update doctors set education='$education' where id='$doc_id'");
   if(@$res)
   {
      return TRUE;
   }
}





////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////// file i.e doctor_api_four.php file//////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////









public function get_education_doctor($id){

    $res = $this->db->query("SELECT * FROM `doctors` WHERE id='{$id}'");
     

                      
        $data =$res->fetch_assoc();
        $education=json_decode( $data['education'],TRUE);
        print_r($education['year']);
                              foreach($education as $edu) {
                                     
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
                                  
                                                if($doc_degree_list != ''){
                                                    $doc_degree_result = $this->get_data_by_id($doc_degree_list, $table = 'degree', $field = 'degree');
                                                }
                                                
                                                foreach($doc_degree_result as $doc_degz) {
                                                    $result1[]= $doc_degz; 
                                                }

                                                
                                                if($doc_degree_list_new){
                                                    $result1[]=$doc_degree_list_new;
                                                }
                                          
                                                if($doc_college_list != ''){
                                                    $doc_colege_result = $this->get_data_by_id($doc_college_list, $table = 'collage', $field = 'college');
                                                }   
                                                foreach($doc_colege_result as $doc_colzz) { 
                                                    $result2[]= $doc_colzz; 
                                                }
                                                if($doc_college_list_new){
                                                    $result2[]=$doc_college_list_new;
                                           } 
                                           $result3[]=$edu['year'];
                          }
                          $result[]=$result1;
                          $result[]=$result2;
                          $result[]=$result3;
                           return $result ;
                }


    


public function get_doctors_specialization($id)
{
     $res = $this->db->query("SELECT * FROM `doctors` WHERE id='{$id}'");
     

        $data =$res->fetch_assoc();
        


                                 $doc_spelize = json_decode($data['specialization'],TRUE);
                                 print_r($doc_spelize);
                                 foreach($doc_spelize as $docs_spe) { 
                                  
                                  if(is_numeric($docs_spe['specialization'])){
                                     $splize_sel_list[] = $docs_spe['specialization'];
                                  }else{
                                      $splize_sel_list_new[] = $docs_spe['specialization'];
                                  } 
                                }

                                          if(count($splize_sel_list) > 0){
                                            $specliz_array_list = $splize_sel_list;
                                         }else{
                                            $specliz_array_list = $splize_sel_list_new; 
                                         }  
                                         
                                         $splize_sel_list = implode(',',$splize_sel_list);
                                        if($splize_sel_list != ''){
                                           $speliz_result = $this->get_data_by_id($splize_sel_list, $table = 'speciality', $field = 'specialization');
                                        }   
                                        foreach($speliz_result as $doc_splizz) { 
                                                 $result[]=$doc_splizz ;
                                            } 
                                                 if($splize_sel_list_new){
                                                     foreach($splize_sel_list_new as $str_spliz) {
                                                     
                                                         $result[]=$str_spliz;
                                                     }    
                                                 }

                                        return ($result);

}
public function get_services_doctor($id){


  $res = $this->db->query("SELECT * FROM `doctors` WHERE id='{$id}'");
     

        $data =$res->fetch_assoc();



       $service=json_decode($data['services'],TRUE);

                                 foreach($service as $sers) { 
                                  
                                  if(is_numeric($sers['service'])){
                                     $serv_sel_listh[] = $sers['service'];
                                  }else{
                                      $serv_sel_list_new[] = $sers['service'];
                                  } 
                                }
                               $serv_sel_listh = implode(',',$serv_sel_listh);
                               if($serv_sel_listh != ''){
                                  $servresult = $this->get_data_by_id($serv_sel_listh, $table = 'services_for_seo_use', $field = 'services');
                               }   
                               foreach($servresult as $doc_serv) {
                                $result[]= $doc_serv ;
                                 } 
                                        if($serv_sel_list_new){
                                            foreach($serv_sel_list_new as $string_service) {
                                            
                                                $result[]= $string_service;
                                            }    
                                        }
                                return ($result);
                               
    }



public function get_experience_doctor($id){
        
    $res = $this->db->query("SELECT * FROM `doctors` WHERE id='{$id}'");
     

        $data =$res->fetch_assoc();



                            $exper=json_decode( $data['experience_detail'],TRUE);
                            foreach($exper as $expnc) { 

                             $result[]= $expnc['from']; 
                             $result[]= $expnc['to']; 
                              $result[]= $expnc['work']; 
                               $result[]= $expnc['location'];
                               $result[]= $expnc['type']; 


    }
    return ($result);

}

public function get_membership_doctor($id){
     $res = $this->db->query("SELECT * FROM `doctors` WHERE id='{$id}'");
     

        $data =$res->fetch_assoc();



       





        $memberships = json_decode($data['membership'],TRUE);
                                 foreach($memberships as $ser) { 
                                  if(is_numeric($ser['membership'])){
                                     $memb_sel_listh[] = $ser['membership'];
                                  }else{
                                      $memb_sel_list_new[] = $ser['membership'];
                                  } 
                                }
                               $memb_sel_listh = implode(',',$memb_sel_listh);
                               if($memb_sel_listh != ''){
                                  $mem_result = $this->get_data_by_id($memb_sel_listh, $table = 'membership', $field = 'name');
                               }   
                               foreach($mem_result as $memship) 
                                $result[]= $memship;
                                        if($memb_sel_list_new){
                                            foreach($memb_sel_list_new as $string_membership) {
                                            
                                                $result[]= $string_membership;
                                            }    
                                        }
                                        return ($result);
                                
    }            



public function get_article_doctor($id){
     $res = $this->db->query("SELECT * FROM `doctors` WHERE id='{$id}'");
     

        $data =$res->fetch_assoc();



                                
                                
       $service=json_decode($data['article'],TRUE);
                               foreach($service as $ser) {
                                 $result[]= $ser['article'];

                              


    }
     return ($result);

}



public function get_award_doctor($id){
     $res = $this->db->query("SELECT * FROM `doctors` WHERE id='{$id}'");
     

        $data =$res->fetch_assoc();


         $service=json_decode($data['award'],TRUE);
                               foreach($service as $ser) {

                               $result[]= $ser['award'] ;


                                 } 
                          return ($result);
    }


public function get_media_doctor($id){
     $res = $this->db->query("SELECT * FROM `doctors` WHERE id='{$id}'");
     

        $data =$res->fetch_assoc();


 $media_detail = json_decode($data['media'],TRUE);
                               foreach($media_detail as $mediaa) { 
                                 $result['title']=$mediaa['title'];
                                 $result['url']=$mediaa['url'];
                                 $result['referred']=$mediaa['referred'];
                                 $result['date']=$mediaa['date'];
                              
                               } 

                               return ($result);

    } 
    


public function get_registration_detail_doctor($id){
       


  $res = $this->db->query("SELECT * FROM `doctors` WHERE id='{$id}'");
     

        $data =$res->fetch_assoc();
        
      $reg_info=json_decode( $data['registration_detail'],TRUE); 
                            foreach($reg_info as $regd) { 
                                    $result['registration_no']= $regd['registration_no'];
                                     $result['registration_year']=$regd['registration_year'];

                                      if(is_numeric($regd['medical_council'])){
                                              $doc_coun_list = $regd['medical_council'];
                                       }else{
                                            $doc_coun_list_new = $regd['medical_council'];
                                       } 
                                     
                                     if($doc_coun_list != ''){
                                        $doc_counc_result = $this->get_data_by_id($doc_coun_list, $table = 'council', $field = 'council');
                                     }   
                                     foreach($doc_counc_result as $doc_splizz) { 
                                              $result['medical_council']= $doc_splizz; 
                                           }
                                           if($doc_coun_list_new){
                                               foreach($doc_coun_list_new as $str_councc_l) {
                                               
                                               $result['medical_council']=$str_councc_l;
                                               }
                                           }
                                      
                                    
                     
                       }
                       return ($result);
    }   





////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////next file i.e patient_api_one.php file//////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





public function getByPatientId($id, $table){

      $res = $this->db->query("SELECT * FROM `$table` WHERE patient_id='$id'");
 
      $str = '';

         if($res->num_rows > 0){

            return $res->fetch_assoc();

      }

   }





    public function display_patient($id)
{
   $res=$this->db->query("select * from doctors where id='$id'");
   $data = $res->fetch_assoc();
   $doctors_patient = json_decode($data['patients_added'],TRUE);
   $rows = array();
   foreach($doctors_patient as $id)
   {
       $rows[] = $this->getByPatientId($id,"patient");
   }
   
   $res = json_encode($rows);
      return ($rows);

   
}

public function patient_vital_all($id,$doc_id)
{
   echo $id;
   echo $doc_id;

if($id == ''){
   $res=$this->db->query("select * from vital where doctor_id='$doc_id'");
}
else{
   $res=$this->db->query("select * from vital where patient_id='$id' ORDER BY date DESC");
}
   
                                $count=1;

   if($res->num_rows > 0)
   {
      while($data=$res->fetch_assoc())
      { 
      $id=$data['patient_id'];
      
          $res1=$this->db->query("select * from patient where id='".$data['patient_id']."'");
          $data1=$res1->fetch_assoc();
                                      $result1['date']=date("j F Y",strtotime($data['date']));
                                        $result1['pulse']=$data['pulse'];
                                        $result1['temperature']=$data['temperature'];
                                        $result1['weight']=$data['weight'];
                                        $result1['resp_rate']=$data['resp_rate'];
                                        $result1['height']=$data['height'];
                                         $result1['pefr_pre']=$data['pefr_pre'];
                                         $result1['pefr_post']=$data['pefr_post'];
                                         $result1['blood_sugar_fast']=$data['blood_sugar_fast'];
                                         $result1['blood_sugar_rendom']=$data['blood_sugar_rendom'];
                                         $result1['blood_systolic']=$data['blood_systolic'];
                                         $result1['blood_diastolic']=$data['blood_diastolic'];
                                        $count++ ;
                                      }
                                      $result2[]=$result1;
                                   }
                                   
                                   $result[]=$result2;
                                   

                                       return ($result);

}


public function delete_vital($id){
    
    $res = $this->db->query("delete from vital where id='$id'");
    
    if($res){
        
        return TRUE;
    }
}

public function shared_prescription($patient_id,$doc_id){
    
   $res = $this->db->query("select * from share_prescription where to_doctor_id='$doc_id' and patient_id='$patient_id' ");
   
  
                                $count=1;
   if($res->num_rows > 0)
   {
      while($data=$res->fetch_assoc())
      {
             
                                        $result['date']=date("j F Y",strtotime($data['date']));
                                        
                                        
                                        
                                          
                                    $count++ ;
      
      }  
   }
   
   return ($result);
    
}

public function display_ephr_history($patient_id,$doc_id)

{
    $res2 = $this->db->query("select id from patient where patient_id='$patient_id'");
    
    $pid = $res2->fetch_assoc();
   $id =$pid['id'];
   
   
    $res1 = $this->db->query("select * from share_ephr where pid='$id' and todoc='$doc_id'");
    if($res1->num_rows>0){
     
     $res=$this->db->query("select * from ephr where patient_id='$id' and relation!=''"); 
     
    
   
  
   if($res->num_rows > 0)
   {
      while($data1=$res->fetch_assoc())
      {   
      
      
         
                                      $result['name']=$data1['name'];
                                        $result['disease']=$data1['disease'];
                                        $result['pat_mat']=$data1['pat_mat'];
                                        $result['relation']=$data1['relation'];
                                        $result['comment']=$data1['comment'];
                                  
      
      }  
      
   }
   
  


 }

 return ($result);
}

public function display_ephr_vaccine($patient_id,$doc_id)

{
    $res2 = $this->db->query("select id from patient where patient_id='$patient_id'");
    
    $pid = $res2->fetch_assoc();
   $id =$pid['id'];
   
   
    $res1 = $this->db->query("select * from share_ephr where pid='$id' and todoc='$doc_id'");
    if($res1->num_rows>0){
     
     $res=$this->db->query("select * from ephr where patient_id='$id' and age!=''");   
     
    
   
  
   if($res->num_rows > 0)
   {
      while($data1=$res->fetch_assoc())
      {   
      
      
        
                                      $result['name']=$data1['name'];
                                      $result['vaccination']=$data1['vaccination'];
                                        $result['year']=$data1['year'];
                                        $result['age']=$data1['age'];
                                        
                                        $result['comment']=$data1['comment'];
                                      
      }  
      
   }
   
   
 }

 return ($result);
}

public function display_ephr_allergy($patient_id,$doc_id)

{
    $res2 = $this->db->query("select id from patient where patient_id='$patient_id'");
    
    $pid = $res2->fetch_assoc();
   $id =$pid['id'];
   
   
    $res1 = $this->db->query("select * from share_ephr where pid='$id' and todoc='$doc_id'");
    if($res1->num_rows>0){
     
     $res=$this->db->query("select * from ephr where patient_id='$id' and allergy!=''");  
     
    
   
   
   if($res->num_rows > 0)
   {
      while($data1=$res->fetch_assoc())
      {   
      
      
         
                                      $result['name']=$data1['name'];
                                        $result['allergy']=$data1['allergy'];
                                        $result['allergy_type']=$data1['allergy_type'];
                                        $result['symptoms']=$data1['symptoms'];
                                        $result['medicine']=$data1['medicine'];
                                        $result['severity']=$data1['severity'];
                                        $result['comment']=$data1['comment'];
                                        
      }  
      
   }
   
  
 }

 return ($result);
}


public function display_ephr_disease($patient_id,$doc_id)

{
    $res2 = $this->db->query("select id from patient where patient_id='$patient_id'");
    
    $pid = $res2->fetch_assoc();
   $id =$pid['id'];
   
   
    $res1 = $this->db->query("select * from share_ephr where pid='$id' and todoc='$doc_id'");
    if($res1->num_rows>0){
     
     $res=$this->db->query("select * from ephr where patient_id='$id' and disease!='' and year_from!=''");  
     
    
   
   
   if($res->num_rows > 0)
   {
      while($data1=$res->fetch_assoc())
      {   
      
      
         
                                      $result['name']=$data1['name'];
                                        $result['disease']=$data1['disease'];
                                        $result['year_from']=$data1['year_from'];
                                        $result['year_till']=$data1['year_till'];
                                        
                                        $result['comment']=$data1['comment'];
                                      
      }  
      
   }
   
  
 }

 return ($result);
}


public function display_ephr_surgery($patient_id,$doc_id)

{
    $res2 = $this->db->query("select id from patient where patient_id='$patient_id'");
    
    $pid = $res2->fetch_assoc();
   $id =$pid['id'];
   
   
    $res1 = $this->db->query("select * from share_ephr where pid='$id' and todoc='$doc_id'");
    if($res1->num_rows>0){
     
     $res=$this->db->query("select * from ephr where patient_id='$id' and surgery!='' "); 
     
    
   
   
   if($res->num_rows > 0)
   {
      while($data1=$res->fetch_assoc())
      {   
      
      
       
                                      $result['name']=$data1['name'];
                                        $result['surgery']=$data1['surgery'];
                                        $result['year']=$data1['year'];
                                        $result['comment']=$data1['comment'];
                                   
      }  
      
   }
   
   
 }

 return ($result);
}


public function display_ephr_addiction($patient_id,$doc_id)

{
    $res2 = $this->db->query("select id from patient where patient_id='$patient_id'");
    
    $pid = $res2->fetch_assoc();
   $id =$pid['id'];
   
   
    $res1 = $this->db->query("select * from share_ephr where pid='$id' and todoc='$doc_id'");
    if($res1->num_rows>0){
     
     $res=$this->db->query("select * from ephr where patient_id='$id' and addiction!='' ");  
     
    
   
   
   if($res->num_rows > 0)
   {
      while($data1=$res->fetch_assoc())
      {   
      
      
                                      $result['name']=$data1['name'];
                                        $result['addiction']=$data1['addiction'];
                                        $result['status']=$data1['status'];
                                        $result['year_from']=$data1['year_from'];
                                        $result['year_till']=$data1['year_till'];
                                        $result['comment']=$data1['comment'];
                                      
      }  
      
   }
   
  
 }

 return ($result);
}

public function display_ephr_rehabilition($patient_id,$doc_id)

{
    $res2 = $this->db->query("select id from patient where patient_id='$patient_id'");
    
    $pid = $res2->fetch_assoc();
   $id =$pid['id'];
   
   
    $res1 = $this->db->query("select * from share_ephr where pid='$id' and todoc='$doc_id'");
    if($res1->num_rows>0){
     
     $res=$this->db->query("select * from ephr where patient_id='$id' and center!='' ");  
     
    
   
   
   if($res->num_rows > 0)
   {
      while($data1=$res->fetch_assoc())
      {   
      
      
        
                                      $result['name']=$data1['name'];
                                        $result['center']=$data1['center'];
                                        $result['cause']=$data1['cause'];
                                        $result['year_from']=$data1['year_from'];
                                        $result['year_till']=$data1['year_till'];
                                        $result['comment']=$data1['comment'];
                                        
      
      }  
      
   }
   
   
 }

 return ($result);
}







////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////next file i.e patient_api_two.php file//////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////







public function get_patient_appointments_for_doctor($id,$doc_id)
{
    //echo $doc_id,$id;
    $res = $this->db->query("select * from appointments where patient_id='$id' and doctor_id='$doc_id' ORDER BY app_date DESC");
   
   if($res->num_rows > 0)
   {
      while($data=$res->fetch_assoc())
      {
         
                                        $result['app_date']=$data['app_date'];
                                        $result['app_time']=$data['app_time'];
                                        $result['clinic_name']=$data['clinic_name'];
                         
                                  
      
      }  
   }
 return ($result); 
}




public function clinical_note_show1($id,$doc_id)
{
   
   if($id == ''){
      $res=$this->db->query("select * from clinical_note where doctor_id='$doc_id' order by date DESC");
   }
   else{
      $res=$this->db->query("select * from clinical_note where patient_id='$id' order by date DESC");
   }
   
  
   
   if($res->num_rows > 0)
   {
      while($data=$res->fetch_assoc())
      {
      $data1 = $this->getByPatientId($data['patient_id'], 'patient');  
         /*$str.='<div class="clinical_note_main">
                  <div class="clinical_image">
                     <img src="'.base_url.'image/'.$data1['image'].'" width="40px" height="40px">
                  </div>
                  <div class="clinical_name">&nbsp;'.$data1['name'].' </div>
                  <div class="clinical_sex">&nbsp; '.$data1['gender'].' </div>
                  <div class="clinical_id">&nbsp;'.$data1['id'].'  </div>
                  <div class="clinical_date"> &nbsp;'.$data['date'].' </div>
                  <div class="clinical_action">&nbsp; 
                     <a href="'.base_url_doc.'patient/?edit_clinical_note='.$data['id'].'" class="btn btn-info">
                        <i class="material-icons">edit</i>
                     </a>
                        <a href="'.base_url_doc.'patient-detail/?delete_clinical_note='.$data['id'].'" class="btn btn-info" onclick="return conf();">
                           <i class="material-icons">clear</i>
                        </a> 
                        <a href="'.base_url_doc.'print_clinical_note/?print_clinical_note='.$data['id'].'" class="btn btn-info" target="_blank" >
                           <i class="material-icons">print</i>
                        </a>
                        </div>
                     <div style="clear:both"> 
                     </div>
                  <div class="clinical_left">Chi  ef Complaints </div> <div class="clinical_detail">'.$data['complaint'].' </div>
                  <div class="clinical_left">Observation </div> <div class="clinical_detail">'.$data['observation'].' </div>
                  <div class="clinical_left">Invastigations </div> <div class="clinical_detail">'.$data['invastigations'].' </div>
                  <div class="clinical_left">Diagnoses </div> <div class="clinical_detail">'.$data['diagnoses'].' </div>
                  <div class="clinical_left">Note </div> <div class="clinical_detail">'.$data['note'].' </div>
         
         
          </div>
                        <div style="clear:both"> </div>           ';*/
          $result['date']=date("j F Y",strtotime($data['date']));
          $result['complaint']=$data['complaint'];
          $result['observation']=$data['observation'];
          $result['invastigations']=$data['invastigations'];
          $result['diagnoses']=$data['diagnoses'];
          $result['note']=$data['note'];
}


}
return ($result);
}


public function delete_clinical_note($id,$doc_id){
    
    $res = $this->db->query("delete from clinical_note where id='$id' and doctor_id='$doctor_id'");
    if($res)
    {
      return true;
    }
    else
    {
      return false;
    }
} 




public function display_patient_prescription($pid,$doc_id)
{
    //echo $pid;
   $res = $this->db->query("select * from prescription_patient where doctor_id='$doc_id' and patient_id='$pid' ORDER BY date DESC");
    //echo $res->num_rows;
   //$data = $res->fetch_assoc();

  
    if($res->num_rows > 0) 
   {
      while($data=$res->fetch_assoc())
      {
         //$data1=$this->getById($pid,"patient");
         $result['date']=date("j F Y",strtotime($data['date']));
         $drug_names = json_decode($data['drug_name']);
         foreach($drug_names as $drugname)
         {
            $result['drugname']=$drugname;
         }

            $strength = json_decode($data['strength']);
            $unit = json_decode($data['unit']);
            $count = 0;
            foreach($strength as $st)
            {
                $result['st']=$st.' '.$unit[$count];  
               $count++;
            }
            $durations=json_decode($data['duration']);
            $time = json_decode($data['days']);
            $count = 0;
            foreach($durations as $duration)
            {
                
               $result['duration']=$duration.' '.$time[$count];   
               $count++;
            }
            
            $food = json_decode($data['food']);
            foreach($food as $food)
            {
               $result['food']=$food;
         }
            
            $instruction=json_decode($data['instruction']);
            foreach($instruction as $instruct)
            {
               $result['instruct']=$instruct;
         }
        
}


}
return ($result);
}






public function get_tax_by_id($id,$doc_id)
{
    $res=$this->db->query("select * from tax where id='$id' and doctor_id='$doc_id'");
    if($res->num_rows>0)
    {
        $data = $res->fetch_assoc();
        return $data['value'];
    }
    else
        return 0;
    
}
public function get_taxname_by_id($id,$doc_id)
{
    $res=$this->db->query("select * from tax where id='$id' and doctor_id='$doc_id'");
    if($res->num_rows>0)
    {
        $data = $res->fetch_assoc();
        return $data['tax'];
    }
    else
        return 0;
    
}





public function display_invoice_show($pid,$doc_id)
{
    //echo $pid;
   $res = $this->db->query("select * from bill_info where doctor_id='$doc_id' and patient_id='$pid' ORDER BY date DESC");
    //echo $res->num_rows;
   //$data = $res->fetch_assoc();
   
    if($res->num_rows > 0)
   {
      while($data=$res->fetch_assoc())
      {
         //$data1=$this->getById($pid,"patient");
         $result['date']=date("j F Y",strtotime($data['date']));

         $names = json_decode($data['name'],TRUE);
         foreach($names as $name)
         {
            $result['name']=$name;
         }
         

            $amount = json_decode($data['amount'],TRUE);
            
            
            foreach($amount as $at)
            {
                $result['amount']=$at;   
               
            }
            $discount=json_decode($data['discount'],TRUE);
            foreach($discount as $dis)
            {
                
               $result['discount']=number_format((float)$dis,2,'.','');  
               
            }
            $tax="Tax Free";
            if($data['tax'])
            {
                $tax=json_decode($data['tax'],TRUE);
                foreach($tax as $dis)
                {
                    if(intval($dis))
                 { 
                  $result['tax']=$this->get_taxname_by_id($dis,$doc_id);
                  $result['tax']=$this->get_tax_by_id($dis,$doc_id);
               }
                  else
                    $result['tax']=$tax;
    
                  
                }
               
            }
            else
                 $result['tax']=$tax;
            
            
                 $result['total']=$data['total'];
         
            
                 $result['pending_amount']=$data['pending_amount'];

         }
}
return ($result);
}




public function file_show($id,$doc_id)
{
   

      $res=$this->db->query("select * from files where patient_id='$id'and doctor_id='$doc_id'and status_doc='0'");
 
  
 
   if($res->num_rows > 0)
   {
      while($data=$res->fetch_assoc())
      {
          $res1=$this->db->query("select * from patient where id='".$data['patient_id']."'");
          $data1=$res1->fetch_assoc();
          if($data['frm_pat'])
          {
             $te=$data1['name'];
          }
         
         $result['date']=$data['date'];
         $result['category']=$data['category'];
         $result['file_name']=$data['file_name'];                                   
         $result['file']=$data['file'];
}


}

print_r($result);
}



public function delete_file($fileid)
{   
    $res1 = $this->db->query("select status_pat from files where id='$fileid'");
    $res2 = $this->db->query("update files set status_doc='1' where id='$fileid'");
    $data = $res1->fetch_assoc();
    if($data['status_pat']==1){
    $res = $this->db->query("delete from files where id='$fileid'");
    }
    
        return TRUE;
}


















////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////next file i.e appointments_api_one.php file//////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////













public function display_todays_appointment($doc_id)
{
   
   $date = date("Y-m-d");
   $res=$this->db->query("SELECT appointments.id,appointments.clinic_id, appointments.patient_name, appointments.app_date, appointments.app_time, appointments.category, appointments.patient_id, appointments.patient_type, clinic.name,appointments.app_date as date_app from appointments JOIN doctors ON appointments.doctor_id=doctors.id join clinic on clinic.id=appointments.clinic_id WHERE appointments.doctor_id = '$doc_id' and appointments.app_date = '$date' and appointments.status!='Cancel'");
   
   $rows = array();
   while($r = mysqli_fetch_array($res))
   {
       $date = strtotime($r['app_date']);
       $r['app_date'] = date("j F Y",$date);
       
       $r['cur_day'] = date("Y-m-d");
       $cur_time = strtotime(date("Y-m-d h:i A"));
      $appTime = strtotime($r['date_app'].' '.$r['app_time']);
      if($cur_time < $appTime){
         $r['check'] = 1;
      }else{
         $r['check'] = 0;
      }
      
      $rows[] = $r;     
   }
   
   $res = ($rows);
   return ($res);   
}
public function display_upcoming_appointment($doc_id)
{
   
   $date = date("Y-m-d");
   $res=$this->db->query("SELECT appointments.clinic_id,appointments.patient_name, appointments.patient_id, appointments.id, appointments.app_date, appointments.app_time, appointments.category, appointments.patient_type, clinic.name,appointments.app_date as date_app from appointments JOIN doctors ON appointments.doctor_id=doctors.id join clinic on clinic.id = appointments.clinic_id WHERE appointments.doctor_id = '$doc_id' and appointments.app_date > '$date' AND appointments.status != 'Cancel' ORDER BY appointments.app_date");
   
   $rows = array();
   while($r = mysqli_fetch_array($res))
   {
      $date = strtotime($r['app_date']);
       $r['app_date'] = date("j F Y",$date);
       
       $r['cur_day'] = date("Y-m-d");
       $cur_time = strtotime(date("Y-m-d h:i A"));
      $appTime = strtotime($r['date_app'].' '.$r['app_time']);
      if($cur_time < $appTime){
         $r['check'] = 1;
      }else{
         $r['check'] = 0;
      }
      
      $rows[] = $r;
   }
   $res = ($rows);
   return ($res);   
}
public function display_cancelled_appointment($doc_id)
{
   echo "hello";   
   echo $doc_id;
   $res=$this->db->query("SELECT appointments.patient_name,  appointments.id, appointments.patient_id, appointments.remark, appointments.app_date, appointments.app_time, appointments.category, appointments.patient_type, clinic.name from appointments JOIN doctors ON appointments.doctor_id=doctors.id join clinic on clinic.id = appointments.clinic_id WHERE appointments.doctor_id = '$doc_id' AND appointments.status ='Cancel' ORDER BY appointments.app_date DESC");
   
   $rows = array();
   while($r = mysqli_fetch_array($res)){
      $date = strtotime($r['app_date']);
       $r['app_date'] = date("j F Y",$date);
      $rows[] = $r;
   }
   $res = ($rows);
   return ($res);   
}
  



  public function display_recent_appointment($doc_id)
{
   
   $res=$this->db->query("SELECT appointments.patient_name, appointments.id, appointments.patient_id, appointments.app_date, appointments.app_time, appointments.category, appointments.patient_type, clinic.name from appointments JOIN doctors ON appointments.doctor_id=doctors.id join clinic on clinic.id = appointments.clinic_id WHERE appointments.doctor_id = '$doc_id' AND appointments.app_date < CURRENT_DATE AND appointments.status !='Cancel' ORDER BY appointments.app_date DESC");
   
   $rows = array();
   while($r = mysqli_fetch_array($res))
   {
      $date = strtotime($r['app_date']);
       $r['app_date'] = date("j F Y",$date);
      $rows[] = $r;
   }
   $res = ($rows);
   return ($res);
}



public function display_call_requests($doc_id)
{
   
   $res=$this->db->query("SELECT *,app_date as date_app FROM `request_for_call` WHERE doctor_id = '$doc_id' and status = 'Pending' ORDER BY app_date desc ");
   
   $rows = array();
   while($r = mysqli_fetch_array($res))
   {
      $appTime = '';
      $date = strtotime($r['app_date']);
       $r['app_date'] = date("j F Y",$date);
       
       $r['cur_day'] = date("Y-m-d");
      
       $cur_time = strtotime(date("Y-m-d h:i A"));
      $time_app = str_replace(':PM',' PM',$r['app_time']);
      $time_app = str_replace(':AM',' AM',$time_app);
      $appTime = strtotime($r['date_app'].' '.$time_app);
      
      if($appTime > $cur_time ){
         $r['check'] = 1;
      }else{
         $r['check'] = 0;
      }  
      $rows[] = $r;
   }
   $res = ($rows);
   return ($res);
}













////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////// next file i.e calender_api_one.php file///////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
















public function display_event($doc_id)
{
   
   $res=$this->db->query("select * from event where doctor_id='$doc_id'");
   
                                 $count=0;
   if($res->num_rows > 0)
   {
      while($data=$res->fetch_assoc())
      {   
      $count++;
        
                                        $result['name']=$data['name'];
                                        $result['event_time']=$data['event_time'];
                                        $result['event_date']=$data['event_date'];
                                        $result['description']=$data['description'];
                                       
         }  
   }
   
   return ($result);
   
   
}
public function add_event($doc_id,$title,$date,$time,$desctiption)
{
   
   
   $res=$this->db->query("insert into event(name,event_date,event_time,description,doctor_id) values('$title','$date','$time','$desctiption','$doc_id')");
   if($res)
   {
      return true;
   }
}

public function  delete_event($id)
{
   $res=$this->db->query("DELETE FROM event WHERE  id='$id'");
   if($res)
   {
      return true;
   }
}
public function  delete_visit($id)
{
   $res=$this->db->query("DELETE FROM visit WHERE  id='$id'");
   if($res)
   {
      return true;
   }
}





public function get_calendar_detail($doc_id)
{
    
   $res=$this->db->query("select * from calendar_setting where doctor_id='$doc_id'");
   
   //$res=$this->db->query("select * from calendar_setting");
   if(@$res->num_rows > 0)
   {
      return $res->fetch_assoc();
      }
}

public function gethomevisitforcalender($doc_id)
{
   
   $res=$this->db->query("select * from visit where doctor_id='$doc_id'");
   
   //$res=$this->db->query("select * from visit");
   if($res->num_rows>0)
   {
      $count=0;
      while($data=$res->fetch_assoc())
      {
         $visit[$count]=array('patient'=>$data['patient_name'],'app_date'=>$data['date'],'time'=>$data['time'],'id'=>$data['id']);
         $count++;
      }
      return $visit;
   }
}
public function getappointmentforcalender($doc_id)
{
   
   $res=$this->db->query("select * from appointments where doctor_id='$doc_id' and status!='Cancel'");   

   //$res=$this->db->query("select * from appointments");
   if($res->num_rows>0)
   {
      $count=0;
      while($data=$res->fetch_assoc())
      {
         $appointment[$count]=array('patient'=>$data['patient_name'],'app_date'=>$data['app_date'],'time'=>$data['app_time'],'id'=>$data['id']);
         $count++;
      }
      return $appointment;
   }

   
}
public function geteventforcalender($doc_id)
{
   
   $res=$this->db->query("select * from event where doctor_id='$doc_id' ");

   //$res=$this->db->query("select * from event");
   if($res->num_rows>0)
   {
      $count=0;
      while($data=$res->fetch_assoc())
      {
         $event[$count]=array('name'=>$data['name'],'event_date'=>$data['event_date'],'time'=>$data['event_time'],'id'=>$data['id']);
         $count++;
      }
      return $event;
   }

   
}



public function add_visit($doc_id,$patient_name,$date,$time,$add_info)
{
   
   //echo "insert into visit(patient_name,date,time,add_info,doctor_id) values('$patient_name','$date','$time','$add_info','$doc_id')"; exit;
   $res=$this->db->query("insert into visit(patient_name,date,time,add_info,doctor_id) values('$patient_name','$date','$time','$add_info','$doc_id')");
   if(@$res)
   {
      return $res;
   }
}

public function display_today_home_visit($doc_id)
{
    
    $date = date("Y-m-d");
    $res = $this->db->query("select * from `visit` where `doctor_id`='$doc_id' and `token`='' and date='$date'");

          $count=0;
     if($res->num_rows > 0)
   {
      while($data=$res->fetch_assoc())
      {   
      $count++;
        
                                        $result[]=$data;
                                        
         }  
   }
   
   return ($result);
}

public function display_home_visit($doc_id)
{
    $count=0;
    $res = $this->db->query("select * from visit where doctor_id='$doc_id' and token=''");
    if($res->num_rows > 0)
   {
      while($data=$res->fetch_assoc())
      {   
      $count++;
        
                                        $result[]=$data;
                                        
         }  
   }
   
   return ($result);
}





public function getByDoctorid_with_tmp($id,$table,$tmp)
{
   
      $res = $this->db->query("SELECT * FROM `$table` WHERE doctor_id='$id' and templete='$tmp'");
 
      $str = '';

         if($res->num_rows > 0){

            return $res->fetch_assoc();

      }
}





public function token_shuffle($date,$doc_id)
{
       if($this->db->query("SET @i=0;") && $this->db->query("UPDATE `token` SET token_no = @i:=@i+1 WHERE app_date='$date' and doctor_id='$doc_id' and status!='Cancel'  ORDER BY app_time;") )
    {
        $i=0;
    }
   // $update_token=$this->db->multi_query("SET @i=0; UPDATE `token` SET token_no = @i:=@i+1 WHERE app_date='$date' and doctor_id='$doc_id'  ORDER BY app_time;");
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



public function add_appointment($doc_id,$name,$email,$date,$notify,$time,$prescription,$id,$notify_doctor,$patient_id1,$phone_no,$clinic_name)
{
   
   $res=$this->db->query("insert into appointments(patient_name,patient_email,app_date,app_time,doctor_id,patient_id,phone_no,clinic_name,category) values('$name','$email','$date','$time','$doc_id','$patient_id1','$phone_no','$clinic_name','Doctor')");
   $last_id=$this->db->query("SELECT LAST_INSERT_ID(`id`) as id from appointments ORDER BY id DESC LIMIT 1");
   $last_id=$last_id->fetch_assoc();
   $last_id=$last_id['id']; 
   $insert_token=$this->db->query("INSERT INTO `token` (`id`, `app_id`, `patient_id`, `patient_name`, `doctor_id`, `app_time`, `app_date`,`clinic_name`,`token_no`,`status`) VALUES (NULL, '$last_id', '$patient_id1', '$name', '$doc_id', '$time', '$date','$clinic_name','1','pending');");
   
   
   
   $res2=$this->db->query("select * from  patient where patient_id='$patient_id1'");
   if($res2->num_rows > 0)
   {
      // $r1 = $this->insert_into_patient_doctorblob($patient_id1,$doc_id);
      // $r2 = $this->insert_into_doctor_patientblob($doc_id,$patient_id1);
   }
   else
   {
       $image='new.png';
       $pass = sha1($phone_no);
      $res3=$this->db->query("insert into patient(name,email,patient_id,doctor_id,image,phone_no,password,date,parent_id) values('$name','$email','$patient_id1','$doc_id','$image','$phone_no','$pass','$date','$patient_id1')");
       $r1 = $this->insert_into_patient_doctorblob($patient_id1,$doc_id);
       $r2 = $this->insert_into_doctor_patientblob($doc_id,$patient_id1);
      
   }

   if(@$res)
   {
      $active_name="Add Appointment";
      $res1=$this->db->query("select * from appointments where doctor_id='$doc_id' order by id DESC limit 1");
      $data=$res1->fetch_assoc();
      $patient_id=$data['patient_name'];
      
      $action='added';
      $date1=date('Y-m-d');
      $time1=date("h:i");
   $res1=$this->db->query("insert into activity(name,patient_id,doctor_id,action,date,time) values('$active_name','$patient_id','$doc_id','$action','$date1','$time1') ");
      
      $patient_name = $name;
      
      
      if($notify=='sms')
      {
         $doctor=$this->getById($doc_id);
      $doctor_name=$doctor['name'];
      $msg_ar=$this->getByDoctorid_with_tmp($doc_id, "msg_tamplete","appointment");
      $msg=$msg_ar['msg'];
      $msg=str_replace("{{PATIENT}}",$name,$msg);
      $msg=str_replace("{{CLINIC}}",$doctor_name,$msg);
      
      
      
    // $send_sms_url = 'http://www.sms.jprinfotech.com/api/sendhttp.php?authkey=4296AbkgvkyLHP2b584bb4a2&mobiles='.$phone_no.'&message='.$msg.'&sender='.sender_id.'&route=4';
     $send_sms_url='http://login.cheapsmsbazaar.com/vendorsms/pushsms.aspx?user=docconsult&password=aks120109&msisdn='.$phone_no.'&sid='.sender_id.'&msg='.$msg.'&fl=0&gwid=2';

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
      
      
      }
      if($notify=="email")
      {
         $doctor=$this->getById($doc_id);
      $doctor_name=$doctor['name'];
      $msg_ar=$this->getByDoctorid($doc_id, "msg_tamplete");
      $msg=$msg_ar['msg'];
      $msg=str_replace("{{PATIENT}}",$name,$msg);
      $msg=str_replace("{{CLINIC}}",$doctor_name,$msg);
      
      require_once("../phpmailer/PHPMailerAutoload.php");

              $mail = new PHPMailer();

         //   $email = $_GET['email'];

          $mailhost = "docconsult.in";
              $smtpUser = "mail@docconsult.in";
              $smtpPassword = "telekast@123";

           

           $name = "Doc Consult";

           $subject = "Appointment Confirmed";

           $from = "support@jprinfotech.com";

           



                $mail->IsSMTP();

                $mail->Host = $mailhost;

                $mail->SMTPAuth = true;

                $mail->Username = $smtpUser;

                $mail->Password = $smtpPassword;

                //$mail->SMTPSecure = "ssl";  //ssl or tls

                $mail->Port = 465; // 25 or 465 or 587

              

                $mail->From = $from;



                $mail->FromName = $name;

                $mail->AddReplyTo($from);

                $mail->AddAddress($email);

                $mail->IsHTML(true);

                $mail->Subject = $subject;

                $mail->Body = '<div style="width:100%; height:100%; margin:0;" >'.$msg.'
                </div>';

             $mail->Send();      
            
      }
   
      if($notify_doctor=='sms')
      
      {
         $doctor=$this->getById($doc_id);
         $doctor_name=$doctor['name'];
      
      $sms = 'Hello%20'.$doctor_name.',%20Appointment%20for%20'.$patient_name.'%20has%20been%20fixed%20successfully.%20Date%20:%20'.$date.'%20Time%20:%20'.$time.'.';
      $sms = str_replace("<", "", $sms);
       $sms = str_replace(">", "", $sms);
       $sms = rawurlencode($sms);
      
     //$send_sms_url = 'http://www.sms.jprinfotech.com/api/sendhttp.php?authkey=4296AbkgvkyLHP2b584bb4a2&mobiles='.$doctor['phone_no'].'&message='.$sms.'&sender='.sender_id.'&route=4';
     $send_sms_url='http://login.cheapsmsbazaar.com/vendorsms/pushsms.aspx?user=docconsult&password=aks120109&msisdn='.$doctor['phone_no'].'&sid='.sender_id.'&msg='.$sms.'&fl=0&gwid=2';

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
      if($notify_doctor=="email")
      {
            $doctor=$this->getById($doc_id);
      $doctor_name=$doctor['name'];
      $msg_ar=$this->getByDoctorid($doc_id, "msg_tamplete");
      $msg=$msg_ar['msg'];
      $msg=str_replace("{{PATIENT}}",$name,$msg);
      $msg=str_replace("{{CLINIC}}",$doctor_name,$msg);
      
      require_once("../phpmailer/PHPMailerAutoload.php");

              $mail = new PHPMailer();

         //   $email = $_GET['email'];

          $mailhost = "docconsult.in";
              $smtpUser = "mail@docconsult.in";
              $smtpPassword = "telekast@123";

           

           $name = "Doc Consult";

           $subject = "Appointment Confirmed";

           $from = "support@jprinfotech.com";

           



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

                $mail->AddAddress($doctor['email']);

                $mail->IsHTML(true);

                $mail->Subject = $subject;

                $mail->Body = '<div style="width:100%; height:100%; margin:0;" >'.$msg.'
                </div>';

             $mail->Send();      
            return true;
         
      }

      }
      $this->token_shuffle($date,$doc_id);
      return(TRUE);
   }














                        
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////doctor login signup api's ////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////    


















public function randomCodeNum($length) {

                    $key = '';

                    $keys = array_merge(range(0, 9));

                    for ($i = 0; $i < $length; $i++) {

                    $key .= $keys[array_rand($keys)];

                    }

                    return $key;

    }





public function check_existing_number($phone_no){
    
    echo $phone_no;
    $res = $this->db->query("SELECT * FROM doctors where phone_no = '$phone_no'");
    
    //return $res->num_rows;
    if($res->num_rows > 0){
        
        
     return TRUE;
        
    
        
    }

else {
    
    //$msg= "Phone no. doesn't exist in our records";
    return False;
}

}














public function signup_doc($tag,$spec,$name,$em,$phone,$city,$state,$country,$gen,$dob,$pass){
   
    $date_create = date("Y-m-d h:i:s");
    $result['date_create'] = date("Y-m-d h:i:s");

   
    $check = $this->db->query("select * from doctors where phone_no = '$phone'");
    $cat = $this->db->query("select id from category where category='$spec'");
    if($cat->num_rows>0){
        $cat_id = $cat->fetch_assoc();
        $cat=$cat_id['id'];
        $result['cat']=$cat_id['id'];

    }
    if($check->num_rows==0){
      
        
    $pass=sha1($pass);
    $specs[] = array("specialization"=>$spec); 
    $specs1 = json_encode($specs);


    $result['pass']=sha1($pass);
    $result[] = array("specialization"=>$spec); 
    $result['specs1'] = json_encode($specs);
    
    $type="doctor";
    $result['type']="doctor";
    
    if($gen == 'Male'){$doc_img = "Doctor_male.png";
    $result['doc_img'] = "Doctor_male.png";}elseif($gen == 'Female'){$doc_img = "Doctor_female.png";
    $result['doc_img'] = "Doctor_female.png";}
    
    
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



     $result['blog_pass']=md5($pass);
    $result['blog_date']=date("Y-m-d H:i:s");
   
    $result['id_blog']=$id_blog['ID'];
    $result['meta_value']='a:1:{s:6:"author";b:1;}';


   if($res1){
        
        
        return $result;
        }
   

}

}
}
}
$functions = new Functions();

?>