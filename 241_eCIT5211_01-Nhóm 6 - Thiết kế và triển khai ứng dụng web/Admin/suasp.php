<?php
// Kết nối tới cơ sở dữ liệu
$host = "localhost:3306";
$username = "root";
$password = "";
$database = "csdl_webandouong1"; // Đổi tên cơ sở dữ liệu

$conn = new mysqli($host, $username, $password, $database);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

if (isset($_POST['product_id'])) {
    $id = $_POST['product_id'];
    $sql = "SELECT * FROM quanlysanpham WHERE id=$id";
    $result = $conn->query($sql);
    $product = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Milkawa Admin - Sửa sản phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="./css/main.css" />
</head>
<body>
    <div class="container my-5">
        <h1 class="text-center">Sửa sản phẩm</h1>

        <form method="post" action="sanpham.php" class="my-4">
            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
            <div class="mb-3">
                <label for="name" class="form-label">Tên sản phẩm</label>
                <input type="text" name="name" id="name" class="form-control" value="<?= $product['name'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Giá bán</label>
                <input type="number" name="price" id="price" class="form-control" value="<?= $product['price'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Trạng thái</label>
                <select name="status" id="status" class="form-control">
                    <option value="Còn hàng" <?= $product['status'] === 'Còn hàng' ? 'selected' : '' ?>>Còn hàng</option>
                    <option value="Hết hàng" <?= $product['status'] === 'Hết hàng' ? 'selected' : '' ?>>Hết hàng</option>
                </select>
            </div>
            <button type="submit" name="edit_product" class="btn btn-primary">Lưu thay đổi</button>
        </form>
    </div>
</body>
</html>