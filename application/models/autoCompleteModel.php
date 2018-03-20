<?php  
class autoCompleteModel extends CI_Model{

	public function gerSupplierData($term){

			$this->db->select('*')->from('suppliers'); 
			$this->db->where("supplierStatus = 0 AND (supplierName LIKE '%".$term."%' OR supplierCode LIKE '%".$term."%' ) ");
			$query = $this->db->get();     
			//echo $this->db->last_query(); exit;
        return $query->result(); 
	}

}
?>