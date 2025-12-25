<?php
include 'ketnoi.php'; // Kết nối cơ sở dữ liệu

$message = ""; // Biến để hiển thị thông báo

// Kiểm tra nếu form được submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stmt = $conn->prepare("INSERT INTO user (user_id, name, address, phone, role, password) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssss", $user_id, $name, $address, $phone, $role, $password);

    $user_id = $_POST['user_id'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $role = $_POST['role'];
    $password = $_POST['password'];

if ($stmt->execute()) {
  $message = "Thêm tài khoản mới thành công!";
} else {
  $message = "Lỗi: " . $stmt->error;
}
$stmt->close();
}

// Lấy dữ liệu từ bảng "user"
$sql = "SELECT * FROM user ORDER BY user_id DESC";
$result = $conn->query($sql);
?>

            <main class="col-md-10 p-4">
                <h1 class="my-5" style="color: #003366">Tài khoản</h1>

                <!-- Hiển thị thông báo -->
                <?php if ($message): ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>
                <div class="table-container">
                  <table class="table table-hover">
                    <thead>
                      <tr style="color: #64748b">
                        <th style="text-align: center;color: #64748b">User-id</th>
                        <th style="text-align: center;color: #64748b">Tên</th>
                        <th style="text-align: center;color: #64748b">Địa Chỉ</th>
                        <th style="text-align: center;color: #64748b">Số Điện Thoại</th>
                        <th style="text-align: center;color: #64748b">Vai Trò</th>
                        <th style="text-align: center;color: #64748b">Mật Khẩu</th>
                      </tr>
                    </thead>
                    <tbody>
                       <?php if ($result->num_rows > 0): ?>
                          <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td style="text-align: center;font-weight: 500"><?php echo $row['user_id']; ?></td>
                                <td style="text-align: center;font-weight: 500"><?php echo $row['name']; ?></td>
                                <td style="text-align: center;"><?php echo $row['address']; ?></td>    
                                <td style="text-align: center;"><?php echo $row['phone']; ?></td>                                
                                <td style="text-align: center;"><?php echo $row['role']; ?></td>                                
                                <td style="text-align: center;"><?php echo $row['password']; ?></td>
                                                           
                            </tr>
                          <?php endwhile; ?>
                            <?php else: ?>
                              <tr><td colspan="5">Chưa có tài khoản nào!</td></tr>
                          <?php endif; ?>
                    </tbody>
                  </table>
                </div>

                <div style="float: right; margin-bottom: 20px;">
                        <button id="showFormButton" class="p-2" style="color: #fff; font-weight: 700; background: #023672; border-radius: 5px; margin-right: 20px;">
                            Thêm tài khoản
                        </button>
                </div>

                <div id="addUserForm" style="display: none; margin-top: 20px;">
                        <h3>Thêm tài khoản</h3>
                        <form action="" method="POST">
                            <div class="mb-3">
                                <label for="user-id" class="form-label">User ID</label>
                                <input type="number" class="form-control" id="user-id" name="user_id" required />
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Tên</label>
                                <input type="text" class="form-control" id="name" name="name" required />
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Địa chỉ</label>
                                <input type="text" class="form-control" id="address" name="address" required />
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Số điện thoại</label>
                                <input type="number" class="form-control" id="phone" name="phone" required />
                            </div>
                            <div class="mb-3">
                                <label for="role" class="form-label">Vai trò</label>
                                <select class="form-select" id="role" name="role" required>
                                   <option value="Admin">Admin</option>
                                   <option value="Khách hàng">Khách hàng</option>
                                </select>
                            <div class="mb-3">
                                <label for="password" class="form-label">Mật khẩu</label>
                                <input type="text" class="form-control" id="password" name="password" required />
                            </div>
                            </div>
                            <button type="submit" class="btn btn-success">Lưu tài khoản</button>
                        </form>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.js"></script>
    <script>
        document.getElementById("showFormButton").addEventListener("click", function () {
            const form = document.getElementById("addUserForm");
            form.style.display = form.style.display === "none" ? "block" : "none";
        });
    </script>


