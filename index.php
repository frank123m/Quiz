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
<title><?php echo $msgs['title']; ?></title>
</head>

<body>

<p><?php echo $msgs['title']; ?></p>

<?php if ($_SERVER['QUERY_STRING'] == '') : ?>

<p><a href="index.php?step=1"><?php echo $msgs['start']; ?></a></p>

<?php elseif (isset($_GET['step']) && ($_GET['step'] != 5)) : ?>

<p><?php echo $msgs['emu']; ?></p>

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
		<input type="submit" name="submit" value="<?php echo ($_GET['step'] == 4) ? $msgs['result'] : $msgs['next']; ?>">
	</p>
</form>

<?php elseif (isset($_GET['step']) && ($_GET['step'] == 5)) : ?>

<p><?php echo $msgs['ana']; ?></p>

<?php

$a = array('answer1', 'answer2', 'answer3', 'answer4');

foreach ($data2 as $key => $value) {

	if (isset($_COOKIE[$a[$key]])) {

		echo '<p>' . $value[0] . '</p>';
		echo '<p>' . $value[$_COOKIE[$a[$key]]] . '</p>';

		setcookie($a[$key], '', time());

	}

}

?>

<p><a href="./"><?php echo $msgs['restart']; ?></a></p>

<?php endif; ?>

</body>

</html>
