<?php

/**
 * Description of User
 *
 * @author jldr8346
 */
class User_Model_DbTable_User extends Zend_Db_Table_Abstract
{
    protected $_name = 'user';
    protected $_primary = 'id_user';
    protected $_rowClass = 'User_Model_DbTable_Row_User';
    
    
    
    public function inscrire($login,$mp,$email)
    {
        $salt = uniqid();
        
        $datas = array(
                          'login' => $login,
                          'password' => md5(Zend_Registry::get('salt') . $mp . substr($salt,2,5)),
                          'salt' => $salt,
                          'email' => $email,
                          'date_inscription' => date('Y-m-d H:i:s'),
                          'role' => 'member',
                          'gravatar' => md5( strtolower( trim($email ) ) )
                      );
        
        $this->insert($datas);
        
    }
    
    public function inscrireWithFacebook($params){
        
        if(empty($params['fb_email'])){
            throw new Exception('inscrireWithFacebook : Le paramètre fb_email est manquant.');
        }
        
        if(empty($params['fb_id'])){
            throw new Exception('inscrireWithFacebook : Le paramètre fb_id est manquant.');
        }
        if(empty($params['fb_nom'])){
            throw new Exception('inscrireWithFacebook : Le paramètre fb_nom est manquant.');
        }
        if(empty($params['fb_prenom'])){
            throw new Exception('inscrireWithFacebook : Le paramètre fb_prenom est manquant.');
        }
        if(empty($params['fb_link'])){
            throw new Exception('inscrireWithFacebook : Le paramètre fb_link est manquant.');
        }
        
        $user = $this->createRow();
        
        $user->login = $params['fb_prenom'] .' ' . $params['fb_nom'];
        $user->password = 'unknown';
        $user->salt = uniqid();
        $user->fb_email = $params['fb_email'];
        $user->fb_id = $params['fb_id'];
        $user->fb_nom = $params['fb_nom'];
        $user->fb_prenom = $params['fb_prenom'];
        $user->fb_link = $params['fb_link'];
        $user->date_inscription = date('Y-m-d H:i:s');
        $user->statut_connexion = User_Model_Constantes_Statutconnexion::FB_CONNECTION;
        $user->role = 'member';
       
        $user->save();
        return $user;
    }
    
    
    
    public function inscrireWithGoogle($params){

        if(empty($params['google_id'])){
            throw new Exception('inscrireWithGoogle : Le paramètre google_id est manquant.');
        }
        
        if(empty($params['google_email'])){
            throw new Exception('inscrireWithGoogle : Le paramètre google_email est manquant.');
        }
        if(empty($params['google_nom'])){
            throw new Exception('inscrireWithGoogle : Le paramètre google_nom est manquant.');
        }
        if(empty($params['google_prenom'])){
            throw new Exception('inscrireWithGoogle : Le paramètre google_prenom est manquant.');
        }
        if(empty($params['google_profile_image'])){
            throw new Exception('inscrireWithGoogle : Le paramètre google_profile_image est manquant.');
        }
        
        
        
        
        $user = $this->createRow();
        
        $user->login = $params['google_prenom'] .' ' . $params['fb_nom'];
        $user->nom = $params['google_nom'];
        $user->prenom = $params['google_prenom'];
        $user->email = $params['google_email'];
        $user->password = 'unknown';
        $user->salt = uniqid();
        $user->google_email = $params['google_email'];
        $user->google_id = $params['google_id'];
        $user->google_nom = $params['google_nom'];
        $user->google_prenom = $params['google_prenom'];
        $user->google_profile_image = $params['google_profile_image'];
        $user->google_gender = $params['google_gender'];
        $user->google_locale = $params['google_locale'];
        $user->date_inscription = date('Y-m-d H:i:s');
        $user->statut_connexion = User_Model_Constantes_Statutconnexion::GOOGLE_CONNECTION;
        $user->role = 'member';
       
        $user->save();
        return $user;
    }
    
    
    public function getUtilisateursOrderByRole(){
        
        $select = $this->select()
                       ->from($this->_name)
                       ->order('role','asc');
        
        
        return $this->fetchall($select);
        
    }
    
}

?>
