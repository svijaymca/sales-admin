<?php  //random_string('alnum',20)


class customerModel extends CI_Model{

	public function customerModelInsert($data){

			$rData = $this->db->insert('Customers', $data);
			return $rData;
	}
	public function getCustomerList(){

		 $this->db->select('*');
		 $this->db->from('Customers');
		 $this->db->where('CustomerStatus', 0);
		 $query = $this->db->get()->result();
		 return $query;
	}

	public function editCustomer(){
		$id   = $this->uri->segment(3);
		$where = array( "CustomerStatus"=>0, "CustomerUniqId"=>$id );
			$this->db->select('*');
			$this->db->from('Customers');
			$this->db->where($where);
			$query = $this->db->get()->row();
		return $query;
	}

	public function customerModelUpdate($data, $id){

		$this->db->set($data);
		$this->db->where('CustomerId', $id);
		$this->db->update('Customers');

		return true;

	} 

	
 


}
?>