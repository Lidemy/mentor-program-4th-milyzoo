<?php
  // 檢查權限
  if (empty($_SESSION['username'])) { // 如果是空的（ = 沒登入）
    header('Location: login.php'); // 就導回登入頁
    exit();
  }
?>