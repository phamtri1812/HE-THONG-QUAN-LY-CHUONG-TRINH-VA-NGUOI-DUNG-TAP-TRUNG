<?php
    require_once('../../connect/connection.php');
    if(isset($_POST['id_check']) && isset($_POST['name_login'])){
        $id_check=$_POST['id_check'];
        $name_login=$_POST['name_login'];
        $stid=oci_parse($conn, "SELECT * FROM NHANVIEN ORDER BY ID_NV ASC");
        oci_execute($stid);
        $check=0;
        while($row=oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)){
            if($row["TENDN"]==$name_login && $row["ID_NV"]!=$id_check){
                $check++;
            }
        }
        echo $check;
    }
    if(isset($_POST['id_edit'])){
        $id_edit=$_POST['id_edit'];
        $name=$_POST['name'];
        $gender=$_POST['gender'];
        $add=$_POST['add'];
        $date=$_POST['date'];
        $login=$_POST['login'];
        $phone=$_POST['phone'];
        $email=$_POST['email'];
        $stid=oci_parse($conn, "UPDATE NHANVIEN SET HOTEN='".$name."', NGAYSINH=TO_DATE('".$date."','yyyy-mm-dd'), DIACHI='".$add."', SDT='".$phone."', EMAIL='".$email."', GIOITINH='".$gender."', TENDN='".$login."' WHERE ID_NV='".$id_edit."'");
        oci_execute($stid);
        oci_free_statement($stid);
        oci_close($conn);
        echo 'Cập nhật thông tin thành công!';
    }

    if(isset($_POST['check_old_pass']) && isset($_POST['id_check_pass'])){
        $stid=oci_parse($conn, "SELECT * FROM NHANVIEN WHERE ID_NV=".$_POST['id_check_pass']);
        oci_execute($stid);
        while($row=oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)){
            if($row['MATKHAU']==$_POST['check_old_pass']){
                echo '1';
            }
            else {
                echo '0';
            }
        }
    }
    if(isset($_POST['id_pass']) && isset($_POST['new_pass'])){
        $stid=oci_parse($conn, "UPDATE NHANVIEN SET MATKHAU='".$_POST['new_pass']."' WHERE ID_NV='".$_POST["id_pass"]."'");
        oci_execute($stid);
        oci_free_statement($stid);
        oci_close($conn);
        echo 'Cập nhật mật khẩu thành công!';
    }
    if(isset($_POST['id_img'])){
        $id_img=$_POST['id_img'];
        $filename=$_POST['filename'];
        $target_file="uploads/".basename($filename);
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
        $newname="uploads/".$id_img.".jpg";
        rename($target_file,$newname);
        $sql=oci_parse($conn,"UPDATE NHANVIEN SET HINHANH='".$newname."' WHERE ID_NV=".$id_img);
        oci_execute($sql);
        echo $newname;
    }

?>