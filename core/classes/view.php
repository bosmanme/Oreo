<?php
/**
 * Part of the BHive framework.
 *
 * @package    BHive
 * @version    1.0
 * @author     Mathias Bosman
 * @license    MIT License
 * @copyright  2016 - Mathias Bosman
 */

namespace BHive\Core;

/**
* View class
*
* @package		BHive
* @subpackage	Core
*/
class View
{
    protected $_variables = [];
    protected $_controller;
    protected $_action;

    /**
     * Creates a new view
     * @param type $controller
     * @param type $action
     */
    public function __construct($controller, $action)
    {
        $this->_controller = strtolower($controller);
        $this->_action = $action;
    }

    /**
     * Set variables
     * @param string $name
     * @param mixed $value
     */
    public function set($name, $value)
    {
        $this->_variables[$name] = $value;
    }

    /**
     * Returns a variable
     * @param  string $name
     * @return mixed
     */
    public function get($name)
    {
        return $this->_variables[$name];
    }

    /**
     * Display the template if a controller specific footer or header is not found
     * the global header & footer in the view folder will be used
     * @param boolean $doNotRenderHeader enables not outputting headers for a particular action
     *                                   This can be used in AJAX calls.
     */
    public function render($doNotRenderHeader = false)
    {
        extract($this->_variables);

        if ($doNotRenderHeader == false) {
            if (file_exists(APPPATH . 'views' . DS . $this->_controller . DS . 'header.php')) {
                    include APPPATH . 'views' . DS . $this->_controller . DS . 'header.php';
            } else {
                    include APPPATH . 'views' . DS . 'header.php';
            }
        } else {
            // Include script if available
            $script = Asset::js($this->_controller . DS . $this->_action);
            if ($script) {
                echo '<script type="text/javascript" src="' . $script . '"></script>';
            }
        }

        if (file_exists(APPPATH . 'views' . DS . $this->_controller . DS . $this->_action . '.php')) {
            include APPPATH . 'views' . DS . $this->_controller . DS . $this->_action . '.php';
        }

        if ($doNotRenderHeader == false) {
            if (file_exists(APPPATH . 'views' . DS . $this->_controller . DS . 'footer.php')) {
                    include APPPATH . 'views' . DS . $this->_controller . DS . 'footer.php';
            } else {
                    include APPPATH . 'views' . DS . 'footer.php';
            }
        }
    }
}
