<?php

/*
Plugin Name: User Meta Box
Description: Welcome to WordPress plugin development.
Plugin URI:  https://moumini.tarik.online
Author:      Tarik Moumini
Version:     1.0.0
Requires PHP:      8.0
License:     GPLv2 or later
Text Domain: user-meta-box
Domain Path: /languages/

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version
2 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
with this program. If not, visit: https://www.gnu.org/licenses/
*/

// exit if file is called directly
if (!defined('ABSPATH')) {
	exit;
}

require __DIR__ . '/vendor/autoload.php';

use \yso\classes\UserMetaBox;
use \yso\classes\UMBInputField;


define('USERMETABOXDOMAIN', 'user-meta-box');
define('USERMETABOXPATH', plugin_dir_path(__FILE__));



$jsonFieldsPath = dirname(plugin_dir_path(__FILE__));
$json = file_get_contents($jsonFieldsPath . "\demo-data.json");
// Check if a json file exists
if ($json !== false) {
	$obj = json_decode($json);

	$fields = array();
	foreach ($obj as $item) {

		$user_meta_box = new UserMetaBox($item->boxTitle);
		foreach ($item->fields as $field) {
			$type = $field->type;

			// Check if name or id is set
			if(!isset($field->name) && !isset($field->id))
			 continue;
			else {
				if(isset($field->name))
				 $field->id = $field->name;
				else
					$field->name = $field->id;
			}

			if (in_array($type, ['text', 'email', 'password'])) {
				$fields[] = new UMBInputField(
					$field->name,
					$field->id,
					$field->defaultValue ?? '',
					$field->label ?? '',
					$type,
					$field->rules ?? [],
					$field->extraAttr ?? ''
				);
				continue;
			}

			$className = '\yso\classes\UMB' . ucfirst($type) . 'Field';

			if ($type === 'checkbox') {
				$fields[] = new $className(
					$field->name,
					$field->id,
					$field->defaultValue,
					$field->label,
					$field->prepend,
					$field->rules,
					$field->extraAttr
				);
				continue;
			}

			$fields[] = new $className(
				$field->name,
				$field->id,
				$field->defaultValue,
				$field->options,
				$field->label,
				$field->rules,
				$field->extraAttr
			);
		}

		$user_meta_box->add_fields($fields);
		$user_meta_box->init();
	}
}







/**
 * My debuggin function
 */
function log_error($object)
{
	error_log(print_r('$object', true));
	error_log(print_r($object, true));
}
