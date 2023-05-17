<?php 
include ('database.php');
session_start();
if (!empty($_GET['deleteId'])){
    $id = $_GET['deleteId'];
    delete_data($conn,$id);
}

function delete_data ($conn,$id){
    $query = "delete from member where id= $id";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    if ($stmt){
        $msg =$_SESSION['msg'] = "xoa thanh cong";
        $_SESSION['status'] = "success";
        echo $msg;
        
    }else{
        $_SESSION['status'] = "error";
        $msg = $_SESSION['msg'] = "Error: " . $query . "<br>" . mysqli_error($conn);
        echo $msg ;
    }
}

?>