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
    <title>Quản lý Chức Danh</title>
    <link rel="stylesheet" href="../../assets/css/css.css">
    <link rel="stylesheet" href="../../assets/css/job-title-list.css">
    <link rel="stylesheet" href="../../assets/font/themify-icons/themify-icons.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="../../assets/js/job-title.js"></script>
</head>
<body>
    <div id="wrapper">
        <?php 
            require_once("../inc/header.php");
            require_once("../../php/date.php");
        ?>
        <div id="content">
            <?php require_once("../../connect/connection.php");?> 
            <p>DANH SÁCH CHỨC DANH NHÂN VIÊN</p>
            <center>
            <div class="div-btn-table">
                <div>
                    <div class="btn-insert-delete">
                        <button class="btn-insert" onclick="openInsert()">
                            <ti class="ti-plus"></ti>
                            Thêm
                        </button>
                        <button class="btn-delete" onclick="deleteJob()">
                            <ti class="ti-eraser"></ti>
                            Xóa
                        </button>
                    </div>
                </div>
                <div class="div-table">
                    <table id="table">      
                        <tr>
                            <th style="width: 40px;">
                                <input type="checkbox" name="" id="choose-all" onclick="chooseAll()">
                            </th>
                            <th style="width: 70px;">ID</th>
                            <th>TÊN CHỨC DANH</th>
                            <th style="width: 40px;">CHI TIẾT</th>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <input type="text" name="" id="find-id">
                            </td>
                            <td>
                                <input type="text" name="" id="find-name">
                            </td>
                            <td>
                                <button class="btn-find" onclick="findJob()">
                                    <ti class="ti-search"></ti>
                                </button>
                            </td>
                        </tr>
                        <?php
                            $query = 'SELECT * FROM CHUCDANH ORDER BY ID_CD ASC';
                            $stid = oci_parse($conn, $query);
                            oci_execute($stid);
                            while($row=oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
                                if($row['ID_CD']==1 && $row['TENCD']=='Quản trị'){
                        ?>
                        <tr class="row" style="height: 40px">
                            <td></td>
                            <td>1</td>
                            <td>Quản trị</td>
                            <td>
                                <button class="btn-edit" onclick="showEdit(this)" title="Sửa">
                                    <ti class="ti-info"></ti>
                                </button>
                            </td>
                        </tr>
                        <?php
                            }
                            else {   
                        ?>
                        <tr class="row">
                            <td>
                                <input type="checkbox" name="" id="" class="choose">
                            </td>
                            <td><?php echo $row["ID_CD"]?></td>
                            <td><?php echo $row["TENCD"]?></td>
                            <td>
                                <button class="btn-edit" onclick="showEdit(this)" title="Sửa">
                                    <ti class="ti-info"></ti>
                                </button>
                            </td>
                        </tr>
                        <?php
                                }
                            }
                        ?>
                    </table>
                </div>
            </div>
            </center>
            </div>
        </div>
        <?php require_once("../inc/footer.php");?>
    </div>
    <div id="div-insert-edit">
        <input type="hidden" name="" id="id-edit" value="">
        <div class="form-insert-edit">
            <button class="btn-close" onclick="closeForm()">
                <ti class="ti-close"></ti>
            </button>
            <p class="title-insert" id="title-insert"></p>
            <div id="content-insert">
                <div class="name-job">
                    <label for="">Tên Chức Danh:</label>
                    <input name="" id="name-job"></input>
                </div>
                <p>Danh sách nhân viên trong chức danh</p>
                <div class="div-table" style="height: 300px;">
                    <table id="table-user-job-title">
                        <tr>
                            <th style="width: 70px;" >ID</th>
                            <th style="width: 200px;">Tên</th>
                            <th style="width: 100px;">Ngày sinh</th>
                            <th style="width: 90px;"> Giới tính</th>
                            <th>Địa chỉ</th>
                            <th style="width: 150px;">Chức vụ</th>
                            <th style="width: 150px;">Phòng ban</th>
                            <th style="width: 40px;">Xóa</th>
                        </tr>
                    </table>
                </div>
                <div>
                    <div class="btn-save-insert-edit">
                        <button class="btn-save-insert" id="btn-save-insert" onclick="insertJobTitle()">
                            <ti class="ti-plus"></ti>
                            Thêm
                        </button>
                        <button class="btn-save-edit" id="btn-save-edit" onclick="saveEdit()">
                            <ti class="ti-check"></ti>
                            Lưu
                        </button>
                        <button class="btn-cancel" onclick="cancel()">
                            <ti class="ti-close"></ti>
                            Hủy
                        </button>
                    </div>
                </div>
                <p class="p-boder">Danh sách thêm nhân viên</p>
                <div class="div-table">
                    <table id="table-user-list">
                        <tr>
                            <th style="width: 70px;">ID</th>
                            <th style="width: 200px;">Tên</th>
                            <th style="width: 130px;">Ngày sinh</th>
                            <th style="width: 90px;"> Giới tính</th>
                            <th>Địa chỉ</th>
                            <th style="width: 150px;">Chức vụ</th>
                            <th style="width: 150px;">Phòng ban</th>
                            <th style="width: 40px;"></th>
                        </tr>
                        <tr>
                            <td><input type="text" id="id-find" style="width: 70px;"></td>
                            <td><input type="text" id="name-find"></td>
                            <td><input type="date" id="date-find" style="width: 130px;"></td>
                            <td>
                                <select name="" id="gender-find">
                                    <option value="" selected>Tất cả</option>
                                    <option value="Nam">Nam</option>
                                    <option value="Nữ">Nữ</option>
                                </select>
                            </td>
                            <td><input type="text" id="add-find"></td>
                            <td>
                                <select name="" id="position-find">
                                    <option value="" selected>Tất cả</option>
                                    <?php
                                        $stid=oci_parse($conn, 'SELECT * FROM CHUCVU ORDER BY ID_CV ASC');
                                        oci_execute($stid);
                                        while($row=oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)){
                                    ?>
                                    <option value="<?php echo $row["ID_CV"];?>"><?php echo $row["TENCV"];?></option>
                                    <?php        
                                        }
                                    ?>
                                </select>
                            </td>
                            <td>
                                <select name="" id="department-find">
                                    <option value="" selected>Tất cả</option>
                                    <?php
                                        $stid=oci_parse($conn, 'SELECT * FROM PHONGBAN ORDER BY ID_PB ASC');
                                        oci_execute($stid);
                                        while($row=oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)){
                                    ?>
                                    <option value="<?php echo $row["ID_PB"];?>"><?php echo $row["TENPB"];?></option>
                                    <?php        
                                        }
                                    ?>
                                </select>
                            </td>
                            <td>
                                <button class="btn-find" onclick="findUser()" title="Tìm">
                                    <ti class="ti-search"></ti>
                                </button>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>