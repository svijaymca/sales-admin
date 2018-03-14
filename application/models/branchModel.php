<?php  //random_string('alnum',20)


class branchModel extends CI_Model{

	public function branchModelInsert($data){

			$rData = $this->db->insert('branch', $data);
			return $rData;
	}
	public function getBranchList(){

		 $this->db->select('*');
		 $this->db->from('branch');
		 $this->db->where('branchStatus', 0);
		 $query = $this->db->get()->result();
		 return $query;
	}

	public function editBranch(){
		$id   = $this->uri->segment(3);
		$where = array( "branchStatus"=>0, "branchUniqId"=>$id );
			$this->db->select('*');
			$this->db->from('branch');
			$this->db->where($where);
			$query = $this->db->get()->row();
		return $query;
	}

	public function branchModelUpdate($data, $id){

		$this->db->set($data);
		$this->db->where('branchId', $id);
		$this->db->update('branch');

		return true;

	} 

	
 


}
?>