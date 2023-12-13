<?php include('includes/header.php');?>


<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard</h1>
      <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Edit Customer
                <a href="customers.php" class="btn btn-danger float-end">Back</a>
            </h4>
            <div class="card-body">
                <?php alertMessage()?>
                <form action="code.php" method="POST">

                  <?php
                  if(isset($_GET['id']))
                  {
                    if($_GET['id'] != ''){
                       
                       $customerId=$_GET['id']; 
                    }else{
                        echo '<h5>Id Not Found</h5>';
                        return false;
                    }
                  }else{
                    echo '<h5>No Id Found</h5>';
                    return false;
                  }
                  $customerData=getById('customers',$customerId);
                  if($customerData){
                    if($customerData['status']==200){

                    ?>
                    <input type="hidden" name="customerId" value="<?=$customerData['data']['id'];?>">
                    <div class="col-md-12 mb-3">
                        <label for="">Name </label>
                        <input type="text" name="name" required value="<?=$customerData['data']['name'];?>" class="form-control">
                    </div>
                    
                    
                    <div class="col-md-6 mb-3">
                        <label for="">Phone Number </label>
                        <input type="number" name="phone" required value="<?=$customerData['data']['phone'];?>" class="form-control">
                    </div>
                   
                    <div class="col-md-12 mb-3 text-end">
                        <button type="submit" name="updateCustomer" class="btn btn-success">Update Customer</button>
                    </div>
                    <?php


                    }else{
                        echo '<h5>'.$customerData['message'].'</h5>';
                        return false;
                    }

                  }else{
                    echo 'Something Went Wrong';
                    return false;


                  }

                  
                  ?>

                    

                </form>
            </div>
        </div>
      </div>


    </div>
   

<?php include('includes/footer.php');?>