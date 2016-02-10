<?php

class Cart
{
  public $cart_session_id;
  public $cart_user_id;

  public $cart_items;

  public function __construct( $user_id = null )
  {
    $this->load_cart_data( $user_id );
  }

  /**
   * load_cart_products function.
   *
   * @access public
   * @param mixed $db
   * @param mixed $session_id
   * @return void
   */
  public function load_cart_data( $user_id = null )
  {
    $products = array();

    if( is_int( $user_id ) )
    {
      global $ssdb;

      $stmt = $ssdb->prepare( 'SELECT * FROM '.TABLE_PREFIX.'cart WHERE 1=1 AND cart_user_id = ? ' );
      $stmt->bindValue( 1 , "$user_id", PDO::PARAM_STR );
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
   * create_cart_product_record function.
   *
   * @access public
   * @param mixed $session_id
   * @param mixed $product_id
   * @return void
   */
  public function create_cart_product_record( $user_id, $product_id )
  {
    $result = null;

    if( is_int( $user_id ) )
    {
      global $ssdb;

      $stmt = $ssdb->prepare(' INSERT INTO '.TABLE_PREFIX.'cart ( cart_user_id, cart_product_id ) VALUES ( :user_id, :product_id ) ' );
      $stmt->bindParam( ':user_id',    $user_id, PDO::PARAM_INT );
      $stmt->bindParam( ':product_id', $product_id, PDO::PARAM_INT );
      $stmt->execute();
      $row_id = $ssdb->lastInsertId();

      if( $row_id != null )
      {
        $result = (int) $row_id;
      }
    }

    return $result;
  }

  /**
   * get_cart_contents function.
   *
   * @access public
   * @return void
   */
  public function get_cart_contents()
  {
    $items_html = '<ul>';

    if( is_array( $this->cart_items ) && !empty( $this->cart_items ) )
    {
      foreach( $this->cart_items as $cart_item )
      {
        $type        = new Product_Type( $cart_item->product_type );
        $ingredient  = new Ingredient();
        $ingredients = $ingredient->load_product_ingredients( $cart_item->product_id );
        $product     = new Product( $cart_item->product_id );

        $data['cart_item']['product_type']        = $type->product_type_name;
        $data['cart_item']['product_ingredients'] = $ingredients;
        $data['cart_item']['product_price_total'] = $product->get_product_total_price( $product, $ingredients );

        $items_html .= Template_Helper::render_template( __TEMPLATE_PATH__, 'cart-item', $data );
      }
    }

    $items_html .= '</ul>';

    return $items_html;
  }

  /**
   * cart_item_count_string function.
   *
   * @access public
   * @return void
   */
  public function cart_item_count_string()
  {
    $str = '';

    if( is_array( $this->cart_items ) && !empty( $this->cart_items ) )
    {
      $count = count( $this->cart_items );

      if( $count > 0 )
        $str .= '('.$count.')';
    }

    echo $str;
  }

  /**
   * checkout_button function.
   *
   * @access public
   * @return void
   */
  public function checkout_button()
  {
    $btn   = '';

    if( count( $this->cart_items ) > 0 )
    {
      $btn .= '<div class="cart-submit">
                <a href="#" data-trigger-popup="checkout" class="btn btn-primary">Checkout</a>
              </div>';
    }

    return $btn;
  }

  /**
   * get_cart_total function.
   *
   * @access public
   * @return void
   */
  public function get_cart_total()
  {
    $total = array();

    if( is_array( $this->cart_items ) && !empty( $this->cart_items ) )
    {
      foreach( $this->cart_items as $cart_item )
      {
        $type        = new Product_Type( $cart_item->product_type );
        $ingredient  = new Ingredient();
        $ingredients = $ingredient->load_product_ingredients( $cart_item->product_id );
        $product     = new Product( $cart_item->product_id );

        $total[] = $product->get_product_total_price( $product, $ingredients );
      }
    }

    return array_sum( $total );
  }

  /**
   * get_checkout function.
   *
   * @access public
   * @return void
   */
  public function get_checkout()
  {
    $html     = '';
    $types    = array();
    $products = array();

    if( is_array( $this->cart_items ) && !empty( $this->cart_items ) )
    {
      foreach( $this->cart_items as $item )
      {
        $type = new Product_Type( $item->product_type );

        if( $type != 'cone' )
        {
          $types[] = '<input type="hidden" name="cart_product_types[]" value="'.$item->product_id.'" />';
        }

        $products[] = '<input type="hidden" name="cart_product[]" value="'.$item->product_id.'" />';
      }
    }

    $data['checkout']['cart_total'] = $this->get_cart_total();
    $data['checkout']['types']      = $types;
    $data['checkout']['products']   = $products;

    return Template_Helper::render_template( __TEMPLATE_PATH__, 'checkout', $data );
  }

  /**
   * destroy_cart function.
   *
   * @access public
   * @return void
   */
  public function destroy_cart( $user )
  {
    $result = false;

    if( $user instanceOf User )
    {
      global $ssdb;

      $stmt = $ssdb->prepare( 'DELETE FROM '._TABLE_PREFIX.'cart WHERE cart_user_id = ? ' );
      $stmt->bindParam( 1, $user->user_id, PDO::PARAM_INT );

      if( $stmt->execute() )
      {
        $result = true;
      }
    }

    return $result;
  }
}