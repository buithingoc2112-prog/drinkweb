<?php
// Kết nối cơ sở dữ liệu
$host = "localhost";
$username = "root";
$password = "";
$database = "csdl_webandouong1";

$conn = new mysqli($host, $username, $password, $database);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
?>