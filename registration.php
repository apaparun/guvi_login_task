<?php
require_once "config.php";
$email = $password = $confirm_password = '';
$email_err = $password_err = $confirm_password_err = '';
if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(empty(trim($_POST["email"]))){
        $email_err="please enter email id.";
    }
    else{
        $sql="SELECT id FROM users WHERE email = ?";
        if($stmt=mysqli_prepare($link,$sql)){
            mysqli_stmt_bind_param($stmt,"s",$param_email);
            $param_email=trim($_POST["email"]);
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt)==1){
                    $email_err="This email id is already registered";
                }
                else{
                    $email=trim($_POST["email"]);
                }
            }
            else{
                echo"Something went wrong";
            }
        }
        mysqli_stmt_close($stmt);
    }
    if(empty(trim($_POST["password"]))){
        $password_err = "please enter password";
    }
    else if(strlen(trim($_POST["password"])) < 6){
        $password_err=trim($_POST["password"]);
    }
    else{
        $password=trim($_POST["password"]);
    }
    if(empty(trim($_POST["confim_password"]))){
        $confirm_password_err = "please confirm password.";
    }
    else{
        $confirm_password=trim($_POST["confirm_password"]);
        if(empty($password_err)&&($password != $confirm_password)){
            $confirm_password_err="password not matched";
        }
    }
    if(empty($email_err)&&empty($password_err)&& empty($confirm_password_err)){
        $sql = "INSERT INTO users (email,password) VALUES(? , ?)";
        if($stmt = mysqli_prepare($link,$sql)){
            mysqli_stmt_bind_param($stmt,"ss",$param_email,$param_password);
            $param_email=$email;
            $param_password= password_hash($password,PASSWORD_DEFAULT);
        if(mysqli_stmt_execute($stmt)){
            header("location:login.php");
        }
        else{
            echo "something went wrong";
        }
    }
    mysqli_stmt_close($stmt);
    }
mysqli_close($link);
}
?>

