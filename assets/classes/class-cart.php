<?php

class Cart
{
  public $cart_session_id;
  public $cart_user_id;

  public $cart_items;

  public function __construct( $user_id = null )
  {
    $this->load_cart_data( 1 );
  }

  /**
   * load_cart_data function.
   *
   * @access public
   * @param mixed $user_id
   * @return void
   */
  public function load_cart_data( $user_id )
  {
    global $ssdb;

    if( $ssdb instanceOf PDO )
    {
      $stmt = $ssdb->prepare( 'SELECT * FROM '.TABLE_PREFIX.'cart WHERE 1=1 AND cart_user_id = ? ' );
      $stmt->bindValue( 1 , "$user_id", PDO::PARAM_INT );
      $stmt->execute();
      $result = $stmt->fetchAll( PDO::FETCH_OBJ );

      if( is_array( $result ) && !empty( $result ) )
      {
        foreach( $result[0] as $k => $val )
        {
          $this->$k = $val;
        }
      }

      if( isset( $this->cart_session_id ) )
        $this->load_cart_products( $ssdb, $this->cart_session_id );
    }


  }


  /**
   * load_cart_products function.
   *
   * @access public
   * @param mixed $db
   * @param mixed $session_id
   * @return void
   */
  public function load_cart_products( $db, $session_id )
  {
    $products = array();

    if( $db instanceOf PDO )
    {
      $stmt = $db->prepare( 'SELECT * FROM '.TABLE_PREFIX.'cart_items WHERE 1=1 AND cart_session_id = ? ' );
      $stmt->bindValue( 1 , "$session_id", PDO::PARAM_STR );
      $stmt->execute();
      $result = $stmt->fetchAll( PDO::FETCH_OBJ );

      if( is_array( $result ) && !empty( $result ) )
      {
        foreach( $result as $k => $val )
        {
          $products[] = new Product( $val->cart_product_id );
        }
      }
    }

    $this->cart_items = $products;
  }


  /**
   * get_cart_count function.
   *
   * @access public
   * @return void
   */
  public function get_cart_count()
  {
    return count( $this->cart_items );
  }


  /**
   * create_new_cart_record function.
   *
   * @access public
   * @param array $data
   * @return void
   */
  public function create_new_cart_record( array $data )
  {
    $result = false;

    if( is_array( $data ) && !empty( $data ) )
    {
      global $ssdb;

      $session_id = uniqid();
      $user_id    = 4;

      $stmt = $ssdb->prepare(' INSERT INTO '.TABLE_PREFIX.'cart ( cart_session_id, cart_user_id ) VALUES ( :session_id, :user_id ) ' );
      $stmt->bindParam( ':session_id', $session_id, PDO::PARAM_STR );
      $stmt->bindParam( ':user_id', $user_id, PDO::PARAM_INT );

      if( $stmt->execute() )
      {
        $result = $session_id;
      }
    }

    return $result;
  }
}