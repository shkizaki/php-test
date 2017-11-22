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

  <script type="text/javascript">
  function disp() {
    if(window.confirm('削除してもよろしいですか？')) {
      document.frm.submit();
    } else {
      window.alert('キャンセルしました');
    }
  }
  </script>

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
   スタッフ削除<br>
   <br>
   スタッフコード：<br>
   <?php print $staff_code; ?>
   <br>
   スタッフ名：<br>
   <?php print $staff_name; ?>
   <br>
   このスタッフを削除してもよろしいですか？<br>
   <br>
   <form name="frm" method="post" action="staff_delete_done.php">
     <input type="hidden" name="code" value="<?php print $staff_code; ?>">
     <input type="button" onclick="history.back()" value="戻る">
     <!--<input type="submit" value="OK">-->
     <input type="button" value="OK" onclick="disp()">
   </form>
</body>
</html>
