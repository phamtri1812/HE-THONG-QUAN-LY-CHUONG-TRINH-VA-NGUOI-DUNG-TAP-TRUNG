<?php require_once("../../connect/connection.php");
	session_start();
	if(!isset($_SESSION['Login'])){
		header('Location:../../index.php');
    }
    $admin=$_SESSION['Admin'];
	$id= $_SESSION['Login'];
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="shortcut icon" href="../../assets/images/logo.png">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Trang Cá Nhân</title>
        <link rel="stylesheet" href="../../assets/css/user-account.css">
        <link rel="stylesheet" href="../../assets/css/css.css">
        <link rel="stylesheet" href="../../assets/font/themify-icons/themify-icons.css">
        <script src="../../assets/js/user-acc.js"></script>
        <script>
            function logOut(){
                var result = confirm("Bạn muốn đăng xuất?");
                if(result) {
                    
                    document.logoutuser.submit();
                }
            }
            
        </script>
    </head>
    <body>
        <form name='logoutuser' action='../logout.php' method='POST'>
            <input type='hidden' name='logout' value='YES' />
        </form>
        <div id="wrapper">
            <?php
                if($admin!='Admin'){
                    include("../inc/header-user.php");
                }
                else{
                    include("../inc/header.php");
                }
            ?>
            <div id="content-account">
            <input type="hidden" id="id-edit" name="id-edit" value="<?php echo $id; ?>">
                <?php
                    $query_nv = oci_parse($conn, 'SELECT * FROM NHANVIEN WHERE ID_NV='.$id.'');
                    oci_execute($query_nv);
                    while($nv=oci_fetch_array($query_nv, OCI_ASSOC+OCI_RETURN_NULLS)) {
                        if($nv['HINHANH']!=''){
                            $link_img=$nv['HINHANH'];
                        }              
                        else {
                            $link_img='./uploads/no-img.jpg';
                        }          
                ?> 
                <div id="user-account">
                    <div class="name-user">
                        <div id="update-img">
                            <img src="<?php echo $link_img;?>" alt="Ảnh nhân viên" class="img-user" onerror="this.onerror=null;this.src='./uploads/no-img.jpg';">
                            <button class="bi-image" onclick="openInsertImg()"></button>
                        </div>
                        <p><b><?php echo $nv["HOTEN"];?></b></p>
                        ID: <p style="display: inline-block;"><?php echo $id;?></p>
                        <p>Tập đoàn Bưu chính Viễn thông Việt Nam</p>
                    </div>
                    <ul class="menu-user">
                        <li onclick="showInfo()" id="li-info" style="color: #3eaae4;">
                            <ti class="bi-info-circle-fill"></ti>
                            Hồ sơ cá nhân
                        </li>
                        <li onclick="showEditAccount()" id="li-edit">
                            <ti class="bi-pencil-square"></ti>
                            Chỉnh sửa thông tin hồ sơ
                        </li>
                        <li onclick="showChangePassAcc()" id="li-change-pass">
                            <ti class="ti-lock"></ti>
                            Đổi mật khẩu
                        </li>
                        <li onclick="logOut()">
                            <ti class="ti-power-off"></ti>
                            Đăng xuất
                        </li>
                    </ul>
                </div>
                <div id="content-user">
                    <div id="info-user">
                        <p class="info-title">HỒ SƠ NHÂN VIÊN</p>
                        <table class="table-user">    
                            <tr>
                                <td style="width: 150px;"><b>Họ và tên: </b></td>
                                <td style="width: 200px;"><?php echo $nv["HOTEN"];?></td>
                                <td style="width: 150px;"><b>Giới tính: </b></td>
                                <td style="width: 200px;"><?php echo $nv["GIOITINH"];?></td>
                            </tr>
                            <tr>
                                <td style="width: 150px;"><b>Chức vụ: </b></td>
                                <td style="width: 200px;">
                                    <?php
                                        if($nv["ID_CV"]==''){
                                            echo "Không";
                                        } 	
                                        else {
                                            $query_cv=oci_parse($conn, 'SELECT TENCV FROM CHUCVU WHERE ID_CV='.$nv["ID_CV"].'');
                                            oci_execute($query_cv);
                                            while($cv=oci_fetch_array($query_cv, OCI_ASSOC+OCI_RETURN_NULLS)) {
                                                echo $cv["TENCV"];
                                                echo ". ";
                                            }
                                        }				
                                    ?>
                                </td>
                                <td style="width: 150px;"><b>Ngày sinh: </b></td>
                                <td style="width: 200px;">
                                    <?php 
                                        $a=date_create($nv["NGAYSINH"]);
                                        date_format($a,'d-M-y');
                                        echo $a->format("d-m-Y");
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 150px;"><b>Phòng ban: </b></td>
                                <td style="width: 200px;">
                                    <?php 
                                        if($nv["ID_PB"]==''){
                                            echo "Không";
                                        }
                                        else {
                                            $query_pb=oci_parse($conn, 'SELECT TENPB FROM PHONGBAN WHERE ID_PB='.$nv["ID_PB"].'');
                                            oci_execute($query_pb);
                                            while($pb=oci_fetch_array($query_pb, OCI_ASSOC+OCI_RETURN_NULLS)) {
                                                echo $pb["TENPB"];
                                                echo ". ";
                                            }
                                        }
                                    ?>
                                </td>
                                <td style="width: 150px;"><b>Địa chỉ: </b></td>
                                <td style="width: 200px;"><?php echo $nv["DIACHI"];?></td>                                
                            </tr>
                            <tr>
                                <td style="width: 150px;"><b>Nhóm: </b></td>
                                <td style="width: 200px;">
                                    <?php 
                                        $query_n=oci_parse($conn, 'SELECT ID_NHOM FROM NHOM_NV WHERE ID_NV='.$nv["ID_NV"].'');
                                        oci_execute($query_n);
                                        while($n=oci_fetch_array($query_n, OCI_ASSOC+OCI_RETURN_NULLS)) {
                                            if($n["ID_NHOM"]==''){
                                                echo "Không.";
                                            }
                                            else{
                                                $id_n=$n["ID_NHOM"];
                                                $query=oci_parse($conn,'SELECT TENNHOM FROM NHOM WHERE ID_NHOM='.$id_n.'');
                                                oci_execute($query);
                                                while($ten_n=oci_fetch_array($query,OCI_ASSOC+OCI_RETURN_NULLS)){
                                                    echo $ten_n["TENNHOM"];
                                                    echo ". ";
                                                }
                                            }
                                        }
                                    ?>
                                </td>
                                <td style="width: 150px;"><b>Email: </b></td>
                                <td style="width: 200px;"><?php echo $nv["EMAIL"];?></td>
                            </tr>
                            <tr>
                                <td style="width: 150px;"><b>Tên Đăng Nhập: </b></td>
                                <td style="width: 200px;"><?php echo $nv["TENDN"];?></td>
                                <td style="width: 150px;"><b>Số điện thoại: </b></td>
                                <td style="width: 200px;"><?php echo $nv["SDT"];?></td>
                            </tr>
                                <td style="width: 150px;"><b>Chức danh: </b></td>
                                <td style="width: 200px;">
                                    <?php 
                                        $query_cd=oci_parse($conn, 'SELECT ID_CD FROM NV_CD WHERE ID_NV='.$nv["ID_NV"].'');
                                        oci_execute($query_cd);
                                        $i=0;
                                        while($cd=oci_fetch_array($query_cd, OCI_ASSOC+OCI_RETURN_NULLS)) {
                                            $id_cd=$cd["ID_CD"];
                                            $query=oci_parse($conn,'SELECT TENCD FROM CHUCDANH WHERE ID_CD='.$id_cd.'');
                                            oci_execute($query);
                                            while($ten_cd=oci_fetch_array($query,OCI_ASSOC+OCI_RETURN_NULLS)){
                                                echo $ten_cd["TENCD"];
                                                echo ". ";
                                                $i++;
                                            }
                                        }
                                        if($i==0){
                                            echo "Không";
                                        }
                                    ?>
                                </td>                                
                            </tr>
                        </table>
                    </div>
                    <div id="edit-user">
                        <p class="info-title">CHỈNH SỬA THÔNG TIN HỒ SƠ</p>
                        <table class="table-user">                          
                            <input type="hidden" id="id-edit" name="id-edit" value="<?php echo $id;?>">
                            <tr>
                                <td style="width: 130px;"><b>Họ và tên: </b></td>
                                <td style="width: 200px;">
                                    <input type="text" name="user-name" id="user-name" value="<?php echo $nv["HOTEN"];?>">
                                </td>
                                <td style="width: 130px;"><b>Giới tính: </b></td>
                                <td style="width: 200px;">
                                    <select id="user-gender">
                                        <option value="<?php echo $nv["GIOITINH"];?>" disabled><?php echo $nv["GIOITINH"];?></option>
                                        <option value="Nam">Nam</option>
                                        <option value="Nữ">Nữ</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 130px;"><b>Địa chỉ: </b></td>
                                <td style="width: 200px;">
                                    <input type="text" name="user-add" id="user-add" value="<?php echo $nv["DIACHI"];?>">
                                </td>                                
                                <td style="width: 130px;"><b>Ngày sinh: </b></td>
                                <td style="width: 200px;">
                                    <input type="date" name="user-date" id="user-date" value="<?php 
                                        $a=date_create($nv["NGAYSINH"]);
                                        date_format($a,'d-M-y');
                                        echo $a->format("Y-m-d");
                                    ?>">
                                </td>
                            </tr>
                            <tr>                                
                                <td style="width: 130px;"><b>Tên đăng nhập: </b></td>
                                <td style="width: 200px;">
                                    <input type="text" name="user-login" id="user-login" value="<?php echo $nv["TENDN"];?>">
                                </td>
                                <td style="width: 130px;"><b>Số điện thoại: </b></td>
                                <td style="width: 200px;">
                                    <input type="text" name="user-phone" id="user-phone" maxlength="10" value="<?php echo $nv["SDT"];?>">
                                </td>
                            </tr>
                            <tr>                      
                                <td style="width: 130px;"><b>Email: </b></td>
                                <td style="width: 200px;">
                                    <input type="email" name="user-email" id="user-email" value="<?php echo $nv["EMAIL"];?>">
                                </td>
                                <td></td>
                                <td></td>
                            </tr>
                        </table>
                        <div class="btn-save-cancel">
                            <div style="float: right;">
                                <button type="submit" class="save" onclick="saveEditAccount()">Lưu</button>
                                <button class="cancel" onclick="cancel()">Hủy</button>
                            </div>
                        </div>
                    </div>
                    <div id="change-pass">
                        <p>THAY ĐỔI MẬT KHẨU</p>
                            <table class="table-change">
                                <tr>
                                    <td style="width: 200px;"><b>Mật Khẩu Cũ:</b></td>
                                    <td style="width: 200px;">
                                        <div class="input-pass">
                                            <input id="i1-pass" type="password" maxlength="16">
                                            <div id="show-pass1" onclick="showPass1()"><ti class="ti-eye"></ti></div> 
                                            <div id="hidden-pass1" onclick="hiddenPass1()" style="display: none;"><ti class="ti-more-alt"></ti></div>                                            
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 200px;"><b>Mật Khẩu Mới:</b></td>
                                    <td style="width: 200px;">
                                        <div class="input-pass">
                                            <input id="i2-pass" type="password" maxlength="16">
                                            <div id="show-pass2" class="show-pass" onclick="showPass2()"><ti class="ti-eye"></ti></div> 
                                            <div id="hidden-pass2" onclick="hiddenPass2()" style="display: none;"><ti class="ti-more-alt"></ti></div>                                            
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 200px;"><b>Xác Nhận Mật Khẩu:</b></td>
                                    <td style="width: 200px;">
                                        <div class="input-pass">
                                            <input id="i3-pass" type="password" maxlength="16">
                                            <div id="show-pass3" onclick="showPass3()"><ti class="ti-eye"></ti></div>  
                                            <div id="hidden-pass3" onclick="hiddenPass3()" style="display: none;"><ti class="ti-more-alt"></ti></div>                                           
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <div class="btn-save-cancel">
                                <div style="float: right;">
                                    <button type="submit" onclick="saveChangePass()" class="save">Lưu</button>
                                    <button onclick="cancel()" class="cancel">Hủy</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                        }
                    ?>
                </div>
            <?php
                include("../inc/footer.php")
            ?>
        </div>
        <div id="form-insert-image">
            <div class="insert-image">
                <p>ĐỔI ẢNH HỒ SƠ</p>
                <input type="file" onchange="viewImg(this)" name="fileupload" id="fileupload">
                <div id="preview" style="text-align: center;"></div>
                <div>
                    <div class="btn-save-cancel-img">
                        <button class="btn-save-img" onclick="saveImg()">
                            <ti class="ti-check"></ti>
                        Lưu
                        </button>
                        <button class="btn-cancel-img" onclick="cancelUpload()">
                            <ti class="ti-close"></ti>
                            Hủy
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
