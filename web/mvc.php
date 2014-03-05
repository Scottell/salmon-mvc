<? 

function load_class($class_name) {

	$fn = "classes/$class_name.class.php";
	if (file_exists($fn)) {
		include $fn;
    }
}
spl_autoload_register("load_class");

Mvcer::run("sample");
?>