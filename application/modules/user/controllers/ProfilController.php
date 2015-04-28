<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProfilController
 *
 * @author jldr8346
 */
class User_ProfilController extends Zend_Controller_Action
{
    
    
    public function indexAction()
    {
       $params = $this->getAllParams();
       
       if(isset($params['id_user'])){
           
           $userTable = new User_Model_DbTable_User();
           $userRow = $userTable->fetchRow('id_user = ' . $params['id_user']);
           
           if(sizeof($userRow) == 1){
               $this->view->user = $userRow;
           }else{
               $this->redirect('/frontend/error/profil-inexistant');
           }
           
       }else{
           
            $auth = Zend_Auth::getInstance();
            $this->view->user = $auth->getStorage()->read();
           
       }

    }
    
}