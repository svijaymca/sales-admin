<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class StockAvailability extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('UtilityMethods');
	}

	public function index()
	{
		$searchBranchId		= $this->input->post('searchBranchId');
		$searchProductId	= $this->input->post('searchProductId');
		$searchBranchId		= (isset($searchBranchId)) ? $searchBranchId : '';
		$searchProductId	= (isset($searchProductId)) ? $searchProductId : '';

		$data['stockList'] 	= $this->UtilityMethods->getStockAvailability($searchBranchId, $searchProductId);
		$data['branchList'] = $this->UtilityMethods->listBranch();

		$this->load->view('stockAvailability', $data);
	}

	public function stockLedgerExcel()
	{
		$searchBranchId		= $this->uri->segment(3);
		$searchProductId	= $this->uri->segment(4);
		$searchBranchId		= (isset($searchBranchId)) ? $searchBranchId : '';
		$searchProductId	= (isset($searchProductId)) ? $searchProductId : '';

		$data['stockList'] 	= $this->UtilityMethods->getStockAvailability($searchBranchId, $searchProductId);
		$this->load->view('stockAvailabilityExcel', $data);
	}
}
