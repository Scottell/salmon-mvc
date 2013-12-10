<html>
<head>
<title>Sample - Index</title>
</head>
<body>
<?php
global $models;
?>
<? if ($models): ?>
	<table>
<? foreach ($models as $key => $value): ?>
		<tr>
			<td>
				<a href="<?=Mvcer::buildUrl('delete',$value->id)?>">delete</a>
			</td>
			<td><?=$value->name?></td>
		</tr>
<? endforeach; ?>
	</table>
<? endif; ?>
	<a href="<?=Mvcer::buildUrl('add')?>">Add</a>
</body>
</html>