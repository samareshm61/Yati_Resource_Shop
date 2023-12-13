<?php include('includes/header.php');?>


<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard</h1>
      <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Add Customers
                <a href="customers.php" class="btn btn-primary float-end">Back</a>
            </h4>
            <div class="card-body">
                <?php alertMessage()?>
                <form action="code.php" method="POST">
                    <div class="col-md-12 mb-3">
                        <label for="">Name *</label>
                        <input type="text" name="name" required class="form-control">
                    </div>
                   
                    <div class="col-md-6 mb-3">
                        <label for="">Phone Number *</label>
                        <input type="number" name="phone" required class="form-control">
                    </div>
                    

                    <div class="col-md-12 mb-3 text-end">
                        <button type="submit" name="saveCustomer" class="btn btn-success">Save</button>
                    </div>

                </form>
            </div>
        </div>
      </div>


    </div>
   

<?php include('includes/footer.php');?>