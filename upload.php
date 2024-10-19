<?php
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
   session_start();
   if(isset($_SESSION['username'])&&isset($_SESSION['password'])){
     $username = $_SESSION['username'];
     $password = $_SESSION['password'];
   $userid;
   $old_user = false;
   include('dbcon.php');
   $sql = "select * from user_details where username = '$username'"; 
   $res = mysqli_query($con,$sql);
   $HTML = "";
        if(mysqli_num_rows($res)>0){
            $row=mysqli_fetch_assoc($res);
	        $hash=$row['password'];
          $userid = $row['id'];
            if(password_verify($password,$hash)){
                //correct password
                $old_user = true;
                $HTML = '<div class="container upload-container" style="">
                             <div class="row d-flex justify-conent-center align-items-center">
                                  <div class="col-md-12">
                                    <form action="upload.php" method="post" enctype="multipart/form-data">
                                      <p class="initial-msg">Select Image to upload:</p> <br>
                                      <input type="file" name="file[]" id="fileToUpload" multiple> <br>
                                      <input type="submit" value="Upload Image" name="submit"> <br>
                                    </form>
                                  </div>
                                    <!-- error will display here -->
                                      <div class="col-md-12 error m-auto">

                                      </div>
                              </div>
                          </div>';
            }else{
              //incorrect password
              $old_user = false;
              $HTML = "<div class='d-flex justify-content-center align-items-center' style ='text-align:center; width:100%; height:100vh;'>YOU ARE NOT REGISTERED WITH US";
            }
        }else{$old_user = false;
          //incorrect password
          $HTML = "<div class='d-flex justify-content-center align-items-center' style ='text-align:center; width:100%; height:100vh;'>YOU ARE NOT REGISTERED WITH US</div>";
        }
      }else{
        $old_user = false;
        //incorrect password
        $HTML = "<div class='d-flex justify-content-center align-items-center' style ='text-align:center; width:100%; height:100vh;'>YOU ARE NOT REGISTERED WITH US</div>";
      }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>upload</title>
    <style>
      body{
        background-color: rgba(11, 11, 11, 0.143)  !important;
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
        .initial-msg{
          text-align:center;
          padding:2rem;
          font-size:1.5rem;
          font-weight:bold;
        }
        .upload-container{
           margin-top:15rem;
           margin-bottom:20rem;
        }

    </style>
    <!-- font icons -->
    <link rel="stylesheet" href="assets/vendors/themify-icons/css/themify-icons.css">
    <!-- font awesome cdn path -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha256-eZrrJcwDc/3uDhsdt61sL2oOBY362qM3lon1gyExkL0=" crossorigin="anonymous" />
    <!-- owl carousel -->
    <link rel="stylesheet" href="assets/vendors/owl-carousel/css/owl.carousel.css">
    <link rel="stylesheet" href="assets/vendors/owl-carousel/css/owl.theme.default.css">
    <link rel="stylesheet" href="./assets/css/ollie.css">
</head>
<html>
<body>
  <!-- navbar me kya show karna hai -->
  <nav id="scrollspy" class="navbar navbar-light bg-light navbar-expand-lg fixed-top" data-spy="affix" data-offset-top="20">
        <div class="container">
            <a class="navbar-brand" href="#"><img src="assets/imgs/brand.svg" alt="" class="brand-img"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="./index.php">Home</a>
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
  <!-- navbar mw kya show karna hai -->
  <?php
      echo $HTML;
  ?>
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
</body>
</html>
<?php
  // session variables::
  $errors=array();
  if(isset($_POST['submit']) && isset($_FILES['file'])){
    // echo "<pre>";
    // print_r($_FILES['file']);
    // echo "</pre>";
    // image details
     // generate a random key for secret key
     function generateRandomString($length = 32) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    foreach($_FILES['file']['tmp_name'] as $key =>$image){
        $img_name  = $_FILES['file']['name'][$key];
        $full_path =$_FILES['file']['full_path'][$key];
        $type      =$_FILES['file']['type'][$key];
        $file_tmp  = $_FILES['file']['tmp_name'][$key];
        $error     = $_FILES['file']['error'][$key];
        $file_size      = $_FILES['file']['size'];
        $file_ext = strtolower(pathinfo($img_name,PATHINFO_EXTENSION));
        $data = file_get_contents( $file_tmp );
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        // only  images format are allowed..
        $allowed_ext = array("jpg","png","jpeg","gif","psd","svg");
        //------------------------------------------------------------------------------
        // code to convert base64 to aes
        $cipher = "AES-256-CBC";
        $encryption_key  = generateRandomString(); //encrytion key
        $options  = 0;
        $iv = str_repeat("0",openssl_cipher_iv_length($cipher));
        $encrypted =  openssl_encrypt($base64,$cipher,$encryption_key,$options,$iv);
        //-----------------------------------------------------------------------------
        if(in_array($file_ext,$allowed_ext)){
          // upload this image in the image table
           $sql = "insert into images (image_string,user_id,encryption_key) values('$encrypted','$userid','$encryption_key')";
           $success_sql=mysqli_query($con,$sql);
           $success  = 0;
           $failure  = 0; 
            if($success_sql){
              echo '<script>$(".error").append("success<br>");</script>';
            }else{
              echo "failure";
            }
          
        }else{
          $errors[] = "This extension is not allowed";
        }
    }
   
  }
?>