<?php  //random_string('alnum',20)


class invoiceModel extends CI_Model{

	public function invoiceModelInsert($data){

			$rData = $this->db->insert('invoice', $data); 
			$status = $this->db->trans_status();
			return array($this->db->insert_id(), $status);
	}
	public function invoiceDetailsModelInsert($data){

			$rData = $this->db->insert('invoiceDetails', $data); 
			$status = $this->db->trans_status();
			return array($this->db->insert_id(), $status);
	}
	
	public function getInvoiceList(){

		 $this->db->select('invoiceId, invoiceUniqId, invoiceNo, invoiceDate, invoiceCustomerId, invoiceNetTotal, customerName, branchName');
		 $this->db->from('invoice');
		 $this->db->where('invoiceStatus', 0);
		 $this->db->join('customers', 'customers.customerId = invoice.invoiceCustomerId', 'left');
		 $this->db->join('branch', 'branch.branchId = invoice.invoiceBranchId', 'left');
		 $query = $this->db->get()->result();
		 return $query;
	}

	public function editInvoice(){
		
		$id   = $this->UtilityMethods->getId('invoiceId','invoice','invoiceUniqId', $this->uri->segment(3) );

		$where1 = array( "invoiceStatus"=>0, "invoiceId"=>$id );
			$this->db->select('A.*, customerName, branchName, customerAddress');
			$this->db->from('invoice A');
			$this->db->where($where1);
			$this->db->join('customers', 'customers.customerId = A.invoiceCustomerId', 'left');
			$this->db->join('branch', 'branch.branchId = A.invoiceBranchId', 'left');
			$query1 = $this->db->get()->row();

		$where2 = array( "invoiceDetailsStatus"=>0, "invoiceDetailsInvoiceId"=>$id );
			$this->db->select('B.*, productName, productCode');
			$this->db->from('invoiceDetails B');
			$this->db->where($where2);
			$this->db->join('products', 'products.productId = B.invoiceDetailsProductId', 'left');
			$query2 = $this->db->get()->result();



		return array($query1, $query2);
	}

	public function invoiceModelUpdate($data, $id){

		$this->db->set($data);
		$this->db->where('invoiceId', $id);
		$this->db->update('invoice');
		$status = $this->db->trans_status();
		return array($id, $status);
	} 
	
	public function invoiceDetailsModelUpdate($data, $where){

		$this->db->set($data);
		$this->db->where($where);
		$this->db->update('invoiceDetails'); 
		$status = $this->db->trans_status();
		return array($where['invoiceDetailsId'], $status);
	}
	
	public function recordDetailDelete($table, $data, $field, $id)
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

	public function editInvoicePrint($id){
		
		

		$where1 = array( "invoiceStatus"=>0, "invoiceId"=>$id );
			$this->db->select('A.*, customerName, branchName');
			$this->db->from('invoice A');
			$this->db->where($where1);
			$this->db->join('customers', 'customers.customerId = A.invoiceCustomerId', 'left');
			$this->db->join('branch', 'branch.branchId = A.invoiceBranchId', 'left');
			$query1 = $this->db->get()->row();

		$where2 = array( "invoiceDetailsStatus"=>0, "invoiceDetailsInvoiceId"=>$id );
			$this->db->select('B.*, productName, productCode');
			$this->db->from('invoiceDetails B');
			$this->db->where($where2);
			$this->db->join('products', 'products.productId = B.invoiceDetailsProductId', 'left');
			$query2 = $this->db->get()->result();

				

		return array($query1, $query2);
	}
 


}
?>
