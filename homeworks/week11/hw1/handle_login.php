<?php
  session_start(); // 啟動 session
  require_once('_conn.php');
  require_once('_utils.php');

  $username = $_POST['username'];
  $password = $_POST['password'];
  
  if (empty($username) || empty($password)) {
    header('Location: login.php?errCode=1'); // 資料不齊全的處理頁面
    die();
  }

  $sql = 'SELECT * FROM mily_users WHERE username = ?';  // 找出資料表裡所有符合 $_POST['username'] 條件的資料
  $stmt = $conn->prepare($sql); // 防範 SQL Injection 的步驟
  $stmt->bind_param('s', $username); // 把參數放進去
  $result = $stmt->execute();
  if (!$result) {
    die($conn->error);
  }

  $result = $stmt->get_result(); // 防範 SQL Injection 後，要再加上這一行才會把結果拿回來
  if ($result->num_rows === 0) { // 如果沒查到符合的資料（解釋：如果沒有查到這個使用者）
    header('Location: login.php?errCode=2');
    exit(); // 執行到這行後，後面的程式碼皆不會再被執行
  }

 // 有查到使用者，就開始執行後面的動作
  $row = $result->fetch_assoc(); // 找出查到的第一筆資料
  if (password_verify($password, $row['password'])) { // password_verify -> 驗證第一個參數和第二個參數是否相符
    // 登入成功
    /*  
        1. 產生 session id (token)
        2. 把 username 寫入檔案
        3. set-cookie:session-id
    */
    // 相符 = 登入成功
    $_SESSION['username'] = $username; // 設定 session 的變數值
    header('Location: index.php');
  } else {
    header('Location: login.php?errCode=2');
  }
?>