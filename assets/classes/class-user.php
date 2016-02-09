<?php

class User
{
  public  $user_id;
  public  $user_name;
  private $user_password;

  public $current_user = null;


  /**
   * __construct function.
   *
   * @access public
   * @param mixed $id
   * @return void
   */
  public function __construct( $id = null )
  {
    $this->load_user( $id );
  }


  /**
   * load_user function.
   *
   * @access public
   * @param mixed $id
   * @return void
   */
  public function load_user( $identifier = null )
  {
    global $ssdb;

    if( is_int( $identifier ) )
    {
      $stmt = $ssdb->prepare( 'SELECT * FROM '.TABLE_PREFIX.'users WHERE 1=1 AND user_id = ?' );
      $stmt->bindValue( 1, "$identifier", PDO::PARAM_INT );
    }
    else
    {
      $stmt = $ssdb->prepare( 'SELECT * FROM '.TABLE_PREFIX.'users WHERE 1=1 AND user_name = ?' );
      $stmt->bindValue( 1, "$identifier", PDO::PARAM_STR );
    }

    $stmt->execute();
    $result = $stmt->fetchAll( PDO::FETCH_OBJ );

    if( is_array( $result ) )
    {
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