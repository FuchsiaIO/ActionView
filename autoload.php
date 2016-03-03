<?php

/**
 * Action View Autoloader
 *
 * Autoloads all Classes within the application/src directory
 *
 * @author Benjamin J. Anderson <andeb2804@gmail.com>
 * @package Global
 * @since 1.0.0
 * @version v1.0.1
 */

require_once dirname(__FILE__).'/src/config.php';

if(defined('FUCHSIA_ROOT_PATH'))
{
  require_once FUCHSIA_ROOT_PATH.'/vendor/autoload.php';
}
else
{
  require_once dirname(__FILE__).'/vendor/haml/lib/MtHaml/Autoloader.php';
}

MtHaml\Autoloader::register();

spl_autoload_register(function($class){
  $class = strtolower(preg_replace('/\B([A-Z])/', '_$1', str_replace(ACTION_VIEW_NAMESPACE, '', $class)));
  $file = ACTION_VIEW.
    implode( '', 
      array_map( 
        function($fragment) use ($class){
          return "/$fragment";
        }, explode( '\\', $class )
      )
    ).'.php';
    if(file_exists($file))
    {
      require_once $file;
    }
});
