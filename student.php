<?php
session_start();

// Khởi tạo mảng nếu chưa có
if (!isset($_SESSION["students"])) {
    $_SESSION["students"] = [];
}

// Xoá từng sinh viên
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["delete"])) {
    $index = $_POST["delete"];
    if (isset($_SESSION["students"]["$index"])) {
        unset($_SESSION["students"]["$index"]);
        $_SESSION["students"] = array_values($_SESSION["students"]); // reset index
    }
    header("Location: student.php");
    exit;
}
// Xoá toàn bộ
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["clear"])) {
  $_SESSION["students"] = [];
  header("Location: student.php");
  exit;
}
// Thêm sinh viên
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["name"], $_POST["mssv"])) {
    $name = trim($_POST["name"]);
    $mssv = trim($_POST["mssv"]);

    if ($name !== "" && is_numeric($mssv)) {
        $_SESSION["students"][] = ["name" => $name, "mssv" => $mssv];
    }

    header("Location: student.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Danh sách sinh viên</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h2>Thêm sinh viên</h2>
  <form id="studentForm" method="POST" action="student.php">
    Họ tên: <input type="text" name="name" required><br><br>
    Mã số sinh viên: <input type="text" name="mssv" required><br><br>
    <input type="submit" value="Lưu">
  </form>

  <h2>Danh sách sinh viên</h2>
  <?php if (!empty($_SESSION["students"])): ?>
    <table>
      <thead>
        <tr>
          <th>STT</th>
          <th>Họ tên</th>
          <th>MSSV</th>
          <th>Thao tác</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($_SESSION["students"] as $index => $sv): ?>
          <tr>
            <td><?= $index + 1 ?></td>
            <td><?= htmlspecialchars($sv["name"]) ?></td>
            <td><?= htmlspecialchars($sv["mssv"]) ?></td>
            <td>
              <form method="POST" class="inline-form">
                <input type="hidden" name="delete" value="<?= $index ?>">
                <button type="submit" class="btn-delete" title="Xoá sinh viên" onclick="return confirm('Xoá sinh viên này?')">❌</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <form method="POST" class="center-form">
      <input type="hidden" name="clear" value="1">
      <button type="submit" onclick="return confirm('Bạn chắc chắn muốn xoá toàn bộ danh sách?')" class="btn-danger">
        🗑️ Xoá toàn bộ danh sách
      </button>
    </form>
  <?php else: ?>
    <p style="text-align:center;">Chưa có sinh viên nào.</p>
  <?php endif; ?>

  <script>
    function isNumeric(value) {
      return /^-?\d+$/.test(value);
    }

    document.getElementById("studentForm").addEventListener("submit", function(e) {
      const name = document.querySelector('input[name="name"]').value.trim();
      const mssv = document.querySelector('input[name="mssv"]').value.trim();

      if (name === "") {
        e.preventDefault();
        alert("Vui lòng nhập họ tên.");
        return;
      }

      if (!isNumeric(mssv)) {
        e.preventDefault();
        alert("Mã số sinh viên phải là số.");
        return;
      }
    });
  </script>
</body>
</html>