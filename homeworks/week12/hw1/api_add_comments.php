<?php
  require_once('conn.php');
  header('Content-type:application/json;charset=utf-8');
  header('Access-Control-Allow-Origin: *'); // CORS
  
  // 檢查有沒有傳入東西
  if(
    empty($_POST['content']) ||
    empty($_POST['nickname']) ||
    empty($_POST['site_key']) 
  ) {
    $json = array(
      "ok" => false,
      "message" => "Please input missing fields"
    );

    $response = json_encode($json); // 轉成 json 格式
    echo $response;
    die();
  }

  $nickname = $_POST['nickname'];
  $site_key = $_POST['site_key'];
  $content = $_POST['content'];
  
  $sql = "INSERT INTO mily_discussions(site_key, nickname, content) VALUES (?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('sss', $site_key, $nickname, $content); // 預防 SQL Injection 攻擊
  $result = $stmt->execute();

  if (!$result) {
    $json = array(
      "ok" => false,
      "message" => $conn->error
    );
    $response = json_encode($json);
    echo $response;
    die();
  };

  $json = array(
    "ok" => true,
    "message" => "Success"
  );

  $response = json_encode($json);
  echo $response;
?>