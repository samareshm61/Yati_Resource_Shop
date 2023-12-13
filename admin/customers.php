<?php include('includes/header.php');?>


<div class="container-fluid px-4">
   
      <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Add Customer
                <a href="customers-create.php" class="btn btn-primary float-end">Add Customers</a>
            </h4>
            <div class="card-body">
            <?php alertMessage()?>
                <div class="table-responsive">
                    <table class="table table-hover">

                    <thead>
                        <tr>
                           <th>ID</th>
                           <th>Name</th>
                           <th>Phone</th>
                           
                           <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $customers=getAll('customers');
                        if(mysqli_num_rows($customers)>0)
                        {

                        
                        ?>
                        <?php foreach($customers as $Item) : ?>
                        <tr>
                            <td><?=$Item['id']  ?></td>
                            <td><?=$Item['name']  ?></td>
                            <td><?=$Item['phone']  ?></td>

                            
                            <td>
                                <a href="customers-edit.php?id=<?=$Item['id']?>" class="btn btn-success btn-sm">Edit</a>
                                <a href="customers-delete.php?id=<?=$Item['id']?>" class="btn btn-danger btn-sm">Delete</a>
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