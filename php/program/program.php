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
    <title>Quản lý Chương trình</title>
    <link rel="stylesheet" href="../../assets/css/css.css">
    <link rel="stylesheet" href="../../assets/font/themify-icons/themify-icons.css">
    <link rel="stylesheet" href="../../assets/css/program.css">
    <script src="../../assets/js/program.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    
</head>
<body>
    <div id="wrapper">
    <?php
        include("../inc/header.php");
    ?>
    <div id="content">
        <?php require_once("../../connect/connection.php");
            require_once("../../php/date.php");
        ?> 
        <p>DANH SÁCH CHƯƠNG TRÌNH</p>
        <div class="div-btn-table">
            <div>
                <div class="btn-insert-delete">
                    <button class="btn-insert" onclick="openInsert()">
                        <ti class="ti-plus"></ti>
                        Thêm
                    </button>
                    <button class="btn-delete" onclick="deletePro()">
                        <ti class="ti-eraser"></ti>
                        Xóa
                    </button>
                </div>
            </div>
            <div class="div-table">
                <table id="table">      
                    <tr>
                        <th style="width: 40px;">
                            <input type="checkbox" id="choose-all" onclick="chooseAll()">
                        </th>
                        <th style="width: 70px;">ID</th>
                        <th style="width: 250px;">TÊN CHƯƠNG TRÌNH</th>
                        <th style="width: 150px;">THỜI GIAN THỰC HIỆN</th>
                        <th style="width: 200px;">NGƯỜI THỰC HIỆN</th>
                        <th>ĐƠN VỊ THỰC HIỆN</th>
                        <th style="width: 50px;">CHI TIẾT</th>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input type="text" id="find-id">
                        </td>
                        <td>
                            <input type="text" id="find-name">
                        </td>
                        <td>
                            <input type="date" id="find-date" value="" style="width: 150px;">
                        </td>
                        <td>
                            <input type="text" id="find-per">
                        </td>
                        <td>
                            <input type="text" id="find-unit">
                        </td>
                        <td>
                            <button class="btn-find" onclick="findPro()">
                                <ti class="ti-search"></ti>
                            </button>
                        </td>
                    </tr>
                    <?php
                        $query = 'SELECT * FROM CHUONGTRINH ORDER BY ID_CT ASC';
                        $stid = oci_parse($conn, $query);
                        oci_execute($stid);
                        while($row=oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) { 
                    ?>
                    <tr class="row">
                        <td>
                            <input type="checkbox" class="choose">
                        </td>
                        <td><?php echo $row["ID_CT"]?></td>
                        <td><?php echo $row["TENCT"]?></td>
                        <td style="text-align: center;"><?php echo to_date($row['THOIGIANBATDAU'])?></td>
                        <td><?php echo $row["NGUOITHUCHIEN"]?></td>
                        <td><?php echo $row["DVTHUCHIEN"]?></td>
                        <td>
                            <button class="btn-edit" onclick="showEdit(this)" title="Sửa">
                                <ti class="ti-info"></ti>
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
        <input type="hidden" id="id-edit" value="">
        <div class="form-insert-edit">
            <button class="btn-close" onclick="closeForm()">
                <ti class="ti-close"></ti>
            </button>
            <p class="title-insert" id="title-insert"></p>
            <div id="content-insert">
                <div class="information" id="information">
                    <div class="div-flex">
                        <div class="div-width">
                            <label class="div-grid">Tên Chương trình:</label>
                            <textarea id="name-pro" cols="1" rows="1" class="content"></textarea>
                        </div>
                        <div class="div-width-margin">
                            <label class="div-grid">Thời gian thực hiện:</label>
                            <input type="date" id="date-pro" class="content">
                        </div>
                        <div class="div-width-margin">
                            <label class="div-grid">Người thực hiện:</label>
                            <textarea id="per-pro" cols="1" rows="1" class="content"></textarea>
                        </div>
                        <div class="div-width-margin">
                            <label class="div-grid">Link:</label>
                            <input type="url"  id="link-pro" class="content" style="height: 36px;">
                        </div>
                    </div>
                    <div class="div-flex">
                        <div class="div-50">
                            <label class="div-grid">Đơn vị thực hiện:</label>
                            <textarea id="unit-pro" cols="1" rows="2" class="content"></textarea>
                        </div>
                        <div class="div-50-margin">
                            <label class="div-grid">Mô tả</label>
                            <textarea id="desc-pro" cols="1" rows="2" class="content"></textarea>
                        </div>
                    </div>
                    <div class="div-flex">
                        <div class="div-50">
                            <label class="div-grid">Thông tin:</label>
                            <textarea id="info-pro" cols="1" rows="4" class="content"></textarea>
                        </div>
                        <div class="div-50-margin">
                            <label class="div-grid">Ghi chú:</label>
                            <textarea id="note-pro" cols="1" rows="4" class="content"></textarea>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="btn-insert-cancel">
                        <button class="btn-save-edit" id="btn-save-edit" onclick="saveEdit()">
                            <ti class="ti-check"></ti>
                            Lưu
                        </button>
                        <button class="btn-save-insert" id="btn-save-insert" onclick="saveInsert()">
                            <ti class="ti-plus"></ti>
                            Thêm
                        </button>
                        <button class="btn-cancel" onclick="cancel()">
                            <ti class="ti-close"></ti>
                            Hủy
                        </button>
                    </div>
                </div>
            </div>
            <div id="func-program">
                <p class="title-func">Danh sách chức năng chương trình</p>
                <div style="display: flex;">
                    <div class="func-tree">
                        <div class="tree" id="ul-tree">
                        </div>
                    </div>
                    <div class="table-func">
                        <div class="div-btn-func">
                            <button class="btn-green" id="btn-insert-func" onclick="openFormFunc()">
                                <ti class="ti-plus"></ti>
                                Thêm CN
                            </button>
                            <button class="btn-delete" onclick="deleteFunc()">
                                <ti class="ti-eraser"></ti>
                                Xóa
                            </button>
                        </div>
                        <div class="div-table-func">
                            <table id="FuncTable">
                                <tr>
                                    <th style="width: 40px; text-align: center;">
                                        <input type="checkbox" name="" id="choose-all-func" onclick="chooseAllFunc()">
                                    </th>
                                    <th style="width: 70px;" >ID</th>
                                    <th>Tên chức năng</th>
                                    <th>Thuộc chức năng</th>
                                    <th style="display: none;"></th>
                                    <th style="width: 50px;">Chi tiết</th>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>
                                        <input type="text" id="find-id-func">
                                    </td>
                                    <td>
                                        <input type="text" id="find-name-func">
                                    </td>
                                    <td>
                                        <select id="find-parent-func">
                                            
                                        </select>
                                    </td>
                                    <td style="display: none;"></td>
                                    <td>
                                        <button class="btn-find" title="Tìm" onclick="findFunc()">
                                            <ti class="ti-search"></ti>
                                        </button>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="div-insert-func">
        <div class="form-insert-edit">
            <button class="btn-close" onclick="closeFormFunc()">
                <ti class="ti-close"></ti>
            </button>
            <p class="title-insert" id="title-func"></p>
            <input type="hidden" id="id-edit-func" value="">
            <div class="info-func" id="info-func">
                <div class="div-flex">
                    <div class="div-50">
                        <label class="div-grid">Tên Chức năng:</label>
                        <input type="text" id="name-func" class="content-func">
                    </div>
                    <div class="div-50-margin">
                        <label class="div-grid">Link:</label>
                        <input type="url" id="link-func" class="content-func">
                    </div>
                </div>
                <div class="div-flex">
                    <div class="div-50">
                        <label class="div-grid">Mô tả:</label>
                        <textarea id="desc-func" cols="1" rows="4" class="content-func"></textarea>
                    </div>
                    <div class="div-50-margin">
                        <label class="div-grid">Thuộc Chức năng:</label>
                        <select id="parent-func" class="content-func">
                            <option value="">Không</option>
                        </select>
                    </div>
                </div>
            </div>
            <div>
                <div class="btn-insert-cancel">
                    <button class="btn-save-insert" id="btn-save-insert-func"  onclick="insertFunc()">
                        <ti class="ti-check"></ti>
                        Thêm
                    </button>
                    <button class="btn-save-edit" id="btn-save-edit-func" onclick="saveFunc()">
                        <ti class="ti-check"></ti>
                        Lưu
                    </button>
                    <button class="btn-cancel" onclick="cancelFunc()">
                        <ti class="ti-close"></ti>
                        Hủy
                    </button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>