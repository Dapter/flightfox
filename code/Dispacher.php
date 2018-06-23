<?php

class Dispacher {
    
    /**
     * @var Controller
     */
    private $controller;
            
    /**
     * @param Controller $controller
     */
    public function __construct(Controller $controller)
    {
        $this->controller = $controller;
    }
    
    /**
     * @throws Exception
     */
    public function dispatch()
    {
        if (!$this->isAjax()) {
            echo file_get_contents('../template/list.html');
            return;
        }
        
        $param = null;
        $actionName = $this->getActionNameFromURI();
        
        if (strpos($actionName, '/')) {
            list($actionName, $param) = explode('/', $this->getActionNameFromURI());
        }
        
        if (!method_exists($this->controller, $actionName)) {
            throw new Exception('Page not found', 404);
        }

        $data = $this->controller->$actionName($param);
        header('Content-Type: application/json');
        echo json_encode($data);
    }
    
    /**
     * @return string
     */
    private function getActionNameFromURI():string
    {
        $actionName = substr($_SERVER['REQUEST_URI'], 1);
        if ($actionName) {
            return $actionName;
        }
        
        return 'index';
    }
    
    /**
     * @return bool
     */
    private function isAjax():bool
    {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }
}