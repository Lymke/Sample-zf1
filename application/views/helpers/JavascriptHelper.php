<?php 
class Zend_View_Helper_JavascriptHelper extends Zend_View_Helper_Abstract
{   
    function javascriptHelper() {
        $request = Zend_Controller_Front::getInstance()->getRequest();
        $file_uri = 'js/app/' . $request->getControllerName() . '/' . $request->getActionName() . '.js';
        
        if (file_exists($file_uri)) {
            return '<script type="text/javascript" src="/'.$file_uri.'"> </script>';
        }
    }
}