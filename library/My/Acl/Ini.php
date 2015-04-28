<?php
/**
 * Classe de création des ACL via un fichier de configuration INI
**/
class My_Acl_Ini extends Zend_Acl
{
	public function __construct($file)	
        {
            //Définition des rôles
            
		$roles = new Zend_Config_Ini($file, 'roles') ;
		$this->_setRoles($roles);
		
                
           //Définition des ressources
                
		$ressources = new Zend_Config_Ini($file, 'ressources') ;
		$this->_setRessources($ressources) ;
		
		foreach ($roles->toArray() as $role => $parents)	
                {
			$privileges = new Zend_Config_Ini($file, $role) ;
			$this->_setPrivileges($role, $privileges) ;
		}
	 }
	
        /**
         * Création des roles en tenant compte de l'héritage
         * acl.ini
         * [roles]
         * parent1=
         * parent2=
         * role1=parent1,parent2
         * @param type $roles
         * @return \My_Acl_Ini
         */
	protected function _setRoles($roles)
        {
            foreach ($roles as $role => $parents)	
            {
		if (empty($parents))	
                {
                    $parents = null ;
		} 
                else 
                {
                    $parents = explode(',', $parents) ;
		}
                $this->addRole(new Zend_Acl_Role($role), $parents);
            }
            return $this ;
	}
        /**
         * 
         * @param type $ressources
         * @return \My_Acl_Ini
         */
	protected function _setRessources($ressources)	
        {
            foreach ($ressources as $ressource => $parents)	
            {
		if (empty($parents))	
                {
                    $parents = null ;
		} 
                else 
                {
                    $parents = explode(',', $parents) ;
		}
		$this->add(new Zend_Acl_Resource($ressource), $parents);
            }
		
            return $this ;
	}
        
        
        
	protected function _setPrivileges($role, $privileges)	
        {
            foreach ($privileges as $do => $ressources)	
            {
		foreach ($ressources as $ressource => $actions)	
                {
                    if (empty($actions))	
                    {
			$actions = null ;
                    } 
                    else 
                    {
			$actions = explode(',', $actions) ;
                    }
                    
                    //{$do} = allow ou deny
                    $this->{$do}($role, $ressource, $actions);
		}
            }
           
            return $this ;
	}
}