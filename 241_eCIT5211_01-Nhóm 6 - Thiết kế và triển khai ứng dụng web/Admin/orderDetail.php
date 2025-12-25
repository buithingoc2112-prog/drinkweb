<?php
include 'ketnoi.php'; // Kết nối cơ sở dữ liệu

$message = ""; // Biến để hiển thị thông báo

$order_id = $_GET['order_id']; // Lấy order_id từ URL

// Truy vấn thông tin đơn hàng
$order_sql = "SELECT * FROM orders WHERE order_id = $order_id";
$order_result = $conn->query($order_sql);
$order = $order_result->fetch_assoc();

// Truy vấn chi tiết đơn hàng
$order_details_sql = "SELECT * FROM order_detail od
                      WHERE od.order_id = $order_id";
$order_details_result = $conn->query($order_details_sql);
$order_detail = $order_details_result->fetch_all(MYSQLI_ASSOC);


// Láy ra thông tin ngươi mua
$user_sql = "SELECT * FROM user WHERE user_id = " . $order['user_id'];
$user_result = $conn->query($user_sql);
$user = $user_result->fetch_assoc();


?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Milkawa Admin - Thống kê</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
      rel="stylesheet"
    />

    <link rel="stylesheet" href="./css/main.css" />
  </head>
  <body>
    <!-- Navbar -->
    <nav class="navbar navbar-dark">
      <div class="container-fluid">
        <a href="#" class="navbar-brand">
          <img
            src="./images/32f0b3b6bbdc7150ba7ed9c4d9c6b0ad.png"
            alt="Milkawa Logo"
          />
        </a>
        <p class="navbar-text" style="font-weight: 500; color:#fff">Đăng xuất </p>
      </div>
      <div></div>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <!-- Sidebar -->
        <div class="custom-menu">
        <nav>
        <a href="index.php?id=1" class="nav-link">Báo cáo, thống kê</a>
        <a href="index.php?id=2" class="nav-link">Đơn hàng</a>
        <a href="index.php?id=3" class="nav-link">Sản phẩm</a>
        <a href="index.php?id=4" class="nav-link">Tài khoản</a>
    </nav>
</div>

        <main class="col-md-10 p-4">
        <h3 class="text-center mb-5" style="color: #003366;">Chi tiết đơn hàng #<?php echo $order['order_id']; ?></h3>

        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Thông tin khách hàng</h5>
                <p><strong>Tên khách hàng: </strong><?php echo $user['name']; ?></p>
                <p><strong>Địa chỉ: </strong><?php echo $user['address']; ?></p>
                <p><strong>Số điện thoại: </strong><?php echo $user['phone']; ?></p>

                <h5 class="card-title mt-4">Chi tiết sản phẩm trong đơn hàng</h5>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Tên sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Đơn giá</th>
                            <th>Tổng tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $total_amount = 0; // Khởi tạo tổng tiền đơn hàng
                        foreach ($order_detail as $detail) { 
                            $drink_sql = "SELECT * FROM drink WHERE drink_id = " . $detail['drink_id'];
                            $drink_result = $conn->query($drink_sql);
                            $drink = $drink_result->fetch_assoc();
                            
                            $product_total = $drink['price'] * $detail['quantity']; // Tính tổng tiền cho sản phẩm
                            $total_amount += $product_total; // Cộng dồn tổng tiền đơn hàng
                        ?>
                        <tr>
                            <td><?php echo $drink['drink_name']; ?></td>
                            <td><?php echo $detail['quantity']; ?></td>
                            <td><?php echo number_format($drink['price'], 0, ',', '.'); ?> đ</td>
                            <td><?php echo number_format($product_total, 0, ',', '.'); ?> đ</td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>

                <h5 class="card-title mt-4">Thông tin thanh toán</h5>
                <p><strong>Hình thức thanh toán: </strong><?php echo $order['payment_method']; ?></p>
                <p><strong>Ngày đặt hàng: </strong><?php echo date('d-m-Y', strtotime($order['order_date'])); ?></p>
                <p><strong>Tổng tiền: </strong><?php echo number_format($total_amount, 0, ',', '.'); ?> đ</p>

                <div class="d-flex justify-content-between mt-4">
                    <a href="donhang.php" class="btn btn-danger">Quay lại</a>
                    
                </div>
            </div>
        </div>

        </main>
      </div>
    </div>

    <!-- Footer -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.js"></script>
  </body>
</html>

