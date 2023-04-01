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
	$id= $_SESSION['Login'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="shortcut icon" href="../../assets/images/logo.png">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Quản lý</title>
    <link rel="stylesheet" href="../../assets/css/css.css">
    <link rel="stylesheet" href="../../assets/css/manage.css">
    <link rel="stylesheet" href="../../assets/font/themify-icons/themify-icons.css">
</head>
<body>
    <div id="wrapper">
        <?php
            include("../inc/header.php");
        ?>
        <div id="content-manage">
            <ul id="list-manage">
                <a href="./user-list.php">
                    <li style="background: #35c3d7;">
                        <ti></ti>
                        Quản lý Nhân Viên
                    </li>
                </a>
                <a href="../position/position-list.php">
                    <li style="background: #72b0c9;">
                        <ti></ti>
                        Quản lý Chức Vụ
                    </li>
                </a>
                <a href="../department/department-list.php">
                    <li style="background: #519cb9;">
                        <ti></ti>
                        Quản lý Phòng Ban
                    </li>
                </a>
                <a href="../job-title/job-title-list.php">
                    <li style="background: #418aaa;">
                        <ti></ti>
                        Quản lý Chức Danh
                    </li>
                </a>
                <a href="../group/user-group-list.php">
                    <li style="background: #0069a0; padding: 55px 5px;">
                        <ti></ti>
                        Quản lý Nhóm Nhân Viên
                    </li>
                </a>
            </ul>
        </div>
        <?php
            include("../inc/footer.php");
        ?>
    </div>
</body>
</html>