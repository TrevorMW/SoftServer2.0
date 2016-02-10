<?php

class Product_Type
{
  public $product_type_id;
  public $product_type_name;
  public $product_type_slug;
  public $product_type_base_price;

  public $types;

  /**
   * __construct function.
   *
   * @access public
   * @param mixed $identifier (default: null)
   * @return void
   */
  public function __construct( $identifier = null)
  {
    $this->load_product_type( $identifier );
    $this->load_all_types();
  }

  /**
   * load_product_type function.
   *
   * @access public
   * @param mixed $identifier (default: null)
   * @return void
   */
  public function load_product_type( $identifier = null )
  {
    global $ssdb;

    if( is_int( $identifier ) )
    {
      $stmt = $ssdb->prepare( 'SELECT * FROM '.TABLE_PREFIX.'product_type WHERE 1=1 AND product_type_id = ?' );
      $stmt->bindValue( 1, "$identifier", PDO::PARAM_INT );
    }
    else
    {
      $stmt = $ssdb->prepare( 'SELECT * FROM '.TABLE_PREFIX.'product_type WHERE 1=1 AND product_type_slug = ?' );
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
  public function load_all_types()
  {
    global $ssdb;

    $types = array();

    if( $ssdb instanceOf PDO )
    {
      $stmt = $ssdb->prepare( 'SELECT * FROM '.TABLE_PREFIX.'product_type' );
      $stmt->execute();

      $result = $stmt->fetchAll( PDO::FETCH_OBJ );

      if( is_array( $result ) && !empty( $result ) )
      {
        foreach( $result as $k => $val )
        {
          $types[ $val->product_type_slug ] = $val->product_type_name;
        }
      }
    }

    $this->types = $types;
  }

  /**
   * get_product_form_fields function.
   *
   * @access public
   * @param Product_Type $product_type
   * @return void
   */
  public function get_product_form_fields( Product_Type $product_type )
  {
    $fields = '';

    $ingredient = new Ingredient();

    if( $product_type->product_type_slug != null )
    {
      $ingredient->get_ingredients_by_type( 1 );

      switch( $product_type->product_type_slug )
      {
        case 'cone' :

          $ingredients = $ingredient->get_ingredients_by_type( 4 );

          unset( $ingredients[18] );

          $fields .= '<input type="hidden" name="product_type" value="'.$product_type->product_type_id.'" />
                      <li>
                        <select name="ingredients[container]">
                        '.Form_Helper::build_select_options( $ingredients , 'Select a Cone Type'  ).'
                        </select>
                      </li>
                      <li>
                        <label>Scoop #1</label>
                        <select name="ingredients[ice_cream][]">
                        '.Form_Helper::build_select_options( $ingredient->get_ingredients_by_type( 1 ), 'Select 1st Ice Cream Flavor' ).'
                        </select>
                      </li>
                      <li>
                        <label>Scoop #2</label>
                        <select name="ingredients[ice_cream][]">
                        '.Form_Helper::build_select_options( $ingredient->get_ingredients_by_type( 1 ), 'Select 2nd Ice Cream Flavor' ).'
                        </select>
                      </li>';

                    //<li class="submit"><a href="#" data-ajax-get data-action="add_field" data-extra-data="ice_cream">Add Another Flavor!</a></li>


        break;

        case 'milkshake' :

          $fields .= '<input type="hidden" name="product_type" value="'.$product_type->product_type_id.'" />
                      <li>
                        <input type="hidden" name="ingredients[container]" value="18" />
                      </li>
                      <li>
                        <select name="ingredients[ice_cream]">
                        '.Form_Helper::build_select_options( $ingredient->get_ingredients_by_type( 1 ), 'Select an Ice Cream Flavor' ).'
                        </select>
                      </li>
                      <li>
                        <select name="ingredients[milk][]">
                        '.Form_Helper::build_select_options( $ingredient->get_ingredients_by_type( 3 ), 'Select Milk Type' ).'
                        </select>
                      </li>';
        break;


        case 'float' :

          $fields .= '<input type="hidden" name="product_type" value="'.$product_type->product_type_id.'" />
                      <li>
                        <input type="hidden" name="ingredients[container]" value="18" />
                      </li>
                      <li>
                        <select name="ingredients[soda][]">
                        '.Form_Helper::build_select_options( $ingredient->get_ingredients_by_type( 2 ), 'Select a Soda' ).'
                        </select>
                      </li>
                      <li>
                        <label>Scoop #1</label>
                        <select name="ingredients[ice_cream][]">
                        '.Form_Helper::build_select_options( $ingredient->get_ingredients_by_type( 1 ), 'Select an Ice Cream Flavor' ).'
                        </select>
                      </li>
                      <li class="submit"><a href="#" data-ajax-get data-action="add_field" data-extra-data="ice_cream">Add Another Flavor!</a></li>';
        break;

      }
    }

    return $fields;
  }
}