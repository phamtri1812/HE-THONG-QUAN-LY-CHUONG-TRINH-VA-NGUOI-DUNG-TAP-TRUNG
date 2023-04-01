// Hủy
function cancel(){
    var result=confirm('Bạn chắc chắn muốn hủy?');
    if(result){
        location.reload();
    }
} 
// Đóng form insert edit
function closeForm(){
    location.reload();
}
// Mở form insert
function openInsert(){
    document.getElementById('div-insert-edit').style.display='flex';
    $('#title-insert').append('Thêm nhân viên mới');
    document.getElementById('btn-save-insert').style.display='block';
}
// Mở form edit
function openEdit(row){
    document.getElementById('div-insert-edit').style.display='flex';
    document.getElementById('btn-save-edit').style.display='block';
    var i=row.parentNode.parentNode.rowIndex;
    var id_edit=document.getElementById('UserTable').rows[i].cells[1].innerHTML;
    $('#title-insert').append('Sửa thông tin nhân viên '+id_edit);
    document.getElementById('id-edit').value=id_edit;
    $.ajax({
        type: 'POST',
        url: './user-list-data.php',
        data: {
            id_edit: id_edit,
        },
        success: function(response){
            $('#input-insert-edit').html(response);
        }
    });
}
// Tại lại mật khẩu
function resetPass(){
    var id=document.getElementById('id-edit').value;
    var name=document.getElementById('name-user').value;
    var pass=randomPass();
    $.ajax({
        type: 'POST',
        url: './user-list-data.php',
        data: {
            pass_update: pass,
            id_user: id,
            name_user: name
        },
        success: function(response){
            alert(response);
        }
    });
}
// Lưu chỉnh sửa 
function editUser(){
    var id=document.getElementById('id-edit').value;
    var name=document.getElementById('name-user').value;
    var gender=document.getElementById('gender-user').value;
    var date=document.getElementById('date-user').value;
    var phone=document.getElementById('phone-user').value;
    var email=document.getElementById('email-user').value;
    var login=document.getElementById('login-user').value;
    var pos=document.getElementById('pos-user').value;
    var dep=document.getElementById('dep-user').value;
    var add=document.getElementById('add-user').value;
    name=name.trim();
    gender=gender.trim();
    date=date.trim();
    phone=phone.trim();
    email=email.trim();
    login=login.trim();
    dep=dep.trim();
    pos=pos.trim();
    add=add.trim();
    if(name==''){
        alert('Vui lòng nhập tên nhân viên!');
        document.getElementById('name-user').focus();
    }
    else {
        if(login==''){
            alert('Vui lòng nhập tên đang nhập!');
            document.getElementById('login-user').focus();
        }
        else {
            if(pos==''){
                alert('Vui lòng chọn chức vụ cho nhân viên!');
            }
            else {
                if(dep==''){
                    alert('Vui lòng chọn phòng ban cho nhân viên!');
                }
                else {
                    $.ajax({
                        type: 'POST',
                        url: './user-list-data.php',
                        data: {
                            id_check_login: id,
                            name_login: login
                        },
                        success: function(response){
                            if(response==1){
                                $.ajax({
                                    type: 'POST',
                                    url: './user-list-data.php',
                                    data: {
                                        id_save_edit: id,
                                        name: name,
                                        gender: gender,
                                        date: date,
                                        phone: phone,
                                        email: email,
                                        login: login,
                                        pos: pos,
                                        dep: dep,
                                        add: add
                                    },
                                    success: function(response){
                                        alert(response);
                                        location.reload();
                                    }
                                });
                            }
                            else {
                                alert('Tên đăng nhập này đã tồn tại. Vui lòng chọn tên khác');
                                document.getElementById('login-user').value='';
                                document.getElementById('login-user').focus();
                            }
                        }
                    });
                }
            }
        }
    }
}
// Random mật khẩu
function randomPass(){
    var chars = "0123456789abcdefghijklmnopqrstuvwxyz";
    var string_length = 6;
    var randomstring = '';
    for (var i=0; i<string_length; i++) {
        var rnum = Math.floor(Math.random() * chars.length);
        randomstring += chars.substring(rnum,rnum+1);
    }
    return randomstring;
}
// Thêm nhân viên vào CSDL
function insertUser(){
    var name=document.getElementById('name-user').value;
    var gender=document.getElementById('gender-user').value;
    var date=document.getElementById('date-user').value;
    var phone=document.getElementById('phone-user').value;
    var email=document.getElementById('email-user').value;
    var login=document.getElementById('login-user').value;
    var pass=randomPass();
    var pos=document.getElementById('pos-user').value;
    var dep=document.getElementById('dep-user').value;
    var add=document.getElementById('add-user').value;
    name=name.trim();
    gender=gender.trim();
    date=date.trim();
    phone=phone.trim();
    email=email.trim();
    login=login.trim();
    pass=pass.trim();
    dep=dep.trim();
    pos=pos.trim();
    add=add.trim();
    if(name==''){
        alert('Vui lòng nhập tên nhân viên!');
        document.getElementById('name-user').focus();
    }
    else {
        if(login==''){
            alert('Vui lòng nhập tên đăng nhập!');
            document.getElementById('login-user').focus();
        }
        else {
            if(pos==''){
                alert('Vui lòng chọn chức vụ cho nhân viên!');
            }
            else {
                if(dep==''){
                    alert('Vui lòng chọn phòng ban cho nhân viên!');
                }
                else {
                    $.ajax({
                        type: 'POST',
                        url: './user-list-data.php',
                        data: {
                            id_check_login: '',
                            name_login: login
                        },
                        success: function(response){
                            if(response==1){
                                $.ajax({
                                    type: 'POST',
                                    url: './user-list-data.php',
                                    data: {
                                        name_insert: name,
                                        gender: gender,
                                        date: date,
                                        phone: phone,
                                        email: email,
                                        login: login,
                                        pass: pass,
                                        pos: pos,
                                        dep: dep,
                                        add: add
                                    },
                                    success: function(response){
                                        alert(response);
                                        $('#input-insert-edit').load(location.href + ' #input-insert-edit > *');
                                        $('#content').load(location.href + ' #content > *');
                                    }
                                });
                            }
                            else {
                                alert('Tên đăng nhập này đã tồn tại. Vui lòng chọn tên khác');
                                document.getElementById('login-user').value='';
                                document.getElementById('login-user').focus();
                            }
                        }
                    });
                }
            }
        }
    }
}
// Xóa nhân viên
function deleteUser(){
    var rowCount=$('#UserTable tr').length;
    var check=0;
    var id_delete=[];
    for(var i=0; i<rowCount-2; i++){
        const choose=document.getElementsByClassName('choose-user');
        if(choose[i].checked==true){
            id_delete.push(document.getElementById('UserTable').rows[i+2].cells[1].innerHTML);
            check++;
        }
    }
    if(check==0){
        alert('Vui lòng chọn nhân viên để thực hiện xóa!');
    }
    else {
        var result=confirm('Tất cả thông tin của nhân viên trong nhóm và chức danh cũng sẽ bị xóa. \nBạn chắc chắn muốn xóa những nhân viên đã chọn?');
        if(result){
            $.ajax({
                type: 'POST',
                url: './user-list-data.php',
                data: {
                    id_delete: id_delete,
                },
                success: function(response){
                    alert(response);
                    $('#content').load(location.href + ' #content > *');
                }
            });
        }
    }
}
// Chọn tất cả
function chooseAll(){
    var rowCount=$('#UserTable tr').length;
    if(document.getElementById('choose-all').checked==true){
        for(var i=0; i<rowCount-2; i++){
            const choose=document.getElementsByClassName('choose-user');
            choose[i].checked=true;
        }
    }
    else {
        for(var i=0; i<rowCount-2; i++){
            const choose=document.getElementsByClassName('choose-user');
            choose[i].checked=false;
        }
    }
}
// Tìm nhân viên
function findUser(){
    var id=document.getElementById('find-id').value;
    var name=document.getElementById('find-name').value;
    var date=document.getElementById('find-date').value;
    var gender=document.getElementById('find-gender').value;
    var add=document.getElementById('find-add').value;
    var dep=document.getElementById('find-dep').value;
    var pos=document.getElementById('find-pos').value;
    id=id.trim();
    name=name.trim();
    date=date.trim();
    gender=gender.trim();
    add=add.trim();
    dep=dep.trim();
    pos=pos.trim();
    if(id==''){
        id='%';
    }    
    if(name==''){
        name='%';
    }
    if(date==''){
        date='%';
    }
    if(gender==''){
        gender='%';
    }
    if(add==''){
        add='%';
    }
    if(dep==''){
        dep='%';
    }
    if(pos==''){
        pos='%';
    }
    $.ajax({
        type: 'POST',
        url: './user-list-data.php',
        data: {
            id_find: id,
            name_find: name,
            date_find: date,
            gender_find: gender,
            add_find: add,
            dep_find: dep,
            pos_find: pos
        },
        success: function(response){
            $('.row-user').remove();
            $('#UserTable').append(response);
        }
    });

}
// Xem quyền 
function authUser(row){
    var i=row.parentNode.parentNode.rowIndex;
    var id=document.getElementById('UserTable').rows[i].cells[1].innerHTML;
    $.ajax({
        type: 'POST',
        url: './user-list-data.php',
        data: {
            id_user_auth: id
        },
        success: function(response){
            if(response==1){
                document.getElementById('div-auth').style.display='block';
                var name=document.getElementById('UserTable').rows[i].cells[2].innerHTML;
                document.getElementById('id-user').value=id;
                $('#title-auth').html('QUYỀN CỦA NHÂN VIÊN "'+name+'"');
            }
            else {
                alert('Nhân viên này chưa có chức danh hay thuộc nhóm nhân viên nào nên chưa được phân quyền!');
            }
        }
    });

}

function openPro(id){
    var name=document.getElementById(id).innerHTML;
    var length = id.length;
    var id=id.slice(4,length);
    var id_user=document.getElementById('id-user').value;
    $('#title-pro').html('Quyền trên chức năng của chương trình "'+name+'"');
    $.ajax({
        type: 'POST',
        url: './user-list-data.php',
        data: {
            id_pro: id,
            id_user: id_user
        },
        success: function(response){
            $('.row').remove();
            $('#table-func').append(response);
        }
    });
}
// Hiện Quyền Của chức năng chọn
function openFunc(id){
    var name=document.getElementById(id).innerHTML;
    var length = id.length;
    var id=id.slice(5,length);
    var id_user=document.getElementById('id-user').value;
    $('#title-pro').html('Quyền trên chức năng "'+name+'"');
    $.ajax({
        type: 'POST',
        url: './user-list-data.php',
        data: {
            id_func: id,
            id_user: id_user
        },
        success: function(response){
            $('.row').remove();
            $('#table-func').append(response);
        }
    });
}
