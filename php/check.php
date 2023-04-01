<?php
if(isset($_POST['name_user']) && isset($_POST['pass_user'])){
    require_once("../connect/connection.php");
	$stid = oci_parse($conn,'SELECT * FROM NHANVIEN');
	oci_execute($stid); 
    $check='ten';
	while ($row = oci_fetch_assoc($stid)) {	
		if($_POST['name_user']== $row["TENDN"]){
            $check='mk';
			if($_POST['pass_user']==$row["MATKHAU"]){
				$check='yes';
                break;
			}
		}
	}
    echo $check;
}
?>