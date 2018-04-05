<?php  
  include "common/header.php"; 
  include "common/sidebar.php"; 
$page = $this->uri->segment(2);
$id   = $this->uri->segment(3); 

$stockAvailabilityFields = array( 
            "collapse" => array ("name" => 'minMax', "id" =>'minMax', "class" =>'btn btn-box-tool fa fa-minus', "data-widget"=>'collapse', "data-toggle"=>'tooltip', "title"=>'Collapse' ),
         );
?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        STOCK AVALABILITY
        <small>all details</small>
        <?php if ($this->session->flashdata('msg')) {  ?> 
              <span style="color: green; font-size: 14px; text-align: center; padding-left: 20%; padding-right: 20%; "> 
                <?php  echo $this->session->flashdata('msg'); ?> 
              </span> <?php  }?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url('home')?>"><i class="fa fa-home"></i> Home</a></li>
        <li><a href="<?=base_url('stockAvailability')?>"><i class="fa fa-cart-plus"></i> Stock Availability</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->

      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Stock Availability</h3>

          <div class="box-tools pull-right">
           <?=form_button( $stockAvailabilityFields['collapse'])?>
            
          </div>
        </div>
        <div class="box-body">
          <form id="searchStockForm" method="post" action="stockAvailability" >
            <div class="col-sm-12">

                <div class="col-sm-6">
                      <label class="control-label">Branch</label>
                    <?php $branchOptions = array( '0' => ' - SELECT - ');
                       foreach ($branchList as  $list) {
                         $branchOptions[$list->branchId]   = $list->branchName;
                     } $searchBranchId = (isset($_REQUEST['searchBranchId'])) ? $_REQUEST['searchBranchId']:''; ?>    

                      <?=form_dropdown('searchBranchId', $branchOptions, $searchBranchId, 'id ="searchBranchId" class="form-control" style="width:100%;" required tabindex="1"' )?>
                </div>

                <div class="col-sm-6">
                  <?php $searchProductName  = (isset($_REQUEST['searchProductName'])) ? $_REQUEST['searchProductName']:''; 
                        $searchProductId    = (isset($_REQUEST['searchProductId'])) ? $_REQUEST['searchProductId']:'';  ?> 
                      <label class="control-label"> Product</label>
                      <?=form_input('searchProductName', $searchProductName, ' id="searchProductName" class="form-control" tabindex="1" onfocus="getProduct()"')?>
                      <input type="hidden" name="searchProductId" id="searchProductId" value="<?=$searchProductId?>">
                </div> 
                <div class="col-sm-12" style="text-align: center;"> <br>
                    <input type="submit" name="search" id="search" value="Search" class="btn btn-success btn-sm">
                    <input type="reset" name="reset" id="reset" value="Reset" class="btn btn-info btn-sm">
                </div>
            </div>
          </form>
<div class="col-sm-12">
   <?php if(isset($stockList)){ ?>  <a style="color: green;" href="<?=base_url('stockAvailability/stockLedgerExcel/'.$searchBranchId.'/'.$searchProductId)?>" target="_balnk" ><i class="fa fa-file-excel-o" style="float: right; font-size: 20px;"></i></a> <?php } ?>
</div>          
<div class="col-sm-12">
  <?php if(isset($stockList)){ ?>
         <table id="stock" style="width: 95%;" align="center" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style="width: 5%;" >SNO</th>
                  <th style="width: 15%;">PRODUCT CODE</th>
                  <th style="width: 60%;">PRODUCT NAME</th>
                  <th style="width: 20%;">AVAILABILE QUANTITY</th>
                  
                </thead>
                <tbody>
              <?php $sno=1; $stockQty = 0;  foreach ($stockList as $stockAvailabilityList) { ?>
                 
                <tr>
                  <td class="alignCenter"><?=$sno++?></td>
                  <td class="alignCenter"><?=strtoupper($stockAvailabilityList->productCode)?></td>
                  <td><?=ucfirst($stockAvailabilityList->productName)?></td>
                  <td class="alignRight"><?=$stockAvailabilityList->quantity?></td> 
                </tr>

                 <?php $stockQty = $stockQty + $stockAvailabilityList->quantity; }  ?>
               </tbody>
                <tfoot>
                <tr>
                  <th> &nbsp;</th><th> &nbsp;</th>
                  <th class="alignRight"> TOTAL</th>
                  <th class="alignRight"> <?=number_format($stockQty,3,'.','')?></th>
                </tr>
                </tfoot>
              </table>
              <?php }  ?>
        </div>
        </div>

        <!-- /.box-body -->
        <div class="box-footer">
          
        </div>
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->


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

  function getProduct(){
    $('#searchProductName').autocomplete({ source: '<?=base_url("autoCompleteData/getProduct")?>', minLength:1,
      select:function(evt, ui){
                $('#searchProductId').val(ui.item.productId); 
      } 
    });
  }


</script>