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
        <title>Quản Lý Phòng Ban</title>
        <link rel="stylesheet" href="../../assets/css/css.css">
        <link rel="stylesheet" href="../../assets/css/department.css">
        <link rel="stylesheet" href="../../assets/font/themify-icons/themify-icons.css">
        <script src="../../assets/js/department.js"></script>
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
                <?php require_once("../../connect/connection.php"); ?>
                <p>DANH SÁCH PHÒNG BAN</p>
                <div id="department">
                    <div class="tree">
                        <?php
                            function tree($conn,$id){
                                echo '<ul class="ul-tree">';
                                $stid=oci_parse($conn,"SELECT * FROM PHONGBAN where ID_CHA=".$id);
                                oci_execute($stid);
                                while($row=oci_fetch_array($stid,OCI_ASSOC+OCI_RETURN_NULLS)){
                                    $stid1=oci_parse($conn, "SELECT * FROM PHONGBAN WHERE ID_CHA=".$row['ID_PB']."");
                                    oci_execute($stid1);
                                    $i=0;
                                    while($row1=oci_fetch_array($stid1, OCI_ASSOC+OCI_RETURN_NULLS)){
                                        $i++;
                                    }
                                    if($i!=0){
                                        echo '
                                        <li class="li-tree"><ti class="bi-plus-circle-fill"><span id="'.$row["ID_PB"].'" onclick="openDep(this.id)"> '.$row['TENPB'].'</span></ti>';
                                        tree($conn,$row['ID_PB']);
                                        echo '</li>
                                        ';
                                    }
                                    else {
                                        echo '
                                        <li class="li-tree"><ti class="bi-dash-circle-fill"><span class="span-child"> '.$row['TENPB'].'</span></ti>';
                                        echo '</li>
                                        ';
                                    }
                                }
                                echo '</ul>';
                            }
                            $stid=oci_parse($conn, "SELECT * FROM PHONGBAN ORDER BY ID_PB ASC");
                            oci_execute($stid);
                            echo '<ul class="ul-dep-tree"><span id="all" class="title-tree" onclick="openDep(this.id)">Phòng Ban</span>';
                            while($row=oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)){
                                if($row['ID_CHA']==null){
                                    $stid1=oci_parse($conn, "SELECT * FROM PHONGBAN WHERE ID_CHA=".$row['ID_PB']."");
                                    oci_execute($stid1);
                                    $i=0;
                                    while($row1=oci_fetch_array($stid1, OCI_ASSOC+OCI_RETURN_NULLS)){
                                        $i++;
                                    }
                                    if($i!=0){
                                        echo '
                                        <li class="li-tree"><ti class="bi-plus-circle-fill"><span id="'.$row["ID_PB"].'" onclick="openDep(this.id)"> '.$row['TENPB'].'</span></ti>';
                                        tree($conn,$row['ID_PB']);
                                        echo '</li>
                                        ';
                                    }
                                    else {
                                        echo '
                                        <li class="li-tree"><ti class="bi-dash-circle-fill"><span class="span-child"> '.$row['TENPB'].'</span></ti>';
                                        echo '</li>
                                        ';
                                    }
                                }
                            }
                            echo '</ul>';
                        ?>
                    </div>
                    <div id="list-dep">
                        <p id="p-tree">Tất cả Phòng Ban</p>
                        <div>
                            <div class="btn-insert-delete">
                                <button class="btn-insert" onclick="openInsert()">
                                    <ti class="ti-plus"></ti>
                                    Thêm
                                </button>
                                <button class="btn-delete" onclick="deleteDep()">
                                    <ti class="ti-close"></ti>
                                    Xóa
                                </button>
                            </div>
                        </div>
                        <div class="div-table-dep">
                            <table id="table-dep">
                                <tr>
                                    <th style="width: 40px; text-align: center;">
                                        <input type="checkbox" name="" id="choose-all" onclick="chooseAll()">
                                    </th>
                                    <th style="width: 70px;">ID</th>
                                    <th>TÊN PHÒNG BAN</th>
                                    <th>THUỘC PHÒNG BAN</th>
                                    <th style="display: none;">ID ẨN</th>
                                    <th style="width: 50px;">SỬA</th>
                                </tr>
                                <tr class="row-find">
                                    <td></td>
                                    <td>
                                        <input type="text" name="" id="find-id" class="find">
                                    </td>
                                    <td>
                                        <input type="text" name="" id="find-name" class="find">
                                    </td>
                                    <td>
                                        <select name="" id="find-parent" class="find">
                                            <option value="all">Tất cả</option>
                                            <option value="">Không</option>
                                            <?php
                                                $stid_p=oci_parse($conn, "SELECT * FROM PHONGBAN ORDER BY ID_PB ASC");
                                                oci_execute($stid_p);
                                                while($row_p=oci_fetch_array($stid_p, OCI_ASSOC + OCI_RETURN_NULLS)){
                                            ?>
                                            <option value="<?php echo $row_p["ID_PB"];?>"><?php echo $row_p["TENPB"];?></option>
                                            <?php
                                                }
                                            ?>
                                        </select>
                                    </td>
                                    <td style="display: none;"></td>
                                    <td>
                                        <button class="btn-find" onclick="findDep()">
                                            <ti class="ti-search"></ti>
                                        </button>
                                    </td>
                                </tr>
                                <?php
                                    $stid=oci_parse($conn, "SELECT * FROM PHONGBAN ORDER BY ID_PB ASC");
                                    oci_execute($stid);
                                    while($row=oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)){
                                        if($row['ID_CHA']==''){
                                            $ten_cha='Không';
                                        }
                                        else {
                                            $stid1=oci_parse($conn, "SELECT * FROM PHONGBAN WHERE ID_PB=".$row['ID_CHA']);
                                            oci_execute($stid1);
                                            while($row1=oci_fetch_array($stid1, OCI_ASSOC+OCI_RETURN_NULLS)){
                                                $ten_cha=$row1['TENPB'];
                                            }
                                        }
                                ?>
                                <tr class="row-dep">
                                    <td style="text-align: center;">
                                        <input type="checkbox" name="" class="choose-dep">
                                    </td>
                                    <td><?php echo $row["ID_PB"];?></td>
                                    <td><?php echo $row["TENPB"];?></td>
                                    <td><?php echo $ten_cha;?></td>
                                    <td style="display: none;"><?php echo $row['ID_CHA']?></td>
                                    <td>
                                        <button class="btn-edit" onclick="editDep(this)">
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
                    <label for="">Tên Phòng Ban:</label>
                    <input type="text" name="" id="name-dep">
                    <label for="">Thuộc Phòng Ban</label>
                    <select name="" id="parent-dep">
                        <option value="">Không</option>
                        <?php
                            $stid=oci_parse($conn, "SELECT * FROM PHONGBAN ORDER BY ID_PB ASC");
                            oci_execute($stid);
                            while($row=oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)){
                        ?>
                        <option value="<?php echo $row["ID_PB"]?>"><?php echo $row["TENPB"]?></option>
                        <?php
                            }
                        ?>
                    </select>
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
                    <button class="btn-cancel" id="btn-cancel" onclick="cancel()">
                        <ti class="ti-close"></ti>
                        Hủy
                    </button>
                </div>
            </div>
        </div>
        </center>
    </body>
</html>
            