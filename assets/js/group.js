function cancel(){
    var result=confirm('Bạn chắc chắn muốn hủy?');
    if(result){
        location.reload();
    }
} 
function closeForm(){
    location.reload();
}


function chooseAll(){
    var rowCount=$('#table tr').length;
    if(document.getElementById('choose-all').checked==true){
        for(var i=0; i<rowCount-2; i++){
            const choose=document.getElementsByClassName('choose');
            choose[i].checked=true;
        }
    }
    else {
        for(var i=0; i<rowCount-2; i++){
            const choose=document.getElementsByClassName('choose');
            choose[i].checked=false;
        }
    }
}

// Tim

function findGroup(){
    var id=document.getElementById('find-id').value;
    var name=document.getElementById('find-name').value;
    id=id.trim();
    name=name.trim();
    if(id==''){
        id='%';
    }
    if(name==''){
        name='%';
    }
    $.ajax({
        type: 'POST',
        url: './group-data.php',
        data: {
            id_find_group: id,
            name_find_group: name 
        },
        success: function(response){
            document.getElementById('choose-all').checked=false;
            $('.row').remove();
            $('#table').append(response);
        }
    });
}

// Hien thong tin nhom
function showEdit(row){
    var i=row.parentNode.parentNode.rowIndex;
    var id=document.getElementById('table').rows[i].cells[1].innerHTML;
    var name=document.getElementById('table').rows[i].cells[2].innerHTML;
    document.getElementById('div-insert-edit').style.display='block';
    $('#title-insert').html('THÔNG TIN NHÓM '+name+' (ID:'+id+')');
    document.getElementById('btn-save-edit').style.display='block';
    document.getElementById('id-edit').value=id;
    document.getElementById('name-group').value=name;
    $.ajax({
        type: 'POST',
        url: './group-data.php',
        data: {
            id_show: id,
        },
        success: function(response){
            $('#table-user-group').append(response);
        }
    });
}

//Xóa nhan vien
function deleteUser(row){
    var i=row.parentNode.parentNode.rowIndex;
    var name=document.getElementById('table-user-group').rows[i].cells[1].innerHTML;
    var result=confirm('Bạn chắc chắn muốn xóa nhân viên '+name+' ra khỏi nhóm này?');
    if(result){
        document.getElementById('table-user-group').deleteRow(i);
    }
}

// Tim nhân viên
function findUser(){
    var id=document.getElementById('id-find').value;
    var name=document.getElementById('name-find').value;
    var date=document.getElementById('date-find').value;
    var gender=document.getElementById('gender-find').value;
    var add=document.getElementById('add-find').value;
    var position=document.getElementById('position-find').value;
    var department=document.getElementById('department-find').value;
    if(id.trim()==''){
        id='%';
    }
    if(name.trim()==''){
        name='%';
    }
    if(date.trim()==''){
        date='%';
    }
    if(gender.trim()==''){
        gender='%';
    }
    if(add.trim()==''){
        add='%';
    }
    if(position.trim()==''){
        position='%';
    }
    if(department.trim()==''){
        department='%';
    }
    $.ajax({
        type: 'POST',
        url: './group-data.php',
        data:{
            id_find: id,
            name_find: name,
            date_find: date,
            gender_find: gender,
            add_find: add,
            position_find: position,
            department_find: department
        },
        success: function(response){
            $('.row').remove();
            $('#table-user-list').append(response);
        }
    });
}

// Them nhan vien vao nhom
function insertUser(row){
    var i=row.parentNode.parentNode.rowIndex;
    var id=document.getElementById('table-user-list').rows[i].cells[0].innerHTML;
    var name=document.getElementById('table-user-list').rows[i].cells[1].innerHTML;
    var rowCount = $('#table-user-group tr').length;
    var check=0;
    if(rowCount=='1'){
        check=0;
    }
    else {
        for(var j=1; j<rowCount; j++){
            if(id==document.getElementById('table-user-group').rows[j].cells[0].innerHTML){
                alert('Nhân viên '+name+' đã có trong nhóm này!');
                check++;
            }
        }
    }
    if(check==0){
        $.ajax({
            type: 'POST',
            url: './group-data.php',
            data:{
                id_user_insert:id
            },
            success: function(response){
                $('#table-user-group').append(response);
            }
        });
    }
}

// Luu chinh sua
function saveEdit(){
    var id=document.getElementById('id-edit').value;
    var rowCount =  $("#table-user-group tr").length;
    var name=document.getElementById('name-group').value;
    name=name.trim();
    var edit=[];
    if(name==''){
        alert('Vui lòng nhập tên nhóm!');
    }
    else {
        $.ajax({
            type: 'POST',
            url: './group-data.php',
            data: {
                id_check: id,
                name_check: name
            },
            success: function(response){
                if(response!=0){
                    alert('Tên nhóm này đã tồn tại!');
                    document.getElementById('name-group').value='';
                    document.getElementById('name-group').focus();
                }
                else {
                    if(rowCount<=1){
                        alert('Vui lòng chọn nhân viên cho nhóm '+name+'.');
                    }
                    else {
                        for(var i=1; i<rowCount; i++){
                            edit.push(document.getElementById("table-user-group").rows[i].cells[0].innerHTML);
                        }
                        $.ajax ({
                            type: 'POST' ,
                            url: './group-data.php' ,
                            data:{
                                id_edit: id,
                                name_edit: name,
                                edit: edit
                            },
                            success: function (response) {
                                alert(response);
                                closeForm();
                                $("#content").load(location.href + " #content > *");
                            }
                        });
                    }
                }
            }
        });
    }
}


// Xoa nhom

function deleteGroup(){
    var rowCount=$('#table tr').length;
    var check=0;
    var id_delete=[];
    for(var i=0; i<rowCount-2; i++){
        const choose=document.getElementsByClassName('choose');
        if(choose[i].checked==true){
            id_delete.push(document.getElementById('table').rows[i+2].cells[1].innerHTML);
            check++;
        }
    }
    if(check==0){
        alert('Vui lòng chọn nhóm để thực hiện xóa!');
    }
    else {
        var result=confirm('Bạn chắc chắn muốn xóa những nhóm đã chọn?');
        if(result){
            $.ajax({
                type: 'POST',
                url: './group-data.php',
                data: {
                    id_delete: id_delete
                },
                success: function(response){
                    $("#content").load(location.href + " #content > *");
                    alert(response);
                }
            });
        }
    }
}

// Mo form them
function openInsert(){
    document.getElementById('div-insert-edit').style.display='block';
    document.getElementById('btn-save-insert').style.display='block';
    $('#title-insert').html('THÊM NHÓM NHÂN VIÊN');
}

// Luu them nhom
function insertGroup(){
    var id=document.getElementById('id-edit').value;
    var name=document.getElementById('name-group').value;
    var name=name.trim();
    var rowCount=$('#table-user-group tr').length;
    var insert=[];
    if(name==''){
        alert('Vui lòng nhập tên nhóm!');
    }
    else{
        $.ajax({
            type: 'POST',
            url: './group-data.php',
            data: {
                id_check: id,
                name_check: name
            },
            success: function(response){
                if(response!=0){
                    alert('Tên nhóm này đã tồn tại!');
                    document.getElementById('name-group').value='';
                    document.getElementById('name-group').focus();
                }
                else {
                    if(rowCount<=1){
                        alert('Vui lòng chọn nhân viên cho '+name+'.');
                    }
                    else {
                        for(var i=1; i<rowCount; i++){
                            insert.push(document.getElementById("table-user-group").rows[i].cells[0].innerHTML);
                        }
                        $.ajax ({
                            type: 'POST' ,
                            url: './group-data.php' ,
                            data:{
                                name: name,
                                insert: insert
                            },
                            success: function (response) {
                                alert(response); 
                                document.getElementById("name-group").value='';
                                $('#table-user-group').load(location.href + " #table-user-group > * "); 
                                $('#table-user-list').load(location.href + " #table-user-list > * "); 
                            }
                        });
                    }
                }
            }
        });
    }
}