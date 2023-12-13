<?php include('includes/header.php');?>


<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard</h1>
      <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Add Products Here
                <a href="categories.php" class="btn btn-danger float-end">Back</a>
            </h4>
            <div class="card-body">
                <?php alertMessage()?>

                <form action="code.php" method="POST" enctype="multipart/form-data">

                <div class="col-md-12 mb-3">
                    <label>Select Category </label>
                    <select name="category_id" class="form-select">
                    <option value="category_id">Select Category</option>
                    <?php 
                    $categories=getAll('categories');
                    if($categories){
                            if(mysqli_num_rows($categories)>0){
                                foreach($categories as $catItem){
                                    echo '<option value="'.$catItem['id'].'">'.$catItem['name'].'</option>';
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
                        <input type="text" name="name" required class="form-control">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="">Product Price *</label>
                        <input type="number" name="price" required class="form-control">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="">Product Quantity *</label>
                        <input type="number" name="qty" required class="form-control">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="">Description *</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="">Product Image *</label>
                        <input type="file" name="image"  class="form-control">
                    </div>
                    
                   

                    <div class="col-md-6 mb-3 text-end">
                        <button type="submit" name="saveProduct" class="btn btn-success">Save</button>
                    </div>

                </form>
            </div>
        </div>
      </div>


    </div>
   

<?php include('includes/footer.php');?>