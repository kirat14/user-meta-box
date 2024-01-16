<?php

/*
Plugin Name: User Meta Box
Description: Welcome to WordPress plugin development.
Plugin URI:  https://moumini.tarik.online
Author:      Tarik Moumini
Version:     1.0
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

define('USERMETABOXDOMAIN', 'user-meta-box');
define('USERMETABOXPATH', plugin_dir_path(__FILE__));


use \yso\classes\UserMetaBox;
use \yso\classes\UMBTextField;
use \yso\classes\UMBSelectField;
use \yso\classes\UMBCheckboxField;

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/includes/umb-autoloader.php';

$user_meta_box = new UserMetaBox('My user meta box');
$fields[] = new UMBTextField(
	'salary_range',
	'yso_salary_range',
	'90000',
	'Salary Range',
	[
		'length' => [
			['salary_range', 5]
		]
	]
);

$fields[] = new UMBTextField(
	'visa_status',
	'yso_visa_status',
	'F1',
	'Visa Status',
	[
		'length' => [
			['visa_status', 2]
		]
	]
);

$fields[] = new UMBSelectField(
	'yso-degree',
	'yso-degree',
	'master',
	['Bachelor', 'Master'],
	'Degree',
	[
		
	]
);

$fields[] = new UMBCheckboxField(
	'yso-admin',
	'yso-admin',
	false,
	'Is admin',
	'This text to be prepended after the checkbox',
	[
		
	]
);


$user_meta_box->add_fields($fields);

$user_meta_box->init();

