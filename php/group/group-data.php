<?php
	require_once("../../connect/connection.php");
	require_once("../date.php");
	// tim nhom
	if(isset($_POST['id_find_group'])){
        $stid=oci_parse($conn, "SELECT * FROM NHOM WHERE ID_NHOM LIKE '".$_POST['id_find_group']."'
                                                            AND TENNHOM LIKE '%".$_POST['name_find_group']."%'
                                                            ORDER BY ID_NHOM ASC");
        oci_execute($stid);
        while($row=oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)){
			echo '
				<tr class="row">
					<td>
						<input type="checkbox" name="" id="" class="choose">
					</td>
					<td>'.$row["ID_NHOM"].'</td>
					<td>'.$row["TENNHOM"].'</td>
					<td>
						<button class="btn-edit" onclick="showEdit(this)" title="Sửa">
							<ti class="ti-info"></ti>
						</button>
					</td>
				</tr>
			';
        }
    }

	// Xem danh sach
	if(isset($_POST['id_show'])){
		$stid1=oci_parse($conn,"SELECT * FROM NHOM_NV WHERE ID_NHOM=".$_POST['id_show']);
		oci_execute($stid1);
		while($row=oci_fetch_array($stid1,OCI_ASSOC+OCI_RETURN_NULLS)){
			$stid2=oci_parse($conn, "SELECT * FROM NHANVIEN, CHUCVU, PHONGBAN WHERE ID_NV=".$row['ID_NV']." 
																		AND CHUCVU.ID_CV=NHANVIEN.ID_CV 
																		AND PHONGBAN.ID_PB=NHANVIEN.ID_PB
																		ORDER BY ID_NV ASC");
			oci_execute($stid2);
			while($all=oci_fetch_array($stid2, OCI_ASSOC + OCI_RETURN_NULLS)){
				$date=to_date($all["NGAYSINH"]);
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


	// Tim nhân viên
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
			$stid=oci_parse($conn, "SELECT * FROM NHANVIEN WHERE ID_NV LIKE '".$id."' 
			AND HOTEN LIKE '%".$name."%' 
			AND GIOITINH LIKE '".$gender."'
			".$add." 
			AND ID_CV LIKE '".$position."' 
			AND ID_PB LIKE '".$department."' 
			ORDER BY ID_NV ASC");
		}
		else {
			$stid=oci_parse($conn, "SELECT * FROM NHANVIEN WHERE ID_NV LIKE '".$id."' 
			AND HOTEN LIKE '%".$name."%' 
			AND GIOITINH LIKE '".$gender."'
			AND NGAYSINH LIKE DATE '".$date."'
			".$add."  
			AND ID_CV LIKE '".$position."' 
			AND ID_PB LIKE '".$department."' 
			ORDER BY ID_NV ASC");
		}
		oci_execute($stid);
		while($row=oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)){
			if($row["NGAYSINH"]!=''){
				$date=to_date($row["NGAYSINH"]);
			}
			else{
				$date='';
			}
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
			$d=to_date($row["NGAYSINH"]);
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
							<td>'.$d.'</td>
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

	

	// Kiem tra ten trung nhau
	if(isset($_POST['id_check'])){
		$check=0;
		$stid=oci_parse($conn, "SELECT * FROM NHOM");
		oci_execute($stid);
		while($row=oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)){
			if($_POST['id_check']==''){
				if($row['TENNHOM']==$_POST['name_check']){
					$check++;
				}
			}
			else {
				if($row['TENNHOM']==$_POST['name_check'] && $row['ID_NHOM']!=$_POST['id_check']){
					$check++;
				}
			}
		}
		echo $check;
	}

	// luu nhom chinh sua

	if(isset($_POST['id_edit']) && isset($_POST['name_edit']) && isset($_POST['edit'])){
		$id=$_POST['id_edit'];
		$name=$_POST['name_edit'];
		$job=$_POST['edit'];
		$q1=oci_parse($conn,"UPDATE NHOM SET TENNHOM='".$name."' WHERE ID_NHOM=".$id);
		oci_execute($q1);
		
		$q2=oci_parse($conn,"DELETE FROM NHOM_NV WHERE ID_NHOM=".$id);
		oci_execute($q2);
		
		$len=count($job);
		for($i=0; $i<$len; $i++){
			$in=oci_parse($conn,"INSERT INTO NHOM_NV(ID_NHOM,ID_NV) VALUES(".$id.",".$job[$i].")");
			oci_execute($in);
		}
		echo 'Cập nhật thông tin '.$name.' thành công!';
	}

	// Xoa nhom
	if(isset($_POST['id_delete'])){
		$id=$_POST['id_delete'];
		$count=count($id);
		for($i=0;$i<$count; $i++){
			$q1=oci_parse($conn,"DELETE FROM NHOM_NV WHERE ID_NHOM=".$id[$i]);
			$q2=oci_parse($conn,"DELETE FROM NHOM WHERE ID_NHOM=".$id[$i]);
			$q3=oci_parse($conn,"DELETE FROM PHANQUYEN_NHOM WHERE ID_NHOM=".$id[$i]);
			oci_execute($q3);
			oci_execute($q1);
			oci_execute($q2);
		}
		echo 'Đã xóa '.$count.' nhóm.';
	}	

	// them nhom
	if(isset($_POST['name']) && isset($_POST['insert'])){
		$name=$_POST['name'];
		$job=oci_parse($conn,"INSERT INTO NHOM(TENNHOM) VALUES('".$name."')");
		oci_execute($job);
		$newuser=$_POST['insert'];
		$sl=count($_POST['insert']);
		
		$chucdanh=oci_parse($conn,"SELECT ID_NHOM FROM NHOM WHERE TENNHOM='".$name."'");
		oci_execute($chucdanh);
		while($row=oci_fetch_array($chucdanh, OCI_ASSOC + OCI_RETURN_NULLS)){
			$id_cd=$row["ID_NHOM"];
		}
		for($i=0; $i<$sl; $i++){
			$g=oci_parse($conn,"INSERT INTO NHOM_NV(ID_NV, ID_NHOM) VALUES(".$newuser[$i].",".$id_cd.")");
			oci_execute($g);
		}
		$stid=oci_parse($conn,'SELECT ID_CN FROM CHUCNANG ORDER BY ID_CN ASC');
		oci_execute($stid);
		while($row1=oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)){
			$stid2=oci_parse($conn,"INSERT INTO PHANQUYEN_NHOM(ID_NHOM,ID_CN,XEM,SUA,XOA,KHONGXEM,KHONGSUA,KHONGXOA) VALUES(".$id_cd.",".$row1['ID_CN'].",0,0,0,1,1,1)");
			oci_execute($stid2);
		}
		echo 'Thêm '.$name.' thành công!';
	}
?>