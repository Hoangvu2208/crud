<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// session_destroy();
session_start();
include ('database.php');
$_SESSION['isEdit'] = false;


if (isset($_POST)) {

    $username = $_POST['username'];
    $email = $_POST['email'];
    //var_dump($username);
    

    if (!empty($username) && !empty($email)) {
        try {
            $query = "select * from member where email='$email'";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            # code...
            $error_email = $stmt->fetchAll();
            var_dump($error_email);
            if (empty($error_email)) {
               
                try {
                    $query = "INSERT INTO member (username,email) value ('$username','$email')";
                    $stmt = $conn->prepare($query);
                    $stmt->execute();
                    $msg =$_SESSION['msg'] = "them thanh cong";
                    $_SESSION['status'] = "success";
                    //echo $msg;
                } catch (\Throwable $e) {
                    # code...
                    echo $e->getMessage();
                } 
            }else{
                 # code...
            $msg =$_SESSION['msg'] = "email bi trung ";
            $_SESSION['status'] = "error";
            $_SESSION['username'] = $username;
            
            }
        } catch (\Throwable $e) {
            # code...
            $msg =$_SESSION['msg'] = "loi ket noi database ";
            $_SESSION['status'] = "error";
        }      
    } else {
        echo 'vui long dien day du thong tin';
    }
}

?>