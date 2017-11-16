<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>メール送信</title>
</head>
<body>
<?php
mb_language("Japanese");
mb_internal_encoding("UTF-8");

$to = 'shuhei.kizaki@prosol.jp';
$subject = '入力フォームからの送信';
$body =
  '名前：' . $_SESSION['handle'] . "\n" .
  'メールアドレス：' . $_SESSION['email'] . "\n" .
  '性別：' . $_SESSION['sex'] . "\n" .
  '年齢：' . $_SESSION['age'] . "\n" .
  '機器：' . implode(',', $_SESSION['device']) . "\n" .
  '感想他：' . $_SESSION['opinion'] . "\n";

$result = mb_send_mail($to, $subject, $body);

if ($result) {
  echo ' メールを送信しました ';
} else {
  echo ' メール送信に失敗しました ';
}
session_destroy();
?>
</body>
</html>
