<?php 
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
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phân Quyền Nhóm Nhân Viên</title>
    <link rel="stylesheet" href="../../assets/css/css.css">
    <link rel="stylesheet" href="../../assets/css/authority-user.css">
    <link rel="stylesheet" href="../../assets/font/themify-icons/themify-icons.css">
    <script src="../../assets/js/auth-group.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
</head>
<body>
    <div id="wrapper">
        <?php 
            include("../inc/header.php");
        ?>
        <div id="content">
            <?php 
                require_once("../../connect/connection.php"); 
                require_once("../date.php");
            ?>
            <p>PHÂN QUYỀN THEO NHÓM NHÂN VIÊN</p>
            <div class="choose-pro">
                <p>Chọn một nhóm và một chương trình để thực hiện phân quyền</p>
                <div class="content-choose-pro">
                    <div style="display: grid; width: 40%;">
                        <label for="" class="title">Nhóm nhân viên</label>
                        <button class="btn-edit" onclick="chooseGroup()">
                            <ti class="ti-hand-point-up"></ti>
                            Chọn nhóm nhân viên
                        </button>
                        <input type="hidden" id="id-group-auth">
                        <textarea id="name-group" cols="1" rows="3" class="content" readonly></textarea>
                    </div>
                    <div style="display: grid; width: 40%; margin-left: 40px;">
                        <label for="" class="title">Chương trình</label>
                        <button class="btn-edit" onclick="choosePro()">
                            <ti class="ti-hand-point-up"></ti>
                            Chọn chương trình
                        </button>
                        <input type="hidden" id="id-pro-auth">
                        <textarea id="name-pro" cols="1" rows="3" class="content" readonly></textarea>
                    </div>
                    <div style="display: grid; width: 20%; margin-left: 40px;">
                        <div class="btn-show">
                            <button class="btn-edit" onclick="showTreeFunc()">
                                <ti class="ti-view-list"></ti>
                                Cây chức năng CT
                            </button>
                            <button class="btn-edit" onclick="showAuth()">
                                <ti class="ti-pencil-alt"></ti>
                                Hiện bảng phân quyền
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div id="form-authority">
                <div class="div-btn-save-cancel">
                    <div style="width: 50%; position: relative;">
                        <div class="div-check-box">
                            <input type="checkbox" id="checkbox-allow" onchange="checkAllow()"> Cho phép tất cả
                            <input type="checkbox" id="checkbox-block" onchange="checkBlock()"> Chặn tất cả
                        </div>
                    </div>
                    <div style="width: 50%;">
                        <div class="btn-save-cancel">
                            <select name="" id="unit-type" style="margin: 0;">
                                <option value="" selected>Chọn loại đơn vị</option>
                                <option value="Mọi đơn vị">Mọi đơn vị</option>
                                <option value="Đơn vị hiện tại">Đơn vị hiện tại</option>
                                <option value="Cá nhân">Cá nhân</option>
                            </select>
                            <button class="btn-find" onclick="findFunc()">
                                <ti class="ti-search"></ti>
                                Tìm
                            </button>
                            <button class="btn-insert" onclick="saveAuth()">
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
                <div class="div-table">
                    <table id="table-func">
                        <tr>
                            <th style="width: 70px;">ID</th>
                            <th style="width: 200px;">TÊN CHỨC NĂNG</th>
                            <th style="width: 200px;">THUỘC CHỨC NĂNG</th>
                            <th>MÔ TẢ</th>
                            <th style="width: 50px;">XEM</th>
                            <th style="width: 50px;">SỬA</th>
                            <th style="width: 50px;">XÓA</th>
                            <th style="width: 50px;">CHẶN XEM</th>
                            <th style="width: 50px;">CHẶN SỬA</th>
                            <th style="width: 50px;">CHẶN XÓA</th>
                        </tr>
                        <tr>
                            <td>
                                <input id="id-func">
                            </td>
                            <td>
                                <input id="name-func">
                            </td>
                            <td>
                                <select id="parent-func">
                                </select>
                            </td>
                            <td>
                                <input id="desc-func">
                            </td>
                            <td style="text-align: center;">
                                <input type="radio" name="view" id="view">
                            </td>
                            <td style="text-align: center;">
                                <input type="radio" name="edit" id="edit">
                            </td>
                            <td style="text-align: center;">
                                <input type="radio" name="delete" id="delete">
                            </td>
                            <td style="text-align: center;">
                                <input type="radio" name="view" id="deny-view">
                            </td>
                            <td style="text-align: center;">
                                <input type="radio" name="edit" id="deny-edit">
                            </td>
                            <td style="text-align: center;">
                                <input type="radio" name="delete" id="deny-delete">
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <?php 
            include("../inc/footer.php");
        ?>
    </div>
    <div id="div-choose-group">
        <div class="form-choose-group">
            <button class="btn-close" onclick="closeGroup()">
                <ti class="ti-close"></ti>
            </button>
            <p class="title-choose">Chọn nhóm nhân viên</p>
            <div class="div-table">
                <table id="table-group">
                    <tr>
                        <th style="width: 70px;">ID</th>
                        <th>Tên Nhóm</th>
                        <th style="width: 50px;">Chọn</th>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" id="find-id-group">
                        </td>
                        <td>
                            <input type="text" id="find-name-group">
                        </td>
                        <td>
                            <button class="btn-find" onclick="findGroup()" title="Tìm">
                                <ti class="ti-search"></ti>
                            </button>
                        </td>
                    </tr>
                    <?php
                    $stid=oci_parse($conn, "SELECT * FROM NHOM ORDER BY ID_NHOM ASC");
                    oci_execute($stid);
                    while($row=oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)){
                    ?>
                    <tr class="row-group">
                        <td><?php echo $row["ID_NHOM"];?></td>
                        <td><?php echo $row["TENNHOM"];?></td>
                        <td>
                            <button class="btn-insert" onclick="chooseGroupAuth(this)" title="Chọn">
                                <ti class="ti-hand-point-up"></ti>
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
    <div id="div-choose-pro">
        <div class="form-choose-pro">
            <button class="btn-close" onclick="closePro()">
                <ti class="ti-close"></ti>
            </button>
            <p class="title-choose">Chọn Chương Trình</p>
            <div class="div-table">
                <table id="table-pro">
                    <tr>
                        <th style="width: 60px;">ID</th>
                        <th style="width: 200px;">Tên Chương Trình</th>
                        <th style="width: 150px;">Người Thực Hiện</th>
                        <th style="width: 150px;">Đơn Vị Thực Hiện</th>
                        <th style="width: 100px;">Thời Gian</th>
                        <th>Mô tả</th>
                        <th style="width: 50px;">Chọn</th>
                    </tr>
                    <tr>
                        <td>
                            <input id="find-id-pro">
                        </td>
                        <td>
                            <input id="find-name-pro">
                        </td>
                        <td>
                            <input id="find-per-pro">
                        </td>
                        <td>
                            <input id="find-unit-pro">
                        </td>
                        <td>
                            <input type="date" id="find-date-pro" value=""  style="width: 120px;">
                        </td>
                        <td>
                            <input id="find-desc-pro">
                        </td>
                        <td>
                            <button class="btn-find" onclick="findPro()" title="Tìm">
                                <ti class="ti-search"></ti>
                            </button>
                        </td>
                    </tr>
                    <?php
                    $stid=oci_parse($conn,"SELECT * FROM CHUONGTRINH ORDER BY ID_CT");
                    oci_execute($stid);
                    while($row=oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)){
                    ?>
                    <tr class="row-pro">
                        <td><?php echo $row["ID_CT"]?></td>
                        <td><?php echo $row["TENCT"]?></td>
                        <td><?php echo $row["NGUOITHUCHIEN"]?></td>
                        <td><?php echo $row["DVTHUCHIEN"]?></td>
                        <td style="text-align: center;"><?php echo to_date($row["THOIGIANBATDAU"])?></td>
                        <td><?php echo $row["MO_TA_CT"]?></td>
                        <td>
                            <button class="btn-insert" onclick="insertGroup(this)" title="Chọn">
                                <ti class="ti-hand-point-up"></ti>
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
    <div id="div-tree">
        <div class="form-tree">
            <button class="btn-close" onclick="closeTree()">
                <ti class="ti-close"></ti>
            </button>
            <p class="title-choose">Cây chức năng chương trình</p>
            <div class="func-tree">
                <div class="tree" id="ul-tree">
                </div>
            </div>
        </div>
    </div>
</body>
</html>