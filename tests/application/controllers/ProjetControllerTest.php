<?php

class ProjetControllerTest extends Zend_Test_PHPUnit_ControllerTestCase
{

    public function setUp()
    {
        $this->bootstrap = new Zend_Application(APPLICATION_ENV, APPLICATION_PATH . '/configs/application.ini');
        parent::setUp();
    }

    
    /**
     * @test
     */
    public function testPostAddProject()
    {
        $this->request->setMethod('POST')
              ->setPost(array(
                  'titre' => 'AAA',
                  'description' => 'BBB'
              ));
        $this->dispatch('/projet/add');
        
        
        $this->assertController('projet');
        $this->assertAction('add');
        $this->assertNotRedirect();
        //$this->assertQueryContentContains('h2', 'User: foobar');
    }
 
}

