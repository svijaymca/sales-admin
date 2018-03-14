<?php 

class utilityMethods extends CI_Model{

	public function __construct() {
		parent::__construct();
		
		$taxTypes = array('1' => 'CGST & SGST', '2' => 'IGST', '3' => 'OTHERS', '4' => 'WITHOUT TAX'  );

	}

	public function listBranch(){ 

		$this->db->select('*');
		$this->db->from('branch');
		$this->db->where('branchStatus', 0);
		$query = $this->db->get()->result();
		
		return $query;

	}

	public function loginAuthentication(){
		
		if(!isset($this->session->userdata['logged_in']['user_id'])) {
			redirect(base_url()); 
			exit();
		}	
	}

	public function generatePassword($password) {
			$password = md5($password);
			$generate_password = substr($password,0,7).$this->generateRandomString(3).substr($password,7,4).$this->generateRandomString(5).substr($password,11,22);
		return $generate_password;
	}

	public function getRealPassword($password) {

			$real_password = substr($password,0,7).substr($password,10,4).substr($password,19,21); 
		return $real_password;
	}

	public function generateRandomString($length) {
	
			$alphabet = "0123456789abcdefghijklmnopqrstuvwxyz";
			$pass = array();
			$alphaLength = strlen($alphabet) - 1;
			for ($i = 0; $i < $length; $i++) {
				$n = rand(0, $alphaLength);
				$pass[] = $alphabet[$n];
			}
		return implode($pass);
	}


	public function createDateRangeArray($strDateFrom,$strDateTo) {
	  // takes two dates formatted as YYYY-MM-DD and creates an
	  // inclusive array of the dates between the from and to dates.
	
	  // could test validity of dates here but I'm already doing
	  // that in the main script
	//echo $strDateFrom."<br>";
	//echo $strDateTo; exit; 
	  	$aryRange=array();
	
	  	$iDateFrom=mktime(1,0,0,substr($strDateFrom,5,2),     substr($strDateFrom,8,2),substr($strDateFrom,0,4));
	  	$iDateTo=mktime(1,0,0,substr($strDateTo,5,2),     substr($strDateTo,8,2),substr($strDateTo,0,4));
	
	  		if ($iDateTo>=$iDateFrom) {
				array_push($aryRange,date('Y-m-d',$iDateFrom)); // first entry
	
				while ($iDateFrom<$iDateTo) {
				  $iDateFrom+=86400; // add 24 hours
				  array_push($aryRange,date('Y-m-d',$iDateFrom));
				}
	  		}
	  	return $aryRange;
	}

	public function searchArryList($arr, $value) {

		$result = ' ';
		foreach($arr as $arr_value => $arr_list) {
			if($arr_value == $value) {
				$result = $arr_list;
			}
		}
	return $result;
	}

// Upload file
	public function fileUpload($file_name, $file_tmp_name, $file_rename, $path) {
	
		$file_rename     = preg_replace('/[^a-zA-Z0-9]/s', '-', $file_rename);
		
		$file_extn       = explode('.',$file_name);
		$file_name_space = str_replace(' ','-',strtolower($file_rename));
		$file_new_name   = $file_name_space.'-'.uniqid().'.'.$file_extn[1];//echo $file_new_name; exit;
			if(!file_exists($path)) {
				mkdir($path);
			}

			if(move_uploaded_file($file_tmp_name,$path.$file_new_name)) {
				//echo 'upload';
			} else {
				//echo 'Test';
			}
	
		return $file_new_name;	
	}

	public function getRealIpAddr(){

		if (!empty($_SERVER['HTTP_CLIENT_IP'])){
			$ip=$_SERVER['HTTP_CLIENT_IP'];
		}elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
			$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
		}else{
				$ip=$_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}	

	public function dateTimeDisplayFormat($date_time){
		return date("j-M-Y h:i A", $date_time);
	}

	public function dateGeneralFormat($date){
		$date = implode('/', array_reverse(explode('-', $date))); 
		return $date;
	}

	public function dateDatabaseFormat($date){
		$date = implode('-', array_reverse(explode('/', $date)));
		return $date;
	}

	public function getId($id_name, $table_name, $uniqid_name, $uniq_id){ 

		$condition = $uniqid_name." = '".$uniq_id."' ";
		$this->db->select($id_name);
		$this->db->from($table_name);
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();
			$row = $query->row();
		return $row->$id_name;

	}

	public function recordDelete($table, $data, $field, $id)
	{


		if(!empty($id)){	
			$this->db->set($data); 
			$this->db->where($field, $id);
			$this->db->update($table);  

			return true;

		}else{

			return false;
		}

	} 

	public function getExistOrNot($table_name, $field, $val, $status){ 
		 $condition = $field." = '".$val."'  AND " .$status." = 0 ";
			$this->db->select($field);
			$this->db->from($table_name);
			$this->db->where($condition);
			 $query = $this->db->get();
			
		return $query->num_rows(); 

	}

}


?>