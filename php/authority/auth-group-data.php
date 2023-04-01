<?php
    require_once('../../connect/connection.php');
    require_once("../date.php");
    if(isset($_POST['id_find_group']) ){
        $id=$_POST['id_find_group'];
        $name=$_POST['name'];
        $stid=oci_parse($conn, "SELECT * FROM NHOM WHERE ID_NHOM LIKE '".$id."' AND TENNHOM LIKE '%".$name."%' ORDER BY ID_NHOM ASC");
        oci_execute($stid);
        while($row=oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)){
            echo '
                <tr class="row-group">
                    <td>'.$row["ID_NHOM"].'</td>
                    <td>'.$row["TENNHOM"].'</td>
                    <td>
                        <button class="btn-insert" onclick="chooseGroupAuth(this)" title="Chọn">
                            <ti class="ti-hand-point-up"></ti>
                        </button>
                    </td>
                </tr>
            ';
        }
    }
// Tim chuong trinh
    if(isset($_POST['id_find_pro'])){
        $id=$_POST['id_find_pro'];
        $name=$_POST['name'];
        $per=$_POST['per'];
        $unit=$_POST['unit'];
        $date=$_POST['date'];
        $desc=$_POST['desc'];
        if($per=='%'){
            $per_find='';
        }
        else{
            $per_find="AND NGUOITHUCHIEN LIKE '%".$per."%'";
        }
        if($unit=='%'){
            $unit_find='';
        }
        else{
            $unit_find="AND DVTHUCHIEN LIKE '%".$unit."%'";
        }
        if($date=='%'){
            $date_find='';
        }
        else{
            $date_find="AND THOIGIANBATDAU LIKE DATE '".$date."'";
        }
        $stid=oci_parse($conn, "SELECT * FROM CHUONGTRINH WHERE ID_CT LIKE '".$id."'
        AND TENCT LIKE '%".$name."%'
        ".$per_find."
        ".$unit_find."
        ".$date_find."
        AND MO_TA_CT LIKE '%".$desc."%'
        ORDER BY ID_CT ASC");
        oci_execute($stid);
        while($row=oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)){
            echo '
                <tr class="row-pro">
                    <td>'.$row["ID_CT"].'</td>
                    <td>'.$row["TENCT"].'</td>
                    <td>'.$row["NGUOITHUCHIEN"].'</td>
                    <td>'.$row["DVTHUCHIEN"].'</td>
                    <td style="text-align: center;">'.to_date($row["THOIGIANBATDAU"]).'</td>
                    <td>'.$row["MO_TA_CT"].'</td>
                    <td>
                        <button class="btn-insert" onclick="insertGroup(this)" title="Chọn">
                            <ti class="ti-hand-point-up"></ti>
                        </button>
                    </td>
                </tr>
            ';
        }
    }
    //Hien bang phan quyen 
    if(isset($_POST['id_group']) && isset($_POST['id_pro'])){
        $id_group=$_POST['id_group'];
        $id_pro=$_POST['id_pro'];
        $stid=oci_parse($conn, "SELECT * FROM PHANQUYEN_NHOM, CHUCNANG WHERE ID_CT=".$id_pro." 
                                                                        AND ID_NHOM=".$id_group."
                                                                        AND PHANQUYEN_NHOM.ID_CN=CHUCNANG.ID_CN
                                                                        ORDER BY PHANQUYEN_NHOM.ID_CN ASC");
        oci_execute($stid);
        $i=0;
        while($row=oci_fetch_array($stid, OCI_ASSOC +OCI_RETURN_NULLS)){
            $id_cha=$row["ID_CN_CHA"];
            if($id_cha==null){
                $ten_cha='Không';
            }
            else{
                $stid1=oci_parse($conn, "SELECT * FROM CHUCNANG WHERE ID_CN=".$id_cha." ORDER BY ID_CN ASC");
                oci_execute($stid1);
                while($row1=oci_fetch_array($stid1, OCI_ASSOC + OCI_RETURN_NULLS)){
                    $ten_cha=$row1["TENCN"];
                }
            }
            $i++;
            echo '
                <tr class="row-func-auth">
                    <td>'.$row["ID_CN"].'</td>
                    <td>'.$row["TENCN"].'</td>
                    <td>'.$ten_cha.'</td>
                    <td>'.$row["MO_TA_CN"].'</td>
                ';
                if($row['XEM']==1){
                    echo '
                    <td style="text-align: center;">
                        <input type="radio" name="view'.$i.'" id="view'.$i.'" checked>
                    </td>
                    ';
                }
                else{
                    echo '
                    <td style="text-align: center;">
                        <input type="radio" name="view'.$i.'" id="view'.$i.'">
                    </td>
                    ';
                }
                if($row['SUA']==1){
                    echo '
                    <td style="text-align: center;">
                        <input type="radio" name="edit'.$i.'" id="edit'.$i.'" checked>
                    </td>
                    ';
                }
                else {
                    echo '
                    <td style="text-align: center;">
                        <input type="radio" name="edit'.$i.'" id="edit'.$i.'">
                    </td>
                    ';
                }
                if($row['XOA']==1){
                    echo '
                    <td style="text-align: center;">
                        <input type="radio" name="delete'.$i.'" id="delete'.$i.'" checked>
                    </td>
                    ';
                }
                else {
                    echo '
                    <td style="text-align: center;">
                        <input type="radio" name="delete'.$i.'" id="delete'.$i.'">
                    </td>
                    ';
                }
                if($row['KHONGXEM']==1){
                    echo '
                    <td style="text-align: center;">
                        <input type="radio" name="view'.$i.'" id="deny-view'.$i.'" checked>
                    </td>
                    ';
                }
                else {
                    echo '
                    <td style="text-align: center;">
                        <input type="radio" name="view'.$i.'" id="deny-view'.$i.'">
                    </td>
                    ';
                }
                if($row['KHONGSUA']==1){
                    echo '
                    <td style="text-align: center;">
                        <input type="radio" name="edit'.$i.'" id="deny-edit'.$i.'" checked>
                    </td>
                    ';
                }
                else {
                    echo '
                    <td style="text-align: center;">
                        <input type="radio" name="edit'.$i.'" id="deny-edit'.$i.'">
                    </td>
                    ';
                }
                if($row['KHONGXOA']==1){
                    echo '
                    <td style="text-align: center;">
                        <input type="radio" name="delete'.$i.'" id="deny-delete'.$i.'" checked>
                    </td>
                    ';
                }
                else {
                    echo '
                    <td style="text-align: center;">
                        <input type="radio" name="delete'.$i.'" id="deny-delete'.$i.'">
                    </td>
                    ';
                }
            echo '
                </tr>
            ';
        }
        
    }
// Thanh select tim kiem
    if(isset($_POST['id_pro_select'])){
        echo '
                <option value="all">Tất cả</option>
                <option value="">Không</option>
        ';
        $stid=oci_parse($conn, "SELECT * FROM CHUCNANG WHERE ID_CT=".$_POST['id_pro_select']." ORDER BY ID_CN ASC");
        oci_execute($stid);
        while($row=oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)){
            echo '
                <option value="'.$row["ID_CN"].'">'.$row["TENCN"].'</option>
            ';
        }
    }
    if(isset($_POST['id_func_find'])){
        if($_POST['id_parent']=='all'){
            $parent='';
        }
        elseif($_POST['id_parent']=='%'){
            $parent= 'AND ID_CN_CHA  IS NULL';
        }
        else{
            $parent='AND ID_CN_CHA LIKE '.$_POST["id_parent"].'';
        }
        if($_POST['desc']=='%'){
            $desc='';
        }
        else {
            $desc="AND MO_TA_CN LIKE '%".$_POST['desc']."%'";
        }
        $stid=oci_parse($conn, "SELECT * FROM PHANQUYEN_NHOM, CHUCNANG WHERE ID_CT=".$_POST["id_pro_find"]."
                                                        AND ID_NHOM=".$_POST["id_group_find"]."
                                                        AND CHUCNANG.ID_CN LIKE '".$_POST['id_func_find']."'
                                                        AND CHUCNANG.TENCN LIKE '%".$_POST['name']."%'
                                                        ".$parent."
                                                        ".$desc."
                                                        AND XEM LIKE '".$_POST['view_func']."'
                                                        AND SUA LIKE '".$_POST['edit_func']."'
                                                        AND XOA LIKE '".$_POST['delete_func']."'
                                                        AND KHONGXEM LIKE '".$_POST['deny_view']."'
                                                        AND KHONGSUA LIKE '".$_POST['deny_edit']."'
                                                        AND KHONGXOA LIKE '".$_POST['deny_delete']."'
                                                        AND PHANQUYEN_NHOM.ID_CN=CHUCNANG.ID_CN ORDER BY PHANQUYEN_NHOM.ID_CN ASC");
        oci_execute($stid);
        $i=0;
        while($row=oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)){
            $i++;
            $id_cha=$row["ID_CN_CHA"];
            if($id_cha==null){
                $ten_cha='Không';
            }
            else{
                $stid1=oci_parse($conn, "SELECT * FROM CHUCNANG WHERE ID_CN=".$id_cha." ORDER BY ID_CN ASC");
                oci_execute($stid1);
                while($row1=oci_fetch_array($stid1, OCI_ASSOC + OCI_RETURN_NULLS)){
                    $ten_cha=$row1["TENCN"];
                }
            }
            echo '
                <tr class="row-func-auth">
                    <td>'.$row["ID_CN"].'</td>
                    <td>'.$row["TENCN"].'</td>
                    <td>'.$ten_cha.'</td>
                    <td>'.$row["MO_TA_CN"].'</td>
                ';
                if($row['XEM']==1){
                    echo '
                    <td style="text-align: center;">
                        <input type="radio" name="view'.$i.'" id="view'.$i.'" checked>
                    </td>
                    ';
                }
                else{
                    echo '
                    <td style="text-align: center;">
                        <input type="radio" name="view'.$i.'" id="view'.$i.'">
                    </td>
                    ';
                }
                if($row['SUA']==1){
                    echo '
                    <td style="text-align: center;">
                        <input type="radio" name="edit'.$i.'" id="edit'.$i.'" checked>
                    </td>
                    ';
                }
                else {
                    echo '
                    <td style="text-align: center;">
                        <input type="radio" name="edit'.$i.'" id="edit'.$i.'">
                    </td>
                    ';
                }
                if($row['XOA']==1){
                    echo '
                    <td style="text-align: center;">
                        <input type="radio" name="delete'.$i.'" id="delete'.$i.'" checked>
                    </td>
                    ';
                }
                else {
                    echo '
                    <td style="text-align: center;">
                        <input type="radio" name="delete'.$i.'" id="delete'.$i.'">
                    </td>
                    ';
                }
                if($row['KHONGXEM']==1){
                    echo '
                    <td style="text-align: center;">
                        <input type="radio" name="view'.$i.'" id="deny-view'.$i.'" checked>
                    </td>
                    ';
                }
                else {
                    echo '
                    <td style="text-align: center;">
                        <input type="radio" name="view'.$i.'" id="deny-view'.$i.'">
                    </td>
                    ';
                }
                if($row['KHONGSUA']==1){
                    echo '
                    <td style="text-align: center;">
                        <input type="radio" name="edit'.$i.'" id="deny-edit'.$i.'" checked>
                    </td>
                    ';
                }
                else {
                    echo '
                    <td style="text-align: center;">
                        <input type="radio" name="edit'.$i.'" id="deny-edit'.$i.'">
                    </td>
                    ';
                }
                if($row['KHONGXOA']==1){
                    echo '
                    <td style="text-align: center;">
                        <input type="radio" name="delete'.$i.'" id="deny-delete'.$i.'" checked>
                    </td>
                    ';
                }
                else {
                    echo '
                    <td style="text-align: center;">
                        <input type="radio" name="delete'.$i.'" id="deny-delete'.$i.'">
                    </td>
                    ';
                }
            echo '
                </tr>
            ';
        }
    }

    if(isset($_POST["sql"])){
        $sql=$_POST["sql"];
        $unit=$_POST['unit'];
        $id_group=$_POST['id_nhom'];
        $id_pro=$_POST['id_ct'];
        $l=count($sql);
        for($i=0;$i<$l;$i++){
            $stid=oci_parse($conn,$sql[$i]);
            oci_execute($stid);
        }
        $stid_cn=oci_parse($conn, "SELECT * FROM CHUCNANG WHERE ID_CT=".$id_pro);
        oci_execute($stid_cn);
        while($row_cn=oci_fetch_array($stid_cn, OCI_ASSOC+OCI_RETURN_NULLS)){
            $stid_unit=oci_parse($conn, "UPDATE PHANQUYEN_NHOM SET LOAIDONVI='".$unit."' WHERE ID_NHOM=".$id_group." AND ID_CN=".$row_cn['ID_CN']);
            oci_execute($stid_unit);
        }
        echo 'Cập nhật phân quyền cho nhóm thành công!';
    }
// Cây chức năng
    if(isset($_POST['id_pro_tree'])){
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
            $stid=oci_parse($conn,"SELECT * FROM CHUCNANG where ID_CN_CHA=".$id." ORDER BY ID_CN ASC");
            oci_execute($stid);
            while($row=oci_fetch_array($stid,OCI_ASSOC+OCI_RETURN_NULLS)){
                $stid1=oci_parse($conn, "SELECT * FROM CHUCNANG WHERE ID_CN_CHA=".$row['ID_CN']." ORDER BY ID_CN ASC");
                oci_execute($stid1);
                $i=0;
                while($row1=oci_fetch_array($stid1, OCI_ASSOC+OCI_RETURN_NULLS)){
                    $i++;
                }
                if($i!=0){
                    echo '
                    <li class="li-tree"><ti class="bi-plus-circle-fill"></ti> '.$row['TENCN'].'';
                    tree($conn,$row['ID_CN']);
                    echo '</li>
                    ';
                }
                else {
                    echo '
                    <li class="li-tree"><ti class="bi-dash-circle-fill"></ti> '.$row['TENCN'].'';
                    echo '</li>
                    ';
                }
            }
            echo '</ul>';
        }
        $stid=oci_parse($conn, "SELECT * FROM CHUCNANG WHERE ID_CT=".$_POST['id_pro_tree']." ORDER BY ID_CN ASC");
        oci_execute($stid);
        $stid_ct=oci_parse($conn, "SELECT * FROM CHUONGTRINH WHERE ID_CT=".$_POST['id_pro_tree']."");
        oci_execute($stid_ct);
        while($ten_ct=oci_fetch_array($stid_ct, OCI_ASSOC+ OCI_RETURN_NULLS)){
            echo '<div class="name-pro-tree"><b>'.$ten_ct['TENCT'].'</b></div>';
        }
        echo '<ul class="ul-func-tree">';
        while($row=oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)){
            if($row['ID_CN_CHA']==null){
            $stid1=oci_parse($conn, "SELECT * FROM CHUCNANG WHERE ID_CN_CHA=".$row['ID_CN']." ORDER BY ID_CN ASC");
            oci_execute($stid1);
            $i=0;
            while($row1=oci_fetch_array($stid1, OCI_ASSOC+OCI_RETURN_NULLS)){
                $i++;
            }
            if($i!=0){
                echo '
                <li class="li-tree"><ti class="bi-plus-circle-fill"></ti> '.$row['TENCN'].'';
                tree($conn,$row['ID_CN']);
                echo '</li>
                ';
            }
            else {
                echo '
                <li class="li-tree"><ti class="bi-dash-circle-fill"></ti> '.$row['TENCN'].'';
                echo '</li>
                ';
            }
            }
        }
        echo '</ul>';
    }


    //Cho phép tất cả || Chặn tất cả
    if(isset($_POST['id_func_allow'])&& isset($_POST['id_group_allow']) ){
        $id_group=$_POST['id_group_allow'];
        $id_function=$_POST['id_func_allow'];
		$SL=count($id_function);
		$i=0;
		for($CN=0;$CN<$SL;$CN++){
			$stid=oci_parse($conn, "SELECT * FROM PHANQUYEN_NHOM, CHUCNANG WHERE CHUCNANG.ID_CN=".$id_function[$CN]." 
																			AND ID_NHOM=".$id_group."
																			AND PHANQUYEN_NHOM.ID_CN=CHUCNANG.ID_CN
																			ORDER BY PHANQUYEN_NHOM.ID_CN ASC");
			oci_execute($stid);
			
			while($row=oci_fetch_array($stid, OCI_ASSOC +OCI_RETURN_NULLS)){
				$id_cha=$row["ID_CN_CHA"];
				if($id_cha==null){
					$ten_cha='Không';
				}
				else{
					$stid1=oci_parse($conn, "SELECT * FROM CHUCNANG WHERE ID_CN=".$id_cha." ORDER BY ID_CN ASC");
					oci_execute($stid1);
					while($row1=oci_fetch_array($stid1, OCI_ASSOC + OCI_RETURN_NULLS)){
						$ten_cha=$row1["TENCN"];
					}
				}
				$i++;
				echo '
					<tr class="row-func-auth">
						<td>'.$row["ID_CN"].'</td>
						<td>'.$row["TENCN"].'</td>
						<td>'.$ten_cha.'</td>
						<td>'.$row["MO_TA_CN"].'</td>
					';
					if($row['XEM']==1){
						echo '
						<td style="text-align: center;">
							<input type="radio" name="view'.$i.'" id="view'.$i.'" checked>
						</td>
						';
					}
					else{
						echo '
						<td style="text-align: center;">
							<input type="radio" name="view'.$i.'" id="view'.$i.'">
						</td>
						';
					}
					if($row['SUA']==1){
						echo '
						<td style="text-align: center;">
							<input type="radio" name="edit'.$i.'" id="edit'.$i.'" checked>
						</td>
						';
					}
					else {
						echo '
						<td style="text-align: center;">
							<input type="radio" name="edit'.$i.'" id="edit'.$i.'">
						</td>
						';
					}
					if($row['XOA']==1){
						echo '
						<td style="text-align: center;">
							<input type="radio" name="delete'.$i.'" id="delete'.$i.'" checked>
						</td>
						';
					}
					else {
						echo '
						<td style="text-align: center;">
							<input type="radio" name="delete'.$i.'" id="delete'.$i.'">
						</td>
						';
					}
					if($row['KHONGXEM']==1){
						echo '
						<td style="text-align: center;">
							<input type="radio" name="view'.$i.'" id="deny-view'.$i.'" checked>
						</td>
						';
					}
					else {
						echo '
						<td style="text-align: center;">
							<input type="radio" name="view'.$i.'" id="deny-view'.$i.'">
						</td>
						';
					}
					if($row['KHONGSUA']==1){
						echo '
						<td style="text-align: center;">
							<input type="radio" name="edit'.$i.'" id="deny-edit'.$i.'" checked>
						</td>
						';
					}
					else {
						echo '
						<td style="text-align: center;">
							<input type="radio" name="edit'.$i.'" id="deny-edit'.$i.'">
						</td>
						';
					}
					if($row['KHONGXOA']==1){
						echo '
						<td style="text-align: center;">
							<input type="radio" name="delete'.$i.'" id="deny-delete'.$i.'" checked>
						</td>
						';
					}
					else {
						echo '
						<td style="text-align: center;">
							<input type="radio" name="delete'.$i.'" id="deny-delete'.$i.'">
						</td>
						';
					}
				echo '
					</tr>
				';
			}
		}
    }

    // Kiem tra loại đơn vị, hiển thị
    if(isset($_POST['id_pro_unit']) && isset($_POST['id_group_unit'])){
        $id_pro=$_POST['id_pro_unit'];
        $id_group=$_POST['id_group_unit'];
        $stid=oci_parse($conn, "SELECT * FROM PHANQUYEN_NHOM,CHUCNANG WHERE ID_CT=".$id_pro."
                                                    AND ID_NHOM=".$id_group."
                                                    AND PHANQUYEN_NHOM.ID_CN=CHUCNANG.ID_CN");
        oci_execute($stid);
        while($row=oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)){
            $type_unit=$row['LOAIDONVI'];
        }
        echo  $type_unit;
    }
?>