<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Upload file đơn giản</title>
</head>
<body>

<h2>Chọn file để upload</h2>

<form action="" method="POST" enctype="multipart/form-data">
  <input type="file" name="myfile"><br><br>
  <input type="submit" name="upload" value="Upload">
</form>

<?php
if (isset($_POST["upload"])) {
    $target_dir = "uploads/"; // thư mục lưu file
    $target_file = $target_dir . basename($_FILES["myfile"]["name"]);

    // Kiểm tra thư mục tồn tại chưa
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    if (move_uploaded_file($_FILES["myfile"]["tmp_name"], $target_file)) {
        echo "<p style='color:green;'>Upload thành công!</p>";
        echo "Tên file: " . htmlspecialchars($_FILES["myfile"]["name"]);
    } else {
        echo "<p style='color:red;'>Upload thất bại.</p>";
    }
}
?>

</body>
</html>
