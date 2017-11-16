<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>入力内容の確認ページ</title>
</head>
<body>
<?php
//名前を表示する
	echo '<p>名前：' . htmlspecialchars($_POST['handle']) . '</p>';

//性別を表示する
	$clean = array();

	switch ($_POST['sex']){
		case 'male':
		case 'female':
			$clean['sex'] = $_POST['sex'];
			break;
		default:
			/* エラー */
			$clean['sex'] = '不正なデータです';
			break;
	}

	echo '<p>性別：' . $clean['sex'] . '</p>';

//年齢を表示する
	switch ($_POST['age']){
		case '10+':
		case '20+':
		case '30+':
		case '40+':
		case '50+':
		case '60+':
			$clean['age'] = $_POST['age'];
			break;
		default:
			/* エラー */
			$clean['age'] = '入力し直してください。';
			break;
		}

		echo '<p>年齢：' . $clean['age'] . '</p>';

//使用機器を表示する
	echo '<p>使用機器の種類：';
	foreach($_POST['device'] as $value) {
		echo $value . ', ';
	}

//ご感想ご質問を表示する
	echo '<p>ご感想・ご質問：' . htmlspecialchars($_POST['opinion']) . '</p>';
?>
</body>
</html>
