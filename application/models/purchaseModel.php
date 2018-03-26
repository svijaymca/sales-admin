<?php  //random_string('alnum',20)


class purchaseModel extends CI_Model{

	public function purchaseModelInsert($data){

			$rData = $this->db->insert('purchase', $data); 
			$status = $this->db->trans_status();
			return array($this->db->insert_id(), $status);
	}
	public function purchaseDetailsModelInsert($data){

			$rData = $this->db->insert('purchaseDetails', $data); 
			$status = $this->db->trans_status();
			return array($this->db->insert_id(), $status);
	}
	
	public function getPurchaseList(){

		 $this->db->select('purchaseId, purchaseUniqId, purchaseNo, purchaseDate, purchaseSupplierId, purchaseNetTotal, supplierName, branchName');
		 $this->db->from('purchase');
		 $this->db->where('purchaseStatus', 0);
		 $this->db->join('suppliers', 'suppliers.supplierId = purchase.purchaseSupplierId', 'left');
		 $this->db->join('branch', 'branch.branchId = purchase.purchaseBranchId', 'left');
		 $query = $this->db->get()->result();
		 return $query;
	}

	public function editPurchase(){
		
		$id   = $this->UtilityMethods->getId('purchaseId','purchase','purchaseUniqId', $this->uri->segment(3) );

		$where1 = array( "purchaseStatus"=>0, "purchaseId"=>$id );
			$this->db->select('A.*, supplierName, branchName');
			$this->db->from('purchase A');
			$this->db->where($where1);
			$this->db->join('suppliers', 'suppliers.supplierId = A.purchaseSupplierId', 'left');
			$this->db->join('branch', 'branch.branchId = A.purchaseBranchId', 'left');
			$query1 = $this->db->get()->row();

		$where2 = array( "purchaseDetailsStatus"=>0, "purchaseDetailsPurchaseId"=>$id );
			$this->db->select('B.*, productName, productCode');
			$this->db->from('purchaseDetails B');
			$this->db->where($where2);
			$this->db->join('products', 'products.productId = B.purchaseDetailsProductId', 'left');
			$query2 = $this->db->get()->result();



		return array($query1, $query2);
	}

	public function purchaseModelUpdate($data, $id){

		$this->db->set($data);
		$this->db->where('purchaseId', $id);
		$this->db->update('purchase');

		return true;

	} 

	
 


}
?>
