<?php
header('Content-Type: text/html; charset=ISO-8859-1');
ini_set("display_errors",'off');

//define('base_url', 'http://clients2.jprportal.com/doctor/');
//define('base_url_admin', 'http://clients2.jprportal.com/doctor/admin/');
//define('base_url_doc', 'http://clients2.jprportal.com/doctor/doc_panel/');
//define('base_url_patient', 'http://clients2.jprportal.com/doctor/patient_panel/');
//define('base_url_yoga', 'http://clients2.jprportal.com/doctor/yoga/');

//define('base_url', 'http://192.168.0.101/doctor/');
//define('base_url_admin', 'http://192.168.0.101/doctor/admin/');
//define('base_url_doc', 'http://192.168.0.101/doctor/doc_panel/');
//define('base_url_patient', 'http://192.168.0.101/doctor/patient_panel/');
//define('base_url_yoga', 'http://192.168.0.101/doctor/yoga/');
//define('base_url_hospital', 'http://192.168.0.101/doctor/hospital/');
//define('base_url_lab', 'http://192.168.0.101/doctor/lab_panel/');
//define('base_url_gyms', 'http://192.168.0.101/doctor/gyms/');
//define('base_url_ayush', 'http://192.168.0.101/doctor/ayush_panel/');

define('base_url', 'http://localhost/docconsult/');
define('base_url_admin', 'http://localhost/docconsult/admin/');
define('base_url_doc', 'http://localhost/docconsult/doc_panel/');
define('base_url_patient', 'http://localhost/docconsult/patient_panel/');
define('base_url_yoga', 'http://localhost/docconsult/yoga/');
define('base_url_hospital', 'http://localhost/docconsult/hospital/');
define('base_url_lab', 'http://localhost/docconsult/lab_panel/');
define('base_url_gyms', 'http://localhost/docconsult/gyms/');
define('base_url_ayush', 'http://localhost/docconsult/ayush_panel/');
define('base_url_pharma', 'http://localhost/docconsult/pharma/');
define('base_url_subadmin', 'http://localhost/docconsult/subadmin/');
define('base_url_image','http://localhost/docconsult/image/');
define('sender_id', 'DEMOOO');

define('date', date('d-m-Y'));
define('mailhost', "docconsult.in");
define('smtpUser', 'mail@docconsult.in');
define('smtpPassword', 'telekast@123');	



class Config {
	public function connection(){
		$host = 'localhost';
		//$db_user = 'jprporta_doctor';
		//$db_pass = 'L#O~OQ!4){kf';
		//$db_name = 'jprporta_doctor';
		
		//$db_user = 'root';
		//$db_pass = '';
		//$db_name = 'doctors';
		
		$db_user = 'root';
		$db_pass = '';
		$db_name = 'docconsu_db';
		$db = new mysqli($host, $db_user, $db_pass, $db_name);
		if($db->connect_error) {
				die('Could Not Connect: ' . $db->connect_error);
		}
		return $db;
	}
}

class Config_blog {
	public function connection() 
	{
		$host = 'localhost';
		
		
// 		$db_user = 'rajatsingh';
// 		$db_pass = 'rajat@123';
// 		$db_name = 'rajatsin_wp';
        
        $db_user = 'root';
		$db_pass = '';
		$db_name = 'docconsu_wp';

		
		
		$db = new mysqli($host, $db_user, $db_pass, $db_name);
		if($db->connect_error) {
				die('Could Not Connect: ' . $db->connect_error);
		}
		return $db;
		
	}
}
?>
