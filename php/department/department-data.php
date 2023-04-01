<?php
    require_once('../../connect/connection.php');
    if(isset($_POST['id_tree'])){
        $id=$_POST['id_tree'];
        if($id=='all'){
            $stid=oci_parse($conn, "SELECT * FROM PHONGBAN ORDER BY ID_PB ASC");
        }
        else {
            $stid=oci_parse($conn, "SELECT * FROM PHONGBAN WHERE ID_CHA=".$id." ORDER BY ID_PB ASC");
        }
        oci_execute($stid);
        while($row=oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)){
            if($row['ID_CHA']==''){
                $ten_cha='Không';
            }
            else{
                $stid1=oci_parse($conn, "SELECT * FROM PHONGBAN WHERE ID_PB=".$row['ID_CHA']);
                oci_execute($stid1);
                while($row1=oci_fetch_array($stid1, OCI_ASSOC+OCI_RETURN_NULLS)){
                    $ten_cha=$row1['TENPB'];
                }
            }
            echo '
                <tr class="row-dep">
                    <td style="text-align: center;">
                        <input type="checkbox" name="" class="choose-dep">
                    </td>
                    <td>'.$row["ID_PB"].'</td>
                    <td>'.$row["TENPB"].'</td>
                    <td>'.$ten_cha.'</td>
                    <td style="display: none;">'.$row["ID_CHA"].'</td>
                    <td>
                        <button class="btn-edit" onclick="editDep(this)" title="Sửa">
                            <ti class="ti-pencil"></ti>
                        </button>
                    </td>
                </tr>
            ';
        }

    }
    // Kiem tra phong ban
    if(isset($_POST['id_check_user'])){
        $count=count($_POST['id_check_user']);
        $id=$_POST['id_check_user'];
        $name=$_POST['name_check_user'];
        for($i=0; $i<$count; $i++){
            $stid=oci_parse($conn, "SELECT * FROM NHANVIEN WHERE ID_PB=".$id[$i]);
            oci_execute($stid);
            while($row=oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)){
                if($row["ID_NV"]!=''){
                    echo ' Đang có nhân viên trong '.$name[$i].'. Bạn không thể xóa!';
                    break;
                }
            }
        }
    }
// Xoa phong ban
    if(isset($_POST['id_delete'])){
        $count=count($_POST['id_delete']);
        $id=$_POST['id_delete'];
        for($i=0; $i<$count; $i++){
            $stid=oci_parse($conn, "DELETE FROM PHONGBAN WHERE ID_PB=".$id[$i]);
            oci_execute($stid);
        }
        echo 'Đã xóa '.$count.' phòng ban!';
    }
// Kiem tra ten
    if(isset($_POST['name_check'])){
        $stid=oci_parse($conn, "SELECT * FROM PHONGBAN");
        oci_execute($stid);
        $check=0;
        if($_POST['parent_check']==''){
            $_POST['parent_check']=null;
        }
        while($row=oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)){
            if($_POST['id_check']==''){
                if($row["TENPB"]==$_POST['name_check'] && $row['ID_CHA']==$_POST['parent_check']){
                    $check++;
                }
            }
            else {
                if($row["TENPB"]==$_POST['name_check'] && $row['ID_CHA']==$_POST['parent_check'] && $row['ID_PB']!=$_POST['id_check']){
                    $check++;
                }
            }
        }
        echo $check;
    }

    if(isset($_POST['name_insert'])){
        if($_POST['parent_insert']!=''){
            $stid=oci_parse($conn, "INSERT INTO PHONGBAN(TENPB, ID_CHA) VALUES('".$_POST['name_insert']."','".$_POST['parent_insert']."')");
        }
        else {
            $stid=oci_parse($conn, "INSERT INTO PHONGBAN(TENPB) VALUES('".$_POST['name_insert']."')");
        }
        oci_execute($stid);
        oci_free_statement($stid);
        oci_close($conn);
        echo 'Thêm "'.$_POST['name_insert'].'" thành công!';
    }

    if(isset($_POST['id_find'])){
        if($_POST['parent_find']=='all'){
            $parent="";
        }
        else{
            if($_POST['parent_find']==''){
                $parent="AND ID_CHA IS NULL";
            }
            else {
                $parent="AND ID_CHA LIKE '".$_POST['parent_find']."'";
            }
        } 
        $stid=oci_parse($conn, "SELECT * FROM PHONGBAN WHERE ID_PB LIKE '".$_POST['id_find']."'
                                                            AND TENPB LIKE '%".$_POST['name_find']."%'
                                                            ".$parent."
                                                            ORDER BY ID_PB ASC");
        oci_execute($stid);
        while($row=oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)){
            if($row['ID_CHA']==''){
                $ten_cha='Không';
            }
            else{
                $stid1=oci_parse($conn, "SELECT * FROM PHONGBAN WHERE ID_PB=".$row['ID_CHA']);
                oci_execute($stid1);
                while($row1=oci_fetch_array($stid1, OCI_ASSOC+OCI_RETURN_NULLS)){
                    $ten_cha=$row1['TENPB'];
                }
            }
            echo '
                <tr class="row-dep">
                    <td style="text-align: center;">
                        <input type="checkbox" name="" class="choose-dep">
                    </td>
                    <td>'.$row["ID_PB"].'</td>
                    <td>'.$row["TENPB"].'</td>
                    <td>'.$ten_cha.'</td>
                    <td style="display: none;">'.$row["ID_CHA"].'</td>
                    <td>
                        <button class="btn-edit" onclick="editDep(this)">
                            <ti class="ti-pencil"></ti>
                        </button>
                    </td>
                </tr>
            ';
        }
    }
// Su phong ban 
    if(isset($_POST['id_edit'])){
        $stid=oci_parse($conn, "UPDATE PHONGBAN SET TENPB='".$_POST['name_edit']."', ID_CHA='".$_POST['parent_edit']."' WHERE ID_PB=".$_POST['id_edit']);
        oci_execute($stid);
        echo 'Cập nhật phòng ban thành công!';
    }

// Load select edit
    if(isset($_POST['id_dep_select'])){
        $id_dep=$_POST['id_dep_select'];
        $stid=oci_parse($conn, "SELECT * FROM PHONGBAN ORDER BY ID_PB ASC");
        oci_execute($stid);
        echo '<option value="">Không</option>';
        while($row=oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)){
            if($row["ID_PB"]!=$id_dep && $row["ID_CHA"]!=$id_dep){
                echo '
                    <option value="'.$row["ID_PB"].'">'.$row["TENPB"].'</option>
                ';
            }
        }
    }
?>