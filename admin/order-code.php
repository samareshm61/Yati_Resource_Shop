<?php
error_reporting(E_ERROR | E_PARSE);
include("../config/functions.php");
if (!isset($_SESSION['productItem'])) {
    $_SESSION['productItem'] = [];
}
if (!isset($_SESSION['productIds'])) {
    $_SESSION['productIds'] = [];
}

if (isset($_POST['addItem'])) {
    $productId = validate($_POST['product_id']);
    $productQty = validate($_POST['qty']);

    $productCheck = mysqli_query($conn, "SELECT * FROM products WHERE id='$productId' LIMIT 1 ");

    if ($productCheck) {
        if (mysqli_num_rows($productCheck) > 0) {
            $row = mysqli_fetch_assoc($productCheck);
            if ($row['qty'] < $productQty) {
                redirect('order-create.php', 'only ' . $row['qty'] . ' Quantity Available!');
            }
            $productData = [
                'product_id' => $row['id'],
                'product_name' => $row['name'],
                'product_price' => $row['price'],
                'product_qty' => $productQty,
                'product_image' => $row['image'],
            ];

            if (!in_array($row['id'], $_SESSION['productIds'])) {
                array_push($_SESSION['productIds'], $row['id']);
                array_push($_SESSION['productItem'], $productData);
            } else {
                foreach ($_SESSION['productItem'] as $key => $prodSessionItem) {
                    if ($prodSessionItem['product_id'] == $row['id']) {
                        $newQuantity = $prodSessionItem['product_qty'] + $productQty;

                        $productData = [
                            'product_id' => $row['id'],
                            'product_name' => $row['name'],
                            'product_price' => $row['price'],
                            'product_qty' => $newQuantity,
                            'product_image' => $row['image'],
                        ];
                        $_SESSION['productItem'][$key] = $productData;
                    }
                }
            }
            redirect('order-create.php', 'Items Added Successfully!');
        } else {
            redirect('order-create.php', 'No such product found');
        }
    } else {
        redirect('order-create.php', 'Something Went Wrong');
    }
}

if(isset($_POST['productIncDec'])){
    $productId =validate($_POST['product_id']);
    $quantity =validate($_POST['quantity']);
    $flag=false;
    foreach($_SESSION['productItem'] as $key => $item){
        if($item['product_id']==$productId)
        {
            $flag=true;
            $_SESSION['productItem'][$key]['product_qty']=$quantity;
        }
    }
    if($flag){
        jsonResponse(200,'success','Quantity Updated');
    }else{
        jsonResponse(500,'error','Something Went Wrong');
    }
}

//Proceed to place
if(isset($_POST['proceedToPlace'])){
    $phone=validate($_POST['cphone']);
    $payment_mode=validate($_POST['payment_mode']);

    //Checking customer exists or not
    $checkCustomer=mysqli_query($conn,"SELECT * FROM customers WHERE phone=$phone LIMIT 1");
    if($checkCustomer)
    {
        if(mysqli_num_rows($checkCustomer)>0){
            $_SESSION['invoice_no']="INV_".rand(111111,999999);
            $_SESSION['cphone']= $phone;
            $_SESSION['payment_mode']=$payment_mode;
            jsonResponse("200","success","Customer  Found");
        }
        else{
            $_SESSION['cphone']=$phone;
            jsonResponse(404,"warning","Customer Not Found");
        }

    }else{
        jsonResponse(500,"error","Something Went Wrong!");
    }

}

// Adding customer via Modal Box

if(isset($_POST['saveCustomerBtn'])){
    $name=validate($_POST['name']);
    $phone=validate($_POST['phone']);

    if($name != '' && $phone != ''){
        $data=[
            'name' => $name,
            'phone' => $phone,
        ];
        $result=insert('customers',$data);
        if($result){
            jsonResponse(200,"success","Customer Created Successfully!");
        }else{
            jsonResponse(500,"error","Something Went Wrong!");
        }


    }else{
        jsonResponse(422,"warning","Something Went Wrong!");
    }
}
//Order Summary Storing in the database
if(isset($_POST['saveOrder'])){
  $phone=validate($_SESSION['cphone']);
  $invoice_no=validate($_SESSION['invoice_no']);
  $payment_mode=validate($_SESSION['payment_mode']);
  $order_placed_by_id=isset($_SESSION['loggedInUser']['user_id']);


  $checkCustomer=mysqli_query($conn,"SELECT * FROM customers WHERE phone='$phone' LIMIT 1");

  if(!$checkCustomer){
    jsonResponse(500,"error","Something Went Wrong!");
  }
  if(mysqli_num_rows($checkCustomer)>0){
    $customerData=mysqli_fetch_assoc($checkCustomer);
    if(!isset($_SESSION['productItem'])){
        jsonResponse(404,"warning","No item found!");
    }

    $sessionProducts=$_SESSION['productItem'];
    $totalAmount=0;
    foreach($sessionProducts as $amtItem){
        $totalAmount += $amtItem['product_price'] * $amtItem['product_qty'];
        }
        $data=[

            'customer_id' => $customerData['id'],
            'tracking_no' => rand(11111,99999),
            'invoice_no' =>  $invoice_no,
            'total_amount' => $totalAmount,
            'order_date' => date('Y-m-d'),
            'order_status' => "Booked",
            'payment_mode' => $payment_mode,
            'order_placed_by_id' => $order_placed_by_id 
        ];
        $result=insert('orders',$data);
        $lastOrderId=mysqli_insert_id($conn);

        foreach($sessionProducts as $prodItem){

           
            $productId=$prodItem['id'];
            $price=$prodItem['product_price'];
            $quantity=$prodItem['product_qty'];

            //Inserting Order Items
            $dataOrderItems=[
                'order_id' => $lastOrderId,
                'product_id' => $productId,
                'price' => $price,
                'quantity' => $quantity,
            ];
            $orderItemQuery=insert('order_items',$dataOrderItems);

            //Checking for the books quantity and decreasing and making total quantity
            $checkProductQuantityQuery=mysqli_query($conn,"SELECT * FROM products WHERE id='$productId'");
            $productQtyData=mysqli_fetch_assoc($checkProductQuantityQuery);
            $totalProductQuantity=$productQtyData['qty'] -$quantity;

            $dataUpdate=[
                'qty' =>$totalProductQuantity
            ];
            $productId = $prodItem['id']; // Make sure $prodItem is defined
            $updateProductQty = update('products', $productId, $dataUpdate);

            }

            unset($_SESSION['productIds']);
            unset($_SESSION['productItem']);
            unset($_SESSION['cphone']);
            unset($_SESSION['payment_mode']);
            unset($_SESSION['invoice_no']);

            jsonResponse(200,'success','Order Placed Successfully!');

  }else{
    jsonResponse(404,'warning','No Customer Found!');
  }

}
?>
