<?php
	require_once("../connect/connection.php");
	$stid=oci_parse($conn,"SELECT * FROM NHANVIEN WHERE TENDN='".$_POST['name-user']."' AND MATKHAU='".$_POST['password-user']."'");
	oci_execute($stid);
	while($row=oci_fetch_assoc($stid)){
		$ID= $row["ID_NV"];
		error_reporting(0); 
		session_start();
		if($ID!=null){
			$_SESSION['Admin']='';
			$stid_cd=oci_parse($conn, "SELECT * FROM NV_CD WHERE ID_NV=".$ID);
			oci_execute($stid_cd);
			while($row_cd=oci_fetch_array($stid_cd, OCI_ASSOC+OCI_RETURN_NULLS)){
				if($row_cd['ID_CD']==1){
					$_SESSION['Admin']='Admin';
					break;
				}
			}
			$_SESSION['Login']=$ID;
			header("Location:./user-acc/user-account.php");
		}
	}
?>
