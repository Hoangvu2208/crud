<?php 
global $conn;


try {
    $sever ='localhost';
    $userhost = 'root';
    $password = '';
    $database = 'ajax';

    $conn = new PDO("mysql:host = $sever;dbname=$database",$userhost,$password);
    $conn -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    //echo 'connected';

} catch (\Throwable $e) {
    echo 'connect failed' . $e->getMessage();
    # code...
}


?>