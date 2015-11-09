<?php

/**
 * View Base
 */
namespace ActionView\View;

/**
* Base View Class
*
* Provides functionality to inherited view objects
*
* @since        v0.0.1
* @version      v0.0.1
* @package      ActionController
* @subpackage   View
* @author       Benjamin J. Anderson <andeb2804@gmail.com>
*/
abstract class Base
{
  /** @var object $data Data associated with the view */
  private $data;
  
  /** @var string $content The rendered view content */
  private $content;
  
  /** @var string $layout The name of the layout template in the layout template registry.*/
  private $layout;
  
  /** @var string $view The name of the view template in the view template registry. */
  private $view;
  
  /** @var array $section A collection point for section content.  */
  private $section;
  
  /** @var array $capture The stack of section names currently being captured. */
  private $capture;
  
  /** @var ActionController\Registry\TemplateRegistry $template_registry The template registry currently in use. */
  private $template_registry;
  
  /** @var ActionController\Registry\TemplateRegistry $view_registry The view registry currently in use. */
  private $view_registry;
  
  /** @var ActionController\Registry\TemplateRegistry $layout_registry The layout registry currently in use. */
  private $layout_registry;
  
  /**
   * Constructor.
   *
   * @since v0.0.1
   * @param TemplateRegistry $view_registry A registry for view templates.
   * @param TemplateRegistry $layout_registry A registry for layout templates.
   *
  */
  public function __construct( $view_registry, $layout_registry ) 
  {
    $this->data = (object) array();
    $this->view_registry = $view_registry;
    $this->layout_registry = $layout_registry;
  }
  
  /**
   * Sets the view and layout registry.
   *
   * @since v0.0.1
   * @param ActionController\Registry\TemplateRegistry $view_registry   The view registry.
   * @param ActionController\Registry\TemplateRegistry $layout_registry The layout registry.
   */
  public function setRegistries( $view_registry = null, $layout_registry = null)
  {
    $this->view_registry = $view_registry;
    $this->layout_registry = $layout_registry;
  }

  public function __get( $key )
  {
    return $this->data->$key;
  }
  
  
  public function __set( $key, $val )
  {
    $this->data->$key = $val;
  }
  
  
  public function __isset( $key )
  {
    return isset($this->data->$key);
  }
  
  
  public function __unset( $key )
  {
    unset($this->data->$key);
  }
  

  /**
  * Sets the data object.
  *
  * @since v0.0.1
  * @param array|object $data An array or object where the keys or properties
  * are variable names, and the corresponding values are the variable values.
  * (This param is cast to an object.)
  */   
  public function setData( $data )
  {
    $this->data = (object) $data;
  }
  
  /**
   * Adds to the view data.
   *
   * @since v0.0.1
   * @param array|Traversable $data An array or object where the keys or
   * properties are variable names, and the corresponding values are the
   * variable values; these are looped over and added to the view data.
   */
  public function addData( $data )
  {
    foreach ($data as $key => $val) 
    {
        $this->data->$key = $val;
    }
  }
  
  /**
   * Gets the data object.
   *
   * @since v0.0.1
   * @return object
   */
  public function getData()
  {
    return $this->data;
  }
  
  /**
   * Sets the content to be used in the layout.
   *
   * @since v0.0.1
   * @param string $content The content to be used in the layout.
   */ 
  protected function setContent( $content )
  {
    $this->content = $content;
  }
  
  /**
   * Gets the content to be used in the layout.
   *
   * @since v0.0.1
   * @return string
   */
  public function getContent()
  {
    return $this->content;
  }
  
  /**
   * Sets the name of the layout template to render.
   *
   * @since v0.0.1
   * @param string $layout The name of the layout template to render.
   */
  public function setLayout( $layout )
  {
    $this->layout = $layout;
  }

  /**
   * Gets the name of the layout template to be rendered.
   *
   * @since v0.0.1
   * @return string
   */
  public function getLayout()
  {
    return $this->layout;
  }

  /**
   * Is a particular named section available?
   *
   * @since v0.0.1
   * @param string $name The section name.
   * @return bool
   */
  protected function hasSection( $name )
  {
    return isset($this->section[$name]);
  }
  
  /**
   *
   * Sets the body of a named section directly, as opposed to buffering and
   * capturing output.
   *
   * @since v0.0.1
   * @param string $name The section name.
   * @param string $body The section body.
   */
  protected function setSection( $name, $body )
  {
    $this->section[$name] = $body;
  }
  

  /**
   * Gets the body of a named section.
   *
   * @since v0.0.1
   * @param string $name The section name.
   * @return string
   */
  protected function getSection( $name )
  {
    return $this->section[$name];
  }
  
  /**
   * Begins output buffering for a named section.
   *
   * @since v0.0.1
   * @param string $name The section name.
   */
  protected function beginSection( $name )
  {
    $this->capture[] = $name;
    ob_start();
  }
  
  /**
   *
   * Ends buffering and retains output for the most-recent section.
   *
   * @since v0.0.1
   */
  protected function endSection()
  {
    $body = ob_get_clean();
    $name = array_pop($this->capture);
    $this->setSection($name, $body);
  }
  
  /**
   * Gets the layout template registry.
   *
   * @since v0.0.1
   * @return Pointer
   */   
  public function &getLayoutRegistry()
  {
    return $this->layout_registry;
  }
  
  /**
   * Sets the name of the view template to render.
   *
   * @since v0.0.1
   * @param string $view The name of the view template to render.
   */
  public function setView( $view )
  {
    $this->view = $view;
  }
  

  /**
   * Gets the name of the view template to be rendered.
   *
   * @since v0.0.1
   * @return string
   */
  public function getView()
  {
    return $this->view;
  }
  

  /**
   * Gets the view template registry.
   *
   * @since v0.0.1
   * @return ActionController\Registry\TemplateRegistry
   */
  public function &getViewRegistry()
  {
    return $this->view_registry;
  }

  /**
   * Sets the template registry.
   *
   * @since v0.0.1
   * @param TemplateRegistry $template_registry The template registry.
   */
  protected function setTemplateRegistry( $template_registry )
  {
    $this->template_registry = $template_registry;
  }
  

  /**
   *
   * Gets a template from the registry and binds $this to it.
   *
   * @since v0.0.1
   * @param string $name The template name.
   * @return Closure
   */
  protected function getTemplate( $name )
  {
    $tmpl = $this->template_registry->get($name);
    return $tmpl->bindTo($this, get_class($this));
  }
}