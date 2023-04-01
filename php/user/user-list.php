<?php 
    require_once("../../connect/connection.php"); 
	session_start();
	if(!isset($_SESSION['Login'])){
		header('Location:../../index.php');
    }
    else {
        if($_SESSION['Admin']!='Admin'){
            header('Location:../user-acc/user-account.php');
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="shortcut icon" href="../../assets/images/logo.png">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Quản Lý Nhân Viên</title>
        <link rel="stylesheet" href="../../assets/css/css.css">
        <link rel="stylesheet" href="../../assets/css/user-list.css">
        <link rel="stylesheet" href="../../assets/font/themify-icons/themify-icons.css">
        <script src="../../assets/js/list-user.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
        <script>
            $(document).ready(function () {
                    $(".bi-plus-circle-fill").on("click",function () {
                        $(this).parent().children().toggle();
                        $(this).toggleClass("bi-plus-circle-fill bi-dash-circle-fill");
                        $(this).toggle();
                    });
                });
        </script>
    </head>
    <body>
        <center>
            <div id="wrapper">
                <?php
                    include("../inc/header.php")
                ?>
                <div id="content">
                    <?php 
                        require_once("../../connect/connection.php"); 
                        require_once("../../php/date.php");
                    ?>
                    <p>DANH SÁCH NHÂN VIÊN</p>                    
                    <div class="div-btn-table">
                        <div>
                            <div class="btn-insert-delete">
                                <button class="btn-insert" onclick="openInsert()">
                                    <ti class="ti-plus"></ti>
                                    Thêm
                                </button>
                                <button class="btn-delete" onclick="deleteUser()">
                                    <ti class="ti-eraser"></ti>
                                    Xóa
                                </button>
                            </div>
                        </div>
                        <div class="div-table">
                            <table class="table-user-list" id="UserTable">
                                <tr>
                                    <th style="width: 40px;"><input type="checkbox" id="choose-all" onchange="chooseAll()"></th>
                                    <th style="width: 70px;">ID</th>
                                    <th style="width: 200px;">TÊN NHÂN VIÊN</th>
                                    <th style="width: 150px;">NGÀY SINH</th>
                                    <th style="width: 70px;">GIỚI TÍNH</th>
                                    <th >ĐỊA CHỈ</th>
                                    <th style="width: 150px;">PHÒNG BAN</th>
                                    <th style="width: 150px;">CHỨC VỤ</th>
                                    <th style="width: 50px;">SỬA</th>
                                    <th style="width: 50px;">QUYỀN</th>
                                </tr>
                                <tr class="row-find">
                                    <td></td>
                                    <td><input type="text" id="find-id"></td>
                                    <td><input type="text" id="find-name"></td>
                                    <td><input type="date" id="find-date" value=""></td>
                                    <td>
                                        <select id="find-gender">
                                            <option value="">Tất cả</option>
                                            <option value="Nam">Nam</option>
                                            <option value="Nữ">Nữ</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" id="find-add">
                                    </td>
                                    <td>
                                        <select id="find-dep">
                                            <option value="">Tất cả</option>
                                            <?php
                                                $stid=oci_parse($conn, "SELECT * FROM PHONGBAN ORDER BY ID_PB ASC");
                                                oci_execute($stid);
                                                while($row=oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)){
                                            ?>
                                            <option value="<?php echo $row['ID_PB'];?>"><?php echo $row['TENPB'];?></option>
                                            <?php
                                                }
                                            ?>
                                        </select>
                                    </td>
                                    <td>
                                        <select id="find-pos">
                                            <option value="">Tất cả</option>
                                            <?php
                                                $stid=oci_parse($conn, "SELECT * FROM CHUCVU ORDER BY ID_CV ASC");
                                                oci_execute($stid);
                                                while($row=oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)){
                                            ?>
                                            <option value="<?php echo $row['ID_CV'];?>"><?php echo $row['TENCV'];?></option>
                                            <?php
                                                }
                                            ?>
                                        </select>
                                    </td>
                                    <td colspan="2" style="text-align: center;">
                                        <button class="btn-find" title="Tìm" onclick="findUser()">
                                            <ti class="ti-search"></ti>
                                        </button>
                                    </td>
                                </tr>
                                <?php
                                    $stid=oci_parse($conn, "SELECT * FROM NHANVIEN ORDER BY ID_NV ASC");
                                    oci_execute($stid);
                                    while($row=oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)){
                                ?>
                                <tr class="row-user">
                                    <td><input type="checkbox" class="choose-user"></td>
                                    <td><?php echo $row["ID_NV"];?></td>
                                    <td><?php echo $row["HOTEN"];?></td>
                                    <td style="text-align: center;">
                                        <?php 
                                            echo to_date($row["NGAYSINH"]);
                                        ?>
                                    </td>
                                    <td style="text-align: center;"><?php echo $row["GIOITINH"];?></td>
                                    <td><?php echo $row["DIACHI"];?></td>
                                    <td>
                                        <?php
                                            $stid1=oci_parse($conn, "SELECT * FROM PHONGBAN WHERE ID_PB=".$row['ID_PB']);
                                            oci_execute($stid1);
                                            while($row1=oci_fetch_array($stid1, OCI_ASSOC+OCI_RETURN_NULLS)){
                                                echo $row1['TENPB'];
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            $stid1=oci_parse($conn, "SELECT * FROM CHUCVU WHERE ID_CV=".$row['ID_CV']);
                                            oci_execute($stid1);
                                            while($row1=oci_fetch_array($stid1, OCI_ASSOC+OCI_RETURN_NULLS)){
                                                echo $row1['TENCV'];
                                            }
                                        ?>
                                    </td>
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
                                <?php
                                    }
                                ?>
                            </table>
                        </div>
                    </div>
                </div>
                <?php
                    include("../inc/footer.php");
                ?>
            </div>
            <div id="div-insert-edit">
                <div class="form-insert-edit">
                    <button class="btn-close" onclick="closeForm()">
                        <ti class="ti-close"></ti>
                    </button>
                    <input type="hidden" id="id-edit">
                    <p id="title-insert" class="title-insert"></p>
                    <div id="input-insert-edit">
                        <div class="div-flex">
                            <div style="width: 33.3333%;">
                                <label>Tên nhân viên:</label>
                                <input id="name-user" class="input-user">
                            </div>
                            <div style="width: 33.3333%; margin-left: 30px;">
                                <label>Giới tính:</label>
                                <select id="gender-user" class="input-user">
                                    <option value="Nam">Nam</option>
                                    <option value="Nữ">Nữ</option>
                                </select>
                            </div>
                            <div style="width: 33.3333%; margin-left: 30px;">
                                <label>Ngày sinh:</label>
                                <input type="date" id="date-user" value="" class="input-user">
                            </div>
                        </div>
                        <div class="div-flex">
                            <div style="width: 33.3333%;">
                                <label>Số điện thoại:</label>
                                <input id="phone-user" maxlength="10" class="input-user">
                            </div>
                            <div style="width: 33.3333%; margin-left: 30px;">
                                <label>Email:</label>
                                <input type="email" id="email-user" class="input-user">
                            </div>
                            <div style="width: 33.3333%; margin-left: 30px;">
                                <label>Tên đăng nhập:</label>
                                <input type="text" id="login-user" class="input-user">
                            </div>
                        </div>
                        <div class="div-flex">
                            <div style="width: 33.3333%;">
                                <label>Địa chỉ:</label>
                                <input id="add-user" class="input-user">
                            </div>
                            <div style="width: 33.3333%; margin-left: 30px;">
                                <label>Chức vụ:</label>
                                <select id="pos-user" class="input-user">
                                    <option value="" disabled selected>Chọn</option>
                                    <?php
                                        $stid=oci_parse($conn, "SELECT * FROM CHUCVU ORDER BY ID_CV ASC");
                                        oci_execute($stid);
                                        while($row=oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)){
                                    ?>
                                    <option value="<?php echo $row["ID_CV"];?>"><?php echo $row["TENCV"];?></option>
                                    <?php
                                        }
                                    ?>
                                </select>
                            </div>
                            <div style="width: 33.3333%; margin-left: 30px;">
                                <label>Phòng ban:</label>
                                <select id="dep-user" class="input-user">
                                    <option value="" disabled selected>Chọn</option>
                                    <?php
                                        $stid=oci_parse($conn, "SELECT * FROM PHONGBAN ORDER BY ID_PB ASC");
                                        oci_execute($stid);
                                        while($row=oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)){
                                    ?>
                                    <option value="<?php echo $row["ID_PB"];?>"><?php echo $row["TENPB"];?></option>
                                    <?php
                                        }
                                    ?>
                                </select>
                            </div>    
                        </div>
                    </div>
                    <div >
                        <div class="btn-save-cancel">
                            <button class="btn-save-insert" id="btn-save-insert" onclick="insertUser()">
                                <ti class="ti-check"></ti>
                                Thêm
                            </button>
                            <button class="btn-save-edit" id="btn-save-edit" onclick="editUser()">
                                <ti class="ti-check"></ti>
                                Lưu
                            </button>
                            <button class="btn-cancel" onclick="cancel()">
                                <ti class="ti-close"></ti>
                                Hủy
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Quyền nhân viên -->
            <div id="div-auth">
                <div class="form-insert-edit">
                    <button class="btn-close" onclick="closeForm()">
                        <ti class="ti-close"></ti>
                    </button>
                    <p id="title-auth" class="title-insert">Quyền của nhân viên</p>
                    <div class="div-flex">
                        <div class="tree" style="width: 30%;">
                            <?php
                                function tree($conn,$id){
                                    echo '<ul class="ul-tree">';
                                    $stid=oci_parse($conn,"SELECT * FROM CHUCNANG where ID_CN_CHA=".$id." ORDER BY ID_CN ASC");
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
                                            <li class="li-tree"><ti class="bi-plus-circle-fill"><span id="func-'.$row["ID_CN"].'" onclick="openFunc(this.id)"> '.$row['TENCN'].'</span></ti>';
                                            tree($conn,$row['ID_CN']);
                                            echo '</li>
                                            ';
                                        }
                                        else {
                                            echo '
                                            <li class="li-tree"><ti class="bi-dash-circle-fill"><span id="func-'.$row["ID_CN"].'" onclick="openFunc(this.id)"> '.$row['TENCN'].'</span></ti>';
                                            echo '</li>
                                            ';
                                        }
                                    }
                                    echo '</ul>';
                                }
                                $stid=oci_parse($conn, "SELECT * FROM CHUONGTRINH ORDER BY ID_CT ASC");
                                oci_execute($stid);
                                echo '<ul class="ul-dep-tree">Danh sách chương trình';
                                while($row=oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)){
                                    $stid_cn=oci_parse($conn, "SELECT * FROM CHUCNANG WHERE ID_CT=".$row['ID_CT']);
                                    oci_execute($stid_cn);
                                    $cn=0;
                                    while($row_cn=oci_fetch_array($stid_cn, OCI_ASSOC + OCI_RETURN_NULLS)){
                                        $cn++;
                                    }
                                    if($cn!=0){
                                        echo '
                                        <li class="li-tree"><ti class="bi-plus-circle-fill"><span id="pro-'.$row["ID_CT"].'" value="'.$row["ID_CT"].'" onclick="openPro(this.id)"> '.$row['TENCT'].'</span></ti>';
                                            echo '<ul class="ul-tree">';
                                            $stid_cn1=oci_parse($conn, "SELECT * FROM CHUCNANG WHERE ID_CT=".$row['ID_CT']." ORDER BY ID_CN ASC");
                                            oci_execute($stid_cn1);
                                            while($row_cn1=oci_fetch_array($stid_cn1, OCI_ASSOC+OCI_RETURN_NULLS)){
                                                if($row_cn1['ID_CN_CHA']==null){
                                                    $stid_cn2=oci_parse($conn, "SELECT * FROM CHUCNANG WHERE ID_CN_CHA=".$row_cn1['ID_CN']."");
                                                    oci_execute($stid_cn2);
                                                    $i=0;
                                                    while($row_cn2=oci_fetch_array($stid_cn2, OCI_ASSOC+OCI_RETURN_NULLS)){
                                                        $i++;
                                                    }
                                                    if($i!=0){
                                                        echo '
                                                        <li class="li-tree"><ti class="bi-plus-circle-fill"><span id="func-'.$row_cn1["ID_CN"].'" onclick="openFunc(this.id)"> '.$row_cn1['TENCN'].'</span></ti>';
                                                        tree($conn,$row_cn1['ID_CN']);
                                                        echo '
                                                            </li>
                                                        ';
                                                    }
                                                    else {
                                                        echo '
                                                            <li class="li-tree"><ti class="bi-dash-circle-fill"><span id="func-'.$row_cn1["ID_CN"].'" onclick="openFunc(this.id)"> '.$row_cn1['TENCN'].'</span></ti></li>
                                                        ';
                                                    }
                                                }
                                            }
                                            echo '</ul>';
                                        echo '</li>
                                        ';
                                    }
                                    else{
                                        echo '
                                        <li class="li-tree"><ti class="bi-dash-circle-fill"><span class="span-child"> '.$row['TENCT'].'</span></ti>';
                                        echo '</li>
                                        ';
                                    }
                                }
                                echo '</ul>';
                            ?>
                        </div>
                        <div class="div-table-func">
                            <input type="hidden" id="id-user">
                            <p class="title-pro" id="title-pro">Bảng Quyền</p>
                            <div class="div-table">
                                <table id="table-func">
                                    <tr>
                                        <th style="width: 70px;">ID</th>
                                        <th style="width: 200px;">Tên Chức năng</th>
                                        <th style="width: 150px;">LINK</th>
                                        <th style="width: 60px;">Xem</th>
                                        <th style="width: 60px;">Sửa</th>
                                        <th style="width: 60px;">Xóa</th>
                                        <th style="width: 60px;">Chặn Xem</th>
                                        <th style="width: 60px;">Chặn Sửa</th>
                                        <th style="width: 60px;">Chặn Xóa</th>
                                    </tr>
                                    <tr class="row">
                                        <td colspan="9" style="text-align: center;"><i>Vui lòng chọn một chương trìn hoặc một chức năng để xem quyền!</i></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </center>
    </body>
</html>
            