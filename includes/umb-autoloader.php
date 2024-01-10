<?php
// Or, using an anonymous function
spl_autoload_register(function ($class) {
	$class_path = str_replace('yso\\', '', $class);
	/* $class_path = str_replace('\\', DIRECTORY_SEPARATOR, $class_path);
	$class_path = str_replace('/', DIRECTORY_SEPARATOR, $class_path); */

	$file = WP_PLUGIN_DIR . '/user-meta-box/includes/' . $class_path . '.php';

	// if the file exists, require it
	if (file_exists($file)) {
		require $file;
	}
});