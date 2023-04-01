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
        <meta http-equiv="X-UA-Compatible" content="IE=edge" charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Quản Lý Chức Vụ</title>
        <link rel="stylesheet" href="../../assets/css/css.css">
        <link rel="stylesheet" href="../../assets/css/position.css">
        <link rel="stylesheet" href="../../assets/font/themify-icons/themify-icons.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="../../assets/js/position.js"></script>
    </head>
    <body>
        <div id="wrapper">
            <?php
                include("../inc/header.php")
            ?>
            <div id="content">
                <?php
                    require_once("../../connect/connection.php"); 
                ?>
                <p>DANH SÁCH CHỨC VỤ</p>
                <div id="table-btn-pos">
                    <div>
                        <div class="btn-insert-delete">
                            <button class="btn-insert" onclick="openInsert()">
                                <ti class="ti-plus"></ti>
                                Thêm
                            </button>
                            <button class="btn-delete" onclick="deletePos()">
                                <ti class="ti-eraser"></ti>
                                Xóa
                            </button>
                        </div>
                    </div>
                    <div class="div-table">
                        <table id="table-pos">
                            <tr>
                                <th style="width: 40px; text-align: center;">
                                    <input type="checkbox" name="" id="choose-all" onclick="chooseAll()">
                                </th>
                                <th style="width: 70px;">ID</th>
                                <th>TÊN CHỨC VỤ</th>
                                <th style="width: 50px;">SỬA</th>
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
                                    <button class="btn-find" onclick="findPos()">
                                        <ti class="ti-search"></ti>
                                    </button>
                                </td>
                            </tr>
                            <?php
                                $stid=oci_parse($conn, "SELECT * FROM CHUCVU ORDER BY ID_CV ASC");
                                oci_execute($stid);
                                while($row=oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)){
                            ?>
                            <tr class="row-pos">
                                <td style="text-align: center;">
                                    <input type="checkbox" name="" id="" class="choose-pos">
                                </td>
                                <td><?php echo $row["ID_CV"];?></td>
                                <td><?php echo $row["TENCV"];?></td>
                                <td>
                                    <button class="btn-edit" onclick="openEdit(this)">
                                        <ti class="ti-pencil"></ti>
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
            <input type="hidden" name="" id="id-edit">
            <div id="div-insert">
                <button class="btn-close" onclick="closeForm()">
                    <ti class="ti-close"></ti>
                </button>
                <p id="title-insert" class="title-insert"></p>
                <div class="content-div-insert">
                    <label for="">Tên Chức Vụ:</label>
                    <input type="text" name="" id="name-pos">
                </div>
                <div class="btn-save-insert-edit">
                    <button class="btn-save-insert" id="btn-save-insert" onclick="saveInsert()">
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
        </div>
    </body>
</html>
            