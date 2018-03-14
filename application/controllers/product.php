<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('UtilityMethods');
		$this->load->model('productModel');
	}

	public function index()
	{
		$productList['list'] = $this->productModel->getProductList(); 
		$this->load->view('product', $productList);
	}

	public function productAdd()
	{
		$this->load->view('product','productAdd');
	}

	public function productInsert()
	{ 

            	
		$data = array(
			'productUniqId' => random_string('alnum',20),
			'productCode' 	=> $this->input->post('productCode'),
			'productName' 	=> $this->input->post('productName'),
			'productRate' 	=> $this->input->post('productRate'),
			'productAddedBy' => $this->session->userdata['logged_in']['user_id'],
			'productAddedOn' => NOW(),
			'productAddedIp' => $this->UtilityMethods->getRealIpAddr() );

		$existsData = $this->UtilityMethods->getExistOrNot('products','productCode',$this->input->post('productCode'), 'productStatus');
		if( $existsData < 1){
			$result = $this->productModel->productModelInsert($data);
			$this->session->set_flashdata('msg', 'Product Added Successfully...');
			redirect(base_url('product/productAdd'));
		}else{
			$this->session->set_flashdata('msg', 'Product Code Already Exists...');
			redirect(base_url('product/productAdd'));
		}
	}
	public function productEdit()
	{
		$editPrd['editData'] = $this->productModel->editProduct(); 
		$this->load->view('product', $editPrd);
	}

	public function productUpdate()
	{ 
		$uniqId 	= $this->input->post('productUniqId');
		$productId 	= $this->input->post('productId');

		$data = array(
			'productCode' 	=> $this->input->post('productCode'),
			'productName' 	=> $this->input->post('productName'),
			'productRate' 	=> $this->input->post('productRate'),
			'productModifiedBy' => $this->session->userdata['logged_in']['user_id'],
			'productModifiedOn' => NOW(),
			'productModifiedIp' => $this->UtilityMethods->getRealIpAddr() );
		
			$result = $this->productModel->productModelUpdate($data, $productId);
			$this->session->set_flashdata('msg', 'Product Updated Successfully...');
			redirect(base_url('product/productEdit/'.$uniqId));
		
	}

	public function productDelete()
	{ 
		 $id = $this->uri->segment(3); 
		
		if(isset($id)){
			$data = array(
				'productStatus' 	=> 1,
				'productDeletedBy' 	=> $this->session->userdata['logged_in']['user_id'],
				'productDeletedOn' 	=> NOW(),
				'productDeletedIp' 	=> $this->UtilityMethods->getRealIpAddr() );

			$result = $this->UtilityMethods->recordDelete('products', $data, 'productUniqId', $id);

			if($result==true){
				$this->session->set_flashdata('msg', 'Product Deleted Successfully...');
				redirect(base_url('product'));
			}else{
				$this->session->set_flashdata('msg', 'Product Not Selected ...');
				redirect(base_url('product'));
			}

		}else{
			$this->session->set_flashdata('msg', 'Product Not Selected ...');
			redirect(base_url('product'));
		}
	}

}
