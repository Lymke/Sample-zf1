<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of UserTable
 *
 * @author mirolo
 */
class App_Model_Db_Table_UserTable extends Zend_Db_Table_Abstract{
    
    protected $_name   = 'user';
    protected $_primary = 'id_user';
    protected $_rowClass = 'App_Model_Db_Table_Row_UserRow';
    
    public function inscrire($params){
        $salt = uniqid();
        
        $datas = array(
                          'login_user' => $params['login'],
                          'password_user' => md5(Zend_Registry::get('salt') . $params['password'] . substr($salt,2,5)),
                          'salt_user' => $salt,
                          'email_user' => $params['email'],
                          'date_inscription_user' => date('Y-m-d H:i:s'),
                          'role_user' => 'member',
                          'gravatar_user' => md5( strtolower( trim($params['email'] ) ) )
                      );
        try
        {
            $this->insert($datas);
        } 
        catch (Exception $ex) {
        }
        
    }
    
    public function getUser($id) {
        $select = $this->select()
                       ->from($this->_name)
                       ->where('id_user = ?',$id);
        return $this->fetchAll($select);
    }
    
}