function showInfo(){
    document.getElementById('info-user').style.display='block';
    document.getElementById('edit-user').style.display='none';
    document.getElementById('change-pass').style.display='none';
    document.getElementById("li-info").style.color="var(--blue-find)";
    document.getElementById("li-edit").style.color="#000";
    document.getElementById("li-change-pass").style.color="#000";

}

function showEditAccount(){
    document.getElementById('info-user').style.display='none';
    document.getElementById('edit-user').style.display='block';
    document.getElementById('change-pass').style.display='none';
    document.getElementById("li-info").style.color="#000";
    document.getElementById("li-edit").style.color="var(--blue-find)";
    document.getElementById("li-change-pass").style.color="#000";
}

function showChangePassAcc(){
    document.getElementById('info-user').style.display='none';
    document.getElementById('edit-user').style.display='none';
    document.getElementById('change-pass').style.display='grid';
    document.getElementById("li-info").style.color="#000";
    document.getElementById("li-edit").style.color="#000";
    document.getElementById("li-change-pass").style.color="var(--blue-find)";
}

function checkLogin(){
    var id=document.getElementById('id-edit').value;
    var name_login=document.getElementById('user-login').value;
    name_login=name_login.trim();
    var check=true;
    $.ajax({
        type: 'POST',
        url: './user-acc-data.php',
        data: {
            id_check: id,
            name_login: name_login
        },
        success: function(response){
            if(response!=0){
                check=false;
                alert('Tên đăng nhập này đã được sử dụng. Vui lòng nhập tên khác!');
                document.getElementById('user-login').value='';
                document.getElementById('user-login').focus();
            }
        }
    });
}

function saveEditAccount(){
    var id=document.getElementById('id-edit').value;
    var name=document.getElementById('user-name').value;
    var gender=document.getElementById('user-gender').value;
    var add=document.getElementById('user-add').value;
    var date=document.getElementById('user-date').value;
    var login=document.getElementById('user-login').value;
    var phone=document.getElementById('user-phone').value;
    var email=document.getElementById('user-email').value;
    name=name.trim();
    add=add.trim();
    date=date.trim();
    login=login.trim();
    phone=phone.trim();
    email=email.trim();
    if(name==''){
        alert('Vui lòng nhập tên!');
        document.getElementById('name-user').focus();
    }
    else {
        if(add==''){
            alert('Vui lòng nhập địa chỉ!');
            document.getElementById('name-add').focus();
        }
        else {
            if(date==''){
                alert('Vui lòng nhập ngày sinh!');
                document.getElementById('name-date').focus();
            }
            else {
                if(login==''){
                    alert('Vui lòng nhập tên đăng nhập!');
                    document.getElementById('name-login').focus();
                }
                else {
                    if(phone==''){
                        alert('Vui lòng nhập số điện thoại!');
                        document.getElementById('name-phone').focus();
                    }
                    else {
                        if(email==''){
                            alert('Vui lòng nhập email!');
                            document.getElementById('name-email').focus();
                        }
                        else {
                            $.ajax({
                                type: 'POST',
                                url: './user-acc-data.php',
                                data: {
                                    id_check: id,
                                    name_login: login
                                },
                                success: function(response){
                                    if(response!=0){
                                        alert('Tên đăng nhập này đã được sử dụng. Vui lòng nhập tên khác!');
                                        document.getElementById('user-login').value='';
                                        document.getElementById('user-login').focus();
                                    }
                                    else {
                                        $.ajax({
                                            type: 'POST',
                                            url: './user-acc-data.php',
                                            data: {
                                                id_edit: id,
                                                name: name,
                                                gender: gender,
                                                add: add,
                                                date: date,
                                                login: login,
                                                phone: phone,
                                                email: email
                                            },
                                            success: function(response){
                                                alert(response);
                                                location.reload();
                                            }
                                        });
                                    }
                                }
                            });
                            
                        }
                    }
                }
            }
        }
    }
}

function showPass1(){
    document.getElementById("i1-pass").type="text";
    document.getElementById("show-pass1").style.display='none';
    document.getElementById("hidden-pass1").style.display='block';
}
function showPass2(){
    document.getElementById("i2-pass").type="text";
    document.getElementById("show-pass2").style.display='none';
    document.getElementById("hidden-pass2").style.display='block';
}
function showPass3(){
    document.getElementById("i3-pass").type="text";
    document.getElementById("show-pass3").style.display='none';
    document.getElementById("hidden-pass3").style.display='block';
}
function hiddenPass1(){
    document.getElementById("i1-pass").type="password";
    document.getElementById("show-pass1").style.display='block';
    document.getElementById("hidden-pass1").style.display='none';
}
function hiddenPass2(){
    document.getElementById("i2-pass").type="password";
    document.getElementById("show-pass2").style.display='block';
    document.getElementById("hidden-pass2").style.display='none';
}
function hiddenPass3(){
    document.getElementById("i3-pass").type="password";
    document.getElementById("show-pass3").style.display='block';
    document.getElementById("hidden-pass3").style.display='none';
}


function cancel(){
    var result=confirm('Bạn chắn chắc muốn hủy thay đổi?');
    if(result){
        location.reload();
    }
}

function saveChangePass(){
    var id=document.getElementById('id-edit').value;
    var old_pass=document.getElementById("i1-pass").value;
    var new_pass=document.getElementById("i2-pass").value;
    var confirm_pass=document.getElementById("i3-pass").value;
    if(old_pass=="" || new_pass=="" || confirm_pass==""){
        alert("Vui lòng nhập đầy đủ thông tin!");
    }
    else {
        if(new_pass!=confirm_pass){
            alert("Xác nhận sai!!");
        }
        else{
            $.ajax({
                type: 'POST',
                url: './user-acc-data.php',
                data: {
                    id_check_pass: id,
                    check_old_pass: old_pass,
                },
                success: function(response){
                    if(response==1){
                        $.ajax({
                            type: 'POST',
                            url: './user-acc-data.php',
                            data: {
                                id_pass: id,
                                new_pass: new_pass
                            },
                            success: function(response){
                                alert(response);
                                location.reload();
                            }
                        });
                    }
                    else {
                        alert('Mật khẩu sai!!')
                    }
                }
            });
        }
    }
}

function openInsertImg(){
    document.getElementById('form-insert-image').style.display='flex';
}
function viewImg(input){
    const [file] = input.files;
    const reader = new FileReader();
    reader.onload = e => {
        const img = document.createElement('img');
        img.src = e.target.result;
        // img.width = 200;
        img.height = 250;
        img.alt = 'file';
        $('#preview').html(img);
    }
    reader.readAsDataURL(file);
}

function saveImg(){
    var id=document.getElementById('id-edit').value;
    var file_data = $("#fileupload").prop("files")[0];   
    var form_data = new FormData();
    form_data.append("file", file_data);
    $.ajax({
        url: "./upload.php",
        dataType: 'text',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,                         
        type: 'post',
        success: function(response){
            if(response=='file' || response=='format'){
                alert('Vui lòng chọn file ảnh đúng định dạng ("jpg", "png", "jpeg", "gif")!');
            }
            else {
                if(response=='size'){
                    alert('Vui lòng chọn file ảnh có kích thước nhỏ hơn 800KB!');
                }
                else{
                    $.ajax({
                        type: 'POST',
                        url: './user-acc-data.php',
                        data: {
                            filename: response,
                            id_img: id
                        },
                        success: function(response){
                            document.getElementById('form-insert-image').style.display='none';
                            location.reload();
                        }
                    });
                }
            }
        }
    });
}

function cancelUpload(){
    document.getElementById('form-insert-image').style.display='none';
    $('#form-insert-image').load(location.href + ' #form-insert-image >*');
}