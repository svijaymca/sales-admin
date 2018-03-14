<?php  
  include "common/header.php"; 
  include "common/sidebar.php"; 
$page = $this->uri->segment(2);
$id   = $this->uri->segment(3); 
$purchaseCode     = isset($editData->purchaseCode) ? $editData->purchaseCode:'';
$purchaseName     = isset($editData->purchaseName) ? $editData->purchaseName:'';
$purchaseMobileNo = isset($editData->purchaseMobileNo) ? $editData->purchaseMobileNo:'';
$purchaseAddress  = isset($editData->purchaseAddress) ? $editData->purchaseAddress:'';
$purchaseEmail    = isset($editData->purchaseEmail) ? $editData->purchaseEmail:'';
$purchaseGstNo    = isset($editData->purchaseGstNo) ? $editData->purchaseGstNo:'';
$purchaseId       = isset($editData->purchaseId) ? $editData->purchaseId:'';
$purchaseUniqId   = isset($editData->purchaseUniqId) ? $editData->purchaseUniqId:'';

$purchaseFields = array( 
            "purForm" => array ("method" => 'post', "name" => 'purchaseForm', "id" =>'purchaseForm' ),
            "purCode" => array ("name" => 'purchaseCode', "id" =>'purchaseCode', "class" =>'form-control upperCase', "required"=>'required',  "value"=> $purchaseCode ),
            "purName" => array ("name" => 'purchaseName', "id" =>'purchaseName', "class" =>'form-control upperCase', "required"=>'required', "value"=>$purchaseName ),
            "purMob" => array ("name" => 'purchaseMobileNo', "id" =>'purchaseMobileNo', "class" =>'form-control',  "value"=>$purchaseMobileNo ),
            "purEmail" => array ("name" => 'purchaseEmail', "id" =>'purchaseEmail', "class" =>'form-control',  "value"=>$purchaseEmail ),
            "purGst" => array ("name" => 'purchaseGstNo', "id" =>'purchaseGstNo', "class" =>'form-control upperCase',  "value"=>$purchaseGstNo ),
            "purAddress" => array ("name" => 'purchaseAddress', "id" =>'purchaseAddress', "class" =>'form-control',  "value"=>$purchaseAddress, "rows"=>2 ),
            "purId" => array ("name" => 'purchaseId', "id" =>'purchaseId', "class" =>'form-control', "value"=>$purchaseId, "type"=>'hidden'),
            "purUniqId" => array ("name" => 'purchaseUniqId', "id" =>'purchaseUniqId', "class" =>'form-control', "value"=>$purchaseUniqId,"type"=>'hidden' ),
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

                      <?=form_dropdown('purchaseBranchId', $branchOptions, '', 'id ="purchaseBranchId" class="form-control select2" style="width:100%;" ' )?>
                </div>

                <div class="col-sm-6">
                      <label class="control-label"> Date</label>
                      <?=form_input('purchaseDate', '', 'id ="purchaseDate" class="form-control datePicker" style="" ')?>
                </div>     

                <div class="col-sm-6">
                      <label class="control-label">Supplier</label>
                      <?=form_input('purchaseSupplierName', '', 'id ="purchaseSupplierName" class="form-control" onfocus="getSupplier()"')?>
                      <?php $purSid = array("name" => 'purchaseSupplierId', "id" =>'purchaseSupplierId',  "value"=>'', "type"=>'hidden'); ?>
                      <?=form_input($purSid)?>
                </div>

                <div class="col-sm-6">
                      <label class="control-label">Email</label>
                      <?=form_input( $purchaseFields['purEmail'])?>
                </div>

                <div class="col-sm-6">
                      <label class="control-label">GST NO</label>
                      <?=form_input( $purchaseFields['purGst'])?> 
                </div>

                <div class="col-sm-6">
                      <label class="control-label">Address</label>
                      <?=form_textarea( $purchaseFields['purAddress'])?> 
                </div>

            </div>
        
        
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <?=form_input( $purchaseFields['purId'])?>
            <?=form_input( $purchaseFields['purUniqId'])?>

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
  })
</script>