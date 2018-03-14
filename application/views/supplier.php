<?php  
  include "common/header.php"; 
  include "common/sidebar.php"; 
$page = $this->uri->segment(2);
$id   = $this->uri->segment(3); 
$supplierCode     = isset($editData->supplierCode) ? $editData->supplierCode:'';
$supplierName     = isset($editData->supplierName) ? $editData->supplierName:'';
$supplierMobileNo = isset($editData->supplierMobileNo) ? $editData->supplierMobileNo:'';
$supplierAddress  = isset($editData->supplierAddress) ? $editData->supplierAddress:'';
$supplierEmail    = isset($editData->supplierEmail) ? $editData->supplierEmail:'';
$supplierGstNo    = isset($editData->supplierGstNo) ? $editData->supplierGstNo:'';
$supplierId       = isset($editData->supplierId) ? $editData->supplierId:'';
$supplierUniqId   = isset($editData->supplierUniqId) ? $editData->supplierUniqId:'';

$supplierFields = array( 
            "supForm" => array ("method" => 'post', "name" => 'supplierForm', "id" =>'supplierForm' ),
            "supCode" => array ("name" => 'supplierCode', "id" =>'supplierCode', "class" =>'form-control upperCase', "required"=>'required',  "value"=> $supplierCode ),
            "supName" => array ("name" => 'supplierName', "id" =>'supplierName', "class" =>'form-control upperCase', "required"=>'required', "value"=>$supplierName ),
            "supMob" => array ("name" => 'supplierMobileNo', "id" =>'supplierMobileNo', "class" =>'form-control',  "value"=>$supplierMobileNo ),
            "supEmail" => array ("name" => 'supplierEmail', "id" =>'supplierEmail', "class" =>'form-control',  "value"=>$supplierEmail ),
            "supGst" => array ("name" => 'supplierGstNo', "id" =>'supplierGstNo', "class" =>'form-control upperCase',  "value"=>$supplierGstNo ),
            "supAddress" => array ("name" => 'supplierAddress', "id" =>'supplierAddress', "class" =>'form-control',  "value"=>$supplierAddress, "rows"=>2 ),
            "supId" => array ("name" => 'supplierId', "id" =>'supplierId', "class" =>'form-control', "value"=>$supplierId, "type"=>'hidden'),
            "supUniqId" => array ("name" => 'supplierUniqId', "id" =>'supplierUniqId', "class" =>'form-control', "value"=>$supplierUniqId,"type"=>'hidden' ),
            "supSubmit" => array ("name" => 'addSupplier', "id" =>'addSupplier', "class" =>'btn btn-success btn-sm', "value"=>'SAVE',"type"=>'submit' ),
            "supReset" => array ("name" => 'resetSupplier', "id" =>'resetSupplier', "class" =>'btn btn-warning btn-sm', "value"=>'RESET',"type"=>'reset' ),
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
        <li><a href="<?=base_url('supplier')?>"><i class="fa fa-cart-plus"></i> Supplier</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
<?php if( isset($page) && ($page == 'supplierAdd') || ($page == 'supplierEdit' && isset($id)) ) {   ?>
      <!-- Default box -->

      <?php $func =''; if($page == 'supplierAdd'){ $func ='supplier/supplierInsert'; }else{ $func ='supplier/supplierUpdate'; } ?>
<?php echo form_open_multipart($func, $supplierFields['supForm']);?>
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"> <b>SUPPLIER</b></h3>

          <div class="box-tools pull-right">
            <?php if(($page != 'supplierAdd')){ ?><a class="btn btn-primary btn-sm" href="<?=base_url('supplier/supplierAdd')?>" data-widget="Add Supplier" data-toggle="tooltip" title="Add Supplier"> ADD </a> <?php } ?>
            <?=form_button( $supplierFields['collapse'])?>
            <!--<button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>-->
          </div>
        </div>
        <div class="box-body">
            <div class="col-sm-12">
                <div class="col-sm-6">
                      <label class="control-label">Supplier Code </label>
                      <?=form_input( $supplierFields['supCode'])?>
                </div>
                <div class="col-sm-6">
                      <label class="control-label">Supplier Name</label>
                      <?=form_input( $supplierFields['supName'])?>
                </div>        
                <div class="col-sm-6">
                      <label class="control-label">Mobile No</label>
                      <?=form_input( $supplierFields['supMob'])?>
                </div>
                <div class="col-sm-6">
                      <label class="control-label">Email</label>
                      <?=form_input( $supplierFields['supEmail'])?>
                </div>
                <div class="col-sm-6">
                      <label class="control-label">GST NO</label>
                      <?=form_input( $supplierFields['supGst'])?> 
                </div>
                <div class="col-sm-6">
                      <label class="control-label">Address</label>
                      <?=form_textarea( $supplierFields['supAddress'])?> 
                </div>
            </div>
        
        
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <?=form_input( $supplierFields['supId'])?>
            <?=form_input( $supplierFields['supUniqId'])?>

            <?=form_input( $supplierFields['supSubmit'])?>
            <?=form_input( $supplierFields['supReset'])?>
            <?=anchor(base_url('supplier'), 'Back', 'class="btn btn-info btn-sm"')?>
        </div>
        <!-- /.box-footer-->
      </div>
      <?php echo form_close(); ?>
<?php }else{ ?>

      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Supplier List</h3>

          <div class="box-tools pull-right">
            <?=anchor(base_url('supplier/supplierAdd'),'ADD', 'class="btn btn-primary btn-sm"', 'data-widget="Add Supplier"', 'data-toggle="tooltip"', 'title="Add Supplier"')?>
           <?=form_button( $supplierFields['collapse'])?>
            
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
              <?php $sno=1; if(isset($list)){  foreach ($list as $supplierList) { ?>
                 
                <tr>
                  <td><?=$sno++?></td>
                  <td><?=strtoupper($supplierList->supplierCode)?></td>
                  <td><?=strtoupper($supplierList->supplierName)?></td>
                  <td><?=$supplierList->supplierMobileNo?></td>
                  <td><?=$supplierList->supplierEmail?></td>
                  <td class="cnt">
                    <a href="<?=base_url('supplier/supplierEdit/'.$supplierList->supplierUniqId)?>"><i class="fa fa-edit" style="font-size:16px"></i> </a>  
                   &nbsp;&nbsp; <a style="font-size:16px; color: red" href="<?=base_url('supplier/supplierDelete/'.$supplierList->supplierUniqId)?>"><i class="fa fa-trash-o"></i></td> 
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