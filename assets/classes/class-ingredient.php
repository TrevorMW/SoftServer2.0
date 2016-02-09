<?php

class Ingredient
{
  public $ingredient_id;
  public $ingredient_name;
  public $ingredient_slug;
  public $ingredient_type;

  public $all_ingredients;

  /**
   * __construct function.
   *
   * @access public
   * @param mixed $identifier (default: null)
   * @return void
   */
  public function __construct( $identifier = null )
  {
    $this->load_ingredient( $identifier );
  }


  /**
   * load_ingredient function.
   *
   * @access public
   * @param mixed $identifier (default: null)
   * @return void
   */
  public function load_ingredient( $identifier = null )
  {
    global $ssdb;

    if( $ssdb instanceOf PDO )
    {
      if( is_int( $identifier ) )
      {
        $stmt = $ssdb->prepare( 'SELECT * FROM '.TABLE_PREFIX.'ingredients
                                 INNER JOIN '.TABLE_PREFIX.'ingredient_type
                                 ON '.TABLE_PREFIX.'ingredients.ingredient_type = '.TABLE_PREFIX.'ingredient_type.ingredient_type_id
                                 WHERE 1=1 AND ingredient_id = ?' );


        $stmt->bindValue( 1, "$identifier", PDO::PARAM_INT );
      }
      else
      {
        $stmt = $ssdb->prepare( 'SELECT * FROM '.TABLE_PREFIX.'ingredients
                                 INNER JOIN '.TABLE_PREFIX.'ingredient_type
                                 ON '.TABLE_PREFIX.'ingredients.ingredient_type = '.TABLE_PREFIX.'ingredient_type.ingredient_type_id
                                 WHERE 1=1 AND ingredient_slug = ?' );

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
   * get_ingredients_by_type function.
   *
   * @access public
   * @param mixed $type_id
   * @return void
   */
  public function get_ingredients_by_type( $type_id )
  {
    global $ssdb;

    $filtered_options = array();

    if( $ssdb instanceOf PDO )
    {
      $stmt = $ssdb->prepare( "SELECT * FROM ".TABLE_PREFIX."ingredients WHERE 1=1 AND ingredient_type = ?" );
      $stmt->bindValue( 1, "$type_id", PDO::PARAM_STR );
      $stmt->execute();
      $result = $stmt->fetchAll( PDO::FETCH_OBJ );

      if( is_array( $result ) )
        $filtered_options = $this->build_ingredient_array( $result );
    }

    return $filtered_options;
  }


  /**
   * build_ingredient_array function.
   *
   * @access public
   * @param mixed $data
   * @return void
   */
  public function build_ingredient_array( $data )
  {
    $ingredients = array();

    if( is_array( $data ) && !empty( $data ) )
    {
      foreach( $data as $k => $val )
      {
        $ingredients[ $val->ingredient_id ] = $val->ingredient_name;
      }
    }

    return $ingredients;
  }
}