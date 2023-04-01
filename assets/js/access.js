function listPro(){
    document.getElementById('func-access').style.display='none';
    document.getElementById('pro-access').style.display='block';
}

function openPro(id){
    document.getElementById('func-access').style.display='block';
    document.getElementById('pro-access').style.display='none';
    var name=document.getElementById(id).innerHTML;
    $('#title-access').html('Quyền Trong Chương Trình'+name);
    var length = id.length;
    var id=id.slice(4,length);
    var id_user=document.getElementById('id-user').value;
    $.ajax({
        type: 'POST',
        url: './access-data.php',
        data: {
            id_pro: id,
            id_user: id_user
        },
        success: function(response){
            $('.row').remove();
            $('#table-access').append(response);
        }
    });
}

function openFunc(id){
    document.getElementById('func-access').style.display='block';
    document.getElementById('pro-access').style.display='none';
    var name=document.getElementById(id).innerHTML;
    $('#title-access').html('Quyền Trên '+name);
    var length = id.length;
    var id=id.slice(5,length);
    var id_user=document.getElementById('id-user').value;
    $.ajax({
        type: 'POST',
        url: './access-data.php',
        data: {
            id_func: id,
            id_user: id_user
        },
        success: function(response){
            $('.row').remove();
            $('#table-access').append(response);
        }
    });
}

function closeForm(){
    document.getElementById('form-info-pro').style.display='none';
}

function infoPro(row){
    document.getElementById('form-info-pro').style.display='flex';
    var i=row.parentNode.parentNode.rowIndex;
    var id=document.getElementById('table-pro').rows[i].cells[0].innerHTML;
    $.ajax({
        type: 'POST',
        url: './access-data.php',
        data: {
            id_pro_info:id
        },
        success: function(response){
            $('.content-info').html(response);
        }
    });
}