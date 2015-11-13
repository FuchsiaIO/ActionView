<?php
/**
 * View Factory
 */
namespace ActionView\Factory;

/**
* View Factory
*
* Constructs new Concrete Views
*
* @since        v0.0.1
* @version      v0.0.1
* @package      ActionView
* @subpackage   Factory
* @author       Benjamin J. Anderson <andeb2804@gmail.com>
*/
class ViewFactory
{
  
  /**
   * newInstance
   *
   * @since v0.0.1
   * @param array $views     The view alias list
   * @param array $templates The template alias list
   * @return ActionView\View\Concrete A concrete view
   */
  public function newInstance( $views = array(), $templates = array() )
  {
    return new \ActionView\View\Concrete(
      new \ActionView\Registry\TemplateRegistry($views),
      new \ActionView\Registry\TemplateRegistry($templates)
    );
  }
  
}