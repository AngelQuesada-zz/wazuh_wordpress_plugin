<?php

/*
Plugin Name: Wazuh-Task
Description: Selection task plugin for wazuh
Version: 1.0
Author: Angel Quesada
*/

/*
 * Create the plugin table in database when is activated
 */

register_activation_hook( __FILE__, 'my_plugin_create_db' );

function my_plugin_create_db() {
	
    global $wpdb;
    
	$charset_collate = $wpdb->get_charset_collate();
	$table_name = $wpdb->prefix . 'wazuh_task';

	$sql = "CREATE TABLE $table_name (
		id int(9) NOT NULL AUTO_INCREMENT,
		id_md5 char(10) NOT NULL,
		name_md5 char(50) NOT NULL,
		code_md5 char(200) NOT NULL,
		UNIQUE KEY id (id)
	) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );

    $wpdb->insert("wp_wazuh_task", array('id_md5' => '001','name_md5' => 'srvmail','code_md5' => 'bddac79424b4fad646d7fe56a8b5af77'));
    $wpdb->insert("wp_wazuh_task", array('id_md5' => '002','name_md5' => 'srvdatabase','code_md5' => '75ba2cdf8f0d1527afb0b843b0036ba8'));
    $wpdb->insert("wp_wazuh_task", array('id_md5' => '003','name_md5' => 'websrv','code_md5' => 'd6899f6189fab1976f4f40bd246b192d'));
    $wpdb->insert("wp_wazuh_task", array('id_md5' => '004','name_md5' => 'security','code_md5' => 'bc1fe94600e5195725db983fa1dae23e'));
    $wpdb->insert("wp_wazuh_task", array('id_md5' => '005','name_md5' => 'remote','code_md5' => '73e379d2344b6c6f94e6895cf160a186'));
    
}

/*
 * Drop the plugin table from database when is activated
 */

register_deactivation_hook( __FILE__, 'my_plugin_remove_db' );

function my_plugin_remove_db() {

     global $wpdb;
     $table_name = $wpdb->prefix . 'wazuh_task';
     $sql = "DROP TABLE IF EXISTS $table_name";
     $wpdb->query($sql);
     delete_option("my_plugin_db_version");

}   


require_once plugin_dir_path(__FILE__) . 'includes/wt-functions.php';

