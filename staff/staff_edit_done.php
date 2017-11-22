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
    $staff_code=$_POST['code'];
    $staff_name=$_POST['name'];
    $staff_pass=$_POST['pass'];
    //サニタイジング
    $staff_name=htmlspecialchars($staff_name,ENT_QUOTES,'UTF-8');
    $staff_pass=htmlspecialchars($staff_pass,ENT_QUOTES,'UTF-8');
    //DB接続 PDO::setAttribute — 属性を設定するhttp://php.net/manual/ja/pdo.setattribute.php
    $dsn='mysql:dbname=shop;host=localhost;charset=utf8';
    $username='root';
    $password='';
    $dbh=new PDO($dsn, $username, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    //SQL発行
    $sql='UPDATE mst_staff SET name=?,password=? WHERE code=?';
    $stmt=$dbh->prepare($sql);
    $data[]=$staff_name;
    $data[]=$staff_pass;
    $data[]=$staff_code;
    $stmt->execute($data);
    //DB接断
    $dbh=null;

  } catch (Exception $e) {
    //DBエラー表示
    print 'ただいま障害により大変ご迷惑をおかけしております。';
    exit();
  }

   ?>

   修正しました。<br>
   <br>
   <a href="staff_list.php">戻る</a>
</body>
</html>
