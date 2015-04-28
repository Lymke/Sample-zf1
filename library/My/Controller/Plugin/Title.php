<?php
/**
 * @desc        
 */
class My_Controller_Plugin_Title extends Zend_Controller_Plugin_Abstract
{
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
      //$module     = $request->getModuleName() ;
      $controller = $request->getControllerName() ;
      $action     = $request->getActionName() ;
      
      $view = Zend_Controller_Front::getInstance()
                    ->getParam('bootstrap')
                    ->getResource('view');
      
       $view->headTitle()->append($controller);
       $view->headTitle()->append($action);
    }
    
}