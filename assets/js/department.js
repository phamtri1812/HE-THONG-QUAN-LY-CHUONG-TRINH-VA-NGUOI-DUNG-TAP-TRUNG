function openDep(id){
    if(id=='all'){
        $('#p-tree').html('Danh Sách Tất Cả Phòng Ban');
    }
    else {
        $('#p-tree').html('Danh Sách Phòng Ban Thuộc '+document.getElementById(id).innerHTML);
    }
    var id_tree=id;
    $.ajax({
        type: 'POST',
        url: './department-data.php',
        data: {
            id_tree: id_tree
        },
        success: function(response){
            $('.row-dep').remove();
            $('#table-dep').append(response);
        }
    });
}

function chooseAll(){
    var rowCount=$('#table-dep tr').length;
    if(document.getElementById('choose-all').checked==true){
        for(var i=0; i<rowCount-2; i++){
            const choose=document.getElementsByClassName('choose-dep');
            choose[i].checked=true;
        }
    }
    else {
        for(var i=0; i<rowCount-2; i++){
            const choose=document.getElementsByClassName('choose-dep');
            choose[i].checked=false;
        }
    }
}

function cancel(){
    var result=confirm('Bạn chắc chắn muốn hủy?');
    if(result){
        location.reload();
    }
} 
function closeForm(){
    location.reload();
}

function openInsert(){
    $('#title-insert').html('THÊM PHÒNG BAN');
    document.getElementById('div-insert-edit').style.display='flex';
    document.getElementById('btn-save-insert').style.display='block';
}

function deleteDep(){
    var rowCount=$('#table-dep tr').length;
    var check=0;
    var id_delete=[];
    var name_delete=[];
    for(var i=0; i<rowCount-2; i++){
        const choose=document.getElementsByClassName('choose-dep');
        if(choose[i].checked==true){
            id_delete.push(document.getElementById('table-dep').rows[i+2].cells[1].innerHTML);
            name_delete.push(document.getElementById('table-dep').rows[i+2].cells[2].innerHTML);
            check++;
        }
    }
    if(check==0){
        alert('Vui lòng chọn phòng ban để thực hiện xóa!');
    }
    else {
        $.ajax({
            type: 'POST',
            url: './department-data.php',
            data: {
                id_check_user: id_delete,
                name_check_user: name_delete
            },
            success: function(response){
                if(response==''){
                    var result=confirm('Bạn chắc chắn muốn xóa những phòng ban đã chọn?');
                    if(result){
                        $.ajax({
                            type: 'POST',
                            url: './department-data.php',
                            data: {
                                id_delete: id_delete,
                            },
                            success: function(response){
                                alert(response);
                                location.reload();
                            }
                        });
                    }
                }
                else{
                    alert(response);
                }
            }
        });
    }
}

function saveInsert(){
    var id=document.getElementById('id-edit').value;
    var name=document.getElementById('name-dep').value;
    var parent=document.getElementById('parent-dep').value;
    name=name.trim();
    if(name==''){
        alert('Vui lòng nhập tên phòng!');
        document.getElementById('name-dep').focus();
    }
    else {
        $.ajax({
            type: 'POST',
            url: './department-data.php',
            data: {
                id_check: id,
                name_check: name,
                parent_check: parent
            },
            success: function(response){
                if(response!=0){
                    alert('Phòng ban này đã tồn tại. Vui lòng nhập tên khác!');
                    document.getElementById('name-dep').value='';
                    document.getElementById('name-dep').focus();
                }
                else {
                    $.ajax({
                        type: 'POST',
                        url: './department-data.php',
                        data: {
                            name_insert: name,
                            parent_insert: parent
                        },
                        success: function(response){
                            alert(response);
                            $('.content-div-insert').load(location.href + ' .content-div-insert > *');
                            $('#content').load(location.href + ' #content > *');
                        }
                    });
                }
            }
        });
    }
}

function findDep(){
    var id=document.getElementById('find-id').value;
    var name=document.getElementById('find-name').value;
    var parent=document.getElementById('find-parent').value;
    id=id.trim();
    name=name.trim();
    parent=parent.trim();
    if(id==''){
        id='%';
    }
    if(name==''){
        name='%';
    }
    $.ajax({
        type: 'POST',
        url: './department-data.php',
        data: {
            id_find: id,
            name_find: name, 
            parent_find: parent
        },
        success: function(response){
            $('.row-dep').remove();
            $('#table-dep').append(response);
        }
    });
}

function editDep(row){
    var i=row.parentNode.parentNode.rowIndex;
    var id=document.getElementById('table-dep').rows[i].cells[1].innerHTML;
    var name=document.getElementById('table-dep').rows[i].cells[2].innerHTML;
    var parent=document.getElementById('table-dep').rows[i].cells[4].innerHTML;
    $('#title-insert').html('THÔNG TIN '+name.toUpperCase()+' (ID: '+id+')');
    document.getElementById('div-insert-edit').style.display='flex';
    document.getElementById('btn-save-edit').style.display='block';
    document.getElementById('name-dep').value=name;
    document.getElementById('id-edit').value=id;
    $.ajax({
        type: 'POST',
        url: './department-data.php',
        data: {
            id_dep_select: id
        },
        success: function(response){
            $('#parent-dep').html(response);
            document.getElementById('parent-dep').value=parent;
        }
    });
}

function saveEdit(){
    var id=document.getElementById('id-edit').value;
    var name=document.getElementById('name-dep').value;
    var parent=document.getElementById('parent-dep').value;
    name=name.trim();
    if(name==''){
        alert('Vui lòng nhập tên phòng!');
        document.getElementById('name-dep').focus();
    }
    else {
        $.ajax({
            type: 'POST',
            url: './department-data.php',
            data: {
                id_check: id,
                name_check: name,
                parent_check: parent
            },
            success: function(response){
                if(response!=0){
                    alert('Phòng ban này đã tồn tại. Vui lòng nhập tên khác!');
                    document.getElementById('name-dep').value='';
                    document.getElementById('name-dep').focus();
                }
                else {
                    $.ajax({
                        type: 'POST',
                        url: './department-data.php',
                        data: {
                            id_edit: id,
                            name_edit: name,
                            parent_edit: parent
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