<?php

namespace MQM\ToolsBundle;




class Utils
{    
    public static $TRUNCATE_DEFAULT_MAX_LENGTH = 160;
    private static $instance = null;
    
    /**
     * @return Utils
     */
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new Utils();
        }
        
        return self::$instance;
    }
    
    public function convertDateTimeToTimeStamp($date)
    {
        if ($date == null) {
            return  0;
        }
        
        return $date->getTimestamp();
    }
    
    public function firstLetterCapital($str)
    {
        //$cadena = utf8_decode($cadena);
        //$cadena = utf8_encode(ucwords(strtolower($cadena)));
        $str = strtolower($str);
        $str = ucfirst($str);
    
        return $str;
    }
    
    public function roundoff($number)
    {
        $roundoff = (float) ($number * 100.0) + (float) 0.5;
        $roundoff = (floor($roundoff) / 100.0) ;
    
        return $roundoff;
    }
    
    public function truncate($word, $maxLength = null, $moreInfoLink=null)
    {
        if ($word == null) {
            return null;
        }        
        if($maxLength == null){
            $maxLength = self::$TRUNCATE_DEFAULT_MAX_LENGTH;
        }

        $length = strlen($word);
        if ($length >= $maxLength) {
            $newStr = substr($word, 0, $maxLength);
            //echo $newStr;
            if($moreInfoLink != null){
                $newStr.="<a href='" . $moreInfoLink . "'>...</a>";
            }
            else{
                $newStr.="...";
            }
            
            return $newStr;
        } 

        return $word;
    }
   
    public function getSubstringTillMatches($source, $matchingString)
    {
        $pos = strrpos($source, $matchingString);
        if ($pos == false) {
            return $source;
        }
        
        return substr($source, 0, $pos);
    }
    
    public function getLastPathSegment($url)
    {
        $path = parse_url($url, PHP_URL_PATH); // to get the path from a whole URL
        $pathTrimmed = trim($path, '/'); // normalise with no leading or trailing slash
        $pathTokens = explode('/', $pathTrimmed); // get segments delimited by a slash

        return end($pathTokens); // get the last segment
    }
    
    public function toQueryString($array)
    {        
        if ($array == null) {
            return null;
        }
        
        $querystring = "";
        $count = 0;
        foreach ($array as $key => $value) {
            if($count == 0){
                $querystring.="?";
            }
            else{
                $querystring.="&";
            }
            
            $querystring .=$key ."=".$value;
                    
            $count++;
        }
        
        return $querystring;
    }
    
    function cleanInput($input)
    {
        $search = array(
            '@<script[^>]*?>.*?</script>@si', // Strip out javascript
            '@<[\/\!]*?[^<>]*?>@si', // Strip out HTML tags
            '@<style[^>]*?>.*?</style>@siU', // Strip style tags properly
            '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments
        );
        $output = preg_replace($search, '', $input);
        
        return $output;
    }

    function sanitize($input)
    {
        if (is_array($input)) {
            foreach ($input as $var => $val) {
                $output[$var] = $this->sanitize($val);
            }
        } 
        else {
            if (get_magic_quotes_gpc()) {
                $input = stripslashes($input);
            }
            $input = $this->cleanInput($input);
            $output = mysql_real_escape_string($input);
        }
        
        return $output;
    }
    
    public function getParametersByRequestMethod($request)
    {
        if ($request  == null) {
            return null;
        }        
        $method = $request->getMethod();
        $query = null;
        if($method == 'POST'){
            $query = $request->request;
        }
        else{
            $query = $request->query;
        }
        
        return $query;
    }
    
    public function getAllParametersFromRequestAndQuery($request)
    {
        if ($request  == null) {
            return null;
        }
        
        $parameters = array();
        $paramRequest = $request->request->all();
        $paramQuery = $request->query->all();
        $parameters = array_merge($paramQuery, $paramRequest);        
        
        return $parameters;
    }
    
    public function floatToPrettyFloat($price, $thousandSeparator = '.', $decimalSeparator=',')
    {
        if ($price == null) {
            return $price;
        }
        
        $price .=  "";        
        $priceArray = explode(".", $price);        
        $integerPart = $priceArray[0];
        $floatingPart = null;
        if (count($priceArray) > 1) {
            $floatingPart = $priceArray[1];
        }
        $length = strlen($integerPart);
        $prettyPrice = "";
        for ($dotCount=0, $index = $length -1; $index >= 0; $index--, $dotCount++) {
            if ($dotCount > 0 && $dotCount % 3 == 0) {
                $prettyPrice.= $thousandSeparator;
            }
            $prettyPrice.= $integerPart[$index];                        
        }
        $prettyPrice = strrev($prettyPrice);
        $prettyPrice.= $floatingPart != null ? $decimalSeparator . $floatingPart : "";
        
        return $prettyPrice;
    }
    
    public function prettyFloatToFloat($prettyFloat, $thousandSeparator = '.', $decimalSeparator=',')
    {
        if ($prettyFloat == null) {
            return $prettyFloat;
        }
        $length = strlen($prettyFloat);
        $float = "";
        for ($index = 0; $index < $length; $index++) {
            if ($prettyFloat[$index] != $thousandSeparator) {
                $float .= $prettyFloat[$index];                
            }
        }
        $float = str_replace($decimalSeparator, '.', $float);        
        $float = (float) $float;
        $float += 0.0;
        
        return $float;
    }

    public function decimalToPercentage($decimal)
    {
        return ((float)$decimal) * ((float)100.0);
    }

    public function percentageToDecimal($percentage)
    {
        return ((float)$percentage) / ((float)100.0);
    }
}
