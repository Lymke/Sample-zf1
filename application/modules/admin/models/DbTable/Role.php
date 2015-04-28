<?php

/**
 * Description of User
 *
 * @author jldr8346
 */
class Admin_Model_DbTable_Role extends Zend_Db_Table_Abstract
{
    protected $_name = 'role';
    protected $_primary = 'id_role';
    protected $_rowClass = 'Admin_Model_DbTable_Row_Role';
}

?>
