<?php

class Form_Helper
{
  /**
   * build_select_options function.
   *
   * @access public
   * @static
   * @param array $options (default: array())
   * @param mixed $selected (default: null)
   * @param mixed $default_name (default: null)
   * @return void
   */
  public static function build_select_options( $options = array(), $selected = null, $default_name = null )
  {
    $html = '';

    $default_name != null ? $html .= '<option value="">'.$default_name.'</option>' : '' ;

    if( !empty( $options ) )
    {
      foreach( $options as $k => $option )
      {
        $html .= '<option value="'.$k.'" '.selected( $selected, $k, $echo ).'>'.$option.'</option>';
      }
    }

    return $html;
  }
}