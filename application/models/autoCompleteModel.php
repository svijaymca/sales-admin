<?php  ////echo $this->db->last_query(); exit;
class autoCompleteModel extends CI_Model{
	
	public function gerProductData($term){
			$this->db->select('*')->from('products'); 
			$this->db->where("productStatus = 0 AND (productName LIKE '%".$term."%' OR productCode LIKE '%".$term."%' ) ");
			$query = $this->db->get();     
        return $query->result(); 
	}
	
	public function gerSupplierData($term){
			$this->db->select('*')->from('suppliers'); 
			$this->db->where("supplierStatus = 0 AND (supplierName LIKE '%".$term."%' OR supplierCode LIKE '%".$term."%' ) ");
			$query = $this->db->get();     
        return $query->result(); 
	}
	
	public function gerCustomerData($term){
			$this->db->select('*')->from('customers'); 
			$this->db->where("customerStatus = 0 AND (customerName LIKE '%".$term."%' OR customerCode LIKE '%".$term."%' ) ");
			$query = $this->db->get();     
        return $query->result(); 
	}

	public function gerStock($brId, $prdId){

		$where = array(
				'stockLedgerStatus' 	=> 0,
				'stockLedgerBranchId' 	=> $brId,
				'stockLedgerProductId' 	=> $prdId );

			$this->db->select('SUM(stockLedgerQty) as qty')->from('stockLedger'); 
			$this->db->where($where);
			$record = $this->db->get()->row(); 
			    
        return $record->qty; 
	}
	

}
?>
