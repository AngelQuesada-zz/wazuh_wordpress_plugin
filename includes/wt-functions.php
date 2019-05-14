<?php

/*
 * Add my new menu to the Admin Control Panel
 */
 
add_action( 'admin_menu', 'wt_Add_My_Admin_Link' );
 
function wt_Add_My_Admin_Link() {

    $url = site_url();


    add_menu_page(
    'Wazuh Task', // Title of the page
    'Wazuh Task', // Text to show on the menu link
    'manage_options', // Capability requirement to see the link
    plugin_dir_path(__FILE__) . '/wt-main.php', // The 'slug' - file to display when clicking the link
    null,
    $url."/wp-content/plugins/wazuh-task/img/logo.png"
    );

}

/*
 * Adds custom CSS and JS to my plugin
 */

add_action( 'admin_enqueue_scripts', 'wpdocs_enqueue_custom_admin_style' ); 

function wpdocs_enqueue_custom_admin_style($hook) {

    if(!strpos($hook, "/includes/wt-main.php"))
        return;
    
    $link = plugin_dir_url(__FILE__) . '../css/styles.css';
    wp_register_style( 'custom_wp_admin_css', $link, false, '1.0' );
    wp_enqueue_style( 'custom_wp_admin_css' );
    
}

function pw_load_scripts($hook) {
    
    
    if(!strpos($hook, "/includes/wt-main.php"))
        return;
    
    $link_js = plugin_dir_url(__FILE__) . '../js/javascript.js';
    wp_enqueue_script( 'custom-js', $link_js);
    
}

add_action( 'admin_enqueue_scripts', 'my_enqueue' );

function my_enqueue($hook) {
    if(!strpos($hook, "/includes/wt-main.php"))
        return;
        
    $link_js = plugin_dir_url(__FILE__) . '../js/javascript.js';

	wp_enqueue_script( 'ajax-script', $link_js, array('jquery') );

	// in JavaScript, object properties are accessed as ajax_object.ajax_url, ajax_object.we_value
	wp_localize_script( 'ajax-script', 'ajax_object',array( 'ajax_url' => admin_url( 'admin-ajax.php' )) );
}

add_action( 'wp_ajax_manage_data', 'manage_ajax_data' );
add_action( 'wp_ajax_nopriv_manage_data', 'manage_ajax_data' );

function manage_ajax_data() {

    if(!isset($_POST["data"])){
        echo json_encode("Something failed!",JSON_UNESCAPED_UNICODE);
        return false;
        wp_die();
    }

    global $wpdb;
    
    $data = $_POST["data"];
    $db_data = $wpdb->get_results("SELECT code_md5 FROM wp_wazuh_task");

    $response = array();
    $data_md5 = array();
    $db_data_md5 = array();

    foreach ($db_data as $key => $value) {
        array_push($db_data_md5, $db_data[$key]->code_md5);
    }

    foreach ($data as $key => $value) {
        $md5_code = strtoupper(md5($value['id'].$value['name']));
        if(in_array($value['md5'], $db_data_md5, true)){
            if($md5_code === $value['md5']){
                array_push($response,"<p style='color:green'>".$value['md5']." is <strong>in the database</strong> and the MD5 is correct</p>");
            }else{
                array_push($response, "<p style='color:red'>".$value['md5']." is <strong>in the database</strong> but the MD5 is not correct</p>");
            }
        }else{
            if($md5_code === $value['md5']){
                array_push($response,"<p style='color:green'>".$value['md5']." is <strong>not the database</strong> and the MD5 is correct (saved on DB)</p>");
                $wpdb->insert($wpdb->prefix.'wazuh_task', array('id_md5'=>$value['id'],'name_md5'=>$value['name'],'code_md5'=>$value['md5'] ));
            }else{
                array_push($response, "<p style='color:red'>".$value['md5']." is <strong>not the database</strong> and the MD5 is not correct (saved on DB)</p>");
                $wpdb->insert($wpdb->prefix.'wazuh_task', array('id_md5'=>$value['id'],'name_md5'=>$value['name'],'code_md5'=>$value['md5'] ));
            }
        }
    }

    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    wp_die();
    
}