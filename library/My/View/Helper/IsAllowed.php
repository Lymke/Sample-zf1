<?php
/**  * Proxy vers le contrôleur d'authentification **/ 
    class My_View_Helper_IsAllowed extends Zend_View_Helper_Abstract 
    {   
        
        protected $_acl;   
        protected $_auth; 
        
        
        /**    * Proxy vers la fonction acl is allowed function    */   
        public function isAllowed($resource, $actions) 
        {      
                $this->_acl = Zend_Registry::get('acl') ; 
                $this->_auth = Zend_Auth::getInstance() ;     
                // contrôle si l'utilisateur est authentifié     
                if ($this->_auth->hasIdentity()) 
                {       // yes ! on récupère son role       
                        $user = $this->_auth->getStorage()->read() ;       
                        $role = $user->role_user;     
                        
                } 
                else 
                {
                    // non = invité       
                    $role = 'guest';
                }
                // contrôle si l'utilisateur est autorisé     
                return $this->_acl->isAllowed($role, $resource, $actions) ;   
        }
                
        
    }