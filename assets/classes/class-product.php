<?php

class Product extends Product_Type
{
  public $product_id;
  public $product_base_price;
  public $product_type;

  /**
   * __construct function.
   *
   * @access public
   * @param mixed $identifier (default: null)
   * @return void
   */
  public function __construct( $identifier = null )
  {
    $this->load_product( $identifier );
  }


  /**
   * load_product function.
   *
   * @access public
   * @param mixed $identifier (default: null)
   * @return void
   */
  public function load_product( $identifier = null )
  {
    global $ssdb;

    if( $ssdb instanceOf PDO )
    {
      // IF IDENTIFIER IS OF TYPE INT, LOAD DIRECTLY, ELSE ASSUME IDENTIFIER IS OF TYPE STRING AND TRY TO LOAD BY SLUG
      if( is_int( $identifier ) )
      {
        $stmt = $ssdb->prepare( 'SELECT * FROM '.TABLE_PREFIX.'product WHERE 1=1 AND product_id = ?' );
        $stmt->bindValue( 1, "$identifier", PDO::PARAM_INT );
      }
      else
      {
        $stmt = $ssdb->prepare( 'SELECT * FROM '.TABLE_PREFIX.'product WHERE 1=1 AND product_slug = ?' );
        $stmt->bindValue( 1, "$identifier", PDO::PARAM_STR );
      }

      $stmt->execute();
      $result = $stmt->fetchAll( PDO::FETCH_OBJ );

      if( is_array( $result ) && !empty( $result ) )
      {
        foreach( $result[0] as $k => $val )
        {
          $this->$k = $val;
        }
      }
    }
  }


  /**
   * create_product_slug function.
   *
   * @access public
   * @param mixed $name
   * @return void
   */
  public function create_product_slug( $name )
  {
    return sanitize_title_with_dashes( $name );
  }


  /**
   * create_product_record function.
   *
   * @access public
   * @return void
   */
  public function create_product_record( Product_Type $type )
  {
    $result = false;

    if( $type instanceOf Product_Type )
    {
      global $ssdb;

      $stmt = $ssdb->prepare(' INSERT INTO '.TABLE_PREFIX.'cart ( product_base_price, product_type ) VALUES ( :base_price, :type ) ' );
      $stmt->bindParam( ':base_price', $type->product_type_base_price, PDO::PARAM_STR );
      $stmt->bindParam( ':type', $type->product_type_id, PDO::PARAM_INT );
      $stmt->execute();
      $id = $stmt->lastInsertId();

      var_dump( $id );
    }

    return $result;
  }


  /**
   * add_product_ingredient_records function.
   *
   * @access public
   * @param mixed $sess_id
   * @param mixed $ingredients
   * @return void
   */
  public function add_product_ingredient_records( $product_id, $ingredients )
  {
    if( is_array( $ingredients ) && !empty( $ingredients ) )
    {
      global $db;

      foreach( $ingredients as $ingredient )
      {
        $stmt = $db->prepare( 'INSERT INTO '.TABLE_PREFIX.'product_ingredients ( product_id, ingredient_id ) VALUES ( :product_id, :ingredient_id )' );
        $stmt->bindParam( ':product_id',    "$product_id", PDO::PARAM_INT );
        $stmt->bindParam( ':ingredient_id', "$ingredient", PDO::PARAM_INT );
        $stmt->execute();
      }


    }
  }
}