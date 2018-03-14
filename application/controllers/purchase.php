<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('UtilityMethods');
		$this->load->model('purchaseModel');

		 
	}

	public function index()
	{
		$purchaseList['list'] = $this->purchaseModel->getPurchaseList(); 
		$this->load->view('purchase', $purchaseList);
	}

	public function purchaseAdd()
	{
		$dataList['branches'] = $this->UtilityMethods->listBranch();
		
		$this->load->view('purchase', $dataList);

	}

	public function purchaseInsert()
	{ 

            	
		$data = array(
			'purchaseUniqId' => random_string('alnum',20),
			'purchaseCode' 	=> $this->input->post('purchaseCode'),
			'purchaseName' 	=> $this->input->post('purchaseName'),
			'purchaseMobileNo' 	=> $this->input->post('purchaseMobileNo'),
			'purchaseAddress' 	=> $this->input->post('purchaseAddress'),
			'purchaseEmail' 	=> $this->input->post('purchaseEmail'),
			'purchaseGstNo' 	=> $this->input->post('purchaseGstNo'),
			'purchaseAddedBy' => $this->session->userdata['logged_in']['user_id'],
			'purchaseAddedOn' => NOW(),
			'purchaseAddedIp' => $this->UtilityMethods->getRealIpAddr() );

		$existsData_c = $this->UtilityMethods->getExistOrNot('purchases','purchaseCode',$this->input->post('purchaseCode'), 'purchaseStatus');
		$existsData_g = $this->UtilityMethods->getExistOrNot('purchases','purchaseGstNo',$this->input->post('purchaseGstNo'), 'purchaseStatus');

		if( ($existsData_c < 1) && ($existsData_g < 1) ){
			$result = $this->purchaseModel->purchaseModelInsert($data);
			$this->session->set_flashdata('msg', 'Purchase Added Successfully...');
			redirect(base_url('purchase/purchaseAdd'));
		}else{
			$this->session->set_flashdata('msg', 'Purchase Code Or GST NO Already Exists...');
			redirect(base_url('purchase/purchaseAdd'));
		}
	

	}
	public function purchaseEdit()
	{
		$editPrd['editData'] = $this->purchaseModel->editPurchase(); 
		$this->load->view('purchase', $editPrd);
	}

	public function purchaseUpdate()
	{ 
		$uniqId 	= $this->input->post('purchaseUniqId');
		$purchaseId 	= $this->input->post('purchaseId');

		$data = array(
			'purchaseCode' 	=> $this->input->post('purchaseCode'),
			'purchaseName' 	=> $this->input->post('purchaseName'),
			'purchaseMobileNo' 	=> $this->input->post('purchaseMobileNo'),
			'purchaseAddress' 	=> $this->input->post('purchaseAddress'),
			'purchaseEmail' 	=> $this->input->post('purchaseEmail'),
			'purchaseGstNo' 	=> $this->input->post('purchaseGstNo'),
			'purchaseModifiedBy' => $this->session->userdata['logged_in']['user_id'],
			'purchaseModifiedOn' => NOW(),
			'purchaseModifiedIp' => $this->UtilityMethods->getRealIpAddr() );

			$result = $this->purchaseModel->purchaseModelUpdate($data, $purchaseId);
			$this->session->set_flashdata('msg', 'Purchase Updated Successfully...');
			redirect(base_url('purchase/purchaseEdit/'.$uniqId));
		
	}

	public function purchaseDelete()
	{ 
		 $id = $this->uri->segment(3); 
		
		if(isset($id)){
			$data = array(
				'purchaseStatus' 	=> 1,
				'purchaseDeletedBy' 	=> $this->session->userdata['logged_in']['user_id'],
				'purchaseDeletedOn' 	=> NOW(),
				'purchaseDeletedIp' 	=> $this->UtilityMethods->getRealIpAddr() );

			$result = $this->UtilityMethods->recordDelete('purchases', $data, 'purchaseUniqId', $id);

			if($result==true){
				$this->session->set_flashdata('msg', 'Purchase Deleted Successfully...');
				redirect(base_url('purchase'));
			}else{
				$this->session->set_flashdata('msg', 'Purchase Not Selected ...');
				redirect(base_url('purchase'));
			}

		}else{
			$this->session->set_flashdata('msg', 'Purchase Not Selected ...');
			redirect(base_url('purchase'));
		}
	}

}
