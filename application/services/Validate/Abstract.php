<?php


/**
 * @see Navo_Service_Validate_Interface
 */
require_once 'application/services/Validate/Interface.php';

/**
 * @category   Navo
 * @package    Navo_Service_Validate
 */
abstract class Navo_Service_Validate_Abstract implements Navo_Service_Validate_Interface
{
    /**
     * The value to be validated
     *
     * @var mixed
     */
    protected $_value;

    /**
     * Additional variables available for validation failure messages
     *
     * @var array
     */
    protected $_messageVariables = array();

    /**
     * Validation failure message template definitions
     *
     * @var array
     */
    protected $_messageTemplates = array();

    /**
     * Array of validation failure messages
     *
     * @var array
     */
    protected $_messages = array();

    /**
     * Flag indidcating whether or not value should be obfuscated in error
     * messages
     * @var bool
     */
    protected $_obscureValue = false;

    /**
     * Array of validation failure message codes
     *
     * @var array
     * @deprecated Since 1.5.0
     */
    protected $_errors = array();

    

    /**
     * Limits the maximum returned length of a error message
     *
     * @var Integer
     */
    protected static $_messageLength = -1;

    /**
     * Returns array of validation failure messages
     *
     * @return array
     */
    public function getMessages()
    {
        return $this->_messages;
    }

    /**
     * Returns an array of the names of variables that are used in constructing validation failure messages
     *
     * @return array
     */
    public function getMessageVariables()
    {
        return array_keys($this->_messageVariables);
    }

    /**
     * Returns the message templates from the validator
     *
     * @return array
     */
    public function getMessageTemplates()
    {
        return $this->_messageTemplates;
    }

    /**
     * Sets the validation failure message template for a particular key
     *
     * @param  string $messageString
     * @param  string $messageKey     OPTIONAL
     * @return Navo_Service_Validate_Abstract Provides a fluent interface
     * @throws Exception
     */
    public function setMessage($messageString, $messageKey = null)
    {
        if ($messageKey === null) {
            $keys = array_keys($this->_messageTemplates);
            foreach($keys as $key) {
                $this->setMessage($messageString, $key);
            }
            return $this;
        }

        if (!isset($this->_messageTemplates[$messageKey])) {
            throw new Exception("No message template exists for key '$messageKey'");
        }

        $this->_messageTemplates[$messageKey] = $messageString;
        return $this;
    }

    /**
     * Sets validation failure message templates given as an array, where the array keys are the message keys,
     * and the array values are the message template strings.
     *
     * @param  array $messages
     * @return Navo_Service_Validate_Abstract
     */
    public function setMessages(array $messages)
    {
        foreach ($messages as $key => $message) {
            $this->setMessage($message, $key);
        }
        return $this;
    }

    /**
     * Magic function returns the value of the requested property, if and only if it is the value or a
     * message variable.
     *
     * @param  string $property
     * @return mixed
     * @throws Exception
     */
    public function __get($property)
    {
        if ($property == 'value') {
            return $this->_value;
        }
        if (array_key_exists($property, $this->_messageVariables)) {
            return $this->{$this->_messageVariables[$property]};
        }
        /**
         * @see Exception
         */
        throw new Exception("No property exists by the name '$property'");
    }

    /**
     * Constructs and returns a validation failure message with the given message key and value.
     *
     * Returns null if and only if $messageKey does not correspond to an existing template.
     *
     * If a translator is available and a translation exists for $messageKey,
     * the translation will be used.
     *
     * @param  string $messageKey
     * @param  string $value
     * @return string
     */
    protected function _createMessage($messageKey, $value)
    {
        if (!isset($this->_messageTemplates[$messageKey])) {
            return null;
        }

        $message = $this->_messageTemplates[$messageKey];

        if (null !== ($translator = $this->getTranslator())) {
            if ($translator->isTranslated($messageKey)) {
                $message = $translator->translate($messageKey);
            } else {
                $message = $translator->translate($message);
            }
        }

        if (is_object($value)) {
            if (!in_array('__toString', get_class_methods($value))) {
                $value = get_class($value) . ' object';
            } else {
                $value = $value->__toString();
            }
        } else {
            $value = (string)$value;
        }

        if ($this->getObscureValue()) {
            $value = str_repeat('*', strlen($value));
        }

        $message = str_replace('%value%', (string) $value, $message);
        foreach ($this->_messageVariables as $ident => $property) {
            $message = str_replace("%$ident%", (string) $this->$property, $message);
        }

        $length = self::getMessageLength();
        if (($length > -1) && (strlen($message) > $length)) {
            $message = substr($message, 0, (self::getMessageLength() - 3)) . '...';
        }

        return $message;
    }

    /**
     * @param  string $messageKey
     * @param  string $value      OPTIONAL
     * @return void
     */
    protected function _error($messageKey, $value = null)
    {
        if ($messageKey === null) {
            $keys = array_keys($this->_messageTemplates);
            $messageKey = current($keys);
        }
        if ($value === null) {
            $value = $this->_value;
        }
        $this->_errors[]              = $messageKey;
        $this->_messages[$messageKey] = $this->_createMessage($messageKey, $value);
    }

    /**
     * Sets the value to be validated and clears the messages and errors arrays
     *
     * @param  mixed $value
     * @return void
     */
    protected function _setValue($value)
    {
        $this->_value    = $value;
        $this->_messages = array();
        $this->_errors   = array();
    }

    /**
     * Returns array of validation failure message codes
     *
     * @return array
     * @deprecated Since 1.5.0
     */
    public function getErrors()
    {
        return $this->_errors;
    }

    /**
     * Set flag indicating whether or not value should be obfuscated in messages
     *
     * @param  bool $flag
     * @return Navo_Service_Validate_Abstract
     */
    public function setObscureValue($flag)
    {
        $this->_obscureValue = (bool) $flag;
        return $this;
    }

    /**
     * Retrieve flag indicating whether or not value should be obfuscated in
     * messages
     *
     * @return bool
     */
    public function getObscureValue()
    {
        return $this->_obscureValue;
    }

    
    /**
     * Returns the maximum allowed message length
     *
     * @return integer
     */
    public static function getMessageLength()
    {
        return self::$_messageLength;
    }

    /**
     * Sets the maximum allowed message length
     *
     * @param integer $length
     */
    public static function setMessageLength($length = -1)
    {
        self::$_messageLength = $length;
    }
}
