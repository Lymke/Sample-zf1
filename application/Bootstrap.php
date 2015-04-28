<?php
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    /**
     * Initialize view
     *
     * @return Zend_View
     */
    protected function _initView(){
        $view = new Zend_View();
        $view->doctype('HTML5');
        $view->headTitle('Zend')
             ->setSeparator(' - ');
        $view->headMeta()->appendHttpEquiv('Content-Type', 'text/html; charset=UTF-8');
        $view->addHelperPath("My/View/Helper", "My_View_Helper");
        
        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
        $viewRenderer->setView($view);
        return $view;
    }
    /**
     * Configuration de la base de données
     */
    protected function _initDatabase()
    {   
        $configDb = new Zend_Config_Ini( APPLICATION_PATH . '/configs/db.ini', APPLICATION_ENV);
        $dbAdapter = Zend_Db::factory($configDb->resources->db);
        // Set the DB Table default adaptor for auto connection in the models
        Zend_Db_Table::setDefaultAdapter($dbAdapter);
        Zend_Registry::set('dbAdapter', $dbAdapter);
    }
    
    /**
     * Configuration des ACL
     */
    protected function _initACL()
    {
        $this->bootstrap('FrontController');
        $front = $this->getResource('FrontController');
        
        $acl_ini = APPLICATION_PATH . '/configs/acl.ini';
        $acl     = new My_Acl_Ini($acl_ini) ;
        Zend_Registry::set('acl',$acl);
        $front->registerPlugin(new My_Controller_Plugin_Auth($acl));
    }
    
    /**
     * Configurer le registre
     */
    protected function _initRegistry()
    {
        $salt = $this->getOption('salt');
        Zend_Registry::set('salt', $salt);
    }
}
