<?php
include('../config/functions.php');

if(isset($_POST['saveAdmin']))
{
    $name=validate($_POST['name']);
    $email=validate($_POST['email']);
    $password=validate($_POST['password']);
    $phone=validate($_POST['phone']);
    $is_ban=isset($_POST['is_ban']) == true ? 1:0;


    
    if($name != '' && $email != '' && $password != ''){
      $emailCheck=mysqli_query($conn,"SELECT * FROM admins WHERE email='$email'");
      if($emailCheck){
        if(mysqli_num_rows($emailCheck)>0){
            redirect('admins-create.php','Email Already Exist');
        }
      }
      $bcrypt_password=password_hash($password,PASSWORD_BCRYPT);
     $data=[
        'name' =>$name,
         'email' =>$email,
         'password'=>$bcrypt_password,	
          'phone'=>$phone, 
          'is_ban'=>$is_ban,	

     ];
     $result=insert('admins',$data);
     if($result){
        redirect('admin.php','Admin Created Successfully!');
     }else{
        redirect('admins-create.php','Something Went Wrong');
     }
    }else{
        redirect('admins-create.php','Please fill require field');
    }
}

//Update and Delete
if(isset($_POST['updateAdmin'])){
    $adminId=validate($_POST['adminId']);
    $adminData=getById('admins',$adminId);
    if($adminData['status']!=200){
        redirect('admins-edit.php?id='.$adminId,'Please fill require field');
    }

    $name=validate($_POST['name']);
    $email=validate($_POST['email']);
    $password=validate($_POST['password']);
    $phone=validate($_POST['phone']);
    $is_ban=isset($_POST['is_ban']) == true ? 1:0;

    $EmailCheckQuery="SELECT * FROM admins WHERE email='$email' AND id='$adminId'";
    $checkResult=mysqli_query($conn,$EmailCheckQuery);
    if($checkResult){
        if(mysqli_num_rows($checkResult)>0){
            redirect('admins-edit.php?id='.$adminId,'Email already used by another user');
            
        }
    }
    
    if($password != ''){
        $hashedPassword=password_hash($password,PASSWORD_BCRYPT);
    }else{
        $hashedPassword=$adminData['data']['password'];
    }
    if($name != '' && $email != ''){
        $data=[
            'name' =>$name,
             'email' =>$email,
             'password'=>$hashedPassword,	
              'phone'=>$phone, 
              'is_ban'=>$is_ban,	
    
         ];
         $result=update('admins',$adminId,$data);

         if($result){
            redirect('admins-edit.php?id='.$adminId,'Admin Updated Successfully!');

         }else{
            redirect('admins-edit.php?id'.$adminId,'Something Went Wrong!');
         }

    }else{
        redirect('admins-create.php','Please fill require field');
    }
}

//Store Categories
if(isset($_POST['saveCategory'])){
    $name=validate($_POST['name']);
    $description=validate($_POST['description']);

             $data=[
            'name' =>$name,
             'description' =>$description,
             
         ];
         $result=insert('categories',$data);
     if($result){
        redirect('categories.php','Category Added Sucessfully!');
     }else{
        redirect('categories-create.php','Something Went Wrong');
     }
    
}
//Update Category
if(isset($_POST['updateCategory']))
{
    $categoryId=validate($_POST['categoryId']);
    $name=validate($_POST['name']);
    $description=validate($_POST['description']);

             $data=[
            'name' =>$name,
             'description' =>$description,
             
         ];
         $result=update('categories',$categoryId,$data);
     if($result){
        redirect('categories-edit.php?id='.$categoryId,'Category Updated Sucessfully!');
     }else{
        redirect('categories-edit.php?id='.$categoryId,'Something Went Wrong');
     }

}

//Inserting the Products

if (isset($_POST['saveProduct'])) {
    $category_id = validate($_POST['category_id']);
    $name = validate($_POST['name']);
    $price = validate($_POST['price']);
    $qty = validate($_POST['qty']);
    $description = validate($_POST['description']);

    $finalImage = '';  // Initialize to an empty string

    if ($_FILES['image']['size'] > 0) {
        $path = '../assets/uploads/products';
        $image_ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

        $filename = time() . '.' . $image_ext;
        if(move_uploaded_file($_FILES['image']['tmp_name'], $path . "/" . $filename)){
            echo 'File Uploaded Successfully';
        }else{
            echo 'Error in file uploading';
        }
    
        $finalImage = "assets/uploads/products/" . $filename;
        echo $finalImage;

    }

    $data = [
        'category_id' => $category_id,
        'name' => $name,
        'description' => $description,
        'price' => $price,
        'qty' => $qty,
        'image' => $finalImage,
    ];

    // Assuming insert function performs database insertion
    $result = insert('products', $data);

    if ($result) {
        redirect('products.php', 'Product Added Successfully!');
    } else {
        redirect('products-create.php', 'Something Went Wrong');
    }
}

//Edit products
if(isset($_POST['updateProduct']))
{
    $product_id = validate($_POST['product_id']);
    $productData=getById('products',$product_id);
    if(!$productData){
        redirect('products.php','No Such Product Found');
    }
    $category_id = validate($_POST['category_id']);
    $name = validate($_POST['name']);
    $price = validate($_POST['price']);
    $qty = validate($_POST['qty']);
    $description = validate($_POST['description']);

    $finalImage = '';  // Initialize to an empty string

    if ($_FILES['image']['size'] > 0) {
        $path = '../assets/uploads/products';
        $image_ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

        $filename = time() . '.' . $image_ext;
        if(move_uploaded_file($_FILES['image']['tmp_name'], $path . "/" . $filename)){
            echo 'File Uploaded Successfully';
        }else{
            echo 'Error in file uploading';
        }
    
        $finalImage = "assets/uploads/products/" . $filename;
        $deleteImage="../".$productData['data']['image'];
        if(file_exists($deleteImage)){
            unlink($deleteImage);
        }else{
            $finalImage = "assets/uploads/products/" . $filename;
        }

    }

    $data = [
        'category_id' => $category_id,
        'name' => $name,
        'description' => $description,
        'price' => $price,
        'qty' => $qty,
        'image' => $finalImage,
    ];

    
    $result = update('products', $product_id, $data);

    if ($result) {
        redirect('products.php?=id'.$product_id, 'Product Added Successfully!');
    } else {
        redirect('products-edit.php?=id'.$product_id, 'Something Went Wrong');
    }
}

// Create Customer
if(isset($_POST['saveCustomer'])){
    $name=validate($_POST['name']);
    $phone=validate($_POST['phone']);
   


    
    if($name != '' && $phone != ''){
      $phoneCheck=mysqli_query($conn,"SELECT * FROM customers WHERE phone='$phone'");
      if($phoneCheck){
        if(mysqli_num_rows($phoneCheck)>0){
            redirect('customers-create.php','Phone Number Already Exist');
        }
      }
     
     $data=[
        'name' =>$name,
        'phone'=>$phone, 
          	

     ];
     $result=insert('customers',$data);
     if($result){
        redirect('customers.php','Customer Created Successfully!');
     }else{
        redirect('customers-create.php','Something Went Wrong');
     }
    }else{
        redirect('customers-create.php','Please fill require field');
    }
}
//Update Customer
if(isset($_POST['updateCustomer']))
{
    $customerId=validate($_POST['customerId']);
    $customerData=getById('customers',$customerId);
    if($customerData['status']!=200){
        redirect('customers-edit.php?id='.$customerId,'Please fill require field');
    }

    $name=validate($_POST['name']);
    
    $phone=validate($_POST['phone']);
    

    $phoneCheckQuery="SELECT * FROM customers WHERE phone='$phone' AND id='$customerId'";
    $checkResult=mysqli_query($conn,$phoneCheckQuery);
    if($checkResult){
        if(mysqli_num_rows($checkResult)>0){
            redirect('customers-edit.php?id='.$customerId,'Phone number already used by another user');
            
        }
    }
    
   
    
        $data=[
            'name' =>$name,
             'phone'=>$phone, 
             	
    
         ];
         $result=update('customers',$customerId,$data);

         if($result)
         {
            redirect('customers.php?id='.$adminId,'Customer Updated Successfully!');

         }else
         {
            redirect('customers-edit.php?id'.$adminId,'Something Went Wrong!');
         }

    }
    
   

?>