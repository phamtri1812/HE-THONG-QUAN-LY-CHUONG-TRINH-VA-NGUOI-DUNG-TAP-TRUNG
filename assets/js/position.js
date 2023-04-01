function chooseAll(){
    var rowCount=$('#table-pos tr').length;
    if(document.getElementById('choose-all').checked==true){
        for(var i=0; i<rowCount-2; i++){
            const choose=document.getElementsByClassName('choose-pos');
            choose[i].checked=true;
        }
    }
    else {
        for(var i=0; i<rowCount-2; i++){
            const choose=document.getElementsByClassName('choose-pos');
            choose[i].checked=false;
        }
    }
}

function openInsert(){
    document.getElementById('div-insert-edit').style.display='flex';
    $('#title-insert').html('THÊM CHỨC VỤ');
    document.getElementById('btn-save-insert').style.display='block';
}

function deletePos(){
    var rowCount=$('#table-pos tr').length;
    var check=0;
    var id_delete=[];
    var name_delete=[];
    for(var i=0; i<rowCount-2; i++){
        const choose=document.getElementsByClassName('choose-pos');
        if(choose[i].checked==true){
            id_delete.push(document.getElementById('table-pos').rows[i+2].cells[1].innerHTML);
            name_delete.push(document.getElementById('table-pos').rows[i+2].cells[2].innerHTML);
            check++;
        }
    }
    if(check==0){
        alert('Vui lòng chọn chức vụ để thực hiện xóa!');
    }
    else {
        $.ajax({
            type: 'POST',
            url: './position-data.php',
            data: {
                id_check_user: id_delete,
                name_check_user: name_delete
            },
            success: function(response){
                if(response==''){
                    var result=confirm('Bạn chắc chắn muốn xóa những chức vụ đã chọn?');
                    if(result){
                        $.ajax({
                            type: 'POST',
                            url: './position-data.php',
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

function findPos(){
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
        url: './position-data.php',
        data: {
            id_find: id,
            name_find: name
        },
        success: function(response){
            $('.row-pos').remove();
            $('#table-pos').append(response);
        }
    });
}

function openEdit(row){
    var i=row.parentNode.parentNode.rowIndex;
    var id=document.getElementById('table-pos').rows[i].cells[1].innerHTML;
    var name=document.getElementById('table-pos').rows[i].cells[2].innerHTML;
    $('#title-insert').html('CHỨC VỤ '+name.toUpperCase()+' (ID: '+id+')');
    document.getElementById('div-insert-edit').style.display='flex';
    document.getElementById('btn-save-edit').style.display='block';
    document.getElementById('name-pos').value=name;
    document.getElementById('id-edit').value=id;
}

function saveEdit(){
    var id=document.getElementById('id-edit').value;
    var name=document.getElementById('name-pos').value;
    name=name.trim();
    if(name==''){
        alert('Vui lòng nhập tên chức vụ!');
        document.getElementById('name-pos').focus();
    }
    else {
        $.ajax({
            type: 'POST',
            url: './position-data.php',
            data: {
                id_check: id,
                name_check: name
            },
            success: function(response){
                if(response!=0){
                    alert('Chức vụ này đã tồn tại. Vui lòng nhập tên khác!');
                    document.getElementById('name-pos').value='';
                    document.getElementById('name-pos').focus();
                }
                else {
                    $.ajax({
                        type: 'POST',
                        url: './position-data.php',
                        data: {
                            id_edit: id,
                            name_edit: name,
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

function saveInsert(){
    var id=document.getElementById('id-edit').value;
    var name=document.getElementById('name-pos').value;
    name=name.trim();
    if(name==''){
        alert('Vui lòng nhập tên chức vụ!');
        document.getElementById('name-pos').focus();
    }
    else {
        $.ajax({
            type: 'POST',
            url: './position-data.php',
            data: {
                id_check: id,
                name_check: name
            },
            success: function(response){
                if(response!=0){
                    alert('Chức vụ này đã tồn tại. Vui lòng nhập tên khác!');
                    document.getElementById('name-pos').value='';
                    document.getElementById('name-pos').focus();
                }
                else {
                    $.ajax({
                        type: 'POST',
                        url: './position-data.php',
                        data: {
                            name_insert: name,
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

function cancel(){
    var result=confirm('Bạn chắc chắn muốn hủy?');
    if(result){
        location.reload();
    }
} 
function closeForm(){
    location.reload();
}
