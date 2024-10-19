<?php
// ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
  include('dbcon.php');
  session_start();
  if(isset($_SESSION['username'])&&isset($_SESSION['password'])){
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];
    $email;
  $userid;
  $verified_user = false;
  $sql = "select * from user_details where username = '$username'"; 
  $res = mysqli_query($con,$sql);
  $HTML = "";
       if(mysqli_num_rows($res)>0){
         $row=mysqli_fetch_assoc($res);
         $hash=$row['password'];
         $userid = $row['id'];
         $email = $row['email'];
           if(password_verify($password,$hash)){
             $verified_user = true;
            //now you can show the profile section
              $sql2 = "select image_string,encryption_key from images where user_id = '$userid'";
              $result = mysqli_query($con,$sql2);
              $storeArray = Array();
              $encryptionArray = Array();
              while ($row = mysqli_fetch_assoc($result)) {
                  $storeArray[] =  $row['image_string'];  
                  $encryptionArray[] = $row['encryption_key'];//getting all the encryption keys here
              }
           }else{
            $verified_user = false;
            $HTML = "<div class='msg'>YOU NEED TO LOGIN FIRST...</div>";
           }
      }else{
        $verified_user = false;
        $HTML  = "<div class='msg'>YOU NEED TO SIGN UP FIRST...</div>";
      }
    }else{
      $verified_user = false;
      $HTML = "<div class='msg'>YOU  ARE NOT AUTHORISED USER TO ACCESS IT , LOGIN FIRST...</div>";
    }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profile page | humsecure </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/profile.css">
    <!-- navigation bar all code  -->

    <!-- font icons -->
    <link rel="stylesheet" href="assets/vendors/themify-icons/css/themify-icons.css">
    
    <!-- owl carousel -->
    <link rel="stylesheet" href="assets/vendors/owl-carousel/css/owl.carousel.css">
    <link rel="stylesheet" href="assets/vendors/owl-carousel/css/owl.theme.default.css">

        <!-- Bootstrap + Ollie main styles -->
      <link rel="stylesheet" href="assets/css/ollie.css">
      <!-- font icons -->
      <link rel="stylesheet" href="assets/vendors/themify-icons/css/themify-icons.css">
        <!-- font awesome cdn path -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha256-eZrrJcwDc/3uDhsdt61sL2oOBY362qM3lon1gyExkL0=" crossorigin="anonymous" />
  <style>
    .heading-primary-main {
        display:none;
        font-weight: 400;
        animation-name: moveInleft;
        animation-duration: 3s;
    }
    
@keyframes moveInleft {
    0% {
        opacity: 0;
        transform: translateX(-100px);
    }

    80% {
        transform: translateX(10px);
    }
    100% {
        opacity: 1;
        transform: translate(0);
    }
}


  </style>
  </head>

  <body>
  <!-- navigation bar --> 
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
                        <a class="nav-link" href="./login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>
                    <!-- <li class="nav-item ml-0 ml-lg-4">
                        <a class="nav-link btn btn-primary" href="components.html">Components</a>
                    </li> -->
                </ul>
            </div>
        </div>
    </nav>

  <!-- navigation bar -->
    <?php
      if($verified_user){
    ?>
        <!-- Student Profile -->
<div class="student-profile py-4" style= "margin-top:5rem;">
    <div class="container">
      <div class="row">
        <div class="col-lg-4">
          <div class="card shadow-sm">
            <div class="card-header bg-transparent text-center">
              <img class="profile_img" src="https://placeimg.com/640/480/arch/any" alt="">
              <h3><?php echo "$username"; ?></h3>
            </div>
            <div class="card-body">
              <p class="mb-0"><strong class="pr-1">USER ID: <?php echo "$userid"; ?></strong></p>
              <p class="mb-0"><strong class="pr-1">Class:</strong>4</p>
              <p class="mb-0"><strong class="pr-1">Section:</strong>A</p>
            </div>
          </div>
        </div>
        <div class="col-lg-8">
          <div class="card shadow-sm">
            <div class="card-header bg-transparent border-0">
              <h3 class="mb-0"><i class="far fa-clone pr-1"></i>General Information</h3>
            </div>
            <div class="card-body pt-0">
              <table class="table table-bordered">
                <tr>
                  <th width="30%">photos uploded</th>
                  <td width="2%">:</td>
                  <td><?php print_r(count($storeArray)); ?></td>
                </tr>
                <tr>
                  <th width="30%">Joined</th>
                  <td width="2%">:</td>
                  <td>2020</td>
                </tr>
                <tr>
                  <th width="30%">email</th>
                  <td width="2%">:</td>
                  <td><?php echo $email ?></td>
                </tr>
                <!-- <tr>
                  <th width="30%">Religion</th>
                  <td width="2%">:</td>
                  <td>Group</td>
                </tr> -->
                <!-- <tr>
                  <th width="30%">blood</th>
                  <td width="2%">:</td>
                  <td>B+</td>
                </tr> -->
              </table>
              <div class ="container">
                <div class="row">
                  <div class="col-md-6 button-parent">
                   <button class = "btn btn-primary w-100 h-100 btn-download-all" onclick="downloadImg()">Download all images</button>
                  </div>
                  <div class="col-md-6 otp-form-parent">
                  <input class="form-control form-control-lg heading-primary-main otp-form" type="text" placeholder="Enter OTP sent to your mail" aria-label=".form-control-lg example">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- gallery code  -->
     <div class="container d-flex justify-content-center align-items-center">
         <div class="row d-flex justify-content-center align-items-center">
              <?php
               function str_replace_first($search, $replace, $subject)
               {
                   $search = '/'.preg_quote($search, '/').'/';
                   return preg_replace($search, $replace, $subject, 1);
               }
                $i = 0;
                foreach($storeArray as $img){
                  
                  $cipher = "AES-256-CBC";
                  $encryption_key  = $encryptionArray[$i];
                  $i++;
                  $options  = 0;
                  $iv = str_repeat("0",openssl_cipher_iv_length($cipher));
                  $base64 = openssl_decrypt($img,$cipher,$encryption_key,$options,$iv);
                 
                 

                  $file_extension =  explode('/', mime_content_type($base64))[1];
                  if($file_extension=="svg+xml"){
                    $base64=str_replace_first('image/','',$base64); 
                  }
  
                  $code = '<div class="col-lg-4 col-md-6 col-sm- images d-flex justify-content-center align-items-center">
                    <img src='. $base64 .' alt="" class="img_common"  width="300" height="200">
                  </div>';
                  print_r($code);
              }                 
              ?>
              <div id="image-viewer">
                  <span class="close">&times;</span>
                  <img class="modal-content" id="full-image">
              </div>
          </div>
     </div>
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
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <script>
      $(".images img").click(function(){
        $("#full-image").attr("src", $(this).attr("src"));
        $('#image-viewer').show();
        $("#image-viewer .close").click(function(){
          $('#image-viewer').hide();
        });
      });
    </script>
    <!-- navbar coding scripts -->
    <!-- core  -->
    <script src="assets/vendors/jquery/jquery-3.4.1.js"></script>
    <script src="assets/vendors/bootstrap/bootstrap.bundle.js"></script>

    <!-- bootstrap 3 affix -->
	<script src="assets/vendors/bootstrap/bootstrap.affix.js"></script>
    
    <!-- Owl carousel  -->
    <script src="assets/vendors/owl-carousel/js/owl.carousel.js"></script>


    <!-- Ollie js -->
    <script src="assets/js/Ollie.js"></script>
    <script>
     
     function downloadImg(){
        var otp_number = "";
       //if download button ka text ka value donwload all image hai to
          if($('.btn-download-all').text()=="Download all images"){
              $('.otp-form').css("display","block");
              $('.btn-download-all').css("background","green");
              $('.btn-download-all').text("Verify OTP");
              $.ajax({
                url:'otp.php',
                success:function(result){
                  //here result is the otp
                   otp_number = result.slice(-8);
                   alert(otp_number);
                   $('.btn-download-all').click(()=>{
                      if($('.otp-form').val().length===0){
                        alert("Enter the OTP");
                      }else{
                            if($('.otp-form').val().trim()===otp_number.trim()){
                                  $('.otp-form-parent').hide();
                                  $('.button-parent').removeClass('col-md-6');
                                  $('.button-parent').addClass('col-12');
                                  $('.button-parent').addClass('heading-primary-main'); 
                                  $('.button-parent').css('display','block'); 
                                  $('.btn-download-all').text("OTP VERIFIED, CLICK HERE TO DOWNLOAD");
                                // ---------------------------------------------------------
                                      //download all photos using php code starts here
                                      $('.btn-download-all').click(()=>{
                                        if( $('.btn-download-all').text()==="OTP VERIFIED, CLICK HERE TO DOWNLOAD"){
                                            $.ajax({
                                               url:'download.php',
                                               type: 'POST',
                                               success:function(result){
                                                 window.location = 'download.php';
                                               }
                                            });
                                        }
                                      });
                                      //download all photos using pho code ends here
                                // ---------------------------------------------------------
                            }else{
                                alert('Wrong otp entered ,Try Again');
                            }
                        } 
                   });
                   
                }
              });
            }
       }
    </script>
    <?php
      }else{
        echo $HTML;
      }
    ?>
  </body>
</html>
