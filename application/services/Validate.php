<?php


/**
 * @see Navo_Service_Validate_Interface
 */
require_once 'application/services/Validate/Interface.php';


class Navo_Service_Validate implements Navo_Service_Validate_Interface
{
    /**
     * Validator chain
     *
     * @var array
     */
    protected $_validators = array();

    /**
     * Array of validation failure messages
     *
     * @var array
     */
    protected $_messages = array();

    /**
     * Default Namespaces
     *
     * @var array
     */
    protected static $_defaultNamespaces = array();

    /**
     * Array of validation failure message codes
     *
     * @var array
     * @deprecated Since 1.5.0
     */
    protected $_errors = array();

    /**
     * Adds a validator to the end of the chain
     *
     * If $breakChainOnFailure is true, then if the validator fails, the next validator in the chain,
     * if one exists, will not be executed.
     *
     * @param  Navo_Service_Valation_Interface $validator
     * @param  boolean                 $breakChainOnFailure
     * @return Navo_Service_Valation Provides a fluent interface
     */
    public function addValidator(Navo_Service_Valation_Interface $validator, $breakChainOnFailure = false)
    {
        $this->_validators[] = array(
            'instance' => $validator,
            'breakChainOnFailure' => (boolean) $breakChainOnFailure
            );
        return $this;
    }

    /**
     * Returns true if and only if $value passes all validations in the chain
     *
     * Validators are run in the order in which they were added to the chain (FIFO).
     *
     * @param  mixed $value
     * @return boolean
     */
    public function isValid($value)
    {
        $this->_messages = array();
        $this->_errors   = array();
        $result = true;
        foreach ($this->_validators as $element) {
            $validator = $element['instance'];
            if ($validator->isValid($value)) {
                continue;
            }
            $result = false;
            $messages = $validator->getMessages();
            $this->_messages = array_merge($this->_messages, $messages);
            $this->_errors   = array_merge($this->_errors,   array_keys($messages));
            if ($element['breakChainOnFailure']) {
                break;
            }
        }
        return $result;
    }

    /**
     * Defined by Navo_Service_Valation_Interface
     *
     * Returns array of validation failure messages
     *
     * @return array
     */
    public function getMessages()
    {
        return $this->_messages;
    }

    /**
     * Defined by Navo_Service_Valation_Interface
     *
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
     * Returns the maximum allowed message length
     *
     * @return integer
     */
    public static function getMessageLength()
    {
        return Navo_Service_Validate_Abstract::getMessageLength();
    }

    /**
     * Sets the maximum allowed message length
     *
     * @param integer $length
     */
    public static function setMessageLength($length = -1)
    {
        Navo_Service_Validate_Abstract::setMessageLength($length);
    }

}
