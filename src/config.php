<?php
  
/**
 * @const ACTION_VIEW The root path of the package
 */ 
define( 'ACTION_VIEW', dirname(__FILE__) );

/**
 * @const ACTION_VIEW_NAMESPACE The package namespace.
 */ 
define( 'ACTION_VIEW_NAMESPACE', 'ActionView' );

/**
 * @const USE_HAML use haml preprocessor?
 */ 
if(!defined('USE_HAML'))
{
  define('USE_HAML', false);
}

if(!defined('HAML_CACHE_PATH'))
{
  define('HAML_CACHE_PATH', ACTION_VIEW.'/.haml');
}