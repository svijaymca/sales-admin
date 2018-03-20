<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class autoCompleteData extends CI_Controller {

	function __construct() { 
		parent::__construct();
		$this->load->model('UtilityMethods');
		$this->load->model('autoCompleteModel');
	}

	public function index()
	{
		
	}

	public function getSupplier()
	{	
		$keyword = $this->input->get('term');
		$query = $this->autoCompleteModel->gerSupplierData($keyword); 
			if(!empty($query)){
				$data = array(); //Create array  
				foreach( $query as $row )  
				{  
					$data[] = array(   
									'supplierId'=>$row->supplierId,  
									'value' => $row->supplierName,
									'label' => $row->supplierName.'-'.$row->supplierCode
								);    
				} 
			 echo json_encode($data);
			}else{
				echo "No Data Found";
			}
			
		
	}


}
