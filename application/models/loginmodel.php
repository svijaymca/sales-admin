<?php 
class LoginModel extends CI_Model{

	public function userAuthentication($data){
			

			$condition = "user_username = '".$data['username']."' "; 
			$this->db->select('*');
			$this->db->from('users');
			$this->db->where($condition);
			$this->db->limit(1);
			$query = $this->db->get(); 

			if ($query->num_rows() == 1) {
				return true;
			} else {
				return false;
			}
	}


	public function read_user_information($username) {

		$condition = "user_username = '".$username."' ";
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();

			if ($query->num_rows() == 1) {
				return $query->result();
			} else {
				return false;
			}
	}

}

?>