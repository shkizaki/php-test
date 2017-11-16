<?php
session_start();
?>
<?php
if ( $_SERVER['REQUEST_METHOD'] != 'POST' ) {
  echo "不正なアクセスです。";
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>ロールバックのページ</title>
</head>
<body>
<?php
//rollback
$output = array();
$return_var = null;
$command = 'sshpass';
$command .= " -p" . escapeshellarg( $_SESSION['password'] );
$command .= " ssh -o StrictHostKeyChecking=no -o UserKnownHostsFile=/dev/null";
$command .= " root@" . escapeshellarg( $_SESSION['ipaddr'] );
$command .= "mv /etc/firewalld/zones/public.xml.old /etc/firewalld/zones/public.xml"
$command .= " > /dev/null 2>&1";
htmlspecialchars( exec( $command,$output,$return_var ) );
if ( $return_var == 0 ){
  echo "ロールバックに成功しました。"
} else {
  header('Location: rollbackerror.html');
}

?>

<p><b>再度実行する場合は、「戻る」を押してください。</b></p>
<p><b>終了する場合は、「OK」を押してください。</b></p>
<button onClick="location.href='input.html'">戻る</button>
<button onClick="location.href='input.html'">OK</button>

</body>
</html>
