<?php

class Order
{
  public $order_id;
  public $order_user_id;
  public $order_status = false;

  public $products;

  /**
   * __construct function.
   *
   * @access public
   * @param mixed $id
   * @return void
   */
  public function __construct( $id = null )
  {
    $this->load_order( $id );

    if( is_int( $this->order_id ) )
      $this->load_order_products( $this->order_id );
  }

  /**
   * load_product function.
   *
   * @access public
   * @param mixed $identifier
   * @return void
   */
  public function load_order( $id )
  {
    global $ssdb;

    if( $ssdb instanceOf PDO )
    {
      if( is_int( $id ) )
      {
        $stmt = $ssdb->prepare( 'SELECT * FROM '.TABLE_PREFIX.'orders WHERE 1=1 AND order_id = ?' );
        $stmt->bindValue( 1, "$id", PDO::PARAM_STR );
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
   * load_order_details function.
   *
   * @access public
   * @param mixed $order_id
   * @return void
   */
  public function load_order_details( $order_id )
  {

  }

  /**
   * load_order_products function.
   *
   * @access public
   * @param mixed $order_id
   * @return void
   */
  public function load_order_products( $id = null )
  {
    global $ssdb;

    $products = array();

    if( is_int( $id ) && $ssdb instanceOf PDO )
    {
      $stmt = $ssdb->prepare( 'SELECT * FROM '.__TABLE_PREFIX__.'order_items WHERE 1=1 AND order_id = ? ' );
      $stmt->bindParam( 1, "$order_id", PDO::PARAM_INT );
      $stmt->execute();
      $result = $stmt->fetchAll( PDO::FETCH_OBJ );

      if( is_array( $result ) && !empty( $result ) )
      {
        foreach( $results as $k => $product_id )
        {
          $product = new Product( $product_id );

          var_dump( $product );
        }
      }
    }

    return $products;
  }

  /**
   * create_order_record function.
   *
   * @access public
   * @return void
   */
  public function create_order_record( $user, $order_total )
  {
    $order_id = null;

    if( $user instanceOf User )
    {
      global $ssdb;

      $order_status = '1';

      $stmt = $ssdb->prepare( 'INSERT INTO '.TABLE_PREFIX.'orders ( order_user_id, order_status, order_total ) VALUES ( :order_user, :order_status, :order_total )' );
      $stmt->bindParam( ':order_user',   $user->user_id, PDO::PARAM_INT  );
      $stmt->bindParam( ':order_status', $order_status,  PDO::PARAM_BOOL );
      $stmt->bindParam( ':order_total',  $order_total,   PDO::PARAM_STR  );
      $stmt->execute();

      $result = $ssdb->lastInsertId();

      if( $result != null )
        $order_id = (int) $result;
    }

    return $order_id;
  }

  public function create_order_product_records( $order_id, $products )
  {
    $result = true;

    if( is_int( $order_id ) )
    {
      global $ssdb;

      if( is_array( $products ) && !empty( $products ) )
      {
        foreach( $products as $product )
        {
          $product_id = (int) $product;

          $stmt = $ssdb->prepare( 'INSERT INTO '.TABLE_PREFIX.'order_items ( order_id, product_id ) VALUES ( :order_id, :product_id )' );
          $stmt->bindParam( ':order_id',   $order_id,    PDO::PARAM_INT  );
          $stmt->bindParam( ':product_id', $product_id,  PDO::PARAM_INT );
          $results = $stmt->execute();

          if( !$results )
            $result = false;

          $stmt = '';
        }
      }
    }

    return $result;
  }
}