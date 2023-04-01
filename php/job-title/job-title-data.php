
<?php 
	require_once("../../connect/connection.php");
	require_once("../date.php");

	// Tim nhan vien
	if(isset($_POST['id_find'])){
		$id=$_POST['id_find'];
		$name=$_POST['name_find'];
		$date=$_POST['date_find'];
		$gender=$_POST['gender_find'];
		$add=$_POST['add_find'];
		$position=$_POST['position_find'];
		$department=$_POST['department_find'];
		if($add=='%'){
			$add="";
		}
		else{
			$add="AND DIACHI LIKE '%".$add."%'";
		}
		if($date=='%'){
			$date="";
		}
		else {
			$date="AND NGAYSINH LIKE DATE '".$date."'";
			
		}
		$stid=oci_parse($conn, "SELECT * FROM NHANVIEN WHERE ID_NV LIKE '".$id."' 
														AND HOTEN LIKE '%".$name."%' 
														AND GIOITINH LIKE '".$gender."'
														".$date."
														".$add."  
														AND ID_CV LIKE '".$position."' 
														AND ID_PB LIKE '".$department."' 
														ORDER BY ID_NV ASC");
		oci_execute($stid);
		while($row=oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)){
			$date=to_date($row["NGAYSINH"]);

			$stid_cv=oci_parse($conn, "SELECT TENCV FROM CHUCVU WHERE ID_CV=".$row["ID_CV"]."");
			oci_execute($stid_cv);
			while($cv=oci_fetch_array($stid_cv, OCI_ASSOC + OCI_RETURN_NULLS)){
				$id_pb=$row["ID_PB"];

				$stid_pb=oci_parse($conn, "SELECT TENPB FROM PHONGBAN WHERE ID_PB=".$id_pb."");
				oci_execute($stid_pb);
				while($pb=oci_fetch_array($stid_pb, OCI_ASSOC + OCI_RETURN_NULLS)){
				echo '
					<tr class="row">
						<td>'.$row["ID_NV"].'</td>
						<td>'.$row["HOTEN"].'</td>
						<td>'.$date.'</td>
						<td>'.$row["GIOITINH"].'</td>
						<td>'.$row["DIACHI"].'</td>
						<td>'.$cv["TENCV"].'</td>
						<td>'.$pb["TENPB"].'</td>
						<td>
							<button class="btn-insert" onclick="insertUser(this)" title="Thêm">
								<ti class="ti-plus"></ti>
							</button>
						</td>
					</tr>
					';
				}
			}
		}
	}

	// Them nhan vien
	if(isset($_POST['id_user_insert'])){
		$id=$_POST['id_user_insert'];
		$stid=oci_parse($conn, 'SELECT * FROM NHANVIEN WHERE ID_NV='.$id.'');
		oci_execute($stid);
		while($row=oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)){
			$stid_cv=oci_parse($conn, 'SELECT TENCV FROM CHUCVU WHERE ID_CV='.$row["ID_CV"].'');
			oci_execute($stid_cv);
			while($cv=oci_fetch_array($stid_cv, OCI_ASSOC + OCI_RETURN_NULLS)){
				$stid_pb=oci_parse($conn, 'SELECT TENPB FROM PHONGBAN WHERE ID_PB='.$row["ID_PB"].'');
				oci_execute($stid_pb);
				while($pb=oci_fetch_array($stid_pb, OCI_ASSOC + OCI_RETURN_NULLS)){
					echo '
						<tr>
							<td>'.$row["ID_NV"].'</td>
							<td>'.$row["HOTEN"].'</td>
							<td>'.to_date($row["NGAYSINH"]).'</td>
							<td>'.$row["GIOITINH"].'</td>
							<td>'.$row["DIACHI"].'</td>
							<td>'.$cv["TENCV"].'</td>
							<td>'.$pb["TENPB"].'</td>
							<td>
								<button class="btn-delete-user" onclick="deleteUser(this)" title="Xóa">
								<ti class="ti-eraser"></ti>    
								</button>
							</td>
						</tr>
					';
				}
			}
		}
	}
	// Them chuc danh
	if(isset($_POST['name']) && isset($_POST['insert'])){
		$name=$_POST['name'];
		$job=oci_parse($conn,"INSERT INTO CHUCDANH(TENCD) VALUES('".$name."')");
		oci_execute($job);
		$newuser=$_POST['insert'];
		$sl=count($_POST['insert']);
		
		$chucdanh=oci_parse($conn,"SELECT ID_CD FROM CHUCDANH WHERE TENCD='".$name."'");
		oci_execute($chucdanh);
		while($row=oci_fetch_array($chucdanh, OCI_ASSOC + OCI_RETURN_NULLS)){
			$id_cd=$row["ID_CD"];
		}
		for($i=0; $i<$sl; $i++){
			$g=oci_parse($conn,"INSERT INTO NV_CD(ID_NV, ID_CD) VALUES(".$newuser[$i].",".$id_cd.")");
			oci_execute($g);
		}
		$stid=oci_parse($conn,'SELECT ID_CN FROM CHUCNANG ORDER BY ID_CN ASC');
		oci_execute($stid);
		while($row1=oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)){
			$stid2=oci_parse($conn,"INSERT INTO PHANQUYEN_NV(ID_CD,ID_CN,XEM,SUA,XOA,KHONGXEM,KHONGSUA,KHONGXOA) VALUES(".$id_cd.",".$row1['ID_CN'].",0,0,0,1,1,1)");
			oci_execute($stid2);
		}
		echo 'Thêm chức danh '.$name.' thành công!';
	}
// Xoa chuc danh
	if(isset($_POST['id_delete'])){
		$id=$_POST['id_delete'];
		$count=count($id);
		for($i=0;$i<$count; $i++){
			$q1=oci_parse($conn,"DELETE FROM NV_CD WHERE ID_CD=".$id[$i]);
			$q2=oci_parse($conn,"DELETE FROM CHUCDANH WHERE ID_CD=".$id[$i]);
			$q3=oci_parse($conn,"DELETE FROM PHANQUYEN_NV WHERE ID_CD=".$id[$i]);
			oci_execute($q3);
			oci_execute($q1);
			oci_execute($q2);
		}
		echo 'Đã xóa '.$count.' chức danh.';
	}	
// Xem danh sach
	if(isset($_POST['id_show'])){
		$stid1=oci_parse($conn,"SELECT * FROM NV_CD WHERE ID_CD=".$_POST['id_show']);
		oci_execute($stid1);
		while($row=oci_fetch_array($stid1,OCI_ASSOC+OCI_RETURN_NULLS)){
			$stid2=oci_parse($conn, "SELECT * FROM NHANVIEN, CHUCVU, PHONGBAN WHERE ID_NV=".$row['ID_NV']." AND CHUCVU.ID_CV=NHANVIEN.ID_CV AND PHONGBAN.ID_PB=NHANVIEN.ID_PB");
			oci_execute($stid2);
			while($all=oci_fetch_array($stid2, OCI_ASSOC + OCI_RETURN_NULLS)){
				$a=date_create($all["NGAYSINH"]);
				date_format($a,'d-M-y');
				$date=$a->format("d-m-Y");
				$stid_cv=oci_parse($conn, 'SELECT TENCV FROM CHUCVU WHERE ID_CV='.$all["ID_CV"].'');
				oci_execute($stid_cv);
				while($cv=oci_fetch_array($stid_cv, OCI_ASSOC + OCI_RETURN_NULLS)){
					$stid_pb=oci_parse($conn, 'SELECT TENPB FROM PHONGBAN WHERE ID_PB='.$all["ID_PB"].'');
					oci_execute($stid_pb);
					while($pb=oci_fetch_array($stid_pb, OCI_ASSOC + OCI_RETURN_NULLS)){
						echo '
						<tr>
							<td>'.$all["ID_NV"].'</td>
							<td>'.$all["HOTEN"].'</td>
							<td>'.$date.'</td>
							<td>'.$all["GIOITINH"].'</td>
							<td>'.$all["DIACHI"].'</td>
							<td>'.$cv["TENCV"].'</td>
							<td>'.$pb["TENPB"].'</td>
							<td>
								<button class="btn-delete-user" onclick="deleteUser(this)" title="Xóa">
									<ti class="ti-eraser"></ti>    
								</button>
							</td>
						</tr>
						';
					}
				}
			}
		}
	}
	// Danh sach nhân viên không thuộc chức danh
	if(isset($_POST['id_not_job'])){
		$id=$_POST['id_not_job'];
		// if($id!=''){
		// 	$stid=oci_parse($conn, "SELECT * FROM NHANVIEN, CHUCVU, PHONGBAN 
		// 									WHERE ID_NV NOT IN (SELECT NHANVIEN.ID_NV FROM NV_CD, NHANVIEN WHERE ID_CD=".$id." AND NV_CD.ID_NV=NHANVIEN.ID_NV)
		// 									AND NHANVIEN.ID_PB=PHONGBAN.ID_PB
		// 									AND NHANVIEN.ID_CV=CHUCVU.ID_CV
		// 									ORDER BY ID_NV ASC");
		// }
		// else {
			$stid=oci_parse($conn, "SELECT * FROM NHANVIEN, CHUCVU, PHONGBAN 
										WHERE NHANVIEN.ID_PB=PHONGBAN.ID_PB
										AND NHANVIEN.ID_CV=CHUCVU.ID_CV
										ORDER BY ID_NV ASC");
		// }
		oci_execute($stid);
		while($row=oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)){
			echo '
				<tr class="row">
					<td>'.$row["ID_NV"].'</td>
					<td>'.$row["HOTEN"].'</td>
					<td>'.to_date($row['NGAYSINH']).'</td>
					<td>'.$row["GIOITINH"].'</td>
					<td>'.$row["DIACHI"].'</td>
					<td>'.$row['TENPB'].'</td>
					<td>'.$row['TENCV'].'</td>
					<td>
						<button class="btn-insert" onclick="insertUser(this)" title="Thêm">
							<ti class="ti-plus"></ti>
						</button>
					</td>
				</tr>
			';
		}
	}

	// luu chuc danh

	if(isset($_POST['id_edit']) && isset($_POST['name_edit']) && isset($_POST['edit'])){
		$id=$_POST['id_edit'];
		$name=$_POST['name_edit'];
		$job=$_POST['edit'];
		$q1=oci_parse($conn,"UPDATE CHUCDANH SET TENCD='".$name."' WHERE ID_CD=".$id);
		oci_execute($q1);
		
		$q2=oci_parse($conn,"DELETE FROM NV_CD WHERE ID_CD=".$id);
		oci_execute($q2);
		
		$len=count($job);
		for($i=0; $i<$len; $i++){
			$in=oci_parse($conn,"INSERT INTO NV_CD(ID_CD,ID_NV) VALUES(".$id.",".$job[$i].")");
			oci_execute($in);
		}
		echo 'Cập nhật thông tin chức danh '.$name.' thành công!';
	}
// kIEM TRA TEN CHUC DANH
	if(isset($_POST['id_check'])){
		$check=0;
		$stid=oci_parse($conn, "SELECT * FROM CHUCDANH");
		oci_execute($stid);
		while($row=oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)){
			if($_POST['id_check']==''){
				if($row['TENCD']==$_POST['name_check']){
					$check++;
				}
			}
			else {
				if($row['TENCD']==$_POST['name_check'] && $row['ID_CD']!=$_POST['id_check']){
					$check++;
				}
			}
		}
		echo $check;
	}
// Tim chuc danh
	if(isset($_POST['id_find_job'])){
        $stid=oci_parse($conn, "SELECT * FROM CHUCDANH WHERE ID_CD LIKE '".$_POST['id_find_job']."'
                                                            AND TENCD LIKE '%".$_POST['name_find_job']."%'
                                                            ORDER BY ID_CD ASC");
        oci_execute($stid);
        while($row=oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)){
			if($row['ID_CD']==1 && $row['TENCD']=='Quản trị'){
				echo '
					<tr class="row" style="height: 40px">
						<td></td>
						<td>1</td>
						<td>Quản trị</td>
						<td></td>
					</tr>
				';
			}
			else {
				echo '
					<tr class="row">
						<td>
							<input type="checkbox" name="" id="" class="choose">
						</td>
						<td>'.$row["ID_CD"].'</td>
						<td>'.$row["TENCD"].'</td>
						<td>
							<button class="btn-edit" onclick="showEdit(this)" title="Sửa">
								<ti class="ti-info"></ti>
							</button>
						</td>
					</tr>
				';
			}
        }
    }
?>