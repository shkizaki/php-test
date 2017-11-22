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
  <?php

  try {
    //前ページからデータ受け取り
    $staff_code=$_GET['staffcode'];
//DB接続
    $dsn='mysql:dbname=shop;host=localhost;charset=utf8';
    $username='root';
    $password='';
    $dbh=new PDO($dsn, $username, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
//SQL発行(スタッフコードで絞込み)
    $sql='SELECT name from mst_staff WHERE code=?';
    $stmt=$dbh->prepare($sql);
    $data[]=$staff_code;
    $stmt->execute($data);
/*PDO::FETCH_ASSOC: は、結果セットに 返された際のカラム名で添字を付けた配列を返します
スタッフ名を変数に格納*/
    $rec=$stmt->fetch(PDO::FETCH_ASSOC);
    $staff_name=$rec['name'];
//DB切断
    $dbh=null;

  } catch (Exception $e) {
    print 'ただいま障害が発生しております。';
    exit();
  }

   ?>
   スタッフ修正<br>
   <br>
   スタッフコード：<br>
   <?php print $staff_code; ?>
   <br>
   <br>
   <form method="post" action="staff_edit_check.php">
     <input type="hidden" name="code" value="<?php print $staff_code; ?>">
     スタッフ名：<br />
     <input type="text" name="name" style="width:200px" value="<?php print $staff_name; ?>"><br />
     パスワードを入力してください：<br />
     <input type="password" name="pass" style="width:100px"><br />
     パスワードをもう1度入力してください：<br />
     <input type="password" name="pass2" style="width:100px"><br />
     <br />
     <input type="button" onclick="history.back()" value="戻る">
     <input type="submit" value="OK">
   </form>
</body>
</html>
