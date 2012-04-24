<?php

namespace MQM\ToolsBundle\Test;



use MQM\ToolsBundle\IO\IniProperties;

class IniPropertiesTest extends \Symfony\Bundle\FrameworkBundle\Test\WebTestCase
{   
    protected $_container;
    /**
     * @var IniProperties
     */
    private $iniReader;

    public function __construct()
    {
        parent::__construct();
        
        $client = static::createClient();
        $container = $client->getContainer();
        $this->_container = $container;  
    }
    
    protected function setUp()
    {
        $this->iniReader = $this->get('mqm_tools.ini_reader');
    }

    protected function tearDown()
    {
    }

    protected function get($service)
    {
        return $this->_container->get($service);
    }
    
    public function testReadIniProperties()
    {
        $this->iniReader->parse(__DIR__ . '/' . 'test_properties.ini');
        $field1 = $this->iniReader->getProperty('field1');
        $this->assertEquals('value1', $field1);
        $field2 = $this->iniReader->getProperty('field2');
        $this->assertEquals('value2', $field2);
        $field3 = $this->iniReader->getProperty('field3');
        $this->assertEquals('value3', $field3);
    }
}
