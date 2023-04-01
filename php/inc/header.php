<?php 
    require_once("../../connect/connection.php")
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
	function logout(){
		var result = confirm("Bạn muốn đăng xuất?");
		if(result){
            document.flogout.submit();
		}
	}
</script>
<form name='flogout' action='../logout.php' method='POST'>
	<input type='hidden' name='logout' value='YES' />
</form>
<link rel="stylesheet" href="../../assets/css/css.css">
<div id="header">
    <div id="logo">
        <a href="../user-acc/user-account.php">
            <img src="../../assets/images/logo_vnpt_xanh.png" alt="VNPT" class="logo-img">
        </a>
    </div>
    <div id="menu-bar">
        <ul id="nav">
            <li>
                <a href="../user-acc/user-account.php">
                    <ti class="bi-person-square"></ti>
                    <br>
                    <p>Cá Nhân</p>
                </a>
            </li>
            <li>
                <a href="../user/manage.php">
                    <ti class="bi-card-list"></ti>
                    <br>
                    <p>Quản lý</p>
                </a>
                <ul class="user" style="min-width: 250px;">
                    <li><a href="../user/user-list.php">Danh sách Nhân Viên</a></li>
                    <li><a href="../position/position-list.php">Danh sách Chức Vụ</a></li>                            
                    <li><a href="../department/department-list.php">Danh sách Phòng Ban</a></li>
                    <li><a href="../job-title/job-title-list.php">Danh sách Chức Danh</a></li>
                    <li><a href="../group/user-group-list.php">Danh sách Nhóm Nhân Viên</a></li>
                </ul>
            </li>
            <li>
                <a href="../program/program.php">
                    <ti class="bi-journal-bookmark-fill"></ti>
                    <br>
                    <p>Chương trình</p>
                </a>
            </li>
            <li>
                <a href="../authority/authority.php">
                    <ti class="ti-unlock"></ti>
                    <br>
                    <p>Phân quyền</p>
                </a>
                <ul class="user" style="min-width: 270px;">
                    <li><a href="../authority/authority-job-title.php">Phân quyền theo Chức danh</a></li>
                    <li><a href="../authority/authority-group.php">Phân quyền theo Nhóm Nhân viên</a></li>                      
                </ul>
            </li>
            <li>
                <a href="../access/access.php">
                    <ti class="ti-key"></ti>
                    <br>
                    <p>Quyền</p>
                </a>
            </li>
            <li>
                <a href="javascript:logout();">
                    <ti class="ti-power-off"></ti>
                    <br>
                    <p>Đăng xuất</p>
                </a>
            </li>
        </ul>
    </div>
</div>