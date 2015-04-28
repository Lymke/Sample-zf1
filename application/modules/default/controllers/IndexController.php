<?php

class Default_IndexController extends Zend_Controller_Action
{

    public function init()
    {
       
    }

    public function indexAction()
    { 
        $stylo = new Default_Model_Stylo();
        echo $stylo->ecrire();die;
        
      //var_dump($this->getAllParams());
     /* $fp = fopen(APPLICATION_PATH . "/../data/fichier.txt","a");
      $writer = new User_Model_Writer($fp);
      $writer->ecrire();
      */
      //Get the logger handle from the register
      $logger = Zend_Registry::get('logger');

      //Use the logger
      $logger->log("message", 3);//Second argument is the loglevel (0-7)
    }
    
    public function changerLangueAction(){

    }
    
    public function equipeAction(){

    }


    public function cahierDesChargesAction(){
        
    }
    
    public function presentationsAction(){
        
    }
    
}

