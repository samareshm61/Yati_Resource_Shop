<?php
require '../config/functions.php';
$paraResultId=checkParamId('id');
if(is_numeric($paraResultId)){
$adminId=validate($paraResultId);
$admin=getById('admins',$adminId);

if($admin['status']==200){
    $adminDeleteRes=delete('admins',$adminId);
    if($adminDeleteRes){
        redirect('admin.php','Admin Deleted Successfully');
    }else{
        redirect('admin.php','Something Went wrong');
    }

}else{
    redirect('admin.php',$admin['message']);
}

}else{
    redirect('admin.php','Something Went wrong');
}

?>