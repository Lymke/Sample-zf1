<?php

class ProjetController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {   //Zend_Loader::loadClass('Stylo');
        //$stylo = new Stylo();
        //die($stylo->ecrire());
    }

    public function addAction()
    {
        $form =  new App_Form_Projet();
       
        
        
        if($this->getRequest()->isPost())
        {   $params = $this->getAllParams();
            
            if($form->isValid($params))
            {
                $projetDb = new App_Model_Db_Projet();
                $projetDb->insert($params);
            }
            else
            {
            }
        }
        
        $this->view->form_projet = $form;
        
    }
    
    public function listAction()
    {
        $projetDb = new App_Model_Db_Projet();
                
        $this->view->projects = $projetDb->fetchAll();
        
    }
    

}

