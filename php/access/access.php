<?php 
    require_once('../../connect/connection.php');
	session_start();
	if(!isset($_SESSION['Login'])){
		header('Location:../../index.php');
    }
    $admin=$_SESSION['Admin'];
	$id= $_SESSION['Login'];
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
    if($check!=1){
        header('Location:../user-acc/user-account.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="shortcut icon" href="../../assets/images/logo.png">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phân Quyền Chức Danh</title>
    <link rel="stylesheet" href="../../assets/css/css.css">
    <link rel="stylesheet" href="../../assets/css/access.css">
    <link rel="stylesheet" href="../../assets/font/themify-icons/themify-icons.css">
    <script src="../../assets/js/access.js"></script>	
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
    <div id="wrapper">
        <input type="hidden" id="id-user" value="<?php echo $id;?>">
        <?php
            if($admin!='Admin'){
                include("../inc/header-user.php");
            }
            else{
                include("../inc/header.php");
            }
        ?>
        <div id="content">
            <?php 
                require_once('../../connect/connection.php');
                require_once("../date.php");
            ?>
            <p>QUYỀN THAO TÁC</p>
            <div class="content-access">
                <div class="tree">
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
                        echo '<ul class="ul-dep-tree"><span class="title-tree" onclick="listPro()">Danh sách chương trình</span>';
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
                <div class="func-access" id="func-access">
                    <p class="title-access" id="title-access">Bảng quyền truy cập</p>
                    <div class="div-table">
                        <table id="table-access">
                            <tr>
                                <th style="width: 70px;">ID</th>
                                <th>Tên Chức năng</th>
                                <th>LINK</th>
                                <th style="width: 60px;">Xem</th>
                                <th style="width: 60px;">Sửa</th>
                                <th style="width: 60px;">Xóa</th>
                                <th style="width: 60px;">Chặn Xem</th>
                                <th style="width: 60px;">Chặn Sửa</th>
                                <th style="width: 60px;">Chặn Xóa</th>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="pro-access" id="pro-access">
                    <p class="title-access" id="title-pro">Danh sách chương trình</p>
                    <div class="div-table">
                        <table id="table-pro">
                            <tr>
                                <th style="width: 70px;">ID</th>
                                <th>Tên Chương Trình</th>
                                <th style="width: 100px;">Thời gian thực hiện</th>
                                <th style="width: 200px;">Người Thực hiện</th>
                                <th style="width: 50px;">Chi Tiết</th>
                            </tr>
                            <?php
                                $stid=oci_parse($conn, "SELECT * FROM CHUONGTRINH ORDER BY ID_CT ASC");
                                oci_execute($stid);
                                while($row=oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)){
                            ?>
                            <tr>
                                <td><?php echo $row["ID_CT"];?></td>
                                <td><?php echo $row["TENCT"];?></td>
                                <td style="text-align: center;"><?php echo to_date($row["THOIGIANBATDAU"]);?></td>
                                <td><?php echo $row["NGUOITHUCHIEN"];?></td>
                                <td>
                                    <button class="btn-edit" onclick="infoPro(this)">
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
        </div>
        <?php 
            include("../inc/footer.php");
        ?>
    </div>
    <div id="form-info-pro">
        <div class="div-info-pro">
            <button class="btn-close" onclick="closeForm()">
                <ti class="ti-close"></ti>
            </button>
            <p>THÔNG TIN CHƯƠNG TRÌNH</p>
            <div class="content-info">
                <a href=""></a>
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
                        <input type="url" id="link-pro" class="content" style="height: 36px;">
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
        </div>
    </div>
</body>
</html>