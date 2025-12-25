<div class="custom-menu">
    <h4 class="text-center" >ADMIN</h4>
    <nav>
        <a href="index.php?id=1" class="nav-link">Báo cáo, thống kê</a>
        <a href="index.php?id=2" class="nav-link">Đơn hàng</a>
        <a href="index.php?id=3" class="nav-link">Sản phẩm</a>
        <a href="index.php?id=4" class="nav-link">Tài khoản</a>
    </nav>
</div>


<style>
.custom-menu {
    background-color: #f8f9fa; /* Màu nền sáng cho thanh menu */
    padding: 80px 10px; /* Khoảng cách giữa viền và nội dung */
    border-right: 1px solid #ddd; /* Viền phải để phân cách */
    height: 100%;
    display: flex;
    flex-direction: column; /* Đảm bảo các mục menu sẽ xếp theo chiều dọc */
    align-items: flex-start; /* Căn lề trái cho thanh menu */
}

.custom-menu h4 {
    color: #003366; /* Màu chữ cho tiêu đề */
    font-weight: 800;
    font-size: 40px;
    margin-bottom: 20px;
    text-transform: uppercase; /* Viết hoa tiêu đề */
}

.custom-menu nav {
    display: flex;
    flex-direction: column; /* Đảm bảo các mục menu xếp theo chiều dọc */
    align-items: flex-start; /* Căn lề trái cho các mục menu */
    gap: 10px; /* Khoảng cách giữa các mục menu */
    width: 100%; /* Chiếm toàn bộ chiều rộng của menu */
}

.custom-menu .nav-link {
    display: inline-block; /* Mỗi mục menu chiếm một phần riêng */
    color: #003366; /* Màu chữ */
    font-weight: 600; /* Làm đậm chữ */
    font-size: 25px;
    padding: 10px 20px; /* Khoảng cách trong mỗi mục menu */
    text-decoration: none; /* Loại bỏ gạch chân */
    border-radius: 5px; /* Bo góc các mục menu */
    width: 100%; /* Chiếm toàn bộ chiều rộng của menu */
    transition: background-color 0.3s ease; /* Hiệu ứng chuyển màu nền khi hover */
}

.custom-menu .nav-link:hover {
    background-color: #e6f0ff; /* Màu nền khi hover */
    color: #003366; /* Đổi màu chữ khi hover */
}

.custom-menu .nav-link.active {
    background-color: #003366; /* Màu nền của mục đang được chọn */
    color: white; /* Màu chữ của mục đang được chọn */
}

.custom-menu .nav-link:focus {
    outline: none; /* Xóa viền khi focus */
}

</style>