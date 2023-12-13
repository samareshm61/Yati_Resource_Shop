<?php include('includes/header.php');?>


<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard</h1>
      <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Orders
                <a href="orders.php" class="btn btn-danger btn-sm float-end">Back</a>
            </h4>
            <div class="card-body">
            <?php
            if(isset($_GET['track'])){
                $trakingNo=validate($_GET['track']);
                if($trakingNo == ''){
                    ?>
                
                <div class="text-center py-5">
                    <h5>No Tracking Number Found</h5>
                    <div>
                    <a href="orders.php" class="btn btn-primary mt-4 w-25">Go Back To Orders</a>
                    </div>
                </div>
                
                <?php
                }
                $orderQuery="SELECT o.*,c.* FROM orders o,customers c 
                WHERE c.id=o.customer_id AND tracking_no='$trakingNo'";
                $orderQueryRes=mysqli_query($conn,$orderQuery);
                if(!$orderQueryRes){
                    echo '<h5>Something Went Wrong</h5>';
                    return false;
                }
                if(mysqli_num_rows($orderQueryRes)>0){
                    $orderDataRow=mysqli_fetch_assoc($orderQueryRes);
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
<td style="padding: 10px; text-align: left;"><?= $orderDataRow['invoice_no']; ?></td>
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
<td style="padding: 10px; text-align: left;"><?= $orderDataRow['name']; ?></td>
</tr>
<tr>
<td style="padding: 10px; text-align: left;">Phone:</td>
<td style="padding: 10px; text-align: left;"><?= $orderDataRow['phone']; ?></td>
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
                    echo '<h5>No Data Found</h5>';
                    return false;
                }
                $orderItemQuery="SELECT oi.quantity as orderItemQuantity,oi.price as orderItemPrice,o.*,oi.*,p.* FROM orders o,order_items oi,products p
                WHERE oi.order_id=o.id AND p.id=oi.product_id AND o.tracking_no='$trakingNo'";

                $orderItemQueryRes=mysqli_query($conn,$orderItemQuery);
                //print_r($orderItemQueryRes);
                if($orderItemQueryRes){
                    if(mysqli_num_rows($orderItemQueryRes)>0){

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
                                foreach($orderItemQueryRes as $key => $row):
                                    
                                   ?>

                                   <tr>
                                   <td align="start" style="border-bottom: 1px solid #ccc;" width="5%"><?= $i++;?></td>
                                   <td align="start" style="border-bottom: 1px solid #ccc;" width="5%"><?=$row['product_name']; ?></td>
                                   <td align="start" style="border-bottom: 1px solid #ccc;" width="5%"><?= number_format($row['orderItemPrice'],0);?></td>
                                   <td align="start" style="border-bottom: 1px solid #ccc;" width="5%"><?= $row['orderItemQuantity']; ?></td>
                                   <td align="start" style="border-bottom: 1px solid #ccc;" class="fw-bold">
                                   <?=
                                   number_format($row['orderItemPrice']*$row['orderItemQuantity'],0);
                                   ?>
                                   </td>
                                   </tr>
                                   <?php endforeach; ?>
                                   <tr>
                                    <td colspan="4" align="end" style="font-weight:bold;">Grand Total:</td>
                                    <td colspan="1" align="end" style="font-weight:bold;"><?= number_format($row['total_amount'],0); ?></td>
                                   </tr>
                                   <tr>
                                    <td colspan="5">Payment Mode:<?= $row['payment_mode']; ?></td>
                                   </tr>
                             </tbody>
                        
                        </table>
                        </div>
                        <?php

                    }else{
                        echo '<h5>No Data Found</h5>';
                    return false;
                    }

                }else{
                    echo '<h5>Something Went Wrong</h5>';
                    return false;
                }



            }else{
                ?>
                
                <div class="text-center py-5">
                    <h5>No Tracking Number Found</h5>
                    <div>
                    <a href="orders.php" class="btn btn-primary mt-4 w-25">Go Back To Orders</a>
                    </div>
                </div>
                
                <?php
            }
            
            
            ?>


            </div>
        </div>
      </div>


    </div>
   

<?php include('includes/footer.php');?>