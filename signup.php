
<?php
session_start();
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
date_default_timezone_set('Asia/Kolkata');
$x = 0;
$already_registered = false;
include("dbcon.php");
     if(isset($_POST['submit'])) {
        $username   = trim($_POST['username']);
        $email = trim($_POST['email']);
        $_SESSION['password'] = $_POST['password'];
        $_SESSION['username']  = $username;
        $password = password_hash(trim($_POST['password']),PASSWORD_BCRYPT);
        $cpassword = password_hash(trim($_POST['cpassword']),PASSWORD_BCRYPT);
      
        // check whether user is already registred or not ?
        $sql ="select * from user_details where email = '$email'";
        $success_sql=mysqli_query($con,$sql);
        if(mysqli_num_rows($success_sql)>0){
           //user already registered
           $already_registered = true;
        }else{
            $sql ="insert into user_details(`username`,`email`,`password`,`confirm_password`)
            values ('$username','$email','$password','$cpassword')";
            // $res=mysqli_query($con,$sql);
            $res1=mysqli_query($con,$sql);
            if($res1){
                header('Location:index.php');
            }else{
                $x=1;
            }
            // mail that you have been succesfully logged in
            
        
        }
         
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sign Up</title>


<link rel="stylesheet" href="./assets/css/ollie.css">
<link rel="stylesheet" href="./css/sign_up.css">
    <!-- font icons -->
     <link rel="stylesheet" href="assets/vendors/themify-icons/css/themify-icons.css">
    <!-- font awesome cdn path -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha256-eZrrJcwDc/3uDhsdt61sL2oOBY362qM3lon1gyExkL0=" crossorigin="anonymous" />
    <!-- owl carousel -->
    <link rel="stylesheet" href="assets/vendors/owl-carousel/css/owl.carousel.css">
    <link rel="stylesheet" href="assets/vendors/owl-carousel/css/owl.theme.default.css">

<style>
    input[type="text"], input[type="password"] {
        font-size:1rem;
        height:3rem;
        margin:0;
    }
    input[type="submit"]{
        padding: 0.3rem;
        font-size:1em;
        background-color:#171717;
        border-radius:0.5rem;
    }
    input[type="submit"]:hover{
        background-color:grey;
    }
    label{
        top:23px;
    }
    p{
        margin:0rem;
        padding:0;
        /* border:1px solid black; */
        display:flex;
        flex-direction:column;
    }
    .form-sign-up{
        margin-top:10rem;
        /* height:50vh; */
    }
    footer{
        background-color:white;
    }
    .error{
            border:1px solid pink;
            text-align:center;
            background-color:rgba(255, 192, 203, 0.394);
            padding:2rem;
        }
        .container-error{
            display: none;
            margin-top:10rem;
        }
    
</style>
</head>
<body>
<nav id="scrollspy" class="navbar navbar-light bg-light navbar-expand-lg fixed-top" data-spy="affix" data-offset-top="20">
    <div class="container">
        <a class="navbar-brand" href="#"><img src="assets/imgs/brand.svg" alt="" class="brand-img"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./sign_up.php">Register here</a>
                </li> 
                <li class="nav-item">
                    <a class="nav-link" href="./login.php">Login/New User ?</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="container container-error" >
    <div class="row d-flex justify-content-center align-items-center">
        <div class= "error col-md-6" >
            unable to register currently try again later.
        </div>
    </div>
</div>

<!-- sign_up main form starts here------------------------------------------------------------------->
	
<form action="signup.php" method = "post" class="form-sign-up">
  <h2>Sign Up</h2>
        <p>
            <label>username</label>
            <input type="text" name="username"  class="inputs" id="username">
        </p>
		<p>
			<label for="Email" class="floatLabel">Email</label>
            <input type="text" name="email" class="inputs" id="email"> 
		</p>
		<p>
			<label for="password" class="floatLabel">Password</label>
		    <input type="password" name="password" id="changePasswordForm"  class="inputs">
            <span id="password_span"></span>
		</p>
		<p>
			<label for="confirm_password" class="floatLabel">Confirm Password</label>
            <input type="password" name="cpassword"  class="inputs" id="confirm_password">
            <span class="do_not_match_span">Your passwords do not match</span>
		</p>
		<p>
			<input type="submit" value="Create My Account" id="submit" name="submit">
		</p>
	</form>
<!-- sign_up main ends here -------------------------------------------------------------------------->
<!-- footer coding will come here -->
 <!-- footer page starts here -->
 <div class="container">
 <footer class="footer mt-5 border-top">
            <div class="row align-items-center justify-content-center">
                <div class="col-md-6 text-center text-md-left">
                    <p class="mb-0">Copyright <script>document.write(new Date().getFullYear())</script> &copy; <a target="_blank" href="http://www.devcrud.com">humsecure</a></p>
                </div>
                <div class="col-md-6 text-center text-md-right">
                    <div class="social-links">
                        <a href="javascript:void(0)" class="link"><i class="ti-facebook"></i></a>
                        <a href="javascript:void(0)" class="link"><i class="ti-twitter-alt"></i></a>
                        <a href="javascript:void(0)" class="link"><i class="ti-google"></i></a>
                        <a href="javascript:void(0)" class="link"><i class="ti-pinterest-alt"></i></a>
                        <a href="javascript:void(0)" class="link"><i class="ti-instagram"></i></a>
                        <a href="javascript:void(0)" class="link"><i class="ti-rss"></i></a>
                    </div>
                </div>
            </div> 
  </footer>
  </div>
 <!-- footer page ends here -->
<!-- footer coding will end here -->
<!-- jquery scripts -->
<!-- jquery scripts -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- bootstrap scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
<!-- core  -->
<script src="assets/vendors/jquery/jquery-3.4.1.js"></script>
<script src="assets/vendors/bootstrap/bootstrap.bundle.js"></script>

<!-- bootstrap 3 affix -->
<script src="assets/vendors/bootstrap/bootstrap.affix.js"></script>

<!-- Owl carousel  -->
<script src="assets/vendors/owl-carousel/js/owl.carousel.js"></script>


<!-- Ollie js -->
<script src="assets/js/Ollie.js"></script>
<?php
    if($x){
        echo "<script>$('.container-error').css('display','block');</script>";
    }
    if($already_registered){
        echo "<script>$('.container-error').css('display','block');</script>";
        echo "<script>$('.error').text('user name alredy registered');</script>";
    }
?>
<!-- validation of passwords in sign up page-->
<script>
       
            var $email = $("#email");
            var $password = $("#changePasswordForm");
            var $confirmPassword = $("#confirm_password");
            var $username = $("#username");
            var error_password = [];
            //Hide hints
            $("form span").hide();
            //disable button
            $(':input[type="submit"]').prop('disabled',true);
            function isPasswordValid(){
              error_password = [];
              var $length =  $password.val().length > 8; //
              var small_case = false;
              var capital_case = false;
              var digits = false;
              var special_case = false;
                  //contains a number ?
                  
                if((/\d/.test($password.val()))) {
                    //number checking 
                    digits = true;
                   
                }else {
                    error_password.push("Password should contain digits.");
                    digits = false;
                }
                if(/[A-Z]/.test($password.val())){
                    //checking for the capital case
                    capital_case = true;
                   
                }else {
                    error_password.push("Password should contain capital letters.");
                    capital_case = false;
                }
                if(/[a-z]/.test($password.val())){ 
                    //checking for the small case
                    small_case = true;
                 
                }else{
                    small_case = false;
                    error_password.push("Password should small letters.");
                } 
   
                if(/[!@#$%^&*(),.?":{}|<>]/.test($password.val())){
                    //checking for the special case
                    special_case = true;
                 
                }else{
                    special_case = false;
                    error_password.push("Password should special letters.");
                }   
                
                if(digits&&capital_case&&small_case&&special_case&& $length){
                    error_password=[];
                    return true;
                }else{
                   return false;
                }
                //insert all the errors to span tag below the password section

            }
            function isPasswordsMatch(){
                if($password.val() == $confirmPassword.val()){
                    return true;
                }else{
                    return false;
                }
            }
            function show_do_not_match(){
                
                if(!isPasswordsMatch()){
                    $('.do_not_match_span').show();
                }else{
                    $('.do_not_match_span').hide();
                }
                $(':input[type="submit"]').prop('disabled',!(isPasswordValid()&&isPasswordsMatch()));
              
            }
            function show_errors_of_password(){
                if(!isPasswordValid()){
                    $("#password_span").show();
                    $("#password_span").text("");
                    var $code = "<ul>";
                    error_password.forEach(element => {
                        $code = $code +  "<li>"+element+"</li>";
                    });
                    $code = $code + "</ul>";
                    console.log($code);
                    $("#password_span").append($code);
                }else{
                    error_password= [];
                    $("#password_span").hide();
                }
            }
           //on focus truggers a  function for confirm password 
             $confirmPassword.keyup(show_do_not_match);
          //onfocus  triggers function for the passsword section
             $password.keyup(show_errors_of_password); 
             //enable the submit button when password is perfect, 
            
           
            
</script>
</body>
</html>
