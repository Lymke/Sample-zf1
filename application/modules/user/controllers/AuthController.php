<?php

class User_AuthController extends Zend_Controller_Action {

    
    public function inscriptionAction()
    {   
        $recaptchaAPI = new Recaptcha_Api();
        $config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/config.ini',APPLICATION_ENV);
        $captchaValide = true;
        if ($this->_request->isPost ()) 
        {
            $post =  $this->_request->getPost();
            
            $resp = $recaptchaAPI->recaptcha_check_answer ($config->recaptcha->privateKey,
                                                            $_SERVER["REMOTE_ADDR"],
                                                            $_POST["recaptcha_challenge_field"],
                                                            $_POST["recaptcha_response_field"]);

            if (!$resp->is_valid) 
            {
                $captchaValide = false;
            }
            else 
            {
                $login = $post['f_insc_login'];
                $mp = $post['f_insc_mp'];
                $email = $post['f_insc_email'];

                $userTable = new User_Model_DbTable_User();
                $userTable->inscrire($login, $mp, $email);

                $this->_redirect('/user/auth/connexion');
            }
        }
        $this->view->recaptchaAPI = $recaptchaAPI;
        $this->view->captchaValide = $captchaValide;
        $this->view->publickey = $config->recaptcha->publicKey;
    }
    
    public function connexionWithFacebookAction(){
        
        $params = $this->getAllParams();
        $res = false;
        
        if($params['fb_id'] != '' && $params['fb_email']){
            
            $userTable = new User_Model_DbTable_User();
            
            $userRow = $userTable->fetchRow('fb_email = "' . $params['fb_email'].'"');
            
            //l'utilisateur s'est connecté mais n'est pas référencé dnas notre base
            if(sizeof($userRow) == 0){
                $userRow = $userTable->inscrireWithFacebook($params);
            }
            
            $auth   = Zend_Auth::getInstance();
            $auth->getStorage()->write($userRow);
            $res = true;
            
        }
       
        echo Zend_Json::encode($res);
        exit();
    }
    
    public function connexionWithGoogleAction(){
        
        $params = $this->getAllParams();
        $res = false;
        
        if($params['google_id'] != '' && $params['google_email']){
            
            $userTable = new User_Model_DbTable_User();
            
            $userRow = $userTable->fetchRow('google_email = "' . $params['google_email'].'"');
            
            //l'utilisateur s'est connecté mais n'est pas référencé dnas notre base
            if(sizeof($userRow) == 0){
                $userRow = $userTable->inscrireWithGoogle($params);
            }
            
            $auth   = Zend_Auth::getInstance();
            $auth->getStorage()->write($userRow);
            $res = true;
            
        }
       
        echo Zend_Json::encode($res);
        exit();
        
    }
    
    
    public function connexionAction(){
        
        if ($this->_request->isPost()) {
   
            $post =  $this->_request->getPost();
            
            //Vérification des paramètres
            
            $valid = true;
            
            if($post['f_connect_login'] == '' || $post['f_connect_mp'] == ''){
                
                $valid = false;
            }
            
            if($valid){
                
            
                //configure l'instance avec des méthodes de réglage
                $dbAdapter = Zend_Db_Table::getDefaultAdapter();        
                $authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);

                //Connexion
                $authAdapter->setIdentity($post['f_connect_login'])
                            ->setCredential($post['f_connect_mp']);

                $authAdapter->setTableName('user')
                            ->setIdentityColumn('login')
                            ->setCredentialColumn('password')
                            ->setCredentialTreatment('MD5(CONCAT("'.Zend_Registry::get('salt').'",?,(SUBSTR( salt, 3, 5))))');

                // Réalise la requête d'authentification, et sauvegarde le résultat
                $auth   = Zend_Auth::getInstance();
                $result = $auth->authenticate($authAdapter);

                /* On peut récupérer l'objet de la table
                    // Affiche l'identité
                    echo $result->getIdentity() . "\n\n";

                    // Affiche la ligne de résultat
                    print_r($authAdapter->getResultRowObject());
                 */

                if ($result->isValid()) 
                {
                    $data = $authAdapter->getResultRowObject(null, array('password','salt'));
                    $auth->getStorage()->write($data);
                    $this->_redirect('/user/profil/index');
                } 
                else 
                {
                   //on ne fait rien pour le moment : la personne n'a pas été identifiée
                }
            }
        }
    }
    
    public function checkLoginAjaxAction(){
       
        $params= $this->getAllParams();
        
        $userTable = new User_Model_DbTable_User();
        
        $userRow = $userTable->fetchRow('login = "'.$params['login'].'"');
        
        
        
        if(sizeof($userRow) == 1){
            $res = true;
        }else{
            $res = false;
        }
        
        echo Zend_Json::encode($res);
        exit();
    }
    
    
    public function deconnexionAction()
    {
        Zend_Auth::getInstance()->clearIdentity();
    }

}