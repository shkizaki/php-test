<?php
//ログインチェックからのセッション開始
session_start();
//セッションIDの再生成（セッションハイジャック対策）
session_regenerate_id(true);
/*セッション変数に1が格納されていなければログインせず、
ログイン成功した場合は、「ログイン中」と表示*/
if(isset($_SESSION['login'])==false) {
  print 'ログインしていません。<br>';
  print '<a href="../staff_login/staff_login.html">ログイン画面へ</a>';
  exit();
} else {
  print $_SESSION['staff_name'];
  print 'さんログイン中<br>';
  print '<br>';
}
 ?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>ろくまる農園</title>
</head>
<body>
  スタッフが選択されていません<br>
  <a href="staff_list.php">戻る<a>
</body>

</html>
