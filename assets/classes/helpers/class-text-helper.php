<?php

class Text_Helper
{

  /**
   * sanitize_title_with_dashes function.
   *
   * @access public
   * @param mixed $title
   * @param string $raw_title (default: '')
   * @param string $context (default: 'display')
   * @return void
   */
  public static function sanitize_title_with_dashes( $title, $raw_title = '', $context = 'display' )
  {
    $title = strip_tags( $title );
    $title = preg_replace( '|%([a-fA-F0-9][a-fA-F0-9])|', '---$1---', $title );
    $title = str_replace( '%', '', $title);
    $title = preg_replace( '|---([a-fA-F0-9][a-fA-F0-9])---|', '%$1', $title );
    $title = strtolower( $title );
    $title = preg_replace( '/&.+?;/', '', $title ); // kill entities
    $title = str_replace( '.', '-', $title );
    $title = preg_replace('/[^%a-z0-9 _-]/', '', $title);
    $title = preg_replace('/\s+/', '-', $title);
    $title = preg_replace('|-+|', '-', $title);
    $title = trim( $title, '-' );

    return $title;
  }

  /**
   * format_string_as_price function.
   *
   * @access public
   * @static
   * @param mixed $string
   * @return void
   */
  public static function format_string_as_price( $string )
  {
    return '$'.number_format( $string, 2 );
  }
}