<?php require_once( 'config.php' );

/**
 * Define AWL the things.
 *
 * @access public
 * @return void
 *
 */
function start_up_ice_cream_machine()
{
  $db   = new DB();
  $cart = new Cart();

  $GLOBALS['ssdb'] = $db;
  $GLOBALS['cart'] = $cart;

  build_application_tables();
}

function load_ajax_dependencies()
{
  $db = new DB();

  $GLOBALS['ssdb'] = $db;
}


/**
 * Poor man's magikul autoloader.
 *
 * @access public
 * @param mixed $classname
 * @return void
 *
 */
function __autoload( $classname )
{
  $filename = __CLASSES_PATH__ . 'class-'. strtolower( $classname ) .".php";

  include_once( $filename );
}



/**
 * Build all necessary tables
 *
 * @access public
 * @return void
 */
function build_application_tables()
{
  global $ssdb;

  if( $ssdb instanceof PDO && $ssdb->errors == null )
  {
    // CREATE PRODUCT TYPES TABLE
    $table_name = TABLE_PREFIX.'_product_types';
    $ssdb->exec( "CREATE TABLE IF NOT EXISTS $table_name (
      type_id INT( 11 ) AUTO_INCREMENT PRIMARY KEY,
      type_name VARCHAR ( 125 ) NOT NULL,

    )" );

    // CREATE PRODUCT TABLE
    $table_name = TABLE_PREFIX.'_product';
    $ssdb->exec( "CREATE TABLE IF NOT EXISTS $table_name ( )" );

    // CREATE CART TABLE
    $table_name = TABLE_PREFIX.'_cart';
    $ssdb->exec( "CREATE TABLE IF NOT EXISTS $table_name ( )" );

    // CREATE ORDERS TABLE
    $table_name = TABLE_PREFIX.'_orders';
    $ssdb->exec( "CREATE TABLE IF NOT EXISTS $table_name ( )" );

    // CREATE FLAVORS TABLE
    $table_name = TABLE_PREFIX.'_flavors';
    $ssdb->exec( "CREATE TABLE IF NOT EXISTS $table_name ( )" );

    // CREATE SODAS TABLE
    $table_name = TABLE_PREFIX.'_sodas';
    $ssdb->exec( "CREATE TABLE IF NOT EXISTS $table_name ( )" );

    // CREATE MILK TABLE
    $table_name = TABLE_PREFIX.'_milk';
    $ssdb->exec( "CREATE TABLE IF NOT EXISTS $table_name ( )" );

    // CREATE CONTAINERS TABLE
    $table_name = TABLE_PREFIX.'_containers';
    $ssdb->exec( "CREATE TABLE IF NOT EXISTS $table_name ( )" );
  }
}