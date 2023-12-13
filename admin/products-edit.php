<?php include('includes/header.php');?>


<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard</h1>
      <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Edit Products Here
                <a href="products.php" class="btn btn-danger float-end">Back</a>
            </h4>
            <div class="card-body">
                <?php alertMessage()?>

                <form action="code.php" method="POST" enctype="multipart/form-data">

                <?php
                   $paramValue=checkParamId('id');
                   if(!is_numeric($paramValue)){
                    echo '<h5>'.$paramValue.'</h5>';
                    return false;
                   }

                   $product=getById('products',$paramValue);

                   if($product['status'] == 200){

                   

                   
                ?>
                <input type="hidden" name="product_id" value="<?= $product['data']['id']; ?>">
                <div class="col-md-12 mb-3">
                    <label>Select Category </label>
                    <select name="category_id" class="form-select">
                    <option value="category_id">Select Category</option>
                    <?php 
                    $categories=getAll('categories');
                    if($categories){
                            if(mysqli_num_rows($categories)>0){
                                foreach($categories as $catItem){
                                    ?>
                                    <option value="<?=$catItem['id'] ?>"
                                    <?= $product['data']['category_id']==$catItem['id'] ? 'selected' : ''; ?>
                                    
                                    >
                                     <?= $catItem['name'] ?>

                                    </option>
                                    <?php
                                }

                            }else{
                                echo '<option value="">No Category Found</option>';
                            }
                    }else{
                        echo '<option value="">Something Went Wrong!</option>';
                    }
                    ?>

                    </select>
                    

                </div>
                    <div class="col-md-12 mb-3">
                        <label for="">Product Name *</label>
                        <input type="text" name="name"  value="<?= $product['data']['name']; ?>" class="form-control">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="">Product Price *</label>
                        <input type="number" name="price"  value="<?= $product['data']['price']; ?>" class="form-control">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="">Product Quantity *</label>
                        <input type="number" name="qty"  value="<?= $product['data']['qty']; ?>" class="form-control">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="">Description *</label>
                        <textarea name="description"  value="<?= $product['data']['description']; ?>" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="">Product Image *</label>
                        <input type="file" name="image"  class="form-control">
                        <img src="../<?=$product['data']['image']; ?>" style="height: 40px;width: 40px;" alt="Img"/>
                    </div>
                    
                   

                    <div class="col-md-6 mb-3 text-end">
                        <button type="submit" name="updateProduct" class="btn btn-success">Update</button>
                    </div>
                    <?php
                   }else{
                    echo '<h5>'.$product['message'].'</h5>';
                   }
                    
                    
                    ?>

                </form>
            </div>
        </div>
      </div>


    </div>
   

<?php include('includes/footer.php');?>