<?php 
    require_once("../../connect/connection.php");
    // Kiem tra ten
    if(isset($_POST['name_check'])){
        $stid=oci_parse($conn, "SELECT * FROM CHUCVU");
        oci_execute($stid);
        $check=0;
        while($row=oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)){
            if($_POST['id_check']==''){
                if($row["TENCV"]==$_POST['name_check']){
                    $check++;
                }
            }
            else {
                if($row["TENCV"]==$_POST['name_check'] && $row['ID_CV']!=$_POST['id_check']){
                    $check++;
                }
            }
        }
        echo $check;
    }

    if(isset($_POST['name_insert'])){
        $stid=oci_parse($conn, "INSERT INTO CHUCVU(TENCV) VALUES('".$_POST['name_insert']."')");
        oci_execute($stid);
        oci_free_statement($stid);
        oci_close($conn);
        echo 'Thêm chức vụ"'.$_POST['name_insert'].'" thành công!';
    }
    // Chuc vu nhan vien
    if(isset($_POST['id_check_user'])){
        $count=count($_POST['id_check_user']);
        $id=$_POST['id_check_user'];
        $name=$_POST['name_check_user'];
        for($i=0; $i<$count; $i++){
            $stid=oci_parse($conn, "SELECT * FROM NHANVIEN WHERE ID_CV=".$id[$i]);
            oci_execute($stid);
            while($row=oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)){
                if($row["ID_NV"]!=''){
                    echo 'Chức vụ '.$name[$i].' đang có nhân viên nắm giữ. Bạn không thể xóa!';
                    break;
                }
            }
        }
    }
    // Xoa chuc vu
    if(isset($_POST['id_delete'])){
        $count=count($_POST['id_delete']);
        $id=$_POST['id_delete'];
        for($i=0; $i<$count; $i++){
            $stid=oci_parse($conn, "DELETE FROM CHUCVU WHERE ID_CV=".$id[$i]);
            oci_execute($stid);
        }
        echo 'Đã xóa '.$count.' chức vụ!';
    }
    // Tim chuc vu
    if(isset($_POST['id_find'])){
        $stid=oci_parse($conn, "SELECT * FROM CHUCVU WHERE ID_CV LIKE '".$_POST['id_find']."'
                                                            AND TENCV LIKE '%".$_POST['name_find']."%'
                                                            ORDER BY ID_CV ASC");
        oci_execute($stid);
        while($row=oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)){
            echo '
                <tr class="row-pos">
                    <td style="text-align: center;">
                        <input type="checkbox" name="" id="" class="choose-pos">
                    </td>
                    <td>'.$row["ID_CV"].'</td>
                    <td>'.$row["TENCV"].'</td>
                    <td>
                        <button class="btn-edit" onclick="openEdit(this)">
                            <ti class="ti-pencil"></ti>
                        </button>
                    </td>
                </tr>
            ';
        }
    }

    // Sua chuc vu
    if(isset($_POST['id_edit'])){
        $stid=oci_parse($conn, "UPDATE CHUCVU SET TENCV='".$_POST['name_edit']."' WHERE ID_CV=".$_POST['id_edit']);
        oci_execute($stid);
        echo 'Cập nhật chức vụ thành công!';
    }
?>