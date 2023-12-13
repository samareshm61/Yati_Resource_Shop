<?php include('includes/header.php');?>
<!-- Modal Box -->
<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="addCustomerModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
            <label >Enter Customer Name</label>
            <input type="text" class="form-control" id="c_name" />
        </div>
        <div class="mb-3">
            <label >Enter Phone Number</label>
            <input type="number" class="form-control" id="c_phone" />
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary saveCustomer">Save</button>
      </div>
    </div>
  </div>
</div>
<div class="container-fluid px-4">
    <h1 class="mt-4">Order</h1>
      <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Create Order
                <a href="#" class="btn btn-primary float-end">Back</a>
            </h4>
            <div class="card-body">
                <?php alertMessage()?>

                <form action="order-code.php" method="POST">
                    <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="">Select Product *</label>
                        <select name="product_id" class="form-select mySelect">
                            <option value="">-- Select Product --</option>
                             <?php
                             $products=getAll('products');
                             if($products)
                             {
                                if(mysqli_num_rows($products)>0)
                                {
                                foreach($products as $items)
                                {
                                    ?>
                                    <option value="<?= $items['id']; ?>"><?= $items['name'] ;?></option>
                                    <?php
                                }
                                 
                               }else{
                                echo '<option value="">No such Products Found</option>';
                               }

                        
                            }else{
                                
                                    echo '<option value="">Something Went Wrong</option>';
                                 
                            }
                             
                             ?>

                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="">Quantity *</label>
                        <input type="nummber" name="qty" value="1" class="form-control"/>
                    </div>
                    
                   

                    <div class="col-md-3 mb-3 text-end">
                         </br>
                        <button type="submit" name="addItem" class="btn btn-success">Add Item</button>
                    </div>
                    </div>

                </form>
            </div>
        </div>
      </div>
      
     <div class="card mt-3">
        <div class="card-header">
            <h4 class="mb-0">Products</h4>
        </div>
        <div class="card-body">
            <?php
            if(isset($_SESSION['productItem'])){
                $sessionProducts=$_SESSION['productItem'];
                if(empty($sessionProducts)){
                     unset($_SESSION['productIds']);
                     unset($_SESSION['productItem']);

                }
                ?>
                <div class="table-responsive mb-3">

                <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Product Name</th>
                        <th>Product Price</th>
                        <th>Product Quantity</th>
                        <th>Total Price</th>
                        <th>Remove</th>
                       
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i=1; 
                    foreach($sessionProducts as $key=> $item) : ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td><?= $item['product_name']; ?></td>
                        <td><?= $item['product_price']; ?></td>
                        <td>
                            <div class="input-group qtyBox">
                                <input type="hidden" value="<?= $item['product_id']; ?>" class="prodId">
                                <button class="input-group-text decrement">-</button>
                                <input type="text" value="<?= $item['product_qty'];  ?>" class="qty quantityInput">
                                <button class="input-group-text increment">+</button>
                            </div>
                        </td>
                        <td><?= number_format($item['product_price']* $item['product_qty'],0) ?></td>
                        <td>
                            <a href="order-item-delete.php?index=<?= $key; ?>" class="btn btn-danger">Remove</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>

                </tbody>

                </table>
                <div class="mt-2">
                    <hr>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="">Select Payment Mode</label>
                            <select id="payment_mode" class="form-select">
                                <option value="">--Select Payment Mode--</option>
                                <option value="cash payment">Cash Payment</option>
                                <option value="online payment">Online Payment</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                        <label for="">Enter Customer Phone *</label>
                        <input type="number" id="cphone" class="form-control" value="" required />
                        </div>
                        <div class="col-md-4">
                            <br/>
                        <button type="button" class="btn btn-warning w-100 proceedToPlace">Proceed For Payment</button>

                       
                        </div>
                    </div>
                </div>
                </div>
                <?php
            }else{
                echo '<h5>No Item Added</h5>';
            }
            ?>
        </div>
     </div>

    </div>
   

<?php include('includes/footer.php');?>