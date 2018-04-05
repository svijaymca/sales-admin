
 <html>
  <head>
    <title>
      
    </title>
  </head>
<body>
 <?php 
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment;Filename=stock-avalability-".date('d-m-Y').".xls"); 
?>
  <table id="stock"  align="center" class="table table-bordered table-striped">
      <thead>
          <tr><th colspan="4"> STOCK AVAILABILITY </th></tr>
          <tr>
            <th>SNO</th>
            <th>PRODUCT CODE</th>
            <th>PRODUCT NAME</th>
            <th>AVAILABILE QUANTITY</th>
          </tr>
      </thead>
      <tbody>
  <?php $sno=1; $stockQty = 0;  foreach ($stockList as $stockAvailabilityList) { ?>
          <tr>
            <td><?=$sno++?></td>
            <td ><?=strtoupper($stockAvailabilityList->productCode)?></td>
            <td><?=ucfirst($stockAvailabilityList->productName)?></td>
            <td><?=$stockAvailabilityList->quantity?></td> 
          </tr>

  <?php $stockQty = $stockQty + $stockAvailabilityList->quantity; }  ?>
      </tbody>
      <tfoot>
            <tr>
              <th> &nbsp;</th>
              <th> &nbsp;</th>
              <th> TOTAL</th>
              <th> <?=number_format($stockQty,3,'.','')?></th>
            </tr>
      </tfoot>
  </table>
</body>
</html>