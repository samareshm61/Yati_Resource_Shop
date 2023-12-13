<?php
require '../config/functions.php';
$paraResultId=checkParamId('id');
if(is_numeric($paraResultId)){
$productId=validate($paraResultId);
$product=getById('products',$productId);

if($product['status']==200){
    $productDelete=delete('products',$productId);
    if($productDelete){
        $deleteImage="../".$product['data']['image'];
        if(file_exists($deleteImage)){
            unlink($deleteImage);
        }
        redirect('products.php','Product Deleted Successfully');
    }else{
        redirect('products.php','Something Went wrong');
    }

}else{
    redirect('products.php',$product['message']);
}

}else{
    redirect('products.php','Something Went wrong');
}

?>