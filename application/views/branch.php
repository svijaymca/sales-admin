<?php  
  include "common/header.php"; 
  include "common/sidebar.php"; 
$page = $this->uri->segment(2);
$id   = $this->uri->segment(3); 
$branchCode     = isset($editData->branchCode) ? $editData->branchCode:'';
$branchName     = isset($editData->branchName) ? $editData->branchName:'';
$branchLineNo   = isset($editData->branchLineNo) ? $editData->branchLineNo:'';
$branchAddress  = isset($editData->branchAddress) ? $editData->branchAddress:'';
$branchEmail    = isset($editData->branchEmail) ? $editData->branchEmail:'';
$branchGstNo    = isset($editData->branchGstNo) ? $editData->branchGstNo:'';
$branchId       = isset($editData->branchId) ? $editData->branchId:'';
$branchUniqId   = isset($editData->branchUniqId) ? $editData->branchUniqId:'';

$branchFields = array( 
            "brForm" => array ("method" => 'post', "name" => 'branchForm', "id" =>'branchForm' ),
            "brCode" => array ("name" => 'branchCode', "id" =>'branchCode', "class" =>'form-control upperCase', "required"=>'required',  "value"=> $branchCode ),
            "brName" => array ("name" => 'branchName', "id" =>'branchName', "class" =>'form-control upperCase', "required"=>'required', "value"=>$branchName ),
            "brLin" => array ("name" => 'branchLineNo', "id" =>'branchLineNo', "class" =>'form-control',  "value"=>$branchLineNo ),
            "brEmail" => array ("name" => 'branchEmail', "id" =>'branchEmail', "class" =>'form-control',  "value"=>$branchEmail ),
            "brGst" => array ("name" => 'branchGstNo', "id" =>'branchGstNo', "class" =>'form-control upperCase',  "value"=>$branchGstNo ),
            "brAddress" => array ("name" => 'branchAddress', "id" =>'branchAddress', "class" =>'form-control',  "value"=>$branchAddress, "rows"=>2 ),
            "brId" => array ("name" => 'branchId', "id" =>'branchId', "class" =>'form-control', "value"=>$branchId, "type"=>'hidden'),
            "brUniqId" => array ("name" => 'branchUniqId', "id" =>'branchUniqId', "class" =>'form-control', "value"=>$branchUniqId,"type"=>'hidden' ),
            "brSubmit" => array ("name" => 'addBranch', "id" =>'addBranch', "class" =>'btn btn-success btn-sm', "value"=>'SAVE',"type"=>'submit' ),
            "brReset" => array ("name" => 'resetBranch', "id" =>'resetBranch', "class" =>'btn btn-warning btn-sm', "value"=>'RESET',"type"=>'reset' ),
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
        <li><a href="<?=base_url('branch')?>"><i class="fa fa-cart-plus"></i> Branch</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
<?php if( isset($page) && ($page == 'branchAdd') || ($page == 'branchEdit' && isset($id)) ) {   ?>
      <!-- Default box -->

      <?php $func =''; if($page == 'branchAdd'){ $func ='branch/branchInsert'; }else{ $func ='branch/branchUpdate'; } ?>
<?php echo form_open_multipart($func, $branchFields['brForm']);?>
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"> <b>BRANCH</b></h3>

          <div class="box-tools pull-right">
            <?php if(($page != 'branchAdd')){ ?><a class="btn btn-primary btn-sm" href="<?=base_url('branch/branchAdd')?>" data-widget="Add Branch" data-toggle="tooltip" title="Add Branch"> ADD </a> <?php } ?>
            <?=form_button( $branchFields['collapse'])?>
            <!--<button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>-->
          </div>
        </div>
        <div class="box-body">
            <div class="col-sm-12">
                <div class="col-sm-6">
                      <label class="control-label">Branch Code </label>
                      <?=form_input( $branchFields['brCode'])?>
                </div>
                <div class="col-sm-6">
                      <label class="control-label">Branch Name</label>
                      <?=form_input( $branchFields['brName'])?>
                </div>        
                <div class="col-sm-6">
                      <label class="control-label">Line No</label>
                      <?=form_input( $branchFields['brLin'])?>
                </div>
                <div class="col-sm-6">
                      <label class="control-label">Email</label>
                      <?=form_input( $branchFields['brEmail'])?>
                </div>
                <div class="col-sm-6">
                      <label class="control-label">GST NO</label>
                      <?=form_input( $branchFields['brGst'])?> 
                </div>
                <div class="col-sm-6">
                      <label class="control-label">Address</label>
                      <?=form_textarea( $branchFields['brAddress'])?> 
                </div>
            </div>
        
        
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <?=form_input( $branchFields['brId'])?>
            <?=form_input( $branchFields['brUniqId'])?>

            <?=form_input( $branchFields['brSubmit'])?>
            <?=form_input( $branchFields['brReset'])?>
            <?=anchor(base_url('branch'), 'Back', 'class="btn btn-info btn-sm"')?>
        </div>
        <!-- /.box-footer-->
      </div>
      <?php echo form_close(); ?>
<?php }else{ ?>

      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Branch List</h3>

          <div class="box-tools pull-right">
            <?=anchor(base_url('branch/branchAdd'),'ADD', 'class="btn btn-primary btn-sm"', 'data-widget="Add Branch"', 'data-toggle="tooltip"', 'title="Add Branch"')?>
           <?=form_button( $branchFields['collapse'])?>
            
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
                  <th>LINE NO</th>
                  <th>E-MAIL</th>
                  <th class="cnt" width="10%">ACTION</th>
                </tr>
                </thead>
                <tbody>
              <?php $sno=1; if(isset($list)){  foreach ($list as $branchList) { ?>
                 
                <tr>
                  <td><?=$sno++?></td>
                  <td><?=strtoupper($branchList->branchCode)?></td>
                  <td><?=strtoupper($branchList->branchName)?></td>
                  <td><?=$branchList->branchLineNo?></td>
                  <td><?=$branchList->branchEmail?></td>
                  <td class="cnt">
                    <a href="<?=base_url('branch/branchEdit/'.$branchList->branchUniqId)?>"><i class="fa fa-edit" style="font-size:16px"></i> </a>  
                   &nbsp;&nbsp; <a style="font-size:16px; color: red" href="<?=base_url('branch/branchDelete/'.$branchList->branchUniqId)?>"><i class="fa fa-trash-o"></i></td> 
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