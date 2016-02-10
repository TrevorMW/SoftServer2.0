<?php

class Coupon
{
  public $coupon_id;
  public $coupon_code;
  public $coupon_discount;

  /**
   * __construct function.
   *
   * @access public
   * @param mixed $coupon_identifier (default: null)
   * @return void
   */
  public function __construct( $coupon_identifier = null )
  {
    $this->load_coupon( $coupon_identifier );
  }

  /**
   * load_coupon function.
   *
   * @access public
   * @param mixed $identifier (default: null)
   * @return void
   */
  public function load_coupon( $identifier = null )
  {
    global $ssdb;

    if( $ssdb instanceOf PDO )
    {
      $stmt = null;

      if( is_int( $identifier ) )
      {
        $stmt = $ssdb->prepare( 'SELECT * FROM '.TABLE_PREFIX.'coupons WHERE 1=1 AND coupon_id = ?' );
        $stmt->bindValue( 1, "$identifier", PDO::PARAM_INT );
      }
      else
      {
        $stmt = $ssdb->prepare( 'SELECT * FROM '.TABLE_PREFIX.'coupons WHERE 1=1 AND coupon_code = ?' );
        $stmt->bindValue( 1, "$identifier", PDO::PARAM_STR );
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
}