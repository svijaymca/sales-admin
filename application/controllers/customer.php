<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('UtilityMethods');
		$this->load->model('customerModel');
	}

	public function index()
	{
		$customerList['list'] = $this->customerModel->getCustomerList(); 
		$this->load->view('customer', $customerList);
	}

	public function customerAdd()
	{
		$this->load->view('customer','customerAdd');
	}

	public function customerInsert()
	{ 

            	
		$data = array(
			'customerUniqId' => random_string('alnum',20),
			'customerCode' 	=> $this->input->post('customerCode'),
			'customerName' 	=> $this->input->post('customerName'),
			'customerMobileNo' 	=> $this->input->post('customerMobileNo'),
			'customerAddress' 	=> $this->input->post('customerAddress'),
			'customerEmail' 	=> $this->input->post('customerEmail'),
			'customerGstNo' 	=> $this->input->post('customerGstNo'),
			'customerAddedBy' => $this->session->userdata['logged_in']['user_id'],
			'customerAddedOn' => NOW(),
			'customerAddedIp' => $this->UtilityMethods->getRealIpAddr() );

		$existsData_c = $this->UtilityMethods->getExistOrNot('customers','customerCode',$this->input->post('customerCode'), 'customerStatus');
		$existsData_g = $this->UtilityMethods->getExistOrNot('customers','customerGstNo',$this->input->post('customerGstNo'), 'customerStatus');

		if( ($existsData_c < 1) && ($existsData_g < 1) ){
			$result = $this->customerModel->customerModelInsert($data);
			$this->session->set_flashdata('msg', 'Customer Added Successfully...');
			redirect(base_url('customer/customerAdd'));
		}else{
			$this->session->set_flashdata('msg', 'Customer Code Or GST NO Already Exists...');
			redirect(base_url('customer/customerAdd'));
		}
	

	}
	public function customerEdit()
	{
		$editPrd['editData'] = $this->customerModel->editCustomer(); 
		$this->load->view('customer', $editPrd);
	}

	public function customerUpdate()
	{ 
		$uniqId 	= $this->input->post('customerUniqId');
		$customerId 	= $this->input->post('customerId');

		$data = array(
			'customerCode' 	=> $this->input->post('customerCode'),
			'customerName' 	=> $this->input->post('customerName'),
			'customerMobileNo' 	=> $this->input->post('customerMobileNo'),
			'customerAddress' 	=> $this->input->post('customerAddress'),
			'customerEmail' 	=> $this->input->post('customerEmail'),
			'customerGstNo' 	=> $this->input->post('customerGstNo'),
			'customerModifiedBy' => $this->session->userdata['logged_in']['user_id'],
			'customerModifiedOn' => NOW(),
			'customerModifiedIp' => $this->UtilityMethods->getRealIpAddr() );

			$result = $this->customerModel->customerModelUpdate($data, $customerId);
			$this->session->set_flashdata('msg', 'Customer Updated Successfully...');
			redirect(base_url('customer/customerEdit/'.$uniqId));
		
	}

	public function customerDelete()
	{ 
		 $id = $this->uri->segment(3); 
		
		if(isset($id)){
			$data = array(
				'customerStatus' 	=> 1,
				'customerDeletedBy' 	=> $this->session->userdata['logged_in']['user_id'],
				'customerDeletedOn' 	=> NOW(),
				'customerDeletedIp' 	=> $this->UtilityMethods->getRealIpAddr() );

			$result = $this->UtilityMethods->recordDelete('customers', $data, 'customerUniqId', $id);

			if($result==true){
				$this->session->set_flashdata('msg', 'Customer Deleted Successfully...');
				redirect(base_url('customer'));
			}else{
				$this->session->set_flashdata('msg', 'Customer Not Selected ...');
				redirect(base_url('customer'));
			}

		}else{
			$this->session->set_flashdata('msg', 'Customer Not Selected ...');
			redirect(base_url('customer'));
		}
	}

}
