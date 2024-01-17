<?php

// if uninstall.php is not called by WordPress, die
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    die;
}


global $wpdb;

$rslt = $wpdb->query("DELETE FROM $wpdb->usermeta WHERE meta_key LIKE '%umb-%'");