<?php require_once("../../connect/connection.php"); 
	session_start();
	if(!isset($_SESSION['Login']))
		header('Location:../../index.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="shortcut icon" href="../../assets/images/logo.png">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Phân Quyền</title>
    <link rel="stylesheet" href="../../assets/css/css.css">
    <link rel="stylesheet" href="../../assets/css/autority.css">
    <link rel="stylesheet" href="../../assets/font/themify-icons/themify-icons.css">
</head>
<body>
    <div id="wrapper">
        <?php include("../inc/header.php")?>
        <div id="content-authority">
            <ul id="list-authority">
                <a href="./authority-job-title.php">
                    <li style="background: #6dbcdb;">
                        Phân quyền theo Chức danh
                    </li>
                </a>
                <a href="./authority-group.php">
                    <li style="background: #6dbcdb;">
                        Phân quyền theo Nhóm nhân viên
                    </li>
                </a>

            </ul>
        </div>
        <?php include("../inc/footer.php")?>
    </div>
</body>
</html>