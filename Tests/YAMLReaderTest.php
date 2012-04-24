<?php

namespace MQM\ToolsBundle\Test;

use MQM\ToolsBundle\IO\YAMLProperties;

class YAMLReaderTest extends \Symfony\Bundle\FrameworkBundle\Test\WebTestCase
{   
    protected $_container;
    
    /**
     * @var YAMLProperties
     */
    private $reader;

    public function __construct()
    {
        parent::__construct();
        
        $client = static::createClient();
        $container = $client->getContainer();
        $this->_container = $container;  
    }
    
    protected function setUp()
    {
        $this->reader = $this->get('mqm_tools.yaml_reader');
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
        $this->reader->parse(__DIR__ . '/' . 'test_properties.yml');
        $field1 = $this->reader->getProperty('field1');
        $this->assertEquals('value1', $field1);
        $field2 = $this->reader->getProperty('field2');
        $this->assertEquals('value2', $field2);
        $field3 = $this->reader->getProperty('field3');
        $this->assertEquals('value3', $field3);
    }
    
    public function testSetProperties()
    {
        $this->reader->parse(__DIR__ . '/' . 'test_properties.yml')
                ->setProperty('field1', 'newValue1')
                ;        
        $field1 = $this->reader->getProperty('field1');
        $this->assertEquals('newValue1', $field1);
        $field1 = $this->reader->setProperty('field1', 'value1');
    }
}
