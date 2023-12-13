<?php
require '../config/functions.php';

$paraResultId=checkParamId('index');
if(is_numeric($paraResultId)){

    $indexValue=validate($paraResultId);
    if(isset($_SESSION['productItem']) && ($_SESSION['productIds'])){
        unset($_SESSION['productItem'][$indexValue]);
        unset($_SESSION['productIds'][$indexValue]);
        redirect('order-create.php','Item Removed Successfully!');
    }else{
        redirect('order-create.php','There is no item');
    }



}else{
    redirect('order-create.php','Param Is Not Numeric');
}


?>