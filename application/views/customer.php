<?php  
  include "common/header.php"; 
  include "common/sidebar.php"; 
$page = $this->uri->segment(2);
$id   = $this->uri->segment(3); 
$customerCode     = isset($editData->customerCode) ? $editData->customerCode:'';
$customerName     = isset($editData->customerName) ? $editData->customerName:'';
$customerMobileNo = isset($editData->customerMobileNo) ? $editData->customerMobileNo:'';
$customerAddress  = isset($editData->customerAddress) ? $editData->customerAddress:'';
$customerEmail    = isset($editData->customerEmail) ? $editData->customerEmail:'';
$customerGstNo    = isset($editData->customerGstNo) ? $editData->customerGstNo:'';
$customerId       = isset($editData->customerId) ? $editData->customerId:'';
$customerUniqId   = isset($editData->customerUniqId) ? $editData->customerUniqId:'';

$customerFields = array( 
            "cusForm" => array ("method" => 'post', "name" => 'customerForm', "id" =>'customerForm' ),
            "cusCode" => array ("name" => 'customerCode', "id" =>'customerCode', "class" =>'form-control upperCase', "required"=>'required',  "value"=> $customerCode ),
            "cusName" => array ("name" => 'customerName', "id" =>'customerName', "class" =>'form-control upperCase', "required"=>'required', "value"=>$customerName ),
            "cusMob" => array ("name" => 'customerMobileNo', "id" =>'customerMobileNo', "class" =>'form-control',  "value"=>$customerMobileNo ),
            "cusEmail" => array ("name" => 'customerEmail', "id" =>'customerEmail', "class" =>'form-control',  "value"=>$customerEmail ),
            "cusGst" => array ("name" => 'customerGstNo', "id" =>'customerGstNo', "class" =>'form-control upperCase',  "value"=>$customerGstNo ),
            "cusAddress" => array ("name" => 'customerAddress', "id" =>'customerAddress', "class" =>'form-control',  "value"=>$customerAddress, "rows"=>2 ),
            "cusId" => array ("name" => 'customerId', "id" =>'customerId', "class" =>'form-control', "value"=>$customerId, "type"=>'hidden'),
            "cusUniqId" => array ("name" => 'customerUniqId', "id" =>'customerUniqId', "class" =>'form-control', "value"=>$customerUniqId,"type"=>'hidden' ),
            "cusSubmit" => array ("name" => 'addCustomer', "id" =>'addCustomer', "class" =>'btn btn-success btn-sm', "value"=>'SAVE',"type"=>'submit' ),
            "cusReset" => array ("name" => 'resetCustomer', "id" =>'resetCustomer', "class" =>'btn btn-warning btn-sm', "value"=>'RESET',"type"=>'reset' ),
            "collapse" => array ("name" => 'minMax', "id" =>'minMax', "class" =>'btn btn-box-tool fa fa-minus', "data-widget"=>'collapse', "data-toggle"=>'tooltip', "title"=>'Collapse' ),
            
         );
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        MASTER
        <small>all master details</small>
        <?php if ($this->session->flashdata('msg')) {  ?> 
              <span style="color: green; font-size: 14px; text-align: center; padding-left: 20%; padding-right: 20%; "> 
                <?php  echo $this->session->flashdata('msg'); ?> 
              </span> <?php  }?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url('home')?>"><i class="fa fa-home"></i> Home</a></li>
        <li><a href="<?=base_url('customer')?>"><i class="fa fa-cart-plus"></i> Customer</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
<?php if( isset($page) && ($page == 'customerAdd') || ($page == 'customerEdit' && isset($id)) ) {   ?>
      <!-- Default box -->

      <?php $func =''; if($page == 'customerAdd'){ $func ='customer/customerInsert'; }else{ $func ='customer/customerUpdate'; } ?>
<?php echo form_open_multipart($func, $customerFields['cusForm']);?>
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"> <b>CUSTOMER</b></h3>

          <div class="box-tools pull-right">
            <?php if(($page != 'customerAdd')){ ?><a class="btn btn-primary btn-sm" href="<?=base_url('customer/customerAdd')?>" data-widget="Add Customer" data-toggle="tooltip" title="Add Customer"> ADD </a> <?php } ?>
            <?=form_button( $customerFields['collapse'])?>
            <!--<button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>-->
          </div>
        </div>
        <div class="box-body">
            <div class="col-sm-12">
                <div class="col-sm-6">
                      <label class="control-label">Customer Code </label>
                      <?=form_input( $customerFields['cusCode'])?>
                </div>
                <div class="col-sm-6">
                      <label class="control-label">Customer Name</label>
                      <?=form_input( $customerFields['cusName'])?>
                </div>        
                <div class="col-sm-6">
                      <label class="control-label">Mobile No</label>
                      <?=form_input( $customerFields['cusMob'])?>
                </div>
                <div class="col-sm-6">
                      <label class="control-label">Email</label>
                      <?=form_input( $customerFields['cusEmail'])?>
                </div>
                <div class="col-sm-6">
                      <label class="control-label">GST NO</label>
                      <?=form_input( $customerFields['cusGst'])?> 
                </div>
                <div class="col-sm-6">
                      <label class="control-label">Address</label>
                      <?=form_textarea( $customerFields['cusAddress'])?> 
                </div>
            </div>
        
        
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <?=form_input( $customerFields['cusId'])?>
            <?=form_input( $customerFields['cusUniqId'])?>

            <?=form_input( $customerFields['cusSubmit'])?>
            <?=form_input( $customerFields['cusReset'])?>
            <?=anchor(base_url('customer'), 'Back', 'class="btn btn-info btn-sm"')?>
        </div>
        <!-- /.box-footer-->
      </div>
      <?php echo form_close(); ?>
<?php }else{ ?>

      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Customer List</h3>

          <div class="box-tools pull-right">
            <?=anchor(base_url('customer/customerAdd'),'ADD', 'class="btn btn-primary btn-sm"', 'data-widget="Add Customer"', 'data-toggle="tooltip"', 'title="Add Customer"')?>
           <?=form_button( $customerFields['collapse'])?>
            
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
              <?php $sno=1; if(isset($list)){  foreach ($list as $customerList) { ?>
                 
                <tr>
                  <td><?=$sno++?></td>
                  <td><?=strtoupper($customerList->customerCode)?></td>
                  <td><?=strtoupper($customerList->customerName)?></td>
                  <td><?=$customerList->customerMobileNo?></td>
                  <td><?=$customerList->customerEmail?></td>
                  <td class="cnt">
                    <a href="<?=base_url('customer/customerEdit/'.$customerList->customerUniqId)?>"><i class="fa fa-edit" style="font-size:16px"></i> </a>  
                   &nbsp;&nbsp; <a style="font-size:16px; color: red" href="<?=base_url('customer/customerDelete/'.$customerList->customerUniqId)?>"><i class="fa fa-trash-o"></i></td> 
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