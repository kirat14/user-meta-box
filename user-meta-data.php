<?php

/*
Plugin Name: User Meta Data
Description: This plugin simplifies the process of adding additional fields to the WordPress user profile screen by utilizing a JSON file.
Plugin URI:  #
Author:      Tarik Moumini
Author URI: https://moumini.tarik.online
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

use \yso\classes\UserProfileSection;
use \yso\classes\UMBInputField;


define('USERMETABOXDOMAIN', 'user-meta-box');
define('USERMETABOXPATH', plugin_dir_path(__FILE__));


class UserMetaData
{
	private string $json;
	private array $fields;
	function __construct()
	{

	}

	public function init()
	{
		$this->read_json_user_data();
		// Check if a json file exists
		if ($this->json !== false) {
			$obj = json_decode($this->json);

			foreach ($obj as $section) {
				$userProfileSection = new UserProfileSection($section->boxTitle);
				$this->generate_fields($section, $userProfileSection);
				$userProfileSection->init();
			}
		}
	}

	function read_json_user_data()
	{
		$jsonFieldsPath = dirname(plugin_dir_path(__FILE__));
		$this->json = file_get_contents($jsonFieldsPath . "\demo-data.json");
	}

	function generate_fields($section, $userProfileSection)
	{
		foreach ($section->fields as $field) {

			// Check if name or id is set
			if (!isset($field->name) && !isset($field->id))
				continue;
			else {
				if (isset($field->name))
					$field->id = $field->name;
				else
					$field->name = $field->id;
			}
			if (in_array($field->type, ['text', 'email', 'password'])) {
				$this->create_input_field($userProfileSection, $field);
				continue;
			}

			$className = '\yso\classes\UMB' . ucfirst($field->type) . 'Field';

			if ($field->type === 'checkbox') {
				$this->create_checkbox($userProfileSection, $field, $className);
				continue;
			}

			$userProfileSection->fields[] = new $className(
				$field->name,
				$field->id,
				$field->defaultValue,
				$field->options,
				$field->label,
				$field->rules,
				$field->extraAttr
			);
		}
	}

	private function create_input_field($userProfileSection, $field)
	{
		$userProfileSection->fields[] = new UMBInputField(
			$field->name,
			$field->id,
			$field->defaultValue ?? '',
			$field->label ?? '',
			$field->type,
			$field->rules ?? [],
			$field->extraAttr ?? ''
		);
	}

	private function create_checkbox($userProfileSection, $field, $className)
	{
		$userProfileSection->fields[] = new $className(
			$field->name,
			$field->id,
			$field->defaultValue,
			$field->label,
			$field->prepend,
			$field->rules,
			$field->extraAttr
		);
	}



	private function activate()
	{

	}

	private function deactivate()
	{

	}
	private function uninstall()
	{

	}
}

$userMetaData = new UserMetaData();
$userMetaData->init();

// activation
register_activation_hook(__FILE__, array($userMetaData, 'activate'));
// deactivation
register_activation_hook(__FILE__, array($userMetaData, 'deactivate'));







/**
 * My debuggin function
 */
function log_error($object)
{
	error_log(print_r('$object', true));
	error_log(print_r($object, true));
}
