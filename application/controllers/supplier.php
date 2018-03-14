<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('UtilityMethods');
		$this->load->model('supplierModel');
	}

	public function index()
	{
		$supplierList['list'] = $this->supplierModel->getSupplierList(); 
		$this->load->view('supplier', $supplierList);
	}

	public function supplierAdd()
	{
		$this->load->view('supplier','supplierAdd');
	}

	public function supplierInsert()
	{ 

            	
		$data = array(
			'supplierUniqId' => random_string('alnum',20),
			'supplierCode' 	=> $this->input->post('supplierCode'),
			'supplierName' 	=> $this->input->post('supplierName'),
			'supplierMobileNo' 	=> $this->input->post('supplierMobileNo'),
			'supplierAddress' 	=> $this->input->post('supplierAddress'),
			'supplierEmail' 	=> $this->input->post('supplierEmail'),
			'supplierGstNo' 	=> $this->input->post('supplierGstNo'),
			'supplierAddedBy' => $this->session->userdata['logged_in']['user_id'],
			'supplierAddedOn' => NOW(),
			'supplierAddedIp' => $this->UtilityMethods->getRealIpAddr() );

		$existsData_c = $this->UtilityMethods->getExistOrNot('suppliers','supplierCode',$this->input->post('supplierCode'), 'supplierStatus');
		$existsData_g = $this->UtilityMethods->getExistOrNot('suppliers','supplierGstNo',$this->input->post('supplierGstNo'), 'supplierStatus');

		if( ($existsData_c < 1) && ($existsData_g < 1) ){
			$result = $this->supplierModel->supplierModelInsert($data);
			$this->session->set_flashdata('msg', 'Supplier Added Successfully...');
			redirect(base_url('supplier/supplierAdd'));
		}else{
			$this->session->set_flashdata('msg', 'Supplier Code Or GST NO Already Exists...');
			redirect(base_url('supplier/supplierAdd'));
		}
	

	}
	public function supplierEdit()
	{
		$editPrd['editData'] = $this->supplierModel->editSupplier(); 
		$this->load->view('supplier', $editPrd);
	}

	public function supplierUpdate()
	{ 
		$uniqId 	= $this->input->post('supplierUniqId');
		$supplierId 	= $this->input->post('supplierId');

		$data = array(
			'supplierCode' 	=> $this->input->post('supplierCode'),
			'supplierName' 	=> $this->input->post('supplierName'),
			'supplierMobileNo' 	=> $this->input->post('supplierMobileNo'),
			'supplierAddress' 	=> $this->input->post('supplierAddress'),
			'supplierEmail' 	=> $this->input->post('supplierEmail'),
			'supplierGstNo' 	=> $this->input->post('supplierGstNo'),
			'supplierModifiedBy' => $this->session->userdata['logged_in']['user_id'],
			'supplierModifiedOn' => NOW(),
			'supplierModifiedIp' => $this->UtilityMethods->getRealIpAddr() );

			$result = $this->supplierModel->supplierModelUpdate($data, $supplierId);
			$this->session->set_flashdata('msg', 'Supplier Updated Successfully...');
			redirect(base_url('supplier/supplierEdit/'.$uniqId));
		
	}

	public function supplierDelete()
	{ 
		 $id = $this->uri->segment(3); 
		
		if(isset($id)){
			$data = array(
				'supplierStatus' 	=> 1,
				'supplierDeletedBy' 	=> $this->session->userdata['logged_in']['user_id'],
				'supplierDeletedOn' 	=> NOW(),
				'supplierDeletedIp' 	=> $this->UtilityMethods->getRealIpAddr() );

			$result = $this->UtilityMethods->recordDelete('suppliers', $data, 'supplierUniqId', $id);

			if($result==true){
				$this->session->set_flashdata('msg', 'Supplier Deleted Successfully...');
				redirect(base_url('supplier'));
			}else{
				$this->session->set_flashdata('msg', 'Supplier Not Selected ...');
				redirect(base_url('supplier'));
			}

		}else{
			$this->session->set_flashdata('msg', 'Supplier Not Selected ...');
			redirect(base_url('supplier'));
		}
	}

}
