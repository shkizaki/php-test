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
}

if(isset($_POST['disp'])==true) {
//もし何も選択しなければngへ飛ばす(header — 生の HTTP ヘッダを送信する)
  if(isset($_POST['staffcode'])==false) {
    header('Location:staff_ng.php');
    exit();
  }
//参照ページへ飛ばす
  $staff_code=$_POST['staffcode'];
  header('Location:staff_disp.php?staffcode='.$staff_code);
  exit();
}

if(isset($_POST['add'])==true) {
//追加ページへ飛ばす
  header('Location:staff_add.php');
  exit();
}

if(isset($_POST['edit'])==true) {
//もし何も選択しなければngへ飛ばす
  if(isset($_POST['staffcode'])==false) {
    header('Location:staff_ng.php');
    exit();
  }
//修正ページへ飛ばす
  $staff_code=$_POST['staffcode'];
  header('Location:staff_edit.php?staffcode='.$staff_code);
  exit();
}

if(isset($_POST['delete'])==true) {
//もし何も選択しなければngへ飛ばす
  if(isset($_POST['staffcode'])==false) {
    header('Location:staff_ng.php');
    exit();
  }
  //削除ページへ飛ばす
  $staff_code=$_POST['staffcode'];
  header('Location:staff_delete.php?staffcode='.$staff_code);
  exit();
}

/*if(isset($_POST['deleteall'])==true) {
//もし何も選択しなければngへ飛ばす
  if(isset($_POST['staffcode'])==false) {
    header('Location:staff_ng.php');
    exit();
  }
  //削除ページへ飛ばす
  $staff_code=$_POST['staffcode'];
  //var_dump($staff_code);
  header('Location:staff_deleteall_done.php');
  exit();
}*/


 ?>
