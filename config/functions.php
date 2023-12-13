<?php
session_start();
require 'dbcon.php';

//Input validation

function validate($inputData){
    global $conn;
    $validatedData=mysqli_real_escape_string($conn,$inputData);
    return trim($validatedData);
}

//Redirect from one page to another with the message(status)
function redirect($url,$status){
    $_SESSION['status']=$status;
    header('Location: '.$url);
    exit(0);
}
//Display messages or status after any process
function alertMessage(){
    if(isset($_SESSION['status'])){
         $_SESSION['status'];
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
        '.$_SESSION['status'].'
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
        unset($_SESSION['status']);
    }
}
//Insert record using this function
function insert($tableName, $data)
{
    global $conn;
    $table = validate($tableName);
    $columns = array_keys($data);
    $values = array_values($data);  // Use array_values to get the actual values

    // Escape values to prevent SQL injection
    $escapedValues = array_map(function ($value) use ($conn) {
        return mysqli_real_escape_string($conn, $value);
    }, $values);

    $finalColumn = implode(',', $columns);
    $finalValues = "'" . implode("','", $escapedValues) . "'";

    $query = "INSERT INTO $table ($finalColumn) VALUES ($finalValues)";
    $result = mysqli_query($conn, $query);
    return $result;
}

//Update data using this function

function update($tableName,$id,$data){
    global $conn;
    $table=validate($tableName);
    $id=validate($id);
    $updateDataString="";

    foreach($data as $column =>$value)
{
    $updateDataString .=$column.'='."'$value',";
}

$finalUpdateData=substr(trim($updateDataString),0,-1);
$query="UPDATE $table SET $finalUpdateData WHERE id='$id'";
$result=mysqli_query($conn,$query);
return $result;
}

function getAll($tableName,$status=NULL){
    global $conn;
    $table=validate($tableName);
    $status=validate($status);

    if($status == 'status')
    {
        $query="SELECT * FROM $table WHERE status='0'";

    }
    else
    {
        $query="SELECT * FROM $table";

    }
    return mysqli_query($conn,$query);
}

function getById($tableName,$id){
    global $conn;
    $table=validate($tableName);
    $id=validate($id);

    $query="SELECT * FROM $table WHERE id='$id' LIMIT 1";
    $result=mysqli_query($conn,$query);

    if($result){
      
       if(mysqli_num_rows($result)==1){
        $row=mysqli_fetch_assoc($result); 
        $response=[
            'status' => 200,
            'data' =>$row,
            'message' => 'Record Found'
        ];
        return $response;

       }else{
        $response=[
            'status' => 404,
            'message' => 'No Data Found'
        ];
        return $response;
       }

    }else{
        $response=[
            'status' => 500,
            'message' => 'Something Went Wrong'
        ];
        return $response;
    }
}

//Delete data from databse using id

function delete($tableName,$id){
    global $conn;
    $table=validate($tableName);
    $id=validate($id);

    $query="DELETE FROM $table WHERE id='$id' LIMIT 1";
    $result=mysqli_query($conn,$query);
    return $result; 
}


function checkParamId($type){

    if(isset($_GET[$type])){
        if($_GET[$type]!=''){
            return $_GET[$type];

        }else{
            return '<h5>Id not found</h5>';
        }
    }else{
            return '<h5>Id not found</h5>';
    }
}

//Logout Session

// unset($_SESSION['loggedIn']);
// unset($_SESSION['loggedInUser']);
//logout Session
function logoutSession() {
    // Unset all session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();
}

//For JSON
function jsonResponse($status,$status_type,$message){
    $response=[
        'status' => $status,
        'status_type' =>$status_type,
        'message' => $message
      ];
      echo json_encode($response);
      return;
}

//Get Count Function 
function getCount($tableName)
{
    global $conn;
    $table=validate($tableName);
    $query="SELECT * FROM $table";
    $query_run=mysqli_query($conn,$query);
    if($query_run){
        $totalCount=mysqli_num_rows($query_run);
        return $totalCount;

    }else{
        return 'Something Went Wrong';
    }
}



?>
