<? if ($_SESSION["success"]): ?>
	Thing added!<br />
<? endif; ?>

<table>
	<tr><th>name</th></tr>
<? if ($model): ?>
<? foreach ($model as $value): ?>
	<tr>
		<td>
			<a href="<?=Mvcer::buildUrl('delete',$value->id)?>">delete</a>
		</td>
		<td><?=$value->name?></td>
	</tr>
<? endforeach; ?>
<? endif; ?>
</table>

<a href="<?=Mvcer::buildUrl('add')?>">Add</a>

<? Mvcer::renderView("_partial", array("via" => "renderView"))?>
