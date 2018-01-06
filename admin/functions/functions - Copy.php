    <?php
ob_start();
session_start();
require_once("config.php");

class Functions{

	public function __construct(){

		$connect=new Config();

		$this->db=$connect->connection();
		
		$connect_blog=new Config_blog();
    	$this->db_blog=$connect_blog->connection();
		date_default_timezone_set("Asia/Kolkata");
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

	public function start_session(){

		return session_start();

	}



public function get_welcome_doctor_data($id,$doctors){

     $id=$_SESSION['login_id'];
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

	public function find_trending_blogs(){
        $period=date("Ym");
        $period_last = $period - 1;
        //echo $period;
        $data = $this->db_blog->query("SELECT DISTINCT id FROM `wp1_post_views` where type='2' AND (period = '$period' OR period='$period_last') ORDER BY `count` DESC");
        //echo $data->num_rows;
        if($data->num_rows > 0)
        {
            $str='';
            $count=0;
            
            while($res=$data->fetch_assoc())
            {
            
                if($count<6){
                //echo $res['id'];
                $str.='<div class="row" style="margin-top:10px;width:100%">
			    <div class="col-sm-12">
			        <div class="row">
        			
        				<div style="float:left;margin-left:8%">
        					<a style="font-size: 1.1em;color:#333;text-decoration:none;" href="';
        					
        					
        	$id = $res['id'];				
        	$post_name = $this->db_blog->query("SELECT * FROM `wp1_posts` where ID = '$id'");
        	$post_name = $post_name->fetch_assoc();
        	$str.=$post_name['guid'];
        	$str.='">';
        	$str.=$post_name['post_title'];   
        	$author_id = $post_name['post_author'];
        	$author_name = $this->db_blog->query("SELECT * FROM `wp1_users` where ID = '$author_id'");
        	$author_name = $author_name->fetch_assoc();
        	
        	$str.='</a><br>
        					<p style="font-size: .7em;color: #828282;margin-top: 0.2em;" class="text-justify">';
        				//$str.=$res[''];
        				$str.=$author_name['display_name'];
        					$str.='</p>
        				</div>
        			</div>
        		</div>
			</div>';}
                $count = $count +1;
            }
            $str.='';
        }
        return $str;
    }
	
	
    public function find_trending_blogs_new($blog_user){
       
        $period=date("Ym");
        $period_last = $period - 1;
        //echo $period;
        
        $data = $this->db_blog->query("SELECT * FROM wp_posts where post_author='$blog_user'");

        if($data->num_rows > 0)
        {
            $str='';
            $count=0;
            
            while($res=$data->fetch_assoc())
            {
                
                
                 $post_title =  $res['post_title'];
                if($count<6){
                 $res['ID'];
                $str.='<div class="row" style="margin-top:10px;width:100%">
			    <div class="col-sm-12">
			        <div class="row">
        			
        				<div style="float:left;margin-left:8%">
        					<a style="font-size: 1.1em;color:#333;text-decoration:none;" href="';
        					
        					
         	$id = $res['ID'];				
          	$post_name = $this->db_blog->query("SELECT * FROM `wp_posts` where ID = '$id'");
         	$post_name = $post_name->fetch_assoc();
        	$str.='">';
         	
         	$str.='</br>';
         	$str.'<img src="'.$image_link['guid'].'" alt="blog-image" style="width:50px; height:50px;">';
         	$str.='</br>';
           	$str.=$post_name['post_title']; 
           	$str.='</br>';
           	$str.=$post_name['post_content'];
        
         	$image_link = $this->db_blog->query("SELECT * FROM `wp_posts` where ID = '$id'");
         	$image_link = $image_link->fetch_assoc();
         	$str.'<img src="'.$image_link['guid'].'" alt="blog-image" style="width:50px; height:50px;">';
        	$author_name = $this->db_blog->query("SELECT * FROM `wp_posts` where ID = '$id'");
         	$author_name = $author_name->fetch_assoc();
        	$str.='</a><br>
        					<p style="font-size: .7em;color: #828282;margin-top: 0.2em;" class="text-justify">';
        				//$str.=$res[''];
        				//$str.=$author_name['display_name'];
        					$str.='</p>
        				</div>
        			</div>
        		</div>
			</div>';}
                $count = $count +1;
            }
            $str.='';
        }
         $str;
        return $str;
    }
	public function randomCode($length) {

                    $key = '';

                    $keys = array_merge(range(0, 9), range('a', 'z'), range('A', 'Z'));



                    for ($i = 0; $i < $length; $i++) {

                    $key .= $keys[array_rand($keys)];

                    }

                    return $key;

    }
public function display_recent_appointment()
{
	$id=$_SESSION['login_id'];
	$res=$this->db->query("SELECT appointments.patient_name, appointments.id, appointments.patient_id, appointments.app_date, appointments.app_time, appointments.category, appointments.patient_type, clinic.name from appointments JOIN doctors ON appointments.doctor_id=doctors.id join clinic on clinic.id = appointments.clinic_id WHERE appointments.doctor_id = '$id' AND appointments.app_date < CURRENT_DATE AND appointments.status !='Cancel' ORDER BY appointments.app_date DESC");
	
	$rows = array();
	while($r = mysqli_fetch_array($res)){
		$rows[] = $r;
	}
	$res = json_encode($rows);
	return $res;	
}


public function checkLogin(){

	if(!@$_SESSION['admin_logged_in'])
	{

		header('Location: '.base_url_admin);

		die();

	}

}
public function display_call_requests()
{
	$id=$_SESSION['login_id'];
	$res=$this->db->query("SELECT * FROM `request_for_call` WHERE doctor_id = '$id' ORDER BY app_date");
	
	$rows = array();
	while($r = mysqli_fetch_array($res)){
		$rows[] = $r;
	}
	$res = json_encode($rows);
	return $res;	
}


public function prescription_print($patient_id){
    
    $doc_id=$_SESSION['login_id'];
    $res = $this->db->query("select date from prescription_patient where patient_id='$patient_id' and doctor_id='$doc_id' UNION select date from clinical_note where patient_id='$patient_id' and doctor_id='$doc_id' UNION select date from vital where patient_id='$patient_id' and doctor_id='$doc_id'");
     
    
    
    	$str='';
	$str=' <div class="col-sm-12 table-responsive" > <table id="treat_table" class="table patient-profile-tables table-striped " >
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        
                                        <th>Print</th>
                                        
                                    </tr>
                                </thead>
                                 <tbody>';
                                $count=1;
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
					$str.=' <tr>
                                        <td><input type="hidden" value='.$data['date'].'>'.date("j F Y",strtotime($data['date'])).'</td>
                                        
                                        
                                        
                                        	<td><a href="'.base_url_doc.'prescription.php?patient_id='.$patient_id.'&date='.$data['date'].'&doc_id='.$doc_id.'" target="_blank"><div class="patient-list-buttons glyphicon glyphicon-print"></div></a>
                                        	
                                        	
								 </td>
                                    </tr>';
                                    $count++ ;
		
		}	
	}
	else {
        $str.='<tr><td colspan="2">No Records Found To Show.</td></tr>';
    }
	$str.=' </tbody></table></div>';
	 return $str;
}





public function display_todays_income_by_doctor_id()
{
    $doc_id = $_SESSION['login_id'];
    $date = date("Y-m-d");
    $res = $this->db->query("select * from bill_info where date='$date' and doctor_id='$doc_id'");
    
    $income = 0;
    
    while($data = $res->fetch_assoc())
    {
        $income+= $data['total'];
    }
    return $income;
}
	public function doctor_login($username, $password)
	{
	    
	    $res=  $this->db->query("SELECT * FROM `doctors` where  `phone_no` = '$username' AND `password` = '$password' AND `type` = 'Doctor'");
   
   if($res->num_rows > 0){
            session_start();
       
            $data = $res->fetch_assoc();

            $_SESSION['login_success'] = TRUE;
            $_SESSION['name'] = $data['name']; 
            $_SESSION['login_id'] = $data['id'];
            $_SESSION['email'] = $data['email'];
            $_SESSION['profile_image'] = $data['image'];
            $_SESSION['last_login_timestamp'] = time();
            $_SESSION['doc_details'] = $data;
            return TRUE;
            //header('Location: '.base_url_doc.'calender.php');
            
          
   }
   else
   {
       return FALSE;
   }
	}


    public function getPatientName($pid)
{
    $res = $this->db->query("select * from patient where patient_id='$pid' or name='$pid'");
    if($res->num_rows > 0)
    {
        $data = $res->fetch_assoc();
        return $data['name'];
    }
}

public function get_doc_name() 
{
    $id = $_SESSION['login_id'];
    $res = $this->db->query("select * from doctors where id='$id'");
    
    if($res->num_rows>0)
    {
        $data = $res->fetch_assoc();
        return $data['name'];
    }
}

public function get_consult_time(){
    $id = $_SESSION['login_id'];
    $res = $this->db->query("select duration,consult from practice where doctor_id='$id' ");
    
    if($res->num_rows>0){
        return $res->fetch_assoc();
        
    }
}





public function admin_notifications()
{
	$id=$_SESSION['login_id'];
	$res=$this->db->query("select * from admin_notified where (type='Doctor' or type='') and (doctor_id='$id' or doctor_id='')");
	
	$rows = array();
	while($r = mysqli_fetch_array($res)){
		$rows[] = $r;
	}
	$res = json_encode($rows);
	return $res;	
}
	public function admin_login($username, $password){

		   $username = mysqli_real_escape_string($this->db, $username);

		   $password = mysqli_real_escape_string($this->db, $password);

		   $pass = sha1($password);

		   $res = $this->db->query("SELECT * FROM admin_user WHERE admin_uname='{$username}' AND admin_password='{$pass}'");

		   if($res->num_rows > 0){

			   $data = $res->fetch_assoc();

			   $_SESSION['admin_logged_in'] = TRUE;

			   $_SESSION['name'] = $data['admin_fname'];

			   $_SESSION['username'] = $data['admin_uname'];

			   header("Location: ".base_url_admin."dashboard/");

		   }

		   else {

			   return FALSE;

		   }

			   

	}
public function add_error($error,$title,$type)
{
	$doc_id=$_SESSION['login_id'];
	$res=$this->db->query("insert into error(error,title,doctor_id,type) values('$error','$title','$doc_id','$type')");
	if(@$res)
	{
		return TRUE;
	}
}

public function send_sms_to_group($group_id,$msg)
{
    $points=$this->getByDoctorId($_SESSION['login_id'],"points");
    $msg_count=$points['points'];
    //$msg_count=(int)$msg_count['points'];
    $doc_id=$_SESSION['login_id'];
    $res=$this->db->query("select * from groups where id='$group_id' and doctor_id='$doc_id'");
    $data=$res->fetch_assoc();
    $phone=$data['patient_id'];
    $ids=json_decode($phone);
    foreach($ids as $id)
    {
    $pdata=$this->db->query("select * from patient where patient_id='$id' and doctor_id='$doc_id'");
    $pdata=$pdata->fetch_assoc();
    $phone_no=$pdata['phone_no'];
    $pmsg='Hello '.$pdata['name'].' '.$msg;
    if($msg_count<0)
    {
        echo "<script> alert('You have reached your sms limit'); </script>";
        break;
    }
    $doctor=$this->getById($_SESSION['login_id'],"doctors");
		$name=$pdata['name'];
		$note=$msg;
		$msg_ar=$this->getByDoctorid_with_tmp($_SESSION['login_id'], "msg_tamplete","public");
		$msg=$msg_ar['msg'];
		$msg=str_replace("{{PATIENT}}",$name,$msg);
		$msg=str_replace("{{CLINIC}}",$note,$msg);
     //$send_sms_url = 'http://www.sms.jprinfotech.com/api/sendhttp.php?authkey=4296AbkgvkyLHP2b584bb4a2&mobiles='.$phone_no.'&message='.$msg.'&sender='.sender_id.'&route=4';
     
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
     $msg_count--;
     $pat=$pdata['id'];
     $date=date('Y-m-d');
     $this->db->query("INSERT INTO `sms` (`id`, `patient_id`, `message`, `doctor_id`, `date`, `status`, `groups`) VALUES (NULL,'$pat', '$msg', '$doc_id','$date', 'delivered', '$group_id')");
     
    }
    $in=$this->db->query("update points set points='$msg_count' where doctor_id='$doc_id'");
}
public function send_sms_to_area($area,$msg)
{
    $points=$this->getByDoctorId($_SESSION['login_id'],"points");
   $msg_count=$points['points'];
    //$msg_count=(int)$msg_count['points'];
    $doc_id=$_SESSION['login_id'];
    // $res=$this->db->query("select * from groups where id='$group_id' and doctor_id='$doc_id'");
    // $data=$res->fetch_assoc();
    // $phone=$data['patient_id'];
    // $ids=json_decode($phone);
    $que=$this->db->query("select name,phone_no from patient where area='$area' and doctor_id='$doc_id'");
    while($pdata=$que->fetch_assoc())
    {
    $phone_no=$pdata['phone_no'];
    $pmsg='Hello '.$pdata['name'].',\n'.$msg;
    if($msg_count<0)
    {
        echo "<script> alert('You have reached your sms limit'); </script>";
        break;
    }
    
    $doctor=$this->getById($_SESSION['login_id'],"doctors");
		$name=$pdata['name'];
		$note=$msg;
		$msg_ar=$this->getByDoctorid_with_tmp($_SESSION['login_id'], "msg_tamplete","public");
		$msg=$msg_ar['msg'];
		$msg=str_replace("{{PATIENT}}",$name,$msg);
		$msg=str_replace("{{CLINIC}}",$note,$msg);
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
     $pat=$pdata['id'];
     $date=date('Y-m-d');
     $msg_count--;
     $this->db->query("INSERT INTO `sms` (`id`, `patient_id`, `message`, `doctor_id`, `date`, `status`, `groups`) VALUES (NULL,'$pat', '$msg', '$doc_id','$date', 'delivered', '')");
     
     
    }
    $in=$this->db->query("update points set points='$msg_count' where doctor_id='$doc_id'");
}
public function send_sms_to_patient($patient_id,$msg)
{
   $points=$this->getByDoctorId($_SESSION['login_id'],"points");
    $msg_count=$points['points'];
    //$msg_count=(int)$msg_count['points'];
    $doc_id=$_SESSION['login_id'];
    // $res=$this->db->query("select * from groups where id='$group_id' and doctor_id='$doc_id'");
    // $data=$res->fetch_assoc();
    // $phone=$data['patient_id'];
    // $ids=json_decode($phone);
    $que=$this->db->query("select * from patient where id='$patient_id' and doctor_id='$doc_id'");
    $pdata=$que->fetch_assoc();
    

    $phone_no=$pdata['phone_no'];
    $pmsg='Hello '.$pdata['name'].','.$msg;
    $pmsg = str_replace(" ", "%20", $pmsg);
    if($msg_count<0)
    {
        echo "<script> alert('You have reached your sms limit'); </script>";
        return ;
        
    }
    //return $sms;
    
    $doctor=$this->getById($_SESSION['login_id'],"doctors");
		$name=$pdata['name'];
		$note=$msg;
		$msg_ar=$this->getByDoctorid_with_tmp($_SESSION['login_id'], "msg_tamplete","public");
		$msg=$msg_ar['msg'];
		$msg=str_replace("{{PATIENT}}",$name,$msg);
		$msg=str_replace("{{CLINIC}}",$note,$msg);
    
    
    
    
   // $send_sms_url = 'http://www.sms.jprinfotech.com/api/sendhttp.php?authkey=4296AbkgvkyLHP2b584bb4a2&mobiles='.$phone_no.'&message='.$msg.'&sender='.sender_id.'&route=4';
    
    $send_sms_url='http://login.cheapsmsbazaar.com/vendorsms/pushsms.aspx?user=docconsult&password=aks120109&msisdn='.$phone_no.'&sid='.sender_id.'&msg='.$msg.'&fl=0&gwid=2';
 
     
     $send_sms_url = str_replace(" ", "%20", $send_sms_url);
    
    
    
    ///////////
     
   
    //  $send_sms_url = 'http://www.sms.jprinfotech.com/api/sendhttp.php?authkey=4296AbkgvkyLHP2b584bb4a2&mobiles='.$phone_no.'&message='.$pmsg.'&sender='.sender_id.'&route=4';
    //  $send_sms_url = str_replace(" ", "%20", $send_sms_url);
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
     $msg_count--;
     $pat=$pdata['id'];
     $date=date('Y-m-d');
     
     $this->db->query("INSERT INTO `sms` (`id`, `patient_id`, `message`, `doctor_id`, `date`, `status`, `groups`) VALUES (NULL,'$pat', '$msg', '$doc_id','$date', 'delivered', '')");
     
    
     
    
     $in=$this->db->query("update points set points='$msg_count' where doctor_id='$doc_id'"); 
}
public function send_email_to_group($group_id, $doctor_msg)
{
    $doc_id=$_SESSION['login_id'];
	$doc_id = json_encode(array($doc_id));
	$res = $this->db->query("select * from patient where groups = '$group_id' and doctor_id = '$doc_id' ");
    $str = '';
 	if($res->num_rows > 0)
 	{
 		while($data = $res->fetch_assoc())
		{
			$email = $data['email'];
			$name = $data['name'];
		
			$msg = $this->email_header();
			
			$msg .= '<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: #f5f5fa; ">
						<tr>
							<td></td>
							<td class="header container">
								<div style="max-width: 630px;    margin: 0 auto;    display: block;">
									<table>
										<tr>
											<td>
											<br>
												<h3>Hello , '.$name.' </h3>
												<p class="lead">'.$doctor_msg.'</a></p>
											</td>
										</tr>
									</table>
								</div>			
							</td>
							<td></td>
						</tr>
					</table>';
			
			$msg .= $this->email_footer();
			
			$fromAdd = "service@docconsult.in";
			$subject = "Communication Email";
			$this->foremail($email,$msg,$fromAdd,$subject);
		} 		
 	}
}
public function send_email_to_area($area, $doctor_msg)
{
    $doc_id=$_SESSION['login_id'];
	$doc_id = json_encode(array($doc_id));
	$res = $this->db->query("select * from patient where area = '$area' and doctor_id = '$doc_id' ");
    $str = '';
 	if($res->num_rows > 0)
 	{
 		while($data = $res->fetch_assoc())
		{
			$email = $data['email'];
			$name = $data['name'];
		
			$msg = $this->email_header();
			
			$msg .= '<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: #f5f5fa; ">
						<tr>
							<td></td>
							<td class="header container">
								<div style="max-width: 630px;    margin: 0 auto;    display: block;">
									<table>
										<tr>
											<td>
											<br>
												<h3>Hello , '.$name.' </h3>
												<p class="lead">'.$doctor_msg.'</a></p>
											</td>
										</tr>
									</table>
								</div>			
							</td>
							<td></td>
						</tr>
					</table>';
			
			$msg .= $this->email_footer();
			
			$fromAdd = "service@docconsult.in";
			$subject = "Communication Email";
			$this->foremail($email,$msg,$fromAdd,$subject);
		} 		
 	}
}
public function send_email_to_patient($patient_id, $doctor_msg)
{
	$res = $this->db->query("select * from patient where patient_id='$patient_id' ");
    $str = '';
 	if($res->num_rows > 0)
 	{
 		$data = $res->fetch_assoc();
 		$email = $data['email'];
		$name = $data['name'];
 		
 	}
	$msg = $this->email_header();
	
	$msg .= '<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: #f5f5fa; ">
				<tr>
					<td></td>
					<td class="header container">
						<div style="max-width: 630px;    margin: 0 auto;    display: block;">
							<table>
								<tr>
									<td>
									<br>
										<h3>Hello , '.$name.' </h3>
										<p class="lead">'.$doctor_msg.'</a></p>
									</td>
								</tr>
							</table>
						</div>			
					</td>
					<td></td>
				</tr>
			</table>';
	
	$msg .= $this->email_footer();
	
	$fromAdd = "service@docconsult.in";
	$subject = "Communication Email";
	$this->foremail($email,$msg,$fromAdd,$subject);
}
public function email_header()
{
	$str = '<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: linear-gradient(to right, #2D9CDB, #2F5894);">
				<tr>
					<td></td>
					<td class="header container">
						
						<div style="max-width: 650px;    margin: 0 auto;    display: block;">
					<span style="width:50%;float:left"> <a href="'.base_url.'"><img style="height:70px" src="'.base_url_image.'logo.png" ></span></a>
						</div>
						
					</td>
					<td></td>
				</tr>
			</table>';
	return $str;		
}

public function email_footer()
{
	$str = '<table class="head-wrap"  style="width: 650px; margin: 0 auto; background: linear-gradient(to right, #2D9CDB, #2F5894);">
	<tr>
		<td></td>
		<td class="header container">
			
			<div style="max-width: 630px;    margin: 0 auto;    display: block;">
			<table>
				<tr>
					<td><a href="#"><img style="height:70px" src="'.base_url_image.'logo.png" ></a>
					<p style="  font-size: 12px;     margin: 2px 10px;  color:#fff;">Contact NO : <strong> 0141-2785199</strong></p>
					<p style="  font-size: 12px;      margin: 2px 10px;  color:#fff;">Email: <strong><a href="emailto:hseldon@trantor.com" style="color:#fff;">service@docconsult.in</a></strong></p>
					<p style="   font-size: 12px;     margin: 2px 10px;  color:#fff;">Copyright © 2017 DocConsult | All Right Reserved 2016</p>	</td>
					
					<td style="text-align: right;    width: 50%;">
					<p style="float: right; text-align: right; margin-right: 0px; margin-top: 60px;">
														<a href="https://www.facebook.com/docconsult/"><img src="'.base_url_image.'F.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a> 
														<a href="https://twitter.com/Docconsult12"><img src="'.base_url_image.'T.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a>
														<a href="https://www.youtube.com/channel/UCroHJE8lYtX3Wz9j233Dtwg"><img src="'.base_url_image.'Y.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a>
														<a href="https://www.instagram.com/docconsultservices/"><img src="'.base_url_image.'I.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a> 
														<a href="https://www.linkedin.com/in/docconsult-services-a70a72134/"><img src="'.base_url_image.'L.png" style=" margin-right: 5px; width: 18px; background: rgba(0, 0, 0, 0.36);  height: 18px; padding: 5px;"></a></br>
														</p></td>
				</tr>
			</table>
			</div>
			
		</td>
		<td></td>
	</tr>
</table>';
	return $str;		
}

public function display_patient_groups($id)
 {
 	$res = $this->db->query("select * from patient where patient_id='$id'");
    $str = '';
 	if($res->num_rows > 0)
 	{
 		$data = $res->fetch_assoc();

 		$data1 = $data['group_names'];

 		$data2 = json_decode($data1,TRUE);

 		foreach($data2 as $group)
 		{
 			echo $group;
 		}
 	}

 }
 
 public function add_to_group($id,$group_name)
 {
      $doc_id = $_SESSION['login_id'];
     $res = $this->db->query("select * from groups where name='$group_name' and doctor_id='$doc_id' ");
     
     
    
     if($res->num_rows > 0)
     {
         $data1 = $res->fetch_assoc();
         $groupid = $data1['id'];
     
         
         if(empty($data1['patient_id']))
         {
             $rows = array();
             
             $rows[0]=$id;
             
             $g = json_encode($rows);
             
             $res1 = $this->db->query("update groups set patient_id='$g' where id='$groupid' and doctor_id='$doc_id'");
         }
         else
         {
            $data = $data1['patient_id'];
            $data2 = json_decode($data,TRUE);
            $count=0;
            $c = 0;
            $data3 = array();
 		    foreach($data2 as $group)
 		    {
 		        
 			     $data3[$count]=$group;
 			     $count++;
 			     if($group==$id)
 			     { $c = 1; }
 		    }
 		    if($c==0)
 		    { $data3[$count] = $id; } 
 		    
 		    $g = json_encode($data3);
 		    $res1 = $this->db->query("update groups set patient_id='$g' where id='$groupid' and doctor_id='$doc_id'");
         }
     }
 }
 
 public function add_to_group_by_id($id,$group_id)
 {
      $doc_id = $_SESSION['login_id'];
     $res = $this->db->query("select * from groups where id='$group_id' and doctor_id='$doc_id' ");
     
     
    
     if($res->num_rows > 0)
     {
         $data1 = $res->fetch_assoc();
         $groupid = $data1['id'];
     
         
         if(empty($data1['patient_id']))
         {
             $rows = array();
             
             $rows[0]=$id;
             
             $g = json_encode($rows);
             
             $res1 = $this->db->query("update groups set patient_id='$g' where id='$groupid' and doctor_id='$doc_id'");
         }
         else
         {
            $data = $data1['patient_id'];
            $data2 = json_decode($data,TRUE);
            $count=0;
            $c = 0;
            $data3 = array();
 		    foreach($data2 as $group)
 		    {
 		        
 			     $data3[$count]=$group;
 			     $count++;
 			     if($group==$id)
 			     { $c = 1; }
 		    }
 		    if($c==0)
 		    { $data3[$count] = $id; } 
 		    
 		    $g = json_encode($data3);
 		    $res1 = $this->db->query("update groups set patient_id='$g' where id='$groupid' and doctor_id='$doc_id'");
         }
     }
 }
 
 


 
public function get_patient_detail_info_by_id($pid)
{
    $doc_id = $_SESSION['login_id'];
    $res = $this->db->query("select * from patient where patient_id='$pid'");
    
    $str = '';
    if($res-num_rows > 0)
    {
        $data = $res->fetch_assoc();
        $name = $data['name'];
        //echo $pid,$name;
        return $name;
        
    }
    
}
public function get_group_details($group_id)
{
    //echo $group_id;
    
    $doc_id = $_SESSION['login_id'];
    $res = $this->db->query("select * from groups where doctor_id='$doc_id' and id='$group_id'");
    
    $data = $res->fetch_assoc();
    $data1 = $data['patient_id'];
    $data2 = json_decode($data1, TRUE);
    
    $str = '';
    foreach($data2 as $pid)
    {
        //echo $pid;
        $name = $this->get_patient_detail_info_by_id($pid);
        //echo $name;
        
        $str.= '<div class="row">
                <input type="hidden" name="id[]" class="group-input col-sm-4" value="'.$pid.'">
                <input type="text" name="patient[]" class="group-input col-sm-4" value="'.$name.'"><span style="font-size:30px;cursor:pointer" class="col-sm-1 remove_field" >&times;</span>
                </div>';
    }
    return $str;
    
}

	public function getuserByname($username){

		$res = $this->db->query("SELECT * FROM `registration` WHERE uname='$username'");

		$str = '';

			if($res->num_rows > 0){

				return $res->fetch_assoc();

		}

	}
	
public function getQuestionById($id, $table){
	    //$id=$_SESSION['login_id'];
            
		$res = $this->db->query("SELECT * FROM `$table` WHERE `id`='{$id}'");

			if($res->num_rows > 0){

				return $res->fetch_assoc();

		}

	}
	
public function update_expense($expenses_name,$vendor,$date,$mode,$amount,$id)
	{
	    $doc_id=$_SESSION['login_id'];
	    $date1=date('Y-m-d');
	    $res = $this->db->query("update doctor_expenses set expense='$expenses_name',vendor='$vendor',date='$date',mode_of_payment='$mode',amount='$amount',stored_date='$date1' where id='$id' and doctor_id='$doc_id'");
	    if(@$res)
	    {
	        return TRUE;
	    }
	}

public function edit_doctor_patient_detail($name,$aadhaar,$email,$phone_no,$country,$city,$state,$area,$pincode,$address,$patient_id,$groups)	{
    
    $doc_id=$_SESSION['login_id'];
    
    $res = $this->db->query("update patient set name='$name', aadhaar_id='$aadhaar',email='$email',phone_no='$phone_no',country='$country',city='$city',state='$state',area='$area',pincode='$pincode',address='$address',group_names='$groups' where patient_id='$patient_id'");
    if($res)
        return TRUE;
    
}

public function display_todays_appointment()
{
	$id=$_SESSION['login_id'];
	$date = date("Y-m-d");
	$res=$this->db->query("SELECT appointments.id,appointments.clinic_id, appointments.patient_name, appointments.app_date, appointments.app_time, appointments.category, appointments.patient_id, appointments.patient_type, clinic.name,appointments.app_date as date_app from appointments JOIN doctors ON appointments.doctor_id=doctors.id join clinic on clinic.id=appointments.clinic_id WHERE appointments.doctor_id = '$id' and appointments.app_date = '$date' and appointments.status!='Cancel'");
	
	$rows = array();
	while($r = mysqli_fetch_array($res)){
	    $date = strtotime($r['app_date']);
	    $r['app_date'] = date("j F Y",$date);
	    
	    $r['cur_day'] = date("Y-m-d");
	    $r['cur_time'] = date("h:i A");
		$rows[] = $r;
		
	}
	
	$res = json_encode($rows);
	return $res;	
}
public function display_upcoming_appointment()
{
	$id=$_SESSION['login_id'];
	$date = date("Y-m-d");
	$res=$this->db->query("SELECT appointments.patient_name, appointments.patient_id, appointments.id, appointments.app_date, appointments.app_time, appointments.category, appointments.patient_type, clinic.name from appointments JOIN doctors ON appointments.doctor_id=doctors.id join clinic on clinic.id = appointments.clinic_id WHERE appointments.doctor_id = '$id' and appointments.app_date > '$date' AND appointments.status != 'Cancel' ORDER BY appointments.app_date");
	
	$rows = array();
	while($r = mysqli_fetch_array($res)){
		$date = strtotime($r['app_date']);
	    $r['app_date'] = date("j F Y",$date);
		$rows[] = $r;
	}
	$res = json_encode($rows);
	return $res;	
}
public function display_cancelled_appointment()
{
	$id=$_SESSION['login_id'];
	$res=$this->db->query("SELECT appointments.patient_name,  appointments.id, appointments.patient_id, appointments.remark, appointments.app_date, appointments.app_time, appointments.category, appointments.patient_type, clinic.name from appointments JOIN doctors ON appointments.doctor_id=doctors.id join clinic on clinic.id = appointments.clinic_id WHERE appointments.doctor_id = '$id' AND appointments.status ='Cancel' ORDER BY appointments.app_date DESC");
	
	$rows = array();
	while($r = mysqli_fetch_array($res)){
    	$date = strtotime($r['app_date']);
	    $r['app_date'] = date("j F Y",$date);
		$rows[] = $r;
	}
	$res = json_encode($rows);
	return $res;	
}
	public function getPatientByDoctorId($id){
	   	$id=$_SESSION['login_id'];
            
		$res = $this->db->query("SELECT * FROM patient WHERE `doctor_id`='$id'");

			if($res->num_rows > 0){

				return $res;

		}

	}
	public function get_invoice_data_by_id($id)
	{
	    //echo $id;
	    $data = $this->db->query("select * from bill_info where id='$id'");
	    if($data->num_rows > 0)
	    {   //echo "hi";
	        return $data->fetch_assoc();
	    }
	}
	public function getById($id, $table){
	   	//$id=$_SESSION['login_id'];
        
		$res = $this->db->query("SELECT * FROM `$table` WHERE `id`='{$id}'");
		//$res = $this->db->query("SELECT * FROM $table WHERE id='$id'");
		

			if($res->num_rows > 0){
			   // echo "right";

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

    public function getBycatg($category, $table){

        $res = $this->db->query("SELECT * FROM `$table` WHERE id='$category'");
 
        $str = '';

            if($res->num_rows > 0){

                return $res->fetch_assoc();

        }

    }
	public function getByClinicId($id, $table){

		$res = $this->db->query("SELECT * FROM `$table` WHERE clinic_id='{$id}'");
 
		$str = '';

			if($res->num_rows > 0){

				return $res->fetch_assoc();

		}

	}
	public function getByPatientId($id, $table){

		$res = $this->db->query("SELECT * FROM `$table` WHERE patient_id='$id'");
 
		$str = '';

			if($res->num_rows > 0){

				return $res->fetch_assoc();

		}

	}
	public function change_pass_admin($pass, $id) {

		if($res->num_rows > 0){

			$res_u = $this->db->query("UPDATE doctors SET password = '$pass' WHERE id='$id'");

			if($res_u){

				return TRUE;

			}

		}

	}
	

	public function deleteByIDuser($id, $user){

		$res = $this->db->query("DELETE FROM products_mf WHERE id= '$id' AND by_user = '$user'");

		if($res){
			

			return TRUE;

		}

	}
	public function add_homevisit_activity()
	{
		$active_name="Add home visit";
		$patient_id=0;
	$doc_id=$_SESSION['login_id'];
		$action='added';
		$date=date('Y-m-d');
	   $time=date("h:i");
		
		$res1=$this->db->query("insert into activity(name,patient_id,doctor_id,action,date,time) values('$active_name','$patient_id','$doc_id','$action','$date','$time') ");
		return TRUE;
	}
	public function add_education_activity()
	{
		$active_name="Add Education Tips";
		$patient_id=0;
	$doc_id=$_SESSION['login_id'];
		$action='added';
		$date=date('Y-m-d');
	   $time=date("h:i");
		
		$res1=$this->db->query("insert into activity(name,patient_id,doctor_id,action,date,time) values('$active_name','$patient_id','$doc_id','$action','$date','$time') ");
		return TRUE;
	}
	public function add_blog_activity()
	{
		$active_name="Add Blog";
		$patient_id=0;
	$doc_id=$_SESSION['login_id'];
		$action='added';
		$date=date('Y-m-d');
	   $time=date("h:i");
		
		$res1=$this->db->query("insert into activity(name,patient_id,doctor_id,action,date,time) values('$active_name','$patient_id','$doc_id','$action','$date','$time') ");
		return TRUE;
	}
	public function add_event_activity()
	{
		$active_name="Add Event";
		$patient_id=0;
	$doc_id=$_SESSION['login_id'];
		$action='added';
		$date=date('Y-m-d');
	   $time=date("h:i");
		
		$res1=$this->db->query("insert into activity(name,patient_id,doctor_id,action,date,time) values('$active_name','$patient_id','$doc_id','$action','$date','$time') ");
		return TRUE;
	}
	public function add_error_activity($type)
	{
		$active_name="Add $type";
		$patient_id=0;
	$doc_id=$_SESSION['login_id'];
		$action='added';
		$date=date('Y-m-d');
	   $time=date("h:i");
		
		$res1=$this->db->query("insert into activity(name,patient_id,doctor_id,action,date,time) values('$active_name','$patient_id','$doc_id','$action','$date','$time') ");
		return TRUE;
	}
	/*public function delete_error_activity($type){
		$active_name="Delete $type";
		$patient_id=0;
	$doc_id=$_SESSION['login_id'];
		$action='deleted';
		$date=date('Y-m-d');
	   $time=date("h:i");
		
		$res1=$this->db->query("insert into activity(name,patient_id,doctor_id,action,date,time) values('$active_name','$patient_id','$doc_id','$action','$date','$time') ");
		return TRUE;
	}*/

	public function delete_by_id($table, $id){

			$res = $this->db->query("DELETE FROM $table WHERE id= '$id'");

				if($res){
					$active_name="Delete $table ";
	
		$patient_id=0;
	$doc_id=$_SESSION['login_id'];
		$action='deleted';
		$date=date('Y-m-d');
	   $time=date("h:i");
		
		$res1=$this->db->query("insert into activity(name,patient_id,doctor_id,action,date,time) values('$active_name','$patient_id','$doc_id','$action','$date','$time') ");

				 return TRUE;

				}else {

				

				return FALSE;	

				}

	}

  public function getpageByname($name, $table){

		$res = $this->db->query("SELECT * FROM $table WHERE name='$name'");

		$str = '';

			if($res->num_rows > 0){

				return $res->fetch_assoc();

			}

	}

/*public function foremail($email,$days)
		{

			$data=$this->getByproemail($email,"orders");

			require_once("phpmailer/PHPMailerAutoload.php");

              $mail = new PHPMailer();

			//   $email = $_GET['email'];

			 $mailhost = "docconsult.in";
              $smtpUser = "mail@docconsult.in";
              $smtpPassword = "telekast@123";

			  

			  $name = "JPR Infotech";

			  $subject = "Consolidated Renewal Reminder | JPR Infotech";

			  $from = "support@jprinfotech.com";

			  



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

                $mail->Body = '<div style="width:100%; height:100%; margin:0;" >

	<div style="background-color:#e9e9e9; width:90%; float:left; height:70px;padding:30px;">

		<span style="width:50%;float:left"> <img src="http://jprinfotech.com/images/logo1.png" /></span>

		<span style="width:50%; text-align:right;float:left;font-size: 17px;"> 24/7 Support:<b> +91-8875555667</b> <br /><b>Customer Name : </b>'. $data["name"].'</span>

	</div>

	<div style="font-size:50px;width:90%;float:left;margin-top:20px;padding-left:26px;"> Your Website(s) will expire in '.$days.' days</div>

	<div  style="font-size:16px;width:90%;float:left;margin-top:20px;padding-left:26px;padding-bottom: 20px; color: #333333;line-height: 22px;" >

Log in today and renew your item(s) before 10 February 2016 to avoid interruption to your services. The following domain(s) will expire in just '.$days.' days:

<br>

	</div>

	<div style="background-color:#76bb2b;width:90%;height:100%; float:left;padding:30px;margin-top:10">

	 <br>

	<span style="background-color:#fff;color:#000;width:100%;height:50%;float:left;margin-top:28px;padding-bottom: 18px; padding-top: 18px;font-size: 17px;">&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;<a href="'.$data["domain_name"].'" target="_blank"  style=" text-decoration:none" >'. $data["domain_name"].' </a> (Domain + Web Hosting)<br><br /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

Registered On : '. $data["registration_date"].'<br />

<br /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

Expiring On : '.$data["expire_date"].'<br />

	</span>

	<a href="'.$data["payment_link"].'" target="_blank"><span style="background-color:#FF8000;color:#fff;width:37%;padding:21px; border-bottom:outset 7px #FF8000;float:left; font-weight:bold; text-align:center; font-size:21px;margin-top:28px; ">  RENEW NOW</span></a>

</div>

<div style="background-color:#e9e9e9; width:90%; float:left; height:17px;padding:30px;margin-top: 10px;"> <center>Copyright &copy; 2010-2016 JPR Infotech Company. All rights reserved.</center></div>

</div>

';

			$mail->Send();
}*/
public function check_patient_existence($pid)
{
    $res = $this->db->query("select * from patient where patient_id='$pid'");
    if($res->num_rows > 0)
        return TRUE;
    else
        return FALSE;
}
public function get_doctors($pid)
{
    /*echo "<script>alert('.$pid.');</script>";*/
    $res = $this->db->query("select * from patient where patient_id='$pid'");
    if($res->num_rows > 0)
    return $res->fetch_assoc();
}
public function check_if_exist($array,$id)
{
    //$array = json_decode($array, TRUE);
    $count = count($array);
    
    for($i = 0; $i<$count; $i++)
    {
        if($array[$i]==$id)
            return TRUE;
    }
    return FALSE;
}
public function add_patient($name,$email,$phone_no,$address,$city,$state,$pincode,$country,$doctor_id,$gender,$dob,$aadhar_id,$area,$patient,$age,$image,$group)
{
	/*echo "<script>alert('i m in');</script>";*/
	$date=date('Y-m-d');
	
      if(empty($image))
      {
        if($gender=="Male"){
            //$image='default_patient_male_3.png';
            if($patient%2==0){
               $image='default_patient_male_3.png'; 
            }
            elseif($patient%2==1){
               $image='default_patient_male_4.png'; 
            }
            
        }
        elseif($gender==='Female'){
            // $image='default_patient_male_3.png';
            if($patient%2==0){
               $image='default_patient_female_1.jpg'; 
            }
            elseif($patient%2==1){
               $image='default_patient_female_6.png'; 
            }
        }
        
	  }
	  
	  $res1 = $this->check_patient_existence($patient);
	  if(!$res1){
	      /*echo "<script>alert('i am here');</script>";*/
	      $d = array();
	      $d[0] = $doctor_id;
	      $doctor_id = json_encode($d);
	$res=$this->db->query("insert into patient(name,email,phone_no,address,city,state,pincode,country,status,doctor_id,date,gender,dob,aadhaar_id,area,patient_id,age,image,group_names) values('$name','$email','$phone_no','$address','$city','$state','$pincode','$country','Complete','$doctor_id','$date','$gender','$dob','$aadhar_id','$area','$patient','$age','$image','$group')");
	  }
	  else
	  {
	      /*echo "<script>alert('hello');</script>";*/
	      $res2 =$this->get_doctors($patient);
	      $doctorarray = json_decode($res2['doctor_id'],TRUE);
	      $count = count($doctorarray);
	      if($count==0)
	      {$doctorarray[0]=$doctor_id;
	      $doctor_id = json_encode($doctorarray);
	          $res = $this->db->query("update patient set doctor_id='$doctor_id' where patient_id='$patient'");
	      }
	      else
	      {
	          $count++;
	          if(!$this->check_if_exist($doctorarray,$_SESSION['login_id'])){
	          $doctorarray[$count]=$_SESSION['login_id'];
	          $doctor_id = json_encode($doctorarray);
	          
	            $res = $this->db->query("update patient set doctor_id='$doctor_id' where patient_id='$patient'");
	      }}
	  }
	  $docid=$_SESSION['login_id'];
	  $res3 = $this->db->query("select * from doctors where id='$docid'");
	  $data3 = $res3->fetch_assoc();
	  
	  if(empty($data3['patients_added']))
	  {
	      $p = array();
	      $p[0] = $patient;
	      $p = json_encode($p);
	      $r1 = $this->db->query("update doctors set patients_added='$p' where id='$docid'");
	      
	  }
	  else
	  {
	      $p = json_decode($data3['patients_added'],TRUE);
	      
	      $count = count($p);
	     
	      if($count==0)
	      {
	         $p[0]=$patient;
	      }
	      else
	      {
	          $count++;
	          $p[$count] = $patient;
	      }
	       if(!$this->check_if_exist($p,$patient)){
	      $p = json_encode($p);
	      
	        $r1 = $this->db->query("update doctors set patients_added='$p' where id='$docid'");
	  }}
	if(@$res)
	{
		 
		$active_name="Add Patient";
		$res1=$this->db->query("select * from patient where doctor_id='$doctor_id' order by id DESC limit 1");
		$data=$res1->fetch_assoc();
		$patient_id=$name;
		$doc_id=$doctor_id;
		$action='added';
		$date=date('Y-m-d');
	   $time=date("h:i");
		
		
		$res1=$this->db->query("insert into activity(name,patient_id,doctor_id,action,date,time) values('$active_name','$patient_id','$doc_id','$action','$date','$time') ");
		return TRUE;
	}
	else
	{
		return true;
	}
	
}

public function compress($source, $destination, $quality) {

		$info = getimagesize($source);

		if ($info['mime'] == 'image/jpeg') 
			$image = imagecreatefromjpeg($source);

		elseif ($info['mime'] == 'image/gif') 
			$image = imagecreatefromgif($source);

		elseif ($info['mime'] == 'image/png') 
			$image = imagecreatefrompng($source);

		imagejpeg($image, $destination, $quality);

		return $destination;
	}
	
public function display_all_time_patient()
{
    $id=$_SESSION['login_id'];
    $res = $this->db->query("select name from patient where doctor_id='$id'");
    if($res->num_rows > 0)
    {
        return $res->num_rows;
    }
    else
    {
        return 0;
    }
}


public function edit_img($img,$patient_id){
    
    $res = $this->db->query("update patient set image='$img' where patient_id='$patient_id' ");
    
    if($res){
        
        return TRUE;
    }
}

public function display_patient()
{
	$id=$_SESSION['login_id'];
	$res=$this->db->query("select * from doctors where id='$id'");
	$data = $res->fetch_assoc();
	$doctors_patient = json_decode($data['patients_added'],TRUE);
	
	$rows = array();
	foreach($doctors_patient as $id)
	{
	    $rows[] = $this->getByPatientId($id,"patient");
	}
	

	$res = json_encode($rows);
	return $res;
	
}
public function getstates()
{
    $result = $this->db->query("SELECT * FROM state_name");
		while($row=mysqli_fetch_assoc($result)) {
			$resultset[] = $row;
		}		
		if(!empty($resultset))
			return $resultset;
}

public function get_procedures()
{
	$id=$_SESSION['login_id'];
	$res=$this->db->query("select * from procedure_catalog where doctor_id='$id'");
	
	$rows = array();
	while($r = mysqli_fetch_array($res)){
		$rows[] = $r;
	}
	$res = json_encode($rows);
	return $res;
}

public function getdistrict($query)
{
    $result = $this->db->query($query);
		while($row=mysqli_fetch_assoc($result)) {
			$resultset[] = $row; 
		}		
		if(!empty($resultset))
			return $resultset;
}
public function display_patient1($id)
{
	$res1=$this->db->query("select * from appointments where doctor_id='$id'");
	$data1=$res1->fetch_assoc();
	$str='';
	$res=$this->db->query("select * from patient where email='".$data1['patient_email']."'");
	$str='  <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>Patient Image</th>
                                        <th>Name</th>
                                         <th>Phone No</th>
                                        <th>Area, City</th>
                                        <th>Age</th>
                                         <th>Gender</th>
                                         <th>Patient ID</th>
                                         <th>Action</th>
                                    </tr>
                                </thead>
                                 <tbody>';
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
			$area = $this->getById($data['area'], 'area');
			$str.=' <tr>
                                        <td><img src="'.base_url.'image/'.$data['image'].'" width="60" height="60"></td>
                                        <td>'.$data['name'].'</td>
                                        <td>'.$data['phone_no'].'</td>
                                        <td>'.$area['name'].', '.$data['city'].'</td>
                                        <td>'.$data['age'].'</td>
                                        <td>'.$data['gender'].'</td>
                                        <td>'.$data['patient_id'].'</td>
                                        <td><a href="'.base_url_doc.'patient/?display='.$data['id'].'" class="btn btn-info"><i class="material-icons">account_circle</i></a>
								 </td>
                                    </tr>
                                   ';
		
		}	
	}
	$str.=' </tbody></table>';
	 return $str;
}
 public function update_gallery_hospi($id, $images_array,$video){
	  
	  $res = $this->db->query("UPDATE doctors SET benner = '$images_array',video_url='$video' WHERE id = '$id'");
	  if($res){
		return TRUE;
	}
	else{
		return FALSE;
	}
  }
  public function insert_update_clinic_gallery($id, $images_array,$video){
	  
	$res = $this->db->query("UPDATE clinic SET benner = '$images_array', video_url='$video' WHERE id = '$id'");
	  if($res){
		return TRUE;
	}
	else{
		return FALSE;
	}
  }
  public function update_gallery_hospi_video($id,$video){
	  
	  $res = $this->db->query("UPDATE doctors SET video_url='$video' WHERE id = '$id'");
	  if($res){
		return TRUE;
	}
	else{
		return FALSE;
	}
  }
   public function update_gallery_hospi_images($id, $images_array){
	  
	  $res = $this->db->query("UPDATE doctors SET benner = '$images_array' WHERE id = '$id'");
	  if($res){
		return TRUE;
	}
	else{
		return FALSE;
	}
  }
   public function remove_gallery_image1($img_id, $gal, $img_arr)
   {
        $Path = '../image/gallery/'.$gal[$img_arr];
	    unlink($Path);  
        unset($gal[$img_arr]);
        $gal1 = array_values($gal);
        $gal2 = implode(",", $gal);
        $res = $this->db->query("UPDATE doctors SET benner = '$gal2' WHERE id = '$img_id'");
        if($res){
            return TRUE;
        }
        else{
            return FALSE;
        }
  }
public function display_appointment_by_doctor($id)
{
	$res=$this->db->query("select * from appointments where doctor_id='$id' and status ='Active'");
	$str='';
	
	$str=' <form method="post"> <div style="clear:both;margin-top:10px"></div>  <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>Select </th>
                                        <th>Patient Name</th>
                                        <th>Clinic</th>
                                         <th>Appointment Date</th>
                                        <th>Appointment Time</th>
                                        
                                        <th>Submitted By</th>
                                        <th>Patient Type</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                 <tbody>';
                                 $count=0;
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
			$clinic=$this->getById($data['clinic_id'],"clinic");
			
			$count++;
			$str.=' <tr>
                                        <td><div class="demo-checkbox">
                               
                                <input type="radio" id="md_checkbox_'.$count.'" class="chk-col-pink" name="cancel[]" value="'.$data['id'].'" >
                                <label for="md_checkbox_'.$count.'"></label>
                                
                            </div></td> 
                                        <td>'.$data['patient_name'].'</td>
                                        <td>'.$clinic['name'].'</td>
                                        <td>'.$data['app_date'].'</td>
                                        <td>'.$data['app_time'].'</td>
                                        <td>'.$data['category'].'</td>
                                         <td>'.$data['patient_type'].'</td>
                                       <td><input class="btn btn-primary waves-effect" name="cancel_appointment" type="submit" value="Cancel"></td>
                                        <td><a href="'.base_url_doc.'patient-detail/?display_appoint='.$data['id'].'&patient_id='.$_GET['patient_id'].'" class="btn btn-info"><i class="material-icons">account_circle</i></a>
								 </td>
                                    </tr>
                                   ';
		
		}	
	}
	$str.=' </tbody></table>';
	 return $str;
}
public function display_appointment($id)
{
	$res=$this->db->query("select * from appointments where patient_id='$id' and status!='Cancel'");
	$str='';
	
	$str=' <form method="post">   <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>Select </th>
                                        <th>Patient Name</th>
                                        <th>Patient Email</th>
                                         <th>Appointment Date</th>
                                        <th>Appointment Time</th>
                                        
                                        <th>Submitted By</th>
                                        <th>Patient Type</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                 <tbody>';
                                 $count=0;
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
			
			$count++;
			$str.=' <tr>
                                        <td><div class="demo-checkbox">
                               
                                <input type="radio" id="md_checkbox_'.$count.'" class="chk-col-pink" name="cancel[]" value="'.$data['id'].'" >
                                <label for="md_checkbox_'.$count.'"></label>
                                
                            </div></td> 
                                        <td>'.$data['patient_name'].'</td>
                                        <td>'.$data['patient_email'].'</td>
                                        <td>'.$data['app_date'].'</td>
                                        <td>'.$data['app_time'].'</td>
                                        <td>'.$data['category'].'</td>
                                        <td>'.$data['patient_type'].'</td>
                                        <td><input class="btn btn-primary waves-effect" name="cancel_appointment" type="submit" value="Cancel"></td>
                                        <td><a href="'.base_url_doc.'patient-detail/?display_appoint='.$data['id'].'&patient_id='.$_GET['patient_id'].'" class="btn btn-info"><i class="material-icons">account_circle</i></a>
								 </td>
                                    </tr>
                                   ';
		
		}	
	}
	$str.=' </tbody></table>';
	 return $str;
}
public function display_call_by_doctor($id)
{
	$res=$this->db->query("select * from call_appointments where doctor_id='$id' and status!='Cancel'");
	$str='';
	
	$str=' <div style="clear:both;margin-top:10px"></div>  <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                       
                                        <th>Patient Name</th>
                                      
                                         <th>Request For Date</th>
                                         <th>Phone No</th>
                                         <th>Location</th>
                                         <th>Symptoms</th>
                                       
                                        
                                        <th>Submitted By</th>
                                        <th>Patient Type</th>
                                       
                                    </tr>
                                </thead>
                                 <tbody>';
                                 $count=0;
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
			$clinic=$this->getById($data['clinic_id'],"clinic");
			
			$count++;
			$str.=' <tr> 
                                        <td>'.$data['patient_name'].'</td>
                                       
                                        <td>'.$data['app_date'].'</td>
                                        <td>'.$data['phone_no'].'</td>
                                        <td>'.$data['area'].'</td>
                                        <td>'.$data['query'].'</td>
                                       
                                        <td>'.$data['category'].'</td>
                                         <td>'.$data['patient_type'].'</td>
                                       
                                       
                                    </tr>
                                   ';
		
		}	
	}
	$str.=' </tbody></table>';
	 return $str;
}


public function display_call_appointment($id)
{
	$res=$this->db->query("select * from call_appointments where patient_id='$id' and status!='Cancel'");
	$str='';
	
	$str=' <div style="clear:both;margin-top:10px"></div>  <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                       
                                        <th>Patient Name</th>
                                      
                                         <th>Request For Date</th>
                                         <th>Phone No</th>
                                         <th>Location</th>
                                         <th>Symptoms</th>
                                       
                                        
                                        <th>Submitted By</th>
                                        <th>Patient Type</th>
                                       
                                    </tr>
                                </thead>
                                 <tbody>';
                                 $count=0;
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
			$clinic=$this->getById($data['clinic_id'],"clinic");
			
			$count++;
			$str.=' <tr> 
                                        <td>'.$data['patient_name'].'</td>
                                       
                                        <td>'.$data['app_date'].'</td>
                                        <td>'.$data['phone_no'].'</td>
                                        <td>'.$data['area'].'</td>
                                        <td>'.$data['query'].'</td>
                                       
                                        <td>'.$data['category'].'</td>
                                         <td>'.$data['patient_type'].'</td>
                                       
                                       
                                    </tr>
                                   ';
		
		}	
	}
	$str.=' </tbody></table>';
	 return $str;
}
public function edit_patient($name,$email,$phone_no,$address,$city,$state,$pincode,$doctor_id,$gender,$dob,$aadhar_id,$referrer,$medical_history,$area,$groups,$patient,$telephone,$age,$new_area,$new_groups,$new_medical_history,$refer,$image,$id)
{
		
		if(!empty($new_area))
	{
		$res1=$this->db->query("select * from area where name='$new_area'");
	$data=$res1->fetch_assoc();
       $area=$data['id'];
	}
	if(!empty($new_medical_history))
	{
       
       $res2=$this->db->query("select * from medical_history where name='$new_medical_history'");
      
	  $data1=$res2->fetch_assoc();
      $medical_history=$data1['id'];
      }
     if(!empty($new_groups))
	  { 
       $res3=$this->db->query("select * from groups where name='$new_groups'");
	$data2=$res3->fetch_assoc();
       $groups=$data2['id'];
      }
     if(!empty($new_refer))
	  {
    $res4=$this->db->query("select * from referrer where name='$refer'");
	$data3=$res4->fetch_assoc();
       $referrer=$data3['id'];
      }
     
	$res=$this->db->query("update  patient set name='$name',email='$email',phone_no='$phone_no',address='$address',city='$city',state='$state',pincode='$pincode',gender='$gender',dob='$dob',aadhaar_id='$aadhar_id',referrer='$referrer',medical_history='$medical_history',area='$area',groups='$groups',patient_id='$patient',telephone='$telephone',age='$age',image='$image' where id='$id'");
	if(@$res)
	{
		$active_name="Update Patient";
		$res1=$this->db->query("select * from patient where id='$id' order by id DESC limit 1");
		$data=$res1->fetch_assoc();
		$patient_id=$data['name'];
		$doc_id=@$_SESSION['login_id'];
		$action='edited';
		$date=date('Y-m-d');
	   $time=date("h:i");
		
		$res1=$this->db->query("insert into activity(name,patient_id,doctor_id,action,date,time) values('$active_name','$patient_id','$doc_id','$action','$date','$time') ");
		return true;
	}
}
public function edit_patient1($name,$email,$phone_no,$address,$city,$state,$pincode,$doctor_id,$gender,$dob,$aadhar_id,$referrer,$medical_history,$area,$groups,$patient,$telephone,$age,$new_area,$new_groups,$new_medical_history,$refer,$image,$id)
{
		
		if(!empty($new_area))
	{
		$res1=$this->db->query("select * from area where name='$new_area'");
	$data=$res1->fetch_assoc();
       $area=$data['id'];
	}
	if(!empty($new_medical_history))
	{
       
       $res2=$this->db->query("select * from medical_history where name='$new_medical_history'");
      
	  $data1=$res2->fetch_assoc();
      $medical_history=$data1['id'];
      }
     if(!empty($new_groups))
	  { 
       $res3=$this->db->query("select * from groups where name='$new_groups'");
	$data2=$res3->fetch_assoc();
       $groups=$data2['id'];
      }
     if(!empty($new_refer))
	  {
    $res4=$this->db->query("select * from referrer where name='$refer'");
	$data3=$res4->fetch_assoc();
       $referrer=$data3['id'];
      }
     
	$res=$this->db->query("update  patient set name='$name',email='$email',phone_no='$phone_no',address='$address',city='$city',state='$state',pincode='$pincode',gender='$gender',dob='$dob',aadhaar_id='$aadhar_id',referrer='$referrer',medical_history='$medical_history',area='$area',groups='$groups',patient_id='$patient',telephone='$telephone',age='$age',image='$image' where id='$id'");
	if(@$res)
	{
		$active_name="Update Patient";
		$res1=$this->db->query("select * from patient where id='$id' order by id DESC limit 1");
		$data=$res1->fetch_assoc();
		$patient_id=$data['name'];
		$doc_id=@$_SESSION['login_id'];
		$action='edited';
		$date=date('Y-m-d');
	   $time=date("h:i");
		
		$res1=$this->db->query("insert into activity(name,patient_id,doctor_id,action,date,time) values('$active_name','$patient_id','$doc_id','$action','$date','$time') ");
		
	}
	return true;
}
public function edit_appointment($name,$email,$date,$notify,$time,$id,$phone,$patient_id1)
{
	
	//$res=$this->db->query("update appointments set patient_name='$name',patient_email='$email',app_date='$date',app_time='$time',patient_id='$patient_id1',phone_no='$phone' where id='$id'");
    $doc_id=$_SESSION['login_id'];
	$res=$this->db->query("update appointments set patient_name='$name',patient_email='$email',app_date='$date',app_time='$time',patient_id='$patient_id1',phone_no='$phone' where id='$id';");
    //echo $id;
    $reschedule=$this->db->query("UPDATE `token` SET app_date='$date',app_time='$time',patient_name='$name' where app_id='$id';");
    if($this->db->query("SET @i=0;") && $this->db->query("UPDATE `token` SET token_no = @i:=@i+1 WHERE app_date='$date' and doctor_id='$doc_id' and status!='Cancel'  ORDER BY app_time;") )
    {
        $ii=0;
    }
	if(@$res)
	{
		$active_name="Update appointment";
		$res1=$this->db->query("select * from appointments where id='$id' order by id DESC limit 1");
		$data=$res1->fetch_assoc();
		$patient_id=0;
		$doc_id=$_SESSION['login_id'];
		$action='edited';
		$date=date('Y-m-d');
	   $time=date("h:i");
		$res1=$this->db->query("insert into activity(name,patient_id,doctor_id,action,date,time) values('$active_name','$patient_id','$doc_id','$action','$date','$time') ");
		if($notify=='sms')
		{
		    
			$doctor=$this->getById($_SESSION['login_id'],"doctors");
		$doctor_name=$doctor['name'];
		$msg_ar=$this->getByDoctorid_with_tmp($_SESSION['login_id'], "msg_tamplete","appointment");
		$msg=$msg_ar['msg'];
		$msg=str_replace("{{PATIENT}}",$name,$msg);
		$msg=str_replace("{{CLINIC}}",$doctor_name,$msg);
		
		
		
     //$send_sms_url = 'http://www.sms.jprinfotech.com/api/sendhttp.php?authkey=4296AbkgvkyLHP2b584bb4a2&mobiles='.$phone.'&message='.$msg.'&sender='.sender_id.'&route=4';
     $send_sms_url='http://login.cheapsmsbazaar.com/vendorsms/pushsms.aspx?user=docconsult&password=aks120109&msisdn='.$phone.'&sid='.sender_id.'&msg='.$msg.'&fl=0&gwid=2';

     

     
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
		else
		{
				require_once("../phpmailer/PHPMailerAutoload.php");
              $mail = new PHPMailer();
			//   $email = $_GET['email'];
			 $mailhost = "docconsult.in";
              $smtpUser = "mail@docconsult.in";
              $smtpPassword = "telekast@123";
			   $name = "JPR Infotech";
			  $subject = "Consolidated Renewal Reminder | JPR Infotech";
			  $from = "support@jprinfotech.com";
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
                $mail->Body = '<div style="width:100%; height:100%; margin:0;" >
	<div style="background-color:#e9e9e9; width:90%; float:left; height:70px;padding:30px;">
		<span style="width:50%;float:left"> <img src="http://jprinfotech.com/images/logo1.png" /></span>
		<span style="width:50%; text-align:right;float:left;font-size: 17px;"> 24/7 Support:<b> +91-8875555667</b> <br /><b>Customer Name : </b>'. $data["name"].'</span>
	</div>
	<div style="font-size:50px;width:90%;float:left;margin-top:20px;padding-left:26px;"> Your Website(s) will expire in '.$days.' days</div>
	<div  style="font-size:16px;width:90%;float:left;margin-top:20px;padding-left:26px;padding-bottom: 20px; color: #333333;line-height: 22px;" >
Log in today and renew your item(s) before 10 February 2016 to avoid interruption to your services. The following domain(s) will expire in just '.$days.' days:

<br>
	</div>
	<div style="background-color:#76bb2b;width:90%;height:100%; float:left;padding:30px;margin-top:10">
	 <br>
	<span style="background-color:#fff;color:#000;width:100%;height:50%;float:left;margin-top:28px;padding-bottom: 18px; padding-top: 18px;font-size: 17px;">&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;<a href="'.$data["domain_name"].'" target="_blank"  style=" text-decoration:none" >'. $data["domain_name"].' </a> (Domain + Web Hosting)<br><br /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

Registered On : '. $data["registration_date"].'<br />

<br /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

Expiring On : '.$data["expire_date"].'<br />

	</span>

	<a href="'.$data["payment_link"].'" target="_blank"><span style="background-color:#FF8000;color:#fff;width:37%;padding:21px; border-bottom:outset 7px #FF8000;float:left; font-weight:bold; text-align:center; font-size:21px;margin-top:28px; ">  RENEW NOW</span></a>

</div>

<div style="background-color:#e9e9e9; width:90%; float:left; height:17px;padding:30px;margin-top: 10px;"> <center>Copyright &copy; 2010-2016 JPR Infotech Company. All rights reserved.</center></div>

</div>

';
			$mail->Send();
			
		}
		return TRUE;
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
public function add_appointment($name,$email,$date,$notify,$time,$prescription,$id,$notify_doctor,$patient_id1,$phone_no,$clinic_name)
{
	$doc_id=$_SESSION['login_id'];
	
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
			$doctor=$this->getById($_SESSION['login_id'],"doctors");
		$doctor_name=$doctor['name'];
		$msg_ar=$this->getByDoctorid_with_tmp($_SESSION['login_id'], "msg_tamplete","appointment");
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
			$doctor=$this->getById($_SESSION['login_id'],"doctors");
		$doctor_name=$doctor['name'];
		$msg_ar=$this->getByDoctorid($_SESSION['login_id'], "msg_tamplete");
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
			$doctor=$this->getById($_SESSION['login_id'],"doctors");
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
				$doctor=$this->getById($_SESSION['login_id'],"doctors");
		$doctor_name=$doctor['name'];
		$msg_ar=$this->getByDoctorid($_SESSION['login_id'], "msg_tamplete");
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

public function patient_vital($id)
{
	$res=$this->db->query("select * from patient where doctor_id='$id'");
	$str='';
	$str='  <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>Patient Image</th>
                                        <th>Name</th>
                                         <th>Phone No</th>
                                        <th>Area, City</th>
                                        <th>Age</th>
                                         <th>Gender</th>
                                         <th>Patient ID</th>
                                         <th>Action</th>
                                    </tr>
                                </thead>
                                 <tbody>';
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
			$area = $this->getById($data['area'], 'area');
			$str.=' <tr>
                                        <td><img src="'.base_url.'image/'.$data['image'].'" width="60" height="60"></td>
                                        <td>'.$data['name'].'</td>
                                        <td>'.$data['phone_no'].'</td>
                                        <td>'.$area['name'].', '.$data['city'].'</td>
                                        <td>'.$data['age'].'</td>
                                        <td>'.$data['gender'].'</td>
                                        <td>'.$data['patient_id'].'</td>
                                        <td><a href="'.base_url_doc.'patient-detail/?vital='.$data['id'].'&patient_id='.$data['id'].'" class="btn btn-info"><i class="material-icons">add</i></a>
								 </td>
                                    </tr>
                                   ';
		
		}	
	}
	$str.=' </tbody></table>';
	 return $str;
}


 
public function patient_vital_display($id)
{
	$res=$this->db->query("select * from patient where doctor_id='$id'");
	$str='';
	$str='  <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>Patient Image</th>
                                        <th>Name</th>
                                         <th>Phone No</th>
                                        <th>Area, City</th>
                                        <th>Age</th>
                                         <th>Gender</th>
                                         <th>Patient ID</th>
                                         <th>Action</th>
                                    </tr>
                                </thead>
                                 <tbody>';
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
			$area = $this->getById($data['area'], 'area');
			$str.=' <tr>
                                        <td><img src="'.base_url.'image/'.$data['image'].'" width="60" height="60"></td>
                                        <td>'.$data['name'].'</td>
                                        <td>'.$data['phone_no'].'</td>
                                        <td>'.$area['name'].', '.$data['city'].'</td>
                                        <td>'.$data['age'].'</td>
                                        <td>'.$data['gender'].'</td>
                                        <td>'.$data['patient_id'].'</td>
                                        <td><a href="'.base_url_doc.'patient-detail/?vital_display='.$data['id'].'&patient_id='.$data['id'].'" class="btn btn-info">
                                        <i class="material-icons">add</i></a>
								 </td>
                                    </tr>
                                   ';
		
		}	
	}
	$str.=' </tbody></table>';
	 return $str;
}

public function select_option_drug(){
    
    $res = $this->db->query("select * from medicine");
    
    if($res->num_rows > 0){
         //$str='';
        while($data = $res->fetch_assoc()){
            
           //$str[]=$data['medicine']; 
            
            $str.='<option value="'.$data['medicine'].'">'.$data['medicine'].'</option>';
        }
    }
    return $str;
}

public function add_vital($pulse,$temperature,$weight,$resp_rate,$patient_id,$height,$pefr_pre,$pefr_post,$sugar_fasting,$sugar_rendom,$blood_systolic,$blood_diastolic)
{
	$doc_id=$_SESSION['login_id'];
	$date =date('Y-m-d');
	$res=$this->db->query("insert into vital(pulse,temperature,weight,resp_rate,patient_id,doctor_id,height,pefr_pre,pefr_post,blood_sugar_fast,blood_sugar_rendom,blood_systolic,blood_diastolic,date) values('$pulse','$temperature','$weight','$resp_rate','$patient_id','$doc_id','$height','$pefr_pre','$pefr_post','$sugar_fasting','$sugar_rendom','$blood_systolic','$blood_diastolic','$date')");
	if(@$res)
	{
	   
		return true;
	}
}

/*public function edit_vital($pulse,$temperature,$weight,$resp_rate,$patient_id,$height,$pefr_pre,$pefr_post,$sugar_fasting,$sugar_rendom,$blood_systolic,$blood_diastolic)
{
	$doc_id=$_SESSION['login_id'];
	$date =date('Y-m-d');
	$res=$this->db->query("update vital set  into vital(pulse,temperature,weight,resp_rate,patient_id,doctor_id,height,pefr_pre,pefr_post,blood_sugar_fast,blood_sugar_rendom,blood_systolic,blood_diastolic,date) values('$pulse','$temperature','$weight','$resp_rate','$patient_id','$doc_id','$height','$pefr_pre','$pefr_post','$sugar_fasting','$sugar_rendom','$blood_systolic','$blood_diastolic','$date')");
	if(@$res)
	{
	   
		return true;
	}
}*/

public function vital_show($id)
{

	$res=$this->db->query("select * from vital where doctor_id='$id'");
	
	$str='';
	$str='  <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Pulse</th>
                                        <th>Temperature</th>
                                         <th>Weight</th>
                                        <th>Resp Rate</th>
                                        <th>Patient</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                 <tbody>';
	if($res->num_rows > 0)
	{
		
		while($data=$res->fetch_assoc())
		{ 
		$id=$data['patient_id'];
		
			 $res1=$this->db->query("select * from patient where id='".$data['patient_id']."'");
			 $data1=$res1->fetch_assoc();
			$str.=' <tr>                <td>'.$data['date'].'</td>
                                        <td>'.$data['pulse'].'</td>
                                        <td>'.$data['temperature'].'</td>
                                        <td>'.$data['weight'].'</td>
                                        <td>'.$data['resp_rate'].'</td>
                                        <td>'.$data1['name'].'</td>
                                      
                                        <td><a href="'.base_url_doc.'patient-detail/?delete_vital='.$data['id'].'patient_id='.$data1['id'].'" class="btn btn-info" onclick="return conf();"><i class="material-icons">clear</i></a>
								 </td>
                                    </tr>
                                   ';
		
		}	
	}
	else{
	    $str.="<tr><td colspan= '6'>No Vital Sign Record Found.</td></tr>";
	}
	
	$str.=' </tbody></table>';
	 return $str;
}public function patient_vital_all($id)
{
$doc_id=$_SESSION['login_id'];
if($id == ''){
	$res=$this->db->query("select * from vital where doctor_id='$doc_id'");
}
else{
	$res=$this->db->query("select * from vital where patient_id='$id' ORDER BY date DESC");
}
	
	
	$str='';
	// $str='  <table class="table table-bordered table-striped table-hover dataTable js-exportable" style="font-size:10px !important">
 //                                <thead>
 //                                    <tr>
 //                                        <th>Name</th>
 //                                        <th>Pulse</th>
 //                                        <th>Temperature</th>
 //                                         <th>Weight</th>
 //                                        <th>Resp Rate</th>
 //                                         <th>Height</th> 
 //                                         <th>Pefr</th>
 //                                          <th>Blood Sugar</th>
 //                                        <th>Blood Pressure</th>
 //                                        <th>Action</th>
 //                                    </tr>
 //                                </thead>
 //                                 <tbody>';
    $str.='<div class="col-sm-12 table-responsive" > <table id="vitalsign" class="table patient-profile-tables table-striped " >
				<thead>
                    <tr>
                       <th>Date</th>
                        <th>Pulse</th>
                        <th>Temperature</th>
                         <th>Weight</th>
                        <th>Resp Rate</th>
                         <th>Height</th> 
                         <th>Pefr</th>
                          <th>Blood Sugar</th>
                        <th>Blood Pressure</th>
                        <th>Action</th>
                    </tr>
                </thead>
				<tbody>';
		$count =1;
	if($res->num_rows > 0)
	{
		
		while($data=$res->fetch_assoc())
		{ 
		$id=$data['patient_id'];
		
			 $res1=$this->db->query("select * from patient where id='".$data['patient_id']."'");
			 $data1=$res1->fetch_assoc();
			$str.=' <tr>
                                       <td style="width:150px"><input type="hidden" value='.$data['date'].'>'.date("j F Y",strtotime($data['date'])).'</td>
                                        <td>'.$data['pulse'].'</td>
                                        <td>'.$data['temperature'].'</td>
                                        <td>'.$data['weight'].'</td>
                                        <td>'.$data['resp_rate'].'</td>
                                        <td>'.$data['height'].'</td>
                                         <td>'.$data['pefr_pre'].'/'.$data['pefr_post'].'</td>
                                         <td>'.$data['blood_sugar_fast'].'/'.$data['blood_sugar_rendom'].'</td>
                                         <td>'.$data['blood_systolic'].'/'.$data['blood_diastolic'].'</td>
                                       
                                      
                                        <td style="width:220px"><div onclick="editvital('.$count.','.$data['id'].')" class="patient-list-buttons glyphicon glyphicon-pencil editvitalbutton" ></div>
                                        <a style="float:left" href="'.base_url_doc.'patient-detail-page.php?patient_id='.$_GET['patient_id'].'&delete_vital='.$data['id'].'"  onclick="return conf();"
                                        ><div class="patient-list-buttons glyphicon glyphicon-trash" ></div></a>
                                    
								 </td>
                                    </tr>
                                   ';
		$count++ ;
		}	
	}
	else
	{
		$str.="<tr><td colspan=10>No Records Found To Show.</td></tr>";
	}
	
	$str.=' </tbody></table></div>';
	 return $str;
}

public function delete_vital($id){
    
    $res = $this->db->query("delete from vital where id='$id'");
    
    if($res){
        
        return TRUE;
    }
}

public function add_clinical_note($complaint,$observations,$investigations,$diagnoses,$note,$patient_id)
{
	print_r();
	
	$doc_id = $_SESSION['login_id'];
	$date=date("Y-m-d");
	$res=$this->db->query("insert into clinical_note(complaint,observation,invastigations,diagnoses,note,doctor_id,patient_id,date) values('$complaint','$observations','$investigations','$diagnoses','$note','$doc_id','$patient_id','$date')");
	if(@$res)
	{
		return true;
	}
}
public function clinical_note_show($id)
{
	$doc_id = $_SESSION['login_id'];
	if($id == ''){
		$res=$this->db->query("select * from clinical_note where doctor_id='$doc_id'");
	}
	else{
		$res=$this->db->query("select * from clinical_note where patient_id='$id'");
	}
	
	$str='';
	$str='  <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Complaint</th>
                                        <th>Observation</th>
                                         <th>Invastigations</th>
                                        <th>Note</th>
                                     
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                 <tbody>';
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
		$data1 = $this->getbyId($data['patient_id'], 'patient');	 
			$str.=' <tr>
                                        <td>'.$data1['name'].'</td>
                                        <td>'.$data['complaint'].'</td>
                                        <td>'.$data['observation'].'</td>
                                        <td>'.$data['invastigations'].'</td>
                                        <td>'.$data['note'].'</td>
                                      
                                        <td><a href="'.base_url_doc.'patient/?edit_clinical_note='.$data['id'].'" class="btn btn-info"><i class="material-icons">edit</i></a>
                                        <a href="'.base_url_doc.'patient-detail/?delete_clinical_note='.$data['id'].'" class="btn btn-info" onclick="return conf();"><i class="material-icons">clear</i></a> <a href="'.base_url_doc.'print_clinical_note/?print_clinical_note='.$data['id'].'" class="btn btn-info" target="_blank"><i class="material-icons">print</i></a>
								 </td>
                                    </tr>
                                   ';
		
		}	
	}
	$str.=' </tbody></table>';
	 return $str;
}
public function clinical_note_show1($id)
{
	$doc_id = $_SESSION['login_id'];
	if($id == ''){
		$res=$this->db->query("select * from clinical_note where doctor_id='$doc_id' order by date DESC");
	}
	else{
		$res=$this->db->query("select * from clinical_note where patient_id='$id' order by date DESC");
	}
	
	$str='';
	
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
		$data1 = $this->getbyId($data['patient_id'], 'patient');	 
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
            $str.='<div class="col-sm-12" style="border: solid 1px #e2e2e2; border-radius: 4px;position: relative;padding: 10px; box-shadow: 0px 0px 10px #f9f9f9; margin:5px 0 5px 0">
			<div class="row">
				<span class="col-sm-2 col-xs-12"><h4><strong id="new_clinical"><input type="hidden" value='.$data['date'].'>'.date("j F Y",strtotime($data['date'])).'</strong></h4></span>
				<span style="float: right;">
					<a style="float:left" href="#"  class="editclinicalbtn" ><div onclick="editclinicalnotesid('.$data['id'].')" class="patient-list-buttons glyphicon glyphicon-pencil" ></div></a>
                    <a style="float:left" href="'.base_url_doc.'patient-detail-page.php?patient_id='.$id.'&delete_clinical_note='.$data['id'].'"  onclick="return conf();"><div class="patient-list-buttons glyphicon glyphicon-trash" ></div></a>
				</span>
			</div>
			<div class="row">
				<div class="col-sm-2 col-xs-12 clinical_note_heading" >Chief Complaints</div>
				<div class="col-sm-10 col-xs-12 clinical_note_content" style="font-size: 12px;">'.$data['complaint'].'</div>
			</div>
			<div class="row">
				<div class="col-sm-2 col-xs-12 clinical_note_heading" >Observation</div>
				<div class="col-sm-10 col-xs-12 clinical_note_content" style="font-size: 12px;">'.$data['observation'].'</div>
			</div>
			<div class="row">
				<div class="col-sm-2 col-xs-12 clinical_note_heading" >Invastigations</div>
				<div class="col-sm-10 col-xs-12 clinical_note_content" style="font-size: 12px;">'.$data['invastigations'].'</div>
			</div>
			<div class="row">
				<div class="col-sm-2 col-xs-12 clinical_note_heading" >Diagnoses</div>
				<div class="col-sm-10 col-xs-12 clinical_note_content" style="font-size: 12px;">'.$data['diagnoses'].'</div>
			</div>
			<div class="row">
				<div class="col-sm-2 col-xs-12 clinical_note_heading" >Note</div>
				<div class="col-sm-10 col-xs-12 clinical_note_content" style="font-size: 12px;">'.$data['note'].'</div>
			</div>
			
		</div>';
		
		}	
	} else {
		$str.="<div>No Clinic Notes Found To Show.</div>";
	}
	$str.=' </tbody></table>';
	 return $str;
}

public function delete_clinical_note($id){
    
    $res = $this->db->query("delete from clinical_note where id='$id'");
} 
public function get_patient_appointments_for_doctor($id)
{
    $doc_id = $_SESSION['login_id'];
    //echo $doc_id,$id;
    $res = $this->db->query("select * from appointments where patient_id='$id' and doctor_id='$doc_id' ORDER BY app_date DESC");
    $str='';
	$str='  <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>Appointment Date</th>
                                        <th>Appointment Time</th>
                                         <th>Clinic</th>
                                    </tr>
                                </thead>
                                 <tbody>';
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
			$str.=' <tr>
                                        <td>'.$data['app_date'].'</td>
                                        <td>'.$data['app_time'].'</td>
                                        <td>'.$data['clinic_name'].'</td>
								 
                                    </tr>
                                   ';
		
		}	
	}
	$str.=' </tbody></table>';
	 return $str;
}
public function patient_files($id)
{
	$res=$this->db->query("select * from patient where doctor_id='$id'");
	$str='';
	$str='  <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>Patient Image</th>
                                        <th>Name</th>
                                         <th>Phone No</th>
                                        <th>Area, City</th>
                                        <th>Age</th>
                                         <th>Gender</th>
                                         <th>Patient ID</th>
                                         <th>Action</th>
                                    </tr>
                                </thead>
                                 <tbody>';
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
			$area = $this->getById($data['area'], 'area');
			$str.=' <tr>
                                        <td><img src="'.base_url.'image/'.$data['image'].'" width="60" height="60"></td>
                                        <td>'.$data['name'].'</td>
                                        <td>'.$data['phone_no'].'</td>
                                        <td>'.$area['name'].', '.$data['city'].'</td>
                                        <td>'.$data['age'].'</td>
                                        <td>'.$data['gender'].'</td>
                                        <td>'.$data['patient_id'].'</td>
                                        <td><a href="'.base_url_doc.'patient-detail/?file='.$data['id'].'&patient_id='.$data['id'].'" class="btn btn-info"><i class="material-icons">add</i></a>
								 </td>
                                    </tr>
                                   ';
		
		}	
	}
	$str.=' </tbody></table>';
	 return $str;
}
public function add_files_category($file)
{
	$doc_id=$_SESSION['login_id'];
	
	$res=$this->db->query("insert into file_category (file,doctor_id) values('$file','$doc_id')");
	if(@$res)
	{
		return true;
	}
}
public function categoryfiles()
{
	$doc_id = @$_SESSION['login_id'];
	$res=$this->db->query("select * from file_category where doctor_id='$doc_id'");
	$str='';
	
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
			$str.=' <option value="'.$data['file'].'">'.$data['file'].'</option>
                                   ';
		
		}	
	}
	
	 return $str;
}
public function add_file($category, $file, $id, $name)
{
	$doc_id=$_SESSION['login_id'];
	
	$date = date("Y-m-d");
	$res=$this->db->query("insert into files (category, file,patient_id,doctor_id,file_name,date) values('$category','$file','$id','$doc_id','$name','$date')");
	if(@$res)
	{
		return true;
	}
}
public function file_show($id)
{
	$doc_id = $_SESSION['login_id'];
	

		$res=$this->db->query("select * from files where patient_id='$id'and doctor_id='$doc_id'and status_doc='0'");

	
	
	$str='';
	$str='<div class="col-sm-12 table-responsive" >  <table  class="table table-striped  patient-profile-tables">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                    	<th>File Category</th>
                                        <th>File Name</th>
                                        <th>From</th>
                                      
                                        
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                 <tbody> ';
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
			 else
			 {
			    $te=$_SESSION['name'];
			 }
			$str.=' <tr> <td> <input type="hidden" value='.$data['date'].'>'.$data['date'].'</td>
                                        <td>'.$data['category'].'</td>
                                        <td>'.$data['file_name'].'</td>
                                        <td>'.$te.'</td>
                                       
                                       
                                        
                                      
                                       
                                        <td>
                                        <a href="'.base_url.'files/'.$data['file'].'" download><div class="patient-list-buttons glyphicon glyphicon-download-alt" ></div></a>
                                        <a href="'.base_url_doc.'patient-detail-page.php?delete_file='.$data['id'].'&patient_id='.$id.'" onclick="return conf();"><div class="patient-list-buttons glyphicon glyphicon-trash" ></div></a>
								 </td>
                                    </tr>';
		
		}	
	} else {
	    $str.='<tr><td colspan="4">No Records Found To Show.</td></tr>';
	} 
	
	$str.=' </tbody></table></div>';
	 return $str;
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
public function patient_prescription($id)
{
	$res=$this->db->query("select * from patient where doctor_id='$id'");
	$str='';
	$str='  <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>Patient Image</th>
                                        <th>Name</th>
                                         <th>Phone No</th>
                                        <th>Area, City</th>
                                        <th>Age</th>
                                         <th>Gender</th>
                                         <th>Patient ID</th>
                                         <th>Action</th>
                                    </tr>
                                </thead>
                                 <tbody>';
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
			$area = $this->getById($data['area'], 'area');
			$str.=' <tr>
                                        <td><img src="'.base_url.'image/'.$data['image'].'" width="60" height="60"></td>
                                        <td>'.$data['name'].'</td>
                                        <td>'.$data['phone_no'].'</td>
                                        <td>'.$area['name'].', '.$data['city'].'</td>
                                        <td>'.$data['age'].'</td>
                                        <td>'.$data['gender'].'</td>
                                        <td>'.$data['patient_id'].'</td>
                                        <td><a href="'.base_url_doc.'patient-detail/?prescription='.$data['id'].'&patient_id='.$data['id'].'" class="btn btn-info"><i class="material-icons">add</i></a>
								 </td>
                                    </tr>
                                   ';
		
		}	
	}
	
	
	$str.=' </tbody></table>';
	 return $str;
}

public function add_prescription($file,$id)
{
	$doc_id=$_SESSION['login_id'];
	
	$res=$this->db->query("insert into  files(file,patient_id,doctor_id) values('$file','$id','$doc_id')");
	if(@$res)
	{
		return true;
	}
}
public function prescription_show($id)
{
	$res=$this->db->query("select * from patient where doctor_id='$id'");
	$str='';
	$str='  <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>Patient Image</th>
                                        <th>Name</th>
                                         <th>Phone No</th>
                                        <th>Area, City</th>
                                        <th>Age</th>
                                         <th>Gender</th>
                                         <th>Patient ID</th>
                                         <th>Action</th>
                                    </tr>
                                </thead>
                                 <tbody>';
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
			$area = $this->getById($data['area'], 'area');
			$str.=' <tr>
                                        <td><img src="'.base_url.'image/'.$data['image'].'" width="60" height="60"></td>
                                        <td>'.$data['name'].'</td>
                                        <td>'.$data['phone_no'].'</td>
                                        <td>'.$area['name'].', '.$data['city'].'</td>
                                        <td>'.$data['age'].'</td>
                                        <td>'.$data['gender'].'</td>
                                        <td>'.$data['patient_id'].'</td>
                                        <td><a href="'.base_url_doc.'patient-detail/?display_patient_prescription='.$data['id'].'&patient_id='.$data['id'].'" class="btn btn-info"><i class="material-icons">add</i></a>
								 </td>
                                    </tr>
                                   ';
		
		}	
	}
	$str.=' </tbody></table>';
	 return $str;
}
public function patient_invoice($id)
{
	$res=$this->db->query("select * from patient where doctor_id='$id'");
	$str='';
	$str='  <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>Patient Image</th>
                                        <th>Name</th>
                                         <th>Phone No</th>
                                        <th>Area, City</th>
                                        <th>Age</th>
                                         <th>Gender</th>
                                         <th>Patient ID</th>
                                         <th>Action</th>
                                    </tr>
                                </thead>
                                 <tbody>';
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
			$area = $this->getById($data['area'], 'area');
			$str.=' <tr>
                                        <td><img src="'.base_url.'image/'.$data['image'].'" width="60" height="60"></td>
                                        <td>'.$data['name'].'</td>
                                        <td>'.$data['phone_no'].'</td>
                                        <td>'.$area['name'].', '.$data['city'].'</td>
                                        <td>'.$data['age'].'</td>
                                        <td>'.$data['gender'].'</td>
                                        <td>'.$data['patient_id'].'</td>
                                        <td><a href="'.base_url_doc.'patient-detail/?action=invoice&patient_id='.$data['id'].'" class="btn btn-info"><i class="material-icons">add</i></a>
								 </td>
                                    </tr>
                                   ';
		
		}	
	}
	$str.=' </tbody></table>';
	 return $str;
}
public function add_invoice($amount,$id,$treatment,$discount,$total,$tax)
{
	$doc_id=$_SESSION['login_id'];
	$date=date('Y-m-d');
	$total=0;
	$amount=json_decode($amount,true);
	$discount=json_decode($discount,true);
	$tax=json_decode($tax,true);
	$len = count($amount);
    for($i=0;$i<$len;$i++)
    	{
    	    if(intval($tax[$i]))
    	        $total+=floatval($amount[$i])-((floatval($amount[$i])*floatval($discount[$i]))/100)+((floatval($this->get_tax_by_id($tax[$i]))*floatval($amount[$i]))/100);
    	    else
                $total+=floatval($amount[$i])-((floatval($amount[$i])*floatval($discount[$i]))/100);

    	}
	$amount = json_encode($amount);
	$discount = json_encode($discount);
	$tax = json_encode($tax);
	if($total)
	    $res=$this->db->query("insert into  bill_info(name,amount,discount,patient_id,doctor_id,status,total,date,tax,pending_amount) values('$treatment','$amount','$discount','$id','$doc_id','Pending','$total','$date','$tax','$total')");
	else
	    $res=$this->db->query("insert into  bill_info(name,amount,discount,patient_id,doctor_id,status,total,date,tax,pending_amount) values('$treatment','$amount','$discount','$id','$doc_id','Paid','$total','$date','$tax','$total')");

	if(@$res)
	{
		return true;
	}
}

public function edit_invoice($name,$amount,$id,$total,$discount,$description)
{
	$doc_id=$_SESSION['login_id'];
	//echo $name;
	//$date=date('Y-m-d');
	//$total=$amount+$tax;
	$res=$this->db->query("update bill_info set name='$name',amount='$amount',prescription='$description',discount='$discount',total='$total' where id='$id'");
	if(@$res)
	{
		return true;
	}
}

public function invoice_show($doc_id,$patient_id)
{
	$res=$this->db->query("select * from bill_info where doctor_id='$doc_id' and patient_id='$patient_id'");
	$str='';
	$str='<div class="col-sm-12 table-responsive" >   <table id="treat_table" class="table patient-profile-tables table-striped " >
                                <thead>
                                    <tr><th>Date</th>
                                        <th>Treatment Name</th>
                                        <th>Amount</th>
                                        <th>Discount</th>
                                        <th>Tax</th>
                                        <th>Total</th>
                                        <th >Action</th>
                                    </tr>
                                </thead>
                                 <tbody>';
                              
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
		    $temp = json_decode($data['tax'],true);
		    $tem='';
		    for($i=0;$i<count($temp);$i++)
		        {
		            if(intval($temp[i]))
		                $tem+='<b>'.get_taxname_by_id($temp[$i]).':'.get_tax_by_id($temp[$i]).'%</b><br>';
		            else
		                $tem+='<b>0</b><br>';
		            
		        }
					$str.=' <tr>        <td>'.$data['date'].'</td>
                                        <td>'.$data['name'].'</td>
                                        <td>'.$data['amount'].'</td>
                                        <td>'.$data['discount'].'</td>
                                        <td>'.$tem.'</td>
                                        <td>'.$data['total'].'</td>
                                        <td style=" width:150px">
                                        	<a href="'.base_url_doc.'print_bill/?id='.$data['id'].'" target="_blank"><div class="patient-list-buttons glyphicon glyphicon-print"></div></a>
                                        	<a href="'.base_url_doc.'patient-detail-page.php?patient_id='.$_GET['patient_id'].'&delete_invoice='.$data['id'].'" ><div class="patient-list-buttons glyphicon glyphicon-trash"></div></a>
                                        	
								 </td>
                                    </tr>';
                                 
		
		}	
	}
	$str.=' </tbody></table></div>';
	 return $str;
}

public function delete_invoice($id){
    
    $res = $this->db->query("delete from bill_info where id='$id'");
    
    if($res){
        
        return TRUE;
    }
}



public function invoice_show_patient($id)
{
	$res=$this->db->query("select * from bill_info where patient_id='$id'");
	$str='';
	$str='  <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Prescription</th>
                                        <th>Amount</th>
                                        <th>Tax</th>
                                       
                                         <th>Total</th>
                                       <th>Action</th>
                                    </tr>
                                </thead>
                                 <tbody>';
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
					$str.=' <tr>
                                        <td>'.$data['name'].'</td>
                                        <td>'.$data['email'].'</td>
                                        <td>'.$data['prescription'].'</td>
                                        <td>'.$data['amount'].'</td>
                                        <td>'.$data['tax'].'</td>
                                        <td>'.$data['total'].'</td>
                                        <td>
                                        	<a href="'.base_url_doc.'print_bill/?id='.$data['id'].'" class="btn btn-info"  target="_blank"><i class="material-icons">print</i></a><a href="'.base_url_doc.'patient-detail/?delete_invoice='.$data['id'].'" class="btn btn-info" onclick="return conf();"><i class="material-icons">clear</i></a>
								 </td>
                                    </tr>';
		
		}	
	}
	$str.=' </tbody></table>';
	 return $str;
}

public function patient_payment($id)
{
	$res=$this->db->query("select * from patient where doctor_id='$id'");
	$str='';
	$str='  <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>Patient Image</th>
                                        <th>Name</th>
                                         <th>Phone No</th>
                                        <th>Area, City</th>
                                        <th>Age</th>
                                         <th>Gender</th>
                                         <th>Patient ID</th>
                                         <th>Action</th>
                                    </tr>
                                </thead>
                                 <tbody>';
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
			$area = $this->getById($data['area'], 'area');
			$str.=' <tr>
                                        <td><img src="'.base_url.'image/'.$data['image'].'" width="60" height="60"></td>
                                        <td>'.$data['name'].'</td>
                                        <td>'.$data['phone_no'].'</td>
                                        <td>'.$area['name'].', '.$data['city'].'</td>
                                        <td>'.$data['age'].'</td>
                                        <td>'.$data['gender'].'</td>
                                        <td>'.$data['patient_id'].'</td>
                                        <td><a href="'.base_url_doc.'patient-detail/?payment='.$data['id'].'&patient_id='.$data['id'].'" class="btn btn-info"><i class="material-icons">add</i></a>
								 </td>
                                    </tr>
                                   ';
		
		}	
	}
	$str.=' </tbody></table>';
	 return $str;
}


public function patient_payment_patient($id)
{
	$res=$this->db->query("select * from patient where id='$id'");
	$str='';
	$str='  <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>Patient Image</th>
                                        <th>Name</th>
                                         <th>Phone No</th>
                                        <th>Area, City</th>
                                        <th>Age</th>
                                         <th>Gender</th>
                                         <th>Patient ID</th>
                                         <th>Action</th>
                                    </tr>
                                </thead>
                                 <tbody>';
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
			$area = $this->getById($data['area'], 'area');
			$str.=' <tr>
                                        <td><img src="'.base_url.'image/'.$data['image'].'" width="60" height="60"></td>
                                        <td>'.$data['name'].'</td>
                                        <td>'.$data['phone_no'].'</td>
                                        <td>'.$area['name'].', '.$data['city'].'</td>
                                        <td>'.$data['age'].'</td>
                                        <td>'.$data['gender'].'</td>
                                        <td>'.$data['patient_id'].'</td>
                                        <td><a href="'.base_url_doc.'patient-detail/?payment='.$data['id'].'&patient_id='.$data['id'].'" class="btn btn-info"><i class="material-icons">add</i></a>
								 </td>
                                    </tr>
                                   ';
		
		}	
	}
	$str.=' </tbody></table>';
	 return $str;
}

public function update_payment($id)
{
	$doc_id=$_SESSION['login_id'];
	$res=$this->db->query("select * from bill_info where id='$id'");
	$data=$res->fetch_assoc();
	if($data['status']=="Pending")
	{
		$status="Paid";
	}
	else
	{
		$status='Pending';
	}
		$res=$this->db->query("update bill_info set status='$status' where id='$id'");
	if(@$res)
	{
		header("Location:".base_url_doc."patient-detail/?action=payment&patient_id=");
	}
}
public function all_invoice($id)
{
	$res=$this->db->query("select * from bill_info where patient_id='$id'");
	$str='';
	$str='  <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Treatment</th>
                                        <th>Amount</th>
                                       <th>Action</th>
                                    </tr>
                                </thead>
                                 <tbody>';
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
					$str.=' <tr>
                                        <td>'.$data['name'].'</td>
                                        <td>'.$data['email'].'</td>
                                        <td>'.$data['prescription'].'</td>
                                        <td>'.$data['total'].'</td>';
                                        if($data['status']=="Paid")
                                        {
											$str.=' <td>
											<a href="'.base_url_doc.'print_bill/?id='.$data['id'].'" class="btn btn-info" target="_blank"><i class="material-icons">print</i></a>
											<a href="'.base_url_doc.'patient-detail/?paid='.$data['id'].'" class="btn btn-info">Paid</a>
											<a href="'.base_url_doc.'patient-detail/?delete_invoice='.$data['id'].'" class="btn btn-info" onclick="return conf();"><i class="material-icons" >clear</i></a> </td>';
										}
										else{
											
											$str.=' <td>
											<a href="'.base_url_doc.'print_bill/?id='.$data['id'].'" class="btn btn-info" target="_blank"><i class="material-icons">print</i></a>
											<a href="'.base_url_doc.'patient-detail/?paid='.$data['id'].'" class="btn btn-info">Pending</a>
											<a href="'.base_url_doc.'patient-detail/?delete_invoice='.$data['id'].'" class="btn btn-info" onclick="return conf();"><i class="material-icons">clear</i></a> </td>';
										}
                                       
                                  $str.='</tr>';
		
		}	
	}
	$str.=' </tbody></table>';
	 return $str;
}

public function all_invoice_doctor($id)
{
	$doc_id=$_SESSION['login_id'];
	$res=$this->db->query("select * from bill_info where doctor_id='$id'");
	$str='';
	$str='  <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Treatment</th>
                                        <th>Amount</th>
                                       <th>Action</th>
                                    </tr>
                                </thead>
                                 <tbody>';
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
					$str.=' <tr>
                                        <td>'.$data['name'].'</td>
                                        <td>'.$data['email'].'</td>
                                        <td>'.$data['prescription'].'</td>
                                        <td>'.$data['total'].'</td>';
                                        if($data['status']=="Paid")
                                        {
											$str.=' <td><a href="'.base_url_doc.'patient-detail/?paid='.$data['id'].'" class="btn btn-info">Paid</a>
												<a href="'.base_url_doc.'print_bill/?id='.$data['id'].'" class="btn btn-info"  target="_blank"><i class="material-icons">print</i></a>
											<a href="'.base_url_doc.'patient-detail/?delete_invoice='.$data['id'].'" class="btn btn-info" onclick="return conf();"><i class="material-icons">clear</i></a> </td>';
										}
										else{
											$str.=' <td><a href="'.base_url_doc.'patient-detail/?paid='.$data['id'].'" class="btn btn-info">Pending</a>
												<a href="'.base_url_doc.'print_bill/?id='.$data['id'].'" class="btn btn-info"  target="_blank"><i class="material-icons">print</i></a>
											<a href="'.base_url_doc.'patient-detail/?delete_invoice='.$data['id'].'" class="btn btn-info" onclick="return conf();"><i class="material-icons">clear</i></a> </td>';
										}
                                       
                                  $str.='</tr>';
		
		}	
	}
	$str.=' </tbody></table>';
	 return $str;
}

public function dropdown_patients()
{
	$doc_id=$_SESSION['login_id'];
	$res=$this->db->query("select * from patient where doctor_id='$doc_id'");
	
	
	if($res->num_rows > 0)
	{
		$str='<input type="checkbox" id="md_checkbox_457487" class="filled-in chk-col-cyan" value="all"  name="patient[]">
    <label for="md_checkbox_457487">All</label> <div id="forcheck">';
		while($data=$res->fetch_assoc())
		{
			$str.=' <input type="checkbox" id="md_checkbox_'.$data['id'].'" class="filled-in chk-col-cyan forcheck" value="'.$data['id'].'"  name="patient[]">
    <label for="md_checkbox_'.$data['id'].'">'.$data['name'].' ('.$data['patient_id'].')</label>
			';
		}
		$str.='</div>';
	}
	
	return $str;
}
public function send_msg($patient,$msg,$group,$area,$hindi)
{
	
	
	if(empty($msg))
	{
		$msg=$hindi;
		$route="&unicode=1";
	}
	else
	{
		$route="";
	}
	$lenght=strlen($msg);
	

	$doc_id=$_SESSION['login_id'];
	$res=$this->db->query("select * from doctors where id='$doc_id'");
	$msg.=" By Docconsult.in";
	
	 $res1=$this->db->query("select * from points where doctor_id='$doc_id'");
	 if($res1->num_rows > 0)
	 {
	 	$point=$res1->fetch_assoc();
	 	if($point['points']>0)
	 	{
	
if(@$res)
{  

 $remain_points=$point['points'];
 if($lenght > 140 && $lenght < 280)
	{
		$remain_points--;
	}
	if($lenght > 280 && $lenght < 420)
	{
		$remain_points--;
		$remain_points--;
	}
	if($lenght > 420 && $lenght < 560)
	{
		$remain_points--;
		$remain_points--;
		$remain_points--;
	}
	if($lenght > 560 && $lenght < 700)
	{
		$remain_points--;
		$remain_points--;
		$remain_points--;
		$remain_points--;
	}
	if($lenght > 700 && $lenght < 840)
	{
		$remain_points--;
		$remain_points--;
		$remain_points--;
		$remain_points--;
		$remain_points--;
	}
	if($lenght > 840 && $lenght < 980)
	{
		$remain_points--;
		$remain_points--;
		$remain_points--;
		$remain_points--;
		$remain_points--;
		$remain_points--;
	}
	if($lenght > 980 && $lenght < 1120)
	{
		$remain_points--;
		$remain_points--;
		$remain_points--;
		$remain_points--;
		$remain_points--;
		$remain_points--;
		$remain_points--;
	}
	

	
	
	
   $data1=$this->getById($doc_id,'doctors');
	$sender_phone_no=$data1['phone_no'];
	$sender_name=$data1['name'];
   
   $active_name="Send SMS";
		$res4=$this->db->query("select * from patient where doctor_id='$doc_id' order by id DESC limit 1");
		$data=$res4->fetch_assoc();
		$patient_id=$data['name'];
		
		$action='send';
		$date=date('Y-m-d');
	   $time=date("h:i");
		
		$res5=$this->db->query("insert into activity(name,patient_id,doctor_id,action,date,time) values('$active_name','$patient_id','$doc_id','$action','$date','$time') ");
	if(empty($patient))
	{
		if($group != 0)
	{
		$res=$this->sms_loop($group,"groups",$remain_points,$msg,$route);
	}
	elseif($area != 0)
	{
	$res=$this->sms_loop($area,"area",$remain_points,$msg,$route);

	}
		 
	}
	else
	{
		
		$send='';
		foreach($patient as $p)
		{
			if($p=="all")
			{
				
					if($group != 0)
					{
						$send="success";
					$res=$this->sms_loop($group,"groups",$remain_points,$msg,$route);
					}
				elseif($area != 0)
					{
						$send="success";
				$res=$this->sms_loop($area,"area",$remain_points,$msg,$route);
					}
					
			}
		}
		if(empty($send))
		{
			
			foreach($patient as $p)
		    {
		    	$res=$this->sms_loop($p,"id",$remain_points,$msg,$route);
		    }
			
		}

	}
	
	//echo  "insert into message(sender,sender_email,sender_phone_no,sender_name,message,receiver_name,receiver_email,receiver_phone_no) values('Doctor','null','$sender_phone_no','$sender_name','$msg',$receiver_name','null','$receiver_phone_no')";exit;
	return TRUE;
}
}
 }
}
public function sms_loop($id,$field,$remain_points,$msg,$route)
{
	
	$doc_id=$_SESSION['login_id'];
	 $data1=$this->getById($doc_id,'doctors');
	$sender_phone_no=$data1['phone_no'];
	$sender_name=$data1['name'];
	
	$res3=$this->db->query("select * from patient where doctor_id='$doc_id' and $field='$id' ");
		if($res3->num_rows>0)
		{
			
			while($data2=$res3->fetch_assoc())
			{ $remain_points--;
				$phone_no=$data2['phone_no'];
				$patient_name=$data2['name'];
				$patient_id=$data2['id'];
			
	$msg = str_replace("<", "", $msg);
	$msg = str_replace(">", "", $msg);
	$msg = rawurlencode($msg);

	
	
	
	  //$send_sms_url = 'http://www.sms.jprinfotech.com/api/sendhttp.php?authkey=4296AbkgvkyLHP2b584bb4a2&mobiles='.$phone_no.'&message='.$msg.'&sender='.sender_id.'&route=4'.$route;
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
				$res=$this->db->query("insert into message(sender,sender_email,sender_phone_no,sender_name,message,receiver_name,receiver_email,receiver_phone_no) values('Doctor','0','$sender_phone_no','$sender_name','$msg','$patient_name','0','$phone_no')");
				
	$date=date('Y-m-d');
	
		$res=$this->db->query("insert into sms(patient_id,message,doctor_id,date,status) values('$patient_id','$msg','$doc_id','$date','delivered')");
			}
			
			 $res2=$this->db->query("update points set points='$remain_points' where doctor_id='$doc_id'");
			 
		}
	
		
		
}
public function display_sms()
{	$id=$_SESSION['login_id'];
	$res=$this->db->query("select sms.date, sms.message, sms.status, patient.name, patient.phone_no from sms left JOIN patient ON sms.patient_id = patient.id where  sms.doctor_id='$id'");

	$rows = array();
	while($r = mysqli_fetch_array($res)){
		$date = strtotime($r['date']);
	    $r['date'] = date("j F Y",$date);
		$rows[] = $r;
	}
	$res = json_encode($rows);
	return $res;
}
public function send_email($patient,$msg,$subject,$group,$area)
{
	$doc_id=$_SESSION['login_id'];
	$res=$this->db->query("select * from doctors where id='$doc_id'");
	
if($res->num_rows>0)
{  

   $data1=$res->fetch_assoc();
	
   
   $active_name="Send Email";
		$res4=$this->db->query("select * from patient where doctor_id='$doc_id' order by id DESC limit 1");
		$data=$res4->fetch_assoc();
		$patient_id=$data['name'];
		
		$action='send';
		$date=date('Y-m-d');
	   $time=date("h:i");
		
		$res5=$this->db->query("insert into activity(name,patient_id,doctor_id,action,date,time) values('$active_name','$patient_id','$doc_id','$action','$date','$time') ");
		
	if(empty($patient))
	{
		if($group != 0)
	{
		$res=$this->email_loop($group,"groups",$msg,$subject);
	}
	elseif($area != 0)
	{
	$res=$this->email_loop($group,"groups",$msg,$subject);

	}
		 
	}
	else
	{
		
		$send='';
		foreach($patient as $p)
		{
			if($p=="all")
			{
				
					if($group != 0)
					{
						$send="success";
				$res=$this->email_loop($group,"groups",$msg,$subject);
					}
				elseif($area != 0)
					{
						$send="success";
				$res=$this->email_loop($group,"groups",$msg,$subject);
					}
					
			}
		}
		if(empty($send))
		{
			
			
			foreach($patient as $p)
		    {
		    	$res=$this->email_loop($p,"id",$msg,$subject);
		    }
			
		}

	}
	return TRUE;
              
	
	}
	}

public function email_loop($id,$field,$msg,$subject)
{
	
	$doc_id=$_SESSION['login_id'];
	 $data1=$this->getById($doc_id,'doctors');
	$sender_email=$data1['email'];
	$sender_name=$data1['name'];
	
	$res3=$this->db->query("select * from patient where doctor_id='$doc_id' and $field='$id' ");
		if($res3->num_rows>0)
		{
			while($data2=$res3->fetch_assoc())
			{
				
				$rec_email=$data2['email'];
				$patient_name=$data2['name'];
				$patient_id=$data2['id'];
				
			 require_once("../phpmailer/PHPMailerAutoload.php");

              $mail = new PHPMailer();

			//   $email = $_GET['email'];

			 $mailhost = "docconsult.in";
              $smtpUser = "mail@docconsult.in";
              $smtpPassword = "telekast@123";
		  
			  $name = "DocConsult";
			  $subject = $subject;
			  $from = "info@docconsult.in";
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
              $mail->AddAddress($rec_email);
             //   $mail->AddAddress("csharma727@gmail.com");
                $mail->IsHTML(true);

                $mail->Subject = $subject;

                $mail->Body = '<div style="width:100%; height:100%; margin:0;" >

	<div style=" width:90%; float:left; height:70px;padding:30px;">

		<span style="width:50%;float:left"> <img src="http://docconsult.in/images/logo.png"  style="height:70px"/></span>

		<span style="width:50%; text-align:right;float:left;font-size: 17px;">  </span>

	</div>

	<div style="font-size:18px;width:90%;float:left;margin-top:20px;padding-left:26px;">'.$msg.'</div>	
';
		if($mail->Send())
		{
			$res=$this->db->query("insert into message(sender,sender_email,sender_phone_no,sender_name,message,receiver_name,receiver_email,receiver_phone_no) values('Doctor','$sender_email','0','$sender_name','$msg','$patient_name','$rec_email','0')");
				
	$date=date('Y-m-d');
	
	
		$res=$this->db->query("insert into email(patient_id,message,doctor_id,date,status) values('$patient_id','$msg','$doc_id','$date','delivered')");
		}
		else{
			echo $mail->ErrorInfo;
		}
	
	
	
	
				
			}
			
			
		return TRUE;	 
		}
		
}
public function display_email()
{	$id=$_SESSION['login_id'];
	$res=$this->db->query("select email.date, email.message, email.status, email.Subject, patient.email, patient.name from email LEFT JOIN patient ON email.patient_id = patient.id where email.doctor_id='$id'");
	
	$rows = array();
	while($r = mysqli_fetch_array($res)){
		$date = strtotime($r['date']);
	    $r['date'] = date("j F Y",$date);
		$rows[] = $r;
	}
	$res = json_encode($rows);
	return $res;
}
public function daily_summary($id)
{
	$date=date('Y-m-d');

	$res=$this->db->query("select * from bill_info where doctor_id='$id' and date='$date'");
	
	$str=' <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Patient Name</th>
                                        <th>Prescription</th>
                                        <th>Amount</th>
                                   </tr>
                                </thead>
                                 <tbody>';
                                // echo "select * from bill_info where doctor_id='$id' and date='$date'"; exit;
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
			$data1=$this->getById($data['patient_id'],"patient");
					$str.=' <tr>
                                        <td>'.$data['id'].'</td>
                                        <td>'.$data1['name'].'</td>
                                        <td>'.$data['prescription'].'</td>
                                        <td>'.$data['amount'].'</td>
                                      </tr>';
				}	
	}
	$str.=' </tbody></table>';
	 return $str;
}
public function diplay_payment_reports($from,$to)
{ 
$doc_id=$_SESSION['login_id'];
if($from==0)
{
		$res=$this->db->query("select * from bill_info where status='Paid'  and doctor_id='$doc_id'");
}
else{
	$from=str_replace("/","-",$from);
$to=str_replace("/","-",$to);
	$res=$this->db->query("select * from bill_info where (status='Paid' and doctor_id='$doc_id') and(date > '$from' and date < '$to')");
}

	$str=' <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Patient Name</th>
                                         <th>Patient Email</th>
                                        <th>Prescription</th>
                                        <th>Amount</th>
                                   </tr>
                                </thead>
                                 <tbody>';
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
			$data1=$this->getById($data['patient_id'],"patient");
					$str.=' <tr>
                                        <td>'.$data['id'].'</td>
                                        <td>'.$data['name'].'</td>
                                         <td>'.$data1['email'].'</td>
                                        <td>'.$data['prescription'].'</td>
                                        <td>'.$data['amount'].'</td>
                                      </tr>';
				}	
	}
	$str.=' </tbody></table>';
	 return $str;
}
public function check_if_patient_alreay_exists($phone_no)
{
    /*echo "<script>alert($phone_no);</script>";*/
    $res = $this->db->query("select * from patient where phone_no='$phone_no'");
    if($res->num_rows > 0)
    {
        $data = $res->fetch_assoc();
        return $data['patient_id'];
    }
    else
    {
        return 0;
    }
}
public function get_patient_detail_by_patient_id($patient_id)
{
    $res = $this->db->query("select * from patient where patient_id='$patient_id'");
    if($res->num_rows > 0)
    {
        return $res->fetch_assoc();
    }
}
public function diplay_appointments_reports($from,$to)
{ 
$doc_id=$_SESSION['login_id'];
if($from==0)
{
		$res=$this->db->query("select * from appointments where  doctor_id='$doc_id'");
}
else{
	$from=str_replace("/","-",$from);
$to=str_replace("/","-",$to);
	$res=$this->db->query("select * from appointments where (doctor_id='$doc_id') and(app_date > '$from' and app_date < '$to')");
	//echo "select * from appointments where (doctor_id='$doc_id') and(app_date > '$from' and app_date < '$to')";exit;
}

	$str=' <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Patient Name</th>
                                         <th>Patient Email</th>
                                         <th>Appointment Date</th>
                                         <th>Appointment Time</th>
                                        <th>Prescription</th>
                                       
                                   </tr>
                                </thead>
                                 <tbody>';
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
			
					$str.='<tr>
                                        <td>'.$data['id'].'</td>
                                        <td>'.$data['patient_name'].'</td>
                                         <td>'.$data['patient_email'].'</td>
                                           <td>'.$data['app_date'].'</td>
                                        <td>'.$data['app_time'].'</td>
                                        <td>'.$data['prescription'].'</td>
                                      </tr>';
				}	
	}
	$str.=' </tbody></table>';
	 return $str;
}
public function diplay_patients_reports($from,$to)
{ 
$doc_id=$_SESSION['login_id'];
if($from==0)
{
		$res=$this->db->query("select * from patient where  doctor_id='$doc_id'");
}
else{
	$from=str_replace("/","-",$from);
$to=str_replace("/","-",$to);
	$res=$this->db->query("select * from patient where doctor_id='$doc_id' and(date > '$from' and date < '$to')");
	}

	$str=' <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                       
                                        <th>Patient Name</th>
                                         <th>Patient Email</th>
                                         <th>Patient Phone </th>
                                         <th>Address</th>
                                         <th>City</th>
                                        <th>State</th>
                                         <th>Pincode</th>
                                         
                                         
                                       
                                   </tr>
                                </thead>
                                 <tbody>';
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
			
					$str.='<tr>
                                        <td>'.$data['name'].'</td>
                                        <td>'.$data['email'].'</td>
                                        <td>'.$data['phone_no'].'</td>
                                        <td>'.$data['address'].'</td>
                                        <td>'.$data['city'].'</td>
                                        <td>'.$data['state'].'</td>
                                        <td>'.$data['pincode'].'</td>
                                       
                                      </tr>';
				}	
	}
	$str.=' </tbody></table>';
	 return $str;
}


public function diplay_appointment_counts()
{ 


	// $rows = array();
	// while($r = mysqli_fetch_array($res)){
	// 	$rows[] = $r;
	// }
	// $res = json_encode($rows);
	// return $res;




$doc_id=$_SESSION['login_id'];
//$res=$this->db->query("select * from bill_info where  doctor_id='$doc_id'");
	//	$res1=$this->db->query("select * from doctor_expenses where  doctor_id='$doc_id'");

//$res = $this->db->query("select bill_info.amount as amount, bill_info.date as date, doctor_expenses.amount as expenses from bill_info INNER JOIN doctor_expenses ON bill_info.date=doctor_expenses.date and bill_info.doctor_id=doctor_expenses.doctor_id and bill_info.date<=CURDATE() and bill_info.date>CURDATE()-7");
$rows=array();
$rows[0][0] = "date";
$rows[0][1] = "counts";

for($i=0;$i<7;$i++){
    $date=date('Y-m-d');
$date1 = strtotime("-".$i." days", strtotime($date));
$date2=date("Y-m-d", $date1);
$res = $this->db->query("select * from appointments where doctor_id='$doc_id' and app_date='$date2' and status!='Cancel'");
$count=$res->num_rows;

$rows[$i+1][0] =$date2 ;
$rows[$i+1][1] = $count;

}
// if($from==0)
// {
// 		$res=$this->db->query("select * from bill_info where  doctor_id='$doc_id'");
// 		$res1=$this->db->query("select * from doctor_expenses where  doctor_id='$doc_id'");
// }
// else{
// 	$from=str_replace("/","-",$from);
// $to=str_replace("/","-",$to);
// 	$res=$this->db->query("select * from bill_info where doctor_id='$doc_id' and(date > '$from' and date < '$to')");
// 	$res1=$this->db->query("select * from doctor_expenses where doctor_id='$doc_id' and(date > '$from' and date < '$to')");
// 	}



	// $str=' <table class="table table-bordered table-striped table-hover dataTable js-exportable">
 //                                <thead>
 //                                    <tr>
 //                                         <th>Income</th>
 //                                         <th>Expenses</th>
 //                                         <th>Net Income</th>
 //                                    </tr>
 //                                </thead>
 //                                 <tbody>';
 //                                 $income=0;
 //                                  $expenses=0;
	// if($res->num_rows > 0)
	// {
	// 	while($data=$res->fetch_assoc())
	// 	{
	// 		$income+=$data['amount'];
	// 	}	
	// }	
	// if($res1->num_rows > 0)
	// {
	// 	while($data1=$res1->fetch_assoc())
	// 	{
	// 		$expenses+=$data1['amount'];
	// 	}	
	// }	

	
/*	if($res1->num_rows>0)
	{
		$count = 1;
		while($data1 = $res1->fetch_assoc())
		{
			// if(!$data1['amount'])
			// {
			// 	$rows[$count][2]=0;
			// }
			// else
			// {
			// 	$rows[$count][2]=$data1['amount'];
			// }
			
			$rows[$count][2]=(int)$data1['amount'];
			//$rows[$count][2]=4000;
			$count++;
		}
	}*/


	$res = json_encode($rows);
	// return $res;
	//$res = json_encode($rows);
	return $res;

	// $total_income=$income-$expenses;
	// 	$str.='<tr>         <td>'.$income.'</td>
 //                                        <td>'.$expenses.'</td>
 //                                        <td>'.$total_income.'</td>
                                       
 //                               </tr>';
				
	// $str.=' </tbody></table>';
	 //return $str;
}

public function diplay_appointment_counts2($date1,$date2)
{ 


	// $rows = array();
	// while($r = mysqli_fetch_array($res)){
	// 	$rows[] = $r;
	// }
	// $res = json_encode($rows);
	// return $res;

$startTimeStamp = strtotime($date1);
$endTimeStamp = strtotime($date2);

$timeDiff = abs($endTimeStamp - $startTimeStamp);

$numberDays = $timeDiff/86400;  // 86400 seconds in one day

// and you might want to convert to integer
$numberDays = intval($numberDays);


$doc_id=$_SESSION['login_id'];
//$res=$this->db->query("select * from bill_info where  doctor_id='$doc_id'");
	//	$res1=$this->db->query("select * from doctor_expenses where  doctor_id='$doc_id'");

//$res = $this->db->query("select bill_info.amount as amount, bill_info.date as date, doctor_expenses.amount as expenses from bill_info INNER JOIN doctor_expenses ON bill_info.date=doctor_expenses.date and bill_info.doctor_id=doctor_expenses.doctor_id and bill_info.date<=CURDATE() and bill_info.date>CURDATE()-7");
$rows=array();
$rows[0][0] = "date";
$rows[0][1] = "counts";

for($i=0;$i<=$numberDays;$i++){
    //$date=date('Y-m-d');
$date3 = strtotime("-".$i." days", strtotime($date2));
$date4=date("Y-m-d", $date3);
$res = $this->db->query("select * from appointments where doctor_id='$doc_id' and app_date='$date4'");
$count=$res->num_rows;

$rows[$i+1][0] =$date4 ;
$rows[$i+1][1] = $count;

}
// if($from==0)
// {
// 		$res=$this->db->query("select * from bill_info where  doctor_id='$doc_id'");
// 		$res1=$this->db->query("select * from doctor_expenses where  doctor_id='$doc_id'");
// }
// else{
// 	$from=str_replace("/","-",$from);
// $to=str_replace("/","-",$to);
// 	$res=$this->db->query("select * from bill_info where doctor_id='$doc_id' and(date > '$from' and date < '$to')");
// 	$res1=$this->db->query("select * from doctor_expenses where doctor_id='$doc_id' and(date > '$from' and date < '$to')");
// 	}



	// $str=' <table class="table table-bordered table-striped table-hover dataTable js-exportable">
 //                                <thead>
 //                                    <tr>
 //                                         <th>Income</th>
 //                                         <th>Expenses</th>
 //                                         <th>Net Income</th>
 //                                    </tr>
 //                                </thead>
 //                                 <tbody>';
 //                                 $income=0;
 //                                  $expenses=0;
	// if($res->num_rows > 0)
	// {
	// 	while($data=$res->fetch_assoc())
	// 	{
	// 		$income+=$data['amount'];
	// 	}	
	// }	
	// if($res1->num_rows > 0)
	// {
	// 	while($data1=$res1->fetch_assoc())
	// 	{
	// 		$expenses+=$data1['amount'];
	// 	}	
	// }	

	
/*	if($res1->num_rows>0)
	{
		$count = 1;
		while($data1 = $res1->fetch_assoc())
		{
			// if(!$data1['amount'])
			// {
			// 	$rows[$count][2]=0;
			// }
			// else
			// {
			// 	$rows[$count][2]=$data1['amount'];
			// }
			
			$rows[$count][2]=(int)$data1['amount'];
			//$rows[$count][2]=4000;
			$count++;
		}
	}*/


	$res = json_encode($rows);
	// return $res;
	//$res = json_encode($rows);
	return $res;

	// $total_income=$income-$expenses;
	// 	$str.='<tr>         <td>'.$income.'</td>
 //                                        <td>'.$expenses.'</td>
 //                                        <td>'.$total_income.'</td>
                                       
 //                               </tr>';
				
	// $str.=' </tbody></table>';
	 //return $str;
}


public function diplay_profile_hits()
{ 


	// $rows = array();
	// while($r = mysqli_fetch_array($res)){
	// 	$rows[] = $r;
	// }
	// $res = json_encode($rows);
	// return $res;




$doc_id=$_SESSION['login_id'];
//$res=$this->db->query("select * from bill_info where  doctor_id='$doc_id'");
	//	$res1=$this->db->query("select * from doctor_expenses where  doctor_id='$doc_id'");

//$res = $this->db->query("select bill_info.amount as amount, bill_info.date as date, doctor_expenses.amount as expenses from bill_info INNER JOIN doctor_expenses ON bill_info.date=doctor_expenses.date and bill_info.doctor_id=doctor_expenses.doctor_id and bill_info.date<=CURDATE() and bill_info.date>CURDATE()-7");
/*$res = $this->db->query("select hits, date from hits where doctor_id='$doc_id'and date>CURDATE()-7");
// if($from==0)
// {
// 		$res=$this->db->query("select * from bill_info where  doctor_id='$doc_id'");
// 		$res1=$this->db->query("select * from doctor_expenses where  doctor_id='$doc_id'");
// }
// else{
// 	$from=str_replace("/","-",$from);
// $to=str_replace("/","-",$to);
// 	$res=$this->db->query("select * from bill_info where doctor_id='$doc_id' and(date > '$from' and date < '$to')");
// 	$res1=$this->db->query("select * from doctor_expenses where doctor_id='$doc_id' and(date > '$from' and date < '$to')");
// 	}



	// $str=' <table class="table table-bordered table-striped table-hover dataTable js-exportable">
 //                                <thead>
 //                                    <tr>
 //                                         <th>Income</th>
 //                                         <th>Expenses</th>
 //                                         <th>Net Income</th>
 //                                    </tr>
 //                                </thead>
 //                                 <tbody>';
 //                                 $income=0;
 //                                  $expenses=0;
	// if($res->num_rows > 0)
	// {
	// 	while($data=$res->fetch_assoc())
	// 	{
	// 		$income+=$data['amount'];
	// 	}	
	// }	
	// if($res1->num_rows > 0)
	// {
	// 	while($data1=$res1->fetch_assoc())
	// 	{
	// 		$expenses+=$data1['amount'];
	// 	}	
	// }	

	$rows=array();

	$rows[0][0] = "date";
	$rows[0][1] = "Views";

	if($res->num_rows>0)
	{
		$count = 1;
		while($data = $res->fetch_assoc())
		{
			$rows[$count][0]=$data['date'];
			$rows[$count][1]=(int)$data['hits'];
		
			$count++;
		}
	}*/


/*	if($res1->num_rows>0)
	{
		$count = 1;
		while($data1 = $res1->fetch_assoc())
		{
			// if(!$data1['amount'])
			// {
			// 	$rows[$count][2]=0;
			// }
			// else
			// {
			// 	$rows[$count][2]=$data1['amount'];
			// }
			
			$rows[$count][2]=(int)$data1['amount'];
			//$rows[$count][2]=4000;
			$count++;
		}
	}*/

$rows=array();
$rows[0][0] = "date";
$rows[0][1] = "hits";
//$rows[0][2] = "tooltip";


for($i=0;$i<7;$i++){
    $date=date('Y-m-d');
$date1 = strtotime("-".$i." days", strtotime($date));
$date2=date("Y-m-d", $date1);
$tmp = $i-7;
$date3 = strtotime("-".$tmp." days",$date2);
$date3 = date('Y-m-d',$date3);
$res = $this->db->query("select hits from hits where doctor_id='$doc_id' and date='$date2'");
$count=$res->num_rows;
$res1 = $this->db->query("select hits from hits where doctor_id='$doc_id' and date='$date3'");
$data=$res->fetch_assoc();
$comm = "";
if($count==0){
    
    $data['hits']=0;
}
/*if($res1->num_rows>0)
{
    $data1=$res1->fetch_assoc();
    if($data1['hits']-$data['hits']>0)
    {
        $temp = (($data1['hits']-$data['hits'])/$data1['hits']+$data['hits'])*100;
        $comm = '<p>Previous week:<br>more by '.$temp.'%</p><i class="fa fa-caret-up" aria-hidden="true"></i>';
    }
    else if($data1['hits']-$data['hits']==0)
    {
        $temp = (($data1['hits']-$data['hits'])/$data1['hits']+$data['hits'])*100;
        $comm = '<p>Previous week:<br>more by '.$temp.'%</p>';
    }
    else
    {
        $temp = (($data1['hits']-$data['hits'])/$data1['hits']+$data['hits'])*100*(-1);
        $comm = '<p>Previous week:<br>less by '.$temp.'%</p><i class="fa fa-caret-down" aria-hidden="true"></i>';
    }
    
    
}
else if($res1->num_rows==0)
{
    
}*/
$rows[$i+1][0] =$date2 ;
$rows[$i+1][1] = $data['hits'];
//$rows[$i+1][2] = $comm;

}

	$res = json_encode($rows);
	// return $res;
	//$res = json_encode($rows);
	return $res;

	// $total_income=$income-$expenses;
	// 	$str.='<tr>         <td>'.$income.'</td>
 //                                        <td>'.$expenses.'</td>
 //                                        <td>'.$total_income.'</td>
                                       
 //                               </tr>';
				
	// $str.=' </tbody></table>';
	 //return $str;
}

public function diplay_profile_hits2($date1,$date2)
{ 


	// $rows = array();
	// while($r = mysqli_fetch_array($res)){
	// 	$rows[] = $r;
	// }
	// $res = json_encode($rows);
	// return $res;




$doc_id=$_SESSION['login_id'];
//$res=$this->db->query("select * from bill_info where  doctor_id='$doc_id'");
	//	$res1=$this->db->query("select * from doctor_expenses where  doctor_id='$doc_id'");
 //$date1 = strtotime($date1);
    // $date2 = strtotime($date2);

/*$date1 = date('Y-m-d',$date1);
$date2 = date('Y-m-d',$date2);
//$res = $this->db->query("select bill_info.amount as amount, bill_info.date as date, doctor_expenses.amount as expenses from bill_info INNER JOIN doctor_expenses ON bill_info.date=doctor_expenses.date and bill_info.doctor_id=doctor_expenses.doctor_id and bill_info.date<=CURDATE() and bill_info.date>CURDATE()-7");
$res = $this->db->query("select hits, date from hits where doctor_id='$doc_id'and date>='$date1' and date<='$date2'");
// if($from==0)
// {
// 		$res=$this->db->query("select * from bill_info where  doctor_id='$doc_id'");
// 		$res1=$this->db->query("select * from doctor_expenses where  doctor_id='$doc_id'");
// }
// else{
// 	$from=str_replace("/","-",$from);
// $to=str_replace("/","-",$to);
// 	$res=$this->db->query("select * from bill_info where doctor_id='$doc_id' and(date > '$from' and date < '$to')");
// 	$res1=$this->db->query("select * from doctor_expenses where doctor_id='$doc_id' and(date > '$from' and date < '$to')");
// 	}



	// $str=' <table class="table table-bordered table-striped table-hover dataTable js-exportable">
 //                                <thead>
 //                                    <tr>
 //                                         <th>Income</th>
 //                                         <th>Expenses</th>
 //                                         <th>Net Income</th>
 //                                    </tr>
 //                                </thead>
 //                                 <tbody>';
 //                                 $income=0;
 //                                  $expenses=0;
	// if($res->num_rows > 0)
	// {
	// 	while($data=$res->fetch_assoc())
	// 	{
	// 		$income+=$data['amount'];
	// 	}	
	// }	
	// if($res1->num_rows > 0)
	// {
	// 	while($data1=$res1->fetch_assoc())
	// 	{
	// 		$expenses+=$data1['amount'];
	// 	}	
	// }	

	$rows=array();

	$rows[0][0] = "date";
	$rows[0][1] = "Views";

	if($res->num_rows>0)
	{
		$count = 1;
		while($data = $res->fetch_assoc())
		{
			$rows[$count][0]=$data['date'];
			$rows[$count][1]=(int)$data['hits'];
		
			$count++;
		}*/
	
$startTimeStamp = strtotime($date1);
$endTimeStamp = strtotime($date2);

$timeDiff = abs($endTimeStamp - $startTimeStamp);

$numberDays = $timeDiff/86400;  // 86400 seconds in one day

// and you might want to convert to integer
$numberDays = intval($numberDays);
//	echo $numberDays;
		
		$rows=array();
$rows[0][0] = "date";
$rows[0][1] = "hits";

for($i=0;$i<=$numberDays;$i++){
    //$date=date('Y-m-d');
$date3 = strtotime("-".$i." days", $endTimeStamp);
$date4=date("Y-m-d", $date3);
$res = $this->db->query("select hits from hits where doctor_id='$doc_id' and date='$date4'");
$count=$res->num_rows;

$data=$res->fetch_assoc();
if($count==0){
    
    $data['hits']=0;
}

$rows[$i+1][0] =$date4 ;
$rows[$i+1][1] = $data['hits'];

}

	$res = json_encode($rows);
	// return $res;
	//$res = json_encode($rows);
	return $res;
		
	


/*	if($res1->num_rows>0)
	{
		$count = 1;
		while($data1 = $res1->fetch_assoc())
		{
			// if(!$data1['amount'])
			// {
			// 	$rows[$count][2]=0;
			// }
			// else
			// {
			// 	$rows[$count][2]=$data1['amount'];
			// }
			
			$rows[$count][2]=(int)$data1['amount'];
			//$rows[$count][2]=4000;
			$count++;
		}
	}*/


	//$res = json_encode($rows);
	// return $res;
	//$res = json_encode($rows);
	//return $res;

	// $total_income=$income-$expenses;
	// 	$str.='<tr>         <td>'.$income.'</td>
 //                                        <td>'.$expenses.'</td>
 //                                        <td>'.$total_income.'</td>
                                       
 //                               </tr>';
				
	// $str.=' </tbody></table>';
	 //return $str;
}

public function diplay_income_sum_reports_week()
{ 

$doc_id=$_SESSION['login_id'];

$rows=array();
$rows[0][0] = "date";
$rows[0][1] = "amount";
$rows[0][2] = "expenses";
for($i=0;$i<7;$i++){
$date=date('Y-m-d');
$date1 = strtotime("-".$i." days", strtotime($date));
$date2=date("Y-m-d", $date1);
$res = $this->db->query("SELECT doctor_expenses.amount as expenses FROM `doctor_expenses` where doctor_id='$doc_id' and date='$date2'");
$res1 = $this->db->query("select bill_info.total as amount from bill_info where bill_info.date='$date2' and bill_info.doctor_id='$doc_id'");
if($res->num_rows>0)
{
    $data=$res->fetch_assoc();
}
else{
    
    $data=array();
    $data["expenses"]=0;
}
if($res1->num_rows>0){
    $data1=$res1->fetch_assoc();
}
else{
    
    $data1=array();
    $data1["amount"]=0;
}
$rows[$i+1][0] =$date2 ;
$rows[$i+1][1] = intval($data1['amount']);
$rows[$i+1][2] = intval($data['expenses']);
}

	
	$res = json_encode($rows);
	return $res;
	 //return $str;*/
}

public function diplay_income_sum_reports2($date1,$date2)
{ 


	// $rows = array();
	// while($r = mysqli_fetch_array($res)){
	// 	$rows[] = $r;
	// }
	// $res = json_encode($rows);
	// return $res;




$doc_id=$_SESSION['login_id'];
//$res=$this->db->query("select * from bill_info where  doctor_id='$doc_id'");
	//	$res1=$this->db->query("select * from doctor_expenses where  doctor_id='$doc_id'");


    //$date1 = strtotime($date1);
     //$date2 = strtotime($date2);
     
     $startTimeStamp = strtotime($date1);
$endTimeStamp = strtotime($date2);

$timeDiff = abs($endTimeStamp - $startTimeStamp);

$numberDays = $timeDiff/86400;  // 86400 seconds in one day

// and you might want to convert to integer
$numberDays = intval($numberDays);

/*$date1 = date('Y-m-d',$date1);
$date2 = date('Y-m-d',$date2);
    
    $res = $this->db->query("select bill_info.amount as amount, bill_info.date as date, doctor_expenses.amount as expenses from bill_info INNER JOIN doctor_expenses ON bill_info.date=doctor_expenses.date and bill_info.doctor_id=doctor_expenses.doctor_id and bill_info.date>='$date1' and bill_info.date<='$date2'");


// if($from==0)
// {
// 		$res=$this->db->query("select * from bill_info where  doctor_id='$doc_id'");
// 		$res1=$this->db->query("select * from doctor_expenses where  doctor_id='$doc_id'");
// }
// else{
// 	$from=str_replace("/","-",$from);
// $to=str_replace("/","-",$to);
// 	$res=$this->db->query("select * from bill_info where doctor_id='$doc_id' and(date > '$from' and date < '$to')");
// 	$res1=$this->db->query("select * from doctor_expenses where doctor_id='$doc_id' and(date > '$from' and date < '$to')");
// 	}



	// $str=' <table class="table table-bordered table-striped table-hover dataTable js-exportable">
 //                                <thead>
 //                                    <tr>
 //                                         <th>Income</th>
 //                                         <th>Expenses</th>
 //                                         <th>Net Income</th>
 //                                    </tr>
 //                                </thead>
 //                                 <tbody>';
 //                                 $income=0;
 //                                  $expenses=0;
	// if($res->num_rows > 0)
	// {
	// 	while($data=$res->fetch_assoc())
	// 	{
	// 		$income+=$data['amount'];
	// 	}	
	// }	
	// if($res1->num_rows > 0)
	// {
	// 	while($data1=$res1->fetch_assoc())
	// 	{
	// 		$expenses+=$data1['amount'];
	// 	}	
	// }	

	$rows=array();

	$rows[0][0] = "date";
	$rows[0][1] = "income";
	$rows[0][2] = "expenses";
	if($res->num_rows>0)
	{
		$count = 1;
		while($data = $res->fetch_assoc())
		{
			$rows[$count][0]=$data['date'];
			$rows[$count][1]=(int)$data['amount'];
			$rows[$count][2]=(int)$data['expenses'];
			$count++;
		}
	}


/*	if($res1->num_rows>0)
	{
		$count = 1;
		while($data1 = $res1->fetch_assoc())
		{
			// if(!$data1['amount'])
			// {
			// 	$rows[$count][2]=0;
			// }
			// else
			// {
			// 	$rows[$count][2]=$data1['amount'];
			// }
			
			$rows[$count][2]=(int)$data1['amount'];
			//$rows[$count][2]=4000;
			$count++;
		}
	}*/


/*	$res = json_encode($rows);
	// return $res;
	//$res = json_encode($rows);
	return $res;*/

	// $total_income=$income-$expenses;
	// 	$str.='<tr>         <td>'.$income.'</td>
 //                                        <td>'.$expenses.'</td>
 //                                        <td>'.$total_income.'</td>
                                       
 //                               </tr>';
				
	// $str.=' </tbody></table>';
	 //return $str;
	 
	 $rows=array();
$rows[0][0] = "date";
$rows[0][1] = "amount";
$rows[0][2] = "expenses";

for($i=0;$i<=$numberDays;$i++){
    //$date=date('Y-m-d');
$date3 = strtotime("-".$i." days", $endTimeStamp);
$date4=date("Y-m-d", $date3);
 $res = $this->db->query("select bill_info.amount as amount, doctor_expenses.amount as expenses from bill_info INNER JOIN doctor_expenses ON bill_info.date=doctor_expenses.date and bill_info.doctor_id=doctor_expenses.doctor_id and bill_info.date='$date4'");

$count=$res->num_rows;

$data=$res->fetch_assoc();
if($count==0){
    
   $data['amount']=0;
    $data['expenses']=0;
}

$rows[$i+1][0] =$date4 ;
$rows[$i+1][1] = $data['amount'];
$rows[$i+1][2] = $data['expenses'];

}

	
	$res = json_encode($rows);
	// return $res;
	//$res = json_encode($rows);
	return $res;

	 
}
public function diplay_income_reports($from,$to)
{ 



$doc_id=$_SESSION['login_id'];
if($from==0)
{
		$res=$this->db->query("select * from bill_info where  doctor_id='$doc_id'");
}
else{
	$from=str_replace("/","-",$from);
$to=str_replace("/","-",$to);
	$res=$this->db->query("select * from bill_info where doctor_id='$doc_id' and(date > '$from' and date < '$to')");
	}

	$str=' <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                       
                                        <th>Invoice No</th>
                                         <th>Patient Name</th>
                                         <th>Prescription </th>
                                          <th>Date</th>
                                         <th>Amount</th>
                                    </tr>
                                </thead>
                                 <tbody>';
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
			
					$str.='<tr>
                                        <td>'.$data['id'].'</td>
                                        <td>'.$data['name'].'</td>
                                        <td>'.$data['prescription'].'</td>
                                        <td>'.$data['date'].'</td>
                                        <td>'.$data['amount'].'</td>
                                      
                                       
                                      </tr>';
				}	
	}
	$str.=' </tbody></table>';
	 return $str;
}
public function diplay_expenses_reports($from,$to)
{ 
$doc_id=$_SESSION['login_id'];
if($from==0)
{
		$res=$this->db->query("select * from doctor_expenses where  doctor_id='$doc_id'");
}
else{
	$from=str_replace("/","-",$from);
$to=str_replace("/","-",$to);
	$res=$this->db->query("select * from doctor_expenses where doctor_id='$doc_id' and(stored_date > '$from' and stored_date < '$to')");
	}

	$str=' <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                       <th>Vendor</th>
                                        <th>Date</th>
                                         <th>Expense</th>
                                         <th>Mode Of Payment </th>
                                         <th>Amount</th>
                                         <th>Entry Date</th>
                                    </tr>
                                </thead>
                                 <tbody>';
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{$str.='<tr> <td>';
		   $ven=json_decode($data['vendor'],true);
		      foreach($ven as $vendor)
		      {
			  	$str.=$vendor.'<br><br>';
			  }
					$str.='</td><td>';
				 $date=json_decode($data['date'],true);
		      foreach($date as $d)
		      {
			  	$str.=$d.'<br><br>';
			  }	
					
				$str.='</td><td>';
				 $expense=json_decode($data['expense'],true);
		      foreach($expense as $exp)
		      {
			  	$str.=$exp.'<br><br>';
			  }		
					
               $str.='</td><td>';
				 $mode_of_payment=json_decode($data['mode_of_payment'],true);
		      foreach($mode_of_payment as $mode)
		      {
			  	$str.=$mode.'<br><br>';
			  }		
				 $str.='</td><td>';
				 $amount=json_decode($data['amount'],true);
		      foreach($amount as $amt)
		      {
			  	$str.=$amt.'<br><br>';
			  }	                        
                                        
                                $str.='</td><td>'.$data['stored_date'].' </td></tr>';
				}	
	}
	$str.=' </tbody></table>';
	 return $str;
}
public function diplay_views_reports($from,$to)
{ 
$doc_id=$_SESSION['login_id'];
$hits=0;
$like=0;
if($from==0)
{
		$res=$this->db->query("select * from hits where  doctor_id='$doc_id'");
}
else{
	$from=str_replace("/","-",$from);
$to=str_replace("/","-",$to);
	$res=$this->db->query("select * from hits where doctor_id='$doc_id' and(date > '$from' and date < '$to')");
	}

	$str=' <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                       <th>Profile Hits</th>
                                        <th>Whole Profile View</th>
                                         <th> Total Likes</th>
                                         
                                    </tr>
                                </thead>
                                 <tbody>';
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
			 $hits=$hits+$data['hits'];
		}
		if($from==0)
		{
			$res1=$this->db->query("select * from likes where doctor_id='$doc_id'");
		}
		else{
			$res1=$this->db->query("select * from likes where doctor_id='$doc_id' and( date > '$from' and date < '$to')");
		}
			
		//echo "select * from likes where doctor_id='$doc_id' and(date > '$from' and date < '$to')"; exit;
		if($res1->num_rows > 0)
		{
		while($data1=$res1->fetch_assoc())
		{
			 $like++;
		}
		}
		$str.='<tr><td>'.$hits.' </td> <td>'.$hits.' </td>  <td> '.$like.'</td></tr>';
	}
	$str.=' </tbody></table>';
	 return $str;
}
public function diplay_amount_due_reports($from,$to)
{ 
$doc_id=$_SESSION['login_id'];
if($from==0)
{
		$res=$this->db->query("select * from bill_info where  doctor_id='$doc_id' and status='Pending'");
}
else{
	$from=str_replace("/","-",$from);
$to=str_replace("/","-",$to);
	$res=$this->db->query("select * from bill_info where (doctor_id='$doc_id' and status='Pending') and(date > '$from' and date < '$to')");
	}

	$str=' <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                       
                                        <th>Invoice No</th>
                                         <th>Patient Name</th>
                                         <th>Prescription </th>
                                          <th>Date</th>
                                         <th>Amount</th>
                                    </tr>
                                </thead>
                                 <tbody>';
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
			
					$str.='<tr>
                                        <td>'.$data['id'].'</td>
                                        <td>'.$data['name'].'</td>
                                        <td>'.$data['prescription'].'</td>
                                        <td>'.$data['date'].'</td>
                                        <td>'.$data['amount'].'</td>
                                      
                                       
                                      </tr>';
				}	
	}
	$str.=' </tbody></table>';
	 return $str;
}
public function update_award($award)
{
	$doc_id=$_SESSION['login_id'];
	$res=$this->db->query("select * from doctors where id='$doc_id'");
	$data=$res->fetch_assoc();
	$ser=json_decode($data['award'],true);
	$count=0;
	if(!empty($ser))
	{
		
	
	foreach($ser as $data1)
			{
				$count++;
				
				}
				}
				$ser[$count]=array("award"=>$award);
			
				$qual=json_encode($ser);
	$res=$this->db->query("update doctors set award='$qual' where id='$doc_id'");
	if(@$res)
	{
		$active_name="Update profile";
	
		$patient_id=0;
	
		$action='edited';
		$date=date('Y-m-d');
	   $time=date("h:i");
		
		$res1=$this->db->query("insert into activity(name,patient_id,doctor_id,action,date,time) values('$active_name','$patient_id','$doc_id','$action','$date','$time') ");
		return TRUE;
	}
}
public function update_member($member)
{
	$doc_id=$_SESSION['login_id'];
	$res=$this->db->query("update doctors set membership='$member' where id='$doc_id'");
	if(@$res)
	{
		$active_name="Update profile";
	
		$patient_id=0;
	
		$action='edited';
		$date=date('Y-m-d');
	   $time=date("h:i");
		
		$res1=$this->db->query("insert into activity(name,patient_id,doctor_id,action,date,time) values('$active_name','$patient_id','$doc_id','$action','$date','$time') ");
		return TRUE;
	}
}
public function update_service($service)
{
	$doc_id=$_SESSION['login_id'];
	$res=$this->db->query("select * from doctors where id='$doc_id'");
	$data=$res->fetch_assoc();
	$ser=json_decode($data['services'],true);
	$count=0;
	if(!empty($ser))
	{
		
	
	foreach($ser as $data1)
			{
				$count++;
				
				}
				}
				$ser[$count]=array("service"=>$service);
			
				$qual=json_encode($ser);
	$res=$this->db->query("update doctors set services='$qual' where id='$doc_id'");
	if(@$res)
	{
		$active_name="Update profile";
	
		$patient_id=0;
	
		$action='edited';
		$date=date('Y-m-d');
	   $time=date("h:i");
		
		$res1=$this->db->query("insert into activity(name,patient_id,doctor_id,action,date,time) values('$active_name','$patient_id','$doc_id','$action','$date','$time') ");
		return TRUE;
	}
}
public function update_about($about)
{
	$doc_id=$_SESSION['login_id'];
	$res=$this->db->query("update doctors set about='$about' where id='$doc_id'");
	if(@$res)
	{
		$active_name="Update profile";
	
		$patient_id=0;
	
		$action='edited';
		$date=date('Y-m-d');
	   $time=date("h:i");
		
		$res1=$this->db->query("insert into activity(name,patient_id,doctor_id,action,date,time) values('$active_name','$patient_id','$doc_id','$action','$date','$time') ");
		return TRUE;
	}
}
public function education()
{
	
$doc_id=$_SESSION['login_id'];

		$res=$this->db->query("select * from doctors where id='$doc_id'");
	
	$str=' <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                          <th>Qulification</th>
                                         <th>College</th>
                                         <th>Year </th>
                                         
                                    </tr>
                                </thead>
                                 <tbody>';
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
			$quli=json_decode($data['education'],true);
			
			foreach($quli as $data1)
			{
				
			$str.='<tr>
                          <td>'.$data1['qualification'].'</td>
                          <td>'.$data1['collage'].'</td>
                          <td>'.$data1['year'].'</td>
                        
                  </tr>';
               }
				}	
	}
	$str.=' </tbody></table>';
	 return $str;
}
public function services()
{
	
$doc_id=$_SESSION['login_id'];

		$res=$this->db->query("select * from doctors where id='$doc_id'");
	
	$str=' <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                          <th>service</th>
                                         
                                         
                                    </tr>
                                </thead>
                                 <tbody>';
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
			$quli=json_decode($data['services'],true);
			
			foreach($quli as $data1)
			{
				
			$str.='<tr>
                          <td>'.$data1['service'].'</td>
                         
                        
                  </tr>';
               }
				}	
	}
	$str.=' </tbody></table>';
	 return $str;
}public function award()
{
	
$doc_id=$_SESSION['login_id'];

		$res=$this->db->query("select * from doctors where id='$doc_id'");
	
	$str=' <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                          <th>Award</th>
                                         
                                         
                                    </tr>
                                </thead>
                                 <tbody>';
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
			$quli=json_decode($data['award'],true);
			
			foreach($quli as $data1)
			{
				
			$str.='<tr>
                          <td>'.$data1['award'].'</td>
                         
                        
                  </tr>';
               }
				}	
	}
	$str.=' </tbody></table>';
	 return $str;
}
public function diplay_update_quali($qualification,$collage,$year)
{
	$doc_id=$_SESSION['login_id'];
	$res=$this->db->query("select * from doctors where id='$doc_id'");
	$data=$res->fetch_assoc();
	$education=json_decode($data['education'],true);
	$count=0;
	foreach($education as $data1)
			{
				$count++;
				
				}
				$education[$count]=array("qualification"=>$qualification,"collage"=>$collage,"year"=>$year);
			
				$qual=json_encode($education);
	$res1=$this->db->query("update doctors set education='$qual' where id='$doc_id'");
	if(@$res1)
	{
		$active_name="Update profile";
	
		$patient_id=0;
	
		$action='edited';
		$date=date('Y-m-d');
	   $time=date("h:i");
		
		$res1=$this->db->query("insert into activity(name,patient_id,doctor_id,action,date,time) values('$active_name','$patient_id','$doc_id','$action','$date','$time') ");
		return true;
	}
	
	
}
public function update_profile_image($image)
{
	$doc_id=$_SESSION['login_id'];
	$res=$this->db->query("update doctors set image='$image' where id='$doc_id'");
	if($res)
	{
		return TRUE;
	}
}
public function update_appointment_slot($slot)
{$doc_id=$_SESSION['login_id'];
	$res=$this->db->query("select  * from doctor_additional where doctor_id='$doc_id'");
	if($res->num_rows > 0)
	{
		$res1=$this->db->query("update doctor_additional set appointment_slot='$slot' where doctor_id='$doc_id'");
		if(@$res1)
		{
			$active_name="Update profile";
	
		$patient_id=0;
	
		$action='edited';
		$date=date('Y-m-d');
	   $time=date("h:i");
		
		$res1=$this->db->query("insert into activity(name,patient_id,doctor_id,action,date,time) values('$active_name','$patient_id','$doc_id','$action','$date','$time') ");
			return TRUE;
		}
	}
	else
	{
		$res1=$this->db->query("insert into doctor_additional(appointment_slot,doctor_id) values('$slot','$doc_id')"
		); 
		if(@$res1)
		{
			$active_name="Add Additional Information";
		
		
		$patient_id=0;
		
		$action='added';
		$date=date('Y-m-d');
	   $time=date("h:i");
		
		$res1=$this->db->query("insert into activity(name,patient_id,doctor_id,action,date,time) values('$active_name','$patient_id','$doc_id','$action','$date','$time') ");
			return TRUE;
		}
	}
	
}
public function update_days($days)
{
	$doc_id=$_SESSION['login_id'];
	$res=$this->db->query("select  * from doctor_additional where doctor_id='$doc_id'");
	if($res->num_rows > 0)
	{
		
		$res1=$this->db->query("update doctor_additional set days='$days' where doctor_id='$doc_id'");
		if(@$res1)
		{
			return TRUE;
		}
	}
	else
	{
		$res1=$this->db->query("insert into doctor_additional(days,doctor_id) values('$days','$doc_id')");
		if(@$res1)
		{
			return TRUE;
		}
	}
}
public function update_time($time)
{
	$doc_id=$_SESSION['login_id'];
	$res=$this->db->query("select  * from doctor_additional where doctor_id='$doc_id'");
	if($res->num_rows > 0)
	{
		
		$res1=$this->db->query("update doctor_additional set time='$time' where doctor_id='$doc_id'");
		if(@$res1)
		{
			return TRUE;
		}
	}
	else
	{
		$res1=$this->db->query("insert into doctor_additional(time,doctor_id) values('$time','$doc_id')");
		if(@$res1)
		{
			return TRUE;
		}
	}
}public function update_fees($fees)
{
	$doc_id=$_SESSION['login_id'];
	$res=$this->db->query("select  * from doctor_additional where doctor_id='$doc_id'");
	if($res->num_rows > 0)
	{
		$res1=$this->db->query("update doctor_additional set fees='$fees' where doctor_id='$doc_id'");
		if(@$res1)
		{
			return TRUE;
		}
	}
	else
	{
		$res1=$this->db->query("insert into doctor_additional(fees,doctor_id) values('$fees','$doc_id')");
		if(@$res1)
		{
			return TRUE;
		}
	}
}
public function update_profile($name,$email,$phone_no,$sec,$reg_no,$reg_year,$reg_add_info,$address,$city,$specialization,$experience)
{
	$doc_id=$_SESSION['login_id'];
	$res=$this->db->query("update doctors set name='$name',email='$email',phone_no='$phone_no',secondry_phone='$sec',registration_no='$reg_no',reg_year='$reg_year',reg_add_info='$reg_add_info',address='$address',city='$city',specialization='$specialization',experience='$experience' where id='$doc_id' ");
	if(@$res)
	{
		return TRUE;
	}
}

public function feedback($id)
{
	$res=$this->db->query("select * from appointments where doctor_id='$id'");
	$str='';
	
	$str='  <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>Patient Name</th>
                                        <th>Feedback</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                      
                                       
                                    </tr>
                                </thead>
                                 <tbody>';
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
			if(!empty($data['feadback']))
			{
			$str.=' <tr>
                                        <td>'.$data['patient_name'].'</td>
                                        <td>'.$data['feadback'].'</td>
                                        <td>'.$data['app_date'].'</td>
                                                                               
                                       
								 </td>
                                    </tr>
                                   ';
		  }
		}	
	}
	$str.=' </tbody></table>';
	 return $str;
}
public function feedback1($id,$start,$end)
{
	$res=$this->db->query("select * from appointments where doctor_id='$id' and(app_date > '$start' and app_date < '$end') "); 
	//echo "select * from appointments where doctor_id='$id' and(app_date < '$start' and app_date > '$end') ";exit;
	$str='';
	
	$str='  <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>Patient Name</th>
                                        <th>Feedback</th>
                                        <th>Date</th>
                                      
                                       
                                    </tr>
                                </thead>
                                 <tbody>';
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
			if(!empty($data['feadback']))
			{
			$str.=' <tr>
			                <td>'.$data['patient_name'].'</td>
                            <td>'.$data['feadback'].'</td>
                           <td>'.$data['app_date'].'</td>
                                                                               
                                       
								 </td>
                                    </tr>
                                   ';
		
		 }
		}	
	}
	$str.=' </tbody></table>';
	 return $str;
}
public function prescription($id)
{
	$res=$this->db->query("select * from prescription where doctor_id='$id'");
	$str='';
	
	/*$str='  <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>Drug Name</th>
                                        <th>Drug Type</th>
                                        <th>DRUG DOSAGE</th>
                                        <th>DRUG INSTRUCTION</th>
                                         <th>Action</th>
                                    </tr>
                                </thead>
                                 <tbody>';*/
    $str='<div class="col-sm-12 contentTable">
			<div class="col-sm-12 table-responsive" >
				<table class="patientsList">
					<thead  style="font-weight: 700">
							<tr  style="color: #333333; background-color: white">
								 <th>Drug Name</th>
                                        <th>Drug Type</th>
                                        <th>Drug Dosage</th>
                                        <th>Drug Instruction</th>
                                        <th>Status</th>
                                         <th>Action</th>						
							</tr>
						</thead>
						<tbody>';
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
			$str.=' <tr>
                                        <td>'.$data['name'].'</td>
                                        <td>'.$data['drug_type'].'</td>
                                        <td>'.$data['strength'].'  '.$data['unit'].'</td>
                                        <td>'.$data['instructions'].'</td>         
                                        <td>'.$data['status'].'</td>
                                        <td><div class="patient-list-buttons glyphicon glyphicon-trash" onclick="delete_prescription('.$data['id'].')" ></div>
								 </td>
                                    </tr>
                                   ';
		
		}	
	} else {
		$str.="<td colspan='5'>No Records Found.</td>";
	}
	$str.=' </tbody></table></div></div>';
	 return $str;
}
public function insert_prescription($drug_name,$drug_type,$strength,$unit,$instruction)
{
	$doc_id=$_SESSION['login_id'];
    $check=$this->db->query("select * from medicine where medicine = '$drug_name'");
	if($check->num_rows>0){
	    return FALSE;
	}
	$res=$this->db->query("insert into prescription(name,drug_type,strength,unit,instructions,doctor_id,status) values('$drug_name','$drug_type','$strength','$unit','$instruction','$doc_id','Pending')");
	if(@$res)
	{
		$active_name="Add Prescription";
		
		
		$patient_id=0;
		
		$action='added';
		$date=date('Y-m-d');
	   $time=date("h:i");
		
		$res1=$this->db->query("insert into activity(name,patient_id,doctor_id,action,date,time) values('$active_name','$patient_id','$doc_id','$action','$date','$time') ");
		return TRUE;
	}
}
public function insert_practice($practice_name,$tagline,$practice_address,$locality,$country,$state,$city,$phone_no,$email,$website,$pincode,$image)
{
	$doc_id=$_SESSION['login_id'];
	$res1=$this->db->query("select * from practice where doctor_id='$doc_id'");
	if($res1->num_rows > 0)
	{
	 
		$res=$this->db->query("update practice set practice_name='$practice_name',tagline='$tagline',practice_address='$practice_address',locality='$locality',country='$country',state='$state',city='$city',phone_no='$phone_no',email='$email',website='$website',pincode='$pincode',image='$image' where doctor_id='$doc_id'");
		
		$active_name="Update Practice Doctor";
		$patient_id=0;
		$action='edited';
		$date=date('Y-m-d');
	   $time=date("h:i");
	$res1=$this->db->query("insert into activity(name,patient_id,doctor_id,action,date,time) values('$active_name','$patient_id','$doc_id','$action','$date','$time') ");
	}
	else{
		$res=$this->db->query("insert into practice(practice_name,tagline,practice_address,locality,country,state,city,phone_no,email,website,pincode,doctor_id,image) values('$practice_name','$tagline','$practice_address','$locality','$country','$state','$city','$phone_no','$email','$website','$pincode','$doc_id','$image')");
		$active_name="Insert Practice Doctor";
	
		$patient_id=0;
	
		$action='added';
		$date=date('Y-m-d');
	   $time=date("h:i");
		
		$res1=$this->db->query("insert into activity(name,patient_id,doctor_id,action,date,time) values('$active_name','$patient_id','$doc_id','$action','$date','$time') ");
		
		
	}
	
	if(@$res)
	{
		return TRUE;
	}
}
public function display_practice_doctor($id)
{
	$res=$this->db->query("select * from practice_doctor where doctor_id='$id'");
	$str='';
	
	/*$str='  <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th> Name</th>
                                        <th>Role</th>
                                        <th>Login Status</th>
                                        <th>Last Login</th>
                                         <th>Action</th>
                                    </tr>
                                </thead>
                                 <tbody>';*/
    $str='<div class="col-sm-12 contentTable" style="padding:20px">
			<div class="col-sm-12 table-responsive" >
				<table class="patientsList">
					<thead  style="font-weight: 700">
							<tr  style="color: #333333; background-color: white">
								 <th> Name</th>
                                        <th>Role</th>
                                        <th>Login Status</th>
                                        <th>Last Login</th>
                                         <th>Action</th>						
							</tr>
						</thead>
						<tbody>';
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
			$str.=' <tr>
                                        <td>'.$data['name'].'</td>
                                        <td>'.$data['role'].'</td>
                                        <td>'.$data['status'].'  </td>
                                        <td>'.@$time.'</td>                                  
                                        <td><div onclick="delete_doctor('.$data['id'].')" class="patient-list-buttons glyphicon glyphicon-trash" ></div>
								 </td>
                                    </tr>
                                   ';
		
		}	
	} else {
		$str.="<td colspan='5'>No Records Found.</td>";
	}
	$str.=' </tbody></table></div></div>';
	 return $str;
}
public function insert_practice_doctor($name,$email,$phone,$reg_no,$role,$service)
{
	 $key = '';
                    $keys = array_merge(range(0, 9), range('a', 'z'), range('A', 'Z'));
                    for ($i = 0; $i < 16; $i++)
                     {
                    $key .= $keys[array_rand($keys)];
                     }
	$doc_id=$_SESSION['login_id'];
	$res=$this->db->query("insert into practice_doctor(name,email,phone_no,reg_no,role,status,doctor_id,tokan,education) values('$name','$email','$phone','$reg_no','$role','Active','$doc_id','$key','$service')");
$res=1;
	if(@$res)
	{
			$patient_id=0;
	$active_name='Practice Doctor Added';
		$action='added';
		$date=date('Y-m-d');
	   $time=date("h:i");
		
		$res1=$this->db->query("insert into activity(name,patient_id,doctor_id,action,date,time) values('$active_name','$patient_id','$doc_id','$action','$date','$time') "); 
		
		require_once("../phpmailer/PHPMailerAutoload.php");

              $mail = new PHPMailer();

			//   $email = $_GET['email'];

			 $mailhost = "docconsult.in";
              $smtpUser = "mail@docconsult.in";
              $smtpPassword = "telekast@123";

			  

			  $name = "JPR Infotech";

			  $subject = "Active Your Account| JPR Infotech";

			  $from = "support@jprinfotech.com";

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

                $mail->Body = '<div style="width:100%; height:100%; margin:0;" >

	<div style="background-color:#e9e9e9; width:90%; float:left; height:70px;padding:30px;">

		<span style="width:50%;float:left"> <img src="http://jprinfotech.com/images/logo1.png" /></span>

		<span style="width:50%; text-align:right;float:left;font-size: 17px;"> 24/7 Support:<b> +91-8875555667</b> <br /><b>Customer Name : </b>'. $name.'</span>

	</div>

	<div style="font-size:50px;width:90%;float:left;margin-top:20px;padding-left:26px;"> Please Activate Your Account</div>

	<div  style="font-size:16px;width:90%;float:left;margin-top:20px;padding-left:26px;padding-bottom: 20px; color: #333333;line-height: 22px;" >



<br>

	</div>

	<div style="background-color:#76bb2b;width:90%;height:100%; float:left;padding:30px;margin-top:10">

	 <br>

	
	<a href="'.base_url_doc.'create_password/?tokan='.$key.'" target="_blank"><span style="background-color:#FF8000;color:#fff;width:37%;padding:21px; border-bottom:outset 7px #FF8000;float:left; font-weight:bold; text-align:center; font-size:21px;margin-top:28px; ">  Click Here/span></a>

</div>

<div style="background-color:#e9e9e9; width:90%; float:left; height:17px;padding:30px;margin-top: 10px;"> <center>Copyright &copy; 2010-2016 JPR Infotech Company. All rights reserved.</center></div>

</div>

';
	$mail->Send();
		return true;
	}
}
public function update_practice_doctor_password($new,$tokan)
{
	$res=$this->db->query("update practice_doctor set password='$new' where tokan='$tokan'");
	if(@$res)
	{
		$active_name="Update practic doctor profile ";
	
		$patient_id=0;
	
		$action='edited';
		$date=date('Y-m-d');
	   $time=date("h:i");
		$doc_id=$_SESSION['login_id'];
		$res1=$this->db->query("insert into activity(name,patient_id,doctor_id,action,date,time) values('$active_name','$patient_id','$doc_id','$action','$date','$time') ");
		return TRUE;
	}
	
}
public function login_doctor($username,$password)
{
	$res=$this->db->query("SELECT * FROM `doctors` WHERE `email`='{$username}' AND `password`='{$password}' AND `type` = 'Doctor'");
	
	if($res->num_rows > 0){
			   $data = $res->fetch_assoc();
			   $_SESSION['login_success'] = TRUE;
			   $_SESSION['name'] = $data['name']; 
			   $_SESSION['login_id'] = $data['id'];
			   $_SESSION['email'] = $data['email'];
				//echo error_reporting(E_ALL);
				//echo ini_set('display_errors', TRUE);
				echo "<script> window.location.href='".base_url_doc."calendar/?action=display'; </script> "; 
				//header("Location: ".base_url_doc."dashboard/");
//exit;
		   }

		   else {
		   	 $res=$this->db->query("select * from practice_doctor where email='$username' and password='$password'");
				if($res->num_rows > 0){
					
			   $data = $res->fetch_assoc();
                $data1=$this->getById($data['doctor_id'],"doctors");
			   $_SESSION['login_success'] = TRUE;

			   $_SESSION['name'] = $data1['name']; 
			   $_SESSION['login_id'] = $data1['id'];
			   $_SESSION['email'] = $data1['email'];
			   if($data['role']=='Administrator')
			   {
			  
			   
			   }
			   elseif($data['role']=='Receptionist')
			   {
			   	$_SESSION['receptionist']=true;
			   }
			    elseif($data['role']=='Front_Desk')
			   {
			   	$_SESSION['front_desk']=true;
			   }
			    elseif($data['role']=='Biller')
			   {
			   	$_SESSION['biller']=true;
			   }
			
echo "<script> window.location.href='".base_url_doc."dashboard/'; </script> "; 
			   //header("Location: ".base_url_doc."dashboard/");

		   }
		   else
		   {
		   	return FALSE;
		   }
			   

		   }
}
public function update_practice_doctor($name,$email,$phone,$reg_no,$role,$id)
{
	$res=$this->db->query("update practice_doctor set name='$name',email='$email',phone_no='$phone',reg_no='$reg_no',role='$role' where id='$id' ");
	if(@$res)
	{
		$active_name="Update practice doctor profile";
	
		$patient_id=0;
	
		$action='edited';
		$date=date('Y-m-d');
	   $time=date("h:i");
		$doc_id=$_SESSION['login_id'];
		$res1=$this->db->query("insert into activity(name,patient_id,doctor_id,action,date,time) values('$active_name','$patient_id','$doc_id','$action','$date','$time') ");
		return true;
	}
}
public function add_under_option()
{
	$doc_id=$_SESSION['login_id'];
	$str='';
	$res=$this->db->query("select * from procedure_catalog where doctor_id='$doc_id'");
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
			$str.='<option value="'.$data['id'].'">'.$data['name'].' </option>';
		}
	}
	return $str;
}
public function add_procedure_catelog($name,$cost,$note,$tax)
{
	$doc_id=$_SESSION['login_id'];
	$total_cost =(1+($tax/100))*$cost;
	
	$noterray = array();
	$notearray[0] = $note;
	$note = json_encode($notearray);
	
	$res=$this->db->query("insert into procedure_catalog(name,cost,note,doctor_id,tax,total_amount) values('$name','$cost','$note','$doc_id','$tax','$total_cost')");
	if(@$res)
	{
		$active_name="add procedure catalog";
		
		$patient_id=0;
		
		$action='add';
		$date=date('Y-m-d');
	   $time=date("h:i");
		
		$res1=$this->db->query("insert into activity(name,patient_id,doctor_id,action,date,time) values('$active_name','$patient_id','$doc_id','$action','$date','$time') ");
		return true;
	}
}
public function dispaly_procedure_catalog()
{
	$id=$_SESSION['login_id'];
	$res=$this->db->query("select * from procedure_catalog where doctor_id='$id'");
	$str='';
	
	/*$str='  <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>Treatment Name</th>
                                        <th>Cost</th>
                                        <th>Under</th>
                                        <th>Note</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                 <tbody>';*/
     $str='<div class="col-sm-12 contentTable">
			<div class="col-sm-12 table-responsive" >
				<table class="patientsList" id="procedureCatalog">
					<thead  style="font-weight: 700">
							<tr  style="color: #333333; background-color: white">
								 <th>Treatment Name</th>
                                        <th>Cost(&#8377;)</th>
                                        <th>Tax(%)</th>
                                        <th>Amount(&#8377;)</th>
                                        <th>Note</th>
                                        <th>Action</th>					
							</tr>
						</thead>
						<tbody>';
						$count = 1;
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
		    $note = json_decode($data['note'],TRUE);
			$str.=' <tr>
                                        
                                        <td>'.$data['name'].'</td>
                                        <td>'.$data['cost'].'</td>
                                        <td>'.$data['tax'].'</td>
                                        <td>'.$data['total_amount'].'</td>
                                        <td>'.$note[0].'</td>                                  
                                        <td><div class="patient-list-buttons glyphicon glyphicon-pencil edit-btn" onclick="editprocedure('.$count.','.$data['id'].');"><div class="patient-list-buttons glyphicon glyphicon-trash" onclick="delete_procedure_catalog('.$data['id'].')"></div>
								 </td>
                                    </tr>
                                   ';
                                   $count++;
		
		}	
	} else {
		$str.="<td colspan='4'>No Records Found.</td>";
	}
	$str.=' </tbody></table></div></div>';
	 return $str;
}

public function edit_under_option($value)
{
	$doc_id=$_SESSION['login_id'];
	$str='';
	$res=$this->db->query("select * from procedure_catalog where doctor_id='$doc_id'");
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{ 
			if($data['under']==$value)
			{
				$selected='Selected';
			}
			else{
				$selected='';
			}
			$str.='<option value="'.$data['name'].'" '.$selected.'>'.$data['name'].' </option>';
		}
	}
	return $str;
}
// public function edit_procedure_catelog($name,$cost,$under,$note,$id)
// {
// 	$res=$this->db->query("update procedure_catalog set name='$name',cost='$cost',under='$under',note='$note' where id='$id'");
// 	if(@$res)
// 	{
// 		$active_name="Update Procedure Catalog";
	
// 		$patient_id=0;
	
// 		$action='edited';
// 		$date=date('Y-m-d');
// 	   $time=date("h:i");
// 		$doc_id=$_SESSION['login_id'];
// 		$res1=$this->db->query("insert into activity(name,patient_id,doctor_id,action,date,time) values('$active_name','$patient_id','$doc_id','$action','$date','$time') ");
// 		return true;
// 	}
// }
public function edit_procedure_catalog($id,$name,$cost,$tax,$amount,$note)
{
    $notearray = array();
    $notearray[0] = $note;
    $note = json_encode($notearray);
    $amount = intval($cost)*(1+(intval($tax)/100));
    $res = $this->db->query("update procedure_catalog set name='$name',cost='$cost',tax='$tax',note='$note',total_amount='$amount' where id='$id'");
    if($res)
    {return TRUE;}
}
public function add_tax($tax,$tax_value)
{
	$doc_id=$_SESSION['login_id'];
	$res=$this->db->query("insert into tax(tax,value,doctor_id) values('$tax','$tax_value','$doc_id')");
	if(@$res)
	return true;
}
public function dispaly_tax()
{
	$id=$_SESSION['login_id'];
	$res=$this->db->query("select * from tax where doctor_id='$id'");
	$str='';
	
	/*$str='  <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>Tax Name</th>
                                        <th>Value</th>
                                        
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                 <tbody>';*/
    $str='<div class="col-sm-12 contentTable">
			<div class="table-responsive">
				<table class="patientsList">
					<thead  style="font-weight: 700">
							<tr  style="color: #333333; background-color: white">
								  <th>Tax Name</th>
                                        <th>Value</th>
                                        
                                        <th>Action</th>						
							</tr>
						</thead>
						<tbody>';
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
			$str.=' <tr>
                                        <td>'.$data['tax'].'</td>
                                        <td>'.$data['value'].'</td>
                                                                      
                                        <td><div class="patient-list-buttons glyphicon glyphicon-trash" onclick="delete_tax('.$data['id'].')"></div>
								 </td>
                                    </tr>
                                   ';
		
		}	
	}
	else {
		$str.="<td colspan='3'>No Records Found.</td>";
	}
	$str.=' </tbody></table></div></div>';
	 return $str;
}

public function add_mode($mode,$type,$vandor_fee)
{
	$doc_id=$_SESSION['login_id'];
	
	$res=$this->db->query("insert into mode_of_payment(mode,type,vendor_fee,doctor_id) values('$mode','$type','$vandor_fee','$doc_id')");
	if(@$res)
	{
		return TRUE;
	}
}
public function dispaly_mode()
{
	$id=$_SESSION['login_id'];
	$res=$this->db->query("select * from mode_of_payment where doctor_id='$id'");
	$str='';
	
	/*$str='  <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>Mode Of Payment</th>
                                        <th>Type</th>
                                        <th>Vendor Fee</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                 <tbody>';*/
     $str='<div class="col-sm-12 contentTable">
			<div class="table-responsive">
				<table class="patientsList">
					<thead  style="font-weight: 700">
							<tr  style="color: #333333; background-color: white">
								 <th>Mode Of Payment</th>
                                        <th>Type</th>
                                        <th>Vendor Fee</th>
                                        <th>Action</th>				
							</tr>
						</thead>
						<tbody>';
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
			$str.=' <tr>
                                        <td>'.$data['mode'].'</td>
                                        <td>'.$data['type'].'</td>
                                        <td>'.$data['vendor_fee'].'</td>                        
                                        <td><div class="patient-list-buttons glyphicon glyphicon-trash" onclick="delete_mode_of_payment('.$data['id'].')"></div>
								 </td>
                                    </tr>
                                   ';
		
		}	
	} else {
		$str.="<td colspan='4'>No Records Found.</td>";
	}
	$str.=' </tbody></table></div></div>';
	 return $str;
}

public function dispaly_mode_of_payment()
{
	$id=$_SESSION['login_id'];
	$res=$this->db->query("select * from mode_of_payment where doctor_id='$id'");
	$str='';
	if($res->num_rows > 0)
	{   
	    $str.='<option value="0">Select Payment Mode</option>';
		while($data=$res->fetch_assoc())
		{
			$str.='<option value="'.$data['mode'].'">'.$data['mode'].'</option>';
		
		}	
	}
	 return $str;
}
public function add_hide_detail($payment,$invoice)
{     $doc_id=$_SESSION['login_id'];
	 $res1=$this->db->query("select * from hide_detail where doctor_id='$doc_id'");
	if($res1->num_rows > 0)
	{
		$res=$this->db->query("update hide_detail set payment='$payment',invoice='$invoice' where doctor_id='$doc_id'");    
		
	
	}
	else{
		$res=$this->db->query("insert into hide_detail(payment,invoice,doctor_id) values('$payment','$invoice','$doc_id')");
	}
	
	if(@$res)
	{
		return true;
	}
}
public function tax_dropdown()
{
    $doc_id=$_SESSION['login_id'];
	$res=$this->db->query("select * from tax where doctor_id='$doc_id'");
	$str='<option value="0">Tax-Free</option>';
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
			$str.='<option value="'.$data['id'].'">'.$data['tax'].'</option>';
		}
	}
	return $str;
}
public function tax_dropdown1()
{
    $doc_id=$_SESSION['login_id'];
	$res=$this->db->query("select * from tax where doctor_id='$doc_id'");
	$str='<option value="0" selected>Tax-Free</option>';
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
			$str.='<option value="'.$data['value'].'">'.$data['tax'].'</option>';
		}
	}
	return $str;
}
public function tax_dropdown2()
{
    $doc_id=$_SESSION['login_id'];
	$res=$this->db->query("select * from tax where doctor_id='$doc_id'");
	$str='<option value="0" selected>Tax-Free</option>';
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
			$str.='<option value="'.$data['value'].'">'.$data['tax'].'</option>';
		}
	}
	return $str;
}
public function add_referrer($name)
{
	$doc_id=$_SESSION['login_id'];
	$res=$this->db->query("insert into referrer(name,doctor_id) values('$name','$doc_id')");
	if(@$res)
	{
		return true;
	}
}
public function referrer($doc_id)
{
	$res=$this->db->query("select * from referrer where doctor_id='$doc_id'");
	$str='';
	
	$str='  <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                       <th>Action</th>
                                    </tr>
                                </thead>
                                 <tbody>';
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
			$str.=' <tr>
                                        <td>'.$data['name'].'</td>
                                                          
                                        <td><a href="'.base_url_doc.'setting/?delete_referrer='.$data['id'].'" class="btn btn-info" onclick="return conf();"><i class="material-icons">clear</i></a>
								 </td>
                                    </tr>
                                   ';
		
		}	
	}
	$str.=' </tbody></table>';
	 return $str;
	
}
public function add_complaints($name,$doc_id)
{
	$doc_id=$_SESSION['login_id'];
	$res=$this->db->query("insert into complaints(name,doctor_id) values('$name','$doc_id')");
	if(@$res)
	{
		return true;
	}
}
public function dispaly_complaints()
{ $doc_id=$_SESSION['login_id'];
	$res=$this->db->query("select * from complaints where doctor_id='$doc_id'");
	$str='';
	
	$str='  <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                       <th>Action</th>
                                    </tr>
                                </thead>
                                 <tbody>';
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
			$str.=' <tr>
                                        <td>'.$data['name'].'</td>
                                                          
                                        <td><a href="'.base_url_doc.'setting/?delete_complaints='.$data['id'].'" class="btn btn-info" onclick="return conf();"><i class="material-icons">clear</i></a>
								 </td>
                                    </tr>
                                   ';
		
		}	
	}
	$str.=' </tbody></table>';
	 return $str;
	
}
public function add_observations($name,$doc_id)
{
	$doc_id=$_SESSION['login_id'];
	$res=$this->db->query("insert into observations(name,doctor_id) values('$name','$doc_id')");
	if(@$res)
	{
		return true;
	}
}
public function dispaly_observations()
{ $doc_id=$_SESSION['login_id'];
	$res=$this->db->query("select * from observations where doctor_id='$doc_id'");
	$str='';
	
	$str='  <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                       <th>Action</th>
                                    </tr>
                                </thead>
                                 <tbody>';
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
			$str.=' <tr>
                                        <td>'.$data['name'].'</td>
                                                          
                                        <td><a href="'.base_url_doc.'setting/?delete_observations='.$data['id'].'" class="btn btn-info" onclick="return conf();"><i class="material-icons">clear</i></a>
								 </td>
                                    </tr>
                                   ';
		
		}	
	}
	$str.=' </tbody></table>';
	 return $str;
	
}
public function add_dignoses($name,$doc_id)
{
	$doc_id=$_SESSION['login_id'];
	$res=$this->db->query("insert into dignoses(name,doctor_id) values('$name','$doc_id')");
	if(@$res)
	{
		return true;
	}
}
public function dispaly_dignoses()
{ $doc_id=$_SESSION['login_id'];
	$res=$this->db->query("select * from dignoses where doctor_id='$doc_id'");
	$str='';
	
	$str='  <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                       <th>Action</th>
                                    </tr>
                                </thead>
                                 <tbody>';
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
			$str.=' <tr>
                                        <td>'.$data['name'].'</td>
                                        <td><a href="'.base_url_doc.'setting/?delete_dignoses='.$data['id'].'" class="btn btn-info" onclick="return conf();"><i class="material-icons">clear</i></a>
								 </td>
                                    </tr>
                                   ';
		
		}	
	}
	$str.=' </tbody></table>';
	 return $str;
	
}
public function add_investigations($name,$doc_id)
{
	$doc_id=$_SESSION['login_id'];
	$res=$this->db->query("insert into investigations(name,doctor_id) values('$name','$doc_id')");
	if(@$res)
	{
		return true;
	}
}
public function dispaly_investigations()
{ $doc_id=$_SESSION['login_id'];
	$res=$this->db->query("select * from investigations where doctor_id='$doc_id'");
	$str='';
	
	$str='  <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                       <th>Action</th>
                                    </tr>
                                </thead>
                                 <tbody>';
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
			$str.=' <tr>
                                        <td>'.$data['name'].'</td>
                                        <td><a href="'.base_url_doc.'setting/?delete_investigations='.$data['id'].'" class="btn btn-info" onclick="return conf();"><i class="material-icons">clear</i></a>
								 </td>
                                    </tr>
                                   ';
		
		}	
	}
	$str.=' </tbody></table>';
	 return $str;
	
}

public function add_file_labels($name,$doc_id)
{
	$doc_id=$_SESSION['login_id'];
	$res=$this->db->query("insert into file_labels(name,doctor_id) values('$name','$doc_id')");
	if(@$res)
	{
		return true;
	}
}
public function dispaly_file_labels()
{ $doc_id=$_SESSION['login_id'];
	$res=$this->db->query("select * from file_labels where doctor_id='$doc_id'");
	$str='';
	
	$str='  <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                       <th>Action</th>
                                    </tr>
                                </thead>
                                 <tbody>';
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
			$str.=' <tr>
                                        <td>'.$data['name'].'</td>
                                        <td><a href="'.base_url_doc.'setting/?delete_file_labels='.$data['id'].'" class="btn btn-info" onclick="return conf();"><i class="material-icons">clear</i></a>
								 </td>
                                    </tr>
                                   ';
		
		}	
	}
	$str.=' </tbody></table>';
	 return $str;
	
}
public function add_vital_sign($name,$doc_id)
{
	$doc_id=$_SESSION['login_id'];
	$res=$this->db->query("insert into vital_sign(name,doctor_id) values('$name','$doc_id')");
	if(@$res)
	{
		return true;
	}
}
public function dispaly_vital_sign()
{ $doc_id=$_SESSION['login_id'];
	$res=$this->db->query("select * from vital_sign where doctor_id='$doc_id'");
	$str='';
	
	$str='  <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                       <th>Action</th>
                                    </tr>
                                </thead>
                                 <tbody>';
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
			$str.=' <tr>
                                        <td>'.$data['name'].'</td>
                                        <td><a href="'.base_url_doc.'setting/?delete_vital_sign='.$data['id'].'" class="btn btn-info" onclick="return conf();"><i class="material-icons">clear</i></a>
								 </td>
                                    </tr>
                                   ';
		
		}	
	}
	$str.=' </tbody></table>';
	 return $str;
	
}
public function add_note($name,$doc_id)
{
	$doc_id=$_SESSION['login_id'];
	$res=$this->db->query("insert into note(name,doctor_id) values('$name','$doc_id')");
	if(@$res)
	{
		return true;
	}
}
public function dispaly_note()
{ $doc_id=$_SESSION['login_id'];
	$res=$this->db->query("select * from note where doctor_id='$doc_id'");
	$str='';
	
	$str='  <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                       <th>Action</th>
                                    </tr>
                                </thead>
                                 <tbody>';
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
			$str.=' <tr>
                                        <td>'.$data['name'].'</td>
                                        <td><a href="'.base_url_doc.'setting/?delete_note='.$data['id'].'" class="btn btn-info" onclick="return conf();"><i class="material-icons">clear</i></a>
								 </td>
                                    </tr>
                                   ';
		
		}	
	}
	$str.=' </tbody></table>';
	 return $str;
	
}
public function display_referrer_dropdown($doc_id)
{
	$res=$this->db->query("select * from referrer where doctor_id='$doc_id'");
	$str='';
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
			$str.='<option value="'.$data['id'].'">'.$data['name'].'</option>';
		}
	}
	return $str;
}
public function add_medical_history($name,$doc_id)
{
	$doc_id=$_SESSION['login_id'];
	$res=$this->db->query("insert into medical_history(name,doctor_id) values('$name','$doc_id')");
	if(@$res)
	{
		return true;
	}
}
public function display_medical_history()
{ $doc_id=$_SESSION['login_id'];
	$res=$this->db->query("select * from medical_history where doctor_id='$doc_id'");
	$str='';
	
	/*$str='  <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                       <th>Action</th>
                                    </tr>
                                </thead>
                                 <tbody>';*/
     $str='<div class="col-sm-12 contentTable">
			<div class="col-sm-12 table-responsive" >
				<table class="patientsList">
					<thead  style="font-weight: 700">
							<tr  style="color: #333333; background-color: white">
								 <th>Name</th>
                                       <th>Action</th>			
							</tr>
						</thead>
						<tbody>';
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
			$str.=' <tr>
                                        <td>'.$data['name'].'</td>
                                        <td><div class="patient-list-buttons glyphicon glyphicon-trash" onclick="delete_medical_history('.$data['id'].')"></div>
								 </td>
                                    </tr>
                                   ';
		
		}	
	} else {
		$str.="<td colspan='2'>No Records Found.</td>";
	}
	$str.=' </tbody></table></div></div>';
	 return $str;
	
}
public function medical_history_dropdown($doc_id)
{
	$str='';
	$res=$this->db->query("select * from medical_history where doctor_id='$doc_id'");
	 if($res->num_rows >0);
	 {
	 	 while($data=$res->fetch_assoc())
	 	 {
		 	$str.='<option value="'.$data['id'].'"> '.$data['name'].'  </option>';
		 }
	 }
	 return $str;
}
public function edit_medical_history_dropdown($id)
{
	$str='';
	$doc_id=$_SESSION['login_id'];
	$res=$this->db->query("select * from medical_history where doctor_id='$doc_id'");
	 if($res->num_rows >0);
	 {
	 	 while($data=$res->fetch_assoc())
	 	 {
	 	 	 if($data['id']==$id)
		  {
		  	$select='selected';
		  }
		  else{
		  	$select='';
		  }
		 	$str.='<option value="'.$data['id'].'" '.$select.'> '.$data['name'].'  </option>';
		 }
	 }
	 return $str;
}
public function edit_group_dropdown($id)
{
	$str='';
	$doc_id=$_SESSION['login_id'];
	$res=$this->db->query("select * from groups where doctor_id='$doc_id'");
	 if($res->num_rows >0);
	 {
	 	 while($data=$res->fetch_assoc())
	 	 {
	 	 	 if($data['id']==$id)
		  {
		  	$select='selected';
		  }
		  else{
		  	$select='';
		  }
		 	$str.='<option value="'.$data['id'].'" '.$select.'> '.$data['name'].'  </option>';
		 }
	 }
	 return $str;
}
public function edit_referrer_dropdown($id)
{ 
	$doc_id=$_SESSION['login_id'];
	$res=$this->db->query("select * from referrer where doctor_id='$doc_id'");
	$str='';
	if($res->num_rows >0)
	{
		 while($data=$res->fetch_assoc())
		 { 
		 if($data['id']==$id)
		  {
		  	$select='selected';
		  }
		  else{
		  	$select='';
		  }
		 
		  $str.='<option value="'.$data['id'].'" '.$select.'> '.$data['name'].'</option>';
		 }
	}
	return $str;
}
public function display_patient_appointment($doc_id)
{
	$res=$this->db->query("select * from patient where doctor_id='$doc_id'");
	$str='';
	$str='  <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                          <th>Patient Id</th>
                                        <th>Email</th>
                                         <th>Phone No</th>
                                        <th>Address</th>
                                        <th>City</th>
                                        <th>State</th>
                                       
                                         <th>Pincode</th>
                                         <th>Action</th>
                                    </tr>
                                </thead>
                                 <tbody>';
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
			$str.=' <tr>
                                        <td>'.$data['name'].'</td>
                                        <td>'.$data['patient_id'].'</td>
                                        <td>'.$data['email'].'</td>
                                        <td>'.$data['phone_no'].'</td>
                                        <td>'.$data['address'].'</td>
                                        <td>'.$data['city'].'</td>
                                        <td>'.$data['state'].'</td>
                                        <td>'.$data['pincode'].'</td>
                                        <td><a href="'.base_url_doc.'patient/?add_new_appointment='.$data['id'].'" class="btn btn-info"><i class="material-icons">edit</i></a>
								 </td>
                                    </tr>
                                   ';
		
		}	
	}
	$str.=' </tbody></table>';
	 return $str;
	
}
public function prescription_for_patient($drug_type)
{
	
	$res=$this->db->query("select * from prescription where drug_type = '$drug_type'");
	$str='';
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
			$str.='<option value="'.$data['id'].'" data-id="'.$data['id'].'" class="pre">'.$data['drug_type'].' '.$data['name'].' '.$data['strength'].' '.$data['unit'].' </option>';
		}
	}
	return $str;
}
public function add_treatment_patient($name,$strength,$unit,$duration,$day,$morning,$noon,$night,$food,$patient_id,$instruction)
{
	$doc_id=$_SESSION['login_id'];
	$date=date('Y-m-d');
	
	$res=$this->db->query("insert into prescription_patient(drug_name,strength,unit,duration,days,morning,noon,night,food,doctor_id,patient_id,date,instruction,remark) values('$name','$strength','$unit','$duration','$day','$morning','$noon','$night','$food','$doc_id','$patient_id','$date','$instruction','$remark')");
	if(@$res)
	{
		$active_name="prescription";
		$res1=$this->db->query("select * from prescription_patient where doctor_id='$doc_id' order by id DESC limit 1");
		$data=$res1->fetch_assoc();
		 $data2=$this->getByDoctorId($_SESSION['login_id'],"print_setting");;
		$patient_id=$data['patient_id'];
		$patient_id=$this->getById($patient_id,"patient");
		$patient=$patient_id;
		$patient_id=$patient_id['name'];
		 $doctor=$this->getById($data['doctor_id'],"doctors");
		
 $body='<link href="<?php echo base_url; ?>style.css" rel="stylesheet" />
 <div class="main_content">
		<div class="inner_print_div">
				<div class="header_left_print">
					<div class="image_print">'; if(!empty($data2['logo'])) { $body.='<img  src="'. base_url.'/image/'.$data2['logo'].'" width="200px" /> '; }
					else { $body.=' <h2>'.$data2['header'].'</h2>'; } $body.='</div>
				
					<div class="header_left_header">'. $data2['header_left'].'</div>

				</div>
				<div class="header_right_header">
				'. $data2['header_right'].'
				
				
				</div>
			
				</div>
				<div class="sub_div "><h3>'. $patient['name'].' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'. $patient['gender'].'</h3>
				'. $patient['patient_id'].'<br>'.$patient['phone_no'].'<br>'.$patient['email'].'<br>
					
					
					
				
</div>		
<div class="sub_b_div ">
				<h3> By '.$doctor['be_name'].". ".$doctor['name'].' </h3>
					
					
				
</div>	
<Div class="heading_print"> <h3> Prescription(R<sub>x</sub>)</h3></Div>
<div class="table_div_print">
	 <div style="width: 98%;float: left;padding: 10px;background: #ccc;">
                        <div style="width: 20%;float:left;font-weight:bold;">Drug Name
                        </div>
                        <div style="width: 10%;float:left;font-weight:bold">Stregth</div>
                        <div style="width: 10%;float:left;font-weight:bold">Unit</div>
                        <div style="width: 10%;float:left;font-weight:bold">Duration</div>
                        <div style="width: 10%;float:left;font-weight:bold">Morning</div>
                        <div style="width: 10%;float:left;font-weight:bold">Noon</div>
                        <div style="width: 10%;float:left;font-weight:bold">Night</div>
                        <div style="width: 10%;float:left;font-weight:bold">Food</div>
                         </div>
		 <div style="width: 100%;float: left;padding: 10px;">
                         <div style="width: 20%;float:left;">'; $drug_name=json_decode($data['drug_name'],true); 
                         foreach($drug_name as $key=>$drug) { $key1=$key+1; $body.='<div style="width: 100%;float:left;">'.$key1.'  '. $drug.'</div>'; } $body.='</div>
                         
                         <div style="width: 10%;float:left;">'; $strength=json_decode($data['strength'],true);  foreach($strength as $stren) {  $body.='<div style="width: 100%;float:left;">'.  $stren.' </div>    '; }  $body.=' </div>
                         
                         <div style="width: 10%;float:left;">'; $strength=json_decode($data['unit'],true);  foreach($strength as $stren) { $body.='<div style="width: 100%;float:left;">'.  $stren.'</div>   '; } $body.='</div>
                         
                         <div style="width: 10%;float:left;">';
                        $duration=json_decode($data['duration'],true);
                         $d='';
                          $days=json_decode($data['days'],true); foreach($days as $key=>$da) { $d[$key]=$da; }  foreach($duration as $key=>$stren) { $body.='<div style="width: 100%;float:left;">'.  $stren. ''.$d[$key].' </div>'; } $body.=' </div>
                          <div style="width: 10%;float:left;">'; $strength=json_decode($data['morning'],true);  foreach($strength as $stren) { $body.=' <div style="width: 100%;float:left;">'.  $stren.'</div>    '; }$body.='</div> 
                           <div style="width: 10%;float:left;">'; $strength=json_decode($data['noon'],true);  foreach($strength as $stren) { $body.='<div style="width: 100%;float:left;">'.  $stren.'</div>'; } $body.='</div>  <div style="width: 10%;float:left;">'; $strength=json_decode($data['night'],true);  foreach($strength as $stren) { $body.='<div style="width: 100%;float:left;">'.  $stren.'</div>    '; } $body.=' </div>
                           <div style="width: 10%;float:left;">'; $strength=json_decode($data['food'],true);
                             foreach($strength as $stren) { $body.='<div style="width: 100%;float:left;">'.  $stren.' </div>'; }   $body.='</div><br>
                         
                         <div style="width: 100%;float:left;">'; $strength=json_decode($data['instruction'],true); 
                         foreach($strength as $key=>$stren) { $body.='<div style="width: 100%;float:left;"><br>Instructions for '.$key1.' :'. $stren.' </div>'; } $body.=' </div>
                         </div>
	
</div>	
	
<div class="sub_bottom_div">'. @$data2['footer'].' </div>
<div class="sub_bottom_div2">'.@$data2['footer_left'].'</div>
<div class="sub_bottom_div3">'. @$data2['footer_right'].'</div>

			</div>
				
 ';
 include "../mpdf/mpdf.php";
$file_name="pre#".$data["id"].".pdf";
	//Printing content
$stylesheet = file_get_contents('../style.css');
$mpdf=new mPDF($body);
$mpdf->WriteHTML($stylesheet,1);
$mpdf->WriteHTML($body,2);
$mpdf->Output("../pdf/".$file_name , "F");

		
		
		$action='added';
		$date=date('Y-m-d');
	   $time=date("h:i");
		
		$res1=$this->db->query("insert into activity(name,patient_id,doctor_id,action,date,time) values('$active_name','$patient_id','$doc_id','$action','$date','$time') ");
		return TRUE;
		
	}
}

public function add_patient_prescription($drug_name,$duration,$date,$instruction,$patient_id){
    
    	$doc_id=$_SESSION['login_id'];
    $res1=$this->db->query("insert into prescription_patient(drug_name,patient_id,doctor_id,duration,date,instruction) values('$drug_name','$patient_id','$doc_id','$duration','$date','$instruction') ");
    
    if($res1){
        
        return TRUE;
    }
}

// public function display_patient_prescription($doc_id,$patient_id)
// {
// 	if($patient_id == ''){
// 		$res=$this->db->query("select * from prescription_patient where doctor_id='$doc_id'");
// 	}
// 	else{
// 		$res=$this->db->query("select * from prescription_patient where patient_id='$patient_id'");
// 	}
	
// 	$str='  <table class="table table-striped table-responsive patient-profile-tables">
//                                 <thead>
//                                     <tr>
//                                         <th>Date</th>
//                                         <th>Durg Name</th>
//                                         <th>Duration</th>
//                                         <th>Instructions</th>
//                                         <th>Action</th>
//                                     </tr>
//                                 </thead>
//                                  <tbody>';
// 	if($res->num_rows > 0)
// 	{
// 		while($data=$res->fetch_assoc())
// 		{
// 			$data1=$this->getById($data['patient_id'],"patient");
// 			$str.=' <tr><td>'.$data['date'].' </td><td>';
//                                         $drug_name=json_decode($data['drug_name']);
                                        
//                                         foreach($drug_name as $drug)
//                                         {
// 											$str.='<b>'.$drug.'</b><br>';
// 										}
//                                         $str.='</td><td>';
//                                          $durations=json_decode($data['duration']);
                                        
//                                         foreach($durations as $duration)
//                                         {
// 											$str.=''.$duration.'<br>';
// 										}
//                                         $str.='</td><td>';
//                                          $instruction=json_decode($data['instruction']);
                                        
//                                         foreach($instruction as $instruct)
//                                         {
// 											$str.=''.$instruct.'<br>';
// 										}
//                                       $str.='
                                       

//                                       		<td ><a style="float:left" href="'.base_url_doc.'patient/?prescription_edit='.$data['id'].'" 
//                                         ><div class="patient-list-buttons glyphicon glyphicon-pencil" ></div></a>
//                                         <a style="float:left" href="'.base_url_doc.'patient-detail-page.php?patient_id='.$_GET['patient_id'].'&prescription_delete='.$data['id'].'"  onclick="return conf();"
//                                         ><div class="patient-list-buttons glyphicon glyphicon-trash" ></div></a>
//                                      <a  style="float:left" href="'.base_url_doc.'print_prescription/?id='.$data['id'].'" target="_blank"
//                                         ><div class="patient-list-buttons glyphicon glyphicon-print" ></div></a>
//                                       		</td></tr>';
		
// 		}	
// 	} else {
// 		$str.="<tr><td colspan=5>No Records Found To Show.</td></tr>";
// 	}
// 	$str.=' </tbody></table>';
	
// 	 return $str;
	
// }

public function display_patient_prescription($doc_id,$pid)
{
    //echo $pid;
	$res = $this->db->query("select * from prescription_patient where doctor_id='$doc_id' and patient_id='$pid' ORDER BY date DESC");
    //echo $res->num_rows;
	//$data = $res->fetch_assoc();

	$str = '';
	$str='<div class="col-sm-12 table-responsive" >   <table id="drug_patient" class="table table-striped  patient-profile-tables">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Durg Name</th>
                                        <th>Strength</th>
                                        <th>Duration</th>
                                        <th>Food</th>
                                        <th>Instructions</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                 <tbody>';
    if($res->num_rows > 0) 
	{
		while($data=$res->fetch_assoc())
		{
			//$data1=$this->getById($pid,"patient");
			$str.=' <tr><td><input type="hidden" value='.$data['date'].'>'.date("j F Y",strtotime($data['date'])).' </td><td>';

			$drug_names = json_decode($data['drug_name']);
			foreach($drug_names as $drugname)
			{
				$str.='<b>'.$drugname.'</b><br>';
			}
			$str.='</td><td>';

            $strength = json_decode($data['strength']);
            $unit = json_decode($data['unit']);
            $count = 0;
            foreach($strength as $st)
            {
                $str.='<b>'.$st.' '.$unit[$count].'</b><br>';	
            	$count++;
            }
            	$str.='</td><td>';
            $durations=json_decode($data['duration']);
            $time = json_decode($data['days']);
            $count = 0;
            foreach($durations as $duration)
            {
                
            	$str.='<b>'.$duration.' '.$time[$count].'</b><br>';	
            	$count++;
            }
            $str.='</td><td>';
            
            $food = json_decode($data['food']);
            foreach($food as $food)
            {
            	$str.=''.$food.'<br>';
			}
            $str.='</td><td>';
            
            $instruction=json_decode($data['instruction']);
            foreach($instruction as $instruct)
            {
            	$str.=''.$instruct.'<br>';
			}
			$str.='</td>';


			$str.='<td ><a style="float:left" href="prescription_edit.php?id='.$data['id'].'" 
                                        ><div class="patient-list-buttons glyphicon glyphicon-pencil" ></div></a>
                                        <a style="float:left" href="'.base_url_doc.'patient-detail-page.php?patient_id='.$pid.'&prescription_delete='.$data['id'].'"  onclick="return conf();"
                                        ><div class="patient-list-buttons glyphicon glyphicon-trash" ></div></a>
                                       		</td></tr>';

		}
	}
	else
	{
		$str.="<tr><td colspan=5>No Records Found To Show.</td></tr>";
	}

	$str.=' </tbody></table></div>';
	
	 return $str;
}


public function display_invoice_show($doc_id,$pid)
{
    //echo $pid;
	$res = $this->db->query("select * from bill_info where doctor_id='$doc_id' and patient_id='$pid' ORDER BY date DESC");
    //echo $res->num_rows;
	//$data = $res->fetch_assoc();
    
	$str = '';
	$str=' <div class="col-sm-12 table-responsive" >  <table  class="table table-striped table-responsive patient-profile-tables" id="invoiceTable">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Treatment</th>
                                        <th>Amount</th>
                                        <th>Discount</th>
                                        <th>Tax</th>
                                        <th>Total</th>
                                        <th>Pending</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                 <tbody>';
                                 $count=1;
    if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
			//$data1=$this->getById($pid,"patient");
			$str.=' <tr><td> <input type="hidden" value='.$data['date'].'>'.date("j F Y",strtotime($data['date'])).' </td><td>';

			$names = json_decode($data['name'],TRUE);
			foreach($names as $name)
			{
				$str.=''.$name.'<br>';
			}
			$str.='</td><td>';

            $amount = json_decode($data['amount'],TRUE);
            
            
            foreach($amount as $at)
            {
                $str.=''.$at.'<br>';	
            	
            }
            	$str.='</td><td>';
            $discount=json_decode($data['discount'],TRUE);
            foreach($discount as $dis)
            {
                
            	$str.=''.number_format((float)$dis,2,'.','').'<br>';	
            	
            }
            $str.='</td><td>';
            if($data['tax'])
            {
                $tax=json_decode($data['tax'],TRUE);
                foreach($tax as $dis)
                {
                    if(intval($dis))
                	$str.=''.$this->get_taxname_by_id($dis).":".$this->get_tax_by_id($dis).'<br>';
                	else
                    $str.='Tax Free';
    
                	
                }
                $str.='</td><td>';
            }
            else
                $str.='Tax Free</td><td>';
            
            
            	$str.=''.$data['total'].'';
			
            
			$str.='</td>';
            $str.='<td>'.$data['pending_amount'].'</td>';

			$str.='<td >
                                        <a href="'.base_url_doc.'patient-detail-page.php?patient_id='.$pid.'&delete_invoice='.$data['id'].'" ><div class="patient-list-buttons glyphicon glyphicon-trash"></div></a>
                                     <a  style="float:left" href="'.base_url_doc.'invoice.php?id='.$data['id'].'&pid='.$pid.'&date='.$data['date'].'" target="_blank"
                                        ><div class="patient-list-buttons glyphicon glyphicon-print" ></div></a>';
                                        if($data['pending_amount']!=0){
                                        $str.='<div class="patient-list-buttons glyphicon glyphicon-ok editinvoicebtn" onclick="change_invoice_status('.$count.','.$data['id'].')"></div>';}
                                       	$str.='</td></tr>';
                                       	$count++;

		}
	}
	else
	{
		$str.="<tr><td colspan=5>No Records Found To Show.</td></tr>";
	}

	$str.=' </tbody></table></div>';
	
	 return $str;
}
public function edit_invoice_by_id($id,$name,$amount,$pending)
{
    $pending=floatval($amount)-floatval($pending);
    if($pending)
        $res = $this->db->query("update bill_info set pending_amount='$pending' where id='$id'");
    else
        $res = $this->db->query("update bill_info set pending_amount='$pending' ,status='Paid' where id='$id'");
    if($res)
        return TRUE;
}
public function change_invoice_status($id)
{
    $res = $this->db->query("update bill_info set status='Paid' where id='$id'");
    return TRUE; 
}

public function print_patient_detail($patient_id){
    
    $res = $this->db->query("select * from patient where patient_id='$patient_id'");
    
    if($res){
        
        return $res->fetch_assoc();
    }
}

public function print_patient_vital($patient_id,$date){
    
    $res = $this->db->query("select * from vital where patient_id='$patient_id' and date='$date'");
    
    if($res){
         
        return $res->fetch_assoc();
    }
}

public function print_patient_clinical_note($patient_id,$date){
    
    $res = $this->db->query("select * from clinical_note where patient_id='$patient_id' and date='$date'");
    
    if($res){
         
        return $res->fetch_assoc();
    }
}

public function print_drug_name($patient_id,$date)
{
    //echo $pid;
	$res = $this->db->query("select * from prescription_patient where date='$date' and patient_id='$patient_id'");
    //echo $res->num_rows;
	//$data = $res->fetch_assoc();
 
	$str = '';
	if($res->num_rows > 0){
	$str='<div class="col-sm-12 table-responsive" >   <table id="drug_patient" class="table table-striped table-responsive patient-profile-tables">
                                <thead>
                                    <tr>
                                       
                                        <th>Durg Name</th>
                                        <th>Strength</th>
                                        <th>Duration</th>
                                        <th>Food</th>
                                        <th>Instructions</th>
                                        
                                    </tr>
                                </thead>
                                 <tbody>';
   
	
		while($data=$res->fetch_assoc())
		{
			//$data1=$this->getById($pid,"patient");
			$str.=' <tr><td>';

			$drug_names = json_decode($data['drug_name']);
			foreach($drug_names as $drugname)
			{
				$str.='<b>'.$drugname.'</b><br>';
			}
			$str.='</td><td>';

            $strength = json_decode($data['strength']);
            $unit = json_decode($data['unit']);
            $count = 0;
            foreach($strength as $st)
            {
                $str.='<b>'.$st.' '.$unit[$count].'</b><br>';	
            	$count++;
            }
            	$str.='</td><td>';
            $durations=json_decode($data['duration']);
            $time = json_decode($data['days']);
            $count = 0;
            foreach($durations as $duration)
            {
                
            	$str.='<b>'.$duration.' '.$time[$count].'</b><br>';	
            	$count++;
            }
            $str.='</td><td>';
            
            $food = json_decode($data['food']);
            foreach($food as $food)
            {
            	$str.=''.$food.'<br>';
			}
            $str.='</td><td>';
            
            $instruction=json_decode($data['instruction']);
            foreach($instruction as $instruct)
            {
            	$str.=''.$instruct.'<br>';
			}
			$str.='</td>';


			

		}
	
	

	$str.=' </tbody></table></div>';
	}
	 return $str;
}

public function delete_prescription($id){
    
    $res = $this->db->query("delete from prescription_patient where id='$id'");
    
    if($res){
        return TRUE;
    }
}

public function add_expenses_type($name,$doc_id)
{
	$res=$this->db->query("insert into expenses(name,doctor_id) value('$name','$doc_id')");
	if(@$res)
	{
		return true;
	}
}
public function display_expenses_type()
{
	$doc_id=$_SESSION['login_id'];
	$res=$this->db->query("select * from expenses where doctor_id='$doc_id'");
	$str='';
	
	/*$str='  <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                       <th>Action</th>
                                    </tr>
                                </thead>
                                 <tbody>';*/
      $str='<div class="col-sm-12 contentTable">
			<div class="col-sm-12 table-responsive" >
				<table class="patientsList">
					<thead  style="font-weight: 700">
							<tr  style="color: #333333; background-color: white">
								 <th>Name</th>
                                       <th>Action</th>			
							</tr>
						</thead>
						<tbody>';
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
			$str.=' <tr>
                                        <td>'.$data['name'].'</td>
                                        <td><div class="patient-list-buttons glyphicon glyphicon-trash" onclick="delete_expenses_type('.$data['id'].')"></div>
								 </td>
                                    </tr>
                                   ';
		
		}	
	} else {
		$str.="<td colspan='2'>No Records Found.</td>";
	}
	$str.=' </tbody></table></div></div>';
	 return $str;
}

public function all_expenses_type()
{
	$doc_id=$_SESSION['login_id'];
	$res=$this->db->query("select * from expenses where doctor_id='$doc_id'");
	$str='';
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
			$str.='<p data-id="'.$data['id'].'" class="exp">'.$data['name'].' </p>';
		}
	}
	return $str;
}
public function mode_of_payment_dropdown()
{
	$doc_id=$_SESSION['login_id'];
	$res=$this->db->query("select * from mode_of_payment where doctor_id='$doc_id'");
	$str='';
	if($res->num_rows>0)
	{
		while($data=$res->fetch_assoc())
		{
			$str.='<option value="'.$data['mode'].'">'.$data['mode'].' </option>';
		}
	}
	return $str;
}
public function add_doctor_expneses($expenses_name,$vender,$date,$mode,$amount)
{
	$doc_id=$_SESSION['login_id'];
	$date1=date('Y-m-d');
	
	$res=$this->db->query("insert into doctor_expenses(expense,vendor,date,mode_of_payment,amount,doctor_id,stored_date) values('$expenses_name','$vender','$date','$mode','$amount','$doc_id','$date1')");
	if(@$res)
	{
		$active_name="expenses";
		
		$patient_id=0;
		
		$action='added';
		$date=date('Y-m-d');
	   $time=date("h:i");
		
		$res1=$this->db->query("insert into activity(name,patient_id,doctor_id,action,date,time) values('$active_name','$patient_id','$doc_id','$action','$date','$time') ");
		return true;
	}
}
public function display_doctor_expenses()
{
	
$doc_id=$_SESSION['login_id'];


	$res=$this->db->query("select * from doctor_expenses where  doctor_id='$doc_id'");	
	$rows = array();
	while($r = mysqli_fetch_array($res)){
		$date = strtotime($r['date']);
	    $r['date'] = date("j F Y",$date);
		$rows[] = $r;
	}
	$res = json_encode($rows);
	return $res;	
}

public function display_doctor_expenses_bydate($date1,$date2)
{
	
$doc_id=$_SESSION['login_id'];


	$res=$this->db->query("select * from doctor_expenses where  doctor_id='$doc_id' and date>='$date1' and date<='$date2'");	
	$rows = array();
	while($r = mysqli_fetch_array($res)){
		$date = strtotime($r['date']);
	    $r['date'] = date("j F Y",$date);
		$rows[] = $r;
	}
	$res = json_encode($rows);
	return $res;	
}

public function add_contact($email,$phone,$language)
{
	$doc_id=$_SESSION['login_id'];
	$res=$this->db->query("select * from contact_detail where doctor_id='$doc_id'");
	if($res->num_rows>0)
	{
		$res1=$this->db->query("update contact_detail set email='$email',phone_no='$phone',language='$language' where doctor_id='$doc_id'");
		/*$res2=$this->db->query("update doctors set email='$email',phone_no='$phone',language='$language' where id='$doc_id'");
		*/
	}
	else{
		$res1=$this->db->query("insert into contact_detail(email,phone_no,language,doctor_id) values('$email','$$phone','$language','$doc_id')");
	}
	
	if(@$res1)
	{
		return true;
	}
}
public function confirm_msg($patient_name,$clinic,$category,$contact,$confirm)
{
	$doc_id=$_SESSION['login_id'];
	if($confirm=="on")
	{
	$res=$this->db->query("select * from setting where doctor_id='$doc_id' and temp_name='confirm_msg'");
	if($res->num_rows>0)
	{
		$data=$res->fetch_assoc();
		$id=$data['id'];
		$res1=$this->db->query("update setting set patient='$patient_name',clinic='$clinic',category='$category',contact='$contact' where id='$id' ");
	}
	else{
			$res1=$this->db->query("insert setting(temp_name,patient,clinic,category,contact,doctor_id) values('confirm_msg','$patient_name','$clinic','$category','$contact','$doc_id')");
	}
	}
 else{
 	$res1=$this->db->query("delete from setting where doctor_id='$doc_id' and temp_name='confirm_msg'");
   }
	if(@$res1)
	{
		return true;
	}
}
public function cancel_msg($patient_name,$clinic,$category,$contact,$cancel)
{
	
	$doc_id=$_SESSION['login_id'];
	if($cancel=="on")
	{
	$res=$this->db->query("select * from setting where doctor_id='$doc_id' and temp_name='cancel_msg'");
	if($res->num_rows>0)
	{ 

		$data=$res->fetch_assoc();
		$id=$data['id'];
		$res1=$this->db->query("update setting set patient='$patient_name',clinic='$clinic',category='$category',contact='$contact' where id='$id' ");
	}
	else{
			$res1=$this->db->query("insert setting(temp_name,patient,clinic,category,contact,doctor_id) values('cancel_msg','$patient_name','$clinic','$category','$contact','$doc_id')");
	}
	}
	else
	{
		$res1=$this->db->query("delete from setting where doctor_id='$doc_id' and temp_name='cancel_msg'");
	}

	if(@$res1)
	{
		return true;
	}
}
public function reminder_msg($patient_name,$clinic,$category,$contact,$reminder)
{
	
	$doc_id=$_SESSION['login_id'];
	if($reminder=="on")
	{
	
	$res=$this->db->query("select * from setting where doctor_id='$doc_id' and temp_name='reminder_msg'");
	if($res->num_rows>0)
	{
		$data=$res->fetch_assoc();
		$id=$data['id'];
		$res1=$this->db->query("update setting set patient='$patient_name',clinic='$clinic',category='$category',contact='$contact' where id='$id' ");
	}
	else{
			$res1=$this->db->query("insert setting(temp_name,patient,clinic,category,contact,doctor_id) values('reminder_msg','$patient_name','$clinic','$category','$contact','$doc_id')");
	}

	
	}
	else
	{
		$res1=$this->db->query("delete from setting where doctor_id='$doc_id' and temp_name='reminder_msg'");
	}
	if(@$res1)
	{
		return true;
	}
}
public function reminder_check($reminder)
{
	$doc_id=$_SESSION['login_id'];
	$res=$this->db->query("select * from setting where doctor_id='$doc_id' and temp_name='$reminder'");
	if($res->num_rows>0)
	{
	    //echo "hello";
		return $res->fetch_assoc();
	}
}
public function templete_check($reminder)
{
	$doc_id=$_SESSION['login_id'];
	$res=$this->db->query("select * from msg_tamplete where doctor_id='$doc_id' and templete='$reminder'");
	if($res->num_rows>0)
	{
		return $res->fetch_assoc();
	}
}
public function add_templete($msg,$tmp,$bir)
{
	$doc_id=$_SESSION['login_id'];
 if($bir=="on")
	{
	
	$res=$this->db->query("select * from msg_tamplete where doctor_id='$doc_id' and templete='$tmp'");
	if($res->num_rows>0)
	{
		$data=$res->fetch_assoc();
		$id=$data['id'];
		$res1=$this->db->query("update msg_tamplete set templete='$tmp',msg='$msg' where id='$id' ");
	}
	else{
			$res1=$this->db->query("insert msg_tamplete(templete,msg,doctor_id) values('$tmp','$msg','$doc_id')");
	}
    }
    else
    {
    	$res1=$this->db->query("delete from msg_tamplete where doctor_id='$doc_id' and templete='$tmp'");
		
	}
	if(@$res1)
	{
		return true;
	}
}
public function follow_setting($tmp,$patient,$stop,$follow)
{
	$doc_id=$_SESSION['login_id'];
	if($follow=="on")
	{
	
	$res=$this->db->query("select * from setting where doctor_id='$doc_id' and temp_name='$tmp'");
	if($res->num_rows>0)
	{
		$data=$res->fetch_assoc();
		$id=$data['id'];
		$res1=$this->db->query("update setting set patient='$patient',stop='$stop' where id='$id' ");
	}
	else{
			$res1=$this->db->query("insert setting(temp_name,patient,stop,doctor_id) values('$tmp','$patient','$stop','$doc_id')");
	}
}

else
{
	$res1=$this->db->query("delete from setting where doctor_id='$doc_id' and temp_name='$tmp'");
}
	if(@$res1)
	{
		return true;
	}
}
public function add_email_setting($confirm,$cancel,$reminder,$follow,$birthday)
{
	$doc_id=$_SESSION['login_id'];
	if($follow=="on")
	{
	
	$res=$this->db->query("select * from email_setting where doctor_id='$doc_id'");
	if($res->num_rows>0)
	{
		$data=$res->fetch_assoc();
		$id=$data['id'];
		$res1=$this->db->query("update email_setting set confirm='$confirm',cancel='$cancel',reminder='$reminder',follow='$follow', birthday='$birthday' where doctor_id='$doc_id' ");
	}
	else{
			$res1=$this->db->query("insert email_setting(confirm,cancel,reminder,follow,birthday,doctor_id) values('$confirm','$cancel','$reminder','$follow','$birthday','$doc_id')");
	}
	
	if(@$res1)
	{
		return true;
	}
			
}
}
public function add_calendar_setting($slote,$open,$close)
{
	$doc_id=$_SESSION['login_id'];
	
	
	$res=$this->db->query("select * from calendar_setting where doctor_id='$doc_id'");
	if($res->num_rows>0)
	{
		$data=$res->fetch_assoc();
		$id=$data['id'];
		$res1=$this->db->query("update calendar_setting set slote='$slote',open='$open',close='$close' where id='$id' ");
	}
	else{
			$res1=$this->db->query("insert calendar_setting(slote,open,close,doctor_id) values('$slote','$open','$close','$doc_id')");
	}
	
	if(@$res1)
	{
		return true;
	}

}
public function get_calendar_detail()
{
	 $doc_id=$_SESSION['login_id'];
	$res=$this->db->query("select * from calendar_setting where doctor_id='$doc_id'");
	
	//$res=$this->db->query("select * from calendar_setting");
	if(@$res->num_rows > 0)
	{
		return $res->fetch_assoc();
		}
}

public function gethomevisitforcalender()
{
	$doc_id=$_SESSION['login_id'];
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
public function getappointmentforcalender()
{
	$doc_id=$_SESSION['login_id'];
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
public function geteventforcalender()
{
	$doc_id=$_SESSION['login_id'];
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
public function appointment_slote()
{
    $doc_id=$_SESSION['login_id'];
	$res=$this->db->query("select * from practice where doctor_id='$doc_id'");

	//$res=$this->db->query("select * from doctor_additional");
	if(@$res->num_rows > 0)
	{$data=$res->fetch_assoc();
	$time=$data['duration'];
	
	
		return  $time;
	}	
}
public function calendar_setting()
{
	$doc_id=$_SESSION['login_id'];
	$res=$this->db->query("select * from calendar_setting where doctor_id='$doc_id'");
	if(@$res)
	{
		return $res->fetch_assoc();
	}
}
public function add_app_category($name,$doc_id)
{
	$res=$this->db->query("insert into appointment_category(name,doctor_id) values('$name','$doc_id')");
	if(@$res)
	{
		return true;
	}
}
public function dispaly_app_category()
{ $doc_id=$_SESSION['login_id'];
	$res=$this->db->query("select * from appointment_category where doctor_id='$doc_id'");
	$str='';
	
	/*$str='  <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                       <th>Action</th>
                                    </tr>
                                </thead>
                                 <tbody>';*/
    $str='<div class="col-sm-12 contentTable">
			<div class="col-sm-12 table-responsive" >
				<table class="patientsList">
					<thead  style="font-weight: 700">
							<tr  style="color: #333333; background-color: white">
								 <th>Name</th>
                                       <th>Action</th>						
							</tr>
						</thead>
						<tbody>';
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
			$str.=' <tr>
                                        <td>'.$data['name'].'</td>
                                                          
                                        <td><div class="patient-list-buttons glyphicon glyphicon-trash" onclick="delete_app_category('.$data['id'].')"></div>
								 </td>
                                    </tr>
                                   ';
		
		}	
	} else {
		$str.="<td colspan='2'>No Records Found.</td>";
	}
	$str.=' </tbody></table></div></div>';
	 return $str;
	
}
public function total_sms($doc_id)
{
	$res=$this->db->query("select * from sms where doctor_id='$doc_id' and status='delivered'");
	$str='';
	
	$str='  <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>Status</th>
                                       <th>Today</th>
                                        <th>Last 30 days</th>
                                    </tr>
                                </thead>
                                 <tbody>';
                                 $today=0;
                                 $month=0;
	if($res->num_rows > 0)
	{
		$date=date('Y-m-d');
		$last = strtotime(date('Y-m-d') . ' -30 days');
		$last=date('Y-m-d', $last); 
		while($data=$res->fetch_assoc())
		{
			if($date==$data['date'])
			{
				$today++;
			}
			if($data['date']>$last)
			{
				$month++;
			}
	}
			
			
			$str.=' <tr>
                                        <td>Delivered</td>
                                        <td>'.$today.'</td>
                                        <td>'.$month.'</td>          
                                       
                                    </tr>
                                   ';
		
			
	}
	$str.=' </tbody></table>';
	 return $str;
}
public function total_sms_failed($doc_id)
{
	$res=$this->db->query("select * from sms where doctor_id='$doc_id' and status='failed'");
	$str='';
	
	$str='  <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>Status</th>
                                       <th>Today</th>
                                        <th>Last 30 days</th>
                                    </tr>
                                </thead>
                                 <tbody>';
                                 $today=0;
                                 $month=0;
	if($res->num_rows > 0)
	{
		$date=date('Y-m-d');
		$last = strtotime(date('Y-m-d') . ' -30 days');
		$last=date('Y-m-d', $last); 
		while($data=$res->fetch_assoc())
		{
			if($date==$data['date'])
			{
				$today++;
			}
			if($data['date']>$last)
			{
				$month++;
			}
	}
			
			
			$str.=' <tr>
                                        <td>Failed</td>
                                        <td>'.$today.'</td>
                                        <td>'.$month.'</td>          
                                       
                                    </tr>
                                   ';
		
			
	}
	$str.=' </tbody></table>';
	 return $str;
}
public function remain_points()
{
	$doc_id=$_SESSION['login_id'];
	$res=$this->db->query("select * from points where doctor_id='$doc_id'");
	if($res->num_rows > 0)
	{
		$data=$res->fetch_assoc();
		return $data['points'];
		
	}
	
}
public function total_email($doc_id)
{
	$res=$this->db->query("select * from email where doctor_id='$doc_id' and status='delivered'");
	$str='';
	
	$str='  <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>Status</th>
                                       <th>Today</th>
                                        <th>Last 30 days</th>
                                    </tr>
                                </thead>
                                 <tbody>';
                                 $today=0;
                                 $month=0;
	if($res->num_rows > 0)
	{
		$date=date('Y-m-d');
		$last = strtotime(date('Y-m-d') . ' -30 days');
		$last=date('Y-m-d', $last); 
		while($data=$res->fetch_assoc())
		{
			if($date==$data['date'])
			{
				$today++;
			}
			if($data['date']>$last)
			{
				$month++;
			}
	}
			
			
			$str.=' <tr>
                                        <td>Delivered</td>
                                        <td>'.$today.'</td>
                                        <td>'.$month.'</td>          
                                       
                                    </tr>
                                   ';
		
			
	}
	$str.=' </tbody></table>';
	 return $str;
	
}
public function total_email_failed($doc_id)
{
	$res=$this->db->query("select * from email where doctor_id='$doc_id' and status='failed'");
	$str='';
	
	$str='  <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>Status</th>
                                       <th>Today</th>
                                        <th>Last 30 days</th>
                                    </tr>
                                </thead>
                                 <tbody>';
                                 $today=0;
                                 $month=0;
	if($res->num_rows > 0)
	{
		$date=date('Y-m-d');
		$last = strtotime(date('Y-m-d') . ' -30 days');
		$last=date('Y-m-d', $last); 
		while($data=$res->fetch_assoc())
		{
			if($date==$data['date'])
			{
				$today++;
			}
			if($data['date']>$last)
			{
				$month++;
			}
	}
			
			
			$str.=' <tr>
                                        <td>Failed</td>
                                        <td>'.$today.'</td>
                                        <td>'.$month.'</td>          
                                       
                                    </tr>
                                   ';
		
			
	}
	$str.=' </tbody></table>';
	 return $str;
	
}
public function patient_treatment($doc_id)
{
	$res=$this->db->query("select * from patient where doctor_id='$doc_id'");
	$str='';
	$str='  <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                         <th>Phone No</th>
                                        <th>Address</th>
                                        <th>City</th>
                                        <th>State</th>
                                       
                                         <th>Pincode</th>
                                         <th>Action</th>
                                    </tr>
                                </thead>
                                 <tbody>';
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
			$str.=' <tr>
                                        <td>'.$data['name'].'</td>
                                        <td>'.$data['email'].'</td>
                                        <td>'.$data['phone_no'].'</td>
                                        <td>'.$data['address'].'</td>
                                        <td>'.$data['city'].'</td>
                                        <td>'.$data['state'].'</td>
                                        <td>'.$data['pincode'].'</td>
                                        <td><a href="'.base_url_doc.'patient-detail/?treatment='.$data['id'].'" class="btn btn-info"><i class="material-icons">add</i></a>
								 </td>
                                    </tr>
                                   ';
		
		}	
	}
	$str.=' </tbody></table>';
	 return $str;
}
public function treatment_for_patient()
{
	
	$doc_id=$_SESSION['login_id'];
	$res=$this->db->query("select * from procedure_catalog where doctor_id='$doc_id'");
	$str='';
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
			$str.='<option value="'.$data['id'].'" data-id="'.$data['id'].'" class="tre">'.$data['name'].' </option>';
		}
	}
	return $str;
}
public function add_treatment($name,$qty,$cost,$discount,$total,$patient_id,$note)
{
	$doc_id=$_SESSION['login_id'];
	
	$res=$this->db->query("insert into treatment(name,qty,cost,discount,total,patient_id,note,doctor_id) values('$name','$qty','$cost','$discount','$total','$patient_id','$note','$doc_id')");
	if(@$res)
	{
		$active_name="treatment ";
		$res1=$this->db->query("select * from treatment where doctor_id='$doc_id' order by id DESC limit 1");
		$data=$res1->fetch_assoc();
		$patient_id=$data['patient_id'];
		$patient_id=$this->getById($patient_id,"patient");
		$patient_id=$patient_id['name'];
		
		$action='add';
		$date=date('Y-m-d');
	   $time=date("h:i");
		
		$res1=$this->db->query("insert into activity(name,patient_id,doctor_id,action,date,time) values('$active_name','$patient_id','$doc_id','$action','$date','$time') ");
		return true;
	}
}

public function treatment_show($id)
{
	$res=$this->db->query("select * from patient where doctor_id='$id'");
	$str='';
	$str='  <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                         <th>Phone No</th>
                                        <th>Address</th>
                                        <th>City</th>
                                        <th>State</th>
                                       
                                         <th>Pincode</th>
                                         <th>Action</th>
                                    </tr>
                                </thead>
                                 <tbody>';
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
			$str.=' <tr>
                                        <td>'.$data['name'].'</td>
                                        <td>'.$data['email'].'</td>
                                        <td>'.$data['phone_no'].'</td>
                                        <td>'.$data['address'].'</td>
                                        <td>'.$data['city'].'</td>
                                        <td>'.$data['state'].'</td>
                                        <td>'.$data['pincode'].'</td>
                                        <td><a href="'.base_url_doc.'patient/?display_patient_treatment='.$data['id'].'" class="btn btn-info"><i class="material-icons">add</i></a>
								 </td>
                                    </tr>
                                   ';
		
		}	
	}
	$str.=' </tbody></table>';
	 return $str;
}
public function display_patient_treatment($doc_id,$patient_id)
{
	if($patient_id == ''){
		$res=$this->db->query("select * from treatment where doctor_id='$doc_id'");
	}
	else{
		$res=$this->db->query("select * from treatment where patient_id='$patient_id'");
	}
	
	$str='';
	$str=' <div class="col-sm-12 table-responsive" >  <table class="table patient-profile-tables table-striped table-responsive">
                                <thead>
                                    <tr>
                                        <th> Name</th>
                                        <th>Cost</th>
                                         <th>Discount</th>
                                         <th>Total</th> 
                                         <th>Action</th>                                        
                                    </tr>
                                </thead>
                                 <tbody>';
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
			$data1 = $this->getbyId($data['patient_id'], 'patient');
			$str.=' <tr> 			
			<td>';
                                        $drug_name=json_decode($data['name']);
                                        
                                        foreach($drug_name as $drug)
                                        {
											$str.='<b>'.$drug.'</b><br><br>';
										}
                                        $str.='</td><td>';
                                         $durations=json_decode($data['cost']);
                                        
                                        foreach($durations as $duration)
                                        {
											$str.=''.$duration.'<br><br>';
										}
                                        $str.='</td><td>';
                                         $instruction=json_decode($data['discount']);
                                        
                                        foreach($instruction as $instruct)
                                        {
											$str.=''.$instruct.'<br><br>';
										} $str.='</td><td>';
                                        $total=json_decode($data['total']);
                                        
                                        foreach($total as $tot)
                                        {
											$str.=''.$tot.'<br><br>';
										}
                                       $str.='
                                       	</td><td ><a style="float:left" href="'.base_url_doc.'patient-detail/?edit_procedure='.$data['id'].'" 
                                        ><div class="patient-list-buttons glyphicon glyphicon-pencil" ></div></a>
                                        <a style="float:left" href="'.base_url_doc.'patient-detail/?delete_procedure='.$data['id'].'"  onclick="return conf();"
                                        ><div class="patient-list-buttons glyphicon glyphicon-trash" ></div></a>
                                     <a  style="float:left" href="'.base_url_doc.'procedure_print/?id='.$data['id'].'" target="_blank"
                                        ><div class="patient-list-buttons glyphicon glyphicon-print" ></div></a>
                                       </td></tr>';
		
		}	
	} else {
		$str.="<tr><td colspan=5 >No Records Found To Show.</td></tr>";
	}
	$str.=' </tbody></table></div>';
	 return $str;
	
}
public function display_patient_treatment1($doc_id,$patient_id)
{
	if($patient_id == ''){
		$res=$this->db->query("select * from treatment where doctor_id='$doc_id'");
	}
	else{
		$res=$this->db->query("select * from treatment where patient_id='$patient_id'");
	}
	
	$str='';
	$str='  <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>Patient Name</th>
                                        <th> Name</th>
                                        <th>Cost</th>
                                         <th>Discount</th>
                                         <th>Total</th> 
                                         <th>Action</th>
                                        
                                    </tr>
                                </thead>
                                 <tbody>';
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
			$data1 = $this->getbyId($data['patient_id'], 'patient');
			$str.=' <tr> 
			<td>'.$data1['name'].'</td>
			
			<td>';
                                        $drug_name=json_decode($data['name']);
                                        
                                        foreach($drug_name as $drug)
                                        {
											$str.='<b>'.$drug.'</b><br><br>';
										}
                                        $str.='</td><td>';
                                         $durations=json_decode($data['cost']);
                                        
                                        foreach($durations as $duration)
                                        {
											$str.=''.$duration.'<br><br>';
										}
                                        $str.='</td><td>';
                                         $instruction=json_decode($data['discount']);
                                        
                                        foreach($instruction as $instruct)
                                        {
											$str.=''.$instruct.'<br><br>';
										} $str.='</td><td>';
                                        $total=json_decode($data['total']);
                                        
                                        foreach($total as $tot)
                                        {
											$str.=''.$tot.'<br><br>';
										}
                                       $str.='</td> <td><a href="'.base_url_doc.'patient-detail/?edit_procedure='.$data['id'].'" class="btn btn-info" ><i class="material-icons">edit</i></a>
                                        <a href="'.base_url_doc.'patient-detail/?delete_procedure='.$data['id'].'" class="btn btn-danger" onclick="return conf();"><i class="material-icons">clear</i></a> <a href="'.base_url_doc.'treatment_print/?id='.$data['id'].'" class="btn btn-info" target="_blank"><i class="material-icons">print</i></a> </td></tr>';
		
		}	
	}
	$str.=' </tbody></table>';
	 return $str;
	
}
public function add_patient_bulk($file)
{
 $handle = fopen($file, "r");
 $c = 0;
 $res=$this->db->query("select * from patient order by patient_id DESC limit 1");
 $data=$res->fetch_assoc();
 $patient_id=$data['patient_id'];

 while(($filesop = fgetcsv($handle, 10000, ",")) !== false)
 {
 $name = $filesop[0];
 $email = $filesop[1];
 $password = $filesop[2];
 $address = $filesop[3];
 $area = $filesop[4];
 $city = $filesop[5];
 $state = $filesop[6];
 $phone_no = $filesop[7];
 $pincode = $filesop[8];
 $status = $filesop[9];
 $gender = $filesop[10];
 $aadhaar_id = $filesop[11];
 $dob = $filesop[12];
 $medical_history = $filesop[13];
 $referrer = $filesop[14];
 $relation = $filesop[15];
$area=str_replace(",","",$area);
$city=str_replace(",","",$city);


$doc_id = $_SESSION['login_id'];
 


 

$date=date('Y-m-d');
if($c > 0)
{
	$res1=$this->db->query("select * from area where name='$area'");
 
 if($res1->num_rows>0)
 {
 	$data1=$res1->fetch_assoc();
 	$area=$data1['id'];
 }
 else
 {
 	 
 	$res2=$this->db->query("insert into area (name,doctor_id) values('$area','$doc_id')");
 	 $res3=$this->db->query("select * from area where name='$area'");
 	 $data3=$res3->fetch_assoc();
 	$area=$data3['id'];
 }
 
$res = $this->db->query("INSERT INTO patient(name,email,password,address,area,city,state,phone_no,pincode,status,doctor_id,date,gender,aadhaar_id,dob,medical_history,referrer,relation,image,patient_id) VALUES ('$name','$email','$password','$address','$area','$city','$state','$phone_no','$pincode','$status','$doc_id','$date','$gender','$aadhaar_id','$dob','$medical_history','$referrer','$relation','patient_avatar-male.jpg','$patient_id')");	
}
 $c++;
 $patient_id++;
 }
 
 if(@$res)
 {
 	return true;
 }
}
public function add_appointment_bulk($file)
{
	
 $handle = fopen($file, "r");
 $c = 0;
 while(($filesop = fgetcsv($handle, 1000, ",")) !== false)
 {
 $name = $filesop[0];
 $email = $filesop[1];
 $date = $filesop[2];
 $time = $filesop[3];
 
 
$doc_id = $_SESSION['login_id'];

if($c > 0)
{
	$date=str_replace("/","-",$date);
	$date=explode("-",$date);
	$new=$date[2].'-'.$date[0].'-'.$date[1];
	
$res = $this->db->query("INSERT INTO appointments(patient_name,patient_email,app_date,app_time,doctor_id) VALUES ('$name','$email','$new','$time','$doc_id')");	
}
 $c++;
 }
 
 if(@$res)
 {
 	return true;
 }
}
public function add_procedure_bulk($file)
{
	
 $handle = fopen($file, "r");
 $c = 0;
 while(($filesop = fgetcsv($handle, 1000, ",")) !== false)
 {
 $name = $filesop[0];
 $cost = $filesop[1];
 $note = $filesop[2];
 
 
 
$doc_id = $_SESSION['login_id'];

if($c > 0)
{
	
	
$res = $this->db->query("INSERT INTO procedure_catalog(name,cost,note,doctor_id) VALUES ('$name','$cost','$note','$doc_id')");	
}
 $c++;
 }
 
 if(@$res)
 {
 	return true;
 }
}

public function getByPatientId2($pid)
{
    $res = $this->db->query("select * from patient where patient_id='$pid'");
    $data = $res->fetch_assoc();
}

public function add_prescription_content($drugnames,$drugtypes,$strengths,$units,$durations,$times,$mornings,$noons,$nights,$foods,$instructions,$pid)
{
	$doc_id = $_SESSION['login_id'];

	$date = date("Y-m-d");
    
	$res = $this->db->query("insert into prescription_patient(drug_name,drug_type,strength,unit,duration,days,morning,noon,night,food,instruction,doctor_id,patient_id,date) values('$drugnames','$drugtypes','$strengths','$units','$durations','$times','$mornings','$noons','$nights','$foods','$instructions','$doc_id','$pid','$date')");
    
    $patientdata = $this->getByPatientId2($pid);
    $patient_name = $patientdata['name'];
    $date = date("Y-m-d");
    $time = date("h:i");
    $name = "Add Prescription";
    $action = "issued";
    $res1 = $this->db->query("insert into activity(name,patient_id,doctor_id,action,date,time) values('$name','$pid','$doc_id','$action','$date','$time')");
	if($res)
	{
		return TRUE;
	}
}

public function update_prescription_content($drugnames,$drugtypes,$strengths,$units,$durations,$times,$mornings,$noons,$nights,$foods,$instructions,$pid,$prescription_id)
{
	$doc_id = $_SESSION['login_id'];

	$date = date("Y-m-d");

	$res = $this->db->query("update prescription_patient set drug_name='$drugnames',drug_type='$drugtypes',strength='$strengths',unit='$units',duration='$durations',days='$times',morning='$mornings',noon='$noons',night='$nights',food='$foods',instruction='$instructions' where id='$prescription_id'");

	if($res)
	{
		return TRUE;
	}
}


public function add_prescription_bulk($file)
{
	
 $handle = fopen($file, "r");
 $c = 0;
 while(($filesop = fgetcsv($handle, 1000, ",")) !== false)
 {
 $name = $filesop[0];
 $drug_type = $filesop[1];
 $strength = $filesop[2];
 $unit = $filesop[3];
 $instruction = $filesop[4];
 
 
 
$doc_id = $_SESSION['login_id'];

if($c > 0)
{

$res = $this->db->query("INSERT INTO prescription(name,drug_type,strength,unit,instructions,doctor_id) VALUES ('$name','$drug_type','$strength','$unit','$instruction','$doc_id')");	
}
 $c++;
 }
 
 if(@$res)
 {
 	return true;
 }
}

public function add_visit($patient_name,$date,$time,$add_info)
{
	$doc_id=@$_SESSION['login_id'];
	//echo "insert into visit(patient_name,date,time,add_info,doctor_id) values('$patient_name','$date','$time','$add_info','$doc_id')"; exit;
	$res=$this->db->query("insert into visit(patient_name,date,time,add_info,doctor_id) values('$patient_name','$date','$time','$add_info','$doc_id')");
	if(@$res)
	{
		return $res;
	}
}

public function display_today_home_visit()
{
    $doc_id=$_SESSION['login_id'];
    $date = date("Y-m-d");
    $res = $this->db->query("select * from visit where doctor_id='$doc_id' and token='' and date='$date'");
    if($res->num_rows > 0)
    {
        return $res->num_rows;
    }
    else
    {
        return 0;
    }
}

public function display_home_visit()
{
    $doc_id=$_SESSION['login_id'];
    $res = $this->db->query("select * from visit where doctor_id='$doc_id' and token=''");
    if($res->num_rows > 0)
    {
        return $res->num_rows;
    }
    else
    {
        return 0;
    }
}

public function display_app()
{   $doc_id=$_SESSION['login_id'];
	$res=$this->db->query("select * from appointments where doctor_id='$doc_id'");
    if($res->num_rows > 0)
    {
    	    return $res->num_rows;
    }
    else
    {
        return 0;
    }
}

public function display_today_pending_app()
{
    $doc_id=$_SESSION['login_id'];
    $date = date("Y-m-d");
	$res=$this->db->query("select * from token where doctor_id='$doc_id' and app_date='$date' and status='pending'");
	if($res->num_rows > 0)
    {
    	    return $res->num_rows;
    }
    else
    {
        return 0;
    }
}


public function display_today_app()
{
    $doc_id=$_SESSION['login_id'];
    $date = date("Y-m-d");
	$res=$this->db->query("select * from appointments where doctor_id='$doc_id' and app_date='$date' and status!='Cancel'");
	if($res->num_rows > 0)
    {
    	    return $res->num_rows;
    }
    else
    {
        return 0;
    }
}
public function display_visit()
{     $doc_id=$_SESSION['login_id'];
	$res=$this->db->query("select patient.name, visit.date, visit.time, visit.add_info, visit.id from visit inner join patient on visit.patient_name = patient.id where visit.doctor_id='$doc_id' and visit.token=''");

	$rows = array();
	while($r = mysqli_fetch_array($res)){
		$date = strtotime($r['date']);
	    $r['date'] = date("j F Y",$date);
		$rows[] = $r;
	}
	$res = json_encode($rows);
	return $res;
	//$str='';
	/*$str='  <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>Patient Name</th>
                                        <th>Date</th>
                                         <th>Time</th>
                                         <th>Additional Information</th>
                                         <th>Action</th>
                                    </tr>
                                </thead>
                                 <tbody>';*/
    /*$str='<div class="row contentTable">
			<div class="table-responsive" style="height:150px; overflow:scroll">
				<table class="patientsList">
					<thead  style="font-weight: 700">
							<tr  style="color: #f8f8f8; background-color: white">
								<td>Patient Name</td>
								<td>Date</td>
								<td>Time</td>
								<td>Additional Information</td>
								<td>Action</td>							
							</tr>
						</thead>
						<tbody>';
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
			$data1=$this->getById($data['patient_name'],"patient");*/
			/*$str.=' <tr>
                                        <td>'.$data1['name'].'</td>
                                        <td>'.$data['date'].'</td>
                                        <td>'.$data['time'].'</td>
                                        <td>'.$data['add_info'].'</td>
                                      
                                        <td><a href="'.base_url_doc.'visit/?edit='.$data['id'].'" class="btn btn-info"><i class="material-icons">edit</i></a><a href="'.base_url_doc.'visit/?delete='.$data['id'].'" class="btn btn-info" onclick="return conf();"><i class="material-icons">clear</i></a>
								 </td>
                                    </tr>
                                   ';*/
          /*  $str.='<tr>
				    <td class="patientName">'.$data1['name'].'</td>
				    <td>'.$data['date'].'</td>
				    <td>'.$data['time'].'</td>
				    <td>'.$data['add_info'].'</td>
				   	<td> <div class="patient-list-buttons glyphicon glyphicon-edit"></div>
				    <div class="patient-list-buttons glyphicon glyphicon-trash" style="float:right"></div>
				  		 </td></tr>';
		
		}	
	}
	else {
			echo '<h5>No Data Available to show.</h5>';
		}
	$str.='</tbody></table>
			</div>
		</div>';
	 return $str;*/
}

public function display_today_visit_app_count()
{
    $doc_id=$_SESSION['login_id'];
    $date = date("Y-m-d");
    $res = $this->db->query("select * from visit where doctor_id='$doc_id and token!='' and date='$date'");
    if($res->num_rows>0)
    {
        return $res->num_rows;
    }
    else
    {
        return 0;
    }
}

public function display_today_events()
{
    $doc_id=$_SESSION['login_id'];
    //echo $doc_id;
    $date = date("Y-m-d");
    $res = $this->db->query("select * from event where doctor_id='$doc_id' and event_date='$date'");
    if($res->num_rows>0)
    {
        return $res->num_rows;
    }
    else
    {
        return 0;
    }
}

public function display_visit_app_count()
{
    $doc_id=$_SESSION['login_id'];
    $res = $this->db->query("select * from visit where doctor_id='$doc_id and token!=''");
    if($res->num_rows>0)
    {
        return $res->num_rows;
    }
    else
    {
        return 0;
    }
}

public function display_visit_appointments()
{     $doc_id=$_SESSION['login_id'];
	$res=$this->db->query("select patient.name, patient.phone_no, patient.area, patient.age, patient.gender, patient.patient_id, visit.date from visit inner join patient on visit.patient_name = patient.id where visit.doctor_id='$doc_id' and visit.token!=''");

	$rows = array();
	while($r = mysqli_fetch_array($res)){
		$date = strtotime($r['date']);
	    $r['date'] = date("j F Y",$date);
		$rows[] = $r;
	}
	$res = json_encode($rows);
	return $res;

	//$str='';
	// $str='  <table class="table table-bordered table-striped table-hover dataTable js-exportable">
 //                                  <thead>
 //                                    <tr>
 //                                    <th>Date</th>
 //                                        <th>Patient Name</th>
 //                                        <th>Email</th>
 //                                        <th>Phone No</th>
 //                                        <th>Address</th>
 //                                         <th>Area</th>
 //                                         <th>City</th>
 //                                          <th>State</th>
                                        
 //                                    </tr>
 //                                </thead>
 //                                 <tbody>';
 //     $str='<div class="row contentTable">
	// 		<div class="table-responsive" style="height:150px; overflow:scroll">
	// 			<table class="patientsList">
	// 				<thead  style="font-weight: 700">
	// 					<tr  style="color: #f8f8f8; background-color: white">
	// 						<td>Patient Name</td>
	// 						<td>Contact</td>
	// 						<td>Address</td>
	// 						<td>Age</td>
	// 						<td>Gender</td>
	// 						<td>Patient Id</td>
	// 						<td>Date</td>
	// 					</tr>
	// 				</thead>
	// 				<tbody>';                            	

	// if($res->num_rows > 0)
	// {
	// 	while($data=$res->fetch_assoc())
	// 	{
	// 		$data1=$this->getById($data['patient_name'],"patient");
			// $str.=' <tr>                <th>'.$data['date'].'</th>
   //                                      <td>'.$data['patient_name'].'</td>
   //                                      <td>'.$data['email'].'</td>
   //                                      <td>'.$data['phone_no'].'</td>
   //                                      <td>'.$data['address'].'</td>
   //                                      <td>'.$data['area'].'</td>
   //                                      <td>'.$data['city'].'</td>
   //                                      <td>'.$data['state'].'</td>
                                      
                                        
   //                                  </tr>
   //                                 ';

			// $str.='<tr>
			// 	    <td class="patientName">'.$data['patient_name'].'</td>
			// 	    <td>'.$data['phone_no'].'</td>
			// 	    <td>'.$data['area'].'</td>
			// 	     <td>'.$data['age'].'</td>
			// 	    <td>'.$data['gender'].'</td>
			// 	    <td>'.$data['patient_id'].'</td>
			// 	     <td>'.$data['date'].'</td>
			// 	    '/*<td><div class="img-circle patientImage"></div>
			// 	    <div class="img-circle patientImage"></div></td>*/.'
			// 	  </tr>';
		
	// 	}	

	// }
	// else {
	// 		$str.='<tr><td colspan="7">No records found to show.</td></tr>';
	// 	}
	// $str.='</tbody></table></div></div>';
	//  return $str;
}
public function display_visit_recent()
{     $doc_id=$_SESSION['login_id'];
$date=date('Y-m-d');
$start = strtotime($date." -  8 days");
$date1 = strtotime($date." +  1 days");
$start=date('Y-m-d', $start); 

	$res=$this->db->query("select * from visit where doctor_id='$doc_id' and (date < '$date' and date > '$start') and token=''  ");
	
	$str='';
	$str='  <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>Patient Name</th>
                                        <th>Date</th>
                                         <th>Time</th>
                                         <th>Additional Information</th>
                                         <th>Action</th>
                                    </tr>
                                </thead>
                                 <tbody>';
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
			$data1=$this->getById($data['patient_name'],"patient");
			$str.=' <tr>
                                        <td>'.$data1['name'].'</td>
                                        <td>'.$data['date'].'</td>
                                        <td>'.$data['time'].'</td>
                                        <td>'.$data['add_info'].'</td>
                                      
                                        <td><a href="'.base_url_doc.'visit/?edit='.$data['id'].'" class="btn btn-info"><i class="material-icons">edit</i></a><a href="'.base_url_doc.'visit/?delete_re='.$data['id'].'" class="btn btn-info" onclick="return conf();"><i class="material-icons">clear</i></a>
								 </td>
                                    </tr>
                                   ';
		
		}	
	}
	$str.=' </tbody></table>';
	 return $str;
}
public function display_visit_recent_appointment()
{     $doc_id=$_SESSION['login_id'];
$date=date('Y-m-d');
$start = strtotime($date." -  8 days");
$date1 = strtotime($date." +  1 days");
$start=date('Y-m-d', $start); 

	$res=$this->db->query("select * from visit where doctor_id='$doc_id' and (date < '$date' and date > '$start')and token!='' ");
	
	$str='';
	$str='  <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                    <th>Date</th>
                                        <th>Patient Name</th>
                                        <th>Email</th>
                                        <th>Phone No</th>
                                        <th>Address</th>
                                         <th>Area</th>
                                         <th>City</th>
                                          <th>State</th>
                                        
                                    </tr>
                                </thead>
                                 <tbody>';
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
			
			$str.=' <tr>                <th>'.$data['date'].'</th>
                                        <td>'.$data['patient_name'].'</td>
                                        <td>'.$data['email'].'</td>
                                        <td>'.$data['phone_no'].'</td>
                                        <td>'.$data['address'].'</td>
                                        <td>'.$data['area'].'</td>
                                        <td>'.$data['city'].'</td>
                                        <td>'.$data['state'].'</td>
                                      
                                        
                                    </tr>
                                   ';
		
		}	
	}
	$str.=' </tbody></table>';
	 return $str;
}
public function edit_patient_dropdown($id)
{
	$doc_id=$_SESSION['login_id'];
	$res=$this->db->query("select * from patient where doctor_id='$doc_id'");
	$str='';
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
			if($data['id']==$id)
			{
				$select='selected';
			}
			else{
				$select='';
			}
			$str.='<option value="'.$data['id'].'" '.$select.'> '.$data['name'].'</option>';
		}
	}
	return $str;
}
public function patient_dropdown()
{
	$doc_id=$_SESSION['login_id'];
	$res=$this->db->query("select * from patient where doctor_id='$doc_id'");
	$str='';
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
			
			$str.='<option value="'.$data['id'].'" > '.$data['name'].'</option>';
		}
	}
	return $str;
}
public function complaints_dropdown()
{
	$doc_id=$_SESSION['login_id'];
	$res=$this->db->query("select * from complaints where doctor_id='$doc_id'");
	$str='';
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
			
			$str.='<option value="'.$data['id'].'" > '.$data['name'].'</option>';
		}
	}
	return $str;
}
public function Observations_dropdown()
{
	$doc_id=$_SESSION['login_id'];
	$res=$this->db->query("select * from observations where doctor_id='$doc_id'");
	$str='';
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
			
			$str.='<option value="'.$data['id'].'" > '.$data['name'].'</option>';
		}
	}
	return $str;
}
public function investigations_dropdown()
{
	$doc_id=$_SESSION['login_id'];
	$res=$this->db->query("select * from investigations where doctor_id='$doc_id'");
	$str='';
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
			
			$str.='<option value="'.$data['id'].'" > '.$data['name'].'</option>';
		}
	}
	return $str;
}
public function diagnoses_dropdown()
{
	$doc_id=$_SESSION['login_id'];
	$res=$this->db->query("select * from dignoses where doctor_id='$doc_id'");
	$str='';
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
			
			$str.='<option value="'.$data['id'].'" > '.$data['name'].'</option>';
		}
	}
	return $str;
}
public function morabidities_dropdown()
{
	$doc_id=$_SESSION['login_id'];
	$res=$this->db->query("select * from co_morabidities where doctor_id='$doc_id'");
	$str='';
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
			
			$str.='<option value="'.$data['id'].'" > '.$data['name'].'</option>';
		}
	}
	return $str;
}
public function edit_visit($patient_name,$date,$time,$add_info,$id)
{
	
	$res=$this->db->query("update visit set patient_name='$patient_name',date='$date',time='$time',add_info='$add_info' where id='$id'");
	if(@$res)
	{
		return true;
	}
}
public function add_area($name)
{ 
$doc_id=$_SESSION['login_id'];
	$res=$this->db->query("insert into area(name,doctor_id) values('$name','$doc_id')");
	if(@$res)
	{
		return true;
	}
}
public function display_area()
{
	$doc_id=$_SESSION['login_id'];
	$res=$this->db->query("select * from area where doctor_id='$doc_id'");
	$str='';
	$str='  <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>Area Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                 <tbody>';
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
			
			$str.=' <tr>
                                        <td>'.$data['name'].'</td>
                                                                            
                                        <td><a href="'.base_url_doc.'area/?delete='.$data['id'].'" class="btn btn-info" onclick="return conf();"><i class="material-icons">clear</i></a>
								 </td>
                                    </tr>
                                   ';
		
		}	
	}
	$str.=' </tbody></table>';
	 return $str;
}
public function area_dropdown()
{
	$doc_id=$_SESSION['login_id'];
	$result=$this->db->query("select city from doctors where id='$doc_id'");
	$ddata=$result->fetch_assoc();
	$city=$ddata['city'];
	$res=$this->db->query("select * from area_name where district='$city'");
	
	$str='';
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
			$str.='<option value="'.$data['area'].'">'.$data['area'].'</option>';
		}
	}
	return $str;
}
public function group_dropdown()
{
	$doc_id=$_SESSION['login_id'];
	$res=$this->db->query("select * from groups where doctor_id='$doc_id'");
	
	$str='';
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
			$str.='<option value="'.$data['id'].'">'.$data['name'].'</option>';
		}
	}
	return $str;
}
public function area_dropdown_edit($id)
{
	$doc_id=$_SESSION['login_id'];
	$res=$this->db->query("select * from area where doctor_id='$doc_id'");
	
	$str='';
	if($res->num_rows > 0)
	{
		
		while($data=$res->fetch_assoc())
		{
			if($id==$data['id'])
		   {
			$selected="selected";
		     }
		else{
			$selected='';
		    }
			$str.='<option value="'.$data['id'].'" '.$selected.'>'.$data['name'].'</option>';
		 }
	}
	return $str;
}
public function area_wise_patient($name)
{
	$doc_id=$_SESSION['login_id'];
	
	$res=$this->db->query("select * from patient where doctor_id='$doc_id' and area='$name'");
	$str='';
	$str='  <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                         <th>Phone No</th>
                                        <th>Address</th>
                                        <th>City</th>
                                        <th>State</th>
                                       
                                         <th>Pincode</th>
                                         <th>Action</th>
                                    </tr>
                                </thead>
                                 <tbody>';
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
			$str.=' <tr>
                                        <td>'.$data['name'].'</td>
                                        <td>'.$data['email'].'</td>
                                        <td>'.$data['phone_no'].'</td>
                                        <td>'.$data['address'].'</td>
                                        <td>'.$data['city'].'</td>
                                        <td>'.$data['state'].'</td>
                                        <td>'.$data['pincode'].'</td>
                                        <td><a href="'.base_url_doc.'patient/?edit='.$data['id'].'" class="btn btn-info"><i class="material-icons">edit</i></a>
								 </td>
                                    </tr>
                                   ';
		
		}	
	}
	$str.=' </tbody></table>';
	 return $str;
	
}
public function add_video($title,$description,$file_name)
{
    	$doc_id=$_SESSION['login_id'];
	$date=date('Y-m-d');
		$res=$this->db->query("insert into video_promotion(title,description,file_name,doctor_id,date,status) values('$title','$description','$file_name','$doc_id','$date','Pending')");
		return $res;
}
public function add_education($title,$description,$file_name,$video_url,$site,$short_description)
{
	$doc_id=$_SESSION['login_id'];
	$date=date('Y-m-d');
	
	$res=$this->db->query("insert into doc_blog(title,short_description,description,image,video,doctor_id,site,date,status) values('$title','$short_description','$description','$file_name','$video_url','$doc_id','$site','$date','Pending')");

	if(@$res)
	{
		/*echo "<script type='text/javascript'>alert('test1');</script>";*/
		$active_name="add education";
	
		$patient_id=0;
	
		$action='add';
		$date=date('Y-m-d');
	   $time=date("h:i");
		
		//$res1=$this->db->query("insert into activity(name,patient_id,doctor_id,action,date,time) values('$active_name','$patient_id','$doc_id','$action','$date','$time') "); 
		return TRUE;
	}
}
public function add_blog($title,$description,$file_name,$video_url,$site,$short_description)
{
	$doc_id=$_SESSION['login_id'];
	
	$res=$this->db->query("insert into education(title,description,file_name,doctor_id,video_url,site,short_description) values('$title','$description','$file_name','$doc_id','$video_url','$site','$short_description')");
	if(@$res)
	{
		$active_name="add blog";
	
		$patient_id=0;
	
		$action='add';
		$date=date('Y-m-d');
	   $time=date("h:i");
		
		//$res1=$this->db->query("insert into activity(name,patient_id,doctor_id,action,date,time) values('$active_name','$patient_id','$doc_id','$action','$date','$time') "); 
		return TRUE;
	}
}

public function add_clinical_note_options($title, $table)
{
	$doc_id=$_SESSION['login_id'];

	$res=$this->db->query("insert into $table (name, doctor_id) values('$title','$doc_id')");
	if(@$res)
	{
		return TRUE;
	}
}
public function display_education()
{
	$doc_id=$_SESSION['login_id'];
	$email=$_SESSION['email'];
	$res=$this->db_blog->query("select * from wp1_users where user_email='$email'");
	$data_id  = $res->fetch_assoc();
	$data_id = $data_id['ID'];
	$res1 = $this->db_blog->query("select * from wp1_posts where post_author = '$data_id' and post_status='publish' and comment_status='open' and ping_status='open' and post_type='post'");
	$str='';
	/*$str='  <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Video Url</th>
                                        <th>Site</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                 <tbody>';*/

    $str.='<div class="row contentTable " >
		<div class=" col-sm-12 table-responsive " style="height: 480px">
			<table id="blog_table" class="patientsList" >
				<thead  style="font-weight: 700">
					<tr style="color: #f8f8f8; background-color: white">
						<td>Date</td>
						<td>Title</td>
						
						
						
						<td>Action</td>
					</tr>
				</thead>
				<tbody>';
			$count = 1;
	if($res1->num_rows > 0)
	{
		while($data=$res1->fetch_assoc())
		{
			$link = $data['guid'];
			/*$str.=' <tr>
                                        <td>'.$data['title'].'</td>
                                        <td>'.htmlspecialchars_decode($data['description']).'</td>
                                        <td>'.$data['video'].'</td>
                                        <td>'.$data['site'].'</td>
                                        <td><a href="'.base_url_doc.'education/?edit='.$data['id'].'" class="btn btn-info"><i class="material-icons">edit</i></a>
                                        <a href="'.base_url_doc.'education/?delete='.$data['id'].'" class="btn btn-danger" onclick="return conf();"> <i class="material-icons">clear</i></a>
								 </td>
                                    </tr>
                                   ';*/
                                   $date = strtotime($data['post_date']);
                                    //echo date(“j F Y”, $date);
			$str.='<tr>                 <td>'.date("j F Y",$date).'</td>
                                        <td>'.$data['post_title'].'</td>
                                       
                                        
                                        <td>
				    						
				    						<a href="'.$link.'"  onclick="return conf();"><div class="patient-list-buttons glyphicon glyphicon-eye-open"></div></a>
										</td></tr>';
								$count++ ;	
		}	
	}
	 else {
			$str.='<tr><td colspan="5">No Records Found To Display.</td></tr>';
		}
	$str.=' </tbody></table></div></div>';
	 return $str;
}
public function delete_error($id)
{
	$res = $this->db->query("delete from error where id='$id'");
    
    if($res){
        
        return TRUE;
    }
}


public function delete_education($id)
{
	$res = $this->db->query("delete from doc_blog where id='$id'");
    
    if($res){
        
        return TRUE;
    }
}
public function delete_doc_blog($id)
{
	$res = $this->db->query("delete from education where id='$id'");
    
    if($res){
        
        return TRUE;
    }
}
public function delete_video($id)
{
	$res = $this->db->query("delete from video_promotion where id='$id'");
    
    if($res){
        
        return TRUE;
    }
}
public function display_video($doc_id)
{
	$doc_id=$_SESSION['login_id'];
	$res=$this->db->query("select * from video_promotion where doctor_id='$doc_id'");
	$str='';
/*	$str='  <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Short Description</th>
                                        <th>Video Url</th>
                                        <th>Site</th>
                                        <th>Helpful(Y/N)</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                 <tbody>';*/
    $str='<div class="row contentTable " >
		<div class=" col-sm-12 table-responsive " style="padding:0">
			
				<table class="patientsList " style="font-size:18px;">
					<thead  style="font-weight: 70">
							<tr style="color: #f8f8f8; background-color: white; font-weight:700">
							<td  >Date</td>	<td  >Title</td>
                                        <td >Description</td>
                                        <td >Video Name</td>
                                        <td>Status</td>
                                        <td >Action</td>						
							</tr>
						</thead>
						<tbody>';
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
			$str.='  <tr><td >'.date("j F Y",strtotime($data['date'])).' </td>
                                        <td >'.$data['title'].' </td>
                                       <td>'.htmlspecialchars_decode($data['description']).'</td>
                                        
                                        <td>'.$data['file_name'].'</td>
                                        <td>'.$data['status'].'</td>
                                        <td ><a href="'.base_url_doc.'promotional.php?delete_video='.$data['id'].'"  onclick="return conf();"><div class="patient-list-buttons glyphicon glyphicon-trash"></div></a>

								 </td>
                                  </tr>
                                   ';
		
		}	
	}
	$str.=' </tbody></table></div></div>';
	 return $str;
}
public function display_doc_blog($doc_id)
{
	$doc_id=$_SESSION['login_id'];
	$res=$this->db->query("select * from education where doctor_id='$doc_id'");
	$str='';
/*	$str='  <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Short Description</th>
                                        <th>Video Url</th>
                                        <th>Site</th>
                                        <th>Helpful(Y/N)</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                 <tbody>';*/
    $str='
			
				<table id="health_tip_table" class="patientsList col-sm-12" style="font-size:18px;">
					<thead  style="font-weight: 70">
							<tr style="color: #f8f8f8; background-color: white; font-weight:700">
								<td  >Title</td>
                                        
                                        <td >Video</td>
                                        <td> Status </td>
                                        <td >Action</td>						
							</tr>
						</thead>
						<tbody>';
				$count =1;	
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
			$str.='  <tr>
                                        <td >'.$data['title'].'  </td>
                                       
                                        
                                        <td>'.$data['video_url'].'</td>
                                        <td>'.$data['status'].'</td>
                                        <td ><a href="'.base_url_doc.'editBlog.php?edit_health='.$data['id'].'"  onclick="return conf();"><div class="patient-list-buttons glyphicon glyphicon-pencil"></div></a>
                                        <a href="'.base_url_doc.'promotional.php?delete_health='.$data['id'].'"  onclick="return conf();"><div class="patient-list-buttons glyphicon glyphicon-trash"></div></a>
                                        <a href="'.base_url_doc.'blogInfo.php?view='.$data['id'].'"  onclick="return conf();"><div class="patient-list-buttons glyphicon glyphicon-eye-open"></div></a>

								 </td>
                                  </tr>
                                   ';
	$count++ ;
		}	
	}
	$str.=' </tbody></table>';
	 return $str;
}



public function edit_education($title,$description,$file_name,$id,$video_url,$site,$short_description)
{
	$res=$this->db->query("update doc_blog set title='$title',description='$description',image='$file_name',video='$video_url',site='$site',short_description='$short_description' where id='$id'");
	if(@$res)
	{
		$active_name="Update education";
	
		$patient_id=0;
	
		$action='edited';
		$date=date('Y-m-d');
	   $time=date("h:i");
		$doc_id=$_SESSION['login_id'];
		$res1=$this->db->query("insert into activity(name,patient_id,doctor_id,action,date,time) values('$active_name','$patient_id','$doc_id','$action','$date','$time') ");
		return true; 
	}
}


public function edit_blog($title,$description,$file_name,$id,$video_url,$site,$short_description)
{
	
	$res=$this->db->query("update education set title='$title',description='$description',file_name='$file_name',video_url='$video_url',site='$site',short_description='$short_description' where id='$id'");
	return $res;
	if(@$res)
	{
		$active_name="Update blog";
	
		$patient_id=0;
	
		$action='edited';
		$date=date('Y-m-d');
	   $time=date("h:i");
		$doc_id=$_SESSION['login_id'];
		$res1=$this->db->query("insert into activity(name,patient_id,doctor_id,action,date,time) values('$active_name','$patient_id','$doc_id','$action','$date','$time') ");
		return true;
	}
}
public function add_group($name)
{
	$doc_id=$_SESSION['login_id'];
	$res=$this->db->query("insert into groups(name,doctor_id) values('$name','$doc_id')");
	if(@$res)
	{
		return true;
	}
}
public function edit_group($name,$id)
{
	$doc_id=$_SESSION['login_id'];
	$res=$this->db->query("update groups set name='$name' where id='$id'");
	if(@$res)
	{
		return true;
	}
}


public function display_groups1()
 {
 	$id = $_SESSION['login_id'];
 	$res = $this->db->query("select * from groups where doctor_id='$id'");

 	$str='';

 	if($res->num_rows > 0)
 	{
 		while($data = $res->fetch_assoc())
 		{
 			$str.='<input type="checkbox" name="group[]" value="'.$data['name'].'">'.$data['name'].'<br>';
 		}
 	}
 	return $str;
 }
 public function display_groups2()
 {
 	$id = $_SESSION['login_id'];
 	$res = $this->db->query("select * from groups where doctor_id='$id'");

 	$str='';

 	if($res->num_rows > 0)
 	{
 		while($data = $res->fetch_assoc())
 		{
 			$str.='<input type="checkbox" name="group[]" value="'.$data['name'].'">'.$data['name'].'<br>';
 		}
 	}
 	return $str;
 }
 
 public function check_patient_group($id,$name)
 {
     $res = $this->db->query("select * from patient where patient_id='$id'");
     //echo $name;
     //echo $id;
     if($res->num_rows > 0)
     {
         $data = $res->fetch_assoc();
         $data1 = $data['group_names'];
         $data2 = json_decode($data1,TRUE);
         
         foreach($data2 as $groupname)
         {
             //echo $groupname;
             if($groupname==$name)
             {
                    return TRUE;
             }
         }
     }
     return FALSE;
 }
public function display_groups($id)
 {
 	$doc_id = $_SESSION['login_id'];
 	$res = $this->db->query("select * from groups where doctor_id='$doc_id'");

 	$str='';

 	if($res->num_rows > 0)
 	{
 		while($data = $res->fetch_assoc())
 		{
 			$str.='<input type="checkbox" name="group[]" value="'.$data['name'].'"';
 			if($this->check_patient_group($id,$data['name'])){ 
 			    $str.='checked readonly';
 			    }
 			$str.= '>'.$data['name'].'<br>';
 		}
 	}
 	return $str;
 }
public function display_group()
{
	$doc_id=$_SESSION['login_id'];
	$res=$this->db->query("select * from groups where doctor_id='$doc_id'");
	$str='';
	/*$str='  <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                      
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                 <tbody>';*/
  	$str='<div class="col-sm-12 contentTable">
			<div class="col-sm-12 table-responsive" >
				<table class="patientsList">
					<thead  style="font-weight: 700">
							<tr  style="color: #333333; background-color: white">
								 <th>Name</th>
                                       <th>Action</th>						
							</tr>
						</thead>
						<tbody>';
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
			$str.=' <tr>
                                        <td><a style="text-decoration:none" href="setting.php?edit_group='.$data['id'].'">'.$data['name'].'</a></td>
                                      
                                        <td>
                                        <div class="patient-list-buttons glyphicon glyphicon-trash" onclick="delete_group('.$data['id'].')"></div>
								 </td>
                                    </tr>
                                   ';
		
		}	
	} else {
		$str.="<td colspan='2'>No Records Found.</td>";
	}
	$str.=' </tbody></table></div></div>';
	 return $str;
}
public function group_wise()
{
	$doc_id=$_SESSION['login_id'];
	$res=$this->db->query("select * from groups where doctor_id='$doc_id' ");
	$str='';
	$str='  <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                      
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                 <tbody>';
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
			$str.=' <tr>
                                        <td>'.$data['name'].'</td>
                                      
                                        <td><a href="'.base_url_doc.'patient/?display_group='.$data['id'].'" class="btn btn-info"><i class="material-icons">edit</i></a>
                                      
								 </td>
                                    </tr>
                                   ';
		
		}	
	}
	$str.=' </tbody></table>';
	 return $str;
}
public function group_wise_patient($id)
{
	$doc_id=$_SESSION['login_id'];
	$res=$this->db->query("select * from patient where doctor_id='$doc_id' and groups='$id' ");
	$str='';
	$str='  <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                         <th>Phone No</th>
                                        <th>Address</th>
                                        <th>City</th>
                                        <th>State</th>
                                       
                                         <th>Pincode</th>
                                         <th>Action</th>
                                    </tr>
                                </thead>
                                 <tbody>';
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
			$str.=' <tr>
                                        <td>'.$data['name'].'</td>
                                        <td>'.$data['email'].'</td>
                                        <td>'.$data['phone_no'].'</td>
                                        <td>'.$data['address'].'</td>
                                        <td>'.$data['city'].'</td>
                                        <td>'.$data['state'].'</td>
                                        <td>'.$data['pincode'].'</td>
                                        <td><a href="'.base_url_doc.'patient/?edit='.$data['id'].'" class="btn btn-info"><i class="material-icons">edit</i></a>
								 </td>
                                    </tr>
                                   ';
		
		}	
	}
	$str.=' </tbody></table>';
	 return $str;
}
public function display_birthday($start,$end)
{
	$start=explode("-",$start);
	$end=explode("-",$end);
	$month=$start[1]-1;
	$month_end=$end[1]+1;
	$date=$start[2]-1;
	$date_end=$end[2]+1;
	
	$doc_id=$_SESSION['login_id'];
	$res=$this->db->query("select * from patient where doctor_id='$doc_id' ");
	$str='';
	$str='  <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                         <th>Phone No</th>
                                        <th>Address</th>
                                        <th>City</th>
                                        <th>State</th>
                                       
                                         <th>DOB</th>
                                         <th>Action</th>
                                    </tr>
                                </thead>
                                 <tbody>';
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
			$birth=explode("-",$data['dob']);
		
			if($birth[1] > $month && $birth[1] < $month_end)
			{
				
				if($birth[2] > $date && $birth[2] < $date_end)
			     {
			$str.=' <tr>
                                        <td>'.$data['name'].'</td>
                                        <td>'.$data['email'].'</td>
                                        <td>'.$data['phone_no'].'</td>
                                        <td>'.$data['address'].'</td>
                                        <td>'.$data['city'].'</td>
                                        <td>'.$data['state'].'</td>
                                        <td>'.$data['dob'].'</td>
                                        <td><a href="'.base_url_doc.'communications/?send_msg='.$data['id'].'" class="btn btn-info"><i class="material-icons">send</i></a>
                                        <a href="'.base_url_doc.'communications/?send_email='.$data['id'].'" class="btn btn-info"><i class="material-icons">email</i></a>
								 </td>
                                    </tr>
                                   ';
                }
		 }
		}	
	}
	$str.=' </tbody></table>';
	 return $str;
}
public function send_birthday_email($id)
{
$data=$this->getById($id,"patient"); 
require_once("phpmailer/PHPMailerAutoload.php");

              $mail = new PHPMailer();

			//   $email = $_GET['email'];

			 $mailhost = "docconsult.in";
              $smtpUser = "mail@docconsult.in";
              $smtpPassword = "telekast@123";

			  

			  $name = "JPR Infotech";

			  $subject = "test";

			  $from = "support@jprinfotech.com";

			  



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

                $mail->AddAddress($data['email']);

                $mail->IsHTML(true);

                $mail->Subject = $subject;

                $mail->Body = '<div style="width:100%; height:100%; margin:0;" >test </div>';

			$mail->Send();
}
public function change_activity_doctor_status($date)
{
    $doc_id = $_SESSION['login_id'];
    $res = $this->db->query("update activity set doctor_status='already_seen' where doctor_id='$doc_id' and date='$date'"); 
}
public function display_activity()
{
	$doc_id=$_SESSION['login_id'];
	$date = date("Y-m-d");
	$res=$this->db->query("select * from activity where doctor_id='$doc_id' and DATEDIFF(CURDATE(),activity.date)<5 and doctor_status='not_seen' order by date DESC");
	
	$str='';
	if($res->num_rows > 0)
	{
		
		
		/* $str='<div style="width:100%;float:left;">
		 <div class="activity_header"> Activities </div>';*/
		 
		 $str = '<div class="col-sm-12 activityTable">
		<ul style="padding-left:0">';
		$count=0;
		$same_date='';
		while($data=$res->fetch_assoc())
		{
		
			$patient_name=$this->getById($data['patient_id'],"patient");
			$doctor_name=$this->getById($data['doctor_id'],"doctors");
            
            
		     if($data['date'] == @$same_date )
		     {
			 	
			 }
			 else{
			 	if($same_date>$data['date']){
			 		$str.='</ul></li>';
			 	}
                
                
                //echo $data["date"].;
			 	$same_date=$data['date'];
			 	$str.='<li style="position:relative"><strong>'.date("j F Y",strtotime($data['date'])).'</strong><span style="font-size:30px;top:15px;cursor:pointer;right:0;position:absolute" class="remove_field" onclick="change_activity_stat(\''.$data['date'].'\')">&times;</span></li><li>
				<ul class="activities" style="padding-left:0">';
			 }
		      	
        /* $str.='<div class="activity_body" style="'.$background.'"><div style="width:70%;float:left;">'.$data['name'].'  '.$patient_name['name'].' By '.$doctor_name['name'].'</div> <div style="width:30%; float:left;text-align:right">'.$data['action'].' at '.$data['time'].' by '.$doctor_name['name'].'  </div> </div>';		*/
                $patient_name = $this->getPatientName($data['patient_id']);
                if(!empty($patient_name)){
         $str.='<li>'.$data['name'].'  '.$patient_name['name'].' : '.$patient_name.'<span>'.$data['time'].'</span></li>';}
         else
         {
             $str.='<li>'.$data['name'].'  '.$patient_name['name'].' : '.$data['patient_id'].'<span>'.$data['time'].'</span></li>';
         }
		}	
		$str.='</ul></li></ul></div>';
	}
	return $str;
}

public function display_profile_service()
{
	$str='';
	$doc_id=@$_SESSION['login_id'];
	$res=$this->db->query("select * from doctors where id='$doc_id'");
	if($res->num_rows >0)
	{
		while($data=$res->fetch_assoc())
		{
			$service=json_decode($data['services'],true);
			foreach($service as $ser)
			{
				$str.='<li style="float: left;width: 33%;">'.$ser['service'].'</li>';
			}
			
		}
	}
	return $str;
}
public function eductaion_li()
{
$doc_id=$_SESSION['login_id'];


		$res=$this->db->query("select * from doctors where id='$doc_id'");
	
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
			$quli=json_decode($data['education'],true);
			
			foreach($quli as $data1)
			{
				
			@$str.='<li>'.$data1['qualification'].'&nbsp;'.$data1['collage'].'&nbsp;'.$data1['year'].'</li>';
               }
				}	
	}

	 return $str;
}



public function quilfication()
{
	$doc_id=$_SESSION['login_id'];
	$res=$this->db->query("select * from doctors where id='$doc_id'");
	$str='';
	if($res->num_rows>0)
	{
	   while($data=$res->fetch_assoc())
	   {
	   	$qul=json_decode($data['education'],true);
	   	foreach($qul as $qualification)
	   	{
			$str.='<small>'.$qualification['qualification'].'&nbsp;</small>';
		}
	   }
	}
	return $str;
}


public function sms_setting()
{
	$doc_id=$_SESSION['login_id'];
	$res=$this->db->query("select * from practice_doctor where doctor_id='$doc_id'");
	
	
	
	
	
	
	
	$str=' <table class="table table-bordered table-striped table-hover  ">
                                 <thead>
                                    <tr>
                                        <th>Role</th>
                                        <th>Name</th>
                                         <th colspan="2">New Appointment</th>
                                        <th colspan="2">Cancel/Reschedule Appointment</th>
                                    </tr>
                                    <tr>
                                        <th> </th>
                                        <th> </th>
                                       
                                         <th>SMS</th>
                                         <th>Email</th> 
                                         <th>SMS</th>
                                         <th>Email</th>
                                    </tr>
                                </thead>
                                 <tbody>';
                                 $count=0;
    $res1=$this->db->query("select * from msg_setting where doctor_id='$doc_id'");
   $select_new='';
   $select_cancel='';
   $select_cancel_email='';
   $select_new_email='';
    $data1=$res1->fetch_assoc();
   
   
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
			$find=0; $find1=0; $find2=0; $find3=0;
			$count++;
	      $sms_cencel=json_decode($data1['sms_cancel'],true);
          $ar=count($sms_cencel);
          for($i=0;$i<$ar;$i++)
          {
		  if($data['id']==$sms_cencel[$i])
		   {
			$select_cancel="checked";
			$find=1;
		   }
		else{
			if($find==0)
			$select_cancel="";
		  }
	     }
	      $email_cencel=json_decode($data1['email_cancel'],true);
          $ar=count($email_cencel);
          for($i=0;$i<$ar;$i++)
          {
		  if($data['id']==$email_cencel[$i])
		   {
			$select_cancel_email="checked";
			$find1=1;
		   }
		else{
			if($find1==0)
			$select_cancel_email="";
		  }
	     } 
	     $sms_new=json_decode($data1['sms_new'],true);
          $ar=count($sms_new);
          for($i=0;$i<$ar;$i++)
          {
		  if($data['id']==$sms_new[$i])
		   {
			$select_new="checked";
			$find2=1;
		   }
		else{
			if($find2==0)
			$select_new="";
		  }
	     }
	      $email_new=json_decode($data1['email_new'],true);
          $ar=count($email_new);
          
          for($i=0;$i<$ar;$i++)
          {
		  if($data['id']==$email_new[$i])
		   {
		   	
			$select_new_email="checked";
			$find3=1;
		   }
		else{
			if($find3==0)
			$select_new_email="";
		  }
	     }
			
			$str.=' <tr>
			<td>'.$data['role'].'</td>
			<td>'.$data['name'].'</td>
			<td> <div class="demo-checkbox">
                               
                                <input type="checkbox" id="md_checkbox_'.$count.'" class="chk-col-pink" name="sms_new[]" value="'.$data['id'].'" '.$select_new.'>
                                <label for="md_checkbox_'.$count.'"></label>
                                
                            </div></td>
			<td><div class="demo-checkbox">
                               
                                <input type="checkbox" id="md_checkbox_1'.$count.'" class="chk-col-pink" name="email_new[]" value="'.$data['id'].'" '.$select_new_email.' >
                                <label for="md_checkbox_1'.$count.'" ></label>
                                
                            </div></td>
			<td><div class="demo-checkbox">
                               
                                <input type="checkbox" id="md_checkbox_2'.$count.'" class="chk-col-pink"           name="sms_cancel[]" value="'.$data['id'].'" '.$select_cancel.' >
                                <label for="md_checkbox_2'.$count.'"></label>
                                
                            </div></td>
			<td><div class="demo-checkbox">
                               
                                <input type="checkbox" id="md_checkbox_3'.$count.'" class="chk-col-pink" name="email_cancel[]" value="'.$data['id'].'" '.$select_cancel_email.' >
                                <label for="md_checkbox_3'.$count.'"></label>
                                
                            </div></td>
               </tr>
                                   ';
       
		}	
	}
	$str.=' </tbody></table>';

	
	
	return $str;
}
public function update_msg_setting($sms_new,$email_new,$sms_cancel,$email_cancel)
{ 
	$doc_id=$_SESSION['login_id'];
	$res=$this->db->query("select * from msg_setting where doctor_id='$doc_id'");
	if(@$res->num_rows>0)
	{
		$res1=$this->db->query("update msg_setting set sms_new='$sms_new',email_new='$email_new',sms_cancel='$sms_cancel',email_cancel='$email_cancel' where doctor_id='$doc_id'");
	}
	else{
		$res1=$this->db->query("insert into msg_setting(sms_new,email_new,sms_cancel,email_cancel,doctor_id) values('$sms_new','$email_new','$sms_cancel','$email_cancel','$doc_id')");
	}
	if(@$res1)
	{
		return true;
	}
}
public function add_id_proof($image)
{
	$doc_id=$_SESSION['login_id'];
	$res=$this->db->query("update doctors set id_proof='$image' where id='$doc_id'");
	if(@$res)
	{
		return true;
	}
}
public function add_qul_proof($image)
{
	$doc_id=$_SESSION['login_id'];
	$res=$this->db->query("update doctors set qualification_proof='$image' where id='$doc_id'");
	if(@$res)
	{
		return true;
	}
}
public function short_consult()
{
	$doc_id=$_SESSION['login_id'];
	$doctor=$this->getById($doc_id,"doctors");
	$res=$this->db->query("select * from question where doctor_id='".$doc_id."' and status!='pending'");
	$str='';
	if(@$res->num_rows>0)
	{  
	
		while($data=$res->fetch_assoc())
		{
			$patient=$this->getById($data["patient_id"],"patient");
			// $str.='<a href="'.base_url_doc.'consult.php/?con='.$data['id'].'"> <div style="width:30%;float:left;margin-bottom:10px;border:solid #e1e1e1 1px;margin-left:10px;padding:10px; background: #f8f8f8; box-shadow: 0px 1px 1px 2px #e1e1e1; "><div style="font-weight:bold;font-size:15px;width:100%;float:left;color:#39b54a; text-transform: capitalize;margin-bottom:5px">'.$data['pro_type'].' </div>
			// <div style="width:100%;float:left;color:red">Submited By : '.$patient['name'].' </div>
			// <div class="consult_body">'.$data['msg'].' </div></div> </a>';

// 			$str.='<a href="'.base_url_doc.'chatPage.php?con='.$data['id'].'" style="text-decoration: none;">
// 			<div class="ques-box">
//     			<h4 style="margin-bottom: 6px"><strong>'.$data['pro_type'].'</strong></h4>
//     			<span class="sub-heading" >Submitted By:'.$patient['name'].'</span><br>
//     			<p style="text-align: justify;margin-top: 6px">'.$data['msg'].'</p>
//     		</div></a>';
		
		
		
		 $str.='<a class="feed-flex-card" href="'.base_url_doc.'chatPage.php?con='.$data['id'].'" style="text-decoration: none;margin:10px;color:#333">
		 <div  style="">
            <div class="col-sm-12">
				<h5 ><strong>'.$data['pro_type'].'</strong></h5>
				';
	
		$str.='<h5><small>Submitted By: '.$patient['name'].'</small></h5>
			</div>
			<div class=" patient-card ">
			<div class="col-sm-12">
				<h6>'.$data['msg'].'</h6>
			</div>
			</div>
		</div>
		</a>';
		
		
		}
	}
	
	$res=$this->db->query("select * from question where doctor_id='".$doc_id."' and status='pending'");
	if(@$res->num_rows>0)
	{  
	
		while($data=$res->fetch_assoc())
		{
			$patient=$this->getById($data["patient_id"],"patient");
			// $str.='<a href="'.base_url_doc.'consult.php/?con='.$data['id'].'"> <div style="width:30%;float:left;margin-bottom:10px;border:solid #e1e1e1 1px;margin-left:10px;padding:10px; background: white; box-shadow: 0px 1px 1px 2px #e1e1e1; "><div style="font-weight:bold;font-size:15px;width:100%;float:left;color:#39b54a; text-transform: capitalize;margin-bottom:5px">'.$data['pro_type'].' </div>
			// <div style="width:100%;float:left;color:red">Submited By : '.$patient['name'].' </div>
			// <div class="consult_body">'.$data['msg'].' </div></div> </a>';

// 			$str.='<a href="'.base_url_doc.'chatPage.php?con='.$data['id'].'" style="text-decoration: none;"><div class="ques-box">
// 			<h4 style="margin-bottom: 6px"><strong>'.$data['pro_type'].'</strong></h4>
// 			<span class="sub-heading" >Submitted By:'.$patient['name'].'</span><br>
// 			<p style="text-align: justify;margin-top: 6px">'.$data['msg'].'</p>
// 		</div></a>';

            $str.='<a class="feed-flex-card" href="'.base_url_doc.'chatPage.php?con='.$data['id'].'" style="text-decoration: none;margin:10px;color:#333">
		 <div  >
            <div class="col-sm-12">
				<h5 ><strong>'.$data['pro_type'].'</strong></h5>
				';
	
		$str.='<h5><small>Submitted By: '.$patient['name'].'</small></h5>
			</div>
			<div class=" patient-card ">
			<div class="col-sm-12">
				<h6>'.$data['msg'].'</h6>
			</div>
			</div>
		</div>
		</a>';
		}
	}
	
	
	$res=$this->db->query("select * from question where category_id='".$doctor['category']."' and status!='pending'");
	
	if(@$res->num_rows>0)
	{  
	
		while($data=$res->fetch_assoc())
		{
			$patient=$this->getById($data["patient_id"],"patient");
			/*$str.='<a href="'.base_url_doc.'consult.php/?con='.$data['id'].'" > <div style="width:30%;float:left;margin-bottom:10px;border:solid #e1e1e1 1px;margin-left:10px;padding:10px; background: #f8f8f8; box-shadow: 0px 1px 1px 2px #e1e1e1; "><div style="font-weight:bold;font-size:15px;width:100%;float:left;color:#39b54a; text-transform: capitalize;margin-bottom:5px">'.$data['pro_type'].' </div>
			<div style="width:100%;float:left;color:red">Submited By : '.$patient['name'].' </div>
			<div class="consult_body">'.$data['msg'].' </div></div> </a>';*/

// 			$str.='
// 			<a href="'.base_url_doc.'chatPage.php?con='.$data['id'].'" style="text-decoration: none;">
// 			<div class="ques-box">
// 			<h4 style="margin-bottom: 6px"><strong>'.$data['pro_type'].'</strong></h4>
// 			<span class="sub-heading" >Submitted By:'.$patient['name'].'</span><br>
// 			<p style="text-align: justify;margin-top: 6px">'.$data['msg'].'</p>
// 		</div></a>';

            $str.='<a class="feed-flex-card" href="'.base_url_doc.'chatPage.php?con='.$data['id'].'" style="text-decoration: none;margin:10px;color:#333">
		 <div  >
            <div class="col-sm-12">
				<h5 ><strong>'.$data['pro_type'].'</strong></h5>
				';
	
		$str.='<h5><small>Submitted By: '.$patient['name'].'</small></h5>
			</div>
			<div class=" patient-card ">
			<div class="col-sm-12">
				<h6>'.$data['msg'].'</h6>
			</div>
			</div>
		</div>
		</a>';
		}
	}
	
	$res=$this->db->query("select * from question where category_id='".$doctor['category']."' and status='pending'");
	
	if(@$res->num_rows>0)
	{  
	
		while($data=$res->fetch_assoc())
		{
			$patient=$this->getById($data["patient_id"],"patient");
			/*$str.='<a href="'.base_url_doc.'consult.php/?con='.$data['id'].'" > <div style="width:30%;float:left;margin-bottom:10px;border:solid #e1e1e1 1px;margin-left:10px;padding:10px; background: white; box-shadow: 0px 1px 1px 2px #e1e1e1; "><div style="font-weight:bold;font-size:15px;width:100%;float:left;color:#39b54a; text-transform: capitalize;margin-bottom:5px">'.$data['pro_type'].' </div>
			<div style="width:100%;float:left;color:red">Submited By : '.$patient['name'].' </div>
			<div class="consult_body">'.$data['msg'].' </div></div> </a>';*/

// 			$str.='
// 			<a href="'.base_url_doc.'chatPage.php?con='.$data['id'].'" style="text-decoration: none;">
// 			<div class="ques-box">
// 			<h4 style="margin-bottom: 6px"><strong>'.$data['pro_type'].'</strong></h4>
// 			<span class="sub-heading" >Submitted By:'.$patient['name'].'</span><br>
// 			<p style="text-align: justify;margin-top: 6px">'.$data['msg'].'</p>
// 		</div></a>';

            $str.='<a class="feed-flex-card" href="'.base_url_doc.'chatPage.php?con='.$data['id'].'" style="text-decoration: none;margin:10px;color:#333">
		 <div  >
            <div class="col-sm-12">
				<h5 ><strong>'.$data['pro_type'].'</strong></h5>
				';
	
		$str.='<h5><small>Submitted By: '.$patient['name'].'</small></h5>
			</div>
			<div class=" patient-card ">
			<div class="col-sm-12">
				<h6>'.$data['msg'].'</h6>
			</div>
			</div>
		</div>
		</a>';
		}
	}
	
	return $str;
}public function short_consult1()
{
	$doc_id=$_SESSION['login_id'];
	$doctor=$this->getById($doc_id,"doctors");
	$res=$this->db->query("select * from question where category_id='".$doctor['category']."'");
	$str='';
	if(@$res->num_rows>0)
	{  
	
		while($data=$res->fetch_assoc())
		{
			$str.='<a href="'.base_url_doc.'consult/?con='.$data['id'].'"> <div style="width:100%;float:left;margin-bottom:10px"><div class="consult_heading">'.$data['pro_area'].' </div>
			<div class="consult_body">'.$data['msg'].' </div></div> </a>';
		}
	}
	return $str;
}
// public function cunsult_comment($id)
// {
// 	$res=$this->db->query("select * from consult_comment where consult_id='$id'");
// 	$str='';
// 	if($res->num_rows>0)
// 	{
// 		while($data=$res->fetch_assoc())
// 		{ 
// 		$doctor=$this->getById($data['doctor_id'],"doctors");
// 		if(empty($data['doctor_id']))
// 		{
// 			$doctor_name="Patient";
// 		}
// 		else
// 		{
// 			if(!empty($doctor['be_name']))
// 			{
// 				$doctor_name=$doctor['be_name'].". ".$doctor['name'];
// 			}
// 			else{
// 				$doctor_name=$doctor['name'];
// 			}
			
// 		}
		
// 			/*$str.='<div style="width:100%;float:left;margin-bottom:10px"><div class="consult_heading">'.
// 			$doctor_name.' </div>
// 			<div class="consult_body"><h5>Opinion </h5>'.$data['opinion'].'<br> </div></div>';*/
// 			$str.='<div class="text-justify" style="margin:30px 0 0 3%">

// 					<p style="color: #09BC8A;font-size: 16px;">'.$doctor_name.'</p>
// 					<p style="font-size: 14px;margin-left: 3%">'.$data['opinion'].'</p>
// 				</div>';
// 		}
// 	}
// 	return $str;
// }

public function get_pending_ques()
{
    $id=$_SESSION['login_id'];
    $res = $this->db->query("select * from consult_comment where doctor_id='$id' and status='pending'");
    $count = 0;
    if($res->num_rows > 0)
    {
        while($data = $res->fetch_assoc())
        {
            $count++;
        }
    }
    return $count;
}
public function cunsult_comment($id)
{
	$res=$this->db->query("select * from consult_comment where consult_id='$id'");
	$str='';
	if($res->num_rows>0)
	{
		while($data=$res->fetch_assoc())
		{ 
		$doctor=$this->getById($data['doctor_id'],"doctors");
		if(empty($doctor['id']))
		{
			$doctor_name="Patient";
		}
		else
		{
			if(!empty($doctor['be_name']))
			{
				$doctor_name=$doctor['be_name'].". ".$doctor['name'];
			}
			else{
				$doctor_name=$doctor['name'];
			}
			
		}
		
			/*$str.='<div style="width:100%;float:left;margin-bottom:10px"><div class="consult_heading">'.
			$doctor_name.' </div>
			<div class="consult_body"><h5>Opinion </h5>'.$data['opinion'].'<br> </div></div>';*/
			$str.='<div class="text-justify" style="margin:30px 0 0 3%">

 					<p style="color: #09BC8A;font-size: 16px;">'.$doctor_name.'</p>
 					<p style="font-size: 14px;margin-left: 3%">'.$data['opinion'].'</p>
				</div>';
		}
	}
	return $str;
}
public function add_consult_comment($op,$next,$help,$id)
{ 
$doc_id=$_SESSION['login_id'];
$date=date("Y-m-d");
	$res=$this->db->query("insert into consult_comment(opinion,next,help,consult_id,doctor_id,status,date) values('$op','$next','$help','$id','$doc_id','Unread','$date')");
	if(@$res)
	{
		return true;
	}
}
public function display_today_ques()
{
    $doc_id = $_SESSION['login_id'];
    $res = $this->db->query("select * from question where status='active' and doctor_id='$doc_id'");
    
    return $res->num_rows;
}
public function appointment_reports_time_remain()
{   
    $time=date('h:i:a');
   $extime=explode(":",$time);
   $date=date('Y-m-d');
   
   if($extime[2]=="pm")
   {
   	$orgtime=12+$extime[0];
   }
   else
   {
   $orgtime=$extime[0];	
   }
   
  // echo $orgtime;
   $comp=$orgtime.":".$extime[1];
  
    $doc_id=$_SESSION['login_id'];
	$res=$this->db->query("select * from appointments where doctor_id='$doc_id'");

	$str='';
	
	$str='  <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>Patient Name</th>
                                        <th>Patient Email</th>
                                         <th>Appointment Date</th>
                                        <th>Appointment Time</th>
                                        
                                    
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                 <tbody>';
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{ 
		
			     if( ($data['app_time'] > $comp) && (($data['app_date']==$date) || $data['app_date']>$date) )
		      		{
			
		
			$str.=' <tr>
                                        <td>'.$data['patient_name'].'</td>
                                        <td>'.$data['patient_email'].'</td>
                                        <td>'.$data['app_date'].'</td>
                                        <td>'.$data['app_time'].'</td>
                                       
                                       
                                        <td><a href="'.base_url_doc.'patient-detail/?display_appoint='.$data['id'].'" class="btn btn-info"><i class="material-icons">account_circle</i></a>
								 </td>
                                    </tr>
                                   ';
		}
		}	
	}
	$str.=' </tbody></table>';
	 return $str;
}
public function appointment_reports_time_complete()
{    $doc_id=$_SESSION['login_id'];
    $time=date('h:i:a');
   $extime=explode(":",$time);
   $date=date('Y-m-d');
   
   if($extime[2]=="pm")
   {
   	$orgtime=12+$extime[0];
   }
   else
   {
   $orgtime=$extime[0];	
   }
   
  // echo $orgtime;
   $comp=$orgtime.":".$extime[1];
   $res1=$this->db->query("select * from doctor_additional where doctor_id='$doc_id'");
   $data1=$res1->fetch_assoc();
 
   $min=explode(" ",$data1['appointment_slot']);
   $com_min=$extime[1]+$min[0];
   $comp1=$orgtime.":".$com_min;
	$res=$this->db->query("select * from appointments where doctor_id='$doc_id'");
	$str='';
	
	$str='  <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>Patient Name</th>
                                        <th>Patient Email</th>
                                         <th>Appointment Date</th>
                                        <th>Appointment Time</th>
                                        
                                     
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                 <tbody>';
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
				{  
				   $complete_time_Ar=explode(":",$data['app_time']);
		
		     $comp_min=$complete_time_Ar[1]+$min[0];
	         $comp1=$complete_time_Ar[0].":".$comp_min;
	        
	       // echo $data['app_time'] ."<". $comp ."&&". $data['app_date']."==".$date ."&&".$comp .">". $comp1."<br>";
		    if($data['app_time'] < $comp && ($data['app_date']==$date || $data['app_date']< $date) && $comp > $comp1 )
		      {
			
		
			$str.=' <tr>
                                        <td>'.$data['patient_name'].'</td>
                                        <td>'.$data['patient_email'].'</td>
                                        <td>'.$data['app_date'].'</td>
                                        <td>'.$data['app_time'].'</td>
                                       
                                       
                                        <td><a href="'.base_url_doc.'patient-detail/?display_appoint='.$data['id'].'" class="btn btn-info"><i class="material-icons">account_circle</i></a>
								 </td>
                                    </tr>
                                   ';
		}
		}	
	}
	$str.=' </tbody></table>';
	 return $str;
}
public function appointment_reports_ongoing()
{   $doc_id=$_SESSION['login_id'];
    $time=date('h:i:a');
   $extime=explode(":",$time);
   $date=date('Y-m-d');
   
   if($extime[2]=="pm")
   {
   	$orgtime=12+$extime[0];
   }
   else
   {
   $orgtime=$extime[0];	
   }
   
  // echo $orgtime;
   $comp=$orgtime.":".$extime[1];
   $res1=$this->db->query("select * from doctor_additional where doctor_id='$doc_id'");
   $data1=$res1->fetch_assoc();
 
   $min=explode(" ",$data1['appointment_slot']);
   
  
	$res=$this->db->query("select * from appointments where doctor_id='$doc_id'");
	$str='';
	
	$str='  <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>Patient Name</th>
                                        <th>Patient Email</th>
                                         <th>Appointment Date</th>
                                        <th>Appointment Time</th>
                                         <th>Action</th>
                                    </tr>
                                </thead>
                                 <tbody>';
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{ 
		$complete_time_Ar=explode(":",$data['app_time']);
		
		$comp_min=$complete_time_Ar[1]+$min[0];
	    $comp1=$complete_time_Ar[0].":".$comp_min;
	   //     echo $data['app_time'] ."<". $comp ."&&". $data['app_date']."==".$date ."&&".$comp ."<". $comp1."<br>";
		    if($data['app_time'] < $comp && $data['app_date']==$date && $comp < $comp1 )
		      {
			
		
			$str.=' <tr>
                                        <td>'.$data['patient_name'].'</td>
                                        <td>'.$data['patient_email'].'</td>
                                        <td>'.$data['app_date'].'</td>
                                        <td>'.$data['app_time'].'</td>
                                      
                                       
                                        <td><a href="'.base_url_doc.'patient-detail/?display_appoint='.$data['id'].'" class="btn btn-info"><i class="material-icons">account_circle</i></a>
								 </td>
                                    </tr>
                                   ';
		}
		}	
	}
	
	$str.=' </tbody></table>';
	 return $str;
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
public function app_cancel($can,$remark,$patient_sms,$patient_email,$doctor_sms,$doctor_email)
{
	$res=$this->db->query("update appointments set status='Cancel',remark='$remark', cancel_by = '1' where id='$can' ");
	
	if(@$res)
	{
		  
        $send_sms=0;
        $res1=$this->db->query("select * from appointments where id='$can'");
        $data=$res1->fetch_assoc();
        $doctor=$this->getById($data['doctor_id'],"doctors");
        $clinic=$this->getByDoctorId($data['doctor_id'],"clinic");
        $doctor_name=$doctor['be_name'].$doctor['name'];
        $id=$can;
        $email=$data['patient_email'];
        $date=$data['app_date'];
        $time=$data['app_time'];
        $clinic_name=$clinic['name'];
        $phone=$data['phone_no'];
        $phone_no=$doctor['phone_no'];
        $patient_name=$data['patient_name'];
        
        if($patient_sms == 1)
        {
            $forpatientsms = ' cancelled with '.$doctor['be_name'].$doctor['name'].' at '.$clinic['name'] .' on '.$data['app_date'].' at '.$data['app_time'];
            $sms='Hi '.$data['patient_name'].' Your Appointment has been '.$forpatientsms.' you can login here '.base_url.'login';
            $sms = str_replace("<", "", $sms);
            $sms = str_replace(">", "", $sms);
            $sms = rawurlencode($sms);
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
            $data_ch = curl_exec($ch);
            curl_close($ch);
        }    
        if($doctor_sms == 1)
        {
            $doc_sms = ' cancelled with '.$data['patient_name'].' at '.$clinic_name.' on '.$data['app_date'].' at '.$data['app_time'];
            $sms = "Hi ".$doctor['be_name'].$doctor['name']." An Appointment has been ".$doc_sms." you can login here ".base_url."doctor-login"." ";
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
            $data_ch = curl_exec($ch);
            curl_close($ch);
        }
			
        require_once("../phpmailer/PHPMailerAutoload.php");
        $mailhost = "docconsult.in";
        $smtpUser = "mail@docconsult.in";
        $smtpPassword = "telekast@123";

		if($patient_email == 1)
        {	
            $str='<table width="100%" cellpadding="0" cellspacing="0" align="center" border="0" style="max-width:600px;background:#fff;border:solid 1px #fafafb">
            <tbody><tr>
                <td style="height:10px">&nbsp;  </td>
            </tr>
        
            <tr>
                <td>
                    <table width="100%" cellpadding="0" cellspacing="0" border="0" align="center" style="max-width:600px;border-bottom:solid 1px #f0f0f0;padding-bottom:13px">
                        <tbody><tr>
                            <td width="300"><a href="'.base_url.'" style="margin-left:10px;display:block" target="_blank"><img src="https://docconsult.in/image/logo.png" width="200px" height="70px"></a></td>
                           
                        </tr>
                    </tbody></table>
                </td>
            </tr>
            <tr>
                <td>
                    <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#fff" style="padding:15px;font-family:Open Sans,sans-serif">
                        <tbody><tr>
                            <td>
                    <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#fff">
            <tbody><tr>
                <td>
                    <div style="padding-top:20px;padding-left:5px;padding-right:5px;padding-bottom:5px;font-size:12pt;font-weight:bold">
                        Dear '.$patient_name.',
                    </div>
                </td>
                        
                    </tr>
            </tbody></table>
            <div style="padding:5px">
                <b>Sorry to inform you that your Appointment taken by you has been Cancelled. </b>
             <br>
                This mail is<a style="color:#02a6d8;text-decoration:none" href="'.base_url.'" target="_blank" > Generated by Docconsult.</a> Here are the details: 
            </div>
            <div style="padding:5px">
            <table style="margin-top:5px;margin-bottom:5px;border:none;width:540px;color:#333;font-size:10pt;line-height:1.5" cellpadding="3" cellspacing="0">
                <tbody>';
            
    		$str.='  <tr>
                <td style="width:170px;font-weight:bold;border-bottom:1px solid #ebebeb">Appointment with</td>
                <td style="width:350px;border-bottom:1px solid #ebebeb">'.$doctor['be_name'].' '.$doctor['name'].'</td>
            </tr>';	
    	
            $str.='
                
            <tr>
                <td style="width:170px;font-weight:bold;border-bottom:1px solid #ebebeb">Appointment Date</td>
                <td style="width:350px;border-bottom:1px solid #ebebeb"><span><span>'.$date.'</span></span></td>
            </tr>
            <tr>
                <td style="width:170px;font-weight:bold;border-bottom:1px solid #ebebeb">Appointment Time</td>
                <td style="width:350px;border-bottom:1px solid #ebebeb"><span><span class="aQJ">'.$time.'</span></span></td>
            </tr>
            <tr>
                <td style="width:170px;font-weight:bold;border-bottom:1px solid #ebebeb"> Appointment For</td>
                <td style="width:350px;border-bottom:1px solid #ebebeb">'.$patient_name.'</td>
            </tr>
            <tr>
                <td style="width:170px;font-weight:bold;border-bottom:1px solid #ebebeb"> Remark</td>
                <td style="width:350px;border-bottom:1px solid #ebebeb">'.$data['remark'].'</td>
            </tr>
            </tbody></table>
            </div>
            <div style="margin-top:10px;padding:5px;font-weight:bold;font-size:12pt">
                How to get there</div>
            <div>
            <table style="margin-bottom:5px;border:none;width:540px;color:#333;font-size:10pt;line-height:1.5" cellpadding="3" cellspacing="0">
            <tbody>
            <tr>
                <td style="width:120px"> Clinic Name</td>
                <td style="width:400px">'.$clinic['name'].'</td>
            </tr>
            <tr>
                <td style="width:120px"> Address</td>
                <td style="width:400px">'.$clinic['address'].', '.$clinic['area'].', '.$clinic['city'].'</td>
            </tr>
            
                    <tr>
                <td style="width:120px;vertical-align:top">Location</td>
                <td style="width:400px">
                    <a href="http://www.google.com/maps/place/'.$clinic['latitude'].','.$clinic['longitude'].'" style="margin-top:5px;color:#005c87;text-decoration:none" target="_blank" >View in Google Maps</a>
                </td>
            </tr>
                </tbody></table>
            </div>
    
            <div style="margin-top:10px;padding:5px">
                <br>
               If you find this is useful for you please give star rating and feedback. 
            Email us if you have any questions or feedback 
            <br>
            Please Visit on <a href="'.base_url.'"></a></div>
            <table style="border:none;width:540px;color:#7f7f7f;font-size:14px;line-height:1.5;margin-bottom:20px" cellpadding="0" cellspacing="0">
                <tbody><tr>
                            <td style="width:40px">
                      
                    </td>
                    <td style="vertical-align:center;font-weight:bold"><a href="mailto:info@docconsult.in" target="_blank">info@docconsult.in</a></td>
                </tr>
            </tbody></table>
                                </td>
                            </tr>
                        </tbody></table>
                       </td>
                </tr>
            </tbody></table>';
         
            $mail = new PHPMailer();
            $from = "service@docconsult.in";
            $mail->IsSMTP();
            $mail->Host = $mailhost;
            $mail->SMTPAuth = true;
            $mail->Username = $smtpUser;
            $mail->Password = $smtpPassword;
            $mail->Port = 25; // 25 or 465 or 587
            
            $name = "DocConsult";
            $subject = 'Your Appointment with '.@$doctor['be_name'].' '.$doctor['name'].' Has Been Canecelled ';
            $from = "service@docconsult.in";
            $mail->From = $from;
            $mail->FromName = $name;
            $mail->AddReplyTo($from);
            $mail->AddAddress($email);
            $mail->IsHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $str;
            $mail->Send();
        }
        if($doctor_email == 1)
        {
    	    $str1='<table width="100%" cellpadding="0" cellspacing="0" align="center" border="0" style="max-width:600px;background:#fff;border:solid 1px #fafafb">
            <tbody><tr>
                <td style="height:10px">&nbsp;  </td>
            </tr>
        
            <tr>
                <td>
                    <table width="100%" cellpadding="0" cellspacing="0" border="0" align="center" style="max-width:600px;border-bottom:solid 1px #f0f0f0;padding-bottom:13px">
                        <tbody><tr>
                            <td width="300"><a href="'.base_url.'" style="margin-left:10px;display:block" target="_blank"><img src="https://docconsult.in/image/logo.png" width="200px" height="70px"></a></td>
                           
                        </tr>
                    </tbody></table>
                </td>
            </tr>
            <tr>
                <td>
                    <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#fff" style="padding:15px;font-family:Open Sans,sans-serif">
                        <tbody><tr>
                            <td>
                    <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#fff">
            <tbody><tr>
            <td>
                <div style="padding-top:20px;padding-left:5px;padding-right:5px;padding-bottom:5px;font-size:12pt;font-weight:bold">
                    Dear '.$doctor_name.',
                </div>
            </td>
                    
                </tr>
            </tbody></table>
            <div style="padding:5px">
            An appointment has been Cancelled by you. This mail is <a style="color:#02a6d8;text-decoration:none" href="'.base_url.'" target="_blank" > Generated by Docconsult.</a> Here are the details:
               
            </div>
            <div style="padding:5px">
                <table style="margin-top:5px;margin-bottom:5px;border:none;width:540px;color:#333;font-size:10pt;line-height:1.5" cellpadding="3" cellspacing="0">
            <tbody>';
            
           
    			$str1.='<tr><td style="width:170px;font-weight:bold;border-bottom:1px solid #ebebeb">Appoinment taken for</td>
                <td style="width:350px;border-bottom:1px solid #ebebeb">'.$patient_name.'</td></tr>';
    	
            $str1.='
                
            
            <tr>
                <td style="width:170px;font-weight:bold;border-bottom:1px solid #ebebeb">Phone No book by</td>
                <td style="width:350px;border-bottom:1px solid #ebebeb">'.$phone.'</td>
            </tr>
            <tr>
                <td style="width:170px;font-weight:bold;border-bottom:1px solid #ebebeb">Email</td>
                <td style="width:350px;border-bottom:1px solid #ebebeb">'.$data['patient_email'].'</td>
            </tr>
            
            <tr>
                <td style="width:170px;font-weight:bold;border-bottom:1px solid #ebebeb">Appointment Date</td>
                <td style="width:350px;border-bottom:1px solid #ebebeb"><span><span>'.$date.'</span></span></td>
            </tr>
            <tr>
                <td style="width:170px;font-weight:bold;border-bottom:1px solid #ebebeb">Appointment Time</td>
                <td style="width:350px;border-bottom:1px solid #ebebeb"><span><span class="aQJ">'.$time.'</span></span></td>
            </tr>
            <tr>
                <td style="width:170px;font-weight:bold;border-bottom:1px solid #ebebeb">Appoinment fix with</td>
                <td style="width:350px;border-bottom:1px solid #ebebeb">'.$doctor_name.'</td>
            </tr>
            <tr>
                <td style="width:170px;font-weight:bold;border-bottom:1px solid #ebebeb">Clinic Name</td>
                <td style="width:350px;border-bottom:1px solid #ebebeb">'.$clinic_name.'</td>
            </tr>
            <tr>
                <td style="width:170px;font-weight:bold;border-bottom:1px solid #ebebeb">Remark</td>
                <td style="width:350px;border-bottom:1px solid #ebebeb">'.$data['remark'].'</td>
            </tr>
                </tbody></table>
            </div>
            
            
            
            <div style="margin-top:10px;padding:5px">
                <br>
                Email us if you have any questions or feedback</div>
            <table style="border:none;width:540px;color:#7f7f7f;font-size:14px;line-height:1.5;margin-bottom:20px" cellpadding="0" cellspacing="0">
                <tbody><tr>
                            <td style="width:40px">
                      
                    </td>
                    <td style="vertical-align:center;font-weight:bold"><a href="mailto:info@docconsult.in" target="_blank">info@docconsult.in</a></td>
                </tr>
            </tbody></table>
                                </td>
                            </tr>
                        </tbody></table>
                       </td>
                </tr>
            
               
            </tbody></table>';
            $mail = new PHPMailer();
            $subject = 'An Appointment  Has Been Cancelled';
            $from = "service@docconsult.in";
            $mail->IsSMTP();
            $mail->Host = $mailhost;
            $mail->SMTPAuth = true;
            $mail->Username = $smtpUser;
            $mail->Password = $smtpPassword;
            $mail->Port = 25; // 25 or 465 or 587
            
            $name = "DocConsult";
            $mail->From = $from;
            $mail->FromName = $name;
            $mail->AddReplyTo($from);
            $mail->AddAddress($doctor['email']);
            $mail->IsHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $str1;
            $mail->Send();
        }
        ////Email for admin
        $subject = 'An Appointment  Has Been Cancelled';
        
        $str2='<table width="100%" cellpadding="0" cellspacing="0" align="center" border="0" style="max-width:600px;background:#fff;border:solid 1px #fafafb">
                <tbody><tr>
                    <td style="height:10px">&nbsp;  </td>
                </tr>
            
                <tr>
                    <td>
                        <table width="100%" cellpadding="0" cellspacing="0" border="0" align="center" style="max-width:600px;border-bottom:solid 1px #f0f0f0;padding-bottom:13px">
                            <tbody><tr>
                                <td width="300"><a href="'.base_url.'" style="margin-left:10px;display:block" target="_blank"><img src="https://docconsult.in/image/logo.png" width="200px" height="70px"></a></td>
                               
                            </tr>
                        </tbody></table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#fff" style="padding:15px;font-family:Open Sans,sans-serif">
                            <tbody><tr>
                                <td>
                        <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#fff">
                <tbody><tr>
                    <td>
                        <div style="padding-top:20px;padding-left:5px;padding-right:5px;padding-bottom:5px;font-size:12pt;font-weight:bold">
                            Dear Admin,
                        </div>
                    </td>
                            
                        </tr>
            </tbody></table>
            <div style="padding:5px">
            An appointment has been Cancelled by '.$doctor['be_name'].$doctor['name'].'. This mail is <a style="color:#02a6d8;text-decoration:none" href="'.base_url.'" target="_blank" > Generated by Docconsult.</a> Here are the details:
               
            </div>
            <div style="padding:5px">
                <table style="margin-top:5px;margin-bottom:5px;border:none;width:540px;color:#333;font-size:10pt;line-height:1.5" cellpadding="3" cellspacing="0">
                    <tbody>';
                    
                   
            			$str2.='<tr><td style="width:170px;font-weight:bold;border-bottom:1px solid #ebebeb">Appoinment taken for</td>
                        <td style="width:350px;border-bottom:1px solid #ebebeb">'.$patient_name.'</td></tr>';
            	
                    $str2.='
                        
                    <tr>
                        <td colspan="2" style="font-weight:bold;border-bottom:1px solid #ebebeb">Doctor Detail</td>
                    </tr>
                    <tr>
                        <td style="width:170px;font-weight:bold;border-bottom:1px solid #ebebeb">Doctor Name</td>
                        <td style="width:350px;border-bottom:1px solid #ebebeb">'.$doctor_name.'</td>
                    </tr>
                    <tr>
                        <td style="width:170px;font-weight:bold;border-bottom:1px solid #ebebeb">Doctor Email</td>
                        <td style="width:350px;border-bottom:1px solid #ebebeb">'.$doctor['email'].'</td>
                    </tr>
                    <tr>
                        <td style="width:170px;font-weight:bold;border-bottom:1px solid #ebebeb">Doctor Mobile No.</td>
                        <td style="width:350px;border-bottom:1px solid #ebebeb">'.$doctor['phone_no'].'</td>
                    </tr>
                    <tr>
                        <td style="width:170px;font-weight:bold;border-bottom:1px solid #ebebeb">Clinic Name</td>
                        <td style="width:350px;border-bottom:1px solid #ebebeb">'.$clinic['name'].'</td>
                    </tr>
                    
                    <tr>
                        <td style="width:170px;font-weight:bold;border-bottom:1px solid #ebebeb">Clinic Address</td>
                        <td style="width:350px;border-bottom:1px solid #ebebeb">'.$clinic['address'].', '.$clinic['area'].', '.$clinic['city'].'</td>
                    </tr>
                    
                    <tr height="30px">
                        <td colspan="2"></td>
                    </tr>
                    <tr>
                        <td colspan="2" style="font-weight:bold;border-bottom:1px solid #ebebeb">Patient Detail</td>
                    </tr>
                    <tr>
                        <td style="width:170px;font-weight:bold;border-bottom:1px solid #ebebeb">Pateint Name</td>
                        <td style="width:350px;border-bottom:1px solid #ebebeb">'.$data['patient_name'].'</td>
                    </tr>
                    <tr>
                        <td style="width:170px;font-weight:bold;border-bottom:1px solid #ebebeb">Patient Mobile no.</td>
                        <td style="width:350px;border-bottom:1px solid #ebebeb">'.$phone.'</td>
                    </tr>
                    <tr>
                        <td style="width:170px;font-weight:bold;border-bottom:1px solid #ebebeb">Pateint Email</td>
                        <td style="width:350px;border-bottom:1px solid #ebebeb">'.$data['patient_email'].'</td>
                    </tr>
                    
                    <tr>
                        <td style="width:170px;font-weight:bold;border-bottom:1px solid #ebebeb">Appointment Date</td>
                        <td style="width:350px;border-bottom:1px solid #ebebeb"><span><span>'.$date.'</span></span></td>
                    </tr>
                    <tr>
                        <td style="width:170px;font-weight:bold;border-bottom:1px solid #ebebeb">Appointment Time</td>
                        <td style="width:350px;border-bottom:1px solid #ebebeb"><span><span class="aQJ">'.$time.'</span></span></td>
                    </tr>
                    <tr>
                        <td style="width:170px;font-weight:bold;border-bottom:1px solid #ebebeb">Remark by Doctor</td>
                        <td style="width:350px;border-bottom:1px solid #ebebeb">'.$data['remark'].'</td>
                    </tr>
                </tbody></table>
            </div>
            
            
            
            <div style="margin-top:10px;padding:5px">
            <table style="border:none;width:540px;color:#7f7f7f;font-size:14px;line-height:1.5;margin-bottom:20px" cellpadding="0" cellspacing="0">
                <tbody><tr>
                            <td style="width:40px">
                      
                    </td>
                    <td style="vertical-align:center;font-weight:bold"><a href="mailto:info@docconsult.in" target="_blank">info@docconsult.in</a></td>
                </tr>
            </tbody></table>
                                </td>
                            </tr>
                        </tbody></table>
                       </td>
                </tr>
            
               
            </tbody></table>';
           
            $mail = new PHPMailer();
            $subject = 'An Appointment  Has Been Cancelled';
            $from = "service@docconsult.in";
            $mail->IsSMTP();
            $mail->Host = $mailhost;
            $mail->SMTPAuth = true;
            $mail->Username = $smtpUser;
            $mail->Password = $smtpPassword;
            $mail->Port = 25; // 25 or 465 or 587
           
            $name = "DocConsult";
            $mail->From = $from;
            $mail->FromName = $name;
            $mail->AddReplyTo($from);
            $mail->AddAddress("info@docconsult.in");
            $mail->IsHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $str2;
            $mail->Send();

        return TRUE;
	}
}

public function app_reschedule($can,$remark,$patient_sms =1,$patient_email=1,$doctor_sms,$doctor_email=1,$schedule_date,$schedule_time)
{
	$res=$this->db->query("update appointments set status='Pending',remark='$remark' where id='$can' ");
	
	if(@$res)
	{
        $send_sms=0;
        $res1=$this->db->query("select * from appointments where id='$can'");
        $data=$res1->fetch_assoc();
        $doctor=$this->getById($data['doctor_id'],"doctors");
        $clinic=$this->getByDoctorId($data['doctor_id'],"clinic");
        $doctor_name=$doctor['be_name'].$doctor['name'];
        $id=$can;
        $email=$data['patient_email'];
        $date=$data['app_date'];
        $time=$data['app_time'];
        $clinic_name=$clinic['name'];
        $phone=$data['phone_no'];
        $phone_no=$doctor['phone_no'];
        $patient_name=$data['patient_name'];
        
        if($patient_sms == 1)
        {
            $forpatientsms = ' '.$data['app_date'].' at '.$data['app_time'].' has been Reschedule with '.$doctor['be_name'].$doctor['name'].' at '.$clinic['name'] .' on '.$schedule_date.' at '.$schedule_time;
            $sms='Hi '.$data['patient_name'].' Your Appointment has been '.$forpatientsms.' you can login here '.base_url.'login';
            $sms = str_replace("<", "", $sms);
            $sms = str_replace(">", "", $sms);
            $sms = rawurlencode($sms);
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
            $data_ch = curl_exec($ch);
            curl_close($ch);
        }    
        if($doctor_sms == 1)
        {
            $doc_sms = ' Reschedule with '.$data['patient_name'].' at '.$clinic_name.' on '.$schedule_date.' at '.$schedule_time;
            $sms = "Hi ".$doctor['be_name'].$doctor['name']." An Appointment has been ".$doc_sms." you can login here ".base_url."doctor-login"." ";
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
            $data_ch = curl_exec($ch);
            curl_close($ch);
        }
			
        require_once("../phpmailer/PHPMailerAutoload.php");
        $mailhost = "docconsult.in";
        $smtpUser = "mail@docconsult.in";
        $smtpPassword = "telekast@123";

		if($patient_email == 1)
        {	
            $str='<table width="100%" cellpadding="0" cellspacing="0" align="center" border="0" style="max-width:600px;background:#fff;border:solid 1px #fafafb">
            <tbody><tr>
                <td style="height:10px">&nbsp;  </td>
            </tr>
        
            <tr>
                <td>
                    <table width="100%" cellpadding="0" cellspacing="0" border="0" align="center" style="max-width:600px;border-bottom:solid 1px #f0f0f0;padding-bottom:13px">
                        <tbody><tr>
                            <td width="300"><a href="'.base_url.'" style="margin-left:10px;display:block" target="_blank"><img src="https://docconsult.in/image/logo.png" width="200px" height="70px"></a></td>
                           
                        </tr>
                    </tbody></table>
                </td>
            </tr>
            <tr>
                <td>
                    <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#fff" style="padding:15px;font-family:Open Sans,sans-serif">
                        <tbody><tr>
                            <td>
                    <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#fff">
            <tbody><tr>
                <td>
                    <div style="padding-top:20px;padding-left:5px;padding-right:5px;padding-bottom:5px;font-size:12pt;font-weight:bold">
                        Dear '.$patient_name.',
                    </div>
                </td>
                        
                    </tr>
            </tbody></table>
            <div style="padding:5px">
                <b>your Appointment Reschedule. by Doctor </b>
             <br>
                This mail is<a style="color:#02a6d8;text-decoration:none" href="'.base_url.'" target="_blank" > Generated by Docconsult.</a> Here are the details: 
            </div>
            <div style="padding:5px">
            <table style="margin-top:5px;margin-bottom:5px;border:none;width:540px;color:#333;font-size:10pt;line-height:1.5" cellpadding="3" cellspacing="0">
                <tbody>';
            
    		$str.='  <tr>
                <td style="width:170px;font-weight:bold;border-bottom:1px solid #ebebeb">Appointment with</td>
                <td style="width:350px;border-bottom:1px solid #ebebeb">'.$doctor['be_name'].' '.$doctor['name'].'</td>
            </tr>';	
    	
            $str.='
                
            <tr>
                <td style="width:170px;font-weight:bold;border-bottom:1px solid #ebebeb">Date</td>
                <td style="width:350px;border-bottom:1px solid #ebebeb"><span><span>'.$date.'</span></span></td>
            </tr>
            <tr>
                <td style="width:170px;font-weight:bold;border-bottom:1px solid #ebebeb">Time</td>
                <td style="width:350px;border-bottom:1px solid #ebebeb"><span><span class="aQJ">'.$time.'</span></span></td>
            </tr>
            
            <tr>
                <td style="width:170px;font-weight:bold;border-bottom:1px solid #ebebeb">Appointment Reschedule Date</td>
                <td style="width:350px;border-bottom:1px solid #ebebeb"><span><span>'.$schedule_date.'</span></span></td>
            </tr>
            <tr>
                <td style="width:170px;font-weight:bold;border-bottom:1px solid #ebebeb">Appointment Reschedule Time</td>
                <td style="width:350px;border-bottom:1px solid #ebebeb"><span><span class="aQJ">'.$schedule_time.'</span></span></td>
            </tr>
            
            <tr>
                <td style="width:170px;font-weight:bold;border-bottom:1px solid #ebebeb"> Appointment For</td>
                <td style="width:350px;border-bottom:1px solid #ebebeb">'.$patient_name.'</td>
            </tr>
            <tr>
                <td style="width:170px;font-weight:bold;border-bottom:1px solid #ebebeb"> Remark</td>
                <td style="width:350px;border-bottom:1px solid #ebebeb">'.$data['remark'].'</td>
            </tr>
            </tbody></table>
            </div>
            <div style="margin-top:10px;padding:5px;font-weight:bold;font-size:12pt">
                How to get there</div>
            <div>
            <table style="margin-bottom:5px;border:none;width:540px;color:#333;font-size:10pt;line-height:1.5" cellpadding="3" cellspacing="0">
            <tbody>
            <tr>
                <td style="width:120px"> Clinic Name</td>
                <td style="width:400px">'.$clinic['name'].'</td>
            </tr>
            <tr>
                <td style="width:120px"> Address</td>
                <td style="width:400px">'.$clinic['address'].', '.$clinic['area'].', '.$clinic['city'].'</td>
            </tr>
            
                    <tr>
                <td style="width:120px;vertical-align:top">Location</td>
                <td style="width:400px">
                    <a href="http://www.google.com/maps/place/'.$clinic['latitude'].','.$clinic['longitude'].'" style="margin-top:5px;color:#005c87;text-decoration:none" target="_blank" >View in Google Maps</a>
                </td>
            </tr>
                </tbody></table>
            </div>
    
            <div style="margin-top:10px;padding:5px">
                <br>
               If you find this is useful for you please give star rating and feedback. 
            Email us if you have any questions or feedback 
            <br>
            Please Visit on <a href="'.base_url.'"></a></div>
            <table style="border:none;width:540px;color:#7f7f7f;font-size:14px;line-height:1.5;margin-bottom:20px" cellpadding="0" cellspacing="0">
                <tbody><tr>
                            <td style="width:40px">
                      
                    </td>
                    <td style="vertical-align:center;font-weight:bold"><a href="mailto:info@docconsult.in" target="_blank">info@docconsult.in</a></td>
                </tr>
            </tbody></table>
                                </td>
                            </tr>
                        </tbody></table>
                       </td>
                </tr>
            </tbody></table>';
         
            $mail = new PHPMailer();
            $from = "service@docconsult.in";
            $mail->IsSMTP();
            $mail->Host = $mailhost;
            $mail->SMTPAuth = true;
            $mail->Username = $smtpUser;
            $mail->Password = $smtpPassword;
            $mail->Port = 25; // 25 or 465 or 587
            
            $name = "DocConsult";
            $subject = 'Your Appointment with '.@$doctor['be_name'].' '.$doctor['name'].' Has Been Reschedule ';
            $from = "service@docconsult.in";
            $mail->From = $from;
            $mail->FromName = $name;
            $mail->AddReplyTo($from);
            $mail->AddAddress($email);
            $mail->IsHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $str;
            $mail->Send();
        }
        if($doctor_email == 1)
        {
    	    $str1='<table width="100%" cellpadding="0" cellspacing="0" align="center" border="0" style="max-width:600px;background:#fff;border:solid 1px #fafafb">
            <tbody><tr>
                <td style="height:10px">&nbsp;  </td>
            </tr>
        
            <tr>
                <td>
                    <table width="100%" cellpadding="0" cellspacing="0" border="0" align="center" style="max-width:600px;border-bottom:solid 1px #f0f0f0;padding-bottom:13px">
                        <tbody><tr>
                            <td width="300"><a href="'.base_url.'" style="margin-left:10px;display:block" target="_blank"><img src="https://docconsult.in/image/logo.png" width="200px" height="70px"></a></td>
                           
                        </tr>
                    </tbody></table>
                </td>
            </tr>
            <tr>
                <td>
                    <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#fff" style="padding:15px;font-family:Open Sans,sans-serif">
                        <tbody><tr>
                            <td>
                    <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#fff">
            <tbody><tr>
            <td>
                <div style="padding-top:20px;padding-left:5px;padding-right:5px;padding-bottom:5px;font-size:12pt;font-weight:bold">
                    Dear '.$doctor_name.',
                </div>
            </td>
                    
                </tr>
            </tbody></table>
            <div style="padding:5px">
            An appointment has been Reschedule by you. This mail is <a style="color:#02a6d8;text-decoration:none" href="'.base_url.'" target="_blank" > Generated by Docconsult.</a> Here are the details:
               
            </div>
            <div style="padding:5px">
                <table style="margin-top:5px;margin-bottom:5px;border:none;width:540px;color:#333;font-size:10pt;line-height:1.5" cellpadding="3" cellspacing="0">
            <tbody>';
            
           
    			$str1.='<tr><td style="width:170px;font-weight:bold;border-bottom:1px solid #ebebeb">Appoinment taken for</td>
                <td style="width:350px;border-bottom:1px solid #ebebeb">'.$patient_name.'</td></tr>';
    	
            $str1.='
                
            
            <tr>
                <td style="width:170px;font-weight:bold;border-bottom:1px solid #ebebeb">Phone No book by</td>
                <td style="width:350px;border-bottom:1px solid #ebebeb">'.$phone.'</td>
            </tr>
            <tr>
                <td style="width:170px;font-weight:bold;border-bottom:1px solid #ebebeb">Email</td>
                <td style="width:350px;border-bottom:1px solid #ebebeb">'.$data['patient_email'].'</td>
            </tr>
            
            <tr>
                <td style="width:170px;font-weight:bold;border-bottom:1px solid #ebebeb">Appointment Date</td>
                <td style="width:350px;border-bottom:1px solid #ebebeb"><span><span>'.$date.'</span></span></td>
            </tr>
            <tr>
                <td style="width:170px;font-weight:bold;border-bottom:1px solid #ebebeb">Appointment Time</td>
                <td style="width:350px;border-bottom:1px solid #ebebeb"><span><span class="aQJ">'.$time.'</span></span></td>
            </tr>
            
            <tr>
                <td style="width:170px;font-weight:bold;border-bottom:1px solid #ebebeb">Appointment Reschedule Date</td>
                <td style="width:350px;border-bottom:1px solid #ebebeb"><span><span>'.$schedule_date.'</span></span></td>
            </tr>
            <tr>
                <td style="width:170px;font-weight:bold;border-bottom:1px solid #ebebeb">Appointment Reschedule Time</td>
                <td style="width:350px;border-bottom:1px solid #ebebeb"><span><span class="aQJ">'.$schedule_time.'</span></span></td>
            </tr>
            
            <tr>
                <td style="width:170px;font-weight:bold;border-bottom:1px solid #ebebeb">Appoinment fix with</td>
                <td style="width:350px;border-bottom:1px solid #ebebeb">'.$doctor_name.'</td>
            </tr>
            
            <tr>
                <td style="width:170px;font-weight:bold;border-bottom:1px solid #ebebeb">Clinic Name</td>
                <td style="width:350px;border-bottom:1px solid #ebebeb">'.$clinic_name.'</td>
            </tr>
            <tr>
                <td style="width:170px;font-weight:bold;border-bottom:1px solid #ebebeb">Remark</td>
                <td style="width:350px;border-bottom:1px solid #ebebeb">'.$data['remark'].'</td>
            </tr>
                </tbody></table>
            </div>
            
            
            
            <div style="margin-top:10px;padding:5px">
                <br>
                Email us if you have any questions or feedback</div>
            <table style="border:none;width:540px;color:#7f7f7f;font-size:14px;line-height:1.5;margin-bottom:20px" cellpadding="0" cellspacing="0">
                <tbody><tr>
                            <td style="width:40px">
                      
                    </td>
                    <td style="vertical-align:center;font-weight:bold"><a href="mailto:info@docconsult.in" target="_blank">info@docconsult.in</a></td>
                </tr>
            </tbody></table>
                                </td>
                            </tr>
                        </tbody></table>
                       </td>
                </tr>
            
               
            </tbody></table>';
            $mail = new PHPMailer();
            $subject = 'An Appointment Has Been Reschedule';
            $from = "service@docconsult.in";
            $mail->IsSMTP();
            $mail->Host = $mailhost;
            $mail->SMTPAuth = true;
            $mail->Username = $smtpUser;
            $mail->Password = $smtpPassword;
            $mail->Port = 25; // 25 or 465 or 587
            
            $name = "DocConsult";
            $mail->From = $from;
            $mail->FromName = $name;
            $mail->AddReplyTo($from);
            $mail->AddAddress($doctor['email']);
            $mail->IsHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $str1;
            $mail->Send();
        }
        ////Email for admin
        $subject = 'An Appointment  Has Been Reschedule';
        
        $str2='<table width="100%" cellpadding="0" cellspacing="0" align="center" border="0" style="max-width:600px;background:#fff;border:solid 1px #fafafb">
                <tbody><tr>
                    <td style="height:10px">&nbsp;  </td>
                </tr>
            
                <tr>
                    <td>
                        <table width="100%" cellpadding="0" cellspacing="0" border="0" align="center" style="max-width:600px;border-bottom:solid 1px #f0f0f0;padding-bottom:13px">
                            <tbody><tr>
                                <td width="300"><a href="'.base_url.'" style="margin-left:10px;display:block" target="_blank"><img src="https://docconsult.in/image/logo.png" width="200px" height="70px"></a></td>
                               
                            </tr>
                        </tbody></table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#fff" style="padding:15px;font-family:Open Sans,sans-serif">
                            <tbody><tr>
                                <td>
                        <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#fff">
                <tbody><tr>
                    <td>
                        <div style="padding-top:20px;padding-left:5px;padding-right:5px;padding-bottom:5px;font-size:12pt;font-weight:bold">
                            Dear Admin,
                        </div>
                    </td>
                            
                        </tr>
            </tbody></table>
            <div style="padding:5px">
            An appointment has been Reschedule by '.$doctor['be_name'].$doctor['name'].'. This mail is <a style="color:#02a6d8;text-decoration:none" href="'.base_url.'" target="_blank" > Generated by Docconsult.</a> Here are the details:
               
            </div>
            <div style="padding:5px">
                <table style="margin-top:5px;margin-bottom:5px;border:none;width:540px;color:#333;font-size:10pt;line-height:1.5" cellpadding="3" cellspacing="0">
                    <tbody>';
                    
                   
            			$str2.='<tr><td style="width:170px;font-weight:bold;border-bottom:1px solid #ebebeb">Appoinment taken for</td>
                        <td style="width:350px;border-bottom:1px solid #ebebeb">'.$patient_name.'</td></tr>';
            	
                    $str2.='
                        
                    <tr>
                        <td colspan="2" style="font-weight:bold;border-bottom:1px solid #ebebeb">Doctor Detail</td>
                    </tr>
                    <tr>
                        <td style="width:170px;font-weight:bold;border-bottom:1px solid #ebebeb">Doctor Name</td>
                        <td style="width:350px;border-bottom:1px solid #ebebeb">'.$doctor_name.'</td>
                    </tr>
                    <tr>
                        <td style="width:170px;font-weight:bold;border-bottom:1px solid #ebebeb">Doctor Email</td>
                        <td style="width:350px;border-bottom:1px solid #ebebeb">'.$doctor['email'].'</td>
                    </tr>
                    <tr>
                        <td style="width:170px;font-weight:bold;border-bottom:1px solid #ebebeb">Doctor Mobile No.</td>
                        <td style="width:350px;border-bottom:1px solid #ebebeb">'.$doctor['phone_no'].'</td>
                    </tr>
                    <tr>
                        <td style="width:170px;font-weight:bold;border-bottom:1px solid #ebebeb">Clinic Name</td>
                        <td style="width:350px;border-bottom:1px solid #ebebeb">'.$clinic['name'].'</td>
                    </tr>
                    
                    <tr>
                        <td style="width:170px;font-weight:bold;border-bottom:1px solid #ebebeb">Clinic Address</td>
                        <td style="width:350px;border-bottom:1px solid #ebebeb">'.$clinic['address'].', '.$clinic['area'].', '.$clinic['city'].'</td>
                    </tr>
                    
                    <tr height="30px">
                        <td colspan="2"></td>
                    </tr>
                    <tr>
                        <td colspan="2" style="font-weight:bold;border-bottom:1px solid #ebebeb">Patient Detail</td>
                    </tr>
                    <tr>
                        <td style="width:170px;font-weight:bold;border-bottom:1px solid #ebebeb">Pateint Name</td>
                        <td style="width:350px;border-bottom:1px solid #ebebeb">'.$data['patient_name'].'</td>
                    </tr>
                    <tr>
                        <td style="width:170px;font-weight:bold;border-bottom:1px solid #ebebeb">Patient Mobile no.</td>
                        <td style="width:350px;border-bottom:1px solid #ebebeb">'.$phone.'</td>
                    </tr>
                    <tr>
                        <td style="width:170px;font-weight:bold;border-bottom:1px solid #ebebeb">Pateint Email</td>
                        <td style="width:350px;border-bottom:1px solid #ebebeb">'.$data['patient_email'].'</td>
                    </tr>
                    
                    <tr>
                        <td style="width:170px;font-weight:bold;border-bottom:1px solid #ebebeb">Appointment Date</td>
                        <td style="width:350px;border-bottom:1px solid #ebebeb"><span><span>'.$date.'</span></span></td>
                    </tr>
                    <tr>
                        <td style="width:170px;font-weight:bold;border-bottom:1px solid #ebebeb">Appointment Time</td>
                        <td style="width:350px;border-bottom:1px solid #ebebeb"><span><span class="aQJ">'.$time.'</span></span></td>
                    </tr>
                    
                    <tr>
                        <td style="width:170px;font-weight:bold;border-bottom:1px solid #ebebeb">Appointment Reschedule Date</td>
                        <td style="width:350px;border-bottom:1px solid #ebebeb"><span><span>'.$schedule_date.'</span></span></td>
                    </tr>
                    <tr>
                        <td style="width:170px;font-weight:bold;border-bottom:1px solid #ebebeb">Appointment Reschedule Time</td>
                        <td style="width:350px;border-bottom:1px solid #ebebeb"><span><span class="aQJ">'.$schedule_time.'</span></span></td>
                    </tr>
                    
                    <tr>
                        <td style="width:170px;font-weight:bold;border-bottom:1px solid #ebebeb">Remark by Doctor</td>
                        <td style="width:350px;border-bottom:1px solid #ebebeb">'.$data['remark'].'</td>
                    </tr>
                </tbody></table>
            </div>
            
            
            
            <div style="margin-top:10px;padding:5px">
            <table style="border:none;width:540px;color:#7f7f7f;font-size:14px;line-height:1.5;margin-bottom:20px" cellpadding="0" cellspacing="0">
                <tbody><tr>
                            <td style="width:40px">
                      
                    </td>
                    <td style="vertical-align:center;font-weight:bold"><a href="mailto:info@docconsult.in" target="_blank">info@docconsult.in</a></td>
                </tr>
            </tbody></table>
                                </td>
                            </tr>
                        </tbody></table>
                       </td>
                </tr>
            
               
            </tbody></table>';
           
            $mail = new PHPMailer();
            $subject = 'An Appointment  Has Been Cancelled';
            $from = "service@docconsult.in";
            $mail->IsSMTP();
            $mail->Host = $mailhost;
            $mail->SMTPAuth = true;
            $mail->Username = $smtpUser;
            $mail->Password = $smtpPassword;
            $mail->Port = 25; // 25 or 465 or 587
           
            $name = "DocConsult";
            $mail->From = $from;
            $mail->FromName = $name;
            $mail->AddReplyTo($from);
            $mail->AddAddress("info@docconsult.in");
            $mail->IsHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $str2;
            $mail->Send();
        
        $schedule_date = date('Y-m-d',strtotime($schedule_date));
        $res=$this->db->query("update appointments set app_date='$schedule_date', app_time='$schedule_time' where id='$can' ");
        return TRUE;
	}
}
public function display_cancel_appointment($id)
{
	$doc_id=$_SESSION['login_id'];
	$res=$this->db->query("select * from appointments where doctor_id='$doc_id' and status='Cancel'");
	$str='';
	
	$str='   <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        
                                        <th>Patient Name</th>
                                        <th>Patient Email</th>
                                         <th>Appointment Date</th>
                                        <th>Appointment Time</th>
                                        <th>Remark</th>
                                        
                                        <th>Feedback</th>
                                       
                                    </tr>
                                </thead>
                                 <tbody>';
                                 $count=0;
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
			$count++;
			$str.=' <tr>
                                       
                                        <td>'.$data['patient_name'].'</td>
                                        <td>'.$data['patient_email'].'</td>
                                        <td>'.$data['app_date'].'</td>
                                        <td>'.$data['app_time'].'</td>
                                        <td>'.$data['remark'].'</td>
                                        <td>'.$data['feadback'].'</td>
                                       
                                       
                                    </tr>
                                   ';
		
		}	
	}
	$str.=' </tbody></table>';
	 return $str;
}
public function edit_patient_priscription($id)
{
	$res=$this->db->query("select * from prescription_patient where id='$id' ");
	$count=0;
	$str='<div  id="printthis">';
	$str=' <table class="table table-bordered table-striped table-hover js-basic-example dataTable" >
                                <thead>
                                    <tr>
                                         <th>Doctor Name</th>
                                        <th>Durg Name</th>
                                        <th>Duration</th>
                                         <th>Instructions</th>
                                         <th>Morning</th>
                                         <th>Noon</th>
                                         <th>Night</th>
                                         <th>Food</th>
                                         
                                        
                                        
                                    </tr>
                                </thead>
                                 <tbody>';
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
			$data1=$this->getById($data['doctor_id'],"doctors");
			$str.=' <tr><td>'.$data1['name'].'</td> <td>';
                                        $drug_name=json_decode($data['drug_name']);
                                        
                                        
                                        foreach($drug_name as $key=>$drug)
                                        {
                                        	$count++;
											$str.='<input type="text"  name="drug_name['.$key.']" value="'.$drug.'"><br><br>';
										}
                                        $str.='</td><td>';
                                         $durations=json_decode($data['duration']);
                                        
                                        foreach($durations as $key=>$duration)
                                        {
											$str.='<input type="text"  name="strength['.$key.']" value="'.$duration.'"><br><br>';
										}
                                        $str.='</td><td>';
                                         $instruction=json_decode($data['instruction']);
                                        
                                        foreach($instruction as $key=>$instruct)
                                        {
											$str.='<input type="text"  name="unit['.$key.']" 
											value="'.$instruct.'"><br><br>';
										} 
										$str.='</td><td>';
                                         $morning=json_decode($data['morning']);
                                        
                                        foreach($morning as $key=>$morni)
                                        {
											$str.='<input type="text"  name="mor['.$key.']" 
											value="'.$morni.'"><br><br>';
										}$str.='</td><td>';
                                         $noon=json_decode($data['noon']);
                                        
                                        foreach($noon as $key=>$noo)
                                        {
											$str.='<input type="text"  name="noon['.$key.']" 
											value="'.$noo.'"><br><br>';
										}$str.='</td><td>';
                                         $night=json_decode($data['night']);
                                        
                                        foreach($night as $key=>$nigh)
                                        {
											$str.='<input type="text"  name="night['.$key.']" 
											value="'.$nigh.'"><br><br>';
										}$str.='</td><td>';
                                         $food=json_decode($data['food']);
                                        
                                        foreach($food as $key=>$foo)
                                        {
											$str.='<input type="text"  name="foo['.$key.']" 
											value="'.$foo.'"><br><br>';
										}
                                       $str.='</td><td>'.$data['date'].' </td>
                                                     </tr>';
		
		}	
	}
	$str.=' </tbody></table></div>';
	
	 return $str;
	
}

public function get_occupation($id, $type)
{
	$category_id = (int)($_SESSION['doc_details']['category']);
	if($type == 0){
	    $sql = "select * from clinic_category where id='$id'";
	}else{
	    $sql = "select * from category where id='$id'";
	}
	
	$res = $this->db->query($sql);
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{ echo $data['category'];
		}
	}
}

// public function update_doctor_about($name,$gender,$about,$exp,$befor,$quali,$clinic)
// {
		
// 	$doc_id=$_SESSION['login_id'];
// 	$about=$about;
// 	$res1=$this->db->query("update doctors set gender='$gender',about='$about',experience='$exp',status='Active',new_name='$name',remark='$remark',id_proof='$proof',be_name='$befor',qualification='$quali',clinic_name='$clinic' where id='$doc_id'");
		
	
// 	if($res1)
// 	{
// 		return true;
// 	}
// }
            
public function update_doctor_about($about,$exp,$gender,$dob,$age,$sec_phone,$sec_email,$clinic_id)
{
	$doc_id=$_SESSION['login_id'];
    $about = $this->db->real_escape_string($about);
    
    if($clinic_id == '-1')
    {
	    $res1=$this->db->query("update doctors set secondry_phone = '$sec_phone', new_email = '$sec_email', gender = '$gender', dob = '$dob', age = '$age', about='$about', experience='$exp' where id='$doc_id'");
    } 
    else 
    {
        $res1=$this->db->query("update clinic set about='$about',experience='$exp',home_visit='$home_visit' where id='$clinic_id'");
    }
	
	if($res1)
	{
		return true;
	}
}
public function update_clinic_detail($about, $clinic_name, $year_of_estb, $clic_mob, $clic_email, $clinic_id)
{
    $about = $this->db->real_escape_string($about);
    $clinic_name = $this->db->real_escape_string($clinic_name);

 	$sql = "update clinic set about = '$about', name = '$clinic_name', email = '$clic_email', esthablishment_year = '$year_of_estb', secondry_phone = '$clic_mob'  where id = '$clinic_id'";
   
    $res1=$this->db->query($sql);
    if($res1)
    {
    	return true;
    }
}
public function prescription_list($id)
{
	unset($_SESSION['tab_count']);
	$res=$this->db->query("select * from prescription_patient where id='$id'");
	$str='';
	$_SESSION['tab_count']=0;
	if($res->num_rows > 0 )
	{
		$count=0;
		while($data=$res->fetch_assoc())
		{
			$drug_name=json_decode($data['drug_name'],true);
			$strength=json_decode($data['strength'],true);
			$unit=json_decode($data['unit'],true);
			$duration=json_decode($data['duration'],true);	
			$days=json_decode($data['days'],true);
			$morning=json_decode($data['morning'],true);
			$noon=json_decode($data['noon'],true);
			$night=json_decode($data['night'],true);
			$food=json_decode($data['food'],true);
			
			$insetruction=json_decode($data['instruction'],true);
			
			$n=count($drug_name);
			
			for($i=0;$i<$n;$i++)
			{
				if($days[$i]=="day")
				{
					$select_day="selected";
				}
				else{
					$select_day='';
				}
				if($days[$i]=="week")
				{
					$select_week="selected";
				}
				else
				{
					$select_week='';
				}
				if($days[$i]=="year")
				{
					$select_year="selected";
				}
				else{
					$select_year='';
				}
				if($food[$i]=="after")
				{
					$foo_af="checked";
				}
				else{
					$foo_af="";
				}if($food[$i]=="before")
				{
					$foo_be="checked";
				}
				else{
					$foo_be="";
				}
				
				$_SESSION['tab_count']++;
$str.='<div style="width:100%; float:left;margin-bottom:15px" id="pre_'.$count.'">';

$str.='
							<div style="float:left;width:20%;">
							'.$drug_name[$i].'	
							<input type="hidden" value="'.$drug_name[$i].'" name="drug_name['.$count.']">
							</div>
							<div style="float:left;width:9%;">
								'.$strength[$i].' 
							<input type="hidden" value="'.$strength[$i].'" name="strength['.$count.']">
							</div>
							<div style="float:left;width:5%;">
								'.$unit[$i].'
							<input type="hidden" value="'.$unit[$i].'" name="unit['.$count.']">
							</div>
							<div style="float:left;width:8%;">
								<input type="number" name="duration['.$count.']" min="1" style="width:40px;" value="'.$duration[$i].'" >
							
							</div>
							<div style="float:left;width:12%;">
								
							<select name="days['.$count.']">
							<option value="day" '.$select_day.' >Day </option>
							<option value="week" '.$select_week.'>Week</option>
							<option value="year" '.$select_year.'>Year</option>
							</select>
						
								
							</div>
							<div style="float:left;width:8%;">
								
							<input type="number" name="morning['.$count.']" min="0" step="0.5" style="width:50px;" value="'.$morning[$i].'">
						
								
							</div>
							<div style="float:left;width:8%;">
								
							<input type="number" name="noon['.$count.']" min="0" step="0.5" style="width:50px;" value="'.$noon[$i].'">
						
								
							</div>
							<div style="float:left;width:8%;">
								
							<input type="number" name="night['.$count.']" min="0" step="0.5" style="width:50px;" value="'.$night[$i].'" >
						
								
							</div>
							<div style="float:left;width:12%;">
								 <div class="demo-radio-button">
							 <input type="radio" class="with-gap" id="radio_'.$count.'"  name="food['.$count.']" value="after" '.$foo_af.' />
                                <label for="radio_'.$count.'" style="min-width:40px">After</label>
                                 <input  type="radio" class="with-gap" id="radio'.$count.'" name="food['.$count.']" value="before" '.$foo_be.' />
                                <label for="radio'.$count.'" style="min-width:40px">Before</label>       </div>
						</div>
							
							<div style="float:left;width:10%;">
								
							<a onclick="remove_drug('.$count.')"> X </a>
						
								
							</div>
							<div style="float:left;width:100%;">Instruction :  <input type="text" name="instruction['.$count.']" value="'.$insetruction[$i].'"  > </div>
							';
							 
							

$str.='</div>';
$count++;
}
		}
	}
	return $str;
}
public function edit_treatment_patient($name,$strength,$unit,$duration,$day,$morning,$noon,$night,$food,$id,$instruction)
{
	
	$res=$this->db->query("update prescription_patient set drug_name='$name',strength='$strength',unit='$unit',duration='$duration',days='$day',morning='$morning',noon='$noon',night='$night',food='$food',instruction='$instruction' where id='$id'");
	if(@$res)
	{
		return true;
	}
}

public function education1()
{
	
$doc_id=$_SESSION['login_id'];

		$res=$this->db->query("select * from doctors where id='$doc_id'");
	

	 return $res->fetch_assoc();
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
public function update_service_doctor($service,$clinic_id)
{
	$doc_id=$_SESSION['login_id'];
	if($clinic_id == '-1'){
	$res=$this->db->query("update doctors set services='$service' where id='$doc_id'");
	} else {
	$res=$this->db->query("update clinic set services='$service' where id='$clinic_id'");

	}
	if($res)
	{
		return true;
	}
}public function update_award_doctor($service,$clinic_id)
{
	$doc_id=$_SESSION['login_id'];
	if($clinic_id == '-1'){
	$res=$this->db->query("update doctors set award='$service' where id='$doc_id'");
	} else {
	    $res=$this->db->query("update clinic set award='$service' where id='$clinic_id'");
	}
	if($res)
	{
		return true;
	}
}
public function update_membership_doctor($member,$clinic_id)
{
	$doc_id=$_SESSION['login_id'];
	if($clinic_id == '-1'){
	$res=$this->db->query("update doctors set membership='$member' where id='$doc_id'");
	} else {
	    $res=$this->db->query("update clinic set membership='$member' where id='$clinic_id'");
	}
	if($res)
	{
		return true;
	}
}public function update_sp_doctor($sp,$clinic_id)
{
	$sp = $this->db->real_escape_string($sp);
	
	$doc_id=$_SESSION['login_id'];
	if($clinic_id == '-1'){
	$res=$this->db->query("update doctors set specialization='$sp' where id='$doc_id'");
	} else {
	$res=$this->db->query("update clinic set specialization='$sp' where id='$clinic_id'");

	}
	if($res)
	{
		return true;
	}
}public function update_address_doctor($address,$city,$state,$pincode,$country,$district,$location,$map)
{
	$doc_id=$_SESSION['login_id'];
	
	$res=$this->db->query("update doctors set address='$address',city='$city',state='$state',pincode='$pincode',district='$district',location='$location',country='$country',map='$map' where id='$doc_id'");
	
	if($res)
	{
		return true;
	}
}
public function update_contact_doctor($phone_no,$sec,$telephone,$email, $website,$clinic_id)
{
	$doc_id=$_SESSION['login_id'];
	if($clinic_id=='-1'){
	$res=$this->db->query("update doctors set new_phone_no='$phone_no',secondry_phone='$sec',telephone='$telephone', new_email='$email', website = '$website' where id='$doc_id'");
	} else {
	    	$res=$this->db->query("update clinic set phone_no='$phone_no',secondry_phone='$sec',telephone='$telephone', new_email='$email', website = '$website' where id='$clinic_id'");

	}
	if($res)
	{
		return true;
	}
}
public function update_special_note($special_note)
{
	$doc_id=$_SESSION['login_id'];
	
	$res=$this->db->query("update doctors set special_note='$special_note' where id='$doc_id'");
	
	if($res)
	{
		return true;
	}
}
public function update_special_note_clinic($id, $special_note)
{
	
	$res=$this->db->query("update clinic set special_note='$special_note' where id='$id'");
	
	if($res)
	{
		return true;
	}
}
// public function update_reg_doctor($reg_no,$reg_year,$reg_add_info,$proof,$remark)
// {
// 	$doc_id=$_SESSION['login_id'];
// 	$res=$this->db->query("select * from doctors where id='$doc_id'");
// 	$data=$res->fetch_assoc();
// 	if($reg_no==$data['registration_no'])
// 	{
// 			$res=$this->db->query("update doctors set reg_year='$reg_year',reg_add_info='$reg_add_info',reg_proof='$proof',reg_remark='$remark' where id='$doc_id'");
// 	}
// 	else{
// 			$res=$this->db->query("update doctors set registration_no='$reg_no',reg_year='$reg_year',reg_add_info='$reg_add_info',reg_proof='$proof',new_reg='$reg_no',reg_remark='$remark' where id='$doc_id'");
// 	}

	
// 	if($res)
// 	{
// 		return true;
// 	}
// }

public function update_reg_doctor($reg_info, $clinic_id)
{
	$doc_id=$_SESSION['login_id'];
// 	$res=$this->db->query("select * from doctors where id='$doc_id'");
// 	$data=$res->fetch_assoc();
// 	if($reg_no==$data['registration_no'])
// 	{
// 			$res=$this->db->query("update doctors set reg_year='$reg_year',reg_add_info='$reg_add_info',reg_proof='$proof',reg_remark='$remark' where id='$doc_id'");
// 	}
// 	else{
// 			$res=$this->db->query("update doctors set registration_no='$reg_no',reg_year='$reg_year',reg_add_info='$reg_add_info',reg_proof='$proof',new_reg='$reg_no',reg_remark='$remark' where id='$doc_id'");
// 	}
    
    if($clinic_id=='-1'){
    $res = $this->db->query("update doctors set registration_detail='$reg_info' where id='$doc_id'");
    }
    else
    {
        $res = $this->db->query("update clinic set registration_detail='$reg_info' where id='$clinic_id'");
    }
	
	if($res)
	{
		return true;
	}
}

// public function add_clinic($name, $email)
// { 
// $doc_id=$_SESSION['login_id'];
// $res=$this->db->query("select * from doctors where id='$doc_id'");
// if($res->num_rows>0)
// {
// 	$data=$res->fetch_assoc();
	
// 	$award=$data['award'];
// 	$service=$data['services'];
// 	$pincode=$data['pincode'];
// 	$address=$data['address'];
// 	$state=$data['state'];
// 	$city=$data['city'];
// 	$specializattion=$data['specialization'];
// 	$about=$data['about'];
// 	$membership=$data['membership'];
	
	
// 	$res=$this->db->query("insert into clinic (name,d_type,doctor_id,image,award,services,pincode,address,state,city,specialization,about,membership) values('$name','$d_type','$doc_id','avatar-male.jpg','$award','$service','$pincode','$address','$state','$city','$specializattion','$about','$membership')");
// }

// else
// {
// 	$res=$this->db->query("insert into clinic (name,email,doctor_id,image) values('$name','$email','$doc_id','avatar-male.jpg')");
// }
// 	if(@$res)
// 	{
// 		return true;
// 	}
// }

public function add_clinic($clinic_name, $clinic_city, $clinic_area, $clinic_category)
{
    $doc_id = $_SESSION['login_id'];
    $res=$this->db->query("select * from doctors where id='$doc_id'");
    
    $first_clinic_sql = " select * from clinic where doctor_id = '$doc_id' ";
    $first_clinic_query = $this->db->query($first_clinic_sql);
    $num_of_clinic = $first_clinic_query->num_rows;
    
    if($res->num_rows > 0)
    {
        $data = $res->fetch_assoc();
        $name = $data['name'];
        $award=$data['award'];
    	$service=$data['services'];
    	$pincode = $data['pincode'];
    	$address = $data['address'];
    	$state = $data['state'];
    	$city = $data['city'];
    	$specialization = $data['specialization'];
    	$about = $data['about'];
    	$membership = $data['membership'];
        $date = date('Y-m-d');
        
        $address = $clinic_city.$clinic_area;
        $map_result = $this->get_lat_long($address);
        $lat = $map_result['lat'];
        $long = $map_result['long'];
        
        $clinic_name = $this->db->real_escape_string($clinic_name);
        $about = $this->db->real_escape_string($about);
        
        $sql = "insert into clinic(name, d_type, city, doctor_id, area, state, specialization, about, membership, services, date, image, latitude, longitude, category) 
                          values('$clinic_name', '$owner','$clinic_city','$doc_id','$clinic_area','$state','$specialization', '','$membership','$service', '$date','medical_clinic.png', '$lat', '$long', '$clinic_category')";
       
        $res = $this->db->query($sql);
    
        if($res)
        {
            $sql = "select id from clinic where date = '$date' and name = '$clinic_name' and city = '$clinic_city' order by id desc limit 1";
            $query = $this->db->query($sql);
            $result = $query->fetch_assoc();
            $c_id = $result['id'];
            
            $date = date('Y-m-d');
    	  	$sql1 = "insert into practice(doctor_id, clinic_id, date) values('$doc_id', '$c_id', '$date')";
    	 	$res1=$this->db->query($sql1);
    	 	
    	 	$res2=$this->db->query("select clinic from doctors where id = '$doc_id' ");
    	 	$tem = $res2->fetch_assoc();
    	 	$arr=array();
    	 	if($tem['clinic'] != null)
    	 	{
    	 	    $arr=json_decode($tem['clinic'],true);
    	 	}
    	 	$temp = array();
    	 	$temp["did"] = $doc_id;
    	 	$temp["clinic_id"] = $c_id;
    	 	array_push($arr,$temp);
    	 	$arr=json_encode($arr);
    	 	
    	 	if($num_of_clinic == 0){$qur = " ,location = '$clinic_area' ";}else{$qur = '';}
    	 	
    	 	$res3=$this->db->query("update doctors set clinic='$arr' $qur where id='$doc_id'");
    	 
    	 	$arr = array();
    	 	
    	 	$sql_doc = "select specialization from doctors where id = '$doc_id'";
    	    $res_doc = $this->db->query($sql_doc);
    	    $data_doc = $res_doc->fetch_assoc();
    	    
    	    $doc_specialization = $data_doc['specialization'];
    	    $doc_specialization = json_decode($doc_specialization,true);
    	    $doc_fist_specil['specialization'] = $doc_specialization[0]['specialization'];
            
    	    $all_spe = array();
            array_push($all_spe,$doc_fist_specil);
            $all_spe = json_encode($all_spe);
    	 	
    	 	array_push($arr,$doc_id);
    	 	$arr = json_encode($arr);
    	 	$clic_sql = "update clinic set secondary_doctor='$arr', specialization = '$all_spe' where id='$c_id'";
    	 	$res5 = $this->db->query($clic_sql);
    	 	
    		return $c_id;
        }
    }
    
}
public function add_into_clinic_table_new_doctor($clinic_id,$new_doctor_phone_no)
{
    $doc_id = $_SESSION['login_id'];
    
    $res = $this->db->query("select * from clinic where id='$clinic_id'");
    $res1 = $this->db->query("select * from doctors where phone_no='$new_doctor_phone_no'");
    $data1= $res1->fetch_assoc();
    $new_doctor_id = $data1['id'];
    //echo $new_doctor_phone_no,$new_doctor_id,"hello";
    
    if($res->num_rows > 0 )
    {
        $data = $res->fetch_assoc();
        $doctor_in_clinic = $data['secondary_doctor'];
        
        if(empty($doctor_in_clinic))
        {
            $dic = array();
            $dic[0] = $new_doctor_id;
            
            $dic = json_encode($dic);
            $res2 = $this->db->query("update clinic set secondary_doctor='$dic' where id='$clinic_id'");
        }
        else
        {
            $dic = json_decode($data['secondary_doctor'],TRUE);
            $dic2 = array();
            $count = 0;
            foreach($dic as $doctor_id)
            {
                $dic2[$count] = $doctor_id;
                $count++;
            }
            $dic2[$count] =$new_doctor_id;
            $dic = json_encode($dic2);
            
            $res3 = $this->db->query("update clinic set secondary_doctor='$dic' where id='$clinic_id'");
        }
    }
     return $new_doctor_id;
}
public function show_clinic_doctors_by_clinic_id($id)
{
    $res = $this->db->query("select * from doctors where id='$id'");
    
        $clinic_data = $res->fetch_assoc();
        $clinic = json_decode($clinic_data['clinic'],TRUE);
        
        foreach($clinic as $c)
        {
            echo $c['did'],$c['clinic_id'];
        }
        echo "hi";
}
public function add_new_doctor_to_clinic($clinic_id,$new_doctor_phone_no,$new_doctor_name)
{
    $doc_id = $_SESSION['login_id'];
    //echo $new_doctor_phone_no;
    $new_doctor_id = $this->add_into_clinic_table_new_doctor($clinic_id,$new_doctor_phone_no);
    
    //echo $new_doctor_id;
    $new_doctor_in_clinic = array();
    
    $res = $this->db->query("select * from doctors where id='$new_doctor_id'"); 
    $data = $res->fetch_assoc();
    $previous_doctors = json_decode($data['clinic'],TRUE);
    $count_previous_doctor = count($previous_doctors);
    if($count_previous_doctor!=0)
        {$count_previous_doctor++;}
    
    $previous_doctors[$count_previous_doctor]['did'] = $doc_id;
    $previous_doctors[$count_previous_doctor]['clinic_id'] = $clinic_id;
    
    $doctors = json_encode($previous_doctors);
    $res2 = $this->db->query("update doctors set clinic = '$doctors' where id='$new_doctor_id'");
    
    return TRUE;
    
    
}

public function display_all_clinic($id)
{
    $data=$this->getById($id,"doctors"); 
	$parsent=12;
	if(!empty($data['name']))
	{
		$parsent+=4;
	}
	if(!empty($data['id_proof']))
	{
		$parsent+=4;
	}if(!empty($data['qualification_proof']))
	{
		$parsent+=4;
	}
	if(!empty($data['email']))
	{
		$parsent+=4;
	}
	if(!empty($data['phone_no']))
	{
		$parsent+=4;
		
	}
	if(!empty($data['education']))
	{
		$parsent+=4;
		
	}
	if(!empty($data['registration_no']))
	{
		$parsent+=4;
		
	}
	if(!empty($data['reg_year']))
	{
		$parsent+=4;
	}
	if(!empty($data['reg_add_info']))
	{
		$parsent+=4;
	}
	if(!empty($data['award']))
	{
		$parsent+=4;
	}
	if(!empty($data['award_year']))
	{
		$parsent+=4;
	}
	if(!empty($data['address']))
	{
		$parsent+=4;
	}
	if(!empty($data['city']))
	{
		$parsent+=4;
	}
	if(!empty($data['specialization']))
	{
		$parsent+=4;
	}
	if(!empty($data['about']))
	{
		$parsent+=4;
	}
	if(!empty($data['services']))
	{
		$parsent+=4;
	}
	if(!empty($data['experience']))
	{
		$parsent+=4;
	}
	if(!empty($data['membership']))
	{
		$parsent+=4;
	}
	
	
	if(!empty($data['status']))
	{
		$parsent+=8;
	}
	if(!empty($data['image']))
	{
		$parsent+=8;
	}
	$_SESSION['parsent']=$parsent;
	
	
	
	$data1=$this->get_clinic_detail();
	
	$data=$this->getById($id,"doctors"); 
	$parsent1=12;
	if(!empty($data1['name']))
	{
		$parsent1+=4;
	}
	if(!empty($data1['id_proof']))
	{
		$parsent1+=4;
	}if(!empty($data1['qualification_proof']))
	{
		$parsent1+=4;
	}
	if(!empty($data1['email']))
	{
		$parsent1+=4;
	}
	if(!empty($data1['phone_no']))
	{
		$parsent1+=4;
		
	}
	if(!empty($data1['education']))
	{
		$parsent1+=4;
		
	}
	if(!empty($data1['registration_no']))
	{
		$parsent1+=4;
		
	}
	if(!empty($data1['reg_year']))
	{
		$parsent1+=4;
	}
	if(!empty($data1['reg_add_info']))
	{
		$parsent1+=4;
	}
	if(!empty($data1['award']))
	{
		$parsent1+=4;
	}
	if(!empty($data1['award_year']))
	{
		$parsent1+=4;
	}
	if(!empty($data1['address']))
	{
		$parsent1+=4;
	}
	if(!empty($data1['city']))
	{
		$parsent1+=4;
	}
	if(!empty($data1['specialization']))
	{
		$parsent1+=4;
	}
	if(!empty($data1['about']))
	{
		$parsent1+=4;
	}
	if(!empty($data1['services']))
	{
		$parsent1+=4;
	}
	if(!empty($data1['experience']))
	{
		$parsent1+=4;
	}
	if(!empty($data1['membership']))
	{
		$parsent1+=4;
	}
	
	
	if(!empty($data1['status']))
	{
		$parsent1+=8;
	}
	if(!empty($data1['image']))
	{
		$parsent1+=8;
	}
	$_SESSION['parsent1']=$parsent1;
	
	$res=$this->db->query("select * from clinic where doctor_id='$id'");
	$str='';
	
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
			$own_clinic_id[] = $data['id'];
			$clicn_timing =  $clicn_timing2 = '';
            
            if($data['check1'] != ''){
                $day_name = explode(',',$data['check1']);
                foreach($day_name as $days){
                    $clicn_timing = $data[$days];
                    if($data[$days.'1']){
                        $clicn_timing .= ' <b>| </b>'.$data[$days.'1'];
                    }    
                }
            }
            if($data['check2'] != ''){
                $day_name = explode(',',$data['check2']);
                foreach($day_name as $dayss){
                    $clicn_timing2 = $clinic[$dayss];
                    if($data[$dayss.'1']){
                        $clicn_timing2 .= ' <b>| </b>'.$data[$dayss.'1'];
                    }    
                }
            }
            
            if($data['24*7'] == '24'){
                $tym ='<h6 style="margin-top: 0">Timing : Open 24X7</h6>';  
            }else{
                $tym ='<h6 style="margin-top: 0">Timing : '.$clicn_timing.'<br>'.$clicn_timing2.'</h6>';
            }
			
			$str.='
			<div class="patient-card col-sm-5"> 
			<a href=doctor_profile.php?profile=clinic&clinic_id='.$data['id'].' style="color: #333333" >
			  <div class="row" style="padding:10px;" > <img  class="col-xs-12 col-sm-3" src='.base_url_image.'dp-clinic/'.$data['image'].' style="height: 80px; float: left;background-color: #c4c4c4" width="60px" >
				<div class="edit-button" style="color:#333333;opacity: 1;">
                	<small style="color:#ff8601">Edit</small>
                	<div class="glyphicon glyphicon-pencil"></div>
                </div>
				<div class="col-sm-9 col-xs-12">
				  <h5 style="margin-top: 0"><strong>'.$data['name'].'</strong></h5>
				  <h6>'.$data['address'].'</h6>
				  <h6 style="margin-top: 0">'.$data['secondry_phone'].'</h6>
				  '.$tym.'
				  </div>
			  </div>
			  </a> 
			  </div>';
		}	
	}
	
	$res = $this->db->query("select * from doctors where id='$id'");
	
	$data = $res->fetch_assoc();
	$doc_in_other_clinic = json_decode($data['clinic'],TRUE);
	
	foreach($doc_in_other_clinic as $d)
	{
	    if(in_array($d['clinic_id'], $own_clinic_id)){continue;}
	    
	    $clinic = $this->getById($d['clinic_id'],"clinic");
	    
	    $clicn_timing =  $clicn_timing2 = '';
        if($clinic['check1'] != ''){
            $day_name = explode(',',$clinic['check1']);
            foreach($day_name as $days){
                $clicn_timing = $clinic[$days];
                if($clinic[$days.'1']){
                    $clicn_timing .= ' <b>| </b>'.$clinic[$days.'1'];
                }    
            }
        }
        if($clinic['check2'] != ''){
            $day_name = explode(',',$clinic['check2']);
            foreach($day_name as $dayss){
                $clicn_timing2 = $clinic[$dayss];
                if($clinic[$dayss.'1']){
                    $clicn_timing2 .= ' <b>| </b>'.$clinic[$dayss.'1'];
                }    
            }
        }
	    $str.='
	    
		<div class="patient-card col-sm-5"> 
		
		  <div class="row" style="padding:10px;" > <img  class="col-xs-12 col-sm-3" src='.base_url_image.$clinic['image'].' style="height: 80px; float: left;background-color: #c4c4c4" width="60px" >
			
			
			<div class="col-sm-9 col-xs-12">
			  <h5 style="margin-top: 0"><strong>'.$clinic['name'].'</strong></h5>
			  <h6>'.$clinic['address'].'</h6>
			  <h6 style="margin-top: 0">'.$clinic['secondry_phone'].'</h6>';
			  if($clinic['24*7'] == '24'){
				    $str.='<h6 style="margin-top: 0">Timing : Open 24X7</h6>';  
				  }else{
    			    $str.='<h6 style="margin-top: 0">Timing : '.$clicn_timing.'<br>'.$clicn_timing2.'</h6>';
				  }
			$str.='</div>
		  </div>
		   
		  </div>
';
	}
	 return $str;
	 
}
public function show_sec_doctor_in_clinic_by_clinic_id($clinic_id)
{
    //echo $clinic_id;
    $res = $this->db->query("select * from clinic where id='$clinic_id'");
    $data = $res->fetch_assoc();
    $sec_doctor = json_decode($data['secondary_doctor'],TRUE);
    $str = '';
    foreach($sec_doctor as $doc_id)
    {
        //echo $doc_id;
        $doctor = $this->getById($doc_id,"doctors");
        $doc_name = $doctor['name'];
        $doc_phone = $doctor['phone_no'];
        $doc_image = $doctor['image'];
        
        $str.='<div class="patient-card col-sm-5 edit-container">          
                        <div class="row" style="padding: 20px" >
                            <div class="edit-button" style="opacity: 0;">
									<!--<a data-toggle="modal" href="#editdocmodal" style="color: black" onclick="getdet('.$doctor["id"].');"><div class="glyphicon glyphicon-pencil"></div></a>-->
									<a href="add_edit_doctor.php?id='.$doctor[id].'&cid='.$clinic_id.'" style="color: black"><div class="glyphicon glyphicon-pencil"></div></a>
								</div>
                            <img  class="col-xs-12 col-sm-3" src='.base_url_image.'dp/'.$doctor['image'].' style="height: 80px; float: left;background-color: #c4c4c4" width="60px" >                                    
                            <div class="col-sm-9 col-xs-12">
                                <h5 style="margin-top: 0"><strong>'.$doctor['name'].'</strong></h5>
                                <h6>'.$doctor['phone_no'].'</h6>
                                
                            </div>
                        </div>
                   
                </div>';
    }
    return $str;
}
public function update_clinic_about($id, $name, $about, $exp)
{
	$about=mysql_real_escape_string($about);
	$res=$this->db->query("update clinic set name='$name', about='$about', image='$exp' where id='$id'");
	if($res)
	{
		return true;
	}
	
}

public function update_service_clinic($id, $service)
{
	
	
	$res=$this->db->query("update clinic set services='$service' where id='$id'");
	
	if($res)
	{
		return true;
	}
}public function update_award_clinic($id, $service)
{
	
	
	$res=$this->db->query("update clinic set award='$service' where id='$id'");
	
	if($res)
	{
		return true;
	}
}
public function update_acc_clinic($id, $service)
{
	$doc_id=$_SESSION['login_id'];
	
	$res=$this->db->query("update clinic set accreditation='$service' where id='$id'");
	
	if($res)
	{
		return true;
	}
}
public function update_membership_clinic($id, $member)
{

	
	$res=$this->db->query("update clinic set membership='$member' where id='$id'");
	
	if($res)
	{
		return true;
	}
}public function update_sp_clinic($id, $sp)
{

	
	$res=$this->db->query("update clinic set specialization='$sp' where id='$id'");
	
	if($res)
	{
		return true;
	}
}
public function update_address_clinic($id, $address,$city,$state,$pincode,$district,$area,$country,$map)
{
	
	
	$res=$this->db->query("update clinic set address='$address',city='$city',state='$state',pincode='$pincode',district='$district',area='$area',country='$country',map='$map' where id='$id'");
	
	if($res)
	{
		return true;
	}
}
public function update_contact_clinic($id,$phone_no,$sec,$telephone,$new_email,$website)
{
	$doc_id=$_SESSION['login_id'];
	
	$res=$this->db->query("update clinic set phone_no='$phone_no',secondry_phone='$sec',telephone='$telephone',new_email='$new_email',website='$website' where id='$id'");
	
	if($res)
	{
		return true;
	}
}
public function update_reg_clinic($id,$reg_no,$reg_year,$reg_add_info,$proof)
{
	$doc_id=$_SESSION['login_id'];
	
	$res=$this->db->query("update clinic set registration_no='$reg_no',reg_year='$reg_year',reg_add_info='$reg_add_info',reg_proof='$proof' where id='$id'");
	
	if($res)
	{
		return true;
	}
}
public function get_clinic_detail()
{
	$doc_id=$_SESSION['login_id'];
	$res=$this->db->query("SELECT * FROM `clinic` WHERE `doctor_id` = '$doc_id'");
	if(@$res->num_rows > 0)
	{
		return $res->fetch_assoc();
	}
}

public function get_clinic_detail_edit($id)
{
	
	$res=$this->db->query("SELECT * FROM `clinic` WHERE `id` = '$id'");
	if(@$res->num_rows > 0)
	{
		return $res->fetch_assoc();
	}
}
public function update_id_clinic($id, $file)
{
	
	//echo "update clinic set id_proof='$file' where doctor_id='$doc_id'"; exit;
	$res=$this->db->query("update clinic set id_proof='$file' where id='$id'");
	if($res)
	{
		return true;
		
	}
	
}
public function update_benner($image)
{
	$doc_id=$_SESSION['login_id'];
	$res=$this->db->query("update doctors set benner='$image' where id='$doc_id'");
	if($res)
	{
		return TRUE;
	}
}
public function update_profile_pic($image,$cid)
{
	$doc_id=$_SESSION['login_id'];
	if($cid == ''){
	    $res=$this->db->query("update doctors set image='$image' where id='$doc_id'");
	}else{
	    $res=$this->db->query("update clinic set image='$image' where id='$cid'");
	}    
	if($res)
	{
		return TRUE;
	}
}public function update_benner_clinic($image)
{
	$doc_id=$_SESSION['login_id'];
	$res=$this->db->query("update clinic set benner='$image' where id='$doc_id'");
	if($res)
	{
		return TRUE;
	}
}
public function remove_image($data_ar,$col)
	{
		
		$doc_id=$_SESSION['login_id'];
		if(!empty($data_ar))
		 $data=json_encode($data_ar);
		 else
		 $data='';
		$res=$this->db->query("update doctors set $col='$data' where id='$doc_id'");
		if($res)
		{
			return true;
		}

	}


 public function remove_image_clinic($data_ar,$col)
	{
		
		$doc_id=$_SESSION['login_id'];
		 if(!empty($data_ar))
		 $data=json_encode($data_ar);
		 else
		 $data='';
	
		$res=$this->db->query("update clinic set $col='$data' where doctor_id='$doc_id'");
		if($res)
		{
			return true;
		}

	}
	
	public function remove_education($data_ar,$col)
	{
		
		$doc_id=$_SESSION['login_id'];
		 if(!empty($data_ar))
		 $data=json_encode($data_ar);
		 else
		 $data='';
	     
		$res=$this->db->query("update doctors set $col='$data' where id='$doc_id'");
		if($res)
		{
			return true;
		}

	}
public function edit_vital($pulse,$temperature,$weight,$resp_rate,$id,$height,$pefr_pre,$pefr_post,$sugar_fasting,$sugar_rendom,$blood_s,$blood_d)
{
	$res=$this->db->query("update vital set pulse='$pulse',temperature='$temperature',weight='$weight',resp_rate='$resp_rate',height='$height',pefr_pre='$pefr_pre',pefr_post='$pefr_post',blood_sugar_fast='$sugar_fasting',blood_sugar_rendom='$sugar_rendom',blood_systolic='$blood_s',blood_diastolic='$blood_d' where id='$id'");
	 if($res)
	 {
	 	return true;
	 }
}
public function edit_clinical_note($complaint,$observations,$investigations,$diagnoses,$note,$id)
{
	
	$res=$this->db->query("update clinical_note set complaint='$complaint',observation='$observations',invastigations='$investigations',diagnoses='$diagnoses',note='$note' where id='$id'");
	if($res)
	{
		return true;
	}
}
public function update_practice1($monday,$tuesday,$wednesday,$thursday,$friday,$saturday,$sunday,$monday1,$tuesday1,$wednesday1,$thursday1,$friday1,$saturday1,$sunday1,$monday_sec,$tuesday_sec,$wednesday_sec,$thursday_sec,$friday_sec,$saturday_sec,$sunday_sec,$monday_sec1,$tuesday_sec1,$wednesday_sec1,$thursday_sec1,$friday_sec1,$saturday_sec1,$sunday_sec1,$clinic_id,$doc_id)
{
	$doc_id=$_SESSION['login_id'];
	//echo $clinic_id,$doc_id;
	$res=$this->db->query("select * from practice where doctor_id='$doc_id' and clinic_id='$clinic_id'");
	 if($res->num_rows > 0)
	 {
	 	
    //echo $clinic_id,$doc_id;
	$res1=$this->db->query("update practice set monday='$monday',tuesday='$tuesday',wednesday='$wednesday',thursday='$thursday',friday='$friday',saturday='$saturday',sunday='$sunday',monday1='$monday1',tuesday1='$tuesday1',wednesday1='$wednesday1',thursday1='$thursday1',friday1='$friday1',saturday1='$saturday1',sunday1='$sunday1',monday_sec='$monday_sec',tuesday_sec='$tuesday_sec',wednesday_sec='$wednesday_sec',thursday_sec='$thursday_sec',friday_sec='$friday_sec',saturday_sec='$saturday_sec',sunday_sec='$sunday_sec',monday_sec1='$monday_sec1',tuesday_sec1='$tuesday_sec1',wednesday_sec1='$wednesday_sec1',thursday_sec1='$thursday_sec1',friday_sec1='$friday_sec1',saturday_sec1='$saturday_sec1',sunday_sec1='$sunday_sec1' where doctor_id='$doc_id' and clinic_id='$clinic_id'");
	if(@$res1)
	{
		return true;
	}
	 	
	 }
	 else{
	 //echo $clinic_id,$doc_id,"hello";
	 	$res1=$this->db->query("insert into practice(monday,tuesday,wednesday,thursday,friday,saturday,sunday,monday1,tuesday1,wednesday1,thursday1,friday1,saturday1,sunday1,monday_sec,tuesday_sec,wednesday_sec,thursday_sec,friday_sec,saturday_sec,sunday_sec,monday_sec1,tuesday_sec1,wednesday_sec1,thursday_sec1,friday_sec1,saturday_sec1,sunday_sec1,doctor_id,clinic_id) values('$monday','$tuesday','$wednesday','$thursday','$friday','$saturday','$sunday','$monday1','$tuesday1','$wednesday1','$thursday1','$friday1','$saturday1','$sunday1','$monday_sec','$tuesday_sec','$wednesday_sec','$thursday_sec','$friday_sec','$saturday_sec','$sunday_sec','$monday_sec1','$tuesday_sec1','$wednesday_sec1','$thursday_sec1','$friday_sec1','$saturday_sec1','$sunday_sec1','$doc_id','$clinic_id')");
	 	if($res1)
	 	{
			return true;
		}
	 }
	
		
	

	
}

public function get_practice_by_doc_id_clinic_id($clinic_id)
{
    //echo $clinic_id;
    $doc_id=$_SESSION['login_id'];
    
    $res = $this->db->query("select * from practice where doctor_id='$doc_id' and clinic_id='$clinic_id'");
    if($res->num_rows > 0)
    {
        return $res->fetch_assoc();
    }
}
public function get_timing1_session1_from_time($clinic_id)
{
    $doc_id = $_SESSION['login_id'];
    //echo $clinic_id,$doc_id,"hi";
    $res = $this->db->query("select * from practice where doctor_id='$doc_id' and clinic_id='$clinic_id'");
    
    $data = $res->fetch_assoc();
    if(!empty($data['sunday']))
    {
        //echo "hello";
        $time = explode('-',$data['sunday']);
        return $time[0];
    }
    else if(!empty($data['monday']))
    {
        //echo "hello";
        $time = explode('-',$data['monday']);
        return $time[0];
    }
    else if(!empty($data['tuesday']))
    {
        //echo "hello";
        $time = explode('-',$data['tuesday']);
        return $time[0];
    }
    else if(!empty($data['wednesday']))
    {
        //echo "hello";
        $time = explode('-',$data['wednesday']);
        return $time[0];
    }
    else if(!empty($data['thursday']))
    {
        //echo "hello";
        $time = explode('-',$data['thursday']);
        return $time[0];
    }
    else if(!empty($data['friday']))
    {
        //echo "hello";
        $time = explode('-',$data['friday']);
        return $time[0];
    }
    else if(!empty($data['saturday']))
    {
        //echo "hello";
        $time = explode('-',$data['saturday']);
        return $time[0];
    }
}
public function get_timing2_session1_from_time($clinic_id)
{
    $doc_id = $_SESSION['login_id'];
    //echo $clinic_id,$doc_id,"hi";
    $res = $this->db->query("select * from practice where doctor_id='$doc_id' and clinic_id='$clinic_id'");
    
    $data = $res->fetch_assoc();
    if(!empty($data['sunday_sec']))
    {
        //echo "hello";
        $time = explode('-',$data['sunday_sec']);
        return $time[0];
    }
    else if(!empty($data['monday_sec']))
    {
        //echo "hello";
        $time = explode('-',$data['monday_sec']);
        return $time[0];
    }
    else if(!empty($data['tuesday_sec']))
    {
        //echo "hello";
        $time = explode('-',$data['tuesday_sec']);
        return $time[0];
    }
    else if(!empty($data['wednesday_sec']))
    {
        //echo "hello";
        $time = explode('-',$data['wednesday_sec']);
        return $time[0];
    }
    else if(!empty($data['thursday_sec']))
    {
        //echo "hello";
        $time = explode('-',$data['thursday_sec']);
        return $time[0];
    }
    else if(!empty($data['friday_sec']))
    {
        //echo "hello";
        $time = explode('-',$data['friday_sec']);
        return $time[0];
    }
    else if(!empty($data['saturday_sec']))
    {
        //echo "hello";
        $time = explode('-',$data['saturday_sec']);
        return $time[0];
    }
}
public function get_timing1_session2_from_time($clinic_id)
{
    $doc_id = $_SESSION['login_id'];
    //echo $clinic_id,$doc_id,"hi";
    $res = $this->db->query("select * from practice where doctor_id='$doc_id' and clinic_id='$clinic_id'");
    
    $data = $res->fetch_assoc();
    if(!empty($data['sunday1']))
    {
        //echo "hello";
        $time = explode('-',$data['sunday1']);
        return $time[0];
    }
    else if(!empty($data['monday1']))
    {
        //echo "hello";
        $time = explode('-',$data['monday1']);
        return $time[0];
    }
    else if(!empty($data['tuesday1']))
    {
        //echo "hello";
        $time = explode('-',$data['tuesday1']);
        return $time[0];
    }
    else if(!empty($data['wednesday1']))
    {
        //echo "hello";
        $time = explode('-',$data['wednesday1']);
        return $time[0];
    }
    else if(!empty($data['thursday1']))
    {
        //echo "hello";
        $time = explode('-',$data['thursday1']);
        return $time[0];
    }
    else if(!empty($data['friday1']))
    {
        //echo "hello";
        $time = explode('-',$data['friday1']);
        return $time[0];
    }
    else if(!empty($data['saturday1']))
    {
        //echo "hello";
        $time = explode('-',$data['saturday1']);
        return $time[0];
    }
}
public function get_timing2_session2_from_time($clinic_id)
{
    $doc_id = $_SESSION['login_id'];
    //echo $clinic_id,$doc_id,"hi";
    $res = $this->db->query("select * from practice where doctor_id='$doc_id' and clinic_id='$clinic_id'");
    
    $data = $res->fetch_assoc();
    if(!empty($data['sunday_sec1']))
    {
        //echo "hello";
        $time = explode('-',$data['sunday_sec1']);
        return $time[0];
    }
    else if(!empty($data['monday_sec1']))
    {
        //echo "hello";
        $time = explode('-',$data['monday_sec1']);
        return $time[0];
    }
    else if(!empty($data['tuesday_sec1']))
    {
        //echo "hello";
        $time = explode('-',$data['tuesday_sec1']);
        return $time[0];
    }
    else if(!empty($data['wednesday_sec1']))
    {
        //echo "hello";
        $time = explode('-',$data['wednesday_sec1']);
        return $time[0];
    }
    else if(!empty($data['thursday_sec1']))
    {
        //echo "hello";
        $time = explode('-',$data['thursday_sec1']);
        return $time[0];
    }
    else if(!empty($data['friday_sec1']))
    {
        //echo "hello";
        $time = explode('-',$data['friday_sec1']);
        return $time[0];
    }
    else if(!empty($data['saturday_sec1']))
    {
        //echo "hello";
        $time = explode('-',$data['saturday_sec1']);
        return $time[0];
    }
}
public function get_timing1_session1_to_time($clinic_id)
{
    $doc_id = $_SESSION['login_id'];
    //echo $clinic_id,$doc_id,"hi";
    $res = $this->db->query("select * from practice where doctor_id='$doc_id' and clinic_id='$clinic_id'");
    
    $data = $res->fetch_assoc();
    if(!empty($data['sunday']))
    {
        //echo "hello";
        $time = explode('-',$data['sunday']);
        return $time[1];
    }
    else if(!empty($data['monday']))
    {
        //echo "hello";
        $time = explode('-',$data['monday']);
        return $time[1];
    }
    else if(!empty($data['tuesday']))
    {
        //echo "hello";
        $time = explode('-',$data['tuesday']);
        return $time[1];
    }
    else if(!empty($data['wednesday']))
    {
        //echo "hello";
        $time = explode('-',$data['wednesday']);
        return $time[1];
    }
    else if(!empty($data['thursday']))
    {
        //echo "hello";
        $time = explode('-',$data['thursday']);
        return $time[1];
    }
    else if(!empty($data['friday']))
    {
        //echo "hello";
        $time = explode('-',$data['friday']);
        return $time[1];
    }
    else if(!empty($data['saturday']))
    {
        //echo "hello";
        $time = explode('-',$data['saturday']);
        return $time[1];
    }
}
public function get_timing2_session1_to_time($clinic_id)
{
    $doc_id = $_SESSION['login_id'];
    //echo $clinic_id,$doc_id,"hi";
    $res = $this->db->query("select * from practice where doctor_id='$doc_id' and clinic_id='$clinic_id'");
    
    $data = $res->fetch_assoc();
    if(!empty($data['sunday_sec']))
    {
        //echo "hello";
        $time = explode('-',$data['sunday_sec']);
        return $time[1];
    }
    else if(!empty($data['monday_sec']))
    {
        //echo "hello";
        $time = explode('-',$data['monday_sec']);
        return $time[1];
    }
    else if(!empty($data['tuesday_sec']))
    {
        //echo "hello";
        $time = explode('-',$data['tuesday_sec']);
        return $time[1];
    }
    else if(!empty($data['wednesday_sec']))
    {
        //echo "hello";
        $time = explode('-',$data['wednesday_sec']);
        return $time[1];
    }
    else if(!empty($data['thursday_sec']))
    {
        //echo "hello";
        $time = explode('-',$data['thursday_sec']);
        return $time[1];
    }
    else if(!empty($data['friday_sec']))
    {
        //echo "hello";
        $time = explode('-',$data['friday_sec']);
        return $time[1];
    }
    else if(!empty($data['saturday_sec']))
    {
        //echo "hello";
        $time = explode('-',$data['saturday_sec']);
        return $time[1];
    }
}
public function get_timing1_session2_to_time($clinic_id)
{
    $doc_id = $_SESSION['login_id'];
    //echo $clinic_id,$doc_id,"hi";
    $res = $this->db->query("select * from practice where doctor_id='$doc_id' and clinic_id='$clinic_id'");
    
    $data = $res->fetch_assoc();
    if(!empty($data['sunday1']))
    {
        //echo "hello";
        $time = explode('-',$data['sunday1']);
        return $time[1];
    }
    else if(!empty($data['monday1']))
    {
        //echo "hello";
        $time = explode('-',$data['monday1']);
        return $time[1];
    }
    else if(!empty($data['tuesday1']))
    {
        //echo "hello";
        $time = explode('-',$data['tuesday1']);
        return $time[1];
    }
    else if(!empty($data['wednesday1']))
    {
        //echo "hello";
        $time = explode('-',$data['wednesday1']);
        return $time[1];
    }
    else if(!empty($data['thursday1']))
    {
        //echo "hello";
        $time = explode('-',$data['thursday1']);
        return $time[1];
    }
    else if(!empty($data['friday1']))
    {
        //echo "hello";
        $time = explode('-',$data['friday1']);
        return $time[1];
    }
    else if(!empty($data['saturday1']))
    {
        //echo "hello";
        $time = explode('-',$data['saturday1']);
        return $time[1];
    }
}
public function get_timing2_session2_to_time($clinic_id)
{
    $doc_id = $_SESSION['login_id'];
    //echo $clinic_id,$doc_id,"hi";
    $res = $this->db->query("select * from practice where doctor_id='$doc_id' and clinic_id='$clinic_id'");
    
    $data = $res->fetch_assoc();
    if(!empty($data['sunday_sec1']))
    {
        //echo "hello";
        $time = explode('-',$data['sunday_sec1']);
        return $time[1];
    }
    else if(!empty($data['monday_sec1']))
    {
        //echo "hello";
        $time = explode('-',$data['monday_sec1']);
        return $time[1];
    }
    else if(!empty($data['tuesday_sec1']))
    {
        //echo "hello";
        $time = explode('-',$data['tuesday_sec1']);
        return $time[1];
    }
    else if(!empty($data['wednesday_sec1']))
    {
        //echo "hello";
        $time = explode('-',$data['wednesday_sec1']);
        return $time[1];
    }
    else if(!empty($data['thursday_sec1']))
    {
        //echo "hello";
        $time = explode('-',$data['thursday_sec1']);
        return $time[1];
    }
    else if(!empty($data['friday_sec1']))
    {
        //echo "hello";
        $time = explode('-',$data['friday_sec1']);
        return $time[1];
    }
    else if(!empty($data['saturday_sec1']))
    {
        //echo "hello";
        $time = explode('-',$data['saturday_sec1']);
        return $time[1];
    }
}
public function update_practice_clinic($consult,$duration,$monday,$tuesday,$wednesday,$thursday,$friday,$saturday,$sunday,$monday1,$tuesday1,$wednesday1,$thursday1,$friday1,$saturday1,$sunday1,$clinic_id)
{
	$res=$this->db->query("select * from practice where clinic_id='$clinic_id'");
	 if($res->num_rows > 0)
	 {
	
	$res1=$this->db->query("update practice set consult='$consult',monday='$monday',tuesday='$tuesday',wednesday='$wednesday',thursday='$thursday',friday='$friday',saturday='$saturday',sunday='$sunday',monday1='$monday1',tuesday1='$tuesday1',wednesday1='$wednesday1',thursday1='$thursday1',friday1='$friday1',saturday1='$saturday1',sunday1='$sunday1',duration='$duration' where clinic_id='$clinic_id'");
	if(@$res1)
	{
		return TRUE;
	}
	 	
	 }
	 else{
	 	$res1=$this->db->query("insert into practice(consult,duration,monday,tuesday,wednesday,thursday,friday,saturday,sunday,monday1,tuesday1,wednesday1,thursday1,friday1,saturday1,sunday1,clinic_id) values('$consult','$duration','$monday','$tuesday','$wednesday','$thursday','$friday','$saturday','$sunday','$monday1','$tuesday1','$wednesday1','$thursday1','$friday1','$saturday1','$sunday1','$clinic_id')");
	 	if($res1)
	 	{
			return true;
		}
	 }
	
}

public function update_slot_fees_by_doctor_id($fees,$slot)
{
    $doc_id = $_SESSION['login_id'];
    //echo $fees,$slot,$doc_id;
    $res = $this->db->query("update practice set duration='$slot',consult='$fees' where doctor_id='$doc_id'");
    if($res)
    {
        return TRUE;
    }
}
public function service_dropdown()
 {
 	$res=$this->db->query("select * from service");
 	$str='';
 	if($res->num_rows > 0)
 	{
		while($data=$res->fetch_assoc())
		{
			$str.='<option value="'.$data['name'].'"> '.$data['name'].' </option>';
		}
	}
	return $str;
 }
public function collage_dropdown()
 {
 	$res=$this->db->query("select * from collage");
 	$str='';
 	if($res->num_rows > 0)
 	{
		while($data=$res->fetch_assoc())
		{
			$str.='<option value="'.$data['name'].'"> '.$data['name'].' </option>';
		}
	}
	return $str;
 }
 public function check_pass_and_change($old_password,$new_password,$new_password1)
 {
     $doc_id = $_SESSION['login_id'];
     $res = $this->db->query("select * from doctors where id='$doc_id'");
    // echo $old_password,$new_password,$new_password1;
     $data = $res->fetch_assoc();
     
     if($data['password']==$old_password && $new_password==$new_password1)
     {
         $res1 = $this->db->query("update doctors set password='$new_password1' where id='$doc_id'");
         if($res1)
         {
            return TRUE;
         }
         else
         {
             return FALSE;
         }
     }
     return FALSE;
 }
  public function check_phone_and_change($old_phone,$new_phone)
 {
     $doc_id = $_SESSION['login_id'];
     $res = $this->db->query("select * from doctors where id='$doc_id'");
    // echo $old_password,$new_password,$new_password1;
     $data = $res->fetch_assoc();
     
     if($data['phone_no']==$old_phone)
     {
         $res1 = $this->db->query("update doctors set phone_no='$new_phone' where id='$doc_id'");
         if($res1)
         {
            return TRUE;
         }
         else
         {
             return FALSE;
         }
     }
     return FALSE;
 }
 
 public function update_education_doctor($education,$clinic_id)
 {
 	$doc_id=$_SESSION['login_id'];
 	if($clinic_id == '-1'){
 	    $sql = "update doctors set education = '".$education."' where id=".$doc_id;
 	} 
 	else{
 	    $sql = "update clinic set education='".$education."' where id=".$clinic_id;
 	}
 	
 	$res=$this->db->query($sql);
 	if(@$res)
 	{
		return true;
	}
 }  
 public function update_expernce_doctor($experience,$clinic_id)
 {
 	$doc_id=$_SESSION['login_id'];
 	if($clinic_id == '-1'){
 	  $sql = 'update doctors set experience_detail = \''.$experience.'\'  where id='.$doc_id.'';
 	 
 	   $res=$this->db->query($sql);
 	} else {
 	    
 	    $res=$this->db->query('update clinic set experience_detail = \''.$experience.'\' where id='.$clinic_id.'');
 	    
 	}
 	if(@$res)
 	{
		return true;
	}
 } 
 public function update_experience_doctor($education)
 {
 	$doc_id=$_SESSION['login_id'];
 	$education = $this->db->real_escape_string($education);
 	$res=$this->db->query("update doctors set experience_detail = '$education' where id='$doc_id'");
 	if(@$res)
 	{
		return true;
	}
 } 
 public function update_addition_education_doctor($education)
 {
 	$doc_id=$_SESSION['login_id'];
 	$res=$this->db->query("update doctors set additional_education='$education',status='Active ' where id='$doc_id'");
 	if(@$res)
 	{
		return true;
	}
 }
 public function getpractice_detail_per()
 {
 	$doc_id=$_SESSION['login_id'];
 	$res=$this->db->query("select * from practice where (doctor_id='$doc_id')");
 	if($res->num_rows > 0)
 	{
		return $res->fetch_assoc();
	}
	
 }
 public function getpractice_detail_clinic($id)
 {
 	$doc_id=$_SESSION['login_id'];
 	$res2=$this->db->query("select * from practice where (clinic_id='$id')");
		if($res2->num_rows > 0)
 			{
			return $res2->fetch_assoc();
			}
 }
  public function remove_gallery_image($img_id, $gal, $img_arr)
  {
	  $Path = '../image/clinic-gallery/'.$gal[$img_arr];
	  unlink($Path);  
	  unset($gal[$img_arr]);
	  $gal1 = array_values($gal);
	  $gal2 = implode(",", $gal);
	  $res = $this->db->query("UPDATE clinic SET benner = '$gal2' WHERE id = '$img_id'");
	  if($res){
		return TRUE;
	}
	else{
		return FALSE;
	}
  }
   public function update_gallery($id, $images_array,$video_url){
	 
	  $res = $this->db->query("UPDATE clinic SET benner = '$images_array',video_url='$video_url' WHERE id = '$id'");
	  if($res){
		return TRUE;
	}
	else{
		return FALSE;
	}
  }
  
	public function delete_clinic_by_id($table, $id){
			$res = $this->db->query("DELETE FROM $table WHERE id= '$id'");
				if($res){
				 return TRUE;
				}else {
				
				return FALSE;	
				}
	}
public function communication_patient()
{
	$doc_id=$_SESSION['login_id'];
	$res=$this->db->query("select * from patient where doctor_id='$doc_id'");
	$str='';
	$str='  <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>Patient Image</th>
                                        <th>Name</th>
                                         <th>Phone No</th>
                                        <th>Area, City</th>
                                        <th>Age</th>
                                         <th>Gender</th>
                                         <th>Patient ID</th>
                                         <th>Action</th>
                                    </tr>
                                </thead>
                                 <tbody>';
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
			$area = $this->getById($data['area'], 'area');
			$str.=' <tr>
                                        <td><img src="'.base_url.'image/'.$data['image'].'" width="60" height="60"></td>
                                        <td>'.$data['name'].'</td>
                                        <td>'.$data['phone_no'].'</td>
                                        <td>'.$area['name'].', '.$data['city'].'</td>
                                        <td>'.$data['age'].'</td>
                                        <td>'.$data['gender'].'</td>
                                        <td>'.$data['patient_id'].'</td>
                                        <td>
                                        <a href="'.base_url_doc.'patient-detail/?select='.$data['id'].'" style="padding:9px 13px 10px 9px; font-weight: bold;" class="btn btn-info">
                                        Select</a>
								 </td>
                                    </tr>
                                   ';
		
		}	
	}
	$str.=' </tbody></table>';
	 return $str;
}
public function update_patient_commmunication($birthday,$followup,$id,$followup_email,$birthday_email,$followup_days)
{
	
	$res=$this->db->query("update patient set birthday='$birthday',followup='$followup',birthday_email='$birthday_email',followup_email='$followup_email',follow_up_days='$followup_days' where id='$id'");
	if($res)
	{
		return TRUE;
	}
}
public function Update_print($header,$left,$right,$title,$image)
{
	$doc_id=@$_SESSION['login_id'];
	
	if($header=="Yes")
	{
	
	$res=$this->db->query("select * from print_setting where doctor_id='$doc_id'");
	
	if($res->num_rows>0)
	{
		
		$res1=$this->db->query("update print_setting set header='$title',header_left='$left',header_right='$right',logo='$image' where doctor_id='$doc_id'");
		if(@$res1)
		{
			return true;
		}
	}
	else
	{
		
		$res1=$this->db->query("insert into print_setting(header,header_left,header_right,logo,doctor_id) values('$title','$left','$right','$image','$doc_id')");
		if(@$res1)
		{
			return true;
		}
	}
		
	}
	else{
		$res1=$this->db->query("delete from print_setting where doctor_id='$doc_id'");
		if(@$res1)
		{
			return true;
		}
	}
}public function Update_print_footer($footer,$left,$right)
{
	$doc_id=@$_SESSION['login_id'];
	

	
	$res=$this->db->query("select * from print_setting where doctor_id='$doc_id'");
	
	if($res->num_rows>0)
	{
		
		$res1=$this->db->query("update print_setting set footer='$footer',footer_left='$left',footer_right='$right' where doctor_id='$doc_id'");
		if(@$res1)
		{
			return true;
		}
	}
	else
	{
		
		$res1=$this->db->query("insert into print_setting(footer,footer_left,footer_right,doctor_id) values('$footer','$left','$right','$doc_id')");
		if(@$res1)
		{
			return true;
		}
	}
		
	
	
}
public function update_appointment($online_appointment, $doc_id)
{
$res=$this->db->query("update doctors set online_appointment='$online_appointment' where id='$doc_id'");
if($res)
{
	return true;
}	
}
public function report_feedback($id)
{
    $res = $this->db->query("update feedback set status='Inactive' where id = '$id'");
    return $res;
}

public function feedback_reply($id,$note){
    
    $res = $this->db->query("update feedback set reply = '$note' where id='$id'");
    return true;
}

public function feedback_front()
{
	$patient_id=@$_SESSION['login_id'];
	
	$res=$this->db->query("select * from feedback where doctor_id='$patient_id' and status='Active' order by starred desc, date desc ");
	
    $str='';
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{   
		
		
         $str.='<div class="feed-flex-card"  style="margin:10px;position:relative">
            <div class="col-sm-12">
				<h5 ><strong>'.$data['name'].'</strong></h5>';
				if($data['reply']==''){
				$str.='<div onclick="feed_reply('.$data['id'].')" data-toggle="modal" data-target="#reply_feed_modal" class="patient-list-buttons glyphicon glyphicon-share-alt"  style="float:right;top:10px;right:80px;position:absolute"  ></div>
				';
				}
		if($data['starred']==1){
				$str.='<div class="patient-list-buttons glyphicon glyphicon-flag"  style="float:right;top:10px;right:10px;position:absolute"  ></div>
                <div class="patient-list-buttons glyphicon glyphicon-star" style="float:right;top:10px;right:45px;position:absolute" onclick="feedback_unstarred('.$data['id'].')"    ></div>
                ';
		}
		else{
			$str.='
				<div class="patient-list-buttons glyphicon glyphicon-flag"  style="float:right;top:10px;right:10px;position:absolute"  ></div>
                <div class="patient-list-buttons glyphicon glyphicon-pushpin" onclick="feedback_starred('.$data['id'].')"  style="float:right;top:10px;right:45px;position:absolute"  ></div>
                ';
		}	
		$str.='<h5>';
		for($counter=1; $counter <= 5; $counter++){
		    if($counter <= $data['rate'] ){
		        $str.='<span class="glyphicon glyphicon-star filled"></span>';
		    } else {
		        $str.='<span class="glyphicon glyphicon-star empty"></span>';
		    }
		}
		
		$str.='<small style="margin-left:10px">'.date("j F Y",strtotime($data['date'])).' </small></h5>
			</div>
			<div class=" patient-card ">
			<div class="col-sm-12">
				<h6>'.$data['description'].'</h6>
			</div>
			</div>
		</div>';
		}	
	}
	
	//$str.=' </tbody></table>';
	 return $str;
	
}

public function display_feedback_after_starred($id)
{
	$patient_id=@$_SESSION['login_id'];
	$res1= $this->db->query("update feedback set starred=1 WHERE id='$id'");
	$res=$this->db->query("select * from feedback where doctor_id='$patient_id' and status='Active' order by starred desc, date desc ");
	
    $str='';
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{   
		
         $str.='<div  style="width:30%;margin:10px;position:relative">
            <div class="col-sm-12">
				<h5 ><strong>'.$data['name'].'</strong></h5>
				';
		if($data['starred']==1){
				$str.='<div class="patient-list-buttons glyphicon glyphicon-flag"  style="float:right;top:10px;right:10px;position:absolute"  ></div>
                <div class="patient-list-buttons glyphicon glyphicon-star" onclick="feedback_unstarred('.$data['id'].')"  style="float:right;top:10px;right:45px;position:absolute"  ></div>';
		}
		else{
			$str.='
				<div class="patient-list-buttons glyphicon glyphicon-flag"  style="float:right;top:10px;right:10px;position:absolute"  ></div>
                <div class="patient-list-buttons glyphicon glyphicon-pushpin" onclick="feedback_starred('.$data['id'].')"  style="float:right;top:10px;right:45px;position:absolute"  ></div>';
		}	
		$str.='<h5><small>'.$data['rate'].' / 5 reviewed on '.date("j F Y",strtotime($data['date'])).' </small></h5>
			</div>
			<div class=" patient-card ">
			<div class="col-sm-12">
				<h6>'.$data['description'].'</h6>
			</div>
			</div>
		</div>';
		}		
	}
	
	//$str.=' </tbody></table>';
	 return $str;
}


public function display_feedback_after_unstarred($id)
{
	$patient_id=@$_SESSION['login_id'];
	$res1= $this->db->query("update feedback set starred=0 WHERE id='$id'");
	$res=$this->db->query("select * from feedback where doctor_id='$patient_id' and status='Active' order by starred desc, date desc ");
	
    $str='';
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{   
		
         $str.='<div style="width:30%;margin:10px;position:relative">
            <div class="col-sm-12">
				<h5 ><strong>'.$data['name'].'</strong></h5>
				';
		if($data['starred']==1){
				$str.='<div class="patient-list-buttons glyphicon glyphicon-flag"  style="float:right;top:10px;right:10px;position:absolute"  ></div>
                <div class="patient-list-buttons glyphicon glyphicon-star" onclick="feedback_unstarred('.$data['id'].')"  style="float:right;top:10px;right:45px;position:absolute"  ></div>';
		}
		else{
			$str.='
				<div class="patient-list-buttons glyphicon glyphicon-flag"  style="float:right;top:10px;right:10px;position:absolute"  ></div>
                <div class="patient-list-buttons glyphicon glyphicon-pushpin" onclick="feedback_starred('.$data['id'].')"  style="float:right;top:10px;right:45px;position:absolute"  ></div>';
		}	
		$str.='<h5><small>'.$data['rate'].' / 5 reviewed on '.date("j F Y",strtotime($data['date'])).' </small></h5>
			</div>
			<div class=" patient-card ">
			<div class="col-sm-12">
				<h6>'.$data['description'].'</h6>
			</div>
			</div>
		</div>';
		}		
	}
	
	//$str.=' </tbody></table>';
	 return $str;
}



 
public function notification()
{
	$doc_id=$_SESSION['login_id'];
	$res=$this->db->query("select * from feedback where doctor_id='$doc_id' and status='Pending'");
	$str='';
	if($res->num_rows >0 )
	{
		$str=' <table class="table table-bordered table-striped table-hover dataTable ">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                         <th>Description</th>
                                      
                                        <th>Action</th>
                                     </tr>
                                </thead>
                                 <tbody>';
		while($data=$res->fetch_assoc())
		{
			$str.=' <tr>
                                        <td>'.$data['name'].'</td>
                                       
                                        <td>'.$data['description'].'</td>
                                        <td><a href="'.base_url_doc.'feedback/?action=display" class="btn btn-info">
                                   View</a>
                                                                            </td>
                                      
                                       
                                       
                                    </tr>
                                   ';
	
	
	
		}
		$str.=' </tbody></table>';
	}
	return $str;
}
public function display_event()
{
	$doc_id=$_SESSION['login_id'];
	$res=$this->db->query("select * from event where doctor_id='$doc_id'");
	$str=' <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>Event Title</th>
                                         <th>Time</th>
                                        <th>Date</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                     </tr>
                                </thead>
                                 <tbody>';
                                 $count=0;
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{   
		$count++;
		  
			$str.=' <tr>
                                        <td>'.$data['name'].'</td>
                                        <td>'.$data['event_time'].'</td>
                                        <td>'.$data['event_date'].'</td>
                                        <td>'.$data['description'].'</td>
                                        <td><a href="'.base_url_doc.'event/?edit='.$data['id'].'" class="btn btn-info">
                                        <i class="material-icons">edit</i></a>
                                        <a href="'.base_url_doc.'event/?delete='.$data['id'].'" class="btn btn-danger" onclick="return conf();"> <i class="material-icons">clear</i></a>                                       </td>
                                      
                                       
                                       
                                    </tr>
                                   ';
			}	
	}
	
	$str.=' </tbody></table>';
	 return $str;
	
	
}
public function add_event($title,$date,$time,$desctiption)
{
	$doc_id=$_SESSION['login_id'];
	
	$res=$this->db->query("insert into event(name,event_date,event_time,description,doctor_id) values('$title','$date','$time','$desctiption','$doc_id')");
	if($res)
	{
		return true;
	}
}
public function  edit_event($title,$date,$time,$description,$id)
{
	$res=$this->db->query("update event set name='$title',event_date='$date',event_time='$time',description='$description' where id='$id'");
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

public function update_consult_detail($consult,$online_appointment,$home_visit,$fee)
{
	$doc_id=$_SESSION['login_id'];
	

		$res1=$this->db->query("update doctors set online_appointment='$online_appointment',home_visit='$home_visit',home_visit_fee='$fee' where id='$doc_id' ");
		if($res1)
		{
			return true;
		}
	
}
public function all_clinic_checkbox()
{
	$doc_id=$_SESSION['login_id'];
	$res=$this->db->query("select * from clinic where doctor_id='$doc_id'");
	$str='';
	if($res->num_rows>0)
	{
		while($data=$res->fetch_assoc())
		{
			
			$str.=' <li role="presentation"><a href="#'.$data['id'].'" data-toggle="tab">'.$data['name'].'</a></li>';
		}
	}
	return $str;
}
public function  practice_add()
{
	$doc_id=@$_SESSION['login_id'];
	$res=$this->db->query("insert into practice_count(doctor_id) value($doc_id)");
	if($res)
	{
		return true;
	}
}


public function display_error()
{
	$doc_id=$_SESSION['login_id'];
	$res=$this->db->query("select * from error where doctor_id='$doc_id'");
	$str='';

    $str.='<div class="row contentTable " >
		<div class=" col-sm-12 table-responsive " style="height: 480px">
			<table id="blog_table" class="patientsList" >
				<thead  style="font-weight: 700">
					<tr style="color: #f8f8f8; background-color: white">
						<td>Type</td>
						<td>Subject</td>
						
						
						<td>Description</td>
						<td>Action</td>
					</tr>
				</thead>
				<tbody>';
			
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{

			$str.='<tr>                 <td>'.$data['type'].'</td>
                                        <td>'.$data['title'].'</td>
                                       
                                        
                                        <td>'.$data['error'].'</td>
                                        <td>
				    						<a href="'.base_url_doc.'edit_error.php?edit_error='.$data['id'].'"  onclick="return conf();"><div class="patient-list-buttons glyphicon glyphicon-pencil"></div></a>
				    						<a href="'.base_url_doc.'report_an_error.php?delete_error='.$data['id'].'"  onclick="return conf();"><div class="patient-list-buttons glyphicon glyphicon-trash"></div></a>
				    							</td></tr>';	
		}	
	}
	 else {
			$str.='<tr><td colspan="5">No Records Found To Display.</td></tr>';
		}
	$str.=' </tbody></table></div></div>';
	 return $str;
}



public function getallpractice()
{
	$days='';
	$days1='';
	$days_sec='';
	$days_sec1='';
	$time='';
	$time1='';
	$time_sec='';
	$time_sec1='';
	$str='';
	$doc_id=$_SESSION['login_id'];
	$res1=$this->db->query("select * from doctors where id='$doc_id'");
	$data=$res1->fetch_assoc();
	$res2=$this->db->query("select * from practice where doctor_id='$doc_id'");
			$practice=$res2->fetch_assoc();
			if($practice['monday'] != ''){
							$days.= 'Mon';
							$time=$practice['monday'] ;
						}
						else{
							$days.= '';
						}
						if($practice['tuesday'] != ''){
							$days.= ', Tue';
							$time=$practice['tuesday'] ;
						}
						else{
							$days.= '';
						}
						if($practice['wednesday'] != ''){
							$days.= ', Wed';
						}
						else{
							$days.= '';
						}
						if($practice['thursday'] != ''){
							$days.= ', Thurs';
							$time=$practice['wednesday'] ;
						}
						else{
							$days.= '';
						}
						if($practice['friday'] != ''){
							$days.= ', Fri';
							$time=$practice['friday'] ;
						}
						else{
							$days.= '';
						}
						if($practice['saturday'] != ''){
							$days.= ', Sat';
							$time=$practice['saturday'] ;
						}
						else{
							$days.= '';
						}
						if($practice['sunday'] != ''){
							$days.= ', Sun';
							$time=$practice['sunday'] ;
						}
						else{
							$days.= '';
						}if($practice['monday1'] != '')
						{
							$days1.= 'Mon';
							$time1=$practice['monday1'] ;
						}
						else{
							$days.= '';
						}
						if($practice['tuesday1'] != '')
						{
							$days1.= ', Tue';
							$time1=$practice['tuesday1'];
						}
						else{
							$days1.= '';
						}
						if($practice['wednesday1'] != ''){
							$days1.= ', Wed';
						}
						else{
							$days1.= '';
						}
						if($practice['thursday1'] != ''){
							$days1.= ', Thurs';
							$time1=$practice['wednesday1'] ;
						}
						else{
							$days1.= '';
						}
						if($practice['friday1'] != ''){
							$days1.= ', Fri';
							$time1=$practice['friday1'] ;
						}
						else{
							$days1.= '';
						}
						if($practice['saturday1'] != ''){
							$days1.= ', Sat';
							$time1=$practice['saturday1'] ;
						}
						else{
							$days1.= '';
						}
						if($practice['sunday1'] != ''){
							$days1.= ', Sun';
							$time1=$practice['sunday1'] ;
						}
						else{
							$days1.= '';
						}
						
						if($practice['monday_sec'] != ''){
							$days_sec.= 'Mon';
							$time_sec=$practice['monday_sec'] ;
						}
						else{
							$days_sec.= '';
						}
						if($practice['tuesday_sec'] != ''){
							$days_sec.= ', Tue';
							$time_sec=$practice['tuesday_sec'] ;
						}
						else{
							$days_sec.= '';
						}
						if($practice['wednesday_sec'] != ''){
							$days_sec.= ', Wed';
						}
						else{
							$days_sec.= '';
						}
						if($practice['thursday_sec'] != ''){
							$days_sec.= ', Thurs';
							$time_sec=$practice['wednesday_sec'] ;
						}
						else{
							$days_sec.= '';
						}
						if($practice['friday_sec'] != ''){
							$days_sec.= ', Fri';
							$time_sec=$practice['friday_sec'] ;
						}
						else{
							$days_sec.= '';
						}
						if($practice['saturday_sec'] != ''){
							$days_sec.= ', Sat';
							$time_sec=$practice['saturday_sec'] ;
						}
						else{
							$days_sec.= '';
						}
						if($practice['sunday_sec'] != ''){
							$days_sec.= ', Sun';
							$time_sec=$practice['sunday_sec'] ;
						}
                      	
                      	if($practice['monday_sec1'] != ''){
							$days_sec1.= 'Mon';
							$time_sec1=$practice['monday_sec1'] ;
						}
						else{
							$days_sec1.= '';
						}
						if($practice['tuesday_sec1'] != ''){
							$days_sec1.= ', Tue';
							$time_sec1=$practice['tuesday_sec1'] ;
						}
						else{
							$days_sec1.= '';
						}
						if($practice['wednesday_sec1'] != ''){
							$days_sec1.= ', Wed';
						}
						else{
							$days_sec1.= '';
						}
						if($practice['thursday_sec1'] != ''){
							$days_sec1.= ', Thurs';
							$time_sec1=$practice['wednesday_sec1'] ;
						}
						else{
							$days_sec1.= '';
						}
						if($practice['friday_sec1'] != ''){
							$days_sec1.= ', Fri';
							$time_sec1=$practice['friday_sec1'] ;
						}
						else{
							$days_sec1.= '';
						}
						if($practice['saturday_sec1'] != ''){
							$days_sec1.= ', Sat';
							$time_sec1=$practice['saturday_sec1'] ;
						}
						else{
							$days_sec1.= '';
						}
						if($practice['sunday_sec1'] != ''){
							$days_sec1.= ', Sun';
							$time_sec1=$practice['sunday_sec1'] ;
						}
						else{
							$days_sec1.= '';
						}
			$str.='<div class="card" style="min-height: auto !important">
                        <div class="header bg-cyan">
                            <h2>
                              Practice Time & Consultation Fee                     </h2>
                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown view_more">
                                   <a href="'.base_url_doc.'profile/?edit_practice_doctor=true&practice_id=0">Edit</a>
                                   
                                </li>
                            </ul>
                        </div>
                        <div class="body" style="height: 330px ">
                          <div class="profile_div" style="font-size:15px;">
                         <h4>Timing </h4>
                         <h5>SESSION FRIST</h5>
                         '.$days.' <br> '.$time.' <BR>
                         <h5>SESSION SECOND</h5>
                         '.$days_sec.' <br> '.$time_sec.'

                          </div>
                          
                           <div class="profile_div"> 
                          <a href="'.base_url_doc.'profile/?edit_practice_doctor=true&practice_id=0">Edit Appointment Slot</a><br> 
                         '. $practice['duration'].' Minutes
                           </div>
                           
                           <div class="profile_div1" style="font-size:15px;">
                          <h4>Timing </h4>
                         <h5>SESSION FRIST</h5>
                         '.$days1.' <br> '.$time1.' <BR>
                         <h5>SESSION SECOND</h5>
                         '.$days_sec1.' <br> '.$time_sec1.'';
                     
                   
                     
                     
                   $str.='<br>
                         
                          </div>
                        </div>
                    </div>';
	
	$count=1;
	
	

	/*if($res->num_rows> 0)
	{
		while($data1=$res->fetch_assoc())
		{
			$days='';
	$days1='';
	$days_sec='';
	$days_sec1='';
	$time='';
	$time1='';
	$time_sec='';
	$time_sec1='';
			$count++;
			$res2=$this->db->query("select * from practice where practice_id='".$data1['id']."'");
			$practice=$res2->fetch_assoc();
			if($practice['monday'] != ''){
							$days.= 'Mon';
							$time=$practice['monday'] ;
						}
						else{
							$days.= '';
						}
						if($practice['tuesday'] != ''){
							$days.= ', Tue';
							$time=$practice['tuesday'] ;
						}
						else{
							$days.= '';
						}
						if($practice['wednesday'] != ''){
							$days.= ', Wed';
						}
						else{
							$days.= '';
						}
						if($practice['thursday'] != ''){
							$days.= ', Thurs';
							$time=$practice['wednesday'] ;
						}
						else{
							$days.= '';
						}
						if($practice['friday'] != ''){
							$days.= ', Fri';
							$time=$practice['friday'] ;
						}
						else{
							$days.= '';
						}
						if($practice['saturday'] != ''){
							$days.= ', Sat';
							$time=$practice['saturday'] ;
						}
						else{
							$days.= '';
						}
						if($practice['sunday'] != ''){
							$days.= ', Sun';
							$time=$practice['sunday'] ;
						}
						else{
							$days.= '';
						}if($practice['monday1'] != ''){
							$days1.= 'Mon';
							$time1=$practice['monday1'] ;
						}
						else{
							$days.= '';
						}
						if($practice['tuesday1'] != ''){
							$days1.= ', Tue';
							$time1=$practice['tuesday1'] ;
						}
						else{
							$days1.= '';
						}
						if($practice['wednesday1'] != ''){
							$days1.= ', Wed';
						}
						else{
							$days1.= '';
						}
						if($practice['thursday1'] != ''){
							$days1.= ', Thurs';
							$time1=$practice['wednesday1'] ;
						}
						else{
							$days1.= '';
						}
						if($practice['friday1'] != ''){
							$days1.= ', Fri';
							$time1=$practice['friday1'] ;
						}
						else{
							$days1.= '';
						}
						if($practice['saturday1'] != ''){
							$days1.= ', Sat';
							$time1=$practice['saturday1'] ;
						}
						else{
							$days1.= '';
						}
						if($practice['sunday1'] != ''){
							$days1.= ', Sun';
							$time1=$practice['sunday1'] ;
						}
						else{
							$days1.= '';
						}
						
						if($practice['monday_sec'] != ''){
							$days_sec.= 'Mon';
							$time_sec=$practice['monday_sec'] ;
						}
						else{
							$days_sec.= '';
						}
						if($practice['tuesday_sec'] != ''){
							$days_sec.= ', Tue';
							$time_sec=$practice['tuesday_sec'] ;
						}
						else{
							$days_sec.= '';
						}
						if($practice['wednesday_sec'] != ''){
							$days_sec.= ', Wed';
						}
						else{
							$days_sec.= '';
						}
						if($practice['thursday_sec'] != ''){
							$days_sec.= ', Thurs';
							$time_sec=$practice['wednesday_sec'] ;
						}
						else{
							$days_sec.= '';
						}
						if($practice['friday_sec'] != ''){
							$days_sec.= ', Fri';
							$time_sec=$practice['friday_sec'] ;
						}
						else{
							$days_sec.= '';
						}
						if($practice['saturday_sec'] != ''){
							$days_sec.= ', Sat';
							$time_sec=$practice['saturday_sec'] ;
						}
						else{
							$days_sec.= '';
						}
						if($practice['sunday_sec'] != ''){
							$days_sec.= ', Sun';
							$time_sec=$practice['sunday_sec'] ;
						}
                      	
                      	if($practice['monday_sec1'] != ''){
							$days_sec1.= 'Mon';
							$time_sec1=$practice['monday_sec1'] ;
						}
						else{
							$days_sec1.= '';
						}
						if($practice['tuesday_sec1'] != ''){
							$days_sec1.= ', Tue';
							$time_sec1=$practice['tuesday_sec1'] ;
						}
						else{
							$days_sec1.= '';
						}
						if($practice['wednesday_sec1'] != ''){
							$days_sec1.= ', Wed';
						}
						else{
							$days_sec1.= '';
						}
						if($practice['thursday_sec1'] != ''){
							$days_sec1.= ', Thurs';
							$time_sec1=$practice['wednesday_sec1'] ;
						}
						else{
							$days_sec1.= '';
						}
						if($practice['friday_sec1'] != ''){
							$days_sec1.= ', Fri';
							$time_sec1=$practice['friday_sec1'] ;
						}
						else{
							$days_sec1.= '';
						}
						if($practice['saturday_sec1'] != ''){
							$days_sec1.= ', Sat';
							$time_sec1=$practice['saturday_sec1'] ;
						}
						else{
							$days_sec1.= '';
						}
						if($practice['sunday_sec1'] != ''){
							$days_sec1.= ', Sun';
							$time_sec1=$practice['sunday_sec1'] ;
						}
						else{
							$days_sec1.= '';
						}
			$str.='<div class="card">
                        <div class="header bg-cyan">
                            <h2>
                           Practice '.$count.'                           </h2>
                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="'.base_url_doc.'profile/?edit_practice_doctor=true&practice_id='.$data1['id'].'">Edit</a></li>
                                        <li><a href="'. base_url_doc .'profile/?add_practice=true">Add More</a></li>
                                     <li><a href="'. base_url_doc .'profile/?delete_practice=true&practice_id='.$data1['id'].'">Delete</a></li>
                                        
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="body" style="height: 330px ">
                          <div class="profile_div" style="font-size:15px;">
                         <h4>Timing </h4>
                         <h5>SESSION FRIST</h5>
                         '.$days.' <br> '.$time.' <BR>
                         <h5>SESSION SECOND</h5>
                         '.$days_sec.' <br> '.$time_sec.'

                          </div>
                          
                           <div class="profile_div"> 
                          <a href="'.base_url_doc.'profile/?edit_practice_doctor=true&practice_id='.$data1['id'].'">Edit Appointment Slot</a><br> 
                         '. $practice['duration'].' Minutes
                           </div>
                           
                           <div class="profile_div1" style="font-size:15px;">
                          <h4>Timing </h4>
                         <h5>SESSION FRIST</h5>
                         '.$days1.' <br> '.$time1.' <BR>
                         <h5>SESSION SECOND</h5>
                         '.$days_sec1.' <br> '.$time_sec1.'';
                     
                   
                     
                     
                   $str.='<br>
                         
                          </div>
                        </div>
                    </div>';
		}
	}  */
	return $str;
}
public function delete_practice($practice_id)
{
	$res=$this->db->query("delete from  practice_count where id='$practice_id'");
	
	if($res)
	{
		$res1=$this->db->query("delect from practice where practice_id='$practice_id'");
		if($res1)
		{
			
		}
	}
	return true;
}
public function clinic_practice()
{
	$doc_id=@$_SESSION['login_id'];
	$res=$this->db->query("select  * from clinic where doctor_id='$doc_id'");
	$str='';
	if($res->num_rows>0)
	{
		while($data=$res->fetch_assoc())
		{
			$data2=$this->getpractice_detail_clinic($data['id']);
	       $data3=$this->getbyId($_SESSION['login_id'], 'doctors'); 
			$str.='  <div role="tabpanel" class="tab-pane animated fadeInRight " id="'.$data['id'].'">
                                        
                                        
                                        
                                            <form  method="post" enctype="multipart/form-data">
                                 
                               <div class="col-sm-6">
                             <div class="form-group form-float">
                              <label class="form-label">Appointment Duration</label>
                                    <div class="form-line">
                                      <select name="duration">
                                      	<option value="15"';  if($data2['duration']=="15")  $str.= "selected";  $str.='> 15 MIN </option>
                                      	<option value="20" ';  if($data2['duration']=="20")  $str.= "selected";$str.='> 20 MIN </option>
                                      	<option value="30" ';  if($data2['duration']=="30")  $str.= "selected"; $str.='> 30 MIN </option>
                                      	<option value="60"';  if($data2['duration']=="60")  $str.= "selected"; $str.='> 1 Hour </option>
                                      	<option value="120" ';  if($data2['duration']=="120")  $str.= "selected"; $str.='> 2 Hours </option>
                                      </select>
                                      
                                    </div>
                                </div>	
                               </div>
                                <div class="col-sm-6">
                             <div class="form-group form-float">
                              <label class="form-label">Consult Fee</label>
                                    <div class="form-line">
                                  <input type="text" name="consult_fee" value="'.$data2['consult'].'">
                                      
                                    </div>
                                </div>	
                               </div>
                               
                               <div style="clear: both;"></div>
                               <input type="hidden" name="clinic_id" value="'.$data['id'].'">
                               
                              <div style="clear: both;"></div>
                             
                                <div class="form-group form-float">
                             
                                    <div class="form-line">
                                      <div class="demo-checkbox">
                               
                                
                                <div class="col-sm-1 my-session-format">
                                
                              
                                
                                <input type="checkbox" id="md_checkbox_mo'.$data['id'].'" class="chk-col-pink monday-check" name="mon" onclick="check_checkbox_mo_'.$data['id'].'()"
                                 value="Mon"';if($data2['monday'] == ''){  $str.= ""; } else {  $str.= "checked"; }$str.='  >
                                <label for="md_checkbox_mo'.$data['id'].'"> Mon</label>
                                
                            
                                
                                </div><!--Monday-->
                                
                                <div class="col-sm-1 my-session-format">
                                
                                <input type="checkbox" id="md_checkbox_tu'.$data['id'].'" class="chk-col-pink" name="tue" onclick="check_checkbox_tu_'.$data['id'].'()"
                                value="Tue" '; if(@$data2['tuesday'] == '' ){ $str.= ""; } else { $str.= "checked"; }$str.=' >
                                <label for="md_checkbox_tu'.$data['id'].'"> Tue</label>
                                
                                </div><!--Tuesday-->
                                 
                                <div class="col-sm-1 my-session-format">
                                
                               
                                
                                <input type="checkbox" id="md_checkbox_we'.$data['id'].'" class="chk-col-pink" name="wed" onclick="check_checkbox_we_'.$data['id'].'()"
                                value="Wed"'; if(@$data2['wednesday'] == ''){ $str.= ""; } else { $str.= "checked"; }$str.='  >
                                <label for="md_checkbox_we'.$data['id'].'"> Wed</label>
                                
                              
                                
                              </div>

								<div class="col-sm-1 my-session-format">
                                
                               
                                <input type="checkbox" id="md_checkbox_th'.$data['id'].'" class="chk-col-pink" name="thu" onclick="check_checkbox_th_'.$data['id'].'()"
                                value="Thu"'; if(@$data2['thursday'] =='' ){ $str.= ""; } else { $str.="checked"; }$str.='  >
                                <label for="md_checkbox_th'.$data['id'].'"> Thu</label>
                                
                         
                                
                                
                                </div><!--Thursday-->

								<div class="col-sm-1 my-session-format">
                                
                               
                                <input type="checkbox" id="md_checkbox_fr'.$data['id'].'" class="chk-col-pink" name="fri"  onclick="check_checkbox_fr_'.$data['id'].'()"
                                value="Fri"'; if(@$data2['friday'] == '' ) {  $str.= ""; } else {  $str.= "checked"; }$str.='  >
                                <label for="md_checkbox_fr'.$data['id'].'"> Fri</label>
                               
                                </div><!--Friday-->

								<div class="col-sm-1 my-session-format">
                                
                              
                                <input type="checkbox" id="md_checkbox_sa'.$data['id'].'" class="chk-col-pink" name="sat"  onclick="check_checkbox_sa_'.$data['id'].'()"
                                value="Sat"';if(@$data2['saturday'] == '' ) {  $str.= ""; } else {  $str.= "checked"; }$str.='  >
                                <label for="md_checkbox_sa'.$data['id'].'"> Sat</label>
                               
                                </div><!--Saturday-->

								<div class="col-sm-1 my-session-format">
                                
                               
                                <input type="checkbox" id="md_checkbox_sun'.$data['id'].'" class="chk-col-pink" name="sun"  onclick="check_checkbox_sun_'.$data['id'].'()"
                                value="Sun"'; if($data2['sunday'] == '' ) {  $str.= ""; } else {  $str.= "checked"; }
                                
                              $str.=' />
                                <label for="md_checkbox_sun'.$data['id'].'"> Sun</label>
                                
                               
                                
                                </div><!--Sunday-->
                               
                               
                                
                            </div>
                                    </div>
                                </div>
                                 
                                 <div style="clear: both"></div>
                                 
                                 
                              <div class="form-group form-float" style="width: auto;">
                               <label class="form-label">Session 1</label>
                                     <div class="form-line">
                              <div class="col-sm-12">
                                <label> From : </label>
                                    '; 
                                    $time='';
                                    $time1='';
                                    $time2='';
                                    $time3='';
                                    if(!empty($data2['monday']))
                                    {
										$time=explode("-",$data2['monday']);
									} if(!empty($data2['tuesday']))
                                    {
										$time=explode("-",$data2['tuesday']);
									} if(!empty($data2['wednesday']))
                                    {
										$time=explode("-",$data2['wednesday']);
									} if(!empty($data2['thursday']))
                                    {
										$time=explode("-",$data2['thursday']);
									} if(!empty($data2['friday']))
                                    {
										$time=explode("-",$data2['friday']);
									} if(!empty($data2['saturday']))
                                    {
										$time=explode("-",$data2['saturday']);
									}
                                       $time1=explode(" ",@$time[0]);
                                       $time2=explode(" ",@$time[1]);
                                      $time3=explode(".",@$time1[0]); 
                                        
                                       $time4=explode(".",@$time2[0]); 
                                      
                                       $h=@$time3[0];
                                       $h_sec=@$time4[0];
                                       $min_sec=@$time4[1];
                                       $m=@$time3[1];
                                       
                                       $am=@$time1[1];
                                       $am_sec=@$time2[1]; 
                                       if(!empty($data2['monday_sec']))
                                    	{
										$time_sec=explode("-",$data2['monday_sec']);
										} if(!empty($data2['tuesday_sec']))
                                    	{
										$time_sec=explode("-",$data2['tuesday_sec']);
										} if(!empty($data2['wednesday_sec']))
                                    	{
										$time_sec=explode("-",$data2['wednesday_sec']);
										}
										 if(!empty($data2['thursday_sec']))
                                   		 {
										$time_sec=explode("-",$data2['thursday_sec']);
										} if(!empty($data2['friday_sec']))
                                   		 {
										$time_sec=explode("-",$data2['friday_sec']);
										} if(!empty($data2['saturday_sec']))
                                    	{
										$time_sec=explode("-",$data2['saturday_sec']);
										}
                                       $time_sec1=explode(" ",@$time_sec[0]);
                                       $time_sec2=explode(" ",@$time_sec[1]);
                                      $time_sec3=explode(".",@$time_sec1[0]); 
                                        
                                       $time_sec4=explode(".",@$time_sec2[0]); 
                                      
                                       $h_sd=@$time_sec3[0];
                                       $h_sec_sd=@$time_sec4[0];
                                       $min_sec_sd=@$time_sec4[1];
                                       $m_sd=@$time_sec3[1];
                                       $am_sd=@$time_sec1[1];
                                       $am_sec_sd=@$time_sec2[1];;
                                     
									
                                
                                       $str.=' <select  name="hours" id="first_session_time_f_'.$data['id'].'">
                                   <option value="">Select From Time</option>
                                     <option value="1" '; if(@$h=="1")  $str.= "selected"; $str.='>1</option>
                                     <option value="2" '; if(@$h=="2")  $str.= "selected";  $str.='>2</option>
                                     <option value="3" '; if(@$h=="3")  $str.= "selected";  $str.='>3</option>
                                     <option value="4" '; if(@$h=="4")  $str.= "selected";  $str.='>4</option>
                                     <option value="5" '; if(@$h=="5")  $str.= "selected";  $str.='>5</option>
                                     <option value="6" '; if(@$h=="6")  $str.= "selected";  $str.='>6</option>
                                     <option value="7" '; if(@$h=="7")  $str.= "selected";  $str.='>7</option>
                                     <option value="8" '; if(@$h=="8")  $str.= "selected";  $str.='>8</option>
                                     <option value="9" '; if(@$h=="9")  $str.= "selected";  $str.='>9</option>
                                     <option value="10" '; if(@$h=="10")  $str.= "selected";  $str.='>10</option>
                                     <option value="11" '; if(@$h=="11")  $str.= "selected";  $str.='>11</option>                                   <option value="12" '; if(@$h=="12")  $str.= "selected";  $str.='>12</option>
                                    
                            </select> 
                                     <select  name="min" id="first_session_min_'.$data['id'].'">
                                    <option value="w">Select From Min</option>
                                     <option value="00" '; if(@$m=="00")  $str.= "selected";  $str.='>00</option> 
                                     <option value="05" '; if(@$m=="05")  $str.= "selected";  $str.='>05</option>
                                     <option value="10" '; if(@$m=="10")  $str.= "selected";  $str.='>10</option>
                                     <option value="15" '; if(@$m=="15")  $str.= "selected";  $str.='>15</option>
                                     <option value="20" '; if(@$m=="20")  $str.= "selected";  $str.='>20</option>
                                     <option value="25" '; if(@$m=="25")  $str.= "selected";  $str.='>25</option>
                                     <option value="30" '; if(@$m=="30")  $str.= "selected";  $str.='>30</option>
                                     <option value="35" '; if(@$m=="35")  $str.= "selected";  $str.='>35</option>
                                     <option value="40" '; if(@$m=="40")  $str.= "selected";  $str.='>40</option>
                                     <option value="45" '; if(@$m=="45")  $str.= "selected";  $str.='>45</option>
                                     <option value="50" '; if(@$m=="50")  $str.= "selected";  $str.='>50</option>
                                     <option value="55" '; if(@$m=="55")  $str.= "selected";  $str.='>55</option>                                   
                                    
                            </select> 
                            
                             <select  name="am_pm" id="first_session_am_'.$data['id'].'">
                            
                              <option value="w">Select From AM-PM</option>
                                     <option value="AM" '; if(@$am=="AM")  $str.= "selected";  $str.='>AM</option> 
                                     <option value="PM" '; if(@$am=="PM")  $str.= "selected";  $str.='>PM</option>
                            </select> 
                            </div>
                            <div class="col-sm-12">
                                
                                     <label> To : </label>
                                    
                                        <select  name="hours_to" id="first_session_time_t_'.$data['id'].'">
                                   <option value="">Select To Time</option>
                                     <option value="1" '; if(@$h_sec=="1")  $str.= "selected";  $str.='>1</option>
                                     <option value="2" '; if(@$h_sec=="2")  $str.= "selected";  $str.='>2</option>
                                     <option value="3" '; if(@$h_sec=="3")  $str.= "selected";  $str.='>3</option>
                                     <option value="4" '; if(@$h_sec=="4")  $str.= "selected";  $str.='>4</option>
                                     <option value="5" '; if(@$h_sec=="5")  $str.= "selected";  $str.='>5</option>
                                     <option value="6" '; if(@$h_sec=="6")  $str.= "selected";  $str.='>6</option>
                                     <option value="7" '; if(@$h_sec=="7")  $str.= "selected";  $str.='>7</option>
                                     <option value="8" '; if(@$h_sec=="8")  $str.= "selected";  $str.='>8</option>
                                     <option value="9" '; if(@$h_sec=="9")  $str.= "selected";  $str.='>9</option>
                                     <option value="10" '; if(@$h_sec=="10")  $str.= "selected";  $str.='>10</option>
                                     <option value="11" '; if(@$h_sec=="11")  $str.= "selected";  $str.='>11</option>                                   <option value="12" '; if(@$h_sec=="12")  $str.= "selected";  $str.='>12</option>
                                    
                            </select> 
                                     <select  name="min_to" id="first_session_min_t_'.$data['id'].'">
                                    <option value="w">Select From Min</option>
                                     <option value="00" '; if(@$min_sec=="00")  $str.= "selected";  $str.='>00</option> 
                                     <option value="05" '; if(@$min_sec=="05")  $str.= "selected";  $str.='>05</option>
                                     <option value="10" '; if(@$min_sec=="10")  $str.= "selected";  $str.='>10</option>
                                     <option value="15" '; if(@$min_sec=="15")  $str.= "selected";  $str.='>15</option>
                                     <option value="20" '; if(@$min_sec=="20")  $str.= "selected";  $str.='>20</option>
                                     <option value="25" '; if(@$min_sec=="25")  $str.= "selected";  $str.='>25</option>
                                     <option value="30" '; if(@$min_sec=="30")  $str.= "selected";  $str.='>30</option>
                                     <option value="35" '; if(@$min_sec=="35")  $str.= "selected";  $str.='>35</option>
                                     <option value="40" '; if(@$min_sec=="40")  $str.= "selected";  $str.='>40</option>
                                     <option value="45" '; if(@$min_sec=="45")  $str.= "selected";  $str.='>45</option>
                                     <option value="50" '; if(@$min_sec=="50")  $str.= "selected";  $str.='>50</option>
                                     <option value="55" '; if(@$min_sec=="55")  $str.= "selected";  $str.='>55</option>                                   
                                    
                            </select> 
                             <select  name="am_pm_to" id="first_session_am_t_'.$data['id'].'">
                              <option value="w">Select From AM-PM</option>
                                     <option value="AM" '; if(@$am_sec=="AM")  $str.= "selected";  $str.='>AM</option> 
                                     <option value="PM" '; if(@$am_sec=="PM")  $str.= "selected";  $str.='>PM</option>
                            </select> 
                            </div>
                            </div>
                            </div>
                            <div style="clear: both"></div>
                                <div class="form-group form-float">
                              <label class="form-label">Session 2</label>
                                     <div class="form-line">
                                      <div class="form-group form-float" style="width: auto;">
                              <div class="col-sm-12">
                                <label> From : </label>
                                    
                                        <select  name="hours_sec" id="sec_session_time_f_'.$data['id'].'">
                                   <option value="">Select From Time</option>
                                     <option value="1" '; if(@$h_sd=="1")  $str.= "selected";  $str.='>1</option>
                                     <option value="2" '; if(@$h_sd=="2")  $str.= "selected";  $str.='>2</option>
                                     <option value="3" '; if(@$h_sd=="3")  $str.= "selected";  $str.='>3</option>
                                     <option value="4" '; if(@$h_sd=="4")  $str.= "selected";  $str.='>4</option>
                                     <option value="5" '; if(@$h_sd=="5")  $str.= "selected";  $str.='>5</option>
                                     <option value="6" '; if(@$h_sd=="6")  $str.= "selected";  $str.='>6</option>
                                     <option value="7" '; if(@$h_sd=="7")  $str.= "selected";  $str.='>7</option>
                                     <option value="8" '; if(@$h_sd=="8")  $str.= "selected";  $str.='>8</option>
                                     <option value="9" '; if(@$h_sd=="9")  $str.= "selected";  $str.='>9</option>
                                     <option value="10" '; if(@$h_sd=="10")  $str.= "selected";  $str.='>10</option>
                                     <option value="11" '; if(@$h_sd=="11")  $str.= "selected";  $str.='>11</option>                                   <option value="12" '; if(@$h_sd=="12")  $str.= "selected";  $str.='>12</option>
                                    
                            </select> 
                                     <select  name="min_sec" id="sec_session_min_f_'.$data['id'].'">
                                    <option value="w">Select From Min</option>
                                     <option value="00" '; if(@$m_sd=="00")  $str.= "selected";  $str.='>00</option> 
                                     <option value="05" '; if(@$m_sd=="05")  $str.= "selected";  $str.='>05</option>
                                     <option value="10" '; if(@$m_sd=="10")  $str.= "selected";  $str.='>10</option>
                                     <option value="15" '; if(@$m_sd=="15")  $str.= "selected";  $str.='>15</option>
                                     <option value="20" '; if(@$m_sd=="20")  $str.= "selected";  $str.='>20</option>
                                     <option value="25" '; if(@$m_sd=="25")  $str.= "selected";  $str.='>25</option>
                                     <option value="30" '; if(@$m_sd=="30")  $str.= "selected";  $str.='>30</option>
                                     <option value="35" '; if(@$m_sd=="35")  $str.= "selected";  $str.='>35</option>
                                     <option value="40" '; if(@$m_sd=="40")  $str.= "selected";  $str.='>40</option>
                                     <option value="45" '; if(@$m_sd=="45")  $str.= "selected";  $str.='>45</option>
                                     <option value="50" '; if(@$m_sd=="50")  $str.= "selected";  $str.='>50</option>
                                     <option value="55" '; if(@$m_sd=="55")  $str.= "selected";  $str.='>55</option>                                   
                                    
                            </select> 
                             <select  name="am_pm_sec" id="sec_session_am_f_'.$data['id'].'">
                             <option value="w">Select From AM-PM</option>
                                     <option value="AM" '; if(@$am_sd=="AM")  $str.= "selected";  $str.='>AM</option> 
                                     <option value="PM" '; if(@$am_sd=="PM")  $str.= "selected";  $str.='>PM</option>
                            </select> 
                            </div>
                            <div class="col-sm-12">
                                
                                     <label> To : </label>
                                    
                                        <select  name="hours_to_sec" id="sec_session_time_t_'.$data['id'].'">
                                   <option value="">Select To Time</option>
                                     <option value="1" '; if(@$h_sec_sd=="1")  $str.= "selected";  $str.='>1</option>
                                     <option value="2" '; if(@$h_sec_sd=="2")  $str.= "selected";  $str.='>2</option>
                                     <option value="3" '; if(@$h_sec_sd=="3")  $str.= "selected";  $str.='>3</option>
                                     <option value="4" '; if(@$h_sec_sd=="4")  $str.= "selected";  $str.='>4</option>
                                     <option value="5" '; if(@$h_sec_sd=="5")  $str.= "selected";  $str.='>5</option>
                                     <option value="6" '; if(@$h_sec_sd=="6")  $str.= "selected";  $str.='>6</option>
                                     <option value="7" '; if(@$h_sec_sd=="7")  $str.= "selected";  $str.='>7</option>
                                     <option value="8" '; if(@$h_sec_sd=="8")  $str.= "selected";  $str.='>8</option>
                                     <option value="9" '; if(@$h_sec_sd=="9")  $str.= "selected";  $str.='>9</option>
                                     <option value="10" '; if(@$h_sec_sd=="10")  $str.= "selected";  $str.='>10</option>
                                     <option value="11" '; if(@$h_sec_sd=="11")  $str.= "selected";  $str.='>11</option>                                   <option value="12" '; if(@$h_sec_sd=="12")  $str.= "selected";  $str.='>12</option>
                                    
                            </select> 
                                     <select  name="min_to_sec"  id="sec_session_min_t_'.$data['id'].'">
                                    <option value="w">Select From Min</option>
                                     <option value="00" '; if(@$min_sec_sd=="00")  $str.= "selected";  $str.='>00</option> 
                                     <option value="05" '; if(@$min_sec_sd=="05")  $str.= "selected";  $str.='>05</option>
                                     <option value="10" '; if(@$min_sec_sd=="10")  $str.= "selected";  $str.='>10</option>
                                     <option value="15" '; if(@$min_sec_sd=="15")  $str.= "selected";  $str.='>15</option>
                                     <option value="20" '; if(@$min_sec_sd=="20")  $str.= "selected";  $str.='>20</option>
                                     <option value="25" '; if(@$min_sec_sd=="25")  $str.= "selected";  $str.='>25</option>
                                     <option value="30" '; if(@$min_sec_sd=="30")  $str.= "selected";  $str.='>30</option>
                                     <option value="35" '; if(@$min_sec_sd=="35")  $str.= "selected";  $str.='>35</option>
                                     <option value="40" '; if(@$min_sec_sd=="40")  $str.= "selected";  $str.='>40</option>
                                     <option value="45" '; if(@$min_sec_sd=="45")  $str.= "selected";  $str.='>45</option>
                                     <option value="50" '; if(@$min_sec_sd=="50")  $str.= "selected";  $str.='>50</option>
                                     <option value="55" '; if(@$min_sec_sd=="55")  $str.= "selected";  $str.='>55</option>                                    
                            </select> 
                             <select  name="am_pm_to_sec" id="sec_session_am_t_'.$data['id'].'">
                             <option value="w">Select From AM-PM</option>
                                     <option value="AM" '; if(@$am_sec_sd=="AM")  $str.= "selected";  $str.='>AM</option> 
                                     <option value="PM" '; if(@$am_sec_sd=="PM")  $str.= "selected";  $str.='>PM</option>
                            </select> 
                            </div>
                            </div>
                            
                            </div>
                            </div>
                                                              <div style="clear: both;"></div>';
                                                              
    //    <!-- **************************** Timing 2 Start ****************************--> 
             
                                   if(!empty($data2['monday1']))
                                    {
										$time7=explode("-",$data2['monday1']);
									} if(!empty($data2['tuesday1']))
                                    {
										$time7=explode("-",$data2['tuesday1']);
									} if(!empty($data2['wednesday1']))
                                    {
										$time7=explode("-",$data2['wednesday1']);
									} if(!empty($data2['thursday1']))
                                    {
										$time7=explode("-",$data2['thursday1']);
									} if(!empty($data2['friday1']))
                                    {
										$time7=explode("-",$data2['friday1']);
									} if(!empty($data2['saturday1']))
                                    {
										$time7=explode("-",$data2['saturday1']);
									}
									if(!empty($data2['sunday1']))
                                    {
										$time7=explode("-",$data2['sunday1']);
									}
                                       $time11=explode(" ",@$time7[0]);
                                       $time21=explode(" ",@$time7[1]);
                                      $time31=explode(".",@$time11[0]); 
                                        
                                       $time41=explode(".",@$time21[0]); 
                                      
                                       $h1=@$time31[0];
                                       
                                       $h_sec1=@$time41[0];
                                       $min_sec1=@$time41[1];
                                       $m1=@$time31[1];
                                       $am1=@$time11[1];
                                       $am_sec1=@$time21[1]; 
                                       if(!empty($data21['monday_sec1']))
                                    	{
										$time_sec7=explode("-",$data2['monday_sec1']);
										} if(!empty($data2['tuesday_sec1']))
                                    	{
										$time_sec7=explode("-",$data2['tuesday_sec1']);
										} if(!empty($data2['wednesday_sec1']))
                                    	{
										$time_sec7=explode("-",$data2['wednesday_sec1']);
										}
										 if(!empty($data2['thursday_sec1']))
                                    {
										$time_sec7=explode("-",$data2['thursday_sec1']);
									} if(!empty($data2['friday_sec1']))
                                    {
										$time_sec7=explode("-",$data2['friday_sec1']);
									} if(!empty($data2['saturday_sec1']))
                                    {
										$time_sec7=explode("-",$data2['saturday_sec1']);
									}
									if(!empty($data2['sunday_sec1']))
                                    {
										$time_sec7=explode("-",$data2['sunday_sec1']);
									}
                                       $time_sec11=explode(" ",@$time_sec7[0]);
                                       $time_sec21=explode(" ",@$time_sec7[1]);
                                      $time_sec31=explode(".",@$time_sec11[0]); 
                                        
                                       $time_sec41=explode(".",@$time_sec21[0]); 
                                      
                                       $h_sd1=@$time_sec31[0];
                                       $h_sec_sd1=@$time_sec41[0];
                                       $min_sec_sd1=@$time_sec41[1];
                                       $m_sd1=@$time_sec31[1];
                                       $am_sd1=@$time_sec11[1];
                                       $am_sec_sd1=@$time_sec21[1];
                                     
								
       $str.=' <div style="width:100%;  padding: 10px;background: #f5f5f5;font-size:20px;font-weight: bold"> Timing 2  </div>
                                  <div style="clear: both;"></div>
                               
                                <div class="form-group form-float">
                             
                                    <div class="form-line">
                                      <div class="demo-checkbox">
                               
                                <div class="col-sm-1 my-session-format">
                                
                                <input type="checkbox" id="md_checkbox_mo1'.$data['id'].'" class="chk-col-pink monday-check" name="mon1" onclick="check_checkbox_mo1_'.$data['id'].'()"
                                 value="Mon"'; if($data2['monday1'] == ''){  $str.= ""; } else {  $str.= "checked"; } $str.='  >
                                <label for="md_checkbox_mo1'.$data['id'].'"> Mon</label>
                               
                                
                                </div>
                                
                                <div class="col-sm-1 my-session-format">
                              
                                <input type="checkbox" id="md_checkbox_tu1'.$data['id'].'" class="chk-col-pink" name="tue1"  onclick="check_checkbox_tu1_'.$data['id'].'()"
                                value="Tue" '; if(@$data2['tuesday1'] == '' ){  $str.= ""; } else {  $str.= "checked"; } $str.=' >
                                <label for="md_checkbox_tu1'.$data['id'].'"> Tue</label>
                                
                               
                                                   </div>
                                                                 <div class="col-sm-1 my-session-format">
                               
                                <input type="checkbox" id="md_checkbox_we1'.$data['id'].'" class="chk-col-pink" name="wed1"  onclick="check_checkbox_we1_'.$data['id'].'()"
                                value="Wed" '; if(@$data2['wednesday1'] == ''){  $str.= ""; } else {  $str.= "checked"; } $str.='  >
                                <label for="md_checkbox_we1'.$data['id'].'"> Wed</label>
                               
                              </div>

								<div class="col-sm-1 my-session-format">
                                
                                <input type="checkbox" id="md_checkbox_th1'.$data['id'].'" class="chk-col-pink" name="thu1"  onclick="check_checkbox_th1_'.$data['id'].'()"
                                value="Thu" '; if(@$data2['thursday1'] =='' ){  $str.= ""; } else {  $str.= "checked"; } $str.='  >
                                <label for="md_checkbox_th1'.$data['id'].'"> Thu</label>
                               
                                
                                </div><!--Thursday-->

								<div class="col-sm-1 my-session-format">
                                
                                <input type="checkbox" id="md_checkbox_fr1'.$data['id'].'" class="chk-col-pink" name="fri1"  onclick="check_checkbox_fr1_'.$data['id'].'()"
                                value="Fri" '; if(@$data2['friday1'] == '' ) {  $str.= ""; } else {  $str.= "checked"; } $str.='  >
                                <label for="md_checkbox_fr1'.$data['id'].'"> Fri</label>
                                
                                
                                </div><!--Friday-->

								<div class="col-sm-1 my-session-format">
                               
                                <input type="checkbox" id="md_checkbox_sa1'.$data['id'].'" class="chk-col-pink" name="sat1"  onclick="check_checkbox_sa1_'.$data['id'].'()"
                                value="Sat" '; if(@$data2['saturday1'] == '' ) {  $str.= ""; } else {  $str.= "checked"; } $str.='  >
                                <label for="md_checkbox_sa1'.$data['id'].'"> Sat</label>
                               
                              
                           
                                
                                </div>
                                
								<div class="col-sm-1 my-session-format">
                               
                                <input type="checkbox" id="md_checkbox_su1'.$data['id'].'" class="chk-col-pink" name="sun1"  onclick="check_checkbox_sun1_'.$data['id'].'()"
                                value="Sat" '; if(@$data2['sunday1'] == '' ) {  $str.= ""; } else {  $str.= "checked"; } $str.='  >
                                <label for="md_checkbox_su1'.$data['id'].'"> Sun</label>
                               
                               
                           
                                
                                </div>

                            </div>
                                    </div>
                                </div>
                                
                                 <div style="clear: both"></div>
                               
                                 
                              <div class="form-group form-float" style="width: auto;">
                               <label class="form-label">Session 1</label>
                                     <div class="form-line">
                              <div class="col-sm-12">
                                <label> From : </label>
                                    
                                        <select  name="hours1" id="tim_sec_time_f_'.$data['id'].'">
                                  <option value="">Select From Time</option>
                                     <option value="1" '; if(@$h1=="1")  $str.= "selected";  $str.='>1</option>
                                     <option value="2" '; if(@$h1=="2")  $str.= "selected";  $str.='>2</option>
                                     <option value="3" '; if(@$h1=="3")  $str.= "selected";  $str.='>3</option>
                                     <option value="4" '; if(@$h1=="4")  $str.= "selected";  $str.='>4</option>
                                     <option value="5" '; if(@$h1=="5")  $str.= "selected";  $str.='>5</option>
                                     <option value="6" '; if(@$h1=="6")  $str.= "selected";  $str.='>6</option>
                                     <option value="7" '; if(@$h1=="7")  $str.= "selected";  $str.='>7</option>
                                     <option value="8" '; if(@$h1=="8")  $str.= "selected";  $str.='>8</option>
                                     <option value="9" '; if(@$h1=="9")  $str.= "selected";  $str.='>9</option>
                                     <option value="10" '; if(@$h1=="10")  $str.= "selected";  $str.='>10</option>
                                     <option value="11" '; if(@$h1=="11")  $str.= "selected";  $str.='>11</option>                                   					 <option value="12" '; if(@$h1=="12")  $str.= "selected";  $str.='>12</option>
                                    
                            </select> 
                                     <select  name="min1" id="tim_sec_min_f_'.$data['id'].'">
                                   <option value="w">Select From Min</option>
                                    <option value="00" '; if(@$m1=="00")  $str.= "selected";  $str.='>00</option> 
                                     <option value="05" '; if(@$m1=="05")  $str.= "selected";  $str.='>05</option>
                                     <option value="10" '; if(@$m1=="10")  $str.= "selected";  $str.='>10</option>
                                     <option value="15" '; if(@$m1=="15")  $str.= "selected";  $str.='>15</option>
                                     <option value="20" '; if(@$m1=="20")  $str.= "selected";  $str.='>20</option>
                                     <option value="25" '; if(@$m1=="25")  $str.= "selected";  $str.='>25</option>
                                     <option value="30" '; if(@$m1=="30")  $str.= "selected";  $str.='>30</option>
                                     <option value="35" '; if(@$m1=="35")  $str.= "selected";  $str.='>35</option>
                                     <option value="40" '; if(@$m1=="40")  $str.= "selected";  $str.='>40</option>
                                     <option value="45" '; if(@$m1=="45")  $str.= "selected";  $str.='>45</option>
                                     <option value="50" '; if(@$m1=="50")  $str.= "selected";  $str.='>50</option>
                                     <option value="55" '; if(@$m1=="55")  $str.= "selected";  $str.='>55</option>                                        
                                    
                            </select> 
                             <select  name="am_pm1" id="tim_sec_am_f_'.$data['id'].'">
                                     <option value="w">Select From AM-PM</option>
                                       <option value="AM" '; if(@$am1=="AM")  $str.= "selected";  $str.='>AM</option> 
                                     <option value="PM" '; if(@$am1=="PM")  $str.= "selected";  $str.='>PM</option>
                                                                        
                            </select> 
                            </div>
                            <div class="col-sm-12">
                                
                                     <label> To : </label>
                                    
                                        <select  name="hours_to1" id="tim_sec_time_t_'.$data['id'].'">
                                  <option value="">Select To Time</option>
                                     <option value="1" '; if(@$h_sec1=="1")  $str.= "selected";  $str.='>1</option>
                                     <option value="2" '; if(@$h_sec1=="2")  $str.= "selected";  $str.='>2</option>
                                     <option value="3" '; if(@$h_sec1=="3")  $str.= "selected";  $str.='>3</option>
                                     <option value="4" '; if(@$h_sec1=="4")  $str.= "selected";  $str.='>4</option>
                                     <option value="5" '; if(@$h_sec1=="5")  $str.= "selected";  $str.='>5</option>
                                     <option value="6" '; if(@$h_sec1=="6")  $str.= "selected";  $str.='>6</option>
                                     <option value="7" '; if(@$h_sec1=="7")  $str.= "selected";  $str.='>7</option>
                                     <option value="8" '; if(@$h_sec1=="8")  $str.= "selected";  $str.='>8</option>
                                     <option value="9" '; if(@$h_sec1=="9")  $str.= "selected";  $str.='>9</option>
                                     <option value="10" '; if(@$h_sec1=="10")  $str.= "selected";  $str.='>10</option>
                                     <option value="11" '; if(@$h_sec1=="11")  $str.= "selected";  $str.='>11</option>                                                  <option value="12" '; if(@$h_sec=="12")  $str.= "selected";  $str.='>12</option>
                                    
                            </select> 
                                     <select  name="min_to1" id="tim_sec_min_t_'.$data['id'].'">
                                   
                                     <option value="w">Select From Min</option>
                                       <option value="00" '; if(@$min_sec1=="00")  $str.= "selected";  $str.='>00</option> 
                                     <option value="05" '; if(@$min_sec1=="05")  $str.= "selected";  $str.='>05</option>
                                     <option value="10" '; if(@$min_sec1=="10")  $str.= "selected";  $str.='>10</option>
                                     <option value="15" '; if(@$min_sec1=="15")  $str.= "selected";  $str.='>15</option>
                                     <option value="20" '; if(@$min_sec1=="20")  $str.= "selected";  $str.='>20</option>
                                     <option value="25" '; if(@$min_sec1=="25")  $str.= "selected";  $str.='>25</option>
                                     <option value="30" '; if(@$min_sec1=="30")  $str.= "selected";  $str.='>30</option>
                                     <option value="35" '; if(@$min_sec1=="35")  $str.= "selected";  $str.='>35</option>
                                     <option value="40" '; if(@$min_sec1=="40")  $str.= "selected";  $str.='>40</option>
                                     <option value="45" '; if(@$min_sec1=="45")  $str.= "selected";  $str.='>45</option>
                                     <option value="50" '; if(@$min_sec1=="50")  $str.= "selected";  $str.='>50</option>
                                     <option value="55" '; if(@$min_sec1=="55")  $str.= "selected";  $str.='>55</option>                                  
                                    
                            </select> 
                             <select  name="am_pm_to1" id="tim_sec_am_t_'.$data['id'].'">
                             <option value="w">Select From AM-PM</option>
                                    <option value="AM" '; if(@$am_sec1=="AM")  $str.= "selected";  $str.='>AM</option> 
                                     <option value="PM" '; if(@$am_sec1=="PM")  $str.= "selected";  $str.='>PM</option>
                            </select> 
                            </div>
                            </div>
                            </div>
                            <div style="clear: both"></div>
                                <div class="form-group form-float">
                              <label class="form-label">Session 2</label>
                                     <div class="form-line">
                                      <div class="form-group form-float" style="width: auto;">
                              <div class="col-sm-12">
                                <label> From : </label>
                                    
                                        <select  name="hours_sec1" id="tim_sec_time_f_s_'.$data['id'].'">
                                   <option value="">Select From Time</option>
                                     <option value="1" '; if(@$h_sd1=="1")  $str.= "selected";  $str.='>1</option>
                                     <option value="2" '; if(@$h_sd1=="2")  $str.= "selected";  $str.='>2</option>
                                     <option value="3" '; if(@$h_sd1=="3")  $str.= "selected";  $str.='>3</option>
                                     <option value="4" '; if(@$h_sd1=="4")  $str.= "selected";  $str.='>4</option>
                                     <option value="5" '; if(@$h_sd1=="5")  $str.= "selected";  $str.='>5</option>
                                     <option value="6" '; if(@$h_sd1=="6")  $str.= "selected";  $str.='>6</option>
                                     <option value="7" '; if(@$h_sd1=="7")  $str.= "selected";  $str.='>7</option>
                                     <option value="8" '; if(@$h_sd1=="8")  $str.= "selected";  $str.='>8</option>
                                     <option value="9" '; if(@$h_sd1=="9")  $str.= "selected";  $str.='>9</option>
                                     <option value="10" '; if(@$h_sd1=="10")  $str.= "selected";  $str.='>10</option>
                                     <option value="11" '; if(@$h_sd1=="11")  $str.= "selected";  $str.='>11</option>                                   <option value="12" '; if(@$h_sd=="12")  $str.= "selected";  $str.='>12</option>
                                    
                            </select> 
                                     <select  name="min_sec1" id="tim_sec_min_f_s_'.$data['id'].'">
                                   <option value="w">Select From Min</option>
                                     <option value="00" '; if(@$m_sd1=="00")  $str.= "selected";  $str.='>00</option> 
                                     <option value="05" '; if(@$m_sd1=="05")  $str.= "selected";  $str.='>05</option>
                                     <option value="10" '; if(@$m_sd1=="10")  $str.= "selected";  $str.='>10</option>
                                     <option value="15" '; if(@$m_sd1=="15")  $str.= "selected";  $str.='>15</option>
                                     <option value="20" '; if(@$m_sd1=="20")  $str.= "selected";  $str.='>20</option>
                                     <option value="25" '; if(@$m_sd1=="25")  $str.= "selected";  $str.='>25</option>
                                     <option value="30" '; if(@$m_sd1=="30")  $str.= "selected";  $str.='>30</option>
                                     <option value="35" '; if(@$m_sd1=="35")  $str.= "selected";  $str.='>35</option>
                                     <option value="40" '; if(@$m_sd1=="40")  $str.= "selected";  $str.='>40</option>
                                     <option value="45" '; if(@$m_sd1=="45")  $str.= "selected";  $str.='>45</option>
                                     <option value="50" '; if(@$m_sd1=="50")  $str.= "selected";  $str.='>50</option>
                                     <option value="55" '; if(@$m_sd1=="55")  $str.= "selected";  $str.='>55</option>                                    
                                    
                            </select> 
                             <select  name="am_pm_sec1" id="tim_sec_am_f_s_'.$data['id'].'">
                             <option value="w">Select From AM-PM</option>
                                     <option value="AM" '; if(@$am_sd1=="AM")  $str.= "selected";  $str.='>AM</option> 
                                     <option value="PM" '; if(@$am_sd1=="PM")  $str.= "selected";  $str.='>PM</option>
                            </select> 
                            </div>
                            <div class="col-sm-12">
                                
                                     <label> To : </label>
                                    
                                        <select  name="hours_to_sec1" id="tim_sec_time_t_s_'.$data['id'].'">
                                    <option value="">Select To Time</option>
                                     <option value="1" '; if(@$h_sec_sd1=="1")  $str.= "selected";  $str.='>1</option>
                                     <option value="2" '; if(@$h_sec_sd1=="2")  $str.= "selected";  $str.='>2</option>
                                     <option value="3" '; if(@$h_sec_sd1=="3")  $str.= "selected";  $str.='>3</option>
                                     <option value="4" '; if(@$h_sec_sd1=="4")  $str.= "selected";  $str.='>4</option>
                                     <option value="5" '; if(@$h_sec_sd1=="5")  $str.= "selected";  $str.='>5</option>
                                     <option value="6" '; if(@$h_sec_sd1=="6")  $str.= "selected";  $str.='>6</option>
                                     <option value="7" '; if(@$h_sec_sd1=="7")  $str.= "selected";  $str.='>7</option>
                                     <option value="8" '; if(@$h_sec_sd1=="8")  $str.= "selected";  $str.='>8</option>
                                     <option value="9" '; if(@$h_sec_sd1=="9")  $str.= "selected";  $str.='>9</option>
                                     <option value="10" '; if(@$h_sec_sd1=="10")  $str.= "selected";  $str.='>10</option>
                                     <option value="11" '; if(@$h_sec_sd1=="11")  $str.= "selected";  $str.='>11</option>                                   <option value="12" '; if(@$h_sec_sd1=="12")  $str.= "selected";  $str.='>12</option>
                                    
                            </select> 
                                     <select  name="min_to_sec1" id="tim_sec_min_t_s_'.$data['id'].'">
                                   <option value="w">Select From Min</option>
                                     <option value="00" '; if(@$min_sec_sd1=="00")  $str.= "selected";  $str.='>00</option> 
                                     <option value="05" '; if(@$min_sec_sd1=="05")  $str.= "selected";  $str.='>05</option>
                                     <option value="10" '; if(@$min_sec_sd1=="10")  $str.= "selected";  $str.='>10</option>
                                     <option value="15" '; if(@$min_sec_sd1=="15")  $str.= "selected";  $str.='>15</option>
                                     <option value="20" '; if(@$min_sec_sd1=="20")  $str.= "selected";  $str.='>20</option>
                                     <option value="25" '; if(@$min_sec_sd1=="25")  $str.= "selected";  $str.='>25</option>
                                     <option value="30" '; if(@$min_sec_sd1=="30")  $str.= "selected";  $str.='>30</option>
                                     <option value="35" '; if(@$min_sec_sd1=="35")  $str.= "selected";  $str.='>35</option>
                                     <option value="40" '; if(@$min_sec_sd1=="40")  $str.= "selected";  $str.='>40</option>
                                     <option value="45" '; if(@$min_sec_sd1=="45")  $str.= "selected";  $str.='>45</option>
                                     <option value="50" '; if(@$min_sec_sd1=="50")  $str.= "selected";  $str.='>50</option>
                                     <option value="55" '; if(@$min_sec_sd1=="55")  $str.= "selected";  $str.='>55</option>                                   
                                    
                            </select> 
                             <select  name="am_pm_to_sec1" id="tim_sec_am_t_s_'.$data['id'].'">
                             <option value="w">Select From AM-PM</option>
                                     <option value="AM" '; if(@$am_sec_sd1=="AM")  $str.= "selected";  $str.='>AM</option> 
                                     <option value="PM" '; if(@$am_sec_sd1=="PM") $str.= "selected";  $str.='>PM</option>
                            </select> 
                            </div>
                            <div style="clear:both"></div>
                            
                                    <input class="btn btn-primary waves-effect" name="update_practice_other" type="submit" value="Save ">
                                 
                               </form>
                            
                            </div></div></div>   </div>
                            



                             
<script>
 function check_checkbox_mo_'.$data['id'].'()
 {
 	 if($("#md_checkbox_mo1'.$data['id'].'").is(":checked"))
 	 {
      $("#md_checkbox_mo1'.$data['id'].'").prop("checked", false);
	 }
 }
 function check_checkbox_mo1_'.$data['id'].'()
 {
  	 if($("#md_checkbox_mo'.$data['id'].'").is(":checked"))
  	 {
 	    $("#md_checkbox_mo'.$data['id'].'").prop("checked", false);
	 }
 }function check_checkbox_tu_'.$data['id'].'()
 {
 	 if($("#md_checkbox_tu1'.$data['id'].'").is(":checked"))
 	 {
      $("#md_checkbox_tu1'.$data['id'].'").prop("checked", false);
	 }
 }
 function check_checkbox_tu1_'.$data['id'].'()
 {
  	 if($("#md_checkbox_tu'.$data['id'].'").is(":checked"))
  	 {
 	    $("#md_checkbox_tu'.$data['id'].'").prop("checked", false);
	 }
 }function check_checkbox_we_'.$data['id'].'()
 {
 	 if($("#md_checkbox_we1'.$data['id'].'").is(":checked"))
 	 {
      $("#md_checkbox_we1'.$data['id'].'").prop("checked", false);
	 }
 }
 function check_checkbox_we1_'.$data['id'].'()
 {
  	 if($("#md_checkbox_we'.$data['id'].'").is(":checked"))
  	 {
 	    $("#md_checkbox_we'.$data['id'].'").prop("checked", false);
	 }
 }function check_checkbox_th_'.$data['id'].'()
 {
 	 if($("#md_checkbox_th1'.$data['id'].'").is(":checked"))
 	 {
      $("#md_checkbox_th1'.$data['id'].'").prop("checked", false);
	 }
 }
 function check_checkbox_th1_'.$data['id'].'()
 {
  	 if($("#md_checkbox_th'.$data['id'].'").is(":checked"))
  	 {
 	    $("#md_checkbox_th'.$data['id'].'").prop("checked", false);
	 }
 }function check_checkbox_fr_'.$data['id'].'()
 {
 	 if($("#md_checkbox_fr1'.$data['id'].'").is(":checked"))
 	 {
      $("#md_checkbox_fr1'.$data['id'].'").prop("checked", false);
	 }
 }
 function check_checkbox_fr1_'.$data['id'].'()
 {
  	 if($("#md_checkbox_fr'.$data['id'].'").is(":checked"))
  	 {
 	    $("#md_checkbox_fr'.$data['id'].'").prop("checked", false);
	 }
 }function check_checkbox_sa_'.$data['id'].'()
 {
 	 if($("#md_checkbox_sa1'.$data['id'].'").is(":checked"))
 	 {
      $("#md_checkbox_sa1'.$data['id'].'").prop("checked", false);
	 }
 }
 function check_checkbox_sa1_'.$data['id'].'()
 {
  	 if($("#md_checkbox_sa'.$data['id'].'").is(":checked"))
  	 {
 	    $("#md_checkbox_sa'.$data['id'].'").prop("checked", false);
	 }
 }function check_checkbox_sun_'.$data['id'].'()
 {
 	 if($("#md_checkbox_su1'.$data['id'].'").is(":checked"))
 	 {
      $("#md_checkbox_su1'.$data['id'].'").prop("checked", false);
	 }
 }
 function check_checkbox_sun1_'.$data['id'].'()
 {
  	 if($("#md_checkbox_sun'.$data['id'].'").is(":checked"))
  	 {
 	    $("#md_checkbox_sun'.$data['id'].'").prop("checked", false);
	 }
 }
    
</script> ';
                            
		}
	}
	return $str;
}
public function edit_error($error,$title,$type,$id)
{
	
	$res=$this->db->query("update error set error='$error',title='$title',type='$type' where id='$id'");
	if($res)
	{
		return true;
	}
}
public function update_login_detail($time,$date)
{
	$doc_id=$_SESSION['login_id'];
	$res=$this->db->query("update doctors set login_time='$time',login_date='$date' where id='$doc_id'");
	if($res)
	{
		return true;
	}
}
public function file_show_patient()
{
	$id=$_SESSION['login_id'];
	$res=$this->db->query("select * from patient where doctor_id='$id'");
	$str='';
	$str='  <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>Patient Image</th>
                                        <th>Name</th>
                                         <th>Phone No</th>
                                        <th>Area, City</th>
                                        <th>Age</th>
                                         <th>Gender</th>
                                         <th>Patient ID</th>
                                         <th>Action</th>
                                    </tr>
                                </thead>
                                 <tbody>';
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
			$area = $this->getById($data['area'], 'area');
			$str.=' <tr>
                                        <td><img src="'.base_url.'image/'.$data['image'].'" width="60" height="60"></td>
                                        <td>'.$data['name'].'</td>
                                        <td>'.$data['phone_no'].'</td>
                                        <td>'.$area['name'].', '.$data['city'].'</td>
                                        <td>'.$data['age'].'</td>
                                        <td>'.$data['gender'].'</td>
                                        <td>'.$data['patient_id'].'</td>
                                        <td>
                                        <a href="'.base_url_doc.'patient-detail/?action=file_show_detail&patient_id='.$data['id'].'" style="padding:9px 13px 10px 9px; font-weight: bold;" class="btn btn-info">
                                        View</a>
                                      
								 </td>
                                    </tr>
                                   ';
		
		}	
	}
	$str.=' </tbody></table>';
	 return $str;
}
public function change_notification_stat($doc_id)
{
    $res = $this->db->query("update feedback set status='Active' where doctor_id='$doc_id'");
    $res = $this->db->query("update activity set doctor_notification_status='Active' where doctor_id='$doc_id'");
    if($res)
    { 
        return TRUE;
    }
}
public function notification_detail()
{
	$doc_id=$_SESSION['login_id'];
	$res=$this->db->query("select * from feedback where doctor_id='$doc_id' and status='Pending' ");
	$str='';
	if($res->num_rows>0)
	{
		
		while($data=$res->fetch_assoc())
		{
			$str.=' <li><a href="feedback.php">'.$data['name'].' reviewed you on '.$data['date'].'.</a></li>
			<li class="divider"></li>';
		}
			
	}
	$res=$this->db->query("select * from admin_notified where (type='Doctor' or type='') and (doctor_id='$doc_id' or doctor_id='') and status='unread' ");
	
	if($res->num_rows>0)
	{
		while($data=$res->fetch_assoc())
		{
			$str.=' <li><a href="admin_notification.php">Admin sent you a notification.</a></li>
			<li class="divider"></li>';
		}
	}
	
	$res1=$this->db->query("select * from activity where doctor_id='$doc_id' and doctor_notification_status='not_seen' ORDER BY date DESC LIMIT 10");
	if($res1->num_rows>0)
	{
		
		while($data=$res1->fetch_assoc())
		{
			$patient_name = $this->getPatientName($data['patient_id']);
		    if(!empty($patient_name)){
			$str.=' <li>'.$data['name'].' : '.$patient_name.'.</a></li>
			<li class="divider"></li>';}
			else
			{
			    $str.=' <li>'.$data['name'].' : '.$data['patient_id'].'.</a></li>
			<li class="divider"></li>';
			}
		}
			
	}
	return($str);
}
public function notification_detail2()
{
	$doc_id=$_SESSION['login_id'];
	$res=$this->db->query("select * from feedback where doctor_id='$doc_id' LIMIT 10");
	$str='';
	if($res->num_rows>0)
	{
		
		while($data=$res->fetch_assoc())
		{
			$str.=' <li><a href="feedback.php">'.$data['name'].' reviewed you on '.$data['date'].'.</a></li>
			<li class="divider"></li>';
		}
			
	}
	$res=$this->db->query("select * from admin_notified where (type='Doctor' or type='') and (doctor_id='$doc_id' or doctor_id='') and status='unread' ");
	
	if($res->num_rows>0)
	{
		while($data=$res->fetch_assoc())
		{
			$str.=' <li><a href="admin_notification.php">Admin sent you a notification.</a></li>
			<li class="divider"></li>';
		}
	}
	$res1=$this->db->query("select * from activity where doctor_id='$doc_id' ORDER BY date DESC LIMIT 10");
	if($res1->num_rows>0)
	{
		
		while($data=$res1->fetch_assoc())
		{
		    $patient_name = $this->getPatientName($data['patient_id']);
		    if(!empty($patient_name)){
			$str.=' <li>'.$data['name'].' : '.$patient_name.'.</a></li>
			<li class="divider"></li>';}
			else
			{
			    $str.=' <li>'.$data['name'].' : '.$data['patient_id'].'.</a></li>
			<li class="divider"></li>';
			}
		}
			
	}
	return($str);
}
public function admin_notification_detail()
{
	$doc_id=$_SESSION['login_id'];
	$res=$this->db->query("select * from admin_notified where (type='Doctor' or type='') and (doctor_id='$doc_id' or doctor_id='') and status='read' ");
	$str='';
	if($res->num_rows>0)
	{
		while($data=$res->fetch_assoc())
		{
			$str.=' <li><a href="'.base_url_doc.'admin_notified/?notified_id='.$data['id'].'">'.$data['description'].'</a></li>
			<li class="divider"></li>';
		}
	}
	return($str);
}
public function notification_count()
{
	$doc_id=$_SESSION['login_id'];
	$res=$this->db->query("select * from feedback where doctor_id='$doc_id' and status='Pending' ");
	$str='';
	$count=0;
	if($res->num_rows>0)
	{
		while($data=$res->fetch_assoc())
		{
			$count++;
		}
	}
	$res=$this->db->query("select * from admin_notified where (type='Doctor' or type='') and (doctor_id='$doc_id' or doctor_id='') and status='unread' ");
	$str='';
	if($res->num_rows>0)
	{
		while($data=$res->fetch_assoc())
		{
			$count++;
		}
	}
	
	$res1=$this->db->query("select * from activity where doctor_id='$doc_id' and doctor_notification_status='not_seen' ORDER BY date DESC");
	if($res1->num_rows>0)
	{
		
		while($data=$res1->fetch_assoc())
		{
			$count++;
		}
			
	}
	return($count);
}
public function admin_notification_table($status)
{
	$doc_id=$_SESSION['login_id'];
	$res=$this->db->query("select * from admin_notified where (type='Doctor' or type='') and (doctor_id='$doc_id' or doctor_id='') and status='$status'");
	$str=' <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>Subject</th>
                                        <th>Description</th>
                                        
                                         <th>Action</th>
                                       
                                    </tr>
                                </thead>
                                 <tbody>';
	if($res->num_rows>0)
	{
		while($data=$res->fetch_assoc())
		{
			
			$str.='<tr>
                                       
                                        <td>'.$data['title'].'</td>
                                        <td>'.$data['description'].'</td>
                                      
                                        
                                        <td>  <a href="'.base_url_doc.'admin_notified/?notified_id='.$data['id'].'" style="padding:9px 13px 10px 9px; font-weight: bold;" class="btn btn-info">
                                        View</a></td>
                                       
                                    </tr>';
		}
    }  
     $str.=' </tbody></table>';
	 return $str;
	 
}
public function update_notification_status()
{	$id=$_SESSION['login_id'];
	$res=$this->db->query("update admin_notified set status='read' where doctor_id='$id'");
	if($res)
	return(true);
}
public function getByDoctorid_with_tmp($id,$table,$tmp)
{
	
		$res = $this->db->query("SELECT * FROM `$table` WHERE doctor_id='$id' and templete='$tmp'");
 
		$str = '';

			if($res->num_rows > 0){

				return $res->fetch_assoc();

		}
}
public function edit_treatment($name,$qty,$cost,$discount,$total,$note,$id)
{
	$res=$this->db->query("update treatment set name='$name',qty='$qty',cost='$cost',discount='$discount',total='$total',note='$note' where id='$id'");
	if($res)
	{
		return true;
	}
}
public function areawisepatient($id)
{
	$res=$this->db->query("select * from patient where area='$id'");
	
	if($res->num_rows>0)
	{
		$str='<input type="checkbox" id="md_checkbox_457487" class="filled-in chk-col-cyan " value="all"  name="patient[]">
    <label for="md_checkbox_457487">All</label> <div id="forcheck">';
		while($data=$res->fetch_assoc())
		{
			$str.='<input type="checkbox" id="md_checkbox_'.$data['id'].'" class="filled-in chk-col-cyan forcheck" value="'.$data['id'].'" name="patient[]">
    <label for="md_checkbox_'.$data['id'].'">'.$data['name'].' ('.$data['patient_id'].')</label>';
		}
		$str.='</div>';
	}
	return $str;
}public function groupwisepatient($id)
{
	
	$res=$this->db->query("select * from patient where groups='$id'");

	if($res->num_rows>0)
	{
		$str='<input type="checkbox" id="md_checkbox_457487" class="filled-in chk-col-cyan " value="all"  name="patient[]">
    <label for="md_checkbox_457487">All</label> <div id="forcheck">';
		while($data=$res->fetch_assoc())
		{
			$str.='<input type="checkbox" id="md_checkbox_'.$data['id'].'" class="filled-in chk-col-cyan forcheck" value="'.$data['id'].'" name="patient[]">
    <label for="md_checkbox_'.$data['id'].'">'.$data['name'].' ('.$data['patient_id'].')</label>';
		}
		$str.='</div>';
	}
	
	
	return $str;
}
public function dropdown_patients1()
{
	$doc_id=$_SESSION['login_id'];
	$doc_id = json_encode(array($doc_id));
	$res=$this->db->query("select * from patient where doctor_id='$doc_id'");
	$str='';
	if($res->num_rows>0)
	{
		while($data=$res->fetch_assoc())
		{
			$str.='<option value="'.$data['id'].'">'.$data['name'].'</option>';
		}
	}
	return $str;
}
public function clinic_id_ar()
{
	$doc_id=$_SESSION['login_id'];
	$res=$this->db->query("select * from clinic where doctor_id='$doc_id'");
	if($res->num_rows>0)
	{
		while($data=$res->fetch_assoc())
		{
			$a[]=$data['id'];
		}
	}
	return @$a;
}
public function update_feedback_status($id,$status)
{
	$res=$this->db->query("update feedback set status='$status' where id='$id'");
	if($res)
	{
		return(TRUE);
	}
}
public function popup_qustion()
{
	$doc_id=$_SESSION['login_id'];
	$res=$this->db->query("select * from question where doctor_id='$doc_id'");
	if($res->num_rows>0)
	{
		$count=0;
		while($data=$res->fetch_assoc())
		{
			$res1=$this->db->query("select * from consult_comment where consult_id='".$data['id']."'");
			if($res1->num_rows>0)
			{
				
			}
			else{
				$count++;
			}
		}
	}
	if($count>0)
	{
		return($count);
	}	
}


public function next_patient_name(){
	$id = $_SESSION['login_id'];
	$date1=date("Y/m/d");
	$res= $this->db->query("select * from token WHERE doctor_id='$id' and app_date='$date1' and status='pending' ORDER BY token_no ASC LIMIT 1");
	if($res->num_rows>0)
    {
    
    	$data = $res->fetch_assoc();
    	return $data['patient_name'];
    }
    else{
        return "No New Patient";
    }
    
}

public function get_next_patient_time(){
	$id = $_SESSION['login_id'];
	$date1=date("Y/m/d");
	$res= $this->db->query("select * from token WHERE doctor_id='$id' and app_date='$date1' and status='pending' ORDER BY token_no ASC LIMIT 1");
	if($res->num_rows>0)
    {
    	$data = $res->fetch_assoc();
    	return $data['app_time'];
    }
    else{
        return "--:--:--";
    }
    

}

public function next_patient_token(){
	$id = $_SESSION['login_id'];
	$date1=date("Y/m/d");
	$res= $this->db->query("select * from token WHERE doctor_id='$id' and app_date='$date1' and status='pending' ORDER BY token_no ASC LIMIT 1");
	if($res->num_rows>0)
    {
    	$data = $res->fetch_assoc();
    	return $data['token_no'];
    	
    }
    else{
        return "-";
    }
}


public function display_tokens_after_cancel($token_id){
        $id = $_SESSION['login_id'];
        $date1=date("Y/m/d");
        $res1= $this->db->query("update token set status='Cancel' WHERE id='$token_id'");
        
        $res_data= $this->db->query("select * from token where id='$token_id'");
        $app=$res_data->fetch_assoc();
        $app_id=$app['app_id'];
        $doc_id=$app['doctor_id'];
        $date=$app['app_date'];
        if($this->db->query("SET @i=0;") && $this->db->query("UPDATE `token` SET token_no = @i:=@i+1 WHERE app_date='$date' and doctor_id='$doc_id' and status!='Cancel'  ORDER BY app_time;") )
    {
       $ii=0;
    }
        $cancel= $this->db->query("update appointments set status='Cancel' where id='$app_id'");
        $res= $this->db->query("select * from token WHERE doctor_id='$id' and app_date='$date1' and status='pending' ORDER BY token_no");
        $str='<div style="height:200px;overflow:scroll;">';
        if($res->num_rows>0)
        {   
            //$data=$res->fetch_assoc();
            $str='<div style="height:200px;overflow:scroll;">';
    
            while($data=$res->fetch_assoc())
            {
                
                $str.='<div class="row" style="height:55px;width:100%">
                        <section style="padding-top: 25px;" id="'.$data['token_no'].'">
                        <div class="col-xs-2">
                            <div class="img-circle live-token-no"><b>';
                $str.=$data['token_no'];
                $str.='</b></div>
                        </div>      
                        <div class="col-xs-6 live-token-doctor-name">';
                if($data['status']=='Done'){
                    $str.='<a style="padding:0;margin:0" href="patient-detail-page.php?patient_id='.$data['patient_id'].'">'.$data['patient_name'].'</a><h6 style="margin:0;padding:0">'.$data['clinic_name'].'</h6></div>';
                    $str.='<div class="col-xs-4 col-xs-offset-0" style="margin-top:5px">
                            <span class="glyphicon glyphicon-ok-sign live-token-button-done check"  href="#" style="margin-left: 30%"></span>
                        </div>
                    </section>
                    </div>';
                }
                else if($data['status']=='pending'){
                    if($count==0){
                        $str.='<a style="padding:0;margin:0" href="patient-detail-page.php?patient_id='.$data['patient_id'].'">'.$data['patient_name'].'</a><h6 style="margin:0;padding:0">'.$data['clinic_name'].'</h6></div>';
                         $str.='<div class="col-xs-4 col-xs-offset-0" style="margin-top:5px">
                            <span class="glyphicon glyphicon-ok-circle live-token-button check" onclick="token_done('.$data['id'].','.$data['patient_id'].')" href="#" style="margin-left: 5%"></span>
                            <span class="glyphicon glyphicon-remove live-token-button-cancel" onclick="token_cancel('.$data['id'].')" style="margin-left: 10%"></span>
                        </div>
                    </section>
                    </div>';
                    $count=1;
                    }
                    else{
                        $str.='<a style="padding:0;margin:0" href="patient-detail-page.php?patient_id='.$data['patient_id'].'">'.$data['patient_name'].'</a><h6 style="margin:0;padding:0">'.$data['clinic_name'].'</h6></div>';
                        $str.='<div class="col-xs-4 col-xs-offset-0" style="margin-top:5px">
                            <span class="glyphicon glyphicon-circle-arrow-up live-token-button-upcoming check" onclick="token_done('.$data['id'].','.$data['patient_id'].')" href="#" style="margin-left: 5%"></span>
                            <span class="glyphicon glyphicon-remove live-token-button-cancel" onclick="token_cancel('.$data['id'].')" style="margin-left:10%"></span>
                        </div>
                    </section>
                    </div>';
                    }
                    
                    
                }
            }
            $str.='</div>';
        }
        return $str;

    }
public function display_tokens_after_check($token_id){
        $id = $_SESSION['login_id'];
        $date1=date("Y/m/d");
        $res1= $this->db->query("update token set status='Done' WHERE id='$token_id'");
        $res= $this->db->query("select * from token WHERE doctor_id='$id' and app_date='$date1' and status='pending' ORDER BY token_no");
        $str='';
        if($res->num_rows>0)
        {   
            //$data=$res->fetch_assoc();
            $str='<div style="height:200px;overflow:scroll;">';
            $count=0;
            while($data=$res->fetch_assoc())
            {
                
                $str.='<div class="row" style="height:55px;width:100%">
                        <section style="padding-top: 25px;" id="'.$data['token_no'].'">
                        <div class="col-sm-2">
                            <div class="img-circle live-token-no"><b>';
                $str.=$data['token_no'];
                $str.='</b></div>
                        </div>      
                        <div class="col-sm-6 live-token-doctor-name">';
                if($data['status']=='Done'){
                    $str.='<a style="padding:0;margin:0" href="patient-detail-page.php?patient_id='.$data['patient_id'].'">'.$data['patient_name'].'</a><h6 style="margin:0;padding:0">'.$data['clinic_name'].'</h6></div>';
                    $str.='<div class="col-sm-4 col-sm-offset-0" style="margin-top: 5px">
                            <span class="glyphicon glyphicon-ok-sign live-token-button-done check"  href="#" style="margin-left: 30%"></span>
                        </div>
                    </section>
                    </div>';
                }
                else if($data['status']=='pending'){
                    if($count==0){
                        $str.='<a style="padding:0;margin:0" href="patient-detail-page.php?patient_id='.$data['patient_id'].'">'.$data['patient_name'].'</a><h6 style="margin:0;padding:0">'.$data['clinic_name'].'</h6></div>';
                         $str.='<div class="col-sm-4 col-sm-offset-0" style="margin-top: 5px">
                            <span class="glyphicon glyphicon-ok-circle live-token-button check" onclick="token_done('.$data['id'].','.$data['patient_id'].')" href="#" style="margin-left: 5%"></span>
                            <span class="glyphicon glyphicon-remove live-token-button-cancel" onclick="token_cancel('.$data['id'].')" style="margin-left: 10%"></span>
                        </div>
                    </section>
                    </div>';
                    $count=1;
                    }
                    else{
                        $str.='<a style="padding:0;margin:0" href="patient-detail-page.php?patient_id='.$data['patient_id'].'">'.$data['patient_name'].'</a><h6 style="margin:0;padding:0">'.$data['clinic_name'].'</h6></div>';
                        $str.='<div class="col-sm-4 col-sm-offset-0" style="margin-top:5px">
                            <span class="glyphicon glyphicon-circle-arrow-up live-token-button-upcoming check" onclick="token_done('.$data['id'].','.$data['patient_id'].')" href="#" style="margin-left: 5%"></span>
                            <span class="glyphicon glyphicon-remove live-token-button-cancel" onclick="token_cancel('.$data['id'].')" style="margin-left:10%"></span>
                        </div>
                    </section>
                    </div>';
                    }
                    
                    
                }
                
            }
            $str.='</div>';
        }
        return $str;

    }
public function insert_invoice_through_token_done($patient_id)
{
    $doc_id = $_SESSION['login_id'];
    $namearray = array();
    $namearray[0] = "Cosultation";
    $name = json_encode($namearray);
   // $name = "Consultation";
    
    $res1 = $this->db->query("select * from practice where doctor_id='$doc_id'");
    $data1 = $res1->fetch_assoc();
    $amountarray = array();
    $amountarray[0] = $data1['consult'];
    $amount = json_encode($amountarray);
    
    $discountarray = array();
    $discountarray[0] = 0;
    $discount = json_encode($discountarray);
    
    
    $total = $data1['consult'];
    
    $status = "Paid";
    
    $tax = 0;
    
    $date = date("Y-m-d");
    
    $res = $this->db->query("insert into bill_info(name,amount,discount,total,doctor_id,patient_id,status,tax,date) values('$name','$amount','$discount','$total','$doc_id','$patient_id','$status','$tax','$date')");
    return TRUE;
    
}
public function display_tokens(){
        $id = $_SESSION['login_id'];
        $date1=date("Y/m/d");
        $res= $this->db->query("select * from token WHERE doctor_id='$id' and app_date='$date1' and status='pending' ORDER BY token_no");
        $str='';
        if($res->num_rows>0)
        {   
            //$data=$res->fetch_assoc();
            $str='';
            $count=0;
            while($data=$res->fetch_assoc())
            {
                
                $str.='<div class="row" style="height:55px;width:100%">
                        <section style="padding-top:25px;" id="'.$data['token_no'].'">
                        <div class="col-xs-2">
                            <div class="img-circle live-token-no"><b>';
                $str.=$data['token_no'];
                $str.='</b></div>
                        </div>      
                        <div class="col-xs-6 live-token-doctor-name">';
                if($data['status']=='Done'){
                    $str.='<a style="padding:0;margin:0" href="patient-detail-page.php?patient_id='.$data['patient_id'].'">'.$data['patient_name'].'</a><h6 style="margin:0;padding:0">'.$data['clinic_name'].'</h6></div>';
                    $str.='<div class="col-xs-4 col-xs-offset-0" style="margin-top: 5px">
                            <span class="glyphicon glyphicon-ok-sign live-token-button-done check"  href="#" style="margin-left: 30%"></span>
                        </div>
                    </section>
                    </div>';
                }
                else if($data['status']=='pending'){
                    if($count==0){
                        $str.='<a style="padding:0;margin:0" href="patient-detail-page.php?patient_id='.$data['patient_id'].'">'.$data['patient_name'].'</a><h6 style="margin:0;padding:0">'.$data['clinic_name'].'</h6></div>';
                         $str.='<div class="col-xs-4 col-xs-offset-0" style="margin-top: 5px">
                            <span class="glyphicon glyphicon-ok-circle live-token-button check" onclick="token_done('.$data['id'].','.$data['patient_id'].')" href="#" style="margin-left: 5%"></span>
                            <span class="glyphicon glyphicon-remove live-token-button-cancel" onclick="token_cancel('.$data['id'].')" style="margin-left: 10%"></span>
                        </div>
                    </section>
                    </div>';
                    $count=1;
                    }
                    else{
                        $str.='<a style="padding:0;margin:0" href="patient-detail-page.php?patient_id='.$data['patient_id'].'">'.$data['patient_name'].'</a><h6 style="margin:0;padding:0">'.$data['clinic_name'].'</h6></div>';
                        $str.='<div class="col-xs-4 col-xs-offset-0" style="margin-top: 5px">
                            <span class="glyphicon glyphicon-circle-arrow-up live-token-button-upcoming check" onclick="token_done('.$data['id'].','.$data['patient_id'].')" href="#" style="margin-left: 5%"></span>
                            <span class="glyphicon glyphicon-remove live-token-button-cancel" onclick="token_cancel('.$data['id'].')" style="margin-left:10%"></span>
                        </div>
                    </section>
                    </div>';
                    }
                    
                    
                }
                
                
                
                

            }
            $str.='';
        }
        return $str;

    }
    public function display_tokens_done(){
        $id = $_SESSION['login_id'];
        $date1=date("Y/m/d");
        $res= $this->db->query("select * from token WHERE doctor_id='$id' and app_date='$date1' and status='Done' ORDER BY token_no");
        $str='';
        if($res->num_rows>0)
        {   
            //$data=$res->fetch_assoc();
            $str='';
            $count=0;
            while($data=$res->fetch_assoc())
            {
                
                $str.='<div class="row" style="height:55px;width:100%">
                        <section style="padding-top:25px;" id="'.$data['token_no'].'">
                        <div class="col-xs-2">
                            <div class="img-circle live-token-no"><b>';
                $str.=$data['token_no'];
                $str.='</b></div>
                        </div>      
                        <div  class="col-xs-6 live-token-doctor-name">';
                if($data['status']=='Done'){
                    $str.='<a style="padding:0;margin:0" href="patient-detail-page.php?patient_id='.$data['patient_id'].'">'.$data['patient_name'].'</a><h6 style="margin:0;padding:0">'.$data['clinic_name'].'</h6></div>';
                    $str.='<div class="col-xs-4 col-xs-offset-0" style="margin-top: 5px">
                            <span class="glyphicon glyphicon-ok-sign live-token-button-done check"  href="#" style="margin-left: 30%"></span>
                        </div>
                    </section>
                    </div>';
                }
                else if($data['status']=='pending'){
                    if($count==0){
                         $str.='<a style="padding:0;margin:0" href="patient-detail-page.php?patient_id='.$data['patient_id'].'">'.$data['patient_name'].'</a><h6 style="margin:0;padding:0">'.$data['clinic_name'].'</h6></div>';
                   
                         $str.='<div class="col-xs-4 col-xs-offset-0" style="margin-top: 5px">
                            <span class="glyphicon glyphicon-ok-circle live-token-button check" onclick="token_done('.$data['id'].','.$data['patient_id'].')" href="#" style="margin-left: 5%"></span>
                            <span class="glyphicon glyphicon-remove live-token-button-cancel" onclick="token_cancel('.$data['id'].')" style="margin-left: 10%"></span>
                        </div>
                    </section>
                    </div>';
                    $count=1;
                    }
                    else{
                         $str.='<a style="padding:0;margin:0" href="patient-detail-page.php?patient_id='.$data['patient_id'].'">'.$data['patient_name'].'</a><h6 style="margin:0;padding:0">'.$data['clinic_name'].'</h6></div>';
                   
                        $str.='<div class="col-xs-4 col-xs-offset-0" style="margin-top: 5px">
                            <span class="glyphicon glyphicon-circle-arrow-up live-token-button-upcoming check" onclick="token_done('.$data['id'].','.$data['patient_id'].')" href="#" style="margin-left: 5%"></span>
                            <span class="glyphicon glyphicon-remove live-token-button-cancel" onclick="token_cancel('.$data['id'].')" style="margin-left:10%"></span>
                        </div>
                    </section>
                    </div>';
                    }
                    
                    
                }
                
                
                
                

            }
            $str.='';
        }
        return $str;

    }
    public function get_clinic_by_doctorid($doc_id){
    
    $result = $this->db->query("SELECT * FROM clinic where doctor_id='$doc_id'");
		while($row=mysqli_fetch_assoc($result)) {
			$resultset[] = $row;
		}		
		if(!empty($resultset))
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
    public function get_next_patient_details($doc_id)
    {
        $id = $_SESSION['login_id'];
    	$date1=date("Y/m/d");
    	$res= $this->db->query("select * from token WHERE doctor_id='$id' and app_date='$date1' and status='pending' ORDER BY token_no ASC LIMIT 1");
    	return mysqli_fetch_assoc($res);
    }
    public function  get_next_patient_image($patient_id)
    {
        $id = $_SESSION['login_id'];
    	$res= $this->db->query("select * from patient WHERE patient_id='$patient_id'");
    	$data = $res->fetch_assoc();
    	return $data['image']; 
    }
    public function get_appointment_by_date($strdate)
    {
        $id = $_SESSION['login_id'];
        $date = strtotime($strdate);
        $date1 = date('Y-m-d',$date);
    	$res=$this->db->query("select * from appointments where doctor_id='$id' and app_date='$date1' and status!='Cancel'");
    	//$data = $res->fetch_assoc();
    	$rows=array();
        $rows[0][0] = "Patient Name";
        $rows[0][1] = "Appointment Time";
        $rows[0][2] = "Remark";
        $i=0;
    	if($res->num_rows > 0)
    	{
    	    while($data=$res->fetch_assoc())
    	    {
    	        $rows[$i+1][0] = $data['patient_name'];
                $rows[$i+1][1] = $data['app_time'];
                $rows[$i+1][2] = $data['remark'];
                $i=$i+1;
    	    }
    	}
    	else{
    	  $rows[1][0] = "";
            $rows[1][1] = "";
            $rows[1][2] = "";
    	}
    	    
    	    
    //	$str.=' </tbody></table>';
        $res = json_encode($rows);
    	return $res;
    }
    public function get_expenses_by_date($strdate)
    {
        $id = $_SESSION['login_id'];
        $date = strtotime($strdate);
        $date = date('Y-m-d',$date);
        $res = $this->db->query("select bill_info.amount as amount, doctor_expenses.amount as expenses from bill_info INNER JOIN doctor_expenses ON bill_info.date=doctor_expenses.date and bill_info.doctor_id=doctor_expenses.doctor_id and bill_info.date='$date'");
        $rows=array();
        $rows[0][0] ="Bill Amount";
        $rows[0][1] = "Expenses";
        $i = 0;
        if($res->num_rows > 0)
        {
            while($data=$res->fetch_assoc())
            {
                $rows[$i+1][0] = $data['amount'];
                $rows[$i+1][1] = $data['expenses'];
                $i=$i+1;
            }
        }
        else{
            $rows[1][0] = "";
            $rows[1][1] = "";
        }
        $res = json_encode($rows);
        return $res;
    }
    
public function shared_prescription($patient_id){
    
   $doc_id = $_SESSION['login_id']; 
   $res = $this->db->query("select * from share_prescription where to_doctor_id='$doc_id' and patient_id='$patient_id' ");
   
   $str='';
	$str=' <div class="col-sm-12 table-responsive" >  <table id="treat_table" class="table patient-profile-tables table-striped table-responsive" >
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        
                                        <th>Print</th>
                                        
                                    </tr>
                                </thead>
                                 <tbody>';
                                $count=1;
	if($res->num_rows > 0)
	{
		while($data=$res->fetch_assoc())
		{
					$str.=' <tr>
                                        <td><input type="hidden" value='.$data['date'].'>'.date("j F Y",strtotime($data['date'])).'</td>
                                        
                                        
                                        
                                        	<td><a href="'.base_url_doc.'prescription.php?patient_id='.$patient_id.'&date='.$data['date'].'&doc_id='.$data['from_doctor_id'].'" target="_blank"><div class="patient-list-buttons glyphicon glyphicon-print"></div></a>
                                        	
                                        	
								 </td>
                                    </tr>';
                                    $count++ ;
		
		}	
	}
	else {
        $str.='<tr><td colspan="2">No Records Found To Show.</td></tr>';
    }
	$str.=' </tbody></table></div>';
	 return $str;
    
}

public function display_ephr_history($patient_id)

{
    $res2 = $this->db->query("select id from patient where patient_id='$patient_id'");
    
    $pid = $res2->fetch_assoc();
	$id =$pid['id'];
	$doc_id=$_SESSION['login_id'];
	
	 $res1 = $this->db->query("select * from share_ephr where pid='$id' and todoc='$doc_id'");
	 if($res1->num_rows>0){
	  
	  $res=$this->db->query("select * from ephr where patient_id='$id' and relation!=''");	
	  
	 
	
	$str=' 
	 <div class="col-sm-12 table-responsive" > 
	
	 <table id="treat_table" class="table patient-profile-tables table-striped table-responsive" >
                                <thead>
                                    <tr>
                                        <th>Patient Name</th>
                                        <th>Disease</th>
                                        <th>Maternal/Paternal(L/min)</th> 
                                         <th>Relation</th>
                                         <th>Remark</th>
                                        
                                        
                                    </tr>
                                </thead>
                                 <tbody>';
	if($res->num_rows > 0)
	{
		while($data1=$res->fetch_assoc())
		{   
		
		
			$str.=' <tr>
			                             <td>'.$data1['name'].'</td>
                                        <td>'.$data1['disease'].'</td>
                                        <td>'.$data1['pat_mat'].'</td>
                                        <td>'.$data1['relation'].'</td>
                                        <td>'.$data1['comment'].'</td>
                                        </tr>
                                   ';
		
		}	
		
	}
	
	$str.=' </tbody></table></div>';
	 return $str;
 }
}

public function display_ephr_vaccine($patient_id)

{
    $res2 = $this->db->query("select id from patient where patient_id='$patient_id'");
    
    $pid = $res2->fetch_assoc();
	$id =$pid['id'];
	$doc_id=$_SESSION['login_id'];
	
	 $res1 = $this->db->query("select * from share_ephr where pid='$id' and todoc='$doc_id'");
	 if($res1->num_rows>0){
	  
	  $res=$this->db->query("select * from ephr where patient_id='$id' and age!=''");	
	  
	 
	
	$str=' 
	 
	<div class="col-sm-12 table-responsive" > 
	 <table id="treat_table" class="table patient-profile-tables table-striped table-responsive">
                                <thead>
                                    <tr>
                                        <th>Patient Name</th>
                                        <th>Vaccination</th>
                                        <th>Year</th>
                                        <th>Age</th> 
                                         
                                         <th>Remark</th>
                                        
                                        
                                    </tr>
                                </thead>
                                 <tbody>';
	if($res->num_rows > 0)
	{
		while($data1=$res->fetch_assoc())
		{   
		
		
			$str.=' <tr>
			                             <td>'.$data1['name'].'</td>
			                             <td>'.$data1['vaccination'].'</td>
                                        <td>'.$data1['year'].'</td>
                                        <td>'.$data1['age'].'</td>
                                        
                                        <td>'.$data1['comment'].'</td>
                                        </tr>
                                   ';
		
		}	
		
	}
	
	$str.=' </tbody></table></div>';
	 return $str;
 }
}

public function display_ephr_allergy($patient_id)

{
    $res2 = $this->db->query("select id from patient where patient_id='$patient_id'");
    
    $pid = $res2->fetch_assoc();
	$id =$pid['id'];
	$doc_id=$_SESSION['login_id'];
	
	 $res1 = $this->db->query("select * from share_ephr where pid='$id' and todoc='$doc_id'");
	 if($res1->num_rows>0){
	  
	  $res=$this->db->query("select * from ephr where patient_id='$id' and allergy!=''");	
	  
	 
	
	$str=' 
	 <div class="col-sm-12 table-responsive" > 
	
	 <table id="treat_table" class="table patient-profile-tables table-striped table-responsive">
                                <thead>
                                    <tr>
                                        <th rowspan=2>Patient Name</th>
                                        <th rowspan=2>Allergy</th>
                                        <th rowspan=2>Allergy Type</th>
                                        <th rowspan=2>Symptoms</th> 
                                         <th rowspan=2>Medicine</th>
                                         <th rowspan=2>Severity</th>
                                         <th rowspan=2>Remark</th>
                                        
                                    </tr>
                                </thead>
                                 <tbody>';
	if($res->num_rows > 0)
	{
		while($data1=$res->fetch_assoc())
		{   
		
		
			$str.=' <tr>
			                             <td>'.$data1['name'].'</td>
                                        <td>'.$data1['allergy'].'</td>
                                        <td>'.$data1['allergy_type'].'</td>
                                        <td>'.$data1['symptoms'].'</td>
                                        <td>'.$data1['medicine'].'</td>
                                        <td>'.$data1['severity'].'</td>
                                        <td>'.$data1['comment'].'</td>
                                        </tr>
                                   ';
		
		}	
		
	}
	
	$str.=' </tbody></table></div>';
	 return $str;
 }
}


public function display_ephr_disease($patient_id)

{
    $res2 = $this->db->query("select id from patient where patient_id='$patient_id'");
    
    $pid = $res2->fetch_assoc();
	$id =$pid['id'];
	$doc_id=$_SESSION['login_id'];
	
	 $res1 = $this->db->query("select * from share_ephr where pid='$id' and todoc='$doc_id'");
	 if($res1->num_rows>0){
	  
	  $res=$this->db->query("select * from ephr where patient_id='$id' and disease!='' and year_from!=''");	
	  
	 
	
	$str=' 
	 <div class="col-sm-12 table-responsive" > 
	
	 <table id="treat_table" class="table patient-profile-tables table-striped table-responsive">
                                <thead>
                                    <tr>
                                        <th>Patient Name</th>
                                        <th>Disease</th>
                                        <th>Year(from)</th> 
                                         <th>Year(till)</th>
                                         
                                         <th>Remark</th>
                                        
                                    </tr>
                                </thead>
                                 <tbody>';
	if($res->num_rows > 0)
	{
		while($data1=$res->fetch_assoc())
		{   
		
		
			$str.=' <tr>
			                             <td>'.$data1['name'].'</td>
                                        <td>'.$data1['disease'].'</td>
                                        <td>'.$data1['year_from'].'</td>
                                        <td>'.$data1['year_till'].'</td>
                                        
                                        <td>'.$data1['comment'].'</td>
                                       </tr>
                                   ';
		
		}	
		
	}
	
	$str.=' </tbody></table></div>';
	 return $str;
 }
}


public function display_ephr_surgery($patient_id)

{
    $res2 = $this->db->query("select id from patient where patient_id='$patient_id'");
    
    $pid = $res2->fetch_assoc();
	$id =$pid['id'];
	$doc_id=$_SESSION['login_id'];
	
	 $res1 = $this->db->query("select * from share_ephr where pid='$id' and todoc='$doc_id'");
	 if($res1->num_rows>0){
	  
	  $res=$this->db->query("select * from ephr where patient_id='$id' and surgery!='' ");	
	  
	 
	
	$str=' 
	 
	<div class="col-sm-12 table-responsive" > 
	 <table id="treat_table" class="table patient-profile-tables table-striped table-responsive">
                                <thead>
                                    <tr>
                                        <th>Patient Name</th>
                                        <th>Surgery</th>
                                        <th>Year</th> 
                                         
                                         <th>Remark</th>
                                        
                                    </tr>
                                </thead>
                                 <tbody>';
	if($res->num_rows > 0)
	{
		while($data1=$res->fetch_assoc())
		{   
		
		
			$str.=' <tr>
			                             <td>'.$data1['name'].'</td>
                                        <td>'.$data1['surgery'].'</td>
                                        <td>'.$data1['year'].'</td>
                                        <td>'.$data1['comment'].'</td>
                                       </tr>
                                   ';
		
		}	
		
	}
	
	$str.=' </tbody></table></div>';
	 return $str;
 }
}


public function display_ephr_addiction($patient_id)

{
    $res2 = $this->db->query("select id from patient where patient_id='$patient_id'");
    
    $pid = $res2->fetch_assoc();
	$id =$pid['id'];
	$doc_id=$_SESSION['login_id'];
	
	 $res1 = $this->db->query("select * from share_ephr where pid='$id' and todoc='$doc_id'");
	 if($res1->num_rows>0){
	  
	  $res=$this->db->query("select * from ephr where patient_id='$id' and addiction!='' ");	
	  
	 
	
	$str=' 
	 <div class="col-sm-12 table-responsive" > 
	
	 <table id="treat_table" class="table patient-profile-tables table-striped table-responsive">
                                <thead>
                                    <tr>
                                        <th>Patient Name</th>
                                        <th>Addiction</th>
                                        <th>Status</th> 
                                         <th>Year(from)</th>
                                         <th>Year(till)</th>
                                         <th>Remark</th>
                                       
                                    </tr>
                                </thead>
                                 <tbody>';
	if($res->num_rows > 0)
	{
		while($data1=$res->fetch_assoc())
		{   
		
		
			$str.=' <tr>
			                             <td>'.$data1['name'].'</td>
                                        <td>'.$data1['addiction'].'</td>
                                        <td>'.$data1['status'].'</td>
                                        <td>'.$data1['year_from'].'</td>
                                        <td>'.$data1['year_till'].'</td>
                                        <td>'.$data1['comment'].'</td>
                                        </tr>
                                   ';
		
		}	
		
	}
	
	$str.=' </tbody></table></div>';
	 return $str;
 }
}

public function display_ephr_rehabilition($patient_id)

{
    $res2 = $this->db->query("select id from patient where patient_id='$patient_id'");
    
    $pid = $res2->fetch_assoc();
	$id =$pid['id'];
	$doc_id=$_SESSION['login_id'];
	
	 $res1 = $this->db->query("select * from share_ephr where pid='$id' and todoc='$doc_id'");
	 if($res1->num_rows>0){
	  
	  $res=$this->db->query("select * from ephr where patient_id='$id' and center!='' ");	
	  
	 
	
	$str=' 
	 <div class="col-sm-12 table-responsive" > 
	
	 <table id="treat_table" class="table patient-profile-tables table-striped table-responsive">
                                <thead>
                                    <tr>
                                        <th>Patient Name</th>
                                        <th>Rehab Center</th>
                                        <th>Cause</th> 
                                         <th>Year(from)</th>
                                         <th>Year(till)</th>
                                         <th>Remark</th>
                                        
                                    </tr>
                                </thead>
                                 <tbody>';
	if($res->num_rows > 0)
	{
		while($data1=$res->fetch_assoc())
		{   
		
		
			$str.=' <tr>
			                             <td>'.$data1['name'].'</td>
                                        <td>'.$data1['center'].'</td>
                                        <td>'.$data1['cause'].'</td>
                                        <td>'.$data1['year_from'].'</td>
                                        <td>'.$data1['year_till'].'</td>
                                        <td>'.$data1['comment'].'</td>
                                        </tr>
                                   ';
		
		}	
		
	}
	
	$str.=' </tbody></table></div>';
	 return $str;
 }
}

public function display_monthly_income()
{
    $doc_id = $_SESSION['login_id'];
    $row = array();
   /* $row[0][0]="Date";
    $row[0][1]="Amount";
    $row[0][2]="Expenses";*/
    for($i=0;$i<=6;$i++)
    {
        $date = strftime("%Y-%m",strtotime("-".$i." months"));
        $res = $this->db->query("SELECT SUM(bill_info.total) as amount from bill_info where bill_info.doctor_id = '$doc_id' and DATE_FORMAT(bill_info.date,'%Y-%m')='$date'");
        $res1 = $this->db->query("SELECT SUM(doctor_expenses.amount) as expenses from doctor_expenses where doctor_expenses.doctor_id = '$doc_id' and DATE_FORMAT(doctor_expenses.date,'%Y-%m')='$date'");
        $temp = array($date);
        if($res->num_rows>0)
        {
            $data = $res->fetch_assoc();
            if($data["amount"])
            {
                array_push($temp,intval($data["amount"]));
            }
            else{
                array_push($temp,0);
            }
        }
        else{
            array_push($temp,0);
        }
        if($res1->num_rows>0)
        {
            $data1 = $res1->fetch_assoc();
            if($data1["expenses"])
            {
                array_push($temp,intval($data1["expenses"]));
            }
            else{
                array_push($temp,0);
            }
        }
        else{
            array_push($temp,0);
        }
        array_unshift($row,$temp);
    }
    array_unshift($row,array("Date","Amount","Expenses"));
    $res = json_encode($row);
    return $res;
}
public function display_yearly_income()
{
    $doc_id = $_SESSION['login_id'];
    $row = array();
  /* $row[0][0]="Date";
    $row[0][1]="Amount";
    $row[0][2]="Expenses";*/
    for($i=0;$i<=6;$i++)
    {
        $date = strftime("%Y",strtotime("-".$i." years"));
        $res = $this->db->query("SELECT SUM(bill_info.total) as amount from bill_info where bill_info.doctor_id = '$doc_id' and DATE_FORMAT(bill_info.date,'%Y')='$date'");
        $res1 = $this->db->query("SELECT SUM(doctor_expenses.amount) as expenses from doctor_expenses where doctor_expenses.doctor_id = '$doc_id' and DATE_FORMAT(doctor_expenses.date,'%Y')='$date'");
        $temp = array($date);
        if($res->num_rows>0)
        {
            $data = $res->fetch_assoc();
            if($data["amount"])
            {
                array_push($temp,intval($data["amount"]));
            }
            else{
                array_push($temp,0);
            }
        }
        else{
            array_push($temp,0);
        }
        if($res1->num_rows>0)
        {
            $data1 = $res1->fetch_assoc();
            if($data1["expenses"])
            {
                array_push($temp,intval($data1["expenses"]));
            }
            else{
                array_push($temp,0);
            }
        }
        else{
            array_push($temp,0);
        }
        array_unshift($row,$temp);
    }
    array_unshift($row,array("Date","Amount","Expenses"));
    $res = json_encode($row);
    return $res;
}
public function display_monthly_profile_hits()
{
    $doc_id = $_SESSION['login_id'];
    $row = array();
    for($i=0;$i<=6;$i++)
    {
        $date = strftime("%Y-%m",strtotime("-".$i." months"));
        $temp = array($date);
        $res = $this->db->query("SELECT SUM(hits.hits) as hit from hits where hits.doctor_id = '$doc_id' and DATE_FORMAT(hits.date,'%Y-%m')='$date'");
        if($res->num_rows>0)
        {
            $data = $res->fetch_assoc();
            if($data["hit"])
            {
                array_push($temp,intval($data["hit"]));
            }
            else{
                array_push($temp,0);
            }
        }
        else{
            array_push($temp,0);
        }
         array_unshift($row,$temp);
    }
    array_unshift($row,array("Date","Profile Hits"));
    $res = json_encode($row);
    return $res;
}
public function display_yearly_profile_hits()
{
    $doc_id = $_SESSION['login_id'];
    $row = array();
    for($i=0;$i<=6;$i++)
    {
        $date = strftime("%Y",strtotime("-".$i." years"));
        $temp = array($date);
        $res = $this->db->query("SELECT SUM(hits.hits) as hit from hits where hits.doctor_id = '$doc_id' and DATE_FORMAT(hits.date,'%Y')='$date'");
        if($res->num_rows>0)
        {
            $data = $res->fetch_assoc();
            if($data["hit"])
            {
                array_push($temp,intval($data["hit"]));
            }
            else{
                array_push($temp,0);
            }
        }
        else{
            array_push($temp,0);
        }
         array_unshift($row,$temp);
    }
    array_unshift($row,array("Date","Profile Hits"));
    $res = json_encode($row);
    return $res;
}
public function display_monthly_appointments()
{
    $doc_id = $_SESSION['login_id'];
    $row = array();
    for($i=0;$i<=6;$i++)
    {
        $date = strftime("%Y-%m",strtotime("-".$i." months"));
        $temp = array($date);
        $res = $this->db->query("SELECT COUNT(*) as hit from appointments WHERE appointments.doctor_id = '$doc_id' and DATE_FORMAT(appointments.app_date,'%Y-%m')='$date'");
        if($res->num_rows>0)
        {
            $data = $res->fetch_assoc();
            if($data["hit"])
            {
                array_push($temp,intval($data["hit"]));
            }
            else{
                array_push($temp,0);
            }
        }
        else{
            array_push($temp,0);
        }
         array_unshift($row,$temp);
    }
    array_unshift($row,array("Date","Appointments"));
    $res = json_encode($row);
    return $res;
}

public function display_yearly_appointments()
{
    $doc_id = $_SESSION['login_id'];
    $row = array();
    for($i=0;$i<=6;$i++)
    {
        $date = strftime("%Y",strtotime("-".$i." years"));
        $temp = array($date);
        $res = $this->db->query("SELECT COUNT(*) as hit from appointments WHERE appointments.doctor_id = '$doc_id' and DATE_FORMAT(appointments.app_date,'%Y')='$date'");
        if($res->num_rows>0)
        {
            $data = $res->fetch_assoc();
            if($data["hit"])
            {
                array_push($temp,intval($data["hit"]));
            }
            else{
                array_push($temp,0);
            }
        }
        else{
            array_push($temp,0);
        }
         array_unshift($row,$temp);
    }
    array_unshift($row,array("Date","Appointments"));
    $res = json_encode($row);
    return $res;
}

public function doctor_specialization()
{
    $doctor_id=$_SESSION['login_id'];
    $ret = $this->db->query("SELECT * FROM doctors WHERE id = '$doctor_id' ");
    if($ret->num_rows > 0){
        return $ret->fetch_assoc();
    }
}

public function get_queries($spec)
{
    $result = $this->db->query("SELECT * FROM online_queries WHERE specialization='$spec' AND status=0 ");
    while($row=mysqli_fetch_assoc($result)) {
			$resultset[] = $row;
		}		
		if(!empty($resultset))
			return $resultset;
}
public function get_sbp($pid)
{
    $doctor_id=$_SESSION['login_id'];
    $res=$this->db->query("select manage_health.patient_name as name, manage_health.date as date, manage_health.time as time ,manage_health.systolic as systolic ,manage_health.diastolic as diastolic from (select sid from share_healthtracker where doc_id='$doctor_id' and pid='$pid') as t,manage_health where manage_health.id = t.sid and manage_health.systolic!=''");	
	$str='<div  class="col-sm-12 table-responsive" style="margin-top: 10px;">
        					<table id="bptable" class="table table-striped patient-panel-table">
        						<tr style="font-weight: bold;">
        							<td>Patient Name</td>
        							<td>Systolic</td>
        							<td>Diastolic</td>
        							<td>Date</td>
        							<td>Time</td>
        						</tr>';
    if($res->num_rows>0)
    {
        $count = $res->num_rows;
        for($i=0;$i<$count;$i++){
        $data=$res->fetch_assoc();
        $str.='<tr>
            <td>'.$data['name'].'</td>
            <td>'.$data['systolic'].'</td>
            <td>'.$data['diastolic'].'</td>
            <td>'.$data['date'].'</td>
            <td>'.$data['time'].'</td>
            </tr>';
            
        }
    }
    $str.='</table></div>';
    return $str;
}
public function get_sd($pid)
{
    $doctor_id=$_SESSION['login_id'];
    $res=$this->db->query("select manage_health.patient_name as name, manage_health.date as date, manage_health.time as time ,manage_health.fast as fast ,manage_health.rand as rand from (select sid from share_healthtracker where doc_id='$doctor_id'and pid='$pid') as t,manage_health where manage_health.id = t.sid and manage_health.fast!=''");	
	$str='<div  class="col-sm-12" style="margin-top: 10px;">
        					<table id="bptable" class="table table-responsive table-striped patient-panel-table">
        						<tr style="font-weight: bold;">
        							<td>Patient Name</td>
        							<td>Blood Sugar(fasting)</td>
        							<td>Blood Sugar(random)</td>
        							<td>Date</td>
        							<td>Time</td>
        						</tr>';
    if($res->num_rows>0)
    {
        $count = $res->num_rows;
        for($i=0;$i<$count;$i++){
        $data=$res->fetch_assoc();
        $str.='<tr>
            <td>'.$data['name'].'</td>
            <td>'.$data['fast'].'</td>
            <td>'.$data['rand'].'</td>
            <td>'.$data['date'].'</td>
            <td>'.$data['time'].'</td>
            </tr>';
            
        }
    }
    $str.='</table></div>';
    return $str;
}
public function get_sa($pid)
{
    $doctor_id=$_SESSION['login_id'];
    $res=$this->db->query("select manage_health.patient_name as name, manage_health.date as date, manage_health.time as time ,manage_health.resp as resp ,manage_health.pre as pre, manage_health.post as post from (select sid from share_healthtracker where doc_id='$doctor_id' and pid='$pid') as t,manage_health where manage_health.id = t.sid and manage_health.resp!=''");	
	$str='<div  class="col-sm-12" style="margin-top: 10px;">
        					<table id="bptable" class="table table-responsive table-striped patient-panel-table">
        						<tr style="font-weight: bold;">
        							<td>Patient Name</td>
        							<td>RESP Rate (Breath/min)</td>
        							<td>PEFR Pre (L/min)</td>
        							<td>PEFR Post (L/min)</td>
        							<td>Date</td>
        							<td>Time</td>
        						</tr>';
    if($res->num_rows>0)
    {
        $count = $res->num_rows;
        for($i=0;$i<$count;$i++){
        $data=$res->fetch_assoc();
        $str.='<tr>
            <td>'.$data['name'].'</td>
            <td>'.$data['resp'].'</td>
            <td>'.$data['pre'].'</td>
            <td>'.$data['post'].'</td>
            <td>'.$data['date'].'</td>
            <td>'.$data['time'].'</td>
            </tr>';
            
        }
    }
    $str.='</table></div>';
    return $str;
}
public function get_sf($pid)
{
    $doctor_id=$_SESSION['login_id'];
    $res=$this->db->query("select manage_health.patient_name as name, manage_health.date as date, manage_health.time as time ,manage_health.pulse as pulse ,manage_health.temp as temp from (select sid from share_healthtracker where doc_id='$doctor_id' and pid='$pid') as t,manage_health where manage_health.id = t.sid and manage_health.pulse!=''");	
	$str='<div  class="col-sm-12" style="margin-top: 10px;">
        					<table id="bptable" class="table table-responsive table-striped patient-panel-table">
        						<tr style="font-weight: bold;">
        							<td>Patient Name</td>
        							<td>Pulse (Heart Beats/min)</td>
        							<td>Temperature</td>
        							<td>Date</td>
        							<td>Time</td>
        						</tr>';
    if($res->num_rows>0)
    {
        $count = $res->num_rows;
        for($i=0;$i<$count;$i++){
        $data=$res->fetch_assoc();
        $str.='<tr>
            <td>'.$data['name'].'</td>
            <td>'.$data['pulse'].'</td>
            <td>'.$data['temp'].'</td>
            <td>'.$data['date'].'</td>
            <td>'.$data['time'].'</td>
            </tr>';
            
        }
    }
    $str.='</table></div>';
    return $str;
}
public function get_tax_by_id($id)
{
    $doctor_id=$_SESSION['login_id'];
    $res=$this->db->query("select * from tax where id='$id' and doctor_id='$doctor_id'");
    if($res->num_rows>0)
    {
        $data = $res->fetch_assoc();
        return $data['value'];
    }
    else
        return 0;
    
}
public function get_taxname_by_id($id)
{
    $doctor_id=$_SESSION['login_id'];
    $res=$this->db->query("select * from tax where id='$id' and doctor_id='$doctor_id'");
    if($res->num_rows>0)
    {
        $data = $res->fetch_assoc();
        return $data['tax'];
    }
    else
        return 0;
    
}
public function get_patient_pending($id)
{
    $doctor_id=$_SESSION['login_id'];
    $res=$this->db->query("select sum(pending_amount) as pending from bill_info where patient_id='$id' and doctor_id='$doctor_id' and status='Pending'");
    if($res->num_rows>0)
    {
        $data = $res->fetch_assoc();
        return $data['pending'];
    }
    else
    {
        return 0;
    }
}
public function payment_dropdown()
{
    $doctor_id=$_SESSION['login_id'];
    $res=$this->db->query("select * from mode_of_payment where doctor_id='$doctor_id'");
    $str='';
    if($res->num_rows>0)
    {
        $count=$res->num_rows;
        for($i=0;$i<$count;$i++)
        {
            $data = $res->fetch_assoc();
            $str.='<option value='.$data['vendor_fee'].'>'.$data['mode'].' ('.$data['vendor_fee'].'%)</option>';
            
        }
    }
    return $str;
}
public function verify_num($num)
{
    $doctor_id=$_SESSION['login_id'];
    $res=$this->db->query("select * from doctors where id='$doctor_id' and phone_no='$num'");
    if($res->num_rows>0)
        return true;
    else
        return false;
}
public function otp_newphone($num)
{
    $doctor_id=$_SESSION['login_id'];
    $otp_number = mt_rand(100000,999999);
    $msg='Docconsult: OTP for new number is: '.$otp_number;
    $send_sms_url='http://login.cheapsmsbazaar.com/vendorsms/pushsms.aspx?user=docconsult&password=aks120109&msisdn='.$num.'&sid='.sender_id.'&msg='.rawurlencode($msg).'&fl=0&gwid=2';
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
    $res = $this->db->query("update doctors set token='$otp_number' where id='$doctor_id'");
    if($res)
        return json_encode($data);
    else
        return 0;
}
public function check_otp($otp,$ph)
{
    $doctor_id=$_SESSION['login_id'];
    $res=$this->db->query("update doctors set phone_no='$ph' where id='$doctor_id' and token='$otp'");
    return $res->affected_rows;
}
public function doc_add_to_clinic($num, $cid)
{
    $sql = "select * from doctors where phone_no = '$num' ";
    $res = $this->db->query($sql);
    if($res->num_rows>0){
        
        $data = $res->fetch_assoc();
        
        $clinic_id = json_decode($data['clinic'],true);
        $chk = array();

       foreach($clinic_id as $clic){
            $chk[] = $clic['clinic_id'];   
       }
        $chk1 = in_array($cid,$chk); 
        if($chk1)
        {
            return json_encode('registered');
        }else{
            return json_encode($data);
        }
    }    
    else
        return json_encode(false);
}

public function update_practice2($fees,$dura,$monday,$tuesday,$wednesday,$thursday,$friday,$saturday,$sunday,$monday1,$tuesday1,$wednesday1,$thursday1,$friday1,$saturday1,$sunday1,$monday_sec,$tuesday_sec,$wednesday_sec,$thursday_sec,$friday_sec,$saturday_sec,$sunday_sec,$monday_sec1,$tuesday_sec1,$wednesday_sec1,$thursday_sec1,$friday_sec1,$saturday_sec1,$sunday_sec1,$clinic_id,$doc_id,$mon_cnt,$tue_cnt,$wed_cnt,$thu_cnt,$fri_cnt,$sat_cnt,$sun_cnt,$alow,$timing1,$timing2,$timing3,$timing4,$timing5,$timing6,$timing7,$mode)
{
    $id = $doc_id;
    $sql = "select * from practice where doctor_id='$doc_id' and clinic_id='$clinic_id'";

    $res=$this->db->query($sql);
   
    if($res->num_rows > 0)
    {
        //$sql = "update practice set monday='$monday',tuesday='$tuesday',wednesday='$wednesday',thursday='$thursday',friday='$friday',saturday='$saturday',sunday='$sunday',monday1='$monday1',tuesday1='$tuesday1',wednesday1='$wednesday1',thursday1='$thursday1',friday1='$friday1',saturday1='$saturday1',sunday1='$sunday1',monday_sec='$monday_sec',tuesday_sec='$tuesday_sec',wednesday_sec='$wednesday_sec',thursday_sec='$thursday_sec',friday_sec='$friday_sec',saturday_sec='$saturday_sec',sunday_sec='$sunday_sec',monday_sec1='$monday_sec1',tuesday_sec1='$tuesday_sec1',wednesday_sec1='$wednesday_sec1',thursday_sec1='$thursday_sec1',friday_sec1='$friday_sec1',saturday_sec1='$saturday_sec1',sunday_sec1='$sunday_sec1', mon_row = '$mon_cnt', tue_row = '$tue_cnt', wed_row = '$wed_cnt', thu_row = '$thu_cnt', fri_row = '$fri_cnt', sat_row = '$sat_cnt', sun_row = '$sun_cnt', allow='$alow', check1 = '$timing1', check2 = '$timing2', check3 = '$timing3', check4 = '$timing4', check5 = '$timing5', check6 = '$timing6', check7 = '$timing7' where doctor_id='$doc_id' and clinic_id='$clinic_id'";
        $sql = "update practice set duration = '$dura', consult = '$fees', monday = '$monday', tuesday = '$tuesday', wednesday = '$wednesday', thursday = '$thursday', friday = '$friday', saturday = '$saturday', sunday = '$sunday', monday1 = '$monday1', tuesday1 = '$tuesday1', wednesday1 = '$wednesday1', thursday1 = '$thursday1', friday1 = '$friday1', saturday1 = '$saturday1',sunday1 = '$sunday1',monday_sec = '$monday_sec',tuesday_sec = '$tuesday_sec', wednesday_sec = '$wednesday_sec',thursday_sec = '$thursday_sec',friday_sec = '$friday_sec',saturday_sec = '$saturday_sec',sunday_sec = '$sunday_sec',monday_sec1 = '$monday_sec1',tuesday_sec1 = '$tuesday_sec1',wednesday_sec1 = '$wednesday_sec1',thursday_sec1 = '$thursday_sec1',friday_sec1 = '$friday_sec1',saturday_sec1 = '$saturday_sec1',sunday_sec1 = '$sunday_sec1',mon_row = '$mon_cnt', tue_row = '$tue_cnt', wed_row = '$wed_cnt', thu_row = '$thu_cnt', fri_row = '$fri_cnt', sat_row = '$sat_cnt', sun_row = 'sun_cnt',allow = '$alow', check1 = '$timing1', check2 = '$timing2', check3 = '$timing3', check4 = '$timing4', check5 = '$timing5', check6 = '$timing6', check7 = '$timing7' where doctor_id = '$doc_id' and clinic_id = '$clinic_id'";
        
        $res1=$this->db->query($sql);
    	if(@$res1)
    	{
    		return true;
    	}
	 }
	 else
	 {
	 	$date = date('Y-m-d');
	  	$sql1 = "insert into practice(duration,consult,monday,tuesday,wednesday,thursday,friday,saturday,sunday,monday1,tuesday1,wednesday1,thursday1,friday1,saturday1,sunday1,monday_sec,tuesday_sec,wednesday_sec,thursday_sec,friday_sec,saturday_sec,sunday_sec,monday_sec1,tuesday_sec1,wednesday_sec1,thursday_sec1,friday_sec1,saturday_sec1,sunday_sec1,doctor_id,clinic_id, mon_row, tue_row, wed_row, thu_row, fri_row, sat_row, sun_row, date, allow, check1, check2, check3, check4, check5, check6, check7) values('$dura','$fees','$monday','$tuesday','$wednesday','$thursday','$friday','$saturday','$sunday','$monday1','$tuesday1','$wednesday1','$thursday1','$friday1','$saturday1','$sunday1','$monday_sec','$tuesday_sec','$wednesday_sec','$thursday_sec','$friday_sec','$saturday_sec','$sunday_sec','$monday_sec1','$tuesday_sec1','$wednesday_sec1','$thursday_sec1','$friday_sec1','$saturday_sec1','$sunday_sec1','$doc_id','$clinic_id', '$mon_cnt', '$tue_cnt', '$wed_cnt', '$thu_cnt', '$fri_cnt', '$sat_cnt', '$sun_cnt', '$date','$alow','$timing1','$timing2','$timing3','$timing4','$timing5','$timing6','$timing7')";
	 
	 	$res1=$this->db->query($sql1);
	 	$res2=$this->db->query(" select clinic from doctors where id='$doc_id' ");
	 	$own = $this->db->query(" select doctor_id, area from clinic where id = '$clinic_id' ");
	 	$tem = $res2->fetch_assoc();
	 	$arr=array();
	 	if($tem['clinic']!=null)
	 	{
	 	    $arr=json_decode($tem['clinic'],true);
	 	}
	 	$temp = array();
	 	$clic_result = $own->fetch_assoc();
	 	$clinic_area = $clic_result['area'];
	 	
	 	$temp["did"] = $clic_result['doctor_id'];
	 	$temp["clinic_id"] = $clinic_id;
	 	array_push($arr,$temp);
	 	$arr=json_encode($arr);
	 	
	 	$first_practice_sql = " select * from practice where doctor_id = '$id' ";
	 	$first_practice_query = $this->db->query($first_practice_sql);
	 	
	 	$no_of_practice = $first_practice_query->num_rows;
	 	
	 	if($no_of_practice == 1){$qur = " ,location = '$clinic_area' ";}else{$qur = '';}
	 	
	    $update_doctors = "update doctors set clinic='$arr' $qur where id='$id'";
	 	$res3=$this->db->query($update_doctors);
	 	$res4 = $this->db->query("select secondary_doctor from clinic where id='$clinic_id'");
	 	$tem = $res4->fetch_assoc();
	 	$arr = array();
	 	if($tem['secondary_doctor']!=null)
	 	{
	 	    $arr = json_decode($tem['secondary_doctor'],true);
	 	}
	 	
	 	
	 	$sql_doc = "select specialization,services from doctors where id = '$id'";
	    $res_doc = $this->db->query($sql_doc);
	    $data_doc = $res_doc->fetch_assoc();
	    
	    $doc_services = $data_doc['services']; // Fetch Doctor Services
	    $doc_services = json_decode($doc_services,true);
        
	    $doc_specialization = $data_doc['specialization']; // Fetch Doctor Specialization
	    $doc_specialization = json_decode($doc_specialization,true);
	    $doc_fist_specil['specialization'] = $doc_specialization[0]['specialization']; // Fetch Doctor First Specialization
        
        $sql_clinic = "select specialization,services from clinic where id = '$clinic_id'";
	    $res_clinic = $this->db->query($sql_clinic);
	    $data_clinic = $res_clinic->fetch_assoc();
	    $array_service = $data_clinic['services'];
	    $array_specil = $data_clinic['specialization'];
	    
	    $all_service = json_decode($array_service,true);
        $all_service=array_merge($all_service,$doc_services);
        
        $all_service = json_encode($all_service);
        
        $all_spe = json_decode($array_specil,true);
        array_push($all_spe,$doc_fist_specil);
        $all_spe = json_encode($all_spe);
	 	
	 	array_push($arr,$id);
	 	$arr = json_encode($arr);
	 	$clic_sql = "update clinic set secondary_doctor='$arr', specialization = '$all_spe', services = '$all_service' where id='$clinic_id'";
	 	$res5 = $this->db->query($clic_sql);
	 	if($res1)
	 	{
			return true;
		}
	 }
}
// public function helper(){
//     $clic = $this->db->query("select secondary_doctor,id,doctor_id from clinic where secondary_doctor!=''");
//     for($i=0;$i<$clic->num_rows;$i++)
//     {
//         $x = $clic->fetch_assoc();
//         $res = json_decode($x['secondary_doctor'],true);
//         foreach($res as $t)
//         {
//             $res1 = $this->db->query("select * from doctors where id='$t'");
//             if($res1->num_rows>0)
//             {
//                 $data = $res1->fetch_assoc();
//                 if(json_decode($data['clinic'],true)[0]==null)
//                 {
//                     $mainarr=array();
//                     $temp = array();
//                     $temp["did"]=$x['doctor_id'];
//                     $temp["clinic_id"]=$x['id'];
//                     array_push($mainarr,$temp);
//                     $temp=json_encode($mainarr);
//                     $this->db->query("update doctors set clinic='$temp' where id='$t'");
//                 }
//                 else{
//                     $mainarr = json_decode($data['clinic'],true);
//                     $temp = array();
//                     $temp["did"]=$x['doctor_id'];
//                     $temp["clinic_id"]=$x['id'];
//                     array_push($mainarr,$temp);
//                     $temp=json_encode($mainarr);
//                     $this->db->query("update doctors set clinic='$temp' where id='$t'");
//                 }
                
//             }
//         }
        
//     }
//     $res4 = $this->db->query("select * from doctors");
//     for($i=0;$i<$res4->num_rows;$i++)
//     {
//         $tem = $res4->fetch_assoc();
//         if(json_decode($tem['clinic'],true)[0]==null)
//         {
//             $this->db->query("update doctors set clinic='' where id=".$tem['id']);
//         }
//     }
    
// }
public function edit_details_form($id)
{
    $data = array();
    $res = $this->db->query("select * from practice where doctor_id='$id'");
    $res2 = $this->db->query("select id,name,email,phone_no from doctors where id='$id'");
    $data["data"] = $res2->fetch_assoc();
    $data["timings"] = array();
    $count = $res->num_rows;
    for($i=0;$i<$count;$i++)
    {
        array_push($data["timings"],$res->fetch_assoc());
    }
    return json_encode($data);
}

public function update_profile_detail($latitude, $longitude, $country, $state, $city, $area, $pincode, $landmark, $address, $clinic_id){
  
    
    $sql = "update clinic  set latitude = '$latitude',  longitude = '$longitude', country = '$country', state = '$state', 
            city = '$city', area = '$area', pincode = '$pincode', landmark = '$landmark', address='$address' where id = '$clinic_id' ";
    $res = $this->db->query($sql);
    
    if($res){
        return true;
    }
}
public function update_video_doctor($video_info){
  
    $doc_id=$_SESSION['login_id'];
    $sql = "update doctors set video_url = '$video_info' where id = '$doc_id' ";
    $res = $this->db->query($sql);
    
    if($res){
        return true;
    }
}

public function update_clinic_sp($sp,$clinic_id)
{
	$doc_id=$_SESSION['login_id'];
    $res=$this->db->query("update clinic set specialization='$sp' where id='$clinic_id'");

	if($res)
	{
		return true;
	}
}

public function update_clinic_service($service,$clinic_id)
{
	$doc_id=$_SESSION['login_id'];
    $res=$this->db->query("update clinic set services = '$service' where id='$clinic_id'");

	if($res)
	{
		return true;
	}
}

public function update_clinics_detail($clic_name, $clic_email, $clic_mob, $clic_address, $clic_website, $clic_reg_no, $clic_year,$clinic_id)
{
    $sql = "update clinic set registration_no = '$clic_reg_no', reg_year = '$clic_year' where id='$clinic_id'";
    $res=$this->db->query($sql);

	if($res)
	{
		return true;
	}
}
public function update_clinic_timing($clinic_id, $allow_for, $duration, $regis_fee, $twinty4x7, $time_mon,$time_tue,$time_wed,$time_thu,$time_fri,$time_sat,$time_sun, $time_mon1,$time_tue1,$time_wed1,$time_thu1,$time_fri1,$time_sat1,$time_sun1,$timing1,$timing2)
{
    $sql = "update clinic set `24*7` = '$twinty4x7', duration = '$duration', registration_fee = '$regis_fee', allow = '$allow_for', mon = '$time_mon', tue='$time_tue', wed='$time_wed', thu='$time_thu',fri='$time_fri', sat='$time_sat',sun='$time_sun', mon1='$time_mon1', tue1='$time_tue1', wed1='$time_wed1', thu1='$time_thu1', fri1='$time_fri1', sat1='$time_sat1', sun1='$time_sun1', check1 ='$timing1', check2='$timing2' where id = '$clinic_id' ";

    $res = $this->db->query($sql);
    
    if($res){
        return true;
    }
}

public function get_doc_id_by_phone($number) 
{
   
    $res = $this->db->query("select * from doctors where phone_no = '$number' ");
    
    if($res->num_rows>0)
    {
        $data = $res->fetch_assoc();
        return $data['id'];
    }
}
public function match_clinic_and_doctor_time($doc_id, $cid, $get_time, $days, $box_cnt, $time_other) 
{
    //print $box_cnt." ".$time_other;   
    $error = 0;
    $select_time = date('H:i:s',strtotime($get_time));
    $time_other = date('H:i:s',strtotime($time_other));
    
    $clinic_sql = "select `24*7` from clinic where id = '$cid' ";
    $clinic_qur = $this->db->query($clinic_sql);
    $clinic_res = $clinic_qur->fetch_assoc();
    
    if($clinic_res['24*7'] != '24')
    {
        $k = 0;
        foreach($days as $day){
        
            $sql = "select $day,".$day."1 from clinic where id = '$cid' ";
            $query = $this->db->query($sql);
    
            if($query->num_rows>0){
                $data = $query->fetch_assoc();
                $time1 = $data[$day];
                $time2 = $data[$day.'1'];
                $times1 = explode('-',$time1);
                $times2 = explode('-',$time2);
                
                $from = date('H:i:s',strtotime($times1[0]));
                $to = date('H:i:s',strtotime($times1[1]));
                
                $from1 = date('H:i:s',strtotime($times2[0]));
                $to1 = date('H:i:s',strtotime($times2[1]));
                
                 //print $from.' - '.$to.' , '.$from1.' - '.$to1.' , '.$select_time."<br>";
                $error = 1;
                if($box_cnt == 2 || $box_cnt == 4)
                {
                    if($time_other >= $from  and $time_other <= $to){
                       if($select_time >= $from and $select_time <= $to){
                            $error = 0;
                        }else{
                            $error=1;
                            return $error;
                        }
                    }
                    if($time_other >= $from1 and $time_other <= $to1){
                        if($select_time >= $from1 and $select_time <= $to1){
                            $error = 0;
                        }
                        else{
                            $error=1;
                            return $error;
                        }
                    }
                }
                else
                {
                    if($select_time >= $from and $select_time <= $to){$error = 0; $cnt_arr1[] = 1;}
                    
                    //print $select_time .' >= '. $from1 .' and '. $select_time .' <= '. $to1;print "<br>";
                    
                    if($select_time >= $from1 and $select_time <= $to1){$error = 0; $cnt_arr[] = 1;}
                }
            }
        
            $k++;
        }
        $c_error = count($cnt_arr);
        $c_error1 = count($cnt_arr1);
        //print $k.' - '.$c_error1.' - '.$c_error."<br>";
        if($k != $c_error1 && $c_error1 > 0){$error = 1;}
        if($k != $c_error && $c_error > 0){$error = 1;}
        
    }
    if($error==1){
        return $error;
    }
    $practice_sql = "select * from practice where doctor_id = '$doc_id' and clinic_id != '' ";
    $practice_query = $this->db->query($practice_sql);
    if($practice_query->num_rows > 0)
    {
        while($res_practice = $practice_query->fetch_assoc())
        {
           
            if($res_practice['clinic_id'] != $cid)
            {
                $from_mon = $from_mon1 = $from_tue = $from_tue1 = $from_wed = $from_wed1 = $from_thu = $from_thu1 = $from_fri = $from_fri1 = $from_sat = $from_sat1 = $from_sun = $from_sun1 = '';
                $to_mon = $to_mon1 = $to_tue = $to_tue1 = $to_wed = $to_wed1 = $to_thu = $to_thu1 = $to_fri = $to_fri1 = $to_sat = $to_sat1 = $to_sun = $to_sun1 = '' ;
            
                foreach($days as $day){
                    switch($day){
                        case mon:
                            $d_name = 'monday';
                            break;
                        case tue:
                            $d_name = 'tuesday';
                            break;
                        case wed:
                            $d_name = 'wednesday';
                            break;    
                        case thu:
                            $d_name = 'thursday';
                            break;
                        case fri:
                            $d_name = 'friday';
                            break;
                        case sat:
                            $d_name = 'saturday';
                            break;
                        case sun:
                            $d_name = 'sunday';
                            break;    
                    }
                    if($res_practice[$d_name] != '')
                    {
                        $session_dday = explode('-',$res_practice[$d_name]);
                        $from_dday = date('H:i:s',strtotime($session_dday[0]));
                        $to_dday = date('H:i:s',strtotime($session_dday[1]));
                    }
                    
                    if($res_practice[$d_name.'1'] != '')
                    {
                        $session_dday1 = explode('-',$res_practice[$d_name.'1']);
                        $from_dday1 = date('H:i:s',strtotime($session_dday1[0]));
                        $to_dday1 = date('H:i:s',strtotime($session_dday1[1]));
                    }
                    //print $select_time . '>= '. $from_dday .' and '. $select_time .' <= '. $to_dday;print "<br>";
                    if($select_time >= $from_dday and $select_time <= $to_dday){$error = 1;}
                    if($select_time >= $from_dday1 and $select_time <= $to_dday1){$error = 1;}
                    
                }
            }    
        }
    }
    
    return $error;
}


public function match_clinic_and_doctor_time_new($doc_id, $cid, $days, $tym1, $tym2, $tym3, $tym4) 
{
    //print $box_cnt." ".$time_other;   
    $error = 0;
    $tym1 = date('H:i:s',strtotime($tym1));
    $tym2 = date('H:i:s',strtotime($tym2));
    $tym3 = date('H:i:s',strtotime($tym3));
    $tym4 = date('H:i:s',strtotime($tym4));
    
    $clinic_sql = "select `24*7` from clinic where id = '$cid' ";
    $clinic_qur = $this->db->query($clinic_sql);
    $clinic_res = $clinic_qur->fetch_assoc();
    
    if($clinic_res['24*7'] != '24')
    {
        $k = 0;
        foreach($days as $day){
        
            $sql = "select $day,".$day."1 from clinic where id = '$cid' ";
            $query = $this->db->query($sql);
    
            if($query->num_rows>0)
            {
                $data = $query->fetch_assoc();
                $time1 = $data[$day];
                $time2 = $data[$day.'1'];
                $times1 = explode('-',$time1);
                $times2 = explode('-',$time2);
                
                if($times1[0] != ''){$from = date('H:i:s',strtotime($times1[0]));
                }else{$from = '';}
                if($times1[1] != ''){$to = date('H:i:s',strtotime($times1[1]));
                }else{$to = '';}
                
                if($times2[0] != ''){
                    $from1 = date('H:i:s',strtotime($times2[0]));
                    $to1 = date('H:i:s',strtotime($times2[1]));
                }else{
                    $from1 = $to1 = '';
                }
                
                //Session - 1
                if($from1 == '' && $to1 == '')
                {
                    if($tym1 >= $from && $tym1 <= $to){
                        $error = 0;
                    }else{
                        return $error = 1;
                    }
                    if($tym2 >= $from && $tym2 <= $to){
                        $error = 0;
                    }else{
                        return $error = 1;
                    }
                }
                else
                {
                    if($tym1 >= $from && $tym1 <= $to){
                        $error = 0;
                    }else{
                        return $error = 1;
                    }
                    if($tym2 >= $from && $tym2 <= $to){
                        $error = 0;
                    }else{
                        return $error = 1;
                    }
                    
                    if($tym1 >= $from1 && $tym1 <= $to1){
                        $error = 0;
                    }else{
                        return $error = 1;
                    }
                    
                    if($tym2 >= $from1 && $tym2 <= $to1){
                        $error = 0;
                    }else{
                        return $error = 1;
                    }
                }
                
                //Session - 2
                
                if($from1 != '' or $to1 != '')
                {
                    if($to1 != '')
                    {
                        if($from1 > $tym2 and $from1 < $to1)
                        {
                            $error = 0;
                        }else{
                            return $error = 1;;
                        }
                    }else
                    {
                        if($from1 > $tym2)
                        {
                            $error = 0;
                        }else{
                            return  $error = 1;
                        }
                    }
                }
            }
        }
    }
    if($error==1){
        return $error;
    }
    
    $practice_sql = "select * from practice where doctor_id = '$doc_id' and clinic_id != '' ";
    $practice_query = $this->db->query($practice_sql);
    if($practice_query->num_rows > 0)
    {
        while($res_practice = $practice_query->fetch_assoc())
        {
           
            if($res_practice['clinic_id'] != $cid)
            {
                $from_mon = $from_mon1 = $from_tue = $from_tue1 = $from_wed = $from_wed1 = $from_thu = $from_thu1 = $from_fri = $from_fri1 = $from_sat = $from_sat1 = $from_sun = $from_sun1 = '';
                $to_mon = $to_mon1 = $to_tue = $to_tue1 = $to_wed = $to_wed1 = $to_thu = $to_thu1 = $to_fri = $to_fri1 = $to_sat = $to_sat1 = $to_sun = $to_sun1 = '' ;
        
                foreach($days as $day){
                    switch($day){
                        case mon:
                            $d_name = 'monday';
                            break;
                        case tue:
                            $d_name = 'tuesday';
                            break;
                        case wed:
                            $d_name = 'wednesday';
                            break;    
                        case thu:
                            $d_name = 'thursday';
                            break;
                        case fri:
                            $d_name = 'friday';
                            break;
                        case sat:
                            $d_name = 'saturday';
                            break;
                        case sun:
                            $d_name = 'sunday';
                            break;    
                    }
                    
                    $session_dday = '';
                    if($res_practice[$d_name] != '')
                    {
                        $session_dday = explode('-',$res_practice[$d_name]);
                        $from_dday = date('H:i:s',strtotime($session_dday[0]));
                        $to_dday = date('H:i:s',strtotime($session_dday[1]));
                    }
                    
                    if($res_practice[$d_name.'1'] != '')
                    {
                        $session_dday1 = explode('-',$res_practice[$d_name.'1']);
                        $from_dday1 = date('H:i:s',strtotime($session_dday1[0]));
                        $to_dday1 = date('H:i:s',strtotime($session_dday1[1]));
                    }
                    
                        // print $tym1 . '>= '. $from_dday .' and '. $tym1 .' <= '. $to_dday;print "<br>";
                    //Session - 1 Start
                    if($tym1 >= $from_dday and $tym1 <= $to_dday){$error = 1;}
                    if($tym2 >= $from_dday and $tym2 <= $to_dday){$error = 1;}
                    
                    if($tym1 >= $from_dday1 and $tym1 <= $to_dday1){$error = 1;}
                    if($tym2 >= $from_dday1 and $tym2 <= $to_dday1){$error = 1;}
                    
                    //Session - 2 Start
                    if($from_dday1 != '' && $to_dday1 != '')
                    {
                        if($tym3 >= $from_dday and $tym3 <= $to_dday){$error = 1;}
                        if($tym4 >= $from_dday and $tym4 <= $to_dday){$error = 1;}
                        
                        if($tym3 >= $from_dday1 and $tym3 <= $to_dday1){$error = 1;}
                        if($tym4 >= $from_dday1 and $tym4 <= $to_dday1){$error = 1;}
                    }
                    elseif($from_dday1 != '' && $to_dday1 == '')
                    {
                        if($tym3 >= $from_dday and $tym3 <= $to_dday){$error = 1;}
                    }
                }
            }
        }
    }
    
    return $error;
}


public function get_no_of_clinic()
{
    $id = $_SESSION['login_id'];
    $res = $this->db->query("select clinic from doctors where id = '$id' ");
    
    $row = $res->fetch_assoc();
    
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
public function get_doctors_edu_degree_list(){
    
    $sql = " select * from degree ";
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

public function get_doctors_edu_college_list(){
    
    $sql = " select * from collage ";
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
public function get_doctors_service_list($speciality){
    
    $speciality_list  = implode(",",$speciality);

    if(count($speciality) > 1){
        $search = "SELECT specialization from speciality where id in($speciality_list)";
    }else{
        if(!is_numeric($speciality_list)){
            $search = "'$speciality_list'";
        }else{
            $search = "SELECT specialization from speciality where id in($speciality_list)";
        }
    }
    
    $sql = " select * from services_for_seo_use where speciality in ($search) ";
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

public function get_doctors_membership_list(){
    
    $sql = " select * from membership ";
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
public function get_doctors_council_list(){
    
    $sql = " select * from council ";
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

public function check_doctor_fisrt_clinic($doctor_id){
    
    $val = 0;
    $sql = "select id from clinic where doctor_id = '$doctor_id' ";
    $query = $this->db->query($sql);
    if($query->num_rows > 0){
        $val = 1;
    }else{
        
        $sql1 = "select clinic from doctors where id = '$doctors_id' and clinic != '' ";
        $query1 = $this->db->query($sql1);
        if($query1->num_rows > 0){
            $val = 1;
        }
    }
    return $val;
}

public function get_state_name_by_city($city){
    
    $state_name = '';
    $sql = "select state from area_name where district = '$city' limit 1 ";
    $query = $this->db->query($sql);
    if($query->num_rows>0){
        $result = $query->fetch_assoc();
        $state_name = $result['state'];
    }
    return $state_name;
}
public function get_all_city_list(){
    
    $sql = "SELECT DISTINCT district FROM `area_name` ";
    $query = $this->db->query($sql);
    
    while($row = $query->fetch_assoc())
    {
        $citys[] =  $row['district'];
    }
    return $citys;
}

public function getPracticeDetail($id, $clinic_id, $table){

	$res = $this->db->query("SELECT * FROM `$table` WHERE clinic_id = '{$clinic_id}' and doctor_id = '$id' ");

	$str = '';
		if($res->num_rows > 0){
			return $res->fetch_assoc();
	}
}

public function admin_doctor_login($id) {


 $res=  $this->db->query("SELECT * FROM doctors where  id='$id' AND type = 'Doctor'");
 
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

public function get_data_by_id($value, $table, $field)
{
    $sql = "select $field from $table where id in($value)";
    $query = $this->db->query($sql);
    while($row = $query->fetch_assoc()){
        $result[] = $row[$field];
    }
    return $result;
}

public function get_pincode_option($city,$area){
    
    $sel_opetions = '';
    $sql = "select pincode from area_name where district = '$city' and area = '$area' ";
    $query = $this->db->query($sql);
    $sel_opetions = '<select name="pincode" id="pincode"  class="add-event-input" value="">';
    while($row_data = $query->fetch_assoc())
    {
        $sel_opetions .= "<option value='".$row_data['pincode']."'>".$row_data['pincode']."</option>";   
    }
    $sel_opetions .= "</select>";
    return $sel_opetions;
}

public function get_lat_long($address) {
    
    $url = "http://maps.google.com/maps/api/geocode/json?address=".urlencode($address)."&sensor=false&region=India";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($ch);
    curl_close($ch);
    $response_a = json_decode($response);
    $result['lat'] = $response_a->results[0]->geometry->location->lat;
    $result['long'] = $response_a->results[0]->geometry->location->lng;
    
    return $result;
}

public function check_practice_for_sidebar($id) {
    
    $res = $this->db->query("select * from practice where doctor_id='$id'");
    if($res->num_rows > 0){
        
        return true;
    }
    else {
        
        return false;
    }
}

public function check_doc_status($id) {
    
    $res = $this->db->query("select status from doctors where id='$id'");
    
    if($res->num_rows > 0){
        
        $data = $res->fetch_assoc();
        
        return $data['status'];
    }
}

public function insert_blog_data($title, $pic, $texteditor, $dt2) {
    
    $sql = "INSERT INTO wp_posts (post_title, post_name, guid, post_date, post_date_gmt,post_status,  post_type, post_content, post_modified, post_modified_gmt, comment_status, ping_status  ) VALUES ('$title', '$title', '$pic', '$dt2', '$dt2','publish', 'post', '$texteditor', '$dt2','$dt2','closed', 'closed')" ; 
    
    
    $query = $this->db_blog->query($sql);
     
    
    if($query){
        return true;
    }
}


public function last_id_fetch_blog($title1, $texteditor1) {
    
    $sql = "select * from wp_posts where post_title='$title1' and post_content='$texteditor1' order by ID desc Limit 1";
    $res = $this->db_blog->query($sql);

    if($res->num_rows > 0){
        $dataselect = $res->fetch_assoc();
        return  $dataselect['ID'];
    }
}


public function last_id_fetch_blog_temp($title2, $texteditor2) {
    
    $sql1 = "select * from wp_temp_posts where post_title='$title' and post_content='$texteditor2' order by ID desc Limit 1";
    $res1 = $this->db_blog->query($sql1);

    if($res1->num_rows > 0){
        $dataselect1 = $res1->fetch_assoc();
        return  $dataselect1['ID'];
    }
}



public function get_patient_mob() {
    
    $sq = "select * from phone_no where patient phone_no='$phone_no'";
    $res = $this->db->query($sql);

    if($res->num_rows > 0){
        $dataselect = $res->fetch_assoc();
        return  $dataselect['phone_no'];
    }
}


public function get_doctor_mob() {
    
    $sq = "select * from phone_no where doctors phone_no='$phone_no'";
    $res = $this->db->query($sql);

    if($res->num_rows > 0){
        $dataselect = $res->fetch_assoc();
        return  $dataselect['phone_no'];
    }
}


public function insert_img_blog($title, $pic, $texteditor, $dt2, $last_insert_id, $url) {
    
    $sql = "INSERT INTO wp_posts (post_title, post_name, guid, post_date, post_date_gmt,post_status,  post_type, post_mime_type, post_content, post_parent, post_modified, post_modified_gmt) VALUES ('$pic', '$pic', '$url', '$dt2', '$dt2','inherit', 'attachment', 'image/jpeg',  '$texteditor','$last_insert_id', '$dt2','$dt2')" ; 
  $post_url =  base_url .'/blog/?p='.$last_insert_id;
    $query = $this->db_blog->query($sql);
     
     echo  $update_blog = "UPDATE wp_posts set guid ='$post_url' where ID ='$last_insert_id'";
     $query1 = $this->db_blog->query($update_blog);
     
  
         if($query){
        return true;
    }
    
    
}

public function last_id_fetch_media($pic, $last_insert_id) {
    
    $sql = "select * from wp_posts where post_title='$pic' and post_parent='$last_insert_id' order by ID desc Limit 1";
    $res = $this->db_blog->query($sql);

    if($res->num_rows > 0){
        $dataselect = $res->fetch_assoc();
        return  $dataselect['ID'];
    }
}

public function insert_img_metadata($last_media_id) {
    
    $sql = "INSERT INTO wp_postmeta (post_id, meta_key ,meta_value) VALUES ('$last_media_id', '', '')" ; 
    $query = $this->db_blog->query($sql);
    $valuearray= array('_edit_lock','_edit_last','_thumbnail_id','_disable_fbc','_oss_meta');
    $valuemetakey= array('','',$last_media_id,'','0');
    for($i=0; $i<5; $i++){
    $val = $valuearray[$i];
    $val1 = $valuemetakey[$i];
      $sqlval = "INSERT INTO wp_postmeta (post_id, meta_key ,meta_value) VALUES ('$last_media_id', '  $val', ' $val1')" ;    
      $query1 = $this->db_blog->query($sqlval);
    }
    
    
    if($query){
        return true;
    }
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

public function check_clinic_time_in_doctor_time($session1_1, $session1_2, $session1_3, $session1_4, $session2_1, $session2_2, $session2_3, $session2_4, $cid){
    
    $session1_1 = date('H:i:s',strtotime($session1_1));
    $session1_2 = date('H:i:s',strtotime($session1_2));
    $session1_3 = date('H:i:s',strtotime($session1_3));
    $session1_4 = date('H:i:s',strtotime($session1_4));
    
    $session2_1 = date('H:i:s',strtotime($session2_1));
    $session2_2 = date('H:i:s',strtotime($session2_2));
    $session2_3 = date('H:i:s',strtotime($session2_3));
    $session2_4 = date('H:i:s',strtotime($session2_4));
    
    //$session1_1.' '.$session1_2.' '.$session1_3.' '.$session1_4.' '.$session2_1.' '.$session2_2.' '.$session1_3.' '.$session1_4.' '.$cid;
}

public function event_camp_adv($event_name,$org_by,$from_date,$to_date,$time_from,$time_to,$country,$state,$city,$area,$address,$des,$bullets,$contact,$reg,$catgo) {

$doc_id = $_SESSION['login_id'];
$created = date("Y-m-d");
$points = json_encode($bullets); 
    $res = $this->db->query("insert into event_camp(doctor_id,name,organised,from_date,to_date,from_time,to_time,country,state,city,area,address,description,points,contact,status,created_on,category,reg_amount)
                            values('$doc_id','$event_name','$org_by','$from_date','$to_date','$time_from','$time_to','$country','$state','$city','$area','$address','$des','$points','$contact','Pending','$created','$catgo','$reg')");

return true;
}

public function event_adv_show(){
    //<table class="table table-bordered table-striped table-hover dataTable js-exportable">
    $str='';
    $str='  <div class="col-sm-12 table-responsive" > <table id="vitalsign" class="table patient-profile-tables table-striped " >
                                <thead>
                                    <tr>
                                        <th>Event/Camp</th>
                                        <th>Category</th>
                                        <th>Organised By</th>
                                         <th>From</th>
                                        <th>To</th>
                                        <th>Created on</th>
                                        <th>Action</th>
                                        
                                    </tr>
                                </thead>
                                 <tbody>';
    
    $doctor_id=$_SESSION['login_id'];
    $res = $this->db->query("select * from event_camp where doctor_id='$doctor_id'");
    if($res->num_rows > 0){

        while($data=$res->fetch_assoc()){

           $str.=' <tr>
                                        
                                        <td>'.$data['name'].'</td>
                                        <td>'.$data['category'].'</td>
                                        <td>'.$data['organised'].'</td>
                                        <td>'.$data['from_date'].'</td>
                                        <td>'.$data['to_date'].'</td>
                                        <td>'.$data['created_on'].'</td>
                                        <td>'.'<a class="patient-list-buttons glyphicon glyphicon-pencil editvitalbutton" href='.base_url_doc.'event_camp.php?edit='.$data['id'].'></a></td>
                                        
                                
                                    </tr>
                                   ';
        
        }   
    }
    $str.=' </tbody></table></div>'; 

        return $str;
    }

public function edit_event_adv($id){

    $res = $this->db->query("select * from event_camp where id='$id'");

    if($res->num_rows > 0){

        return $res->fetch_assoc();
    }
}




public function update_event_camp_adv($id,$event_name,$org_by,$from_date,$to_date,$time_from,$time_to,$country,$state,$city,$area,$address,$des,$bullets,$contact,$reg,$catgo) {

    $points = json_encode($bullets); 
    $res = $this->db->query("update event_camp set name='$event_name', organised='$org_by', from_date='$from_date', to_date='$to_date', from_time='$time_from',to_time='$time_to',country='$country',state='$state',city='$city',area='$area',address='$address',description='$des',points='$points',contact='$contact',reg_amount='$reg',category='$catgo' where id='$id'");
   //print update event_camp set name='$event_name', organised='$org_by', from_date='$from_date', to_date='$to_date', from_time='$time_from',to_time='$time_to',country='$country',state='$state',city='$city',area='$area',address='$address',description='$des',points='$points',contact='$contact',reg_amount='$reg',category='$category' ";
//die();
    if(res) {
        $_SESSION['event_adv']=true;
    }
header('location:'.base_url_doc.'event_camp.php');
}

// public function display_recent_blogs()
// {
//     $id=$_SESSION['login_id'];

//     $res = $this->db_blog->query("SELECT * FROM wp_posts where post_author='$id' order by ID desc ");
    
//     $rows = array();
//     while($r = $res->fetch_assoc()){
//         $rows[] = $r;
//     }
//     return $rows;    
// }
public function display_recent_blogs()
{
    $id=$_SESSION['login_id'];
    $sql = "SELECT * FROM wp_posts as t1 where t1.post_author='$id' order by t1.ID desc ";
    $res=$this->db_blog->query($sql);
    
    $rows = array();
    while($r = $res->fetch_assoc())
    {
        $rows[] = $r;
    }
    $result = json_encode($rows);
    return $result;    
}


public function display_recent_blogs_edit($blog_id)
{

    $sql = "SELECT * FROM wp_posts  where ID='$blog_id'";

    $res=$this->db_blog->query($sql);
    
    if($res->num_rows > 0){

        $data = $res->fetch_assoc();
        return $data;
    }    
}


public function get_wordpress_data_by_id($value, $table, $field)
{
    $sql = "select $field from $table where id in($value)";
    $query = $this->db_blog->query($sql);
    while($row = $query->fetch_assoc()){
        $result[] = $row[$field];
    }
    return $result;
}



public function getById_doctor_id($id,$table, $phone_no){
        //$id=$_SESSION['login_id'];

        $res = $this->db->query("SELECT * FROM doctors");
        //$res = $this->db->query("SELECT * FROM $table WHERE id='$id'");
        
        while($row = $query->fetch_assoc()){
        $result[] = $row[$field];
    }
            

    }






}
$functions = new Functions();

?>