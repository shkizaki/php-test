<?php
session_start();
?>
<?php
if ( $_SERVER['REQUEST_METHOD'] != 'POST' ) {
  echo "不正なアクセスです。";
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>入力内容の確認ページ</title>
</head>
<body>
<?php

// IPアドレス表示
  echo '<p> IPアドレス：' . htmlspecialchars($_POST['ipaddr']) . '</p>';

// パスワード表示
  echo '<p> パスワード：*******' . htmlspecialchars($_POST['password'] == '') . '</p>';

// ポート番号表示
  echo '<p> ポート番号：' . htmlspecialchars($_POST['port']) . '</p>';


//$_SESSION に入力データを保存する
$_SESSION['ipaddr'] = $_POST['ipaddr'];
$_SESSION['password'] = $_POST['password'];
$_SESSION['port'] = $_POST['port'];

?>

<p><b>この内容で実行してよろしいですか？</b></p>
<button onClick="history.back();">キャンセル</button>
<button onClick="location.href='exec.php'">OK</button>

</body>
</html>
