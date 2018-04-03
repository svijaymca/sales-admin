<script>
function getRow(){
       
        var rowCount  = $('#productDetailTable >tbody >tr').length; 
        var i         = parseInt(rowCount);
        var sno       = parseInt(rowCount) + 1; 
        var apndRow = '<tr>';

            apndRow += '<td> '+ sno +'</td>';

            apndRow += '<td><input type="hidden" name="invoiceDetailsId[]" id="invoiceDetailsId'+i+'" /> ';
            apndRow += '<input type="hidden" name="invoiceDetailsProductId[]" id="invoiceDetailsProductId'+i+'" /> ';
            apndRow += '<input type="text" name="invoiceDetailsProductName[]" id="invoiceDetailsProductName'+i+'" onfocus="getProduct('+i+')" class="form-control" /> </td>';

            apndRow += '<td><input type="text" name="invoiceDetailsProductCode[]" id="invoiceDetailsProductCode'+i+'" class="form-control" readonly /> </td>';

            apndRow += '<td><input type="text" name="invoiceDetailsQty[]" id="invoiceDetailsQty'+i+'" class="form-control alignRight" onkeyup="getAmount('+i+')" /> </td>';

            apndRow += '<td><input type="text" name="invoiceDetailsRate[]" id="invoiceDetailsRate'+i+'" class="form-control alignRight" onfocus="getAmount('+i+')" readonly /> </td>';

            apndRow += '<td><input type="text" name="invoiceDetailsAmount[]" id="invoiceDetailsAmount'+i+'" class="form-control alignRight amount" onfocus="getAmount('+i+')" readonly /> </td></tr>';

        $('#productDetailTable >tbody').append(apndRow); 
 }
 
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  });

  function getCustomer(){
    $('#invoiceCustomerName').autocomplete({ source: '<?=base_url("autoCompleteData/getCustomer")?>', minLength:1,
      select:function(evt, ui){
                $('#invoiceCustomerId').val(ui.item.customerId);
      } 
    });
  }
  function getProduct(id){
    $('#invoiceDetailsProductName'+id).autocomplete({ source: '<?=base_url("autoCompleteData/getProduct")?>', minLength:1,
      select:function(evt, ui){
                $('#invoiceDetailsProductCode'+id).val(ui.item.productCode);
                $('#invoiceDetailsProductId'+id).val(ui.item.productId); 
                $('#invoiceDetailsRate'+id).val(ui.item.productRate); 
                $('#invoiceDetailsQty'+id).focus();
      } 
    });
  }

function getAmount(id){

    var qty   = $('#invoiceDetailsQty'+id).val();
    var rate  = $('#invoiceDetailsRate'+id).val();
    var amount = 0;
    
      if(!isNaN(qty)){
        
        var qtyVal    = Number(qty); 
        var rateVal   = Number(rate);

         amount    = qtyVal * rateVal;

        $('#invoiceDetailsAmount'+id).val(amount.toFixed(2));

       getTotalAmount();
      }else{
            alert('Please Enter numbers in Quantity');
              $('#invoiceDetailsAmount'+id).val(amount.toFixed(2));
              $('#invoiceDetailsQty'+id).focus();
            return false;
     }
}

function getTotalAmount(){

    var amount  = $('.amount').map(function() { return this.value; }).get();
    var total   = 0; 
    for(var i=0; i < $('.amount').length; i++){

          var amt    = Number(amount[i]); 

              total   = total + amt;
    }
      $('#invoiceGrossTotal').val(total.toFixed(2));
      getNetAmount();
}

function discountValue(type){
    var gross     	= Number($('#invoiceGrossTotal').val());
	var disPer   	= Number($('#invoiceDiscountPer').val());
    var disamt   	= Number($('#invoiceDiscountAmount').val());
	 
	if(type==1){
		var damt	= ( disPer * gross ) / 100 ;
		$('#invoiceDiscountAmount').val(damt.toFixed(2));
	}else if(type==2){
		var dPer	= ( disamt / gross ) * 100 ;
		$('#invoiceDiscountPer').val(dPer.toFixed(2));
	}
	getNetAmount();
}

function getNetAmount(){ 

    var gross     	= Number($('#invoiceGrossTotal').val());
	var disPer   	= Number($('#invoiceDiscountPer').val());
    //var disamt   	= Number($('#invoiceDiscountAmount').val());
    var cgstPer   	= Number($('#invoiceCgstPer').val());
    var cgstamt  	= Number($('#invoiceCgstAmount').val());
    var sgstPer   	= Number($('#invoiceSgstPer').val());
    var sgstamt   	= Number($('#invoiceSgstAmount').val());
    var igstPer   	= Number($('#invoiceIgstPer').val());
    var igstamt   	= Number($('#invoiceIgstAmount').val());
    var net       	= Number($('#invoiceNetTotal').val());
	
	var disamt	= ( disPer * gross ) / 100 ;
	$('#invoiceDiscountAmount').val(disamt.toFixed(2));
	
	
	var grossAmount	= Number(gross) - Number(disamt);

    var cgstAmount    = ( grossAmount * cgstPer ) / 100 ; $('#invoiceCgstAmount').val(cgstAmount.toFixed(2));
    var sgstAmount    = ( grossAmount * sgstPer ) / 100 ; $('#invoiceSgstAmount').val(sgstAmount.toFixed(2));
    var igstAmount    = ( grossAmount * igstPer ) / 100 ; $('#invoiceIgstAmount').val(igstAmount.toFixed(2));

    var netAmount = grossAmount + cgstAmount + sgstAmount + igstAmount; 

    $('#invoiceNetTotal').val(netAmount.toFixed(2));
}

function formValidation(){

      var isValid = true; 

      var branchId    = $('#invoiceBranchId').val();
      var customerId  = $('#invoiceCustomerId').val();
      var pDate       = $('#invoiceDate').val();
      var amount      = $('#invoiceNetTotal').val();

      if(branchId =='' || branchId ==0){
          $('#invoiceBranchId').css({"border-color": "#f31242", "border-width":"1px", "border-style":"solid"});
          $('#invoiceBranchId').focus();
       
       isValid = false;
      }
	  
      if(customerId =='' || customerId ==0){
          $('#invoiceCustomerName').css({"border-color": "#f31242", "border-width":"1px", "border-style":"solid"});
          $('#invoiceCustomerName').focus();
       
       isValid = false;
      }
	  
      if(pDate =='' || pDate =='00/00/0000'){
          $('#invoiceDate').css({"border-color": "#f31242", "border-width":"1px", "border-style":"solid"});
          $('#invoiceDate').focus();
       
       isValid = false;
      }
	  
      if(amount =='' || amount ==0 ){
          $('#invoiceNetTotal').css({"border-color": "#f31242", "border-width":"1px", "border-style":"solid"});
          $('#invoiceNetTotal').focus();
       	  $('#invNtTtl').show(1000);
       isValid = false;
      }
     
      return isValid;

}



</script>

<?php  
  include "common/header.php"; 
  include "common/sidebar.php"; 
$page = $this->uri->segment(2);
$id   = $this->uri->segment(3); 

$invoiceFields = array( 
            "purForm" => array ("method" => 'post', "name" => 'invoiceForm', "id" =>'invoiceForm', "onsubmit"=>'return formValidation();' ),
            "purSubmit" => array ("name" => 'addInvoice', "id" =>'addInvoice', "class" =>'btn btn-success btn-sm', "value"=>'SAVE',"type"=>'submit' ),
            "purReset" => array ("name" => 'resetInvoice', "id" =>'resetInvoice', "class" =>'btn btn-warning btn-sm', "value"=>'RESET',"type"=>'reset' ),
            "collapse" => array ("name" => 'minMax', "id" =>'minMax', "class" =>'btn btn-box-tool fa fa-minus', "data-widget"=>'collapse', "data-toggle"=>'tooltip', "title"=>'Collapse' ),
            
         );
?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        PURCHASE & SALES
        <small>all details</small>
        <?php if ($this->session->flashdata('msg')) {  ?> 
              <span style="color: green; font-size: 14px; text-align: center; padding-left: 20%; padding-right: 20%; "> 
                <?php  echo $this->session->flashdata('msg'); ?> 
              </span> <?php  }?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url('home')?>"><i class="fa fa-home"></i> Home</a></li>
        <li><a href="<?=base_url('invoice')?>"><i class="fa fa-cart-plus"></i> Invoice</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
<?php if( isset($page) && ($page == 'invoiceAdd') || ($page == 'invoiceEdit' && isset($id)) ) {   ?>
      <!-- Default box -->

      <?php $func =''; if($page == 'invoiceAdd'){ $func ='invoice/invoiceInsert'; }else{ $func ='invoice/invoiceUpdate'; } ?>
<?php echo form_open_multipart($func, $invoiceFields['purForm']);
echo form_hidden('invoiceId', !empty($editData->invoiceUniqId)?$editData->invoiceUniqId:'', 'id="invoiceId"');
?>
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"> <b>INVOICE</b></h3>

          <div class="box-tools pull-right">
            <?php if(($page != 'invoiceAdd')){ ?><a class="btn btn-primary btn-sm" href="<?=base_url('invoice/invoiceAdd')?>" data-widget="Add Invoice" data-toggle="tooltip" title="Add Invoice"> ADD </a> <?php } ?>
            <?=form_button( $invoiceFields['collapse'])?>
            <!--<button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>-->
          </div>
        </div>
        <div class="box-body">
            <div class="col-sm-12">

                <div class="col-sm-6">
                      <label class="control-label">Branch</label>
                    <?php $branchOptions = array( '0' => ' - SELECT - ');
                       foreach ($branches as  $list) {
                         $branchOptions[$list->branchId]   = $list->branchName ;
                     } ?>    

                      <?=form_dropdown('invoiceBranchId', $branchOptions, !empty($editData->invoiceBranchId)?$editData->invoiceBranchId:'', 'id ="invoiceBranchId" class="form-control select2" style="width:100%;" required tabindex="1"' )?>
                </div>

                <div class="col-sm-6">
                      <label class="control-label"> Date</label><?php $date=''; if(!empty($editData->invoiceDate)){  $date=date('d/m/Y', strtotime($editData->invoiceDate));  } ?>
                      <?=form_input('invoiceDate', $date, 'id ="invoiceDate" class="form-control datePicker" style="" required tabindex="1"')?>
                </div>     

                <div class="col-sm-6">
                      <label class="control-label">Customer</label>
                      <?=form_input('invoiceCustomerName', !empty($editData->customerName)?$editData->customerName:'', 'id ="invoiceCustomerName" class="form-control" onfocus="getCustomer()" required tabindex="1" ' )?>
                      <?php $purSid = array("name" => 'invoiceCustomerId', "id" =>'invoiceCustomerId',  "value"=>!empty($editData->invoiceCustomerId)?$editData->invoiceCustomerId:'', "type"=>'hidden'); ?>
                      <?=form_input($purSid)?>
                </div>

                <div class="col-sm-12">
                  <div class="box-body">  
                    <div class="table-responsive tableBorder">
                      <table class="table table-bordered " id="productDetailTable">
                        <thead>
                          <tr><th colspan="<?php if($page=='invoiceEdit'){ echo 7;}else{ echo 6; }?>" class="upperCase" style="background-color: #bbe1f8; color: #222d32; font-size: 22px;">
                           Product Details 
                              <div style="float:right; "><span id="productRow" class="fa fa-fw fa-plus-square" data-toggle='tooltip' onclick="getRow()" title='Add Product Row'></span></div>
                          </th></tr>
                        
                        <tr style="background-color: #daecf8; color: #222d32" class="upperCase">
                          <th style="width: 5%;">#</th>
                          <th style="width: 20%;"> Product</th>
                          <th style="width: 15%;"> Code</th>
                          <th style="width: 15%;"> Quantity</th>
                          <th style="width: 15%;"> Rate</th>
                          <th style="width: 20%;"> Amount </th>
						  <?php if($page=='invoiceEdit'){ ?> <th style="width: 5%; text-align:center"> Del </th><?php }?>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $sno = 1; $i=0;
						if($page=='invoiceAdd'){ ?>
						 
                       <?php  for($i=0; $i<5; $i++){ 
                        ?>
                        <tr>
                          <td> <?=$sno++?></td>  
                          <td>
                            <input type="text" name="invoiceDetailsProductName[]" id="invoiceDetailsProductName<?=$i?>" class="form-control" onfocus="getProduct(<?=$i?>)" tabindex="1" />
                            <input type="hidden" name="invoiceDetailsProductId[]" id="invoiceDetailsProductId<?=$i?>"  />
                            <input type="hidden" name="invoiceDetailsId[]" id="invoiceDetailsId<?=$i?>"  />
                          </td>
                          <td>
                             <input type="text" name="invoiceDetailsProductCode[]" id="invoiceDetailsProductCode<?=$i?>" class="form-control alignCenter"  readonly />
                          </td> 
                          <td>
                            <input type="text" name="invoiceDetailsQty[]" id="invoiceDetailsQty<?=$i?>" class="form-control alignRight" tabindex="1" onkeyup="getAmount(<?=$i?>)" />
                          </td> 
                          <td>
                             <input type="text" name="invoiceDetailsRate[]" id="invoiceDetailsRate<?=$i?>" class="form-control alignRight"  readonly />
                          </td>
                          <td>
                              <input type="text" name="invoiceDetailsAmount[]" id="invoiceDetailsAmount<?=$i?>" class="form-control alignRight amount"  readonly />
                          </td>    
                        </tr>
                          <?php }?>
						  
						   <?php }else{  ?>
						   
						<?php  foreach( $editDataDetail  as $editDetail){
						  ?>
						 <tr>
                          <td> <?=$sno++?></td>  
                          <td>
                            <input type="text" name="invoiceDetailsProductName[]" id="invoiceDetailsProductName<?=$i?>" class="form-control" onfocus="getProduct(<?=$i?>)" tabindex="1" value="<?=!empty($editDetail->productName)?$editDetail->productName:''?>" />
                            <input type="hidden" name="invoiceDetailsProductId[]" id="invoiceDetailsProductId<?=$i?>" value="<?=!empty($editDetail->invoiceDetailsProductId)?$editDetail->invoiceDetailsProductId:''?>"  />
                            <input type="hidden" name="invoiceDetailsId[]" id="invoiceDetailsId<?=$i?>" value="<?=!empty($editDetail->invoiceDetailsId)?$editDetail->invoiceDetailsId:''?>"  />
                          </td>
                          <td>
                             <input type="text" name="invoiceDetailsProductCode[]" id="invoiceDetailsProductCode<?=$i?>" class="form-control alignCenter"  readonly value="<?=!empty($editDetail->productCode)?$editDetail->productCode:''?>" />
                          </td> 
                          <td>
                            <input type="text" name="invoiceDetailsQty[]" id="invoiceDetailsQty<?=$i?>" class="form-control alignRight" tabindex="1" onkeyup="getAmount(<?=$i?>)" value="<?=!empty($editDetail->invoiceDetailsQty)?$editDetail->invoiceDetailsQty:''?>" />
                          </td> 
                          <td>
                             <input type="text" name="invoiceDetailsRate[]" id="invoiceDetailsRate<?=$i?>" class="form-control alignRight" value="<?=!empty($editDetail->invoiceDetailsRate)?$editDetail->invoiceDetailsRate:''?>" readonly />
                          </td>
                          <td>
                              <input type="text" name="invoiceDetailsAmount[]" id="invoiceDetailsAmount<?=$i?>" class="form-control alignRight amount" value="<?=!empty($editDetail->invoiceDetailsAmount)?$editDetail->invoiceDetailsAmount:''?>" readonly />
                          </td>    
                           <td style="text-align:center">
               <a style="font-size:16px; color: red" href="<?=base_url('invoice/invoiceDetailDelete/'.$editDetail->invoiceDetailsUniqId.'/'.$editData->invoiceUniqId)?>" onclick="return confirm('Are You Want To Delete....!')"><i class="fa fa-trash-o"></i></a>
						    </td>
                        </tr>
						  
					<?php $i = $i+1; } ?>
						 
						<?php } ?>
                        
                      </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                  <div class="col-sm-12">
                       <table class="table table-bordered table-responsive">
                          <tr><td style="width: 50%"></td>
                            <th style="width: 20%" class="alignRight">Gross Total</th>
                            <td style="width: 10%"></td>
                            <td style="width: 20%">
                              <?=form_input('invoiceGrossTotal', !empty($editData->invoiceGrossTotal)?$editData->invoiceGrossTotal:'', 'id="invoiceGrossTotal" class="form-control alignRight " readonly ')?>
                            </td></tr>
                          <tr><td style="width: 50%"></td>
                            <th style="width: 20%" class="alignRight">DISCOUNT %</th>
                            <td style="width: 10%"> <?=form_input('invoiceDiscountPer', !empty($editData->invoiceDiscountPer)?$editData->invoiceDiscountPer:'', 'id="invoiceDiscountPer" class="form-control alignRight" onkeyup="discountValue(1)"  tabindex="1" ')?></td>
                            <td  style="width: 20%">
                          <?=form_input('invoiceDiscountAmount', !empty($editData->invoiceDiscountAmount)?$editData->invoiceDiscountAmount:'', 'id="invoiceDiscountAmount" class="form-control alignRight" onblur="discountValue(2)" ')?>
                        </td></tr>
						<tr><td style="width: 50%"></td>
                            <th style="width: 20%" class="alignRight">CGST %</th>
                            <td style="width: 10%"> <?=form_input('invoiceCgstPer', !empty($editData->invoiceCgstPer)?$editData->invoiceCgstPer:'', 'id="invoiceCgstPer" class="form-control alignRight" onkeyup="getNetAmount()"  tabindex="1" ')?></td>
                            <td  style="width: 20%">
                          <?=form_input('invoiceCgstAmount', !empty($editData->invoiceCgstAmount)?$editData->invoiceCgstAmount:'', 'id="invoiceCgstAmount" class="form-control alignRight" readonly  onfocus="getNetAmount()"  ')?>
                        </td></tr>
                        <tr><td style="width: 50%"></td>
                            <th style="width: 20%" class="alignRight">SGST %</th>
                            <td style="width: 10%"> <?=form_input('invoiceSgstPer', !empty($editData->invoiceSgstPer)?$editData->invoiceSgstPer:'', 'id="invoiceSgstPer" class="form-control alignRight" onkeyup="getNetAmount()" tabindex="1" ')?></td>
                            <td  style="width: 20%">
                          <?=form_input('invoiceSgstAmount', !empty($editData->invoiceSgstAmount)?$editData->invoiceSgstAmount:'', 'id="invoiceSgstAmount" class="form-control alignRight " readonly onfocus="getNetAmount()"  ')?>
                        </td></tr>
                        <tr><td style="width: 50%"></td>
                            <th style="width: 20%" class="alignRight">IGST %</th>
                            <td style="width: 10%"> <?=form_input('invoiceIgstPer', !empty($editData->invoiceIgstPer)?$editData->invoiceIgstPer:'', 'id="invoiceIgstPer" class="form-control alignRight " onkeyup="getNetAmount()" tabindex="1" ')?></td>
                            <td  style="width: 20%">
                          <?=form_input('invoiceIgstAmount', !empty($editData->invoiceIgstAmount)?$editData->invoiceIgstAmount:'', 'id="invoiceIgstAmount" class="form-control alignRight " readonly onfocus="getNetAmount()"  ')?>
                        </td></tr>
                       
                        <tr><td style="width: 50%">
                          <label class="control-label">Remarks</label>
                          <?php $remarks = array ("name" => 'invoiceRemarks', "id" =>'invoiceRemarks', "class" =>'form-control',  "value"=>!empty($editData->invoiceRemarks)?$editData->invoiceRemarks:'', "rows"=>2, "tabindex"=>'1' ) ?>
                          <?=form_textarea(  $remarks)?>
                        </td>
                            <th style="width: 20%" class="alignRight">Net Amount</th>
                            <td style="width: 10%"> </td>
                            <td style="width: 20%">
                          <?=form_input('invoiceNetTotal', !empty($editData->invoiceNetTotal)?$editData->invoiceNetTotal:'', 'id="invoiceNetTotal" class="form-control alignRight " readonly="readonly" required="required" ')?>
						  <span id="invNtTtl" style="display:none;" class="errorText">Ivoice Amount is Zero..!</span>
                        </td></tr>

                        </table>
                     
                  </div>
            </div>
        
        
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
			
            <?=form_input( $invoiceFields['purSubmit'])?>
            <?=form_input( $invoiceFields['purReset'])?>
            <?=anchor(base_url('invoice'), 'Back', 'class="btn btn-info btn-sm"')?>
        </div>
        <!-- /.box-footer-->
      </div>
      <?php echo form_close(); ?>

<?php }else{ ?>

      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Invoice List</h3>

          <div class="box-tools pull-right">
            <?=anchor(base_url('invoice/invoiceAdd'),'ADD', 'class="btn btn-primary btn-sm"', 'data-widget="Add Invoice"', 'data-toggle="tooltip"', 'title="Add Invoice"')?>
           <?=form_button( $invoiceFields['collapse'])?>
            
            <!--<button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>-->
          </div>
        </div>
        <div class="box-body">
         <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>SNO</th>
                  <th>BRANCH</th>
                  <th>INVOICE NO</th>
                  <th>DATE</th>
                  <th>CUSTOMER</th>
                  <th>AMOUNT</th>
                  <th class="cnt" width="10%">ACTION</th>
                </tr>
                </thead>
                <tbody>
              <?php $sno=1; if(isset($list)){  foreach ($list as $invoiceList) { ?>
                 
                <tr>
                  <td><?=$sno++?></td>
                  <td><?=strtoupper($invoiceList->branchName)?></td>
                  <td class="fontBold">
                    <a style="color: red;" href="<?=base_url('invoicePrint/printInvoice/'.$invoiceList->invoiceUniqId)?>" target="_balnk" ><i class="fa fa-print"> &nbsp;</i></a> &nbsp;
                   <?=strtoupper($invoiceList->invoiceNo)?> &nbsp;
                   <a  style="color: green;" href="<?=base_url('invoicePrint/printInvoice/'.$invoiceList->invoiceUniqId.'/excel')?>" target="_balnk" ><i class="fa fa-file-excel-o"></i></a>
                      
                    </td>
                  <td><?=date("d/m/Y", strtotime($invoiceList->invoiceDate))?></td>
                  <td><?=strtoupper($invoiceList->customerName)?></td>
                  <td><?=$invoiceList->invoiceNetTotal?></td>
                  <td class="cnt">
                    <a href="<?=base_url('invoice/invoiceEdit/'.$invoiceList->invoiceUniqId)?>"><i class="fa fa-edit" style="font-size:16px"></i> </a>  
                   &nbsp;&nbsp;&nbsp;
				    <a style="font-size:16px; color: red" href="<?=base_url('invoice/invoiceDelete/'.$invoiceList->invoiceUniqId)?>" onclick="return confirm('Are You Want To Delete....!')"><i class="fa fa-trash-o"></i></a></td> 
                </tr>
                 <?php } } ?>
               </tbody>
                
              </table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          
        </div>
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->
<?php } ?>


    </section>


    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <!-- /.content-wrapper -->
<?php require_once "common/footer.php" ?>



<!-- page script -->
