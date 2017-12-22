<?php

$data = array(
	array(
		'有一天你經過一座橋，橋下風景很漂亮，你會：',
		'慢慢走過去',
		'開開心心蹦蹦跳跳過去',
		'急急忙忙跑過去'
	),
	array(
		'中途遇見一隻兔子，長的漂漂亮亮，躺在路邊一動也不動的，你心裡想：',
		'他在休息',
		'他暈倒了',
		'他死了'
	),
	array(
		'過橋一半的時候，你回家的唯一鑰匙掉到橋下，你會：',
		'奮不顧身的下去撿',
		'在橋上觀望再下去撿',
		'撿都不撿就回家了'
	),
	array(
		'回到家門口，你沒有鑰匙會怎麼辦？',
		'去朋友家',
		'找可能的入口翻進去',
		'等家人回來開門'
	),
);

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
<title>線上心理測驗</title>
</head>

<body>

<?php if ($_SERVER['QUERY_STRING'] == '') : ?>

<p>線上心理測驗：</p>
<p><a href="index.php?step=1">準備好了嗎？請按此開始測驗！</a></p>

<?php elseif (isset($_GET['step']) && ($_GET['step'] != 5)) : ?>

<p>假如你是一支兔子：</p>

<?php

$c_name = 'answer' . $_GET['step']; /* 設定 cookie 名稱 */
$q_index = $_GET['step'] - 1; /* 設定問題索引值 */

$question = $data[$q_index][0];
$ans1 = $data[$q_index][1];
$ans2 = $data[$q_index][2];
$ans3 = $data[$q_index][3];

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

	echo '<p>【人生觀態度】</p>';

	switch ($_COOKIE['answer1']) {
		case '1': echo '<p>你對自己未來沒有把握！總是邊走邊看走一步算一步的那種！</p>'; break;
		case '2': echo '<p>你對自己的未來充滿自信，相信你這一生不會白活才對！</p>'; break;
		case '3': echo '<p>你是為了別人而活！忙忙碌碌過一生，有點可憐！</p>'; break;
	}

	echo '<p>【愛情觀】</p>';

	switch ($_COOKIE['answer2']) {
		case '1': echo '<p>你可能對你的愛情不能專心，常常半路就會放棄跑去睡覺！</p>'; break;
		case '2': echo '<p>你遇到愛情會無法自拔，會墜入愛情的迷網裡！頭腦暈暈的。</p>'; break;
		case '3': echo '<p>你對愛沒啥渴望，心中缺乏愛。</p>'; break;
	}

	echo '<p>【對金錢的看法】</p>';

	switch ($_COOKIE['answer3']) {
		case '1': echo '<p>你貪財如命，會為了錢誤了你的一生。</p>'; break;
		case '2': echo '<p>你對金錢管理會謹慎一點，常會想買一個東西而想好久才買，買了不喜歡的會難過好久！</p>'; break;
		case '3': echo '<p>你對金錢比較不在乎，視金錢如糞土的人用金錢收買不了他的心的！</p>'; break;
	}

	echo '<p>【對家的感覺！包括對家人的態度】</p>';

	switch ($_COOKIE['answer4']) {
		case '1': echo '<p>你對家沒甚麼依賴度 如果發生事情你會找朋友而不會想到家人。</p>'; break;
		case '2': echo '<p>你對家人的態度有時會很不耐煩，但事後又會很後悔，但你還是會想家的。</p>'; break;
		case '3': echo '<p>你的家庭一定很美滿，你跟家人處的很好，彼此會互相照顧，是個很顧家的人！</p>'; break;
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
