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
   * @return ActionView\View\Concrete A concrete view
   */
  public function newInstance()
  {
    return new \ActionView\View\Concrete(
      new \ActionView\Registry\TemplateRegistry,
      new \ActionView\Registry\TemplateRegistry
    );
  }
  
}