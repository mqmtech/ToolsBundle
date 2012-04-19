<?php

namespace MQM\ToolsBundle\Twig\Extension;

use MQM\ToolsBundle\Utils;

class ToolsExtension extends \Twig_Extension
{
    private $utils;
    
    public function __construct(Utils $utils)
    {
        $this->utils = $utils;
    }
    
    public function getName()
    {
        return 'ToolsTwigExtension';
    }

    public function getFunctions()
    {
        return array(
            'mqm_tools_totime' => new \Twig_Function_Method($this, 'toTime'),
            'mqm_tools_truncate' => new \Twig_Function_Method($this, 'truncate'),
        );
    }
    
    public function getFilters()
    {
        return array(
            'mqm_tools_totime' => new \Twig_Filter_Method($this, 'toTime'),
            'mqm_tools_truncate' => new \Twig_Filter_Method($this, 'truncate'),
            'mqm_tools_first_letter_capital' => new \Twig_Filter_Method($this, 'firstLetterCapital'),
            'mqm_tools_floor' => new \Twig_Filter_Method($this, 'floor'),
        );
    }

    public function toTime($string)
    {
        return strtotime($string);
    }
    
    public function truncate($word, $maxLength = null, $moreInfoLink=null)
    {
        return $this->utils->truncate($word, $maxLength, $moreInfoLink);
    }
    
    public function firstLetterCapital($words)
    {
        return $this->utils->firstLetterCapital($words);
    }
    
    public function floor($number)
    {
        return floor($number);
    }
}