<?php
/*
Plugin Name: Origins Product Menu
Description: Plugin for product menu management for Origins Cannabis site
Author: Origins Cannabis
Author URI: http://www.originscannabis.com/
*/

function add_menu_items(){
	$blog_id = get_current_blog_id();
	$menus_hook = add_menu_page( 'Origins Menu', 'Origins Menu', 'activate_plugins', 'origins_menu', 'menus_page', 'dashicons-groups', 15 );
    $menu_new_menu_hook = add_submenu_page( 'origins_menu', 'Manage Menu', 'Add New Menu', 'activate_plugins', 'origins_add_menu', 'menu_new_menu_page' );
    $menu_bulk_upload_page = add_submenu_page( 'origins_menu', 'Bulk Upload Menu', 'Bulk Upload Menu', 'activate_plugins', 'origins_bulk_upload_menu', 'menu_bulk_upload_page' );
    $menu_types_hook = add_submenu_page( 'origins_menu', 'Types', 'Types', 'activate_plugins', 'origins_menu_types', 'menu_types_page' );
    $menu_subtypes_hook = add_submenu_page( 'origins_menu', 'Sub Types', 'Sub Types', 'activate_plugins', 'origins_menu_subtypes', 'menu_subtypes_page' );
    $menu_farms_hook = add_submenu_page( 'origins_menu', 'Farms', 'Farms', 'activate_plugins', 'origins_menu_farms', 'menu_farms_page' );
    $menu_lifestyles_hook = add_submenu_page( 'origins_menu', 'Lifestyles', 'Lifestyles', 'activate_plugins', 'origins_menu_lifestyles', 'menu_lifestyles_page' );
    $menu_specials_hook = add_submenu_page( 'origins_menu', 'Designations', 'Designations', 'activate_plugins', 'origins_menu_specials', 'menu_specials_page' );

    add_action( "load-$menus_hook", 'load_admin_scripts' );
    add_action( "load-$menu_new_menu_hook", 'load_admin_scripts' );
    add_action( "load-$menu_bulk_upload_page", 'load_admin_scripts' );
    add_action( "load-$menu_types_hook", 'load_admin_scripts' );
    add_action( "load-$menu_subtypes_hook", 'load_admin_scripts' );
    add_action( "load-$menu_farms_hook", 'load_admin_scripts' );
    add_action( "load-$menu_lifestyles_hook", 'load_admin_scripts' );
	add_action( "load-$menu_specials_hook", 'load_admin_scripts' );
}
add_action( 'admin_menu', 'add_menu_items' );

//PAGES
function menus_page(){ include 'includes/menus.php'; }
function menu_new_menu_page(){ include 'includes/post-menu.php'; }
function menu_bulk_upload_page(){ include 'includes/bulk-upload-menu.php'; }
function menu_types_page(){ include 'includes/menu-types.php'; }
function menu_subtypes_page(){ include 'includes/menu-subtypes.php'; }
function menu_farms_page(){ include 'includes/menu-farms.php'; }
function menu_lifestyles_page(){ include 'includes/menu-lifestyles.php'; }
function menu_specials_page(){ include 'includes/menu-specials.php'; }

function load_admin_scripts(){
    add_action( 'admin_enqueue_scripts', 'init_scripts' );
}

function init_scripts() {

       // Bootstrap
        wp_enqueue_style( 'admin-bootstrap-css', '/wp-content/plugins/origins-product-menu/lib/bootstrap/bootstrap.min.css' );
        wp_enqueue_script( 'admin-bootstrap-js', '/wp-content/plugins/origins-product-menu/lib/bootstrap/bootstrap.min.js', array(), '', true );

        // Datatable
        wp_enqueue_style( 'dt-css', 'https://cdn.datatables.net/t/dt/dt-1.10.11/datatables.min.css');
        wp_enqueue_script( 'dt-js', 'https://cdn.datatables.net/t/dt/dt-1.10.11/datatables.min.js', array(), '', true );
        
        //Angular
        wp_enqueue_script( 'ae-angular', '//ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular.min.js', array(), '', true );
        
        //Angular Plugins
        wp_enqueue_script( 'angular-dt', '/wp-content/plugins/origins-product-menu/lib/datatables/angular-datatables.min.js', array( ), '', true );
        wp_enqueue_script( 'angular-dt-bootstrap-js', '/wp-content/plugins/origins-product-menu/lib/datatables/angular-datatables.bootstrap.min.js', array( ), '', true );
        wp_enqueue_style( 'angular-dt-bootstrap-css', '/wp-content/plugins/origins-product-menu/lib/datatables/datatables.bootstrap.min.css');
        wp_enqueue_script( 'dt-columnfilter', '/wp-content/plugins/origins-product-menu/lib/datatables/dataTables.columnFilter.js', array( ), '', true );
        wp_enqueue_script( 'angular-dt-columnfilter', '/wp-content/plugins/origins-product-menu/lib/datatables/angular-datatables.columnfilter.min.js', array( ), '', true );
         wp_enqueue_script( 'dt-lightcolumnfilter', '/wp-content/plugins/origins-product-menu/lib/datatables/dataTables.lightColumnFilter.min.js', array( ), '', true );
        wp_enqueue_script( 'angular-dt-lightcolumnfilter', '/wp-content/plugins/origins-product-menu/lib/datatables/angular-datatables.light-columnfilter.min.js', array( ), '', true );
        wp_enqueue_style( 'angular-dt-style-css', '/wp-content/plugins/origins-product-menu/lib/datatables/angular-datatables.min.css' );

        wp_enqueue_script( 'angular-ui-bootsrap', '/wp-content/plugins/origins-product-menu/lib/bootstrap/ui-bootstrap-1.3.2.min.js', array( ), '', true );
        wp_enqueue_script( 'angular-ui-bootsrap-tpls', '/wp-content/plugins/origins-product-menu/lib/bootstrap/ui-bootstrap-tpls.js', array( ), '', true );

        wp_enqueue_script( 'toaster-js', '/wp-content/plugins/origins-product-menu/lib/misc/angular-toastr.tpls.js', array(), '', true );
        wp_enqueue_script( 'loader-js', '//cdnjs.cloudflare.com/ajax/libs/spin.js/1.2.7/spin.min.js', array(), '' );
        wp_enqueue_script( 'loader2-js', '/wp-content/plugins/origins-product-menu/lib/misc/angular-loading.min.js', array(), '', true );
        
        wp_enqueue_style( 'toaster-css', '/wp-content/plugins/origins-product-menu/lib/misc/angular-toastr.css' );
        wp_enqueue_style( 'loader-css', '/wp-content/plugins/origins-product-menu/lib/misc/angular-loading.css' );
        
        // wp_enqueue_script( 'ngsanitize-js', '/wp-content/plugins/origins-product-menu/js/angular-sanitize.min.js', array(), '', true );

        wp_enqueue_style( 'font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css' );
        wp_enqueue_style( 'admin-custom-css', '/wp-content/plugins/origins-product-menu/css/style.css' );

        wp_enqueue_script( 'csv-import-js', '/wp-content/plugins/origins-product-menu/lib/csv-import/angular-csv-import.js', array(), '', true );

        wp_enqueue_script( 'ae-js', '/wp-content/plugins/origins-product-menu/js/app.js', array(), '', true );
        wp_enqueue_script( 'type-js', '/wp-content/plugins/origins-product-menu/js/types.js', array(), '', true );
        wp_enqueue_script( 'farm-js', '/wp-content/plugins/origins-product-menu/js/farms.js', array(), '', true );
        wp_enqueue_script( 'lifestyle-js', '/wp-content/plugins/origins-product-menu/js/lifestyle.js', array(), '', true );
        wp_enqueue_script( 'special-js', '/wp-content/plugins/origins-product-menu/js/special.js', array(), '', true );
        wp_enqueue_script( 'bulk-upload-js', '/wp-content/plugins/origins-product-menu/js/bulk-upload-menu.js', array(), '', true );

        wp_enqueue_media();

}


// MENU MAIN FUNCTION ================================================

// get types
add_action( 'wp_ajax_get_menus', 'get_menus' );
add_action( 'wp_ajax_nopriv_get_menus', 'get_menus' );
function get_menus(){
    global $wpdb;
    $page = $_POST['page'];

    $query_string = 'SELECT 
        custom_menu.id, 
        custom_menu.name, 
        custom_menu.cbs_ratio, 
        custom_menu.lab_result_link, 
        custom_menu.prices, 
        custom_farm.name as farm, 
        custom_type.name as type, 
        custom_sub_type.name as subtype, 
        custom_lifestyle.name as lifestyle, 
        custom_special_tags.name as special_tags, 
        SUBSTRING_INDEX(custom_menu.description," ",5) as description 
        FROM custom_menu 
        LEFT JOIN custom_farm ON custom_menu.farm = custom_farm.id
        LEFT JOIN custom_type ON custom_menu.type = custom_type.id
        LEFT JOIN custom_sub_type ON custom_menu.subtype = custom_sub_type.id
        LEFT JOIN custom_lifestyle ON custom_menu.lifestyle = custom_lifestyle.id
        LEFT JOIN custom_special_tags ON custom_menu.special_tags = custom_special_tags.id
        ORDER BY custom_menu.id DESC LIMIT 10 ';

    if( $page > 1 ){
        $query_string .= 'OFFSET '. ( ($page-1) * 10 );
    }

    $query_string .= ';';

    $results = $wpdb->get_results($query_string);

    foreach ($results as $key => $value) {
        $results[$key]->prices = unserialize( $value->prices );
    }

    echo json_encode($results);
    wp_die();
}

// get options
add_action( 'wp_ajax_get_options', 'get_options' );
add_action( 'wp_ajax_nopriv_get_options', 'get_options' );
function get_options(){
    global $wpdb;

    $results['farms'] = $wpdb->get_results('SELECT * FROM custom_farm');
    $results['lifestyle'] = $wpdb->get_results('SELECT * FROM custom_lifestyle');
    $results['type'] = $wpdb->get_results('SELECT * FROM custom_type');
    $results['subtype'] = $wpdb->get_results('SELECT * FROM custom_sub_type');
    $results['special_tags'] = $wpdb->get_results('SELECT * FROM custom_special_tags');

    echo json_encode($results);
    wp_die();
}

// post menu
add_action( 'wp_ajax_origins_post_menu', 'origins_post_menu' );
add_action( 'wp_ajax_nopriv_origins_post_menu', 'origins_post_menu' );
function origins_post_menu(){
    global $wpdb;

    $menu = $_POST['params'];

    $menu_array =  array(
        'name' => $menu['name'],
        'description' => $menu['description'],
        'cbs_ratio' => $menu['cbs_ratio'],
        'lab_result_link' => $menu['lab_result_link'],
        'prices' => serialize( $menu['prices'] ),
        'special_tags' => $menu['special_tags'] ? $menu['special_tags'] : null,
        'type' => $menu['type'] ? $menu['type'] : null,
        'subtype' => $menu['subtype'] ? $menu['subtype'] : null,
        'farm' => $menu['farm'] ? $menu['farm'] : null,
        'lifestyle' => $menu['lifestyle'] ? $menu['lifestyle'] : null,
    );

    if( isset( $menu['id'] ) && $menu['id'] <> '' ){ //edit
        $result = $wpdb->update( 'custom_menu', $menu_array, array( 'id' => $menu['id']) );
        $message = "Menu successfull updated!";
    }else{
        $result = $wpdb->insert( 'custom_menu', $menu_array );
        $message = "Menu successfull added!";
    }

    if( $result )
        echo json_encode( array( 'result' => $result, 'success' => true, 'message' => $message ) );
    else
        echo json_encode( array( 'message' => $wpdb->last_error, 'success' => false ) );

    wp_die();
}

// get menu
add_action( 'wp_ajax_origins_get_menu', 'origins_get_menu' );
add_action( 'wp_ajax_nopriv_origins_get_menu', 'origins_get_menu' );
function origins_get_menu(){
    global $wpdb;
    $menuId = $_POST['menuId'];
    $response = $wpdb->get_row( "SELECT * FROM custom_menu WHERE id = " . $menuId );
    $response->prices = unserialize( $response->prices );
    echo json_encode($response);
    wp_die();
}

// get total items
add_action( 'wp_ajax_origins_get_total_items', 'origins_get_total_items' );
add_action( 'wp_ajax_nopriv_origins_get_total_items', 'origins_get_total_items' );
function origins_get_total_items(){
    global $wpdb;
    $response = $wpdb->get_var( "SELECT COUNT(*) FROM custom_menu" );
    echo json_encode($response);
    wp_die();
}

// delete menu
add_action( 'wp_ajax_delete_origins_menu', 'delete_origins_menu' );
add_action( 'wp_ajax_nopriv_delete_origins_menu', 'delete_origins_menu' );
function delete_origins_menu(){
    global $wpdb;
    $menuId = $_POST['menuId'];
    
    if( is_array($menuId) ){
        $menuIds = implode( ',', array_map( 'absint', $menuId ) );
        $response = $wpdb->query( "DELETE FROM custom_menu WHERE id IN(". $menuIds .")" );
    }else{
        $response = $wpdb->delete( 'custom_menu', array('id' => $menuId) );
    }

    echo json_encode($response);
    wp_die();
}

// @end MENU MAIN FUNCTION ================================================

// TYPES FUNCTIONS ================================================
// get types
add_action( 'wp_ajax_get_origins_types', 'get_origins_types' );
add_action( 'wp_ajax_nopriv_get_origins_types', 'get_origins_types' );
function get_origins_types(){
    global $wpdb;
    $results = $wpdb->get_results( 'SELECT * FROM custom_type' );
    echo json_encode($results);
    wp_die();
}

// get subtypes
add_action( 'wp_ajax_get_origins_subtypes', 'get_origins_subtypes' );
add_action( 'wp_ajax_nopriv_get_origins_subtypes', 'get_origins_subtypes' );
function get_origins_subtypes(){
    global $wpdb;
    $results = $wpdb->get_results( 'SELECT 
        custom_sub_type.id, custom_sub_type.name, custom_sub_type.description, custom_sub_type.parent_type, custom_type.name as parent_name
        FROM custom_sub_type
        LEFT JOIN custom_type ON custom_type.id = custom_sub_type.parent_type' 
    );
    echo json_encode($results);
    wp_die();
}

// post subtype
add_action( 'wp_ajax_post_origins_subtype', 'post_origins_subtype' );
add_action( 'wp_ajax_nopriv_post_origins_subtype', 'post_origins_subtype' );
function post_origins_subtype(){
    global $wpdb;
    $params = $_POST['params'];

    if( isset( $params['id'] ) ){ //edit
        $result = $wpdb->update( 'custom_sub_type', array(
            'name' => $params['name'],
            'description' => $params['description'],
            'parent_type' => $params['parent_type']
        ), array( 'id' => $params['id']) );
        $message = "Type successfull updated!";
    }else{
        $result = $wpdb->insert( 'custom_sub_type', $params );
        $message = "Type successfull added!";
    }

    if( $result )
        echo json_encode( array( 'result' => $result, 'success' => true, 'message' => $message ) );
    else
        echo json_encode( array( 'message' => $wpdb->last_error, 'success' => false ) );

    // echo json_encode($message);
    wp_die();
}

// post type
add_action( 'wp_ajax_post_origins_type', 'post_origins_type' );
add_action( 'wp_ajax_nopriv_post_origins_type', 'post_origins_type' );
function post_origins_type(){
    global $wpdb;
    $params = $_POST['params'];

    if( isset( $params['id'] ) ){ //edit
        $result = $wpdb->update( 'custom_type', array(
            'name' => $params['name'],
            'description' => $params['description']
        ), array( 'id' => $params['id']) );
        $message = "Type successfull updated!";
    }else{
        $result = $wpdb->insert( 'custom_type', $params );
        $message = "Type successfull added!";
    }

    echo json_encode($message);
    wp_die();
}

// delete type
add_action( 'wp_ajax_delete_origins_type', 'delete_origins_type' );
add_action( 'wp_ajax_nopriv_delete_origins_type', 'delete_origins_type' );
function delete_origins_type(){
    global $wpdb;
    $typeId = $_POST['typeId'];
    $response = $wpdb->delete( 'custom_type', array('id' => $typeId) );
    echo json_encode($response);
    wp_die();
}

// delete subtype
add_action( 'wp_ajax_delete_origins_subtype', 'delete_origins_subtype' );
add_action( 'wp_ajax_nopriv_delete_origins_subtype', 'delete_origins_subtype' );
function delete_origins_subtype(){
    global $wpdb;
    $subtypeId = $_POST['subtypeId'];
    $response = $wpdb->delete( 'custom_sub_type', array('id' => $subtypeId) );
    echo json_encode($response);
    wp_die();
}


// FARMS FUNCTIONS
// get farms
add_action( 'wp_ajax_get_origins_farms', 'get_origins_farms' );
add_action( 'wp_ajax_nopriv_get_origins_farms', 'get_origins_farms' );
function get_origins_farms(){
    global $wpdb;
    $results = $wpdb->get_results( 'SELECT * FROM custom_farm' );
    echo json_encode($results);
    wp_die();
}

// add type
add_action( 'wp_ajax_post_origins_farm', 'post_origins_farm' );
add_action( 'wp_ajax_nopriv_post_origins_farm', 'post_origins_farm' );
function post_origins_farm(){
    global $wpdb;
    $params = $_POST['params'];

    if( isset( $params['id'] ) ){ //edit
        $result = $wpdb->update( 'custom_farm', array(
            'name' => $params['name'],
            'description' => $params['description']
        ), array( 'id' => $params['id']) );
        $message = "Type successfull updated!";
    }else{
        $result = $wpdb->insert( 'custom_farm', $params );
        $message = "Type successfull added!";
    }

    echo json_encode($message);
    wp_die();
}

// delete type
add_action( 'wp_ajax_delete_origins_farm', 'delete_origins_farm' );
add_action( 'wp_ajax_nopriv_delete_origins_farm', 'delete_origins_farm' );
function delete_origins_farm(){
    global $wpdb;
    $farmId = $_POST['farmId'];
    $response = $wpdb->delete( 'custom_farm', array('id' => $farmId) );
    echo json_encode($response);
    wp_die();
}


// LIFESYLES FUNCTIONS
add_action( 'wp_ajax_get_origins_lifestyles', 'get_origins_lifestyles' );
add_action( 'wp_ajax_nopriv_get_origins_lifestyles', 'get_origins_lifestyles' );
function get_origins_lifestyles(){
    global $wpdb;
    $results = $wpdb->get_results( 'SELECT * FROM custom_lifestyle' );
    echo json_encode($results);
    wp_die();
}

add_action( 'wp_ajax_post_origins_lifestyle', 'post_origins_lifestyle' );
add_action( 'wp_ajax_nopriv_post_origins_lifestyle', 'post_origins_lifestyle' );
function post_origins_lifestyle(){
    global $wpdb;
    $params = $_POST['params'];

    if( isset( $params['id'] ) ){ //edit
        $result = $wpdb->update( 'custom_lifestyle', array(
            'name' => $params['name'],
            'description' => $params['description']
        ), array( 'id' => $params['id']) );
        $message = "Type successfull updated!";
    }else{
        $result = $wpdb->insert( 'custom_lifestyle', $params );
        $message = "Lifestyle successfull added!";
    }

    echo json_encode($message);
    wp_die();
}

add_action( 'wp_ajax_delete_origins_lifestyle', 'delete_origins_lifestyle' );
add_action( 'wp_ajax_nopriv_delete_origins_lifestyle', 'delete_origins_lifestyle' );
function delete_origins_lifestyle(){
    global $wpdb;
    $lifestyleId = $_POST['lifestyleId'];
    $response = $wpdb->delete( 'custom_lifestyle', array('id' => $lifestyleId) );
    echo json_encode($response);
    wp_die();
}

// SPECIAL FUNCTIONS
add_action( 'wp_ajax_get_origins_specials', 'get_origins_specials' );
add_action( 'wp_ajax_nopriv_get_origins_specials', 'get_origins_specials' );
function get_origins_specials(){
    global $wpdb;
    $results = $wpdb->get_results( 'SELECT * FROM custom_special_tags' );
    echo json_encode($results);
    wp_die();
}

add_action( 'wp_ajax_post_origins_special', 'post_origins_special' );
add_action( 'wp_ajax_nopriv_post_origins_special', 'post_origins_special' );
function post_origins_special(){
    global $wpdb;
    $params = $_POST['params'];

    if( isset( $params['id'] ) ){ //edit
        $result = $wpdb->update( 'custom_special_tags', array(
            'name' => $params['name'],
            'description' => $params['description']
        ), array( 'id' => $params['id']) );
        $message = "Item successfull updated!";
    }else{
        $result = $wpdb->insert( 'custom_special_tags', $params );
        $message = "Special Tag successfull added!";
    }

    echo json_encode($message);
    wp_die();
}

add_action( 'wp_ajax_delete_origins_special', 'delete_origins_special' );
add_action( 'wp_ajax_nopriv_delete_origins_special', 'delete_origins_special' );
function delete_origins_special(){
    global $wpdb;
    $specialId = $_POST['specialId'];
    $response = $wpdb->delete( 'custom_special_tags', array('id' => $specialId) );
    echo json_encode($response);
    wp_die();
}


// function install_p() {

//   global $wpdb;

//     $prefix = $wpdb->get_blog_prefix(BLOG_ID_CURRENT_SITE);
//     $table_name = $prefix . 'capitalization';

//     $charset_collate = $wpdb->get_charset_collate();
//     $sql = "CREATE TABLE $table_name (
//       id mediumint(9) NOT NULL AUTO_INCREMENT,
//       amount varchar(100) NOT NULL,
//       currency varchar(100) NOT NULL,
//       country varchar(100) NOT NULL,
//       isactive mediumint(9) NOT NULL,
//       UNIQUE KEY id (id)
//     ) $charset_collate;";

//     $wpdb->query( $sql );

// }

// register_activation_hook( __FILE__, 'install_p' );