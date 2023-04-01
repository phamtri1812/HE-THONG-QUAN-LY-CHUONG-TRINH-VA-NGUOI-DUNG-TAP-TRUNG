<?php
    $host = '//localhost/orcl';
    $db   = 'PHTRI';
    // $user = '';
    $pass = 'B1812391';
    $charset = 'utf8';
    $conn = oci_connect($db, $pass, $host, $charset);
    if (!$conn){
        echo "Không kết nối được CSDL!!!";
    }
?>