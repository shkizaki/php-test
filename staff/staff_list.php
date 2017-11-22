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
<!--演習2-->
  <script type="text/javascript">
  function del() {
    if(window.confirm('削除してもよろしいですか？')) {
      document.dlt.submit();
    } else {
      window.alert('キャンセルしました');
    }
  }
  </script>

</head>
<body>
  <?php

  try {
    //DB接続 PDO::setAttribute — 属性を設定するhttp://php.net/manual/ja/pdo.setattribute.php
    $dsn='mysql:dbname=shop;host=localhost;charset=utf8';
    $username="root";
    $password="";
    $dbh=new PDO($dsn, $username, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    //SQL発行
    $sql='SELECT code,name FROM mst_staff WHERE 1';
    $stmt=$dbh->prepare($sql);
    $stmt->execute();
    //DB切断
    $dbh=null;

    print '<h3>スタッフ一覧</h3><br>';

    print '<form method="post" action="staff_branch.php">';
    /*スタッフを1行ずつ$stmtから取り出して表示
    データががなくなったらbreakでループ処理から抜ける
    PDO::FETCH_ASSOC: は、結果セットに 返された際のカラム名で添字を付けた配列を返します。*/
    while(true) {
      $rec=$stmt->fetch(PDO::FETCH_ASSOC);
      if($rec == false) {
        break;
      }
      print '<input type="radio" name="staffcode" value="'.$rec['code'].'">';
    	print $rec['name'];
    	print '<br>';
    }
    print '<input type="submit" name="disp" value="参照">';
    print '<input type="submit" name="add" value="追加">';
    print '<input type="submit" name="edit" value="修正">';
    print '<input type="submit" name="delete" value="削除">';
    print '</form>';


  } catch (Exception $e) {
    print 'ただいま障害が発生しております。';
    exit();

  }

   ?>



   <br>
<!--演習1 -->
   <h3>スタッフ検索</h3>
   <form method="get" action="staff_search.php">
     <input type="text" name="search">
     <input type="submit" value="検索">
   </form>

<!--演習2-->
   <?php

   try {
     //DB接続 PDO::setAttribute — 属性を設定するhttp://php.net/manual/ja/pdo.setattribute.php
     $dsn='mysql:dbname=shop;host=localhost;charset=utf8';
     $username="root";
     $password="";
     $dbh=new PDO($dsn, $username, $password);
     $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
     //SQL発行
     $sql='SELECT code,name FROM mst_staff WHERE 1';
     $stmt=$dbh->prepare($sql);
     $stmt->execute();
     //DB切断
     $dbh=null;

     print '<h3>スタッフ一括削除</h3><br>';

     print '<form name="dlt" method="post" action="staff_deleteall_done.php">';
     /*スタッフを1行ずつ$stmtから取り出して表示
     データががなくなったらbreakでループ処理から抜ける
     PDO::FETCH_ASSOC: は、結果セットに 返された際のカラム名で添字を付けた配列を返します。*/
     while(true) {
       $rec=$stmt->fetch(PDO::FETCH_ASSOC);
       if($rec == false) {
         break;
       }
      print '<input type="checkbox" name="staffcode[]" value="'.$rec['code'].'">';
     	print $rec['name'];
     	print '<br>';

     }
     print '<input type="button" name="deleteall" value="一括削除" onclick="del()"><br>';
     print '</form>';
   } catch (Exception $e) {
     print 'ただいま障害が発生しております。';
     exit();

   }

    ?>
   <a href="../staff_login/staff_top.php">トップメニューへ</a><br>
</body>
</html>
