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
  <style>
 .container {
  display: flex;
  flex-direction: row;
  height: 100vh;
}

.menu {
  width: 20%;
  background-color: #f8f9fa;
  border-right: 1px solid #ddd;
  display: flex;
  flex-direction: column;
  justify-content: flex-start; /* Đảm bảo menu được căn lề trên */
}

.content {
  width: 80%;
  padding: 20px;
  display: flex;
  flex-direction: column;
  justify-content: flex-start; /* Căn lề trên cho nội dung chính */
}

.header {
  width: 100%;
}

  </style>
</head>
<body>
  <!-- Header -->
  <div class="header">
    <?php include "header.php"; ?>
  </div>

  <div class="container">
  <!-- Menu -->
  <div class="menu">
    <?php include "menu.php"; ?>
  </div>

  <!-- Nội dung chính -->
  <div class="content">
    <?php include "noidung.php"; ?>
  </div>
</div>

    <?php include "footer.php"; ?>
  
</body>
</html>
