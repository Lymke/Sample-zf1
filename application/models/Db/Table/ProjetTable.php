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
class App_Model_Db_Table_ProjetTable extends Zend_Db_Table_Abstract{
    
    protected $_name   = 'projet';
    protected $_primary = 'id_projet';
    protected $_rowClass = 'App_Model_Db_Table_Row_ProjetRow';
    
    
    public function getProjectByUser($idUser){
        $select = $this->select()
                       ->from($this->_name)
                       ->setIntegrityCheck(false)
                       ->join('user', 'user.id_user = ' .$this->_name.'.id_createur' , 
                               array()) 
                       ->where('user.id_user = ?',$idUser);

        return  $this->fetchall($select);
    }
}