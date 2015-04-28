<?php  
class Zend_View_Helper_CssHelper extends Zend_View_Helper_Abstract 
{ 
    function cssHelper() { 
        $request = Zend_Controller_Front::getInstance()->getRequest(); 
        $file_uri = 'css/app/' . $request->getControllerName() . '/' . $request->getActionName() . '.css'; 
         
        if (file_exists($file_uri)) { 
            return '<link rel="stylesheet" href="/'.$file_uri.'">';
        } 
         
        return $this->view->headLink(); 
         
    } 
}