<?php

    ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
    session_start();
    include('dbcon.php');
    date_default_timezone_set('Asia/Kolkata');
        $username = $_SESSION['username'];
        $password = $_SESSION['password'];  
        $sql = "select * from user_details where username = '$username' or email = '$username'"; 
        $res = mysqli_query($con,$sql);
        if(mysqli_num_rows($res)>0){
            $row=mysqli_fetch_assoc($res);
	        $hash=$row['password'];
            $_SESSION['username']  = $row['username'];
            $userid = $row['id'];
            if(password_verify($password,$hash)){
                $sql2 = "select image_string,encryption_key from images where user_id = '$userid'";
                $result = mysqli_query($con,$sql2);
                $storeArray = Array();
                $encryptionArray = Array();
                while ($row = mysqli_fetch_assoc($result)) {
                    $storeArray[] =  $row['image_string'];  
                    $encryptionArray[] = $row['encryption_key'];//getting all the encryption keys here
                }
                $i = 0;
                $allImages = Array();
                foreach($storeArray as $img){
                  $cipher = "AES-256-CBC";
                  $encryption_key  = $encryptionArray[$i];
                  $i++;
                  $options  = 0;
                  $iv = str_repeat("0",openssl_cipher_iv_length($cipher));
                  $base64 = openssl_decrypt($img,$cipher,$encryption_key,$options,$iv);
                  $allImages[] = $base64;
                }         
                //coverting all base64 to real images and storing it in upload folder
                foreach($allImages as $eachimg){
                    $data = $eachimg;
                    $file_extension =  explode('/', mime_content_type($eachimg))[1];
                    if($file_extension=="svg+xml"){
                        $file_extension = "svg";
                    }
                    list($type, $data) = explode(';', $data);
                    list(, $data)      = explode(',', $data);
                    $decoded_data = base64_decode($data);
                    $file = "uploads/" . uniqid() .'.'.$file_extension;
                    $success = file_put_contents($file, $decoded_data);
                }

                    //delete the zip file..
                    
                     // Folder path to be flushed
                     $folder_path = "zippedFile/";
                     // List of name of files inside
                     // specified folder
                     $files = glob($folder_path.'/*'); 
                     
                     // Deleting all the files in the list
                     foreach($files as $file) {
                         if(is_file($file)) 
                         
                             // Delete the given file
                             unlink($file); 
                     }

                //converting the upload folder to zip file 
                // Include and initialize ZipArchive class
                require_once 'ZipArchiver.class.php';
                $zipper = new ZipArchiver;

                // Path of the directory to be zipped
                $dirPath = 'uploads/';

                // Path of output zip file
                $zipPath = 'zippedFile/'.$username.'.zip';

                // Create zip archive
                $zip = $zipper->zipDir($dirPath, $zipPath);
                //deleting the uplaod folder content
                // Folder path to be flushed
                    $folder_path = "uploads/";
                    
                    // List of name of files inside
                    // specified folder
                    $files = glob($folder_path.'/*'); 
                    
                    // Deleting all the files in the list
                    foreach($files as $file) {
                        if(is_file($file)) 
                        
                            // Delete the given file
                            unlink($file); 
                    }
                //download the zip file..
                // Initialize a file URL to the variable
                $archive_file_name = 'zippedFile/'.$username.'.zip'; // of course find the exact filename....        
                if (file_exists($archive_file_name)) {
                    header('Content-Description: File Transfer');
                    header("Content-Type: application/zip");
                    header('Content-Disposition: attachment; filename="'.basename($archive_file_name).'"');
                    header('Expires: 0');
                    header('Cache-Control: must-revalidate');
                    header('Pragma: public');
                    header('Content-Length: ' . filesize($archive_file_name));
                    ob_clean();
                    readfile($archive_file_name);
                } else {
                    exit("Could not find Zip file to download");
                }
                
                // exit;
               
                
            }
        }
?>