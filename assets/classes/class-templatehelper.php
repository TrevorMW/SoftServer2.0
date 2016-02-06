<?php

class TemplateHelper
{
  public static function render_template( $path = null, $name = null, array $params = null )
  {
    $templates = array();
    if ( isset( $name ) )
      $templates[] = "/views/{$path}/{$name}.php";

    $templates[] = "/views/{$path}/{$slug}.php";

    $_template_file = locate_template( $templates, false, false );

    if ( is_array( $params ) )
      extract( $params, EXTR_SKIP );

    require( $_template_file );
  }

}