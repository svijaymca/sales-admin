<?php  //random_string('alnum',20)


class supplierModel extends CI_Model{

	public function supplierModelInsert($data){

			$rData = $this->db->insert('suppliers', $data);
			return $rData;
	}
	
	public function getSupplierList(){

		 $this->db->select('*');
		 $this->db->from('suppliers');
		 $this->db->where('supplierStatus', 0);
		 $query = $this->db->get()->result();
		 return $query;
	}

	public function editSupplier(){
		$id   = $this->uri->segment(3);
		$where = array( "supplierStatus"=>0, "supplierUniqId"=>$id );
			$this->db->select('*');
			$this->db->from('suppliers');
			$this->db->where($where);
			$query = $this->db->get()->row();
		return $query;
	}

	public function supplierModelUpdate($data, $id){

		$this->db->set($data);
		$this->db->where('supplierId', $id);
		$this->db->update('suppliers');

		return true;

	} 

	
 


}
?>