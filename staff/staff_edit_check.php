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
//前ページからデータ受け取り
  $staff_code=$_POST['code'];
  $staff_name=$_POST['name'];
  $staff_pass=$_POST['pass'];
  $staff_pass2=$_POST['pass2'];

//サニタイジング
  $staff_name=htmlspecialchars($staff_name,ENT_QUOTES,'UTF-8');
  $staff_pass=htmlspecialchars($staff_pass,ENT_QUOTES,'UTF-8');
  $staff_pass2=htmlspecialchars($staff_pass2,ENT_QUOTES,'UTF-8');

//スタッフ名表示
  if($staff_name=='') {
    print 'スタッフ名が入力されていません。<br>';
  } else {
    print 'スタッフ名：';
  	print $staff_name;
  	print '<br>';
  }

//パスワード表示
  if($staff_pass=='') {
    print 'パスワードが入力されていません。<br>';
  }
//パスワード確認
  if($staff_pass!=$staff_pass2) {
    print 'パスワードが一致しません。<br>';
  }

//空白なら「戻る」。正常なら表示
  if($staff_name==''||$staff_pass==''||$staff_pass!=$staff_pass2) {
    print '<form>';
    print '<form type="button" onclick="history.back()" value="戻る">';
    print '</form>';
  } else {
    $staff_pass=md5($staff_pass);
  	print '<form method="post" action="staff_edit_done.php">';
    print '<input type="hidden" name="code" value="'.$staff_code.'">';
  	print '<input type="hidden" name="name" value="'.$staff_name.'">';
  	print '<input type="hidden" name="pass" value="'.$staff_pass.'">';
  	print '<br>';
  	print '<input type="button" onclick="history.back()" value="戻る">';
  	print '<input type="submit" value="OK">';
  	print '</form>';
  }
   ?>
</body>
</html>
