<?php  //random_string('alnum',20)


class productModel extends CI_Model{

	public function productModelInsert($data){

			$rData = $this->db->insert('products', $data);
			return $rData;
	}
	public function getProductList(){

		 $this->db->select('*');
		 $this->db->from('products');
		 $this->db->where('productStatus', 0);
		 $query = $this->db->get()->result();
		 return $query;
	}

	public function editProduct(){
		$id   = $this->uri->segment(3); 
		$where = array( "productStatus"=>0, "productUniqId"=>$id );
			$this->db->select('*');
			$this->db->from('products');
			$this->db->where($where);
			$query = $this->db->get()->row();
		return $query;
	}

	public function productModelUpdate($data, $id){

		$this->db->set($data);
		$this->db->where('productId', $id);
		$this->db->update('products');

		return true;

	} 

	
 


}
?>