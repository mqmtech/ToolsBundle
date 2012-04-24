<?php

namespace MQM\ToolsBundle\IO;

use MQM\ToolsBundle\IO\PropertiesInterface;
use Symfony\Component\Yaml\Parser;
use Symfony\Component\Yaml\Dumper;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Exception\DumpException;

final class YAMLProperties implements PropertiesInterface
{
    private $path;
    private $properties;

    public function __construct($path = null)
    {
        $this->path = $path;
    }

    public function parse($path = null)
    {
        if ($path) {
            $this->path = $path;
        }
        $yaml = new Parser();
        try {
            $this->properties = $yaml->parse(file_get_contents($this->path));
        }
        catch (ParseException $e) {
             printf("Unable to parse the YAML string: %s", $e->getMessage());
        }
        
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getProperty($name)
    {
        if ($this->properties == null) {
            $this->parse();
        }
        
        if (isset($this->properties[$name]))
            return $this->properties[$name];

        return null;
    }

    public function setProperty($name, $value)
    {
        $this->properties[$name] = $value;
        try {
            $this->saveToYAMLFile();
        }
        catch (DumpException $e) {
            printf("Unable to save the YAML array: %s", $e->getMessage());
        }
        
        return $this;
    }
    
    private function saveToYAMLFile()
    {
        $dumper = new Dumper();
        $yaml = $dumper->dump($this->properties, 2);
        file_put_contents($this->path, $yaml);
    }
}