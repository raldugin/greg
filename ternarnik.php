<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Document</title>
</head>
<body>


<?php

	$arr = ['name' => 'Alex', 'family' => 'Raldugin'];
	$a = 3;
	$b = 2;
	$val = 'установлена переменная';

	// если $a == $b то присваиваем $c = Foobar, иначе 0
	$c = ($a == $b) ? ' FooBar' : 0;
	var_dump((bool)$c);

?>

<hr>
	<?php foreach ($arr as $key => $value) : ?>
		<h3><?= $key. " - ". $value ?></h3>
	<?php endforeach ?>

<hr>
	<?php if ($a < $b) : ?>
		<h3><?= "a < b" ?></h3>
	<?php else: ?>
		<h3><?= "a > b" ?></h3>
	<?php endif ?>

<hr>
	<?php for ($i = 1; $i <= 5; $i++) : ?>
		<?= $i . " " . mt_rand(1, 1000) . "<br>" ?>
	<?php endfor ?>

<hr>
	<?php switch ($val): case 1: ?>
		<div>1</div>
		<?php break ?>
	<?php case 2: ?>
		<div>2</div>
		<?php break; ?>
	<?php case 3: ?>
		<div>3</div>
		<?php break; ?>
	<?php default: ?>
		<div>123</div>
		<?php break; ?>
	<?php endswitch ?>

<hr>
	<!-- если не установлена переменная $val то присваиваем значение "не усновлена переменная" -->
	<?php echo isset($val) ? $val : "не усновлена переменная" ?>
	<!--	или его сокращенная форма-->
	<?= $val ?? "не усновлена переменная" ?>

</body>
</html>

