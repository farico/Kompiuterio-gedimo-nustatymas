<?php

/**
 * Description of page
 *
 * @author Aivaras Voveris <aivaras@activesec.eu>
 * @since Oct 8, 2011
 */
class page
{
    /**
     * @var bool defined if user must be logged in to access page
     */
    protected $_loginRequired = false;
    
    /**
     * @var bool show layout?
     */
    protected $_showLayout = true;
    
    /**
     * @var bool show view?
     */
    protected $_showView = true;
    
    /**
     * @var string controller name
     */
    protected $_controller = null;
    
    protected $_self = null;
    
    /**
     * @var string view extension
     */
    protected $_viewExt = '.view.php';
    
    /**
     * @var string layout name (in views/layouts/$_layout.$_viewExt
     */
    protected $_layout = 'default';
    
    /**
     * @var array holds template vars and their values
     */
    protected $_templateValues = null;
    protected $_layoutVars = null;
    
    /**
     * @var database instance of database
     */
    protected $db = null;
    
    protected $_validates = true;
    protected $_errors = null;
    
    /**
     * Sets controller name and initiates database
     */
    public function __construct()
    {
        $this->_controller = get_class($this);
        $this->db = db::getInstance();
        $this->_self = str_replace('pages__', null, $this->_controller == 'page' ? URL : URL . $this->_controller . '/');
    }
    
    /**
     * Default action
     */
    public function index()
    {
        
    }
    
    /**
     * Before action callback function
     * @param string $action action to be called
     * @return bool true
     */
    protected function _beforeAction($action)
    {
        return true;
    }
    
    /**
     * Calls action, checks for result and attempts to display action template
     * @param string $action action name
     */
    final public function callAction($action)
    {
        $beforeAction = $this->_beforeAction($action);
        if ($beforeAction !== true) {
            return false;
        }
        
        $result = $this->$action();
        if ($result !== false) {
            $this->_beforeDisplay();
            $this->display(str_replace('pages__', null, $this->_controller) . '/' . $action);
        }
    }
    
    protected function _beforeDisplay()
    {
        
    }
    
    /**
     * Displays template by path
     * @param string $path template path
     */
    public function display($path)
    {
        $aliases = array(
            'errors' => 'app/errors'
        );
        if (isset($aliases[$path])) {
            $path = $aliases[$path];
        }
        unset($aliases);
        if (file_exists(APP_LOCATION . 'views/' . $path . $this->_viewExt)) {
            if ($this->_templateValues !== null) {
                extract($this->_templateValues, EXTR_SKIP|EXTR_REFS);
            }
            $here = $this->_self;
            $validates = $this->_validates;
            ob_start();
            include APP_LOCATION . 'views/' . $path . $this->_viewExt;
            $actionOutput = ob_get_contents();
            ob_end_clean();
            
            if ($this->_showLayout && $path != 'app/errors') {
                if ($this->_layoutVars !== null) {
                    extract($this->_layoutVars, EXTR_SKIP|EXTR_REFS);
                }
                $content =& $actionOutput;
                include APP_LOCATION . 'views/layouts/' . $this->_layout . $this->_viewExt;
            } else {
                echo $actionOutput;
            }
        } else {
            pr('View not found: ', APP_LOCATION . 'views/' . $path . $this->_viewExt);
        }
    }
    
    /**
     * Sets variable for template
     * @param string $var variable name
     * @param mixed $value vairable value
     * @return bool success
     */
    protected function _set($var, $value = null)
    {
        return $this->_setViewVar('templateValues', $var, $value);
    }
    
    protected function _setLayout($var, $value = null)
    {
        return $this->_setViewVar('layoutVars', $var, $value);
    }
    
    protected function _setViewVar($type, $var, $value = null)
    {
        $varName = '_' . $type;
        
        if (is_array($var) && is_null($value)) {
            $keys = array_keys($var);
            extract($var);
            $var = $keys[0];
            $value = ${$var};

            foreach($keys as $var) {
                $this->{$varName}[$var] = ${$var};
            }
            return true;
        }
        $this->{$varName}[$var] = $value;
        return true;
    }
    
    protected function _error($error)
    {
        $this->_errors[] = $error;
    }
    
    protected function _validates()
    {
        if (empty($this->_errors)) {
            return true;
        }
        
        $this->_set('errors', $this->_errors);
        $this->_validates = false;
        
        return false;
    }
    
    protected function _redirect($where)
    {
        header('Location: ' . $where);
        die;
    }
}
