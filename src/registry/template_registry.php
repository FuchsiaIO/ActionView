<?php
/**
 * Template Registry
 */
namespace ActionView\Registry;

/**
* Template Registry
*
* Registers a template, constructs a closure wrapping the file path
*
* @since        v0.0.1
* @version      v0.0.1
* @package      ActionView
* @subpackage   Registry
* @author       Benjamin J. Anderson <andeb2804@gmail.com>
*/
class TemplateRegistry
{
  
  /** @var array $map Template Registries */
  protected $map;
  
  /**
   * Constructs a new template registry
   *
   * @since v0.0.1
   * @param array $map An array containing templates to register
   */
  public function __construct( $map = array() )
  {
    foreach ($map as $name => $spec) 
    {
      $this->set($name, $spec);
    }
  }
  
  /**
   * Registers a template
   *
   * @since v0.0.1
   * @since v0.0.2 Automatically preprocesses HAML files when .haml is in the filename
   * @param string $name An alias to the template
   * @param string $spec The file template path
   */
  public function set( $name, $spec )
  {
    if (is_string($spec)) 
    {
      $__FILE__ = $spec;
      $spec = function ($__VARS__ = array()) use ($__FILE__) 
      {
        extract($__VARS__, EXTR_SKIP);
    
        if(!file_exists($__FILE__))
        {
          throw new \ActionView\Exception\TemplateNotFound('Unable to load view: '.$__FILE__);
        }
        
        if(USE_HAML || strstr($__FILE__, '.haml'))
        {
          $haml = new \MtHaml\Environment('php');
          $hamlExecutor = new \MtHaml\Support\Php\Executor($haml, array(
              'cache' => HAML_CACHE_PATH,
          ));
          return $hamlExecutor->display($__FILE__, $__VARS__);
        }
        else
        {
          $content = require $__FILE__;
          return $content;
        }
      };
    }
    $this->map[$name] = $spec;
  }
  
  /**
   * Validates that a template exists in the template map
   *
   * @since v0.0.1
   * @param string $name A template alias
   */
  public function has( $name )
  {
    return isset($this->map[$name]);
  }
  
  /**
   * Gets a template from the template map
   *
   * @since v0.0.1
   * @param string $name A template alias
   */
  public function get( $name )
  {
    if(isset($this->map[$name]))
    {
      return $this->map[$name];
    }
    throw new \ActionView\Exception\TemplateNotFound($name);
  }
}