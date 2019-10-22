<?php
$email = $_POST['email'];
$password = $_POST['pass'];

$con = new mysqli('localhost', 'skodr_confest', 'admin', 'skodr_sifat');
$loginsql = $con->query("SELECT * from register where email = '$email'");
if($loginsql->num_rows > 0){
    while($data = $loginsql->fetch_assoc()){
        if($data['isEmailConfirmed']==0){
            echo "Please Verify Mail";
        }
        else{
            if(password_verify($password,$data['password'])){
            header("Location: shop/");
        }
        else   echo "MisMatched";
            }

    }

}



?>