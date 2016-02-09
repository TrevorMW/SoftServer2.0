<?php

class Ingredient_Type
{
  public $ingredient_type_id;
  public $ingredient_type_name;
  public $ingredient_type_slug;

  public $ingredient_types;

  public function __construct( $identifier = null)
  {
    $this->load_ingredient_type( $identifier );
    $this->load_all_ingredient_types();
  }

  /**
   * load_product_type function.
   *
   * @access public
   * @param mixed $identifier (default: null)
   * @return void
   */
  public function load_ingredient_type( $identifier = null )
  {
    global $ssdb;

    if( is_int( $identifier ) )
    {
      $stmt = $ssdb->prepare( 'SELECT * FROM '.TABLE_PREFIX.'ingredient_type WHERE 1=1 AND ingredient_type_id = ?' );
      $stmt->bindValue( 1, "$identifier", PDO::PARAM_INT );
    }
    else
    {
      $stmt = $ssdb->prepare( 'SELECT * FROM '.TABLE_PREFIX.'ingredient_type WHERE 1=1 AND ingredient_type_slug = ?' );
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

  /**
   * load_all_types function.
   *
   * @access public
   * @return void
   */
  public function load_all_ingredient_types()
  {
    global $ssdb;

    $types = array();

    if( $ssdb instanceOf PDO )
    {
      $stmt = $ssdb->prepare( 'SELECT * FROM '.TABLE_PREFIX.'ingredient_type' );
      $stmt->execute();
      $result = $stmt->fetchAll( PDO::FETCH_OBJ );

      if( is_array( $result ) && !empty( $result ) )
      {
        foreach( $result as $k => $val )
        {
          $types[ $val->ingredient_type_id ] = $val->ingredient_type_name;
        }
      }
    }

    $this->ingredient_types = $types;
  }
}