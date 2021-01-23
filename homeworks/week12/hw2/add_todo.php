<?php
  require_once('conn.php');
  header('Content-type:application/json;charset=utf-8');
  header('Access-Control-Allow-Origin: *'); // CORS
  
  if (empty($_POST['todo'])) { // 如果欄位有缺
    $json = array(
      "ok" => false,
      "message" => "Please input missing fields"
    );

    $response = json_encode($json); // 轉成 json 格式
    echo $response;
    die();
  }

  $todo = $_POST['todo'];
  $sql = "INSERT INTO mily_todolist(todo) VALUES(?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('s', $todo); // 把參數放進去，有幾個字就有幾個 s (s 代表 string，如果要放整數就寫 i，代表 int)
  $result = $stmt->execute();
  if (!$result) {
    $json = array(
      "ok" => false,
      "message" => $conn->error
    );

    $response = json_encode($json);
    echo $response;
    die();
  }

  $json = array(
    "ok" => true,
    "message" => "Success!",
    "id" => $conn->insert_id
  );

  $response = json_encode($json);
  echo $response;
?>