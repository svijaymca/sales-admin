<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Branch extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('UtilityMethods');
		$this->load->model('branchModel');
	}

	public function index()
	{
		$branchList['list'] = $this->branchModel->getBranchList(); 
		$this->load->view('branch', $branchList);
	}

	public function branchAdd()
	{
		$this->load->view('branch','branchAdd');
	}

	public function branchInsert()
	{ 

            	
		$data = array(
			'branchUniqId' => random_string('alnum',20),
			'branchCode' 	=> $this->input->post('branchCode'),
			'branchName' 	=> $this->input->post('branchName'),
			'branchLineNo' 	=> $this->input->post('branchLineNo'),
			'branchAddress' 	=> $this->input->post('branchAddress'),
			'branchEmail' 	=> $this->input->post('branchEmail'),
			'branchGstNo' 	=> $this->input->post('branchGstNo'),
			'branchAddedBy' => $this->session->userdata['logged_in']['user_id'],
			'branchAddedOn' => NOW(),
			'branchAddedIp' => $this->UtilityMethods->getRealIpAddr() );

		$existsData_c = $this->UtilityMethods->getExistOrNot('branch','branchCode',$this->input->post('branchCode'), 'branchStatus');
		$existsData_g = $this->UtilityMethods->getExistOrNot('branch','branchGstNo',$this->input->post('branchGstNo'), 'branchStatus');

		if( ($existsData_c < 1) && ($existsData_g < 1) ){
			$result = $this->branchModel->branchModelInsert($data);
			$this->session->set_flashdata('msg', 'Branch Added Successfully...');
			redirect(base_url('branch/branchAdd'));
		}else{
			$this->session->set_flashdata('msg', 'Branch Code Or GST NO Already Exists...');
			redirect(base_url('branch/branchAdd'));
		}
	

	}
	public function branchEdit()
	{
		$editPrd['editData'] = $this->branchModel->editBranch(); 
		$this->load->view('branch', $editPrd);
	}

	public function branchUpdate()
	{ 
		$uniqId 	= $this->input->post('branchUniqId');
		$branchId 	= $this->input->post('branchId');

		$data = array(
			'branchCode' 	=> $this->input->post('branchCode'),
			'branchName' 	=> $this->input->post('branchName'),
			'branchLineNo' 	=> $this->input->post('branchLineNo'),
			'branchAddress' => $this->input->post('branchAddress'),
			'branchEmail' 	=> $this->input->post('branchEmail'),
			'branchGstNo' 	=> $this->input->post('branchGstNo'),
			'branchModifiedBy' => $this->session->userdata['logged_in']['user_id'],
			'branchModifiedOn' => NOW(),
			'branchModifiedIp' => $this->UtilityMethods->getRealIpAddr() );

			$result = $this->branchModel->branchModelUpdate($data, $branchId);
			$this->session->set_flashdata('msg', 'Branch Updated Successfully...');
			redirect(base_url('branch/branchEdit/'.$uniqId));
		
	}

	public function branchDelete()
	{ 
		 $id = $this->uri->segment(3); 
		
		if(isset($id)){
			$data = array(
				'branchStatus' 	=> 1,
				'branchDeletedBy' 	=> $this->session->userdata['logged_in']['user_id'],
				'branchDeletedOn' 	=> NOW(),
				'branchDeletedIp' 	=> $this->UtilityMethods->getRealIpAddr() );

			$result = $this->UtilityMethods->recordDelete('branchs', $data, 'branchUniqId', $id);

			if($result==true){
				$this->session->set_flashdata('msg', 'Branch Deleted Successfully...');
				redirect(base_url('branch'));
			}else{
				$this->session->set_flashdata('msg', 'Branch Not Selected ...');
				redirect(base_url('branch'));
			}

		}else{
			$this->session->set_flashdata('msg', 'Branch Not Selected ...');
			redirect(base_url('branch'));
		}
	}

}
