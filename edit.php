<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include ('database.php');

$_SESSION['isEdit'] = true;

if (!empty($_GET['editId'])){
    $id = $_GET['editId'];
    $editUser = array();
    try {
        $query = "SELECT username,email FROM member WHERE id = $id";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $editUser = $stmt->fetch(PDO::FETCH_ASSOC);
        $editUser['id'] = $id;
        //var_dump($editUser);
        //echo 'them thanh cong';
        //var_dump($editUser);
        echo (json_encode($editUser));
        
        // $_SESSION['edit']['username'] = $editUser['username'];
        // $_SESSION['edit']['email'] = $editUser['email'];
    } catch (\Throwable $e) {
        # code...
        echo $e->getMessage();
    }
 
}else{
    var_dump($_POST);
    if (!empty($_POST)) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $id = $_POST['id'];
    
       if (!empty($username) && !empty($email)){
       try {
        $query = "UPDATE member set username = '$username',email='$email' WHERE id = $id";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        if ($stmt) {
            echo 'sua thanh cong';
            $_SESSION['msg'] = "Sua thanh cong";
            $_SESSION['status'] = "success";
        }else{
            echo 'loi';
        }
       } catch (\Throwable $e) {
        # code..
        echo $e->getMessage();
       }
       }
    }else{
        echo 'khong nhan duoc du lieu';
    }
}



?>