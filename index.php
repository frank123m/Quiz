<?php
require_once 'data.php';

if (isset($_GET['submit'])) {

	$query = $_SERVER['QUERY_STRING'];
	$q = substr($query, 0, 7);
	$ans = substr($query, 8, 1);
	$next = substr($q, 6, 1) + 1;

	setcookie($q, $ans, time() + 3600);
	header('Location: index.php?step=' . $next);
	exit; /* 雖然跳轉了, 但是底下還是會執行, 所以用這一行跳離. */

}

?>

<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>心理測驗</title>
</head>

<body>

<?php if ($_SERVER['QUERY_STRING'] == '') : ?>

<p>心理測驗：</p>
<p><a href="index.php?step=1">準備好了嗎？請按此開始測驗！</a></p>

<?php elseif (isset($_GET['step']) && ($_GET['step'] != 5)) : ?>

<p>假如你是一支兔子：</p>

<?php

$c_name = 'answer' . $_GET['step']; /* 設定 cookie 名稱 */
$q_index = $_GET['step'] - 1; /* 設定問題索引值 */

$question = $data1[$q_index][0];
$ans1 = $data1[$q_index][1];
$ans2 = $data1[$q_index][2];
$ans3 = $data1[$q_index][3];

?>

<form method="get">
	<p><?php echo $question; ?></p>
	<p>
		<input type="radio" name="<?php echo $c_name; ?>" value="1" checked="checked"><?php echo $ans1; ?><br>
		<input type="radio" name="<?php echo $c_name; ?>" value="2"><?php echo $ans2; ?><br>
		<input type="radio" name="<?php echo $c_name; ?>" value="3"><?php echo $ans3; ?>
	</p>
	<p>
		<input type="submit" name="submit" value="下一步">
	</p>
</form>

<?php elseif (isset($_GET['step']) && ($_GET['step'] == 5)) : ?>

<p>分析結果：</p>

<?php

$a = array('answer1', 'answer2', 'answer3', 'answer4');

if (isset($_COOKIE[$a[0]], $_COOKIE[$a[1]], $_COOKIE[$a[2]], $_COOKIE[$a[3]])) {

	foreach ($data2 as $key => $value) {

		echo '<p>' . $value[0] . '</p>';
		echo '<p>' . $value[$_COOKIE[$a[$key]]] . '</p>';

	}

}

setcookie('answer1', '', time() - 1);
setcookie('answer2', '', time() - 1);
setcookie('answer3', '', time() - 1);
setcookie('answer4', '', time() - 1);

?>

<p><a href="./">重來一次!</a></p>

<?php endif; ?>

</body>

</html>
