<?php


namespace Musapp;

/**
 * Description of Validator
 *
 * @author User
 */
class Validator {
    
    
    public static function getValidator($validationRules =[], $values =[]){
        return new self($validationRules, $values);
    }
    
    protected $rules;
    protected $values;
    protected $messages;

    public function __construct($rules = [], $values = []) {
        $this->rules = $rules;
        $this->values = $values;
    }

    
    /**
     * check if input data is nice
     * 
     * @return bool
     */
    public function isValid()
    {
        
        // validate each item
        foreach ($this->rules as $name => $rules)
        {
            $this->validateItem($name, $rules);
        }
        
        return count($this->messages) === 0;
    }
    
    
    /**
     * check each individual item
     * 
     * @param string $name
     * @param string $rules
     */
    public function validateItem($name, $rules)
    {
        foreach ($rules as $ruleName => $ruleValue)
        {
            if ($ruleValue == false) {
                continue;
            }
            
            if (is_numeric($ruleName)) {
                $ruleName = $ruleValue;
            }
            
            $ruleValues = is_array($ruleValue) ? $ruleValue : array($ruleValue);
            $method = 'check'.$this->camelizeDashed($ruleName);
            
            array_unshift($ruleValues, $this->getValue($name));
            
            $res = call_user_func_array([$this, $method], $ruleValues);
            
            if ($res === false)
            {
                $this->setRuleError($name, $ruleName, "Rule `$ruleName` failed");
                
                return false;
            }
        }
        
        return true;
    }
    
   /**
     * get the value of item
     * 
     * @param string $item
     * @return mixed|null
     */
    public function getValue($item)
    {
        return isset($this->values[$item])
                ? $this->values[$item] 
                : null ;
    }    
    
    public function getValues(){
        return $this->values;
    }

    public function getError($item)
    {
        return isset($this->messages[$item])
                ? $this->messages[$item] 
                : null ;
    }
    

    public function setError($item, $error)
    {
        $this->messages[$item][] = $error;
    }
    
    public function setRuleError($item, $rule, $error)
    {
        $this->messages[$item][$rule] = $error;
    }
    
    public function getMessages()
    {
        return $this->messages;
    }    
    
    /**
     * remove dashes and camelize
     * 
     * @param string $input
     * @return string
     */
    public function camelizeDashed($input)
    {
        $first = ucwords(str_replace(array('-', '_'), ' ', $input));
        
        return lcfirst(str_replace(' ', '', $first));
    }   
    
    /**
     * check if value exists
     * 
     * @param mixed $input
     * @return bool
     */
    public static function checkRequired($input)
    {
        return !empty($input);
        //return $input != "" && $input !== null;
    }    
    
    
    /**
     * checks if input is valid date
     * 
     * @param mixed $input
     * @return bool
     */
    public function checkDate($input)
    {
        if ($input instanceof DateTime)
        {
            return true;
        }
        elseif (strtotime($input) === false) 
        {
            return false;
        }
        
        $date = date_parse($input);

        return checkdate($date['month'], $date['day'], $date['year']);
    }
    
    /**
     * checks if input is valid date format
     * @param mixed  $input
     * @param StringUtil $format
     * @return bool
     */
    public function checkDateFormat($input, $format) 
    {
        $parsed = date_parse_from_format($format, $input);

        return $parsed['error_count'] === 0 && $parsed['warning_count'] === 0;
    }    
    
    
    /**
     * checks if input is valid email address
     * @param mixed $input
     * @return bool
     */
    public function checkEmail($input)
    {
        return filter_var($input, FILTER_VALIDATE_EMAIL) !== false;
    }

    public function checkNum($input) 
    {
        if (is_int($input)) {
            return true;
        }
        
        return ctype_digit($input); 
    }
    
    /**
     * check exact length
     * @param mixed $input
     * @param mixed $length
     * @return bool
     */
    public function checkLength($input, $length)
    {
        return mb_strlen($input, 'UTF-8') == $length;
    }
    
    /**
     * check exact length
     * @param mixed $input
     * @param mixed $minLength
     * @return bool
     */
    public function checkMinLength($input, $minLength)
    {
        return mb_strlen($input, 'UTF-8') >= $minLength;
    }
    
        /**
     * check exact length
     * @param mixed $input
     * @param mixed $maxLength
     * @return bool
     */
    public function checkMaxLength($input, $maxLength)
    {
        return mb_strlen($input, 'UTF-8') <= $maxLength;
    }
    
    
}