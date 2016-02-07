<?php

class FormHelper
{
  /**
   * build_select_options function.
   *
   * @access public
   * @static
   * @param array $options (default: array())
   * @param mixed $default_name (default: null)
   * @return void
   */
  public static function build_select_options( array $options = null, $default_name = null )
  {
    $option_html = '';

    if( is_array( $options ) && $options != null )
    {
      $default_name != null ? $option_html .= '<option value="">'.$default_name.'</option>' : '' ;

      foreach( $options as $k => $option )
      {
        $option_html .= '<option value="'.$k.'" >'.ucfirst( $option ).'</option>';
      }
    }

    return $option_html;
  }

  public static function parse_fields( array $fields = null )
  {
    $field_html = '';

    if( is_array( $fields ) && !empty( $fields ) )
    {
      foreach( $fields as $k => $field )
      {
        $field_html .= FormHelper::build_field( $field );
      }
    }

    return $field_html;
  }

  public static function build_field( $field_data )
  {
    $html = '';

    if( is_array( $field_data ) && !empty( $field_data ) )
    {
      switch( $field_data['type'] )
      {
        case 'select' :

          $html = '<select name="'.$field_data['name'].'" '.$field_data['data'].'>'.$field_data['options'].'</select>';

        break;

        case 'hidden' :

          $html = '<input type="hidden" name="'.$field_data['name'].'" '.$field_data['data'].' value="'.$field_data['value'].'" />';

        break;

      }
    }

    return $html;
  }
}