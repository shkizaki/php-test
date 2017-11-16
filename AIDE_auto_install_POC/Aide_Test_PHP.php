<html>
<head>
<meta name="viewport" content="width=640">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo $_SERVER['PHP_SELF'] ?></title>
</htad>
<body style="background-color:#ffffff">
<h1>AIDE-INSTALL</h1>
<?php if ( $_SERVER['REQUEST_METHOD'] != 'POST' ) { ?>

<form method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
<p>
    IPAddress: <input type="text" name="attr1"><br>
    Password : <input type="text" name="attr2"><br>
    <input type="submit" value="Execute">
</p>
</form>

<?php } else { ?>

<pre style="border:1px solid #eee;background-color:#f8f8f8">
<?php
    $output=array();
    $ret=null;
    $command = 'sshpass';
    $command .= " -p " . escapeshellarg( $_POST["attr2"] );
    $command .= " ssh -o StrictHostKeyChecking=no -o UserKnownHostsFile=/dev/null";
    $command .= " root@" . $_POST["attr1"] ;
    $command .= " 'yum list installed | grep aide' > /dev/null";
    htmlspecialchars(exec( $command, $output, $ret ));
    if ($ret == 0) :
        echo "すでにインストール済みです。";
    elseif ($ret != 1) :
        echo "問題がありインストール出来ません。".$ret ;
    else :
        $output=array();
        $ret=null;
        $command = 'sshpass';
        $command .= " -p " . escapeshellarg( $_POST["attr2"] );
        $command .= " ssh -o StrictHostKeyChecking=no -o UserKnownHostsFile=/dev/null";
        $command .= " root@" . $_POST["attr1"] ;
        $command .= " 'yum -y install aide' > /dev/null";
        htmlspecialchars(exec( $command, $output, $ret ));
        if ($ret <> 0) :
            echo "インストールに失敗しました。".$ret ;
        else :
            echo "インストールが成功しました。";
            $output=array();
            $ret=null;
            $command = 'sshpass';
            $command .= " -p " . escapeshellarg( $_POST["attr2"] );
            $command .= " ssh -o StrictHostKeyChecking=no -o UserKnownHostsFile=/dev/null";
            $command .= " root@" . $_POST["attr1"] ;
            $command .= " 'cp -p /etc/aide.conf /etc/aide.conf.back' > /dev/null";
            htmlspecialchars(exec( $command, $output, $ret ));
            if ($ret <> 0) :
                echo "コンフィグファイルのコピーに失敗しました。".$ret ;
            else :
                $output=array();
                $ret=null;
                $command = 'sshpass';
                $command .= " -p " . escapeshellarg( $_POST["attr2"] );
                $command .= " ssh -o StrictHostKeyChecking=no -o UserKnownHostsFile=/dev/null";
                $command .= " root@" . $_POST["attr1"] ;
                $command .= " \"sed -i -e 's/^\\/boot/\\!\\/boot/g' -e 's/^\\/bin/\\!\\/bin/g' -e 's/^\\/sbin/\\!\\/sbin/g' -e 's/^\\/lib/\\!\\/lib/g' -e 's/^\\/lib64/\\!\\/lib64/g' -e 's/^\\/opt/\\!\\/opt/g' -e 's/^\\/root/\\!\\/root/g' /etc/aide.conf\" > /dev/null";
                htmlspecialchars(exec( $command, $output, $ret ));
                if ($ret <> 0) :
                    echo "コンフィグファイルの修正に失敗しました。".$ret ;
                else :
                    echo "AIDEのインストール処理が完了しました。";
                endif;
            endif;
        endif;
    endif;
?></pre>

<?php } ?>
</body>
</html>