<?php

namespace MQM\ToolsBundle\IO;

interface ReaderInterface
{
    /**
     * @param string 
     */
    public function setPath($path);
    
    /**
     * @param string|null
     * 
     * @return array
     */
    public function parse($path = null);
    
    /**
     * @param string 
     */
    public function getProperty($property);
    
    /**
     * @param string
     * @param string 
     */
    public function setProperty($property, $value);
}