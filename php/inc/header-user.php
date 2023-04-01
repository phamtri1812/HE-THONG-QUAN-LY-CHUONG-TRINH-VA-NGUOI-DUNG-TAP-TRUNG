<?php 
    require_once("../../connect/connection.php")
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
	function logout(){
		var result = confirm("Bạn muốn đăng xuất?");
		if(result) {
		     document.flogout.submit();
		}
	}
</script>
<link rel="stylesheet" href="../../assets/css/css.css">
<div id="header">
    <form name='flogout' action='../logout.php' method='POST'>
        <input type='hidden' name='logout' value='YES' />
    </form>
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