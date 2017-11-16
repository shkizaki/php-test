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

<pre style="border:1px solid #eee;background-color:#f8f8f8"><?php
    $command = './command.sh';
    $command .= " " . escapeshellarg( $_POST['attr1'] );
    $command .= " " . escapeshellarg( $_POST['attr2'] );
    $command .= " 2>&1";
    print_r( htmlspecialchars( shell_exec( $command ) ) );
?></pre>

<?php } ?>
</body>
</html>