<?php  
  include "common/header.php"; 
  include "common/sidebar.php"; 
$page = $this->uri->segment(2);
$id   = $this->uri->segment(3); 

$purchaseFields = array( 
            "purForm" => array ("method" => 'post', "name" => 'purchaseForm', "id" =>'purchaseForm', "onsubmit"=>'return formValidation();' ),
            "purSubmit" => array ("name" => 'addPurchase', "id" =>'addPurchase', "class" =>'btn btn-success btn-sm', "value"=>'SAVE',"type"=>'submit' ),
            "purReset" => array ("name" => 'resetPurchase', "id" =>'resetPurchase', "class" =>'btn btn-warning btn-sm', "value"=>'RESET',"type"=>'reset' ),
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
        <li><a href="<?=base_url('purchase')?>"><i class="fa fa-cart-plus"></i> Purchase</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
<?php if( isset($page) && ($page == 'purchaseAdd') || ($page == 'purchaseEdit' && isset($id)) ) {   ?>
      <!-- Default box -->

      <?php $func =''; if($page == 'purchaseAdd'){ $func ='purchase/purchaseInsert'; }else{ $func ='purchase/purchaseUpdate'; } ?>
<?php echo form_open_multipart($func, $purchaseFields['purForm']);?>
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"> <b>PURCHASE</b></h3>

          <div class="box-tools pull-right">
            <?php if(($page != 'purchaseAdd')){ ?><a class="btn btn-primary btn-sm" href="<?=base_url('purchase/purchaseAdd')?>" data-widget="Add Purchase" data-toggle="tooltip" title="Add Purchase"> ADD </a> <?php } ?>
            <?=form_button( $purchaseFields['collapse'])?>
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

                      <?=form_dropdown('purchaseBranchId', $branchOptions, '', 'id ="purchaseBranchId" class="form-control select2" style="width:100%;" required' )?>
                </div>

                <div class="col-sm-6">
                      <label class="control-label"> Date</label>
                      <?=form_input('purchaseDate', '', 'id ="purchaseDate" class="form-control datePicker" style="" required')?>
                </div>     

                <div class="col-sm-6">
                      <label class="control-label">Supplier</label>
                      <?=form_input('purchaseSupplierName', '', 'id ="purchaseSupplierName" class="form-control" onfocus="getSupplier()" required' )?>
                      <?php $purSid = array("name" => 'purchaseSupplierId', "id" =>'purchaseSupplierId',  "value"=>'', "type"=>'hidden'); ?>
                      <?=form_input($purSid)?>
                </div>

                <div class="col-sm-12">
                  <div class="box-body">  
                    <div class="table-responsive tableBorder">
                      <table class="table table-bordered " id="productDetailTable">
                        <thead>
                          <tr><th colspan="6" class="upperCase" style="background-color: #bbe1f8; color: #222d32; font-size: 22px;">
                           Product Details 
                              <div style="float:right; "><span id="productRow" class="fa fa-fw fa-plus-square" data-toggle='tooltip' title='Add Product Row'></span></div>
                          </th></tr>
                        
                        <tr style="background-color: #daecf8; color: #222d32" class="upperCase">
                          <th style="width: 5%;">#</th>
                          <th style="width: 25%;"> Product</th>
                          <th style="width: 15%;"> Code</th>
                          <th style="width: 15%;"> Quantity</th>
                          <th style="width: 15%;"> Rate</th>
                          <th style="width: 20%;"> Amount </th>
                        </tr>
                        </thead>
                        <tbody><div class="col-sm-12">
                        <?php $i=0; $sno = 1; ?>
                        <tr>
                          <td> <?=$sno++?></td>  
                          <td>
                            <?=form_input('purchaseDetailsProductName[]', '', 'id="purchaseDetailsProductName'.$i.'" class="form-control" onfocus="getProduct('.$i.')"')?>
                            <?=form_hidden('purchaseDetailsProductId[]', '', 'id="purchaseDetailsProductId'.$i.'"')?>
                            <?=form_hidden('purchaseDetailsId[]', '', 'id="purchaseDetailsId'.$i.'"')?>
                          </td>
                          <td>
                            <?=form_input('purchaseDetailsProductCode[]', '', 'id="purchaseDetailsProductCode'.$i.'" class="form-control" readonly')?>
                          </td> 
                          <td>
                            <?=form_input('purchaseDetailsQty[]', '', 'id="purchaseDetailsQty'.$i.'" class="form-control alignRight" onkeyup="getAmount('.$i.')"  ')?>
                          </td> 
                          <td>
                            <?=form_input('purchaseDetailsRate[]', '', 'id="purchaseDetailsRate'.$i.'" class="form-control alignRight" onfocus="getAmount('.$i.')" readonly')?>
                          </td>
                          <td>
                            <?=form_input('purchaseDetailsAmount[]', '', 'id="purchaseDetailsAmount'.$i.'" class="form-control alignRight amount" onfocus="getAmount('.$i.')" readonly ')?>
                          </td>    
                        </tr>

                        </tbody>
                      
                      </table>
                    </div>
                  </div>
                </div>
                  <div class="col-sm-12">
                       <table class="table table-bordered table-responsive">
                          <tr><td style="width: 50%"></td>
                            <th  style="width: 20%" class="alignRight">Gross Total</th>
                            <td  style="width: 10%"></td>
                            <td  style="width: 20%">
                              <?=form_input('purchaseGrossTotal', '', 'id="purchaseGrossTotal" class="form-control alignRight " readonly ')?>
                            </td></tr>
                          <tr><td style="width: 50%"></td>
                            <th  style="width: 20%" class="alignRight">CGST %</th>
                            <td  style="width: 10%"> <?=form_input('purchaseCgstPer', '', 'id="purchaseCgstPer" class="form-control alignRight " onkeyup="getNetAmount()" ')?></td>
                            <td  style="width: 20%">
                          <?=form_input('purchaseCgstAmount', '', 'id="purchaseCgstAmount" class="form-control alignRight " readonly  onfocus="getNetAmount()"  ')?>
                        </td></tr>
                        <tr><td style="width: 50%"></td>
                            <th  style="width: 20%" class="alignRight">SGST %</th>
                            <td  style="width: 10%"> <?=form_input('purchaseSgstPer', '', 'id="purchaseSgstPer" class="form-control alignRight " onkeyup="getNetAmount()"  ')?></td>
                            <td  style="width: 20%">
                          <?=form_input('purchaseSgstAmount', '', 'id="purchaseSgstAmount" class="form-control alignRight " readonly onfocus="getNetAmount()"  ')?>
                        </td></tr>
                        <tr><td style="width: 50%"></td>
                            <th  style="width: 20%" class="alignRight">IGST %</th>
                            <td  style="width: 10%"> <?=form_input('purchaseIgstPer', '', 'id="purchaseIgstPer" class="form-control alignRight " onkeyup="getNetAmount()"  ')?></td>
                            <td  style="width: 20%">
                          <?=form_input('purchaseIgstAmount', '', 'id="purchaseIgstAmount" class="form-control alignRight " readonly onfocus="getNetAmount()"  ')?>
                        </td></tr>
                       
                        <tr><td style="width: 50%">
                          <label class="control-label">Remarks</label>
                          <?php $remarks = array ("name" => 'purchaseRemarks', "id" =>'purchaseRemarks', "class" =>'form-control',  "value"=>'', "rows"=>2 ) ?>
                          <?=form_textarea(  $remarks)?>
                        </td>
                            <th  style="width: 20%" class="alignRight">Net Amount</th>
                            <td  style="width: 10%"> </td>
                            <td  style="width: 20%">
                          <?=form_input('purchaseNetTotal', '', 'id="purchaseNetTotal" class="form-control alignRight " readonly="readonly" required="required" ')?>
                        </td></tr>

                        </table>
                     
                  </div>
            </div>
        
        
        </div>
        <!-- /.box-body -->
        <div class="box-footer">

            <?=form_input( $purchaseFields['purSubmit'])?>
            <?=form_input( $purchaseFields['purReset'])?>
            <?=anchor(base_url('purchase'), 'Back', 'class="btn btn-info btn-sm"')?>
        </div>
        <!-- /.box-footer-->
      </div>
      <?php echo form_close(); ?>
<?php }else{ ?>

      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Purchase List</h3>

          <div class="box-tools pull-right">
            <?=anchor(base_url('purchase/purchaseAdd'),'ADD', 'class="btn btn-primary btn-sm"', 'data-widget="Add Purchase"', 'data-toggle="tooltip"', 'title="Add Purchase"')?>
           <?=form_button( $purchaseFields['collapse'])?>
            
            <!--<button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>-->
          </div>
        </div>
        <div class="box-body">
         <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>SNO</th>
                  <th>CODE</th>
                  <th>NAME</th>
                  <th>MOBILE</th>
                  <th>E-MAIL</th>
                  <th class="cnt" width="10%">ACTION</th>
                </tr>
                </thead>
                <tbody>
              <?php $sno=1; if(isset($list)){  foreach ($list as $purchaseList) { ?>
                 
                <tr>
                  <td><?=$sno++?></td>
                  <td><?=strtoupper($purchaseList->purchaseCode)?></td>
                  <td><?=strtoupper($purchaseList->purchaseName)?></td>
                  <td><?=$purchaseList->purchaseMobileNo?></td>
                  <td><?=$purchaseList->purchaseEmail?></td>
                  <td class="cnt">
                    <a href="<?=base_url('purchase/purchaseEdit/'.$purchaseList->purchaseUniqId)?>"><i class="fa fa-edit" style="font-size:16px"></i> </a>  
                   &nbsp;&nbsp; <a style="font-size:16px; color: red" href="<?=base_url('purchase/purchaseDelete/'.$purchaseList->purchaseUniqId)?>"><i class="fa fa-trash-o"></i></td> 
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
<script>
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

  function getSupplier(){
    $('#purchaseSupplierName').autocomplete({ source: '<?=base_url("autoCompleteData/getSupplier")?>', minLength:1,
      select:function(evt, ui){
                $('#purchaseSupplierId').val(ui.item.supplierId);
      } 
    });
  }
  function getProduct(id){
    $('#purchaseDetailsProductName'+id).autocomplete({ source: '<?=base_url("autoCompleteData/getProduct")?>', minLength:1,
      select:function(evt, ui){
                $('#purchaseDetailsProductCode'+id).val(ui.item.productCode);
                $('#purchaseDetailsProductId'+id).val(ui.item.productId); 
                $('#purchaseDetailsRate'+id).val(ui.item.productRate); 
                $('#purchaseDetailsQty'+id).focus();
      } 
    });
  }


 $('#productRow').click(function(){
       
        var rowCount  = $('#productDetailTable >tbody >tr').length; 
        var i         = parseInt(rowCount);
        var sno       = parseInt(rowCount) + 1; 
        var apndRow = '<tr>';

            apndRow += '<td> '+ sno +'</td>';

            apndRow += '<td><input type="hidden" name="productDetailsId[]" id="productDetailsId'+i+'" /> ';
            apndRow += '<input type="hidden" name="purchaseDetailsProductId[]" id="purchaseDetailsProductId'+i+'" /> ';
            apndRow += '<input type="text" name="purchaseDetailsProductName[]" id="purchaseDetailsProductName'+i+'" onfocus="getProduct('+i+')" class="form-control" /> </td>';

            apndRow += '<td><input type="text" name="purchaseDetailsProductCode[]" id="purchaseDetailsProductCode'+i+'" class="form-control" readonly /> </td>';

            apndRow += '<td><input type="text" name="purchaseDetailsQty[]" id="purchaseDetailsQty'+i+'" class="form-control alignRight" onkeyup="getAmount('+i+')" /> </td>';

            apndRow += '<td><input type="text" name="purchaseDetailsRate[]" id="purchaseDetailsRate'+i+'" class="form-control alignRight" onfocus="getAmount('+i+')" readonly /> </td>';

            apndRow += '<td><input type="text" name="purchaseDetailsAmount[]" id="purchaseDetailsAmount'+i+'" class="form-control alignRight amount" onfocus="getAmount('+i+')" readonly /> </td></tr>';

        $('#productDetailTable >tbody').append(apndRow);
 });

function getAmount(id){

    var qty   = $('#purchaseDetailsQty'+id).val();
    var rate  = $('#purchaseDetailsRate'+id).val();
    var amount = 0;
    
      if(!isNaN(qty)){
        
        var qtyVal    = Number(qty); 
        var rateVal   = Number(rate);

         amount    = qtyVal * rateVal;

        $('#purchaseDetailsAmount'+id).val(amount.toFixed(2));

       getTotalAmount();
      }else{
            alert('Please Enter numbers in Quantity');
              $('#purchaseDetailsAmount'+id).val(amount.toFixed(2));
              $('#purchaseDetailsQty'+id).focus();
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
      $('#purchaseGrossTotal').val(total.toFixed(2));
}

function getNetAmount(){

    var gross     = Number($('#purchaseGrossTotal').val());
    var cgstPer   = Number($('#purchaseCgstPer').val());
    var cgstamt   = Number($('#purchaseCgstAmount').val());
    var sgstPer   = Number($('#purchaseSgstPer').val());
    var sgstamt   = Number($('#purchaseSgstAmount').val());
    var igstPer   = Number($('#purchaseIgstPer').val());
    var igstamt   = Number($('#purchaseIgstAmount').val());
    var net       = Number($('#purchaseNetTotal').val());


    cgstAmount    = ( gross * cgstPer ) / 100 ; $('#purchaseCgstAmount').val(cgstAmount.toFixed(2));
    sgstAmount    = ( gross * sgstPer ) / 100 ; $('#purchaseSgstAmount').val(sgstAmount.toFixed(2));
    igstAmount    = ( gross * igstPer ) / 100 ; $('#purchaseIgstAmount').val(igstAmount.toFixed(2));

    var netAmount = gross + cgstAmount + sgstAmount + igstAmount; 

    $('#purchaseNetTotal').val(netAmount.toFixed(2));
}

function formValidation(){

      var isValid = true; 

      var branchId    = $('#purchaseBranchId').val();
      var SupplierId  = $('#purchaseSupplierId').val();
      var pDate       = $('#purchaseDate').val();
      var amount      = $('#purchaseNetTotal').val();

      if(branchId =='' || branchId ==0){
          $('#purchaseBranchId').css({"border-color": "#f31242", "border-width":"1px", "border-style":"solid"});
          $('#purchaseBranchId').focus();
       
       isValid = false;

      }
      if(SupplierId =='' || SupplierId ==0){
          $('#purchaseSupplierName').css({"border-color": "#f31242", "border-width":"1px", "border-style":"solid"});
          $('#purchaseSupplierName').focus();
       
       isValid = false;

      }
      if(pDate =='' || pDate =='00/00/0000'){
          $('#purchaseDate').css({"border-color": "#f31242", "border-width":"1px", "border-style":"solid"});
          $('#purchaseDate').focus();
       
       isValid = false;

      }
      if(amount =='' || amount ==0 ){
          $('#purchaseNetTotal').css({"border-color": "#f31242", "border-width":"1px", "border-style":"solid"});
          $('#purchaseNetTotal').focus();
       
       isValid = false;

      }
     
      return isValid;

}
</script>
