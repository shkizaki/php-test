<?php
echo "処理を開始します。しばらくお待ちください...<br />\n";
echo str_pad(" ",4096)."<br />\n";

ob_end_flush();
ob_start('mb_output_handler');

for ( $i = 1; $i <= 10; $i++ ) {
sleep( 5 );	// 時間がかかる処理
echo $i * 10 ."件の処理を完了しました<br />\n";

ob_flush();
flush();
}
echo "処理が完了しました<br />\n";
?>
#######################################################
// shell_execで下記コマンド実行。
/* tail -f --pid $(cat pidfile | awk '{print $1}') process.log */
<?php
$output = shell_exec('tail -f --pid $(cat pidfile | awk '{print $1}') process.log');
echo "<pre>$output</pre>";
?>
