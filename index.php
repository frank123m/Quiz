<?php
require_once 'data.php';

if (isset($_GET['submit'])) {

	$query = $_SERVER['QUERY_STRING'];
	$q = substr($query, 0, 7);
	$ans = substr($query, 8, 1);
	$next = substr($q, 6, 1) + 1;

	setcookie($q, $ans, time() + 3600);
	header('Location: index.php?step=' . $next);
	exit;

}

?>

<!doctype html>
<html lang="zh-Hant-TW">

<head>
<meta charset="utf-8">
<title><?= $msgs['title']; ?></title>
</head>

<body>

<p><?= $msgs['title']; ?></p>

<?php if ($_SERVER['QUERY_STRING'] == '') : ?>

	<p><a href="index.php?step=1"><?= $msgs['start']; ?></a></p>

<?php elseif (!isset($_GET['step']) || !in_array($_GET['step'], range(1, 5))) : ?>

	<p><?= $msgs['404']; ?></p>

<?php elseif ($_GET['step'] != 5) : $step = $_GET['step']; $cn = 'answer' . $step; $q_index = $step - 1; ?>

	<p><?= $msgs['emu']; ?></p>

	<form method="get">
		<p><?= $data1[$q_index][0]; ?></p>
		<p>
			<input type="radio" name="<?= $cn; ?>" value="1" checked="checked"><?= $data1[$q_index][1]; ?><br>
			<input type="radio" name="<?= $cn; ?>" value="2"><?= $data1[$q_index][2]; ?><br>
			<input type="radio" name="<?= $cn; ?>" value="3"><?= $data1[$q_index][3]; ?>
		</p>
		<p>
			<input type="submit" name="submit" value="<?= ($step == 4) ? $msgs['result'] : $msgs['next']; ?>">
		</p>
	</form>

<?php else : ?>

	<p><?= $msgs['ana']; ?></p>

	<?php foreach ($data2 as $key => $value) : $cn = 'answer' . ($key + 1); ?>

		<?php if (isset($_COOKIE[$cn])) : ?>

			<p><?= $value[0]; ?></p>
			<p><?= $value[$_COOKIE[$cn]]; ?></p>

			<?php setcookie($cn, '', time()); ?>

		<?php endif; ?>

	<?php endforeach; ?>

	<p><a href="./"><?= $msgs['restart']; ?></a></p>

<?php endif; ?>

</body>

</html>

