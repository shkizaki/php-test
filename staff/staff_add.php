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
  <body>
    スタッフ追加<br>
      <form method="post" action="staff_add_check.php">
      スタッフ名を入力してください：<br>
      <input type="text" name="name" style="width:200px"><br>
      パスワードを入力してください：<br>
      <input type="password" name="pass" style="width:100px"><br>
      パスワードをもう一度入力してください：<br>
      <input type="password" name="pass2" style="width:100px"><br>
      <br>
      <input type="button" onclick="history.back()" value="戻る"><br>
      <input type="submit" value="OK">
    </form>
  </body>
</head>
</html>
