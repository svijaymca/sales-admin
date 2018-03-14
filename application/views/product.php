<?php  
  include "common/header.php"; 
  include "common/sidebar.php"; 
$page = $this->uri->segment(2);
$id   = $this->uri->segment(3); 
$productCode    = isset($editData->productCode) ? $editData->productCode:'';
$productName    = isset($editData->productName) ? $editData->productName:'';
$productRate    = isset($editData->productRate) ? $editData->productRate:'';
$productId      = isset($editData->productId) ? $editData->productId:'';
$productUniqId  = isset($editData->productUniqId) ? $editData->productUniqId:'';
$productFields = array( 
            "prdForm" => array ("method" => 'post', "name" => 'productForm', "id" =>'productForm' ),
            "prdCode" => array ("name" => 'productCode', "id" =>'productCode', "class" =>'form-control upperCase', "required"=>'required',  "value"=> $productCode ),
            "prdName" => array ("name" => 'productName', "id" =>'productName', "class" =>'form-control upperCase', "required"=>'required', "value"=>$productName ),
            "prdRate" => array ("name" => 'productRate', "id" =>'productRate', "class" =>'form-control',  "value"=>$productRate ),
            "prdId" => array ("name" => 'productId', "id" =>'productId', "class" =>'form-control', "value"=>$productId, "type"=>'hidden'),
            "prdUniqId" => array ("name" => 'productUniqId', "id" =>'productUniqId', "class" =>'form-control', "value"=>$productUniqId,"type"=>'hidden' ),
            "prdSubmit" => array ("name" => 'addProduct', "id" =>'addProduct', "class" =>'btn btn-success btn-sm', "value"=>'SAVE',"type"=>'submit' ),
            "prdReset" => array ("name" => 'resetProduct', "id" =>'resetProduct', "class" =>'btn btn-warning btn-sm', "value"=>'RESET',"type"=>'reset' ),
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
        <li><a href="<?=base_url('product')?>"><i class="fa fa-cart-plus"></i> Product</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
<?php if( isset($page) && ($page == 'productAdd') || ($page == 'productEdit' && isset($id)) ) {   ?>
      <!-- Default box -->

      <?php $func =''; if($page == 'productAdd'){ $func ='product/productInsert'; }else{ $func ='product/productUpdate'; } ?>
<?php echo form_open_multipart($func, $productFields['prdForm']);?>
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"> <b>PRODUCT</b></h3>

          <div class="box-tools pull-right">
            <?php if(($page != 'productAdd')){ ?><a class="btn btn-primary btn-sm" href="<?=base_url('product/productAdd')?>" data-widget="Add Product" data-toggle="tooltip" title="Add Product"> ADD </a> <?php } ?>
            <?=form_button( $productFields['collapse'])?>
            <!--<button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>-->
          </div>
        </div>
        <div class="box-body">
          <div class="col-sm-12">
            <div class="col-sm-6">
                  <label class="control-label">Product Code </label>
                  <?=form_input( $productFields['prdCode'])?>
            </div>
            <div class="col-sm-6">
                  <label class="control-label">Product Name</label>
                  <?=form_input( $productFields['prdName'])?>
            </div>        
            <div class="col-sm-6">
                  <label class="control-label">Rate</label>
                  <?=form_input( $productFields['prdRate'])?>
                  <?php echo validation_errors('<div class="error">', '</div>'); ?>
            </div>
          </div>
        
        
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <?=form_input( $productFields['prdId'])?>
            <?=form_input( $productFields['prdUniqId'])?>

            <?=form_input( $productFields['prdSubmit'])?>
            <?=form_input( $productFields['prdReset'])?>
            <?=anchor(base_url('product'), 'Back', 'class="btn btn-info btn-sm"')?>
        </div>
        <!-- /.box-footer-->
      </div>
      <?php echo form_close(); ?>
<?php }else{ ?>

      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Product List</h3>

          <div class="box-tools pull-right">
            <?=anchor(base_url('product/productAdd'),'ADD', 'class="btn btn-primary btn-sm"', 'data-widget="Add Product"', 'data-toggle="tooltip"', 'title="Add Product"')?>
           <?=form_button( $productFields['collapse'])?>
            
            <!--<button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>-->
          </div>
        </div>
        <div class="box-body" id="div-table-content">
         <table id="example1" class="table table-bordered table-striped" style="overflow-x: scroll;">
                <thead>
                <tr>
                  <th>SNO</th>
                  <th>CODE</th>
                  <th>NAME</th>
                  <th>RATE</th>
                  <th class="cnt" width="10%">ACTION</th>
                </tr>
                </thead>
                <tbody>
              <?php $sno=1; if(isset($list)){  foreach ($list as $productList) { ?>
                 
                <tr>
                  <td><?=$sno++?></td>
                  <td><?=strtoupper($productList->productCode)?></td>
                  <td><?=strtoupper($productList->productName)?></td>
                  <td><?=$productList->productRate?></td>
                  <td class="cnt">
                    <a href="<?=base_url('product/productEdit/'.$productList->productUniqId)?>"><i class="fa fa-edit" style="font-size:16px"></i> </a>  
                  &nbsp; &nbsp; <a style="font-size:16px; color: red;" href="<?=base_url('product/productDelete/'.$productList->productUniqId)?>"><i class="fa fa-trash-o"></i></td> 
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
      'autoWidth'   : false,
      "scrollY": 200,
        "scrollX": true
    })
  })
</script>