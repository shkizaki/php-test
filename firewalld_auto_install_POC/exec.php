<?php
session_start();
?>
<?php
if ( $_SERVER['REQUEST_METHOD'] != 'POST' ) {
  echo "不正なアクセスです。"
}
?>

// 入力されたポート番号をテキストに落とす
<?php
$portfile = 'ports.txt';
// ファイルをオープンしてコンテンツを取得
$current = file_get_contents($portfile);
//ports.txtにポート番号追加
$current .= $_SESSION['port']
//置換
$current = str_replace(",", "\n", $current)
// 結果をファイルに書き出す
file_put_contents($portfile, $current);
?>

<?php
//portを開けるために呼び出す関数
function portsopen() {
  $output = array();
  $return_var = null;
  $command = 'sshpass';
  $command .= " -p" . escapeshellarg( $_SESSION['password'] );
  $command .= " ssh -o StrictHostKeyChecking=no -o UserKnownHostsFile=/dev/null";
  $command .= " root@" . escapeshellarg( $_SESSION['ipaddr'] );
  $command .= " firewall-cmd --add-port=";
  $command .= "" . escapeshellarg( $_SESSION['port'] );
  $command .= "/tcp --permanent";
  htmlspecialchars( shell_exec( $command,$output,$return_var ) );
}
  //pingチェック
  $output = array();
  $return_var = null;
  $command = 'ping -c 4';
  $command .= " " . escapeshellarg( $_SESSION['ipaddr'] );
  $command .= " > /dev/null 2>&1";
  htmlspecialchars( exec( $command,$output,$return_var ) );
  if ( $return_var != 0 ){
    header('Location: pingerror.html');
  }

  //ポートチェック
  $output = array();
  $return_var = null;
  $command = 'nmap -p 22';
  $command .= " " . escapeshellarg( $_SESSION['ipaddr'] );
  $command .= " | egrep "closed|filtered" |wc -l";
  htmlspecialchars( shell_exec( $command,$output,$return_var ) );
  if ( $return_var != 0 ){
    header('Location: porterror.html');
  }
  //SSHチェック
  $output = array();
  $return_var = null;
  $command = 'sshpass';
  $command .= " -p" . escapeshellarg( $_SESSION['password'] );
  $command .= " ssh -o StrictHostKeyChecking=no -o UserKnownHostsFile=/dev/null";
  $command .= " root@" . escapeshellarg( $_SESSION['ipaddr'] );
  $command .= " hostname";
  htmlspecialchars( shell_exec( $command,$output,$return_var ) );
  if ( $return_var != 0 ){
    header('Location: ssherror.html');
  }

  //バージョンチェック
  $output = array();
  $return_var = null;
  $command = 'sshpass';
  $command .= " -p" . escapeshellarg( $_SESSION['password'] );
  $command .= " ssh -o StrictHostKeyChecking=no -o UserKnownHostsFile=/dev/null";
  $command .= " root@" . escapeshellarg( $_SESSION['ipaddr'] );
  $command .= " uname -r |sed -e 's/^.*el\([0-9]*\).*$/\1/'";
  htmlspecialchars( shell_exec( $command,$output,$return_var ) );
  switch ( $output ){
    case '7':
      echo "firewalldを確認します。";
      $output = array();
      $return_var = null;
      $command = 'sshpass';
      $command .= " -p" . escapeshellarg( $_SESSION['password'] );
      $command .= " ssh -o StrictHostKeyChecking=no -o UserKnownHostsFile=/dev/null";
      $command .= " root@" . escapeshellarg( $_SESSION['ipaddr'] );
      $command .= " firewall-cmd --state";
      htmlspecialchars( shell_exec( $command,$output,$return_var ) );
      if ( $return_var == 0 ){
        echo "すでにインストール済みで起動していたので、ポートを開けます。";
        portopen();

        //while文で処理
        }
      } elseif ( $return_var == 252 ){
        echo "停止していたので、起動します。";
        $output = array();
        $return_var = null;
        $command = 'sshpass';
        $command .= " -p" . escapeshellarg( $_SESSION['password'] );
        $command .= " ssh -o StrictHostKeyChecking=no -o UserKnownHostsFile=/dev/null";
        $command .= " root@" . escapeshellarg( $_SESSION['ipaddr'] );
        $command .= " systemctl start firewalld";
        htmlspecialchars( shell_exec( $command,$output,$return_var ) );
        $command = 'sshpass';
        $command .= " -p" . escapeshellarg( $_SESSION['password'] );
        $command .= " ssh -o StrictHostKeyChecking=no -o UserKnownHostsFile=/dev/null";
        $command .= " root@" . escapeshellarg( $_SESSION['ipaddr'] );
        $command .= " systemctl enable firewalld";
        htmlspecialchars( shell_exec( $command,$output,$return_var ) );

      } elseif ($return_var == 127 ) {
        echo "インストールが必要ですので、インストールします。";
        $command = 'sshpass';
        $command .= " -p" . escapeshellarg( $_SESSION['password'] );
        $command .= " ssh -o StrictHostKeyChecking=no -o UserKnownHostsFile=/dev/null";
        $command .= " root@" . escapeshellarg( $_SESSION['ipaddr'] );
        $command .= " yum -y intsall firewalld";
        htmlspecialchars( shell_exec( $command,$output,$return_var ) );
        if ( $return_var == 0 ){
          echo "インストールが成功しました。起動します。";
          $command = 'sshpass';
          $command .= " -p" . escapeshellarg( $_SESSION['password'] );
          $command .= " ssh -o StrictHostKeyChecking=no -o UserKnownHostsFile=/dev/null";
          $command .= " root@" . escapeshellarg( $_SESSION['ipaddr'] );
          $command .= " systemctl start firewalld";
          htmlspecialchars( shell_exec( $command,$output,$return_var ) );
          if ( $return_var == 0 ){
        }
      }
    break;
    case '5 or 6':
      echo "iptablesをインストールします。";
      $output = array();
      $return_var = null;
      $command = 'sshpass';
      $command .= " -p" . escapeshellarg( $_SESSION['password'] );
      $command .= " ssh -o StrictHostKeyChecking=no -o UserKnownHostsFile=/dev/null";
      $command .= " root@" . escapeshellarg( $_SESSION['ipaddr'] );
      $command .= " service status iptables";
      htmlspecialchars( shell_exec( $command,$output,$return_var ) );
      if ( $return_var == 0 ){
        echo "すでにインストール済みです。";
      }
    break;
    default:
      header('Location: versionerror.html');
  }
  //$command3 = './sshcheck.sh';
  //$command3 .= " " . escapeshellarg( $_SESSION['ipaddr'] );
  //$command3 .= " " . escapeshellarg( $_SESSION['password'] );
  //$command .= " " . escapeshellarg( $_SESSION['port'] );
  //$command3 .= " 2>&1";
  //print_r( htmlspecialchars( shell_exec( $command3 ) ) );
  //$output = ;
  //if ($output == "error") {
  //  <p><b>異常終了しました。このまま終了します。</b></p>
  //  <button onClick="location.href='error.php'">OK</button>
  //} elseif ($output == "restore") {
  //  <p><b>異常終了しました。設定をリストアします。</b></p>
  //  <button onClick="location.href='restore.php'">OK</button>
  //} else {
  //  <p><b>正常終了しました。設定を確認します。</b></p>
  //  <button onClick="location.href='success.php'">OK</button>
  //}


?>
