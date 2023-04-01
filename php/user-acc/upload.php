<?php
    require_once('../../connect/connection.php');
    if ( 0 < $_FILES['file']['error'] ) {
        echo 'File ảnh lỗi!';
    }
    else {
        $target_file="uploads/" . basename($_FILES['file']['name']);
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
        $maxfilesize = 800000;
        $allowtypes = array('jpg', 'png', 'jpeg', 'gif', 'JPG', 'PNG', 'JPEG', 'GIF');
        //Kiểm tra xem có phải là ảnh bằng hàm getimagesize
        if(getimagesize($_FILES['file']["tmp_name"])){
            if($_FILES['file']["size"] <= $maxfilesize){
                if(in_array($imageFileType, $allowtypes )){
                    move_uploaded_file($_FILES['file']["tmp_name"], $target_file);
                    echo $target_file;
                }
                else{
                    echo "fotmat";
                }
            }
            else{
                echo "size";
            }
        }
        else{
            echo "file";
        }
    }
?>