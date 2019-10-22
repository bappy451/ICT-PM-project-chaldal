<?php

$msg = "";
$cMsg = "";


if (isset($_POST['submit'])){

    $con = new mysqli('localhost', 'skodr_confest', 'admin', 'skodr_sifat');

    $name = $con->real_escape_string($_POST["name"]);
    $phone = $con->real_escape_string($_POST['phone']);
    $email = $con->real_escape_string($_POST['email']);
    $password = $con->real_escape_string($_POST['password']);
    $cpassword = $con->real_escape_string($_POST['cpassword']);
    if($name == "" || $phone == "" || $email == "" || $password == "" || $password!=$cpassword){
       $msg = "Check Your Inputs";
    }
    else{
        $sql = $con->query("SELECT * FROM register WHERE email = '$email'");
        if($sql->num_rows>0 AND $data = $sql->fetch_assoc()) {
          if($data['isEmailConfirmed']==0){
            $msg = "Your Mail is registered and waiting for Verification. Check Your Mail for Verification";
          }
          else {
            $msg = "Your Mail is registered Please Login";
          }

        }
        else{
            $token = '1234567890qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM';
            $token = str_shuffle($token);
            $token = substr($token,0,20);
            $hashPassword = password_hash($password, PASSWORD_BCRYPT);
            $queryInsert = $con->query("INSERT INTO register(name,phone,email,password,isEmailConfirmed,token) VALUES ('$name','$phone','$email','$hashPassword','0','$token')");
            if($queryInsert!=0) {
                $to = $email;
                $subject = "Verify";
                $message = "Click the link below to activate your account <br>
                     skoder.co/test/confirm.php?email=$email&token=$token";

// Always set content-type when sending HTML email
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
                $headers .= 'From: <istiak@skoder.co>' . "\r\n";


                $sendmail = mail($to,$subject,$message,$headers);
                if($sendmail == TRUE){
                    $msg = "Registed & Mail sent to ".$email." . Please Verify";
                }
                else {

                    $sql2 = $con->query("Delete FROM register WHERE email = '$email'");
                    if($sql2!=0) $msg = "Register Again PLS";
                }

//                try{
//                    include_once "phpMailer/PHPMailer.php";
//                    //include_once "phpMailer/Exception.php";
//                    include_once "phpMailer/SMTP.php";
//
//                    $mail = new PHPMailer(TRUE);
//                    $mail->SMTPDebug = 2;                                       // Enable verbose debug output
//                    $mail->isSMTP();                                            // Set mailer to use SMTP
//                    $mail->Host       = 'smtp.mail.yahoo.com';  // Specify main and backup SMTP servers
//                    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
//                    $mail->Username   = 'sifatistiak@yahoo.com';                     // SMTP username
//                    $mail->Password   = 'Ss01764205039';                               // SMTP password
//                    $mail->SMTPSecure = 'ssl';                                  // Enable TLS encryption, `ssl` also accepted
//                    $mail->Port       = 465;
//                    $mail -> setFrom('sifatistiak@gmail.com');
//                    $mail->addAddress($email,$name);
//                    $mail->Subject = 'Please verify Mail @Chaldal.co';
//                    $mail->isHTML(TRUE);
//                    $mail->Body =
//                        "Click the link below to activate your account <br><br>
//                            <a href='localhost/auth/confirm.php?email=$email&token=$token'>Click Here To Verify</a>"
//                    ;
//                    $mail->send();
//                    $cMsg = "MAIL SENT";
//                }
//                catch (Exception $e){
//                    //$cMsg = $e;
//                }

            }

        }

    }
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <style>
    body{
      background-image: url("https://img.freepik.com/free-photo/white-cloud-sky-background_74190-4646.jpg?size=626&ext=jpg");
      background-size: cover;
    }
    </style>

</head>
<body >
<div class="container" style="margin-top: 0px;">
    <div class="row justify-content-center">
        <div class="col-md-6 col-md-offset-3">
          <div class="login100-pic js-tilt" data-tilt>
            <img src="img/Chaldal.png" alt="IMG">
            <h2 align = "center">Registration Panel</h2>
          </div>

            <?php if($msg !="") echo $msg."<br><br>" .$cMsg. "<br><br>";  ?>

<form action="register.php" method="post">
    <div class="form-group">
        <label for="exampleInputEmail1">Name</label>
        <input type="text" class="form-control" name="name"  placeholder="Enter Name">

    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Phone</label>
        <input type="number" class="form-control" name="phone" placeholder="Enter Phone No. 01XXXXXXXXX">

    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Email address</label>
        <input type="email" class="form-control" name="email" aria-describedby="emailHelp" placeholder="Enter email">

    </div>
    <div class="form-group">
        <label for="exampleInputPassword1">Password</label>
        <input type="password" class="form-control" name="password" placeholder="Password">
    </div>
    <div class="form-group">
        <label for="exampleInputPassword1">Confirm Password</label>
        <input type="password" class="form-control" name="cpassword" placeholder="Confirm Password">
    </div>


    <input class="btn btn-primary" type="submit" name="submit" value ="Register">

</form>
        </div>
    </div>
</div>
</body>
</html>
