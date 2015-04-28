<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UtilisateursController
 *
 * @author mirolo
 */
class Admin_UtilisateursController extends Zend_Controller_Action{
    
    public function gererAction(){
        
        $userTable = new User_Model_DbTable_User();
        $roleTable = new Admin_Model_DbTable_Role();

        $userRowSet = $userTable->getUtilisateursOrderByRole();
        $roleRowSet = $roleTable->fetchAll();
        
        $this->view->userRowSet = $userRowSet;
        $this->view->roleRowSet = $roleRowSet;
        
    }
    
    
    public function modifierAjaxAction(){
        
        $res = false;
        $params = $this->getAllParams();
        
        if(isset($params['id_user'])){
            
            $userTable = new User_Model_DbTable_User();
        
            $userRow = $userTable->fetchRow('id_user = ' . $params['id_user']);
            
            if(sizeof($userRow) != 0){
                
                $userRow->role = $params['role'];
                $userRow->save();
                $res = true;
            }
        }
        echo Zend_Json::encode($res);
        exit();
    }
    
    public function supprimerAjaxAction(){
        
        $res = false;
        $params = $this->getAllParams();
        
        if(isset($params['id_user'])){
            
            $userTable = new User_Model_DbTable_User();
        
            $userRow = $userTable->fetchRow('id_user = ' . $params['id_user']);
            
            if(sizeof($userRow) != 0){
                $userRow->delete();
                $res = true;
            }
        }
         echo Zend_Json::encode($res);
        exit();
        
    }
    
}

?>
