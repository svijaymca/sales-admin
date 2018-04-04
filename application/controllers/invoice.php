<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('UtilityMethods');
		$this->load->model('invoiceModel');

		 
	}

	public function index()
	{
		$invoiceList['list'] = $this->invoiceModel->getInvoiceList(); 
		$this->load->view('invoice', $invoiceList);
	}

	public function invoiceAdd()
	{
		$dataList['branches'] = $this->UtilityMethods->listBranch();
		
		$this->load->view('invoice', $dataList);

	}

	public function invoiceInsert()
	{ 
			$this->db->trans_start(); $tranSaction = true;
            	//print_r($_POST); exit;

            $no = $this->UtilityMethods->getNo('invoice', 'invoiceNo', 'invoiceBranchId', $this->input->post('invoiceBranchId'), 'invoiceStatus');

            	$n = substr($no,2);
            	$invoiceNo = '';
            	if($n > 0 ){
            		$invoiceNo 	= 'IN'.substr(('00000'.++$n),-5);
            	}else{
            		$invoiceNo 	= 'IN'.substr(('00001'.++$n),-5);
            	}

            	$invoiceDate = $this->UtilityMethods->dateDatabaseFormat($this->input->post('invoiceDate'));
    if($this->input->post('invoiceNetTotal') > 0 ){

		 $data = array(
			'invoiceUniqId' => random_string('alnum',20),
			'invoiceNo' 	=> $invoiceNo,
			'invoiceDate' 	=> $invoiceDate,
			'invoiceCustomerId' 	=>  $this->input->post('invoiceCustomerId'),
			'invoiceGrossTotal' 	=> $this->input->post('invoiceGrossTotal'),
			'invoiceDiscountPer' 	=> $this->input->post('invoiceDiscountPer'),
			'invoiceDiscountAmount' => $this->input->post('invoiceDiscountAmount'),
			'invoiceCgstPer' 	=> $this->input->post('invoiceCgstPer'),
			'invoiceCgstAmount' 	=> $this->input->post('invoiceCgstAmount'),
			'invoiceSgstPer' 	=> $this->input->post('invoiceSgstPer'),
			'invoiceSgstAmount' 	=> $this->input->post('invoiceSgstAmount'),
			'invoiceIgstPer' 	=> $this->input->post('invoiceIgstPer'),
			'invoiceIgstAmount' 	=> $this->input->post('invoiceIgstAmount'),
			'invoiceNetTotal' 	=> $this->input->post('invoiceNetTotal'),
			'invoiceRemarks' 	=> $this->input->post('invoiceRemarks'),
			'invoiceBranchId' 	=> $this->input->post('invoiceBranchId'),
			'invoiceAddedBy' => $this->session->userdata['logged_in']['user_id'],
			'invoiceAddedOn' => NOW(),
			'invoiceAddedIp' => $this->UtilityMethods->getRealIpAddr() );

			list($invoiceId, $transStatus) = $this->invoiceModel->invoiceModelInsert($data);


			$invoiceDetailsProductId 	=	$this->input->post('invoiceDetailsProductId');	
			$invoiceDetailsQty 			=	$this->input->post('invoiceDetailsQty');
			$invoiceDetailsRate 		=	$this->input->post('invoiceDetailsRate');
			$invoiceDetailsAmount 		=	$this->input->post('invoiceDetailsAmount');	

			if( $invoiceId > 0 ){	
					
				for($index = 0; $index < count($invoiceDetailsProductId); $index++ ){ 
					if(!empty($invoiceDetailsProductId[$index]) && !empty($invoiceDetailsQty[$index])){
						
								$details = array(
									'invoiceDetailsUniqId' 		=> random_string('alnum', 20),
									'invoiceDetailsInvoiceId' 	=> $invoiceId,
									'invoiceDetailsProductId' 	=> $invoiceDetailsProductId[$index],
									'invoiceDetailsQty' 		=> $invoiceDetailsQty[$index],
									'invoiceDetailsRate' 		=> $invoiceDetailsRate[$index],
									'invoiceDetailsAmount' 		=> $invoiceDetailsAmount[$index],
									'invoiceDetailsAddedBy' 	=> $this->session->userdata['logged_in']['user_id'],
									'invoiceDetailsAddedOn' 	=> NOW(),
									'invoiceDetailsAddedIp' 	=> $this->UtilityMethods->getRealIpAddr() );
									
										list($purdetails, $status) = $this->invoiceModel->invoiceDetailsModelInsert($details);	
								
						if($status===false){
							$tranSaction = false;
							break;
						}else{
							$sta = $this->UtilityMethods->stockLedger('OUT',$invoiceId, $purdetails, $invoiceDate, $invoiceDetailsProductId[$index], $this->input->post('invoiceBranchId'), $invoiceDetailsQty[$index]*-1 , 'INVOICE');

								if($sta===false){
									$tranSaction = false;
									break;
								}
						}
						
						

					}
				}
			$this->session->set_flashdata('msg', 'Invoice Added Successfully...');
			
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
		redirect(base_url('invoice/invoiceAdd'));
	}


	public function invoiceView()
	{
		list($editPrd['editData'],$editPrd['editDataDetail']) = $this->invoiceModel->editInvoice();
		$this->load->view('invoice', $editPrd);
	}
	
	public function invoiceEdit()
	{
		$editPrd['branches'] = $this->UtilityMethods->listBranch();
		list($editPrd['editData'],$editPrd['editDataDetail']) = $this->invoiceModel->editInvoice();
		$this->load->view('invoice', $editPrd);
	}
	
	public function invoiceUpdate()
	{ 
		$this->db->trans_start(); $tranSaction = true;
            	//print_r($_POST); exit;
	$invoiceId   = $this->UtilityMethods->getId('invoiceId','invoice','invoiceUniqId', $this->input->post('invoiceId') );
	$invoiceDate = $this->UtilityMethods->dateDatabaseFormat($this->input->post('invoiceDate'));
    if($this->input->post('invoiceNetTotal') > 0 ){
		
		 $data = array(
			'invoiceDate' 	=> $this->UtilityMethods->dateDatabaseFormat($this->input->post('invoiceDate')),
			'invoiceGrossTotal' => $this->input->post('invoiceGrossTotal'),
			'invoiceDiscountPer' 	=> $this->input->post('invoiceDiscountPer'),
			'invoiceDiscountAmount' => $this->input->post('invoiceDiscountAmount'),
			'invoiceCgstPer' 	=> $this->input->post('invoiceCgstPer'),
			'invoiceCgstAmount' => $this->input->post('invoiceCgstAmount'),
			'invoiceSgstPer' 	=> $this->input->post('invoiceSgstPer'),
			'invoiceSgstAmount' => $this->input->post('invoiceSgstAmount'),
			'invoiceIgstPer' 	=> $this->input->post('invoiceIgstPer'),
			'invoiceIgstAmount' => $this->input->post('invoiceIgstAmount'),
			'invoiceNetTotal' 	=> $this->input->post('invoiceNetTotal'),
			'invoiceRemarks' 	=> $this->input->post('invoiceRemarks'),
			'invoiceBranchId' 	=> $this->input->post('invoiceBranchId'),
			'invoiceModifiedBy' => $this->session->userdata['logged_in']['user_id'],
			'invoiceModifiedOn' => NOW(),
			'invoiceModifiedIp' => $this->UtilityMethods->getRealIpAddr() );

			list($invoiceId, $transStatus) = $this->invoiceModel->invoiceModelUpdate($data, $invoiceId);

			$invoiceDetailsId 			=	$this->input->post('invoiceDetailsId');
			$invoiceDetailsProductId 	=	$this->input->post('invoiceDetailsProductId');	
			$invoiceDetailsQty 			=	$this->input->post('invoiceDetailsQty');
			$invoiceDetailsRate 		=	$this->input->post('invoiceDetailsRate');
			$invoiceDetailsAmount 		=	$this->input->post('invoiceDetailsAmount');	

			if( $transStatus === true ){	
					
				for($index = 0; $index < count($invoiceDetailsProductId); $index++ ){ 
					if(!empty($invoiceDetailsProductId[$index]) && !empty($invoiceDetailsQty[$index])){
							if(empty($invoiceDetailsId[$index])){
								$detailsAdd = array(
									'invoiceDetailsUniqId' 		=> random_string('alnum', 20),
									'invoiceDetailsInvoiceId' 	=> $invoiceId,
									'invoiceDetailsProductId' 	=> $invoiceDetailsProductId[$index],
									'invoiceDetailsQty' 		=> $invoiceDetailsQty[$index],
									'invoiceDetailsRate' 		=> $invoiceDetailsRate[$index],
									'invoiceDetailsAmount' 		=> $invoiceDetailsAmount[$index],
									'invoiceDetailsAddedBy' 	=> $this->session->userdata['logged_in']['user_id'],
									'invoiceDetailsAddedOn' 	=> NOW(),
									'invoiceDetailsAddedIp' 	=> $this->UtilityMethods->getRealIpAddr() );
									
										list($purdetails, $status) = $this->invoiceModel->invoiceDetailsModelInsert($detailsAdd);	
								
								if($status===false){
									$tranSaction = false;
									break;
								}else{
									$sta = $this->UtilityMethods->stockLedger('OUT', $invoiceId, $purdetails, $invoiceDate, $invoiceDetailsProductId[$index], $this->input->post('invoiceBranchId'), $invoiceDetailsQty[$index]*-1 , 'INVOICE');

									if($sta===false){
										$tranSaction = false;
										break;
									}
								}

							}else{
							
							$whereDetails = array('invoiceDetailsId' => $invoiceDetailsId[$index], 'invoiceDetailsInvoiceId' => $invoiceId );
							
							$detailsUpdate = array(
									'invoiceDetailsProductId' 	=> $invoiceDetailsProductId[$index],
									'invoiceDetailsQty' 		=> $invoiceDetailsQty[$index],
									'invoiceDetailsRate' 		=> $invoiceDetailsRate[$index],
									'invoiceDetailsAmount' 		=> $invoiceDetailsAmount[$index],
									'invoiceDetailsModifiedBy' 	=> $this->session->userdata['logged_in']['user_id'],
									'invoiceDetailsModifiedOn' 	=> NOW(),
									'invoiceDetailsModifiedIp' 	=> $this->UtilityMethods->getRealIpAddr() );
									
										list($purdetails, $status) = $this->invoiceModel->invoiceDetailsModelUpdate($detailsUpdate, $whereDetails);	
								
								if($status===false){
									$tranSaction = false;
									break;
								}else{
									$sta = $this->UtilityMethods->stockLedger('OUT', $invoiceId , $invoiceDetailsId[$index], $invoiceDate, $invoiceDetailsProductId[$index], $this->input->post('invoiceBranchId'), $invoiceDetailsQty[$index]*-1 , 'INVOICE');

									if($sta===false){
										$tranSaction = false;
										break;
									}
								}
						
								
							}

					}
				}
			$this->session->set_flashdata('msg', 'Invoice Updated Successfully...');
			
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
		redirect(base_url('invoice/invoiceEdit/'.$this->input->post('invoiceId')));
		
	}

	public function invoiceDelete()
	{ 
		$id   = $this->UtilityMethods->getId('invoiceId','invoice','invoiceUniqId', $this->uri->segment(3) );
		if(isset($id)){
			$data1 = array(
				'invoiceStatus' 	=> 1,
				'invoiceDeletedBy' 	=> $this->session->userdata['logged_in']['user_id'],
				'invoiceDeletedOn' 	=> NOW(),
				'invoiceDeletedIp' 	=> $this->UtilityMethods->getRealIpAddr() );
			$data2 = array(
				'invoiceDetailsStatus' 	=> 1,
				'invoiceDetailsDeletedBy' 	=> $this->session->userdata['logged_in']['user_id'],
				'invoiceDetailsDeletedOn' 	=> NOW(),
				'invoiceDetailsDeletedIp' 	=> $this->UtilityMethods->getRealIpAddr() );

			$result = $this->UtilityMethods->recordDelete('invoice', $data1, 'invoiceId', $id);
			$result = $this->UtilityMethods->recordDelete('invoiceDetails', $data2, 'invoiceDetailsInvoiceId', $id);
			$sta 	= $this->UtilityMethods->stockLedger('OUT', $id, '', '', '', '', '', 'ALLDELETE');
			if($result==true){
				$this->session->set_flashdata('msg', 'Invoice Deleted Successfully...');
				redirect(base_url('invoice'));
			}else{
				$this->session->set_flashdata('msg', 'Invoice Not Selected ...');
				redirect(base_url('invoice'));
			}

		}else{
			$this->session->set_flashdata('msg', 'Invoice Not Selected ...');
			redirect(base_url('invoice'));
		}
	}
	public function invoiceDetailDelete()
	{ 
		$id = $this->UtilityMethods->getId('invoiceDetailsId','invoiceDetails','invoiceDetailsUniqId', $this->uri->segment(3));
		$entryId = $this->UtilityMethods->getId('invoiceId','invoice','invoiceUniqId', $this->uri->segment(4));
		if(isset($id)){
			
			$data2 = array(
				'invoiceDetailsStatus' 	=> 1,
				'invoiceDetailsDeletedBy' 	=> $this->session->userdata['logged_in']['user_id'],
				'invoiceDetailsDeletedOn' 	=> NOW(),
				'invoiceDetailsDeletedIp' 	=> $this->UtilityMethods->getRealIpAddr() );

			$result = $this->invoiceModel->recordDetailDelete('invoiceDetails', $data2, 'invoiceDetailsId', $id);

			$sta = $this->UtilityMethods->stockLedger('OUT', $entryId, $id, '', $this->uri->segment(5), $this->uri->segment(6), '', 'DEL');

			if($result==true){
				$this->session->set_flashdata('msg', 'Invoice Product Deleted Successfully...');
				redirect(base_url('invoice/invoiceEdit/'. $this->uri->segment(4)));
			}else{
				$this->session->set_flashdata('msg', 'Invoice Not Selected ...');
				redirect(base_url('invoice/invoiceEdit/'. $this->uri->segment(4)));
			}

		}else{
			$this->session->set_flashdata('msg', 'Invoice Not Selected ...');
			redirect(base_url('invoice/invoiceEdit/'. $this->uri->segment(4)));
		}
	}

}
