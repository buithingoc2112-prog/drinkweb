<?php
session_start(); // Start the session to manage messages

include 'ketnoi.php'; // Kết nối cơ sở dữ liệu

$message = ""; // Biến để hiển thị thông báo

// Check if a form was submitted (for adding or updating order)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['user_id'], $_POST['order_date'], $_POST['payment_method'], $_POST['order_status'])) {
        // Handle adding or editing the order
        $user_id = $_POST['user_id'];
        $order_date = $_POST['order_date'];
        $payment_method = $_POST['payment_method'];
        $order_status = $_POST['order_status'];

        // Check if this is an update or new order
        if (isset($_POST['order_id']) && !empty($_POST['order_id'])) {
            // Update order
            $order_id = $_POST['order_id'];
            $stmt = $conn->prepare("UPDATE orders SET user_id = ?, order_date = ?, payment_method = ?, order_status = ? WHERE order_id = ?");
            $stmt->bind_param("isssi", $user_id, $order_date, $payment_method, $order_status, $order_id);
            if ($stmt->execute()) {
                $_SESSION['message'] = "Đơn hàng đã được cập nhật thành công!";
            } else {
                $_SESSION['message'] = "Lỗi khi cập nhật đơn hàng!";
            }
        } else {
            // Add new order
            $stmt = $conn->prepare("INSERT INTO orders (user_id, order_date, payment_method, order_status) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("isss", $user_id, $order_date, $payment_method, $order_status);
            if ($stmt->execute()) {
                $_SESSION['message'] = "Đơn hàng đã được thêm thành công!";
            } else {
                $_SESSION['message'] = "Lỗi khi thêm đơn hàng!";
            }
        }
        $stmt->close();
        // Redirect to display message
        header("Location: index.php?id=2");
        exit();
    }
}

// Lấy dữ liệu từ bảng "orders" theo id giảm dần
$sql = "
    SELECT 
        o.order_id, 
        o.user_id, 
        o.order_date, 
        o.order_status, 
        o.payment_method, 
        SUM(od.price * od.quantity) AS total_amount 
    FROM 
        orders o
    LEFT JOIN 
        order_detail od 
    ON 
        o.order_id = od.order_id
    GROUP BY 
        o.order_id
    ORDER BY 
        o.order_id DESC
";
$result = $conn->query($sql);

$orders = $result->fetch_all(MYSQLI_ASSOC);

// Get the message from the session if it exists
$message = isset($_SESSION['message']) ? $_SESSION['message'] : '';
unset($_SESSION['message']); // Clear the message after displaying it
?>

<main class="col-md-10 p-4">
  <h1 class="my-5" style="color: #003366;">Đơn hàng</h1>
  
  <!-- Display success or error message -->
  <?php if ($message): ?>
    <div class="alert alert-info"><?php echo $message; ?></div>
  <?php endif; ?>

  <!-- Product Table -->
  <div class="table-container">
    <table class="table table-hover">
      <thead>
        <tr>
          <th style="color: #94a3b8;">Mã đơn hàng</th>
          <th style="color: #94a3b8;">Mã khách hàng</th>
          <th style="color: #94a3b8;">Thời gian đặt hàng</th>
          <th style="color: #94a3b8;">PTTT</th>
          <th style="color: #94a3b8;">Tổng tiền</th>
          <th style="color: #94a3b8;">Trạng thái</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($orders as $order) { ?>
          <tr>
            <td style="font-weight: 500; color: #94a3b8;"><?php echo "#" . $order['order_id'] ?></td>
            <td style="font-weight: 500; color: #94a3b8;"><?php echo "#" . $order['user_id'] ?></td>
            <td style="color: #94a3b8;"><?php echo $order['order_date'] ?></td>
            <td style="color: #94a3b8;"><?php echo $order['payment_method'] ?></td>
            <td style="color: #94a3b8;font-weight: 500;"><?php echo "$" . number_format($order['total_amount']) ?></td>
            <td>
              <?php
                $statusClass = '';
                switch ($order['order_status']) {
                    case 'Đang chuẩn bị':
                        $statusClass = 'status-preparing';
                        $color = '#e6792a';
                        break;
                    case 'Đang giao':
                        $statusClass = 'status-shipping';
                        $color = '#0d894f';
                        break;
                    case 'Đã giao':
                        $statusClass = 'status-delivered';
                        $color = '#29b9e6';
                        break;
                    case 'Đã hủy':
                        $statusClass = 'status-canceled';
                        $color = 'red';
                        break;
                }
              ?>
              <span class="<?php echo $statusClass; ?>" style="color: <?php echo $color ?>; padding: 5px; background: #fdf1e8; border-radius: 10px;">
                <?php echo $order['order_status']; ?>
              </span>
            </td>
            <td>
              <a href="orderDetail.php?order_id=<?php echo $order['order_id']; ?>" class="btn btn-sm btn-light">
                <i class="fa-solid fa-eye"></i>
              </a>
              <button class="btn btn-sm btn-light edit-order-btn" data-order-id="<?php echo $order['order_id']; ?>" style="margin-left: 5px;">
                <i class="fa-solid fa-pen-to-square"></i>
              </button>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>

  <div style="float: right">
    <button id="showAddOrderForm" class="btn" style="font-weight: 600; background-color: #003366; margin-top:20px; margin-right: 20px; color: #fff; padding: 5px 15px; border-radius: 5px;">
      Thêm đơn hàng
    </button>
  </div>

  <!-- Add Order Form (Initially Hidden) -->
  <div id="addOrderForm" style="display: none; margin-top: 20px; position: fixed; bottom: 0; width: 100%; background: #f8f9fa; padding: 20px;">
    <h3>Thêm đơn hàng</h3>
    <form action="index.php?id=2" method="POST">
      <!-- Form Fields for Adding Order -->
      <div class="mb-3">
        <label for="user-id" class="form-label">Mã khách hàng</label>
        <input type="number" class="form-control" id="user-id" name="user_id" required />
      </div>
      <div class="mb-3">
        <label for="order-date" class="form-label">Thời gian đặt hàng</label>
        <input type="date" class="form-control" id="order-date" name="order_date" required />
      </div>
      <div class="mb-3">
        <label for="payment-method" class="form-label">Phương thức thanh toán</label>
        <input type="text" class="form-control" id="payment-method" name="payment_method" required />
      </div>
      <div class="mb-3">
        <label for="order-status" class="form-label">Trạng thái đơn hàng</label>
        <select class="form-select" id="order-status" name="order_status" required>
          <option value="Đang chuẩn bị">Đang chuẩn bị</option>
          <option value="Đang giao">Đang giao</option>
          <option value="Đã giao">Đã giao</option>
          <option value="Đã hủy">Đã hủy</option>
        </select>
      </div>
      <button type="submit" class="btn btn-success">Lưu đơn hàng</button>
    </form>
  </div>

  <!-- Edit Order Form (Initially Hidden) -->
  <div id="editOrderForm" style="display: none; margin-top: 20px; position: fixed; top: 50%; right: 20px; transform: translateY(-50%); width: 300px; background: #f8f9fa; padding: 20px;">
    <h3>Sửa đơn hàng</h3>
    <form id="editOrderFormFields" action="index.php?id=2" method="POST">
      <!-- Form Fields for Editing Order (dynamic data) -->
      <div class="mb-3">
        <label for="edit-order-id" class="form-label">Mã đơn hàng</label>
        <input type="text" class="form-control" id="edit-order-id" name="order_id" readonly />
      </div>
      <div class="mb-3">
        <label for="edit-order-status" class="form-label">Trạng thái đơn hàng</label>
        <select class="form-select" id="edit-order-status" name="order_status" required>
          <option value="Đang chuẩn bị">Đang chuẩn bị</option>
          <option value="Đang giao">Đang giao</option>
          <option value="Đã giao">Đã giao</option>
          <option value="Đã hủy">Đã hủy</option>
        </select>
      </div>
      <button type="submit" class="btn btn-warning">Cập nhật</button>
    </form>
  </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.js"></script>
<script>
  // Toggle visibility of Add Order Form
  document.getElementById("showAddOrderForm").addEventListener("click", function () {
    const form = document.getElementById("addOrderForm");
    form.style.display = form.style.display === "none" ? "block" : "none";
  });

  // Show Edit Order Form and populate with data
  const editButtons = document.querySelectorAll(".edit-order-btn");
  editButtons.forEach(button => {
    button.addEventListener("click", function () {
      const orderId = this.getAttribute("data-order-id");
      document.getElementById("edit-order-id").value = orderId;
      document.getElementById("editOrderForm").style.display = "block";
    });
  });
</script>
</body>
</html>
