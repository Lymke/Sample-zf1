<?php
class My_View_Helper_IsConnected extends Zend_View_Helper_Abstract {
  public function isConnected() {
    $auth = Zend_Auth::getInstance() ;  
     return $auth->hasIdentity();
  }
}