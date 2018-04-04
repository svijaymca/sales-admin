<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class invoicePrint extends CI_Controller { 

	function __construct() { 
		parent::__construct();
		$this->load->model('UtilityMethods');
		$this->load->model('invoiceModel');
	}

	public function index()
	{
		/*$id   = $this->UtilityMethods->getId('invoiceId','invoice','invoiceUniqId', $this->uri->segment(2) );

		$data['invoiceData'] = $this->invoiceModel->editInvoice();
		
		$html=$this->load->view('invoicePrintView', $data); 

		
		$pdf = $this->pdf->load();
		
		$pdf->WriteHTML($html,2);

		$pdf->Output('invoice-print.pdf', "D");
		exit;*/
	}
	public function printInvoice()
	{
		ob_start();
		list($data['invoiceData'], $data['invoiceDetailData']) = $this->invoiceModel->editInvoice();
		$this->load->view('invoicePrintView', $data);
	 if($this->uri->segment(4)!='excel'){ 
		$pdf = new Tc_pdf('P', 'px', 'A4', true, 'UTF-8', false);
		$pdf->SetTitle('INVOICE');
		$pdf->SetHeaderMargin(20);
		$pdf->SetTopMargin(20);
		$pdf->setFooterMargin(20);
		$pdf->SetAutoPageBreak(true);
		$pdf->SetAuthor('Vijay');
		$pdf->SetDisplayMode('real', 'default');
		
		list($data['invoiceData'], $data['invoiceDetailData']) = $this->invoiceModel->editInvoice();
		$this->load->view('invoicePrintView', $data);
			
		$invNo 	= $data['invoiceData'];
		$template = ob_get_contents();
		ob_end_clean();
		$pdf->AddPage();

		$pdf->WriteHTML($template);

		$fileName = $invNo->invoiceNo.' INVOICE.pdf';
		$pdf->Output($fileName, 'I');
	}
		
	}

	

}
