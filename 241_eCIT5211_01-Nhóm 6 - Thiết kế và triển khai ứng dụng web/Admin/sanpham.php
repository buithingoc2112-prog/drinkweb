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

// Xử lý thêm, xóa và sửa sản phẩm
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_product'])) {
        // Thêm sản phẩm
        $name = $_POST['name'];
        $price = $_POST['price'];
        $status = $_POST['status'];

        $stmt = $conn->prepare("INSERT INTO quanlysanpham (name, price, status) VALUES (?, ?, ?)");
        $stmt->bind_param("sis", $name, $price, $status);

        if ($stmt->execute()) {
            header("Location: sanpham.php?status=success");
        } else {
            header("Location: sanpham.php?status=error");
        }
        $stmt->close();
    }

    if (isset($_POST['delete_product'])) {
        // Xóa sản phẩm
        $id = $_POST['product_id'];

        $stmt = $conn->prepare("DELETE FROM quanlysanpham WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            header("Location: sanpham.php?status=success");
        } else {
            header("Location: sanpham.php?status=error");
        }
        $stmt->close();
    }

    if (isset($_POST['edit_product'])) {
        // Sửa sản phẩm
        $id = $_POST['product_id'];
        $name = $_POST['name'];
        $price = $_POST['price'];
        $status = $_POST['status'];

        $stmt = $conn->prepare("UPDATE quanlysanpham SET name = ?, price = ?, status = ? WHERE id = ?");
        $stmt->bind_param("sisi", $name, $price, $status, $id);

        if ($stmt->execute()) {
            header("Location: sanpham.php?status=success");
        } else {
            header("Location: sanpham.php?status=error");
        }
        $stmt->close();
    }
}

// Lấy danh sách sản phẩm
$sql = "SELECT * FROM quanlysanpham";
$result = $conn->query($sql);
?>


            <main class="col-md-10 p-4">
                <h1 class="my-5" style="color: #003366;">Sản phẩm</h1>

                <!-- Product Table -->
                <div class="table-container">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th style="color: #64748b">ID</th>
                                <th style="color: #64748b">TÊN SẢN PHẨM</th>
                                <th style="color: #64748b">GIÁ BÁN</th>
                                <th style="color: #64748b">TRẠNG THÁI</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result->num_rows > 0): ?>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?= $row['id'] ?></td>
                                        <td style="font-weight: 700"><?= $row['name'] ?></td>
                                        <td>$<?= $row['price'] ?></td>
                                        <td>
                                            <span class="status-badge status-available" style="font-weight: 500"><?= $row['status'] ?></span>
                                        </td>
                                        <td>
                                            <form method="post" style="display:inline;">
                                                <input type="hidden" name="product_id" value="<?= $row['id'] ?>">
                                                <button type="submit" name="delete_product" class="btn btn-sm btn-light" style="color: #94a3b8;"><i class="fa-solid fa-trash-can"></i></button>
                                            </form>
                                            <form method="post" action="edit.php" style="display:inline;">
                                                <input type="hidden" name="product_id" value="<?= $row['id'] ?>">
                                                <button type="submit" name="edit_product" class="btn btn-sm btn-light" style="color: #94a3b8;"><i class="fa-solid fa-pen-to-square"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center">Không có sản phẩm nào</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Nút để hiển thị form thêm sản phẩm -->
                <div class="d-flex justify-content-end">
                    <button class="btn btn-success" style="font-weight: 600; background-color: #003366; margin-top: 20px; color: #fff; padding: 5px 15px; border-radius: 5px;" onclick="document.getElementById('addProductForm').style.display='block'">Thêm Sản phẩm</button>
                </div>

                <!-- Form thêm sản phẩm -->
                <div id="addProductForm" style="display:none; margin-top:20px;">
                    <h3>Thêm sản phẩm mới</h3>
                    <form method="post" class="my-4">
                        <div class="mb-3">
                            <label for="name" class="form-label">Tên sản phẩm</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Giá bán</label>
                            <input type="number" name="price" id="price" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Trạng thái</label>
                            <select name="status" id="status" class="form-control">
                                <option value="Còn hàng">Còn hàng</option>
                                <option value="Hết hàng">Hết hàng</option>
                            </select>
                        </div>
                        <button type="submit" name="add_product" class="btn btn-success">Thêm sản phẩm</button>
                    </form>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.js"></script>
</body>
</html>
