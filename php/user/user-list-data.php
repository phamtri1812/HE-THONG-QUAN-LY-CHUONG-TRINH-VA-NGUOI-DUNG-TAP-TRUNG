<?php
    require_once('../../connect/connection.php');
    require_once('../date.php');
    if(isset($_POST['name_insert']) && isset($_POST['login']) && isset($_POST['pass'])){
        $name=$_POST['name_insert'];
        $gender=$_POST['gender'];
        $date=$_POST['date'];
        $phone=$_POST['phone'];
        $email=$_POST['email'];
        $login=$_POST['login'];
        $pass=$_POST['pass'];
        $pos=$_POST['pos'];
        $dep=$_POST['dep'];
        $add=$_POST['add'];
        if($date==''){
            $query="INSERT INTO NHANVIEN(HOTEN,DIACHI,SDT,EMAIL,GIOITINH,TENDN,MATKHAU,ID_CV,ID_PB) VALUES('".$name."','".$add."','".$phone."','".$email."','".$gender."','".$login."','".$pass."','".$pos."','".$dep."')";
        }
        else {
            $query="INSERT INTO NHANVIEN(HOTEN,NGAYSINH,DIACHI,SDT,EMAIL,GIOITINH,TENDN,MATKHAU,ID_CV,ID_PB) VALUES('".$name."',TO_DATE('".$date."','YYYY-MM-DD'),'".$add."','".$phone."','".$email."','".$gender."','".$login."','".$pass."','".$pos."','".$dep."')";
        }
        $stid=oci_parse($conn, $query);
        oci_execute($stid);
        echo 'Nhân viên '.$name.' có tên tài khoản: '.$login.', mật khẩu: '.$pass.'.';
    }
    // Edit user
    if(isset($_POST['id_edit'])){
        $stid=oci_parse($conn, "SELECT * FROM NHANVIEN, CHUCVU, PHONGBAN WHERE ID_NV=".$_POST['id_edit']." 
                                            AND CHUCVU.ID_CV=NHANVIEN.ID_CV
                                            AND PHONGBAN.ID_PB=NHANVIEN.ID_PB");
        oci_execute($stid);
        while($row=oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)){
            if($row["NGAYSINH"]!=''){
                $a=date_create($row["NGAYSINH"]);
                date_format($a,'d-M-y');
                $date=$a->format("Y-m-d");
            }
            else {
                $date='';
            }
            echo '
                <div style="width: 100%;">
                    <button class="btn-reset-pass" id="btn-reset-pass" onclick="resetPass()">
                        Cài lại mật khẩu
                    </button>
                </div>
                <div class="div-flex">
                    <div style="width: 33.3333%;">
                        <label>Tên nhân viên:</label>
                        <input id="name-user" class="input-user" value="'.$row["HOTEN"].'">
                    </div>
                    <div style="width: 33.3333%; margin-left: 30px;">
                        <label>Giới tính:</label>
                        <select id="gender-user" class="input-user">
                            <option value="'.$row["GIOITINH"].'" selected disabled>'.$row["GIOITINH"].'</option>
                            <option value="Nam">Nam</option>
                            <option value="Nữ">Nữ</option>
                        </select>
                    </div>
                    <div style="width: 33.3333%; margin-left: 30px;">
                        <label>Ngày sinh:</label>
                        <input type="date" id="date-user" value="'.$date.'" class="input-user">
                    </div>
                </div>
                <div class="div-flex">
                    <div style="width: 33.3333%;">
                        <label>Số điện thoại:</label>
                        <input id="phone-user" maxlength="10" class="input-user" value="'.$row["SDT"].'">
                    </div>
                    <div style="width: 33.3333%; margin-left: 30px;">
                        <label>Email:</label>
                        <input type="email" id="email-user" class="input-user" value="'.$row["EMAIL"].'">
                    </div>
                    <div style="width: 33.3333%; margin-left: 30px;">
                        <label>Tên đăng nhập:</label>
                        <input type="text" id="login-user" class="input-user" value="'.$row["TENDN"].'">
                    </div>
                </div>
                <div class="div-flex">
                    <div style="width: 33.3333%;">
                        <label>Địa chỉ:</label>
                        <input id="add-user" class="input-user" value="'.$row["DIACHI"].'">
                    </div>
                    <div style="width: 33.3333%; margin-left: 30px;">
                        <label>Chức vụ:</label>
                        <select name="" id="pos-user" class="content-user" style="width:100%;">
                            <option value="'.$row["ID_CV"].'" selected disabled>'.$row["TENCV"].'</option>';
                                $stid1=oci_parse($conn, "SELECT * FROM CHUCVU ORDER BY ID_CV ASC");
                                oci_execute($stid1);
                                while($row1=oci_fetch_array($stid1, OCI_ASSOC + OCI_RETURN_NULLS)){
                                    echo'<option value="'.$row1["ID_CV"].'">'.$row1["TENCV"].'</option>';
                                }
                            echo '
                        </select>
                    </div>
                    <div style="width: 33.3333%; margin-left: 30px;">
                        <label>Phòng ban:</label>
                        <select id="dep-user" class="input-user" style="width:100%;">
                            <option value="'.$row["ID_PB"].'" selected disabled>'.$row["TENPB"].'</option>';
                                $stid1=oci_parse($conn, "SELECT * FROM PHONGBAN ORDER BY ID_PB ASC");
                                oci_execute($stid1);
                                while($row1=oci_fetch_array($stid1, OCI_ASSOC + OCI_RETURN_NULLS)){
                                    echo'<option value="'.$row1["ID_PB"].'">'.$row1["TENPB"].'</option>';
                                }
                            echo '
                        </select>
                    </div>   
                </div>
                <div class="div-flex">
                    <div style="width: 33.3333%;">
                        <label for="" style="width: 100%;">Thuộc nhóm:</label>
                        <div style="text-align: left;">';
                        $stid2=oci_parse($conn, "SELECT * FROM NHOM_NV, NHOM WHERE NHOM_NV.ID_NV=".$_POST['id_edit']." AND NHOM_NV.ID_NHOM=NHOM.ID_NHOM");
                        oci_execute($stid2);
                        while($row1=oci_fetch_array($stid2, OCI_ASSOC+OCI_RETURN_NULLS)){
                            echo $row1['TENNHOM'].'. ';
                        }
                    echo '
                        </div>
                    </div>
                    <div style="width: 33.3333%; margin-left: 30px;">
                        <label for="" style="width: 100%;">Chức danh:</label>
                        <div style="text-align: left;">
                        ';
                            $stid2=oci_parse($conn, "SELECT * FROM NV_CD, CHUCDANH WHERE NV_CD.ID_NV=".$_POST['id_edit']." AND NV_CD.ID_CD=CHUCDANH.ID_CD");
                            oci_execute($stid2);
                            while($row1=oci_fetch_array($stid2, OCI_ASSOC+OCI_RETURN_NULLS)){
                                echo $row1['TENCD'].'. ';
                            }
                    echo '
                        </div>
                    </div>
                    <div style="width: 33.3333%; margin-left: 30px;">
                    </div>
                </div>    
                    
            ';
        }
    }

    // Kiem tra ten dang nhap trung
    if(isset($_POST['id_check_login']) && isset($_POST['name_login'])){
        $stid=oci_parse($conn, "SELECT * FROM NHANVIEN");
        oci_execute($stid);
        $check=1;
        if($_POST['id_check_login']==''){
            while($row=oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)){
                if($row["TENDN"]==$_POST['name_login']){
                    $check++;
                }
            }
        }
        else {
            while($row=oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)){
                if($row["ID_NV"]!=$_POST['id_check_login'] && $row["TENDN"]==$_POST['name_login']){
                    $check++;
                }
            }
        }
        echo $check;
    }
    // 
    if(isset($_POST['id_save_edit'])){
        $id=$_POST['id_save_edit'];
        $name=$_POST['name'];
        $gender=$_POST['gender'];
        $date=$_POST['date'];
        $phone=$_POST['phone'];
        $email=$_POST['email'];
        $login=$_POST['login'];
        $pos=$_POST['pos'];
        $dep=$_POST['dep'];
        $add=$_POST['add'];
        if($date==''){
            $query="UPDATE NHANVIEN SET HOTEN='".$name."', DIACHI='".$add."', SDT='".$phone."', EMAIL='".$email."', GIOITINH='".$gender."', TENDN='".$login."', ID_CV='".$pos."', ID_PB='".$dep."' WHERE ID_NV='".$id."'";
        }
        else {
            $query="UPDATE NHANVIEN SET HOTEN='".$name."', NGAYSINH=TO_DATE('".$date."','yyyy-mm-dd'), DIACHI='".$add."', SDT='".$phone."', EMAIL='".$email."', GIOITINH='".$gender."', TENDN='".$login."', ID_CV='".$pos."', ID_PB='".$dep."' WHERE ID_NV='".$id."'";
        }
        $stid = oci_parse($conn,$query);
        oci_execute($stid);
        oci_free_statement($stid);
        oci_close($conn);
        echo 'Cập nhật thông tin thành công!';
    }

    if(isset($_POST['id_delete'])){
        $id=$_POST['id_delete'];
        $count=count($_POST['id_delete']);
        $check_admin=0;
        $id_cd='';
        for($i=0; $i<$count; $i++){
            $check_cd=0;
            $stid_check=oci_parse($conn, "SELECT * FROM NV_CD WHERE ID_NV=".$id[$i]);
            oci_execute($stid_check);
            while($row_check=oci_fetch_array($stid_check, OCI_ASSOC+OCI_RETURN_NULLS)){
                if($row_check['ID_CD']==1){
                    $check_cd++;
                }
            }
            if($check_cd==0){
                $stid=oci_parse($conn, "SELECT * FROM NV_CD");
                oci_execute($stid);
                while($row=oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)){
                    if($row["ID_NV"]==$id[$i]){
                        $stid1=oci_parse($conn, "DELETE FROM NV_CD WHERE ID_CD=".$row['ID_CD']." AND ID_NV=".$id[$i]);
                        oci_execute($stid1);
                    }
                }
                $stid2=oci_parse($conn, "SELECT * FROM NHOM_NV");
                oci_execute($stid2);
                while($row1=oci_fetch_array($stid2, OCI_ASSOC+OCI_RETURN_NULLS)){
                    if($row1["ID_NV"]==$id[$i]){
                        $stid3=oci_parse($conn, "DELETE FROM NHOM_NV WHERE ID_NHOM=".$row1['ID_NHOM']." AND ID_NV=".$id[$i]);
                        oci_execute($stid3);
                    }
                }
                $stid_img=oci_parse($conn, "SELECT * FROM NHANVIEN WHERE ID_NV=".$id[$i]);
                oci_execute($stid_img);
                while($row_img=oci_fetch_array($stid_img, OCI_ASSOC+OCI_RETURN_NULLS)){
                    if($row_img['HINHANH']!=null){
                        if(file_exists("../user-acc/".$row_img['HINHANH'])){
                            unlink("../user-acc/".$row_img['HINHANH']);
                        }
                    }
                }
                $stid4=oci_parse($conn, "DELETE FROM NHANVIEN WHERE ID_NV=".$id[$i]);
                oci_execute($stid4);
            }
            else {
                $check_admin++;
            }
        }
        if($check_admin!=0){
            echo "Đã xóa ".($count-$check_admin)." nhân viên. Bạn không thể xóa những nhân viên có chức danh 'Quản trị'!";
        }
        else {
            echo "Đã xóa ".$count." nhân viên.";
        }
    }

    if(isset($_POST['id_find'])){
        $id_find=$_POST['id_find'];
        $name_find=$_POST['name_find'];
        $date_find=$_POST['date_find'];
        $gender_find=$_POST['gender_find'];
        $add_find=$_POST['add_find'];
        $dep_find=$_POST['dep_find'];
        $pos_find=$_POST['pos_find'];
        if($date_find=='%'){
            $date_find='';
        }
        else{
            $date_find="AND NGAYSINH LIKE DATE '".$date_find."'";
        }
        if($add_find=="%"){
            $add_find="";
        }
        else{
            $add_find="AND DIACHI LIKE '%".$add_find."%'";
        }
        if($dep_find=="%"){
            $dep_find="";
        }
        else{
            $dep_find="AND ID_PB LIKE '".$dep_find."'";
        }
        if($pos_find=="%"){
            $pos_find="";
        }
        else{
            $pos_find="AND ID_CV LIKE '".$pos_find."'";
        }
        $stid=oci_parse($conn, "SELECT * FROM NHANVIEN WHERE ID_NV LIKE '".$id_find."'
                                            AND HOTEN LIKE '%".$name_find."%'
                                            ".$date_find."
                                            AND GIOITINH LIKE '%".$gender_find."%'
                                            ".$add_find."
                                            ".$dep_find."
                                            ".$pos_find."
                                            ORDER BY ID_NV ASC");
        oci_execute($stid);
        while($row=oci_fetch_array($stid, OCI_ASSOC +  OCI_RETURN_NULLS)){
            if($row['ID_PB']!=''){
                $stid1=oci_parse($conn, "SELECT * FROM PHONGBAN WHERE ID_PB=".$row['ID_PB']);
                oci_execute($stid1);
                while($row1=oci_fetch_array($stid1, OCI_ASSOC+ OCI_RETURN_NULLS)){
                    $ten_pb=$row1['TENPB'];
                }
            }
            else{
                $ten_pb='Không';
            }
            if($row['ID_CV']!=''){
                $stid2=oci_parse($conn, "SELECT * FROM CHUCVU WHERE ID_CV=".$row['ID_CV']);
                oci_execute($stid2);
                while($row2=oci_fetch_array($stid2, OCI_ASSOC+ OCI_RETURN_NULLS)){
                    $ten_cv=$row2['TENCV'];
                }
            }
            else{
                $ten_cv='Không';
            }
            $date=$row['NGAYSINH'];
            if($date!=''){
                $a=date_create($date);
                date_format($a,'d-M-y');
                $date=$a->format("d-m-Y");
            }
            echo '
                <tr class="row-user">
                    <td><input type="checkbox" name="" class="choose-user"></td>
                    <td>'.$row["ID_NV"].'</td>
                    <td>'.$row["HOTEN"].'</td>
                    <td style="text-align: center;">'.$date.'</td>
                    <td style="text-align: center;">'.$row["GIOITINH"].'</td>
                    <td>'.$row["DIACHI"].'</td>
                    <td>'.$ten_pb.'</td>
                    <td>'.$ten_cv.'</td>
                    <td style="text-align: center;">
                        <button class="btn-edit" title="Sửa" onclick="openEdit(this)">
                            <ti class="ti-pencil"></ti>
                        </button>
                    </td>
                    <td>
                        <button class="btn-edit" title="Quyền" onclick="authUser(this)">
                            <ti class="ti-key"></ti>
                        </button>
                    </td>
                </tr>
            ';
        }
    }

    if(isset($_POST['pass_update'])){
        $id=$_POST['id_user'];
        $pass=$_POST['pass_update'];
        $name=$_POST['name_user'];
        $stid=oci_parse($conn, "UPDATE NHANVIEN SET MATKHAU='".$pass."' WHERE ID_NV=".$id);
        oci_execute($stid);
        echo 'Mật khẩu mới của nhân viên '.$name.' là: '.$pass.'.';
    }
// Hiện quyền của chương trình
    if(isset($_POST['id_pro'])){
        $id_pro=$_POST['id_pro'];
        $id_user=$_POST['id_user'];
        $stid_cn=oci_parse($conn, "SELECT * FROM CHUCNANG WHERE ID_CT=".$id_pro." ORDER BY ID_CN ASC");
        oci_execute($stid_cn);
        while($row_cn=oci_fetch_array($stid_cn, OCI_ASSOC + OCI_RETURN_NULLS)){
            $view=1;
            $edit=1;
            $delete=1;
            $stid_nhom=oci_parse($conn, "SELECT * FROM NHOM_NV WHERE ID_NV=".$id_user." ORDER BY ID_NHOM ASC");
            oci_execute($stid_nhom);
            while($row_nhom=oci_fetch_array($stid_nhom, OCI_ASSOC+OCI_RETURN_NULLS)){
                $stid_quyen_nhom=oci_parse($conn, "SELECT * FROM PHANQUYEN_NHOM WHERE ID_NHOM=".$row_nhom['ID_NHOM']." 
                                                                            AND ID_CN=".$row_cn['ID_CN']."");
                oci_execute($stid_quyen_nhom);
                while($row_quyen_nhom=oci_fetch_array($stid_quyen_nhom, OCI_ASSOC+OCI_RETURN_NULLS)){
                    while($row_quyen_nhom['KHONGXEM']==1){
                        $view=0;
                        break;
                    }
                    while($row_quyen_nhom['KHONGSUA']==1){
                        $edit=0;
                        break;
                    }
                    while($row_quyen_nhom['KHONGXOA']==1){
                        $delete=0;
                        break;
                    }
                }
            }

            $stid_cd=oci_parse($conn, "SELECT * FROM NV_CD WHERE ID_NV=".$id_user." ORDER BY ID_CD ASC");
            oci_execute($stid_cd);
            while($row_cd=oci_fetch_array($stid_cd, OCI_ASSOC+OCI_RETURN_NULLS)){
                $stid_quyen_cd=oci_parse($conn, "SELECT * FROM PHANQUYEN_NV WHERE ID_CD=".$row_cd['ID_CD']." 
                                                                            AND ID_CN=".$row_cn['ID_CN']."");
                oci_execute($stid_quyen_cd);
                while($row_quyen_cd=oci_fetch_array($stid_quyen_cd, OCI_ASSOC+OCI_RETURN_NULLS)){
                    while($row_quyen_cd['KHONGXEM']==1){
                        $view=0;
                        break;
                    }
                    while($row_quyen_cd['KHONGSUA']==1){
                        $edit=0;
                        break;
                    }
                    while($row_quyen_cd['KHONGXOA']==1){
                        $delete=0;
                        break;
                    }
                }
            }

            echo '
                <tr class="row">
                    <td>'.$row_cn["ID_CN"].'</td>
                    <td>'.$row_cn["TENCN"].'</td>
                ';
            if($view==0 && $edit==0 && $delete==0){
                echo '<td><i>Không cho phép truy cập<i></td>';
            }
            else {
                if($row_cn["LINK"]==''){
                    echo '<td><i>Không có<i></td>';
                }
                else{
                    echo '<td><a href="'.$row_cn["LINK"].'" target="_blank">'.$row_cn["LINK"].'</a></td>';
                }
            }
            if($view==1){
                echo '<td style="text-align: center;"><ti class="ti-check"></ti></td>';
            }
            else {
                echo '<td></td>';
            }
            if($edit==1){
                echo '<td style="text-align: center;"><ti class="ti-check"></ti></td>';
            }
            else {
                echo '<td></td>';
            }
            if($delete==1){
                echo '<td style="text-align: center;"><ti class="ti-check"></ti></td>';
            }
            else {
                echo '<td></td>';
            }
            // chặn
            if($view==1){
                echo '<td></td>';
            }
            else {
                echo '<td style="text-align: center;"><ti class="ti-close"></ti></td>';
            }
            if($edit==1){
                echo '<td></td>';
            }
            else {
                echo '<td style="text-align: center;"><ti class="ti-close"></ti></td>';
            }
            if($delete==1){
                echo '<td></td>';
            }
            else {
                echo '<td style="text-align: center;"><ti class="ti-close"></ti></td>';
            }
            echo '
                </tr>
            ';
        }
    }

    // Hiện quyền của chức năng được chọn
    if(isset($_POST['id_func'])){
        $id_func=$_POST['id_func'];
        $id_user=$_POST['id_user'];
        $stid_cn=oci_parse($conn, "SELECT * FROM CHUCNANG WHERE ID_CN=".$id_func." ORDER BY ID_CN ASC");
        oci_execute($stid_cn);
        while($row_cn=oci_fetch_array($stid_cn, OCI_ASSOC + OCI_RETURN_NULLS)){
            $view=1;
            $edit=1;
            $delete=1;
            $stid_nhom=oci_parse($conn, "SELECT * FROM NHOM_NV WHERE ID_NV=".$id_user." ORDER BY ID_NHOM ASC");
            oci_execute($stid_nhom);
            while($row_nhom=oci_fetch_array($stid_nhom, OCI_ASSOC+OCI_RETURN_NULLS)){
                $stid_quyen_nhom=oci_parse($conn, "SELECT * FROM PHANQUYEN_NHOM WHERE ID_NHOM=".$row_nhom['ID_NHOM']." 
                                                                            AND ID_CN=".$row_cn['ID_CN']."");
                oci_execute($stid_quyen_nhom);
                while($row_quyen_nhom=oci_fetch_array($stid_quyen_nhom, OCI_ASSOC+OCI_RETURN_NULLS)){
                    while($row_quyen_nhom['KHONGXEM']==1){
                        $view=0;
                        break;
                    }
                    while($row_quyen_nhom['KHONGSUA']==1){
                        $edit=0;
                        break;
                    }
                    while($row_quyen_nhom['KHONGXOA']==1){
                        $delete=0;
                        break;
                    }
                }
            }

            $stid_cd=oci_parse($conn, "SELECT * FROM NV_CD WHERE ID_NV=".$id_user." ORDER BY ID_CD ASC");
            oci_execute($stid_cd);
            while($row_cd=oci_fetch_array($stid_cd, OCI_ASSOC+OCI_RETURN_NULLS)){
                $stid_quyen_cd=oci_parse($conn, "SELECT * FROM PHANQUYEN_NV WHERE ID_CD=".$row_cd['ID_CD']." 
                                                                            AND ID_CN=".$row_cn['ID_CN']."");
                oci_execute($stid_quyen_cd);
                while($row_quyen_cd=oci_fetch_array($stid_quyen_cd, OCI_ASSOC+OCI_RETURN_NULLS)){
                    while($row_quyen_cd['KHONGXEM']==1){
                        $view=0;
                        break;
                    }
                    while($row_quyen_cd['KHONGSUA']==1){
                        $edit=0;
                        break;
                    }
                    while($row_quyen_cd['KHONGXOA']==1){
                        $delete=0;
                        break;
                    }
                }
            }

            echo '
                <tr class="row">
                    <td>'.$row_cn["ID_CN"].'</td>
                    <td>'.$row_cn["TENCN"].'</td>
                ';
            if($view==0 && $edit==0 && $delete==0){
                echo '<td><i>Không cho phép truy cập<i></td>';
            }
            else {
                if($row_cn["LINK"]==''){
                    echo '<td><i>Không có<i></td>';
                }
                else{
                    echo '<td><a href="'.$row_cn["LINK"].'" target="_blank">'.$row_cn["LINK"].'</a></td>';
                }
            }
            if($view==1){
                echo '<td style="text-align: center;"><ti class="ti-check"></ti></td>';
            }
            else {
                echo '<td></td>';
            }
            if($edit==1){
                echo '<td style="text-align: center;"><ti class="ti-check"></ti></td>';
            }
            else {
                echo '<td></td>';
            }
            if($delete==1){
                echo '<td style="text-align: center;"><ti class="ti-check"></ti></td>';
            }
            else {
                echo '<td></td>';
            }
            // chặn
            if($view==1){
                echo '<td></td>';
            }
            else {
                echo '<td style="text-align: center;"><ti class="ti-close"></ti></td>';
            }
            if($edit==1){
                echo '<td></td>';
            }
            else {
                echo '<td style="text-align: center;"><ti class="ti-close"></ti></td>';
            }
            if($delete==1){
                echo '<td></td>';
            }
            else {
                echo '<td style="text-align: center;"><ti class="ti-close"></ti></td>';
            }
            echo '
                </tr>
            ';
        }
    }
    if(isset($_POST['id_user_auth'])){
        $id=$_POST['id_user_auth'];
        $stid=oci_parse($conn, "SELECT * FROM NV_CD WHERE ID_NV=".$id);
        oci_execute($stid);
        $check=0;
        while($row=oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)){
            if($row['ID_CD']!=''){
                $check=1;
                break;
            }
        }
        $stid1=oci_parse($conn, "SELECT * FROM NHOM_NV WHERE ID_NV=".$id);
        oci_execute($stid1);
        while($row1=oci_fetch_array($stid1, OCI_ASSOC+OCI_RETURN_NULLS)){
            if($row1['ID_NHOM']!=''){
                $check=1;
                break;
            }
        }
        echo $check;
    }
?>