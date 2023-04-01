<?php 
    require_once('./connect/connection.php');
    session_start();
	if(isset($_SESSION['Login'])){
		header('Location:./php/user-acc/user-account.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="shortcut icon" href="./assets/images/logo.png">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/index.css">
    <link rel="stylesheet" href="./assets/font/themify-icons/themify-icons.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <title>Hệ Thống Quản Lý Chương Trình Và Người Dùng Tập Trung</title>
    <script lang="text/javascript">
        function closeLogin(){
            document.getElementById('login').style.display='none';
            $.ajax({
                success: function(){
                    $('.form-login').load(location.href + ' .form-login > *');
                }                
            });
        }

        function openLogin(){
            document.getElementById('login').style.display='flex';
        }

        function showPass(){
            document.getElementById('password-user').type='text';
            document.getElementById('btn-hidden-pass').style.display='block';
            document.getElementById('btn-show-pass').style.display='none';
        }

        function hiddenPass(){
            document.getElementById('password-user').type='password';
            document.getElementById('btn-show-pass').style.display='block';
            document.getElementById('btn-hidden-pass').style.display='none';
        }

        function loginUser(){
            var name=document.getElementById('name-user').value;
            var pass=document.getElementById('password-user').value;
            name=name.trim();
            pass=pass.trim();
            document.getElementById('pass-hidden').value=pass;
            if(name==''){
                alert('Vui lòng nhập tên đăng nhập!');
                document.getElementById('name-user').focus();
            }
            else if(pass==''){
                alert('Vui lòng nhập mật khẩu')
                document.getElementById('password-user').focus();
            }
            else{
                $.ajax({
                    type: 'POST',
                    url: './php/check.php',
                    data: {
                        name_user: name,
                        pass_user: pass
                    },
                    success: function(response){
                        if(response=='ten'){
                            alert('Tên đăng nhập sai!');
                        }
                        else{
                            if(response=='mk'){
                                alert('Mật khẩu sai!');
                            }
                            else {
                                if(response=='yes'){
                                    document.login.submit();
                                }
                                else {
                                    alert('Lỗi rồi!!');
                                }
                            }
                        }
                    }
                });
            }
        }
    </script>
</head>
<body>
    <div id="wrapper">
        <button class="btn-login" onclick="openLogin()">
            <ti class="ti-unlock"></ti>
            Đăng nhập
        </button>
        <div id="content">
            <img src="./assets/images/logo_vnpt_trang.png" alt="VNPT" class="index-logo">
            <p>HỆ THỐNG QUẢN LÝ CHƯƠNG TRÌNH VÀ NGƯỜI DÙNG TẬP TRUNG</p>
        </div>
    </div>
    <div id="login">
        <div class="form-login" id="form-login">
            <button class="btn-close" onclick="closeLogin()">
                <ti class="ti-close"></ti>
            </button>
            <p class="title-login">ĐĂNG NHẬP VÀO HỆ THỐNG</p>
            <div class="content-login">
                <label for="">Tên Đăng Nhập</label>
                <form name="login" action="./php/login.php" method="POST">
                    <input type="text" name="name-user" id="name-user" autocomplete="off">
                    <input type="hidden" name="password-user" id="pass-hidden">
                </form>
                <label for="">Mật Khẩu</label>
                <div style="position: relative;">
                    <input type="password" name="" id="password-user">
                    <button class="btn-show-pass" title="Hiện mật khẩu" id="btn-show-pass" onclick="showPass()">
                        <ti class="ti-eye"></ti>
                    </button>
                    <button class="btn-hidden-pass" title="Ẩn mật khẩu" id="btn-hidden-pass" onclick="hiddenPass()">
                        <ti class="ti-more-alt"></ti>
                    </button>
                </div>
                <div class="btn-login-cancel">
                    <button class="btn-login-user" onclick="loginUser()">
                        Đăng Nhập
                    </button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>