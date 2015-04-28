<?php

class App_Model_Db_Projet
{
    private $_modelTable;
    
    public function __construct() {
        $this->_modelTable = new App_Model_Db_Table_ProjetTable();
    }
    
    public function insert($params) {
        $datas = array(
                             'titre_projet' => $params['titre'],
                             'description_projet' => $params['description'],
                             'id_createur' => -1
                );
                 
        return $this->_modelTable->insert($datas);
    }
    
    public function fetchAll() {
    
        return $this->_modelTable->fetchAll();
    }
}
