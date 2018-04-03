
<?php if($this->uri->segment(4)!='excel'){ ?>
<html>
  <head>
    <title>
      
    </title>
    <style type="text/css">
      <?=file_get_contents(base_url('assets/css/style.css'))?>
    </style>
  </head>
  <body>
    
    <div>
  <?php }else{
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment;Filename=reports-".date('d-m-Y').".xls"); 
  } ?>
      <table style="width: 100%; font-size: 10px;" class="repor-table-border" cellpadding="5" >
        <thead>
          <tr class="fontBold alignCenter"> <td colspan="6"> Company Details</td> </tr>
           <tr class="fontBold alignCenter"> 
              <td colspan="6" class="report-border-top report-border-bottom"> INVOICE</td>
             </tr>
          <tr>
            <td colspan="3" rowspan="2" valign="top" class="report-border-bottom report-border-top report-border-right"> Address <br>
                <?=$invoiceData->customerName?> <br>
                <?=$invoiceData->customerAddress?>
            </td>
            <td class="report-border-bottom report-border-right"> INVOICE NO</td>
            <td class="report-border-bottom report-border-right" colspan="2"><?=$invoiceData->invoiceNo?></td>
          </tr>
          <tr>
            <td class="report-border-bottom report-border-right"> DATE</td>
            <td class="report-border-bottom report-border-right" colspan="2"><?=date('d/m/Y', strtotime($invoiceData->invoiceDate))?></td>
          </tr>
        </thead>
        <tbody>
          <tr style="background-color: #959fa4" class="fontBold">
            <th style="width: 10%;" class="report-border-bottom"> SNO</th>
            <th style="width: 35%;" class="report-border-bottom" colspan="2"> PRODUCT NAME</th>
            <th style="width: 20%;" class="report-border-bottom"> QUANTITY </th>
            <th style="width: 15%;" class="report-border-bottom"> RATE</th>
            <th style="width: 20%;" class="report-border-bottom"> AMOUNT</th>
          </tr>

  <?php $sno =1;
          foreach($invoiceDetailData as $getDetails){
           ?>
          <tr >
            <td class="alignCenter "><?=$sno++?></td>
            <td colspan="2"><?=$getDetails->productName?></td>
            <td class="alignRight "><?=$getDetails->invoiceDetailsQty?></td>
            <td class="alignRight "><?=$getDetails->invoiceDetailsRate?></td>
            <td class="alignRight "><?=$getDetails->invoiceDetailsAmount?></td>
          </tr>
  <?php } ?>
        </tbody>
         <tr>
           <td colspan="3" rowspan="2" class="report-border-top report-border-right" style="margin-left: 20px;"> 
            <u>Rupees in words : </u>
            <i><?php echo ucwords($this->UtilityMethods->numberToWords($invoiceData->invoiceNetTotal)); ?>&nbsp;only</i></td>
           <td colspan="2" class="alignRight report-border-top"> GROSS TOTAL </td>
           <td class="alignRight fontBold report-border-top"> <?=$invoiceData->invoiceGrossTotal?></td>
         </tr>
<?php if($invoiceData->invoiceDiscountPer>0){ ?>
          <tr>
             
             <td colspan="2" class="alignRight"> DISCOUNT &nbsp;&nbsp;  <?=$invoiceData->invoiceDiscountPer?> % </td>
             <td class="alignRight"> <?=$invoiceData->invoiceDiscountAmount?></td>
           </tr>
<?php } ?>

<?php if($invoiceData->invoiceCgstPer>0){ ?>
          <tr>
             <td colspan="3" rowspan="3" class="report-border-top report-border-right" style="margin-left: 20px;"> <u>Remarks : </u>
                <?=$invoiceData->invoiceRemarks?>
             </td>
             <td colspan="2" class="alignRight"> CGST &nbsp;&nbsp;  <?=$invoiceData->invoiceCgstPer?> % </td>
             <td class="alignRight"> <?=$invoiceData->invoiceCgstAmount?></td>
           </tr>
<?php } ?>

<?php if($invoiceData->invoiceSgstPer>0){ ?>
          <tr>
             
             <td colspan="2" class="alignRight"> SGST &nbsp;&nbsp;  <?=$invoiceData->invoiceSgstPer?> % </td>
             <td class="alignRight"> <?=$invoiceData->invoiceSgstAmount?></td>
           </tr>
<?php } ?>

<?php if($invoiceData->invoiceIgstPer>0){ ?>
          <tr>
            
             <td colspan="2" class="alignRight"> IGST &nbsp;&nbsp;  <?=$invoiceData->invoiceIgstPer?> % </td>
             <td class="alignRight"> <?=$invoiceData->invoiceIgstAmount?></td>
           </tr>
<?php } ?>
        
        <tr style="font-size: 16px;">
             <td colspan="2" class="alignRight fontBold" > NET TOTAL &nbsp;&nbsp;  </td>
             <td class="alignRight fontBold"> <?=$invoiceData->invoiceNetTotal?></td>
           </tr>


      </table>
<?php if($this->uri->segment(4)!='excel'){ ?>
    </div>
    
  </body>
</html>
<?php } ?>