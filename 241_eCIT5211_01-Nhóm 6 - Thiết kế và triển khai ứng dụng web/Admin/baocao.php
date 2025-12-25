<?php
include 'ketnoi.php'; // Kết nối cơ sở dữ liệu

$message = ""; // Biến để hiển thị thông báo

// Kiểm tra nếu form được submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $report_id = $_POST['report_id'];
    $user_id = $_POST['user_id'];
    $r_date = $_POST['r_date'];
    $orders = $_POST['orders'];
    $revenue = $_POST['revenue'];

    // Chèn dữ liệu vào bảng "report"
    $sql = "INSERT INTO report (report_id, user_id, r_date, revenue, orders) 
            VALUES ('$report_id', '$user_id', '$r_date', '$revenue', '$orders')";

    if ($conn->query($sql) === TRUE) {
        $message = "Thêm báo cáo mới thành công!";
    } else {
        $message = "Lỗi: " . $conn->error;
    }
}


// Lấy dữ liệu từ bảng "report"
$sql = "SELECT * FROM report ORDER BY report_id DESC";
$result = $conn->query($sql);

// Tính tổng doanh thu và tổng số đơn hàng
$sql_summary = "SELECT SUM(revenue) AS total_revenue, SUM(orders) AS total_orders FROM report";
$result_summary = $conn->query($sql_summary);

$total_revenue = 0;
$total_orders = 0;

if ($result_summary->num_rows > 0) {
    $row_summary = $result_summary->fetch_assoc();
    $total_revenue = $row_summary['total_revenue'];
    $total_orders = $row_summary['total_orders'];
}

// Hàm định dạng số
function format_number($number, $currency = false) {
    $formatted = number_format($number, 0, '', '.'); // Bỏ phần thập phân, thay dấu `,` bằng `.` 
    return $currency ? '$' . $formatted : $formatted;
}
?>



            <main class="col-md-10 p-4">
                <h1 class="my-5" style="color: #003366;">Báo cáo thống kê</h1>

                <!-- Hiển thị thông báo -->
                <?php if ($message): ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>

                <!-- Hiển thị tổng doanh thu và tổng số đơn hàng -->
                <div class="row my-4">
                    <div class="col-md-6">
                        <div class="p-4" style="background-color: #023672; color: #fff; border-radius: 8px;">
                            <h5>Revenue</h5>
                            <h2>$<?php echo number_format($total_revenue, 0); ?></h2>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-4" style="background-color: #f8f9fa; color: #023672; border-radius: 8px;">
                            <h5>Orders</h5>
                            <h2><?php echo number_format($total_orders); ?></h2>
                        </div>
                    </div>
                </div>

                <!-- Bảng báo cáo -->
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="text-align: center;" scope="col">Report-id</th>
                                <th style="text-align: center;" scope="col">User-id</th>
                                <th style="text-align: center;" scope="col">Ngày Tạo</th>
                                <th style="text-align: center;" scope="col">Số Đơn Hàng</th>
                                <th style="text-align: center;" scope="col">Tổng Doanh Thu</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result->num_rows > 0): ?>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td style="text-align: center;"><?php echo $row['report_id']; ?></td>
                                        <td style="text-align: center;"><?php echo $row['user_id']; ?></td>
                                        <td style="text-align: center;"><?php echo $row['r_date']; ?></td>
                                        <td style="text-align: center;"><?php echo $row['orders']; ?></td>
                                        <td style="text-align: center;" class="fw-bold" style="color: #94a3b8">
                                            <?php echo '$' . number_format($row['revenue'], 0); ?>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr><td colspan="6">Chưa có báo cáo nào!</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Nút để hiển thị form thêm báo cáo -->
                <div style="float: right; margin-bottom: 20px;">
                    <button id="showFormButton" class="p-2" style="color: #fff; font-weight: 700; background: #023672; border-radius: 5px; margin-right: 20px;">
                        Tạo báo cáo
                    </button>
                </div>

                <!-- Form thêm báo cáo -->
                <div id="addReportForm" style="display: none; margin-top: 20px;">
                    <h3>Thêm báo cáo mới</h3>
                    <form action="" method="POST">
                        <div class="mb-3">
                            <label for="report-id" class="form-label">Report ID</label>
                            <input type="number" class="form-control" id="report-id" name="report_id" required />
                        </div>
                        <div class="mb-3">
                            <label for="user_id" class="form-label">User ID</label>
                            <input type="number" class="form-control" id="user_id" name="user_id" required />
                        </div>
                        <div class="mb-3">
                            <label for="r_date" class="form-label">Ngày tạo</label>
                            <input type="date" class="form-control" id="r_date" name="r_date" required />
                        </div>
                        <div class="mb-3">
                            <label for="orders" class="form-label">Số đơn hàng</label>
                            <input type="number" class="form-control" id="orders" name="orders" required />
                        </div>
                        <div class="mb-3">
                            <label for="revenue" class="form-label">Tổng doanh thu</label>
                            <input type="number" step="0.01" class="form-control" id="revenue" name="revenue" required />
                        </div>
                        <button type="submit" class="btn btn-success">Lưu báo cáo</button>
                    </form>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById("showFormButton").addEventListener("click", function () {
            const form = document.getElementById("addReportForm");
            form.style.display = form.style.display === "none" ? "block" : "none";
        });
    </script>

