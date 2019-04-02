<!doctype html>
<html lang="ru">
<head>
<meta charset="utf-8">
<?php foreach(self::$css as $key => $value):?>
<link rel="stylesheet" href="app/view/css/<?=$value;?>.css" />
<?php endforeach;?>
<?php foreach(self::$js as $key => $value):?>
<script src="app/view/js/<?=$value;?>.js"></script>
<?php endforeach;?>
<title>Вход в систему</title>
</head>
<body>