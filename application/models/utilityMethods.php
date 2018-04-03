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


	public function stockLedger($type, $detailId, $date, $productId, $branchId, $qty, $ledgerStatus){

		$wh	= array('stockLedgerStatus'=> 0, 'stockLedgerType'=> $type, 'stockLedgerId' => $detailId, 'stockLedgerProductId' => $productId, 'stockLedgerBranchId' 	=> $branchId );

		$this->db->select('*');
		$this->db->from('stockLedger');
		$this->db->where($wh);
		$query 		= $this->db->get();
		$record 	= $query->result();
		$rows 		= $query->num_rows();

		if($ledgerStatus !='DELETE'){

		if($rows == 0){

			$data = array(
				'stockLedgerType' 		=> $type,
				'stockLedgerDetailId' 	=> $detailId,
				'stockLedgerDate' 		=> $date,
				'stockLedgerProductId' 	=> $productId,
				'stockLedgerBranchId' 	=> $branchId,
				'stockLedgerQty' 		=> $qty,
				'stockLedgerAddedBy' 	=> $this->session->userdata['logged_in']['user_id'],
				'stockLedgerAddedOn' 	=> NOW(),
				'stockLedgerAddedIp' 	=> $this->UtilityMethods->getRealIpAddr() );

			$rData = $this->db->insert('stockLedger', $data); 
			$status = $this->db->trans_status();
			return array($status);

		}else{

			$data = array(
				'stockLedgerType' 		=> $type,
				'stockLedgerDate' 		=> $date,
				'stockLedgerProductId' 	=> $productId,
				'stockLedgerBranchId' 	=> $branchId,
				'stockLedgerQty' 		=> $qty,
				'stockLedgerModifiedBy' => $this->session->userdata['logged_in']['user_id'],
				'stockLedgerModifiedOn' => NOW(),
				'stockLedgerModifiedIp' => $this->UtilityMethods->getRealIpAddr() );

			$where	= array( 'stockLedgerId' 	=> $record['stockLedgerId']);

			$this->db->set($data);
			$this->db->where($where);
			$this->db->update('stockLedger'); 
			$status = $this->db->trans_status();

			return array($status);
		}

		}else{
			

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

	public function getNo($table_name, $field, $branch_field, $branch_val, $status){

			$condition = $branch_field." = '".$branch_val."'  AND " .$status." = 0 ";
			$this->db->select_max($field);
			$this->db->from($table_name);
			$this->db->where($condition);
			 $query = $this->db->get(); //echo  $this->db->last_query(); exit;
			 $row 	= $query->row();

		return $row->$field;
	}

	public function numberToWords($number){

		   $no = round($number);
		   $point = sprintf("%.3f",substr($number, -2));
		   $hundred = null;
		   $digits_1 = strlen($no);
		   $i = 0;
		   $str = array();
		   $words = array('0' => '', '1' => 'one', '2' => 'two',
		    '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
		    '7' => 'seven', '8' => 'eight', '9' => 'nine',
		    '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
		    '13' => 'thirteen', '14' => 'fourteen',
		    '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
		    '18' => 'eighteen', '19' =>'nineteen', '20' => 'twenty',
		    '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
		    '60' => 'sixty', '70' => 'seventy',
		    '80' => 'eighty', '90' => 'ninety');
		   $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
		   while ($i < $digits_1) {
		     $divider = ($i == 2) ? 10 : 100;
		     $number = floor($no % $divider);
		     $no = floor($no / $divider);
		     $i += ($divider == 10) ? 1 : 2;
		     if ($number) {
		        $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
		        $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
		        $str [] = ($number < 21) ? $words[$number] .
		            " " . $digits[$counter] . $plural . " " . $hundred
		            :
		            $words[floor($number / 10) * 10]
		            . " " . $words[$number % 10] . " "
		            . $digits[$counter] . $plural . " " . $hundred;
		     } else $str[] = null;
		  }
		  $str = array_reverse($str);
		  $result = implode('', $str);
		  $points = ($point>0) ? "" . $words[$point / 10] . " " . $words[$point = $point % 10] : '';

		  return $result . "Rupees  and ".$points." Paise";
	}

}


?>
