<?php
  function escape($str) {
    return htmlspecialchars($str, ENT_QUOTES);
  }

  // 限制字數，超過字數會自動在後面加上「...」
  function limitTheWords($string, $limit) {
    $string = strip_tags($string); // 去除 HTML 標籤
    $sub_content = mb_substr($string, 0, $limit, 'UTF-8'); // 擷取子字串
    echo $sub_content;  // 顯示處理後的摘要文字
    if (strlen($string) > strlen($sub_content)) echo ' ...';
  }
?>