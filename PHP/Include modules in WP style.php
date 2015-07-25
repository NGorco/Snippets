// Function loads WP-styled modules
function load_modules($dir_path)
{
	$directories = glob($dir_path . '/*' , GLOB_ONLYDIR);

	foreach ($directories as $dir)
	{
		$plugin_file_name = explode('/', $dir);
		$widgetpath = $dir . '/' . array_pop($plugin_file_name) . '.php';

		if(file_exists($widgetpath))
		{
			require_once $widgetpath;
		}
	}
}