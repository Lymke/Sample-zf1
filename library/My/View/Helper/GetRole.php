<?php
class My_View_Helper_GetRole extends Zend_View_Helper_Abstract {
  public function getRole() {
    
    $auth = Zend_Auth::getInstance() ;  
                
    // contrôle si l'utilisateur est authentifié     
    if ($auth->hasIdentity()) {
      
      $user = $auth->getStorage()->read();
      $role = $user->role_user;
      
    } else {
      
      $role = 'guest';
      
    }
     return $role;
  }
}