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

function openInsert(){
    document.getElementById('div-insert-edit').style.display='block';
    document.getElementById('btn-save-insert').style.display='block';
    $('#title-insert').html('THÊM CHỨC DANH NHÂN VIÊN');
    var id='';
    updateListUser(id);
}

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
        url: './job-title-data.php',
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

function insertUser(row){
    var i=row.parentNode.parentNode.rowIndex;
    var id=document.getElementById('table-user-list').rows[i].cells[0].innerHTML;
    var name=document.getElementById('table-user-list').rows[i].cells[1].innerHTML;
    var rowCount = $('#table-user-job-title tr').length;
    var check=0;
    if(rowCount=='1'){
        check=0;
    }
    else {
        for(var j=1; j<rowCount; j++){
            if(id==document.getElementById('table-user-job-title').rows[j].cells[0].innerHTML){
                alert('Nhân viên '+name+' đã có chức danh này!');
                check++;
            }
        }
    }
    if(check==0){
        $.ajax({
            type: 'POST',
            url: './job-title-data.php',
            data:{
                id_user_insert:id
            },
            success: function(response){
                $('#table-user-job-title').append(response);
            }
        });
    }
}

// Them chuc danh
function insertJobTitle(){
    var id=document.getElementById('id-edit').value;
    var name=document.getElementById('name-job').value;
    var name=name.trim();
    var rowCount=$('#table-user-job-title tr').length;
    var insert=[];
    if(name==''){
        alert('Vui lòng nhập tên chức danh!');
    }
    else{
        $.ajax({
            type: 'POST',
            url: './job-title-data.php',
            data: {
                id_check: id,
                name_check: name
            },
            success: function(response){
                if(response!=0){
                    alert('Tên chức danh này đã tồn tại!');
                    document.getElementById('name-job').value='';
                    document.getElementById('name-job').focus();
                }
                else {
                    if(rowCount<=1){
                        alert('Vui lòng chọn nhân viên cho chức danh '+name+'.');
                    }
                    else {
                        for(var i=1; i<rowCount; i++){
                            insert.push(document.getElementById("table-user-job-title").rows[i].cells[0].innerHTML);
                        }
                        $.ajax ({
                            type: 'POST' ,
                            url: './job-title-data.php' ,
                            data:{
                                name: name,
                                insert: insert
                            },
                            success: function (response) {
                                alert(response); 
                                document.getElementById("name-job").value='';
                                $('#table-user-job-title').load(location.href + " #table-user-job-title > * "); 
                                $('#table-user-list').load(location.href + " #table-user-list > * "); 
                            }
                        });
                    }
                }
            }
        });
    }
}

//Xóa nhan vien
function deleteUser(row){
    var i=row.parentNode.parentNode.rowIndex;
    var name=document.getElementById('table-user-job-title').rows[i].cells[1].innerHTML;
    var result=confirm('Bạn chắc chắn muốn xóa nhân viên '+name+' ra khỏi chức danh này?');
    if(result){
        document.getElementById('table-user-job-title').deleteRow(i);
    }
}

// Xoa chuc danh
function deleteJob(){
    var rowCount=$('#table tr').length;
    var check=0;
    var id_delete=[];
    var id=document.getElementById('table').rows[2].cells[1].innerHTML;
    if(id!=1){
        for(var i=0; i<rowCount-2; i++){
            const choose=document.getElementsByClassName('choose');
            if(choose[i].checked==true){
                id_delete.push(document.getElementById('table').rows[i+2].cells[1].innerHTML);
                check++;
            }
        }
    }
    else{
        for(var i=0; i<rowCount-3; i++){
            const choose=document.getElementsByClassName('choose');
            if(choose[i].checked==true){
                id_delete.push(document.getElementById('table').rows[i+3].cells[1].innerHTML);
                check++;
            }
        }
    }
    if(check==0){
        alert('Vui lòng chọn phòng ban để thực hiện xóa!');
    }
    else {
        var result=confirm('Bạn chắc chắn muốn xóa những chức danh đã chọn?');
        if(result){
            $.ajax({
                type: 'POST',
                url: './job-title-data.php',
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

// Tim

function findJob(){
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
        url: './job-title-data.php',
        data: {
            id_find_job: id,
            name_find_job: name 
        },
        success: function(response){
            $('.row').remove();
            $('#table').append(response);
        }
    });
}

function updateListUser(id){
    $.ajax({
        type: 'POST',
        url: './job-title-data.php',
        data: {
            id_not_job: id,
        },
        success: function(response){
            $('.row').remove();
            $('#table-user-list').append(response);
        }
    });
}

//Xem sua 
function showEdit(row){
    var i=row.parentNode.parentNode.rowIndex;
    var id=document.getElementById('table').rows[i].cells[1].innerHTML;
    var name=document.getElementById('table').rows[i].cells[2].innerHTML;
    document.getElementById('div-insert-edit').style.display='block';
    $('#title-insert').html('THÔNG TIN CHỨC DANH '+name+' (ID:'+id+')');
    document.getElementById('btn-save-edit').style.display='block';
    document.getElementById('id-edit').value=id;
    document.getElementById('name-job').value=name;
    if(id==1){
        document.getElementById('name-job').disabled=true;
    }
    $.ajax({
        type: 'POST',
        url: './job-title-data.php',
        data: {
            id_show: id,
        },
        success: function(response){
            $('#table-user-job-title').append(response);
        }
    });
    updateListUser(id);
    
}

function saveEdit(){
    var id=document.getElementById('id-edit').value;
    var rowCount =  $("#table-user-job-title tr").length;
    var name=document.getElementById('name-job').value;
    name=name.trim();
    var edit=[];
    if(name==''){
        alert('Vui lòng nhập tên chức danh!');
    }
    else {
        $.ajax({
            type: 'POST',
            url: './job-title-data.php',
            data: {
                id_check: id,
                name_check: name
            },
            success: function(response){
                if(response!=0){
                    alert('Tên chức danh này đã tồn tại!');
                    document.getElementById('name-job').value='';
                    document.getElementById('name-job').focus();
                }
                else {
                    if(rowCount<=1){
                        alert('Vui lòng chọn nhân viên cho chức danh '+name+'.');
                    }
                    else {
                        for(var i=1; i<rowCount; i++){
                            edit.push(document.getElementById("table-user-job-title").rows[i].cells[0].innerHTML);
                        }
                        $.ajax ({
                            type: 'POST' ,
                            url: './job-title-data.php' ,
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

function checkNameTable(){
    var rowJob=$('#table-user-job-title tr').length;
    alert(rowJob);
}


