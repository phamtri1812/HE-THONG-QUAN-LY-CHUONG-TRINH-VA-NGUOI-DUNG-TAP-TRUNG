function closeForm(){
    location.reload();
}

function closeFormFunc(){
    document.getElementById('div-insert-func').style.display='none';
    $('#div-insert-func').load(location.href + ' #div-insert-func > *');
}

function cancel(){
    var result=confirm('Bạn chắc chắn muốn hủy?');
    if(result){
        location.reload();
    }
}

function cancelFunc(){
    var result=confirm('Bạn chắc chắn muốn hủy?');
    if(result){
        document.getElementById('div-insert-func').style.display='none';
        $('#div-insert-func').load(location.href + ' #div-insert-func > *');
    }
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
        for(var i=0; i<rowCount-1; i++){
            const choose=document.getElementsByClassName('choose');
            choose[i].checked=false;
        }
    }
}

function chooseAllFunc(){
    var rowCount=$('#FuncTable tr').length;
    if(document.getElementById('choose-all-func').checked==true){
        for(var i=0; i<rowCount-2; i++){
            const choose=document.getElementsByClassName('choose-func');
            choose[i].checked=true;
        }
    }
    else {
        for(var i=0; i<rowCount-2; i++){
            const choose=document.getElementsByClassName('choose-func');
            choose[i].checked=false;
        }
    }
}

function updateSelectF(id_pro){
    $.ajax({
        type: 'POST',
            url: './program-data.php',
            data: {
                id_pro_select: id_pro
            },
            success: function(response){
                $('#parent-func').html(response);
            }
    });
}

function resetInsert(){
    document.getElementById('name-func').value='';
    document.getElementById('link-func').value='';
    document.getElementById('desc-func').value='';
}

function updateFindSF(id){
    $.ajax({
        type: 'POST',
            url: './program-data.php',
            data: {
                id_find_func: id
            },
            success: function(response){
                $('#find-parent-func').html(response);
            }
    });
}

function findPro(){
    var id=document.getElementById('find-id').value;
    var name=document.getElementById('find-name').value;
    var date=document.getElementById('find-date').value;
    var per=document.getElementById('find-per').value;
    var unit=document.getElementById('find-unit').value;
    id=id.trim();
    name=name.trim();
    date=date.trim();
    per=per.trim();
    unit=unit.trim();
    if(id==''){
        id='%';
    }
    if(name==''){
        name='%';
    }
    $.ajax({
        type: 'POST',
        url: './program-data.php',
        data: {
            id_find_pro: id,
            name: name,
            date: date,
            per: per,
            unit: unit
        },
        success: function(response){
            document.getElementById('choose-all').checked=false;
            $('.row').remove();
            $('#table').append(response);
        }
    });
}

// Mo form them
function openInsert(){
    document.getElementById('div-insert-edit').style.display='block';
    document.getElementById('btn-save-insert').style.display='block';
    $('#title-insert').html('THÊM CHƯƠNG TRÌNH MỚI');
}

function saveInsert(){
    var id=document.getElementById('id-edit').value;
    var name=document.getElementById('name-pro').value;
    var date=document.getElementById('date-pro').value;
    var per=document.getElementById('per-pro').value;
    var link=document.getElementById('link-pro').value;
    var unit=document.getElementById('unit-pro').value;
    var desc=document.getElementById('desc-pro').value;
    var info=document.getElementById('info-pro').value;
    var note=document.getElementById('note-pro').value;
    name=name.trim();
    date=date.trim();
    per=per.trim();
    link=link.trim();
    unit=unit.trim();
    desc=desc.trim();
    info=info.trim();
    note=note.trim();
    if(name==''){
        alert('Vui lòng nhập tên chương trình!');
        document.getElementById('name-pro').focus();
    }
    else{
        if(date==''){
            alert('Vui lòng chọn ngày thực hiện!');
            document.getElementById('date-pro').focus();
        }
        else{
            if(link==''){
                alert('Vui lòng nhập link chương trình!');
                document.getElementById('link-pro').focus();
            }
            else{
                if(desc==''){
                    alert('Vui lòng nhập mô tả chương trình!');
                    document.getElementById('desc-pro').focus();
                }
                else{
                    $.ajax({
                        type: 'POST',
                        url: './program-data.php',
                        data: {
                            id_check: id,
                            name_check: name
                        },
                        success: function(response){
                            if(response!=0){
                                alert('Tên chương trình này đã tồn tại. Vui lòng nhập tên khác!');
                                document.getElementById('name-pro').value='';
                                document.getElementById('name-pro').focus();
                            }
                            else {
                                $.ajax ({
                                    type: 'POST' ,
                                    url: './program-data.php' ,
                                    data:{
                                        name_insert: name,
                                        date: date,
                                        per: per,
                                        link: link,
                                        unit: unit,
                                        desc: desc,
                                        info: info,
                                        note: note
                                    },
                                    success: function (response) {
                                        alert(response); 
                                        $('#information').load(location.href +' #information > *');
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

// Xoa chuong trinh

function deletePro(){
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
        alert('Vui lòng chọn chương trình để thực hiện xóa!');
    }
    else {
        var result=confirm('Bạn chắc chắn muốn xóa những chương trình đã chọn?');
        if(result){
            $.ajax({
                type: 'POST',
                url: './program-data.php',
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

function showEdit(row){
    var i=row.parentNode.parentNode.rowIndex;
    var id=document.getElementById('table').rows[i].cells[1].innerHTML;
    var name=document.getElementById('table').rows[i].cells[2].innerHTML;
    document.getElementById('div-insert-edit').style.display='block';
    document.getElementById('func-program').style.display='block';
    $('#title-insert').html('THÔNG TIN CHƯƠNG TRÌNH '+name+' (ID:'+id+')');
    document.getElementById('btn-save-edit').style.display='block';
    document.getElementById('id-edit').value=id;
    document.getElementById('name-pro').value=name;
    $.ajax({
        type: 'POST',
        url: './program-data.php',
        data: {
            id_show: id
        },
        success: function(response){
            $('#information').html(response);
        }
    });
    updateFindSF(id);
    updateTreeTable(id, name);
}

function saveEdit(){
    var id=document.getElementById('id-edit').value;
    var name=document.getElementById('name-pro').value;
    var date=document.getElementById('date-pro').value;
    var per=document.getElementById('per-pro').value;
    var link=document.getElementById('link-pro').value;
    var unit=document.getElementById('unit-pro').value;
    var desc=document.getElementById('desc-pro').value;
    var info=document.getElementById('info-pro').value;
    var note=document.getElementById('note-pro').value;
    name=name.trim();
    date=date.trim();
    per=per.trim();
    link=link.trim();
    unit=unit.trim();
    desc=desc.trim();
    info=info.trim();
    note=note.trim();
    if(name==''){
        alert('Vui lòng nhập tên chương trình!');
        document.getElementById('name-pro').focus();
    }
    else{
        if(date==''){
            alert('Vui lòng chọn ngày thực hiện!');
            document.getElementById('date-pro').focus();
        }
        else{
            if(link==''){
                alert('Vui lòng nhập link chương trình!');
                document.getElementById('link-pro').focus();
            }
            else{
                if(desc==''){
                    alert('Vui lòng nhập mô tả chương trình!');
                    document.getElementById('desc-pro').focus();
                }
                else{
                    $.ajax({
                        type: 'POST',
                        url: './program-data.php',
                        data: {
                            id_check: id,
                            name_check: name
                        },
                        success: function(response){
                            if(response!=0){
                                alert('Tên chương trình này đã tồn tại. Vui lòng nhập tên khác!');
                                document.getElementById('name-pro').value='';
                                document.getElementById('name-pro').focus();
                            }
                            else {
                                $.ajax ({
                                    type: 'POST' ,
                                    url: './program-data.php' ,
                                    data:{
                                        id_edit_pro: id,
                                        name: name,
                                        date: date,
                                        per: per,
                                        link: link,
                                        unit: unit,
                                        desc: desc,
                                        info: info,
                                        note: note
                                    },
                                    success: function (response) {
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

function updateTreeTable(id, name){
    $.ajax({
        type: 'POST',
        url: './program-data.php',
        data: {
            id_show_func: id, 
            name_pro_tree: name
        },
        success: function(response){
            $('#ul-tree').html(response);
        }
    });
    $.ajax({
        type: 'POST',
        url: './program-data.php',
        data: {
            id_table_func: id
        },
        success: function(response){
            $('.row-func').remove();
            $('#FuncTable').append(response);
        }
    });
}

function openFunc(id){
    var id_tree=id;
    $.ajax({
        type: 'POST',
        url: './program-data.php',
        data: {
            id_tree: id_tree
        },
        success: function(response){
            $('.row-func').remove();
            $('#FuncTable').append(response);
        }
    });
}

function findFunc(){
    var id=document.getElementById('find-id-func').value;
    var name=document.getElementById('find-name-func').value;
    var parent=document.getElementById('find-parent-func').value;
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
        url: './program-data.php',
        data: {
            id_find_func: id,
            name_find_func: name, 
            parent_find_func: parent
        },
        success: function(response){
            $('.row-func').remove();
            $('#FuncTable').append(response);
        }
    });
}

function openFormFunc(){
    document.getElementById('div-insert-func').style.display='flex';
    $('#title-func').html('THÊM CHỨC NĂNG CHƯƠNG TRÌNH');
    document.getElementById('btn-save-insert-func').style.display='block';
    var id=document.getElementById('id-edit').value;
    updateSelectF(id);
}


// Them chuc nang

function insertFunc(){
    var id_func=document.getElementById('id-edit-func').value;
    var id_pro=document.getElementById('id-edit').value;
    var name=document.getElementById('name-func').value;
    var link=document.getElementById('link-func').value;
    var desc=document.getElementById('desc-func').value;
    var parent=document.getElementById('parent-func').value;
    var name_pro=document.getElementById('all').innerHTML;
    name=name.trim();
    link=link.trim();
    desc=desc.trim();
    parent=parent.trim();
    if(name==''){
        alert('Vui lòng nhập tên chức năng!');
    }
    else {
        $.ajax({
            type: 'POST',
            url: './program-data.php',
            data: {
                id_check_func: id_func,
                id_pro_func: id_pro,
                name_func_check: name,
                parent_check: parent
            },
            success: function(response){
                if(response!=0){
                    alert('Chức năng này đã tồn tại. Vui lòng nhập tên khác!');
                    document.getElementById('name-func').value='';
                    document.getElementById('name-func').focus();
                }
                else {
                    $.ajax({
                        type: 'POST',
                        url: './program-data.php',
                        data: {
                            id_pro_func: id_pro,
                            name_func_insert: name,
                            link: link,
                            desc: desc,
                            parent: parent
                        },
                        success: function(response){
                            alert(response);
                            updateFindSF(id_pro);
                            updateTreeTable(id_pro, name_pro);
                            resetInsert();
                            updateSelectF(id_pro);
                        }
                    });
                }
            }
        });
    }
}

function deleteFunc(){
    var rowCount=$('#FuncTable tr').length;
    var check=0;
    var id_delete=[];
    var name_delete=[];
    var id_pro=document.getElementById('id-edit').value;
    var name_pro=document.getElementById('all').innerHTML;
    for(var i=0; i<rowCount-2; i++){
        const choose=document.getElementsByClassName('choose-func');
        if(choose[i].checked==true){
            id_delete.push(document.getElementById('FuncTable').rows[i+2].cells[1].innerHTML);
            name_delete.push(document.getElementById('FuncTable').rows[i+2].cells[2].innerHTML);
            check++;
        }
    }
    if(check==0){
        alert('Vui lòng chọn chức năng để thực hiện xóa!');
    }
    else {
        var result=confirm('Bạn chắc chắn muốn xóa những chức năng đã chọn?');
        if(result){
            $.ajax({
                type: 'POST',
                url: './program-data.php',
                data: {
                    id_delete_func: id_delete,
                },
                success: function(response){
                    alert(response);
                    updateFindSF(id_pro);
                    updateTreeTable(id_pro, name_pro);
                }
            });
        }
    }
}


function editFunc(row){
    document.getElementById('div-insert-func').style.display='flex';
    document.getElementById('btn-save-edit-func').style.display='block';
    var i=row.parentNode.parentNode.rowIndex;
    var id_pro=document.getElementById('id-edit').value;
    var id_func=document.getElementById('FuncTable').rows[i].cells[1].innerHTML;
    var name_func=document.getElementById('FuncTable').rows[i].cells[2].innerHTML;
    var name_pro=document.getElementById('all').innerHTML;
    document.getElementById('id-edit-func').value=id_func;
    $('#title-func').html('THÔNG TIN "'+name_func+'" CHƯƠNG TRÌNH '+name_pro);
    $.ajax({
        type: 'POST',
        url: './program-data.php',
        data: {
            id_info_func: id_func,
        },
        success: function(response){
            $.ajax({
                type: 'POST',
                url: './program-data.php',
                data: {
                    id_func_select_edit: id_func,
                    id_pro_edit: id_pro
                },
                success: function(response){
                    $('#parent-func').append(response);
                }
            });
            $('#info-func').html(response);
        }
    });
    
}

// Luu cap nhat chuc nang
function saveFunc(){
    var name_ct=document.getElementById('all').innerHTML;
    var id=document.getElementById('id-edit-func').value;
    var id_ct=document.getElementById('id-edit').value;
    var name=document.getElementById('name-func').value;
    var link=document.getElementById('link-func').value;
    var desc=document.getElementById('desc-func').value;
    var parent=document.getElementById('parent-func').value;
    name=name.trim();
    link=link.trim();
    desc=desc.trim();
    if(name==''){
        alert('Vui lòng nhập tên chức năng!');
    }    
    else {
        $.ajax({
            type: 'POST',
            url: './program-data.php',
            data: {
                id_save_func: id,
                name: name,
                link: link,
                desc: desc,
                id_parent: parent
            },
            success: function(response){
                alert(response);
                closeFormFunc();
                $('#form-insert').load(location.href + ' #form-insert > *');
                updateFindSF(id_ct);
                updateSelectF(id_ct);
                updateTreeTable(id_ct, name_ct);
            }
        });
    }
}