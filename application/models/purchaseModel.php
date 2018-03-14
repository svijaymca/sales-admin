<?php  //random_string('alnum',20)


class purchaseModel extends CI_Model{

	public function purchaseModelInsert($data){

			$rData = $this->db->insert('purchase', $data);
			return $rData;
	}
	
	public function getPurchaseList(){

		 $this->db->select('*');
		 $this->db->from('purchase');
		 $this->db->where('purchaseStatus', 0);
		 $query = $this->db->get()->result();
		 return $query;
	}

	public function editPurchase(){
		$id   = $this->uri->segment(3);
		$where = array( "purchaseStatus"=>0, "purchaseUniqId"=>$id );
			$this->db->select('*');
			$this->db->from('purchase');
			$this->db->where($where);
			$query = $this->db->get()->row();
		return $query;
	}

	public function purchaseModelUpdate($data, $id){

		$this->db->set($data);
		$this->db->where('purchaseId', $id);
		$this->db->update('purchase');

		return true;

	} 

	
 


}
?>