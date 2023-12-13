<?php include('includes/header.php');
if(!isset($_SESSION['productItem'])){
    echo '<script>window.location.href="order-create.php"</script>';
}


?>
<div class="modal fade" id="orderSuccessModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
     
     <div class="modal-body">
      <div class="mb-3">
        <h5 id="orderPlaceSuccessMessage"></h5>
      </div>

        <a href="orders.php" class="btn btn-secondary">Close</a>
        <button class="btn btn-danger" onclick="printMyBillingArea()">Print</button>
        
        <!-- <button class="btn btn-primary" onclick="downloadPdf(<?= $invoiceNo ?>)">Download Pdf</button> -->
        </div>  
    </div>

  </div>
</div>

<div class="container-fluid px-4">
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header">
                <h4 class="mb-0">Order Summary
                    <a href="order-create.php" class="btn btn-primary float-end">Back</a>
                </h4>
            </div>
            <div class="card-body">
                <?php alertMessage(); ?>
                <div id="myBillingArea">
                    <?php
                    if(isset($_SESSION['cphone'])){
                            $phone=validate($_SESSION['cphone']);
                            $invoiceNo=validate($_SESSION['invoice_no']);

                            $customerQuery=mysqli_query($conn,"SELECT * FROM customers WHERE phone='$phone' LIMIT 1");
                                if($customerQuery){
                                    if(mysqli_num_rows($customerQuery)>0){
                                        $cRowData=mysqli_fetch_assoc($customerQuery);
                                        ?>
                                       <h2>Invoice</h2>

                 <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
  <thead>
    <tr>
      <th colspan="2" style="background-color: #f2f2f2; padding: 10px; text-align: left;">Invoice Details</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td style="padding: 10px; text-align: left;">Invoice Number:</td>
      <td style="padding: 10px; text-align: left;"><?= $invoiceNo ?></td>
    </tr>
    <tr>
      <td style="padding: 10px; text-align: left;">Invoice Date:</td>
      <td style="padding: 10px; text-align: left;"><?= date('d M Y'); ?></td>
    </tr>
    <!-- Add more details as needed -->
  </tbody>
</table>

<table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
  <thead>
    <tr>
      <th colspan="2" style="background-color: #f2f2f2; padding: 10px; text-align: left;">Customer Details</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td style="padding: 10px; text-align: left;">Name:</td>
      <td style="padding: 10px; text-align: left;"><?= $cRowData['name']; ?></td>
    </tr>
    <tr>
      <td style="padding: 10px; text-align: left;">Phone:</td>
      <td style="padding: 10px; text-align: left;"><?= $cRowData['phone']; ?></td>
    </tr>
    <!-- Add more details as needed -->
  </tbody>
</table>

<table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
  <thead>
    <tr>
      <th colspan="2" style="background-color: #f2f2f2; padding: 10px; text-align: left;">Company Details</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td style="padding: 10px; text-align: left;">Company Name:</td>
      <td style="padding: 10px; text-align: left;">InfoTech</td>
    </tr>
    <tr>
      <td style="padding: 10px; text-align: left;">Address:</td>
      <td style="padding: 10px; text-align: left;">123 Main Street, Cityville</td>
    </tr>
    <!-- Add more details as needed -->
  </tbody>
</table>
                                        
                                        <?php
                                    }else{
                                        echo '<h5>Customer Not Found!</h5>';
                                    }
                                }
                        }
                    ?>

                    <?php 
                    if(isset($_SESSION['productItem'])){
                        $sessionProducts=$_SESSION['productItem'];
                        ?>

                        <div class="table-responsive mb-3">
                            <table style="width:100%" cellPadding="5">
                             <thead>
                                <tr>
                                    <th align="start" style="border-bottom: 1px solid #ccc;" width="5%">ID</th>
                                    <th align="start" style="border-bottom: 1px solid #ccc;">Product Name</th>
                                    <th align="start" style="border-bottom: 1px solid #ccc;" width="10%%">Price</th>
                                    <th align="start" style="border-bottom: 1px solid #ccc;" width="10%">Quantity</th>
                                    <th align="start" style="border-bottom: 1px solid #ccc;" width="15%">Total Price</th>
                                </tr>
                             </thead>
                             <tbody>
                                <?php 
                                $i=1;
                                $totalAmount=0;
                                foreach($sessionProducts as $key => $row):
                                    $totalAmount+=$row['product_price']* $row['product_qty'];
                                   ?>

                                   <tr>
                                   <td align="start" style="border-bottom: 1px solid #ccc;" width="5%"><?= $i++;?></td>
                                   <td align="start" style="border-bottom: 1px solid #ccc;" width="5%"><?=$row['product_name']; ?></td>
                                   <td align="start" style="border-bottom: 1px solid #ccc;" width="5%"><?= number_format($row['product_price'],0);?></td>
                                   <td align="start" style="border-bottom: 1px solid #ccc;" width="5%"><?= $row['product_qty']; ?></td>
                                   <td align="start" style="border-bottom: 1px solid #ccc;" class="fw-bold">
                                   <?=
                                   number_format($row['product_price']*$row['product_qty'],0);
                                   ?>
                                   </td>
                                   </tr>
                                   <?php endforeach; ?>
                                   <tr>
                                    <td colspan="4" align="end" style="font-weight:bold;">Grand Total:</td>
                                    <td colspan="1" align="end" style="font-weight:bold;"><?= number_format($totalAmount,0); ?></td>
                                   </tr>
                                   <tr>
                                    <td colspan="5">Payment Mode:<?= $_SESSION['payment_mode']; ?></td>
                                   </tr>
                             </tbody>
                        
                        </table>
                        </div>
                        <?php

                    }
                    
                    ?>
                </div>
                <?php if(isset($_SESSION['productItem'])) : ?>
                <div class="mt-4 text-end">
               
                    <button type="button"  class="btn btn-success px-4 mx-1" id="saveOrder">Save</button>
                </div>
                <?php endif; ?>
               

            </div>

        </div>
        
    </div>
</div>
</div>

<?php include('includes/footer.php');?>