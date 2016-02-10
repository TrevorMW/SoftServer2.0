<?php

class Product
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
   *1
   * @access public
   * @param mixed $identifier (default: null)
   * @return void
   */
  public function load_product( $id = null, $type = null )
  {
    global $ssdb;

    if( $ssdb instanceOf PDO )
    {
      $stmt = null;

      // IF IDENTIFIER IS OF TYPE INT, LOAD DIRECTLY, ELSE ASSUME IDENTIFIER IS OF TYPE STRING AND TRY TO LOAD BY SLUG
      if( is_int( $id ) )
      {
        $stmt = $ssdb->prepare( 'SELECT * FROM '.TABLE_PREFIX.'product WHERE 1=1 AND product_id = ?' );
        $stmt->bindValue( 1, "$id", PDO::PARAM_INT );
      }

      if( is_int( $type ) )
      {
        $stmt = $ssdb->prepare( 'SELECT * FROM '.TABLE_PREFIX.'product WHERE 1=1 AND product_type = ?' );
        $stmt->bindValue( 1, "$type", PDO::PARAM_INT );
      }

      if( $stmt != null )
      {
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

      $stmt = $ssdb->prepare(' INSERT INTO '.TABLE_PREFIX.'product ( product_base_price, product_type ) VALUES ( :base_price, :type ) ' );
      $stmt->bindParam( ':base_price', $type->product_type_base_price, PDO::PARAM_STR );
      $stmt->bindParam( ':type',       $type->product_type_id,         PDO::PARAM_INT );
      $stmt->execute();
      $id = $ssdb->lastInsertId();

      if( $id != null )
      {
        $result = (int) $id;
      }
    }

    return $result;
  }

  /**
   * create_product_ingredient_records function.
   *
   * @access public
   * @param mixed $product_id
   * @param mixed $ingredients
   * @return void
   */
  public function create_product_ingredient_records( $id, $ingredients )
  {
    if( is_array( $ingredients ) && !empty( $ingredients ) )
    {
      global $ssdb;

      foreach( $ingredients as $ingredient )
      {
        if( is_array( $ingredient ) )
        {
          foreach( $ingredient as $ingredient_type_item )
          {
            try
            {
              $stmt = $ssdb->prepare( 'INSERT INTO '.TABLE_PREFIX.'product_ingredients ( product_id, ingredient_id ) VALUES ( :prod_id, :ingredient_id )' );
              $stmt->bindParam( ':prod_id',       $id,                   PDO::PARAM_INT );
              $stmt->bindParam( ':ingredient_id', $ingredient_type_item, PDO::PARAM_INT );
              $stmt->execute();
            }
            catch( PDOException $e ){}
          }
        }
        else
        {
          try
          {
            $stmt = $ssdb->prepare( 'INSERT INTO '.TABLE_PREFIX.'product_ingredients ( product_id, ingredient_id ) VALUES ( :prod_id, :ingredient_id )' );
            $stmt->bindParam( ':prod_id',       $id,         PDO::PARAM_INT );
            $stmt->bindParam( ':ingredient_id', $ingredient, PDO::PARAM_INT );
            $stmt->execute();
          }
          catch( PDOException $e ){}
        }
      }
    }
  }

  /**
   * get_product_total_price function.
   *
   * @access public
   * @return void
   */
  public function get_product_total_price( $product, $ingredients  )
  {
    $total   = '';
    $add_ons = array();

    if( $product instanceOf Product )
    {
      $total = (float) $product->product_base_price;

      foreach( $ingredients as $ingredient )
      {
        $add_ons[] = (float) $ingredient->ingredient_price;
      }

      $total = $total + array_sum( $add_ons );
    }

    return $total;
  }

}