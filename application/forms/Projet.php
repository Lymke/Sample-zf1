<?php
class App_Form_Projet extends Zend_Form {
    
    public function init() {
        
        $this->setName("add_project");
        $this->setMethod('post');
        
        //Décorateurs
            
            //$this->addElementPrefixPath('My_Decorator', 'My/Decorator/', 'decorator');
        
            $decorators = array(
                'ViewHelper',
                'Errors',
                array('Description', array('tag' => 'p', 'class' => 'description')),
                array('HtmlTag', array('tag' => 'td')),
                array('Label', array('tag' => 'th')),
                array(array('tr' => 'HtmlTag'), array('tag' => 'tr'))
            );
        
        //Titre
        
            $this->addTitre($decorators);
            
        //Description
            
            $this->addDescription($decorators);
            
        //Bouton
            
            $this->addButton();
    }
    
    public function addTitre($decorators = null) {
        
        $titre = new Zend_Form_Element_Text('titre');
        $titre->class = 'form-control';
        $titre->setLabel('Titre');
        $titre->setRequired(true);
        
        $titre->setDecorators($decorators);
        
        //Validators
        $titre->addValidator('alnum');
        
        //Filters
        $titre->addFilter('StringToLower');
                
        $this->addElement($titre);
        
    }
    
    public function addDescription($decorators = null) {
        
        $description = new Zend_Form_Element_Textarea('description');
        $description->class = 'form-control';
        $description->setDecorators($decorators);
        
        $description->setLabel('Description')
                    ->setAttrib('COLS', '40')
                    ->setAttrib('ROWS', '4');
        $this->addElement($description);
    }
    
    public function addButton() {
        
        $bouton = new Zend_Form_Element_Submit('valider');
        $bouton->class = 'btn btn-default';
        $bouton->setLabel('Valider');
        $this->addElement($bouton);
    }
    
    
    
}