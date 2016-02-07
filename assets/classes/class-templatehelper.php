<?php

class TemplateHelper
{
  public function get_template( $path = null, $name = null, array $params = null )
  {
    $html = '';

    if ( isset( $name ) )
      $template = "{$path}{$name}.php";

    if ( is_array( $params ) )
      extract( $params, EXTR_SKIP );

    include( $template );
  }

  public static function render_template( $path = null, $name = null, array $params = null )
  {
    $html = '';

    ob_start();

    $template = new TemplateHelper();
    $template->get_template( $path, $name, $params );

    $html .= ob_get_contents();

    ob_get_clean();

    return $html;
  }
}