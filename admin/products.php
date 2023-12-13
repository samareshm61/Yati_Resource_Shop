<?php include('includes/header.php');?>


<div class="container-fluid px-4">
   
      <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Products
                <a href="products-create.php" class="btn btn-primary float-end">Add Product</a>
            </h4>
            <div class="card-body">
            <?php alertMessage()?>
                <div class="table-responsive">
                    <table class="table table-hover">

                    <thead>
                        <tr>
                           <th>ID</th>
                           <th>Name</th>
                           <th>Image</th>
                           <th>Price</th>
                           <th>Description</th>
                           <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $products=getAll('products');
                        if(mysqli_num_rows($products)>0)
                        {

                        
                        ?>
                        <?php foreach($products as $productsItem) : ?>
                        <tr>
                            <td><?=$productsItem['id'];  ?></td>
                            <td><?=$productsItem['name'] ; ?></td>
                            <td>
                                <img src="../<?= $productsItem['image']; ?>" style="width:50px; height: 50px;" alt="<?=$productsItem['name']  ?>">
                            </td>
                            <td><?=
                            $productsItem['price']; ?></td>
                            <td><?=$productsItem['description']; ?></td>
                            
                            <td>
                                <a href="products-edit.php?id=<?=$productsItem['id']?>" class="btn btn-success btn-sm">Edit</a>
                                <a href="products-delete.php?id=<?=$productsItem['id']?>" class="btn btn-danger btn-sm"
                                onclick="return confirm('Are you Sure Want To Delete?')"
                                >
                                Delete
                            </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php 
                        }
                        else{
                            ?>
                            <tr>
                            <td colspan="4">No Records Found</td>
                        </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
      </div>


    </div>
   

<?php include('includes/footer.php');?>