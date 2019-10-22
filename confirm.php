<?php
if(!isset($_GET['email']) || !isset($_GET['token'])){
    header('Location: register.php');
    exit();
}
else{
    $con = new mysqli('localhost', 'skodr_confest', 'admin', 'skodr_sifat');
    $email = $con->real_escape_string($_GET['email']);
    echo $email;
    $token = $con->real_escape_string($_GET['token']);
    echo $token;
    $sql = $con->query("SELECT * from register WHERE email='$email' AND token='$token' AND  isEmailConfirmed = 0");
    if($sql->num_rows>0){
        $con->query("UPDATE register SET isEmailConfirmed = 1, token = '' WHERE email = '$email'");
        header('Location: Login/');
        exit();
    }
    else {
        echo 'ERROR';
    }
}
?>