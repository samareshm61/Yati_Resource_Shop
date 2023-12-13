<?php include('includes/header.php');?>


<div class="container-fluid px-4">
   
      <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Create Categories
                <a href="categories-create.php" class="btn btn-primary float-end">Add Category</a>
            </h4>
            <div class="card-body">
            <?php alertMessage()?>
                <div class="table-responsive">
                    <table class="table table-hover">

                    <thead>
                        <tr>
                           <th>ID</th>
                           <th>Name</th>
                           
                           <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $categories=getAll('categories');
                        if(mysqli_num_rows($categories)>0)
                        {

                        
                        ?>
                        <?php foreach($categories as $categoriesItem) : ?>
                        <tr>
                            <td><?=$categoriesItem['id']  ?></td>
                            <td><?=$categoriesItem['name']  ?></td>
                            
                            <td>
                                <a href="categories-edit.php?id=<?=$categoriesItem['id']?>" class="btn btn-success btn-sm">Edit</a>
                                <a href="categories-delete.php?id=<?=$categoriesItem['id']?>" class="btn btn-danger btn-sm">Delete</a>
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