<?php 

class Upload{
    function uploadFile($file){
        $flag=true;
        if(isset($_FILES['image'])){
            $errors= array();
            $file_name = $file['image']['name'];
            $file_size = $file['image']['size'];
            $file_tmp = $file['image']['tmp_name'];
            $file_type = $file['image']['type'];
            $file_ext=strtolower(end(explode('.',$file['image']['name'])));
            
            $extensions= array("jpeg","jpg","png");
            
            if(in_array($file_ext,$extensions)=== false){
               $errors[]="extension not allowed, please choose a JPEG or PNG file.";
               
            }
            
            if($file_size > 2097152) {
               $errors[]='File size must be excately 2 MB';
            }
            
            if(empty($errors)==true) {
               move_uploaded_file($file_tmp,"images/".$file_name);
               echo "Success";
            }else{
               print_r($errors);
            }
         }
    }
}