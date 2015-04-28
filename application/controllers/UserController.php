<?php
class UserController extends Zend_Controller_Action {
    
    public function inscriptionAction(){
        if ($this->_request->isPost ()) 
        {
            $userTable = new App_Model_Db_Table_UserTable();
            $userTable->inscrire($_POST);
            $this->_redirect('/user/connexion');
        }
        
    }
    
    public function ajaxCheckLoginAction(){
        $userTable = new App_Model_Db_Table_UserTable();
        $userRow = $userTable->fetchRow('login_user = "'.$_POST['login'].'"');
        if(sizeof($userRow) == 1){
            $res = true;
        }else{
            $res = false;
        }
        
        echo Zend_Json::encode($res);
        exit();
    }
    public function connexionAction(){
        if ($this->_request->isPost ()) 
        {
             if($_POST['connect_login'] != '' || $_POST['connect_password'] != ''){
                
                //configure l'instance avec des méthodes de réglage
                 
                    $dbAdapter = Zend_Db_Table::getDefaultAdapter();        
                    $authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);
                //Connexion
                    
                    $authAdapter->setIdentity($_POST['connect_login'])
                                ->setCredential($_POST['connect_password']);
                    $authAdapter->setTableName('user')
                                ->setIdentityColumn('login_user')
                                ->setCredentialColumn('password_user')
                                ->setCredentialTreatment('MD5(CONCAT("'.Zend_Registry::get('salt').'",?,(SUBSTR( salt_user, 3, 5))))');
                
                // Réalise la requête d'authentification, et sauvegarde le résultat
                
                    $auth   = Zend_Auth::getInstance();
                    $result = $auth->authenticate($authAdapter);
                if ($result->isValid()) 
                {
                    $data = $authAdapter->getResultRowObject(null, array('password','salt'));
                    $auth->getStorage()->write($data);
                    $this->_redirect('/user/profil');
                }
            }
        }
    }
        
    public function profilAction(){
        $auth = Zend_Auth::getInstance();
        $user = $auth->getStorage()->read() ;
        $dbProjet = new App_Model_Db_Table_ProjetTable();
        $this->view->projets = $dbProjet->getProjectByUser($user->id_user);
    }
    
    public function deconnexionAction()
    {
        Zend_Auth::getInstance()->clearIdentity();
    }
}