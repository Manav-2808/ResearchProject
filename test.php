<?php
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
   session_start();
   $username = $_SESSION['username'];
   $password = $_SESSION['password'];
   $userid;
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
                $HTML = '<div class="container">
                <div class="row d-flex justify-conent-center align-items-center">
                  <div class="col-md-4">
                     <form action="test.php" method="post" enctype="multipart/form-data">
                      <p class="initial-msg">Select Image to upload:</p> <br>
                      <input type="file" name="file[]" id="fileToUpload" multiple> <br>
                      <input type="submit" value="Upload Image" name="submit"> <br>
                    </form>
                  </div>
                <!-- error will display here -->
                <div class="row d-flex justify-conent-center align-items-center"> 
                  <div class="col-md-4 error">

                  </div>
                </div>
              </div>
             </div>';
            }else{
                //wrong password
                $HTML = "you are not logged in <a href = 'login.php'>";
                $wrong_password = true;
            }
          }else{
            $HTML = "you are not registered with us <a href = 'sign_up.php'>";
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
        display:flex;
        justify-content:center;
        align-items:center;
        height:100vh;
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


    </style>
</head>
<html>
<body>
  <?php
      echo "$HTML";
  ?>

<!-- jquery scripts -->
    
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
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
            if($success_sql){
              echo "success";
            }else{
              echo "failure";
            }
          
        }else{
          $errors[] = "This extension is not allowed";
        }
    }
   
  }
?>