function cancel(){
    var result=confirm('Bạn chắc chắn muốn hủy?');
    if(result){
        location.reload();
    }
}

function closePro(){
    document.getElementById('div-choose-pro').style.display='none';
}

function choosePro(){
    document.getElementById('div-choose-pro').style.display='flex';
}

function chooseGroup(){
    document.getElementById('div-choose-group').style.display='flex';
}

function closeGroup(){
    document.getElementById('div-choose-group').style.display='none';
}


function closeTree(){
    document.getElementById('div-tree').style.display='none';
}

function showTreeFunc(){
    var id_pro=document.getElementById("id-pro-auth").value;
    if(id_pro!=''){
        document.getElementById('div-tree').style.display='flex';
        $.ajax({
            type: 'POST',
            url: './auth-group-data.php',
            data: {
                id_pro_tree: id_pro
            },
            success: function(response){
                $('#ul-tree').html(response);
            }
        });
    }
    else {
        alert('Vui lòng chọn một chương trình!');
    }
}

// Chon nhom
function chooseGroupAuth(row){
    var i=row.parentNode.parentNode.rowIndex;
    var id=document.getElementById('table-group').rows[i].cells[0].innerHTML;
    var name=document.getElementById('table-group').rows[i].cells[1].innerHTML;
    document.getElementById('name-group').value=name;
    document.getElementById('id-group-auth').value=id;
    document.getElementById('div-choose-group').style.display='none';
    reloadAuth();
}

function reloadAuth(){
    $('#form-authority').load(location.href +' #form-authority > *');
    document.getElementById('form-authority').style.pointerEvents='none';
    document.getElementById('form-authority').style.opacity='0.7';
}

// Hiện bảng phân quyền
function showAuth(){
    var id_group=document.getElementById('id-group-auth').value;
    var id_pro=document.getElementById('id-pro-auth').value;
    var group=document.getElementById('name-group').value;
    var pro=document.getElementById('name-pro').value;
    if(group==''){
        alert('Vui lòng chọn một nhóm để phân quyền!');
    }
    else {
        if(pro==''){
            alert('Vui lòng chọn một chương trình để phân quyền!');
        }
        else {
            $.ajax({
                type: 'POST',
                url: './auth-group-data.php',
                data: {
                    id_pro_unit: id_pro,
                    id_group_unit: id_group
                },
                success: function(response){
                    document.getElementById('unit-type').value=response;
                    document.getElementById('form-authority').style.pointerEvents='all';
                    document.getElementById('form-authority').style.opacity='1';
                    $.ajax({
                        type: 'POST',
                        url: './auth-group-data.php',
                        data: {
                            id_group: id_group,
                            id_pro: id_pro
                        },
                        success: function(response){
                            $('.row-func-auth').remove();
                            $('#table-func').append(response);
                        }
                    });
                    $.ajax({
                        type: 'POST',
                        url: './auth-group-data.php',
                        data: {
                            id_pro_select: id_pro
                        },
                        success: function(response){
                            $("#parent-func").html(response);
                        }
                    });
                }
            });
        }
    }
}

function findGroup(){
    var id=document.getElementById('find-id-group').value;
    var name=document.getElementById('find-name-group').value;
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
        url: './auth-group-data.php',
        data: {
            id_find_group: id,
            name: name
        },
        success: function(response){
            $('.row-group').remove();
            $('#table-group').append(response);
        }
    });
}
// Tìm chuong trinh
function findPro(){
    var id=document.getElementById('find-id-pro').value;
    var name=document.getElementById('find-name-pro').value;
    var per=document.getElementById('find-per-pro').value;
    var unit=document.getElementById('find-unit-pro').value;
    var date=document.getElementById('find-date-pro').value;
    var desc=document.getElementById('find-desc-pro').value;
    id=id.trim();
    name=name.trim();
    per=per.trim();
    unit=unit.trim();
    date=date.trim();
    desc=desc.trim();
    if(id==''){
        id='%';
    }
    if(name==''){
        name='%';
    }
    if(per==''){
        per='%';
    }
    if(unit==''){
        unit='%';
    }
    if(date==''){
        date='%';
    }
    if(desc==''){
        desc='%';
    }
    $.ajax({
        type: 'POST',
        url: './auth-group-data.php',
        data: {
            id_find_pro: id,
            name: name,
            per: per,
            unit: unit,
            date: date,
            desc: desc
        },
        success: function(response){
            $('.row-pro').remove();
            $('#table-pro').append(response);
        }
    });
}

function insertGroup(row){
    var i=row.parentNode.parentNode.rowIndex;
    var id=document.getElementById('table-pro').rows[i].cells[0].innerHTML;
    var name=document.getElementById('table-pro').rows[i].cells[1].innerHTML;
    document.getElementById('name-pro').value=name;
    document.getElementById('id-pro-auth').value=id;
    document.getElementById('div-choose-pro').style.display='none';
    reloadAuth();
}

function findFunc(){
    var id_pro=document.getElementById('id-pro-auth').value;
    var id_group=document.getElementById('id-group-auth').value;
    var id_func_find=document.getElementById('id-func').value;
    var name=document.getElementById('name-func').value;
    var id_parent=document.getElementById('parent-func').value;
    var desc=document.getElementById('desc-func').value;
    var view_func=document.getElementById('view').checked;
    var edit_func=document.getElementById('edit').checked;
    var delete_func=document.getElementById('delete').checked;
    var deny_view=document.getElementById('deny-view').checked;
    var deny_edit=document.getElementById('deny-edit').checked;
    var deny_delete=document.getElementById('deny-delete').checked;
    id_func_find=id_func_find.trim();
    name=name.trim();
    desc=desc.trim();
    if(id_func_find==''){
        id_func_find='%';
    }
    if(name==''){
        name='%';
    }
    if(id_parent==''){
        id_parent='%';
    }
    if(desc==''){
        desc='%';
    }
    if(view_func==true){
        view_func=1;
    }
    else{
        view_func='%';
    }
    if(edit_func==true){
        edit_func=1;
    }
    else{
        edit_func='%';
    }
    if(delete_func==true){
        delete_func=1;
    }
    else{
        delete_func='%';
    }
    if(deny_view==true){
        deny_view=1;
    }
    else{
        deny_view='%';
    }
    if(deny_edit==true){
        deny_edit=1;
    }
    else{
        deny_edit='%';
    }
    if(deny_delete==true){
        deny_delete=1;
    }
    else{
        deny_delete='%';
    }
    $.ajax({
        type: 'POST',
        url: './auth-group-data.php',
        data: {
            id_pro_find: id_pro,
            id_group_find: id_group,
            id_func_find: id_func_find,
            name: name,
            id_parent: id_parent,
            desc: desc,
            view_func: view_func,
            edit_func: edit_func,
            delete_func: delete_func,
            deny_view: deny_view,
            deny_edit: deny_edit,
            deny_delete: deny_delete
        },
        success: function(response){
            document.getElementById('view').checked=false;
            document.getElementById('edit').checked=false;
            document.getElementById('delete').checked=false;
            document.getElementById('deny-view').checked=false;
            document.getElementById('deny-edit').checked=false;
            document.getElementById('deny-delete').checked=false;
            $.ajax({
                type: 'POST',
                url: './auth-group-data.php',
                data: {
                    id_pro_select: id_pro
                },
                success: function(response){
                    $("#parent-func").html(response);
                }
            });
            $('.row-func-auth').remove();
            $('#table-func').append(response);
        }
    });
}
// Luu phan quyen
function saveAuth(){
    var rowcount=$("#table-func tr").length;
	var id_nhom=document.getElementById('id-group-auth').value;
	var id_ct=document.getElementById("id-pro-auth").value;
    var unit=document.getElementById('unit-type').value;
	var sql=[];
    if(unit==''){
        alert('Vui lòng chọn loại đơn vị sử dụng quyền!');
    }
    else{
        for(var i=2;i<rowcount; i++){	
            var id_cn=document.getElementById("table-func").rows[i].cells[0].innerHTML;
            var edit="edit"+(i-1);
            var view="view"+(i-1);
            var del="delete"+(i-1);
            var deny_edit="deny-edit"+(i-1);
            var deny_view="deny-view"+(i-1);
            var deny_del="deny-delete"+(i-1);
            var e=document.getElementById(edit).checked;
            if(e==true){
                e=1;
            }
            else{
                e=0;  
            }
            var v=document.getElementById(view).checked;
            if(v==true){
                v=1;
            }
            else{
                v=0;
            }
            var d=document.getElementById(del).checked;
            if(d==true){
                d=1;
            }
            else{
                d=0;
            }
            var de=document.getElementById(deny_edit).checked;
            if(de==true){
                de=1;
            }
            else{
                de=0;
            }
            var dv=document.getElementById(deny_view).checked;
            if(dv==true){
                dv=1;
            }
            else{
                dv=0;
            }
            var dd=document.getElementById(deny_del).checked;
            if(dd==true){
                dd=1;
            }
            else{
                dd=0;
            }
            query="UPDATE PHANQUYEN_NHOM SET XEM="+v+", SUA="+e+", XOA="+d+", KHONGXEM="+dv+", KHONGSUA="+de+", KHONGXOA="+dd+" WHERE ID_NHOM="+id_nhom+" AND ID_CN="+id_cn;
            sql.push(query);
        }
        $.ajax({
            type: 'POST',
            url: './auth-group-data.php',
            data: {
                sql: sql,
                unit: unit,
                id_nhom: id_nhom,
                id_ct: id_ct
            },
            success: function(response){
                alert(response);
                showAuth();
                document.getElementById('checkbox-allow').checked=false;
                document.getElementById('checkbox-block').checked=false;
            }
        });
    }
}
// Cho phep tat ca
function checkAllow(){
    var check=document.getElementById('checkbox-allow').checked;
    var id_group_allow=document.getElementById('id-group-auth').value;
	var id_pro_allow=document.getElementById("id-pro-auth").value;
    var rowcount=$("#table-func tr").length;
    if(check==true){
        document.getElementById('checkbox-block').checked=false;
        for(var i=2;i<rowcount;i++){
            document.getElementById('view'+(i-1)+'').checked=true;
            document.getElementById('edit'+(i-1)+'').checked=true;
            document.getElementById('delete'+(i-1)+'').checked=true;
        }
    }
    else {
        var id_func_allow=[];
        for(var i=2;i<rowcount; i++){
            id_func_allow.push(document.getElementById('table-func').rows[i].cells[0].innerHTML);
        }
        $.ajax({
            type: 'POST',
            url: './auth-group-data.php',
            data: {
                id_group_allow: id_group_allow,
                id_func_allow: id_func_allow
            },
            success: function(response){
                $('.row-func-auth').remove();
                $('#table-func').append(response);
            }
        });
    }
}
// Chan tat ca
function checkBlock(){
    var check=document.getElementById('checkbox-block').checked;
    var id_group_allow=document.getElementById('id-group-auth').value;
	var id_pro_block=document.getElementById("id-pro-auth").value;
    var rowcount=$("#table-func tr").length;
    if(check==true){
        document.getElementById('checkbox-allow').checked=false;
        for(var i=2;i<rowcount;i++){
            document.getElementById('deny-view'+(i-1)+'').checked=true;
            document.getElementById('deny-edit'+(i-1)+'').checked=true;
            document.getElementById('deny-delete'+(i-1)+'').checked=true;
        }
    }
    else {
        var id_func_allow=[];
        for(var i=2;i<rowcount; i++){
            id_func_allow.push(document.getElementById('table-func').rows[i].cells[0].innerHTML);
        }
        $.ajax({
            type: 'POST',
            url: './auth-group-data.php',
            data: {
                id_group_allow: id_group_allow,
                id_func_allow: id_func_allow
            },
            success: function(response){
                $('.row-func-auth').remove();
                $('#table-func').append(response);
            }
        });
	}
}

