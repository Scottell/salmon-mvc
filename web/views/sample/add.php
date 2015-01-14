<form method="post" action="<?=Mvcer::buildUrl('add')?>">
	Name: <input type="text" name="name"/>
	<input type="submit" name="" value="Add" />
</form>

<a href="<?=Mvcer::buildUrl('index')?>">Return to index</a>

<?=Mvcer::renderAction("_partial")?>
