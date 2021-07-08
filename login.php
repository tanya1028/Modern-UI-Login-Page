<!doctype html>
<html>
<head>
 <title>Login Form</title>
 <link rel="stylesheet" type="text/css" href="style.css">
 <script src="https://www.google.com/recaptcha/api.js"></script>
</head>
<?php

 error_reporting(E_ALL);
 ini_set('display_errors', '1');
 session_start();
 include 'conexion2.php';
 $conn = mysqli_connect($host, $user, $pwd, $db);
 if(!$conn){
 echo "FATAL ERROR connection";
 die();
 }
 if(isset($_POST["g-recaptcha-response"])){
 $secretKey = "6LeHPuMaAAAAAOjTo8PIkyttiTEFQFUiGYF2vnQ1";
 $captcha = $_POST['g-recaptcha-response'];
 $ip= $_SERVER['REMOTE_ADDR'];
 $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$captcha&remoteip=$ip";
 $fire = file_get_contents($url);
 $data = json_decode($fire);
 if ($data->success==true){
 $username = $_POST["username"];
 $password = $_POST["password_1"];
 $sql = "Select * FROM users WHERE name = '" .$username ."' and password = '" .$password . "'";

 $resul = mysqli_query($conn,$sql);
 if(!$resul)
 {
 echo("Error description: " . mysqli_error($conn));
 }
 $numRows = mysqli_num_rows($resul);
 if($numRows != 0){
 $row = mysqli_fetch_array($resul, MYSQLI_ASSOC);
 $name = $row['name'];
 echo "<div class='form'><h2>Login Successful</h2>
 Welcome to the website, "
 .$name."<br><div class='input'><div class='inputbox'>
 <a href='contents1.php'><div class='inputbox'><input type='submit' name='reg_user' value='Click here'></a></div></div</div>";
 } else{
 echo "<h3>Login Error</h3>";
 }}
 else
 echo "Verification failed!";
 }
 mysqli_close($conn);
?>