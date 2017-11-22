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
//Day5-6:演習1
  try {

    $kensaku=$_GET['search'];
    //DB接続 PDO::setAttribute — 属性を設定するhttp://php.net/manual/ja/pdo.setattribute.php
    $dsn='mysql:dbname=shop;host=localhost;charset=utf8';
    $username="root";
    $password="";
    $dbh=new PDO($dsn, $username, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    //SQL発行(名前で絞込み)
    $sql= "SELECT name FROM mst_staff WHERE name LIKE ?";
    $stmt=$dbh->prepare($sql);
    $data[]=$kensaku;
    //$stmt->execute($data);
    //$stmt->execute($data);
    $stmt->execute(array("%$data%"));
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

   <br>スタッフ名：<br>
   <?php
   if($staff_name=="") {
     print '対象のスタッフが見つかりませんでした。<br>';
   } else {
     print $staff_name;
   }
    ?>
   <br>
   <br>
   <p><input type="button" onclick="history.back()" value="戻る"></p>
</body>
</html>
