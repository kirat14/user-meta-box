<?php

/*
Plugin Name: User Field Creator
Description: This plugin simplifies the process of adding additional fields to the WordPress user profile screen by utilizing a JSON file.
Plugin URI:  #
Author:      Tarik Moumini
Author URI: https://moumini.tarik.online
Version:     1.0.0
Requires PHP:      8.0
License:     GPLv2 or later
Text Domain: user-field-creator
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

use \yso\classes\UserFieldCreator;


define('USERFIELDCREATORDOMAIN', 'user-field-creator');
define('FIELDPREFIX', 'UFC-');
define('USERFIELDCREATORPATH', plugin_dir_path(__FILE__));



/**
 * Loads the User Field Creator class.
 *
 *
 * @return void
 */
function __user_field_creator_instance() {
	UserFieldCreator::instance();
}


if ( class_exists( UserFieldCreator::class ) ) {
	// Initialize the main autoloaded class.
	add_action( 'plugins_loaded', '__user_field_creator_instance' );
}



/**
 * My debuggin function
 */
function log_error($object)
{
	error_log(print_r('--------------------', true));
	error_log(print_r($object, true));
}

