<?php
    session_start();
    include('dbcon.php');
    date_default_timezone_set('Asia/Kolkata');
    $wrong_username = false;
    $wrong_password = false;
    if(isset($_POST['submit'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];  
        $_SESSION['username']  = $username; //session username
        $_SESSION['password'] = $password; //session password
        $sql = "select * from user_details where username = '$username' or email = '$username'"; 
        $res = mysqli_query($con,$sql);
       
        if(mysqli_num_rows($res)>0){
            $row=mysqli_fetch_assoc($res);
	        $hash=$row['password'];
            $_SESSION['username']  = $row['username'];
            if(password_verify($password,$hash)){
                //correct password
                header('Location:index.php');
                // header('Location:upload.php');
            }else{
                //wrong password
                $wrong_password = true;
            }
            
        }else{
            //user not registred, wrong username
            $wrong_username = true;
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login page</title>
    <link rel="stylesheet" href="./css/style.css" type="text/css">
      <!-- bootstrap -->
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    
</head>
<style>
        .error{
            border:1px solid pink;
            text-align:center;
            background-color:rgba(255, 192, 203, 0.394);
            padding:2rem;
        }
        .container-error{
            display: none;
            margin-top:5rem;
        }
    </style>
<body> 
    <div class="container container-error" >
        <div class="row d-flex justify-content-center align-items-center">
            <div class= "error col-md-6" >
                unable to register currently try again later.
            </div>
        </div>
    </div>
    <div class="loginbox"> 
        <img src="./assets/imgs/avtaar.png" class="avtaar" alt="">
        <h1>Login here</h1>
        <form action="login.php" method ="post">
            <p>Username</p>
             <input type="text" name="username" placeholder="Enter username">
            <p>Password</p>
            <input type="password" name="password" placeholder="Enter Password">
            <input type="submit" name="submit" value="Login">
            <a href="#">Forgot Password?</a><br>
            <a href="sign_up.php">Don't have an account?</a>
        </form>
    </div>
    <!-- jquery scripts -->
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <?php
    
        if($wrong_username){
            echo "<script>$('.container-error').css('display','block');</script>";
            echo "<script>$('.error').text('username did not registered');</script>";
        }
        if($wrong_password){
            echo "<script>$('.container-error').css('display','block');</script>";
            echo "<script>$('.error').text('password did not match');</script>";
        }
    ?>
</body>
</html>