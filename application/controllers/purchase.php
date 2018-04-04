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
			$this->db->trans_start(); $tranSaction = true;
            	//print_r($_POST); exit;

            $no = $this->UtilityMethods->getNo('purchase', 'purchaseNo', 'purchaseBranchId', $this->input->post('purchaseBranchId'), 'purchaseStatus');

            	$n = substr($no,2);
            	$purchaseNo = '';
            	if($n > 0 ){
            		$purchaseNo 	= 'PU'.substr(('00000'.++$n),-5);
            	}else{
            		$purchaseNo 	= 'PU'.substr(('00001'.++$n),-5);
            	}

    if($this->input->post('purchaseNetTotal') > 0 ){

    	$purchaseDate 	= $this->UtilityMethods->dateDatabaseFormat($this->input->post('purchaseDate'));

		 $data = array(
			'purchaseUniqId' => random_string('alnum',20),
			'purchaseNo' 	=> $purchaseNo,
			'purchaseDate' 	=> $purchaseDate,
			'purchaseSupplierId' 	=>  $this->input->post('purchaseSupplierId'),
			'purchaseGrossTotal' 	=> $this->input->post('purchaseGrossTotal'),
			'purchaseCgstPer' 	=> $this->input->post('purchaseCgstPer'),
			'purchaseCgstAmount' 	=> $this->input->post('purchaseCgstAmount'),
			'purchaseSgstPer' 	=> $this->input->post('purchaseSgstPer'),
			'purchaseSgstAmount' 	=> $this->input->post('purchaseSgstAmount'),
			'purchaseIgstPer' 	=> $this->input->post('purchaseIgstPer'),
			'purchaseIgstAmount' 	=> $this->input->post('purchaseIgstAmount'),
			'purchaseNetTotal' 	=> $this->input->post('purchaseNetTotal'),
			'purchaseRemarks' 	=> $this->input->post('purchaseRemarks'),
			'purchaseBranchId' 	=> $this->input->post('purchaseBranchId'),
			'purchaseAddedBy' => $this->session->userdata['logged_in']['user_id'],
			'purchaseAddedOn' => NOW(),
			'purchaseAddedIp' => $this->UtilityMethods->getRealIpAddr() );

			list($purchaseId, $transStatus) = $this->purchaseModel->purchaseModelInsert($data);


			$purchaseDetailsProductId 	=	$this->input->post('purchaseDetailsProductId');	
			$purchaseDetailsQty 		=	$this->input->post('purchaseDetailsQty');
			$purchaseDetailsRate 		=	$this->input->post('purchaseDetailsRate');
			$purchaseDetailsAmount 		=	$this->input->post('purchaseDetailsAmount');	

			if( $purchaseId > 0 ){	
					
				for($index = 0; $index < count($purchaseDetailsProductId); $index++ ){ 
					if(!empty($purchaseDetailsProductId[$index]) && !empty($purchaseDetailsQty[$index])){
						$details = array(
							'purchaseDetailsUniqId' 		=> random_string('alnum', 20),
							'purchaseDetailsPurchaseId' 	=> $purchaseId,
							'purchaseDetailsProductId' 		=> $purchaseDetailsProductId[$index],
							'purchaseDetailsQty' 			=> $purchaseDetailsQty[$index],
							'purchaseDetailsRate' 			=> $purchaseDetailsRate[$index],
							'purchaseDetailsAmount' 		=> $purchaseDetailsAmount[$index] 
							'purchaseDetailsAddedBy' 		=> $this->session->userdata['logged_in']['user_id'],
							'purchaseDetailsAddedOn' 		=> NOW(),
							'purchaseDetailsAddedIp' 		=> $this->UtilityMethods->getRealIpAddr());
							
					list($purdetails, $status) = $this->purchaseModel->purchaseDetailsModelInsert($details);	
						if($status===false){
							$tranSaction = false;
							break;
						}else{

						$sta = $this->UtilityMethods->stockLedger('IN', $purchaseId, $purdetails, $purchaseDate, $purchaseDetailsProductId[$index], $this->input->post('purchaseBranchId'), $purchaseDetailsQty[$index], 'PURCHASE');

							if($sta===false){
								$tranSaction = false;
								break;
							}	

						}

					}
				}
			$this->session->set_flashdata('msg', 'Purchase Added Successfully...');
			
			}else{
					$tranSaction = false;
			}
		}else{
			$this->session->set_flashdata('msg', 'Amount is Zero, So does not saved...');
		}

		if($tranSaction==false){
			$this->db->trans_rollback();
			$this->session->set_flashdata('msg', 'Query error...');
		}else{
			$this->db->trans_commit();
		}
		redirect(base_url('purchase/purchaseAdd'));
	}


	public function purchaseView()
	{
		list($editPrd['editData'],$editPrd['editDataDetail']) = $this->purchaseModel->editPurchase();


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
		$id   = $this->UtilityMethods->getId('purchaseId','purchase','purchaseUniqId', $this->uri->segment(3) );
		if(isset($id)){
			$data1 = array(
				'purchaseStatus' 	=> 1,
				'purchaseDeletedBy' 	=> $this->session->userdata['logged_in']['user_id'],
				'purchaseDeletedOn' 	=> NOW(),
				'purchaseDeletedIp' 	=> $this->UtilityMethods->getRealIpAddr() );
			$data2 = array(
				'purchaseDetailsStatus' 	=> 1,
				'purchaseDetailsDeletedBy' 	=> $this->session->userdata['logged_in']['user_id'],
				'purchaseDetailsDeletedOn' 	=> NOW(),
				'purchaseDetailsDeletedIp' 	=> $this->UtilityMethods->getRealIpAddr() );


			$result = $this->UtilityMethods->recordDelete('purchase', $data1, 'purchaseId', $id);
			$result = $this->UtilityMethods->recordDelete('purchaseDetails', $data2, 'purchaseDetailsPurchaseId', $id);

			$sta 	= $this->UtilityMethods->stockLedger('IN', $id, '', '', '', '', '', 'ALLDELETE');

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
