<?php
    require_once("../../connect/connection.php");
    require_once("../date.php");
    // tim chuong trinh
    if(isset($_POST['id_find_pro'])){
        if($_POST['date']==''){
            $date="";
        }
        else {
            $date="AND THOIGIANBATDAU LIKE DATE'".$_POST['date']."'";
        }
        if($_POST['per']==''){
            $per="";
        }
        else {
            $per="AND NGUOITHUCHIEN LIKE '%".$_POST['per']."%'";
        }
        if($_POST['unit']==''){
            $unit="";
        }
        else {
            $unit="AND DVTHUCHIEN LIKE '".$_POST['unit']."'";
        }
        $stid=oci_parse($conn, "SELECT * FROM CHUONGTRINH WHERE ID_CT LIKE '".$_POST['id_find_pro']."'
                                                            AND TENCT LIKE '%".$_POST['name']."%'
                                                            ".$date."
                                                            ".$per."
                                                            ".$unit."
                                                            ORDER BY ID_CT ASC");
        oci_execute($stid);
        while($row=oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)){
			echo '
                <tr class="row">
                    <td>
                        <input type="checkbox" class="choose">
                    </td>
                    <td>'.$row["ID_CT"].'</td>
                    <td>'.$row["TENCT"].'</td>
                    <td style="text-align: center;">'.to_date($row['THOIGIANBATDAU']).'</td>
                    <td>'.$row["NGUOITHUCHIEN"].'</td>
                    <td>'.$row["DVTHUCHIEN"].'</td>
                    <td>
                        <button class="btn-edit" onclick="showEdit(this)" title="Sửa">
                            <ti class="ti-info"></ti>
                        </button>
                    </td>
                </tr>
			';
        }
    }

    // Kiem tra ten trung nhau
	if(isset($_POST['id_check'])){
		$check=0;
		$stid=oci_parse($conn, "SELECT * FROM CHUONGTRINH");
		oci_execute($stid);
		while($row=oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)){
			if($_POST['id_check']==''){
				if($row['TENCT']==$_POST['name_check']){
					$check++;
				}
			}
			else {
				if($row['TENCT']==$_POST['name_check'] && $row['ID_CT']!=$_POST['id_check']){
					$check++;
				}
			}
		}
		echo $check;
	}

    // Them chuong trinh
    if(isset($_POST['name_insert'])){
        $name=$_POST['name_insert'];
        $date=$_POST['date'];
        $per=$_POST['per'];
        $link=$_POST['link'];
        $unit=$_POST['unit'];
        $desc=$_POST['desc'];
        $info=$_POST['info'];
        $note=$_POST['note'];
        $stid=oci_parse($conn, "INSERT INTO CHUONGTRINH(TENCT, THOIGIANBATDAU, NGUOITHUCHIEN, LINK, DVTHUCHIEN, MO_TA_CT, THONGTINCT, GHICHU) VALUES('".$name."',TO_DATE('".$date."','YYYY-MM-DD'),'".$per."','".$link."','".$unit."','".$desc."', '".$info."','".$note."')");
        oci_execute($stid);
        oci_free_statement($stid);
        oci_close($conn);
        echo 'Thêm chương trình '.$name.' thành công!';
    }
    if(isset($_POST['id_edit_pro'])){
        $id=$_POST['id_edit_pro'];
		$name=$_POST['name'];
        $date=$_POST['date'];
        $per=$_POST['per'];
        $link=$_POST['link'];
        $unit=$_POST['unit'];
        $desc=$_POST['desc'];
        $info=$_POST['info'];
        $note=$_POST['note'];
        $stid=oci_parse($conn, "UPDATE CHUONGTRINH SET TENCT='".$name."', 
                                                        THOIGIANBATDAU=TO_DATE('".$date."','YYYY-MM-DD'), 
                                                        NGUOITHUCHIEN='".$per."', 
                                                        LINK='".$link."', 
                                                        DVTHUCHIEN='".$unit."', 
                                                        MO_TA_CT='".$desc."', 
                                                        THONGTINCT='".$info."', 
                                                        GHICHU='".$note."'
                                                        WHERE ID_CT=".$id);
        oci_execute($stid);
        oci_free_statement($stid);
        oci_close($conn);
        echo 'Cập nhật chương trình '.$name.' thành công!';
	}

    // // Xoa
    if(isset($_POST["id_delete"])){
        $id=$_POST["id_delete"];
        $count=count($id);
        for($i=0; $i<$count; $i++){
            $q1=oci_parse($conn,"SELECT * FROM CHUCNANG WHERE ID_CT=".$id[$i]." ORDER BY ID_CN ASC");
            oci_execute($q1);
            while($row=oci_fetch_array($q1,OCI_ASSOC+OCI_RETURN_NULLS)){
                $q2=oci_parse($conn,"DELETE FROM PHANQUYEN_NHOM WHERE ID_CN=".$row["ID_CN"]);
                oci_execute($q2);
                $q3=oci_parse($conn,"DELETE FROM PHANQUYEN_NV WHERE ID_CN=".$row["ID_CN"]);
                oci_execute($q3);
            }
            $q4=oci_parse($conn,"DELETE FROM CHUCNANG WHERE ID_CT=".$id[$i]);
            $q5=oci_parse($conn,"DELETE FROM CHUONGTRINH WHERE ID_CT=".$id[$i]);
            oci_execute($q4);
            oci_execute($q5);
        }
        echo 'Đã xóa '.$count.' chương trình!';
    }
    

    // Thong tin chuong trinh
    if(isset($_POST['id_show'])){
        $id=$_POST['id_show'];
        $stid=oci_parse($conn, 'SELECT * FROM CHUONGTRINH WHERE ID_CT='.$id.'');
        oci_execute($stid);
        while($row=oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)){
            $a=date_create($row["THOIGIANBATDAU"]);
            date_format($a,'d-M-y');
            $date=$a->format("Y-m-d");
            echo '
                <div class="div-flex">
                    <div class="div-width">
                        <label class="div-grid">Tên Chương trình:</label>
                        <textarea id="name-pro" cols="1" rows="1" class="content">'.$row["TENCT"].'</textarea>
                    </div>
                    <div class="div-width-margin">
                        <label class="div-grid">Thời gian thực hiện:</label>
                        <input type="date" id="date-pro" class="content" value="'.$date.'">
                    </div>
                    <div class="div-width-margin">
                        <label class="div-grid">Người thực hiện:</label>
                        <textarea id="per-pro" cols="1" rows="1" class="content">'.$row["NGUOITHUCHIEN"].'</textarea>
                    </div>
                    <div class="div-width-margin">
                        <label class="div-grid">Link:</label>
                        <input type="url" id="link-pro" class="content" value="'.$row["LINK"].'">
                    </div>
                </div>
                <div class="div-flex">
                    <div class="div-50">
                        <label class="div-grid">Đơn vị thực hiện:</label>
                        <textarea id="unit-pro" cols="1" rows="2" class="content">'.$row["DVTHUCHIEN"].'</textarea>
                    </div>
                    <div class="div-50-margin">
                        <label class="div-grid">Mô tả</label>
                        <textarea id="desc-pro" cols="1" rows="2" class="content">'.$row["MO_TA_CT"].'</textarea>
                    </div>
                </div>
                <div class="div-flex">
                    <div class="div-50">
                        <label class="div-grid">Thông tin:</label>
                        <textarea id="info-pro" cols="1" rows="4" class="content">'.$row["THONGTINCT"].'</textarea>
                    </div>
                    <div class="div-50-margin">
                        <label class="div-grid">Ghi chú:</label>
                        <textarea id="note-pro" cols="1" rows="4" class="content">'.$row["GHICHU"].'</textarea>
                    </div>
                </div>
            ';
        }
    }
    // Hien chc nang
    if(isset($_POST['id_show_func'])){
        echo '
            <script>
                $(document).ready(function () {
                        $(".bi-plus-circle-fill").on("click",function () {
                            $(this).parent().children().toggle();
                            $(this).toggleClass("bi-plus-circle-fill bi-dash-circle-fill");
                            $(this).toggle();
                        });
                    });
            </script>
        ';
        function tree($conn,$id){
            echo '<ul class="ul-tree">';
                        $stid=oci_parse($conn,"SELECT * FROM CHUCNANG where ID_CN_CHA=".$id);
                        oci_execute($stid);
                        while($row=oci_fetch_array($stid,OCI_ASSOC+OCI_RETURN_NULLS)){
                            $stid1=oci_parse($conn, "SELECT * FROM CHUCNANG WHERE ID_CN_CHA=".$row['ID_CN']."");
                oci_execute($stid1);
                $i=0;
                while($row1=oci_fetch_array($stid1, OCI_ASSOC+OCI_RETURN_NULLS)){
                    $i++;
                }
                if($i!=0){
                    echo '
                    <li class="li-tree"><ti class="bi-plus-circle-fill"> <span id="'.$row["ID_CN"].'" onclick="openFunc(this.id)">'.$row['TENCN'].'</span></ti>';
                    tree($conn,$row['ID_CN']);
                    echo '</li>
                    ';
                }
                else {
                    echo '
                    <li class="li-tree"><ti class="bi-dash-circle-fill"> <span class="span-child">'.$row['TENCN'].'</span></ti>';
                    tree($conn,$row['ID_CN']);
                    echo '</li>
                    ';
                }
                        }
                    echo '</ul>';
        }
        $stid=oci_parse($conn, "SELECT * FROM CHUCNANG WHERE ID_CT=".$_POST['id_show_func']." ORDER BY ID_CN ASC");
        oci_execute($stid);
        echo '<ul class="ul-func-tree"><span id="all" class="title-tree" onclick="openFunc(this.id)">'.$_POST['name_pro_tree'].'</span>';
        while($row=oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)){
            if($row['ID_CN_CHA']==null){
            $stid1=oci_parse($conn, "SELECT * FROM CHUCNANG WHERE ID_CN_CHA=".$row['ID_CN']."");
            oci_execute($stid1);
            $i=0;
            while($row1=oci_fetch_array($stid1, OCI_ASSOC+OCI_RETURN_NULLS)){
                $i++;
            }
            if($i!=0){
                echo '
                <li class="li-tree"><ti class="bi-plus-circle-fill"> <span id="'.$row["ID_CN"].'" onclick="openFunc(this.id)">'.$row['TENCN'].'</span></ti>';
                tree($conn,$row['ID_CN']);
                echo '</li>
                ';
            }
            else {
                echo '
                <li class="li-tree"><ti class="bi-dash-circle-fill"> <span class="span-child">'.$row['TENCN'].'</span></ti>';
                tree($conn,$row['ID_CN']);
                echo '</li>
                ';
            }
            }
        }
        echo '</ul>';

    }
// BANG chuc nang
    if(isset($_POST['id_table_func'])){
        $id=$_POST['id_table_func'];
        $stid=oci_parse($conn, 'SELECT * FROM CHUCNANG WHERE ID_CT='.$id.' ORDER BY ID_CN ASC');
        oci_execute($stid);
        while($row=oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)){
            if($row["ID_CN_CHA"]==null){
                $ten_cha='Không';
            }
            else{
                $stid1=oci_parse($conn, 'SELECT * FROM CHUCNANG WHERE ID_CN='.$row["ID_CN_CHA"].'');
                oci_execute($stid1);
                while($row1=oci_fetch_array($stid1,OCI_ASSOC + OCI_RETURN_NULLS)){
                    $ten_cha=$row1["TENCN"];
                }
            }
            echo '
                <tr class="row-func">
                    <td>
                        <input type="checkbox" class="choose-func">
                    </td>
                    <td>'.$row['ID_CN'].'</td>
                    <td>'.$row['TENCN'].'</td>
                    <td>'.$ten_cha.'</td>
                    <td style="display: none;">'.$row['ID_CN_CHA'].'</td>
                    <td>
                        <button class="btn-edit" onclick="editFunc(this)" title="Sửa">
                            <ti class="ti-pencil"></ti>
                        </button>
                    </td>
                </tr>
            ';
        }
    }

    // Mo form chuc nang
    if(isset($_POST['id_insert_func'])){
        $id=$_POST['id_insert_func'];
        $stid=oci_parse($conn, 'SELECT * FROM CHUCNANG WHERE ID_CT='.$id.' ORDER BY ID_CN ASC');
        oci_execute($stid);
        while($row=oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)){
            echo '<option value="'.$row["ID_CN"].'">'.$row["TENCN"].'</option>';
        }
    }
// Hiện chuc năng khi nhan vao cay
    if(isset($_POST['id_tree'])){
        $id=$_POST['id_tree'];
        if($id=='all'){
            $stid=oci_parse($conn, "SELECT * FROM CHUCNANG ORDER BY ID_CN ASC");
        }
        else {
            $stid=oci_parse($conn, "SELECT * FROM CHUCNANG WHERE ID_CN_CHA=".$id." ORDER BY ID_CN ASC");
        }
        oci_execute($stid);
        while($row=oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)){
            if($row['ID_CN_CHA']==''){
                $ten_cha='Không';
            }
            else{
                $stid1=oci_parse($conn, "SELECT * FROM CHUCNANG WHERE ID_CN=".$row['ID_CN_CHA']);
                oci_execute($stid1);
                while($row1=oci_fetch_array($stid1, OCI_ASSOC+OCI_RETURN_NULLS)){
                    $ten_cha=$row1['TENCN'];
                }
            }
            echo '
                <tr class="row-func">
                    <td style="text-align: center;">
                        <input type="checkbox" class="choose-func">
                    </td>
                    <td>'.$row["ID_CN"].'</td>
                    <td>'.$row["TENCN"].'</td>
                    <td>'.$ten_cha.'</td>
                    <td style="display: none;">'.$row["ID_CN_CHA"].'</td>
                    <td>
                        <button class="btn-edit" onclick="editFunc(this)" title="Sửa">
                            <ti class="ti-pencil"></ti>
                        </button>
                    </td>
                </tr>
            ';
        }

    }

    // Tim chuc nang

    if(isset($_POST['id_find_func'])){
        if($_POST['parent_find_func']=='all'){
            $parent="";
        }
        else{
            if($_POST['parent_find_func']==''){
                $parent="AND ID_CN_CHA IS NULL";
            }
            else {
                $parent="AND ID_CN_CHA LIKE '".$_POST['parent_find_func']."'";
            }
        } 
        $stid=oci_parse($conn, "SELECT * FROM CHUCNANG WHERE ID_CN LIKE '".$_POST['id_find_func']."'
                                                            AND TENCN LIKE '%".$_POST['name_find_func']."%'
                                                            ".$parent."
                                                            ORDER BY ID_CN ASC");
        oci_execute($stid);
        while($row=oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)){
            if($row['ID_CN_CHA']==''){
                $ten_cha='Không';
            }
            else{
                $stid1=oci_parse($conn, "SELECT * FROM CHUCNANG WHERE ID_CN=".$row['ID_CN_CHA']);
                oci_execute($stid1);
                while($row1=oci_fetch_array($stid1, OCI_ASSOC+OCI_RETURN_NULLS)){
                    $ten_cha=$row1['TENCN'];
                }
            }
            echo '
                <tr class="row-func">
                    <td style="text-align: center;">
                        <input type="checkbox" class="choose-func">
                    </td>
                    <td>'.$row["ID_CN"].'</td>
                    <td>'.$row["TENCN"].'</td>
                    <td>'.$ten_cha.'</td>
                    <td style="display: none;">'.$row["ID_CN_CHA"].'</td>
                    <td>
                        <button class="btn-edit" onclick="editFunc(this)" title="Sửa">
                            <ti class="ti-pencil"></ti>
                        </button>
                    </td>
                </tr>
            ';
        }
    }

    // Kiem tra ten trung

    if(isset($_POST['name_func_check'])){
        $stid=oci_parse($conn, "SELECT * FROM CHUCNANG WHERE ID_CT=".$_POST['id_pro_func']);
        oci_execute($stid);
        $check=0;
        if($_POST['parent_check']==''){
            $_POST['parent_check']=null;
        }
        while($row=oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)){
            if($_POST['id_check_func']==''){
                if($row["TENCN"]==$_POST['name_func_check'] && $row['ID_CN_CHA']==$_POST['parent_check']){
                    $check++;
                }
            }
            else {
                if($row["TENCN"]==$_POST['name_func_check'] && $row['ID_CHA']==$_POST['parent_check'] && $row['ID_CN']!=$_POST['id_check_func']){
                    $check++;
                }
            }
        }
        echo $check;
    }

    // Select 

    if(isset($_POST['id_pro_select'])){
        $stid=oci_parse($conn, "SELECT * FROM CHUCNANG WHERE ID_CT=".$_POST['id_pro_select']." ORDER BY ID_CN ASC");
        oci_execute($stid);
        echo '<option value="">Không</option>';
        while($row=oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)){
            echo '
                <option value="'.$row["ID_CN"].'">'.$row["TENCN"].'</option>
            ';
        }
    }

    // find select func
    if(isset($_POST['id_find_func'])){
        $stid=oci_parse($conn, "SELECT * FROM CHUCNANG WHERE ID_CT=".$_POST['id_find_func']." ORDER BY ID_CN ASC");
        oci_execute($stid);
        echo '
            <option value="all" selected>Tất cả</option>
            <option value="">Không</option>
        ';
        while($row=oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)){
            echo '
                <option value="'.$row["ID_CN"].'">'.$row["TENCN"].'</option>
            ';
        }
    }

    if(isset($_POST['id_func_select_edit'])){
        $id_func=$_POST['id_func_select_edit'];
        $id_pro=$_POST['id_pro_edit'];
        $stid=oci_parse($conn, "SELECT * FROM CHUCNANG WHERE ID_CT=".$id_pro." ORDER BY ID_CN ASC");
        oci_execute($stid);
        while($row=oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)){
            if($row["ID_CN"]!=$id_func && $row["ID_CN_CHA"]!=$id_func){
                echo '
                    <option value="'.$row["ID_CN"].'">'.$row["TENCN"].'</option>
                ';
            }
        }
    }

    // // Them chuc nang

    if(isset($_POST['name_func_insert'])){
        $id=$_POST['id_pro_func'];
        $name=$_POST['name_func_insert'];
        $link=$_POST['link'];
        $desc=$_POST['desc'];
        $id_parent=$_POST['parent'];
        $stid=oci_parse($conn, "INSERT INTO CHUCNANG(TENCN, LINK, MO_TA_CN, ID_CN_CHA) VALUES('".$name."','".$link."','".$desc."','".$id_parent."')");
        oci_execute($stid);
        $stid1=oci_parse($conn, "SELECT * FROM CHUCNANG WHERE TENCN='".$name."'");
        oci_execute($stid1);
        while($row1=oci_fetch_array($stid1, OCI_ASSOC + OCI_RETURN_NULLS)){
            $id_cn=$row1["ID_CN"];
        }
        $stid2=oci_parse($conn, "UPDATE CHUCNANG SET ID_CT=".$id." WHERE ID_CN=".$id_cn."");
        oci_execute($stid2);
        //THEM CHUC NANG-CHUCDANH
        $stid3=oci_parse($conn, 'SELECT * FROM CHUCDANH ORDER BY ID_CD ASC');
        oci_execute($stid3);
        while($row3=oci_fetch_array($stid3,OCI_ASSOC+OCI_RETURN_NULLS)){
            $stid4=oci_parse($conn, "INSERT INTO PHANQUYEN_NV(ID_CD,ID_CN,XEM,SUA,XOA,KHONGXEM,KHONGSUA,KHONGXOA) VALUES(".$row3['ID_CD'].",".$id_cn.",0,0,0,1,1,1)");
            oci_execute($stid4);
        }
        // THEEM CHUC NANG- NHOM
        $stid5=oci_parse($conn, 'SELECT * FROM NHOM ORDER BY ID_NHOM ASC');
        oci_execute($stid5);
        while($row5=oci_fetch_array($stid5,OCI_ASSOC+OCI_RETURN_NULLS)){
            $stid6=oci_parse($conn, "INSERT INTO PHANQUYEN_NHOM(ID_NHOM,ID_CN,XEM,SUA,XOA,KHONGXEM,KHONGSUA,KHONGXOA) VALUES(".$row5['ID_NHOM'].",".$id_cn.",0,0,0,1,1,1)");
            oci_execute($stid6);
        }
        echo 'Đã thêm chức năng '.$name.' cho chương trình.';
    }

    // Xoa chuc nang
    if(isset($_POST['id_delete_func'])){
        $count=count($_POST['id_delete_func']);
        $id=$_POST['id_delete_func'];
        for($i=0; $i<$count; $i++){
            $stid1=oci_parse($conn, "DELETE PHANQUYEN_NHOM WHERE ID_CN=".$id[$i]."");
            oci_execute($stid1);
            $stid2=oci_parse($conn, "DELETE PHANQUYEN_NV WHERE ID_CN=".$id[$i]."");
            oci_execute($stid2);
            $stid3=oci_parse($conn, "DELETE CHUCNANG WHERE ID_CN=".$id[$i]."");
            oci_execute($stid3);
        }
        echo 'Đã xóa '.$count.' chức năng!';
    }
    
    if(isset($_POST['id_info_func'])){
        $id=$_POST['id_info_func'];
        $stid=oci_parse($conn, 'SELECT * FROM CHUCNANG WHERE ID_CN='.$id.'');
        oci_execute($stid);
        while($row=oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)){
            if($row["ID_CN_CHA"]==null){
                $ten_cha='Không';
            }
            else {
                $stid1=oci_parse($conn,'SELECT * FROM CHUCNANG WHERE ID_CN='.$row["ID_CN_CHA"].'');
                oci_execute($stid1);
                while($row1=oci_fetch_array($stid1,OCI_ASSOC+ OCI_RETURN_NULLS)){
                    $ten_cha=$row1["TENCN"];
                }
            }
            echo '
                <div class="div-flex">
                    <div class="div-50">
                        <label class="div-grid">Tên Chức năng:</label>
                        <input type="text" id="name-func" class="content-func" value="'.$row['TENCN'].'">
                    </div>
                    <div class="div-50-margin">
                        <label class="div-grid">Link:</label>
                        <input type="url" id="link-func" class="content-func" value="'.$row['LINK'].'">
                    </div>
                </div>
                <div class="div-flex">
                    <div class="div-50">
                        <label class="div-grid">Mô tả:</label>
                        <textarea id="desc-func" cols="1" rows="4" class="content-func">'.$row['MO_TA_CN'].'</textarea>
                    </div>
                    <div class="div-50-margin">
                        <label class="div-grid">Thuộc Chức năng:</label>
                        <select id="parent-func" class="content-func">
                            <option value="'.$row['ID_CN_CHA'].'" selected disabled>'.$ten_cha.'</option>
                            <option value="">Không</option>
                        </select>
                    </div>
                </div>
            ';
        }    
    } 
    
    if(isset($_POST['id_save_func']) && isset($_POST['name'])){
        $id=$_POST['id_save_func'];
        $name=$_POST['name'];
        $link=$_POST['link'];
        $desc=$_POST['desc'];
        $id_parent=$_POST['id_parent'];
        $stid=oci_parse($conn, "UPDATE CHUCNANG SET TENCN='".$name."', LINK='".$link."', MO_TA_CN='".$desc."', ID_CN_CHA='".$id_parent."' WHERE ID_CN=".$id."");
        oci_execute($stid);
        echo 'Cập nhật chức năng thành công!';
    }
?>