<?php
    ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
    include('dbcon.php');
    session_start();
    $old_user = false;
 
    if(isset($_SESSION['username'])&&isset($_SESSION['password'])){
        $username = $_SESSION['username'];
        $password = $_SESSION['password'];
        $sql = "select * from user_details where username = '$username'"; 
        $res = mysqli_query($con,$sql);
        if(mysqli_num_rows($res)>0){
            $row=mysqli_fetch_assoc($res);
            $hash=$row['password'];
            $userid = $row['id'];
            $email = $row['email'];
            if(password_verify($password,$hash)){
                $old_user = true;
            }
        }
    }
    if(!$old_user){
        $code = '<h1 class="carousel-title">We Secure<br>your data</h1>';
    }else{
        $code = '<h1 class="carousel-title">Welcome,<br>'.$username.'</h1>';
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Start your development with Ollie landing page.">
    <meta name="author" content="Devcrud">
    <title>humsecure</title>

    <!-- font icons -->
    <link rel="stylesheet" href="assets/vendors/themify-icons/css/themify-icons.css">
    <!-- font awesome cdn path -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha256-eZrrJcwDc/3uDhsdt61sL2oOBY362qM3lon1gyExkL0=" crossorigin="anonymous" />
    <!-- owl carousel -->
    <link rel="stylesheet" href="assets/vendors/owl-carousel/css/owl.carousel.css">
    <link rel="stylesheet" href="assets/vendors/owl-carousel/css/owl.theme.default.css">

    <!-- Bootstrap + Ollie main styles -->
	<link rel="stylesheet" href="assets/css/ollie.css">
    <style>
        .logged-out{
            display: none;
         }
    </style>
</head>
<body data-spy="scroll" data-target=".navbar" data-offset="40" id="home">
    <nav id="scrollspy" class="navbar navbar-light bg-light navbar-expand-lg fixed-top" data-spy="affix" data-offset-top="20">
        <div class="container">
            <a class="navbar-brand" href="#"><img src="assets/imgs/brand.svg" alt="" class="brand-img"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#home">Home</a>
                    </li>
                    <?php
                        if(!$old_user){
                            $links = '<li class="nav-item">
                                    <a class="nav-link" href="./sign_up.php">Register here</a>
                                </li> 
                                <li class="nav-item">
                                    <a class="nav-link" href="./login.php">Login/New User ?</a>
                                </li>';
                        }else{
                            $links = '<li class="nav-item">
                              <div class=" navbar-collapse" id="navbarNavDarkDropdown">
                                <ul class="navbar-nav">
                                  <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                     '."$username".'
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
                                      <li><a class="dropdown-item" href="profile.php">Profile</a></li>
                                      <li><a class="dropdown-item" href="#">Edit Password</a></li>
                                      <li  onclick ="logout()" ><a class="dropdown-item">Logout</a></li>
                                    </ul>
                                  </li>
                                </ul 
                              </div>
                            </li>';
                        }
                            echo $links;
                    ?>
                    
                    <!-- profile section comes here and logout section comes here -->
                </ul>
            </div>
        </div>
    </nav>
 <!-- logged out code starts here -->
 <div class="container logged-out">
            <div class="row d-flex justify-content-center">
                <div class="col-md-10 d-flex justify-content-center">
                        You have been logged out.
                </div>
            </div>
        </div>
    <!-- logged out code ends here -->
    <header id="home" class="header">
        <div class="overlay"></div>

        <div id="header-carousel" class="carousel slide carousel-fade" data-ride="carousel">  
            <div class="container">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="carousel-caption d-none d-md-block">
                            <?php echo $code; ?>
                           <a href="./upload.php"><button class="btn btn-primary btn-rounded">UPLOAD</button></a> 
                        </div>
                    </div>
                </div>
            </div>        
        </div>

        <div class="infos container mb-4 mb-md-2">
            <div class="title">
                <h6 class="subtitle font-weight-normal">Are you looking for Security ?</h6>
                <h5>We will provide you Security</h5>
                <p class="font-small">start uplaoding images now and enjoy unlimited storage.</p>
            </div>
            <div class="socials text-right">
                <div class="row justify-content-between">
                    <div class="col">
                        <a class="d-block subtitle"><i class="ti-microphone pr-2"></i> (+91) 96369 33013</a>
                        <a class="d-block subtitle"><i class="ti-email pr-2"></i>humsecure.com</a>
                    </div>
                    <div class="col">
                        <h6 class="subtitle font-weight-normal mb-2">Social Media</h6>
                        <div class="social-links">
                            <a href="javascript:void(0)" class="link pr-1"><i class="ti-facebook"></i></a>
                            <a href="javascript:void(0)" class="link pr-1"><i class="ti-twitter-alt"></i></a>
                            <a href="javascript:void(0)" class="link pr-1"><i class="ti-google"></i></a>
                            <a href="javascript:void(0)" class="link pr-1"><i class="ti-pinterest-alt"></i></a>
                            <a href="javascript:void(0)" class="link pr-1"><i class="ti-instagram"></i></a>
                            <a href="javascript:void(0)" class="link pr-1"><i class="ti-rss"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
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
    </section>
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
    <!-- logout code -->
    <script>
        function logout(){
            $.ajax({
                url:'logout.php',
                success:function(){
                    document.location.reload(true);
                }
            });
        }
    </script>
</body>
</html>
<?php
echo "<script>console.log('$old_user')<script>";
?>